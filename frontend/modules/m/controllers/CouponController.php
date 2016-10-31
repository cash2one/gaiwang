<?php
/**
 * 
 * 盖惠券控制器
 * @author 
 *
 */
class CouponController extends WController
{

	 /**
     * 盖惠券列表
     */
     public function actionIndex() {
        $this->showTitle =Yii::t('couponActivity', '我的盖惠劵');
        $this->render('index');
    }
}
