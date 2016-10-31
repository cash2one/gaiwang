<script type="text/javascript">
/**
 * 页面动画效果
 */
$(document).ready(function(){
	$("#overlayer").ajaxStart(function(a){
		   $(this).show();
		 });
	$("#overlayer").ajaxStop(function(){
		   $(this).hide();
		 });

	$('.tab').click(function() {
        $('.adClassList .tab').removeClass('selected');
        $(this).addClass('selected');
    });
});

$(document).ready(function () {
	$('.listTable').each(function () {
		$(this).find('tr:even').addClass('even');
		$(this).find('tr').not(':first').mouseout(function () {
			$(this).removeClass('hover');
		});
		$(this).find('tr').not(':first').mouseover(function () {
			$(this).addClass('hover');
		});
	});
});
</script>

<?php 
//给查询视图一个ajax事件
Yii::app()->clientScript->registerScript('searchBind', "
$('.search-form form').submit(function(){
	$('#machine-advert-agent-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="ctx">
    <div class="optPanel"><div class="panel"><?php $this->renderPartial('_searchmachine',array('model' => $model));?></div></div>
    <div id="dListTable" class="ctxTable">
    	<?php 
    		$this->widget('application.modules.agent.widgets.grid.GridView',array(
    			'id' => 'machine-advert-agent-grid',
    			'selectableRows' => 2,
    			'dataProvider' => $model->searchBind(),
    			'htmlOptions' => array('class' => 'listTable', 'cellpadding' => 0, 'border' => 0, 'cellspacing = 0'),
    			'columns' => array(
					array(
						'htmlOptions' => array('width' => '3%'),
                        'headerHtmlOptions' => array('width' => '3%'),
                        'class' => 'application.modules.agent.widgets.grid.CheckBoxColumn',
                        'checkBoxHtmlOptions' => array(
                            'name' => 'id[]',
                        )
					),
					array(
						'headerHtmlOptions' => array('width' => '23%'),
						'name' => 'name',
						'value' => '$data->name',
					),
					array(
						'headerHtmlOptions' => array('width' => '23%'),
						'name' => 'show_status',
						'value' => 'Machine2AdvertAgent::runStatus($data->run_status)',
						'type' => 'raw',
					),
					array(
						'headerHtmlOptions' => array('width' => '23%'),
						'name' => 'address',
						'value' => '$data->address',
					),
					array(
						'headerHtmlOptions' => array('width' => '23%'),
						'name' => 'biz_name',
						'value' => '$data->biz_name',
					)
    			)
    		));
    	?>
    </div>
</div>