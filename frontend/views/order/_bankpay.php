<?php
/* @var $model OrderForm */
/* @var $form CActiveForm */
$payConfig = Tool::getConfig('payapi');
Yii::app()->clientScript->registerCssFile(DOMAIN.'/css/member.css');
?>
<div class="bank" style="">
    <ul class="payType" >
        <?php if ($payConfig['ipsEnable'] === 'true'): ?>
            <li>
                <?php echo $form->radioButton($model, 'payType', array('value' => OnlinePay::PAY_IPS, 'uncheckValue' => null, 'id' => 'selIPS', 'checked' => false)); ?>
                <label for="selIPS">  <span class="IPS" ></span></label>
            </li>
        <?php endif; ?>
        <?php if ($payConfig['gneteEnable'] === 'true'): ?>
            <li>
                <?php echo $form->radioButton($model, 'payType', array('value' => OnlinePay::PAY_UNION, 'uncheckValue' => null, 'id' => 'selUN', 'checked' => false)); ?>
                <label for="selUN"><span class="UP"></span></label>
            </li>
        <?php endif; ?>
        <?php if ($payConfig['bestEnable'] === 'true'): ?>
            <li>
                <?php echo $form->radioButton($model, 'payType', array('value' => OnlinePay::PAY_BEST, 'uncheckValue' => null, 'id' => 'selBEST', 'checked' => false)); ?>
                <label for="selBEST">
					<span class="BEST" style="width:135px;"></span>
						<div class="decTxt fl">
							<p class="bTit">翼支付</p>
							<p></p>
						</div>
				</label>
            </li>
        <?php endif; ?>

        <?php if ($payConfig['hiEnable'] === 'true'): ?>
            <li>
                <?php echo $form->radioButton($model, 'payType', array('value' => OnlinePay::PAY_HI, 'uncheckValue' => null, 'id' => 'selHi', 'checked' => false)); ?>
                <label for="selHi"><span class="HI"></span></label>
            </li>
        <?php endif; ?>

        <?php if ($payConfig['umEnable'] === 'true'): ?>
            <li>
                <?php echo $form->radioButton($model, 'payType', array('value' => OnlinePay::PAY_UM, 'uncheckValue' => null, 'id' => 'selUm', 'checked' => false)); ?>
                <label for="selUm">
                    <span class="BEST" style="background-position: -11px -235px;width:75px"></span>
                    <div class="decTxt fl">
                        <p class="bTit">U付支付</p>
                        <p></p>
                    </div>
                </label>
            </li>
        <?php endif; ?>


		<?php if ($payConfig['tlzfEnable'] === 'true'): ?>
            <li>
                <?php echo $form->radioButton($model, 'payType', array('value' => OnlinePay::PAY_TLZF, 'uncheckValue' => null, 'id' => 'selTL', 'checked' => false)); ?>
                <label for="selTL">
                    <span class="BEST" style="background-position: -11px -280px;width:72px"></span>
                    <div class="decTxt fl">
                        <p class="bTit">通联支付</p>
                        <p></p>
                    </div>
                </label>
            </li>
        <?php endif; ?>
    </ul>
    <?php //echo $cardList?CHtml::link('使用快捷支付','#',array('id'=>'quickPay','class'=>'red','style'=>'margin:20px 20px;')):'' ?>
</div>
