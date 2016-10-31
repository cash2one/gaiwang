<?php
/* @var $this ApplyCashController */
/* @var $memberModel Member */
/* @var $form CActiveForm */
/** @var $bankModel BankAccount */
/** @var $validateForm ValidatePasswordForm */
$this->breadcrumbs = array(
    Yii::t('memberApplyCash', '积分管理'),
    Yii::t('memberApplyCash', '兑现确认'),
);
?>
<div class="mbRight">
	<div class="EntInfoTab">
		<ul class="clearfix">
			<li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberApplyCash','兑现确认')?></span></a></li>
		</ul>
	</div>
    <div class="mbRcontent">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'cash-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="mgtop20 upladBox "><h3> <?php echo Yii::t('memberApplyCash', '兑现确认'); ?></h3></div>
                <div class="upladBox">
                    <span class="integralCnTxt1"><?php echo Yii::t('memberApplyCash', '1.申请兑现'); ?></span>
                    <span class="integralCnTxt2"><?php echo Yii::t('memberApplyCash', '2.确认兑现'); ?></span>
                    <span class="integralCnTxt3"><?php echo Yii::t('memberApplyCash', '3.兑现完成'); ?></span>
                </div>
                <div class="upladBox mgtop20 mgbottom20">
                    <a class="integralBg"></a>
                    <span class="integralCnIcon1"></span>
                    <span class="integralCnIcon2" style=" background-position: -799px -86px;"></span>
                    <span class="integralCnIcon3"></span>
                </div>

                <table width="890" border="0" cellpadding="0" cellspacing="0" class="tableBank">
                    <tr>
                        <td width="180" height="50" align="right" class="dtEe">
                            <b><?php echo $bankModel->getAttributeLabel('account_name')  ?>：</b>
                        </td>
                        <td height="50" colspan="2" class="pdleft20"><?php echo $bankModel->account_name ?></td>
                    </tr>
                    <tr>
                        <td width="180" height="50" align="right" class="dtEe">
                            <b><?php echo Yii::t('memberApplyCash','提现银行卡号'); ?>：</b>
                        </td>
                        <td height="50" colspan="2" class="pdleft20">
                            <?php echo $bankModel->account ?>
                            <?php echo $bankModel->bank_name ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="180" height="50" align="right" class="dtEe">
                            <b><?php echo Yii::t('memberApplyCash','金额'); ?>：</b>
                        </td>
                        <td height="50" colspan="2" class="pdleft20">￥ <?php echo $this->getParam('money') ?></td>
                    </tr>
                    <tr>
                        <td width="180" height="50" align="right" class="dtEe">
                            <b><?php echo $form->labelEx($validateForm,'password2') ?>：</b>
                        </td>
                        <td height="50" colspan="2" valign="middle" class="pdleft20">
                            <?php echo $form->passwordField($validateForm,'password2',array('class'=>'editinput140 mgright5')) ?>
                            <?php echo CHtml::link('修改二级密码',
                                $this->createAbsoluteUrl('member/setPassword2'),array('class'=>'ftstyle')); ?>
                            <div style="position: relative;clear: both">
                                <?php echo $form->error($validateForm,'password2') ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="180" height="50" align="right" class="dtEe">
                            <b><?php echo $form->labelEx($validateForm,'mobile') ?>：</b>
                        </td>
                        <td height="50" colspan="2" valign="middle" class="pdleft20">
                            <?php echo $form->hiddenField($validateForm,'mobile',array('value'=>$memberModel->mobile)) ?>
                            <?php echo $memberModel->mobile ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="180" height="50" align="right" class="dtEe">
                            <b><?php echo $form->labelEx($validateForm,'mobileVerifyCode'); ?>：</b>
                        </td>
                        <td height="50" colspan="2" valign="middle" class="pdleft20">
                            <?php echo $form->textField($validateForm,'mobileVerifyCode',
                                array('class'=>'integaralIpt2 mgright5','style'=>'width:170px')) ?>&nbsp;
                            <a id="sendMobileCode2" class="sendMobileCode"><span data-status="1">
                                    <?php echo Yii::t('memberApplyCash','获取验证码'); ?></span></a>
                            <?php echo $form->error($validateForm,'mobileVerifyCode'); ?>
                        </td>
                    </tr>
                </table>

                <?php echo CHtml::link('','',array('class'=>'integralQdBtn')); ?>
            </div>
            <div class="mbDate1_b"></div>

        </div>

        <?php $this->endWidget() ?>
    </div>
</div>
<?php $this->renderPartial('/home/_sendMobileCodeJs'); ?>
<script type="text/javascript">
    $(function(){
        sendMobileCode2('#sendMobileCode2');
    });
</script>
<script>
    $(".integralQdBtn").click(function(){
        $('form').submit();
    });
</script>