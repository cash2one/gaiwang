<?php
$this->breadcrumbs = array(
    Yii::t('interestCategory', '兴趣爱好分类列表') => array('admin'),
    Yii::t('interestCategory', '修改兴趣爱好分类'),
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>