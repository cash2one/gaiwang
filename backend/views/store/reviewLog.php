<?php

/* @var $this StoreController */
/* @var $model Store */
$this->breadcrumbs = array(Yii::t('store', '店铺') => array('admin'), Yii::t('store', '审核日志列表'));
?>
<?php
$this->widget('GridView', array(
    'id' => 'store-check-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'username',
        'content',
        array(
            'name' => 'create_time',
            'value' => 'date("Y/m/d H:i:s", $data->create_time)'
        ),
    ),
));
?>
