<?php
/* @var $this PrepaidCardController */
$this->breadcrumbs = array(
    Yii::t('memberPrepaidCard', '积分管理') => '',
    Yii::t('memberPrepaidCard', ' 充值卡充值'),
);
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberPrepaidCard', ' 充值卡充值'); ?></span></a></li>
        </ul>
    </div>
    <div class="mbRcontent">
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="mgtop20 upladBox"><h3><?php echo Yii::t('memberPrepaidCard', ' 盖象商城充值中心'); ?></h3><p><?php echo Yii::t('memberPrepaidCard', ' 充值卡充值、积分充值。'); ?></p></div>
                <div class="mgtop20 upladBox">
                    <?php echo CHtml::button(Yii::t('memberPrepaidCard', '充值卡充值'), array('class' => 'integaralBtn1')) ?>
                    <?php
                    echo CHtml::button(Yii::t('memberPrepaidCard', '积分充值'), array(
                        'class' => 'integaralBtn2',
                        'onclick' => 'location="' . $this->createAbsoluteUrl('/member/recharge/index') . '";'
                    ))
                    ?>
                </div>
            </div>
            <div class="mbDate1_b"></div>
        </div>
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="mgtop10 upladBox integaralbd clearfix">
                    <span class="ingegralIcon1"></span>
                    <span class="ingegralTxt"><?php echo Yii::t('memberPrepaidCard', ' 填写充值卡号码'); ?></span>
                    <span class="ingegralIcon4"></span>
                    <span class="ingegralIcon3"></span>
                    <span class="ingegralTxt"><?php echo Yii::t('memberPrepaidCard', ' 确认充值信息'); ?></span>
                    <span class="ingegralIcon4"></span>
                    <span class="ingegralIcon2"></span>
                    <span class="ingegralTxt"><?php echo Yii::t('memberPrepaidCard', ' 充值完成'); ?></span>
                </div>
                <?php
                $form = $this->beginWidget('ActiveForm', array(
                    'id' => 'prepaidCard-form',
                    'enableClientValidation' => true,
                    'enableAjaxValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
                <div class="mgtop40 upladBox">
                    <?php echo $form->labelEx($model, 'number', array('class' => 'w120')); ?>
                    <?php echo $form->textField($model, 'number', array('class' => 'integaralIpt1')); ?>
                    <?php echo $form->error($model, 'number', array(), false); ?>
                </div>
                <div class="mgtop20 upladBox">
                    <?php echo $form->labelEx($model, 'password', array('class' => 'w120')); ?>
                    <?php echo $form->passwordField($model, 'password', array('class' => 'integaralIpt1')); ?>
                    <?php echo $form->error($model, 'password', array(), false); ?>
                </div>
                <div class="upladBox mgtop20 clearfix">
                    <span class="fl mgtop5" style="padding-right: 2px;"><?php echo $form->labelEx($model, 'verifyCode', array('class' => 'w120')); ?></span>
                    <?php echo $form->textField($model, 'verifyCode', array('class' => 'integaralIpt2', 'style' => 'width:60px;')); ?>
                    <?php
                    $this->widget('CCaptcha', array(
                        'showRefreshButton' => false,
                        'clickableImage' => true,
                        'imageOptions' => array(
                            'alt' => Yii::t('memberPrepaidCard', '点击换图'),
                            'title' => Yii::t('memberPrepaidCard', '点击换图'),
                            'style' => 'height:32px;width:80px;padding:0 3px;cursor:pointer'
                    )));
                    ?>
                    <?php echo $form->error($model, 'verifyCode'); ?>
                </div>
                <div class="mgtop20 upladBox">
                    <?php echo $form->labelEx($model, 'gaiNumber', array('class' => ' mgtop5 w120')); ?>
                    <?php echo $form->textField($model, 'gaiNumber', array('class' => 'integaralIpt1')); ?>
                    <?php echo $form->error($model, 'gaiNumber'); ?>
                    <p class="gay95 mgleft55">
                        <?php  echo  Yii::t('memberRecharge', '（GW号为空，则为自己充值）');  ?>
                    </p>
                </div>
                <div class="upladBox">
                    <?php echo CHtml::submitButton(Yii::t('memberPrepaidCard', '立即充值'), array('class' => 'integaralBtn4')); ?>
                </div>
                <?php $this->endWidget(); ?>
                <div class="inAapBox">
                    <dl>
                        <dt><a href="javascript:;" title="充值积分卡"><img src="../images/bg/interalpic_01_03.gif" width="295" height="181" alt="充值积分卡"></a></dt>
                        <dd>
                            <b><?php echo Yii::t('memberPrepaidCard', ' 充值卡充值'); ?></b>
                            <p><?php echo Yii::t('memberPrepaidCard', ' 1. 此充值卡为盖网会员专属定制'); ?></p>
                            <p><?php echo Yii::t('memberPrepaidCard', ' 2. 充值卡不能与现金兑换，只能在盖网消费'); ?></p>
                            <p><?php echo Yii::t('memberPrepaidCard', ' 3. 充值卡与充值优惠不共享'); ?></p>
                            <p><?php echo Yii::t('memberPrepaidCard', ' 4. 充值卡一经充值不能退换'); ?></p>
                            <p><?php echo Yii::t('memberPrepaidCard', ' 5. 本卡片解释权归盖网所有'); ?></p>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>
<script>
    //解决验证码页面刷新不变   
    $(document).ready(function() {
        var img = new Image;
        img.onload = function() {
            $('#yw0').trigger('click');
        }
        img.src = $('#yw0').attr('src');
    });
</script>