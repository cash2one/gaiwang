<?php
	$this->breadcrumbs = array(
	    Yii::t('sellerCouponActivity', '盖惠券管理') => array('/seller/couponActivity/index'),
	    Yii::t('sellerCouponActivity', '修改盖惠券') => array('/seller/couponActivity/update'),
	);
	
	$this->renderPartial('_form', array('model'=>$model)); 
?>
