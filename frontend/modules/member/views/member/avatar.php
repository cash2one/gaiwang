<?php
/* @var $this  HomeController */
/** @var $model Member */
/** @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberMember', '账户管理') => '',
    Yii::t('memberMember', '用户头像'),
);
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li>
                <?php
                $memberBase = $this->getSession('enterpriseId') ? Yii::t('memberMember', '企业基本信息') : Yii::t('memberMember', '用户基本信息');
                echo CHtml::link('<span>' . $memberBase . '</span>',
                    $this->createAbsoluteUrl('/member/site/index'))
                ?>
            </li>
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberMember', '头像设置'); ?></span></a></li>
            <li><?php echo CHtml::link('<span>' . Yii::t('memberMember', '兴趣爱好') . '</span>', $this->createAbsoluteUrl('/member/interest/index')) ?></li>
        </ul>
    </div>
    <div class="mbRcontent">
        <?php $this->renderPartial('/layouts/_summary'); ?>
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="mgtop20 upladBox"><h3><?php echo Yii::t('memberMember', '更换头像'); ?></h3></div>
                <div
                    class="upladBox"><?php echo Yii::t('memberMember', '如果您还没有设置自己的头像，系统会显示为默认头像，您需要自己上传一张新照片来作为自己的个人头像。'); ?></div>
                <div class="mgtop40 upladBox">
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
                <div class="mgtop40 upladBox"><font class="red"><?php echo Yii::t('memberMember', '设置我的新头像'); ?></font></div>
                <div class="upladBox"><?php echo Yii::t('memberMember', '您可以上传图片或者直接拍摄照片。您提交的图片会自动生成三种尺寸的缩略图。'); ?></div>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
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
                <div class="mgtop10 upladBox">
                    <?php echo $form->fileField($model, 'head_portrait'); ?>
                </div>
                <div class="gay95 upladBox mgtop5">
                    *<?php echo Yii::t('memberMember', '仅支持JPG、GIF、PNG图片文件，且文件小于5M'); ?>
                    <?php echo $form->error($model, 'head_portrait') ?>
                </div>
                <div class="upladBox">
                    <?php echo CHtml::submitButton(Yii::t('memberMember', '立刻上传'), array('class' => 'uploadBtn', 'border' => 'none')) ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>