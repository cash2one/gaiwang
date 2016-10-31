<?php
/* @var $this Controller */
?>
<div class="wrap" id="wrap">
	<div class="header" id="js-header">
				<div class="mainNav">
					<div class="topNav clearfix">
					 <?php if($this->order):?>
					    <a class="icoBlack fl" href="<?php echo $this->createAbsoluteUrl('order/index')?>"></a>
					 <?php elseif($this->id!="site"):?>	
						<a class="icoBlack  fl" href="javascript:history.go(-1);"></a>
					 <?php endif;?>
						<a class="logo TxtTitle fl" href="javascript:void(0);"><?php echo $this->showTitle; ?></a>
					<?php if($this->top):?>			 
						<div class="menuBox fr clearfix">
							<i class="iSearch icoMenu"></i>
							<i class="iMenu icoMenu"></i>
						</div>						
					</div>
				
					<div class="navCon navSearch">
						<i class="icoTriangle"></i>
						<!-- Search layout -->
						<?php $p=$this->getParam('p');?>
						<div class="search">
							<div class="searchBox">
								<form action="<?php echo $this->createUrl('search/search'); ?>">
									<input id="searchInput" name="p" <?php if(isset($p)):?> value="<?php echo $p;?>" <?php endif;?>class="searchInput" type="text" placeholder="搜索" required/><a href="javascript:void(0)" onclick="document.getElementById('searchInput').value = '';" class="dela">+</a>
									<input class="searchSubmit" type="submit" value="搜索"/>						
								</form>
							</div>						
						</div>
					</div>
					<div class="navCon navMenu">
						<i class="icoTriangle"></i>
						<div class="menuList clearfix">
							<a class="item it01" href="<?php echo $this->createAbsoluteUrl('site/');?>">首页</a>
							<a class="item it02" href="<?php echo $this->createAbsoluteUrl('category/');?>">分类</a>
							<a class="item it03" href="<?php echo $this->createAbsoluteUrl('member/');?>">我的盖象</a>
							<a class="item it04" href="<?php echo $this->createAbsoluteUrl('cart/');?>">购物车</a>
						</div>
					</div>					
				</div>
				<?php endif;?>
			</div>
			