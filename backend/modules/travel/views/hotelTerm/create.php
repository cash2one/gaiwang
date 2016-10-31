<?php
    $this->breadcrumbs = array(
        Yii::t('hotel', '酒店管理') => array('admin'),
        Yii::t('hotel', '添加价格计划'),
    );

    $this->renderPartial('_form', array(
        'model' => $model,
    ));
?>