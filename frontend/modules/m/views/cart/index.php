<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $this->pageTitle?>_购物车</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="bookmark" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/global.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/comm.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/member.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/alertStyle.css" type="text/css"/>
    <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/m/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/m/member.js"></script>
    <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/m/alertJs.js"></script> 
</head>
<body>

<?php echo CHtml::form('/cart/confirm') ?>

<div class="wrap ODWrap">
    <div class="header" id="js-header">
        <div class="mainNav">
            <div class="topNav clearfix">
                <a class="icoBlack fl" href="javascript:history.go(-1);"></a>
                <a class="TxtTitle fl" href="javascript:void(0);">购物车</a>
                <a href="#" class="DeleteBtn OSListOnfirmBtn fr" onclick="deleteRecord()">删除</a>
            </div>
        </div>
    </div>
    <div class="main">
        <?php if (!empty($cart['cartInfo'])): ?>
        <div class="cartQSel">
            <span class="cartSel cartQSelTotal fl" num="1"></span><span class="fl">全选</span>
        </div>

        <!-- 购物车开始 -->
            <?php foreach ($cart['cartInfo'] as $key => $val):?>
                <div class="ODItem ODItem2">
                    <ul>
                        <li>
                            <div class="OSlistTitle cartTitle">
                                <div class="OSlistTitleLeft cartTitleLeft fl">
                                    <span class="cartSel cartQSelTotal cartModuleSel fl " num="1"
                                          data_cart="<?php echo $key; ?>"></span>
                                <span class="fl cartName">
                                    <a href="<?php echo $this->createUrl('store/index', array('id' => $key)); ?>"><?php echo $val['storeName'] ?></a>
                                </span>
                                </div>
                                <span class="cartTitleRight fr" id="EditStore_<?php echo $key?>" storeId="<?php echo $key;?>">
                                   <img width="25" src="<?php echo DOMAIN; ?>/images/m/bg/m_ioc15.png"/>OK</span>
                                <div class="clear"></div>
                            </div>
                        </li>
                    </ul>
                    <!-- 产品列表 -->

                    <ul class="cartList">
                        <?php foreach ($val['goods'] as $k => $v): 
                          if ($v['join_activity'] == Goods::JOIN_ACTIVITY_YES && !empty($v['activity_tag_id']) && $v['at_status'] == ActivityTag::STATUS_ON) {
                            $v['goodsType']='hb_goods';
                           } else {
                               $v['goodsType']='default_goods';
                            }
                            //购物车商品是否过期,即商品库存等于0
                            //$isValid=GoodsSpec::getSpecData($v['spec_id'],array('stock'));
                            $sArr= explode(" ", $v['spec']);
                            array_pop($sArr);
                            $specVal="";
                            foreach($sArr as $s){
                                $specArr = explode(':', $s);
                                $specVal.=isset($specArr[1]) ? $specArr[1]."|" : '';
                            }
                            $v['specVal']=$specVal;
                            
                        ?>
                            <li>
                                <span class="cartSel cartQSelTotal fl cartThisSel"  num="1"  id="storeSel_<?php echo $key?>"
                                    data_store=<?php echo $key;?>  data_goodid=<?php echo $v['goods_id'] . "-" . $v['spec_id'] ?>></span>

                                <div class="OSProducts fl cartProducts">
                                    <a href="<?php echo $this->createUrl('goods/index', array('id' => $v['goods_id'])); ?>"
                                       title="<?php echo Tool::truncateUtf8String($v['name'],15); ?>">
                                        <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_54,w_54'), Tool::truncateUtf8String($v['name'],15), array('width' => '80', 'class' => "fl")) ?>
                                    </a>
                           <span class="OSProductsRight cartProductsRight fl">
                                <span class="goods_id" style="display: none;"><?php echo $v['goods_id']; ?></span>
                                <a href="javascript:void()"
                                   title="<?php echo $v['name']; ?>"
                                   class="OSProductsInfo"><?php echo $v['name']; ?></a>
		   						<span class="ODItem2Info storeOld_<?php echo $key; ?>" id="OD_<?php echo $v['goods_id'] . "-" . $v['spec_id'] ?>">
                                    <?php
                                    $arr = explode(" ", $v['spec']);
                                    array_pop($arr);
                                    foreach ($arr as $spec) {
                                        $specArr = explode(":", $spec); 
                                        ?>
                                        <?php echo isset($specArr[0]) ? $specArr[0] . ':' : ''; ?><span class="colorSet"><?php echo isset($specArr[1]) ? $specArr[1] :''; ?></span>
                                        <br/>
                                    <?php }?>
                                    <span class="d32f2f price"><?php echo HtmlHelper::formatPrice($v['price']) ?></span>&nbsp;&nbsp;&nbsp;&nbsp;<span
                                        class="fontC quantity"><?php echo $v['quantity'] ?></span>
			   					</span>		
			   					
                               <span class="ODItem2Info02 storeEdit_<?php echo $key; ?>"  id="OD02_<?php echo $v['goods_id'] . "-" . $v['spec_id'] ?>">
                                   <?php if(!empty($arr)):?>
                                   <span id="specNew_<?php echo $v['goods_id'] . "-" . $v['spec_id'] ?>" onclick="editSpec(<?php echo $v['goods_id'];?>,<?php echo $v['spec_id'];?>,'<?php echo $v['specVal']; ?>');">          
                                   <?php
                                   foreach ($arr as $spec) {
                                       $specArr = explode(':', $spec);
                                       ?>
                                       <p><?php echo isset($specArr[0]) ? $specArr[0] . ':' :''; ?><span class="d32f2f selectItem"><?php echo isset($specArr[1]) ? $specArr[1] :''; ?></span></p>
                                   <?php } ?>
                                          
                                   </span>
                                   <?php endif;?>
                                   <div class="showNum">
                                        <div class="fr SelNumRight" style="float:left;">
                                            <div class="fl SelNumJian" id="SelNumJian" onclick="CartNumUpdate('1','<?php echo $v['goods_id']?>','<?php echo $v['spec_id']?>','<?php echo $v['stock'];?>')"></div>
                                            <input type="hidden" value="<?php echo $v['goodsType']?>" id="goodsType_<?php echo $v['goods_id']?>-<?php echo $v['spec_id']?>">
                                            <input type="number" readonly value="<?php echo $v['quantity'];?>" class="fl setNum" id="quantity_<?php echo $v['goods_id']?>-<?php echo $v['spec_id']?>" max="50"/>
                                            <input type="hidden" value="<?php echo $v['spec_id']?>" id="specId_<?php echo $v['goods_id'] ?>-<?php echo $v['spec_id'] ?>">
                                            <div class="fl SelNumJia" id="SelNumJia" onclick="CartNumUpdate('2','<?php echo $v['goods_id']?>','<?php echo $v['spec_id']?>','<?php echo $v['stock'];?>')"></div>
                                            <div class="clear"></div>
                                        </div>
                                        <!-- 
                                       <p>数量：<span class="number" style="color:#D32F2F;"><?php echo $v['quantity'] ?></span></p>
                                          -->
                                   </div>
			   					</span>
			   					<!-- 商品属性编辑结束 -->
			   					<input type="hidden" id="cartQSel_<?php echo $v['store_id']; ?>_<?php echo $v['goods_id'] . "-" . $v['spec_id'] ?>" name="" value="<?php echo $v['goods_id'] . "-" . $v['spec_id'] ?>">
		    				</span>
                                    <span class="clear"></span>
                                </div>
                                <span class="clear"></span>
								<div class="liMask"></div>
                            </li>
                        <?php endforeach; ?>
                    </ul> 
                    <!-- 产品列表 -->
                </div>  
            <?php endforeach; ?>
             
      <!-- 失效产品列表 开始-->
      <?php if(!empty($unVliadGoods)):
         $goodsIdStr="";
        ?>
        <div class="topNav clearfix" style="">
                <a href="#" class="DeleteBtn OSListOnfirmBtn fr" onclick="deleteUnValidGoods()">清空失效商品</a>
            </div>
      <?php foreach($unVliadGoods as $u=>$n):?>  
			<div class="ODItem">
				<ul class="failureList">
					<li class="failure">
						<span class="failureTag fl" num="1">失效</span>
						<div class="OSProducts fl cartProducts">
							<a href="#" title=""><img width="80" class="fl" src="../images/temp/m_img1.jpg"></img></a>
							<span class="OSProductsRight cartProductsRight fl">
								<a href="#" title="" class="OSProductsInfo"><?php echo $n['name']?></a>
								<span class="ODItem2Info">
									<span class="d32f2f"><?php echo HtmlHelper::formatPrice($n['price']) ?></span><span class="fontC">&nbsp;x&nbsp;<?php echo $n['quantity'];?></span>
								</span>								
							</span>
							<span class="clear"></span>
						</div>
						<span class="clear"></span>
						<div class="liMask"></div>
					</li>						
				</ul>
			</div>
                 </div> 
                 <?php 
                      $goodsIdStr.=$n['goods_id']."-".$n['spec_id']."||";
                 ?>
              <?php endforeach;?>
                  <input type="hidden" value="<?php echo $goodsIdStr;?>" id="goodsIdStrs">
          <?php endif;?>
   <!-- 失效商品列表结束 -->              
            <?php else:?>
                   <div>您的购物车还没有商品 <a href="<?php echo $this->createAbsoluteUrl('site/index');?>"><span style="color:red;">去逛逛！</span> </a></div>
        <?php endif; ?>
    </div>

    <!--某一商品属性编辑-->
    <div class="setMask"></div>
    <div class="setColorItem">
        <span class="cartTitleOK fr"  onclick="updateAction();" >确认</span>

        <div class="OSProducts">
            <a href="#" title="">
                <img width="80" class="fl" src=""/>
					<span class="OSProductsRight fl">
						<span class="OSProductsInfo"></span>
						<span class="d32f2f"></span>
						<span class="SCPriced"></span>
						<span class="specData"></span>
					</span>
            </a>
        </div>
        <div class="ColorList">
        </div>
        <!-- 属性编辑结束 -->
    </div>
    <!-- 底部固定按钮 -->
    <div class="ODFooter">
        <div class="OSListBtn">
            <div class="fl cartCount">合计（不含运费）:<span class="d32f2f" id="totalPrice">￥0.00</span>
                <span class="d32f2f" id="countCart"></span>
            </div>

            <?php echo CHtml::submitButton(Yii::t('message', "结算(0)"), array('class' => 'OSListOnfirmBtn cartBtn fr')); ?>
            <!--
   				 <a href="<?php echo $this->createUrl('orderConfirm/index'); ?>" class="OSListOnfirmBtn cartBtn fr">结算(0)</a>
   				 -->
            <div class="clear"></div>
        </div>
    </div>
</div>
<?php echo CHtml::endForm() ?>
<?php $this->renderPartial('_cartUpdateJs'); ?>
</body>
<?php $tips = Yii::app()->user->hasFlash('tips'); ?>
<?php if($tips): ?>
<script type="text/javascript" src="<?php echo DOMAIN; ?>/js/artDialog/jquery.artDialog.js?skin=aero"></script> 
    <script>
    //成功样式的dialog弹窗提示
     art.dialog({
         icon: 'succeed',
         content: '<?php echo Yii::app()->user->getFlash('tips'); ?>',
         ok: true,
         okVal:'<?php echo Yii::t('member','确定') ?>',
        title:'<?php echo Yii::t('member','消息') ?>'
     });
    </script>
<?php endif; ?>
</html>
