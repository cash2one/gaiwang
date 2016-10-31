<?php
/* @var $this  HomeController */
/** @var $model Member */
/** @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberMember', '账号管理') => '',
    Yii::t('memberMember', '升级为企业会员'),
);
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberMember','升级为企业会员');?></span></a></li>
        </ul>
    </div>
    <div class="mbRcontent">

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="mgtop20 upladBox integaralbd pdbottom10">
                    <span class="pwdstep01_1 fl mgleft14"></span>
                    <span class="fl mgleft14">
                            <h3 class="mgtop10"><?php echo Yii::t('memberMember','提示'); ?></h3>
                            <p class="gay95 "><?php echo Yii::t('memberMember','您好，升级成企业会员后，贵公司需要完成网络店铺签约认证才可以可享受在盖象商城开店并销售商品等一系列的优质服务。'); ?></p>
                    </span>
                </div>


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
                        <table cellspacing="0" cellpadding="0" border="0" width="100%" class="reg_t comReg_t fl" >
                            <?php if(!$model->referrals_id): ?>
                            <tr>
                                <th><?php echo $form->label($model, 'tmp_referrals_id'); ?>：</th>
                                <td>
                                    <?php echo $form->textField($model, 'tmp_referrals_id', array('class' => 'inputtxt','style'=>'width:200px;')); ?>
                                    <?php echo $form->error($model, 'tmp_referrals_id'); ?>(选填)
                                </td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <th><?php echo $form->label($enterprise, 'service_id'); ?>：</th>
                                <td>
                                    <?php echo $form->textField($enterprise, 'service_id', array('class' => 'inputtxt','style'=>'width:200px;')); ?>
                                    <?php echo $form->error($enterprise, 'service_id'); ?>(选填)
                                </td>
                            </tr>

                            <tr>
                                <th>&nbsp;</th>
                                <td class="do">
                                    <?php echo CHtml::submitButton(Yii::t('memberHome','同意协议并升级'), array('type'=>'button','class'=>'regBtn'))?>
                                </td>
                            </tr>
                            <tr>
                                <td class="ta_c" colspan="2">
                                    <?php echo $form->checkBox($model, 'agree',array('checked'=>'checked','style'=>'display:none;')); ?>
                                    <?php echo Yii::t('memberHome', ' ') . CHtml::link(Yii::t('memberHome', '《盖象商城用户入驻协议》'), $this->createUrl('/help/article/agreementEnterprise'), array('target' => '_blank','class'=>'agreement')); ?>
                                    <?php echo $form->error($model, 'agree'); ?>
                                </td>
                            </tr>
                        </table>

                        <?php $this->endWidget() ?>

                </div>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>
