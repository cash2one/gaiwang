<?php
    Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/global.css');
    Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/module.css');
    Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/cart.css');
    Yii::app()->clientScript->registerScriptFile($this->theme->baseUrl.'/js/jquery-1.9.1.js');
?>
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
    <div class="order-cancel">
        <div class="order-title"><span><i class="icon-cart"></i><?php echo Yii::t('orderflow','订单已取消')?></span></div>
        <div class="order-message clearfix">
            <!--<div class="order-message-title">未能在限定时间内完成支付，订单已被取消！</div>-->
            <div class="order-message-txtle">
                <p class="number"><?php echo Yii::t('orderflow','订 单 号')?>：<?php echo $model->code?></p>
                <p class="product"><?php echo Yii::t('orderflow','商    品')?>：<?php echo $model->orderGoods[0]->goods_name.Yii::t('orderflow',' 等多件商品')?></p>
                <p class="money"><?php echo Yii::t('orderflow','交易金额')?>：<?php echo Common::rateConvert($payAccount)?>元</p>
                <p class="time"><?php echo Yii::t('orderflow','下单时间')?>：<?php echo date('Y年m月d日 H:i:s',$model->create_time)?></p>
                <p class="address"><?php echo Yii::t('orderflow','收货地址')?>：<?php echo $model->address . '，' . $model->consignee.'(收) '. $model->mobile?></p>
            </div>
            <div class="order-message-box">
                <a class="again" href="<?php echo DOMAIN?>"><?php echo Yii::t('orderflow','继续购买')?></a>
                    <a class="check" href="<?php echo $this->createUrl('member/order/newDetail',array('code'=>$model->code))?>"><?php echo Yii::t('ordeflow','查看订单')?></a>
            </div>
        </div>
    </div>
</div>
<!-- 主体end -->