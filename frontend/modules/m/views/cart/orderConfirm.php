<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $this->pageTitle?>_确认订单（结算）</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="bookmark" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/global.css" type="text/css"></link>
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/comm.css" type="text/css"></link>
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/member.css" type="text/css"></link>
</head> 
  <body>
  
  <?php echo CHtml::form($this->createAbsoluteUrl('cart/order'), 'post', array('name' => 'SendOrderForm', 'id' => 'order_form'));?>
    <div class="wrap ODWrap">
	 	<div class="header" id="js-header">
			<div class="mainNav">
				<div class="topNav clearfix">
					<a class="icoBlack fl" href="javascript:history.go(-1);"></a>
					<a class="TxtTitle fl" href="javascript:void(0);">确认订单</a>
				</div>
			</div>
		</div>
	    <div class="main">
	    	<a href="<?php echo $this->createUrl('address/index',array('cart'=>'1'));?>" class="logisticsInfo ODInfo OCInfo2">
	    		<span>
		    		收货人：<?php echo $address['real_name']."&nbsp;&nbsp;&nbsp;&nbsp;".$address['mobile'];?><br/>
		    		<?php echo $address['province_name'].$address['city_name'].$address['district_name'].$address['street']?>
	    		</span>
	    	</a>
	    	
	  <?php if (!empty($cart['cartInfo'])):?>
	     <?php foreach ($cart['cartInfo'] as $key => $val):
	               $totalprice=$val['totalprice'];
	               
	        ?>
	    	<div class="ODItem ODItem2 OCList">
	    		<ul>
	    			<li>
	    				<div class="OSlistTitle">
		    				<div class="OSlistTitleLeft fl"><?php echo $val['storeName'] ?></div>
		    				<div class="clear"></div>
		    			</div>
	    			</li>
	    			<!-- 产品列表 -->
	    			<?php foreach($val['goods'] as $k => $v):?>
	    			<li>
		    			<a href="<?php echo $this->createUrl('goods/index',array('id' => $v['goods_id']));?>" title="" class="OSProducts">
		    				<?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_54,w_54'), $v['name'], array('width' => '80','class' => "fl")) ?>
		    				<span class="OSProductsRight ODProductsRight fl">
		    					<span class="OSProductsInfo"><?php echo $v['name'];?></span>
		   						<span class="ODItem2Info">
			   						  <?php echo $v['spec']?><br/>
			   						<?php echo HtmlHelper::formatPrice($v['price']) ?>&nbsp;数量：<?php echo $v['quantity'] ?><br/>
			   					</span>
		    				</span>
		    				<span class="clear"></span>
		    			</a>
	    			</li>
                 
	    			<!-- 产品列表 -->
	    			
	    			  <?php
	    		            $redMoney = $redAccount['memberRedAccount'];
                            $totalRedMoney = 0;//红包金额初始值为0
                            if (!empty($redAccount['use_red_money']) && $redAccount['use_red_money'][$key] > 0) {
                                if ($redMoney > 0) {
                                    if ($redMoney >= $redAccount['use_red_money'][$key]) {
                                        $totalRedMoney +=$redAccount['use_red_money'][$key]; //计算合计红包金额
                                        $useMoney=$redAccount['use_red_money'][$key];
                                        $redMoney -= $redAccount['use_red_money'][$key];
                                    } else {
                                        $totalRedMoney += $redMoney;
                                        $useMoney=$redMoney;
                                        $redMoney -= $redAccount['use_red_money'][$key];
                                    }
                                    $payPrice=$totalprice-$useMoney;
                                }
                            }else{
                              $payPrice=$totalprice;
                              $totalRedMoney=0;
                            }
                            ?>
	    			<?php if (!empty($redAccount['use_red_money']) && $redAccount['use_red_money'][$key] > 0 && !empty($v['at_name'])):?>
	    			 <?php 
	    			      $good_ratio = bcdiv($v['activity_ratio'], 100, 5);
                          $goodRed = bcmul(bcmul($v['gai_sell_price'], $v['quantity'], 2), $good_ratio, 2);
                        ?>
                     <li>
    					<span class="menberLeft fl"><?php echo $v['at_name'];?></span>
    					<span class="menberRight fr">-<?php echo  HtmlHelper::formatPrice($goodRed);?></span>
    					<span class="clear"></span>
	    			  </li>  	  
	    			  <?php endif;?>  
	    			    			
	    			<li>
    					<span class="menberLeft fl">
    					<?php
                                if ($v['freight_payment_type'] != Goods::FREIGHT_TYPE_MODE) {
                                    echo Goods::freightPayType($v['freight_payment_type']);
                                } else {
                                    if (count($this->freight[$k]) == 1) {
                                        echo current($this->freight[$k]);
                                        echo CHtml::hiddenField('freight[' . $k . ']', key($this->freight[$k]));
                                    } else {
                                        echo CHtml::dropDownList('freight[' . $k . ']', '', $this->freight[$k],
                                            array('class' => 'freightSelect', 'data-key' => $k,'id'=>'onfreight'));
                                    }
                                }
                                ?>
    					</span>
    					<span class="menberRight fr">
    					<?php
                                if ($v['freight_payment_type'] != Goods::FREIGHT_TYPE_MODE) {
                                    $freight = '0.00';
                                } else {
                                    $freight = explode('|', (key($this->freight[$k])));
                                    $freight = $freight[1];
                                }
                                 $allTotalPrice +=$freight;
                                echo  HtmlHelper::formatPrice('');
                                echo '<span id="freightmoney">'.$freight.'</span>';        
                       ?>
    					</span>
    					<span class="clear"></span>
	    			</li>
	    		<?php endforeach;?>
	    		     <li>
    					<span class="menberLeft fl">红包合计</span>
    					<span class="menberRight fr d32f2f">-<?php echo HtmlHelper::formatPrice($totalRedMoney);?></span>
    					<span class="clear"></span>
	    			</li>
	    			      
	    			<li>
    					<span class="menberLeft fl">商品合计（不含运费）</span>
    					<span class="menberRight fr d32f2f"><?php echo HtmlHelper::formatPrice($payPrice);?></span>
    					<span class="clear"></span>
	    			</li>
	    		</ul>
	    	</div>
	    	<?php endforeach;?>
	    	<?php endif;?>
	    </div>
	    <!-- 底部固定按钮 -->
	   <div class="ODFooter">
	    	<div class="OSListBtn">
   				    <input type="hidden" value="<?php echo $payPrice; ?>" id="allPrice"/>
   				    <input type="hidden" value="<?php echo $totalRedMoney;?>" id="totalRed">
   				    <input type="hidden" value="<?php echo $address['id'] ?>" name="address"/>
                    <input type="hidden" value="<?php echo Tool::authcode(serialize($this->freight)) ?>" name="freight_array"/>
                    <input type="hidden" value="<?php echo Tool::authcode(serialize($cart_goods)) ?>" name="cart_goods"/>
                    <input type="submit" class="OSListOnfirmBtn OCBtn" id="submitToPay" value="去付款（合计:<?php echo HtmlHelper::formatPrice($allTotalPrice-$totalRedMoney);?>）"/>
   			</div>
	    </div>
   </div>
    <?php echo CHtml::endForm(); ?>
  </body>
  <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<script>
    //运费选择
    $(".freightSelect").change(function () {
        var freight = this.value.split('|');
        freight = parseFloat(freight[2]);
        $("#freightmoney").html(freight); 
        allPrice=parseFloat($("#allPrice").val());
        totalRed=parseFloat($("#totalRed").val());
        var totalpriceJs=allPrice+freight-totalRed;
        $("#submitToPay").val("去付款（合计:<?php echo HtmlHelper::formatPrice('');?>"+totalpriceJs+")");
    });
</script>
</html>
