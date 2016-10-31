<?php
/* @var $this Controller */
?>
<div class="main clearfix">
    <!--------------------------主体-------------------------->
    <div class="main">
        <span class="shopFlowPic_4"></span>
        <div class="shopFlGgbox">
            <?php if ($status) { ?>  
                <div class="shopFlsucessBox">
                    <span class="shopflsucessIcon"><?php echo Yii::t('orderFlow', '恭喜，您已成功付款！'); ?></span>
                    <p><b>·</b><span><?php echo Yii::t('orderFlow', '付款金额'); ?>：<font class="red"> <?php echo $payAccount; ?><?php echo Yii::t('orderFlow', '积分'); ?></font></span></p>
                    <p><b>·</b><span><?php echo Yii::t('orderFlow', '您的订单商品将会在 2个工作日内发货， 7个工作日内收货，请耐心等待！'); ?></span></p>
                    <p class="curr"><b>·</b>
                        <!--<a href="#" title="查看订单详情"></a>-->
                        <?php echo CHtml::link(Yii::t('orderFlow', '查看订单详情'), $this->createAbsoluteUrl('/member/order/admin'), array('title' => Yii::t('orderFlow', '查看订单详情'))) ?>
                    </p>
     <!--               <p>
                        <b>·</b><span>把该宝贝推荐分享到：</span><a href="#" class="shopFlshareIcon_1" title="分享到微信"></a><a href="#" class="shopFlshareIcon_2" title="分享到新浪微博"></a>
                        <a href="#" class="shopFlshareIcon_3" title="分享到人人网"></a><a href="#" class="shopFlshareIcon_4" title="分享到开心网"></a><a href="#" class="shopFlshareIcon_5" title="分享到搜狐网"></a>
                    </p>-->
                </div>

                                                                                                            <!--<span class="shopFlsucessJf"><p><b>·</b>成功交易后将获得：盖网积分: <font><?php echo $returnScore; ?></font>个  购物经验:<span> 10</span></p></span>-->
            <?php } else { ?>

                <div class="shopFlsucessBox">
                    <span class="shopflWrongIcon"><?php echo Yii::t('orderFlow', '抱歉，您的账户余额不足！'); ?></span>
                    <p><b>·</b><?php echo Yii::t('orderFlow', '您的账户金额不足。'); ?><a href="<?php echo DOMAIN; ?>" title="<?php echo Yii::t('orderFlow', '返回盖网'); ?>" class="ft005aa0"><?php echo Yii::t('orderFlow', '(返回盖网)'); ?></a></p>
                    <p><b>·</b>
                        <?php echo Yii::t('orderFlow', '如您的账号没有可支付积分，请使用以下方式支付或{a}后支付。', array('{a}' => CHtml::link('充值积分', $this->createAbsoluteUrl('/member/recharge/index'), array('class' => 'ft005aa0')))); ?>
                    </p>
                </div>
            <?php } ?>

            <span class="shopFlsucessJf"><p>
                    <?php
                    //取客服配置
                    $fr_config = $this->getConfig('freightlink');
                    ?>
                    <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $fr_config['freightQQ']; ?>&amp;site=qq&amp;menu=yes" title="<?php echo Yii::t('orderFlow', '联系客服'); ?>" class="shopflonlinBtn"></a>
                    <?php echo Yii::t('orderFlow', '可联系盖网客服解决问题。客服电话'); ?>：
                    <font class="red"><?php echo Tool::getConfig('site','phone') ?></font>
            </span>
        </div>
        <!--        <div class="shopflhotBox">
                    <span class="shopflhotBoxTitle">
                         <h3>热卖商品</h3>
                         <span class="fr">
                             <a href="#" title="精油">精油</a> <a href="#" title="足膜">足膜</a><a href="#" title="护手"> 护手</a> <a href="#" title="香皂工具">香皂工具</a> <a href="#" title="面膜纸">面膜纸</a> 
                             <a href="#" title="化妆棉">化妆棉</a>  <a href="#" title="假睫毛">假睫毛</a>  <a href="#" title="化妆刷">化妆刷</a><a href="#" title="换一批" class="shopflhotBtn">换一批</a>
                         </span>
                      </span>  
                    <div class="shopflhotContent">
                        <span class="shopflhotBoxCt">
                            <ul>
                                <li>
                                    <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                    <p class="text"><a href="#">￥244.00</a></p>
                                    <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                                </li>
                                
                                <li>
                                    <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                    <p class="text"><a href="#">￥244.00</a></p>
                                    <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                                </li>
                                
                                <li>
                                    <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                    <p class="text"><a href="#">￥244.00</a></p>
                                    <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                                </li>
                                
                                <li>
                                    <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                    <p class="text"><a href="#">￥244.00</a></p>
                                    <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                                </li>
                                
                                <li>
                                    <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                    <p class="text"><a href="#">￥244.00</a></p>
                                    <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                                </li>
                                
                                <li>
                                    <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                    <p class="text"><a href="#">￥244.00</a></p>
                                    <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                                </li>
                                
                                <li>
                                    <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                    <p class="text"><a href="#">￥244.00</a></p>
                                    <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                                </li>
                                
                                <li>
                                    <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                    <p class="text"><a href="#">￥244.00</a></p>
                                    <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                                </li>
                                
                                <li>
                                    <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                    <p class="text"><a href="#">￥244.00</a></p>
                                    <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                                </li>
                                
                                <li>
                                    <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                    <p class="text"><a href="#">￥244.00</a></p>
                                    <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                                </li>
                                
                                <li>
                                    <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                    <p class="text"><a href="#">￥244.00</a></p>
                                    <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                                </li>
                                
                                <li>
                                    <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                    <p class="text"><a href="#">￥244.00</a></p>
                                    <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                                </li>
                            </ul>
                        </span>
                        
                        <span class="shopflhotBoxCt">
                        <ul>
                            <li>
                                <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                <p class="text"><a href="#">￥244.00</a></p>
                                <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                            </li>
                            
                            <li>
                                <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                <p class="text"><a href="#">￥244.00</a></p>
                                <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                            </li>
                            
                            <li>
                                <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                <p class="text"><a href="#">￥244.00</a></p>
                                <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                            </li>
                            
                            <li>
                                <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                <p class="text"><a href="#">￥244.00</a></p>
                                <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                            </li>
                            
                            <li>
                                <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                <p class="text"><a href="#">￥244.00</a></p>
                                <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                            </li>
                            
                            <li>
                                <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                <p class="text"><a href="#">￥244.00</a></p>
                                <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                            </li>
                            
                            <li>
                                <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                <p class="text"><a href="#">￥244.00</a></p>
                                <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                            </li>
                            
                            <li>
                                <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                <p class="text"><a href="#">￥244.00</a></p>
                                <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                            </li>
                            
                            <li>
                                <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                <p class="text"><a href="#">￥244.00</a></p>
                                <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                            </li>
                            
                            <li>
                                <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                <p class="text"><a href="#">￥244.00</a></p>
                                <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                            </li>
                            
                            <li>
                                <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                <p class="text"><a href="#">￥244.00</a></p>
                                <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                            </li>
                            
                            <li>
                                <p><a href="#" title="产品图"><img src="../images/temp/shopflhotpic.gif"  width="135" height="135"/ alt="产品图"></a></p>
                                <p class="text"><a href="#">￥244.00</a></p>
                                <p class="name"><a href="#"> 橄榄油粗粮普洱茶月饼cccccc</a></p>
                            </li>
                        </ul>
                        </span>
                    </div> 
                </div>-->
        <script type="text/javascript">
            $('.shopflhotBoxCt').imgChange({
                botPrev: '.shopflhotBtn', //上一个对象;例:botPrev:'.prev'
                botNext: '.shopflhotBtn', //下一个对象;例:botNext:'.next'
                effect: 'scroll',
                circular: true,
                visible: 1,
                vertical: false,
                steps: 1,
                speed: 1000,
                changeTime: 5000,
                easing: 'swing'
            });
        </script>
    </div>
    <!-- -----------------主体 End--------------------------->
</div>