<?php
/**
 * Created by PhpStorm.
 * User: binbin.liao
 * Date: 2014/12/2
 * Time: 16:15
 */
?>
<?php
if(!$this->isMobile): ?>
    <script src="<?php echo DOMAIN.'/js/jquery.blockUI.js'?>"></script>
    <script>
        $(document).ready(function () {
            $.blockUI({
                message: $('#bindMobile'),
                cursorReset: 'pointer',
                css:{
                    cursor:'hand',
                    width:'35%'
                },
                overlayCSS:{
                    cursor:'hand'
                }
            });

        });
    </script>
<?php endif; ?>
<div id="bindMobile" style="display: none">
    <p>
        亲爱的 <span><?php echo isset($member->username) ? $member->username : $member->gai_number  ?></span>，为了您的账号安全，请您绑定手机！
    </p>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'redEnvelope-form',
        'action' => $this->createAbsoluteUrl('/member/redEnvelope/index'),
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <table class="bindTable">
        <tr>
            <td class="bindTable-td-1"><span class="red">*</span> <?php echo $form->labelEx($member,'mobile'); ?></td>
            <td class="alginLeft bindTable-td-2" colspan="2">
                <?php echo $form->textField($member,'mobile',array('class'=>'integaralIpt1')) ?>
                <?php echo $form->error($member, 'mobile'); ?>
            </td>

        </tr>
        <tr>
            <td><span class="red">*</span> <?php echo $form->labelEx($member,'mobileVerifyCode'); ?></td>
            <td class="alginLeft">
                <?php echo $form->textField($member,'mobileVerifyCode',array('class'=>'integaralIpt1','style'=>'width:100px')) ?>
                <?php echo $form->error($member, 'mobileVerifyCode'); ?>
            </td>
            <td class="alginLeft bindTable-td-3">
                <span class="bind-sendMobileCode" id="bind-sendMobileCode" data-status="1">
                    <span>获取验证码</span>
                </span>
            </td>
        </tr>
        <tr><td colspan="3"><?php echo  CHtml::submitButton('确定',array('class'=>"integaralBtn4")); ?></td> </tr>

    </table>

    <?php $this->endWidget(); ?>
</div>
<script>
    $(function(){
        $("#member-form").remove(); //避免跟上一级的重复
        sendMobileCode('#bind-sendMobileCode','#redEnvelope-form #Member_mobile',function(){ return true;});
    });

</script>