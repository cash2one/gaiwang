
    <?php if ($this->id == 'shop' && isset($this->design)): ?>
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
    
  <?php
        $slide = $this->design->tmpData[DesignFormat::TMP_MAIN_SLIDE];
        $slide = isset($slide['Imgs']) ? $slide['Imgs'] : null;
        ?>
 <div class="shop-banner" id="banner">
  		 <ul class="slides">
  		  <?php if (!empty($slide)):
  		       foreach($slide as $k => $v):
  		     ?>
    		<li><a href="<?php echo $v['Link'];?>" title="<?php echo $v['Title']?>"><img src="<?php echo IMG_DOMAIN . '/' . $v['ImgUrl']; ?>" alt="<?php echo $v['ImgUrl'];?>" /></a></li>
    	    <?php 
    	       endforeach;
    	       else:
    	      ?>
    	      <li><a href="#" title=""><img src="<?php echo $this->theme->baseUrl;?>/images/bgs/st_showDefaultImg.jpg" alt="gx_banner1893x448.jpg" width='1893' height='488'/></a></li>
    	      <?php endif;?>
    	</ul>
  	</div>
  <div class="shop-main2 w1200">
    <div id="">
      <img width="120" height="95" src="<?php echo $this->theme->baseUrl; ?>/images/bgs/shop_title01.png" class="sm-title"/>	
        <?php 
      		$NewGoods=Goods::newGoods($this->store->id,8);
			if (!empty($NewGoods)):
			$curTwo=array_slice($NewGoods,0,2);
			$lastArr=array_slice($NewGoods,2,6);
			endif;
  		?>
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
			        else:
			    ?>
			      <li><a><img width="490" height="480" src="<?php echo $this->theme->baseUrl;?>/images/bgs/st_showDefaultImg.jpg" alt=""></a></li>
			  <?php endif;?>
			</ul>
		</div>
		<div class="shop-show2">
			<ul class="clearfix">
				<?php
				//热门销售  
				 if (!empty($lastArr)):
					foreach($lastArr as $k => $v):
				   ?>
				<li>		
					<?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_360,w_360'), $v['name'], array('height' => '360', 'width' => '360')), $this->createAbsoluteUrl('goods/view', array('id' => $v['id'])), array('title' => $v['name'])); ?>
					<span class="shop-info1"><?php echo HtmlHelper::formatPrice($v['price']);?></span>
				</li>
				<?php 
				  endforeach;
				  else:
				?>
				  <li>
					<a href="#" title=""><img width="360" height="360" src="<?php echo $this->theme->baseUrl;?>/images/bgs/st_showDefaultImg.jpg" alt=""/></a>
					<span class="shop-info1"><?php echo HtmlHelper::formatPrice(null);?>00.00</span>
				</li>  
				<?php endif;?>
			</ul>
		</div>
    </div>	    
    	  
  
<div id="proNew">
       <?php
            //自定义商品列表
                $tmpData=$design->tmpData[DesignFormat::TMP_RIGHT_PROLIST];
                $HotGoods=Design::getGoodsListByCondition($this->store->id,$tmpData);
                if (!empty($HotGoods['goods'])):
                $diyGoodsArr=array_slice($HotGoods['goods'], 0,20);
                endif;
             ?>
 <img width="120" height="95" src="<?php echo $this->theme->baseUrl; ?>/images/bgs/shop_title02.png" class="sm-title sm-title2"/>
  		<div class="shop-show3">
  		<ul class="shop-hotGoods shop-hotGoods2 clearfix">
  			 <?php 
  		      if (!empty($diyGoodsArr)):
                foreach($diyGoodsArr as $k => $v):
                
  		    ?>
  			<li>
  				<?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_280,w_282'), $v['name'], array('height' => '280', 'width' => '282')), $this->createAbsoluteUrl('goods/view', array('id' => $v['id'])), array('title' => $v['name'])); ?>
  			  	<p><?php echo HtmlHelper::formatPrice(null);?><span><?php echo $v['price'];?></span></p>
  				<a href="<?php echo $this->createAbsoluteUrl('goods/view', array('id' => $v['id']));?>" title="" class="shop-hotGoods-title"><?php echo $v['name'];?></a>
  			</li>
  			<?php 
        	       endforeach;
        	        else:
    	       ?>
    	    <li>
  				<a href="#" class="shop-hotGoods-img" title=""><img width="282" height="280" src="<?php echo $this->theme->baseUrl;?>/images/bgs/st_showDefaultImg.jpg" alt=""></a>
  				<p><?php echo HtmlHelper::formatPrice(null);?><span>00.00</span></p>
  				<a href="#" title="" class="shop-hotGoods-title"><?php echo Yii::t('sellerDesign', '商品名称')?></a>
  				<a href="#" title="" class="shop-but"><?php echo Yii::t('sellerDesign', '立即')?><br><?php echo Yii::t('sellerDesign', '抢购')?></a>
  			 </li>
    	       <?php endif;?>
  		</ul>
</div>
</div>
</div>