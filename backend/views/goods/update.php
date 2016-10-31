<?php
/* @var $this GoodsController */
/* @var $model Goods */
$this->breadcrumbs=array(
        Yii::t('goods','商品管理')=>array('index'),
	 Yii::t('goods','更新'),
);

?>
<?php $this->renderPartial('_form', array('model'=>$model, 'imgModelPic'=>$imgModelPic,)); ?>