<?php

/**
 * 获取活动数据
 * @author qinghao.ye <qinghao.ye@g-emall.com>
 */
class ActivityData
{

//    const EXPIRE_TIME = 36000;
    const EXPIRE_TIME = 1800;//正式环境缓存半小时
    const EXPIRE_TIME_ORDER_CACHE = 86400;//缓存一天
    const CACHE_ACTIVITY_CONFIG = 'ActivityConfig';//所有活动的缓存
    const CACHE_ACTIVITY_CONFIG_GOODS_RELATION_MAP = 'ActivityConfigGoodsRelationMap';//商品的活动关系
    const CACHE_ACTIVITY_CONFIG_GOODS_RELATION_INFO = 'ActivityConfigGoodsRelationInfo';//商品的活动关系详情
    const CACHE_ACTIVITY_EXPIRE_CONFIG = 'ActivityExpire';//已过期的活动缓存
    const CACHE_ACTIVITY_GRAB = 'ActivityGrab';//今日必抢缓存
    const CACHE_ACTIVITY_PRODUCT_CATEGORY = 'ActivityProductCategory';//商品一级类别的缓存
    const CACHE_ACTIVITY_PRODUCT_ALL = 'ActivityProductAll';//参加活动的所有商品的缓存
    const CACHE_ACTIVITY_SECKILL_PRODUCT_ALL = 'ActivitySeckillProductAll';
    const CACHE_SECKILL_STOCK = 'seckill_stock';
    const CACHE_SECKILL_GOODS_INFO = 'seckill_goods_info';
    const CACHE_ACTIVITY_ORDER = 'ActivityOrder';
    const CACHE_ACTIVITY_GOODS = 'ActivityGoods';
    const CACHE_FESTIVE_DETAIL_BANNER = 'FestiveDetailBanner';//常规活动页面主图及标题底图缓存缓存名称
    const CACHE_FESTIVE_DETAIL_ALL_GOODS = 'FestiveDetailAllGoods';//常规活动页面某个常规活动的所有商品缓存名称
    const CACHE_FESTIVE_ACTIVITY_NOBEGIN = 'FestiveActivityNoBegin';//常规活动页面即将开始的常规活动数据缓存名称
    const CACHE_FESTIVE_ACTIVITY_GOING = 'FestiveActivityGoing';//常规活动页面获取正在进行的常规活动数据缓存名称
    const CACHE_FESTIVE_ACTIVITY_OVER_ALL = 'FestiveActivityOverAll';//常规活动页面获取已结束的常规活动数据缓存名称
    const CACHE_SECKILL_NAME = 'GoodsName';         //商品名称
    const ACTIVE_RED = 1;//红包活动
	const ACTIVE_FESTIVE = 2;//应节活动
	const ACTIVE_SECKILL = 3;//秒杀活动
    const ACTIVE_AUCTION = 4;//拍卖活动
    const CATEGORY_NAME = 'seckillgoodscategory';//活动商品类别配置,记录于web_config表

    /**
     * 获取产品的一级分类[前端使用]
     * 14和889这两个分类暂时不要
     * @return array
     */
    public static function getProductCategory(){
        $data   = array();
        $config = Tool::cache(self::CACHE_ACTIVITY_PRODUCT_CATEGORY)->get(self::CACHE_ACTIVITY_PRODUCT_CATEGORY);
        if ($config == false) {

            $result = Yii::app()->db->createCommand()->select('name,value')->from('{{web_config}}')->where('name=:name', array(':name'=>self::CATEGORY_NAME))->queryRow();
            if( empty($result) ){
                $data = self::getDefaultActiveCategory();
            }else{
                $data = unserialize($result['value']);
            }

            if (!empty($data)) {
                foreach ($data as $val) {
                    $config[] = $val;
                }
                unset($data);
                Tool::cache(self::CACHE_ACTIVITY_PRODUCT_CATEGORY)->set(self::CACHE_ACTIVITY_PRODUCT_CATEGORY, serialize($config), self::EXPIRE_TIME);
            }
        } else {
            $config = unserialize($config);
        }
        return $config;
    }

    /**
     * 获取活动默认产品的一级分类(相当于默认配置)
     */
    public static function getDefaultActiveCategory(){
        return array(
            array('id'=>1, 'name'=>'家用电器'),
            array('id'=>2, 'name'=>'服饰鞋帽'),
            array('id'=>3, 'name'=>'个护化妆'),
            array('id'=>4, 'name'=>'手机数码'),
            array('id'=>5, 'name'=>'电脑办公'),
            array('id'=>6, 'name'=>'运动健康'),
            array('id'=>7, 'name'=>'家居家装'),
            array('id'=>8, 'name'=>'饮料食品'),
            array('id'=>9, 'name'=>'礼品箱包'),
            array('id'=>10, 'name'=>'珠宝首饰'),
            array('id'=>11, 'name'=>'汽车用品'),
            array('id'=>12, 'name'=>'母婴用品')
        );
    }

    /**
     * 获取已结束的活动[前端使用]
     *
     * @return array
     */
    public static function getActivityRulesExpire()
    {
        $config = Tool::cache(self::CACHE_ACTIVITY_EXPIRE_CONFIG)->get(self::CACHE_ACTIVITY_EXPIRE_CONFIG);
        if ($config == false) {
            $result = Yii::app()->db->createCommand()
                ->select('rm.category_id,rm.name,rm.date_start,rm.date_end,rm.banner1,rm.banner2,rm.banner3,rm.banner4,rs.*')//rm.*,rs.start_time,rs.end_time,rs.picture,rs.remark,rs.status,rs.id
                ->from('{{seckill_rules_main}} rm')
                ->join('{{seckill_rules_seting}} rs', 'rm.id=rs.rules_id')
                ->where('rs.status=4 AND rm.category_id!=3')
                ->order('rm.date_end DESC')
                ->limit(10)
                ->queryAll();

            if (!empty($result)) {
                foreach ($result as $val) {
                    $val['start_dateline'] = $val['date_start'] . ' ' . $val['start_time'];
                    $val['end_dateline'] = $val['date_end'] . ' ' . $val['end_time'];
                    $config[$val['id']] = $val;
                }
                unset($result);
                Tool::cache(self::CACHE_ACTIVITY_EXPIRE_CONFIG)->set(self::CACHE_ACTIVITY_EXPIRE_CONFIG, serialize($config), self::EXPIRE_TIME);
            }
        } else {
            $config = unserialize($config);
        }
        return $config;
    }

    /**
     * 获取开启活动的详细配置[前端使用]
     * @param null $settingId
     * @return bool|mixed
     * array(key=>value)
     * category_id,category_name,activity_id,
     * activity_name,date_start,date_end,setting_id,
     * setting.*
     *
     */
    public static function getActivityRulesSeting($settingId = null)
    {
        //Tool::cache(self::CACHE_ACTIVITY_CONFIG)->delete($name);

        $config = Tool::cache(self::CACHE_ACTIVITY_CONFIG)->get(self::CACHE_ACTIVITY_CONFIG);
        if ($config == false) {
            $result = Yii::app()->db->createCommand()
                ->select('rm.category_id,rm.name,rm.date_start,rm.date_end,rm.banner1,rm.banner2,rm.banner3,rm.banner4,rs.*')
                ->from('{{seckill_rules_main}} rm')
                ->join('{{seckill_rules_seting}} rs', 'rm.id=rs.rules_id')
                ->where('rs.status IN (:notOn,:on)', array(':notOn' => SeckillRulesSeting::NO_BIGING, ':on' => SeckillRulesSeting::BEGINING))
                ->order('rs.sort ASC')
                ->queryAll();

            if (!empty($result)) {
                foreach ($result as $val) {
                    $val['start_dateline'] = $val['date_start'] . ' ' . $val['start_time'];
                    $val['end_dateline'] = $val['date_end'] . ' ' . $val['end_time'];
                    $config[$val['id']] = $val;
                }
                unset($result);
                Tool::cache(self::CACHE_ACTIVITY_CONFIG)->set(self::CACHE_ACTIVITY_CONFIG, serialize($config), self::EXPIRE_TIME);
            }
        } else {
            $config = unserialize($config);
        }
        return $settingId == null ? $config : (isset($config[$settingId]) ? $config[$settingId] : false);
    }


    /**
     * 获取商品与配置的对应关系[前端使用]
     * @param $productId
     * @return array|mixed
     * array(0=>'setting_id',...)
     */
    public static function getActivityProductRelation($productId)
    {
        //Tool::cache(self::CACHE_ACTIVITY_CONFIG_GOODS_RELATION_MAP)->delete($productId);

        $config = Tool::cache(self::CACHE_ACTIVITY_CONFIG_GOODS_RELATION_MAP)->get($productId);
        if ($config == false || $config === true) {
            $result = Yii::app()->db->createCommand()
                ->select('rules_seting_id')
                ->from('{{seckill_product_relation}} r')
                ->join('{{seckill_rules_seting}} s', 's.id=r.rules_seting_id')
                ->where('r.product_id=:pid and r.status=:status', array(':pid' => $productId, ':status' => 1))
                ->order('s.start_time,end_time asc')
                ->queryColumn();
            if (!empty($result)) {
                $config = $result;
                Tool::cache(self::CACHE_ACTIVITY_CONFIG_GOODS_RELATION_MAP)->set($productId, serialize($config), self::EXPIRE_TIME);
            }
        } else {
            $config = unserialize($config);
        }
        return $config;
    }

    /**
     * 获取商品活动关系表详情
     * @param $settingId
     * @param $goodsId
     * @return mixed
     */
    public static function getRelationInfo($settingId, $goodsId)
    {
        $name = $settingId . '_' . $goodsId;
//        Tool::cache(self::CACHE_ACTIVITY_CONFIG_GOODS_RELATION_INFO)->delete($name);

        $config = Tool::cache(self::CACHE_ACTIVITY_CONFIG_GOODS_RELATION_INFO)->get($name);
        if ($config == false) {
            $result = Yii::app()->db->createCommand()
                ->from('{{seckill_product_relation}}')
                ->where('rules_seting_id=:sid and product_id=:pid', array(':sid' => $settingId, ':pid' => $goodsId))
                ->queryRow();
            if (!empty($result)) {
                $config = $result;
                Tool::cache(self::CACHE_ACTIVITY_CONFIG_GOODS_RELATION_INFO)->set($name, serialize($config), self::EXPIRE_TIME);
            }
        } else {
            $config = unserialize($config);
        }
        return $config;
    }

    /**
     * 获取活动时间信息,不能用于判断活动状态
     * @param $setting
     * @param bool $perDay false:以整个活动日期为参照,true:已每天时间和setting做参照
     * @return bool|int 小于0:距离开始时间秒数;大于0:距离结束时间秒数;false:已经结束
     *
     */
    public static function getActiveTime($setting, $perDay = false)
    {
        $time = time();
        $date_start = strtotime(date('Y-m-d') . ' ' . $setting['start_time']);
        $end_time = strtotime(date('Y-m-d') . ' ' . $setting['end_time']);
        $activity_start_time = strtotime($setting['start_dateline']);
        $activity_end_time = strtotime($setting['end_dateline']);
        // 未开始
        if ($time < $activity_start_time) {
            return -(int)($activity_start_time - $time);
        }
        if ($perDay == false) {
            if ($time <= $activity_end_time) {
                return (int)($activity_end_time - $time);
            }
            return false;//已结束
        } // 当天未开始
        elseif ($time < $date_start) {
            return -(int)($date_start - $time);
        } // 当天未结束
        elseif ($time < $end_time) {
            return (int)($end_time - $time);
        } // 未结束
        elseif ($time < $activity_end_time) {
            $tomorrow_start_time = strtotime(date('Y-m-d', time() + 24 * 3600) . ' ' . $setting['start_time']);
            $tomorrow_end_time = strtotime(date('Y-m-d', time() + 24 * 3600) . ' ' . $setting['end_time']);
            // 明天开始
            if ($tomorrow_end_time <= $activity_end_time) {
                return -(int)($tomorrow_start_time - $time);
            }
        }
        return false;//已结束
    }

    /**
     * 时间距离分解
     * @param $time
     * @return array
     */
    public static function dateCount($time)
    {
        $oneHour = 3600;
        $oneDay = 24 * $oneHour;
        $days = floor($time / $oneDay);
        $hours = floor(($time - ($days * $oneDay)) / ($oneHour));
        $minutes = floor(($time - ($days * $oneDay) - ($hours * $oneHour)) / 60);
        $seconds = floor(($time - ($days * $oneDay) - ($hours * $oneHour) - ($minutes * 60)));
        $tips = "{$days}天{$hours}小时{$minutes}分{$seconds}秒 ";
        return compact('days', 'hours', 'minutes', 'seconds', 'tips');

    }

    /**
     * 在活动日期内
     * @param $setting
     * @return bool
     */
    public static function inDate($setting)
    {
        $date = strtotime(date('Y-m-d', time()));
        $date_start = strtotime($setting['date_start']);
        $date_end = strtotime($setting['date_end']);
        if ($date >= $date_start && $date <= $date_end) {
            return true;
        }
        return false;
    }

    /**
     * 在活动时间内
     * @param $setting
     * @return bool
     */
    public static function inHour($setting)
    {
        $time = date('His', time());
        $start_time = str_replace(':', '', $setting['start_time']);
        $end_time = str_replace(':', '', $setting['end_time']);
        if ($time >= $start_time && $time <= $end_time) {
            return true;
        }
        return false;
    }

    /**
     * 购买数量在允许值内
     * @param $quantity
     * @param $setting
     * @return bool
     */
    public static function quantityAllowBuy($quantity, $setting)
    {
        if (is_int($quantity) && $quantity > 1 && $quantity <= $setting['buy_limit']) {
            return true;
        }
        return false;
    }

    /**
     * 获取规则的状态
     * @param $setting
     * @return string
     * return none:没有开启;start:已开启,未开始;running:开始中;stop:已停止;
     */
    public static function getStatus($setting)
    {
        if ($setting['status'] == SeckillRulesSeting::TIME_OVER) {
            return 'stop';
        }
        $time = time();
        if ($setting['status'] != SeckillRulesSeting::NO_BIGING || $setting['status'] != SeckillRulesSeting::BEGINING) {
            $activity_start_time = strtotime($setting['start_dateline']);
            $activity_end_time = strtotime($setting['end_dateline']);
            if ($time < $activity_start_time) {
                return 'start';
            } elseif ($time >= $activity_start_time && $time <= $activity_end_time) {
                if ($setting['category_id'] == 3) {//秒杀
                    $today_creat_time = strtotime(date('Y-m-d') . ' ' . $setting['start_time']);
                    $today_end_time = strtotime(date('Y-m-d') . ' ' . $setting['end_time']);
                    if ($time < $today_creat_time || $time > $today_end_time) {//当天未开始，或当天已结束
                        return 'start';
                    }
                }
                return 'running';
            }
            return 'stop';
        }
        return 'none';
    }

    /**
     *
     * @param $goodsId
     * @param $setting_id
	 * @param $type
     * @return bool|string
     */
    public static function getGoodsInfo($goodsId, $setting_id, $type = 0)
    {
        // 获取商品对应的配置
        $settingIds = self::getActivityProductRelation($goodsId);
        if ($settingIds == false || !in_array($setting_id, $settingIds)) {
            return false;
        }
        // 获取配置详情
        $setting = self::getActivityRulesSeting($setting_id);
        if ($setting == false) {
            return false;
        }
        $status = ActivityData::getStatus($setting);
        if ($status == 'none' || $status == 'stop') {
            return false;
        }

        $title = $setting['name'];
        $timeTips = '';
        $buttonName = '';
        $relationInfo = array();

        if ($status == 'start') {
            $timeTips = '商品即将参加'.($type ? $title : '活动').'，<span>{t}</span>后开始';
            $buttonName = '敬请留意';
        } elseif ($status == 'running') {
            $timeTips = '此商品正在参加'.($type ? $title : '活动').'，<span>{t}</span>后结束，请尽快购买！';
            $buttonName = '加入购物车';
        }

        if ($timeTips) {
            $perDay = $setting['category_id'] == 3 ? true : false;
            $time = ActivityData::dateCount(abs(self::getActiveTime($setting,$perDay)));
            $timeTips = str_replace('{t}', $time['tips'], $timeTips);
            $relationInfo = ActivityData::getRelationInfo($setting['id'], $goodsId);
        }

        return compact('status', 'title', 'timeTips', 'time', 'setting', 'relationInfo', 'buttonName');
    }

    /**
     * 验证入队的购买信息
     * @param array $buy
     * @param bool $setting
     * @param bool $flush
     * @throws CHttpException
     * @return bool
     */
    public static function checkBuyInfo(array $buy, $setting = false, $flush = false)
    {
        if ($setting == false) {
            throw new CHttpException(404, Yii::t('seckill', '抱歉,活动已结束！'));
        }
        $status = ActivityData::getStatus($setting);
        if ($status == 'start') {
            throw new CHttpException(404, Yii::t('seckill', '抱歉,活动还没开始！'));
        } elseif ($status == 'running') {
            //如果规则那里设置为0代表是不限制购买数量
            if($setting['buy_limit'] > 0){
                if ($setting['buy_limit'] < $buy['quantity']) {
                    throw new CHttpException(404,
                        Yii::t('seckill', '抱歉,此商品每人只能限购{limit}件！', array('{limit}' => $setting['buy_limit'])));
                }
            }
            //初始化检查,会员购买数量
            SeckillRedis::checkBuy($setting,$flush);
        } else {
            throw new CHttpException(404, Yii::t('seckill', '抱歉,活动已结束！'));
        }
        //查询库存信息,检查库存是否够扣.
        $stock = ActivityData::getActivityGoodsStock($buy['goods_id'], $buy['goods_spec_id']);
        if ($stock < $buy['quantity']) {
            throw new CHttpException(404, Yii::t('seckill', '抱歉,商品库存不足或者已售完！'));
        }
        return true;
    }

    /**
     * 获取今日必抢轮播数据
     * @return array 返回数组
     */
    public static function getGrabPlaying()
    {
        $config = Tool::cache(self::CACHE_ACTIVITY_GRAB)->get(self::CACHE_ACTIVITY_GRAB);
		$time   = time();
        $date   = date('Y-m-d H:i:s');

        if ($config == false) {
            //获取轮播内容
            $sql = "SELECT g.*,r.status FROM {{seckill_grab}} g LEFT JOIN {{seckill_product_relation}} r ON r.product_id=g.product_id WHERE 1";
            $command = Yii::app()->db->createCommand($sql);
            $grab = $command->queryAll();

            //获取轮播内容
            $sql = "SELECT * FROM {{seckill_playing}} WHERE 1";
            $play = Yii::app()->db->createCommand($sql)->queryRow();

			//处理时间
			$oldTime   = strtotime($play['dateline']);
			$nowNumber = $play['now_number'];
			$dateline  = $play['dateline'];
			if( $time > ($oldTime + 86400) && !empty($grab)){//已经超过一天时间,重新处理必抢的开始时间
				$day = floor(($time - $oldTime)/86400);

				$nowNumber = $play['now_number']+$day;
				$dateline  = date('Y-m-d', $time-86400).' '.substr($play['dateline'], 11);

				if( ($time - $dateline) > 86400){//如果将计时设为前一天,还是超过了86400,则再处理为当天的时间
					$dateline  = date('Y-m-d').' '.substr($play['dateline'], 11);
				}


				//更新轮播表
				$nowNumber = ($nowNumber > $play['total_number']) ? 1 : $nowNumber;
                $sql = "UPDATE {{seckill_playing}} SET `now_number`='$nowNumber',`dateline`='$dateline' WHERE 1";
                Yii::app()->db->createCommand($sql)->execute();
			}

            $config = array(0 => array('totalNumber' => $play['total_number'], 'nowNumber' => $nowNumber, 'dateline' => $dateline));

            if (!empty($grab)) {
                foreach ($grab as $v) {
                    $config[$v['sort']] = array('product_id' => $v['product_id'], 'product_name' => $v['product_name'], 'seller_name' => $v['seller_name'], 'product_stock' => $v['product_stock'], 'product_price' => $v['product_price'], 'market_price' => $v['market_price'], 'thumbnail' => $v['thumbnail'], 'rules_id' => $v['rules_id'], 'rules_name' => $v['rules_name'],'status'=>$v['status']);
                }
                Tool::cache(self::CACHE_ACTIVITY_GRAB)->set(self::CACHE_ACTIVITY_GRAB, serialize($config), 86400);
            }

        } else {//更新表
            $config = unserialize($config);

            //处理日期
            $expire = strtotime($config[0]['dateline']) + 86400;
            if (intval($expire) < intval($time)) {//轮播已过期,需要更新时间
                $nowNumber = $config[0]['nowNumber'] + 1;

                $nowNumber = ($nowNumber > $config[0]['totalNumber']) ? 1 : $config[0]['totalNumber'];
                $config[0] = array('totalNumber' => $config[0]['totalNumber'], 'nowNumber' => $nowNumber, 'dateline' => $date);

                //更新轮播表
                $sql = "UPDATE {{seckill_playing}} SET `now_number`='$nowNumber',`dateline`='$date' WHERE 1";
                Yii::app()->db->createCommand($sql)->execute();

                Tool::cache(self::CACHE_ACTIVITY_GRAB)->set(self::CACHE_ACTIVITY_GRAB, serialize($config), 86400);//已过期,要更新缓存
            }
        }
        return $config;
    }

    /**
     * 获取所有参加活动的商品
     * @param interger $page 当前页数
     * @param interger $catid 栏目id
     * @param interger $pageSize 分页个数
     * @return array
     */
    public static function getActivityProductAll($page=1,$catid=0,$pageSize=30)
    {
        $search = Yii::app()->request->getParam('search');
        $new_version = Tool::cache(ActivityData::CACHE_ACTIVITY_PRODUCT_ALL)->get(ActivityData::CACHE_ACTIVITY_PRODUCT_ALL."_new_version");
        if(!$new_version) $new_version = 1;
        $config = Tool::cache(self::CACHE_ACTIVITY_PRODUCT_ALL)->get(self::CACHE_ACTIVITY_PRODUCT_ALL."_{$page}_{$catid}_{$pageSize}_{$search}_{$new_version}");

        if ($config == false) {//读取相关内容
            //过滤用于app端的季节性活动
            $whereActive = "m.category_id = 2 and s.sort >= 50 and s.sort <> 99999";
                
            $dataActive = Yii::app()->db->createCommand()->select("s.id as setid")
            ->from("{{seckill_rules_main}} as m")
            ->leftjoin("{{seckill_rules_seting}} as s","m.id = s.rules_id" )
            ->where($whereActive)
            ->QueryColumn();
            //过滤用于app端的季节性活动



            $limit = $pageSize*($page-1);
            $sql = "SELECT pr.rules_seting_id,pr.product_category,pr.product_id,g.name AS product_name,g.thumbnail,g.stock,g.market_price,g.price
                    FROM {{seckill_product_relation}} pr LEFT JOIN {{seckill_rules_seting}} rs ON pr.rules_seting_id=rs.id LEFT JOIN {{goods}} g ON pr.product_id=g.id
                    WHERE pr.status=1 AND rs.status IN (2,3) AND g.is_publish=1 AND g.status=1 ";
            if($catid) $sql .= " AND pr.product_category = {$catid}";  // 增加栏目搜索
            if(!empty($search)) $sql .= " AND pr.product_name LIKE '%{$search}%'";
            //过滤用于app端的季节性活动
            if(!empty($dataActive)) $sql .= " AND pr.rules_seting_id not in (".implode($dataActive, ',').")";
            $sql .= " ORDER BY pr.examine_time ASC LIMIT $limit,$pageSize";
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();

            //总数
            $sql = "SELECT count(pr.id) as count FROM {{seckill_product_relation}} pr LEFT JOIN {{seckill_rules_seting}} rs ON pr.rules_seting_id=rs.id LEFT JOIN {{goods}} g ON pr.product_id=g.id
                    WHERE pr.status=1 AND rs.status IN (2,3) AND g.is_publish=1 AND g.status=1 ";
            if($catid) $sql .= " AND pr.product_category = {$catid}";
            if(!empty($search)) $sql .= " AND pr.product_name LIKE '%{$search}%'";
            //过滤用于app端的季节性活动
            if(!empty($dataActive)) $sql .= " AND pr.rules_seting_id not in (".implode($dataActive, ',').")";
            $count = Yii::app()->db->createCommand($sql)->queryRow();
            if($count){
                $countItem = $count['count'];
                $config['page'] = array('count'=>$countItem,'currentPage'=>$page,'pageSize'=>$pageSize);
            }
//            $count =
            //取活动的类型
            $date = date('Y-m-d');
            $cats = array();
            $sql = "SELECT rm.category_id,rs.id FROM {{seckill_rules_main}} rm,{{seckill_rules_seting}} rs WHERE rm.id=rs.rules_id AND rs.status IN (2,3)";
            //过滤用于app端的季节性活动
            if(!empty($dataActive)) $sql .= " AND rs.id not in (".implode($dataActive, ',').")";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            if ($rows) {
                foreach ($rows as $v) {
                    $cats[$v['id']] = $v['category_id'];
                }
            }
            if ($result) {
                foreach ($result as $v) {
                    if (isset($cats[$v['rules_seting_id']]) && $cats[$v['rules_seting_id']] == 3) continue;
                    $config['product'][] = $v;
                }
                unset($result);
                Tool::cache(self::CACHE_ACTIVITY_PRODUCT_ALL)->set(self::CACHE_ACTIVITY_PRODUCT_ALL."_{$page}_{$catid}_{$pageSize}_{$search}_{$new_version}", serialize($config), self::EXPIRE_TIME);
            }

        } else {
            $config = unserialize($config);
        }

        return $config;
    }

    /**
     * 获取秒杀活动商品
     * @return array
     */
    public static function getActivityGoodsList()
    {
        $name = 'SeckillGoodsList';
        $config = Tool::cache(self::CACHE_ACTIVITY_SECKILL_PRODUCT_ALL)->get(self::CACHE_ACTIVITY_SECKILL_PRODUCT_ALL);
        if ($config == false) {
            $sql = "select relation.examine_time,relation.rules_seting_id,relation.product_name,relation.seller_name,relation.examine_time,goods.id,goods.thumbnail,goods.price,seting.start_time,seting.end_time,seting.discount_price,seting.picture,seting.picture,seting.discount_rate,date_format(main.date_start,'%Y/%m/%d') as date_starts,date_format(main.date_end,'%Y/%m/%d') as date_ends
        FROM {{seckill_product_relation}} as relation
        LEFT JOIN {{goods}} as goods ON goods.id=relation.product_id
        LEFT JOIN {{seckill_rules_seting}} as seting ON seting.id=relation.rules_seting_id
        LEFT JOIN {{seckill_rules_main}} as main ON main.id=seting.rules_id
        WHERE relation.category_id in (3) and relation.status=1 and goods.status=1 and seting.status in(2,3) AND CONCAT(main.date_end,' ',seting.end_time) >= NOW()
        group by goods.id ORDER BY main.date_start ASC,goods.stock DESC,relation.examine_time ASC ";
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            $config = $result;
            Tool::cache(self::CACHE_ACTIVITY_SECKILL_PRODUCT_ALL)->set(self::CACHE_ACTIVITY_SECKILL_PRODUCT_ALL, serialize($result), self::EXPIRE_TIME);

        } else {
            $config = unserialize($config);
        }
        return $config;
    }

    /**
     * 获取商品库存
     * @param $goods_id
     * @param $spec_id
     * @param bool $flush
     * @return int
     */
    public static function getActivityGoodsStock($goods_id, $spec_id = 0, $flush = false)
    {
        if ($flush) {
            self::deleteActivityGoodsStock($goods_id);
        }
        $stock = unserialize(Tool::cache(self::CACHE_SECKILL_STOCK)->get($goods_id));
        if ($stock === false) {
            $result = Yii::app()->db->createCommand()
                ->select('id,stock')
                ->from('{{goods_spec}}')
                ->where('goods_id=:gid', array(':gid' => $goods_id))
                ->queryAll();
            if (!empty($result)) {
                $stock['goods'] = 0;
                foreach ($result as $val) {
                    $stock['spec'][$val['id']] = $val['stock'];
                    $stock['goods'] += $val['stock'];
                }
            }
            Tool::cache(self::CACHE_SECKILL_STOCK)->set($goods_id, serialize($stock),60);
        }
        return $spec_id ? (isset($stock['spec'][$spec_id]) && $stock['spec'][$spec_id] ? $stock['spec'][$spec_id] : 0) : $stock['goods'];
    }

    /**
     * 获取商品名称
     * @param $goods_id
     * @return mixed
     */
    public static function getActivityGoodsName($goods_id)
    {
        $name = unserialize(Tool::cache(self::CACHE_SECKILL_NAME)->get($goods_id));
        if ($name === false) {
            $result = Yii::app()->db->createCommand()
                ->select('id,name')
                ->from('{{goods}}')
                ->where('id=:gid', array(':gid' => $goods_id))
                ->queryRow();
            $name = $result['name'];
            Tool::cache(self::CACHE_SECKILL_NAME)->set($goods_id, serialize($result['name']),self::EXPIRE_TIME);
        }
        return $name ;
    }


    /**
     * 删除库存缓存
     * @param $goods_id
     */
    public static function deleteActivityGoodsStock($goods_id)
    {
        Tool::cache(self::CACHE_SECKILL_STOCK)->delete($goods_id);
    }

    /**
     * 获取活动价格
     * @param $settingId 活动规则设置id
     * @param int $price 零售价
     * @return int|string
     * @author binbin.liao
     */
    public static function getActivityPrice($settingId, $price = 0)
    {
        $setting = self::getActivityRulesSeting($settingId);
        $discount_rate = $setting['discount_rate'];//活动折扣
        $discount_price = $setting['discount_price']; //活动限定价格
        if(!empty($discount_rate) && $discount_rate > 0){
            /*$discount_rate = bcdiv($discount_rate, 100);
            if($setting['category_id'] == 1){
                $discount_rate = 1 - $discount_rate;
            }*/
			if($setting['category_id'] == 1){//红包活动 显示原价
				$newPrice = $price;
			}else{
				$newPrice = number_format($price*$discount_rate/100, 2, '.', '');
			}

        }elseif(!empty($discount_price) && $discount_price>=0){
            $newPrice = $discount_price;
        }else{
            $newPrice = 0;
        }
        return $newPrice;
    }

    /**
     * 下单后生产缓存
     * @param $memberId
     * @param $goodsId
     * @param $quantity
     * @param $settingId
     * @param int $expire
     * @return int
     */
    public static function addOrder(array $arr, $expire = self::EXPIRE_TIME_ORDER_CACHE)
    {
        $memberId = $arr['user_id'];
        $goodsId = $arr['goods_id'];
        $quantity = $arr['quantity'];
        $settingId = $arr['setting_id'];
        // key
        $name = $memberId . '-' . $goodsId;
        // 查出现有数量
        $whereStr = 'user_id=:mid and goods_id=:gid';
        $whereParam = array(':mid' => $memberId, ':gid' => $goodsId);
        $quantityFound = Yii::app()->db->createCommand()
            ->select('quantity')->from('{{seckill_order_cache}}')
            ->where($whereStr, $whereParam)
            ->queryScalar();
        if ($quantityFound) {

            if ($arr['is_process'] == SeckillRedis::IS_PROCESS_IN) {
                $data = array(
                    'quantity' => ($quantity + $quantityFound),
                    'is_process' => $arr['is_process'],
                    'create_time' => $arr['create_time'],
                    'order_code' => 0
                );
                Yii::app()->db->createCommand()->update('{{seckill_order_cache}}', $data, $whereStr, $whereParam);
            }else{
                Yii::app()->db->createCommand()->update('{{seckill_order_cache}}', array('order_code'=>$arr['order_code'],'is_process'=>$arr['is_process']), $whereStr, $whereParam);
            }
        } else {

            Yii::app()->db->createCommand()->insert('{{seckill_order_cache}}', $arr);
        }
        // 更新缓存
        Tool::cache(self::CACHE_ACTIVITY_ORDER)->delete($name);
    }


    /**
     * 获取已下单缓存
     * @param $memberId 会员id
     * @param $goodsId 商品id
     * @param int|\秒杀活动规则id $settingId 秒杀活动规则id
     * @param bool $flush
     * @return string
     * @author binbin.liao
     */
    public static function getOrderCache($memberId, $goodsId, $settingId = 0,$flush = false)
    {
        $name = $memberId . '-' . $goodsId;
        $data = unserialize(Tool::cache(self::CACHE_ACTIVITY_ORDER)->get($name));
        if ($data === false || $flush) {
            $data = Yii::app()->db->createCommand()
                ->from('{{seckill_order_cache}}')
//                ->where('user_id=:mid AND goods_id=:gid AND setting_id=:sid', array(':mid' => $memberId, ':gid' => $goodsId, ':sid' => $settingId))
                ->where('user_id=:mid AND goods_id=:gid', array(':mid' => $memberId, ':gid' => $goodsId))
                ->queryRow();
            if(!empty($data)){
                Tool::cache(self::CACHE_ACTIVITY_ORDER)->set($name, serialize($data), self::EXPIRE_TIME_ORDER_CACHE);
            }
        }
        return $data;
    }
    public static function getOrderCacheByCode($code)
    {
        return Yii::app()->db->createCommand()
            ->from('{{seckill_order_cache}}')
            ->where('order_code=:code', array(':code' => $code))
            ->queryRow();
    }

    /**
     * 获取活动的商品信息
     * @param $goodsId
     * @return mixed
     */
    public static function getGoodsCache($goodsId){
		$product = Tool::cache(self::CACHE_ACTIVITY_GOODS)->get($goodsId);
        $data    = isset($product) && !empty($product) ? unserialize($product) : array();

        if(empty($data)){
            $goods = WebGoodsData::checkGoodsStatus($goodsId);
            $goodsSpec = GoodsSpec::getGoodsSpec($goodsId);
            if(!empty($goods)){
                $data = array('goods'=>$goods,'goodsSpec'=>$goodsSpec);
                Tool::cache(self::CACHE_ACTIVITY_GOODS)->set($goodsId, serialize($data), self::EXPIRE_TIME);
            }
        }
        return $data;
    }

    /**
     * 删除商品缓存
     * @param $goodsId
     */
    public static function delGoodsCache($goodsId){
        Tool::cache(self::CACHE_ACTIVITY_GOODS)->delete($goodsId);
    }

    /**
     * 删除缓存及order_cache
     * @param $memberId
     * @param $goodsId
     */
    public static function deleteOrderCache($memberId, $goodsId)
    {
        SeckillRedis::delCacheDefault($memberId, $goodsId);
        // 删除
        $name = $memberId . '-' . $goodsId;
        Tool::cache(self::CACHE_ACTIVITY_ORDER)->delete($name);
        Yii::app()->db->createCommand()->delete('{{seckill_order_cache}}', 'user_id=:mid and goods_id=:gid', array(':mid' => $memberId, ':gid' => $goodsId));
    }

    /**
     * 以活动为单位清除
     */
    public static function cleanCache($setting_id, $goods_id = 0)
    {
        if ($goods_id) {
            // 单独清除某商品
            $goodsIds = array($goods_id);
        } else {
            // 查出现有活动商品
            $sql = "select product_id from {{seckill_product_relation}} where rules_seting_id=:sid";
            $goodsIds = Yii::app()->db->createCommand($sql)->bindParam(':sid', $setting_id)->queryColumn();
        }
        if (!empty($goodsIds)) foreach ($goodsIds as $goods_id) {
            // 清除队列及缓存
            SeckillRedis::delCacheByGoods($goods_id);
            // 清除库存
            self::deleteActivityGoodsStock($goods_id);
            // 清除配置缓存
            Tool::cache(self::CACHE_ACTIVITY_CONFIG_GOODS_RELATION_MAP)->delete($goods_id);
            Tool::cache(self::CACHE_ACTIVITY_CONFIG_GOODS_RELATION_INFO)->delete($setting_id . '_' . $goods_id);
            Tool::cache(self::CACHE_SECKILL_STOCK)->delete($goods_id);
        }
        $delCacheArray = array(
            self::CACHE_FESTIVE_DETAIL_BANNER => 'FestiveDetailBanner' . $setting_id,
            self::CACHE_FESTIVE_DETAIL_ALL_GOODS => 'FestiveDetailAllGoods' . $setting_id,
            self::CACHE_ACTIVITY_CONFIG => self::CACHE_ACTIVITY_CONFIG,
            self::CACHE_ACTIVITY_EXPIRE_CONFIG => self::CACHE_ACTIVITY_EXPIRE_CONFIG,
            //self::CACHE_ACTIVITY_PRODUCT_ALL => self::CACHE_ACTIVITY_PRODUCT_ALL,
            self::CACHE_ACTIVITY_GRAB => self::CACHE_ACTIVITY_GRAB,
            self::CACHE_ACTIVITY_SECKILL_PRODUCT_ALL => self::CACHE_ACTIVITY_SECKILL_PRODUCT_ALL,
            self::CACHE_FESTIVE_ACTIVITY_NOBEGIN => self::CACHE_FESTIVE_ACTIVITY_NOBEGIN,
            self::CACHE_FESTIVE_ACTIVITY_GOING => self::CACHE_FESTIVE_ACTIVITY_GOING,
            self::CACHE_FESTIVE_ACTIVITY_OVER_ALL => self::CACHE_FESTIVE_ACTIVITY_OVER_ALL,
			self::CACHE_ACTIVITY_GOODS => self::CACHE_ACTIVITY_GOODS,
        );
        foreach ($delCacheArray as $key => $value) {
            Tool::cache($key)->delete($value);
        }

        //设置缓存版本 主要是清理前台缓存//
        $new_version = Tool::cache(ActivityData::CACHE_ACTIVITY_PRODUCT_ALL)->get(ActivityData::CACHE_ACTIVITY_PRODUCT_ALL."_new_version");
        if($new_version == false || $new_version >= 999) $new_version = 1;
        else $new_version += 1;
        Tool::cache(ActivityData::CACHE_ACTIVITY_PRODUCT_ALL)->set(ActivityData::CACHE_ACTIVITY_PRODUCT_ALL."_new_version",$new_version,0);
        //////清理前台缓存///////
    }


    public static function closeOrder($code = '')
    {
        if ($code) {
            $data = Yii::app()->db->createCommand()
                ->select('id')
                ->from('{{order}}')
                ->where('code=:code', array(':code' => $code))
                ->queryRow();

            $trans = Yii::app()->db->beginTransaction();
            try{
                //再次根据id,加锁查询
                $sql = 'select create_time,pay_status,code,status,id from gw_order where id='.$data['id'].' for update';
                $data = Yii::app()->db->createCommand($sql)->queryRow();
                //未支付并且时间大于规定的时间就还原库存和关闭订单
                if ($data['pay_status'] == Order::PAY_STATUS_NO && $data['status'] == Order::STATUS_NEW) {
                    Yii::app()->db->createCommand()->update('{{order}}', array('status' => Order::STATUS_CLOSE, 'close_time' => time(), 'extend_remark' => '没有在秒杀活动规定的时间内支付订单'),'id=:id',array(':id'=>$data['id']));
                    //还原库存
                    OnlineOperate::ReductionInventory($data['id']);
                    $trans->commit();
                }
            }catch (Exception $e){
                $trans->rollback();
                throw new CHttpException($e->getMessage());
            }
        }
    }


    /**
     * 删除过期缓存
     * @param $setting_id
     */
    public static function cleanCacheExpire($setting_id)
    {
        // 查出现有活动商品
        $sql = "select product_id from {{seckill_product_relation}} where rules_seting_id=:sid";
        $goodsIds = Yii::app()->db->createCommand($sql)->bindParam(':sid', $setting_id)->queryColumn();
        foreach ($goodsIds as $goods_id) {
            // 清除队列及缓存
            SeckillRedis::delCacheExpireByGoods($goods_id);
        }
    }

	/**
	*  根据rules_setting_id获取对应的活动记录,用于订单详情页面
	* @param $rules_setting_id
	* @return array
	*/
	public static function getActiveBySettingId($rules_setting_id = 0){
		if( intval($rules_setting_id) < 1 ) return array();

		$result = Yii::app()->db->createCommand()
                ->select('rm.category_id,rm.name,rm.date_start,rm.date_end,rm.banner1,rm.banner2,rm.banner3,rm.banner4,rs.*')
                ->from('{{seckill_rules_main}} rm')
                ->join('{{seckill_rules_seting}} rs', 'rm.id=rs.rules_id')
                ->where('rs.id=:id', array(':id' => $rules_setting_id))
                ->queryRow();

		return $result;
	}
}
