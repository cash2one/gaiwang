<?php

/**
 * 线下新的积分规则
 * @author lc
 * @property 2012-03-27
 */
class IntegralOfflineNew {

    public static $config;     //积分规则的配置文件
    public static $smsConfig;    //短信模板的配置文件
    public static $member_type_rate;  //会员转积分的比例
    public static $agentConfig;    //代理分配的配置文件
    public static $time;     //当前执行的时间戳

    const MACHINE_FUN_NAME = '购物消费';

    /**
     * 消费备注
     */
    const CONSUMPTION_MEMBER_CONTENT = '尊敬的盖网会员：{0}，您在线下加盟商{1}的{recordType}{2}处消费{3}，使用{4}盖网积分支付。';

    /**
     * 分配记录备注
     */
    const TRUE_ACCOUNT_FAILURE = '本次是第{0}次在{recordType}{1}消费金额{2},符合自动对账需求,进行自动对账,但对账失败{3}!';
    const TRUE_ACCOUNT_SUCCESS = '本次是第{0}次在{recordType}{1}消费金额{2},符合自动对账需求,进行自动对账,对账成功{3}!';
    const LARGE_EXPENSE_MONEY = '本次是第{0}次在{recordType}{1}消费,本次消费金额大于最大金额{2}没有进行自动对账!';
    const MEMBER_EXPENSE_MONEY = '本次是第{0}次在{recordType}{1}消费,会员在{2}天内在商家消费比例大于最大比例{3}没有进行自动对账!';
    const CONSUMER_MEMBER_CONTENT = '尊敬的盖网会员{0}，您在线下加盟商{1}	的{recordType}{2}处消费{3}的记录完成对账，您获得{4}返还积分。';
    const TUIJIAN_MEMBER_CONTENT = '盖网会员{0}在线下加盟商{1}	的{recordType}{2}处消费{3}，由于不存在推荐者，推荐金额{4}进入盖网。';
    const TUIJIANCUNZAI_MEMBER_CONTENT = '您推荐的会员{0}在线下加盟商{1}	的{recordType}{2}处消费{3}，您获得{4}盖网积分。';
    const AGENT_DIST_CONTENT = '{0}账户分配金额{1}成功！剩余金额{2}，实际扣除代理金额{3}。';
    const AGENT_DIST_MEMBER_CONTENT = '{0}账户分配金额成功！您作为{1}的代理，获得{2}，此金额可以兑现。';
    const MACHINE_INTRO_CONTENT = '有会员在线下加盟商{0}的{recordType}{1}处消费{2}，您作为该{recordType}的推荐者，获得{3}盖网积分。';
    const MACHINE_INTRO_NO_CONTENT = '有会员在线下加盟商{0}	的{recordType}{1}处消费{2}，由于{recordType}不存在推荐者，推荐金额{3}进入盖网。';
    const OFFREFMACHINE_CONTENT = '盖网会员{0}在加盟商{1}处消费，由于该会员最近一次在您这里消费，因此奖励您{2}盖网积分。';
    const OFFREFMACHINE_NO_CONTENT = '盖网会员{0}在加盟商{1}处消费，由于该会员不存在最近一次消费的加盟商，{2}进入盖网。';
    const MEMBER_INFO_CASH_CONTENT = '尊敬的{0}用户，您的加盟商【{1}】共有{2}条账单记录已经完成对账，您获得{3}元可用于提现，请您核对。';
    const AGENT_CONTENT = '盖网会员{0}在线下加盟商{1}的{recordType}{2}处消费{3}，代理获得{4}。';
    const JIDONG_CONTENT = '盖网会员{0}在线下加盟商{1}的{recordType}{2}处消费{3}，机动获得{4}。';
    const COMPANY_CONTENT = '{0}在线下加盟商{1}的{recordType}{2}处消费{3}，使用消费功能，分配金额为{4}，盖网折扣{5}，会员折扣{6}，您获得金额{7}。';
    const REANCHISEE_CONSUMPTION_RECORD_CONTENT = "会员【{0}】在线下加盟商【{1}】的{recordType}【{2}】处消费{3}，分配金额为{4}，盖网折扣{5}%，会员折扣{6}%，商家获得{7}。";
    const CONSUMER_MEMBER_CONTENT_REBACK = '尊敬的盖网会员{0}，您在线下加盟商{1}的{recordType}{2}处消费的{3}的记录已被撤销，退还{4}盖网积分，此退还积分不可兑现。';
    const GATEWANGFENPEI_CONTENT = '盖网会员{0}在线下加盟商{1}的{recordType}{2}处消费{3}，盖网获得{4}。';
    const MACHINE_INSTALL_CASH_CONTENT = '盖网会员{0}在线下加盟商{1}的{recordType}{2}处消费{3}，铺机者{4}获得{5}可用于提现。';
    const MACHINE_OPERATE_CASH_CONTENT = '盖网会员{0}在线下加盟商{1}的{recordType}{2}处消费{3}，运维人{4}获得{5}可用于提现。';
    const MACHIN_REGION_CONTENT = '区域【{0}】暂未有代理,所属红包池获得{1}';
    const OFFLINE_TYPE_DEDUCT = 1; //扣钱
    const OFFLINE_TYPE_ADD = 2;     //加钱
    const DEFAULT_RECOMMANDER = 1; //消费会员推荐人
    const MACHINE_RECOMMANDER = 2; //盖机推荐人
    const LAST_FRANCHISEE_RECOMMANDER = 3; //最近一次消费的加盟商

    /**
     * 返回备注
     */

    public static function getContent($content, $data, $recordType = FranchiseeConsumptionRecord::RECORD_TYPE_POINT) {
        foreach ($data as $key => $value) {
            $content = str_replace('{' . $key . '}', $value, $content);
            switch ($recordType) {
                case FranchiseeConsumptionRecord::RECORD_TYPE_POS:
                    $recordType = 'POS机';
                    break;
                case FranchiseeConsumptionRecord::RECORD_TYPE_VENDING:
                    $recordType = '售货机';
                    break;
                case FranchiseeConsumptionRecord::RECORD_TYPE_PHONE:
                    $recordType = '掌柜';
                    break;
                case FranchiseeConsumptionRecord::RECORD_TYPE_POINT:
                default:
                    $recordType = '盖机';
                    break;
            }
            $content = str_replace('{recordType}', $recordType, $content);
        }
        return $content;
    }

    /**
     * 获取积分分配的配置文件
     */
    public static function getConfig($key = null) {

//        $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . 'allocation.config.inc';
//        self::$config = unserialize(base64_decode(file_get_contents($file)));
        self::$member_type_rate = MemberType::fileCache();
        self::$config = Tool::getConfig($name = 'allocation');
        return $key === null ? self::$config : self::$config[$key];
    }

    /**
     * 获取代理分配值
     */
    public static function getAgentConfig($key = null) {
        self::$agentConfig = Tool::getConfig($name = 'agentdist');
//        $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . 'agentdist.config.inc';
//        self::$agentConfig = unserialize(base64_decode(file_get_contents($file)));
        return $key === null ? self::$agentConfig : self::$agentConfig[$key];
    }

    /**
     * 保留两位小数，不进行四舍五入
     */
    public static function getNumberFormat($num) {
        if ($num == 0) {
            return $num;
        } else {
            return substr(sprintf("%.3f", $num), 0, -1);
        }
    }

    /**
     * 返回发送短信的记录
     */
    public static function getSmsContent($content, $data, $mobile,$rong=null,$tmpId=null) {
        foreach ($data as $key => $value) {
            $content = str_replace('{' . $key . '}', $value, $content);
        }
        return array(
            'mobile' => $mobile,
            'content' => $content,
            'data'=>$rong,
            'tmpId'=>$tmpId,
        );
    }

    /**
     * 获取短信模板的配置文件
     */
    public static function getSmsConfig($key = null) {
        self::$smsConfig = Tool::getConfig($name = 'smsmodel');
//        $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . 'smsmodel.config.inc';
//        self::$smsConfig = unserialize(base64_decode(file_get_contents($file)));
        return $key === null ? self::$smsConfig : self::$smsConfig[$key];
    }

    /**
     * 将时间戳转化成字符串格式
     */
    public static function conversionDate($time) {
        return date('Y/m/d H:i:s', $time);
    }

    /**
     * 线下消费(事务处理)
     * 往加盟商消费表里面添加数据，同时要记录到流水表里面去
     */
    public static function offlineConsume($franchisee, $machine, $member, $data, &$recordId,$extend=array()) {
        $flowHistoryTableName = AccountFlowHistory::monthTable(); //流水日志表名
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $moneyRMB = $data['moneyRMB'];
            $accountFlowTable = $data['accountFlowTable'];
            //查旧账户余额
            $balanceOldRes = AccountBalanceHistory::getTodayAmountByGaiNumber($member['gai_number']);
            //查新余额表
            $balanceRes = AccountBalance::findRecord(
                            array(
                                'account_id' => $member['id'],
                                'type' => AccountBalance::TYPE_CONSUME,
                                'gai_number' => $member['gai_number']
                            )
            );

            if (empty($balanceRes) || $balanceRes['today_amount'] < 0 || $balanceOldRes < 0)
                self::throwErrorMessage('账号异常');

            if ($moneyRMB > ($balanceOldRes + $balanceRes['today_amount']))
                self::throwErrorMessage('积分不足');

            //-----------------------------------------向加盟商消费记录表添加记录------------------------------------------
            $memberDiscount = $franchisee['member_discount'] / 100;
            $gaiwangDiscount = $franchisee['gai_discount'] / 100;
            if ($memberDiscount == 0) {
                $distributeMoney = 0;
            } else {
                //分配金额公式:金额 * (会员-盖网)
                if ($memberDiscount - $gaiwangDiscount > 0) {
                    $distributeMoney = bcmul($moneyRMB, ($memberDiscount - $gaiwangDiscount), 2);
                } else {
                    $distributeMoney = 0;
                }
            }
//            if ($distributeMoney <= 0) {
//                self::throwErrorMessage('商家设定参数有误，分配金额不得小于0', '009');
//            }


            $remark = self::getContent(
                            self::REANCHISEE_CONSUMPTION_RECORD_CONTENT, array(
                        $member['gai_number'],
                        $franchisee['name'],
                        $machine['name'],
                        self::formatPrice($data['money'], $data['symbol']),
                        self::formatPrice($distributeMoney),
                        $franchisee['gai_discount'],
                        $franchisee['member_discount'],
                        self::formatPrice(($moneyRMB - $distributeMoney)),
                            )
            );
            self::$time = time();
            //获取分配比率
            $config = self::getofflineDistributeConfig($machine['id']);
            // 消费记录数据
            $data = array(
                'spend_money' => $moneyRMB,
                'symbol' => $data['symbol'],
                'franchisee_id' => $franchisee['id'],
                'machine_id' => $machine['id'],
                'member_id' => $member['id'],
                'status' => FranchiseeConsumptionRecord::STATUS_NOTCHECK,
                'is_distributed' => FranchiseeConsumptionRecord::STATUS_NOTCHECK,
                'gai_discount' => $franchisee['gai_discount'],
                'member_discount' => $franchisee['member_discount'],
                'distribute_money' => $distributeMoney,
                'create_time' => self::$time,
                'base_price' => $data['basePrice'],
                'machine_serial_number' => $data['machineSN'],
                'serial_number' => isset($data['serial_number']) ? $data['serial_number'] : 'SNt' . Tool::buildOrderNo(),
                'remark' => $remark,
                'entered_money' => $data['money'],
                'distribute_config' => $config, //对账记录
                'record_type' => isset($data['record_type']) ? $data['record_type'] : FranchiseeConsumptionRecord::RECORD_TYPE_POINT,
                'pay_type' => isset($data['pay_type']) ? $data['pay_type'] : FranchiseeConsumptionRecord::PAY_TYPE_INTEGRAL,
            );

            //针对post消费，二次补录大于5笔时，禁止自动对账
            // ----------- modify by xuegang.liu@gmail.com   2016-04-11 15:28:32 -----------------------
            if(isset($extend['auto_check_fail']) ){
                $data['auto_check_fail'] = $extend['auto_check_fail'];
            }
            //--------------------------------------- modify end --------------------------------------

            $tn = FranchiseeConsumptionRecord::model()->tableName();

            Yii::app()->db->createCommand()->insert($tn, $data);
            $recordId = Yii::app()->db->getLastInsertID();

            //----------------------------------------加盟商消费记录表添加记录完毕---------------------------------------------
            //拼接新的$data
            if ($data['record_type'] == FranchiseeConsumptionRecord::RECORD_TYPE_POINT && isset($data['goodsId']) && isset($data['goodsNum']) && $data['goodsId'] > 0 && $data['goodsNum'] > 0 && isset($data['goodsPrice'])) {
                $insertData = array(
                    'serial_number' => $data['serial_number'],
                    'advert_id' => $data['goodsId'],
                    'price' => $data['goodsPrice'],
                    'num' => $data['goodsNum'],
                );
                Yii::app()->db->createCommand()->insert("{{franchisee_consumption_record_advert}}", $insertData);
            }
            $data['address'] = $franchisee['street'];                         //交易地点
            $data['province_id'] = $franchisee['province_id'];                //交易省份ID
            $data['city_id'] = $franchisee['city_id'];                        //交易所在市ID
            $data['district_id'] = $franchisee['district_id'];                //交易地点（区/县）ID
            $data['id'] = $recordId;
            $data['gai_number'] = $member['gai_number'];                     //会员编号

            self::getConfig();

            $official_rate = self::$member_type_rate['official'];   //正式会员积分转化为金额的比例
            $default_rate = self::$member_type_rate['default'];    //消费会员积分转化为金额的比例
            $default_type = self::$member_type_rate['defaultType'];   //消费会员类型

            $member_integral = $moneyRMB / $official_rate;
            $ratio = $official_rate;
            if ($member['type_id'] == $default_type) {  //如果是消费会员那么增加的可兑现金额就会改变
                $member_integral = $moneyRMB / $default_rate;
                $ratio = $default_rate;
            }
            $member_integral = self::getNumberFormat($member_integral);

            $remark = self::getContent(
                            self::CONSUMPTION_MEMBER_CONTENT, array(
                        $member['gai_number'],
                        $franchisee['name'],
                        $machine['name'],
                        self::formatPrice($moneyRMB),
                        $member_integral
                            ), $data['record_type']
            );
            $area = Yii::app()->db->createCommand()->select('area')->from(Region::model()->tableName())->where('id = ' . $franchisee['province_id'])->queryScalar();
            if ($area == 0) {
                self::throwErrorMessage("没有指定该地区南北");
            }
            $data['area_id'] = $area;

            //---------------------------------------修改用户金额---------------------------------
            if ($balanceRes['today_amount'] >= $moneyRMB) {
                $oldBalanceMoney = 0;    //新账户需要扣的
            } elseif ($balanceRes['today_amount'] < $moneyRMB && $balanceRes['today_amount'] > 0) {
                $oldBalanceMoney = $moneyRMB - $balanceRes['today_amount'];   //旧账户需要扣的
            } elseif ($balanceRes['today_amount'] == 0) {
                $oldBalanceMoney = $moneyRMB;   //旧账户需要扣的
            }

            //旧账号充值到新账号
            if ($oldBalanceMoney) {
                $OldmemberBalance = AccountBalanceHistory::findRecord(array(
                            'account_id' => $member['id'],
                            'gai_number' => $member['gai_number'],
                            'type' => AccountFlow::TYPE_CONSUME,
                ));
                $oldBalanceRs = HistoryBalanceUse::process($accountFlowTable, $flowHistoryTableName, $balanceRes, $OldmemberBalance, $oldBalanceMoney, $data['serial_number'], $recordId);
                if (!$oldBalanceRs)
                    self::throwErrorMessage('充值失败');
            }
            //消费会员账号扣钱
            $result = AccountBalance::calculate(array('today_amount' => -$moneyRMB), $balanceRes['id']);
            if (!$result)
                self::throwErrorMessage('更新消费账户失败');

            $memberAccountFlow = array(
                'gai_number' => $member['gai_number'], //GW号
                'debit_amount' => $moneyRMB, //发生额
                'ratio' => $ratio, //积分兑换比例
                'remark' => $remark,
                'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_ORDER_PAY, //备注
                'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_PAY,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_CONSUME,
            );
            self::insertAccFlow($memberAccountFlow, $data, $balanceRes, $accountFlowTable);
            //-------------------------------------修改用户金额完毕-------------------------------
            //----------------------------------------------------------盖网公共账户扣钱-----------------------------------------------------

            $GWPublicAcc = CommonAccount::getOfflineAccount();   //线下总账户余额信息

            $result = AccountBalance::calculate(array('today_amount' => $moneyRMB), $GWPublicAcc['id']);
            if (!$result)
                self::throwErrorMessage("更新公共账户金额失败");

            $accountFlowVirtual = array(
                'credit_amount' => $moneyRMB, //贷方发生额
                'remark' => $remark, //备注
                'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_ORDER_PAY,
                'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_PAY_CHECK,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_CONSUME,
            );
            self::insertAccFlow($accountFlowVirtual, $data, $GWPublicAcc, $accountFlowTable);
            //-------------------------------------------------------盖网公共账户扣钱完毕---------------------------------------

            if (!DebitCredit::checkFlowByCode($accountFlowTable, $data['serial_number']))
                throw new ErrorException('Code DebitCredit Error!', '010');

            if ($oldBalanceMoney) {
                $result = HistoryBalanceUse::pay($data['serial_number'], $oldBalanceMoney, $member, $data['serial_number']);
                if (!$result)
                    self::throwErrorMessage("银行支付失败!");
            }

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            return $e->getMessage();
        }
        return true;
    }

    /**
     * 线下消费(事务处理)
     * 往加盟商消费表里面添加数据，同时要记录到流水表里面去
     * 补录专用
     */
    public static function offlineConsumePos($franchisee, $machine, $member, $data, &$recordId,$extend=array(),$timeS = null) {
        if($timeS === null)
            $timeS = time();
        $flowHistoryTableName = AccountFlowHistory::monthTable($timeS); //流水日志表名
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $moneyRMB = $data['moneyRMB'];
            $accountFlowTable = $data['accountFlowTable'];
            //查旧账户余额
            $balanceOldRes = AccountBalanceHistory::getTodayAmountByGaiNumber($member['gai_number']);
            //查新余额表
            $balanceRes = AccountBalance::findRecord(
                array(
                    'account_id' => $member['id'],
                    'type' => AccountBalance::TYPE_CONSUME,
                    'gai_number' => $member['gai_number']
                )
            );

            if (empty($balanceRes) || $balanceRes['today_amount'] < 0 || $balanceOldRes < 0)
                self::throwErrorMessage('账号异常');

            if ($moneyRMB > ($balanceOldRes + $balanceRes['today_amount']))
                self::throwErrorMessage('积分不足');

            //-----------------------------------------向加盟商消费记录表添加记录------------------------------------------
            $memberDiscount = $franchisee['member_discount'] / 100;
            $gaiwangDiscount = $franchisee['gai_discount'] / 100;
            if ($memberDiscount == 0) {
                $distributeMoney = 0;
            } else {
                //分配金额公式:金额 * (会员-盖网)
                if ($memberDiscount - $gaiwangDiscount > 0) {
                    $distributeMoney = bcmul($moneyRMB, ($memberDiscount - $gaiwangDiscount), 2);
                } else {
                    $distributeMoney = 0;
                }
            }
//            if ($distributeMoney <= 0) {
//                self::throwErrorMessage('商家设定参数有误，分配金额不得小于0', '009');
//            }


            $remark = self::getContent(
                self::REANCHISEE_CONSUMPTION_RECORD_CONTENT, array(
                    $member['gai_number'],
                    $franchisee['name'],
                    $machine['name'],
                    self::formatPrice($data['money'], $data['symbol']),
                    self::formatPrice($distributeMoney),
                    $franchisee['gai_discount'],
                    $franchisee['member_discount'],
                    self::formatPrice(($moneyRMB - $distributeMoney)),
                )
            );
            self::$time = $timeS;
            //获取分配比率
            $config = self::getofflineDistributeConfig($machine['id']);
            // 消费记录数据
            $data = array(
                'spend_money' => $moneyRMB,
                'symbol' => $data['symbol'],
                'franchisee_id' => $franchisee['id'],
                'machine_id' => $machine['id'],
                'member_id' => $member['id'],
                'status' => FranchiseeConsumptionRecord::STATUS_NOTCHECK,
                'is_distributed' => FranchiseeConsumptionRecord::STATUS_NOTCHECK,
                'gai_discount' => $franchisee['gai_discount'],
                'member_discount' => $franchisee['member_discount'],
                'distribute_money' => $distributeMoney,
                'create_time' => self::$time,
                'base_price' => $data['basePrice'],
                'machine_serial_number' => $data['machineSN'],
                'serial_number' => isset($data['serial_number']) ? $data['serial_number'] : 'SNt' . Tool::buildOrderNo(),
                'remark' => $remark,
                'entered_money' => $data['money'],
                'distribute_config' => $config, //对账记录
                'record_type' => isset($data['record_type']) ? $data['record_type'] : FranchiseeConsumptionRecord::RECORD_TYPE_POINT,
                'pay_type' => isset($data['pay_type']) ? $data['pay_type'] : FranchiseeConsumptionRecord::PAY_TYPE_INTEGRAL,
            );

            //针对post消费，二次补录大于5笔时，禁止自动对账
            // ----------- modify by xuegang.liu@gmail.com   2016-04-11 15:28:32 -----------------------
            if(isset($extend['auto_check_fail']) ){
                $data['auto_check_fail'] = $extend['auto_check_fail'];
            }
            //--------------------------------------- modify end --------------------------------------

            $tn = FranchiseeConsumptionRecord::model()->tableName();

            Yii::app()->db->createCommand()->insert($tn, $data);
            $recordId = Yii::app()->db->getLastInsertID();

            //----------------------------------------加盟商消费记录表添加记录完毕---------------------------------------------
            //拼接新的$data
            if ($data['record_type'] == FranchiseeConsumptionRecord::RECORD_TYPE_POINT && isset($data['goodsId']) && isset($data['goodsNum']) && $data['goodsId'] > 0 && $data['goodsNum'] > 0 && isset($data['goodsPrice'])) {
                $insertData = array(
                    'serial_number' => $data['serial_number'],
                    'advert_id' => $data['goodsId'],
                    'price' => $data['goodsPrice'],
                    'num' => $data['goodsNum'],
                );
                Yii::app()->db->createCommand()->insert("{{franchisee_consumption_record_advert}}", $insertData);
            }
            $data['address'] = $franchisee['street'];                         //交易地点
            $data['province_id'] = $franchisee['province_id'];                //交易省份ID
            $data['city_id'] = $franchisee['city_id'];                        //交易所在市ID
            $data['district_id'] = $franchisee['district_id'];                //交易地点（区/县）ID
            $data['id'] = $recordId;
            $data['gai_number'] = $member['gai_number'];                     //会员编号

            self::getConfig();

            $official_rate = self::$member_type_rate['official'];   //正式会员积分转化为金额的比例
            $default_rate = self::$member_type_rate['default'];    //消费会员积分转化为金额的比例
            $default_type = self::$member_type_rate['defaultType'];   //消费会员类型

            $member_integral = $moneyRMB / $official_rate;
            $ratio = $official_rate;
            if ($member['type_id'] == $default_type) {  //如果是消费会员那么增加的可兑现金额就会改变
                $member_integral = $moneyRMB / $default_rate;
                $ratio = $default_rate;
            }
            $member_integral = self::getNumberFormat($member_integral);

            $remark = self::getContent(
                self::CONSUMPTION_MEMBER_CONTENT, array(
                $member['gai_number'],
                $franchisee['name'],
                $machine['name'],
                self::formatPrice($moneyRMB),
                $member_integral
            ), $data['record_type']
            );
            $area = Yii::app()->db->createCommand()->select('area')->from(Region::model()->tableName())->where('id = ' . $franchisee['province_id'])->queryScalar();
            if ($area == 0) {
                self::throwErrorMessage("没有指定该地区南北");
            }
            $data['area_id'] = $area;

            //---------------------------------------修改用户金额---------------------------------
            if ($balanceRes['today_amount'] >= $moneyRMB) {
                $oldBalanceMoney = 0;    //新账户需要扣的
            } elseif ($balanceRes['today_amount'] < $moneyRMB && $balanceRes['today_amount'] > 0) {
                $oldBalanceMoney = $moneyRMB - $balanceRes['today_amount'];   //旧账户需要扣的
            } elseif ($balanceRes['today_amount'] == 0) {
                $oldBalanceMoney = $moneyRMB;   //旧账户需要扣的
            }

            //旧账号充值到新账号
            if ($oldBalanceMoney) {
                $OldmemberBalance = AccountBalanceHistory::findRecord(array(
                    'account_id' => $member['id'],
                    'gai_number' => $member['gai_number'],
                    'type' => AccountFlow::TYPE_CONSUME,
                ));
                $oldBalanceRs = HistoryBalanceUse::process($accountFlowTable, $flowHistoryTableName, $balanceRes, $OldmemberBalance, $oldBalanceMoney, $data['serial_number'], $recordId);
                if (!$oldBalanceRs)
                    self::throwErrorMessage('充值失败');
            }
            //消费会员账号扣钱
            $result = AccountBalance::calculate(array('today_amount' => -$moneyRMB), $balanceRes['id']);
            if (!$result)
                self::throwErrorMessage('更新消费账户失败');

            $memberAccountFlow = array(
                'gai_number' => $member['gai_number'], //GW号
                'debit_amount' => $moneyRMB, //发生额
                'ratio' => $ratio, //积分兑换比例
                'remark' => $remark,
                'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_ORDER_PAY, //备注
                'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_PAY,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_CONSUME,
            );
            self::insertAccFlow($memberAccountFlow, $data, $balanceRes, $accountFlowTable);
            //-------------------------------------修改用户金额完毕-------------------------------
            //----------------------------------------------------------盖网公共账户扣钱-----------------------------------------------------

            $GWPublicAcc = CommonAccount::getOfflineAccount();   //线下总账户余额信息

            $result = AccountBalance::calculate(array('today_amount' => $moneyRMB), $GWPublicAcc['id']);
            if (!$result)
                self::throwErrorMessage("更新公共账户金额失败");

            $accountFlowVirtual = array(
                'credit_amount' => $moneyRMB, //贷方发生额
                'remark' => $remark, //备注
                'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_ORDER_PAY,
                'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_PAY_CHECK,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_CONSUME,
            );
            self::insertAccFlow($accountFlowVirtual, $data, $GWPublicAcc, $accountFlowTable);
            //-------------------------------------------------------盖网公共账户扣钱完毕---------------------------------------

            if (!DebitCredit::checkFlowByCode($accountFlowTable, $data['serial_number']))
                throw new ErrorException('Code DebitCredit Error!', '010');

            if ($oldBalanceMoney) {
                $result = HistoryBalanceUse::pay($data['serial_number'], $oldBalanceMoney, $member, $data['serial_number']);
                if (!$result)
                    self::throwErrorMessage("银行支付失败!");
            }

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            return $e->getMessage();
        }
        return true;
    }

    //获取申请撤销的和已经撤销的线下交易id
    public static function getRebackData($id = "", $array = array(), $get_arr = true) {
        if (empty($array) || !is_array($array))
            $array = array(FranchiseeConsumptionRecordRepeal::STATUS_APPLY, FranchiseeConsumptionRecordRepeal::STATUS_PASS);
        $id_where = empty($id) ? "1=1" : "record_id in (" . $id . ")";
        $status = implode(",", $array);
        $tn_repeal = FranchiseeConsumptionRecordRepeal::model()->tableName();
        $data_repeal = Yii::app()->db->createCommand()
                ->select('record_id')->from($tn_repeal)->where($id_where . ' and status in (' . $status . ')')
                ->queryAll();
        $repeal_ids_arr = array();
        $repeal_ids = "";
        if ($data_repeal) {
            foreach ($data_repeal as $row) {
                $repeal_ids_arr[] = $row['record_id'];
                $repeal_ids .= $row['record_id'] . ",";
            }
        }
        return $get_arr ? $repeal_ids_arr : substr($repeal_ids, 0, -1);
    }

    //获取申请对账的和已经对账的线下交易id
    public static function getConsumptionData($id = "", $array = array(), $get_arr = true) {
        if (empty($array) || !is_array($array))
            $array = array(FranchiseeConsumptionRecordConfirm::STATUS_APPLY, FranchiseeConsumptionRecordConfirm::STATUS_PASS);
        $id_where = empty($id) ? "1=1" : "record_id in (" . $id . ")";
        $status = implode(",", $array);
        $tn_repeal = FranchiseeConsumptionRecordConfirm::model()->tableName();
        $data_repeal = Yii::app()->db->createCommand()
                ->select('record_id')->from($tn_repeal)->where($id_where . ' and status in (' . $status . ')')
                ->queryAll();
        $repeal_ids_arr = array();
        $repeal_ids = "";
        if ($data_repeal) {
            foreach ($data_repeal as $row) {
                $repeal_ids_arr[] = $row['record_id'];
                $repeal_ids .= $row['record_id'] . ",";
            }
        }
        return $get_arr ? $repeal_ids_arr : substr($repeal_ids, 0, -1);
    }

    /**
     * 对账的时候线下总账户扣钱
     * @param array $data 基本数据
     * @param array $accdata 线下总账户数据
     * @param float $money 扣减金额
     * @param string $accountFlowTable 流水表
     */
    public static function sourceAddMoney($data, $accData, $money, $accountFlowTable) {
        //金额变动
        $result = AccountBalance::calculate(array('today_amount' => -$money), $accData['id']);
        if (!$result) {
            $error = "扣减线下总账户金额失败";
            self::throwErrorMessage($error);
        }

        //设定部分流水数据
        $accountFlowVirtual = array(
            'debit_amount' => $money, //借方发生额
            'remark' => "线下总账户扣减金额：$money", //备注
            'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_CONFIRM, //业务节点
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION, //事务类型
        );
        self::insertAccFlow($accountFlowVirtual, $data, $accData, $accountFlowTable);
    }

    /**
     * 对账时企业用户金额增加
     * @param array $data 基本数据
     * @param float $money 增加金额
     * @param string $accountFlowTable 流水表
     */
    public static function storeAddMoney($data, $money, $accountFlowTable) {
        $member_table = Member::model()->tableName();
        $enterprise_table = Enterprise::model()->tableName();
        $franchisee_table = Franchisee::model()->tableName();
        $sql = "select m.id,m.gai_number from 
		$franchisee_table f 
		left join $member_table m on m.id = f.member_id
		where f.id = " . $data['franchisee_id'];

        $franchisee_member_data = Yii::app()->db->createCommand($sql)->queryRow();
        if (empty($franchisee_member_data)) {
            $error = "找不到商家[" . $data['franchisee_name'] . "]，未找到加盟商对应的企业用户";
            self::throwErrorMessage($error);
        }

        //获取企业用户余额
        $storeBalance = AccountBalance::findRecord(array(
                    'account_id' => $franchisee_member_data['id'],
                    'type' => AccountBalance::TYPE_MERCHANT,
                    'gai_number' => $franchisee_member_data['gai_number']
        ));

        $result = AccountBalance::calculate(array('today_amount' => $money), $storeBalance['id']);
        if (!$result) {
            $error = "增加企业用户金额失败";
            self::throwErrorMessage($error);
        }

        //编写备注
        $remark = self::getContent(self::COMPANY_CONTENT, array(
                    $data['gai_number'], $data['franchisee_name'], $data['machine_name'], self::formatPrice($data['spend_money']), self::formatPrice($data['distribute_money']),
                    $data['gai_discount'], $data['member_discount'], self::formatPrice($money)
                        ), $data['record_type']);

        //设定流水数据
        $storeAccountFlow = array(
            'credit_amount' => $money, //贷方发生额
            'remark' => $remark, //备注
            'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_PAY_CASH, //业务节点
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION, //事务类型
        );
        self::insertAccFlow($storeAccountFlow, $data, $storeBalance, $accountFlowTable);
    }

    /**
     * 消费会员分配
     * @param array $data 由消费记录所查询得到的基础数据
     * @param float $money 分配金额
     * @param float $integral 金额换算积分
     * @param float $ratio 积分兑换比例
     * @param string $accountFlowTable 流水表
     */
    public static function memberDistribute($data, $money, $integral, $ratio, $accountFlowTable) {
        //找到会员余额
        $memberBalance = AccountBalance::findRecord(array(
                    'account_id' => $data['member_id'],
                    'type' => AccountBalance::TYPE_CONSUME,
                    'gai_number' => $data['gai_number']
        ));

        $result = AccountBalance::calculate(array('today_amount' => $money), $memberBalance['id']);
        if (!$result) {
            $error = "增加消费会员用户金额失败";
            self::throwErrorMessage($error);
        }

        //向账目流水表中插入记录
        $remark = self::getContent(self::CONSUMER_MEMBER_CONTENT, array(
                    $data['gai_number'], $data['franchisee_name'], $data['machine_name'], self::formatPrice($data['spend_money']), $integral
                        ), $data['record_type']);

        $distributionRatio = self::getNumberFormat($money / $data['distribute_money']);
        $memberAccountFlow = array(
            'credit_amount' => $money, //贷方发生额
            'ratio' => $ratio, //积分兑换比例
            'remark' => $remark, //备注
            'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_REWARD, //业务节点
            'distribution_ratio' => $distributionRatio, //分配比率
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION, //事务类型
        );
        self::insertAccFlow($memberAccountFlow, $data, $memberBalance, $accountFlowTable);

        //获取消费会员总金额(新 + 旧)
        $old_money = Member::getHistoryPrice(AccountBalance::TYPE_CONSUME, $data['member_id'], $data['gai_number']);
        $new_money = $memberBalance['today_amount'] + $money;

        $total_money = $old_money + $new_money;
        //编写短信
        $total_integral = $total_money / $ratio;
        $total_integral = self::getNumberFormat($total_integral);
        $consumer_sms_content = self::getSmsConfig('offScoreConsumeMember');
         $price = is_numeric($data['spend_money']) ? sprintf('%0.2f',$data['spend_money']):$data['spend_money'];
        $priceConvert = Yii::app()->language != 'zh_cn' ? (is_numeric($price) ? number_format(Common::rateConvert($price), 2) : $price) : $price;
        $tmpId = self::getSmsConfig('offScoreConsumeMemberId'); 
        $rong =array(
                    $data['gai_number'], self::conversionDate($data['create_time']), $data['franchisee_name'], self::MACHINE_FUN_NAME,
                   $priceConvert, $integral, $total_integral
                        );
        return self::getSmsContent($consumer_sms_content, array(
                    $data['gai_number'], self::conversionDate($data['create_time']), $data['franchisee_name'], self::MACHINE_FUN_NAME,
                    HtmlHelper::formatPrice($data['spend_money']), $integral, $total_integral
                        ), $data['mobile'],$rong,$tmpId);
    }

    /**
     * 对账时消费会员推荐人增加金额
     * @param array $data 由消费记录所查询得到的基础数据
     * @param float $money 分配金额
     * @param float $integral 积分换算金额
     * @param float ratio 消费会员推荐人比率
     * @param string $accountFlowTable 流水表
     */
    public static function reMemberDistribute($data, $money, $integral, $ratio, $accountFlowTable) {
        $reMemberBalance = AccountBalance::findRecord(array(
                    'account_id' => $data['referrals_id'],
                    'type' => AccountBalance::TYPE_CONSUME,
                    'gai_number' => $data['referrals_gai_number']
        ));

        $result = AccountBalance::calculate(array('today_amount' => $money), $reMemberBalance['id']);
        if (!$result) {
            $error = "增加消费会员推荐人金额失败";
            self::throwErrorMessage($error);
        }

        //向账目流水表中插入记录
        $remark = self::getContent(self::TUIJIANCUNZAI_MEMBER_CONTENT, array(
                    $data['gai_number'], $data['franchisee_name'], $data['machine_name'], self::formatPrice($data['spend_money']), $integral
                        ), $data['record_type']);

        $distributionRatio = self::getNumberFormat($money / $data['distribute_money']);
        $rememberAccountFlow = array(
            'credit_amount' => $money, //贷方发生额
            'ratio' => $ratio, //积分兑换比例
            'remark' => $remark, //备注
            'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_DISTRIBUTION_OTHER, //业务节点
            'distribution_ratio' => $distributionRatio, //分配比率
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION, //事务类型
            'by_gai_number' => $data['gai_number'], //消费会员GW号
        );
        self::insertAccFlow($rememberAccountFlow, $data, $reMemberBalance, $accountFlowTable);

        //获取消费会员总金额(新 + 旧)
        $old_money = Member::getHistoryPrice(AccountBalance::TYPE_CONSUME, $data['referrals_id'], $data['referrals_gai_number']);
        $new_money = $reMemberBalance['today_amount'] + $money;

        $total_money = $old_money + $new_money;
        //编写短信内容
        $referrals_sms_content = self::getSmsConfig('offScoreConsumeRef');
        $tmpId = self::getSmsConfig('offScoreConsumeRefId');
        
        $total_integral = $total_money / $ratio;
        $total_integral = self::getNumberFormat($total_integral);
        $rong = array(
                    $data['referrals_gai_number'], $data['gai_number'], self::conversionDate($data['create_time']), $data['franchisee_name'],
                    $integral, $total_integral
                        );
        return self::getSmsContent($referrals_sms_content, array(
                    $data['referrals_gai_number'], $data['gai_number'], self::conversionDate($data['create_time']), $data['franchisee_name'],
                    $integral, $total_integral
                        ), $data['referrals_mobile'],$rong,$tmpId);
    }

    /**
     * 对账时盖网分配金额
     * @param array $data 基础数据
     * @param float $money 分配金额
     * @param string $accountFlowTable 流水表名
     * @param array $gai_acc 盖网收益账户
     */
    public static function gaiDistribute($data, $money, $accountFlowTable, $gai_acc) {
        $result = AccountBalance::calculate(array('today_amount' => $money), $gai_acc['id']);
        if (!$result) {
            $error = "增加盖网公共账户金额失败";
            self::throwErrorMessage($error);
        }

        $remark = self::getContent(self::GATEWANGFENPEI_CONTENT, array(
                    $data['gai_number'], $data['franchisee_name'], $data['machine_name'], self::formatPrice($data['spend_money']), self::formatPrice($money)
                        ), $data['record_type']);

        $distributionRatio = self::getNumberFormat($money / $data['distribute_money']);
        $accountFlowGai = array(
            'credit_amount' => $money,
            'remark' => $remark,
            'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_DISTRIBUTION, //业务节点
            'distribution_ratio' => $distributionRatio, //分配比率
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION, //事务类型
        );
        self::insertAccFlow($accountFlowGai, $data, $gai_acc, $accountFlowTable);
    }

    /**
     * 对账时盖机推荐人增加金额
     * @param array $data 由消费记录所查询得到的基础数据
     * @param fload $money 分配金额
     * @param float $integral 分配金额对应积分
     * @param float $ratio 比率
     * @param string $accountFlowTable 流水表
     */
    public static function reMachineDistribute($data, $money, $integral, $ratio, $accountFlowTable) {
        $reMachineBalance = AccountBalance::findRecord(array(
                    'account_id' => $data['intro_member_id'],
                    'type' => AccountBalance::TYPE_CONSUME,
                    'gai_number' => $data['introMemberData']['machine_intro_gai_number']
        ));

        $result = AccountBalance::calculate(array('today_amount' => $money), $reMachineBalance['id']);
        if (!$result) {
            $error = "增加盖机推荐人金额失败";
            self::throwErrorMessage($error);
        }
        //向账目流水表中插入记录
        $remark = self::getContent(self::MACHINE_INTRO_CONTENT, array(
                    $data['franchisee_name'], $data['machine_name'], self::formatPrice($data['spend_money']), $integral
                        ), $data['record_type']);

        $distributionRatio = self::getNumberFormat($money / $data['distribute_money']);
        $reMachineAccountFlow = array(
            'credit_amount' => $money, //发生额
            'remark' => $remark, //备注
            'ratio' => $ratio, //比率
            'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_DISTRIBUTION_OTHER, //业务节点
            'distribution_ratio' => $distributionRatio, //分配比率
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION, //事务类型
        );
        self::insertAccFlow($reMachineAccountFlow, $data, $reMachineBalance, $accountFlowTable);
    }

    /**
     * 对账时最后一次消费的加盟商分配
     * @param array $data 由消费记录所查询得到的基础数据
     * @param array $lastFranchisee 最后一次消费加盟商数据
     * @param float $money 分配金额
     * @param float $integral 换算积分
     * @param float $ratio 比率
     * @param string $accountFlowTable 流水表
     */
    public static function lastFranchiseeDistrubute($data, $lastFranchisee, $money, $integral, $ratio, $accountFlowTable) {
        $lastFranchiseeBalance = AccountBalance::findRecord(array(
                    'account_id' => $lastFranchisee['last_member_id'],
                    'type' => AccountBalance::TYPE_CONSUME,
                    'gai_number' => $lastFranchisee['last_gai_number']
        ));

        $result = AccountBalance::calculate(array('today_amount' => $money), $lastFranchiseeBalance['id']);
        if (!$result) {
            $error = "增加最后一次消费加盟商[" . $lastFranchisee['last_username'] . "]金额失败";
            self::throwErrorMessage($error);
        }

        //向账目流水表中插入记录
        $remark = self::getContent(self::OFFREFMACHINE_CONTENT, array(
                    $data['gai_number'], $data['franchisee_name'], $integral
                        ), $data['record_type']);

        $distributionRatio = self::getNumberFormat($money / $data['distribute_money']);
        $lastFranchiseeAccountFlow = array(
            'credit_amount' => $money, //发生额
            'ratio' => $ratio, //积分换算比例
            'remark' => $remark, //备注
            'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_DISTRIBUTION_OTHER, //业务节点
            'distribution_ratio' => $distributionRatio, //分配比率
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION, //事务类型
        );
        self::insertAccFlow($lastFranchiseeAccountFlow, $data, $lastFranchiseeBalance, $accountFlowTable);
    }

    /**
     * 对账时代理里面进行分配金额
     * @param array $data 基础数据
     * @param array $agents 代理数据
     * @param float $money 增加金额
     * @param float $accountFlowTable 账目流水表
     */
    public static function agentDistributeByCity($data, $agents, $money, $ratio='', $accountFlowTable) {
        $agentBalance = AccountBalance::findRecord(array(
                    'account_id' => $agents['agent_area_member_id'],
                    'type' => AccountBalance::TYPE_AGENT,
                    'gai_number' => $agents['agent_area_gai_number']
        ));

        $result = AccountBalance::calculate(array('today_amount' => $money), $agentBalance['id']);
        if (!$result) {
            $error = "更新代理[" . $agents['agent_area_member_id'] . '--' . $agents['agent_area_username'] . " ]金额失败";
            self::throwErrorMessage($error);
        }

        //向账目流水表中插入记录
        $remark = self::getContent(self::AGENT_DIST_MEMBER_CONTENT, array(
                    $agents['agent_name'], $agents['agent_area_name'], self::formatPrice($money)
                        ), $data['record_type']);


        $accountFlowAgent = array(
            'credit_amount' => $money,
            'remark' => $remark,
            'ratio' => $agents['agent_ratio'],
            'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_ORDER_RECON,
            'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_DISTRIBUTION_AGENT, //业务节点
            'distribution_ratio' => self::getNumberFormat($money / $data['distribute_money']), //分配比率
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION, //事务类型
        );
        self::insertAccFlow($accountFlowAgent, $data, $agentBalance, $accountFlowTable);
    }

    /**
     * 对账时机动分配金额
     * @param array $data 基础数据
     * @param float $money 分配金额
     * @param string $accountFlowTable 流水表名
     * @param array $gai 机动账户
     */
    public static function maneuverDistribute($data, $money, $accountFlowTable, $gai) {
        $result = AccountBalance::calculate(array('today_amount' => $money), $gai['id']);
        if (!$result) {
            $error = "增加机动共账户金额失败";
            self::throwErrorMessage($error);
        }
        //向账目流水表中插入记录 
        $remark = self::getContent(self::JIDONG_CONTENT, array(
                    $data['gai_number'], $data['franchisee_name'], $data['machine_name'], self::formatPrice($data['spend_money']), self::formatPrice($money)
                        ), $data['record_type']);

        $distributionRatio = self::getNumberFormat($money / $data['distribute_money']);
        $maneuverAccountFlow = array(
            'credit_amount' => $money, //发生额
            'remark' => $remark, //备注
            'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_DISTRIBUTION_OTHER, //业务节点
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION, //事务类型
        );
        self::insertAccFlow($maneuverAccountFlow, $data, $gai, $accountFlowTable);
    }

    /**
     * 对账时铺机者金额分配
     * @param array $data 基本数据
     * @param float $money 分配金额
     * @param float $integral 分配积分
     * @param string accountFlowTable 流水表
     */
    public static function machineLineDistribute($data, $money, $integral, $ratio, $accountFlowTable) {

        $machineLine = AccountBalance::findRecord(array(
                    'account_id' => $data['install_member_id'],
                    'type' => AccountBalance::TYPE_CASH,
                    'gai_number' => $data['installMemberData']['machine_install_gai_number']
        ));
        $result = AccountBalance::calculate(array('today_amount' => $money), $machineLine['id']);
        if (!$result) {
            $error = '增加铺机者金额失败';
            self::throwErrorMessage($error);
        }

        $remark = self::getContent(self::MACHINE_INSTALL_CASH_CONTENT, array(
                    $data['gai_number'], $data['franchisee_name'], $data['machine_name'], self::formatPrice($data['spend_money']), $data['installMemberData']['machine_install_gai_number'], self::formatPrice($money)
                        ), $data['record_type']);


        $machineLineAccountFlow = array(
            'credit_amount' => $money, //发生额
            'remark' => $remark, //备注
            'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_DISTRIBUTION_OTHER, //业务节点
            'ratio' => $ratio, //分配比率
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION, //事务类型
        );

        self::insertAccFlow($machineLineAccountFlow, $data, $machineLine, $accountFlowTable);
    }

    /**
     * 运维人
     * @param array $data  基本数据
     * @param float $money 分配金额
     * @param float $integral 分配积分
     * @param string $accountFlowTable 流水表
     * */
    public static function machineOperationDistribute($data, $money, $integral, $ratio, $accountFlowTable) {

        $machineOperation = AccountBalance::findRecord(array(
                    'account_id' => $data['operate_member_id'],
                    'type' => AccountBalance::TYPE_CASH,
                    'gai_number' => $data['operateMemberData']['machine_operate_gai_number']
        ));

        $result = AccountBalance::calculate(array('today_amount' => $money), $machineOperation['id']);
        if (!$result) {
            $error = '增加铺机者金额失败';
            self::throwErrorMessage($error);
        }
        $remark = self::getContent(self::MACHINE_OPERATE_CASH_CONTENT, array(
                    $data['gai_number'], $data['franchisee_name'], $data['machine_name'], self::formatPrice($data['spend_money']), $data['operateMemberData']['machine_operate_gai_number'], self::formatPrice($money)
                        ), $data['record_type']);


        $machineLineAccountFlow = array(
            'credit_amount' => $money, //发生额
            'remark' => $remark, //备注
            'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_DISTRIBUTION_OTHER, //业务节点
            'ratio' => $ratio, //分配比率
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION, //事务类型
        );
        self::insertAccFlow($machineLineAccountFlow, $data, $machineOperation, $accountFlowTable);
    }

    /**
     * 对账时不存在的区域分配进入对应资金池
     * @param array $data 基本数据
     * @param float $money 分配金额
     * @param array $region_data 对应区域数据
     * @param string $accountFlowTable 流水表
     * @param array $region 对应区域账户
     */
    public static function CashPooling($data, $money, $region_data, $accountFlowTable, $region) {

        $result = AccountBalance::calculate(array('today_amount' => $money), $region['id']);
        if (!$result) {
            $error = "增加区域[" . $region_data['name'] . "]金额失败";
            self::throwErrorMessage($error);
        }
        //向账目流水表中插入记录 
        $remark = self::getContent(self::MACHIN_REGION_CONTENT, array(
                    $region_data['name'], self::formatPrice($money)
                        ), $data['record_type']);

        $distributionRatio = self::getNumberFormat($money / $data['distribute_money']);
        $regionAccountFlow = array(
            'credit_amount' => $money, //发生额
            'remark' => $remark, //备注
            'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_DISTRIBUTION_AGENT, //业务节点
            'distribution_ratio' => $distributionRatio, //分配比率
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION, //事务类型
        );
        self::insertAccFlow($regionAccountFlow, $data, $region, $accountFlowTable);
    }

    /**
     * 向流水表中插入数据
     * @param    array $arr 部分改变的数据
     * @param    array $data 基础数据
     * @param    array $oldData 旧数据
     * @param    string $tableMonth 要插入的表
     * 加了备注说明需要根据不同的操作传对应数组
     */
    public static function insertAccFlow($arr, $data, $oldData, $tableMonth) {
        $accountFlowData = array(
            'account_id' => $oldData['account_id'], //所属账号
            'gai_number' => $oldData['gai_number'], //GW号
            'card_no' => $oldData['card_no'], //卡号
            'date' => date('Y-m-d', self::$time), //日期
            'create_time' => self::$time, //创建时间
            'type' => $oldData['type'], //类型（1商家、2代理、3消费、4待返还、5冻结、6、盖网公共、9总账户）
            'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_ORDER_RECON, //操作类型
            'trade_spec' => $data['address'],
            'trade_terminal_id' => $data['machine_id'],
            'order_id' => $data['id'],
            'order_code' => $data['serial_number'],
            'area_id' => $data['area_id'],
            'province_id' => $data['province_id'],
            'city_id' => $data['city_id'],
            'district_id' => $data['district_id'],
            'week' => date('W', self::$time),
            'week_day' => date('w', self::$time),
            'ip' => Tool::getIP(),
            'hour' => date('G', self::$time),
            'franchisee_id' => $data['franchisee_id'],
        );
        $insertDataArr = array_merge($accountFlowData, $arr);

        Yii::app()->db->createCommand()->insert($tableMonth, $insertDataArr);
    }

    /**
     * 获取地区完整名称（省/市/区）
     * @param int $city_id 省/市/区编号
     */
    public static function getRegionFullName($city_id, $name = "") {
        $region = Yii::app()->db->createCommand()
                ->select("parent_id,name,depth")
                ->from("{{region}}")
                ->where("id = $city_id")
                ->queryRow();
        if ($region['depth'] == 1) {  //表示已经到达省级
            $regionFullName = $region['name'] . $name;
        } else {
            $regionFullName = self::getRegionFullName($region['parent_id'], $region['name'] . $name);
        }
        return $regionFullName;
    }

    /**
     * 根据加盟商所在的区得到区代理、市代理、省代理
     * @author lc
     */
    public static function getAgentsMemberId($district_id) {
        $agents = array();
        $tn = Region::model()->tableName();
        $member_table = Member::model()->tableName();   //会员表
        $sql = "select t.parent_id,t.member_id,t.name,m.gai_number,pm.username,pm.type_id,m.mobile from $tn t left join $member_table m on m.id=t.member_id left join $member_table pm on pm.id=m.pid and m.role = 2 where t.id=$district_id";
        $district_region = Yii::app()->db->createCommand($sql)->queryRow();
        $agents['district'] = (!empty($district_region)) ? $district_region['member_id'] : 0; //区代理
        $agents['district_type_id'] = (!empty($district_region)) ? $district_region['type_id'] : 0;
        $agents['district_name'] = (!empty($district_region)) ? $district_region['name'] : '';
        $agents['district_mobile'] = (!empty($district_region)) ? $district_region['mobile'] : '';
        $agents['district_gai_number'] = (!empty($district_region)) ? $district_region['gai_number'] : '';
        $agents['district_username'] = (!empty($district_region)) ? $district_region['username'] : '';
        $sql = "select t.parent_id,t.member_id,t.name,m.gai_number,pm.username,pm.type_id,m.mobile from $tn t left join $member_table m on m.id=t.member_id left join $member_table pm on pm.id=m.pid and m.role = 2 where t.id=" . $district_region['parent_id'];
        $city_region = Yii::app()->db->createCommand($sql)->queryRow();
        $agents['city'] = (!empty($city_region)) ? $city_region['member_id'] : 0; //市代理
        $agents['city_type_id'] = (!empty($city_region)) ? $city_region['type_id'] : 0;
        $agents['city_name'] = (!empty($city_region)) ? $city_region['name'] : '';
        $agents['city_mobile'] = (!empty($city_region)) ? $city_region['mobile'] : '';
        $agents['city_gai_number'] = (!empty($city_region)) ? $city_region['gai_number'] : '';
        $agents['city_username'] = (!empty($city_region)) ? $city_region['username'] : '';
        $sql = "select t.parent_id,t.member_id,t.name,m.gai_number,pm.username,pm.type_id,m.mobile from $tn t left join $member_table m on m.id=t.member_id left join $member_table pm on pm.id=m.pid and m.role = 2 where t.id=" . $city_region['parent_id'];
        $province_region = Yii::app()->db->createCommand($sql)->queryRow();
        $agents['province'] = (!empty($province_region)) ? $province_region['member_id'] : 0; //省代理
        $agents['province_type_id'] = (!empty($province_region)) ? $province_region['type_id'] : 0;
        $agents['province_name'] = (!empty($province_region)) ? $province_region['name'] : '';
        $agents['province_mobile'] = (!empty($province_region)) ? $province_region['mobile'] : '';
        $agents['province_gai_number'] = (!empty($province_region)) ? $province_region['gai_number'] : '';
        $agents['province_username'] = (!empty($province_region)) ? $province_region['username'] : '';
        return $agents;
    }

    /**
     * 代理分配规则
     */
    public static function getDistributeConfig()
    {
        $config = self::getConfig();
        $agentConfig = self::getAgentConfig();
        $agentArr = array(
            'province' => $agentConfig['province'],
            'city' => $agentConfig['city'],
            'district' => $agentConfig['district'],
        );
        $allArr = array(
            'onConsume' => $config['onConsume'],
            'onRef' => $config['onRef'],
            'onAgent' => $config['onAgent'],
            'onGai' => $config['onGai'],
            'onFlexible' => $config['onFlexible'],
            'onWeightAverage' => $config['onWeightAverage'],
            'gaiIncome' => $config['gaiIncome'],
            'offConsume' => $config['offConsume'],
            'offRef' => $config['offRef'],
            'offAgent' => $config['offAgent'],
            'offGai' => $config['offGai'],
            'offFlexible' => $config['offFlexible'],
            'offWeightAverage' => $config['offWeightAverage'],
            'offRefMachine' => $config['offRefMachine'],
            'offMachineIncome' => $config['offMachineIncome'],
        );
        $configJson = CJSON::encode(array(
            'allocation' => $allArr,
            'agentDist' => $agentArr,
        ));
        return $configJson;
    }
    /**
     * 获取对应盖机的分配比率
     * string $machineId
     * @return type
     */
    public static function getofflineDistributeConfig($machineId) {

        $gai = self::getConfig();
        $data = OfflineDistribution::model()->find('machine_id=:mid', array(':mid' => $machineId));
        if(empty($data)){     
            $configJson = self::getDistributeConfigNew();
        } else {
             $config = unserialize($data->distribution);
            $Arr = array(
                'gaiIncome' => $gai['gaiIncome'],
                'offManeuver' => $config['offManeuver'],
                'offConsumeNew' => $config['offConsumeNew'],
                'offRefNew' => $config['offRefNew'],
                'gateMachineRef' => $config['gateMachineRef'],
                'offMachineLine' => $config['offMachineLine'], //铺机者
                'offMachineOperation' => $config['offMachineOperation'], //运维人
                'offRegion' => $config['offRegion'],
                'offProvince' => $config['offProvince'],
                'offCity' => $config['offCity'],
                'offDistrict' => $config['offDistrict'],
            );
            $configJson = CJSON::encode(
                            $Arr
            );
        }
        return $configJson;
    }

    /**
     * 新分配规则
     */
    public static function getDistributeConfigNew() {
        $config = self::getConfig();
        $Arr = array(
            'gaiIncome' => $config['gaiIncome'], //盖网收益
            'offManeuver' => $config['offManeuver'], //机动
            'offConsumeNew' => $config['offConsumeNew'], //消费者
            'offRefNew' => $config['offRefNew'], //推荐者
            'gateMachineRef' => $config['gateMachineRef'], //盖机推荐者
            'offMachineLine' => $config['offMachineLine'], //铺机者
            'offMachineOperation' => $config['offMachineOperation'], //运维人
            'offRegion' => $config['offRegion'], //大区
            'offProvince' => $config['offProvince'], //省
            'offCity' => $config['offCity'], //市
            'offDistrict' => $config['offDistrict'], //区   
        );
        $configJson = CJSON::encode(
                        $Arr
        );
        return $configJson;
    }

    /**
     * 线下消费撤销
     * @author LC
     */
    public static function reback($record_id, $applyid_id) {
        self::$time = time();
        $franchiseeConsumptionRecordTable = FranchiseeConsumptionRecord::model()->tableName();
        $franchiseeTable = Franchisee::model()->tableName();
        $memberTable = Member::model()->tableName();
        $record = Yii::app()->db->createCommand()->select('a.id,a.serial_number,a.member_id,a.is_distributed,a.status,a.franchisee_id,am.gai_number,am.type_id,b.member_id as franchisee_member_id,bm.gai_number as franchisee_gai_number,a.spend_money,a.distribute_money,a.symbol,a.machine_id,b.name as franchisee_name,a.record_type')->from($franchiseeConsumptionRecordTable . ' a')
                ->leftJoin($franchiseeTable . ' b', 'a.franchisee_id=b.id')
                ->leftJoin($memberTable . ' am', 'am.id=a.member_id')
                ->leftJoin($memberTable . ' bm', 'bm.id=b.member_id')
                ->where('a.id=' . $record_id)
                ->queryRow();

        $flowTable = AccountFlow::monthTable(self::$time);
        $franchiseeConsumptionRecordRepealTable = FranchiseeConsumptionRecordRepeal::model()->tableName();

        $offlinePublicAcc = CommonAccount::getOfflineAccount();     //线上总账户	

        self::$member_type_rate = MemberType::fileCache();
        $official_rate = IntegralOfflineNew::$member_type_rate['official'];    //正式会员积分转化为金额的比例
        $default_rate = IntegralOfflineNew::$member_type_rate['default'];    //消费会员积分转化为金额的比例
        $default_type = IntegralOfflineNew::$member_type_rate['defaultType'];   //消费会员类型
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $machine = OfflineMachines::getMachineByType($record['machine_id'], $record['record_type'], array($record['record_type'] => array('province_id', 'city_id', 'district_id', 'address')));
            $record['area_id'] = Yii::app()->db->createCommand()->select('area')->from(Region::model()->tableName())->where('id=' . $machine['district_id'])->queryScalar();

            if ($record['symbol'] == 'HKD') {
                Yii::app()->language = 'zh_tw';
            } else {
                Yii::app()->language = 'zh_cn';
            }
            $sql = "select status from " . $franchiseeConsumptionRecordRepealTable . " where id = $applyid_id for update";
            $apply_status = Yii::app()->db->createCommand($sql)->queryScalar();
            if ($apply_status != FranchiseeConsumptionRecordRepeal::STATUS_AUDITI) {
                throw new ErrorException(Yii::t('franchiseeConsumptionRecord', '该记录状态改变，请刷新重新获取数据!'), '001');
            }

            $sql = "select id from " . FranchiseeConsumptionRecord::model()->tableName() . " where id = $record_id for update";
            Yii::app()->db->createCommand($sql)->queryRow();
            if ($record['is_distributed'] != FranchiseeConsumptionRecord::STATUS_NOTCHECK) {
                //状态不等于未对账
                throw new ErrorException(Yii::t('franchiseeConsumptionRecord', '该记录已对账，不能撤销!'), '002');
            }
            if ($record['status'] == FranchiseeConsumptionRecord::STATUS_NOTCHECK) {
                $member_money = $record['spend_money'];
                $member_integral = $member_money / $official_rate;
                $radio = $official_rate;
                if ($record['type_id'] == $default_type) {  //如果是消费会员那么增加的可兑现金额就会改变
                    $member_integral = $member_money / $default_rate;
                    $radio = $default_rate;
                }
                $member_money = IntegralOfflineNew::getNumberFormat($member_money);
                $member_integral = IntegralOfflineNew::getNumberFormat($member_integral);

                $content = self::getContent(self::CONSUMER_MEMBER_CONTENT_REBACK, array(
                            $record['gai_number'], $record['franchisee_name'], $machine['machine_name'], self::formatPrice($record['spend_money']), $member_integral
                                ), $record['record_type']);


                //总账号金额扣减
                $virtualBalance_money = $record['spend_money'];
                AccountBalance::calculate(array('today_amount' => -$virtualBalance_money), $offlinePublicAcc['id']);

                $accountFlowVirtual = array(
                    'credit_amount' => -$virtualBalance_money, //贷方发生额
                    'remark' => '线下订单撤销，金额减少' . $virtualBalance_money, //备注
                    'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_ORDER_CANCLE,
                    'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_CANCEL_CHECK,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_ORDER_CANCEL
                );
                $record = array_merge($record, $machine);
                IntegralOfflineNew::insertAccFlow($accountFlowVirtual, $record, $offlinePublicAcc, $flowTable);


                //给会员的消费账户返还钱
                $memberBalance = AccountBalance::findRecord(array('account_id' => $record['member_id'], 'type' => AccountBalance::TYPE_CONSUME, 'gai_number' => $record['gai_number']));
                AccountBalance::calculate(array('today_amount' => $record['spend_money']), $memberBalance['id']);
                $accountFlowMember = array(
                    'debit_amount' => -$record['spend_money'], //借方发生额
                    'remark' => $content, //备注
                    'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_ORDER_CANCLE,
                    'ratio' => $radio,
                    'node' => AccountFlow::BUSINESS_NODE_OFFLINE_ORDER_CANCEL,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_ORDER_CANCEL
                );
                IntegralOfflineNew::insertAccFlow($accountFlowMember, $record, $memberBalance, $flowTable);

                //--------------------------------------------------更新加盟商消费表中对账状态----------------------------------------------------
                Yii::app()->db->createCommand()->update($franchiseeConsumptionRecordTable, array('status' => FranchiseeConsumptionRecord::STATUS_REBACK, 'repeal_time' => self::$time), "id=" . $record_id);

                //--------------------------------------------------更新加盟商消费表中对账状态结束----------------------------------------------------
                //--------------------------------------------------更新加盟商申请撤销记录表中撤销状态----------------------------------------------------
                Yii::app()->db->createCommand()->update($franchiseeConsumptionRecordRepealTable, array(
                    'status' => FranchiseeConsumptionRecordRepeal::STATUS_PASS,
                    'agree_user_id' => Yii::app()->user->id,
                    'agree_time' => self::$time
                        ), 'id=' . $applyid_id);
                //--------------------------------------------------更新加盟商消费表中对账状态结束----------------------------------------------------
                if (!DebitCredit::checkFlowByCode($flowTable, $record['serial_number'])) {
                    throw new ErrorException('DebitCredit Error!', '010');
                }
                //写入操作记录
                @SystemLog::record(Yii::app()->user->name . "加盟商对账，批量撤销：{$record_id} 成功");
                $transaction->commit();
            } else {
                throw new ErrorException(Yii::t('franchiseeConsumptionRecord', '该记录已撤销，不能重复撤销!'), '003');
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            $content = $e->getMessage();
            $content = empty($content) ? Yii::t('franchiseeConsumptionRecord', '撤销失败，请重新撤销') . '!' : $content;
            return array(
                'result' => false,
                'content' => $content,
            );
        }
        return true;
    }

    /**
     * 给金额加上人民币符号
     * Enter description here ...
     * @author LC
     */
    public static function formatPrice($money, $symbol = 'RMB') {
        return Symbol::getMoneyTypeStr($symbol) . self::getNumberFormat($money);
    }

    /**
     * 抛出异常
     * @param string $error
     * @throws Exception
     */
    public static function throwErrorMessage($error) {
        throw new Exception(Yii::t("IntrgralOfflineNew", $error));
    }

    /**
     *
     * @param array $data
     * @param string $fail_reson
     */
    public static function saveAutoReconFailMemo($data, $fail_reson) {
        FranchiseeConsumptionRecord::model()->updateByPk($data['id'], array('auto_check_fail' => $fail_reson));
    }

    /**
     *  第三方平台确认支付接口
     * @param array $preOrder 预消费订单
     * @param int $node 节点
     * @param string $remark 注释
     * @throws Exception
     * @return boolean|Ambigous <boolean, unknown>
     */
    public static function paymentSubmitPay($preOrder, $node, $remark) {
        try {
            $db = Yii::app()->db;
            $gt = Yii::app()->gt;

            $orderTable = FranchiseeConsumptionRecord::tableName();
            $preOrderTable = FranchiseeConsumptionPreRecord::tableName();

            //加盟商对应的信息
            $member = Yii::app()->db->createCommand()
                    ->select('id,gai_number,status,type_id,mobile')
                    ->from('{{member}}')
                    ->where('id=:id', array(':id' => $preOrder['member_id']))
                    ->queryRow();
            //检查消费类型

            switch ($preOrder['record_type']) {
                case FranchiseeConsumptionRecord::RECORD_TYPE_PHONE:
                    // 检查掌柜
                    $shopkeeper = $gt->createCommand()
                                    ->select('id,name,is_activate,franchisee_id,status')->from('{{shopkeeper}}')
                                    ->where('id=:machine_id and status = ' . Shopkeeper::STATUS_ENABLE . ' and is_activate = ' . Shopkeeper::IS_ACTIVATE_YES, array(':machine_id' => $preOrder['machine_id']))->queryRow();
                    $payee['machine_id'] = $shopkeeper['id'];
                    $payee['machine_name'] = $shopkeeper['name'];
                    $payee['franchisee_id'] = $shopkeeper['franchisee_id'];
                    unset($shopkeeper);
                    break;
                case FranchiseeConsumptionRecord::RECORD_TYPE_POINT:
                    // 检查盖网通
                    $machine = $gt->createCommand()
                                    ->select('id,machine_code,name,biz_info_id,symbol,run_status,status')->from('{{machine}}')
                                    ->where('id=:machine_id and status = ' . Machine::STATUS_ENABLE . ' and run_status != ' . Machine::RUN_STATUS_UNINSTALL, array(':machine_id' => $preOrder['machine_id']))->queryRow();
                    $payee['machine_id'] = $machine['id'];
                    $payee['machine_name'] = $machine['name'];
                    $payee['franchisee_id'] = $machine['biz_info_id'];
                    $payee['code'] = $machine['machine_code'];
                    unset($machine);
                    break;
                case FranchiseeConsumptionRecord::RECORD_TYPE_VENDING:
                    $vending = Yii::app()->gt->createCommand()
                                    ->select('id,name,is_activate,franchisee_id,status')
                                    ->from(VendingMachine::tableName())
                                    ->where('id=:machine_id and status = ' . VendingMachine::STATUS_ENABLE . ' and is_activate = ' . VendingMachine::IS_ACTIVATE_YES, array(':machine_id' => $preOrder['machine_id']))->queryRow();
                    if (empty($vending))
                        throw new Exception('售货机不存在或者没启用');
                    $payee['machine_id'] = $vending['id'];
                    $payee['machine_name'] = $vending['name'];
                    $payee['franchisee_id'] = $vending['franchisee_id'];
                    unset($vending);
                    break;
                default:
                    throw new Exception('record_type有误');
            }

            //检查加盟商信息
            $franchisee = Yii::app()->db->createCommand()
                    ->select('id,member_id,name,member_discount,gai_discount,street,province_id,city_id,district_id')
                    ->from('{{franchisee}}')
                    ->where('id=:id', array(':id' => $payee['franchisee_id']))
                    ->queryRow();
            if (empty($franchisee))
                throw new Exception('商家不存在');

            //加盟商对应的信息
            $franchiseeMember = Yii::app()->db->createCommand()
                    ->select('id,gai_number,status')
                    ->from('{{member}}')
                    ->where('id=:id', array(':id' => $franchisee['member_id']))
                    ->queryRow();
            if (empty($franchiseeMember))
                throw new Exception('商家的账号不存在!');

            // 转换为人民币(100*0.75)
            $moneyRMB = bcmul($preOrder['amount'], bcdiv($preOrder['base_price'], 100, 5), 2);
            /*             * ****************************验证获取数据 end********************************* */

            /*             * ******************************充值*************************************** */
            $ratio = Yii::app()->db->createCommand()
                    ->select("ratio")
                    ->from("{{member_type}}")
                    ->where("id = {$member['type_id']}")
                    ->queryScalar();
            Recharge::payPlatformRecharge($preOrder['serial_number'], $member, $preOrder['amount'], $ratio, $node, $remark);
            /*             * *******************************充值完成********************************* */

            /*             * *******************************支付************************************ */
            //区分消费mo
            switch ($preOrder['record_type']) {
                case FranchiseeConsumptionRecord::RECORD_TYPE_POS:
                case FranchiseeConsumptionRecord::RECORD_TYPE_PHONE:
                case FranchiseeConsumptionRecord::RECORD_TYPE_POINT:
                    $orderData = array(
                        'moneyRMB' => $moneyRMB, //交易金额,不是原价
                        'money' => $preOrder['amount'],
                        'basePrice' => $preOrder['base_price'],
                        'symbol' => $preOrder['symbol'],
                        'machine_id' => $payee['machine_id'],
                        'machine_name' => $payee['machine_name'],
                        'record_type' => $preOrder['record_type'],
                        'machineSN' => $preOrder['machine_serial_number'], //
                        'entered_money' => $preOrder['entered_money'],
                        'serial_number' => $preOrder['serial_number'],
                        'accountFlowTable' => AccountFlow::monthTable(time()),
                        'pay_type' => FranchiseeConsumptionRecord::PAY_TYPE_UM
                    );
                    $machine = array(
                        'id' => $payee['machine_id'],
                        'name' => $payee['machine_name'],
                    );

                    $recordId = IntegralOfflineNew::offlineConsume($franchisee, $machine, $member, $orderData, $recordId = null);

                    if ($recordId != true) {
                        throw new Exception('支付失败!');
                        return false;
                    }

                    /*                     * *******************************支付end************************************ */
                    $sql = 'update ' . $preOrderTable . ' set is_pay = ' . FranchiseeConsumptionPreRecord::IS_PAY_YES . ' , status = ' . FranchiseeConsumptionPreRecord::STATUS_FINISH . ' , is_processed = ' . FranchiseeConsumptionPreRecord::IS_PROCESSED_YES . ' , processed_time = ' . time() . ' where id = ' . $preOrder['id'];
                    $db->createCommand($sql)->execute();
                    return $recordId;
                    break;
                case FranchiseeConsumptionRecord::RECORD_TYPE_VENDING:
                    $cache = Yii::app()->redis;
                    $key = FranchiseeConsumptionPreRecord::ForbidCacheName . '_' . $preOrder['machine_serial_number'];
                    if ($cache->get($key) == 1) {
                        $smsContent = '您好，您在' . $payee['machine_name'] . '售货机购买的商品失败，现在全额退还到您' . $member['gai_number'] . '的盖网的账号上，请留意查看账户。';
                        $datas = array($payee['machine_name'],$member['gai_number']);
                        $tmpId = Tool::getConfig('smsmodel','machinePayFailId');
                        SmsLog::addSmsLog($member['mobile'], $smsContent, $preOrder['id'], SmsLog::TYPE_VENDING_RETURN,null,true, $datas, $tmpId);
                        throw new Exception('支付失败,已经退还金钱到该账户上');
                    }
                    return IntegralOfflineNew::preConsume($preOrder['machine_serial_number'], $member, $preOrder['entered_money'], $payee['machine_id'], $preOrder['symbol'], array(), 'VM', $preOrder['serial_number']);
                    break;
                default:
                    throw new Exception('record_type有误');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            return false;
        }
    }

    /**
     * 预消费 （注意 $serial_number 传入表示是非积分支付）售货机
     * @param intval $orderId 订单号 SN号
     * @param array $memberId 消费者id
     * @param intval $enteredMoney 输入金额
     * @param intval $machineId 机器码
     * @param intval $goodsData 商品数据，id 商品主键，num，商品数量
     * @param string $symboy 币种 默认RMB(人民币)
     * @param string $prefix serial_number前缀
     * @param string $serial_number
     */
    public static function preConsume($orderId, $member, $enteredMoney, $machineId, $symbol = 'RMB', $goodsData = array(), $prefix = 'VM', $serial_number = '') {
        try {
            // 消费金额转换成人民币
            $base_price = 100;
            $amountData = Symbol::exchangeMoney($enteredMoney, $symbol, $base_price);
            $amount = $amountData['amount'];
            $base_price = $amountData['base_price'];
            self::$time = time();

            $flowHistoryTableName = AccountFlowHistory::monthTable(); //流水日志表名
            $accountFlowTable = AccountFlow::monthTable(self::$time);
            $db = Yii::app()->db;
            //判断是否已经有单，有就表示非积分支付
            if (!empty($serial_number)) {
                $is_insert = false;
            } else {
                $is_insert = true;
                $serial_number = $prefix . Tool::buildOrderNo();
            }
            //查旧账户余额
            $balanceOldRes = AccountBalanceHistory::getTodayAmountByGaiNumber($member['gai_number']);
            //开启事务
            $transaction = $db->beginTransaction();
            //查新余额表
            $balanceRes = AccountBalance::findRecord(array('account_id' => $member['id'], 'type' => AccountBalance::TYPE_CONSUME, 'gai_number' => $member['gai_number']));
            if (empty($balanceRes) || $balanceRes['today_amount'] < 0 || $balanceOldRes < 0) {
                throw new Exception(Yii::t('Machine', '账号异常'));
            }

            $balanceTotalMony = $balanceOldRes + $balanceRes['today_amount'];
            if ($amount > $balanceTotalMony) {
                throw new Exception(Yii::t('Machine', '积分不足'));
            }

            if ($balanceRes['today_amount'] >= $amount) {
                $oldBalanceMoney = 0;
            } elseif ($balanceRes['today_amount'] < $amount && $balanceRes['today_amount'] > 0) {
                $oldBalanceMoney = $amount - $balanceRes['today_amount'];   //旧账户需要扣的
            } elseif ($balanceRes['today_amount'] == 0) {
                $oldBalanceMoney = $amount;   //旧账户需要扣的
            }

            //旧账号充值到新账号
            if ($oldBalanceMoney) {
                $OldmemberBalance = AccountBalanceHistory::findRecord(array(
                            'account_id' => $member['id'],
                            'gai_number' => $member['gai_number'],
                            'type' => AccountFlow::TYPE_CONSUME,
                ));
                $oldBalanceRs = HistoryBalanceUse::process($accountFlowTable, $flowHistoryTableName, $balanceRes, $OldmemberBalance, $oldBalanceMoney, $serial_number, 0);
                if (!$oldBalanceRs)
                    self::throwErrorMessage('充值失败');
            }

            //重新查询账户 没有钱就返回错误
            $balanceRes = AccountBalance::findRecord(array('account_id' => $member['id'], 'type' => AccountBalance::TYPE_CONSUME, 'gai_number' => $member['gai_number']));
            if ($balanceRes['today_amount'] < $amount)
                self::throwErrorMessage('代购失败');

            //冻结金额
            if (!AccountFlow::freezingAccounts($accountFlowTable, $balanceRes, $amount, $serial_number, 0))
                self::throwErrorMessage('冻结失败');

            if (!DebitCredit::checkFlowByCode($accountFlowTable, $serial_number)) {
                throw new ErrorException('Code DebitCredit Error!', '010');
            }
            //判断是否有
            if ($is_insert) {
                $insertData = array();
                $insertData['serial_number'] = $serial_number;
                $insertData['machine_serial_number'] = $orderId;
                $insertData['member_id'] = $member['id'];
                $insertData['entered_money'] = $enteredMoney;
                $insertData['amount'] = $amount;
                $insertData['create_time'] = self::$time;
                $insertData['machine_id'] = $machineId;
                $insertData['symbol'] = $symbol;
                $insertData['base_price'] = $base_price;
                $insertData['record_type'] = FranchiseeConsumptionRecord::RECORD_TYPE_VENDING;
                $insertData['is_pay'] = FranchiseeConsumptionPreRecord::IS_PAY_YES;
                if ($db->createCommand()->insert(FranchiseeConsumptionPreRecord::tableName(), $insertData)) {
                    if (!empty($goodsData)) {
                        // 插入售货机订单商品表
                        $insertGoodsData = array();
                        $insertGoodsData['serial_number'] = $serial_number;
                        $insertGoodsData['vending_goods_id'] = $goodsData['id'];
                        $insertGoodsData['pay_num'] = $goodsData['num'];
                        $insertGoodsData['price'] = $goodsData['price'];
                        $db->createCommand()->insert(FranchiseeConsumptionRecordGoods::tableName(), $insertGoodsData);
                    }
                }
            } else {
                $sql = 'update ' . FranchiseeConsumptionPreRecord::tableName() . ' set  is_pay = ' . FranchiseeConsumptionPreRecord::IS_PAY_YES . ' where serial_number = "' . $serial_number . '"';
                $db->createCommand($sql)->execute();
            }
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            if (isset($transaction))
                $transaction->rollBack();
            throw new ErrorException($e->getMessage());
            return false;
        }
    }

}
