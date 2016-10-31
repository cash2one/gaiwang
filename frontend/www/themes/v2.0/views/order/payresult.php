<?php
/* @var $this Controller */
?>
<?php
    Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/global.css');
    Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/module.css');
    Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/cart.css');
    Yii::app()->clientScript->registerScriptFile($this->theme->baseUrl . '/js/jquery-1.9.1.js');
?>
<!--///头///-->
<div class="pages-header">
    <div class="w1200">
        <div class="pages-logo"><a href="<?php echo DOMAIN?>"><img src="<?php echo Yii::app()->theme->baseUrl?>/images/temp/register_logo.jpg" width="213" height="86" /></a></div>
        <div class="order-search icon-cart clearfix">
            <form id="home-form" action="<?php echo $this->createAbsoluteUrl('/search/search'); ?>" target="_blank" method="get">
                <input class="input-problem" type="text" value="<?php echo isset($this->keyword) ? $this->keyword : ''; ?>" name="q"  accesskey="s" autofocus="true" />
                <!--<input name="" type="text" class="input-problem" />-->
                <!--<span class="microphone icon-cart" title="语音"></span>-->
                <input name="" type="submit" value="" class="btn-dete" title="" />
            </form>
        </div>
    </div>
</div>
<!--主体start-->
<div class="shopping-pay">
    <?php if(!isset($result['errorMsg'])):?>
    <div class="order-cancel">
        <div class="order-title-on"><span><i class="icon-cart"></i><?php echo Yii::t('orderflow','订单已支付')?></span></div>
        <div class="order-message clearfix">
            <!--<div class="order-message-title">未能在限定时间内完成支付，订单已被取消！</div>-->
            <div class="order-message-txtle">
                <p class="number"><?php echo Yii::t('orderflow','订 单 号')?>：<?php echo $model->code?></p>
                <p class="product"><?php echo Yii::t('orderflow','商    品')?>：<?php echo $model->orderGoods[0]->goods_name?><?php if(count($model->orderGoods) > 1) echo Yii::t('order','等多件商品')?></p>
                <p class="money"><?php echo Yii::t('orderflow','交易金额')?>：<?php echo Common::rateConvert($payAccount);?>元</p>
                <p class="time"><?php echo Yii::t('orderflow','订单确认时间')?>：<?php echo date('Y年m月d日 H:i:s',$model->create_time)?></p>
                <p class="address"><?php echo Yii::t('orderflow','收货地址')?>：<?php echo $model->address . '，' . $model->consignee.'(收) '. $model->mobile?></p>
            </div>
            <div class="order-message-box">
                <a class="again" href="<?php echo DOMAIN?>"><?php echo Yii::t('orderflow','继续购买')?></a>
                <a class="check" href="<?php echo $this->createUrl('member/order/newdetail',array('code'=>$model->code))?>"><?php echo Yii::t('ordeflow','查看订单')?></a>
                 <?php 
                    $goodsIdArr=array();
                      foreach($model->orderGoods as $k => $v){
                         $goodsIdArr[$k]=$v->goods_id;
                    }
                   ?>
                 <?php if(in_array(OrderMember::GOODS_ONE, $goodsIdArr) || in_array(OrderMember::GOODS_TWO, $goodsIdArr) || in_array(OrderMember::GOODS_THREE, $goodsIdArr)):?>
                    <a class="check" style="color:#fff;background: #c20005" target="_blank" href="<?php echo $this->createUrl('order/addMember',array('code'=>$model->code))?>"><?php echo Yii::t('ordeflow','去填写信息')?>>></a>
                 <?php endif;?>
            </div>
        </div>
    </div>
    <?php else:?>
    <!--主体start-->
        <div class="shopping-pay">
            <div class="order-unpaid">
                <div class="order-title"><span><i class="icon-cart"></i><?php echo Yii::t('orderflow','订单支付失败')?></span></div>
                <div class="order-message clearfix">
                    <div class="left">
                        <?php
                            $endtime = $model->create_time + 86400;
                            $starttime = time();$h=0;$m=0;$s=0;
                            if($endtime>=$starttime){
                                $h = date('H', $endtime) + 24 - date('H', $starttime);
                                $m = date('i', $endtime) - date('i', $starttime);
                                if ($m <= 0) {
                                    $m += 60;
                                    $h -= 1;
                                }
                                $s = date('s', $endtime) - date('s', $starttime);
                                if ($s <= 0) {
                                    $s = date('s', $endtime) - date('s', $starttime) + 60;
                                    $m -= 1;
                                }
                            }
                            ?>
                        <p class="order-message-txt" id="has-time"><?php echo Yii::t('orderflow','距订单过期还剩')?>：<span><?php echo $h?></span> 时 <span><?php echo $m?></span> 分 <span><?php echo $s?></span> 秒</p>
                        <p class="order-message-txt"><?php echo Yii::t('orderflow','订单号')?>：<?php echo $model->code?></p>
                        <p class="order-message-txt"><?php echo Yii::t('orderflow','应付金额')?>：<span><?php echo HtmlHelper::formatPrice($model->pay_price);?></span></p>
                        <p class="order-message-btn"><input onclick="window.location.href='<?php echo $this->createUrl('order/payv2',array('code'=>$model->code))?>'" class="btn-dete" type="button" value="立即付款" />如果您在订单过期前未付款，您的订单将被取消。</p>   
                    </div>
<!--                    <div class="right">
                        <div class="download-code icon-cart">
                            <img width="130" height="130" src="<?php // echo Yii::app()->theme->baseUrl?>/images/temp/pay_logo_130x130.jpg" />
                        </div>
                        <div class="download-message">
                            <i class="icon-cart"></i>下载盖付通扫码支付
                        </div>
                    </div>-->
                </div>
            </div>
            <script>
                //简易倒计时
                var h = <?php echo $h?>, m = <?php echo $m?>, s = <?php echo $s?>;
                function hastime(h,m,s){
                    if(h===0 && m===0 && s===0) window.location.href='<?php echo $this->createUrl('order/cancelOrder',array('code'=>$model->code))?>';//跳回姥姥家
                    s = ps(h,m,s);
                    document.getElementById('has-time').innerHTML = '距订单过期还剩：<span>'+s[0]+'</span> 时 <span>'+s[1]+'</span> 分 <span>'+s[2]+'</span> 秒';
                    setTimeout('hastime('+s[0]+','+s[1]+','+s[2]+')',1000);
                }
                //处理秒
                function ps(h,m,s){
                    if(s === 0){
                        s = 59;
                        if(m>0){
                            m -= 1;
                        } else if(m === 0) {
                            if(h>0){
                                m = 59;
                                h -= 1;
                            } else {
                                h=0;m=0;s=0;
                            }
                        }
                    } else {
                        s -=1;
                    }
                    if(s<10) s = '0' + s;
                    if(m<10) m = '0' + m;
                    if(h<10) h = '0' + h
                    return [h,m,s];
                }
                hastime(h,m,s);
            </script>
            <div class="order-problem">
                <div class="w1000">
                    <div class="order-title">付款遇到问题了？看看是否由于以下原因：</div>
                    <div class="question icon-cart">网上支付显示不成功</div>
                    <div class="answer">
                        1、支付密码错误；<bR />

                        2、银行卡余额不足；<bR />

                        3、所需支付金额超过了银行支付限额，建议您登录网上银行提高上限额度；<bR />

                        4、银行卡在可用作支付的银行卡范围内，但是您的卡尚未在发卡行办理网上支付开通手续。
                    </div>
                    <div class="question icon-cart">网银页面显示错误或者空白</div>
                    <div class="answer">
                        部分网银对不同浏览器的兼容性有限，导致无法正常支付，建议您使用IE浏览器进行支付操作。
                    </div>
                    <div class="question icon-cart">网上银行已扣款，订单仍显示“未付款”</div>
                    <div class="answer">
                        可能由于银行的数据没有即时传输，请不要担心，稍后刷新页面查看。如较长时间仍显示未付款，可联系客服 400-620-6899 为您解决。
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
</div>
<!-- 主体end -->

