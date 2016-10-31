<?php $url="http://member.newgatewang.com/quickPay/bindGht"?>

<div class="shopping-bg ght-bg">
    <div class="shopping-pay">
        <?php 
            $form = $this->beginWidget('ActiveForm',array(
                        'id'=>$this->id .'_form',
                        'enableClientValidation'=>true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true
                        )
                    ));
        ?>
        <div class="orders-successfully">
            <div class="orders-title ght-title2"><span>持卡人信息</span></div>
            <?php if($model->card_type == '01'):?>
            <table class="ght-tabInfo">
                <tr>
                    <td class="ght-td"><?php echo $form->label($model,'bank_num')?>：</td>
                    <td><?php 
                            echo $form->textField($model,'bank_num',array(
                                'class'=>'ght-numInp',
                                'placeholder'=>Yii::t('PayAgreement','银行卡号'),
                                'onbeforepaste'=>"clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))",
                                'onkeyup'=>"value=value.replace(/[^\d]/g,'')",
                                'maxlength'=>'19'
                            ));
                        ?>
                        <?php echo  $form->error($model,'bank_num')?>
                    </td>
                </tr>
                <tr>
                    <td class="ght-td"><?php echo $form->label($model,'accountName')?>：</td>
                    <td>
                        <?php echo $form->textField($model,'accountName',array('class'=>'ght-numInp','placeholder'=>Yii::t('PayAgreement','请输入持卡人姓名'),'maxlength'=>10))?>
                        <?php echo  $form->error($model,'accountName')?>
                    </td>
                </tr>
                <tr>
                    <td class="ght-td"><?php echo $form->label($model,'certificateNo')?>：</td>
                    <td>
                        <?php echo $form->textField($model,'certificateNo',array('class'=>'ght-numInp','placeholder'=>Yii::t('PayAgreement','请输入身份证号'),'maxlength'=>18))?>
                        <?php echo  $form->error($model,'certificateNo')?>
                    </td>
                </tr>
            </table>
            <?php else:?>
                <table class="ght-tabInfo">
                    <tbody>
                        <tr>
                            <td class="ght-td"><?php echo $form->label($model, 'bank_num') ?>：</td>
                            <td><?php
                                echo $form->textField($model, 'bank_num', array(
                                    'class' => 'ght-numInp',
                                    'placeholder' => Yii::t('PayAgreement', '银行卡号'),
                                    'onbeforepaste' => "clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))",
                                    'onkeyup' => "value=value.replace(/[^\d]/g,'')",
                                    'maxlength' => '19'
                                ));
                                ?>
                                <?php echo $form->error($model, 'bank_num') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="ght-td"><?php echo  $form->label($model,'valid')?>：</td>
                            <td>
                                <?php echo $form->textField($model,'valid',array(
                                        'class'=>'ght-nameInp',
                                        'placeholder'=>Yii::t('payAgreement','请输入有效时间'),
                                        'onbeforepaste' => "clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))",
                                        'onkeyup' => "value=value.replace(/[^\d]/g,'')",
                                    ))?>
                                <?php echo $form->error($model,'valid')?>
                            </td>
                        </tr>
                        <tr>
                            <td class="ght-td"><?php echo $form->label($model,'cvn2')?>：</td>
                            <td>
                                <?php echo $form->textField($model,'cvn2',array('class'=>'ght-nameInp','placeholder'=>Yii::t('payAgreement','请输入CVN2码')))?>
                                <?php echo $form->error($model,'cvn2')?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <?php endif;?>
                <div class="orders-title ght-title2"><span>验证信息</span></div>
                <table class="ght-tabInfo">
                        <tr>
                                <td class="ght-td"><?php echo $form->label($model,'mobile')?>：</td>
                                <td>
                                    <?php echo $form->textField($model,'mobile',array(
                                            'class'=>'ght-numInp','placeholder'=>Yii::t('PayAgreement','请输入银行卡预留手机号'),'maxlength'=>13))?>
                                    <?php echo  $form->error($model,'mobile')?>
                                </td>
                        </tr>
                        <tr>
                            <td class="ght-td"><?php echo Yii::t('PayAgreement','短信验证码')?>：</td>
                            <td>
                                <?php echo $form->textField($model,'messageId',array('class'=>'ght-yzInp'))?>
                                <span class="ght-hq" id="sendMobile"><?php echo Yii::t('PayAgreement','免费获取')?></span>
                                &nbsp;<?php echo $form->error($model,'messageId')?>
                                <?php echo $form->hiddenField($model,'messageCode')?>
                            </td>
                        </tr>
                        <tr>
                            <td class="ght-td">&nbsp;</td>
                            <?php 
                                echo $form->hiddenField($model,'card_type');
                                echo $form->hiddenField($model,'bank');
                                echo $form->hiddenField($model,'certificateType',array('value'=>'ZR01'));
//                                echo $form->hiddenField($model,);
                            ?>
                            <td><?php echo CHtml::submitButton('确定',array('class'=>'pay-confirm-btn ght-but2'))?></td>
                        </tr>
                </table>
        </div>
        <?php $this->endWidget();?>
    </div>
</div>
<!-- 主体end -->
<script>
 $("#sendMobile").click(function(){
	var mobile=$("#PayAgreement_mobile").val();
        
        if(jQuery.trim(mobile) == '') {
            $('#PayAgreement_mobile_em_').text('<?php echo Yii::t('payAgreement','手机号码不能为空白')?>').show();
            return false;
        }
	$.ajax({ 
            type:"POST",
            url:"<?php echo $this->createAbsoluteUrl('/member/quickPay/sendMsg');?>",
            dataType:'json',
            data: {
                "mobilePhone":mobile,
                "YII_CSRF_TOKEN":'<?php echo Yii::app()->request->csrfToken?>',
            },
            success:function(data){
                var req = data.reqMsgId;
                $('#PayAgreement_messageCode').val(req);
            }
       });
})
</script>