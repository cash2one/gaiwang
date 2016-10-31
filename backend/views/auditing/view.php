<?php $form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl($this->route,array('id'=>$model->id)),
			'method'=>'post',
			'id' => 'auditing-form',
			'enableAjaxValidation'=>true,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                    ),
		)); ?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
            <caption class=" title-th">
                <?php echo Yii::t('auditing', '加盟商信息')?>
            </caption>
<?php if($model->apply_type != Auditing::APPLY_TYPE_BIZ_BASE):?>
			<tr>
                    <th>
                        <?php echo $form->label($model, 'apply_name')?>：
                    </th>
                    <td>
                        <?php echo $form->textField($model,'apply_name',array('class'=>'text-input-bj  middle')); ?>
						<?php echo $form->error($model,'apply_name'); ?>
                    </td>
           </tr>
           <tr>
                    <td align="right"><?php echo $form->label($model,'parent_id'); ?>：</td>
                    <td align="left" class="table_form_right">
						<?php echo $form->hiddenField($model,'parent_id',array('class'=>'input_box','readonly'=>true)); ?>
						<?php echo $form->textField($model,'parentname',array('id'=>'biz_name','class'=>'text-input-bj  middle','readonly'=>true)); ?>
						<?php
		                echo CHtml::button(Yii::t('auditing', '选择'), array('class' => 'reg-sub', 'id' => 'SetBizPMember'));
		                ?>
		                <?php
		                echo CHtml::button(Yii::t('auditing', '清除'), array('class' => 'reg-sub', 'readonly' => true, 'id' => 'ReSetBizPMember'));
		                ?>
		                <?php echo $form->error($model,'parent_id'); ?>
		                <script>
		                	$("#ReSetBizPMember").click(function(){
								$("#Auditing_parent_id").val('');
								$("#Auditing_parent_id").val('');
		                    });
		                </script>
                    </td>
           </tr>

          <tr>
                    <th>
                        <?php echo $form->label($model, 'alias_name')?>：
                    </th>
                    <td>
                        <?php echo $form->textField($model,'alias_name',array('class'=>'text-input-bj  middle')); ?><span style="color: Red">* </span>
						<?php echo $form->error($model,'alias_name'); ?>
                    </td>
          </tr>
          <tr>
                    <th>
                        <?php echo $form->label($model, 'member_id')?>：
                    </th>
                    <td>
                        <?php echo $form->textField($model,'member_id',array('class'=>'text-input-bj middle')); ?><span style="color: Red">* </span>
						<?php echo $form->error($model,'member_id'); ?>
                    </td>
          </tr>
          <tr>
                    <th>
                        <?php echo $form->label($model,'max_machine');?>
                    </th>
                    <td>
                        <?php echo $form->textField($model,'max_machine',array('class'=>'text-input-bj least')); ?>
						<?php echo $form->error($model,'max_machine'); ?>
                    </td>
          </tr>
          <tr>
                    <th>
                        <?php echo $form->label($model, 'gai_discount')?>：
                    </th>
                    <td>
                        <?php echo $form->textField($model,'gai_discount',array('class'=>'text-input-bj least')); ?>%<span style="color: Red">*请输入0-100 </span>
						<?php echo $form->error($model,'gai_discount'); ?>
                    </td>
          </tr>
          <tr>
                    <th>
                        <?php echo $form->label($model, 'member_discount')?>：
                    </th>
                    <td>
                        <?php echo $form->textField($model,'member_discount',array('class'=>'text-input-bj least')); ?>%<span style="color: Red">*请输入0-100 </span>
						<?php echo $form->error($model,'member_discount'); ?>
                    </td>
          </tr>
<?php endif;?>
<?php if($model->apply_type != Auditing::APPLY_TYPE_BIZ_GUANJIAN):?>
			<tr>
                <th style="width: 120px">
                    <?php echo Yii::t('auditing', '地区')?>：
                </th>
                <td>
                    <?php
                        echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                            'class' => 'input_box2 mt5 dib fl',
                            'prompt' => Yii::t('member', '选择省份'),
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/region/updateCity'),
                                'dataType' => 'json',
                                'data' => array(
                                    'province_id' => 'js:this.value',
                                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                ),
                                'success' => 'function(data) {
                                            $("#Auditing_city_id").html(data.dropDownCities);
                                            $("#Auditing_district_id").html(data.dropDownCounties);
                                        }',
                            )));
                        ?>
                        <?php echo $form->error($model, 'province_id'); ?>
                        <?php
                        echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                            'class' => 'input_box2 mt5 dib fl',
                            'prompt' => Yii::t('member', '选择城市'),
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/region/updateArea'),
                                'update' => '#Auditing_district_id',
                                'data' => array(
                                    'city_id' => 'js:this.value',
                                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                ),
                            )));
                        ?>
                        <?php echo $form->error($model, 'city_id'); ?>
                        <?php
                        echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                            'class' => 'input_box2 mt5 dib fl',
                            'prompt' => Yii::t('member', '选择地区'),
                            'ajax' => array(
                                'type' => 'POST',
                                'data' => array(
                                    'city_id' => 'js:this.value',
                                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                ),
                            )));
                        ?>
                        <?php echo $form->error($model, 'district_id'); ?>
                                <span style="color: Red">* </span>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo Yii::t('auditing', '地址')?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'street',array('class'=>'text-input-bj  middle')); ?><span style="color: Red">* </span>
					<?php echo $form->error($model,'street'); ?>
                </td>
            </tr>
            <tr>
                <th>
                    经纬度：
                </th>
                <td>
                	<?php echo $form->labelEx($model, 'lng'); ?>
	                <?php echo $form->textField($model, 'lng', array('class' => 'text-input-bj  middle')); ?>
	                <?php echo $form->error($model, 'lng'); ?>
                    <?php echo $form->labelEx($model, 'lat'); ?>
	                <?php echo $form->textField($model, 'lat', array('class' => 'text-input-bj  middle')); ?>
	                <?php echo $form->error($model, 'lat'); ?>
	                <?php echo CHtml::button('选择经纬度', array('class' => 'regm-sub', 'onclick' => 'mark_click()')); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->label($model,'summary'); ?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'summary',array('class'=>'text-input-bj  longest','size'=>150)); ?><span style="color: Red">* </span>
					<?php echo $form->error($model,'summary'); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->label($model,'main_course'); ?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'main_course',array('class'=>'text-input-bj  middle')); ?>
					<?php echo $form->error($model,'main_course'); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->label($model,'category_id'); //行业?>：
                </th>
                <td>
                    <?php echo $form->dropDownList($model, 'category_id', CHtml::listData(FranchiseeCategory::model()->findAll(), 'id', 'name'), array('class' => 'text-input-bj'));?><span style="color: Red">* </span>
					<?php echo $form->error($model,'category_id'); ?>
                </td>
            </tr>
            <tr>
                <th>
                    商家Logo：
                </th>
                <td>
                	 <?php 
            		$this->widget('common.widgets.CUploadPic',array(
            			'form' => $form,
            			'model' => $model,
            			'attribute' => 'logo',
            			'upload_width' => 125,
            			'upload_height' => 65,
            			'folder_name' => 'franchisee',
            			'isdate' => 0,
//            			'img_area' => 2,
            			'btn_class' => 'regm-sub',
            			'btn_value' => '设置LOGO',
            		));
            		?>
            		请上传126*65像素的图片
                </td>
            </tr>
            <tr>
                <th>
                    图片列表：
                </th>
                <td>
                    <?php 
            		$this->widget('common.widgets.CUploadPic',array(
            			'form' => $form,
            			'model' => $model,
            			'attribute' => 'path',
            			'upload_width' => 730,
            			'upload_height' => 280,
            			'num' => 5,
            			'folder_name' => 'files',
            			'btn_class' => 'regm-sub',
            			'btn_value' => Yii::t('franchisee','设置列表图片'),
            		));
            		?>
            		<?php echo Yii::t('franchisee','请上传730*280像素的图片');?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->label($model,'mobile'); ?>：
                </th>
                <td class=""even"">
                    <?php echo $form->textField($model,'mobile',array('class'=>'text-input-bj  middle')); ?><span style="color: Red">* </span>
					<?php echo $form->error($model,'mobile'); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->label($model,'qq'); ?>：
                </th>
                <td>
                    <?php echo $form->textArea($model,'qq',array('rows'=>3,'cols'=>15,'class'=>'text-input-bj long')); ?>以逗号分隔，如30994,349850,93802385
					<?php echo $form->error($model,'qq'); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->label($model,'url'); ?>：
                </th>
                <td class=""even"">
                    <?php echo $form->textField($model,'url',array('class'=>'text-input-bj  middle')); ?>
					<?php echo $form->error($model,'url'); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->label($model,'keywords'); ?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'keywords',array('class'=>'text-input-bj  middle')); ?>
								<?php echo $form->error($model,'keywords'); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->label($model,'fax'); ?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'fax',array('class'=>'text-input-bj  middle')); ?>
					<?php echo $form->error($model,'fax'); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->label($model,'zip_code'); ?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'zip_code',array('class'=>'text-input-bj  middle')); ?>
					<?php echo $form->error($model,'zip_code'); ?>
                </td>
            </tr>
            <tr>
                <th>
                   <?php echo $form->label($model,'notice'); ?>：
                </th>
                <td>
                    <?php echo $form->textArea($model,'notice',array('rows'=>3, 'cols'=>120, 'class'=>'text-input-bj  text-area')); ?>
					<?php echo $form->error($model,'notice'); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->label($model,'description'); // 商家介绍?>：
                </th>
                <td>
                    <?php
			            $this->widget('comext.wdueditor.WDueditor', array(
	                		'width' => '90%',
			                'model' => $model,
			                'attribute' => 'description',
			            ));
			        ?>
	            	<?php echo $form->error($model, 'description'); ?>
                </td>
            </tr>
<?php endif;?>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
            <caption class=" title-th">
                <?php echo Yii::t('auditing', '审核信息')?>
            </caption>
			<tr>
                <th style="width: 120px">
                    <?php echo $form->label($model,'author_name')?>：
                </th>
                <td>
                	<?php echo $model->author_name?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->label($model,'author_type')?>：
                </th>
                <td>
                	<?php echo Auditing::getAuthorType($model->author_type)?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->label($model,'submit_time')?>：
                </th>
                <td>
					<?php echo date('Y-m-d H:i:s',$model->submit_time)?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->label($model,'audit_opinion')?>：
                </th>
                <td>
                    <?php echo $form->textArea($model,'audit_opinion',array('rows'=>2, 'cols'=>120, 'class'=>'text-input-bj  text-area', 'value'=>'')); ?>
					<?php echo $form->error($model,'audit_opinion'); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                	<?php echo $form->hiddenField($model, 'id');?>
                    <?php echo $form->hiddenField($model, 'status');?>
                    <?php echo CHtml::submitButton("修改后通过",array('class'=>'regm-sub', 'onclick'=>'return mySubmit('.Auditing::STATUS_PASS.')'))?>
                     <?php echo CHtml::submitButton("不通过",array('class'=>'regm-sub', 'onclick'=>'return mySubmit('.Auditing::STATUS_NOPASS.')'))?>
                </td>
            </tr>
</table>
<?php $this->endWidget(); ?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<script type="text/javascript" language="javascript">
var mark_click = function() {
	var url = 'baidumap.php';
	url += '?lng=' + $('#Franchisee_lng').val() + '&lat=' + $('#Franchisee_lat').val();
	dialog = art.dialog.open(url, {
		'title': '设定经纬度',
		'lock': true,
		'window': 'top',
		'width': 740,
		'height': 600,
		'border': true
	});
};

var onSelected = function(lat, lng) {
	$('#Franchisee_lng').val(lng);
	$('#Franchisee_lat').val(lat);
};

var doClose = function() {
	if (null != dialog) {
		dialog.close();
	}
};
function mySubmit(status)
{
	$("#Auditing_status").val(status);
	$("#auditing-form").submit();
}
</script>
<?php
Yii::app()->clientScript->registerScript('categoryTree', "
var dialog = null;
jQuery(function($) {
    //搜索父加盟商
    $('#SetBizPMember').click(function() {
        dialog = art.dialog.open('" . $this->createUrl('/franchisee/getParentFranchisee') . "', {'id': 'selectmember', title: '搜索父加盟商', width: '800px', height: '620px', lock: true});
    })
    $('#SetRefMember').click(function() {
        dialog = art.dialog.open('" . $this->createUrl('/member/getUser') . "', { 'id': 'selectmember', title: '搜索会员', width: '800px', height: '620px', lock: true });
    })
})

var onSelectBizPMember = function(pid) {
    if (pid) {
        $.ajax({
            cache:false,
            dataType: 'json',
            url:'" . $this->createUrl('/franchisee/getParentName') . "&id='+pid+'&YII_CSRF_TOKEN=" . Yii::app()->request->csrfToken . "',
            success:function(name){
                $('#Auditing_parent_id').val(pid);
                $('#biz_name').val(name);
            }
        })
    }
};
var onSelectMemeber = function (uid) {  
    if (uid) {
        $.ajax({
            cache:false,
            dataType: 'json',
            url:'" . $this->createUrl('/member/getUserName') . "&id='+uid+'&YII_CSRF_TOKEN=" . Yii::app()->request->csrfToken . "',
            success:function(name){
                $('#Franchisee_member_id').val(uid);
                $('#memberName').val(name);
            }
        })
    }
};
", CClientScript::POS_HEAD);
?>