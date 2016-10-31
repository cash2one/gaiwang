<?php
/*@var Order*/
$payConfig = Tool::getConfig('payapi', '');
?>
<div class="bank">
    <ul class="payType">
        <?php if ($payConfig['ipsEnable'] === 'true'): ?>
            <li>
                <input name="payType" type="radio" value="<?php echo Recharge::PAY_TYPE_HUXUN ?>" id="selIPS"/>
                <label for="selIPS">  <span class="IPS" ></span></label>
            </li>
        <?php endif; ?>
        <?php if ($payConfig['gneteEnable'] === 'true'): ?>
            <li>
                <input name="payType" type="radio" value="<?php echo Recharge::PAY_TYPE_YINLIANG ?>" id="selUN"/>
                <label for="selUN"><span class="UP"></span></label>
            </li>
        <?php endif; ?>
        <?php if ($payConfig['bestEnable'] === 'true'): ?>
            <li>
                <input name="payType" type="radio" value="<?php echo Recharge::PAY_TYPE_YI ?>" id="selBEST"/>
                <label for="selBEST"><span class="BEST"></span></label>
            </li>
        <?php endif; ?>
        <?php if ($payConfig['hiEnable'] === 'true'): ?>
            <li>
                <input name="payType" type="radio" value="<?php echo Recharge::PAY_TYPE_HI ?>" id="selHi"/>
                <label for="selHi"><span class="HI"></span></label>
            </li>
        <?php endif; ?>
    </ul>
</div>
