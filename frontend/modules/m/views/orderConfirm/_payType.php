<?php
    $payConfig = Tool::getConfig('payapi');
      //if($totalPrice > $accountMoney):
     //$OtherMoney=$totalPrice-$accountMoney;
     $umCode=$this->getParam('code');
?>
<?php if($payConfig['umQuickEnable'] === 'true'):?>	
   <span class="payQT">快捷支付</span>
            <div class="ODItem ODItem2 OCList payQTSel">
	    		<ul>
	    		 <li>
		    			<span class="OSProducts fl cartProducts paymentTotal" style="height: 90px">
		    				<img width="100" height="50" class="fl" src="<?php echo DOMAIN; ?>/images/m/bg/m_paymentSel6.png"></img>
		    				<span class="OSProductsRight cartProductsRight fl">
		    					<span class="payTitle">快捷支付</span><br/>
		    				                  首次支付可开通快捷支付<br />也可先绑定银行卡再支付
		    				</span>
		    				<span class="cartSel cartQSelTotal fl cartThisSel" num="2"  paytype="<?php echo OnlineWapPay::PAY_UM_QUICK;?>"  style="background: url(<?php echo DOMAIN; ?>/images/m/bg/m_ioc14.png)  no-repeat;background-size:100% 100%" ></span>
		    				<span class="clear"></span>
		    			</span>
		    			
	    			</li>
	    			<li>
		    			<span>
		    			
		    			 <?php 
        	    		    $umCode=$this->getParam('code') ? $this->getParam('code') : '1';
                            $param['gw']=$this->model->gai_number;
                            $param['retUrl']=$this->createAbsoluteUrl('member/bindCard',array('code'=>$umCode));
                            $url=OnlineWapPay::bindUm($param);
		    		     ?>	 
		    			<a href="<?php echo $url;?>"> 
		    			<!--
		    			<a href="<?php echo $this->createAbsoluteUrl('member/bankCard',array('code'=>$umCode)) ?>">
		    			-->	
		    				<img style="width:150px;height:50px" class="fl" src="<?php echo DOMAIN; ?>/images/m/bg/plus_bank_cards.gif"></img>
		    			</a>
		    			</span>
		    			<span class="clear"></span>
	    			</li>
	    		</ul>
	    	</div>	
<?php endif;?>
<?php if($payConfig['ghtQuickEnable'] === 'true'):?>	
   <span class="payQT">快捷支付</span>
            <div class="ODItem ODItem2 OCList payQTSel">
	    		<ul>
	    		 <li>
		    			<span class="OSProducts fl cartProducts paymentTotal" style="height: 90px">
		    				<img width="100" height="50" class="fl" src="<?php echo DOMAIN; ?>/images/m/bg/m_paymentSel9.png"></img>
		    				<span class="OSProductsRight cartProductsRight fl">
		    					<span class="payTitle">快捷支付</span><br/>
		    				                  先绑卡再支付
		    				</span>
		    				<span class="cartSel cartQSelTotal fl cartThisSel" num="2"  paytype="<?php echo OnlineWapPay::PAY_GHT_QUICK;?>"  style="background: url(<?php echo DOMAIN; ?>/images/m/bg/m_ioc14.png)  no-repeat;background-size:100% 100%" ></span>
		    				<span class="clear"></span>
		    			</span>
		    			
	    			</li>
	    			<li>
		    			<span>
		    			<a href="<?php echo $this->createAbsoluteUrl('member/bankCard',array('code'=>$umCode)) ?>">
		    				<img style="width:150px;height:50px" class="fl" src="<?php echo DOMAIN; ?>/images/m/bg/plus_bank_cards.gif"></img>
		    			</a>
		    			</span>
		    			<span class="clear"></span>
	    			</li>
	    		</ul>
	    	</div>	
<?php endif;?>
   			<span class="payQT">网银支付</span>
   			<div class="ODItem ODItem2 OCList payQTSel">
	    		<ul>
	    		
	    		<?php if($payConfig['gneteEnable'] === 'true'): ?>
	    			<li>
		    			<span class="OSProducts fl cartProducts paymentTotal">
		    				<img width="100" class="fl" src="<?php echo DOMAIN; ?>/images/m/bg/m_paymentSel3.png"></img>
		    				<span class="OSProductsRight cartProductsRight fl">
		    					<span class="payTitle">银联支付</span><br/>	
		    				</span>
		    				<span class="cartSel cartQSelTotal fl cartThisSel" num="2"  paytype="<?php echo OnlineWapPay::PAY_WAP_UNION;?>"  style="background: url(<?php echo DOMAIN; ?>/images/m/bg/m_ioc14.png)  no-repeat;background-size:100% 100%" ></span>
		    				<span class="clear"></span>
		    			</span>
		    			<span class="clear"></span>
	    			</li>
	    		<?php endif; ?>
	    		
	    		<?php if($payConfig['bestEnable'] === 'true'): ?>
	    			<li>
		    			<span class="OSProducts fl cartProducts paymentTotal">
		    				<img width="100" class="fl" src="<?php echo DOMAIN; ?>/images/m/bg/m_paymentSel5.png"></img>
		    				<span class="OSProductsRight cartProductsRight fl">
		    					<span class="payTitle">翼支付</span><br/>	
		    				</span>
		    				<span class="cartSel cartQSelTotal fl cartThisSel" num="2"  paytype="<?php echo OnlineWapPay::PAY_BEST;?>"  style="background: url(<?php echo DOMAIN; ?>/images/m/bg/m_ioc14.png)  no-repeat;background-size:100% 100%" ></span>
		    				<span class="clear"></span>
		    			</span>
		    			<span class="clear"></span>
	    			</li>
	    		<?php endif; ?>
	    		<?php if($payConfig['umEnable'] === 'true'): ?>
	    			<li>
		    			<span class="OSProducts fl cartProducts paymentTotal">
		    				<img width="100" height="50" class="fl" src="<?php echo DOMAIN; ?>/images/m/bg/m_paymentSel6.png"></img>
		    				<span class="OSProductsRight cartProductsRight fl">
		    					<span class="payTitle">U付支付</span><br/>
		    					      信用卡支付
		    				</span>
		    				<span class="cartSel cartQSelTotal fl cartThisSel" num="2"  paytype="<?php echo OnlineWapPay::PAY_UM;?>"  style="background: url(<?php echo DOMAIN; ?>/images/m/bg/m_ioc14.png)  no-repeat;background-size:100% 100%" ></span>
		    				<span class="clear"></span>
		    			</span>
		    			<span class="clear"></span>
	    			</li>
	    		<?php endif; ?>
	    		<?php if($payConfig['tlzfEnable'] === 'true'):?>
	    		 <li>
		    			<span class="OSProducts fl cartProducts paymentTotal">
		    				<img width="100" height="50" class="fl" src="<?php echo DOMAIN; ?>/images/m/bg/tlzf.gif"></img>
		    				<span class="OSProductsRight cartProductsRight fl">
		    					<span class="payTitle">通联支付</span><br/>
		    					         通联支付
		    				</span>
		    				<span class="cartSel cartQSelTotal fl cartThisSel" num="2"  paytype="<?php echo OnlineWapPay::PAY_TLZF;?>"  style="background: url(<?php echo DOMAIN; ?>/images/m/bg/m_ioc14.png)  no-repeat;background-size:100% 100%" ></span>
		    				<span class="clear"></span>
		    			</span>
		    			<span class="clear"></span>
	    			</li>
	    		<?php endif;?>	
	    		</ul>
	    	</div>
	    