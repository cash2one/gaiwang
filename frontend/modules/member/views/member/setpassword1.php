<?php
/* @var $this  HomeController */
/** @var $model Member */
/** @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberMember', '账号管理') => '',
    Yii::t('memberMember', ' 密码设置'),
);
?>
<div class="mbRight">
	<div class="EntInfoTab">
		<ul class="clearfix">
                    <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberMember','密码设置');?></span></a></li>
		</ul>
	</div>
    <div class="mbRcontent">
        <!--end 头像及基本信息-->
        <?php $this->renderPartial('/layouts/_summary'); ?>
        <!--end 头像及基本信息-->
        <div class="mbDate1">

            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="mgtop20 upladBox integaralbd pdbottom10">
                    <span class="pwdstep01_1 fl mgleft14"></span>
                    <span class="fl mgleft14">
                            <h3 class="mgtop10"><?php echo Yii::t('memberMember','一级密码(登录密码)'); ?></h3>
                            <p class="gay95 "><?php echo Yii::t('memberMember','权限:登录网站账号'); ?></p>
                    </span>
                </div>
                <div class="upladBox">
                    <div class="passBox">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => $this->id . '-form',
                            'enableAjaxValidation' => true,
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                        ));
                        ?>
                        <dl class="clearfix">
                            <dt><font class="red">*</font><?php echo Yii::t('memberMember','新密码'); ?>：</dt>
                            <dd>
                                <?php echo $form->passwordField($model,'password',array('class'=>'inputtxt','value'=>'')) ?>
                                <?php echo $form->error($model,'password') ?>
                            </dd>
                        </dl>
                        <dl class="clearfix">
                            <dt><font class="red">*</font><?php echo Yii::t('memberMember','确定新密码'); ?>：</dt>
                            <dd>
                                <?php echo $form->passwordField($model,'confirmPassword',array('class'=>'inputtxt','value'=>''))?>
                                <?php echo $form->error($model,'confirmPassword') ?>
                            </dd>
                        </dl>

                        <dl class="clearfix">
                            <dt><?php echo $model->getAttributeLabel('mobile') ?>：</dt>
                            <dd>
                                <?php echo $model->mobile ?>
                                <?php echo $form->hiddenField($model,'mobile') ?>
                            </dd>
                        </dl>

                        <dl class="clearfix">
                            <dt><font class="red">*</font><?php echo $model->getAttributeLabel('mobileVerifyCode') ?>：</dt>
                            <dd>
                                <?php echo $form->textField($model,'mobileVerifyCode',array('class'=>'inputtxt50')) ?>
                                <?php echo $form->error($model,'mobileVerifyCode') ?>
                            </dd>
                            <dd class="flRight">
                                <a href="#" class="sendCode02" id="sendMobileCode">
                                    <span data-status="1"><?php echo Yii::t('memberMember','获取验证码'); ?></span>
                                </a>
                            </dd>
                        </dl>
                        <?php echo CHtml::submitButton(Yii::t('memberMember','确定'),array('class'=>'passQdBtn')) ?>
                        <?php $this->endWidget() ?>

                    </div>
                    <div class="passPic">
                        <?php if(Yii::app()->user->hasFlash('success')): ?>
                        <!--重置修改密码成功弹窗内容-->
                        <div class="passPic_t">
                            <span class="rightIcon"></span>
                            <span class="fl"><b class="txt"><?php echo $this->getFlash('success') ?></b>
                                <p class="gay95"><?php echo Yii::t('memberMember','盖网提醒您，请保管好您的密码！');?></p>
                            </span>
                        </div>
                        <!--重置修改密码成功弹窗内容-->
                        <?php endif; ?>
                        <div class="passPic_b">
                            <ul>
                                <li>
                                    <p class="Title_1"></p>

                                    <p class="content"><span class="contentIcon_1"></span></p>
                                </li>
                                <li>
                                    <p class="Title_2"></p>

                                    <p class="content"><span class="contentIcon_2"></span></p>
                                </li>
                                <li>
                                    <p class="Title_3"></p>

                                    <p class="content"><span class="contentIcon_3"></span></p>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>
<?php echo $this->renderPartial('/home/_sendMobileCodeJs'); ?>
<script type="text/javascript">
    $(function () {
        sendMobileCode2("#sendMobileCode");
    });
</script>