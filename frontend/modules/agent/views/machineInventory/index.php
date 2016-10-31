<?php
/* @var $this OfflineSignStoreController */
/* @var $model OfflineSignStore */
$this->breadcrumbs=array(
    '盘点情况'=>array('admin'),
    '列表' ,
);

$this->menu=array(
    array('label'=>'List OfflineSignStore', 'url'=>array('index')),
    array('label'=>'Create OfflineSignStore', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#agentMaintenance-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<style>
    #agentmember-grid table{width:100%;cellspacing:0;cellpadding:0;}
    a {color: #666666; }
</style>
<style>
    .search_button3{float:'';display:inline;}
</style>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/My97DatePicker/WdatePicker.js"></script>
<div class="line table_white" style="margin: 10px;">
    <?php $this->renderPartial('_search',array('model'=>$model));?>
    <?php 
        $this->widget('application.modules.agent.widgets.grid.GridView',array(
                'id'=>'agentMaintenance-grid',
                'itemsCssClass' => 'table1',
                'dataProvider' => $model->searchInventory(),
                'pagerCssClass' => 'line pagebox',
                'template' => '{items}{pager}',
                'columns' => array(
                array(
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => 'name',
                    'value' => '$data->name',
                ),
                array(
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => 'machine_code',
                    'value' => '$data->machine_code',
                ),
                array(
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => '出厂终端号',
                    'value' => '$data->software_sn',
                ),
                array(
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => Yii::t('AgentMaintenance', '是否已盘点'),
                    'type' => 'raw',
                    'value' => 'MachineInventory::createButtons($data->id,$data->i_begin_time,$data->i_end_time)',
                ),
            )
        ));
    ?>
</div>