<?php
//Cache::setRecommendedCache();
//图片延迟加载

Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/lazyLoad.js');
?>

<!--//图片延迟加载-->

<script type="text/javascript">
	$(function() {
		LAZY.init();
		LAZY.run();
	});
	$(function(){
	//应节性活动页面鼠标选中商品显示效果
	$(".hd_list ul li").hover(function(){
		$(this).find(".hd_item_fd").toggle();
	},function(){
		$(this).find(".hd_item_fd").toggle();
	});
});
</script>
<div class="main">
	<?php if($pic['banner1']) { ?>
	<img alt=""  src="<?php echo ATTR_DOMAIN . '/' . $pic['banner1'] ; ?>" width="100%" height="500" class="hd_banner"/>
	<?php }else{ ?>
	<img alt=""  src="<?php echo DOMAIN; ?>/images/bgs/hd_banner1680X500.jpg" width="100%" height="500" class="hd_banner"/>
	<?php } ?>



	<?php if($pic['banner3']) { ?>
	<img alt="" src="<?php echo ATTR_DOMAIN . '/' . $pic['banner3'] ; ?>" width="100%" height="237" class="hd_title"/>
	<?php }else{ ?>
	<img alt=""  src="<?php echo DOMAIN; ?>/images/bgs/hd_title02.jpg" width="100%" height="237" class="hd_title"/>
	<?php } ?>
	<?php if($goodsOne){?>
	<div class="hd_list hd_list2">
		<ul>
			<?php foreach ($goodsOne as $k => $v) {
				?>
				<li>
					<?php if($v['stock'] < 1){?><a target="_blank" href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['product_id']));?>" ><p class="grabEnd"></p></a><?php }?>
					<div class="hd_item_img">
						<a target="_blank" href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['product_id']));?>" title="">
							<?php if($v['stock'] > 0){ ?>
							<img alt=""  data-url="<?php echo IMG_DOMAIN  .'/'.$v['thumbnail']; ?>" width="380" height="380"/>
							<?php } else{ ?>
							
								<!--<img alt=""  data-url="<?php /*echo IMG_DOMAIN  .'/'.$v['thumbnail']; */?>" width="380" height="380"/>
								<img class="hd_item_img_js" src="<?php /*echo DOMAIN; */?>/images/bgs/spike02.png" width="380" height="380"/>-->
							
							<?php } ?>
						</a>
						<div class="hd_item_fd">
							<div class="hd_item_fd_bg"></div>
							<div class="hd_item_fd_title"><?php echo $v['seller_name']; ?></div>
						</div>
					</div>
					<a target="_blank" href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['product_id']));?>" title="" class="hd_item_title name"><?php echo $v['name'] ?></a>
					<div class="hd_item_info">
					<?php if($v['category_id']==1) { ?>
						    RMB<span class="hd_item_info_font1"><?php echo $v['price'];?></span>
						    <?php }else{ ?>
						RMB<span class="hd_item_info_font1"><?php echo $v['discount_rate']>0 ?  number_format($v['discount_rate']*$v['price']/100,2): number_format($v['discount_price'],2) ?></span>
						<?php } ?>
					</div>
					<?php if($v['stock'] > 0){ ?>

					<a target="_blank" href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['product_id']));?>" title="马上抢购" class="hd_item_fd_but">
						<img alt="马上抢购" src="<?php echo DOMAIN; ?>/images/bgs/hd_buyingPanic.png" width="86" height="80"/>
					</a>

					<?php } ?>
					
				</li>
				<?php } ?>
			</ul>
			<div class="clear"></div>
		</div>
		<?php } ?>

		<?php if($pic['banner4']) { ?>
		<img alt="" src="<?php echo ATTR_DOMAIN . '/' . $pic['banner4'] ; ?>" width="100%" height="246" class="hd_title"/>
		<?php }else{ ?>
		<img alt="" src="<?php echo DOMAIN; ?>/images/bgs/hd_title03.jpg" width="100%" height="246" class="hd_title"/>
		<?php } ?>
		<?php if($goodsTwo){ ?>
		<div class="hd_list hd_list3">
			<ul>
				<?php foreach ($goodsTwo as $k => $v) {		
					?>
					<li>
						<?php if($v['stock'] < 1){?><a target="_blank" href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['product_id']));?>" ><p class="grabEnd"></p></a><?php }?>
						<div class="hd_item_img">
							<a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['product_id']));?>" title="">
								<?php if($v['stock'] > 0){ ?>
							<img alt=""  data-url="<?php echo IMG_DOMAIN  .'/'.$v['thumbnail']; ?>" width="380" height="380"/>
							<?php } else{ ?>

									<!--<img alt=""  data-url="<?php echo IMG_DOMAIN  .'/'.$v['thumbnail']; ?>" width="380" height="380"/>
								<img class="hd_item_img_js" src="<?php /*echo DOMAIN; */?>/images/bgs/spike02.png" width="380" height="380"/>-->
							
							<?php } ?>
							</a>
							<div class="hd_item_fd">
								<div class="hd_item_fd_bg"></div>
								<div class="hd_item_fd_title"><?php echo $v['seller_name']; ?></div>
							</div>
						</div>
						<a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['product_id']));?>" title="" class="hd_item_title name"><?php echo $v['name'] ?></a>
						<div class="hd_item_info">
						    <?php if($v['category_id']==1) { ?>
						    RMB<span class="hd_item_info_font1"><?php echo $v['price'];?></span>
						    <?php }else{ ?>
							RMB<span class="hd_item_info_font1"><?php echo $v['discount_rate']>0 ?  number_format($v['discount_rate']*$v['price']/100,2): number_format($v['discount_price'],2) ?></span>
							<?php } ?>
						</div>
						<?php if($v['stock'] > 0){ ?>

						<a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['product_id']));?>" title="马上抢购" class="hd_item_fd_but"><img alt="马上抢购" src="<?php echo DOMAIN; ?>/images/bgs/hd_buyingPanic.png" width="86" height="80"/></a>
						
						<?php } ?>
						
					</li>
					<?php } ?>
				</ul>
				<div class="clear"></div>
			</div>
			<?php } ?>
			<?php if(empty($goodsOne)){ ?>
			<div style="text-align: center;margin-top: 200px;margin-bottom: 200px;font-size: 18px;font-weight: 700">暂无活动商品</div>
			<?php } ?>
		</div>