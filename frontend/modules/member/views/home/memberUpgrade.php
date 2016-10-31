<?php Yii::app ()->clientScript->registerScriptFile(DOMAIN . '/js/dialog.js'); ?>
<style>
    .register{
        width: 1200px;
    }
</style>
<!--注册-->
<div class="register registerUpdate">
    <div class="title"><h3><?php echo Yii::t('memberHome', '普通用户升级企业用户') ?></h3></div>


    <div class="content clearfix">
        <div class="step step01"></div>
        <script type="text/javascript">
            var changeMobile = '<?php echo Yii::app()->createAbsoluteUrl('member/site/index') ?>';
            var longinLable = '<?php echo Yii::t('memberHome', '马上登录') ?>';
            var no_mobile_message = "<?php echo Yii::t('memberHome', '你还未绑定手机号码，请登录并绑定手机号码后，') ?><br/><?php echo Yii::t('memberHome', '再重新提交升级申请。') ?>";
        </script>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'member-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => "js:function(form, data, hasError){
                    if (!hasError) {
                        if(typeof(data.Member_password) != 'undefined' && data.Member_password != ''){
                            $('#tips_message').html(data.Member_password);
                            $('#do_message').html('<input type=\"button\" id=\"closeButton\" class=\"btnActiveLogin\" onclick=\"closeTips()\" value=\"确定\"></input>');
                        }else{
                            if(data.Member_errType == 'no_mobile'){
                                $('#tips_message').html(no_mobile_message);
                                $('#do_message').html('<a href=\"'+ changeMobile + '\" class=\"btnActiveLogin\">'+ longinLable +'</a>');
                            }else {
                                return true;
                            }
                        }
                        activePhoneTips();
                        return false;
                    }else{
                        return true;
                    }
                }",
            ),
        ));
        ?>
        <table cellspacing="0" cellpadding="0" border="0" width="100%" class="regUp_t ">
            <tbody>
                <tr>
                    <th width="260"><label for="Member_gai_number">你的盖网编号</label>&nbsp;<span class="red">*</span>：</th>
                    <td>
                        <?php echo $form->textField($model, 'gai_number', array('class' => 'inputtxt error')); ?>
                    </td>
                </tr>
                <tr>
                    <th><label for="Member_password">密码</label>&nbsp;<span class="red">*</span>：</th>
                    <td class="td_pass">
                        <?php echo $form->passwordField($model, 'password', array('class' => 'inputtxt passInputtxt')); ?>
                        <a href="#" class="passOn passOff" id="passSwitch"></a>
                    </td>
                </tr>
                <tr>
                    <th><label for="enterprise_service_id">招商人员服务编号 (选填)</label>：</th>
                    <td>
                        <?php echo $form->textField($enterprise, 'service_id', array('class' => 'inputtxt')); ?>
                        <?php echo $form->error($enterprise, 'service_id'); ?>
                    </td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td class="do">
                        <?php echo CHtml::submitButton(Yii::t('memberHome','同意协议并注册'), array('type'=>'submit','name'=>'yt0','value'=>'同意协议并注册','class'=>'regBtn'))?>
                        <br/>
                        <?php echo CHtml::link(Yii::t('memberHome', '《盖象商城用户入驻协议》'), $this->createUrl('/help/article/agreementEnterprise'), array('target' => '_blank','class'=>'agreement')); ?>
                    </td>
                </tr>
            </tbody>
            <?php $this->endWidget() ?>
        </table>
        <?php $this->renderPartial('_kefu') ?>
    </div>
    <div class="weiXin clearfix">
        <?php $this->renderPartial('_weixin') ?>
    </div>
</div>
<div class="activePhoneTips" id="activePhoneTips" style="display:none;">
    <p class="tips" id="tips_message"></p>
    <div class="do" id="do_message">
        <a href="<?php echo Yii::app()->createAbsoluteUrl('member/site/index') ?>" class="btnActiveLogin"><?php echo Yii::t('memberHome', '马上登录') ?></a>
    </div>
</div>
<script type="text/javascript">
    var mapDialogIframe = new Dialog({type:'id', value:'activePhoneTips', width:'430px',height:'210px'}, {title:'<?php echo Yii::t('memberHome', '信息提示')?>'});
    function activePhoneTips(){
        mapDialogIframe.show();        ;
    }
    function closeTips(){
        mapDialogIframe.hide();
    }

</script>
