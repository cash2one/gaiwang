<?php
/** @var $this RechargeController */
/** @var $model Recharge */
$this->breadcrumbs = array(
    Yii::t('memberRecharge', '积分管理') => '',
    Yii::t('memberRecharge', '快捷支付'),
    Yii::t('memberRecharge', '绑定银行卡'),
);
$cardList=array();
?>
<div class="mbRight">
    <div class="left_1"><a class="curr"><?php echo Yii::t('memberRecharge', '银行卡签约'); ?></a></div>
    <div class="right_1"></div>
    <div class="mbRcontent">

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
				<!--<div class="payMethodList">
					<ul>
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
						<li class="clear"></li>
					</ul>
				</div>-->
				<!-- 储蓄卡、信用卡列表切换-->
				<script type="text/javascript">
					$(function(){
						$(".pm-title").click(function(){
							$(".pm-title").removeClass("pmsel");
							$(this).addClass("pmsel");
							if($(this).attr("tag")=="1"){
								$("#PM_list1").show();
								$("#PM_list2").hide();
							}else{
								$("#PM_list2").show();
								$("#PM_list1").hide();
							}
						});
					})
				</script>
				<div class="payMethodTitle">
					<div class="pm-title pm-title1 pmsel" tag="1">储蓄卡</div>
					<div class="pm-title pm-title2" tag="2">信用卡</div>
					<div class="clear"></div>
				</div>
				<?php  
				       $umCode=$this->getParam('code') ? $this->getParam('code') : '1';
				       $retUrl=$this->createAbsoluteUrl('quickPay/bindCard',array('code'=>$umCode));
				       $this->renderPartial('_bankList',array('code'=>$umCode));
				       $param=array(
                                'service'=>'bind_req_shortcut_front',
                                'charset'=>'UTF-8',
                                'mer_id'=>UM_MEMBER_ID,
                                'version'=>'4.0',
                                'mer_cust_id'=>$this->model->gai_number,
				       );
				?>
				<form action="<?php echo UM_PAY_URL;?>" method="post">
				    <?php foreach($param as $k => $v):?>
				    <input type="hidden" name="<?php echo $k;?>" value="<?php echo $v;?>">
				    <?php endforeach;?>
				    <input type="hidden" name="ret_url"  value="<?php echo $retUrl?>">
				    <input type="hidden" name="pay_type"  id="payTypes" value="">
				    <input type="hidden" name="gate_id" id="gateId" value="">
				    <input type="hidden" name="sign_type"  value="RSA">
				    <input type="hidden" name="sign" id="signTypes" value="">
				    <input class="PMBut" value="确认银行卡" type="submit">
				</form>
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
    /*$(document).ajaxStart(function () {
        if(window.unreadMessageNum) return false;
        art.dialog({
            lock: true,
            content: '<?php echo Yii::t('sellerOrder', '正在提交请求，请稍后……'); ?>'
        });
    });*/
    $(document).ajaxError(function () {
        art.dialog({
            content: "<?php echo Yii::t('sellerOrder', '操作失败，请重试'); ?>",
            ok: function () {
                document.location.reload();
            }});
    });
</script>