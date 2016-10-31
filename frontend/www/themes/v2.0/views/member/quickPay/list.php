<?php $cardList = PayAgreement::getCardList($this->getUser()->gw,  PayAgreement::PAY_TYPE_GHT); ?>
<?php //var_dump($cardList);?>
<div class="main-contain">
<div class="withdraw-contents">
    <div class="accounts-box">
        <p class="accounts-title cover-icon"><?php echo Yii::t('memberRecharge', '快捷支付')?></p>
        <div class="fast-box">
            <p class="fast-title"><?php echo Yii::t('memberRecharge', '什么是快捷支付？')?></p>
            <p class="fast-txtle"><?php echo Yii::t('memberRecharge', '快捷支付是最便捷、最安全的网上支付方式。无需开通网银，只需在网上支付中选择U付一键支付，填写相应的银行卡信息，再次支付时只需要输入短信验证码即可完成付款。')?></p>
        </div>
    </div>
    <br />
    <div class="accounts-box">
        <div class="fast-box">
            <p class="fast-title"><b><?php echo Yii::t('memberRecharge', '您已经开通的快捷支付银行卡')?>：</b></p>
            <p class="fast-txtle"><?php echo Yii::t('memberRecharge', '已开通')?>：<span><?php echo count($cardList) ?><?php echo Yii::t('memberRecharge', '张')?></span></p>
            <div class="fast-card clearfix">
                <?php foreach($cardList as $v): ?>
                    <div class="order-bank icon-cart">
                        <div class="bank-name clearfix" id="card_<?php echo $v->id ?>" >
                            <i class="<?php echo $v->bank ?> bank-logo"></i>
                            <span class="bank-info number">****<?php echo substr($v->bank_num,-4); ?></span>
                            <div class="txtr"><span><?php echo $v::getCardType($v->card_type) ?></span></div>
                        </div>
                        <div class="bank-phone">预留手机号码：<?php echo substr($v->mobile,0,3),'***',substr($v->mobile,-3) ?></div>
                        <div class="bank-close">
                            <div class="validate">
                                <input type="text">
                                <button class="validate-code" data-id="<?php echo $v->id ?>">验证码</button>
                                <button class="validate-cancel">取消</button>
                                <button class="validate-submit">提交</button>
                                <input type="hidden" name="reqMsgId" class="reqMsgId">
                            </div>
                            <a href="javascript:;" class="PMClo" data-id="<?php echo $v->id ?>">关闭快捷支付</a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <a target="_blank" href="<?php echo $this->createUrl('quickPay/bindCards');?>"> <div class="fast-card-add ">

                </div></a>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    $(function(){
        var token_csrf = '<?php echo Yii::app()->request->csrfToken;?>';
        $('.bank-close .validate-cancel').on('click',function(){
           $(this).parent('.validate').hide().siblings('.PMClo').fadeIn(500);
        });
        $(".PMClo").click(function(){
            $(this).hide().siblings('.validate').fadeIn(500);
        });
        var time=59,index;
        $('.bank-close .validate-code').on('click',function(){
            var $this = $(this);
            var id = $this.attr('data-id');
            $this.text('发送中').attr('disabled','disabled');
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createAbsoluteUrl('/member/quickPay/sendMsg')?>',
                data:{id:id,YII_CSRF_TOKEN:token_csrf},
                dataType:'json',
                success:function(data){
                    $this.siblings('.reqMsgId').val(data.messageCode);
                    index = setInterval(function(){
                        if(time < 0){ //倒计时完毕
                            $this.removeAttr('disabled').removeAttr('style').text('再发送');
                            clearInterval(index);
                            time = 59;
                        } else{
                            if(time<10) time = time;
                            $this.text('发送('+time+')').css('font-size','10px');
                            time--;
                        }
                    },1000);
                }
            })
        });
        
        function timeClock(){
            console.log(index,time);
            if(time < 0){ //倒计时完毕
                
                clearInterval(index);
            }
            if(time<10) time = '0'+time;
            $('.bank-close .validate-code').text('发送('+time+')')
            time++;
        }
    })

//    $(".PMClo").click(function(){
//        $(this).hide().siblings('.validate').fadeIn(500);
//        var t = $(this);
//        var id = t.attr('data-id');
//        layer.confirm('您确定要关闭这张银行卡的快捷支付吗？',{icon:7,title:'关闭快捷支付'},function(index){
//            $.ajax({
//                type:"POST",
//                url:"<?php //echo $this->createAbsoluteUrl('/member/quickPay/unbind') ?>",
//                data:{id:id,YII_CSRF_TOKEN:"<?php //echo Yii::app()->request->csrfToken; ?>"},
//                success:function(data){
//                   location.reload();
//                }
//            });
//           layer.close(index);
//        });
//        art.dialog({
//            title:"关闭快捷支付",
//            content:'您确定要关闭这张银行卡的快捷支付吗？',
//            ok:function(){
//                $.ajax({
//                    type:"POST",
//                    url:"<?php //echo $this->createAbsoluteUrl('/member/quickPay/close') ?>",
//                    data:{id:id,YII_CSRF_TOKEN:"<?php //echo Yii::app()->request->csrfToken;?>"},
//                    success:function(){
//                        this.content = '关闭成功';
//                        location.reload();
//                    }
//                });
//            },
//            cancel:true
//        });
//    });
</script>