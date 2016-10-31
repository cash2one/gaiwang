<?php
/* @var $this  SiteController */
/** @var $model Member */
$this->breadcrumbs = array(
    Yii::t('member', '账户管理') => '',
    Yii::t('member', '用户基本资料'),
);
Yii::app()->clientScript->registerScriptFile(DOMAIN . "/js/ZeroClipboard.min.js");

$model         = $this->model;
$account       = $this->account;
$onWaitReceipt = Order::onWaitReceipt();
$onWaitComment = Order::onWaitComment();
$hour          = date('H');
$percent       = $model->infoPercentV20();
$style         = ($percent>30 && $percent<100) ? "text-align:left;padding-left:".(($percent*0.9-20)/2)."px;" : "text-align:center;";
$intensity     = Yii::t('member','低');
$leverTip      = '<i class="member-icon level-tip"></i>';
if($model->mobile && $model->email){
    $intensity = 	Yii::t('member','高');
	$leverTip  = '';
}else if($model->mobile || $model->email){
	$intensity = 	Yii::t('member','中');
	$leverTip  = '';
}
?>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.jcarousellite.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function () {
		$(".collection-product .carousel").jCarouselLite({
			visible: 4,  //设置显示个数
			scroll: 4,  //每次滚动的数量
			btnPrev: ".collection-product .prev",  //设置向前按钮样式
			btnNext: ".collection-product .next"   //设置向后按钮样式
		});
		
		var carousel = ($('.carousel').find('li').length-3)/2;
		if(carousel < 5){
		    $('#myleft,#myright').css('display','none');
		}
	});
</script>

<div class="member-section">
        <div class="basic-info">
            <div class="info-details clearfix">
                <span class="avatar">
                    <?php if ($model->head_portrait): ?>
						<?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $model->head_portrait, 'c_fill,h_102,w_102'), '头像', array('width' => 102, 'height' => 102)); ?>
                    <?php else: ?>
                        <?php echo CHtml::image( Yii::app()->theme->baseUrl. '/images/bgs/default_102_102.jpg', '头像', array('width' => 102, 'height' => 102)); ?>
                    <?php endif; ?>
                </span>
                <span class="info-01">
                    <b class="name"><?php echo $modelInfo->name; ?></b>
                    <span class="say-hello"><?php if($hour>=6 && $hour<12){ echo Yii::t('member','早上好');}else if($hour>=12 && $hour<=18){echo Yii::t('member','下午好');}else{echo Yii::t('member','晚上好');}?></span>
                    <p><?php echo Yii::t('member','资料完整度');?>：<span class="process" title="<?php echo $percent;?>%"><i style="width:<?php echo $percent;?>%;"><span style="<?php echo $style;?>"><?php echo $percent.'%';?></span></i></span><?php if($percent < 100){ ?><a href="<?php echo Yii::app()->createAbsoluteUrl('/member/member/update');?>"><?php echo Yii::t('member','立即完善');?></a><?php }?></p>
                    <p><?php echo Yii::t('member','账号安全度');?>：<b class="level"><?php echo $intensity;?></b><?php echo $leverTip;?><i class="member-icon phone <?php if($model->mobile){echo 'active';}?>"></i><i class="member-icon email <?php if($model->email){echo 'active';}?>"></i><a href="<?php echo Yii::app()->createAbsoluteUrl('/member/member/accountSafe');?>"><?php echo Yii::t('member','立即提升');?></a></p>
                </span>
                <ul class="info-02 clearfix">
                    <li><i class="member-icon icon01"></i><?php echo Yii::t('member','余额');?>：<span class="balance"><?php echo HtmlHelper::formatPrice($account['money'],'font',array('class'=>'red')) ?></span></li>
                    <li><i class="member-icon icon02"></i><?php echo Yii::t('member','可用积分');?>：<?php echo $account['integral']; ?></li>
                    <li><i class="member-icon icon03"></i><?php echo Yii::t('member','红包');?>：<?php echo $account['red']; ?></li>
                    <li><i class="member-icon icon04"></i><?php echo Yii::t('member','冻结积分');?>：<?php echo $account['freeze'];?></li>
                </ul>
            </div>
            <div class="info-list">
                <a href="<?php
                        echo $this->createAbsoluteUrl('order/admin', array(
                            'Order[pay_status]' => Order::PAY_STATUS_NO,
                            'Order[status]' => Order::STATUS_NEW,
                            'on' => 'pay'))
                        ?>"><?php echo Yii::t('member','待付款');?><b class="num"><?php echo $waitPayNum;?></b></a>
                <a href="<?php
                        echo $this->createAbsoluteUrl('order/admin', array(
                            'Order[pay_status]' => Order::PAY_STATUS_YES,
                            'Order[status]' => Order::STATUS_NEW,
							'Order[delivery_status]' => Order::DELIVERY_STATUS_WAIT,
                            'on' => 'send'))
                        ?>"><?php echo Yii::t('member','待发货');?><b class="num"><?php echo $waitSendNum;?></b></a>
                <a href="<?php
                        echo $this->createAbsoluteUrl('order/admin', array(
                            'Order[delivery_status]' => Order::DELIVERY_STATUS_SEND,
                            'Order[status]' => Order::STATUS_NEW,
                            'Order[return_status]' => Order::RETURN_STATUS_NONE,
                            'Order[refund_status]' => Order::REFUND_STATUS_NONE,
                            'on' => 'wait'))
                        ?>"><?php echo Yii::t('member','待收货');?><b class="num"><?php echo $waitReceiveNum;?></b></a>
                <a href="<?php
                        echo $this->createAbsoluteUrl('order/admin', array(
                            'Order[is_comment]' => Order::IS_COMMENT_NO,
                            'Order[status]' => Order::STATUS_COMPLETE,
                            'on' => 'comment'))
                        ?>"><?php echo Yii::t('member','待评价');?><b class="num"><?php echo $waitCommentNum;?></b></a>
            </div>
        </div>
        
        <div class="member-category-top clearfix">
            <span class="category-title"><?php echo Yii::t('member','我的订单');?></span>
            <a href="<?php echo Yii::app()->createAbsoluteUrl('/member/order/admin');?>" class="more"><?php echo Yii::t('member','查看全部订单');?> >></a>
        </div>
        <ul class="order-list">
        <?php if(!empty($orders)){
		    foreach ($orders as $k => $v){
				if($v['flag']==Order::FLAG_ONE && $v['create_time']<1401552000) continue; //历史特殊商品，跳过
		?>
          <li>
            <div class="item-top">
                <b class="order-date"><?php echo $this->format()->formatDatetime($v['create_time']); ?></b>
                <span class="order-num"><?php echo Yii::t('memberOrder', '订单编号'); ?>：<?php echo $v['code']; ?></span>
                <?php $store = Order::getStoreInfo($v['goods_id']);?>
                <a href="<?php echo $this->createAbsoluteUrl('/shop/' . $store['id']);?>" class="shop link" title="<?php echo $store['name'];?>" target="_blank"><?php echo Tool::dCutUtf8String($store['name'], 10);?></a>
            </div>
            <div class="item-content clearfix">
                <span class="col-01"><a href="<?php echo $this->createAbsoluteUrl('/JF/' . $v['goods_id']);?>" title="<?php echo $v['goods_name'];?>" target="_blank"><?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['goods_picture'], 'c_fill,h_90,w_90'),'',array('width'=>88, 'height'=>88, 'class'=>'product-img')); ?></a> </span>
                <span class="col-02"><a href="<?php echo $this->createAbsoluteUrl('/JF/' . $v['goods_id']);?>" class="product-name link" target="_blank"><?php echo $v['goods_name'];?>
				<?php if($v['goodsNum']>1){echo '<br/>...';}?></a></span>
                <span class="col-03"><?php echo $v['consignee'];?></span>
                <span class="col-04"><b><?php echo HtmlHelper::formatPrice(sprintf('%0.2f', $v['pay_price']));?></b><p>（<?php echo Yii::t('memberOrder', '含运费'); ?>：<?php echo HtmlHelper::formatPrice($v['freight']); ?>）</p></span>
                <span class="col-05">
                <p><?php echo Order::status($v['status']) ?></p>
                <?php if ($v['status'] == Order::STATUS_NEW): //新订单才显示先关支付、物流状态 ?>
                    <p><?php echo Order::payStatus($v['pay_status']) ?></p>
                    <p><?php echo Order::deliveryStatus($v['delivery_status']); ?></p>
                    <?php if ($v['refund_status'] != Order::REFUND_STATUS_NONE): ?>
                        <p><?php echo Order::refundStatus($v['refund_status']) ?></p>
                    <?php endif ?>
                <?php endif; ?>
                <?php
				switch ($v['return_status']) {
					case 1:
						echo "<p>".Order::returnStatus($v['return_status']).'</p>';
						break;
	  
					case 2:
						echo "<p>".Order::returnStatus($v['return_status']).'</p>';
						break;
					case 3:
						echo "<p>".Order::returnStatus($v['return_status']).'</p>';
						break;
					case 4:
						echo "<p>".Order::returnStatus($v['return_status']).'</p>';
						break;
					default:
						break;
				}
				if($v['is_right']){
					echo "<p>".Order::rightStatus($v['is_right']).'</p>';
				}
				?>
                </span>
                <span class="col-06 myorder-list">
                <a class="btn browse" target="_blank" href="<?php echo $this->createAbsoluteUrl('order/newDetail', array('code' => $v['code']));?>"><?php echo Yii::t('memberOrder', '查看');?></a>
				<!--<?php if ($v['status'] == Order::STATUS_NEW && $v['pay_status'] == Order::PAY_STATUS_NO): //新订单，未支付 ?>
				<?php
                echo '<p style="padding:3px 0;">'.CHtml::link(Yii::t('memberOrder', '去付款'), array('/order/pay', 'code' => $v['code']), array('class'=>'pay-btn')).'</p>';
                $orderCache = ActivityData::getOrderCacheByCode($v['code']);
                if(!empty($orderCache)){//秒杀支付,显示剩余时间
                    $validEnd = $orderCache['create_time'] + SeckillRedis::TIME_INTERVAL_ORDER;
                    $t = $validEnd - time();
                    if($t>0){
                        $h = floor($t/3600);
                        $m = floor($t/60);
                        $s = $t%60;
                        echo "<p class=\"remain-time\">还剩{$h}小时{$m}分钟{$s}秒取消</p>";
                    }
                }
                echo '<p style="padding:3px 0;">'.CHtml::link(Yii::t('memberOrder', '取消订单'), '#', array('class' => 'pay-btn cancelOrder', 'data_code' => $v['code'])).'</p>';
                ?>
				<?php endif; ?>
          
                <?php
                if ($v['status'] == Order::STATUS_NEW && $v['pay_status'] == Order::PAY_STATUS_YES && $v['delivery_status'] == Order::DELIVERY_STATUS_NOT &&
                    $v['refund_status'] == Order::REFUND_STATUS_NONE): //新订单，已支付，未发货
                    ?>
                    <?php echo '<p style="padding:3px 0;">'.CHtml::link(Yii::t('memberOrder', '退款/退货'), '#', array('data_code' => $v['code'], 'class' => 'pay-btn refundOrder')).'</p>'; ?>
                    <?php echo '<p style="padding:3px 0;">'.CHtml::link(Yii::t('memberOrder', '提醒卖家发货'), '#', array('data_code' => $v['code'], 'class' => 'remind-btn')).'</p>'; ?>
                <?php endif; ?>
          
                <?php if ($v['status'] == Order::STATUS_NEW && $v['pay_status'] == Order::PAY_STATUS_YES && $v['delivery_status'] == Order::DELIVERY_STATUS_SEND): //新订单，已支付，已出货
                    ?>
                    <?php if ($v['return_status'] == 0): ?>
                    <a href='javascript:ConfirmRePurcharse("<?php echo $v['code'] ?>",<?php echo $v['freight'] ?>,<?php echo $v['pay_price'] ?>)'><?php echo Yii::t('memberOrder', '退款/退货'); ?></a>
                <?php endif; ?>
                    <?php if ($v['return_status'] == Order::RETURN_STATUS_NONE || $v['return_status'] == Order::RETURN_STATUS_FAILURE || $v['return_status'] == Order::RETURN_STATUS_CANCEL): ?>
                    <?php echo CHtml::link(Yii::t('memberOrder', '确认收货'), '#', array('data_code' => $v['code'], 'class' => 'confirm-btn signOrder')); ?>
                <?php endif; ?>
                <?php endif; ?>
          
                <?php if ($v['status'] == Order::STATUS_COMPLETE && $v['delivery_status'] == Order::DELIVERY_STATUS_RECEIVE && $v['is_comment'] == Order::IS_COMMENT_NO)://已完成、已收货
                    ?>
                    <?php echo CHtml::link(Yii::t('memberOrder', '我要评价'), $this->createAbsoluteUrl('comment/evaluate', array('code' => $v['code'])), array('class'=>'evaluate-btn'));
                    ?>
                <?php endif; ?>
                <?php if ($v['status'] == Order::STATUS_COMPLETE && $v['delivery_status'] == Order::DELIVERY_STATUS_RECEIVE && $v['is_comment'] == Order::IS_COMMENT_YES)://已完成、已收货
                    ?>
                    <?php echo CHtml::link(Yii::t('memberOrder', '修改评价'), $this->createAbsoluteUrl('comment/edit', array('code' => $v['order_id'])), array('class'=>'evaluate-btn'));
                    ?>
                <?php endif; ?>
          
                <?php
                    if($v['status'] == Order::STATUS_NEW && $v['return_status'] == Order::RETURN_STATUS_AGREE){
                        echo CHtml::link(Yii::t('memberOrder', '取消退货'),  '#', array('class' => 'pay-btn cancelReturn', 'data_code' => $v['code']));
                    }
                ?>-->
                </span>
            </div>
          </li>
        <?php }}?> 
        </ul>
        
        <div class="member-category-top clearfix">
            <span class="category-title"><?php echo Yii::t('member','收藏的商品');?></span>
            <a href="<?php echo Yii::app()->createAbsoluteUrl('/member/GoodsCollect');?>" class="more"><?php echo Yii::t('member','查看全部收藏');?> >></a>
        </div>
        <div class="collection-product clearfix">
            <a href="#" class="direct prev" id="myleft"></a>
            <div class="carousel">
                <ul>
                <?php if(!empty($collects)){
				    foreach($collects as $v){
				?>
                    <li>
                        <a href="<?php echo  $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])); ?>" title="<?php echo $v['name'];?>">
                            <img src="<?php echo IMG_DOMAIN.'/'.$v['thumbnail'];?>" width="178" height="178" class="product-img"
                                 alt="<?php echo $v['name'];?>"/>
                            <div class="product-description">
                                <p class="product-name"><?php echo Tool::dCutUtf8String($v['name'], 48);?></p>
                                <p><span class="price"><?php echo HtmlHelper::formatPrice($v['price']); ?></span><s class="old-price"></s></p>
                            </div>
                        </a>
                <?php } }?>
                </ul>
            </div>
            <a href="#" class="direct next" id="myright"></a>
        </div>
    </div>
    
    <div class="member-aside">
        <div class="calendar">
            <div class="calendar-top"><?php echo Yii::t('member','我的日历'); ?><i class="member-icon clock"></i></div>
            <div class="calendar-date">
                <span class="day"><?php echo date('d');?></span>
                <span class="line"></span>
                <p class="week"><?php echo Yii::t('member',Tool::getWeek()); ?></p>
                <p class="date"><?php echo date('Y年m月d日'); ?></p>
            </div>
        </div>
            
        <div class="member-category-top clearfix">
            <span><?php echo Yii::t('member','优品汇'); ?></span>
            <a href="<?php echo Yii::app()->createAbsoluteUrl('/active/festive/index');?>" target="_blank" class="more"><?php echo Yii::t('member','查看更多'); ?> >></a>
        </div>
        <?php if(!empty($active)){ $t = 1; ?>
		<div class="show-list">	
            <?php foreach($active as $v){	
				    if($t>3) break;
					$t++;
                    $url = $v['category_id'] == SeckillRulesSeting::SECKILL_CATEGORY_FOUR ? Yii::app()->createAbsoluteUrl('/active/auction/index/'.$v['id']) : Yii::app()->createAbsoluteUrl('/active/festive/detail/'.$v['id']);
		    ?>
            <a href="<?php echo $url;?>">
                <img src="<?php echo ATTR_DOMAIN . '/' .$v['picture'];?>" alt="<?php echo $v['name'];?>"/>
                <span class="item-title"><?php echo $v['name']?></span>
            </a>
            <?php }?>
         </div>   
        <?php }else{?>
            <div class="no-show" style="display:block;"><?php echo Yii::t('member','目前没有任何活动'); ?></div>
        <?php }?>
        
  </div>
<script type="text/javascript">
/*$(document).ready(function(){
  $("iframe[name=getweather]").attr('src',"<?php echo $this->createUrl('getweather');?>");
});*/
</script>