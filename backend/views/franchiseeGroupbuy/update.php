<?php
/* @var $this franchiseeGroupbuyController */
/* @var $model FranchiseeGroupbuy */

$this->breadcrumbs=array(
    Yii::t('franchiseeGroupbuy','线下团购管理 ')=> array('admin'),
    Yii::t('franchiseeGroupbuy','编辑团购'), 
);

?>
<?php $this->renderPartial('_form', array('model'=>$model,'franchisee_id'=>$franchisee_id)); ?>