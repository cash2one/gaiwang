<?php
/* @var $this  HomeController */
/** @var $model Member */
/** @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberMember', '账号管理') => '',
    Yii::t('memberMember', '基本信息修改')=>'',
    Yii::t('memberMember', '修改绑定手机'),
);
?>
<div class="mbRight">
<div class="EntInfoTab">
    <ul class="clearfix">
        <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberMember','修改绑定手机');?></span></a></li>
    </ul>
</div>
<div class="mbRcontent">

<a href="javascript:void(0)" class="mbTip mgtop10">
    <span class="mbFault"></span>
    <?php echo Yii::t('memberMember', ' 为了保证您的帐号安全，更换绑定手机号码前请先进行安全验证'); ?>
</a>
<div class="mbDate1">
<div class="mbDate1_t"></div>
<div class="mbDate1_c">
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
    <table width="890" border="0" cellpadding="0" cellspacing="0" class="tableBank updateBase">
        <tbody>

        <tr>
            <td height="30" colspan="3" align="center" class="dtffe"><b><?php echo Yii::t('memberMember', '手机绑定'); ?></b></td>
        </tr>
        <tr>
            <td height="30" align="center" class="dtEe">
                <?php echo $form->labelEx($model, 'mobile') ?>
            </td>
            <td colspan="2" class="dtFff pdleft20">
                <?php echo $model->mobile ?>
            </td>
        </tr>
        <tr>
            <td height="30" align="center" class="dtEe">
                登录密码 <span class="required">*</span>：
            </td>
            <td colspan="2" class="dtFff pdleft20">
                <?php echo $form->passwordField($model, 'password', array('class'=>'inputtxt','value'=>'')) ?>
                <?php echo $form->error($model,'password') ?>
            </td>
        </tr>

        <tr>
            <td height="30" align="center" class="dtEe">
                <?php echo $form->labelEx($model, 'mobile2') ?>：
            </td>
            <td colspan="2" class="dtFff pdleft20">
                <?php echo $form->textField($model, 'mobile2', array('class' => 'inputtxt')) ?>
                <?php echo $form->error($model,'mobile2') ?>
            </td>
        </tr>
        <tr>
            <td height="30" align="center" class="dtEe">
                <?php echo $form->labelEx($model, 'mobileVerifyCode2') ?>：
            </td>
            <td colspan="2" class="dtFff pdleft20">
                <?php echo $form->textField($model, 'mobileVerifyCode2', array('class' => 'inputtxt', 'style' => 'width:170px;float:left;')) ?>&nbsp;
                <a href="#" class="sendMobileCode" id="sendMobileCode2">
                    <span data-status="1"><?php echo Yii::t('memberMember', '获取验证码'); ?></span>
                </a>
                <?php echo $form->error($model, 'mobileVerifyCode2'); ?>
            </td>
        </tr>

        </tbody>
    </table>
    <?php echo CHtml::submitButton(Yii::t('memberMember','确定'), array('class' => 'bankBtn', 'style' => 'cursor:pointer')) ?>
    <?php $this->endWidget(); ?>
</div>
<div class="mbDate1_b"></div>
</div>
</div>
</div>
<?php echo $this->renderPartial('/home/_sendMobileCodeJs'); ?>
<script type="text/javascript">
    $(function() {
        //sendMobileCode2("#sendMobileCode");
        sendMobileCode("#sendMobileCode2","#Member_mobile2");
    });
</script>