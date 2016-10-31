
<?php
    /**
     * 网银支付方式页面
     */
    $payConfig = Tool::getConfig('payapi');
?>
<style>
     .radio+label{
	       cursor: pointer;
     }
     .radio{
	       cursor: pointer;
     }
	.bankCard-li label em{
		position:absolute;
		display:inline-block;
		font-style:normal;
		background-color: #ff5a00;
		height:22px;
		line-height:22px;
		text-align:center;
		color:#fff;
		padding:0 5px;
		margin:-20px 0 0 -23px;
	}
	.bankCard-li label em i{
		position:absolute; left:11px; top:18px; display:inline-block;width:0;height:0;overflow:hidden;line-height:0;font-size:0;vertical-align:middle;border-top:7px solid #ff5a00;border-bottom:0 none;border-left:7px solid transparent;
		border-right:7px solid transparent;_color:#FF3FFF;_filter:chroma(color=#FF3FFF);
	}
</style>
<!-- 卡的类别，2借记卡 3信用卡 <预留字段>-->
<?php echo $form->hiddenField($model, 'bankType', array('value' =>OnlineBankPay::PAY_BANK_DEBITCARD,'id'=>'orderFormBankType'))?>
<div class="bankCard-conter bankCard-conter2">
					<div class="bankCard-conter bankCard-conter2">
					<div class="bankCard-category bankCard-category2 clearfix">
						<ul>
						    <li class="bankCard-category-on" tag="1" data-attr="<?php echo OnlineBankPay::PAY_BANK_DEBITCARD;?>">网银支付</li>
							<li tag="2" data-attr="<?php echo OnlineBankPay::PAY_BANK_NONE;?>">支付平台</li>
						</ul>
						<div class="payment-money  still-pay">还需要支付：<span><?php echo HtmlHelper::formatPrice($model->totalPrice) ?></span></div>
					</div>
					</div>
					<div class="bankCard-list">
						<div class="bankCard-cp bankCard-cp1">
							 <?php 
							    //储蓄卡列表
							   $debitcardList=OnlineBankPay::getCommonBank();
							 ?>
							<div class="bankCard-title2">网银支付<img src="<?php echo $this->theme->baseUrl?>/images/bgs/bankPrompt.jpg"/></div>
							<ul class="bankCard-li bankCard-li-height clearfix">
							 <?php if(!empty($debitcardList)):
							     foreach ($debitcardList as $k => $v):
							 ?>
								<li>
									 <?php echo $form->radioButton($model, 'bankCode', array('class' => 'radio', 'value' =>  $v['code'], 'uncheckValue' => null, 'id' => 'credit-card'.$v['code'], )); ?>
									<label for="credit-card<?php echo $v['code']?>" title="<?php echo $v['name'] ?>">
										<i class="bank-logo <?php echo $v['code']?>"></i>
									<?php if($v['code']=='ALIPAY' || $v['code']=='WECHAT') echo '<em>推荐<i></i></em>' ?>
									</label>
								</li>
								<?php endforeach;endif;?>
							</ul>
							<div class="bankMore" tag="1"><span>更多在线支付银行</span><i></i></div>
						</div>
						<div class="bankCard-cp bankCard-cp2">
						 <div class="bankCard-title2">支付平台</div>
							 <ul class="bankCard-li clearfix" id="ghtpay" style="display:none">
							   <li>
								  <?php echo $form->radioButton($model, 'payType', array('class' => 'radio', 'value' => OnlinePay::PAY_GHTKJ, 'uncheckValue' => null, 'id' => 'selGHTKJ', 'checked' => false)); ?>
									<label for="selGHTKJ"><i class="common-bank-logo GHT"></i></label>
								</li>
							   </ul>
							<ul class="bankCard-li clearfix" id="otherpay" style="display:block">
							  <?php if ($payConfig['ghtEnable'] === 'true'): ?>
								<li>
								   <?php echo $form->radioButton($model, 'payType', array('class' => 'radio', 'value' => OnlinePay::PAY_GHT, 'uncheckValue' => null, 'id' => 'selGHT', 'checked' => false)); ?>
									<label for="selGHT"><i class="common-bank-logo GHT"></i><em>推荐<i></i></em></label>
								</li>
								 <?php endif;if ($payConfig['gneteEnable'] === 'true'): ?>
								<li>
								  <?php echo $form->radioButton($model, 'payType', array('class' => 'radio', 'value' => OnlinePay::PAY_UNION, 'uncheckValue' => null, 'id' => 'selUP', 'checked' => false)); ?>
									<label for="selUP"><i class="common-bank-logo UP"></i></label>
								</li>
								 <?php endif;if ($payConfig['umEnable'] === 'true'): ?>
								<li>
								  <?php echo $form->radioButton($model, 'payType', array('class' => 'radio', 'value' => OnlinePay::PAY_UM, 'uncheckValue' => null, 'id' => 'selUM', 'checked' => false)); ?>
									<label for="selUM"><i class="common-bank-logo UM"></i></label>
								</li>
								 <?php endif;if ($payConfig['ipsEnable'] === 'true'): ?>
								<li>
								  <?php echo $form->radioButton($model, 'payType', array('class' => 'radio', 'value' => OnlinePay::PAY_IPS, 'uncheckValue' => null, 'id' => 'selIPS', 'checked' => false)); ?>
									<label for="selIPS"><i class="common-bank-logo IPS"></i></label>
								</li>
								 <?php endif;if ($payConfig['hiEnable'] === 'true'): ?>
								<li>
								  <?php echo $form->radioButton($model, 'payType', array('class' => 'radio', 'value' => OnlinePay::PAY_HI, 'uncheckValue' => null, 'id' => 'selHI', 'checked' => false)); ?>
									<label for="selHI"><i class="common-bank-logo HI"></i></label>
								</li>
								 <?php endif;if ($payConfig['tlzfEnable'] === 'true'): ?>
								<li>
								  <?php echo $form->radioButton($model, 'payType', array('class' => 'radio', 'value' => OnlinePay::PAY_TLZF, 'uncheckValue' => null, 'id' => 'selTLZF', 'checked' => false)); ?>
									<label for="selTLZF"><i class="common-bank-logo TLZF"></i></label>
								</li>
								 <?php endif;if ($payConfig['bestEnable'] === 'true'): ?>
								<li>
								  <?php echo $form->radioButton($model, 'payType', array('class' => 'radio', 'value' => OnlinePay::PAY_BEST, 'uncheckValue' => null, 'id' => 'selBEST', 'checked' => false)); ?>
									<label for="selBEST"><i class="common-bank-logo BEST"></i></label>
								</li>
								<?php endif;?>
							</ul>
							<?php //endif;?>
						</div>
					</div>
				</div>