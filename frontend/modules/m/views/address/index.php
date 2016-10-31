<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $this->pageTitle?>_收货地址</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="bookmark" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/global.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/comm.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/member.css" type="text/css"/>
	<script type="text/javascript" src="<?php echo DOMAIN; ?>/js/m/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="<?php echo DOMAIN; ?>/js/m/member.js"></script>
</head>

      <?php if(Yii::app()->user->hasFlash('message')): ?>
           <script type="text/javascript">
                 alert('<?php echo Yii::app()->user->getFlash('message'); ?>');
           </script>
        <?php endif;?>
  
  <body>
  <?php
  $goods = isset($_GET['goods']) ? $this->getQuery('goods') : '';
  $quantity = isset($_GET['quantity']) ? $this->getQuery('quantity') : '';
  ?>
  <div class="wrap">
 	<div class="header" id="js-header">
		<div class="mainNav">
			<div class="topNav clearfix">
				<a class="icoBlack fl" href="<?php echo $this->createAbsoluteUrl('member/index');?>"></a>
				<a class="TxtTitle fl" href="javascript:void(0);"><?php echo $this->showTitle;?></a>
                <?php if(!empty($goods) && !empty($quantity)):?>
                    <a href="<?php echo $this->createAbsoluteUrl('address/create',array('goods' => $goods,'quantity' => $quantity))?>" class="ordersSearchBtn fr">添加</a>
                <?php elseif(!empty($cart)):?>
                    <a href="<?php echo $this->createAbsoluteUrl('address/create',array('cart'=>$cart))?>" class="ordersSearchBtn fr">添加</a> 
                <?php else:?>
				<a href="<?php echo $this->createAbsoluteUrl('address/create')?>" class="ordersSearchBtn fr">添加</a>
                <?php endif; ?>
			</div>
		</div>
	</div>
    <div class="main">
    	<ul class="OSList addressList">
    	<?php foreach ($address as $as): ?>
    		<li>
    			<div class="OSProducts <?php if($as->default):?>addressSel<?php endif;?>">
                    <span class="addressId" style="display: none"><?php echo $as->id;?></span>
    				收货人：<?php echo $as->real_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $as->mobile; ?><br/>
    				<span class="gray"><?php echo $as->province->name.$as->city->name.$as->district->name.$as->street;?></span>
    			</div>
    		</li>
    		
        <?php endforeach;?>
    	</ul>
        <?php if(isset($_GET['cart_goods']) && !empty($_GET['cart_goods'])){
            $goodsArr = $_GET['cart_goods'];
            $cartGoods = implode(',',$goodsArr);
        }?>
    </div>

   </div>
  <script>
    function addDefault(){
        var address_id = $('.addressSel').find('.addressId').text();
        if(address_id.length <= 0){
            return false;
        }
        var gs = "<?php if(!empty($_GET['goods'])){echo $_GET['goods'];}else{echo "";};?>";
        var quantity = "<?php if(!empty($_GET['quantity'])){echo $_GET['quantity'];}else{echo "";};?>";
        var cart = "<?php if(!empty($_GET['cart'])){echo $cart;}else{echo "";}?>";
        $.post("<?php echo Yii::app()->createUrl('/m/address/default'); ?>",{address_id:address_id,gs:gs,quantity:quantity,cart:cart,YII_CSRF_TOKEN:"<?php echo Yii::app()->request->csrfToken;?>"},function(msg){
            var data= eval("("+msg+")");
             alert(data.msg);  
            if(data.tips == 2 && gs.length > 0 && quantity.length > 0){
                location.href = "<?php echo Yii::app()->createUrl('/m/orderConfirm/index',array('goods'=>$goods,'quantity' => $quantity)); ?>";
            }
            if(data.tips == 2 && cart==1){
            	window.location.href = "<?php echo Yii::app()->createUrl('/m/cart/confirm',array('cart'=>"1"));?>";
            	//location.href = "<?php echo Yii::app()->createUrl('/m/cart/index');?>";
            }
        });   
    }
  </script>
  </body>
</html>
