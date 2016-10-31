<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css" />
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/My97DatePicker/WdatePicker.js"></script>

<?php
    $cs = Yii::app()->clientScript;
    $cs->registerCssFile(AGENT_DOMAIN. "/agent/js/fancybox/jquery.fancybox-1.3.4.css"); 
    $cs->registerScriptFile(AGENT_DOMAIN. "/agent/js/fancybox/jquery.fancybox-1.3.4.pack.js", CClientScript::POS_END);
?>
<script type="text/javascript">
	var cssName = 'selected';

	$(function() {
		$('#dException').addClass(cssName);

		$('.tab').click(function() {
			$('.tablist .tab').removeClass(cssName);
				$(this).addClass(cssName);
			});
		});
	
		var doSelectedAppStatus = function(appStatus){
			$('#appStatus').val(appStatus);
			$('#btn_search').click();
		};
                
                function doViewMachineMonitor(machineName){
                    $("#txtMachineName").val(machineName);
                    $("#btn_search").submit();
                }
</script>

<div class="ctx">

	<div class="optPanel">
		<div class="toolbar img08"><?php echo Yii::t('Machine','盖机监控')?><?php echo CHtml::link(Yii::t('Public','返回列表'), $this->createURL('machineAgent/index'), array('class' => 'button_05 floatRight')); ?></div>
		<div class='optPanel'>			
			<?php
				$this->renderPartial('_search', array(
					'model' => $model,
				));
			?>
		</div>
	</div>
	
	<div class="tablist">
		<?php echo CHtml::link(Yii::t('Machine','正常'), '', array('class' => 'tab', 'id' => 'dNormal', 'onclick' => 'return doSelectedAppStatus(1);')); ?>
		<?php echo CHtml::link(Yii::t('Machine','异常'), '', array('class' => 'tab', 'id' => 'dException', 'onclick' => 'return doSelectedAppStatus(2);')); ?>
		<?php echo CHtml::link(Yii::t('Machine','全部'), '', array('class' => 'tab', 'id' => 'dAllMonitor', 'onclick' => 'return doSelectedAppStatus(0);')); ?>
	</div>
	
	<div id="dListTable" class="ctxTable" style="border-top:2px solid #fff;">
		<ul class="listItem">
			<?php
				$this->widget('application.modules.agent.widgets.ListView', array(
					'dataProvider' => $model->search2(),
					'itemView' => '_view2',
					'id' => 'MachineMonitorAgent-listview',
				));
			?>
		</ul>                
	</div>
	
	<div class="coypyright"></div>  
	   
</div>

<script>
var machineName = "<?php echo $machineName?>";
$(document).ready(function(){
    
   $('#txtMachineName').val(machineName); 
});
</script>

<style>
    .gt-summary{position: relative;top: -20px;font-size: 13px;}
    .tab{cursor: pointer}
</style>
<script>function subPageJump(obj){var n=$(obj).children("input").val(); n = parseInt(n); if(n>0) $(obj).parent().prev("li").children("a").attr("href",$(obj).parent().attr("jumpUrl")+n)[0].click();}</script>