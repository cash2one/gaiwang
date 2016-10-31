
  	<!--主体start-->  	
      <div class="main-contain">
        <div class="withdraw-contents">
        	<div class="crumbs crumbs-en">
              <span><?php echo Yii::t('memberWealth', '您的位置：') ?></span>
                  <a href="#"><?php echo Yii::t('memberWealth', '企业管理') ?></a>
                  <span>&gt</span>
                  <a href="#"><?php echo Yii::t('memberWealth', '企业基本信息') ?></a>
            </div>
            <div class="accounts-box">
                <p class="accounts-title cover-icon"><?php echo Yii::t('memberWealth', '企业基本信息') ?></p>
                <div class="company-box">
                    <div class="company-info">
                    	<div class="info-box">
                            <p class="info-title"><span><?php echo Yii::t('memberWealth', '账户信息') ?></span></p>
                            <p><span><?php echo Yii::t('memberWealth', '登录名') ?>：</span><?php echo $this->getUser()->name; ?></p>
                            <p><span><?php echo Yii::t('memberWealth', '盖网编号') ?>：</span><?php echo $this->getUser()->gw; ?></p>
                        </div>
                    	<?php if(!empty($model->service_start_time) && !empty($model->service_end_time)):?>
                        <div class="info-box">
                            <p class="info-title"><span><?php echo Yii::t('memberWealth', '时间信息') ?></span></p>
                            <p><span><?php echo Yii::t('memberWealth', '开始服务时间') ?>：</span><?php echo $this->format()->formatDatetime($model->service_start_time) ?></p>
                            <p><span><?php echo Yii::t('memberWealth', '结束服务名称') ?>：</span><?php echo $this->format()->formatDatetime($model->service_end_time) ?></p>
                        </div>
                        <?php endif;?>
                        <div class="info-box">
                            <p class="info-title"><span><?php echo Yii::t('memberWealth', '公司信息') ?></span></p>
                            <p><span><?php echo Yii::t('memberWealth', '公司名称') ?>：</span><?php echo  $model->name; ?></p>
                            <p><span><?php echo Yii::t('memberWealth', '公司简称') ?>：</span><?php echo $model->short_name; ?></p>
                            <p><span><?php echo Yii::t('memberWealth', '公司地址') ?>：</span><?php echo Region::getName($model->province_id, $model->city_id, $model->district_id) ?>
                                                   <?php echo $model->street ?></p>
                        </div>
                        
                        <div class="info-box">
                        	<p class="info-title"><span><?php echo Yii::t('memberWealth', '联系人资料') ?></span></p>
                            <p><span><?php echo Yii::t('memberWealth', '联系人姓名') ?>：</span><?php echo $model->link_man; ?></p>
                            <p><span><?php echo Yii::t('memberWealth', '电子邮箱') ?>：</span><?php echo $model->email;?></p>
                            <p><span><?php echo Yii::t('memberWealth', '所属部门') ?>：</span><?php echo Enterprise::departmentArr($model->department) ?></p>
                        </div>
                        
                        <div class="info-box">
                            <p class="info-title"><span><?php echo Yii::t('memberWealth', '手机绑定') ?></span></p>
                            <p><span><?php echo Yii::t('memberWealth', '已绑定的手机') ?>:</span><?php echo $bindMobile;?></p>
                        </div>
                        
                        <div class="info-btn">
                            <input name="" type="button" value="<?php echo Yii::t('memberWealth', '编辑资料') ?>" class="btn-editor" />
                        </div>
                        
                    </div>
                    <div class="company-editor">
                    	<div class="info-box">
                            <p class="info-title"><span><?php echo Yii::t('memberWealth', '账户信息') ?></span></p>
                            <p><span><?php echo Yii::t('memberWealth', '登录名') ?>：</span><?php echo $this->getUser()->name; ?></p>
                            <p><span><?php echo Yii::t('memberWealth', '盖网编号') ?>：</span><?php echo $this->getUser()->gw; ?></p>
                        </div>
                    	<?php if(!empty($model->service_start_time) && !empty($model->service_end_time)):?>
                        <div class="info-box">
                            <p class="info-title"><span><?php echo Yii::t('memberWealth', '时间信息') ?></span></p>
                            <p><span><?php echo Yii::t('memberWealth', '开始服务时间') ?>：</span><?php echo $this->format()->formatDatetime($model->service_start_time) ?></p>
                            <p><span><?php echo Yii::t('memberWealth', '结束服务名称') ?>：</span><?php echo $this->format()->formatDatetime($model->service_end_time) ?></p>
                        </div>
                        <?php endif;?>
          <?php
                $form = $this->beginWidget('ActiveForm', array(
                    'id' => $this->id . '-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
         ?>
                        <div class="info-box">
                            <p class="info-title"><span><?php echo Yii::t('memberWealth', '公司信息') ?></span></p>
                            <p><span><?php echo Yii::t('enterprise', '公司名称'); ?>：</span>
                                     <?php echo $form->textField($model, 'name', array('class' => 'input-txtle'))?>
                            </p>
                            <p><span><?php echo $form->error($model, 'name'); ?></span></p>
                            <p><span><?php echo $form->labelEx($model, 'short_name'); ?>：</span>
                            <?php echo $form->textField($model, 'short_name', array('class' => 'input-txtle'))?></p>
                            <p><span><?php echo Yii::t('enterprise', '公司地址'); ?>：</span>
                <?php
                    echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                        'prompt' => Yii::t('sellerStore', '选择省份'),
                        'class' => 'selectTxt1',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('/member/region/updateCity'),
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
                ?>
                <?php
                    echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                        'prompt' => Yii::t('sellerStore', '选择城市'),
                        'class' => 'selectTxt1',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('/member/region/updateArea'),
                            'update' => '#Enterprise_district_id',
                            'data' => array(
                                'city_id' => 'js:this.value',
                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                            ),
                    )));
                ?>
                <?php
                    echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                        'prompt' => Yii::t('sellerStore', '选择区/县'),
                        'class' => 'selectTxt1',
                        'ajax' => array(
                            'type' => 'POST',
                            'data' => array(
                                'city_id' => 'js:this.value',
                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                            ),
                    )));
                ?>
                </p>
                <p> <?php echo $form->error($model, 'district_id'); ?> 
                    <?php echo $form->error($model, 'city_id'); ?>
                    <?php echo $form->error($model, 'province_id'); ?></p>
                    <p><span><?php echo Yii::t('sellerStore', '详细地址') ?>：</span>
                <?php echo $form->textField($model, 'street', array('class' => 'input-txtle'))?></p>
                <p><span><?php echo $form->error($model, 'street'); ?></span></p>
                   </div>
                        <div class="info-box">
                        	<p class="info-title"><span><?php echo Yii::t('memberWealth', '联系人资料') ?></span></p>
                            <p><span><?php echo $form->labelEx($model, 'link_man'); ?>：</span>
                            <?php echo $form->textField($model, 'link_man', array('class' => 'input-txtle'))?></p>
                            <p><span><?php echo $form->labelEx($model, 'email'); ?>：</span>
                               <?php echo $model->email?>
                               <!--<span><?php echo CHtml::link(Yii::t('memberMember','修改绑定邮箱'),array('/member/member/bindEmail')) ?></span>-->
                            </p>
                            <p><span><?php echo Yii::t('memberWealth', '所属部门') ?>：</span>
                            <?php echo $form->dropDownList($model, 'department', Enterprise::departmentArr());?></p>
                        </div>
                        
                        <div class="info-box">
                            <p class="info-title"><span><?php echo Yii::t('memberWealth', '手机绑定') ?></span></p>
                            <p><span><?php echo Yii::t('memberWealth', '已绑定的手机') ?>:</span><?php echo $bindMobile;?></p>
                        </div>
                        
                        <div class="info-btn">
                            <input id="submitBtn"  type="submit" value="<?php echo Yii::t('memberWealth', '保存') ?>" class="btn-deter" />
                            <input  type="button" value="<?php echo Yii::t('memberWealth', '取消') ?>" class="btn-delete" />
                        </div>
           <?php $this->endWidget() ?>
                    </div>
                </div>
            </div>
            
        </div>
        
        
      </div>       
    <!-- 主体end -->
