<?php
	$this->breadcrumbs = array(
	    Yii::t('sellerCouponActivity', '盖惠券管理') => array('/seller/couponActivity/index'),
	    Yii::t('sellerCouponActivity', '创建盖惠券') => array('/seller/couponActivity/create'),
	);
	
	$this->renderPartial('_form', array('model'=>$model)); 
?>