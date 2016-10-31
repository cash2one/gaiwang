	<div class="positionWrap pt10">
		<div class="position">
			<a href="<?php echo DOMAIN?>"><?php echo Yii::t('Public', '盖象商城')?></a>&nbsp;&gt;&nbsp;
			<a href="<?php echo Yii::app()->controller->createUrl('index')?>"><?php echo Yii::t('Public', '盖网红包')?></a>&nbsp;&gt;&nbsp;
			<a href="<?php echo Yii::app()->controller->createUrl('list')?>"><?php echo Yii::t('Public', '购物红包')?></a>&nbsp;&gt;&nbsp;
			<b><?php echo CouponActivity::getCouponType($type)?></b>
		</div>
	</div>
	<div class="redEnvListBanner">
		<img src="<?php echo $bgPic?>" />
	</div>
    <div class="main redEnvSubMain">
    	<!--楼层-->
		<div class="w1200">
			<div class="reColumn">
				<ul class="content clearfix">
					<?php 
						foreach ($datas as $key=>$val) {
							$class = $key%5 == 4 ? ' class="last"' : '';
					?>
					<li<?php echo $class?>>
						<i class="icon_v"></i>
						<a href="<?php echo Yii::app()->controller->createUrl('detail',array('id'=>$val['id'],'type'=>$val['category_id']))?>" class="img">
							<img src="<?php echo IMG_DOMAIN.'/'.$val['thumbnail']?>" width="225" height="225" alt=""/>
							<span class="name"><?php echo $val['name']?></span>
						</a>
						<div class="clearfix">
						<div class="txt">
							<p class="price">￥<i><?php echo (int)$val['price']?></i></p>
							<p class="condi"><?php echo Yii::t('Public', '购满') . (int)$val['condition'] . Yii::t('Public', '使用')?></p>
						</div>
						<div class="do">
							<a href="javascript:alert('JS效果')" class="icon_v_h btnReceive"><?php echo Yii::t('Public', '立即领取')?></a>
							<p class="period"><?php echo date('m/d', $val['valid_start']) . ' - ' . date('m/d', $val['valid_end'])?></p>
							</div>
						</div>
					</li>
					<?php }?>
				</ul>
				<div class="pageList clearfix">
					<?php 
					  $this->widget('CLinkPager',array(   //此处Yii内置的是CLinkPager，我继承了CLinkPager并重写了相关方法
						    'header'=>'',
					  		'firstPageLabel' => Yii::t('page', '首页'),
						    'prevPageLabel' => Yii::t('page', '上一页'),
						    'nextPageLabel' => Yii::t('page', '下一页'),
						    'lastPageLabel' => Yii::t('page', '末页'),
						    'pages' => $pages,       
						    'maxButtonCount'=>10,    //分页数目
						    'htmlOptions'=>array(
						       'class'=>'yiiPageer',   //包含分页链接的div的class
						     )
						  )
					  );
					?>
				</div>
			</div>
			<div class="redEnvTips">
				<h3><?php echo Yii::t('Public', '红包说明')?></h3>
				<div class="content">
					<p>1、<?php echo Yii::t('Public', '每天领取的盖惠券有数量有限，先到先得；已领取的盖惠券，需使用后才能再次领取')?>；</p>
					<p>2、<?php echo Yii::t('Public', '盖惠券购满指定金额的商品结算时使用，每次只能使用1张盖惠券，也不可与其他优惠叠加使用')?>。<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo Yii::t('Public', '部分特价商品不可以使用该券；盖惠券需在有效日期内使用')?>；</p>
					<p>3、<?php echo Yii::t('Public', '盖惠券最终解释权归商家所有，如有任何疑问请进入相关店铺咨询客服')?>。</p>
				</div>
			</div>
		</div>
	</div>
	