<?php

$this->breadcrumbs = array(
    Yii::t('hotel', '酒店管理') => array('admin'),
    Yii::t('hotel', '更新'),
);

$this->renderPartial('_form', array(
    'province' => $province,
    'city' => $city,
    'district' => $district,
    'model' => $model,
    'pictures' => $pictures
));
?>