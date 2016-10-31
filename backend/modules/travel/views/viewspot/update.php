<?php

$this->breadcrumbs = array(
    Yii::t('viewspot', '城市名片管理') => array('citycard/admin'),
    Yii::t('viewspot', '编辑景点'),
);
$this->renderPartial('_form', array(
            'model' => $model,
            'business'=>$business,
));
?>