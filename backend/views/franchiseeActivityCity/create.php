<?php
$this->breadcrumbs = array(
    Yii::t('franchiseeActivityCity', '加盟商城市管理') => array('admin'),
    Yii::t('franchiseeActivityCity', '添加线下活动城市'),
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>