<?php
//获取拍卖缓存和其它相关信息

class AuctionData
{

    const EXPIRE_TIME = 3600;//缓存一小时
    const CACHE_AUCTION_RECORD = 'AuctionRecord';//拍卖记录缓存
    const ACTIVE_AUCTION = 4;//拍卖活动
    const CACHE_ACTIVITY_AUCTION = 'AuctionActivityAuction';//拍卖活动内容缓存
    const CACHE_AUCTION_GOODS = 'AuctionGoods';//拍卖商品缓存
    const CACHE_AUCTION_ALL_GOODS = 'AuctionAllGoods';//所有拍卖商品缓存(活动未过期)

    //拍卖记录缓存类型
    const CACHE_TYPE_ZERO = 0;//拍卖活动缓存
    const CACHE_TYPE_ONE = 1;//拍卖活动商品缓存
    const CACHE_TYPE_TWO = 2;//拍卖记录缓存

    //限定拍卖倍数 0为不限制
    const MULTIPLES_LIMIT = 99;

    //拍卖活动状态
    const AUCTION_ACTIVE_STATUS_ONE = 1;//未开启
    const AUCTION_ACTIVE_STATUS_TWO = 2;//未开始
    const AUCTION_ACTIVE_STATUS_THREE = 3;//正在进行
    const AUCTION_ACTIVE_STATUS_FOUR = 4;//已结束

    /**
     * 获取拍卖记录缓存
     * @param int $rsId 活动规则表id
     * @param int $goodsId 产品id
     * @param int $id 拍卖记录表id,用于过滤数据
     * @return array|mixed 返回数组
     */
    public static function getAuctionRecord($rsId = 0, $goodsId = 0, $id = 0)
    {
        $return = array();
        if ( $rsId < 0 || $goodsId < 0 ){ return $return; }

        $key    = self::CACHE_AUCTION_RECORD .'-'.$rsId.'-'.$goodsId;
        $cache  = Tool::cache($key)->get($key);

        if ( $cache == false ){//从数据库获取,按降序排列,返回数据时比较好过滤
            $result = Yii::app()->db->createCommand()
                ->select('id,member_id,member_gw,status,auction_time,balance_history,balance')
                ->from('{{seckill_auction_record}}')
                ->where('rules_setting_id=:rsid AND goods_id=:gid', array(':rsid'=>$rsId, ':gid'=>$goodsId))
                ->order('id DESC')
                ->queryAll();

            if ( !empty($result) ){
                foreach ( $result as $k=>$v ){
                    $return[$v['id']] = array(
                        'id' => $v['id'],
                        'member_id' => $v['member_id'],
                        'gw' => substr_replace($v['member_gw'],'****',2,4),
                        'status' => $v['status'],
                        'auction_time' => date('Y-m-d H:i:s',$v['auction_time']),
                        'balance' => bcadd($v['balance'], $v['balance_history'], 2)
                    );
                }

                unset($result);
                Tool::cache($key)->set($key, serialize($return), self::EXPIRE_TIME);
            }
        } else {
            $return = unserialize($cache);
        }

        if ( $id > 0 ){//如果想返回尽量少的数据,则过滤ID
            foreach ( $return as $k=>$v ){
                if( $k < $id ){
                    unset($return[$k]);
                }
            }
        }

        return $return;
    }

    /**
     * 获取拍卖活动的缓存数据(还没过期)
     * @param int $rulesSettingId 活动规则表id 不传则返回所有活动
     * @return array|mixed
     */
    public static function getActivityAuction($rulesSettingId = 0)
    {
        $return = array();
        $key    = self::CACHE_ACTIVITY_AUCTION;
        $cache  = Tool::cache($key)->get($key);

        if ( $cache == false ){
            $result = Yii::app()->db->createCommand()
                ->select('m.id AS rules_id,m.name,m.date_start,m.date_end,s.id,s.status,s.remark,s.start_time,s.end_time')
                ->from('{{seckill_rules_main}} m')
                ->join('{{seckill_rules_seting}} s', 'm.id=s.rules_id')
                ->where('s.status IN (:s2, :s3) AND m.category_id=:cid',
                    array(':s2'=>SeckillRulesSeting::ACTIVITY_NOT_START, ':s3'=>SeckillRulesSeting::ACTIVITY_IS_RUNNING, ':cid'=>self::ACTIVE_AUCTION))
                ->queryAll();

            if ( !empty($result) ){
                foreach ($result as $v){
                    $return[$v['id']] = $v;
                }
                Tool::cache($key)->set($key, serialize($return), self::EXPIRE_TIME);
            }
        } else {
            $return = unserialize($cache);
        }

        if ( $rulesSettingId < 1 ){//取所有拍卖活动
            return $return;
        } else {//取指定拍卖活动
            return isset($return[$rulesSettingId]) ? $return[$rulesSettingId] : array();
        }

    }
	
	/**
     * 获取拍卖活动时间(还没过期)
     * @param int $rulesSettingId 活动规则表id 不传则返回所有活动
     * @return array|mixed
     */
    public static function getActivityRemind($rulesSettingId = 0)
    {
        $return = array();
        $key    = self::CACHE_ACTIVITY_AUCTION;
        $cache  = Tool::cache($key)->get($key);

        if ( $cache == false ){
            $result = Yii::app()->db->createCommand()
                ->select('m.name,concat(m.date_end," ",s.end_time) AS end_time,concat(m.date_start," ",s.start_time) AS start_time')
                ->from('{{seckill_rules_main}} m')
                ->join('{{seckill_rules_seting}} s', 'm.id=s.rules_id')
                ->where('s.status IN (:s2, :s3) AND m.category_id=:cid',
                    array(':s2'=>SeckillRulesSeting::ACTIVITY_NOT_START, ':s3'=>SeckillRulesSeting::ACTIVITY_IS_RUNNING, ':cid'=>self::ACTIVE_AUCTION))
                ->queryAll();

            if ( !empty($result) ){
                foreach ($result as $v){
                    $return[$v['id']] = $v;
                }
                Tool::cache($key)->set($key, serialize($return), self::EXPIRE_TIME);
            }
        } else {
            $return = unserialize($cache);
        }

        if ( $rulesSettingId < 1 ){//取所有拍卖活动
            return $return;
        } else {//取指定拍卖活动
            return isset($return[$rulesSettingId]) ? $return[$rulesSettingId] : array();
        }

    }
	

    /**
     * 获取所有活动的商品(排除已停止的活动)
     * @return array
     */
    public static function getAuctionAllGoods()
    {
        $return = array();
        $key    = self::CACHE_AUCTION_ALL_GOODS;
        $cache  = Tool::cache($key)->get($key);

        if ( $cache == false ){
            $result = Yii::app()->db->createCommand()
                ->select('a.goods_id,a.start_price,a.price_markup,a.status,a.rules_setting_id,g.name,g.thumbnail,rs.status AS setting_status')
                ->from('{{seckill_auction}} a')
                ->leftJoin('{{goods}} g', 'a.goods_id = g.id')
                ->leftJoin('{{seckill_rules_seting}} rs', 'a.rules_setting_id=rs.id')
                ->where('rs.status IN (:s2, :s3) AND a.status=:status',
                    array(':s2'=>SeckillRulesSeting::ACTIVITY_NOT_START, ':s3'=>SeckillRulesSeting::ACTIVITY_IS_RUNNING, ':status'=>SeckillAuction::STATUS_YES))
                ->queryAll();

            if ( !empty($result) ){
                $return = $result;
                Tool::cache($key)->set($key, serialize($return), self::EXPIRE_TIME);
            }
        } else {
            $return = unserialize($cache);
        }

        return $return;
    }
	
	/**
     * 获取活动的商品缓存(根据活动规则)
     * @param int $rulesSettingId 活动规则表的id
     * @return array|mixed
     */
    public static function getAuctionSettingGoods($rulesSettingId = 0)
    {
        $return = array();
        if ( $rulesSettingId < 1 ) return $return;

        $key   = self::CACHE_AUCTION_GOODS . $rulesSettingId;
        $cache = Tool::cache($key)->get($key);

        if ( $cache == false || $cache == true ){
            $result = Yii::app()->db->createCommand()
                ->select('a.goods_id,a.start_price,a.price_markup,a.status,a.rules_setting_id,a.store_id,g.name,g.thumbnail')
                ->from('{{seckill_auction}} a')
                ->leftJoin('{{goods}} g', 'a.goods_id = g.id')
                ->where('rules_setting_id=:rsid AND a.status=:status', array(':rsid'=>$rulesSettingId,':status'=>SeckillAuction::STATUS_YES))
                ->queryAll();

            if ( !empty($result) ){
                foreach ($result as $k=>$v){
                    $return[$v['goods_id']] = $v;
                }
                Tool::cache($key)->set($key, serialize($return), self::EXPIRE_TIME);
            }
        } else {
            $return = unserialize($cache);
        }

        return $return;
    }
	

    /**
     * 设置提醒
     * @param int $rulesSettingId 活动规则表的id
     * @return array|mixed
     */
    public static function getAuctionGoodsRemind($rulesSettingId = 0)
    {
        $return = array();
        if ( $rulesSettingId < 1 ) return $return;

        $key   = self::CACHE_AUCTION_GOODS . $rulesSettingId;
        $cache = Tool::cache($key)->get($key);

        if ( $cache == false || $cache == true ){
            $result = Yii::app()->db->createCommand()
                ->select('sa.goods_id,sa.start_price,sa.price_markup,sa.status,sa.rules_setting_id,sa.store_id,g.name,g.thumbnail,concat(srm.date_end," ",srs.end_time) AS end_time,concat(srm.date_start," ",srs.start_time) AS start_time')
                ->from('{{seckill_auction}} sa')
                ->leftJoin('{{goods}} g', 'sa.goods_id = g.id')
				->leftJoin('{{seckill_rules_seting}} srs', 'srs.id = sa.rules_setting_id')
				->leftJoin('{{seckill_rules_main}} srm', 'srm.id = srs.rules_id')
                ->where('sa.rules_setting_id=:rsid AND sa.status=:status', array(':rsid'=>$rulesSettingId,':status'=>SeckillAuction::STATUS_YES))
                ->queryAll();

            if ( !empty($result) ){
                foreach ($result as $k=>$v){
                    $return[$v['goods_id']] = $v;
                }
				
		    if ( !empty($result) ){
				foreach ($result as $k=>$v){
                    $return[$v['rules_setting_id']] = $v;
                }
			}
                Tool::cache($key)->set($key, serialize($return), self::EXPIRE_TIME);
            }
        } else {
            $return = unserialize($cache);
        }

        return $return;
    }

    /**
     * 检查活动是否过期
     * @param int $rulesSettingId 活动规则表id
     * @return bool 返回值
     */
    public static function checkAuctionIsExpired($rulesSettingId = 0,$goodsId = 0)
    {
        if ( $rulesSettingId < 1 ){ return false;}

        $cache = self::getActivityAuction($rulesSettingId);
        if ( $cache == false ){ return false;}
        
        $oneGoodsTime = Yii::app()->db->createCommand()->select('auction_end_time')->from('{{seckill_auction_price}}')
                        ->where('rules_setting_id=:rsd AND goods_id=:gid',array(':rsd'=>$rulesSettingId,':gid'=>$goodsId))
                        ->queryRow();
                
        $now   = time();
        $start = $cache['date_start'].' '.$cache['start_time'];
        if(!empty($oneGoodsTime['auction_end_time'])) {
            $end   = date('Y-m-d H:i:s',$oneGoodsTime['auction_end_time']);
        } else {
            $end   = $cache['date_end'].' '.$cache['end_time'];
        }

        if ( strtotime($start) > $now || strtotime($end) < $now ){ return false; }

        return true;
    }

    /**
     * 检查活动是否在距结束两分钟内
     * @param int $rulesSettingId 活动规则表id
     * @return bool 返回值
     */
    public static function checkAuctionIsTwoMinute($rulesSettingId = 0,$goodsId = 0)
    {
        if ( $rulesSettingId < 1 ){ return false;}

        $cache = self::getActivityAuction($rulesSettingId);
        if ( $cache == false ){ return false;}

        $oneGoodsTime = Yii::app()->db->createCommand()->select('auction_end_time')->from('{{seckill_auction_price}}')
            ->where('rules_setting_id=:rsd AND goods_id=:gid',array(':rsd'=>$rulesSettingId,':gid'=>$goodsId))
            ->queryRow();

        $now   = time();
        if(!empty($oneGoodsTime['auction_end_time'])) {
            $end   = date('Y-m-d H:i:s',$oneGoodsTime['auction_end_time']);
        } else {
            $end   = $cache['date_end'].' '.$cache['end_time'];
        }

        if ( strtotime($end) - $now<=120 ){ return false; }

        return true;
    }

    /**
     * 处理活动日期,返回 状态/剩余时间/对应文字
     * @param int $rulesSettingId 活动规则表id
     * @return array 返回数组
     */
    public static function dealActiveTimes($rulesSettingId = 0, $goodsId = 0)
    {
        $return = array('status'=>self::AUCTION_ACTIVE_STATUS_FOUR,'name'=>'', 'remainTime'=>0, 'message'=>Yii::t('auction','已经结束'));
        $cache  = self::getActivityAuction($rulesSettingId);

        if ($rulesSettingId < 1 ) return $return;
        
        $oneGoodsTime = Yii::app()->db->createCommand()->select('auction_end_time')->from('{{seckill_auction_price}}')
                        ->where('rules_setting_id=:rsd AND goods_id=:gid',array(':rsd'=>$rulesSettingId,':gid'=>$goodsId))
                        ->queryRow();

        $now   = time();
        if ( $cache == false ){//已结束,单独处理

            $name = Yii::app()->db->createCommand()
                ->select('m.name,s.id')
                ->from('{{seckill_rules_main}} m')
                ->join('{{seckill_rules_seting}} s', 'm.id=s.rules_id')
                ->where('m.category_id=:cid AND s.id=:sid', array(':cid'=>self::ACTIVE_AUCTION, ':sid'=>$rulesSettingId))
                ->queryScalar();

            $return = array(
                'status'=> self::AUCTION_ACTIVE_STATUS_FOUR,
                'name' => $name ? $name : 'NULL',
                'remainTime' => 0,
                'message' => Yii::t('auction','已结束')
                );
        } else if($oneGoodsTime['auction_end_time'] > strtotime($cache['date_end'].' '.$cache['end_time'])) {
            $start = strtotime($cache['date_start'].' '.$cache['start_time']);
            $end   = $oneGoodsTime['auction_end_time'];
            if ( $start <= $now && $end >= $now){//正在进行
                $return['status'] = self::AUCTION_ACTIVE_STATUS_THREE;
                $return['remainTime'] = $end - $now;
                $return['message'] = Yii::t('auction','后结束');
            } else {//已经结束
                $return['status'] = self::AUCTION_ACTIVE_STATUS_FOUR;
                $return['remainTime'] = 0;
            }
            $return['name'] = $cache['name'];
        } else{
            $start = strtotime($cache['date_start'].' '.$cache['start_time']);
            $end   = strtotime($cache['date_end'].' '.$cache['end_time']);
			$leftTime = $oneGoodsTime['auction_end_time'];
            if ( $start > $now ){//还没开始
                $return['status'] = self::AUCTION_ACTIVE_STATUS_TWO;
                $return['remainTime'] = $start - $now;
                $return['message'] = Yii::t('auction','后开始');
            } else {
                if ( $start <= $now && $end >= $now){//正在进行
                    $return['status'] = self::AUCTION_ACTIVE_STATUS_THREE;
                    $return['remainTime'] = $leftTime - $now;
                    $return['message'] = Yii::t('auction','后结束');
                } else {//已经结束
                    $return['status'] = self::AUCTION_ACTIVE_STATUS_FOUR;
                    $return['remainTime'] = 0;
                }
            }

            $return['name'] = $cache['name'];
        }



        return $return;
    }

    /**
     *
     */
    public static function checkActivityStatus($setting = array())
    {
        $return = self::AUCTION_ACTIVE_STATUS_FOUR;
        if( empty($setting) ) return $return;

        $now   = time();
        $start = strtotime($setting['date_start'].' '.$setting['start_time']);
        $end   = strtotime($setting['date_end'].' '.$setting['end_time']);

        //未开始
        if ( $setting['status'] == self::AUCTION_ACTIVE_STATUS_TWO && $start > $now ){
            $return = self::AUCTION_ACTIVE_STATUS_TWO;
        }

        //正在进行
        if ( ($setting['status'] == self::AUCTION_ACTIVE_STATUS_THREE && $end >= $now) || ($setting['status'] == 2 && $start <= $now) ){
            $return = self::AUCTION_ACTIVE_STATUS_THREE;
        }

        //已经结束
        if ( $end < $now ){
            $return = self::AUCTION_ACTIVE_STATUS_FOUR;
        }

        return $return;
    }

    /**
     * 更新拍卖活动和活动商品的缓存数据
     * @param int $rulesSettingId 活动规则表的id
     * @param int $type 更新缓存类型 0为活动 1为活动商品 2为拍卖记录
     * @param int $goodsId 商品ID
     * @return bool 返回值
     */
    public static function updateActivityAuction( $rulesSettingId = 0, $type = 0, $goodsId = 0)
    {
        if( $rulesSettingId < 1 ) return false;

        switch ($type){
            case self::CACHE_TYPE_ONE://删除活动商品缓存
                $key  = self::CACHE_AUCTION_GOODS . $rulesSettingId;
                Tool::cache($key)->delete($key);

                $key2 = self::CACHE_AUCTION_ALL_GOODS;
                Tool::cache($key2)->delete($key2);
            break;

            case self::CACHE_TYPE_TWO://删除拍卖记录缓存
                $key    = self::CACHE_AUCTION_RECORD .'-'.$rulesSettingId.'-'.$goodsId;;
                Tool::cache($key)->delete($key);
            break;

            default://删除活动缓存
                $key = self::CACHE_ACTIVITY_AUCTION;
                Tool::cache($key)->delete($key);
            break;
        }

        return true;
    }
	
	public static function getAuctionEndTime($rulesSettingId=0, $goodsId=0){
        $rulesSettingId = intval($rulesSettingId);
        $goodsId = intval($goodsId);

        if ( $rulesSettingId < 1 || $goodsId < 1 ) return time();

        $sql = "SELECT auction_end_time FROM {{seckill_auction_price}} WHERE rules_setting_id=:rsid AND goods_id=:gid";
        $endTime = Yii::app()->db->createCommand($sql)->queryScalar(array(':rsid'=>$rulesSettingId, ':gid'=>$goodsId));

        return $endTime;
    }
}
?>