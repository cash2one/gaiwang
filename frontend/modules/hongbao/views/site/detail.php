<div class="positionWrap pt10">
	<div class="position">
		<a href="<?php echo DOMAIN?>"><?php echo Yii::t('Public', '盖象商城')?></a>&nbsp;&gt;&nbsp;
		<a href="<?php echo Yii::app()->controller->createUrl('index')?>"><?php echo Yii::t('Public', '盖网红包')?></a>&nbsp;&gt;&nbsp;
		<a href="<?php echo Yii::app()->controller->createUrl('list')?>"><?php echo Yii::t('Public', '购物红包')?></a>&nbsp;&gt;&nbsp;
		<a href="<?php echo Yii::app()->controller->createUrl('listSub',array('type' => $storeData['category_id']))?>"><?php echo CouponActivity::getCouponType($storeData['category_id'])?></a>&nbsp;&gt;&nbsp;
		<b><?php echo Yii::t('Public', '盖惠券详情')?></b>
	</div>
</div>
<div class="main w1200">
	<div class="clearfix">
		<div class="main_leftContent02">
			<div class="redEnvDet">
				<div class="redEnvDetInfo clearfix">	
					<h1><?php echo $storeData['name'].'  '.$couponData['name']?></h1>
					<div class="company">
						<div class="icon_v_h getUse clearfix">
							<div class="img"><img width="130" height="130" alt="" src="<?php echo IMG_DOMAIN.'/'.$couponData['thumbnail']?>"></div>
							<div class="fullUse">
								<p class="price">￥<span class="num"><?php echo (int)$couponData['price']?></span></p>
								<a class="btnUse" title="" href="#"><?php echo Yii::t('Public', '购满') . (int)$couponData['condition'] . Yii::t('Public', '使用')?></a>
							</div>
						</div>
					</div>
					<div class="para">
						<p class="icon_v range"><?php echo Yii::t('Public', '适用范围：限定本店商品')?></p>
						<p class="icon_v limited"><?php echo Yii::t('Public', '使用期限').'：'.date('Y-m-d', $couponData['valid_start']) . Yii::t('Public', '至') . date('Y-m-d', $couponData['valid_end'])?></p>
						<p class="icon_v remainCount"><?php echo Yii::t('Public', '剩余数量').'：'.$couponData['excess'] . Yii::t('Public', '张') .'（'. Yii::t('Public','已有').($couponData['sendout'] - $couponData['excess']).Yii::t('Public','人次领取').'）'?></p>
                        <?php if($button){
                            echo "<a class=\"{$button['class']}\" href=\"{$button['href']}\">{$button['content']}</a>";
                        }?>
						<div style="line-height:12px;" class="bdshare_b left" id="bdshare">
							<img src="http://bdimg.share.baidu.com/static/images/type-button-1.jpg?cdnversion=20120831">
						</div>
					</div>
				</div>
				<div class="icon_v_h useStep">
					<span class="howUse"><?php echo Yii::t('Public', '如何使用这张券')?>?</span>
					<span>1.<?php echo Yii::t('Public', '领取盖惠券')?></span>
					<span>2.<?php echo Yii::t('Public', '挑选商品')?></span>
					<span>3.<?php echo Yii::t('Public', '下单立享优惠')?></span>
				</div>
				<div class="useDesc">
					<h3><?php echo Yii::t('Public', '使用说明')?>:</h3>
					<p>1、<?php echo Yii::t('Public', '此券面值为')?><span class="red"><?php echo (int)$couponData['price'].Yii::t('Public', '元')?></span>，<?php echo Yii::t('Public', '购买指定商品满')?><span class="red"><?php echo (int)$couponData['condition'].Yii::t('Public', '元立减').(int)$couponData['price'].Yii::t('Public', '元')?></span></p>
					<p>2、<?php echo Yii::t('Public', '有效期')?>：<span class="red"><?php echo date('Y-m-d', $couponData['valid_start']) . Yii::t('Public', '至') . date('Y-m-d', $couponData['valid_end'])?></span>，<?php echo Yii::t('Public', '请及时使用，过期无效')?></p>
					<p>3、<?php echo Yii::t('Public', '盖惠券数量有限，先到先得；相同盖惠券未使用完则不可再次领取')?>。</p>
					<p>4、<?php echo Yii::t('Public', '盖惠券每次只能使用1张，不可与其他优惠叠加使用。部分特价商品不参与优惠活动')?>。</p>
					<p>5、<?php echo Yii::t('Public', '此券不挂失，不找零，不兑换现金，不可以抵扣运费')?>。</p>
					<p>6、<?php echo Yii::t('Public', '该券最终解释权归商家所有，如有任何疑问请进入相关店铺咨询')?>。</p>
				</div>	
			</div>
		</div>
		<div class="main_right02">
			<div class="busiIntrod">
				<h3 class="icon_v_h title"><?php echo Yii::t('Public', '商家介绍')?></h3>
				<div class="content">
					<img width="80" height="80" alt="" src="<?php echo IMG_DOMAIN.'/'.$storeData['thumbnail']?>">
					<h3><?php echo $storeData['name']?></h3>
                    <?php $point = $storeData['comments'] == 0 ? 0 : substr(sprintf("%.3f", (($storeData['description_match']+$storeData['serivice_attitude']+$storeData['speed_of_delivery'])/$storeData['comments'])/3), 0, -1);?>
					<p><span class="point p_d<?php echo sprintf("%02d", ceil($point*10));?>"></span>&nbsp;<?php echo $point; echo Yii::t('Public', '分')?>
                    </p>
					<a class="btnEntBusi" title="" href="<?php echo Yii::app()->controller->createAbsoluteUrl('/shop/view',array('id'=>$storeData['id']));?>"><?php echo Yii::t('Public', '进入店铺')?></a>
				</div>
			</div>
			<div class="otherCoupons">
				<h3 class="icon_v_h title"><?php echo Yii::t('Public', '商家其他盖惠券')?></h3>
				<div class="content">
					<?php foreach ($otherCouponData as $key=>$val) {?>
					<div class="icon_v_h items items01">
						<div class="fullUse">
							<p><span class="unit">￥</span><span class="num"><?php echo (int)$val['price']?></span><?php echo Yii::t('Public', '盖惠券')?></p>
							<a class="btnUseCond" title="" href="#"><?php echo Yii::t('Public', '满').(int)$val['condition'].Yii::t('Public', '立减')?></a>
						</div>
					</div>
					<?php }?>
				</div>
			</div>
			<div class="adbox">
                <?php if(!empty($ads)){?>
				<a href="<?php echo $ads['link'];?>" title="<?php echo $ads['title'];?>">
                    <img width="290" height="120 alt="<?php echo $ads['title'];?>" src="<?php echo ATTR_DOMAIN.'/'.$ads['imgurl'];?>">
                </a>
                <?php }?>
			</div>
		</div>
	</div>
</div>
