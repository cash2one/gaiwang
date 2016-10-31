<?php

/**
 * 秒杀活动Redis处理类
 * User: Administrator
 * Date: 2015/5/26
 * Time: 13:37
 */
class SeckillRedis
{
    const SECKILL_LIST = 'seckill_list';
//    const LIST_PREFIX = 'SK';
    const TIME_INTERVAL_CONFIRM = 120; //入队之后允许等待确认2分钟时间间隔.
    const TIME_INTERVAL_ORDER = 300; //入队之后允许等待下单5分钟时间间隔.

    const IS_PROCESS_IN = 0;//抢购入队
    const IS_PROCESS_CONFIRM = 1;//确定抢购
    const IS_PROCESS_ORDER = 2;//已下单
    const IS_PROCESS_PAYED = 3;//已支付

    const LIST_KEY = 'SK-{goods_id}'; // 队列名称
    const CACHE_KEY = 'SK-{member_id}-{goods_id}'; // 队列对应的缓存名称

    public static $member_id;
    public static $goods_id;
    public static $setting_id;

    public static $redis_list;
    public static $redis_cache;

    public static $redis_list_key;
    public static $redis_cache_key;
    public static $redis_cache_buy_key;


    public static function int($member_id, $goods_id, $setting_id = 0)
    {
        // 定义静态变量
        self::$member_id = $member_id;
        self::$goods_id = $goods_id;
        self::$setting_id = $setting_id;
        // 定义队列和缓存的键值
        self::$redis_list_key = str_replace('{goods_id}', $goods_id, self::LIST_KEY);
        self::$redis_cache_key = str_replace(array('{member_id}', '{goods_id}'), array($member_id, $goods_id), self::CACHE_KEY);
        // 保存队列对象
        self::$redis_list = new ARedisList(self::$redis_list_key);
        // 必须保证初始化时,$member_id,$goods_id,$setting_id三个必须参数有值
        if (!self::$setting_id) {
            $arr = self::getCache();
            self::$setting_id = $arr['setting_id'];
        }
        self::checkCacheRelationship();

    }


    public static function addList(array $goodInfo)
    {
        $flag = false;
        $member_id = self::$member_id;

        $stock = ActivityData::getActivityGoodsStock($goodInfo['goods_id'], $goodInfo['goods_spec_id']);
        $redis = self::$redis_list;
        $redisLength = $stock + 20; //目前写死+20
        //队列长度 > 库存 +20 就不能入队列了
        if ($redis->getCount() > $redisLength) {
            throw new CHttpException(503, Yii::t('seckill', '订单队列已满'));
        } else {
            //判断队列是不是已经有数据
            $arr = $redis->getData(true);
            if (!in_array($member_id, $arr)) {
                $flag = $redis->push($member_id);//入队列
                if ($flag == false) {
                    throw new CHttpException(503, Yii::t('seckill', '请求失败!'));
                }
                self::setCache($goodInfo);
            } else {
                return $flag;
            }
        }
        return $flag;
    }

    public static function checkCacheRelationship()
    {
        $cache_data = self::getCache();

        $redis = self::$redis_list;
        $arr = $redis->getData(true);

        if (!empty($cache_data) && in_array(self::$member_id, $arr)) {
            return true;
        }
        // 未支付的清除缓存及order_cache
        if($cache_data['is_process'] < self::IS_PROCESS_PAYED){
            self::delCache();
        }
    }

    /**
     * 设置缓存
     * @param array $data
     */
    public static function setCache(array $data)
    {
        if (!empty($data)){
//            Tool::cache(self::SECKILL_LIST)->set(self::$redis_cache_key, serialize($data), 3600);
            ActivityData::addOrder($data);
        }

    }

    /**
     * 获取缓存数据
     * @return mixed
     */
    public static function getCache($flush = false)
    {
        return ActivityData::getOrderCache(self::$member_id, self::$goods_id, self::$setting_id,$flush);
//        return unserialize(Tool::cache(self::SECKILL_LIST)->get(self::$redis_cache_key));
    }

    /**
     * 检查每步的操作间隔是否大于5分钟
     * @throws CHttpException
     */
    public static function checkTime()
    {
        $info = self::getCache();
        $time_interval = (int)(time() - $info['create_time']);
        $time_limit = 0;
        if ($info['is_process'] == self::IS_PROCESS_IN) {
            $time_limit = self::TIME_INTERVAL_CONFIRM;
        } elseif ($info['is_process'] == self::IS_PROCESS_CONFIRM) {
            $time_limit = self::TIME_INTERVAL_ORDER;
        } elseif ($info['is_process'] == self::IS_PROCESS_ORDER) {
            //已下单了,检查同款商品是否还能购买
            return true;
        }

        // 判断总用时
        if ($time_interval > $time_limit) {
            self::delCache();
            throw new CHttpException(503, Yii::t('seckill', '抱歉,您已经超时!'));
        }
    }

    /**
     * 删除缓存及order_cache
     */
    public static function delCache()
    {
        ActivityData::deleteOrderCache(self::$member_id, self::$goods_id);
    }

    /**
     * 删除队列及缓存,不删order_cache
     * @param $member_id
     * @param $goods_id
     */
    public static function delCacheDefault($member_id, $goods_id)
    {
        $redis_list_key = str_replace('{goods_id}', $goods_id, self::LIST_KEY);
        $redis_cache_key = str_replace(array('{member_id}', '{goods_id}'), array($member_id, $goods_id), self::CACHE_KEY);
        //删除缓存
        Tool::cache(self::SECKILL_LIST)->delete($redis_cache_key);
        //删除队列里面的这个会员数据.
        $redis_list = new ARedisList($redis_list_key);
        $redis_list->remove($member_id);
    }

    /**
     * 删除商品缓存
     * @param $goods_id
     */
    public static function delCacheByGoods($goods_id)
    {
        $redis_list_key = str_replace('{goods_id}', $goods_id, self::LIST_KEY);
        $redis_list = new ARedisList($redis_list_key);
        $memberIds = $redis_list->getData(true);
        //删除队列里面的这个会员数据.
        foreach ($memberIds as $member_id) {
            $redis_cache_key = str_replace(array('{member_id}', '{goods_id}'), array($member_id, $goods_id), self::CACHE_KEY);
            //删除缓存
            Tool::cache(self::SECKILL_LIST)->delete($redis_cache_key);
        }
        $redis_list->clear();
        ActivityData::delGoodsCache($goods_id);//删除缓存
    }

    /**
     * 删除过期缓存
     * @param $goods_id
     */
    public static function delCacheExpireByGoods($goods_id)
    {
        $redis_list_key = str_replace('{goods_id}', $goods_id, self::LIST_KEY);
        $redis_list = new ARedisList($redis_list_key);
        $memberIds = $redis_list->getData(true);
        //删除队列里面的这个会员数据.
        foreach ($memberIds as $member_id) {
            $redis_cache_key = str_replace(array('{member_id}', '{goods_id}'), array($member_id, $goods_id), self::CACHE_KEY);

            //删除缓存
            $cacheData = unserialize(Tool::cache(self::SECKILL_LIST)->get($redis_cache_key));
            if ($cacheData == false) {
                $redis_list->remove($member_id);
            } else{
                if (($cacheData['is_process'] == SeckillRedis::IS_PROCESS_IN &&  time() - $cacheData['create_time'] > self::TIME_INTERVAL_CONFIRM)
                    || ($cacheData['is_process'] == SeckillRedis::IS_PROCESS_ORDER && time() - $cacheData['create_time'] > self::TIME_INTERVAL_ORDER)
                ) {
                    //下完单,没支付,返原库存,关闭订单
                    $codes = $cacheData['order_code'];
                    if($cacheData['is_process'] == SeckillRedis::IS_PROCESS_ORDER && !empty($codes)){
                        foreach($codes as $code){
                            ActivityData::closeOrder($code);
                        }
                    }
                    Tool::cache(self::SECKILL_LIST)->delete($redis_cache_key);
                    $redis_list->remove($member_id);
                }
            }
        }

    }

    /**
     * 入队之前检查重复购买是否满足活动的规则.
     * @param array $setting 活动规则缓存数据
     * @param bool $flush
     * @throws CHttpException
     * @internal param int $addQuantiy 要购买的数量
     */
    public static function checkBuy(array $setting,$flush = false)
    {
        //已经成功秒到的信息
        $data = ActivityData::getOrderCache(self::$member_id, self::$goods_id, self::$setting_id, $flush);
        if(!empty($data) ){
            if($data['is_process'] == SeckillRedis::IS_PROCESS_PAYED){
                throw new CHttpException(503, Yii::t('seckill', '抱歉,此活动商品不能重复购买!'));
            }elseif($setting['buy_limit'] > 0 && $data['quantity'] > $setting['buy_limit']) {
                throw new CHttpException(503, Yii::t('seckill', '抱歉,此商品每人只能限购{limit}件！', array('{limit}' => $setting['buy_limit'])));
            }
        }
    }

}