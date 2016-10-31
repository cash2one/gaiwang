<?php
/**
 * 重置密码视图
 */
/** @var HomeController $this */
/** @var CActiveForm $form */
/** @var Member $model */
?>
<div class="resetPass">
    <div class="top clearfix">
        <h2><span><?php echo Yii::t('memberHome', '找回密码'); ?></span></h2>
    </div>
    <div class="resetPassCon">
        <div class="resetPassStep">
            <ul class="s1 clearfix">
                <li><?php echo Yii::t('memberHome', '1.填写账户信息'); ?></li>
                <li><?php echo Yii::t('memberHome', '2.成功获取新密码'); ?></li>
            </ul>
        </div>
        <div class="resetPassForm">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => $this->id . '-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            if ($model->id):

                ?>
                <table width="410" border="0" cellspacing="0" cellpadding="0" class="resetPassTable">
                    <tr>
                        <th><?php echo $form->label($model, 'gai_number'); ?>：</th>
                        <td>
                            <?php echo $model->gai_number ?>
                        </td>
                    </tr>
                    <tr>
                        <th><span class="red">*</span><?php echo $form->label($model, 'mobile'); ?>：</th>
                        <td>
                            <?php echo $form->textField($model, 'mobile', array('class' => 'inputtxt', 'style' => 'width:305px','readOnly'=>'readOnly')); ?>
                            <?php echo $form->error($model, 'mobile') ?>
                        </td>
                    </tr>
                    <tr>
                        <th><span class="red">*</span><?php echo $form->label($model, 'mobileVerifyCode'); ?>：</th>
                        <td>
                            <?php echo $form->textField($model, 'mobileVerifyCode', array('class' => 'inputtxt', 'style' => 'width:115px')); ?>
                            &nbsp;
                            <a href="#" class="sendMobileCode" id="sendMobileCode">
                                <span data-status="1"><?php echo Yii::t('memberHome', '获取验证码'); ?></span>
                            </a>
                            <?php echo $form->error($model, 'mobileVerifyCode') ?>
                        </td>
                    </tr>
                    <tr>
                        <th><span class="red">*</span><?php echo Yii::t('memberHome', '新密码'); ?>：</th>
                        <td>
                            <?php echo $form->passwordField($model, 'password', array('class' => 'inputtxt inputtxtbg', 'style' => 'width:305px')); ?>
                            <?php echo $form->error($model, 'password') ?>
                        </td>
                    </tr>
                    <tr>
                        <th><span class="red">*</span><?php echo $form->label($model, 'confirmPassword'); ?>：</th>
                        <td>
                            <?php echo $form->passwordField($model, 'confirmPassword', array('class' => 'inputtxt inputtxtbg', 'style' => 'width:305px')); ?>
                            <?php echo $form->error($model, 'confirmPassword') ?>
                            <?php echo $form->hiddenField($model,'id',array('value'=>Tool::authcode($model->id))) ?>
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td class="do">
                            <?php //echo CHtml::imageButton(DOMAIN . '/images/bg/btnSubmit01.gif', array('alt' => Yii::t('memberHome', '提交'))) ?>
                            <?php echo CHtml::submitButton(Yii::t('memberHome','下一步'), array('type'=>'button','name'=>'yt0','value'=>'提交','class'=>'nextBtn'))?>
                        </td>
                    </tr>
                </table>
                <?php

            else:
                ?>

                <table width="410" border="0" cellspacing="0" cellpadding="0" class="resetPassTable">
                    <tr>
                        <th><span class="red">*</span><?php echo Yii::t('memberHome','账号')?>：</th>
                        <td>
                            <?php echo $form->textField($model, 'username', array(
                                'class' => 'inputtxt',
                                'style' => 'width:305px',
                                'placeholder'=>'请输入您的已验证手机/盖网编号/用户名',
                            )); ?>
                            <br/>
                            <?php echo $form->error($model, 'username') ?>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <?php if($members): ?>
                            <br/>
                            <select id="Member_gai_number" name="Member[gai_number]">
                                <?php foreach($members as $v): ?>
                                <option value="<?php echo $v->gai_number ?>"><?php echo $v->gai_number,' ',$v->username; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?php echo $form->labelEx($model, 'verifyCode'); ?>：</th>
                        <td>
                            <?php echo $form->textField($model, 'verifyCode', array('class' => 'inputtxt', 'style' => 'width:115px')); ?>&nbsp;
                            <a onclick="changeVeryfyCode()" class="changeCode" style="cursor: pointer">
                                <?php
                                $this->widget('CCaptcha', array(
                                    'showRefreshButton' => false,
                                    'clickableImage' => true,
                                    'id' => 'verifyCodeImg',
                                    'imageOptions' => array(
                                        'alt' => Yii::t('memberHome', '点击换图'),
                                        'title' => Yii::t('memberHome', '点击换图'),
                                    )
                                ));
                                ?>
                            </a>
                            <?php echo $form->error($model, 'verifyCode'); ?>
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td class="do">
                            <?php //echo CHtml::imageButton(DOMAIN . '/images/bg/btnSubmit01.gif',array('alt' => Yii::t('memberHome', '下一步'))) ?>
                            <?php echo CHtml::submitButton(Yii::t('memberHome','下一步'), array('type'=>'button','name'=>'yt0','value'=>'提交','class'=>'nextBtn'))?>
                        </td>
                    </tr>

                </table>

            <?php
            endif;
            $this->endWidget();
            ?>
        </div>
    </div>
</div>
<?php echo $this->renderPartial('_sendMobileCodeJs'); ?>
<script type="text/javascript">
    $(function () {
        sendMobileCode("#sendMobileCode", "#Member_mobile");
    });
</script>