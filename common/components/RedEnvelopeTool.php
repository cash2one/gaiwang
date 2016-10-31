<?php

/**
 * 红包活动操作类
 * Created by PhpStorm.
 * User: binbin.liao
 * Date: 2014/11/25
 * Time: 20:03
 */
class RedEnvelopeTool {

    /** @var  $memberId 会员id */
    public $memberId;
    public static $instance;

    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new RedEnvelopeTool();
        }
        return self::$instance;
    }

    /**
     * 获取会员红包积分
     * @param $memberId
     * @return mixed
     * @author binbin.liao
     */
    public static function getRedAccount($memberId) {
        $data = Yii::app()->db->createCommand()
                        ->select()
                        ->from('{{member_account}}')
                        ->where('member_id=:id', array(':id' => $memberId))->queryRow();
        return empty($data) ? 0 : $data['money'];
    }

    /**
     * 获取红包支付上限比率
     * @param int $mode
     * @return mixed
     * @author binbin.liao
     */
    public static function getRatio($mode = Activity::ACTIVITY_MODE_RED) {
        return Yii::app()->db->createCommand()
                        ->select('ratio')
                        ->from('{{activity}}')
                        ->limit(1)
                        ->where('mode=:mode', array(':mode' => $mode))->queryRow();
    }

    /**
     * 创建红包、盖惠券活动队列
     * @param $member_id
     * @param $source 来源（1商城、2盖网通）
     * @param $type 类型（1注册送红包、2分享送红包）
     * @param int $is_compensate 是否是补偿红包
     * @param null $sms_content 指定发送短信的内容
     * @return bool
     * @throws Exception
     */
    public static function createRedisActivity($member_id, $source, $type, $is_compensate = Coupon::COMPENSATE_NO, $sms_content = null,$data=array()) {
        $activity = Yii::app()->db->createCommand()
                ->select('id,money,valid_end,status')
                ->from('{{activity}}')
                ->where('mode=:mode and type=:type and status=:status', array(':mode' => Activity::ACTIVITY_MODE_RED, ':type' => $type, ':status' => Activity::STATUS_ON))
                ->queryRow();
        //活动不存在 或 全部都已停止
        if (!$activity)
            return false;

        // 判断活动是否已过期
        if (time() > $activity['valid_end'])
            return false;

        //判断是不够金额送红包
        $balanceRed = CommonAccount::getHongbaoAccount(); //红包账户
        $hasMoney = AccountManage::checkHasMoney($activity['money'], $balanceRed['gai_number']);
        if (!$hasMoney)
            return false;
        /* 使用队列送红包
          $model = new  RedisActivity();
          $model -> member_id = $member_id;
          $model -> activity_id = $activity['id'];
          $model -> money = $activity['money'];
          $model -> source = (string)$source;  //转成string，为了后面使用一致
          $model -> uid = md5(time().mt_rand(1,10000));
          $arr = $model->attributes;
          $arr = array_merge($arr,array('mode'=>(string)Activity::ACTIVITY_MODE_RED,'type'=>(string)$type));
          if($model -> save()){
          $str = CJSON::encode($arr);
          GWRedisList::lset(CouponTool::COUPON_LIST,$str); //入redis 对列
          return true;
          }else {
          throw new Exception(Yii::t("RedEnvelopeTool", '生成红包、盖惠券活动队列失败'));
          return false;
          }
         */
//        如果为红包充值活动
        if ($type == Activity::TYPE_RECHARGE) {
            $arr = array(
                'member_id' => $member_id,
                'activity_id' => $activity['id'],
                'money' => $data['money'],
                'source' => $source,
                'type' => $type,
                'uid' => md5(time() . mt_rand(1, 10000)),
                'mode' => Activity::ACTIVITY_MODE_RED,
                'is_compensate' => $is_compensate,
            );
            if (
                    self::createCoupon($arr) && //创建红包
                    AccountManage::subtractHongBaoMoney($data['money'], $balanceRed['gai_number']) && //从金额池减去红包金额
                    MemberAccount::addHongBaoMoney($data['money'], $member_id) && //往 会员红包金额帐户 加钱                  
                    Activity::model()->updateCounters(array('sendout' => 1), 'mode=:mode AND status=:status AND type=:type', array(':mode' => Activity::ACTIVITY_MODE_RED, ':status' => Activity::STATUS_ON, ':type' => $type)) //发行量
            ) {
             
                $memberInfo = self::_getMemberInfo($member_id);
//                self::_sendSms($memberInfo['mobile'], $type, $activity['money']);
                return true;
            } else {
                return false;
            }
        }


        // 不使用对列送红包
        $arr = array(
            'member_id' => $member_id,
            'activity_id' => $activity['id'],
            'money' => $activity['money'],
            'source' => $source,
            'type' => $type,
            'uid' => md5(time() . mt_rand(1, 10000)),
            'mode' => Activity::ACTIVITY_MODE_RED,
            'is_compensate' => $is_compensate,
        );

        if (
                self::createCoupon($arr) && //创建红包
                AccountManage::subtractHongBaoMoney($activity['money'], $balanceRed['gai_number']) && //从金额池减去红包金额
                MemberAccount::addHongBaoMoney($activity['money'], $member_id) && //往 会员红包金额帐户 加钱
                Activity::model()->updateCounters(array('sendout' => 1), 'mode=:mode AND status=:status AND type=:type', array(':mode' => Activity::ACTIVITY_MODE_RED, ':status' => Activity::STATUS_ON, ':type' => $type)) //发行量
        ) {
            //发送短信
            $memberInfo = self::_getMemberInfo($member_id);
            if ($is_compensate) {
                self::_CompensationSendSms($memberInfo['mobile'], $activity['money'], $sms_content); //红包补偿发送短息
            } else {
                self::_sendSms($memberInfo['mobile'], $type, $activity['money']);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取红包、盖惠券活动队列
     * @return array
     */
    public static function getAedisActivity() {
        return Yii::app()->db->createCommand()
                        ->select('ra.member_id,ra.activity_id,ra.money,ra.source,ra.uid,a.mode,a.type')
                        ->from('{{redis_activity}} as ra ')
                        ->leftJoin('{{activity}} as a', '`ra`.`activity_id` = `a`.`id`')
                        ->queryAll();
    }

    /**
     * 创建红包
     * @param $arr
     * @return bool
     * @throws Exception
     */
    public static function createCoupon($arr) {
        $model = new Coupon();
        $model->member_id = $arr['member_id'];
        $model->store_id = 0;
        $model->money = $arr['money'];
        $model->condition = 0;
        $model->surplus_money = 0;
        $model->valid_start = 0;
        $model->valid_end = 0;
        $model->valid_start = 0;
        $model->status = 0;
        $model->mode = $arr['mode'];
        $model->type = $arr['type'];
        $model->create_time = time();
        $model->use_time = 0;
        $model->source = $arr['source'];
        $model->activity_id = $arr['activity_id'];
        $model->is_compensate = isset($arr['is_compensate']) ? $arr['is_compensate'] : Coupon::COMPENSATE_NO;

        if (!$model->save()) {
            throw new Exception(Yii::t("RedEnvelopeTool", '生成红包失败'));
            return false;
        }
        else
            return true;
    }

    /**
     * 删除红包、盖惠券活动队列
     * @param $uid
     * @return bool
     * @throws Exception
     */
    public static function deleteRedisActivity($uid) {
        $rs = RedisActivity::model()->deleteAllByAttributes(array(), 'uid=:uid', array(':uid' => $uid));
        if (!$rs) {
            throw new Exception(Yii::t("RedEnvelopeTool", '删除红包、盖惠券活动队列失败'));
            return false;
        }
        else
            return true;
    }

    /**
     * @author lhao
     * 盖网通创建红包活动
     * @param $member_id
     * @param $source 来源（1商城、2盖网通）
     * @param $type 类型（1注册送红包、2分享送红包）
     * @return bool
     * @throws Exception|$arr
     */
    public static function createGtRedEnvelope($member_id, $type, $source, $money = 0) {
        $activity = Yii::app()->db->createCommand()
                ->select('id,money,status,mode,type')
                ->from('{{activity}}')
                ->where('type=:type and status=:status and valid_end > :now_time', array(':type' => $type, ':status' => Activity::STATUS_ON, ':now_time' => time()))
                ->queryRow();
        if (!$activity)
            return false;
        $money = $money != 0 ? $money : $activity['money'];
        ;
        $balanceRed = CommonAccount::getHongbaoAccount(); //红包账户
        if (!AccountManage::checkHasMoney($activity['money'], $balanceRed['gai_number']))
            return false;
        try {
            $arr = array();
            $arr['member_id'] = $member_id;
            $arr['money'] = $money;
            $arr['mode'] = $activity['mode'];
            $arr['type'] = $activity['type'];
            $arr['source'] = $source;
            $arr['activity_id'] = $activity['id'];
            $transaction = Yii::app()->db->beginTransaction();

            if (
                    AccountManage::subtractHongBaoMoney($money, $balanceRed['gai_number']) &&
                    MemberAccount::addHongBaoMoney($money, $member_id) &&
                    RedEnvelopeTool::createCoupon($arr)
            ) {

                //红包统计+1 统计
                $sql = "update " . Activity::model()->tableName() . " set sendout = sendout + 1 where id = {$activity['id']}";
                Yii::app()->db->createCommand($sql)->execute();

                $transaction->commit();
                return $arr;
            } else {
                $transaction->rollBack();
                throw new Exception(Yii::t("RedEnvelopeTool", '获取红包失败'));
            }
        } catch (Exception $e) {
            if (isset($transaction))
                $transaction->rollBack();
            throw new Exception(Yii::t("RedEnvelopeTool", '获取红包失败'));
            return false;
        }
    }

    /**
     * 检查是否有抽奖
     * @param array $hongbaoconfig
     * @return array|boolean
     */
    public static function checkLottery($hongbaoconfig = array()) {
        $activity = Yii::app()->db->createCommand()
                ->select('id,money,status')
                ->from('{{activity}}')
                ->where('type=:type and status=:status and valid_end>:now_time', array(':type' => Activity::TYPE_REGISTER, ':status' => Activity::STATUS_ON, ':now_time' => time()))
                ->queryRow();
        if (!empty($hongbaoconfig)) {
            $balanceRed = CommonAccount::getHongbaoAccount(); //红包账户
            if ($activity) {
                $maxMoney = 0; //最大金钱
                foreach ($hongbaoconfig as $key => $val) {
                    if ($maxMoney < $val['money'] || $maxMoney == 0)
                        $maxMoney = $val['money'];
                }
                if (AccountManage::checkHasMoney($maxMoney, $balanceRed['gai_number'])) //检查是否有足够金额
                    return $activity;
                else
                    return false;
            }
            else
                return false;
        }
        else
            return empty($activity) ? false : activity;
    }

    /**
     * 检查是否已经获取红包
     * @param invatel $member_id
     * @param $type 类型（1注册送红包、2分享送红包）
     *
     */
    public static function checkHasGetRedEenvelope($member_id, $type = Activity::TYPE_REGISTER) {
        $coupon = Yii::app()->db->createCommand()
                ->select('id,money,status')
                ->from('{{coupon}}')
                ->where('type=:type and member_id=:member_id', array(':type' => $type, ':member_id' => $member_id))
                ->queryRow();
        if (!empty($coupon))
            return false;
        else
            return true;
    }

    /**
     * @author lhao
     * 抽奖算法
     *
     */
    public static function lottery() {
        $hongbaoconfig = Tool::getConfig('hongbao', 'items');
        if (empty($hongbaoconfig) || !is_array($hongbaoconfig)) {
            throw new Exception(Yii::t("RedEnvelopeTool", '配置文件出错'));
            return false;
        }
        $minMoneyItem = array('money' => 0);
        $blanceMoney = AccountManage::getSurplusMoney();
        $cacheItems = array();
        foreach ($hongbaoconfig as $key => $val) {
            if ($val['money'] < $blanceMoney)
                $cacheItems[] = $val;
            if ($minMoneyItem['money'] == 0 || $minMoneyItem['money'] > $val['money'])
                $minMoneyItem = $val;
        }
        if ($blanceMoney == 0)
            return $minMoneyItem; //红包池余额为0 直接返回最低价钱的奖项;
        $redis = Yii::app()->redis;
        if (count($hongbaoconfig) == count($cacheItems) && $redis) {//检查获取的红包总奖项与判断够钱后代奖项数是否相同 相同获取缓存，不相同另外处理
            if (!$redis->llen(Activity::LUCK_CACHE_KEY_NAME))
                RedEnvelopeTool::createCacheLottery($hongbaoconfig);
            $id = $redis->lpop(Activity::LUCK_CACHE_KEY_NAME);
            return isset($hongbaoconfig[$id]) ? $hongbaoconfig[$id] : $minMoneyItem;
        } else {
            $luckArr = array();
            foreach ($cacheItems as $val)
                $luckArr = array_merge($luckArr, array_fill(0, $val['ratio'], $val));
            shuffle($luckArr);
            $luckArrCount = count($luckArr);
            return $luckArr[rand(0, ($luckArrCount - 1))];
        }
    }

    /**
     * 创建缓存
     * @author lhao
     * @param array $hongbaoconfig
     * @throws Exception
     * @return boolean
     */
    public static function createCacheLottery($hongbaoconfig = '') {
        $hongbaoconfig = $hongbaoconfig ? $hongbaoconfig : Tool::getConfig('hongbao', 'items');
        if (empty($hongbaoconfig) || !is_array($hongbaoconfig)) {
            throw new Exception(Yii::t("RedEnvelopeTool", '配置文件出错'));
            return false;
        }
        $redis = Yii::app()->redis;
        $redis->del(Activity::LUCK_CACHE_KEY_NAME); //先清理了缓存
        $cacheItems = array();

        //处理准备放入缓存的id值
        foreach ($hongbaoconfig as $val)
            $cacheItems = array_merge($cacheItems, array_fill(0, $val['ratio'], $val['id']));
        shuffle($cacheItems);
        $cacheItemsCount = count($cacheItems);
        if (!$cacheItemsCount) {
            throw new Exception(Yii::t("RedEnvelopeTool", '配置文件出错'));
            return false;
        }
        foreach ($cacheItems as $val)
            $redis->rpush(Activity::LUCK_CACHE_KEY_NAME, $val);
        $llen = $redis->llen(Activity::LUCK_CACHE_KEY_NAME);

        if ($llen != 0 && $cacheItemsCount == $llen)
            return true;
        else
            RedEnvelopeTool::createCacheLottery($hongbaoconfig);
    }

    /**
     * 红包补偿发送信提示
     * @param $mobile 手机号
     * @param $money  红包金额
     * @param null $content 短信内容
     */
    public static function _CompensationSendSms($mobile, $money, $content = null) {
        $advertApi = SmsLog::INTERFACE_JXT_ADVERT;   // @author lc  红包活动采用广告渠道进行发送
        if ($content) {
            $smsContent = strtr($content, array(
                '{0}' => $money,
            ));
        } else {
            $smsTemp = Tool::getConfig('smsmodel', 'redCompensation');
            $smsContent = strtr($smsTemp, array(
                '{0}' => $money,
            ));
        }
        if (is_numeric($mobile) && $smsContent)
            SmsLog::addSmsLog($mobile, $smsContent,0, SmsLog::TYPE_OTHER, $advertApi);
    }

    /**
     * 红包活动发送短信提示
     * @param $mobile 手机号码
     * @param $type 活动类型(分享,注册)
     * @param $money 红包金额
     */
    public static function _sendSms($mobile, $type, $money, $isOffline = false) {
        $advertApi = SmsLog::INTERFACE_JXT_ADVERT;   // @author lc  红包活动采用广告渠道进行发送
        switch ($type) {
            case Activity::TYPE_REGISTER:
                if ($isOffline)
                    return true;
                else
                    $smsTemp = Tool::getConfig('smsmodel', 'redRegister');
                $smsContent = strtr($smsTemp, array(
                    '{0}' => $money,
                ));
                break;
            case Activity::TYPE_SHARE:
                $smsTemp = Tool::getConfig('smsmodel', 'shareRegister');
                $smsContent = strtr($smsTemp, array(
                    '{0}' => $money,
                ));
                break;
        }
        if (is_numeric($mobile))
            SmsLog::addSmsLog($mobile, $smsContent, 0, SmsLog::TYPE_OTHER, $advertApi);
    }

    /**
     * 获取会员信息.发送短信
     * @param $memberId
     * @return mixed
     */
    private static function _getMemberInfo($memberId) {
        return Yii::app()->db->createCommand()
                        ->select('id,mobile')
                        ->from('{{member}}')
                        ->where('id=:id', array(':id' => $memberId))
                        ->queryRow();
    }

}