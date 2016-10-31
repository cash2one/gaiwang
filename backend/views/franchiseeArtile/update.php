<?php
/* @var $this FranchiseeArtileController */
/* @var $model FranchiseeArtile */

$this->breadcrumbs=array(
    Yii::t('brand','加盟商管理 ')=> array('admin'),
    Yii::t('brand','加盟商文章编辑'), 
);

?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>