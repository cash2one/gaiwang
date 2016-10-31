<?php
    $this->breadcrumbs = array(
        Yii::t('hotel', '热门地址管理') => array('admin'),
        Yii::t('hotel', '更新'),
    );

    $this->renderPartial('_form', array(
        'city' => $city,
        'model' => $model,
        'province'=>$province,
    ));
?>