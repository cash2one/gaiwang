<?php
/* @var $this AuditingController */
/* @var $model Auditing */

$this->breadcrumbs=array(
	'加盟商管理',
	'审核列表',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#auditing-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
<?php echo Yii::app()->user->checkAccess('Auditing.Pass')?CHtml::button(Yii::t('auditing', '批量通过'), array('class'=>'regm-sub', 'id'=>'batchPass')):''?>
<?php echo Yii::app()->user->checkAccess('Auditing.NotPass')?CHtml::button(Yii::t('auditing', '批量不通过'), array('class'=>'regm-sub', 'id'=>'batchNotPass')):''?>
<div class="c10"></div>
<div class="c10"></div>
<?php $this->widget('GridView', array(
	'id'=>'auditing-grid',
	'dataProvider'=>$model->searchFranchiseeAuditing(),
	'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
	'selectableRows' => 2,
	'columns'=>array(
		array(
             'header' => '全选',
             'htmlOptions' => array('width' => '5%'),
             'headerHtmlOptions' => array('width' => '5%'),
             'class' => 'zii.widgets.grid.CCheckBoxColumn',
             'checkBoxHtmlOptions' => array(
                  'name' => 'id[]',
                  'value' => '$data->id'
             )
        ),
        array(
        	'name' => 'apply_name',
        	'value'=> '$data->apply_name'
        ),
        array(
        	'name' => 'apply_type',
        	'value'=> 'Auditing::getApplyType($data->apply_type)'
        ),
        array(
        	'name' => 'author_name',
        	'value' => '$data->author_name',
        ),
		array(
			'name' => 'author_type',
			'value' => 'Auditing::getAuthorType($data->author_type)',
		),
		array(
			'name' => 'submit_time',
			'value'=> 'date("Y-m-d H:i:s", $data->submit_time)',
		),
		array(
			'class'=>'CButtonColumn',
			'header' => '操作',
			'headerHtmlOptions' => array('class' => 'tabletd tc'),
                 'htmlOptions' => array('class' => 'tc'),
                	'template' => '{view}',
                    'buttons'=>array(
                        'view' => array(
                            'label' => '【'.Yii::t('auditing','查看').'】',
                            'url' => 'Yii::app()->controller->createUrl("view", array("id"=>$data->primaryKey))',
                            'imageUrl' => false,
							'visible' => "Yii::app()->user->checkAccess('Auditing.View')",
                        ),
                    ),
		),
	),
)); ?>
<script type="text/javascript">
var BatchPassUrl = "<?php echo $this->createUrl('pass', array('id'=>1))?>";
BatchPassUrl = BatchPassUrl.substr(0,BatchPassUrl.length-1);
var BatchNotPassUrl = "<?php echo $this->createUrl('notPass', array('id'=>1))?>";
BatchNotPassUrl = BatchNotPassUrl.substr(0,BatchNotPassUrl.length-1);
$(function(){
	$("#batchPass").click(function() {
        var ids = [];
        $("#auditing-grid .select-on-check:checked").each(function() {
            ids.push($(this).val());
        });
        if (ids.length)
        {
        	art.dialog({
            	icon: "question-red",
                content: "<?php echo Yii::t('auditing', '确认批量通过吗？')?>",
                ok: function(){
						var skipUrl = BatchPassUrl+ids;
						window.location.href = skipUrl;
                    },
                cancel: true
            });
        }
        else
        {
            art.dialog({
                content: "<?php echo Yii::t('auditing', '请选择批量通过的申请！')?>",
                ok: true
            });
        }
    });
    $("#batchNotPass").click(function(){
    	var ids = [];
        $("#auditing-grid .select-on-check:checked").each(function() {
            ids.push($(this).val());
        });
        if (ids.length)
        {
        	var skipUrl = BatchNotPassUrl+ids;
        	art.dialog({
            	icon: "question-red",
                content: '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come"><tr><th colspan="2" align="center" class="title-th even" id="confimTitle"><?php echo Yii::t('auditing', '确认批量不通过吗？')?></th></tr><tr id="trOpinion"><th class="odd"><?php echo Yii::t('auditing', '原因')?>：</th><td class="odd"><textarea class="text-input-bj  text-area" style="width: 95%" rows="3" cols="50" id="txtOpinion"></textarea></td></tr></table>',
                ok: function(){
                	skipUrl += "&txtOpinion="+$("#txtOpinion").val();
                	window.location.href = skipUrl;
                    },
                cancel: true
            });
        }
        else
        {
            art.dialog({
                content: "<?php echo Yii::t('auditing', '请选择批量不通过的申请！')?>",
                ok: true
            });
        }
    });
});
</script>