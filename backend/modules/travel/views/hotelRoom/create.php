<?php
    $this->breadcrumbs = array(
        Yii::t('hotel', '酒店房间管理') => array('admin'),
        Yii::t('hotel', '添加'),
    );

    $this->renderPartial('_form', array(
        'model' => $model,
    ));
?>