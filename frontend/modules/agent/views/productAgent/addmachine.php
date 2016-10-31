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
$('#machine-search-form').submit(function(){
	$('#machine-grid').yiiGridView('update', {
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
    		$this->widget('application.widgets.grid.GridView',array(
    			'id' => 'machine-grid',
    			'selectableRows' => 2,
    			'itemsCssClass' => 'listTable',
    			'dataProvider' => $model->searchBindProduct(),
    			'pager' => array('class' => 'application.widgets.LinkPager','maxButtonCount'=>3),
    			'columns' => array(
					array(
						'htmlOptions' => array('width' => '3%'),
                        'headerHtmlOptions' => array('width' => '3%'),
                        'class' => 'application.widgets.grid.CheckBoxColumn',
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
						'name' => Yii::t('Product','运行状态'),
						'value' => 'MachineAgent::getRunStatus($data->run_status)',
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

