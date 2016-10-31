<?php
/* @var $this OfflineSignStoreExtendController */
/* @var $model OfflineSignStoreExtend */

$this->breadcrumbs=array(
	'Offline Sign Store Extends'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OfflineSignStoreExtend', 'url'=>array('index')),
	array('label'=>'Create OfflineSignStoreExtend', 'url'=>array('create')),
	array('label'=>'Update OfflineSignStoreExtend', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OfflineSignStoreExtend', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OfflineSignStoreExtend', 'url'=>array('admin')),
);
?>

<h1>View OfflineSignStoreExtend #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'role_1_audit_status',
		'role_2_audit_status',
		'role_3_audit_status',
		'role_4_audit_status',
		'role_5_audit_status',
		'role_6_audit_status',
		'role_7_audit_status',
		'agent_id',
		'apply_type',
		'is_import',
		'old_member_franchisee_id',
		'status',
		'audit_status',
		'repeat_audit',
		'repeat_application',
		'create_time',
		'update_time',
	),
)); ?>
