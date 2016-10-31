<?php
$count = count($adverts);
$count = $count<1 ? 1 : ($count>4 ? 4 : $count);

$tx    = 0;
$times = array();//活动时间数组,用于处理计时
//print_r($seckill);
?>
<style>
    .grabEnd {
        background: rgba(0, 0, 0, 0) url("../images/bgs/spike02.png") no-repeat scroll 0 0;
        height: 380px;
        position: absolute;
        width: 380px;
        z-index: 2;
    }
</style>
	<!-- 秒杀活动主体 -->
	<div class="main">
		<!-- 秒杀活动大广告图 -->
                        <?php $search = $this->getParam('search');if(empty($search)):?>
		<div class="spikeBanner">
			<div class="flexslider01">
                <ul class="slides">
                <?php if($adverts && is_array($adverts)){
					$ai = 1;
			        foreach($adverts as $v){
						if($ai>4) break;
						if (AdvertPicture::isValid($v['start_time'], $v['end_time'])){
				?>
                    <li style="background:<?php echo $v['background'] ?>;" title="<?php echo $v['title'];?>"><a href="<?php echo $v['link'] ? $v['link'] : 'javascript:void(0);'; ?>" target="<?php echo $v['target'];?>"><span ><img src="<?php echo ATTR_DOMAIN . '/' . $v['picture'] ?>" width="600" height="440"></span></a></li>
                <?php $ai++;} } }else{?>
                    <li style="background:url(../images/bgs/spike01.jpg) center top no-repeat;"><a href="javascript:void(0);">&nbsp;</a></li>
                    <?php }?>
                </ul>
                <ul class="hd">
                <?php for($i=1; $i<=$count; $i++){?>
                    <li></li>
                <?php }?>
                </ul>
			</div>
		</div>
		<!-- 秒杀活动大广告图结束 -->
		
		<div class="advertbg">
            <a href="<?php echo str_replace('.html', '', $this->createAbsoluteUrl('seckill/index'));?>" id="seckilljump" style="display:none;" target="_blank"> </a>
			
            <?php if(empty($seckill) || $nowTime > strtotime($seckill['end_dateline'])){?>
            <?php } else { ?>
            <div class="<?php if(empty($seckill)){echo 'adverta';}else{ echo 'adverta';}?>">
                <?php
                    if( ($seckill['status']==2 || $seckill['status']==3) && $nowTime < strtotime($seckill['start_dateline']) ){
                            $tx = strtotime($seckill['start_dateline'])-$nowTime;
                            if($tx>0){$times['seckill_0'] = $tx;} 
		?>  
                <div class="started" onclick="javascript:document.getElementById('seckilljump').click();">
                    <p class="title"><font id="seckill_0"><?php echo SiteController::dealTimes($tx); ?></font> 后</p>
                    <p class="time">即将开始</p>
                    <p class="message">敬请期待</p>
                </div>
                <?php } else { 
                    $tx = strtotime($seckill['end_dateline'])-$nowTime;
                    if($tx>0){$times['seckill_0'] = $tx;}
		?>  
                <p class="t1">
                    <span class="txtl">疯狂抢购</span>
                    <span class="txtr">仅剩 <font id="seckill_0"><?php echo SiteController::dealTimes($tx); ?></font></span>
                </p>
                <p class="t2" style="width:300px; height:320px;">
                        <a href="<?php echo $seckill['link'] ? $seckill['link'] : str_replace('.html', '', $this->createAbsoluteUrl('seckill/index'));?>" target="_blank"><span></span><img class="lazy" width="300" height="320" alt="疯狂抢购" data-url="<?php echo ATTR_DOMAIN . '/' .$seckill['picture'];?>" /></a>
                </p>
                <p class="t3">
                    <?php echo $seckill['name'];?>
                </p>
		<?php } ?>
            </div>
            <?php } ?>
          
            
			<div class="advertb">
                <?php if($grab[0]['totalNumber']<1){?>
                <div class="started">
                    <p class="title">今日必抢活动</p>
                    <p class="time">即将开始</p>
                    <p class="message">敬请期待</p>
                </div>
                <?php }else{ 
				    $key     = $grab[0]['nowNumber'];
					$price   = $grab[$key]['product_price'];
					$tx      = strtotime($grab[0]['dateline']) + 86400 - $nowTime;
					$rulesId = $grab[$key]['rules_id'];
					
					if($tx>0){$times['grab_0'] = $tx;}
				    if($rulesId>0 && $grab[$key]['status']==1){//若参加活动,则显示活动价格
						//$active = ActivityData::getActivityRulesSeting($grab[$key]['rules_id']);
						if( !empty($active[$rulesId]) && ($nowTime >= strtotime($active[$rulesId]['start_dateline']) && $nowTime <= strtotime($active[$rulesId]['end_dateline'])) ){
						    $price = $active[$rulesId]['discount_rate']>0 ? number_format($active[$rulesId]['discount_rate']*$price/100, 2,'.','') : number_format($active[$rulesId]['discount_price'], 2,'.','');
							
						}
					}
				?>
				<p class="t1">
					<span class="txtl">今日必抢</span>
					<span class="txtr">仅剩 <font id="grab_0"><?php echo SiteController::dealTimes($tx);?></font></span>
				</p>
				<p class="t2" style="width:300px; height:320px;">
					<a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $grab[$key]['product_id']));?>" target="_blank"><span></span><img class="lazy" width="300" height="320" alt="今日必抢" data-url="<?php echo IMG_DOMAIN . '/' .$grab[$key]['thumbnail'];?>" /></a>
				</p>
				<p class="t3" title="<?php echo $grab[$key]['product_name'];?>">
					<?php echo $grab[$key]['product_name'];?>
				</p>
				<p class="t4">
					<span class="txtl">￥<?php echo $price;?></span>
					<span class="txtr"></span>
				</p>
            <?php }?>    
			</div>
            
		</div>
		<div class="clear"></div>
                <div class="seckillDeclare2">
                    <img src="<?php echo Yii::app()->theme->baseUrl?>/images/bgs/seckillDeclare2.jpg"/>
		</div>
                <?php endif;?>
        <div class="spikeProducts">
            <?php if(empty($search)):?>
			<div class="spikeprca">
				<p class="title clearfix">
					<span class="txtl">热门活动</span>
					<span class="txtr">火爆开售</span>
					<?php if(!empty($activity) || $activity!=false){?><a href="<?php echo str_replace('.html', '', $this->createAbsoluteUrl('festive/index'));?>" target="_blank">更多</a><?php }?>
				</p>
                <?php if($activity && !empty($activity)){?>
				<ul class="clearfix">
				<?php
                    $ti = 1;   
					foreach($activity as $k=>$v){
						if($ti>3) break;
						$id = 'seting_'.$v['id'];
						
						if($v['status']==2){
					        $tx = strtotime($v['start_dateline']) - $nowTime;
						}else if($v['status']==3){
							$tx = strtotime($v['end_dateline']) - $nowTime;
						}else{
							$tx = 0;
						}
						if($tx > 0){ $times[$id] = $tx; }
						
						$ti++;
						$url = $this->createAbsoluteUrl('festive/detail/'.$v['id']);
						if( isset($v['category_id']) && $v['category_id'] == ActivityData::ACTIVE_AUCTION){
							$url = $this->createAbsoluteUrl('auction/index/'.$v['id']);
						}
						$link = $v['link'] ? 'http://'.str_replace('http://', '', $v['link']) : ($v['category_id']==ActivityData::ACTIVE_SECKILL ? str_replace('.html', '', $this->createAbsoluteUrl('seckill/index')) : str_replace('.html', '', $url) );
				?>
					<li><?php if($tx==0 || strtotime($v['end_dateline']) < $nowTime){ echo '<p class="grabEnd grabEnd2"></p>';}?>
						<a class="itemImg" href="<?php echo $link;?>"  target="_blank"><img class="lazy" width="380" height="285" alt="<?php echo $v['name']?>" data-url="<?php echo ATTR_DOMAIN . '/' .$v['picture'];?>" /></a>
						<p class="name clearfix">
							<span class="txtl"><?php echo $v['name']?></span>
							<span class="txtr"><?php echo $v['remark'];?></span>
						</p>
						<p class="time" id="<?php echo $id;?>"><?php if($v['status']==2 || $v['status']==3){ echo SiteController::dealTimes($tx);}else{ echo '0天0时0分0秒';}?></p>
					</li>
				<?php }?>
                </ul>
                <?php }else{?>
                    <div class="no_product" id="no_activity">目前没有任何活动</div>
                <?php }?>	
		        
            </div>
	<?php endif;?>		
			<div class="spikeprcb">
				<div class="title clearfix" id="product_show">
					<span class="txtl">活动商品</span>
					<p class="txtr txtr2">
                                            <a href="<?php echo $this->createAbsoluteUrl('site/index',array('category_id'=>0))?>" class="<?php if($this->getParam('category_id') == 0) { echo 'on';}?>" id="0">全部</a>
                    <?php foreach($productCategory as $kp=>$vp){?>
                        <a href="<?php echo $this->createAbsoluteUrl('site/index',array('category_id'=>$vp['id']))?>" id="<?php echo $vp['id'];?>"  class="<?php if($this->getParam('category_id') == $vp['id']) { echo 'on';}?>"><?php echo $vp['name'];?></a>
                    <?php }?>
					</p>
				</div>

                <ul class="clearfix" id="product" style="display:block;">
                <?php 
                    $product = isset($productRelation['product']) ? $productRelation['product'] : array();
                    $pagination = isset($productRelation['page']) ? $productRelation['page'] : '';
                    if(!empty($product) && is_array($product)){
				
				if(!empty($product)){
				    foreach($product as $k=>$v){
						if($k > ($pageSize-1)) break;
                        
						$price    = $v['price'];
						$setingId = $v['rules_seting_id'];
						$id       = 'product_0_'.$v['product_id'];
						
						$string   = '0天0时0分0秒';
						if(!empty($rules) && isset($rules[$setingId]) && is_array($rules[$setingId]) && !empty($rules[$setingId])){
							if( $nowTime > strtotime($rules[$setingId]['end_dateline']) ){ continue; }
							if( $setingId && $rules[$setingId]['category_id']==2 && ($nowTime >= strtotime($rules[$setingId]['start_dateline']) && $nowTime <= strtotime($rules[$setingId]['end_dateline'])) ){//若商品有参加活动,则显示活动价
								$price = $rules[$setingId]['discount_rate']>0 ? number_format($rules[$setingId]['discount_rate']*$price/100,2,'.','') : number_format($rules[$setingId]['discount_price'], 2,'.','');
							}
							if($rules[$setingId]['status']==2){
								$tx = strtotime($rules[$setingId]['start_dateline']) - $nowTime;
								if($tx < 0){ $tx = 0; }
							}else if($rules[$setingId]['status']==3){
								$tx = strtotime($rules[$setingId]['end_dateline']) - $nowTime;
								if($tx < 0){ $tx = 0; }
							}

							if($rules[$setingId]['status']==2 || $rules[$setingId]['status']==3) $staing = SiteController::dealTimes($tx);
							if($tx>0){$times[$id] = $tx;} 
						}
						$class  = ($v['stock'] && $tx) ? '' : 'ending';

				?>
                    <li class="<?php echo $class;?>">
						<a class="itemImg" href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['product_id']));?>" target="_blank">
                        <p class="grabEnd"></p><img width="380" height="300" class="lazy" alt="<?php echo $v['product_name'];?>" data-url="<?php echo IMG_DOMAIN . '/' .$v['thumbnail'];?>" /></a>
						<p class="name"><?php echo $v['product_name'];?></p>
						<div class="pricebg">
							<p class="price clearfix">
								<span class="txtl"><i>￥</i><?php echo $price;?></span>
								<span class="txtr"></span>
							</p>
							<p class="time" id="<?php echo $id;?>"><?php echo $string;?></p>
							<p class="buying"><a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['product_id']));?>" target="_blank" >立即抢购</a></p>
						</div>
					</li>
                <?php } ?>
                <?php }} else {
                    echo '<div class="no_product">目前没有任何活动商品</div>';
		}?>
		</ul>
                <?php //foreach($productCategory as $k=>$v){?>
                    <!--<ul class="clearfix" id="product_<?php //echo $v['id'];?>" style="display:none;"></ul>-->
                <?php //}?>
			</div>
                            <div class="pageList mb50 clearfix">
                    <?php $this->renderPartial('_pager',array('pagination'=>$pagination));?>
                </div>
		<div class="h50"></div>
		</div>
    </div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/layer/layer.js'); ?>
<script language="javascript">
var timeArray   = {};/*计时器数组*/
var pages       = {};/*分页数组*/

var isbool      = true; /*是否允许加载*/
var isend       = false; /*是否已结束(取完数据时,修改此值为true)*/
var range       = 350; /*距下边界高度/单位px*/     
var totalheight = 0; /*下拉条高度*/
var categoryId  = 0; /*当前点击的商品分类*/

<?php
if($times){
    foreach($times as $k=>$v){	
?>
timeArray['<?php echo $k;?>'] = '<?php echo $v;?>';
<?php }}?>

pages[0] = 2;
<?php foreach($productCategory as $k=>$v){?>
pages['<?php echo $v['id'];?>'] = 1;
<?php }?>

/** 点击展示产品 屏蔽ajax 2016-02-01 xqy */		
//$(".spikeprcb .title .txtr span").click(function(){
//	$(this).addClass("on");
//	//$(this).parent().find("span").not(this).removeClass("on");
//	$(this).siblings('span').removeClass("on"); //清除临近兄弟元素的class
//	
//        categoryId = $(this).attr('id');
//        return false;
////      $('#product_'+categoryId).css("display","block");
////	$('.spikeprcb').find("ul").not("#product_"+categoryId).css("display", "none");
//	
////	if($('#product_'+categoryId).html() == ''){
////            console.log('sd');
//	dealProductMore(); //调用，加载类目筛选结果
//		//isbool = false;
//		//setInterval("dealBool()", 1000);
////	}
//});

//**栏目搜索
//function showProduct(catid){
//    $.ajax({
//        url:'<?php echo $this->createAbsoluteUrl('site/getProduct')?>',
//        type:'POST',
//        dataType:'json',
//        data:{catie:catid,YII_CSRF_TOKEN:'<?php echo Yii::app()->request->csrfToken?>'},
//        success:function(data){
//            
//        }
//    })
//    
//}



/** 处理时间倒计时 */
function dealTimes(){
	$.each(timeArray, function (i, v) {
		if(v >= 0){
            $('#'+i).html( getTimeString(v) );
			timeArray[i] = timeArray[i]-1;
		}else{
			delete(timeArray[i]);
			window.location.reload();
		}
    });
}

/** 把时间处理成字符串 */
function getTimeString(t){
	if(t > 0){
		day  = 86400;
		hour = 3600;
		
		d = Math.floor(t/day);
		h = Math.floor((t-day*d)/hour);
		m = Math.floor((t-day*d-h*hour)/60);
		s = t-day*d-h*hour-m*60;
		
		return d+"天"+h+"时"+m+"分"+s+"秒"; 
	}else{
		return '0天0时0分0秒';
	}
}

/** 处理下拉加载更多商品*/
function dealProductMore(){
	//isbool = false;
    $.ajax({
	    url: '<?php echo str_replace('.html', '', $this->createAbsoluteUrl('site/getProduct'));?>',
		type: 'POST',
		dataType: "json",
		data:{'category_id':categoryId, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken;?>'},
		cache: false,
		timeout: 1000,
		error: function(){},
		success: function(data){
		    var length = data.length;		
			var html = cls = '';
 
			$.each(data, function(i,v){
				if(v['times']>0){
				    timeArray['product_'+categoryId+'_'+v['product_id']] = v['times'];
				}
				
				cls = (v['stock']>0 && v['times']>0) ? '' : 'ending';
				html += '<li class="'+ cls +'">';
				html += '<a class="itemImg" href="'+v['href']+'" target="_blank"><p class="grabEnd"></p><img class="lazy" width="380" height="300" alt="'+v['product_name']+'" data-url="'+v['thumbnail']+'" /></a>';
				html += '<p class="name">'+v['product_name']+'</p>';
				html += '<div class="pricebg">';
				html += '<p class="price clearfix">';
				html += '<span class="txtl"><i>￥</i>'+v['price']+'</span>';
				html += '<span class="txtr"></span>';
				html += '</p>';
				html += '<p class="time" id="product_'+categoryId+'_'+v['product_id']+'">'+v['dt']+'</p>';
				html += '<p class="buying"><a href="'+v['href']+'">立即抢购</a></p>';
				html += '</div>';
				html += '</li>';
			});
	        
			if(html != ''){
			    $('#product').html(html);
				pages[categoryId] += 1;
				LAZY.init(); 
                LAZY.run();
			}else{
				var original = $.trim($('#product_'+categoryId).html());
				if(original==''){
					$('#product').html('<div class="no_product">目前没有任何活动商品</div>');
				}
			}
	    }
    });	
}

function dealBool(){
	isbool = true;
}

$(document).ready(function() {
	setInterval("dealTimes()", 1000);
//		
	$(window).scroll(function(){  
		var srollPos = $(window).scrollTop();/*滚动条距顶部距离 */  
		totalheight  = parseFloat($(window).height()) + parseFloat(srollPos); 
//		
//		/*if(($(document).height()-range) <= totalheight){*/
//		if($(document).height() == totalheight){
//			if(isbool === true){
//				isbool = false;
//			    dealProductMore();
//				setInterval("dealBool()", 1000);
//			}
//		} 
	}); 
//	//$("img .lazy").lazyload({effect : "fadeIn" });
    LAZY.init();
    LAZY.run();
});

</script> 
