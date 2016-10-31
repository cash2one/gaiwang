<?php 
	$cs = Yii::app()->clientScript;
	$baseUrl = AGENT_DOMAIN.'/agent';
	$cs->registerCssFile($baseUrl. "/css/machine.css?v=1");
	$cs->registerCssFile($baseUrl. "/js/fancybox/jquery.fancybox-1.3.4.css"); 
	$cs->registerScriptFile($baseUrl. "/js/fancybox/jquery.fancybox-1.3.4.pack.js", CClientScript::POS_END);	
	
	$cs->registerScriptFile($baseUrl. "/js/jquery.artDialog.js?skin=blue");			//弹出框JS插件
	$cs->registerScriptFile($baseUrl. "/js/artDialog.iframeTools.js");				//弹出框调用远程文件插件
	$cs->registerScriptFile($baseUrl. "/js/uploadImg.js");							//上传插件
        
        $cs->registerScriptFile($baseUrl. "/js/My97DatePicker/WdatePicker.js");			//日期插件
?>
<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/js/zTree/css/zTreeStyle.css" /> 
<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/zTree/jquery.ztree.core-3.5.js" ></script> 
<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/zTree/jquery.ztree.excheck-3.5.js" ></script>

<script type="text/javascript">
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

var zNodes = <?php echo $advertTypeData?>;
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
	var clsIdObj = $('#MachineAdvertAgent_category_id');	//获取保存ID的文本控件
	clsIdObj.attr("value",nodes[0].id);	//赋值
}

//显示zTree
function showMenu() {
    var clsObj = $("#category");
    var cityOffset = $("#category").offset();
//    $("#treeContainer").css({ left: cityOffset.left + "px", top: "0px" }).slideToggle("fast");
    $("#treeContainer").css({left:cityOffset.left + "px", top:cityOffset.top + clsObj.outerHeight() + "px"}).slideDown("fast");

    $("body").bind("mousedown", onBodyDown);
}

//关闭ztree的div
function hideMenu() {
    $("#treeContainer").fadeOut("fast");
    $("body").unbind("mousedown", onBodyDown);
}

//窗体点击事件
function onBodyDown(event) {
    if (!(event.target.id == "menuBtn" || event.target.id == "category" || event.target.id == "treeContainer" || $(event.target).parents("#treeContainer").length > 0)) {
        hideMenu();
    }
}
</script>
<div class="ctx">
    <div class="optPanel">
        <div class="toolbar img01">
			<?php 
				switch ($adtype){
					case MachineAdvertAgent::ADVERT_TYPE_COUPON:
						$title = Yii::t('Machine','格子铺');
						break;
					case MachineAdvertAgent::ADVERT_TYPE_SIGN:
						$title = Yii::t('Machine','首页轮播');
						break;
				}
				echo $model->isNewRecord?Yii::t('Public','添加').$title:Yii::t('Public','编辑').$title;
			?>
	        <?php echo CHtml::link(Yii::t('Public','返回'),$this->createUrl('machineAdvertAgent/index',array('adtype'=>$adtype)),array('class'=>'button_05 floatRight'))?>
        </div>
    </div>
    <div class="ctxTable">
        <img id="imgSource" alt="原图" src="" style="display:none;position:absolute;" />
        <?php 
        	Yii::app()->clientScript->registerScript('search', "
			$('#machine-advert-form').submit(function(){
		        $('#thumbnail_id').val($('".  FileManageAgent::VALUE_NAME."thumbnail_id').val());
		        $('#file_id').val($('".  FileManageAgent::VALUE_NAME."file_id').val());
				return true;
			});
			");
			$form=$this->beginWidget('CActiveForm', array(
				'id'=>'machineAdvertAgent-form',
				'enableAjaxValidation'=>true,
				'enableClientValidation'=>true,
			)); 
		?>
		<table width="100%" border="0" cellspacing="1" cellpadding="0" class="inputTable">
			<tbody>
			<tr class="caption">
				<td colspan="2"><?php echo Yii::t('Machine','基本信息')?></td>
		   	</tr>
			<tr>
				<td class="c1 width200"><?php echo $form->label($model, 'title')?>：</td>
				<td>
					<?php echo $form->textField($model, 'title', array('class'=>'inputbox  width200'))?><span class="required">*</span>
					<?php echo $form->error($model,'title'); ?>
				</td>
			</tr>
            <tr>
                <td class="c1"><?php echo $form->label($model, 'description')?>：</td>
                <td>
                	<?php echo $form->textArea($model, 'description', array('class'=>'inputarea width400','rows'=>3,'cols'=>2))?><span class="required">*</span>
					<?php echo $form->error($model,'description'); ?>
                </td>
            </tr> 
            <?php if ($adtype==  MachineAdvertAgent::ADVERT_TYPE_COUPON){//分类，只有优惠劵使用?>
            <tr>
                <td class="c1"><?php echo $form->label($model, 'category_id')?>：</td>
                <td>
					<?php echo CHtml::textField("category",$model->isNewRecord?'':$model->category->name,array('id'=>'category','class'=>'inputbox','onclick'=>'showMenu()','onfocus'=>'showMenu()','readonly'=>true))?>
					<?php echo $form->hiddenField($model, 'category_id')?>&nbsp;
					<?php echo CHtml::link(Yii::t('Public','选择分类'),'javascript:showMenu()',array('class'=>'button_04'))?><span class="required">*</span>
					<?php echo $form->error($model,'category_id'); ?>
					<div id="treeContainer" class="treeContainer"><ul id="treeAdvertCls" class="ztree"></ul></div>
                </td>
            </tr>
            
            <tr id="tr_price">
                <td class="c1"><?php echo $form->label($model, 'price')?>：</td>
                <td>
                	<?php echo $form->textField($model, 'price', array('class'=>'inputbox'))?>
                	<?php echo $form->error($model,'price'); ?><span class="required">*</span>
                </td>
            </tr>
            
            <?php }?>
            <tr>
                <td class="c1"><?php echo $form->label($model, 'use_status')?>：</td>
                <td>
                	<?php echo $form->checkBox($model, 'use_status')?>
					<?php echo $form->error($model,'use_status'); ?>
                </td>
            </tr>
            <tr>
                <td class="c1"><?php echo $form->label($model, 'sort')?>：</td>
                <td>
                	<?php echo $form->textField($model, 'sort', array('class'=>'inputbox width200'))?><span class="required"> *</span>
					<?php echo $form->error($model,'sort'); ?>
                </td>
            </tr>
            <tr>
                <td class="c1"><?php echo $form->label($model, 'svc_start_time')?>：</td>
                <td>
                     <?php
                        $this->widget('comext.timepicker.timepicker', array(
                            'cssClass' => 'inputbox width200 datefield',
                            'model' => $model,
                            'id'=>'MachineAdvertAgent_svc_start_time',
                            'name' => 'svc_start_time',
                        ));
                        ?>
		<span class="required">*</span><?php echo $form->error($model,'svc_start_time'); ?>
                </td>
            </tr>
            <tr>
                <td class="c1"><?php echo $form->label($model, 'svc_end_time')?>：</td>
                <td>
                    <?php
                        $this->widget('comext.timepicker.timepicker', array(
                            'cssClass' => 'inputbox width200 datefield',
                            'model' => $model,
                            'id'=>'MachineAdvertAgent_svc_end_time',
                            'name' => 'svc_end_time',
                        ));
                        ?>
		<span class="required">*</span><?php echo $form->error($model,'svc_end_time'); ?>
                </td>
            </tr>
            <?php if($adtype!=  MachineAdvertAgent::ADVERT_TYPE_VEDIO){//非视频?>
            <tr>
                <td class="c1"> <?php echo $form->label($model, 'display_count')?>：</td>
                <td><?php echo $model->display_count?></td>
            </tr>
            <?php }?>
		    <?php if ($adtype==  MachineAdvertAgent::ADVERT_TYPE_SIGN|$adtype==MachineAdvertAgent::ADVERT_TYPE_VOTE){//首页轮播(投票系统首页轮播)?>
		    <tr class="caption">
			    <td colspan="2"><?php echo Yii::t('Advert','广告信息')?></td>
		    </tr>
		    <tr id="trSignPage">
                <td class="c1"><?php echo $form->label($model,'ad_img')?>：</td>
                <td>
	                	<?php $this->widget('application.modules.agent.widgets.GTUploadPic',array(
	                					'model' => $model,
	                					'form' => $form,
	                					'attribute' => 'file_id',
                						'upload_width'=>1080,
                						'upload_height'=>141,
                                                                'classify'=>  FileManageAgent::FILETYPE_AD,
                					))
	                	?>
                                <span class="required">*</span><?php echo Yii::t('Advert','请上传1080X141像素的图片')?><?php echo $form->error($model,'file_id');?>
                </td> 
            </tr>
            <tr>
                <td class="c1"><?php echo $form->label($model, 'address')?> ：
                </td>
                <td>
                    <?php
		            echo $form->dropDownList($model, 'province_id', RegionAgent::getRegionByParentId($this->getSession('agent_region')), array(
		                'prompt' => Yii::t('Public','选择省份'),
		                'ajax' => array(
		                    'type' => 'POST',
		                    'url' => $this->createUrl('region/getRegionByParentId'),
		                    'dataType' => 'json',
		                    'data' => array(
		                        'pid' => 'js:this.value',
		            			'type' => 'province',
		                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
		                    ),
		                    'success' => 'function(data) {
		                            $("#MachineAdvertAgent_city_id").html(data.dropDownCities);
		                            $("#MachineAdvertAgent_district_id").html(data.dropDownCounties);
		                        }',
		            )));
					?>
		            <?php 
//		            $city_data = ($model->province_id)?CHtml::listData(Region::model()->findAll("parent_id=:pid", array(':pid' => $model->province_id)), 'id', 'name'):array();
		            echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
	                    'prompt' => Yii::t('Public','选择城市'),
	                    'ajax' => array(
	                        'type' => 'POST',
	                        'url' => $this->createUrl('region/getRegionByParentId'),
	                        'update' => '#MachineAdvertAgent_district_id',
	                        'data' => array(
	                            'pid' => 'js:this.value',
		            			'type' => 'city',
	                            Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
	                        ),
	                )));
		            ?>
		            <?php 
//		            $district_data = ($model->city_id)?CHtml::listData(Region::model()->findAll("parent_id=:pid", array(':pid' => $model->city_id)), 'id', 'name'):array();
		            echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
	                    'prompt' => Yii::t('Public','选择区/县'),
	                    ));
		            ?>
		            <span class="required">*</span>
		            <?php echo $form->error($model,'province_id');?>
		            <?php echo $form->error($model,'city_id');?>
		            <?php echo $form->error($model,'district_id');?>
                </td>
            </tr>
		    <?php }?>
		    <?php if ($adtype==MachineAdvertAgent::ADVERT_TYPE_COUPON){//优惠劵?>
		    <tr class="caption">
			    <td colspan="2"><?php echo Yii::t('Advert','广告信息')?></td>
		    </tr>
            <tr class="trCoupon">
                <td class="c1"> <?php echo $form->label($model, 'thumbnail_id')?>：</td>
                <td>
                    <?php $this->widget('application.modules.agent.widgets.GTUploadPic',array(
	                					'model' => $model,
	                					'form' => $form,
	                					'attribute' => 'thumbnail_id',
                						'upload_width'=>220,
                						'upload_height'=>220,
                                                                'classify'=>  FileManageAgent::FILETYPE_AD,
                					))
	                	?>
                	<span class="required">*</span><?php echo Yii::t('Advert','请上传220X220像素的图片')?>
					<?php echo $form->error($model,'thumbnail_id'); ?>
                </td>
            </tr>
            <tr class="trCoupon">
                <td class="c1"><?php echo $form->label($model, 'file_id')?>：</td>
                <td>
                    <?php $this->widget('application.modules.agent.widgets.GTUploadPic',array(
	                					'model' => $model,
	                					'form' => $form,
	                					'attribute' => 'file_id',
                						'upload_width'=>1920,
                						'upload_height'=>960,
                                                                'classify'=>  FileManageAgent::FILETYPE_AD,
                					))
	                	?>
                	<span class="required"></span><?php echo Yii::t('Advert','请上传1920X960像素的图片')?>
					<?php echo $form->error($model,'file_id'); ?>
                </td>
            </tr>
            <tr class="caption trCoupon">
			    <td colspan="2"><?php echo Yii::t('Advert','短信发送信息')?></td>
		    </tr>
            <tr class="trCoupon">
                <td class="c1"><?php echo $form->label($model, 'coupon_name')?>：</td>
                <td>
                	<?php echo $form->textField($model, 'coupon_name',array('class'=>'inputbox width200'))?>
					<?php echo $form->error($model,'coupon_name'); ?>
                </td>
            </tr>
            <tr>
                <td class="c1"><?php echo $form->label($model, 'coupon_address')?> ：
                </td>
                <td>
                    <?php
		            echo $form->dropDownList($model, 'province_id', RegionAgent::getRegionByParentId($this->getSession('agent_region')), array(
		                'prompt' => Yii::t('Public','选择省份'),
		                'ajax' => array(
		                    'type' => 'POST',
		                    'url' => $this->createUrl('region/getRegionByParentId'),
		                    'dataType' => 'json',
		                    'data' => array(
		                        'pid' => 'js:this.value',
		            			'type' => 'province',
		                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
		                    ),
		                    'success' => 'function(data) {
		                            $("#MachineAdvertAgent_city_id").html(data.dropDownCities);
		                            $("#MachineAdvertAgent_district_id").html(data.dropDownCounties);
		                        }',
		            )));
					?>
		            <?php 
//		            $city_data = ($model->province_id)?CHtml::listData(Region::model()->findAll("parent_id=:pid", array(':pid' => $model->province_id)), 'id', 'name'):array();
		            echo $form->dropDownList($model, 'city_id',  Region::getRegionByParentId($model->province_id), array(
	                    'prompt' => Yii::t('Public','选择城市'),
	                    'ajax' => array(
	                        'type' => 'POST',
	                        'url' => $this->createUrl('region/getRegionByParentId'),
	                        'update' => '#MachineAdvertAgent_district_id',
	                        'data' => array(
	                            'pid' => 'js:this.value',
		            			'type' => 'city',
	                            Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
	                        ),
	                )));
		            ?>
		            <?php 
//		            $district_data = ($model->city_id)?CHtml::listData(Region::model()->findAll("parent_id=:pid", array(':pid' => $model->city_id)), 'id', 'name'):array();
		            echo $form->dropDownList($model, 'district_id',  Region::getRegionByParentId($model->city_id), array(
	                    'prompt' => Yii::t('Public','选择区/县'),
	                    ));
		            ?>
		            
		            <?php echo $form->error($model,'province_id');?>
		            <?php echo $form->error($model,'city_id');?>
		            <?php echo $form->error($model,'district_id');?>
                </td>
            </tr>
            <tr class="trCoupon">
                <td class="c1"><?php echo Yii::t('Public','经纬度')?> <?php //echo $form->label($model, 'loc_lng')?>：</td>
                <td>
                        <?php 
                        $this->widget('application.modules.agent.widgets.CBDMap',array(
                            'useClass'=>'inputbox width200',
                            'form'=>$form,
                            'model'=>$model,
                            'attr_lng'=>'loc_lng',
                            'attr_lat'=>'loc_lat',
                            'type'=>'use',
                            ))
                         ?>
                	
                </td>
            </tr>

            <tr class="trCoupon">
                <td class="c1"><?php echo $form->label($model, 'coupon_message')?>：</td>
                <td>
                	<?php echo $form->textArea($model, 'coupon_message',array('class'=>'inputarea width400','cols'=>2,'rows'=>3))?>
                	<?php echo $form->error($model,'coupon_message'); ?>
                </td>
            </tr>
            <tr class="trCoupon">
                <td class="c1"><?php echo $form->label($model, 'coupon_start_time')?>：</td>
                <td>
                    <?php
                        $this->widget('comext.timepicker.timepicker', array(
                            'cssClass' => 'inputbox width200 datefield',
                            'model' => $model,
                            'id'=>'MachineAdvertAgent_coupon_start_time',
                            'name' => 'coupon_start_time',
                        ));
                        ?>
                	<?php echo $form->error($model,'coupon_start_time'); ?>
                </td>
            </tr>
            <tr class="trCoupon">
                <td class="c1"><?php echo $form->label($model, 'coupon_end_time')?>：</td>
                <td>
                    <?php
                        $this->widget('comext.timepicker.timepicker', array(
                            'cssClass' => 'inputbox width200 datefield',
                            'model' => $model,
                            'id'=>'MachineAdvertAgent_coupon_end_time',
                            'name' => 'coupon_end_time',
                        ));
                        ?>
                	<?php echo $form->error($model,'coupon_end_time'); ?>
                </td>
            </tr>
            <tr class="trCoupon">
                <td class="c1"><?php echo $form->label($model, 'coupon_quantity')?>：</td>
                <td>
                	<?php echo $form->textField($model, 'coupon_quantity', array('class'=>'inputbox'))?>
                	<?php echo $form->error($model,'coupon_quantity'); ?>
                </td>
            </tr>
            <tr class="trCoupon">
                <td class="c1"><?php echo $form->label($model, 'coupon_use_count')?>：</td>
                <td><?php echo $model->coupon_use_count?></td>
            </tr>
            <?php }?>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
        </tbody>
    </table>
    <div class="align-center">
    	<?php echo CHtml::submitButton($model->isNewRecord?Yii::t('Public','添加'):Yii::t('Public','保存'),array('class'=>'button_04'))?>&nbsp;&nbsp;&nbsp;
        <?php echo CHtml::link(Yii::t('Public','返回'),$this->createUrl('machineAdvertAgent/index',array('adtype'=>$adtype)),array('class'=>'button_04'))?>
    </div>
<?php $this->endWidget();?>   
</div>
</div>