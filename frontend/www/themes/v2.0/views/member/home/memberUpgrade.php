<div class="wrap">
    <div class="pages-header">
        <div class="w1200">
            <div class="pages-logo"><a href="<?php echo DOMAIN?>"><img src="<?php echo DOMAIN?>/themes/v2.0/images/temp/register_logo.jpg" width="213" height="86" /></a></div>
            <div class="pages-title icon-cart"><?php echo Yii::t('home','欢迎升级')?></div>
        </div>
    </div>

    <div class="main w1200">
        <div class="register-upgrade">
            <?php
            $form = $this->beginWidget('ActiveForm', array(
                'id' => 'member-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
            <div class="upgrade_top clearfix">
                <div class="left">
                    <?php echo Yii::t('home','普通用户升级企业用户')?>
                </div>
                <div class="right">
                    <span class="on"><i class="icon-cart">1</i><?php echo Yii::t('home','提交升级申请')?></span>
                    <span><i class="icon-cart">2</i><?php echo Yii::t('home','提交资质并等待审核')?></span>
                    <span><i class="icon-cart">3</i><?php echo Yii::t('home','资质审核成功，升级完成')?></span>
                </div>
            </div>
            <div class="upgrade_conter">
                <table class="register-tab register-tab-sj">
                    <tr>
                        <td class="register-tab-sj-title"><span><i>*</i><?php echo Yii::t('home','你的盖网编号')?>:</span></td>
                        <td>
                            <?php echo $form->textField($model, 'gai_number', array('class' => 'input-gw')); ?>
                            <?php echo $form->error($model, 'gai_number'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td  class="register-tab-sj-title"><span><i>*</i><?php echo Yii::t('home','密码')?>:</span></td>
                        <td>
                            <?php echo $form->passwordField($model, 'password', array('class' => 'input-password')); ?>
                            <?php echo $form->error($model, 'password'); ?>

                        </td>
                    </tr>
                    <tr>
                        <td  class="register-tab-sj-title"><span><?php echo Yii::t('home','招商人员服务编号(选填)')?>:</span></td>
                        <td>
                            <?php echo $form->textField($enterprise, 'service_id', array('class' => 'input-number')); ?>
                            <?php echo $form->error($enterprise, 'service_id'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p><span>&nbsp;</span>
                                <?php echo CHtml::link(Yii::t('memberHome', '《盖象商城用户入驻协议》'), $this->createUrl('/help/article/agreementEnterprise'), array('class'=>'agreement')); ?>
                            </p>
                            <p><span>&nbsp;</span>
                                <?php echo CHtml::submitButton(Yii::t('memberHome','同意协议并注册'), array('type'=>'submit','name'=>'yt0','value'=>'同意协议并升级','class'=>'btn-dete'))?>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            <?php $this->endWidget() ?>
        </div>
    </div>

</div>
