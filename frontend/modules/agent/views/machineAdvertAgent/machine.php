<?php 
	$cs = Yii::app()->clientScript;
	$baseUrl = AGENT_DOMAIN.'/agent';
        Yii::app()->clientScript->registerCssFile($baseUrl. "/css/machine.css?v=1");
	
	$cs->registerScriptFile($baseUrl. "/js/jquery.artDialog.js?skin=blue");			//弹出框JS插件
	$cs->registerScriptFile($baseUrl. "/js/artDialog.iframeTools.js");				//弹出框调用远程文件插件
        $cs->registerScriptFile($baseUrl. "/js/common.js");                                
        ?>
<script type="text/javascript">
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

	/**
 	 * table样式事件 
	 */
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

	/**
	 * 添加盖机
	 */
	function  addMachine(){
        var url = createUrl("<?php echo $this->createUrl('machineAdvertAgent/addMachine')?>",{"id":<?php echo $model->advert_id?>,"adtype":<?php echo $adtype?>});
		art.dialog.open(url,{
			title : "<?php echo Yii::t('Machine','添加盖机')?>",
			lock : true,
			height : 630,
			width : 880,
			init:function(){//可以再这个地方写窗体加载之后的事件
			},
                        okVal: '<?php echo Yii::t('Public','确定')?>',
			ok : function(){
				var iframe = this.iframe.contentWindow;
				if(!iframe.document.body){
					alert("窗体还没有加载完毕!");
					return false;
				}

				var id = '';
				$(iframe.document.getElementById('dListTable')).find("input[name='id[]']").each(function(){
					if($(this)[0].checked){
						id+= $(this).val()+",";
					}
				});

				id = id.substring(0,id.length-1);

				$('#addid').val(id);

				$('#submit_button').click();
			},
                        cancelVal: '<?php echo Yii::t('Public','取消')?>',
			cancel:true
		});
		return false;
	}
</script>

<?php 
//给显示视图一个ajax事件
Yii::app()->clientScript->registerScript('update', "
$('#machine2Advert-form').submit(function(){
	$('#machine2Advert-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	$('#addid').val('');
	return false;
});
");
?>

<div class="ctx">
	<div class="optPanel">
		<div class="toolbar img01"><?php echo Yii::t('Machine','绑定盖机')?>
			<?php 
				switch ($adtype){
					case MachineAdvertAgent::ADVERT_TYPE_SIGN:
						$url = $this->createUrl('machineAdvertAgent/sign');
						break;
					case MachineAdvertAgent::ADVERT_TYPE_COUPON:
						$url = $this->createUrl('machineAdvertAgent/coupon');
						break;
				}
			?>
			<?php echo CHtml::link(Yii::t('Public','返回'),$url,array('class'=>'button_05 floatRight'));?>
                    <?php // echo CHtml::link(Yii::t('Public','返回'),$this->createUrl('machineAdvertAgent/coupon'),array('class'=>'button_05 floatRight'));?>
                    <?php echo CHtml::link(Yii::t('Machine','添加盖机'),'javascript:addMachine();',array('class'=>'button_05 floatRight','onclick'=>'return addMachine()'))?>
		</div>
	</div>
	<?php 
		$form = $this->beginWidget('CActiveForm',array(
			'id'=>'machine2Advert-form',
		));
			
	?>
	<?php echo CHtml::hiddenField("addid","",array('id'=>'addid'))?>
	<div id="dListTable" class="ctxTable">
		<?php 
			$this->widget('application.modules.agent.widgets.grid.GridView',array(
                            'itemsCssClass' => 'listTable',
			'id' => 'machine2Advert-grid',
			'dataProvider' => $dataProvider,
			'selectableRows' => 2,			//这个用来确定是否为checkbox
			//'htmlOptions' => array('class' => 'listTable', 'cellpadding' => 0, 'border' => 0, 'cellspacing = 0'),
			'columns' => array(
					array(
                        'htmlOptions' => array('width' => '3%'),
                        'headerHtmlOptions' => array('width' => '3%'),
                        'class' => 'application.modules.agent.widgets.grid.CheckBoxColumn',
						'value' => '$data->machine_id',
                        'checkBoxHtmlOptions' => array(
                            'name' => 'delid[]',
                        )
                    ),
					array(
						'headerHtmlOptions' => array('width' => '23%'),
						'name' => 'machine_name',
						'value' => '$data->name',
					),
					array(
						'headerHtmlOptions' => array('width' => '23%'),
						'name' => 'machine_status',
						'value' => 'Machine2AdvertAgent::runStatus($data->run_status)',
						'type' => 'raw',
					),
					array(
						'headerHtmlOptions' => array('width' => '23%'),
						'name' => 'machine_area',
						'value' => '$data->address',
					),
					array(
						'headerHtmlOptions' => array('width' => '23%'),
						'name' => 'machine_service',
						'value' => '$data->biz_name',
					)
				)
			));
		?>
		<div class="footerBar">
			<?php echo CHtml::submitButton(Yii::t('Machine','解除绑定'),array('class'=>'button_05','id' => 'submit_button','name' => 'submit_button'))?>
		</div>
    </div>
<?php $this->endWidget();?>   
</div>
<style>
    .gt-summary{position: relative;top:-20px;}   
</style> 
    

