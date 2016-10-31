<?php 
	$cs = Yii::app()->clientScript->registerScriptFile(AGENT_DOMAIN.'/agent'."/js/jquery.dragsort-0.5.1.min.js");
?>
<script src="<?php echo AGENT_DOMAIN.'/agent'; ?>/js/common.js"></script>
<link href="<?php echo AGENT_DOMAIN.'/agent';?>/css/agent.css" rel="stylesheet" type="text/css" />
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

$(function () {
	$(".ad-list").dragsort({
		dragSelector: "li",
		dragEnd: function () { },
		dragBetween: false,
		placeHolderTemplate: "<li class='placeHolder'><div></div></li>"
	});

	var optResult = $('#hd_OptResult').val();
	if (optResult != null && optResult != '') {
		art.dialog(optResult).time(1.5);
	}
});

// 保存排序
function doSaveSortList(){
	var myAction = createUrl("<?php echo $this->createUrl('machineAgent/productUpdateSort',array('id'=>$model->id,'adtype'=>$adtype))?>");
	$('#productAgentSort-form')[0].action = myAction;
	$('#productAgentSort-form')[0].submit();
	return false;
}

/**
 * 分类查询
 */
function doQuery(categorypid,categoryid){
	$('#ProductAgent_category_pid').val(categorypid);		//改变广告大类的值
	$('#ProductAgent_category_id').val(categoryid);		//改变广告子类的值

	if(categorypid!=''&&categoryid==''){//如果有父节点但是没有子节点，表示点击的是父节点,要获取子节点，然后默认第一个节点选中
		var myUrl = createUrl("<?php echo $this->createUrl('productAgent/getChildType')?>",{"pid":categorypid});
		jQuery.ajax({
			type:"get",dataType:"json",cache:false,async:false,
			url:myUrl,
			error:function(request,status,error){
				alert(request.responseText);
			},
			success:function(data){
				var childHtml = '';
				var liClass = "";
				for(var i=0;i<data.length;i++){
					if(i==0){
						liClass = "tab selected";
						$('#ProductAgent_category_id').val(data[i].id);
					}else{
						liClass = "tab";
					}
					childHtml += '<li class="'+liClass+'" onclick="checkLi(this)"><a href="javascript:doQuery('+data[i].pid+','+data[i].id+');"><span class="name">'+data[i].name+'</span></a></li>';
				}
				
				$('.adClassListItem').find("ul").html('').append(childHtml);
			}
		});
	}
	
	$('#product_agent_search').submit();
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
			<?php echo $model->name?> ->  <?php echo Yii::t('Machine','广告排序')?>
			<?php echo CHtml::link(Yii::t('Public','返回'),$this->createUrl('machineAgent/productlist',array('id'=>$model->id,'adtype'=>$adtype)),array('class'=>'button_04 floatRight'))?>
		</div>
	</div>
	<div id="dListTable" class="ctxTable">
		<table width="100%" border="0" cellspacing="1" cellpadding="0" class="inputTable">
			<tbody>
				<tr class="caption">
					<td colspan="2">
						<?php 
							echo Yii::t('Machine','商品管理');
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
					
						<div class="panel">
							<div class="adClassList">
								<ul>
									<?php
										$pi = 0; 
										foreach ($typeData as $key=>$val):
											if ($adModel->category_pid!=""){
												if($val['id']==$adModel->category_pid){
													$pclass = "selected";
													$pstyle = "";
												}else{ 
													$pclass = "";
													$pstyle = "background:url(/images/home.gif) no-repeat;";
												}
											}else{
												if($pi==0){
													$pclass = "selected";
													$pstyle = "";
												}else{ 
													$pclass = "";
													$pstyle = "background:url(/images/home.gif) no-repeat;";
												}
											}
									?>
									<li>
										<?php echo CHtml::link($val['name'],$this->createUrl('machineAgent/productSort',array('id'=>$model->id,'category_pid'=>$val['id'])),array('class'=>"tab $pclass",'style'=>"$pstyle"))?>
									</li>
									<?php 
										$pi++;
										endforeach;
									?>
								</ul>
							</div>
							<div class="adClassListItem">
								<ul>
									<?php 
										$ci = 0;
										foreach ($typeChild as $keyChile=>$valChile):
											if ($adModel->category_id!=""){
												if($valChile['id']==$adModel->category_id){
													$cclass = "selected";
												}else{ 
													$cclass = "";
												}
											}else{
												if($ci==0){
													$cclass = "selected";
												}else{ 
													$cclass = "";
												}
											}
									?>
									<li class="tab <?php echo $cclass?>">
											<a href="<?php echo $this->createUrl('machineAgent/productSort',array('id'=>$model->id,'category_id'=>$valChile['id'],'category_pid'=>$valChile['pid'])) ?>">
											<span class="name"><?php echo $valChile['name']?></span>
											</a>
										</li>
									<?php 
										$ci++;
										endforeach;
									?>
								</ul>
							</div>
						</div>
                    	
						<?php 
							$form=$this->beginWidget('CActiveForm', array(
								'id'=>'productAgentSort-form',
							)); 
						?>
                                                <div class="headerBar">
							<?php echo CHtml::link(Yii::t('Machine','保存排序'),"javascript:;",array("class"=>"button_04","onclick"=>"return doSaveSortList()"))?>
						</div>
						<div class="adListItem" id="dCouponList">
							<ul class="ad-list">
								<?php 
									foreach ($data as $row){
										$this->renderPartial('productsortview',array('data'=>$row));
									}
								?>
                                                        </ul>
						</div>
						<?php $this->endWidget();?>
					</td>
				</tr>
			</tbody>
            </table>
		<div class="footerBar"></div>
    </div>
</div>
    

