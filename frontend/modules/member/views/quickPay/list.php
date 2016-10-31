<?php
/** @var $this RechargeController */
/** @var $model Recharge */
$this->breadcrumbs = array(
    Yii::t('memberRecharge', '积分管理') => '',
    Yii::t('memberRecharge', '快捷支付'),
);
$cardList = PayAgreement::getCardList($this->getUser()->gw);
?>
<div class="mbRight">
    <div class="left_1"><a class="curr"><?php echo Yii::t('memberRecharge', '我的快捷支付'); ?></a></div>
    <div class="right_1"></div>
    <div class="mbRcontent">

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="mgtop20 upladBox ">
                    <h3 class="mgleft14"><?php echo Yii::t('memberRecharge', '什么是快捷支付？'); ?></h3>

                    <p class="integaralbd pdbottom10">
                        <span class="mgleft14">
                            <?php echo Yii::t('memberRecharge', '快捷支付是最便捷、最安全的网上支付方式。无需开通网银，只需在网上支付中选择U付一键支付，填写相应的银行卡信息，再次支付时只需要输入短信验证码即可完成付款'); ?>。
                        </span>
                    </p>
                </div>
				<div class="clear"></div>
				<div class="payMethodList">
					<p><b>您已经开通的快捷支付银行卡：</b></p>
					<p>已开通：<b class="red"><?php echo count($cardList) ?></b>张</p>
					<ul class="">
                        <?php /** @var $v PayAgreement */ ?>
                        <?php foreach($cardList as $v): ?>
						<li id="card_<?php echo $v->id ?>"><!--招商银行-->
							<div class="<?php echo $v->bank ?> PMImg"></div>
							<div class="PMNum">****<?php echo $v->bank_num ?></div>
							<div class="PMType"><?php echo $v::getCardType($v->card_type) ?></div>
							<div class="clear"></div>
							<div class="PMInfo">预留手机号码<span><?php echo substr($v->mobile,0,3),'***',substr($v->mobile,-3) ?></span></div>
							<div class="PMClo" data-id="<?php echo $v->id ?>" style="cursor:pointer;">关闭快捷支付</div>
						</li>
                        <?php endforeach; ?>
                        <li style="height: 50px;text-align:center;margin-top:90px;">
                           <a href="<?php echo $this->createUrl('quickPay/bindCard');?>" title="添加银行卡">
							<!--<div class="PMInfo"><span style="font-size: 30px">+</span>银行卡</div>-->
							<img height="50" src="../images/bgs/plus_bank_cards.gif"></img>
							</a> 
						</li>
						<li class="clear"></li>
					</ul>
				</div>
				
				
				

            </div>
            <div class="mbDate1_b"></div>

        </div>

    </div>
</div>

<script>
    $(".PMClo").click(function(){
        var id = $(this).attr('data-id');
        art.dialog({
            title:"关闭快捷支付",
            content:'您确定要关闭这张银行卡的快捷支付吗？',
            ok:function(){
                $.ajax({
                    type:"POST",
                    url:"<?php echo $this->createAbsoluteUrl('/member/quickPay/close') ?>",
                    data:{id:id,YII_CSRF_TOKEN:"<?php echo Yii::app()->request->csrfToken;?>"},
                    success:function(){
                        this.content = '关闭成功';
                        location.reload();
                    }
                });
            },
            cancel:true
        });
    });
    $(document).ajaxStart(function () {
        if(window.unreadMessageNum) return false;
        art.dialog({
            lock: true,
            content: '<?php echo Yii::t('sellerOrder', '正在提交请求，请稍后……'); ?>'
        });
    });
    $(document).ajaxError(function () {
        art.dialog({
            content: "<?php echo Yii::t('sellerOrder', '操作失败，请重试'); ?>",
            ok: function () {
                document.location.reload();
            }});
    });
</script>