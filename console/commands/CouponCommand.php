<?php
/**
 * 创建红包、盖惠券脚步
 */
class CouponCommand extends CConsoleCommand {

    /**
     * 检查红包、盖惠券活动队列表 及reids队列 并生成 红包、盖惠券
     */
    public function actionCreateCoupon() {
        $key = CouponTool::COUPON_LIST;
        try {
            CouponTool::checkRedisActivetiy($key); //检查 红包、盖惠券活动队列 是否有未处理的记录
            CouponTool::daemonCoupon($key);
        }catch (Exception $e){
            echo $e->getMessage();
        }

    }

}
