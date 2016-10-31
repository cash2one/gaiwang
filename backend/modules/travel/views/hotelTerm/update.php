<?php
    $this->breadcrumbs = array(
        Yii::t('hotel', '价格计划管理') => array('admin'),
        Yii::t('hotel', '更新'),
    );

    $this->renderPartial('_form', array(
        'model' => $model,
    ));
?>