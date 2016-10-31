	<?php $this->breadcrumbs = array('会员管理','审核企业会员【'.$infoModel->name.'】')?>
	<script src="/js/iframeTools.js" type="text/javascript"></script>
    <script type="text/javascript" language="javascript">
        $(function () {
            $('.breadcrumbs').append('<div class="t-sub"><?php echo CHtml::link(Yii::t('Member', '返回列表'),Yii::app()->createUrl('member/storeMemberList'),array('class'=>'regm-sub'))?></div>');
            $('#btn_OK').bind('click', function () {
                $('#status').val(<?php echo Auditing::STATUS_PASS?>);
                $('#member-form').submit();
            });

            $('#btn_failed').bind('click', function () {
                if ($('#Member_audit_opinion').val() == '') {
                    	alert('审核不通过时审核意见不能为空！', function () {
                        $('#Member_audit_opinion').focus();
                    });
                    return;
                }
                $('#status').val(<?php echo Auditing::STATUS_NOPASS?>);
                $('#member-form').submit();
            });
        });

    </script>
		<?php 
			$form = $this->beginWidget('CActiveForm',array(
				'id' => 'member-form',
			    'enableAjaxValidation' => true,
			    'enableClientValidation' => true,
			));
		?>
	
		<?php echo CHtml::hiddenField("status",'',array('id'=>'status'))?>
		<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
            <tr>
                <td colspan="2" align="center" class="title-th"><?php echo Yii::t('member', '企业信息')?></td>
            </tr>
            <tr>
                <th style="width: 120px"></th>
                <td><label><?php echo $form->checkBox($model,'is_master_account',array('checked'=>true))?><?php echo Yii::t('member', '设定为主账户')?></label></td>
            </tr>
            <tr>
                <th style="text-align: center">公司名称：</th>
                <td>
                	<?php echo $form->textField($infoModel,'name',array('class' => 'text-input-bj  middle'))?><span style="color: Red">* </span>
                    <?php echo $form->error($infoModel,'name')?>
                    
                </td>
            </tr>
            <tr>
                <th style="text-align: center">公司简称：</th>
                <td>
                	<?php echo $form->textField($infoModel,'short_name',array('class' => 'text-input-bj  middle'))?><span style="color: Red">* </span>
                    <?php echo $form->error($infoModel,'short_name')?>
                </td>
            </tr>
            <tr>
                <th style="text-align: center">营业执照编号：</th>
                <td>
                	<?php echo $form->textField($infoModel,'license',array('class'=>'text-input-bj  middle')); ?> <span style="color: Red">* </span>
                    <?php echo $form->error($infoModel,'license') ?>
                </td>
            </tr>
            <tr>
                <th style="text-align: center">营业执照图片：</th>
                <td>
                	<?php 
	            		$this->widget('common.widgets.CUploadPic',array(
	            			'form' => $form,
	            			'model' => $infoModel,
	            			'attribute' => 'license_photo',
	            			'upload_width' => 500,
	            			'upload_height' => 500,
	            			'folder_name' => 'license_photo/patentcodephoto',
	            			'btn_class' => 'regm-sub',
	            			'btn_value' => '上传执照',
	            			'img_area' => 2,
	            		));
	            	?><span style="color: Red">*</span>请上传500x500像素图片
                    <?php echo $form->error($infoModel,'license_photo') ?>
                </td>
            </tr>
            <tr>
                <th style="text-align: center"><?php echo Yii::t('member','公司所在地区'); ?>：</th>
                <td>
                	<?php
                        echo $form->dropDownList($infoModel, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                            'class' => 'text-input-bj valid',
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
                                            $("#Enterprise_city_id").html(data.dropDownCities);
                                            $("#Enterprise_district_id").html(data.dropDownCounties);
                                        }',
                            )));
                        ?>省
                        <?php echo $form->error($infoModel, 'province_id'); ?>
                        <?php
                        echo $form->dropDownList($infoModel, 'city_id', Region::getRegionByParentId($infoModel->province_id), array(
                            'class' => 'text-input-bj valid',
                            'prompt' => Yii::t('member', '选择城市'),
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/region/updateArea'),
                                'update' => '#Enterprise_district_id',
                                'data' => array(
                                    'city_id' => 'js:this.value',
                                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                ),
                            )));
                        ?>市
                        <?php echo $form->error($infoModel, 'city_id'); ?>
                        <?php
                        echo $form->dropDownList($infoModel, 'district_id', Region::getRegionByParentId($infoModel->city_id), array(
                            'class' => 'text-input-bj valid',
                            'prompt' => Yii::t('member', '选择地区'),
                            'ajax' => array(
                                'type' => 'POST',
                                'data' => array(
                                    'city_id' => 'js:this.value',
                                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                ),
                            )));
                        ?>区
                        <span style="color: Red">*</span>
                        <?php echo $form->error($infoModel, 'district_id'); ?>
                </td>
            </tr>
            <tr>
                <th style="text-align: center"><?php echo $form->label($infoModel,'street'); ?>：</th>
                <td>
	                <?php echo $form->textField($infoModel,'street',array('class'=>'text-input-bj  middle')); ?><span style="color: Red">* </span>
	                <?php echo $form->error($infoModel,'street') ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center" class="title-th"><?php echo Yii::t('member','联系人信息'); ?></td>
            </tr>
            <tr>
                <th style="text-align: center"><?php echo $form->label($infoModel,'link_man'); ?>：</th>
                <td>
                	<?php echo $form->textField($infoModel,'link_man',array('class'=>'text-input-bj  middle')); ?><span style="color: Red">* </span>
                    <?php echo $form->error($infoModel,'link_man') ?>
                </td>
            </tr>
            <tr>
                <th style="text-align: center"><?php echo $form->label($infoModel,'department'); ?>：</th>
                <td>
                    <?php 
                    	echo $form->dropDownList($infoModel,'department',$infoModel::departmentArr(),array(
                            'class' => 'text-input-bj valid',
                            'empty'=>Yii::t('home','请选择'),
                        )) 
                     ?><span style="color: Red">* </span>
                    <?php echo $form->error($infoModel,'department') ?>
                </td>
            </tr>
            <tr>
                <th style="text-align: center"><?php echo $form->label($infoModel,'mobile'); ?>：</th>
                <td>
                	<?php echo $form->textField($infoModel,'mobile',array('class'=>'text-input-bj  middle')); ?><span style="color: Red">* </span>
                    <?php echo $form->error($infoModel,'mobile') ?>
                </td>
            </tr>
            <tr>
                <th style="text-align: center"><?php echo $form->label($infoModel,'email'); ?>：</th>
                <td>
                	<?php echo $form->textField($infoModel,'email',array('class'=>'text-input-bj  middle')); ?>
                    <?php echo $form->error($infoModel,'email') ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" class=" title-th" align="center"><?php echo Yii::t('member','服务时间信息'); ?></td>
            </tr>
            <tr>
                <th><?php echo $form->label($infoModel,'service_start_time'); ?>：</th>
                <td>
                	<?php
                        if(!empty($infoModel->service_start_time)) $infoModel->service_start_time = date('Y-m-d H:i:s',$infoModel->service_start_time);
                        $this->widget('comext.timepicker.timepicker', array(
                            'cssClass' => 'datefield text-input-bj middle',
                            'model' => $infoModel,
                            'id'=>'Enterprise_service_start_time',
                            'name' => 'service_start_time',
                        ));
                    ?><span style="color: Red">* </span>
                    <?php echo $form->error($infoModel,'service_start_time') ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $form->label($infoModel,'service_end_time'); ?>：</th>
                <td>
                	<?php
                        if(!empty($infoModel->service_end_time)) $infoModel->service_end_time = date('Y-m-d H:i:s',$infoModel->service_end_time);
                        $this->widget('comext.timepicker.timepicker', array(
                            'cssClass' => 'datefield text-input-bj middle',
                            'model' => $infoModel,
                            'id'=>'Enterprise_service_end_time',
                            'name' => 'service_end_time',
                        ));
                    ?><span style="color: Red">* </span>
                    <?php echo $form->error($infoModel,'service_end_time') ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center" class="title-th"><?php echo Yii::t('member', '审核信息')?></td>
            </tr>
            <tr>
                <th ><?php echo Yii::t('member', '申请类型')?>：</th>
                <td><?php echo Auditing::getApplyType($model->apply_type)?></td>
            </tr>
            <tr>
                <th ><?php echo Yii::t('member', '申请会员编号')?>：</th>
                <td><?php echo $model->author_name?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('member', '申请会员类型')?>：</th>
                <td><?php echo Auditing::getAuthorType($model->author_type)?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('member', '申请提交时间')?>：</th>
                <td><?php echo date('Y-m-d H:i:s',$model->submit_time)?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('member', '审核意见')?>：</th>
                <td>
                	<?php echo $form->textArea($model,'audit_opinion',array('class'=>'text-input-bj  text-area','cols'=>2,'rows'=>2))?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                	<?php echo CHtml::button(Yii::t('member', '修改后通过'),array('class'=>'regm-sub','id'=>'btn_OK'))?>
                	<?php echo CHtml::button(Yii::t('member', '不通过'),array('class'=>'regm-sub','id'=>'btn_failed'))?>
                </td>
            </tr>
        </table>
<?php $this->endWidget();?>


    
