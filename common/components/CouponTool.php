<?php
/**
 * Created by PhpStorm.
 * User: ling.wu
 * Date: 2014/12/26
 * Time: 14:22
 */

class CouponTool {

    const COUPON_LIST = 'coupon_list'; //队列名

    /**
     * 检查 红包、盖惠券活动队列 是否有记录
     * @throws Exception
     */
    public static  function  checkRedisActivetiy($key){
        GWRedisList::delete($key); //清空队列
        $redisActivity = RedEnvelopeTool::getAedisActivity();
        if($redisActivity){
            $balanceRed = CommonAccount::getHongbaoAccount(); //红包账户
            foreach($redisActivity as $ra){
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    //红包活动
                    if ($ra['mode'] == Activity::ACTIVITY_MODE_RED) {
                        $rs = AccountManage::checkHasMoney($ra['money'], $balanceRed['gai_number']); //检查是否有足够金额
                        //金额不足则不创建红包，但仍然删除
                        if($rs) {
                            RedEnvelopeTool::createCoupon($ra);    //创建红包
                            AccountManage::subtractHongBaoMoney($ra['money'], $balanceRed['gai_number']);  //从金额池减去红包金额
                            MemberAccount::addHongBaoMoney($ra['money'],$ra['member_id']);  //往 会员红包金额帐户 加钱
                        }
                        RedEnvelopeTool::deleteRedisActivity($ra['uid']); //删除红包、盖惠券活动队列记录
                        GWRedisList::remove($key,CJSON::encode($ra)); //删除redis队列中的值，防止重复赠送，虽然最开如有清除，但有可能刚清除就又有写入
                    } else {  //盖惠券活动


                    }
                    $transaction->commit();
                }catch (Exception $e){
                    $transaction->rollback();
                    continue ; //继续执行，不然进脚本程会退出
                }
            }
        }
        return true;
    }


    /**
     * 创建红包、盖惠券 进程
     */
    public static function  daemonCoupon($key){
        $balanceRed = CommonAccount::getHongbaoAccount(); //红包账户
        $time = time();
        while(true){
            //先进先出，直到对列为空
            while($str = GWRedisList::pop($key)){
                $arr = CJSON::decode($str);
                $transaction = Yii::app()->db->beginTransaction();
                try{
                    //检查是否有足够金额
                    if ($arr['mode'] == Activity::ACTIVITY_MODE_RED) {
                        if(AccountManage::checkHasMoney($arr['money'],$balanceRed['gai_number'])) {
                            RedEnvelopeTool::createCoupon($arr); //创建红包
                            AccountManage::subtractHongBaoMoney($arr['money'], $balanceRed['gai_number']);  //从金额池减去红包金额
                            MemberAccount::addHongBaoMoney($arr['money'],$arr['member_id']);  //往 会员红包金额帐户 加钱
                        }
                    }
                    else {
                        //创建盖惠券

                    }
                    RedEnvelopeTool::deleteRedisActivity($arr['uid']); //删除红包、盖惠券活动队列表记录
                    $transaction->commit();
                }catch (Exception $e){
                    $transaction->rollback();
                }
            }
            //暂停1秒
            sleep(1);
            $nowTime = time();
            //大约10 分钟 重新检查 红包、盖惠券活动队列表。因为有可能redis没有成功写入记录，但是msyql写入成功，所以重新运行检查
            if(($nowTime - $time)  > 600 ){
                self::checkRedisActivetiy($key);
                $time = $nowTime;
            }
        }
    }


} 