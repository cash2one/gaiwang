<!doctype html>
<html>
    <head>
        <title>盖象微商城Eshop_商品分类</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="keywords" content="盖象商城" />
        <meta name="description" content="全国包邮,货到付款,提供最完美的购物体验！" />		
        <meta content="width=device-width, minimum-scale=1,initial-scale=1, maximum-scale=1, user-scalable=no;" id="viewport" name="viewport" /><!--离线应用的另一个技巧-->		
		<meta content="telephone=no,email=no" name="format-detection">
		<link rel="icon" href="../../images/m/favicon.ico" type="image/x-icon" />
        <link rel="bookmark" href="../../images/m/favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="../../images/m/favicon.ico" type="image/x-icon" />
		<link rel="icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
        <link rel="bookmark" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
        <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/global.css"/>
		<link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/comm.css"/>
		<link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/module.css"/>
		<link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/category.css"/>
    </head>
    <body>
		<div class="wrap" id="wrap">			
			<div class="header" id="js-header">
				<div class="mainNav">
					<div class="topNav clearfix">
						<a class="icoBlack  fl" href="javascript:history.go(-1);"></a>
						<a class="logo TxtTitle fl" href="javascript:void(0);">商品分类</a>
						<div class="menuBox fr clearfix">
							<i class="iSearch icoMenu"></i>
							<i class="iMenu icoMenu"></i>
						</div>						
					</div>
					<div class="navCon navSearch">
						<i class="icoTriangle"></i>
						<!-- Search layout -->
						<div class="search">
							<div class="searchBox">
								<form action="search.html">
									<input id="searchInput" class="searchInput" type="text" placeholder="搜索" required/><a href="javascript:void(0)" onclick="document.getElementById('searchInput').value = '';" class="dela">+</a>
									<input class="searchSubmit" type="submit" value="搜索"/>						
								</form>
							</div>						
						</div>
					</div>
					<div class="navCon navMenu">
						<i class="icoTriangle"></i>
						<div class="menuList clearfix">
							<a class="item it01" href="<?php echo $this->createAbsoluteUrl('site/index');?>">首页</a>
							<a class="item it02" href="<?php echo $this->createAbsoluteUrl('category/index');?>">分类</a>
							<a class="item it03" href="<?php echo $this->createAbsoluteUrl('member/index');?>">我的盖象</a>
							<a class="item it04" href="<?php echo $this->createAbsoluteUrl('cart/index');?>">购物车</a>
						</div>
					</div>					
				</div>
			</div>
		</div>
		
			<!-- Category Layout -->
			<div class="category">
				<div class="category-left" id="touchMenu" data-swipe="[object Object]">
					<ul class="cate-list">
					  <?php if(!empty($TopCategory)):
					        $fid=$this->getParam('cid') ? $this->getParam('cid'):$first;
						    foreach($TopCategory as $k => $p):
						  ?>
						<li><a <?php if($p['id']==$fid):?>  class="cur" <?php endif;?>href="<?php echo $this->createAbsoluteUrl('category/index',array('cid'=>$p['id']));?>"><img src="<?php echo DOMAIN; ?>/images/m/adverts/smallCate<?php if ($p['id']<10){echo "0".$p['id']; }else{echo $p['id'];}?>.jpg" alt="<?php echo $p['name']?>"/><i class="icoTriangle"></i></a></li>
					 <?php endforeach;?>
					</ul>
				</div>
				<div class="category-right" id="touchBox" data-swipe="[object Object]" style="width:100%;overflow-y:scroll;overflow-x:hidden;border:none;">
					<div class="cateConts" >
					<!-- 分类页广告 -->
						 <div class="cateAdver">
						 <?php 
						       $category_adverts=array(
						                '1'=>'http://m.g-emall.com/store/proList/194.html',
                                        '2'=>'http://m.g-emall.com/store/proList/1851.html',
                                        '3'=>'http://m.g-emall.com/store/proList/1742.html',
                                        '4'=>'http://m.g-emall.com/store/proList/1334.html',
                                        '5'=>'http://m.g-emall.com/store/proList/985.html',
                                        '6'=>'http://m.g-emall.com/goods/index/5616',
                                        '7'=>'http://m.g-emall.com/store/proList/19.html',
                                        '8'=>'http://m.g-emall.com/store/proList/1225.html',
                                        '9'=>'http://m.g-emall.com/store/proList/586.html',
                                        '10'=>'http://m.g-emall.com/store/proList/106.html',
                                        '11'=>'http://m.g-emall.com/store/proList/1344.html',
                                        '12'=>'http://m.g-emall.com/store/proList/1013.html',
                                        '14'=>'http://m.g-emall.com/store/proList/361.html',
                                        '889'=>'http://m.g-emall.com/store/proList/1379.html',             
						       );
						     ?>
						 <a href="<?php echo $category_adverts[$fid]; ?>">
						     <img src="<?php echo DOMAIN; ?>/images/m/adverts/cateMenu<?php echo $fid;?>.jpg" alt="<?php echo $p['name'];?>"/>
						 </a>
						  </div>
						<?php
							if(!empty($treeCategory['childClass'])): 
							   foreach($treeCategory['childClass'] as $c):?>			
						<div class="cateItem">
							<p class="columnTit"><a href="<?php echo $this->createAbsoluteUrl('category/list',array('cid'=>$c['id']));?>"><?php echo $c['name']?></a></p>
							<ul class="itemList clearfix">
							  <?php if(!empty($c['childClass'])): foreach($c['childClass'] as $s):?>
								<li><a class="item" href="<?php echo $this->createAbsoluteUrl('category/prolist',array('cid'=>$s['id']));?>"><?php echo $s['name']?></a></li>	
								<?php endforeach;?>
								 <?php else:?>
								 <li><a class="item" href="<?php echo $this->createAbsoluteUrl('category/prolist',array('cid'=>$c['id']));?>"><?php echo $c['name']?></a></li>	
								 <?php endif;?>						
							</ul>
						</div>	
						<?php endforeach;?>	
						<?php else:?>
							<?php 
							      $cid=$this->getParam('cid');
					              $name=Category::getCategoryName($cid);
				               ?>
				                 <div class="cateItem">
				                  <p class="columnTit"><a href="<?php echo $this->createAbsoluteUrl('category/list',array('cid'=>$cid));?>"><?php echo $name ?></a></p>
				                   <ul class="itemList clearfix">
				                      <li><a class="item" href="<?php echo $this->createAbsoluteUrl('category/prolist',array('cid'=>$cid));?>"><?php echo $name ?></a></li>	  
				                   </ul>
				                 </div>	
				                        				
					<?php endif;?>							
					</div>
				<?php endif;?>
				</div>
			</div>
	</body>	
<?php
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/m/jquery.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/m/template.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/m/jquery.touchSwipe.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/m/jquery.touchslider.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/m/com.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/m/categoryScrollNew.js', CClientScript::POS_HEAD);
?>
</html>
