<?php
$this->breadcrumbs = array(
    Yii::t('interest', '兴趣爱好') => array('admin'),
    Yii::t('interest', '新增兴趣爱好'),
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>