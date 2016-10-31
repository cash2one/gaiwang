<link href="<?php echo AGENT_DOMAIN.'/agent';?>/css/machine.css" rel="stylesheet" type="text/css" />
<?php 
		$baseUrl = AGENT_DOMAIN.'/agent';
		$cs = Yii::app()->clientScript;
		$cs->registerScriptFile($baseUrl. "/js/jquery.artDialog.js?skin=blue");			//弹出框JS插件
                $cs->registerScriptFile($baseUrl. "/js/artDialog.iframeTools.js");			//弹出框JS插件
                $cs->registerScriptFile($baseUrl. "/js/uploadImg.js");
                $cs->registerScriptFile($baseUrl. "/js/common.js");
	?>
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
 * 删除指定广告
 */
function deleteAdvert(obj,title){
	art.dialog({
        icon: 'question',
        content: '<?php echo Yii::t('Public','确认删除')?><'+title+'><?php echo Yii::t('MachineAdvert','这个广告')?>?',
        lock: true,
        okVal: '<?php echo Yii::t('Public','确定')?>',
        ok: function(){
			location.href=obj.href;
        },
        cancelVal: '<?php echo Yii::t('Public','取消')?>',
        cancel: function(){}
    });
    return false;
}

/**
 * 删除选中广告
 */
function deleteChoose(){
        var hasChecked = false;
	var idData = [];		//定义保存id变量
	$('.adListItem').find('input[type=checkbox]').each(function(){
		if(this.checked){
			idData.push(this.value);
			hasChecked = true;
		}
	});
        
	if(!hasChecked){
		art.dialog({
			icon: 'warning',
			content: "<?php echo Yii::t('Public','没有数据被选中')?>",
			lock:true,
                        okVal: '<?php echo Yii::t('Public','确定')?>',
			ok:true
		});
		return;
	}

	var myUrl = createUrl("<?php echo $this->createUrl('machineAdvertAgent/delete')?>",{"id":idData,"adtype":<?php echo $adtype?>});
	art.dialog({
		title: "<?php echo Yii::t('Public','删除')?>",
        icon: 'question',
        content: "<?php echo Yii::t('Public','确认删除选中广告')?>?",
        lock: true,
        okVal: '<?php echo Yii::t('Public','确定')?>',
        ok: function(){
        	jQuery.ajax({
        		type:'GET',async:false,cache:false,dataType:'html',
        		url:myUrl,
        		error:function(request,status,errorcontent){
        			alert(request.responseText);
        		},
        		success:function(data){
        			$.fn.yiiListView.update("machine-advert-agent-list");
        			$('.dListTable').find('input[type=checkbox]').checked = false;
        			
        		}
        	});
        },
        cancelVal: '<?php echo Yii::t('Public','取消')?>',
        cancel: function(){}
    });
}

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
</script>
<div class="ctx advertMana">
	<div class="optPanel">
		<div class="toolbar img01">
			<?php
				switch ($adtype){
					case MachineAdvertAgent::ADVERT_TYPE_COUPON:
						$title = Yii::t('Advert','格子铺管理');
						break;
					case MachineAdvertAgent::ADVERT_TYPE_SIGN:
						$title = Yii::t('Advert','首页轮播管理');
						break;
				}
				echo $title; 
			?>
		</div>
		<?php $this->renderPartial('_search2',array('model'=>$model));?>
		
		<?php if ($adtype==MachineAdvertAgent::ADVERT_TYPE_COUPON){//只有优惠劵才使用到这个广告类型查询?>
		<div class="panel">
			<div class="adClassList">
				<ul>
					<li><?php echo CHtml::link(Yii::t('Advert','所有分类'),'javascript:doQuery("","");',array('class'=>'tab selected'))?></li>
					<?php foreach ($typeData as $key=>$val):?>
					<li>
						<?php echo $val['id'] == 2 ? CHtml::link($val['name'],'javascript:doQuery('.$val['id'].',"");',array('class'=>'tab','style'=>'background:url('.$baseUrl.'/images/home.gif) no-repeat 10px 2px;')) : ""?>
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
			<?php echo CHtml::link(Yii::t('Public','批量删除'),'javascript:deleteChoose()',array('class'=>'button_04'))?>
			<?php echo CHtml::link(Yii::t('Public','添加'),$this->createUrl('machineAdvertAgent/create',array('adtype'=>$adtype)),array('class'=>'button_04'))?>
		</div>
		<div class="adListItem">
			<ul class="ad-list">
				<?php 
					$this->widget('application.modules.agent.widgets.ListView', array(
						'dataProvider'=>$model->search(),
						'itemView'=>'_view',
						'id' => 'machine-advert-agent-list'
					)); 
				?>
			</ul>
		</div>
	</div>
</div>
<style>
    .gt-summary{position: relative;top:-30px;}   
</style>