<?php
/** @var Member $model2 */
/** @var CActiveForm $form */
/** @var HomeController $this */
$model2 = new Member('quickRegister');
?>
<div class="keyReg fl">
        <?php
        $ad = isset($_GET['ad'])?'ad='.$_GET['ad']:'';
        $form = $this->beginWidget('ActiveForm', array(
            'id' => $this->id . '-form2',
            'action' => array('home/quickRegister?'.$ad),
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
?>
    <table cellspacing="0" cellpadding="0" border="0" width="370" class="keyReg_t">
        <tbody>
        <tr>
            <th colspan="2" class="regTit">极速注册-只需简单一步</th>
        </tr>
        <tr>
            <th><span class="red">*</span><?php echo $form->label($model2, 'username'); ?>：</th>
            <td>
                <?php echo $form->textField($model2, 'username', array('class' => 'inputtxt error')); ?>
                <?php echo $form->error($model2, 'username'); ?>
            </td>
        </tr>
        <tr>
            <th><span class="red">*</span><?php echo $form->label($model2, 'password'); ?>：</th>
            <td>
				<div class="pwd_c">
					<?php echo $form->passwordField($model2, 'password', array('class' => 'inputtxt passInputtxt showPwd')); ?>
					<a href="javascript:;" class="passOn passOff passOff3" id="show_password"></a>
				</div>
                <?php echo $form->error($model2, 'password'); ?>
            </td>
        </tr>

        <tr>
            <th><span class="red">*</span><?php echo $form->label($model2, 'verifyCode'); ?>：</th>
            <td>
                <?php echo $form->textField($model2, 'verifyCode', array('class' => 'inputtxt codeInputtxt')); ?>&nbsp;
                <a href="javascript::void();" class="changeCode" style="cursor: pointer">
                    <?php
                    $this->widget('CCaptcha', array(
                        'showRefreshButton' => false,
                        'clickableImage' => true,
                        'id' => 'verifyCodeImgQuick',
                        'captchaAction'=>'captcha',
                        'imageOptions' => array(
                            'alt' => Yii::t('memberHome', '点击换图'),
                            'title' => Yii::t('memberHome', '点击换图'),
                        )
                    ));
                    ?>
                </a>
                <?php echo $form->error($model2, 'verifyCode'); ?>

            </td>
        </tr>
        <tr class="ta_c" >
            <td colspan="2">
                <?php echo CHtml::link(Yii::t('memberHome', '《盖象商城用户入驻协议》'), $this->createUrl('/help/article/agreement'), array('target' => '_blank','class'=>'agreement')); ?>
            </td>
        </tr>
        <tr class="ta_c">
            <td colspan="2" class="do">
                <?php if($this->getParam('code')): ?>
                <?php echo $form->hiddenField($model2,'tmp_referrals_id',array('value'=>Tool::lowEncrypt(rawurldecode($this->getParam('code')),'DECODE'))) ?>
                <?php endif; ?>
                <?php echo CHtml::submitButton('同意协议并一键注册',array('class'=>'regBtn')) ?>
            </td>
        </tr>
        </tbody>
    </table>
    <?php $this->endWidget(); ?>
</div>
<script>
    $(function(){
        // 先取得 #password1 及產生一個文字輸入框
        var $password = $('.showPwd');
        var $passwordInput = $('<input type="text" name="' + $password.attr('name') + '" class="' + $password.attr('class') + '" />');
//        console.log($passwordInput);
        $('#show_password').toggle(
            // 用 $passwordInput 來取代 $password
            // 並把 $passwordInput 的值設為 $password 的值
            function(){
                $password.replaceWith($passwordInput.val($password.val()));
                $('#show_password').removeClass('passOff');
            },
            // 用 $password 來取代 $passwordInput
            // 並把 $password 的值設為 $passwordInput 的值
            function(){
                $passwordInput.replaceWith($password.val($passwordInput.val()));
                $('#show_password').addClass('passOff');
            }
        );
    });
</script>
