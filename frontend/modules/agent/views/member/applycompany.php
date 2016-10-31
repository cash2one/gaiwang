<?php 
	$baseUrl = AGENT_DOMAIN.'/agent';
	$cs = Yii::app()->clientScript;
	//样式
	$cs->registerCssFile($baseUrl. "/css/machine.css?v=1");
	
	//显示原图的JS插件
	$cs->registerCssFile($baseUrl. "/js/fancybox/jquery.fancybox-1.3.4.css"); 			
	$cs->registerScriptFile($baseUrl. "/js/fancybox/jquery.fancybox-1.3.4.pack.js");			
	
	//自己写的上传处理插件 
	$cs->registerScriptFile($baseUrl. "/js/uploadImg.js");					
		
?>
<div class="line container_fluid">
    <div class="row_fluid line">
        <div class="vip_title red">
            <p class="unit fl"><?php echo Yii::t('Member','申请添加企业会员')?></p>
            <?php echo CHtml::link(Yii::t('Public','返回列表'),$this->createUrl('member/applyList'),array('class'=>'fr mr10 return')) ?>
        </div>
        <div class="line table_white">
         	<?php 
                $form = $this->beginWidget('CActiveForm',array(
                    'action' => $this->createUrl('member/cancelApply',array('id'=>$new_model->id)),
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
                    <td width="88%" align="left" class="table_form_right">
                    	<?php echo Auditing::getStatus($new_model->status)?>
                    	<?php echo CHtml::submitButton(Yii::t('Member','取消申请'),array('class'=>'btn1 btn_large13','id'=>'cancelapply'))?>
                    </td>
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
                        <?php echo $model->is_master_account?"是":"否"?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'name')?>：</td>
                    <td align="left" class="table_form_right">
                        <?php echo $model->username?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'short_name')?>：</td>
                    <td align="left" class="table_form_right">
                        <?php echo $infoModel->short_name?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'category_id'); ?>：</td>
                    <td align="left" class="table_form_right">
                        <?php echo StoreCategory::getStoreCategoryName($infoModel->category_id)?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'license'); ?>：</td>
                    <td align="left" class="table_form_right">
                        <?php echo $infoModel->license;?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'license_photo'); ?>：</td>
                    <td align="left" class="table_form_right">
			            <div class="ImgList">
                           	<div class="imgbox"> 
								<div class="w_upload">
									<span class="item_box">
										<a class='imga' href='<?php echo ATTR_DOMAIN."/".$infoModel->license_photo?>' onclick='return _showBigPic(this)' >
											<img src="<?php echo ATTR_DOMAIN."/".$infoModel->license_photo?>" class="imgThumb" />
										</a>
									</span>
								</div>
							</div>
						</div>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo Yii::t('Member','公司所在地区'); ?>：</td>
                    <td align="left" class="table_form_right">
                        <?php
	                       echo Region::getName($infoModel->province_id)." ".Region::getName($infoModel->city_id)." ".Region::getName($infoModel->district_id);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'street'); ?>：</td>
                    <td align="left" class="table_form_right">
                        <?php echo $infoModel->street;?>
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
                        <?php echo $infoModel->link_man;?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'department'); ?>：</td>
                    <td align="left" class="table_form_right">
                    	<?php echo Enterprise::departmentArr($infoModel->department)?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'mobile'); ?>：</td>
                    <td align="left" class="table_form_right">
                    	<?php echo $model->mobile?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'email'); ?></td>
                    <td align="left" class="table_form_right">
                    	<?php echo $infoModel->email?>
                    </td>
                </tr>
                <tr class="table1_title">
                    <td colspan="3">
                        <div class="red"><?php echo Yii::t('Member','服务时间信息'); ?></div>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'service_start_time'); ?>：</td>
                    <td align="left" class="table_form_right">
                    	<?php echo date('Y-m-d H:i:s',$infoModel->service_start_time)?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($infoModel,'service_end_time'); ?>：</td>
                    <td align="left" class="table_form_right">
                    	<?php echo date('Y-m-d H:i:s',$infoModel->service_end_time)?>
                    </td>
                </tr>
        </table>
        <?php 
            $this->endWidget();
        ?>
        </div>
    </div>
</div>