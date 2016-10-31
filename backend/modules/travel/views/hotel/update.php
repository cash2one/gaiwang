<?php
    $this->breadcrumbs = array(
        Yii::t('hotel', '酒店管理') => array('admin'),
        Yii::t('hotel', '更新'),
    );

    $this->renderPartial('_form', array(
        'city' => $city,
        'district' => $district,
        'business' => $business,
        'model' => $model,
        'province'=>$province,
    ));
?>