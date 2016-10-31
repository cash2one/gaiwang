<?php
    $this->breadcrumbs = array(
        Yii::t('hotel', '酒店管理') => array('admin'),
        Yii::t('hotel', '添加'),
    );

    $this->renderPartial('_form', array(
        'city' => $city,
        'district' => $district,
        'model' => $model,
        'pictures' => $pictures,
        'province'=>$province,
    ));
?>