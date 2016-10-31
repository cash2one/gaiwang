<!--主体start-->
<div class="member-contain clearfix">
    <div class="crumbs">
        <span><?php echo Yii::t('member', '您的位置');?>：</span>
        <a href="<?php echo $this->createAbsoluteUrl('/member/site/index');?>"><?php echo Yii::t('member', '首页');?></a>
        <span>&gt</span>
        <a href="<?php echo $this->createAbsoluteUrl('/member/exchangeGoods/admin');?>"><?php echo Yii::t('member', '售后服务');?></a>
        <span>&gt</span>
        <a href="javascript:void(0);"><?php echo Yii::t('member', '退换货申请');?></a>
    </div>
    <div class="returns-product">
        <div class="returns-top">
            <p class="returns-title cover-icon"><?php echo Yii::t('member', '售后服务详情');?></p>
            <div class="returns-process clearfix">
                <div class="returns-process-item on">
                    <p class="number">1</p>
                    <p class="txtle"><?php echo Yii::t('member', '买家 提交申请');?></p>
                    <span class="returns-backdrop on"></span>
                </div>

                <div class="returns-process-item on">
                    <p class="number">2</p>
                    <p class="txtle"><?php echo Yii::t('member', '商家 处理申请');?></p>
                    <span class="returns-backdrop <?php if($info['exchange_status'] == Order::EXCHANGE_STATUS_DONE){echo 'on';}?>"></span>
                </div>

                <div class="returns-process-item <?php if($info['exchange_status'] == Order::EXCHANGE_STATUS_DONE){echo 'on';}?>">
                    <p class="number">3</p>
                    <p class="txtle"><?php echo Yii::t('member', '完成');?></p>
                </div>
            </div>
        </div>

        <div class="returns-services">
            <p class="returns-title cover-icon"><?php echo Yii::t('member', '服务进度');?></p>
            <p class="returns-services-title"><?php echo Yii::t('member', '本次服务由');?> <span><?php echo $orderInfo['memberInfo']['store_name'] ?></span> <?php echo Yii::t('member', '为您提供');?></p>
            <div class="returns-services-box">
                <p><span><?php echo Yii::t('member', '退换货编号');?>：</span><?php echo $info['exchange_code'];?></p>
                <p><span><?php echo Yii::t('member', '退换货类型');?>：</span><?php echo Yii::t('memberOrder', '退款不退货');?></p>
                <p><span><?php echo Yii::t('member', '退换货状态');?>：</span><?php echo $exchangeStatus[$info['exchange_status']];?></p>
                <?php if($info['exchange_status'] == 0){ ?>
                <p><?php echo Yii::t('member', '亲爱的客户，请您等待卖家审核结果。');?></p>
                <p class="li"><?php echo Yii::t('member', '如果卖家同意，待您退货给卖家后，卖家将给您支付');?> <i><?php echo HtmlHelper::formatPrice($info['exchange_money']); ?></i><?php echo Yii::t('member', '元 退款');?>；</p>
                <p class="li"><?php echo Yii::t('member', '如果卖家拒绝，可根据卖家的拒绝理由再次提出退款申请，或者您可以直接与卖家沟通；');?></p>
                <p class="li"><?php echo Yii::t('member', '如果卖家在');?><span id="apply_time"></span> <?php echo Yii::t('member', '内未处理，请联系商城客服进行申诉');?></p>
                <p><span><?php echo Yii::t('memberOrder', '您还可以');?>：</span> <a href="javascript:cancalReturn(<?php echo $info['exchange_id'];?>);"><i><?php echo Yii::t('memberOrder', '取消退款不退货申请。取消后将不能再次提交申请！');?></i></a><span class="block-off"></span><?php echo Yii::t('member', '如需客服介入，致电');?><span class="blue">400-620-6899</span></p>
                <?php }else if($info['exchange_status'] == 2){ ?>
                    <p><span><?php echo Yii::t('member', '卖家拒绝说明');?>：</span><?php echo $info['exchange_examine_reason']; ?></p>
                    <p><?php echo Yii::t('member', '如需客服介入，致电');?><span class="blue">400-620-6899</span></p>
                <?php }else if($info['exchange_status'] == 5){ ?>
                    <p><?php echo Yii::t('member', '退款不退货申请已取消，本次服务结束。');?><span class="block-off"></span><?php echo Yii::t('member', '如需客服介入，致电');?><span class="blue">400-620-6899</span></p>
                <?php }else if($info['exchange_status'] == 6){ ?>
                    <p><?php echo Yii::t('member', '退款成功。退款金额');?>：<i><?php echo HtmlHelper::formatPrice($info['exchange_money']) ?></i><?php echo Yii::t('member', '元');?><span class="block-off"></span><?php echo Yii::t('member', '如需客服介入，致电');?><span class="blue">400-620-6899</span></p>
                <?php } ?>
            </div>
        </div>

        <?php $this->renderPartial('_orderinfo',array('orderInfo'=>$orderInfo)); ?>
    </div>
</div>
<?php if($info['exchange_status'] == 0){ ?>
<script>

    function GetRTime(times,Element){
        var t = times;
		if(t < 0 ){
			Element.html("<i> 0</i>天 <i>0</i>时 <i>0</i>分 <i>0</i>秒");
			return true;
		}
		
        var d=Math.floor(t/60/60/24);
        var h=Math.floor(t/60/60%24);
        var m=Math.floor(t/60%60);
        var s=Math.floor(t%60);
        Element.html("<i>  "+d+"</i>天 <i>"+h+"</i>时 <i>"+m+"</i>分 <i>"+s+"</i>秒");

    }

    $(function(){
        var apply_time = <?php echo $info['exchange_apply_time'] ?>;
        var i = 1;
        setInterval(function(){
            var times = apply_time - i;
            GetRTime(times,$('#apply_time'));
            if(times <2 && times > 0){
                history.go(0);
            }
            i++
        },1000);
    })
	
	function cancalReturn(id){
		layer.confirm('<?php echo Yii::t('memberOrder', '你确定要取消该申请?'); ?>', {
			btn: ['确定','取消'], //按钮
			shade: false, //不显示遮罩
			offset: 'auto'
		}, function(){
			$.ajax({
				type: "POST",
				dataType: 'json', 
				url: "<?php echo $this->createAbsoluteUrl('exchangeGoods/cancelReturnNullGoods') ?>",
				data: {
					"YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
					"id": id
				},
				success: function(data) {
					layer.alert(data.message);
					window.location.reload();
				}
			});
		}, function(){
			layer.closeAll();
		});
	}

</script>
<?php } ?>
<!-- 主体end -->