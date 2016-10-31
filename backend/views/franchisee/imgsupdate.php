<?php

$this->breadcrumbs = array(
    Yii::t('franchisee', '加盟商管理') => array('admin'),
    Yii::t('franchisee', '编辑加盟商图片'),
);
?>
<?php $this->renderPartial('_imgsform', array('model' => $model)); ?>