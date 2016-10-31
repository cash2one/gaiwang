<script type="text/javascript">
	$(function(){
		/*右侧悬浮菜单*/
		$('#redEnvNav').onePageNav();
		
		$(window).bind('scroll resize',function(){
			if($(window).scrollTop()>900){
				$(".redEnvNavWrap").show();
			}else{
				$(".redEnvNavWrap").hide();
			}
		})
	})
</script>

<div class="positionWrap pt10">
	<div class="position">
		<a href="<?php echo DOMAIN?>"><?php echo Yii::t('Public', '盖象商城')?></a>&nbsp;&gt;&nbsp;
		<a href="<?php echo Yii::app()->controller->createUrl('index')?>"><?php echo Yii::t('Public', '盖网红包')?></a>&nbsp;&gt;&nbsp;
		<b><?php echo Yii::t('Public', '购物红包')?></b>
	</div>
</div>
<div class="redEnvListBanner">
	<div class="bg01" style="background-image:url(../images/bgs/redEnv1920X535.jpg)"></div>
	<div class="bg02">
		<div class="aCon">
			<a href="#reNo1" title="" class="no1"><?php echo Yii::t('Public', '家用电器')?></a>
			<a href="#reNo2" title="" class="no2"><?php echo Yii::t('Public', '服饰鞋帽')?></a>
			<a href="#reNo3" title="" class="no3"><?php echo Yii::t('Public', '个护化妆')?></a>
			<a href="#reNo4" title="" class="no4"><?php echo Yii::t('Public', '手机数码')?></a>
			<a href="#reNo5" title="" class="no5"><?php echo Yii::t('Public', '电脑办公')?></a>
			<a href="#reNo6" title="" class="no6"><?php echo Yii::t('Public', '运动健康')?></a>
			<a href="#reNo7" title="" class="no7"><?php echo Yii::t('Public', '家居家装')?></a>
			<a href="#reNo8" title="" class="no8"><?php echo Yii::t('Public', '饮料食品')?></a>
			<a href="#reNo9" title="" class="no9"><?php echo Yii::t('Public', '礼品箱包')?></a>
			<a href="#reNo10" title="" class="no10"><?php echo Yii::t('Public', '珠宝首饰')?></a>
			<a href="#reNo11" title="" class="no11"><?php echo Yii::t('Public', '汽车用品')?></a>
			<a href="#reNo12" title="" class="no12"><?php echo Yii::t('Public', '母婴用品')?></a>
			</div>
		</div>
	</div>
    <div class="main redEnvMain">
    	<!--楼层-->
	<div class="w1200">
		<div class="reColumn reColumn1" id="reNo1">
			<div class="title clearfix">
				<h3 class="icon_v">1F <?php echo Yii::t('Public', '家用电器')?></h3>
				<a href="<?php echo Yii::app()->controller->createUrl('listSub',array('type'=>1))?>" title="<?php echo Yii::t('Public', '更多推荐')?>" class="icon_v more"><?php echo Yii::t('Public', '更多推荐')?></a>
			</div>
			<ul class="content clearfix">
				<?php 
					foreach ($reNo1 as $key=>$val) {
						$class = $key == 4 ? ' class="last"' : '';
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
				<?php 
					}
				?>
			</ul>
		</div>
		<div class="reColumn reColumn2" id="reNo2">
			<div class="title clearfix">
				<h3 class="icon_v">2F <?php echo Yii::t('Public','服饰鞋帽')?></h3>
				<a href="<?php echo Yii::app()->controller->createUrl('listSub',array('type'=>2))?>" title="<?php echo Yii::t('Public', '更多推荐')?>" class="icon_v more"><?php echo Yii::t('Public', '更多推荐')?></a>
			</div>
			<ul class="content clearfix">
				<?php 
					foreach ($reNo2 as $key=>$val) {
						$class = $key == 4 ? ' class="last"' : '';
				?>
					<li<?php echo $class?>>
						<i class="<?php echo $class?>"></i>
						<a href="javascript:;" class="img">
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
				<?php 
					}
				?>
			</ul>
		</div>
		<div class="reColumn reColumn3" id="reNo3">
			<div class="title clearfix">
				<h3 class="icon_v">3F <?php echo Yii::t('Public','个护化妆')?></h3>
				<a href="<?php echo Yii::app()->controller->createUrl('listSub',array('type'=>3))?>" title="<?php echo Yii::t('Public', '更多推荐')?>" class="icon_v more"><?php echo Yii::t('Public', '更多推荐')?></a>
			</div>
			<ul class="content clearfix">
				<?php 
					foreach ($reNo3 as $key=>$val) {
						$class = $key == 4 ? ' class="last"' : '';
				?>
					<li<?php echo $class?>>
						<i class="<?php echo $class?>"></i>
						<a href="javascript:;" class="img">
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
				<?php 
					}
				?>
			</ul>
		</div>
		<div class="reColumn reColumn4" id="reNo4">
			<div class="title clearfix">
				<h3 class="icon_v">4F <?php echo Yii::t('Public','手机数码')?></h3>
				<a href="<?php echo Yii::app()->controller->createUrl('listSub',array('type'=>4))?>" title="<?php echo Yii::t('Public', '更多推荐')?>" class="icon_v more"><?php echo Yii::t('Public', '更多推荐')?></a>
			</div>
			<ul class="content clearfix">
				<?php 
					foreach ($reNo4 as $key=>$val) {
						$class = $key == 4 ? ' class="last"' : '';
				?>
					<li<?php echo $class?>>
						<i class="<?php echo $class?>"></i>
						<a href="javascript:;" class="img">
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
				<?php 
					}
				?>
			</ul>
		</div>
		<div class="reColumn reColumn5" id="reNo5">
			<div class="title clearfix">
				<h3 class="icon_v">5F <?php echo Yii::t('Public','电脑办公')?></h3>
				<a href="<?php echo Yii::app()->controller->createUrl('listSub',array('type'=>5))?>" title="<?php echo Yii::t('Public', '更多推荐')?>" class="icon_v more"><?php echo Yii::t('Public', '更多推荐')?></a>
			</div>
			<ul class="content clearfix">
				<?php 
					foreach ($reNo5 as $key=>$val) {
						$class = $key == 4 ? ' class="last"' : '';
				?>
					<li<?php echo $class?>>
						<i class="<?php echo $class?>"></i>
						<a href="javascript:;" class="img">
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
				<?php 
					}
				?>
			</ul>
		</div>
		<div class="reColumn reColumn6" id="reNo6">
			<div class="title clearfix">
				<h3 class="icon_v">6F <?php echo Yii::t('Public','运动健康')?></h3>
				<a href="<?php echo Yii::app()->controller->createUrl('listSub',array('type'=>6))?>" title="<?php echo Yii::t('Public', '更多推荐')?>" class="icon_v more"><?php echo Yii::t('Public', '更多推荐')?></a>
			</div>
			<ul class="content clearfix">
				<?php 
					foreach ($reNo6 as $key=>$val) {
						$class = $key == 4 ? ' class="last"' : '';
				?>
					<li<?php echo $class?>>
						<i class="<?php echo $class?>"></i>
						<a href="javascript:;" class="img">
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
				<?php 
					}
				?>
			</ul>
		</div>
		<div class="reColumn reColumn7" id="reNo7">
			<div class="title clearfix">
				<h3 class="icon_v">7F <?php echo Yii::t('Public','家居家装')?></h3>
				<a href="<?php echo Yii::app()->controller->createUrl('listSub',array('type'=>7))?>" title="<?php echo Yii::t('Public', '更多推荐')?>" class="icon_v more"><?php echo Yii::t('Public', '更多推荐')?></a>
			</div>
			<ul class="content clearfix">
				<?php 
					foreach ($reNo7 as $key=>$val) {
						$class = $key == 4 ? ' class="last"' : '';
				?>
					<li<?php echo $class?>>
						<i class="<?php echo $class?>"></i>
						<a href="javascript:;" class="img">
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
				<?php 
					}
				?>
			</ul>
		</div>
		<div class="reColumn reColumn8" id="reNo8">
			<div class="title clearfix">
				<h3 class="icon_v">8F <?php echo Yii::t('Public','饮料食品')?></h3>
				<a href="<?php echo Yii::app()->controller->createUrl('listSub',array('type'=>8))?>" title="<?php echo Yii::t('Public', '更多推荐')?>" class="icon_v more"><?php echo Yii::t('Public', '更多推荐')?></a>
			</div>
			<ul class="content clearfix">
				<?php 
					foreach ($reNo8 as $key=>$val) {
						$class = $key == 4 ? ' class="last"' : '';
				?>
					<li<?php echo $class?>>
						<i class="<?php echo $class?>"></i>
						<a href="javascript:;" class="img">
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
				<?php 
					}
				?>
			</ul>
		</div>
		<div class="reColumn reColumn9" id="reNo9">
			<div class="title clearfix">
				<h3 class="icon_v">9F <?php echo Yii::t('Public','礼品箱包')?></h3>
				<a href="<?php echo Yii::app()->controller->createUrl('listSub',array('type'=>9))?>" title="<?php echo Yii::t('Public', '更多推荐')?>" class="icon_v more"><?php echo Yii::t('Public', '更多推荐')?></a>
			</div>
			<ul class="content clearfix">
				<?php 
					foreach ($reNo9 as $key=>$val) {
						$class = $key == 4 ? ' class="last"' : '';
				?>
					<li<?php echo $class?>>
						<i class="<?php echo $class?>"></i>
						<a href="javascript:;" class="img">
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
				<?php 
					}
				?>
			</ul>
		</div>
		<div class="reColumn reColumn10" id="reNo10">
			<div class="title clearfix">
				<h3 class="icon_v">10F <?php echo Yii::t('Public','珠宝首饰')?></h3>
				<a href="<?php echo Yii::app()->controller->createUrl('listSub',array('type'=>10))?>" title="<?php echo Yii::t('Public', '更多推荐')?>" class="icon_v more"><?php echo Yii::t('Public', '更多推荐')?></a>
			</div>
			<ul class="content clearfix">
				<?php 
					foreach ($reNo10 as $key=>$val) {
						$class = $key == 4 ? ' class="last"' : '';
				?>
					<li<?php echo $class?>>
						<i class="<?php echo $class?>"></i>
						<a href="javascript:;" class="img">
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
				<?php 
					}
				?>
			</ul>
		</div>
		<div class="reColumn reColumn11" id="reNo11">
			<div class="title clearfix">
				<h3 class="icon_v">11F <?php echo Yii::t('Public','汽车用品')?></h3>
				<a href="<?php echo Yii::app()->controller->createUrl('listSub',array('type'=>11))?>" title="<?php echo Yii::t('Public', '更多推荐')?>" class="icon_v more"><?php echo Yii::t('Public', '更多推荐')?></a>
			</div>
			<ul class="content clearfix">
				<?php 
					foreach ($reNo11 as $key=>$val) {
						$class = $key == 4 ? ' class="last"' : '';
				?>
					<li<?php echo $class?>>
						<i class="<?php echo $class?>"></i>
						<a href="javascript:;" class="img">
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
				<?php 
					}
				?>
			</ul>
		</div>
		<div class="reColumn reColumn12" id="reNo12">
			<div class="title clearfix">
				<h3 class="icon_v">12F <?php echo Yii::t('Public','母婴用品')?></h3>
				<a href="<?php echo Yii::app()->controller->createUrl('listSub',array('type'=>12))?>" title="<?php echo Yii::t('Public', '更多推荐')?>" class="icon_v more"><?php echo Yii::t('Public', '更多推荐')?></a>
			</div>
			<ul class="content clearfix">
				<?php 
					foreach ($reNo12 as $key=>$val) {
						$class = $key == 4 ? ' class="last"' : '';
				?>
					<li<?php echo $class?>>
						<i class="<?php echo $class?>"></i>
						<a href="javascript:;" class="img">
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
				<?php 
					}
				?>
			</ul>
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
		
<div class="redEnvNavWrap">
	<ul id="redEnvNav" class="redEnvNav">
		<li class="current"><a href="#reNo1" class="no1" title="<?php echo Yii::t('Public', '家用电器')?>"><?php echo Yii::t('Public', '家用电器')?></a></li>
		<li><a href="#reNo2" class="no2" title="<?php echo Yii::t('Public', '服饰鞋帽')?>"><?php echo Yii::t('Public', '服饰鞋帽')?></a></li>
		<li><a href="#reNo3" class="no3" title="<?php echo Yii::t('Public', '个护化妆')?>"><?php echo Yii::t('Public', '个护化妆')?></a></li>
		<li><a href="#reNo4" class="no4" title="<?php echo Yii::t('Public', '手机数码')?>"><?php echo Yii::t('Public', '手机数码')?></a></li>
		<li><a href="#reNo5" class="no5" title="<?php echo Yii::t('Public', '电脑办公')?>"><?php echo Yii::t('Public', '电脑办公')?></a></li>
		<li><a href="#reNo6" class="no6" title="<?php echo Yii::t('Public', '运动健康')?>"><?php echo Yii::t('Public', '运动健康')?></a></li>
		<li><a href="#reNo7" class="no7" title="<?php echo Yii::t('Public', '家居家装')?>"><?php echo Yii::t('Public', '家居家装')?></a></li>
		<li><a href="#reNo8" class="no8" title="<?php echo Yii::t('Public', '饮料食品')?>"><?php echo Yii::t('Public', '饮料食品')?></a></li>
		<li><a href="#reNo9" class="no9" title="<?php echo Yii::t('Public', '礼品箱包')?>"><?php echo Yii::t('Public', '礼品箱包')?></a></li>
		<li><a href="#reNo10" class="no10" title="<?php echo Yii::t('Public', '珠宝首饰')?>"><?php echo Yii::t('Public', '珠宝首饰')?></a></li>
		<li><a href="#reNo11" class="no11" title="<?php echo Yii::t('Public', '汽车用品')?>"><?php echo Yii::t('Public', '汽车用品')?></a></li>
		<li><a href="#reNo12" class="no12" title="<?php echo Yii::t('Public', '母婴用品')?>"><?php echo Yii::t('Public', '母婴用品')?></a></li>
	</ul>
	<a href="javascript:;" id="backTop" class="goTop" title="<?php echo Yii::t('Public', '回到顶部')?>"><?php echo Yii::t('Public', '回到顶部')?></a>
</div>