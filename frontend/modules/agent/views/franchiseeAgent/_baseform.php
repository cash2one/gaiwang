<?php 
	$cs = Yii::app()->clientScript;
	$baseUrl = AGENT_DOMAIN.'/agent';
	
	$cs->registerScriptFile($baseUrl. "/js/artDialog.js?skin=blue");
	$cs->registerScriptFile($baseUrl. "/js/artDialog.iframeTools.js");				//弹出框调用远程文件插件
?>
<div class="line container_fluid">
    <div class="row_fluid line">
        <div class="vip_title red">
            <p class="unit fl"><?php echo Yii::t('Franchisee', '编辑加盟商')?></p>
        </div>
        <div class="line table_white">
        	<?php 
        		$form=$this->beginWidget('CActiveForm', array(
					'id'=>'franchiseeAgent-form',
					'enableAjaxValidation'=>true,
					'enableClientValidation'=>true,
				)); 
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table5">
                    <tr class="table1_title" bgcolor="#fcfcfc">
                        <td colspan="2"><?php echo Yii::t('Franchisee', '编辑加盟商基本信息')?></td>
                    </tr>
                    <tr>
                        <td width="12%" align="right"><?php echo Yii::t('Franchisee','状态')?>：</td>
                        <td width="88%" align="left" class="table_form_right"><?php echo Auditing::getStatus($model->status)?></td>
                    </tr>
                    <tr class="table1_title" bgcolor="#fcfcfc">
                        <td colspan="2"><?php echo Yii::t('Franchisee','加盟商信息')?></td>
                    </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('Public', '地区')?>：</td>
                            <td align="left" class="table_form_right">
                                <?php
		                        echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
		                            'class' => 'input_box2 mt5 dib fl',
		                            'prompt' => Yii::t('Public', '选择省份'),
		                            'ajax' => array(
		                                'type' => 'POST',
		                                'url' => $this->createUrl('region/updateCity'),
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
		                            'prompt' => Yii::t('Public', '选择城市'),
		                            'ajax' => array(
		                                'type' => 'POST',
		                                'url' => $this->createUrl('region/updateArea'),
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
		                            'prompt' => Yii::t('Public', '选择地区'),
		                            'ajax' => array(
		                                'type' => 'POST',
		                                'data' => array(
		                                    'city_id' => 'js:this.value',
		                                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
		                                ),
		                            )));
		                        ?>
		                        <?php echo $form->error($model, 'district_id'); ?>
                                <span style="color: Red" class="fl">* </span>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $form->label($model,'street'); ?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $form->textField($model,'street',array('class'=>'input_box')); ?><span style="color: Red" class="fl">* </span>
								<?php echo $form->error($model,'street'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('Pblic','经纬度')?>：</td>
                            <td align="left" class="table_form_right">
								<?php 
									$this->widget('application.modules.agent.widgets.CBDMap',array(
										'model' => $model,
										'form' => $form,
										'attr_lng' => 'lng',
										'attr_lat' => 'lat',
										'type' => 'use',
										'buttonClass' => 'btn1 btn_large13',
									));
								?>
                            </td>
                        </tr>
                        <tr>
                        	<td align="right"><?php echo $form->label($model,'summary'); ?>：</td>
                        	<td>
								<?php echo $form->textField($model,'summary',array('class'=>'input_box','size'=>150)); ?><span style="color: Red" class="fl">* </span>
								<?php echo $form->error($model,'summary'); ?>
                        	</td>
                        </tr>
                      
                        <tr>
                            <td align="right"><?php echo $form->label($model,'main_course'); ?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $form->textField($model,'main_course',array('class'=>'input_box')); ?>
								<span style="color: Red">* </span>
								<?php echo $form->error($model,'main_course'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $form->label($model,'category_id'); //行业?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $form->dropDownList($model, 'category_id', CHtml::listData(FranchiseeCategory::model()->findAll(), 'id', 'name'), array('class' => 'text-input-bj'));?><span style="color: Red">* </span>
								<?php echo $form->error($model,'category_id'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('Franchisee','商家LOGO')?><?php //echo $form->label($model,'logo')?>：</td>
                            <td align="left" class="table_form_right">
                            
								<?php 
				            		$this->widget('application.modules.agent.widgets.GWUploadPic',array(
				            			'form' => $form,
				            			'model' => $model,
				            			'attribute' => 'logo',
				            			'upload_width' => 125,
				            			'upload_height' => 65,
				            			'folder_name' => 'franchisee',
				            			'isdate' => 0,
				            			'img_area' => 2,
				            			'btn_class' => 'btn1 btn_large13 fl',
				            			'btn_value' => Yii::t('Franchisee','设置LOGO'),
				            			'demo' => '<p class="unit tips tips_icon1"> 请上传125*65像素的图片</p>',
				            		));
				            	?>
                            	<span class="fl" style="color: Red">* </span>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo Yii::t('Franchisee','图片列表')?> ：</td>
                            <td align="left" class="table_form_right">
                            	<?php 
				            		$this->widget('application.modules.agent.widgets.GWUploadPic',array(
				            			'form' => $form,
				            			'model' => $model,
				            			'attribute' => 'path',
				            			'upload_width' => 730,
				            			'upload_height' => 280,
				            			'num' => 5,
				            			'folder_name' => 'files',
				            			'btn_class' => 'btn1 btn_large13 fl',
				            			'btn_value' => Yii::t('Franchisee','设置列表图片'),
				            			'demo' => '<p class="unit tips tips_icon1"> 请上传730*280像素的图片</p>',
				            		));
				            	?>
				            	<span class="fl" style="color: Red">* </span>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"></td>
                            <td id="gilid"></td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $form->label($model,'mobile'); ?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $form->textField($model,'mobile',array('class'=>'input_box')); ?><span style="color: Red" class="fl">* </span>
								<?php echo $form->error($model,'mobile'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $form->label($model,'qq'); ?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $form->textArea($model,'qq',array('rows'=>3,'cols'=>15,'class'=>'fl')); ?><p class="unit tips tips_icon1">以逗号分隔，如30994,349850,93802385</p>
								<?php echo $form->error($model,'qq'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $form->label($model,'url'); ?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $form->textField($model,'url',array('class'=>'input_box')); ?>
								<?php echo $form->error($model,'url'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $form->label($model,'keywords'); ?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $form->textField($model,'keywords',array('class'=>'input_box')); ?>
								<?php echo $form->error($model,'keywords'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $form->label($model,'fax'); ?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $form->textField($model,'fax',array('class'=>'input_box')); ?>
								<?php echo $form->error($model,'fax'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $form->label($model,'zip_code'); ?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $form->textField($model,'zip_code',array('class'=>'input_box')); ?>
								<?php echo $form->error($model,'zip_code'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $form->label($model,'notice'); ?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $form->textArea($model,'notice',array('rows'=>3, 'cols'=>120)); ?>
								<?php echo $form->error($model,'notice'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $form->label($model,'description'); // 商家介绍?>：</td>
                            <td align="left" class="table_form_right">
								 <?php
						            $this->widget('ext.wdueditor.WDueditor', array(
				                		'width' => '90%',
						                'model' => $model,
						                'attribute' => 'description',
						            ));
						        ?>
				            	<?php echo $form->error($model, 'description'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php echo CHtml::submitButton(Yii::t('Franchisee','暂存'),array('class'=>'btn1 btn_large03','id'=>'wait','name'=>'wait'));?>
                                <?php echo CHtml::submitButton(Yii::t('Franchisee', '申请'),array('class'=>'btn1 btn_large13','id'=>'apply','name'=>'apply'));?>
                            </td>
                        </tr>
                </table>
		<?php $this->endWidget(); ?>      
		</div>
    </div>
</div>