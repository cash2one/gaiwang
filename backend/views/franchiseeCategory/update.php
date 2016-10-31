<?php
$this->breadcrumbs = array(
    Yii::t('franchiseeCategory', '加盟商管理') => array('admin'),
    Yii::t('franchiseeCategory', '编辑加盟商分类'),
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>