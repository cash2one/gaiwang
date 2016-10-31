<?php
$validEnd = Yii::app()->db->createCommand()
    ->select('valid_end')
    ->from('{{member_account}}')
    ->where('member_id=:member_id', array(':member_id' => $this->model->id))
    ->queryScalar();
?>

<script src="<?php echo DOMAIN ?>/js/jquery.countdown.min.js"></script>
<div class="main-contain">
    <div class="return-record">
        <span><?php echo Yii::t('redEnvelope', '我的钱包'); ?></span>
    </div>
    <div class="asset-center">
        <div class="wallet-top clearfix">
            <div class="wallet-top-item">
                <p class="wallet-price"><?php echo HtmlHelper::formatPrice($this->account['money']) ?></p>
                <p class="wallet-link-box"><a href="<?php echo Yii::app()->createAbsoluteUrl('/member/wealth/cashDetail') ?>"><?php echo Yii::t('redEnvelope', '消费查询'); ?> >></a></p>
            </div>
            <div class="wallet-top-item second">
                <p class="wallet-price"><?php echo HtmlHelper::formatPrice($this->account['red'], 'font') ?><br><span><?php echo Yii::t('redEnvelope', '有效期还剩'); ?><i id="clock" >0</i></span><a class="wallet-link cover-icon wallet-link2" href="#"></a></p>
                <p class="wallet-link-box"><a href="<?php echo Yii::app()->createUrl('/member/redEnvelope/redList') ?>"><?php echo Yii::t('redEnvelope', '查看领取清单'); ?> >></a><?php echo CHtml::link(Yii::t('redEnvelope', '我要分享(领取红包奖励) '), Yii::app()->createAbsoluteUrl('/hongbao/site/share')) ?> <a class="wallet-link cover-icon wallet-link3" href="#"></a></p>
            </div>
        </div>
        <div class="wallet-center">
            <!--<div class="wallet-box">
                <span class="wallet-title cover-icon"><?php /*echo Yii::t('redEnvelope', '店铺优惠卷'); */?></span>
                <span class="price cover-icon"><?php /*echo Yii::t('redEnvelope', '优惠金额'); */?></span>
                <span class="time-end cover-icon"><?php /*echo Yii::t('redEnvelope', '到期时间'); */?></span>
                <span class="time-start cover-icon"><?php /*echo Yii::t('redEnvelope', '开始时间'); */?></span>
            </div>-->
            <div class="wallet-coupon">
                <?php //echo Yii::t('redEnvelope', '暂无商家优惠价'); ?>
                <!--<ul>

                    <li class="coupon-tc">
                        <div class="left">
                            <p class="coupon-name">松下电器旗舰店</p>
                            <p class="coupon-price">¥5</p>
                            <p class="coupon-fix">满158使用</p>
                        </div>
                        <div class="right">
                            <p class="coupon-time">有效期</p>
                            <p class="coupon-start">2015-06-08</p>
                            <p class="coupon-end">2015-06-10</p>
                        </div>
                    </li>

                </ul>-->
            </div>
        </div>
    </div>



</div>
    <div class="wallet-fd wallet-fd1">
        <span></span><!--图标不能删-->
        <h3>有效期时间说明：</h3>
        1、红包积分的余额是有使用的有效期，当有效期时间变为0时，红包积分余额清零。</br>
        2、每次领取到新的红包积分，有效期时间会变成30天，然后重新倒数。</br>

    </div>
    <div class="wallet-fd wallet-fd2">
        <span></span><!--图标不能删-->
        <h3>分享奖红包步骤</h3>
        1、<strong>分享链接</strong>  用户注册登录后，将注册链接分享给好友。</br>
        2、<strong>好友注册成功</strong>  好友通过您分享的注册链接完成注册，成为盖网会员。</br>
        3、<strong>奖励红包</strong> 成功注册并绑定手机后，马上就能获得盖网送出的红包，分享多多，奖励多多。</br>
        <h3>分享奖红包说明</h3>
        1、用户分享的次数不设上限，同一个分享链接新用户注册数量不设上限，赠送的红包数量不设上限；</br>
        2、符合赠送条件的用户，红包会自动发放到红包账户中；</br>
        3、红包可以在盖象商城购物时使用；</br>
        4、红包最终解释权归盖网所有，如有任何疑问请咨询盖网客服</br>
    </div>
<?php if($this->account['red'] > 0){ ?>
<script>
    $(function(){
        var validEnd = '<?php echo date('Y/m/d H:i:s', $validEnd) ?>';
        var validStart = '<?php echo date('Y/m/d H:i:s') ?>';
        $('#clock').countdown(validEnd, function(event) {
            $(this).html(event.strftime('%D 天 %H:%M:%S'));
        }, validStart);
    })
</script>

<?php } ?>
<script>
    $(function(){
        $(".wallet-link2").hover(function(){
            $(".wallet-fd1").css("top",(parseInt($(this).offset().top)+22));
            $(".wallet-fd1").css("left",(parseInt($(this).offset().left)-125));
            $(".wallet-fd1").show();
        },function(){
            $(".wallet-fd1").hide();
        });

        $(".wallet-link3").hover(function(){
            $(".wallet-fd2").css("top",(parseInt($(this).offset().top)+22));
            $(".wallet-fd2").css("left",(parseInt($(this).offset().left)-125));
            $(".wallet-fd2").show();
        },function(){
            $(".wallet-fd2").hide();
        });
    })
</script>