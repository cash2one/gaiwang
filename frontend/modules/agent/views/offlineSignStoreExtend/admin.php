<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<?php
/* @var $this OfflineSignStoreExtendController */
/* @var $model OfflineSignStoreExtend */

$this->breadcrumbs=array(
	'电子化签约申请'=>array('OfflineSignStoreExtend/admin'),
	'列表',
);

$this->menu=array(
	array('label'=>'List OfflineSignStoreExtend', 'url'=>array('index')),
	array('label'=>'Create OfflineSignStoreExtend', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#offline-sign-store-extend-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="com-box">
	<div class="clearfix search-form">
		<?php $this->renderPartial('_search',array('model'=>$model)); ?>
	</div>
	<div class="c10"></div>
	<div class="grid-view" id="article-grid">
		<?php
		$this->widget('application.modules.agent.widgets.grid.GridView',array(
			'id'=>'offline-sign-store-grid',
			'itemsCssClass' => 'tab-reg',
			'dataProvider' => $model->search(),
			'pagerCssClass' => 'line pagebox',
            'afterAjaxUpdate' => 'function() { col_add(); }',
			'template' => '{items}{pager}',
			'columns' => array(
				array(
					'htmlOptions' => array('class' => 'tc'),
					'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '10%'),
					'name' => 'update_time',
					'value' => 'date("Y-m-d H:i:s",$data->update_time)',
				),
				array(
					'htmlOptions' => array('class' => 'tc'),
					'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '15%'),
					'name' => 'enTerName',
					'value' => '$data->enTerName',
				),
				array(
					'htmlOptions' => array('class' => 'tc'),
					'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '15%'),
					'value' => 'OfflineSignStoreExtend::getApplyType($data->apply_type)',
				),
				array(
					'htmlOptions' => array('class' => 'tc'),
					'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '15%'),
					'value' => 'OfflineSignStoreExtend::getStatus($data->status)',
				),
				array(
					'htmlOptions' => array('class' => 'tc'),
					'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '20%'),
					'name' => 'event',
					'value' => 'OfflineSignAuditLogging::getNewEventByStoreId($data->primaryKey,false)',
				),
				array(
					'class'=>'CButtonColumn',
					'headerHtmlOptions' => array('class' => 'tabletd tc'),
					'htmlOptions' => array('class' => 'tc'),
					'header' => Yii::t('Public','操作'),
					'template'=>'{update} {continueUpdate} {canNotPass} {auditSchedule} {qualificationDetails}',
					'buttons'=>array(
						'update' => array(
							'options'=>array('class' => 'btn-sign'),
							'label' => Yii::t('Public','编辑'),
							'url' => 'OfflineSignStoreExtend::getUpdateUrl($data->apply_type,$data->offline_sign_contract_id,$data->primaryKey)',
							'visible' => '$data->status == OfflineSignStoreExtend::STATUS_NO_QUALIFICATION',
							'imageUrl' => false
						),
						'continueUpdate' => array(
							'options'=>array('class' => 'btn-sign'),
							'label' => Yii::t('Public','继续编辑'),
							'url' => 'OfflineSignStoreExtend::getContinueUpdateUrl($data->apply_type,$data->offline_sign_contract_id,$data->primaryKey)',
							'visible' => '$data->status == OfflineSignStoreExtend::STATUS_NOT_SUBMIT && $data->audit_status != OfflineSignStoreExtend::AUDIT_STATUS_SUB_ELECTR',
							'imageUrl' => false
						),
						'canNotPass' => array(
							'options'=>array('class' => 'btn-sign'),
							'label' => Yii::t('Public','不通过原因'),
							'url' => 'Yii::app()->controller->createUrl("canNotPass", array("id"=>$data->primaryKey))',
							'visible' => '$data->status == OfflineSignStoreExtend::STATUS_NOT_BY || $data->status == OfflineSignStoreExtend::STATUS_NOT_BY_CONTRACT',
							'imageUrl' => false
						),
						'auditSchedule' => array(
							'options'=>array('class' => 'btn-sign'),
							'label' => Yii::t('Public','审核进度'),
							'url' => 'Yii::app()->controller->createUrl("offlineSignAuditLogging/seeAudit", array("storeExtendId"=>$data->primaryKey))',
							'imageUrl' => false
						),
						'qualificationDetails' => array(
							'options'=>array('class' => 'btn-sign'),
							'label' => Yii::t('Public','资质详情'),
							'url' => 'Yii::app()->controller->createUrl("qualificationDetails", array("id"=>$data->primaryKey))',
							'imageUrl' => false
						),
					),
				),
			)
		));
		?>
	</div>
</div>
<script>
    col_add();
    /*动态添加状态和流程下拉框*/
    function col_add() {
        var selObj = $("#offline-sign-store-grid_c2");
        selObj.append("<select onchange='changeStatus();'><option value=''>"+'新增类型'+"</option><option value=<?php echo OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE?>>"+'<?php echo OfflineSignStoreExtend::getApplyType(OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE);?>'+"</option><option value=<?php echo OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE?>>"+'<?php echo OfflineSignStoreExtend::getApplyType(OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE);?>'+"</option></select>");
        var selObj = $("#offline-sign-store-grid_c3");
        selObj.append("<select onchange='changeStatus();'><option value=''>"+'审核状态'+"</option>" +
            <?php foreach(OfflineSignStoreExtend::getStatus() as $key=>$val):?>
        "<option value=<?php echo $key?>>"+'<?php echo $val;?>'+"</option>" +
        <?php endforeach;?>
        "</select>");
        $("#offline-sign-store-grid_c2  option[value=<?php echo !empty($model->apply_type)?($model->apply_type):'';?>] ").attr("selected",true);
        $("#offline-sign-store-grid_c3  option[value=<?php echo !empty($model->status)?($model->status):'';?>] ").attr("selected",true);
        $('#status').val(<?php echo !empty($model->status)?($model->status):'';?>);
        $('#apply_type').val(<?php echo !empty($model->apply_type)?($model->apply_type):'';?>);
    }

    /**按状态条件来查询记录*/
    function changeStatus(){
        var apply_type = $("#offline-sign-store-grid_c2").find("option:selected").val();
        var status = $("#offline-sign-store-grid_c3").find("option:selected").val();

        $('#status').val(status);
        $('#apply_type').val(apply_type);
        $('#yw0').submit();
    }
</script>