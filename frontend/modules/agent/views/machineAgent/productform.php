<script src="<?php echo AGENT_DOMAIN.'/agent'; ?>/js/common.js"></script>
<?php 
	$cs = Yii::app()->clientScript;
	$baseUrl = AGENT_DOMAIN.'/agent';
	$cs->registerCssFile($baseUrl. "/css/machine.css?v=1");
	$cs->registerCssFile($baseUrl. "/js/fancybox/jquery.fancybox-1.3.4.css"); 
	$cs->registerScriptFile($baseUrl. "/js/fancybox/jquery.fancybox-1.3.4.pack.js", CClientScript::POS_END);	
	
	$cs->registerScriptFile($baseUrl. "/js/jquery.artDialog.js?skin=blue");			//弹出框JS插件
	$cs->registerScriptFile($baseUrl. "/js/artDialog.iframeTools.js");				//弹出框调用远程文件插件
	$cs->registerScriptFile($baseUrl. "/js/uploadImg.js");							//上传插件
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/zTree/css/zTreeStyle.css" /> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/zTree/jquery.ztree.core-3.5.js" ></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/zTree/jquery.ztree.excheck-3.5.js" ></script>
<script type="text/javascript">
//ztree
var setting = {
	check: {
		enable: true,
		chkStyle: "radio",
		radioType: "all"
	},
	view: {
		dblClickExpand: false
	},
	data: {
		simpleData: {
			enable: true
		}
	},
	callback: {
		onClick: onClick,			//点击回调事件
		onCheck: onCheck			//选中回调事件
	}
};

var zNodes = <?php echo $adTypeData?>;
$(function(){
	$.fn.zTree.init($("#treeAdvertCls"), setting, zNodes);
});

//zTree点击事件,让前面的checkbox被选中
function onClick(e, treeId, treeNode) {
	var zTree = $.fn.zTree.getZTreeObj("treeAdvertCls");
	zTree.checkNode(treeNode, !treeNode.checked, null, true);
	return false;
}

//zTree选中事件
function onCheck(e, treeId, treeNode) {
	var zTree = $.fn.zTree.getZTreeObj("treeAdvertCls"),
	nodes = zTree.getCheckedNodes(true),
	v = "";
	for (var i = 0, l = nodes.length; i < l; i++) {
		v += nodes[i].name + ",";
	}
	if (v.length > 0) v = v.substring(0, v.length - 1);
	var clsObj = $("#category");		//获取显示选中名称的文本控件
	clsObj.attr("value", v);			//赋值
	var clsIdObj = $('#ProductAgent_category_id');	//获取保存ID的文本控件
	clsIdObj.attr("value",nodes[0].id);	//赋值
}

//显示zTree
function showMenu() {
    var clsObj = $("#category");
    var cityOffset = $("#category").offset();
    $("#treeContainer").css({left:cityOffset.left + "px", top:cityOffset.top + clsObj.outerHeight() + "px"}).slideDown("fast");

    $("body").bind("mousedown", onBodyDown);
}

//关闭ztree的div
function hideMenu() {
    $("#treeContainer").fadeOut("fast");
    $("body").unbind("mousedown", onBodyDown);
}

//ztree窗体点击事件
function onBodyDown(event) {
    if (!(event.target.id == "menuBtn" || event.target.id == "category" || event.target.id == "treeContainer" || $(event.target).parents("#treeContainer").length>0)) {
        hideMenu();
    }
}

//绑定加盟商
function selectBizName(){
	art.dialog.open("<?php echo $this->createUrl('productAgent/showBiz')?>",{
		title: "<?php echo Yii::t('Franchisee','选择加盟商')?>",
		lock: true,
		width: 880,
		height: 610,
		init:function(){},
		ok:function(){
			var iframe = this.iframe.contentWindow;
			if(!iframe.document.body){
				alert("iframe还没有加载完毕!");
				return false;
			}
			var biz_id = $(iframe.document.getElementById('franchisee-grid')).find('input[class="select-on-check"]:checked').val();	
			if(biz_id){
				$.post(
					"<?php echo CHtml::normalizeUrl(array('productAgent/getBizInfo'))?>",
					{"<?php echo Yii::app()->request->csrfTokenName?>": "<?php echo Yii::app()->request->csrfToken?>",id:biz_id},
					function(data){
						$("#ProductAgent_biz_info_id").val(biz_id);
						$("#ProductAgent_biz_name").val(data.name);
						$("#ProductAgent_province_id").val(data.province_id);
						$("#ProductAgent_city_id").val(data.city_id);
						$("#ProductAgent_district_id").val(data.district_id);
					},
					"json"
				);
			}
		},
		cancel:true
	});
}
</script>

<div class="ctx">
    <div class="optPanel">
        <div class="toolbar img01">
        	<?php echo $model->isNewRecord?Yii::t('Product','添加产品'):Yii::t('Product','编辑产品')?>
	        <?php echo CHtml::link(Yii::t('Public','返回'),$this->createUrl('machineAgent/productList',array('id'=>$machine_id)),array('class'=>'button_05 floatRight'))?>
	        <?php if ($model->id!=''){?>
	        <?php echo CHtml::link(Yii::t('Public','复制'),Yii::app()->createURL('productAgent/copy',array('id'=>$model->id)),array('class'=>'button_05 floatRight'))?>
	        <?php }?>
        </div>
    </div>
    <div class="ctxTable">
    	<?php 
			$form=$this->beginWidget('CActiveForm', array(
				'id'=>'productAgent-form',
                                'action'=>  $this->createUrl('machineAgent/productUpdate'),
				'enableAjaxValidation'=>true,
				'enableClientValidation'=>true,
			)); 
		?>
		<table width="100%" border="0" cellspacing="1" cellpadding="0" class="inputTable">
	        <tbody>
	            <tr class="caption">
				    <td colspan="2"><?php echo Yii::t('Product','基本信息')?></td>
			    </tr>
	            <tr>
	                <td class="c1 width200"><?php echo Yii::t('Product','产品名称')?>：</td>
	                <td>
	                	<?php echo $form->textField($model, 'name', array('class'=>'inputbox  width200'))?><span class="required">*</span>
						<?php echo $form->error($model,'name'); ?>
	                </td>
	            </tr>
	            <tr>
	                <td class="c1"><?php echo Yii::t('Product','商品编号')?>：</td>
	                <td>
	                	<?php echo $form->textField($model, 'number', array('class'=>'inputbox width200'))?><span class="required">*</span>
						<?php echo $form->error($model,'number'); ?>
	                </td>
	            </tr>
	            <tr>
	                <td class="c1"><?php echo Yii::t('Product','市场价')?>：</td>
	                <td>
	                	<?php echo $form->textField($model, 'market_price', array('class'=>'inputbox width200'))?>（<?php echo Yii::t('Product','元')?>）
						<?php echo $form->error($model,'market_price'); ?>
	                </td>
	            </tr> 
	            <tr>
	                <td class="c1"><?php echo Yii::t('Product','零售价')?>：</td>
	                <td>
		                <?php echo $form->textField($model, 'price', array('class'=>'inputbox width200','onblur'=>'computeReturn()'))?>（<?php echo Yii::t('Product','元')?>）<span class="required">*</span>
						<?php echo $form->error($model,'price'); ?>
	                </td>
	            </tr>
	            <tr>
	                <th class="c1"><?php echo Yii::t('Product','返佣率')?>： </th>
	                <td>
	                	<?php echo $form->textField($model, 'back_rate', array('class'=>'inputbox width200','onblur'=>'computeReturn()'))?>%<span class="required">*</span>
	                	<span id="commission" style="width:100px;height:24px; line-height:24px;color:Red; font-weight:bold; padding:2px 5px;"></span>
						<?php echo $form->error($model,'back_rate'); ?>
	                </td>
	            </tr>
	            <tr>
	                <th class="c1"><?php echo Yii::t('Product','盖机收益')?>： </th>
	                <td>
	                    <?php echo $form->textField($model, 'gt_rate', array('class'=>'inputbox width200','onblur'=>'computeReturn()'))?>%<span class="required">*</span>
                	 <span id="machine" style="width:100px;height:24px; line-height:24px;color:Red; font-weight:bold; padding:2px 5px;"></span>
					<?php echo $form->error($model,'gt_rate'); ?>
	                </td>
	            </tr>
	            <!--
	            <tr>
	                <td class="c1"><?php //echo $form->label($model, 'gw_rate')?>：</td>
	                <td>
	                	<?php //echo $form->textField($model, 'gw_rate', array('class'=>'inputbox width200','onblur'=>'computeReturn()'))?>%<span class="required">*</span>
	                	 <span id="machine" style="width:100px;height:24px; line-height:24px;color:Red; font-weight:bold; padding:2px 5px;"></span>
						<?php //echo $form->error($model,'gw_rate'); ?>
	                </td>
	            </tr>
	            -->
	            <tr>
	                <td class="c1"><?php echo Yii::t('Product','返还积分')?>：</td>
	                <td>
	                    <span id="ReturnScore" style="color:Red; font-weight:bold;">0</span>
	                </td>
	            </tr>
	            <tr>
	                <td class="c1"><?php echo Yii::t('Product','库存量')?>：</td>
	                <td>
		                <?php echo $form->textField($model, 'stock', array('class'=>'inputbox width200'))?><span class="required">*</span>
						<?php echo $form->error($model,'stock'); ?>
	                </td>
	            </tr>
	            <tr>
	                <td class="c1"><?php echo Yii::t('Product','类别')?>：</td>
	                <td>
	                	<?php //不能用id来进行判断，因为复制过来的没有id，但是其实这个内容也要复制过来?>
	                    <?php echo CHtml::textField("category",$model->biz_info_id==''?'':$model->category->name,array('id'=>'category','class'=>'inputbox','onclick'=>'showMenu()','onfocus'=>'showMenu()','readonly'=>true))?>
						<?php echo $form->hiddenField($model, 'category_id')?>&nbsp;
						<?php echo CHtml::link(Yii::t('Product','选择分类'),'javascript:showMenu()',array('class'=>'button_04'))?><span class="required">*</span>
						<?php echo $form->error($model,'category_id'); ?>
						<div id="treeContainer" class="treeContainer"><ul id="treeAdvertCls" class="ztree"></ul></div>
	                </td>
	            </tr>
	             <tr>
	                <td class="c1"><?php echo Yii::t('Product','是否可用')?>：</td>
	                <td>
	                	<?php echo $form->checkBox($model, 'use_status')?>
					<?php echo $form->error($model,'use_status'); ?>
	                </td>
	            </tr>
	            <tr class="caption">
				    <td colspan="2"><?php echo Yii::t('Product','产品信息')?></td>
			    </tr>
	            <tr>
	                <td class="c1"><?php echo Yii::t('Product','审核状态')?>：</td>
	                <td><?php echo ProductAgent::getStatus($model->status==''?ProductAgent::STATUS_0:$model->status)?></td>
	            </tr>
	            <tr>
	                <td class="c1"><?php echo Yii::t('Product','商家')?>：</td>
	                <td>
	                    <?php echo $form->hiddenField($model, 'biz_info_id')?>
						<?php echo $form->hiddenField($model, 'province_id')?>
						<?php echo $form->hiddenField($model, 'city_id')?>
						<?php echo $form->hiddenField($model, 'district_id')?>
						<?php echo $form->textField($model, 'biz_name', array('class'=>'inputbox width200', 'onclick'=>'selectBizName()', 'readonly'=>'readonly'))?>
						<?php echo CHtml::link(Yii::t('Product','选择加盟商'),'javascript:selectBizName()',array('class'=>'button_05'))?>
						<span style="color: Red">*</span>
						<?php echo $form->error($model, 'biz_name')?>
	                </td>
	            </tr>
	            <tr>
	                <td class="c1"><?php echo Yii::t('Product','排序')?>：</td>
	                <td>
	                    <?php echo $form->textField($model, 'sort', array('class'=>'inputbox width200'))?><span class="required">*</span>
						<?php echo $form->error($model,'sort'); ?>
	                </td>
	            </tr>
	            <tr>
	                <td class="c1"><?php echo Yii::t('Product','活动开始时间')?>：</td>
	                <td>
	                	<?php
							$this->widget('comext.timepicker.timepicker', array(
								'cssClass' => 'inputbox width200 datefield',
								'model' => $model,
								'id'=>'ProductAgent_activity_start_time',
								'name' => 'activity_start_time',
							));
						?>
						<span class="required">*</span>
						<?php echo $form->error($model,'activity_start_time'); ?>
	                </td>
	            </tr>
	            <tr>
	                <td class="c1"><?php echo Yii::t('Product','活动结束时间')?>：</td>
	                <td>
	                	<?php
							$this->widget('comext.timepicker.timepicker', array(
								'cssClass' => 'inputbox width200 datefield',
								'model' => $model,
								'id'=>'ProductAgent_activity_end_time',
								'name' => 'activity_end_time',
							));
						?>
						<span class="required">*</span>
						<?php echo $form->error($model,'activity_end_time'); ?>
	                </td>
	            </tr>
	            <tr class="trCoupon">
	                <td class="c1"><?php echo Yii::t('Product','封面图：（请上传145X145像素的图片）')?> </td>
	                <td>
	                	<?php $this->widget('application.modules.agent.widgets.GTUploadPic',array(
	                					'model' => $model,
	                					'form' => $form,
	                					'attribute' => 'thumbnail_id',
                						'upload_width'=>145,
                						'upload_height'=>145,
                					))
	                	?>
	                	<span class="required">*</span>
						<?php echo $form->error($model,'thumbnail_id'); ?>
	                </td>
	            </tr> 
	            <tr class="trCoupon">
	                <td class="c1"><?php echo Yii::t('Product','图片列表：（请上传425*250像素的图片）')?></td>
	                <td align="center">
	                	<?php $this->widget('application.modules.agent.widgets.GTUploadPic',array(
	                					'model' => $model,
	                					'form' => $form,
	                					'attribute' => 'image_list_id',
                						'upload_width'=>425,
                						'upload_height'=>250,
	                					'num' => 5,
                					))
	                	?>
	                	<span class="required">*</span>
						<?php echo $form->error($model,'image_list_id'); ?>
	                </td>
	            </tr>
                    <tr><td colspan="4">&nbsp;</td></tr>
	            <tr class="caption">
				    <td colspan="2"><?php echo Yii::t('Product','产品详情')?></td>
			    </tr>
	            <tr>
	                <td colspan="2" style="z-index: 0">
	                   <?php
	                	$this->widget('ext.wdueditor.WDueditor', array(
	                            'model' => $model,
	                            'attribute' => 'content',
//                				'save_path' => "attachments/".FileManage::FILE_UE_PATH,  //默认是'attachments/UE_uploads'
//                				'url' => IMG_DOMAIN.DS.FileManage::FILE_UE_PATH,	  //默认是ATTR_DOMAIN.'/UE_uploads'
	                    )); 
                    ?>
	                </td>
	            </tr>
	            <tr>
	                <td colspan="2">&nbsp;</td>
	            </tr>
	        </tbody>
	    </table>
	    <div class="align-center">
                    <input type="hidden" name="id" value="<?php echo $machine_id?>">
                     <input type="hidden" name="product_id" value="<?php echo $product_id?>">
	            <?php echo CHtml::submitButton($model->isNewRecord?Yii::t('Public','添加'):Yii::t('Public','保存'),array('class'=>'button_04'))?>&nbsp;&nbsp;&nbsp;
        		<?php echo CHtml::link(Yii::t('Public','返回'),$this->createUrl('machineAgent/productList',array('id'=>$machine_id)),array('class'=>'button_04'))?>
	    </div>
	<?php $this->endWidget();?>      
</div>    
</div>
