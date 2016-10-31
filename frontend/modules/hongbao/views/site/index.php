<?php if(!empty($ads['top'])):?>
<div class="redEnvBanner">
	<div class="flexslider03">
		<ul class="slides">
			<?php 
				foreach ($ads['top'] as $key=>$val) {
			?>
			<li><a href="<?php echo $val['link']?>" title=""><img src="<?php echo ATTR_DOMAIN.'/'.$val['imgurl']?>" alt="" width="1190" height="350"/></a></li>
			<?php }?>
		</ul>
	</div>
</div>
<?php endif;?>
<style type="text/css">
	.colockimg{display:block;position:relative;}
	/* colockbox */
	.bg01{overflow:hidden;}
	.colockbox{width:220px;height:76px;padding-top:29px;position:absolute;right:0px;top:132px;z-index:5;background:url(../images/bgs/updateTipbg.png) no-repeat;}
	.colockbox span{float:left;font-family:Arial, Helvetica, sans-serif;display:inline-block;width:50px;height:76px;line-height:76px;font-size:40px;text-align:center;color:#fff04d;}		
	.day{margin-left:15px;} 
	.hour{margin-left:16px;}
	.minute{margin-left:18px;}
	.second{margin-left:16px;}
	.m2{background:url(../images/bgs/updateTipbg02.png) no-repeat;}
	.m2 span{color:#ff7417}
</style>
<div class="main w1200">
	<!--精选商家优惠券-->
	<div class="recomCoupons">
<!--		<div class="title clearfix">-->
<!--			<h3 class="icon_v">--><?php //echo Yii::t('Public','精选商家优惠券')?><!--</h3>-->
<!--			<div class="do">-->
<!--                <input id="listPage" type="hidden" value="0" />-->
<!--				<a href="javascript:refreshList();" title="--><?php //echo Yii::t('Public','换一批')?><!--" class="icon_v refresh">--><?php //echo Yii::t('Public','换一批')?><!--</a>-->
<!--				<a href="#" title="--><?php //echo Yii::t('Public','更多')?><!--" class="icon_v more">--><?php //echo Yii::t('Public','更多')?><!--</a>-->
<!--			</div>-->
<!--		</div>-->
<!--		<ul id="redList" class="content clearfix">-->
<!--			--><?php
//				if(!empty($coupons)):
//				//输出默认的精选商家盖惠券
//				foreach ($coupons as $key=>$val) :
//					$last = $key == 3 ? ' last' : ''; 	//css样式
//			?>
<!--				<li class="icon_v_h clearfix--><?php //echo $last?><!--">-->
<!--					<a href="--><?php //echo Yii::app()->controller->createUrl('detail',array('id'=>$val['id'],'type'=>$val['category_id']))?><!--" class="img">-->
<!--						<img src="--><?php //echo IMG_DOMAIN.'/'.$val['thumbnail']?><!--" width="165" height="135" alt=""/>-->
<!--						<span class="name">--><?php //echo $val['name']?><!--</span>-->
<!--					</a>-->
<!--					<div class="txt">-->
<!--						<p class="price">￥<i>--><?php //echo (int)$val['price']?><!--</i></p>-->
<!--						<p class="condi">--><?php //echo Yii::t('sellerCouponactivity','满').(int)$val['condition'].Yii::t('sellerCouponactivity','使用')?><!--</p>-->
<!--						<a href="javascript:alert('JS效果')" title="" class="icon_v_h btnCharge">--><?php //echo Yii::t('sellerCouponactivity','免费领取')?><!--</a>-->
<!--						<p class="period">--><?php //echo date('m/d', $val['valid_start']) . ' - ' . date('m/d', $val['valid_end'])?><!--</p>-->
<!--					</div>-->
<!--				</li>-->
<!--			--><?php
//				endforeach;
//			endif;
//			?>
<!--		</ul>-->
	</div>
	<div class="clearfix">
		<div class="main_leftContent">
			<div class="redEnvType">
				<div class="items no01 clearfix">
					<div class="icon_v_h txt">
						<h3><?php echo Yii::t('Public','注册送红包')?></h3>
						<p class="det"><?php echo Yii::t('Public','盖网欢迎您！您来就送大红包！')?></p>
						<a href="<?php echo $this->createAbsoluteUrl('register') ?>" title="" class="icon_v more"><?php echo Yii::t('Public','查看详情')?></a>
					</div>
					<a href="<?php echo Yii::app()->createAbsoluteUrl('hongbao/site/registerCoupon'); ?>" title="" class="colockimg img"><img  src="../images/bgs/redEnv710X260_01.jpg" width="710" height="260" alt="<?php echo Yii::t('Public','注册送红包')?>"/>
						<div class="colockbox m2" id="demo01">
							<!-- <span class="day">-</span> -->
							<span class="hour">-</span>
							<span class="minute">-</span>
							<span class="second">-</span>
						</div>
					</a>
				</div>
<!--				<div class="items no02 clearfix">-->
<!--					<div class="icon_v_h txt">-->
<!--						<h3>--><?php //echo Yii::t('Public','免费派券')?><!--</h3>-->
<!--						<p class="det">--><?php //echo Yii::t('Public','优惠不停，购物由你！')?><!--</p>-->
<!--						<a href="--><?php //echo Yii::app()->controller->createUrl('list')?><!--" title="" class="icon_v more">--><?php //echo Yii::t('Public','查看详情')?><!--</a>-->
<!--					</div>-->
<!--					<a href="--><?php //echo Yii::app()->controller->createUrl('list')?><!--" title="" class="img"><img  src="../images/bgs/redEnv710X260_02.jpg" width="710" height="260" alt="--><?php //echo Yii::t('Public','购物红包')?><!--"/></a>-->
<!--				</div>-->
				<div class="items no03 clearfix">
					<div class="icon_v_h txt">
						<h3><?php echo Yii::t('Public','分享奖红包')?></h3>
						<p class="det"><?php echo Yii::t('Public','马克思说，劳动创造价值。<br/>小郑说，分享也是一种劳动。')?></p>
						<a href="<?php echo Yii::app()->controller->createUrl('share')?>" title="" class="icon_v more"><?php echo Yii::t('Public','查看详情')?></a>
					</div>
					<a href="<?php echo Yii::app()->controller->createUrl('share')?>" title="" class="colockimg img"><img  src="../images/bgs/redEnv710X260_03.jpg" width="710" height="260" alt="<?php echo Yii::t('Public','分享奖红包')?>"/>
						<div class="colockbox" id="demo02">
							<!-- <span class="day">-</span> -->
							<span class="hour">-</span>
							<span class="minute">-</span>
							<span class="second">-</span>
						</div>
					</a>
				</div>
			</div>
		</div>
		<div class="main_right">
			<div class="proArrange05">
				<h3 class="icon_v_h title">推荐商品</h3>
				<ul class="content">
					<?php
						foreach ($recommands as $key=>$val) {
					?>
					<li>
						<a href="<?php echo Yii::app()->createAbsoluteUrl('goods/view',array('id'=>$val['id'])) ?>" target="_blank" title="" class="img"><img src="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $val['thumbnail'], 'c_fill,w_200,h_200') ?>" alt="" width="200" height="200"/></a>
						<a href="<?php echo Yii::app()->createAbsoluteUrl('goods/view',array('id'=>$val['id'])) ?>" target="_blank" class="name" title=""><?php echo $val['stroe_name']?></a>
						<p class="price"><?php echo Yii::t('Public','价格')?>：<span class="num"><?php echo $val['price']?></span></p>
					</li>
					<?php }?>
				</ul>
			</div>
			<div class="adbox redEnvAd">
                <?php if(!empty($ads['right'])){?>
				<a title="<?php echo $ads['right']['title'];?>" href="<?php echo $ads['right']['link'];?>">
                    <img width="225" height="145" src="<?php echo ATTR_DOMAIN.'/'.$ads['right']['imgurl'];?>" alt="<?php echo $ads['right']['title'];?>">
                </a>
                <?php }?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" language="javascript">
    function refreshList(){
        var nowPage = $('#listPage').val();
        nowPage++;
        $.ajax({
            cache:false,
            dataType: 'json',
            url:'<?php echo $this->createUrl('/hongbao/site/ajaxGetCoupons') . "?page='+nowPage+'&YII_CSRF_TOKEN=" . Yii::app()->request->csrfToken ;?>',
            success:function(res){
                $('#listPage').val(res.page);
                var html = '已经是最后一页';
                if(res.data){
                    html = '';
                    var last = '';
                    $.each(res.data, function(i, v){
                        if(i == 'k'+(res.pageSize-1)){last = ' last';}
                        html += '<li class="icon_v_h clearfix'+ last +'">'
                            + '<a href="<?php echo Yii::app()->controller->createUrl("detail");?>?id='+ v.id +'&type='+ v.category_id +'" class="img">'
                            + '<img src="<?php echo ATTR_DOMAIN;?>/'+ v.thumbnail +'" width="165" height="135" alt="" />'
                            + '<span class="name">'+ v.name+'</span></a>'
                            + '<div class="txt"><p class="price">￥<i>'+ v.price+'</i></p>'
                            + '<p class="condi"><?php echo Yii::t("sellerCouponactivity","满");?>'+ v.condition +'<?php echo Yii::t("sellerCouponactivity","使用");?></p>'
                            + '<a href="javascript:alert(\'JS效果\')" title="" class="icon_v_h btnCharge"><?php echo Yii::t("sellerCouponactivity","免费领取")?></a>'
                            + '<p class="period">'+ v.valid_start + ' - ' + v.valid_end +'</p>'
                            + '</div></li>';
                    });
                }
                $('#redList').empty();
                $('#redList').html(html);
            }
        });
    }
</script>
<script type="text/javascript" src="http://www.g-emall.com/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
	$(function(){
		countDown("2015/1/26 21:13:14","#demo01 .day","#demo01 .hour","#demo01 .minute","#demo01 .second");
		countDown("2015/1/26 21:13:14","#demo02 .day","#demo02 .hour","#demo02 .minute","#demo02 .second");
	});
	
	function countDown(time,day_elem,hour_elem,minute_elem,second_elem){
		//if(typeof end_time == "string")
		var end_time = new Date(time).getTime(),//月份是实际月份-1
		//current_time = new Date().getTime(),
		sys_second = (end_time-new Date().getTime())/1000;
		var timer = setInterval(function(){
			if (sys_second > 0) {
				sys_second -= 1;
				var day = Math.floor((sys_second / 3600) / 24);
				var hour = Math.floor((sys_second / 3600) % 24);
				var minute = Math.floor((sys_second / 60) % 60);
				var second = Math.floor(sys_second % 60);
				day_elem && $(day_elem).text(day);//计算天
				$(hour_elem).text(hour<10?"0"+hour:hour);//计算小时
				$(minute_elem).text(minute<10?"0"+minute:minute);//计算分
				$(second_elem).text(second<10?"0"+second:second);// 计算秒
			} else { 
				clearInterval(timer);
			}
		}, 1000);
	}
</script>


