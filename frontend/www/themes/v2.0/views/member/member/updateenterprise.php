<?php
/* @var $this  SiteController */
/** @var $model Member */
$this->breadcrumbs = array(
    Yii::t('member', '设置') => '',
    Yii::t('member', '个人信息'),
);
Yii::app()->clientScript->registerScriptFile(DOMAIN . "/js/ZeroClipboard.min.js");
?>

<div class="main-contain">      
  <div class="withdraw-contents">
      <div class="accounts-box">
          <p class="accounts-title cover-icon"><?php echo Yii::t('member', '个人信息'); ?></p>
          <div class="person-box">
              <div class="person-logo">
                  <div class="left" style="width:68px;margin-left:25px;padding-right:10px;"><?php echo Yii::t('member', '用户头像'); ?>：</div>
                  <div class="right">
                      <p class="logo-img"><?php if ($model->head_portrait): ?>
                            <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $model->head_portrait, 'c_fill,h_102,w_102'), '头像', array('width' => 88, 'height' => 88)); ?>
                        <?php else: ?>
                            <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/head_portrait/default.jpg', 'c_fill,h_102,w_102'), '头像', array('width' => 88, 'height' => 88)); ?>
                        <?php endif; ?></p>
                      <p class="logo-editor" onclick="javascript:window.location.href='<?php echo $this->createAbsoluteUrl('/member/member/avatar');?>';"><?php echo Yii::t('member', '编辑头像');?></p>
                  </div>
              </div>
              <div class="person-info">
                  <div class="info-box">
                    <ul>
                      <li class="clearfix"><div class="info-left"><?php echo $model->getAttributeLabel('username') ?>：</div><?php echo $model->username ?>&nbsp;</li>
                      <li class="clearfix"><div class="info-left"><?php echo $model->getAttributeLabel('gai_number') ?>：</div><?php echo $model->gai_number ?>&nbsp;</li>
                      <li class="clearfix"><div class="info-left"><?php echo $model->getAttributeLabel('real_name') ?>：</div><?php echo $model->real_name ?>&nbsp;</li>
                      <li class="clearfix"><div class="info-left"><?php echo $model->getAttributeLabel('sex') ?>：</div><?php echo $model->gender($model->sex) ?>&nbsp;</li>
                      <li class="clearfix"><div class="info-left"><?php echo $model->getAttributeLabel('birthday') ?>：</div><?php echo empty($model->birthday) ? '' :date('Y-m-d',$model->birthday) ?>&nbsp;</li>
                      <li class="clearfix"><div class="info-left"><?php echo $model->getAttributeLabel('mobile') ?>：</div><?php echo substr_replace($model->mobile, '****', 3,4) ?>&nbsp;</li>
                      <li class="clearfix"><div class="info-left"><?php echo $model->getAttributeLabel('email') ?>：</div><?php echo $model->email ?>&nbsp;<span class="already"></span><span class="none"></span></li>
                      <li class="clearfix"><div class="info-left"><?php echo Yii::t('member', '所在地区'); ?>：</div><?php echo Region::model()->getName($model->province_id, $model->city_id,$model->district_id) ?>&nbsp;</li>
                      <li class="clearfix"><div class="info-left"><?php echo $model->getAttributeLabel('street') ?>：</div><?php echo CHtml::encode($model->street) ?>&nbsp;</li>
                    </ul>
                  </div>
                  <div class="info-btn">
                      <input type="button" value="<?php echo Yii::t('member', '编辑资料'); ?>" class="btn-editor" />
                  </div>
              </div>
              
               <?php
                $form = $this->beginWidget('ActiveForm', array(
                    'id' => $this->id . '-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
			'action' => '/member/update?croute=/member/member/update',
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
               <?php CHtml::$beforeRequiredLabel="<span class='red'>*</span>";CHtml::$afterRequiredLabel="";?>
              <div class="person-editor">
                <div class="info-box">
                    <ul>
                        <li class="clearfix"><div class="info-left"><?php echo $model->getAttributeLabel('username') ?>：</div><?php if (empty($model->username)): ?>
						  <?php echo $form->textField($model, 'username', array('class' => 'input-txtle')) ?>
                          <?php echo $form->error($model, 'username') ?>
                      <?php else: ?>
                          <?php echo $model->username ?>
                      <?php endif; ?></li>
                    <li class="clearfix"><div class="info-left"><?php echo $model->getAttributeLabel('gai_number') ?>：</div><?php echo $model->gai_number ?></li>
                    <li class="clearfix"><div class="info-left"><?php echo $model->getAttributeLabel('real_name') ?>：</div>
					<?php if (empty($model->real_name)): ?>
						<?php echo $form->textField($model, 'real_name', array('class' => 'input-txtle')) ?>
                        <?php echo $form->error($model, 'real_name') ?>
                    <?php else: ?>
                        <?php echo $model->real_name ?>
                    <?php endif; ?></li>
                    <li class="clearfix"><div class="info-left"><?php echo $form->labelEx($model, 'sex'); ?>：</div>
                    <?php if (empty($model->sex)): ?>
						<?php echo $form->radioButtonList($model, 'sex', $model::gender(), array('separator' => '')) ?>
                        <?php echo $form->error($model, 'sex') ?>
                    <?php else: ?>
                        <?php echo $model::gender($model->sex) ?>
                    <?php endif; ?>
                    </li>
                   <li class="clearfix">
                       <div class="info-left"><?php echo $form->labelEx($model, 'birthday') ?>：</div>
                            <?php
                                $model->birthday = empty($model->birthday) ? null : date('Y-m-d', $model->birthday);
				$this->widget('comext.timepicker.timepicker', array(
                                    'model' => $model,
                                    'name' => 'birthday',
                                    'select' => 'date',
                                    'options' => array(
                                        'dateFormat'=>'yy-mm-dd',
                                        'yearRange' => '1905',
                                    ),
//                                    'cssClass'=>'',
                                    'htmlOptions' => array(
                                        'style'=>'color:red'
                                    )
				));
                            ?>
                            <?php echo $form->error($model, 'birthday') ?>
                    </li>
                    <li class="clearfix">
                        <div class="info-left"><?php echo Yii::t('member','手机号码') ?>：</div>
                        <?php echo substr_replace($model->mobile, '****', 3,4) ?>
                        <span><?php echo CHtml::link(Yii::t('memberMember','修改绑定手机'),array('/member/member/bindMobile')) ?></span>
                        <?php echo $form->error($model, 'mobile') ?>
                    </li>
                    <li class="clearfix"><div class="info-left"><?php echo $form->labelEx($model, 'email') ?>：</div>
                    <?php echo $model->email ?>
                        <?php if (empty($model->email)): ?>
                            <span><?php echo CHtml::link(Yii::t('memberMember', '绑定邮箱'), array('/member/member/bindEmail'), array('target' => '_blank')) ?></span>
                        <?php else: ?>
                            <span><?php echo CHtml::link(Yii::t('memberMember', '修改绑定邮箱'), array('/member/member/updateBindEmail'), array('target' => '_blank')) ?></span>
                        <?php endif; ?>
                    <?php echo $form->error($model, 'email') ?>
                    </li>
                    <li class="clearfix"><div class="info-left"><?php echo Yii::t('memberMember', '所在地区'); ?>：</div>
                    <?php
					echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
							'prompt' => Yii::t('memberMember', '选择省份'),
							'class' => 'btn-clecka',
							'ajax' => array(
								'type' => 'POST',
								'url' => $this->createUrl('/member/region/updateCity'),
								'dataType' => 'json',
								'data' => array(
									'province_id' => 'js:this.value',
									'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
								),
								'success' => 'function(data) {
									$("#Member_city_id").html(data.dropDownCities);
									$("#Member_district_id").html(data.dropDownCounties);
								}',
						)));
						?>
						<?php echo $form->error($model, 'province_id'); ?>
						<?php
						echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
							'prompt' => Yii::t('memberMember', '选择城市'),
							'class' => 'btn-cleckb',
							'ajax' => array(
								'type' => 'POST',
								'url' => $this->createUrl('/member/region/updateArea'),
								'update' => '#Member_district_id',
								'data' => array(
									'city_id' => 'js:this.value',
									'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
								),
						)));
						?>
						<?php echo $form->error($model, 'city_id'); ?>
						<?php
						echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
							'prompt' => Yii::t('memberMember', '选择地区'),
							'class' => 'btn-cleckc',
							'ajax' => array(
								'type' => 'POST',
								'data' => array(
									'city_id' => 'js:this.value',
									'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
								),
						)));
					?>
					<?php echo $form->error($model, 'district_id'); ?>
                    </li>
                    <li class="clearfix"><div class="info-left"><?php echo $form->labelEx($model, 'street') ?>：</div>
                    <?php echo $form->textField($model, 'street', array('class' => 'input-txtle')) ?>
                    <?php echo $form->error($model, 'street') ?>
                    </li>
                  </ul>  
                </div>
                <div class="info-btn">
                    <?php echo CHtml::submitButton(Yii::t('memberMember', '保存'), array('class' => 'btn-deter bankBtn')) ?>
                    <input name="" type="button" value="取消" onclick="hidePerson();" class="btn-delete" />
                </div>
            </div>
            <?php $this->endWidget(); ?>     
          </div>
      </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(e) {
		$('#yw0').addClass('input-txtle');
		//日期插件问题, 创建的输入框会显示在底部分层, 需隐藏掉
		setTimeout('$("#ui-datepicker-div").css("display","none");', 2000);
    });
</script>