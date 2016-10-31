<?php
    $this->breadcrumbs = array(
        Yii::t('hotel', '酒店房间管理') => array('admin'),
        Yii::t('hotel', '更新'),
    );

    $this->renderPartial('_form', array(
        'model' => $model,
    ));
?>