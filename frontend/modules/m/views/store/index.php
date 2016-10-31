			<div class="main">
				<div class="container">

					<div class="touchslider proSlider shopSlider">
						<div class="touchslider-viewport">
							<div class="touchslider-item"><a href="#"><?php  echo CHtml::image(ATTR_DOMAIN . '/' . $store->thumbnail,$store->name)?></div>
						</div>
						<a class="icoCover" href="#"><span></span></a>
					</div>					
					
					<div class="proMsg shopMsg">						
						<p class="names"><?php echo Tool:: truncateUtf8String($store->name,15); ?></p>
						<div class="infor">总商品数（<?php echo $goodsCount;?>个）<div class="shopScore">
						<?php 
						  $description_match=$store->description_match;
						  /*$serivice_attitude=$store->serivice_attitude;
						  $speed_of_delivery=$store->speed_of_delivery;
						  $comment=$store->comments ? $store->comments:1;
						  $score=($description_match+$serivice_attitude+$speed_of_delivery)/$comment/3;
						  echo $score;*/
						 $score=$store->avg_score;
						   if(empty($score)){
						       echo '暂无评论';
						   }else{
						       echo '<span class="rateStar"><i class="score" style="width:90%;"></i></span>'.$score;
						   }
						 ?>
						</div></div>	
						<!--  					
						<p class="share"><a class="icoShare" href="" >分享有礼</a><span class="blue">小伙伴们快点行动吧</span></p>
					        -->
					</div>			
					
					<div class="column">
						<div class="columnContent nobg">
							<ul class="products02 clearfix">
							<!-- 人气商品 -->
							<?php if(!empty($hot['goods'])):
							$hotGoods=array_splice($hot['goods'],'0','2');
							 ?>
							<?php foreach ($hotGoods as $good): ?>
								<li>
									<a class="item" href="<?php echo $this->createAbsoluteUrl('goods/index',array('id'=>$good['id']));?>">
										<?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $good['thumbnail'], 'c_fill,h_240,w_620'), $good['name'])?>
										<div class="itemInfor">
											<p class="proname shopname clearfix"><span class="a txtLeft"><?php echo $good['name'];?></span><span class="b red"><?php echo HtmlHelper::formatPrice($good['price']) ?></span></p>
										</div>
									</a>
								</li>
							<?php endforeach;?>
							<?php endif;?>
							<!-- 人气商品 -->								
							</ul>
						</div>						
					</div>
					
					<!-- Advertisement 310*57.5 
					<?php if(!empty($coupon)):?>
							<?php foreach ($coupon as $c): ?>					
					<div class="adverLink clearfix">
					  <a class="item" href="#">
					    <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $coupon->thumbnail, 'c_fill,h_170,w_170'), $coupon->name)?>
					    </a></div>
					    <div class="adverLink clearfix">
					 <?php endforeach;?>	
							<?php endif;?>   			
					-->
					
					<div class="column fullScreen">
						<div class="columnTit mgtop15">店家推荐</div>
						<div class="columnContent nobg">
							<ul class="products03 clearfix" id="goodlist">
							<?php if(!empty($reccomend['goods'])):
							   $reccomend=array_splice($reccomend['goods'],'0','3');
							?>
							<?php foreach ($reccomend as $good): ?>
								<li>
									<a class="item" href="<?php echo $this->createAbsoluteUrl('goods/index',array('id'=>$good['id']));?>">
										<?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $good['thumbnail'], 'c_fill,h_170,w_170'), $good['name'])?>
										<div class="itemInfor">
											<p class="proname"><?php echo Tool:: truncateUtf8String($good['name'],10);?></p>
											<p class="clearfix"><span class="fl price"><b class="red"><?php echo HtmlHelper::formatPrice($good['price']) ?></b></span></p>
										</div>
									</a>
								</li>
							<?php endforeach;?>	
							<?php endif;?>	
							</ul>
							<div class="getMore"><a class="getMoreBtn" href="<?php echo $this->createAbsoluteUrl('store/proList',array('id'=>$store->id));?>">查看所有商品</a></div>
						</div>							
					</div>
					 <?php if(!empty($scategory)):?>
					<div class="category categoryList clearfix fullScreen mgtop15">
						<div class="tableTag">
							<div class="tag">
								<div class="columnTit titBg">店家目录</div>
								<div class="tagList clearfix">
								<?php 
								  $sate=array_splice($scategory,0,7);
								   foreach($sate as $s):
								  ?>
								 <a class="item" href="<?php echo $this->createAbsoluteUrl('store/proList',array('id'=>$store->id,'cid'=>$s['id']));?>"><span><?php echo Tool:: truncateUtf8String($s['name'],4,''); ?></span></a>
								<?php endforeach;?>
								<a class="item more" href="<?php echo $this->createAbsoluteUrl('store/scate',array('id'=>$store->id));?>"><span class="gray">更多></span></a> 
								
								</div>
								
							</div>							
						</div>						
					</div>
					  <?php endif;?>
					<div class="clearfix mgtop20 bottomC"></div>
					<!-- <div class="payBtn clearfix">
						<a class="payNow fl" href="orderConfirmation.html">立即购买</a>
						<a class="goCart fr" href="cart.html">加入购物车</a>
					</div> -->
				</div>
			</div>
		<script src="<?php echo DOMAIN; ?>/js/m/jquery.touchslider.min.js"></script>		          
        <script src="<?php echo DOMAIN; ?>/js/m/template.js"></script>
		<script src="<?php echo DOMAIN; ?>/js/m/com.js"></script>
	</body>	
</html>
