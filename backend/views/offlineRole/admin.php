<?php $this->breadcrumbs = array(Yii::t('offlineRole', '线下角色管理') => array('admin'), Yii::t('offlineRole', '列表')); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#offlineRole-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('OfflineRole.Create')): ?>
    <input id="Btn_Add" type="button" value="<?php echo Yii::t('offlineRole', '创建角色'); ?>" class="regm-sub" onclick="location.href = '<?php echo $this->createAbsoluteUrl("/offlineRole/create"); ?>'" />
<?php endif; ?>
<div class="c10"></div>
<script type='text/javascript'>
function makesure(){
	var role_name = $(this.parentNode.parentNode)[0].children[0].innerHTML;
	var url = this.href;
	art.dialog({
		content: '是否删除线下角色{'+role_name+'}',
		ok: function(){
			location.href = url;
		},
		cancel: true
	});
	return false;
}
</script>
<?php
$this->widget('GridView', array(
    'id' => 'offlineRole-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'role_name',
        'rate',
        'username',
    	array('name'=>'update_time','value'=>'date("Y-m-d H:i:s",$data->update_time)'),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('offlineRole', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => 'Yii::app()->user->checkAccess("OfflineRole.Update")'
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => 'Yii::app()->user->checkAccess("OfflineRole.Delete") && $data->role_id > 10',
                	'click' => 'makesure',
					'url' => 'Yii::app()->controller->createUrl("delete",array("id"=>$data->primarykey))',
                ),
            )
        )
    ),
));
?>