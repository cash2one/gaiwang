<link href="<?php echo AGENT_DOMAIN.'/agent'; ?>/css/agent.css" rel="stylesheet" type="text/css" />
<script src="<?php echo AGENT_DOMAIN.'/agent'; ?>/js/common.js"></script>
<script src="<?php echo AGENT_DOMAIN.'/agent'; ?>/js/jquery.artDialog.js?skin=black" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN.'/agent'; ?>/js/artDialog.iframeTools.js" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN.'/agent'; ?>/js/My97DatePicker/WdatePicker.js"></script>
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

/**
 * 分类查询
 */
function doQuery(categorypid,categoryid){
	$('#MachineAdvertAgent_category_pid').val(categorypid);		//改变广告大类的值
	$('#MachineAdvertAgent_category_id').val(categoryid);		//改变广告子类的值

	if(categorypid==''&&categoryid==''){
		$('.adClassListItem').find("ul").html('');
	}
	
	if(categorypid!=''&&categoryid==''){//如果有父节点但是没有子节点，表示点击的是父节点
		var myUrl = createUrl("<?php echo $this->createUrl('machineAdvertAgent/getChildType')?>",{"pid":categorypid});
		jQuery.ajax({
			type:"get",dataType:"json",cache:false,async:false,
			url:myUrl,
			error:function(request,status,error){
				alert(request.responseText);
			},
			success:function(data){
				var childHtml = '';
				for(var i=0;i<data.length;i++){
					childHtml += '<li class="" onclick="checkLi(this)"><a class="tab" href="javascript:doQuery('+data[i].pid+','+data[i].id+');"><span class="name">'+data[i].name+'</span></a></li>';
				}
				$('.adClassListItem').find("ul").html('').append(childHtml);
			}
		});
	}
	
	$('#search_button').click();
}

/**
 * 给选中子类型添加一个样式
 */
function checkLi(obj){
	$('.adClassListItem').find("li").removeClass('selected');
	$(obj).addClass('selected');
}

function advertChecked(checkboxid){
	$('#'+checkboxid)[0].checked = $('#'+checkboxid)[0].checked?false:true;
}
</script>
<div class="ctx advertMana">
	<div class="optPanel">
		<div class="toolbar img01">
			<?php
				switch ($adtype){
					case MachineAdvertAgent::ADVERT_TYPE_COUPON:
						$title = Yii::t('Machine','格子铺');
						break;
					case MachineAdvertAgent::ADVERT_TYPE_SIGN:
						$title = Yii::t('Machine','首页轮播广告管理');
						break;
					case MachineAdvertAgent::ADVERT_TYPE_VEDIO:
						$title = Yii::t('Machine','视频管理');
						break;
				}
				echo $title; 
			?>
		</div>
		<?php $this->renderPartial('/machineAdvertAgent/_search',array('model'=>$model));?>
		
		<?php if ($adtype==  MachineAdvertAgent::ADVERT_TYPE_COUPON){//只有优惠劵才使用到这个广告类型查询?>
		<div class="panel">
			<div class="adClassList">
				<ul>
					<li><?php echo CHtml::link(Yii::t('Public','所有分类'),'javascript:doQuery("","");',array('class'=>'tab selected'))?></li>
					<?php foreach ($typeData as $key=>$val):?>
					<li>
						<?php echo $val['id'] == 2 ? CHtml::link($val['name'],'javascript:doQuery('.$val['id'].',"");',array('class'=>'tab','style'=>'background:url('.AGENT_DOMAIN.'/agent/images/home.gif) no-repeat 10px 2px;')) : ""?>
					</li>
					<?php endforeach;?>
				</ul>
			</div>
			<div class="adClassListItem"><ul></ul></div>
		</div>
		<?php }?>
		
	</div>
	<div id="dListTable" class="ctxTable">
		<div class="headerBar">
			&nbsp;&nbsp;&nbsp;<label><?php echo CHtml::checkBox("",false,array('onclick'=>'doChooseAll(this,"adListItem")'))?><?php echo Yii::t('Public','全选')?></label>&nbsp;&nbsp;
		</div>
		<div id="addAdvertList" class="adListItem">
			<ul class="ad-list">
				<?php 
					$this->widget('application.modules.agent.widgets.ListView', array(
						'dataProvider'=>$model->searchAdd(),
						'itemView'=>'advertaddview',
						'id' => 'machine-advert-agent-list'
					)); 
				?>
			</ul>
		</div>
	</div>
</div>