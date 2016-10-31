<?php

$this->breadcrumbs = array(
    Yii::t('link', '友情链接管理') => array('admin'),
    Yii::t('link', '编辑友情链接'),
);
?>

<?php $this->renderPartial('_form', array('model' => $model)); ?>