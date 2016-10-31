<?php
/* @var $this  HomeController */
/** @var $model Member */
/** @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberMember', '账户管理') => '',
    Yii::t('memberMember', '用户头像'),
);
?>
<style>
.person-box .person-avatar{border-bottom: 1px solid #ddd;padding: 20px 0; height:500px;}
.person-avatar div{ padding-left:10px; width:100%;}
.h3{font-size: 14px; font-weight:bold;}
.uploadBox{ float:left; margin-top:40px;}
.uploadBox a{vertical-align: middle;}
.userBig{width: 144px;height: 134px;display: block;float: left;border: 1px solid #d2d2d2;background: #fff;text-align: center;border-radius: 3px; padding-top:6px;}
.userCenter{width: 76px;height: 72px;display: block;margin-left: 40px;float: left;border: 1px solid #d2d2d2;background: #fff;text-align: center;border-radius: 3px; padding-top:6px;}
.userSmall{width: 40px;height:36px;display: block;margin-left: 40px;float: left;border: 1px solid #d2d2d2;background: #fff;text-align: center;border-radius: 3px; padding-top:4px;}
.avatar-gay{color: #959595;}
.uploadBox2{float:left; margin-top:40px; text-align:center; padding-left:0 !important;}
.person-box .btn-deter { background: #d40005 none repeat scroll 0 0;border: medium none;border-radius: 3px;color: #fff;cursor: pointer;font-family: "微软雅黑";font-size: 16px;height: 38px;width: 92px;}
</style>
<div class="main-contain">
  <div class="withdraw-contents">
      <div class="accounts-box">
          <p class="accounts-title cover-icon"><?php echo Yii::t('member', '编辑头像'); ?></p>
          <div class="person-box">
              <div class="person-avatar">
                  <div class="h3"><?php echo Yii::t('memberMember', '更换头像'); ?></div>
                  <div><?php echo Yii::t('memberMember', '如果您还没有设置自己的头像，系统会显示为默认头像，您需要自己上传一张新照片来作为自己的个人头像。'); ?></div>
                  <div class="uploadBox">
                    <a href="javascript:;" class="userBig">
                        <?php if ($model->head_portrait): ?>
                            <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $model->head_portrait, 'c_fill,h_128,w_128'), '头像', array('width' => 128, 'height' => 128)); ?>
                        <?php else: ?>
                            <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/head_portrait/default.jpg', 'c_fill,h_128,w_128'), '头像', array('width' => 128, 'height' => 128)); ?>
                        <?php endif; ?>
                    </a>
                    <a href="javascript:;" class="userCenter">
                        <?php if ($model->head_portrait): ?>
                            <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $model->head_portrait, 'c_fill,h_64,w_64'), '头像', array('width' => 64, 'height' => 64)); ?>
                        <?php else: ?>
                            <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/head_portrait/default.jpg', 'c_fill,h_64,w_64'), '头像', array('width' => 64, 'height' => 64)); ?>
                        <?php endif; ?>
                    </a>
                    <a href="javascript:;" class="userSmall">
                        <?php if ($model->head_portrait): ?>
                            <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $model->head_portrait, 'c_fill,h_32,w_32'), '头像', array('width' => 32, 'height' => 32)); ?>
                        <?php else: ?>
                            <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/head_portrait/default.jpg', 'c_fill,h_32,w_32'), '头像', array('width' => 32, 'height' => 32)); ?>
                        <?php endif; ?>
                    </a>
                  </div>
                  <div class="uploadBox"><font class="red"><?php echo Yii::t('memberMember', '设置我的新头像'); ?></font></div>
                  <div><?php echo Yii::t('memberMember', '您可以上传图片或者直接拍摄照片。您提交的图片会自动生成三种尺寸的缩略图。'); ?></div>
                  <?php
                $form = $this->beginWidget('ActiveForm', array(
                    'id' => $this->id . '-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                    ),
                ));
                ?>
                <div><?php echo $form->fileField($model, 'head_portrait'); ?></div>
                <div class="avatar-gay">*<?php echo Yii::t('memberMember', '仅支持JPG、GIF、PNG图片文件，且文件小于5M'); ?>
                    <?php echo $form->error($model, 'head_portrait') ?>
                </div>
                <div class="uploadBox2"><?php echo CHtml::submitButton(Yii::t('memberMember', '立刻上传'), array('class' => 'btn-deter', 'border' => 'none')) ?></div>
                <?php $this->endWidget(); ?>
              </div>  
          </div>
      </div>
  </div>    
</div>