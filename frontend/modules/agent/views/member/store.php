<div class="line container_fluid">
    <div class="row_fluid line">
        <div class="vip_title red">
            <p class="unit fl"><?php echo $model->isNewRecord?Yii::t('Member','申请添加企业会员'):Yii::t('Member','申请编辑企业会员')?></p>
            <?php echo CHtml::link(Yii::t('Public','返回列表'),$this->createUrl('member/applyList'),array('class'=>'fr mr10 return')) ?>
        </div>
        <div class="line table_white">
            <?php 
                $form = $this->beginWidget('CActiveForm',array(
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'id' => 'member-form',
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                ));
            ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table5">
                <tr class="table1_title">
                    <td colspan="2">
                        <div class="red"><?php echo Yii::t('Member','审核信息')?></div>
                    </td>
                </tr>
                <tr>
                    <td width="12%" align="right"><?php echo Yii::t('Member','申请状态')?>：</td>
                    <td width="88%" align="left" class="table_form_right"><?php echo $new_model->isNewRecord?Yii::t('Public','编辑中'):Auditing::getStatus($new_model->status)?></td>
                </tr>
                <tr>
                    <td align="right"><?php echo Yii::t('Member','审核意见')?>：</td>
                    <td align="left" class="table_form_right">
                    	<?php echo $new_model->audit_opinion?>
                    </td>
                </tr>
                <tr class="table1_title">
                    <td colspan="2">
                            <div class="red"><?php echo Yii::t('Member','企业信息')?></div>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo Yii::t('Member','主账户')?>：</td>
                    <td align="left" class="table_form_right">
                        <?php echo $form->checkBox($model,'is_master_account',array('checked'=>true))?><?php echo Yii::t('Member','设定为主账户')?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'name')?>：</td>
                    <td align="left" class="table_form_right">
                        <?php echo $form->textField($model,'username',array('class'=>'input_box'))?><p style="color: Red" class="fl">*</p>
                        <?php echo $form->error($model,'username')?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'short_name')?>：</td>
                    <td align="left" class="table_form_right">
                        <?php echo $form->textField($infoModel,'short_name',array('class'=>'input_box'))?><p style="color: Red" class="fl">*</p>
                        <?php echo $form->error($infoModel,'short_name')?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'category_id'); ?>：</td>
                    <td align="left" class="table_form_right">
                        <?php echo $form->dropDownList($infoModel,'category_id',CHtml::listData(StoreCategory::model()->findAll(),'id','name'),array('class'=>'input_box2 mt5')); ?><p style="color: Red" class="fl">*</p>
                        <?php echo $form->error($infoModel,'category_id') ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'license'); ?>：</td>
                    <td align="left" class="table_form_right">
                        <?php echo $form->textField($infoModel,'license',array('class'=>'input_box')); ?><p style="color: Red" class="fl">*</p>
                        <?php echo $form->error($infoModel,'license') ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'license_photo'); ?>：</td>
                    <td align="left" class="table_form_right">
                            <?php 
				            		$this->widget('application.widgets.GWUploadPic',array(
				            			'form' => $form,
				            			'model' => $infoModel,
				            			'attribute' => 'license_photo',
				            			'upload_width' => 500,
				            			'upload_height' => 500,
				            			'folder_name' => 'license_photo/patentcodephoto',
				            			'btn_class' => 'btn1 btn_large13 fl',
				            			'btn_value' => Yii::t('Member','上传执照'),
				            			'img_area' => 2,
				            			'demo' => '<p class="unit tips tips_icon1">' .Yii::t('Member','请上传500x500像素的图片').'</p>',
				            		));
				            	?>
                            <?php echo $form->error($infoModel,'license_photo') ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo Yii::t('Member','公司所在地区'); ?>：</td>
                    <td align="left" class="table_form_right">
                        <?php
                        echo $form->dropDownList($infoModel, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                            'class' => 'input_box2 mt5 dib fl',
                            'prompt' => Yii::t('Public', '选择省份'),
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/region/updateCity'),
                                'dataType' => 'json',
                                'data' => array(
                                    'province_id' => 'js:this.value',
                                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                ),
                                'success' => 'function(data) {
                                            $("#EnterpriseAgent_city_id").html(data.dropDownCities);
                                            $("#EnterpriseAgent_district_id").html(data.dropDownCounties);
                                        }',
                            )));
                        ?>
                        <?php echo $form->error($infoModel, 'province_id'); ?>
                        <p class="fl"><?php echo Yii::t('Public','省')?></p>
                        <?php
                        echo $form->dropDownList($infoModel, 'city_id', Region::getRegionByParentId($infoModel->province_id), array(
                            'class' => 'input_box2 mt5 dib fl',
                            'prompt' => Yii::t('Public', '选择城市'),
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/region/updateArea'),
                                'update' => '#EnterpriseAgent_district_id',
                                'data' => array(
                                    'city_id' => 'js:this.value',
                                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                ),
                            )));
                        ?>
                        <p class="fl"><?php echo Yii::t('Public','市')?></p>
                        <?php echo $form->error($infoModel, 'city_id'); ?>
                        <?php
                        echo $form->dropDownList($infoModel, 'district_id', Region::getRegionByParentId($infoModel->city_id), array(
                            'class' => 'input_box2 mt5 dib fl',
                            'prompt' => Yii::t('Public', '选择地区'),
                            'ajax' => array(
                                'type' => 'POST',
                                'data' => array(
                                    'city_id' => 'js:this.value',
                                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                ),
                            )));
                        ?>
                        <p class="fl"><?php echo Yii::t('Public','区')?></p>
                        <?php echo $form->error($infoModel, 'district_id'); ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'street'); ?>：</td>
                    <td align="left" class="table_form_right">
                        <?php echo $form->textField($infoModel,'street',array('class'=>'input_box')); ?><p style="color: Red" class="fl">*</p>
                        <?php echo $form->error($infoModel,'street') ?>
                    </td>
                </tr>
                <tr class="table1_title">
                    <td colspan="3">
                        <div class="red"><?php echo Yii::t('Member','联系人信息'); ?></div>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'link_man'); ?>：</td>
                    <td align="left" class="table_form_right">
                        <?php echo $form->textField($infoModel,'link_man',array('class'=>'input_box')); ?><p style="color: Red" class="fl">*</p>
                        <?php echo $form->error($infoModel,'link_man') ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'department'); ?>：</td>
                    <td align="left" class="table_form_right">
                        <?php echo $form->dropDownList($infoModel,'department',$infoModel::departmentArr(),array(
                            'class' => 'input_box2 mt5 dib fl',
                            'empty'=>Yii::t('Public','请选择'),
                        )) ?><p style="color: Red" class="fl">*</p>
                        <?php echo $form->error($infoModel,'department') ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'mobile'); ?>：</td>
                    <td align="left" class="table_form_right">
                        <?php echo $form->textField($model,'mobile',array('class'=>'input_box')); ?><p style="color: Red" class="fl">*</p>
                        <?php echo $form->error($model,'mobile') ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'email'); ?></td>
                    <td align="left" class="table_form_right">
                        <?php echo $form->textField($infoModel,'email',array('class'=>'input_box')); ?>
                        <?php echo $form->error($infoModel,'email') ?>
                    </td>
                </tr>
                <tr class="table1_title">
                    <td colspan="3">
                        <div class="red"><?php echo Yii::t('member','服务时间信息'); ?></div>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'service_start_time'); ?>：</td>
                    <td align="left" class="table_form_right">
                        <?php
                        if(!empty($infoModel->service_start_time)) $infoModel->service_start_time = date('Y-m-d H:i:s',$infoModel->service_start_time);
                        $this->widget('comext.timepicker.timepicker', array(
                            'cssClass' => 'input_box',
                            'model' => $infoModel,
                            'id'=>'Enterprise_service_start_time',
                            'name' => 'service_start_time',
                        ));
                        ?><p style="color: Red" class="fl">*</p>
                        <?php echo $form->error($infoModel,'service_start_time') ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'service_end_time'); ?>：</td>
                    <td align="left" class="table_form_right">
                        <?php
                        if(!empty($infoModel->service_end_time)) $infoModel->service_end_time = date('Y-m-d H:i:s',$infoModel->service_end_time);
                        $this->widget('comext.timepicker.timepicker', array(
                            'cssClass' => 'input_box',
                            'model' => $infoModel,
                            'id'=>'Enterprise_service_end_time',
                            'name' => 'service_end_time',
                        ));
                        ?><p style="color: Red" class="fl">*</p>
                        <?php echo $form->error($infoModel,'service_end_time') ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"></td>
                    <td align="left" class="table_form_right">
                    	<?php echo $form->hiddenField($new_model, 'status');?>
                        <?php echo CHtml::submitButton(Yii::t('Public','暂存'),array('class'=>'btn1 btn_large03', 'onclick'=>'return mySubmit('.Auditing::STATUS_WAIT.')'))?>
                        <?php echo CHtml::submitButton(Yii::t('Public','申请'),array('class'=>'btn1 btn_large13', 'onclick'=>'return mySubmit('.Auditing::STATUS_APPLY.')'))?>
<!--                        <input type="button" class="btn1 btn_large03" value="暂存" id="btn_tempSave" />-->
                        <!--<input id="btn_apply" type="button" value="申请" class="btn1 btn_large13" />-->
                    </td>
                </tr>
        </table>
        <?php 
            $this->endWidget();
        ?>
        </div>
    </div>
</div>
<script type="text/javascript">
function mySubmit(status)
{
	$("#Auditing_status").val(status);
	$("#member-form").submit();
}
</script>