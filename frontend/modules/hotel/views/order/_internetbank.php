
<?php
/**
 * @var $model OrderPayForm
 */
// 获取后台网银状态配置
$payConfig = Tool::getConfig('payapi', '');
?>
<div class="bank" >
    <ul class="payType">
        <?php if ($payConfig['ipsEnable'] === 'true'): ?>
            <li>
                <?php echo CHtml::activeRadioButton($model, 'payWay', array('value' => OnlinePay::PAY_IPS, 'id' => 'bank_hx', 'uncheckValue' => null)) ?>
                <?php echo CHtml::label(CHtml::tag('span', array('class' => 'IPS')), 'bank_hx'); ?>
            </li>
        <?php endif; ?>
        <?php if ($payConfig['gneteEnable'] === 'true'): ?>
            <li>
                <?php echo CHtml::activeRadioButton($model, 'payWay', array('value' => OnlinePay::PAY_UNION, 'id' => 'bank_yl', 'uncheckValue' => null)) ?>
                <?php echo CHtml::label(CHtml::tag('span', array('class' => 'UP')), 'bank_yl'); ?>
            </li>
        <?php endif; ?>
        <?php if ($payConfig['bestEnable'] === 'true'): ?>
            <li>
                <?php echo CHtml::activeRadioButton($model, 'payWay', array('value' => OnlinePay::PAY_BEST, 'id' => 'bank_yzf', 'uncheckValue' => null)) ?>
                <?php echo CHtml::label(CHtml::tag('span', array('class' => 'BEST')), 'bank_yzf'); ?>
            </li>
        <?php endif; ?>
        <?php if ($payConfig['hiEnable'] === 'true'): ?>
            <li>
                <?php echo CHtml::activeRadioButton($model, 'payWay', array('value' => OnlinePay::PAY_HI, 'id' => 'bank_jzg', 'uncheckValue' => null)) ?>
                <?php echo CHtml::label(CHtml::tag('span', array('class' => 'HI')), 'bank_jzg'); ?>
            </li>
        <?php endif; ?>
        <?php if ($payConfig['umEnable'] === 'true'): ?>
            <li>
                <?php echo CHtml::activeRadioButton($model, 'payWay', array('value' => OnlinePay::PAY_UM, 'uncheckValue' => null, 'id' => 'selUm', 'checked' => false)); ?>
                <label for="selUm">
                    <span class="BEST" style="background-position: -11px -235px;"></span>
                    <div class="decTxt fl">
                        <p class="bTit">U付支付</p>
                        <p></p>
                    </div>
                </label>
            </li>
        <?php endif; ?>

        <?php if ($payConfig['tlzfEnable'] === 'true'): ?>
            <li>
                <?php echo CHtml::activeRadioButton($model, 'payWay', array('value' => OnlinePay::PAY_TLZF, 'uncheckValue' => null, 'id' => 'selTL', 'checked' => false)); ?>
                <label for="selTL">
                    <span class="BEST" style="background-position: -11px -280px;"></span>
                    <div class="decTxt fl">
                        <p class="bTit">通联支付</p>
                        <p></p>
                    </div>
                </label>
            </li>
        <?php endif; ?>
    </ul>
</div>
