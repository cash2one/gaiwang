<script src="<?php echo $this->theme->baseUrl; ?>/js/jquery.flexslider-min.js"></script>
<script src="<?php echo $this->theme->baseUrl; ?>/js/shop-v2.0.js"></script>

<?php if (isset($this->design)): ?>
        <style type="text/css">
            body {
            <?php if($this->design->DisplayBgImage): ?> background-image: url('<?php echo IMG_DOMAIN.'/'.$this->design->BGImg ?>');
                background-repeat: <?php echo $this->design->BGRepeat ?>;
                background-position: <?php echo $this->design->BGPosition ?>;
            <?php else: ?> background-color: <?php echo $this->design->BGColor ?>;
            <?php endif; ?>
            }
        </style>
    <?php endif; ?>

<!-- 店铺主体start -->
  	 <?php if ($this->id == 'shop' && ($this->action->id == 'view' || $this->action->id == 'preview')): ?>
        <!-- 幻灯展示 -->
        <?php
        $slide = $this->design->tmpData[DesignFormat::TMP_MAIN_SLIDE];
        $slide = isset($slide['Imgs']) ? $slide['Imgs'] : null;
        ?>
       <!-- end 幻灯展示 --> 
    <?php if (!empty($slide)):?>
  	 <div class="shop-banner">
  		 <ul class="slides">
  		   <?php
  		       foreach($slide as $k => $v):
  		     ?>
    		  <li><a href="<?php echo $v['Link'];?>" title=""><img src="<?php echo IMG_DOMAIN . '/' . $v['ImgUrl']; ?>" alt="<?php echo $v['ImgUrl'];?>" /></a></li>
    	    <?php 
    	       endforeach;  
    	      ?>  
    	</ul>
  	</div>
  	<?php else:?>
  	<div class="shop-banner shopIndex" style="height: 20px"></div>
  	<?php endif; endif;?>
  	
   	<div class="shop-main2 shopIndex" >
   	  <?php 
      		$NewGoods=Goods::newGoods($this->store->id,8);
			if (!empty($NewGoods)):
			$curTwo=array_slice($NewGoods,0,2);
			$lastArr=array_slice($NewGoods,2,6);
  		?>
	   <img width="120" height="95" src="<?php echo $this->theme->baseUrl; ?>/images/bgs/shop_title01.png" class="sm-title"/>     
		<div class="shop-show1">
			<ul class="clearfix">
			  <?php
				//热门销售  
			  if (!empty($curTwo)):
					foreach($curTwo as $c => $s):
				 ?>
			 <li>
				<?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $s['thumbnail'], 'c_fill,h_480,w_490'), $s['name'], array('height' => '480', 'width' => '490')), $this->createAbsoluteUrl('goods/view', array('id' => $s['id'])), array('title' => $s['name'])); ?>
			 </li>
			    <?php 
			       endforeach;
			       endif;
			    ?>
			</ul>
		</div>
		<div class="shop-show2">
			<ul class="clearfix">
				<?php
				//新品推荐
				 if (!empty($lastArr)):
					foreach($lastArr as $k => $v):
				   ?>
				<li>
					<?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_360,w_360'), $v['name'], array('height' => '360', 'width' => '360')), $this->createAbsoluteUrl('goods/view', array('id' => $v['id'])), array('title' => $v['name'])); ?>
					<span class="shop-info1"><?php echo HtmlHelper::formatPrice($v['price']);?></span>
				</li>
				<?php endforeach;endif;?>
			</ul>
		</div>
		<?php  
		     endif;
		?>
		<?php
            //自定义商品列表
                $tmpData=$design->tmpData[DesignFormat::TMP_RIGHT_PROLIST];
                $HotGoods=Design::getGoodsListByCondition($this->store->id,$tmpData,'',20);
				if (!empty($HotGoods['goods'])):
				$diyGoodsArr=array_slice($HotGoods['goods'], 0,20);
             ?>
		<img width="120" height="95" src="<?php echo $this->theme->baseUrl; ?>/images/bgs/shop_title02.png" class="sm-title sm-title2"/>
		<div class="shop-show3">
			<ul class="shop-hotGoods shop-hotGoods2 clearfix">
				<?php 
				     if(!empty($diyGoodsArr)):
				       foreach($diyGoodsArr as $k => $v):
				   ?>
				<li>
					<?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_280,w_292'), $v['name'], array('height' => '280', 'width' => '292')), $this->createAbsoluteUrl('goods/view', array('id' => $v['id'])), array('title' => $v['name'])); ?>
					<p><?php echo HtmlHelper::formatPrice("");?><span><?php echo $v['price'];?></span></p>
					<a href="<?php echo $this->createAbsoluteUrl('goods/view', array('id' => $v['id']));?>" title="" class="shop-hotGoods-title"><?php echo $v['name'];?></a>
				</li>
				<?php 
				   endforeach;
				   endif;
				?>
			</ul>
		</div>
	 <?php endif;?>
		<a href="<?php echo $this->createAbsoluteUrl('shop/product', array('id' => $this->store->id));?>" class="shop-more"><?php echo Yii::t('store', '更多商品')?></a>
  	</div>
  	<!-- 店铺主体end -->
  	<!-- 头部end -->
