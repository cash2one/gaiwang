
<div class="positionWrap pt10">
    <div class="position"><a href="<?php echo Yii::app()->createAbsoluteUrl('/') ?>"><?php echo Yii::t('hongbaoSite','盖象商城') ?></a>&nbsp;&gt;&nbsp;<a href="<?php echo $this->createAbsoluteUrl('index') ?>"><?php echo Yii::t('hongbaoSite','盖网红包') ?></a>&nbsp;&gt;&nbsp;<b><?php echo Yii::t('hongbaoSite','注册送红包') ?></b></div>
</div>

<div class="redEnvReg">
    <div class="bg01">
        <div class="pcon">
            <div class="giveTip"><?php echo Yii::t('hongbaoSite','凡在盖象网站注册成会员即送红包一个，赶紧注册吧!') ?></div>
            <a title="<?php echo Yii::t('hongbaoSite','注册') ?>" href="<?php echo Yii::app()->createAbsoluteUrl('hongbao/site/registerCoupon') ?>"></a>
        </div>
    </div>
    <div class="bg02">
        <div class="pcon">
            <a href="#" title="" onclick = "return false;" style="cursor:default;" class="icon_reg a1" id="step1"></a>
            <a href="#" title="" onclick = "return false;" style="cursor:default;" class="icon_reg a2" id="step5"></a>
            <a href="#" title="" onclick = "return false;" style="cursor:default;" class="icon_reg a3" id="step3"></a>
            <a href="#" title="" onclick = "return false;" style="cursor:default;" class="icon_reg a4" id="step7"></a>
            <i class="icon_reg hr1" id="step2"></i>
            <i class="icon_reg hr2" id="step4"></i>
            <i class="icon_reg hr3" id="step6"></i>
            <a href="<?php echo Yii::app()->createAbsoluteUrl('hongbao/site/registerCoupon') ?>" title="<?php echo Yii::t('hongbaoSite','注册') ?>" class="a5"></a>
        </div>
    </div>
</div>
<div class="main">
    <div class="redEnvRegTips">
        <div class="title"><span><?php echo Yii::t('hongbaoSite','盖网红包，购物无障碍，想买啥就买啥!') ?></span></div>
        <div class="content">
            <h3><?php echo Yii::t('hongbaoSite','注册送红包说明') ?> </h3>
            <div class="desRule">
                <p><?php echo Yii::t('hongbaoSite','1、每位新用户只奖励一个注册红包；') ?></p>
                <p><?php echo Yii::t('hongbaoSite','2、注册获得的红包是盖网红包，可在购物结算时使用;') ?></p>
                <p><?php echo Yii::t('hongbaoSite','3、符合赠送条件的用户，红包会自动发放到红包账户；') ?></p>
                <p><?php echo Yii::t('hongbaoSite','4、红包可以在盖象商城购物时使用；') ?></p>
				<p><?php echo Yii::t('hongbaoSite','5、红包最终解释权归盖网所有，如有任何疑问请咨询盖网客服。') ?></p>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    /*动画*/
    $('#step1').animate({ opacity:'1'},500,function(){
        $('#step2').animate({ opacity:'1'},500,function(){
            $('#step3').animate({ opacity:'1'},500,function(){
                $('#step4').animate({ opacity:'1'},500,function(){
                    $('#step5').animate({ opacity:'1'},500,function(){
                        $('#step6').animate({ opacity:'1'},500,function(){
                            $('#step7').animate({ opacity:'1'},500);
                        });
                    });
                });
            });
        });
    });
</script>