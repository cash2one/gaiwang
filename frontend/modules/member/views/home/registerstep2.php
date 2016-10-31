<?php
//注册后手机验证模板
/* @var $this HomeController */
/* @var $model Member */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/regLogin.js');
?>
<div class="top">
    <ul class="regTab clearfix">
        <li class="curr">
            <span>
                <?php echo $this->getParam('mobile') ? Yii::t('memberHome','企业用户注册') : Yii::t('memberHome','普通用户注册'); ?>
            </span>
        </li>
    </ul>
</div>
<div class="registerCon">
    <div class="regStep">
        <ul class="s2 clearfix">
            <li><?php echo Yii::t('memberHome','1.填写账户信息'); ?></li>
            <li><?php echo Yii::t('memberHome','2.验证账户信息'); ?></li>
            <li><?php echo Yii::t('memberHome','3.完成注册'); ?></li>
        </ul>
    </div>

    <div class="regForm clearfix">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => $this->id . '-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'focus' => array($model, 'mobile'),
        ));
        ?>
        <table width="410" border="0" cellspacing="0" cellpadding="0" class="regFormTable left">
            <tr>
                <th><span class="red">*</span><?php echo Yii::t('memberHome','您的手机号码'); ?>：</th>
                <td>
                    <?php echo $form->textField($model, 'mobile', array(
                        'class' => 'inputtxt',
                        'style' => 'width:305px',
                        'value'=>$this->getParam('mobile'),
                    )); ?>
                    <?php echo $form->error($model, 'mobile'); ?>
                </td>
            </tr>
            <tr>
                <th><span class="red">*</span><?php echo $form->label($model, 'mobileVerifyCode') ?>：</th>
                <td>
                    <?php echo $form->textField($model, 'mobileVerifyCode', array('class' => 'inputtxt', 'style' => 'width:305px')); ?>
                    &nbsp;
                    <a href="#" class="sendMobileCode" id="sendMobileCode">
                        <span data-status="1"><?php echo Yii::t('memberHome','获取验证码'); ?></span>
                    </a>
                </td>
            </tr>

            <tr>
                <th><span class="red">*</span><?php echo Yii::t('memberHome','国家/地区：'); ?></th>
                <td>
                    <div class="selectBox">
                        <?php echo $form->hiddenField($model, 'country_id', array('value' => 1)) ?>
                        <span class="value"><?php echo Yii::t('memberHome','中国'); ?></span>
                        <ul class="options">
                            <li data-id="1"><a href="#"><?php echo Yii::t('memberHome','中国'); ?></a></li>
                            <li data-id="2"><a href="#"><?php echo Yii::t('memberHome','韩国'); ?></a></li>
                            <li data-id="3"><a href="#"><?php echo Yii::t('memberHome','日本'); ?></a></li>
                            <li data-id="35"><a href="#"><?php echo Yii::t('memberHome','台湾省'); ?></a></li>
                            <li data-id="36"><a href="#"><?php echo Yii::t('memberHome','香港特别行政区'); ?></a></li>
                            <li data-id="37"><a href="#"><?php echo Yii::t('memberHome','澳门特别行政区'); ?></a></li>
                        </ul>
                    </div>

                </td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td class="do">
                    <?php //echo CHtml::imageButton(DOMAIN.'/images/bg/nextStep.gif', array('alt' => Yii::t('memberHome','下一步'))) ?>
                    <?php echo CHtml::submitButton(Yii::t('memberHome','下一步'), array('type'=>'button','name'=>'yt0','value'=>'下一步','class'=>'nextBtn'))?>
                </td>
            </tr>
        </table>
        <?php $this->endWidget(); ?>

    </div>
</div>
<?php echo $this->renderPartial('_sendMobileCodeJs'); ?>
<script type="text/javascript">
    $(function () {
        sendMobileCode("#sendMobileCode","#Member_mobile");
    });
</script>