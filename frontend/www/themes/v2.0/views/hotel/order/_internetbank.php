<?php
    /**
     * 网银支付方式页面
     * 
     */
    $payConfig = Tool::getConfig('payapi');
?>
    <?php if ($payConfig['bestEnable'] === 'true'): ?>
    <div class="pay-type clearfix" style="<?php if(!$hasquick) echo 'border-color: rgb(194, 0, 5);'?>">
        <!--翼支付-->
        <?php if(!$hasquick):?>
        <?php echo $form->radioButton($model, 'payWay', array('class' => 'radio','value' => OnlinePay::PAY_BEST, 'uncheckValue' => null, 'id' => 'selNEST', 'checked' => true)); ?>
        <?php else:?>
        <?php echo $form->radioButton($model, 'payWay', array('class' => 'radio', 'value' => OnlinePay::PAY_BEST, 'uncheckValue' => null, 'id' => 'selNEST', 'checked' => false)); ?>
        <?php endif;?>
        <b class="type-name"><?php echo OnlinePay::getPayWayList(OnlinePay::PAY_BEST); ?></b>
        <i class="common-bank-logo BEST"></i>
    </div>
    <?php endif;if ($payConfig['umEnable'] === 'true'): ?>
    <!--U支付-->
    <div class="pay-type clearfix">
        <?php echo $form->radioButton($model, 'payWay', array('class' => 'radio', 'value' => OnlinePay::PAY_UM, 'uncheckValue' => null, 'id' => 'selUm', 'checked' => false)); ?>
        <b class="type-name"><?php echo Yii::t('order', 'U付') ?></b>
        <i class="common-bank-logo UM"></i>
    </div>
    <?php endif;if ($payConfig['ipsEnable'] === 'true'): ?>
    <!--环迅支付-->
    <div class="pay-type clearfix">
         <?php echo $form->radioButton($model, 'payWay', array('class' => 'radio', 'value' => OnlinePay::PAY_IPS, 'uncheckValue' => null, 'id' => 'selIPS', 'checked' => false)); ?>
        <b class="type-name"><?php echo OnlinePay::getPayWayList(OnlinePay::PAY_IPS); ?></b>
        <i class="common-bank-logo IPS"></i>
    </div>
    <?php endif;if ($payConfig['gneteEnable'] === 'true'): ?>
    <!--银联支付-->
    <div class="pay-type clearfix">
        <?php echo $form->radioButton($model, 'payWay', array('class' => 'radio', 'value' => OnlinePay::PAY_UNION, 'uncheckValue' => null, 'id' => 'selUNION', 'checked' => false)); ?>
        <b class="type-name"><?php echo Yii::t('order', '银联支付') ?></b>
        <i class="common-bank-logo UP"></i>
    </div>
    <?php endif;if ($payConfig['hiEnable'] === 'true'): ?>
    <!--汇卡支付-->
    <div class="pay-type clearfix">
        <?php echo $form->radioButton($model, 'payWay', array('class' => 'radio', 'value' => OnlinePay::PAY_HI, 'uncheckValue' => null, 'id' => 'selHI', 'checked' => false)); ?>
        <b class="type-name"><?php echo Yii::t('order', '汇卡支付') ?></b>
        <i class="common-bank-logo HI"></i>
    </div>
    <?php endif;if ($payConfig['tlzfEnable'] === 'true'): ?>
    <!--通联快捷支付-->
    <div class="pay-type clearfix">
        <?php echo $form->radioButton($model, 'payWay', array('class' => 'radio', 'value' => OnlinePay::PAY_TLZF, 'uncheckValue' => null, 'id' => 'selTLZF', 'checked' => false)); ?>
        <b class="type-name"><?php echo Yii::t('order', '通联支付') ?></b>
        <i class="common-bank-logo TLZF"></i>
    </div>
     <?php endif;if ($payConfig['ghtEnable'] === 'true'): ?>
    <!--高汇通支付-->
    <div class="pay-type clearfix">
        <?php echo $form->radioButton($model, 'payWay', array('class' => 'radio', 'value' => OnlinePay::PAY_GHT, 'uncheckValue' => null, 'id' => 'selGHT', 'checked' => false)); ?>
        <b class="type-name"><?php echo Yii::t('order', '高汇通支付') ?></b>
        <i class="common-bank-logo GHT"></i>
    </div>
     <?php endif;if ($payConfig['ghtEnable'] === 'true'): ?>
    <!--EBC钱包支付-->
    <div class="pay-type clearfix">
        <?php echo $form->radioButton($model, 'payWay', array('class' => 'radio', 'value' => OnlinePay::PAY_EBC, 'uncheckValue' => null, 'id' => 'selEBC', 'checked' => false)); ?>
        <b class="type-name"><?php echo Yii::t('order', 'EBC钱包支付') ?></b>
        <i class="common-bank-logo EBC"></i>
    </div>
    <?php endif; ?>