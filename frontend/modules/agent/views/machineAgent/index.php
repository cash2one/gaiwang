<?php
/* @var $this MachineAgentController */
/* @var $dataProvider CActiveDataProvider */
$this->breadcrumbs=array(
    Yii::t('Machine','盖机管理'),
     Yii::t('Machine','盖机列表')
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	var ajaxRequest = $(this).serialize();
        $.fn.yiiListView.update(
                'machine-agent-grid',
                {data: ajaxRequest}
            )
	return false;
});
");
?>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<?php
    $cs = Yii::app()->clientScript;
    $cs->registerCssFile(AGENT_DOMAIN. "/agent/js/fancybox/jquery.fancybox-1.3.4.css"); 
    $cs->registerScriptFile(AGENT_DOMAIN. "/agent/js/fancybox/jquery.fancybox-1.3.4.pack.js", CClientScript::POS_END);
?>
<script type="text/javascript">
function doToggleShowPanel()
{
	$('.search-form').slideToggle(1300);
}
$(function () {
    $(".move_right_a6").live('mouseover',function () {
        $(".move_pulldown").hide();
        $(this).parent().siblings(".move_pulldown").show();
    });
    $(".move_pulldown").live('mouseover',function () {
        $(this).show();
    }).live('mouseout',function () {
        $(this).hide();
    });
});

//跳转盖网通编辑页面
function doEdit(id)
{
	window.location.href = createUrl("<?php echo $this->createUrl('machineAgent/control')?>",{"id":id});
}

/*全选by id*/
function doCheckAll(obj,idValue){
        var checked = obj.checked == true?true:false;
	obj.checked = checked;
	$('#'+ idValue).find("input[type='checkbox']").attr("checked",checked);
}

</script>

<div class="ctx">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
<div class="ctxTable" id="dListTable">
        <div style="padding-top: 10px;" class="headerBar">&nbsp;&nbsp;&nbsp;<input style="display:inline-block" type="checkbox" onclick="doCheckAll(this,'dListTable')"><?php echo Yii::t('Public', '全选')?>
            <a title="<?php echo Yii::t('Public', '搜索栏')?>" href="javascript:doToggleShowPanel()"style="color:#666;position: relative;top:-18px;left:80px;"><?php echo Yii::t('Public', '搜索')?></a>
        </div>
        <div class="adListItem">
            <ul>
            		<?php 
//            			$this->widget('application.modules.agent.widgets.ListView', array(
//							'dataProvider'=>$model->searchControll(),
//							'itemView'=>'_view',
//							'id' => 'machine-agent-grid',
//						)); 
					?>
					<div id="machine-grid" class="list-view">
						<div class="items">
							<?php 
								foreach ($data as $row){
									$this->renderPartial('_view',
										array(
											'region'=>$region,
											'machine'=>$machine,
											'data'=>$row
										)
									);
								}
							?>
						</div>
						<div style='width:100%;display:inline-table;text-align:center;'>
	                     	<div class="gt-pager">
								<?php $this->widget('application.modules.agent.widgets.LinkPager',array('pages'=>$pages));?>
							</div>
                		</div>
					</div>
			</ul>
        </div>
    </div>
</div>


<style>
    .gt-summary{position: relative;top:-20px;}
    .ctxTable{width:auto;overflow: hidden}
</style>