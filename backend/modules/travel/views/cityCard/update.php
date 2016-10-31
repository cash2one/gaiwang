<?php

$this->breadcrumbs = array(
    Yii::t('citycard', '城市名片管理') => array('admin'),
    Yii::t('hotel', '编辑名片'),
);
$this->renderPartial('_form', array(
            'nation'=>$nation,
            'city' => $city,
            'province'=>$province,
            'model' => $model,
));
?>

