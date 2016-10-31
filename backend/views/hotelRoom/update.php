<?php

/* @var $this HotelRoomController */
/* @var $model HotelRoom */

$this->breadcrumbs = array(
    Yii::t('hotelRoom', '酒店客房'),
    Yii::t('hotelRoom', '更新'),
);
?>
<?php $this->renderPartial('_form', array('model' => $model, 'pictures' => $pictures)); ?>