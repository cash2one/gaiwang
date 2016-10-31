       <?php if( Yii::app()->user->hasFlash('flags')): ?>
           <script type="text/javascript">
                 alert('<?php echo  Yii::app()->user->getFlash('flags'); ?>');
           </script>
        <?php endif;?> 
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $this->pageTitle?>_我的订单</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="bookmark" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/global.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/comm.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/member.css" type="text/css"/>
	<script src="<?php echo DOMAIN; ?>/js/m/jquery-2.1.1.min.js"></script>
	<script src="<?php echo DOMAIN; ?>/js/m/jquery.touchslider.min.js"></script>		          
	<script src="<?php echo DOMAIN; ?>/js/m/template.js"></script>
	<script src="<?php echo DOMAIN; ?>/js/m/com.js"></script>
</head>
    
  <body>
  <div class="wrap clearfix">
 	<div class="header" id="js-header">
		<div class="mainNav">
			<div class="topNav clearfix">
				<a class="icoBlack fl" href="<?php echo $this->createAbsoluteUrl('member/index');?>"></a>
				<a class="TxtTitle fl" href="javascript:void()">我的订单</a>
				<a href="<?php
                        echo $this->createAbsoluteUrl('order/index/',array('search' =>1))
                        ?>" class="ordersSearchBtn fr">搜索</a>
			</div>
		</div>
	</div>
    <div class="main">
    	<div class="orderNav">
    		<ul>
    			<li>
    				<a href="<?php echo $this->createAbsoluteUrl('order/index',array('on'=>'1'));?>">全部<img width="13"  <?php if($on==1 || empty($on)):?> class="orderNavSelected" <?php endif;?> src="<?php echo DOMAIN; ?>/images/m/bg/m_ioc12.jpg"></img></a>
    			</li>
    			<li>
    				<a href="<?php
                        echo $this->createAbsoluteUrl('order/index', array(
                            'Order[pay_status]' => $model::PAY_STATUS_NO,
                            'Order[status]' => $model::STATUS_NEW, 
                            'on'=>'2'
                            ))
                        ?>">待付款<img width="13" <?php if($on==2):?> class="orderNavSelected" <?php endif;?> src="<?php echo DOMAIN; ?>/images/m/bg/m_ioc12.jpg"></img></a>
    			</li>
    			  
    			<li>
    				<a href="<?php
                        echo $this->createAbsoluteUrl('order/index', array(
                            'Order[pay_status]' => $model::PAY_STATUS_YES,
                            'Order[status]' => $model::STATUS_NEW,
                            'Order[delivery_status]' => $model::DELIVERY_STATUS_WAIT,
                            'Order[refund_status]' => $model::REFUND_STATUS_NONE,
                            'on' => '3'))
                        ?>">待发货<img width="13" <?php if($on==3):?> class="orderNavSelected" <?php endif;?> src="<?php echo DOMAIN; ?>/images/m/bg/m_ioc12.jpg"></img></a>
    			</li>
    			
    			<li>
    				<a href="<?php
                        echo $this->createAbsoluteUrl('order/index', array(
                            'Order[delivery_status]' => $model::DELIVERY_STATUS_SEND,
                            'Order[status]' => $model::STATUS_NEW,
                            'Order[refund_status]' => $model::REFUND_STATUS_NONE,
                            'on' => '4'))
                        ?>">待收货<img width="13" <?php if($on==4):?> class="orderNavSelected" <?php endif;?> src="<?php echo DOMAIN; ?>/images/m/bg/m_ioc12.jpg"></img></a>
    			</li>
    			<li class="orderNavLi">
    				<a href="<?php
                        echo $this->createAbsoluteUrl('order/index', array(
                            'Order[is_comment]' => $model::IS_COMMENT_NO,
                            'Order[status]' => $model::STATUS_COMPLETE,
                            'Order[delivery_status]' => $model::DELIVERY_STATUS_RECEIVE,
                            'Order[refund_status]' => $model::REFUND_STATUS_NONE,
                            'on' => '5'))
                        ?>">待评价<img width="13" <?php if($on==5):?> class="orderNavSelected" <?php endif;?> src="<?php echo DOMAIN; ?>/images/m/bg/m_ioc12.jpg"></img></a>
    			</li>
    		</ul>
    	</div>
    	<ul class="OSList" id="goodlist">
    	<?php foreach($orders as $k => $v):
    	     $orderGoods = $v->orderGoods;          
    	?>
    		<li>
    			<div class="OSlistTitle">
    				<div class="OSlistTitleLeft fl"><?php echo $v->store->name;?></div>
    				<div class="OSlistTitleRight fr">
    				  <?php if($v->status==$model::STATUS_CLOSE):
    				           echo $model::status($v->status);?>
    				  <?php else:?>
    				     <?php if($v->pay_status==$model::PAY_STATUS_NO){
    				           echo Yii::t("memberOrder","等待付款");
    				       }else if($v->pay_status==$model::PAY_STATUS_YES && $v->delivery_status==$model::DELIVERY_STATUS_NOT){
    				         echo Yii::t("memberOrder","备货中...");
    				       }else if($v->pay_status==$model::PAY_STATUS_YES && ($v->delivery_status==$model::DELIVERY_STATUS_NOT || $v->delivery_status==$model::DELIVERY_STATUS_WAIT || $v->delivery_status==$model::DELIVERY_STATUS_SEND)){
    				         echo $model::deliveryStatus($v->delivery_status);  
    				       } 
    				       else if($v->delivery_status==$model::DELIVERY_STATUS_RECEIVE && $v->is_comment==$model::IS_COMMENT_NO){
    				         echo Yii::t("memberOrder","等待评价");
    				       }
    				       else if($v->is_comment==$model::IS_COMMENT_YES){
    				          echo Yii::t("memberOrder","订单完成");
    				       }   
    				      ?>
    				  <?php endif;?>
    				</div>
    				<div class="clear"></div>
    			</div>
    			<?php foreach ($orderGoods as $order):?>
    			<a href="<?php echo $this->createAbsoluteUrl('goods/index',array('id'=>$order->goods_id));?>" title="" class="OSProducts">
    				<?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $order->goods_picture, 'c_fill,h_100,w_100'),'',array('class'=>'fl','width'=>'100'))?>
    				<span class="OSProductsRight fl">
    					<span class="OSProductsInfo">
    					<?php echo $order->goods_name;?>
    					</span>
   				     <?php if (!empty($order->spec_value)): ?>
                         <?php foreach (unserialize($order->spec_value) as $ksp => $vsp): ?>
                             <?php echo $ksp . ':' . $vsp ?>
                         <?php endforeach; ?>
                     <?php endif; ?><br/>
   						<?php echo HtmlHelper::formatPrice($order['unit_price'])."*".$order['quantity'];?> +	
   						<?php echo HtmlHelper::formatPrice($order['freight']);?>   
    				<br />
    				</span>	
    			</a>
    			<?php endforeach; ?>
		
    			<div class="OSlistTitle">
    				<div class="OSlistTitleLeft2 fl">实付（共 <?php echo count($orderGoods);?> 件商品）</div>
    				<div class="OSlistTitleRight fr d32f2f"><?php echo HtmlHelper::formatPrice($v->pay_price) ?></div>
    				<div class="clear"></div>
    			</div>
    			<div class="OSListBtn">
            		<?php if($v->status!=$model::STATUS_CLOSE):?>
            			<?php if($v->pay_status==$model::PAY_STATUS_NO):?>
            			<?php echo CHtml::link(Yii::t('memberOrder', '去支付'), $this->createAbsoluteUrl('orderConfirm/pay', array('code' => $v->code)),array('class'=>'OSListCheckBtn fr'));?>
            			<?php elseif($v->delivery_status==$model::DELIVERY_STATUS_SEND && $v->status==$model::STATUS_NEW):?>
            			<a data_code="<?php echo $v->code;?>" id="signOrder" class="OSListOnfirmBtn fr confirmOrder">确认收货</a>
            			<?php echo CHtml::link(Yii::t('memberOrder', '查看物流'), $this->createAbsoluteUrl('order/logistics', array('code' => $v->code)),array('class'=>'OSListCheckBtn fr'));?>
            			<?php elseif($v->delivery_status==$model::DELIVERY_STATUS_RECEIVE && $v->is_comment==$model::IS_COMMENT_NO):?>
            			<?php echo CHtml::link(Yii::t('memberOrder', '去评价'), $this->createAbsoluteUrl('order/comment', array('code' => $v->code)),array('class'=>'OSListCheckBtn fr'));?>
            			<?php endif;?>
            	   <?php endif;?>		
    			   <?php echo CHtml::link(Yii::t('memberOrder', '订单详情'), $this->createAbsoluteUrl('order/detail', array('code' => $v->code)),array('class'=>'OSListOnfirmBtn fr'));?>	
    				<div class="clear"></div>
    			</div>
    		</li>
    	<?php endforeach; ?>
    	</ul>
			<?php
                            $this->widget('WLinkPager', array(
                                'pages' => $pages,
                                'jump' => true,
                                'prevPageLabel' =>  Yii::t('page', '上一页'),
                                'nextPageLabel' =>  Yii::t('page', '下一页'),
                            ))
             ?>                 	 
    </div>
   </div>
  <?php $this->renderPartial('_orderSign'); ?>
  </body>
</html>
