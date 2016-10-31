<div class="accounts-box accounts-box2">
    <div class="accounts-revise">
        <div class="revise-progress">
            <div class="revise-item on">
                <p class="number">1</p>
                <p class="title"><?php echo Yii::t('memberMember','验证身份')?></p>
                <span class="on"></span>
            </div>
            <div class="revise-item <?php echo ($step == 2 || $step == 3) ? 'on' : ''?> ">
                <p class="number">2</p>
                <p class="title"><?php echo Yii::t('memberMember','修改邮箱')?></p>
                <span class="<?php echo ($step== 2 || $step==3) ? 'on' : ''?>"></span>
            </div>
            <div class="revise-item">
                <p class="number">3</p>
                <p class="title"><?php echo Yii::t('memberMember','完成')?></p>
            </div>
        </div>
        <?php if($step == 1):?>
        <?php $form = $this->beginWidget('ActiveForm',array(
            'id'=> $this->id . '-form',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions' => array(
                'validateOnSubmit'=>true
            )
        ))?>
        <div class="revise-box">
            <p><span class="revise-left"><?php echo $form->label($model,'email')?>：</span><span class="revise-phone"><?php echo $model->email?></span></p>
            <p><span class="revise-left">
                <?php echo Yii::t('comment','盖象登陆') . $form->label($model,'password')?>：</span>
                <?php echo $form->passwordField($model,'password',array('class'=>'input-password','value'=>''))?>
                <?php CHtml::$errorContainerTag='span'; echo $form->error($model,'password',array('class'=>'revise-message'))?>
            </p>
            <?php echo CHtml::hiddenField('step',  MemberController::STEP_ONE);?>
            <p><?php echo CHtml::submitButton('确定',array('class'=>'btn-deter'))?></p>
        </div>
        <?php $this->endWidget()?>
        <?php elseif($step == 2):?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <?php
            $form = $this->beginWidget('ActiveForm', array(
                'id' => $this->id . '-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true
                )
                    ))
            ?>
            <div class="revise-box">
                <p>
                    <span class="revise-left"><?php echo Yii::t('memberMember','新修改邮箱')?>：</span>
                    <?php echo $form->emailField($model,'email',array('class'=>'input-phone','value'=>''))?>
                    <?php CHtml::$errorContainerTag='span'; echo $form->error($model,'email',array('class'=>'revise-message'))?>
                </p>
                <?php echo CHtml::hiddenField('step',  MemberController::STEP_TWO);?>
                <p><?php echo CHtml::submitButton('确定',array('class'=>'btn-deter'))?></p>
            </div>
        <?php $this->endWidget();?>
        <?php elseif($step == 3):?>
            <div class="revise-box bind-success">
                <div class="revise-result">
                    <p><i class="cover-icon"></i><?php echo Yii::t('memberMember','已发送验证链接至')?>：<span class="revise-phone"><?php echo $model->email?></span></p>
                    <p class="txtle"><?php echo Yii::t('memberMember','验证邮件')?><span>24</span><?php echo Yii::t('memberMember','小时内有效，请尽快登陆您的邮箱点击验证链接完成验证。')?></p>
                </div>
                <?php 
                    $start = stripos($this->model->email,'@')+1;
                    $end = stripos($this->model->email,'.') ;
                    $email = substr($this->model->email, $start,$end-$start);
                ?>
                <p class="revise-result-btn"><input type="button" class="btn-deter" onclick="window.location.href='<?php echo 'http://mail.' . $email . '.com'?>'" value="去验证" /></p>
            </div>
        <?php endif;?>
    </div>
</div>