<!--主体start-->
<div class="member-contain clearfix" xmlns="http://www.w3.org/1999/html">

    <div class="main-contain">
        <div class="return-record">
            <span><a href=""> <?php echo Yii::t('memberPrepaidCard', '积分充值卡')?></a></span>
            <!--<span class="not"><a href="<?php /*echo Yii::app()->createUrl('member/recharge/index') */?>"><?php /*echo Yii::t('memberPrepaidCard', '第三方充值')*/?></a></span>-->
        </div>

        <div class="recharge-cards">
            <div class="cards-box">
                <p class="cards-title"><?php echo Yii::t('memberPrepaidCard', '如何使用积分充值卡？')?></p>
                <div class="revise-progress">
                    <div class="revise-item on">
                        <p class="number">1</p>
                        <p class="title"><?php echo Yii::t('memberPrepaidCard', '填写充值卡信息')?> </p>
                        <span class="on"></span>
                    </div>
                    <div class="revise-item on">
                        <p class="number">2</p>
                        <p class="title"><?php echo Yii::t('memberPrepaidCard', '确认充值卡信息'); ?></p>
                        <span class="on"></span>
                    </div>
                    <div class="revise-item on">
                        <p class="number">3</p>
                        <p class="title"><?php echo Yii::t('memberPrepaidCard', '充值完成'); ?></p>
                    </div>
                </div>

                <div class="cards-conter">
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
                    <div class="cards-info">
                        <span class="cards-left"><i>*</i><?php echo Yii::t('memberPrepaidCard', 'GW号')?>：</span>
                            <?php echo $form->textField($model, 'gaiNumber', array('class' => 'input-name','value'=>$this->getSession('gw'))); ?>
                            <?php echo $form->error($model, 'gaiNumber',array('class'=>'input-message')); ?></br>

                        <br><span class="cards-left"><i>*</i><?php echo Yii::t('memberPrepaidCard', '充值卡号')?>：</span>
                            <?php echo $form->textField($model, 'number', array('class' => 'input-number')); ?>
                            <?php echo $form->error($model, 'number',array('class'=>'input-message')); ?></br>

                        <br><span class="cards-left"><i>*</i><?php echo Yii::t('memberPrepaidCard', '充值密码')?>：</span>
                            <?php echo $form->passwordField($model, 'password', array('class' => 'input-password')); ?>
                            <?php echo $form->error($model, 'password'); ?>
                        </br>
                        <br>
                            <span class="cards-left"><i>*</i><?php echo Yii::t('memberPrepaidCard', '验证码')?>：</span>
                            <?php echo $form->textField($model, 'verifyCode', array('class' => 'input-code')); ?>
                            <span class="input-img">
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
                            </span>
                            <span class="input-next"><?php echo Yii::t('memberPrepaidCard', '换一张')?></span>
                            <?php echo $form->error($model, 'verifyCode',array('class'=>'input-message')); ?>
                        </br>
                        <p><input name="" type="submit" class="btn-deter" value="确认充值" /></p>

                    </div>
                    <?php $this->endWidget(); ?>
                    <div class="cards-message">
                        <p class="message-title"><?php echo Yii::t('memberPrepaidCard', '积分充值卡温馨提示')?>：</p>
                        <p><?php echo Yii::t('memberPrepaidCard', '1、如需帮其他会员充值积分，可输入其他会员的GW号/账户名完成充值流程。')?></p>
                        <p><?php echo Yii::t('memberPrepaidCard', '2、此充值卡为盖网会员专属定制；')?></p>
                        <p><?php echo Yii::t('memberPrepaidCard', '3、充值卡不能与现金兑换，只能在盖网消费；')?></p>
                        <p><?php echo Yii::t('memberPrepaidCard', '4、充值卡与充值优惠不共享；')?></p>
                        <p><?php echo Yii::t('memberPrepaidCard', '5、充值卡一经充值不能退换；')?></p>
                        <p><?php echo Yii::t('memberPrepaidCard', '6、本卡片解释权归盖网所有。')?></p>
                    </div>
                </div>

            </div>
        </div>


    </div>
</div>
<!-- 主体end -->
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