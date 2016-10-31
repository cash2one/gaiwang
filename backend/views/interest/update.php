<?php
$this->breadcrumbs = array(
    Yii::t('interest', '兴趣爱好') => array('admin'),
    Yii::t('interest', '修改兴趣爱好'),
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>