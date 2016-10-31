<?php
/* @var $this OfflineSignStoreController */
/* @var $model OfflineSignStore */
$this->breadcrumbs = array('电子化签约审核列表' => array('offlineSignStoreExtend/admin'), '全部签约列表');


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#offline-sign-store-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<?php $this->renderPartial('_adminTop'); ?>
<br/>
<?php $this->renderPartial('_allsignsearch', array('model' => $model,'role'=>$this->role)); ?>

<?php
$this->widget('GridView',array(
    'id'=>'offline-sign-store-extend-grid',
    'dataProvider' => $model->searchManage($this->role),
    'itemsCssClass' => 'tab-reg',
    'afterAjaxUpdate' => 'function() { col_add(); }',
    'template' => '{items}{pager}',
    'columns' => array(
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '10%px'),
            'name' => 'update_time',
            'value' => 'date("Y-m-d H:i:s",$data->update_time)',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '8%px'),
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:i:s",$data->create_time)',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '10%px'),
            'name' => 'enTerName',
            'value' => '$data->enTerName',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '15%px'),
            'value' => 'OfflineSignStoreExtend::getApplyType($data->apply_type)',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '15%px'),
            'value' => 'OfflineSignStoreExtend::allSignAuditStatus($data->id)',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '10%px'),
            'name' => 'repeat_audit',
            'value' => 'OfflineSignStoreExtend::getIsRepeatAudit($data->repeat_audit)',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '8%px'),
            'name' => 'is_import',
            'value' => 'OfflineSignStoreExtend::getIsImport($data->is_import)',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '10%px'),
            'name' => 'repeat_application',
            'value' => 'OfflineSignStoreExtend::getISRepeatApplication($data->repeat_application)',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '10%px'),
            'name' => 'agent_id',
            'value' => 'OfflineSignStore::getEnterpriseName($data->agent_id)',
        ),
        array(
            'htmlOptions' => array('class' => 'tc'),
            'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '15%px'),
            'name' => '操作',
            'type' => 'raw',
            'value' => 'OfflineSignStoreExtend::createButtonsOther($data->primaryKey)',
        ),
    )
));
?>
<script>
    col_add();
    /*动态添加状态和流程下拉框*/
    function col_add() {
        var selObj = $("#offline-sign-store-extend-grid_c3");
        selObj.append("<select onchange='changeStatus();'><option value=''>"+'新增类型'+"</option><option value=<?php echo OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE?>>"+'新商户'+"</option><option value=<?php echo OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE?>>"+'原有会员新增加盟商'+"</option></select>");
        var selObj = $("#offline-sign-store-extend-grid_c4");
        var allSelect = "<select onchange='changeStatus();'><option value=''>"+'审核状态'+"</option>";
        <?php $all_select = OfflineSignStoreExtend::getAllSignAuditStatus();foreach($all_select as $key=>$value):?>
        allSelect+="<option value=<?php echo $key;?>>"+"<?php echo $value;?>"+"</option>";
        <?php endforeach;?>
        allSelect +='</select>';
        selObj.append(allSelect);

        $("#offline-sign-store-extend-grid_c3  option[value=<?php echo !empty($model->apply_type)?($model->apply_type):'';?>] ").attr("selected",true);
        $("#offline-sign-store-extend-grid_c4  option[value=<?php echo !empty($model->role_audit_status_2_all_sign)?($model->role_audit_status_2_all_sign):'';?>] ").attr("selected",true)
    }

    /**按状态条件来查询记录*/
    function changeStatus(){
        var role_audit_status = $("#offline-sign-store-extend-grid_c4").find("option:selected").val();
        var apply_type = $("#offline-sign-store-extend-grid_c3").find("option:selected").val();
        window.location.href = "<?php echo Yii::app()->createUrl('/OfflineSignStoreExtend/allContractAdmin');?>&role=<?php echo $this->role;?>&role_audit_status="+role_audit_status+"&apply_type="+apply_type;
    }
</script>
