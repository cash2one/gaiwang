<?php
/* @var $this FranchiseeContractController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Franchisee Contracts',
);

$this->menu=array(
	array('label'=>'Create FranchiseeContract', 'url'=>array('create')),
	array('label'=>'Manage FranchiseeContract', 'url'=>array('admin')),
);
?>

<h1>Franchisee Contracts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
