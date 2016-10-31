<?php
$token = Yii::app()->request->csrfToken;

//正则替换图片地址，做延迟加载
$goods['content'] = preg_replace('/src="(.*?)"/i', 'src="' . Yii::app()->theme->baseUrl . '/images/bgs/loading-img.gif" class="lazy" data-url="${1}"', $goods['content']);

?>

<link href="<?php echo $this->theme->baseUrl; ?>/styles/module.css" rel="stylesheet" type="text/css"/>

<!-- 商品主体start -->
<div class="gx-main">
    <div class="gx-content clearfix">
        <div class="goods-left">
            <div class="gl-prodDisplay jp-prodDisplay clearfix">
                <!--缩图开始-->
                <div class="right-extra">
                    <div>
                        <div id="preview" class="spec-preview"> <span class="jqzoom">
                                <?php if (!empty($gallery)) { ?>
                                    <img width="420" height="420"
                                         jqimg="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $gallery[0]['path'], 'c_fill,h_800,w_800'); ?>"
                                         src="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $gallery[0]['path'], 'c_fill,h_800,w_800'); ?>"/>
                                <?php } ?>
                            </span></div>
                        <div class="spec-scroll clearfix"><a class="prev"></a> <a class="next"></a>

                            <div class="items">
                                <ul class="clearfix">
                                    <?php if (!empty($gallery) && is_array($gallery)):
                                        foreach ($gallery as $v):
                                            ?>
                                            <li>
                                                <img
                                                    bimg="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $v['path'], 'c_fill,h_800,w_800'); ?>"
                                                    src="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $v['path'], 'c_fill,h_800,w_800'); ?>"
                                                    onmousemove="preview2(this);"/>
                                            </li>
                                        <?php endforeach;
                                    endif;
                                    ?>

                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <!--缩图结束-->
                <div class="gl-prodDetails jp-prodDetails">
                    <p class="pd-info1" title="<?php echo $cache['name']; ?>"><?php echo $cache['name']; ?></p>

                    <div class="pd-info3"><?php echo Yii::t('auction', '此商品正在参加'); ?> <?php echo $active['name'] ?>
                        ，<span id="remainTime"></span> <?php echo $active['message']; ?> </div>

                    <div class="jp-tx jp-tx1"><i></i>结束前提醒</div>
                    <!--<div class="jp-tx jp-tx2"><i></i>取消提醒</div>
                    <div class="jp-tx jp-tx3"><i></i>已设置提醒</div>-->


                    <dl class="pd-info4 clearfix">
                        <dt><span class="pd-info8"><?php echo Yii::t('auction', '当前价'); ?></span></dt>
                        <dd><span class="pd-info5 start_price"><?php echo HtmlHelper::formatPrice($nowPrice); ?></span>
                            &nbsp;&nbsp;<span>(<?php echo Yii::t('auction', '对应积分'); ?><?php echo HtmlHelper::priceConvertIntegral($nowPrice); ?> <?php echo Yii::t('auction', '积分'); ?>
                                )</span></dd>
                        <dt><?php echo Yii::t('auction', '起拍价'); ?></dt>
                        <dd><span class="pd-info6"><span
                                    class="jp-font2"><?php echo HtmlHelper::formatPrice($cache['start_price']); ?></span>
                        </dd>
                        <dt><?php echo Yii::t('auction', '加价幅度'); ?></dt>
                        <dd><span class="jp-font3"><?php echo HtmlHelper::formatPrice($cache['price_markup']); ?>
                                (<?php echo Yii::t('auction', '对应积分'); ?><?php echo HtmlHelper::priceConvertIntegral($cache['price_markup']); ?> <?php echo Yii::t('auction', '积分'); ?>
                                )</span></dd>
                    </dl>


                    <div class="jp-fd1">
                        <span><?php echo $auctionMens?></span>人已竞拍
                    </div>


                    <?php if ($fee == 'NO') { ?>
                        <?php echo $this->renderPartial('_freight', array('goods' => $goods)); //运费模板   ?>
                    <?php } else { ?>
                        <dl class="pd-info4 pd-info9 clearfix">
                            <dt><?php echo Yii::t('auction', '运费'); ?></dt>
                            <dd><?php if (is_array($fee)) {
                                    echo $fee[0]['name'], ' ' . HtmlHelper::formatPrice($fee[0]['fee']);
                                } else {
                                    echo $fee;
                                } ?></dd>
                        </dl>
                    <?php } ?>
                    <dl class="pd-info4 pd-info9 clearfix">
                        <dt><?php echo Yii::t('auction', '数量'); ?></dt>
                        <dd>1 <?php echo Yii::t('auction', '件'); ?></dd>
                    </dl>
                    <dl class="pd-info4 pd-info9 clearfix">
                        <dt><?php echo Yii::t('auction', '商品编号'); ?></dt>
                        <dd><?php echo $cache['goods_id']; ?></dd>
                    </dl>
                    <?php $button = $active['status'] == 3 ? Yii::t('auction', '马上出价') : ($active['status'] == 2 ? Yii::t('auction', '即将开拍') : Yii::t('auction', '竞拍结束')); ?>
                    <input type="button" value="<?php echo $button; ?>"
                           class="<?php echo $active['status'] == 3 ? 'jp-but1' : 'jp-but2' ?>">


                    <input type="button" value="设置代理价" class="jp-but3">
                    <span class="jp-help">什么是代理价？</span>

                    <!--出价-->
                    <div class="jp-offerInfo" id="cujia" style="z-index:200">
                        <div class="jp-offerInfo-title"><?php echo Yii::t('auction', '出价提示'); ?>
                            <span> (<?php echo Yii::t('auction', '出价成功，会冻结相应积分'); ?>)</span><span class="jp-cancelIco"></span></div>
                        <dl class="clearfix">
                            <dt><?php echo Yii::t('auction', '当前价'); ?></dt>
                            <dd><span
                                    class="jpo-font1 start_price"><?php echo HtmlHelper::formatPrice($nowPrice); ?></span>
                            </dd>
                        </dl>
                        <dl class="clearfix">
                            <dt><?php echo Yii::t('auction', '加价幅度'); ?></dt>
                            <dd>
                                <div class="fl"><?php echo HtmlHelper::formatPrice($cache['price_markup']); ?> &nbsp;X&nbsp;</div>
                                <div class="fl jp-cz">
                                    <span class="jp-cz-jian reduce"></span>
                                    <input type="text" id="multiple" value="1"/>
                                    <span class="jp-cz-jia plus"></span>
                                </div>
                            </dd>
                        </dl>
                        <dl class="clearfix">
                            <dt><?php echo Yii::t('auction', '您本次出价'); ?></dt>
                            <dd><span
                                    class="jpo-font2 add_price"><?php echo HtmlHelper::formatPrice($nowPrice + $cache['price_markup']); ?></span>
                                &nbsp;&nbsp;(<?php echo Yii::t('auction', '对应积分'); ?>：
                                <span
                                    class="add_credit"><?php echo HtmlHelper::priceConvertIntegral($nowPrice + $cache['price_markup']); ?></span> <?php echo Yii::t('auction', '积分'); ?>
                                )
                            </dd>
                        </dl>
                        <div class="clearfix">
                            <input type="button" value="<?php echo Yii::t('auction', '确定出价'); ?>"
                                   class="jpo-confirmBut"/>
                            <input type="button" value="<?php echo Yii::t('auction', '取消'); ?>" class="jpo-cancelBut"/>
                        </div>
                    </div>


                    <!--当前积分不够提示-->
                    <div class="jp-ts1" id="jp-ts1">
                        <div class="jp-ts-title"><?php echo Yii::t('auction', '提示'); ?><span
                                class="jp-ts-cancel"></span></div>
                        <?php echo Yii::t('auction', '您目前的积分不足，请马上充值积分再出价'); ?>
                        <div class="clearfix">
                            <a id="recharge" style="display: none;" target="_blank"
                               href="<?php echo $this->createAbsoluteUrl('/member/prepaidCard/use'); ?>"> </a>
                            <input type="button" onclick="javascript:document.getElementById('recharge').click();"
                                   value="<?php echo Yii::t('auction', '去充值'); ?>" class="jp-tsBut"/>
                            <input type="button" value="<?php echo Yii::t('auction', '取消'); ?>" class="jp-tsCancelBut"/>
                        </div>
                    </div>
                    <!--当前出价最高提示-->
                    <div class="jp-ts2" id="jp-ts2">
                        <div class="jp-ts-title"><?php echo Yii::t('auction', '提示'); ?><span
                                class="jp-ts-cancel"></span></div>
                        <?php echo Yii::t('auction', '当前您已是最高价，无须继续出价'); ?>
                        <div class="clearfix">
                            <input type="button" onclick="closeDiv('jp-ts2');"
                                   value="<?php echo Yii::t('auction', '确定'); ?>" class="jp-tsBut"/>
                        </div>
                    </div>
                    <!--没有默认地址提示-->
                    <div class="jp-ts1" id="jp-ts3" style="z-index:300;">
                        <div class="jp-ts-title"><?php echo Yii::t('auction', '提示'); ?><span class="jp-ts-cancel"></span></div>
                        <?php echo Yii::t('auction', '买家必须有默认收货地址才能参与竞拍'); ?><br/>
                        <?php echo Yii::t('auction', '您目前无任何收货地址信息，请添加地址'); ?>
                        <div class="clearfix">
                            <a id="address" style="display: none;" target="_blank"
                               href="<?php echo $this->createAbsoluteUrl('/member/address/index'); ?>"> </a>
                            <input type="button" onclick="javascript:document.getElementById('address').click();"
                                   value="<?php echo Yii::t('auction', '修改收货地址'); ?>" class="jp-tsBut"/>
                            <input type="button" value="<?php echo Yii::t('auction', '取消'); ?>" class="jp-tsCancelBut"/>
                        </div>
                    </div>
                    <!--没有默认地址提示-->
                    <div class="jp-offerInfo" id="jp-ts4" style="display: none;z-index:300;">
                        <div class="jp-ts-title"><?php echo Yii::t('auction', '提示'); ?><span class="jp-ts-cancel"></span></div>
                        <dl class="clearfix" style="padding-left: 10px; font-size: 14px; padding-bottom: 5px;">
                            <?php echo Yii::t('auction', '若您能竞拍成功，您在商城的默认收货信息将作为拍品的收货信息，即:'); ?>
                        </dl>
                        <dl class="clearfix" style="padding-left: 10px; font-size: 14px; padding-bottom: 5px;">
                            <span style="color: #ff0000;">
                            <?php if (!empty($address)) {
                                echo $address['real_name'] . ' ' . $address['province_name'] . $address['city_name'] . $address['district_name'] . $address['street'] . ', ' . $address['mobile'];
                            } ?>
                        </span>
                        </dl>
                        <dl class="clearfix" style="padding-left: 10px; font-size: 14px; padding-bottom: 5px;">
                            <?php echo Yii::t('auction', '想修改收货信息，您可在 “我的盖象 > 收货地址” 修改默认收货地址'); ?>
                        </dl>
                        <div class="clearfix">
                            <a id="address" style="display: none;" target="_blank"
                               href="<?php echo $this->createAbsoluteUrl('/member/address/index'); ?>"> </a>
                            <input type="button" onclick="javascript:document.getElementById('address').click();"
                                   value="<?php echo Yii::t('auction', '修改收货地址'); ?>" class="jp-tsBut"/>
                            <input type="button" value="<?php echo Yii::t('auction', '确定'); ?>" class="jp-tsCancelBut"/>
                        </div>
                    </div>


                    <!--帮助提示-->
                    <div class="jp-help-fl">
                        <div class="jp-offerInfo-title jp-offerInfo-title2"><?php echo Yii::t('auction', '设置代理出价'); ?><span class="jp-cancelIco"></span>
                        </div>
                        <div class="jp-helpMS">
                            <?php echo Yii::t('auction', ' 竞拍保留价是送拍机构能够接受的拍品最低成交价，买家如想赢得竞拍，则必须出一个超过保留价、并且是所有出价者中最高的价格，也是传统竞拍中一项基本的功能。在竞拍结束时，
                            如果所有的出价记录都没有达到（或超过）保留价，则该次竞拍不成立；在竞拍进行中，只要有一笔出价记录达到（或超过）保留价，则该次竞拍成立，在竞拍结束时，出价最高者将获得竞拍品。<br/>
                            与代理出价相关注意事项：<br/>
                            1 如果领先买家设置了代理出价，并且代理出价高于送拍机构设置的保留价；若竞拍结束，当前价未达保留价，系统将代领先买家出价至保留价促成成交（比如：买家A设置了500元的代理出价，
                            拍品的保留价是100元。竞拍结束时，买家A以80元的代理出价领先，但是未达保留价，则系统将代其出价到100元，以保留价促成成交）；<br/>
                            2 竞拍结束时，如果领先买家未设置代理出价，或者代理出价比保留价低，则该次竞拍不成立。<br/>'); ?>

                        </div>
                    </div>

                    <!--设置代理出价弹出框-->
                    <div class="jp-setOffer" id="jp-setOffer1" style="z-index:200;">
                        <div class="jp-offerInfo-title jp-offerInfo-title2"><?php echo Yii::t('auction', '设置代理出价'); ?><span class="jp-cancelIco"></span>
                        </div>
                        <div class="jp-so-font1">代理出价请设置一个您可接受的最高金额：不低于<span>￥<?php echo $minimumPrice; ?></span>，当前价为
                            <span><?php echo HtmlHelper::formatPrice($nowPrice); ?></span></div>
                        <div class="jp-so-nr">
                            <span class="jp-so-font2"><?php echo Yii::t('auction', '￥'); ?></span>
                            <input type="text" value="" class="jp-so-inp1"/>
                            <span class="jp-so-font3"><?php echo Yii::t('auction', '(对应积分：0积分)'); ?></span>
                        </div>
                        <div class="jp-so-font4" style="display: none;">
                            <?php echo Yii::t('auction', '提示：您目前的积分不足，请'); ?> <a
                                href="<?php echo $this->createAbsoluteUrl('/member/prepaidCard/use'); ?>"><?php echo Yii::t('auction', '马上充值'); ?></a><?php echo Yii::t('auction', '积分再设置'); ?>
                        </div>
                        <div class="jp-so-font4">
                            <div class="jp-r-font4">
                                <input type="checkbox" id="message" <?php echo $agentData['send_message']? "checked='checked'":"";?>/><?php echo Yii::t('auction', '盖象商城站内消息'); ?>
                            </div>
                            <div class="jp-r-font4">
                                <input type="checkbox" value="<?php echo $sendMobile;?>" id="mobile" <?php echo !empty($agentData['send_mobile'])? "checked='checked'":"";?>/>手机短信：<?php echo $sendMobile;?>
                            </div>
                        </div>
                        <input type="button" value="<?php echo Yii::t('auction', '确定'); ?>" class="jp-so-but1">

                        <div class="jp-so-font5"><?php echo Yii::t('auction', '【注意事项】<br/>
                            1）代理价一旦设置不能下调或取消； 2）确认后系统将以最小加价幅度代您出价； 3）若竞拍结束，当前价未达保留价，且您的代理出价高于保留价，系统将代您出价至保留价促成成交；
                            4）首次代理出价需不低于当前价两个加价幅度；5）再次代理出价需不低于上次代理出价两个加价幅度；6）为避免中途停止出价，设置代理价后，请保证您的账户积分不低于代理价。<br/>'); ?>
                        </div>
                    </div>
                    <div class="jp-setOffer" id="jp-setOffer2" style="z-index:200;">
                        <div class="jp-offerInfo-title jp-offerInfo-title2"><?php echo Yii::t('auction', '设置代理出价'); ?><span class="jp-cancelIco"></span></div>
                        <div class="jp-so2-font1"><?php echo Yii::t('auction', '设置成功'); ?></div>
                        <div class="jp-so2-font2"><?php echo Yii::t('auction', '我的代理价：'); ?><span id="a-price">￥11.088</span></div>
                        <div class="jp-so2-font3">(对应积分：12345积分)</div>
                        <input type="button" value="<?php echo Yii::t('auction', '确定'); ?>" class="jp-so-but2">

                        <div class="jp-so2-font4"><?php echo Yii::t('auction', '确定'); ?><?php echo Yii::t('auction', '【提示】为避免出现中途停止出价，设置代理价后，请保证您的账户积分不低于代理价。'); ?></div>
                    </div>
                    <div class="jp-setOffer" id="jp-setOffer3" style="z-index:200;">
                        <div class="jp-offerInfo-title jp-offerInfo-title2"><?php echo Yii::t('auction', '设置代理出价'); ?><span class="jp-cancelIco"></span></div>
                        <div class="jp-so3-font1"><?php echo Yii::t('auction', '已被其他用户的代理出价超越'); ?></div>
                        <div class="jp-so2-font2"><?php echo Yii::t('auction', '我的代理价：'); ?><span>￥ <?php echo !empty($aboveData['agent_price'])?$aboveData['agent_price']:"0";?></span></div>
                        <div class="jp-so2-font3">(对应积分：<?php echo !empty($aboveData['integral'])?$aboveData['integral']:"0";?>积分)</div>
                        <input type="button" value="<?php echo Yii::t('auction', '前去出价'); ?>" class="jp-so-but3">
                        <input type="button" value="<?php echo Yii::t('auction', '重设代理价'); ?>" class="jp-so-but4">

                        <div class="jp-so2-font4"><?php echo Yii::t('auction', '【提示】您可以直接去出价，或者重新设置一个更高的您可接受的代理出价金额。'); ?></div>
                    </div>

                    <div class="jp-remind" style="z-index:200;">
                        <div class="jp-offerInfo-title jp-offerInfo-title2"><?php echo Yii::t('auction','提醒设置');?><span class="jp-cancelIco"></span></div>
                        <div class="jp-r-font1"><?php echo Yii::t('auction','提醒时间');?></div>
                        <div class="jp-r-center">
                            <div class="jp-r-font2"><?php echo Yii::t('auction','结束前20分钟');?>（即 <?php echo date("Y-m-d H:i:s",strtotime($auctionEvery["end_time"])-60*20);?> ）</div>
                            <div class="jp-r-font3">
                                <input type="checkbox" name="send_mobile"  id="send_mobile" value="<?php echo $mobile['mobile']; ?>" <?php if(!empty($auctionRemain["send_mobile"])) echo("checked=checked");?> /><?php echo YII::t('auction','手机短信');?>：<?php if(empty($auctionRemain["send_mobile"])):?><?php echo $mobile["mobile"] ;?><?php else:?><?php echo $auctionRemain["send_mobile"];?><?php endif ?><?php if(empty($userId)) :?><?php echo Yii::t('auction','暂无');?><?php endif ?><?php if(!empty($userId)) :?><span class="jp-r-modify jp-r-but4"><?php echo Yii::t('auction','修改');?></span><?php endif ?>
                            </div>
                            <table class="jp-r-tab">
                                <tr>
                                    <td><?php echo Yii::t('auction','手机号码');?>：</td>
                                    <td><input type="text" name="new_mobile" value="" id="new_mobile"/></td>
                                </tr>
                                <tr>
                                    <td><?php echo Yii::t('auction','验证码');?>：</td>
                                    <td>
                                        <input type="text" name="mobileVerifyCode" value="" id="mobileVerifyCode"/>
                                        <input id="sendMobileCode2" type="button" class="jp-r-ts" value="<?php echo Yii::t('auction', '获取短信验证码'); ?>" />
                                    </td>
                                </tr>
                            </table>
                            <div class="jp-r-font4">
                                <input type="checkbox" name="send_message" id="send_message" value="" <?php if(($auctionRemain["send_message"])==1) echo("checked=checked");?> /><?php echo Yii::t('auction','盖象商城站内消息');?>
                            </div>

                            <?php if(empty($auctionRemain["rules_setting_id"]) && empty($auctionRemain["goods_id"]) && empty($auctionRemain["member_id"]) && $auctionEvery["end_time"] >date('Y-m-d H:i:s',time())) :?><!--添加提醒设置-->
                            <input type="button" value="确定" class="jp-r-but jp-r-but1">
                            <?php endif ?>

                            <?php if(!empty($auctionRemain["rules_setting_id"]) && !empty($auctionRemain["goods_id"]) && !empty($auctionRemain["member_id"]) && $auctionEvery["end_time"] >date('Y-m-d H:i:s',time())) :?><!--修改提醒设置-->
                        <input type="button" value="确定" class="jp-r-but jp-r-but3">
                        <?php endif ?>

                            <input type="button" value="取消" class="jp-r-but jp-r-but2">
                        </div>
                    </div>


                </div>
            </div>
            <div class="gl-main">
                <div class="jp-show">
                    <div class="jp-prompt">
                        <img src="<?php echo $this->theme->baseUrl . '/'; ?>/images/bgs/jp_title.jpg"/>

                        <div class="jp-prompt-info">
                            <p><?php echo Yii::t('auction', '竞拍须知'); ?></p>
                            1、<?php echo Yii::t('auction', '每次出价后，系统冻结买家的出价（对应积分）。当其他买家出更高价格时，积分解冻并返还到买家的账户，此时买家可继续出价竞拍；'); ?>
                            <br/>
                            2、<?php echo Yii::t('auction', '成功竞拍后，买家的拍品收货地址为商城的默认收货地址。想更改地址，可在 "我的盖象 > 收货地址" 选择其它地址作为默认地址；无收货地址的，必须新建收货地址才能进行拍卖；') ?>
                            <br/>
                            3、<?php echo Yii::t('auction', '成功竞拍后，买家务必在72小时内在 “我的盖象 > 我的竞拍 > 我的竞拍订单” 内进行付款，否则系统会自动关闭交易，对应的冻结积分会自动划扣到平台，用于赔付送拍机构；'); ?>
                            <br/>
                            4、<?php echo Yii::t('auction', '成功竞拍并支付货款后，拍品的所有后续服务（包括收货、退换货等），将按盖象商城普通商品既定的服务规则进行处理；'); ?>
                            <br/>
                            5、<?php echo Yii::t('auction', '所有竞拍记录以及对应的操作提示，可在 " 我的盖象 > 我的竞拍 > 我的竞拍记录 " 查阅。'); ?><br/>
                        </div>
                    </div>
                    <div class="jp-details">
                        <div class="jp-details-nav">
                            <ul class="clearfix">
                                <li class="liSel" tag="1"
                                    id="productDiscription"><?php echo Yii::t('auction', '拍品描述'); ?></li>
                                <li tag="2" id="auctionRecord"><?php echo Yii::t('auction', '出价记录'); ?></li>
                            </ul>
                        </div>
                        <div class="jp-details-center">
                            <div class="jp-details-show jp-details1">
                                <div class="pd-info">
                                    <div class="pd-info-mane"><span class="pd-font1"><?php echo Yii::t('auction', '品牌名称'); ?>: </span><?php echo $goods['bname']; ?></div>
                                    <?php if (!empty($goods['attribute'])): ?>

                                        <?php foreach ((array)$goods['attribute'] as $k => $attr): ?>
                                            <span class="pd-font1"><?php echo $attr['name'] ?>：</span> &nbsp;&nbsp;<span class="pd-font1"><?php echo isset($attr['value']) ? $attr['value'] : null; ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </div>
                                <div class="pd-imgShow">
                                    <?php echo Yii::app()->getController()->delSlashes($goods['content']); ?>
                                </div>
                            </div>
                            <div class="jp-details-show jp-details2" id="recordTab">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="goods-right">
            <div class="jp-right-title"><?php echo Yii::t('auction', '竞拍人数') . '<span style="color: #F00"> ' . $auctionMens . ' </span>' . Yii::t('auction', '人'); ?></div>
            <table class="jp-right-tab">
                <tr>
                    <td colspan="3"><?php echo Yii::t('auction', '出价记录') . "(" . $count . ")"; ?></td>
                </tr>
                <tr>
                    <th><?php echo Yii::t('auction', '状态'); ?></th>
                    <th><?php echo Yii::t('auction', '竞拍人'); ?></th>
                    <th><?php echo Yii::t('auction', '价格'); ?></th>
                <tr>
            </table>
            <table class="jp-right-tab" id="recordTable">
                <?php if (!empty($auctionRecord)) {
                    foreach ($auctionRecord as $v) {
                        ?>
                        <?php if ($v['status'] == 1) { ?>
                            <tr class="color000">
                                <td><span class="jp-state1"><?php echo Yii::t('auction', '领先'); ?></span></td>
                                <td><?php echo $v['gw']; ?></td>
                                <td><?php echo HtmlHelper::formatPrice($v['balance']); ?></td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td><span class="jp-state2"><?php echo Yii::t('auction', '出局'); ?></span></td>
                                <td><?php echo $v['gw']; ?></td>
                                <td><?php echo HtmlHelper::formatPrice($v['balance']); ?></td>
                            </tr>
                        <?php } ?>
                    <?php }
                } else { ?>
                    <tr>
                        <td><?php echo Yii::t('auction', '无出价记录'); ?></td>
                    </tr>
                <?php } ?>
            </table>
            <?php if (!empty($auctionRecord)) { ?>
                <a href="javascript:void(0);" class="gr-renovateBut jp-renovateBut" id="findMore"><?php echo Yii::t('auction', '查看更多'); ?></a>
            <?php } ?>
        </div>
    </div>
</div>

<div class="prompt-float">
    <div class="prompt-float-content">
        <div class="prompt-float-title">
            <?php echo Yii::t('auction', '提示'); ?>
            <span class="prompt-float-close"></span>
        </div>
        <span class="prompt-info2" id="span_url" data-url=""></span>
        <input type="button" onclick="closeDiv('prompt-float');" value="<?php echo Yii::t('auction', '确定'); ?>"
               class="prompt-float-but"/>
    </div>
</div>

<!-- 商品主体end -->
<?php echo $this->renderPartial('/layouts/_sendMobileCodeJs'); ?>
<script src="<?php echo $this->theme->baseUrl . '/'; ?>js/jquery.jqzoom.js"></script>

<script type="text/javascript">
    var remainTime = "<?php echo $active['remainTime'];?>";
    var leaveTime = "<?php echo $active['remainTime'];?>";
    var limit = <?php echo $limit;?>;
    var markup = <?php echo $cache['price_markup'];?>;
    var startPrice = '<?php echo $nowPrice;?>';
    var flash = 0;
    var isFirst = <?php echo $isFirst;?>;
    var isAbove = <?php echo !empty($aboveData['is_above'])?($aboveData['is_above']):0;?>;

    if(isAbove==1){
        $('#jp-setOffer3').show();
    }
    if(isAbove==2){
        $('.jp-so3-font1').html("用户当前账户积分不够支出所设置的代理价格");
        $('#jp-setOffer3').show();
    }
    if(isAbove==3){
        $('.jp-so3-font1').html("出价未达到保留价，本次竞拍不成立");
        $('.jp-so-but3').remove();
        $('.jp-so-but4').remove();
        $('#jp-setOffer3').show();
    }

    function ajaxOutPrice() {
        var rsid = '<?php echo $cache['rules_setting_id'];?>';
        var gid = '<?php echo $cache['goods_id']?>';
        var price = '<?php echo $nowPrice;?>';//multiple*markup+startPrice;
        if (rsid < 0 || gid < 0 || price < 0) return false;
        $.ajax({
            'url': '<?php echo str_replace('.html', '', $this->createAbsoluteUrl('auctionAgentPrice/ajaxOutPrice'));?>',
            'dataType': 'json',
            'type': 'post',
            'cache': false,
            'data': {
                'rsid': rsid,
                'goods_id': gid,
                'price': price,
                'YII_CSRF_TOKEN': '<?php echo $token;?>'
            },
            'error': function ($e) {
            },
            'success': function (data) {
                if (data.success == true) {
                    $('.prompt-info2').html(data.message);
                    $(".prompt-float").show();
                    flash = 1;
                }else{
                    $("#jp-setOffer1").show();
                    $("#jp-setOffer2").hide();
                    $("#jp-setOffer3").hide();
                }

            }
        });
    }
    /*加价功能*/
    function setAuction() {
        var rsid = '<?php echo $cache['rules_setting_id'];?>';
        var gid = '<?php echo $cache['goods_id']?>';
        var multiple = parseInt($('#multiple').val());
        var price = '<?php echo $nowPrice;?>';//multiple*markup+startPrice;

        if (rsid < 0 || gid < 0 || multiple < 1 || price < 0) return false;

        $.ajax({
            'url': '<?php echo str_replace('.html', '', $this->createAbsoluteUrl('auction/setAuctionRecord'));?>',
            'dataType': 'json',
            'type': 'post',
            'cache': false,
            'data': {
                'rsid': rsid,
                'goods_id': gid,
                'multiple': multiple,
                'price': price,
                'YII_CSRF_TOKEN': '<?php echo $token;?>'
            },
            'error': function ($e) {
            },
            'success': function (data) {
                $('.jp-offerInfo').hide();
                if (data.change == 2) {
                    $('#jp-ts1').show();
                } else if (data.change == 3) {
                    $('#jp-ts2').show();
                } else if (data.change == 4) {
                    $('#jp-ts3').show();
                } else {
                    $('.prompt-info2').html(data.message);
                    $(".prompt-float").show();
                }

                if (data.url != '') {
                    $('#span_url').attr('data-url', data.url);
                } else {
                    $('#span_url').attr('data-url', '');
                }

                if (data.success == true && data.change == 1) {
                    flash = 1;
                }
            }
        });
    }


    /*加价功能*/
    function setAgentPrice() {
        var rsid = '<?php echo $cache['rules_setting_id'];?>';
        var gid = '<?php echo $cache['goods_id']?>';
        var agent_price = parseInt($('.jp-so-inp1').val());
        var price = '<?php echo $nowPrice;?>';
        if($('#message').is(':checked')){
            $("#message").prop("checked",true);
            var send_message = 1;
        }else{
            var send_message = 0;
        }
        if($('#mobile').is(':checked')){
            $("#mobile").prop("checked",true);
            var send_mobile = $('#mobile').val();
        }else{
            var send_mobile = "";
        }


        if (rsid < 0 || gid < 0) return false;
        $.ajax({
            'url': '<?php echo str_replace('.html', '', $this->createAbsoluteUrl('auctionAgentPrice/setAuctionAgentPrice'));?>',
            'dataType': 'json',
            'type': 'post',
            'cache': false,
            'data': {
                'rsid': rsid,
                'goods_id': gid,
                'agent_price': agent_price,
                'send_message': send_message,
                'send_mobile':send_mobile,
                'price': price,
                'YII_CSRF_TOKEN': '<?php echo $token;?>'
            },
            'error': function ($e) {
            },
            'success': function (data) {

                $('.jp-offerInfo').hide();
                if (data.change == 2) {
                    $('.jp-so-font4').show();//积分余额不足 //调用url
                } else if (data.change == 3) {
                    $('#jp-ts2').show();//当前您已是最高价,无须继续出价
                } else if (data.change == 4) {
                    $('#jp-ts3').show();//设置默认收货地址再进行拍卖 //调用url
                }else if (data.change == 5) {
                    $("#jp-setOffer2>.jp-so2-font2").html("我的代理价：￥" + data.agent_price);
                    $("#jp-setOffer2>.jp-so2-font3").html("(对应积分：" + data.integration + "积分)");
                    $("#jp-setOffer1").hide();
                    $("#jp-setOffer2").show();
                }else {
                    $('.prompt-info2').html(data.message); //是否登录
                    $(".prompt-float").show();
                }

                if (data.url != '') {
                    $('#span_url').attr('data-url', data.url);//是否登录
                } else {
                    $('#span_url').attr('data-url', '');
                }
                if (data.success == true && data.change == 1) {
                    flash = 1;
                }
            }
        });
    }
    //超越后重设出价显示
    $('.jp-so-but3').click(function (){
        $("#jp-setOffer3").hide();
        $("#cujia").show();

    });
    //超越后重设代理出价显示
    $('.jp-so-but4').click(function (){
        ajaxOutPrice();
        $('#jp-setOffer3').hide();




    });

    function closeDiv(div) {
        if (div != '') $('.' + div).hide();
        $(".pordShareBg").hide();

        var url = $('#span_url').attr('data-url');
        if (url != '') {
            window.location.href = url;
        }
        if (flash == 1) window.location.reload();
    }

    /*出价记录tab*/
    $('#auctionRecord').click(function () {
        $.ajax({
            type: "get",
            async: false,
            timeout: 5000,
            url: "<?php echo $this->createAbsoluteUrl("/active/auction/recordList",array('setting_id'=>$cache['rules_setting_id'], 'goods_id'=>$cache['goods_id']));?>",
            error: function (request, status, error) {
                alert(request.responseText);
            },
            success: function (data) {
                $('#recordTab').html(data);
            },
            complete: function () {
                makeCenter();
            }
        });
    });

    /** 处理时间倒计时 */
    function dealTimes() {
        if (remainTime > 0) {
            $('#remainTime').html(getTimeString(remainTime));
            remainTime = remainTime - 1;
        } else {
            if (leaveTime > 0) window.location.reload();
        }
    }

    /** 把时间处理成字符串 */
    function getTimeString(t) {
        if (t > 0) {
            day = 86400;
            hour = 3600;
            minute = 60;

            d = Math.floor(t / day);
            h = Math.floor((t % day) / hour);
            m = Math.floor((t % hour) / minute);
            s = Math.floor(t % minute);

            return d + "天" + h + "时" + m + "分" + s + "秒";
        } else {
            return '0天0时0分0秒';
        }
    }

    /*处理价格积分显示*/
    function dealPriceCredit(v) {
        var price = parseFloat(v * markup) + parseFloat(startPrice);
        $.ajax({
            'url': '<?php echo $this->createAbsoluteUrl("/active/auction/formatPrice");?>',
            'type': 'post',
            'dataType': 'json',
            'cache': false,
            'data': {'price': price, 'YII_CSRF_TOKEN': '<?php echo $token;?>'},
            'error': function (e) {
            },
            'success': function (data) {
                $('.add_price').html(data.price);
                $('.add_credit').html(data.credit);
            }
        });
    }

    /*打开tab*/
    function openRecordTab() {
        $('#auctionRecord').click();
    }

    /*居中函数*/
    function makeCenter() {
        $(document).ready(function () {
            //分页居中
            var yiiPageerW = parseInt($(".yiiPageer").css("width"));
            var pageListW = parseInt($(".pageList").css("width"));
            var num2 = (pageListW - yiiPageerW) / 2;
            $(".yiiPageer").css("padding-left", num2);
        });

    }

    $(function () {
        //查看更多
        $('#findMore').click(function () {
            openRecordTab();

            var pos = $("#auctionRecord").offset().top;
            $("html,body").animate({scrollTop: pos}, 1000);
        });

        //tab切换
        $(".jp-details-nav ul li").click(function () {
            var num = $(this).attr("tag");
            $(".jp-details-nav ul li").removeClass("liSel");
            $(this).addClass("liSel");
            $(".jp-details-show").hide();
            $(".jp-details" + num).show();

        });
        //出价显示
        $(".jp-but1").click(function () {
            $("#cujia").show();
            if (parseInt(isFirst) == 1) {
                $('#jp-ts4').show();
            }
        });


        $(".jpo-cancelBut").click(function () {
            $(".jp-offerInfo").hide();
        });

        $(".jp-cancelIco").click(function () {
            $(this).parent().parent().hide();
        });

        $(".jp-r-but2").click(function () {
            $(this).parent().parent().hide();
        });

        //什么是代理价提示显示
        $(".jp-help").click(function () {
            $(".jp-help-fl").show();
        });
        //设置代理价弹出框
        $(".jp-but3").click(function () {
            ajaxOutPrice();

        });
        $(".jp-so-but1").click(function () {
            setAgentPrice();


        });
        $(".jp-so-but2").click(function () {
            $("#jp-setOffer2").hide();
            window.location.reload();
        });


        //提醒设置
        $(".jp-tx1").click(function () {
            $(".jp-remind").show();
        });
        $(".jp-r-modify").click(function () {
            $(".jp-r-tab").show();
        });

        $(".jpo-confirmBut").click(function () {
            setAuction();
        });

        $(".jp-so-inp1").blur(function () {
            setPriceConvertIntegral();
        });


        function setPriceConvertIntegral() {
            var price = $(".jp-so-inp1").val();
            $.ajax({
                'url': '<?php echo str_replace('.html', '', $this->createAbsoluteUrl('auctionAgentPrice/PriceConvertIntegral'));?>',
                'dataType': 'json',
                'type': 'post',
                'cache': false,
                'data': {'price': price, 'YII_CSRF_TOKEN': '<?php echo $token;?>'},
                'error': function ($e) {
                },
                'success': function (data) {
                    $(".jp-so-font3").html('(对应积分：' + data + '积分)');
                }
            });
        }


        $(".jp-tsCancelBut,.jp-ts-cancel").click(function () {
            $("#jp-ts1,#jp-ts2,#jp-ts3,#jp-ts4").hide();
        });

        //加减倍数
        $('.reduce,.plus').click(function () {
            var multiple = parseInt($('#multiple').val());

            if ($(this).hasClass('plus')) {
                multiple = multiple + 1;
            } else {
                multiple = multiple - 1;
            }

            if (multiple < 1) {
                $('#multiple').val(1);
            } else {
                if (limit > 0 && multiple > limit) {
                    $('#multiple').val(limit);
                } else {

                    $('#multiple').val(multiple);
                }
            }
            dealPriceCredit($('#multiple').val());
        });
        $("#multiple").keyup(function () {
            if (!this.value.match(/^[0-9]+?$/)) {
                this.value = 1;
            }
            if (parseInt(this.value) > limit && limit > 0) {
                this.value = limit;
            }
            if (parseInt(this.value) < 1) {
                this.value = 1;
            }

            dealPriceCredit(this.value);
        });
        /*.blur(function () {
         if (!this.value.match(/^[0-9]+?$/)) {
         this.value = 1;
         }
         if(parseInt(this.value) > limit && limit > 0){
         this.value = limit;
         }
         dealPriceCredit(this.value);
         }).change(function () {
         if(parseInt(this.value) > limit && limit > 0){
         this.value = limit;
         }
         dealPriceCredit(this.value);
         });*/

        //提示框关闭
        $(".prompt-float-close").click(function () {
            $(".prompt-float,.pordShareBg").hide();
        });
    })

    //---------图片放大和小图左右切换效果start
    //详情页图片放大
    function preview2(img) {
        $("#preview .jqzoom img").attr("src", $(img).attr("src"));
        $("#preview .jqzoom img").attr("jqimg", $(img).attr("bimg"));
    }

    $(function () {
        setInterval("dealTimes()", 1000);
        $(".jqzoom").jqueryzoom({xzoom: 420, yzoom: 419});
    });

    //图片预览小图移动效果,页面加载时触发
    $(function () {
        var tempLength = 0; //临时变量,当前移动的长度
        var viewNum = 5; //设置每次显示图片的个数量
        var moveNum = 1; //每次移动的数量
        var moveTime = 300; //移动速度,毫秒
        var scrollDiv = $(".spec-scroll .items ul"); //进行移动动画的容器
        var scrollItems = $(".spec-scroll .items ul li"); //移动容器里的集合
        var moveLength = scrollItems.eq(0).width() * moveNum; //计算每次移动的长度
        var countLength = (scrollItems.length - viewNum) * scrollItems.eq(0).width(); //计算总长度,总个数*单个长度

        //下一张
        $(".spec-scroll .next").bind("click", function () {
            if (tempLength < countLength) {
                if ((countLength - tempLength) > moveLength) {
                    scrollDiv.animate({left: "-=" + moveLength + "px"}, moveTime);
                    tempLength += moveLength;
                } else {
                    scrollDiv.animate({left: "-=" + (countLength - tempLength) + "px"}, moveTime);
                    tempLength += (countLength - tempLength);
                }
            }
        });
        //上一张
        $(".spec-scroll .prev").bind("click", function () {
            if (tempLength > 0) {
                if (tempLength > moveLength) {
                    scrollDiv.animate({left: "+=" + moveLength + "px"}, moveTime);
                    tempLength -= moveLength;
                } else {
                    scrollDiv.animate({left: "+=" + tempLength + "px"}, moveTime);
                    tempLength = 0;
                }
            }
        });

        LAZY.init();
        LAZY.run();
    });
    //---------------图片放大和小图左右切换效果end

    $('#recordTab').on('click', 'a', function () {
        //setInterval('makeCenter()', 100);
        $(this).load($(this).attr('href'), '', function () {
            makeCenter();
        })
    });

    //添加提醒设置
    $(".jp-tx1").click(function(){
        $(".jp-remind").show();
    });

    //修改提醒设置
    $(".jp-tx2").click(function(){
        $(".jp-remind").show();
    });

    //修改手机号码
    $(".jp-r-modify").click(function(){
        $(".jp-r-tab").show();
    });

    //引入添加提醒方法
    $(".jp-r-but1").click(function(){
        addRemind();
    });

    //引入修改提醒方法
    $(".jp-r-but3").click(function(){
        updateRemind();
    });


    /*添加提醒设置*/
    function addRemind(){
        var url = '<?php echo $this->createAbsoluteUrl("/active/auction/remainAdd");?>';

        var goods_id  = '<?php echo $cache['goods_id']?>';
        var rules_setting_id  = '<?php echo $cache['rules_setting_id']?>';
		//var time_start = '<?php echo strtotime($auctionEvery['start_time'])?>';//活动开始时间
        var time_remind = '<?php echo strtotime($auctionEvery['end_time'])?>';//活动结束时间
        var now_time = '<?php echo time()?>'; //当前时间
        var member_id = '<?php echo Yii::app()->user->id ?>';//登录用户ID
        var new_mobile = $("#new_mobile").val();
        var mobileVerifyCode = $("#mobileVerifyCode").val();


        if(!member_id){
            alert("<?php echo Yii::t('auction', '请先登录再进行操作！'); ?>");
			window.location.href="<?php echo $this->createAbsoluteUrl('/member/home/login');?>";
			return false;
        }
		
		/*if(time_start>now_time){
			alert("<?php echo Yii::t('auction', '请在活动开始后再进行设置！'); ?>");
            return false;
		}*/

        if(time_remind-20*60<now_time){//结束时间小于20分钟
            alert("<?php echo Yii::t('auction', '距离结束时间小于20分钟，无法进行设置！'); ?>");
            return false;
        }

        if($("#send_mobile").is(":checked")==false && $("#send_message").is(":checked")==false){
            alert("<?php echo Yii::t('auction', '手机短信跟站内消息不能同时为空！'); ?>");
            return false;
        }


        if(new_mobile) { //如果修改手机号码则插入新号码
            if($("#send_mobile").is(":checked")==false){
                alert("<?php echo Yii::t('auction', '请先勾选手机短信！'); ?>");
                return false;
            }else{
                var new_mobile = $("#new_mobile").val();; //插入修改号码
            }
        }

        if(!new_mobile){//如果不修改手机号码
            if($("#send_mobile").is(":checked")==false){
                var send_mobile = $("#new_mobile").val(); ;	//不勾选手机号码则插入空值
            }else{
                var send_mobile = '<?php echo $mobile['mobile']?>'; //如果不修改手机号码则插入会员号码
            }

        }


        if($("#send_message").is(":checked")) {
            var send_message = 1;
        }else{
            var send_message = 0;
        }

        if(!new_mobile){//如果不修改手机号码则插入会员号码
            $.ajax({
                'url' : url,
                'dataType' : 'json',
                'type' : 'post',
                'cache' : false,
                'data' : {'goods_id': goods_id, 'rules_setting_id': rules_setting_id,'mobileVerifyCode':mobileVerifyCode,'new_mobile': new_mobile,'send_mobile': send_mobile,'send_message': send_message, 'YII_CSRF_TOKEN': '<?php echo $token;?>'},
                'error' : function($e){},
                'success' : function(data){
                    if (data.success) {
                        alert("设置提醒成功！");
                        location.reload();
                    }else if(data.is_error1) {
                        alert("手机验证码有误，请重新获取！");
                    }else if(data.is_error3) {
                        alert("手机验证码未发送或已失效，请点击获取！");
                    }else {
                        alert("设置提醒失败！");
                    }
                }
            });
        }else{//如果修改手机号码则插入新号码
		
		    if(!mobileVerifyCode){
				alert("<?php echo Yii::t('auction', '手机验证码不能为空！'); ?>");
                return false;	
			}
            $.ajax({
                'url' : url,
                'dataType' : 'json',
                'type' : 'post',
                'cache' : false,
                'data' : {'goods_id': goods_id, 'rules_setting_id': rules_setting_id, 'mobileVerifyCode':mobileVerifyCode,'new_mobile': new_mobile,'send_mobile': send_mobile,'send_message': send_message, 'YII_CSRF_TOKEN': '<?php echo $token;?>'},
                'error' : function($e){},
                'success' : function(data){
                    if (data.success) {
                        alert("设置提醒成功！");
                        location.reload();
                    }else if(data.is_error1) {
                        alert("手机验证码有误，请重新获取！");
                    }else if(data.is_error3) {
                        alert("手机验证码未发送或已失效，请点击获取！");
                    }else {
                        alert("设置提醒失败！");
                    }
                }
            });
        }
    }

    /*修改提醒设置*/
    function updateRemind(){
        var url1 = '<?php echo $this->createAbsoluteUrl("/active/auction/remainUpdate");?>';//修改提醒设置
        var url2 = '<?php echo $this->createAbsoluteUrl("/active/auction/remainDelete");?>';//删除设置提醒
        var goods_id  = '<?php echo $cache['goods_id']?>';
        var rules_setting_id  = '<?php echo $cache['rules_setting_id']?>';
        var time_remind = '<?php echo strtotime($auctionEvery['end_time'])?>';//活动结束时间
        var now_time = '<?php echo time()?>'; //当前时间
        var member_id = '<?php echo Yii::app()->user->id ?>';//登录用户ID
        var new_mobile = $("#new_mobile").val();
        var mobileVerifyCode = $("#mobileVerifyCode").val();
		var send_phone = '<?php echo $auctionRemain['send_mobile'];?>';//remind表手机号码

        if(!member_id){
            alert("<?php echo Yii::t('auction', '请先登录再进行操作！'); ?>");
			window.location.href="<?php echo $this->createAbsoluteUrl('/member/home/login');?>";
			return false;
        }

        if(time_remind-20*60<now_time){//结束时间小于20分钟
            alert("<?php echo Yii::t('auction', '距离结束时间小于20分钟，无法进行设置！'); ?>");
            return false;
        }

        if(new_mobile) { //如果修改手机号码则插入新号码
            if($("#send_mobile").is(":checked")==false){
                alert("<?php echo Yii::t('auction', '请先勾选手机短信！'); ?>");
                return false;
            }else{
                var new_mobile = $("#new_mobile").val();; //插入修改号码
            }
        }

        if(!new_mobile){//如果不修改手机号码
            if($("#send_mobile").is(":checked")==false){
                var send_mobile = $("#new_mobile").val(); ;	//不勾选手机号码则插入空值
            }else{//勾选手机号码
				if(!send_phone){
					var send_mobile = '<?php echo $mobile['mobile'];?>'; //如果remind表send_mobile为空，则插入member表的mobile
				}else{
                    var send_mobile = '<?php echo $auctionRemain['send_mobile'];?>'; //插入remind表的send_mobile
				}
            }

        }

        if($("#send_message").is(":checked")) {
            var send_message = 1;
        }else{
            var send_message = 0;
        }

        if(goods_id < 0 || rules_setting_id < 0 ) return false;

        if($("#send_mobile").is(":checked")==false && $("#send_message").is(":checked")==false){//删除设置提醒(删除seckill_auction_remind表)
            $.ajax({
                'url' : url2,
                'dataType' : 'json',
                'type' : 'post',
                'cache' : false,
                'data' : {'goods_id': goods_id, 'rules_setting_id': rules_setting_id, 'send_mobile': send_mobile,'send_message': send_message, 'YII_CSRF_TOKEN': '<?php echo $token;?>'},
                'error' : function($e){},
                'success' : function(data){
                    if (data.success) {
                        alert("设置提醒成功！");
                        location.reload();
                    }else {
                        alert("设置提醒失败！");
                    }
                }
            });
        }else{//修改设置提醒(修改seckill_auction_remind字段send_mobile 与 send_message数据)
            if(!new_mobile){//如果不修改手机号码则插入会员号码
                $.ajax({
                    'url' : url1,
                    'dataType' : 'json',
                    'type' : 'post',
                    'cache' : false,
                    'data' : {'goods_id': goods_id, 'rules_setting_id': rules_setting_id, 'mobileVerifyCode':mobileVerifyCode,'send_mobile': send_mobile,'send_message': send_message, 'YII_CSRF_TOKEN': '<?php echo $token;?>'},
                    'error' : function($e){},
                    'success' : function(data){
                        if (data.success) {
                            alert("设置提醒成功！");
                            location.reload();
                        }else if(data.is_error1) {
                            alert("手机验证码有误，请重新获取！");
                        }else if(data.is_error3) {
                            alert("手机验证码未发送或已失效，请点击获取！");
                        }else {
                            alert("设置提醒成功！");
                            location.reload();
                        }
                    }
                });
            }else{
				
				if(!mobileVerifyCode){
				    alert("<?php echo Yii::t('auction', '手机验证码不能为空！'); ?>");
                    return false;	
			    }
                $.ajax({
                    'url' : url1,
                    'dataType' : 'json',
                    'type' : 'post',
                    'cache' : false,
                    'data' : {'goods_id': goods_id, 'rules_setting_id': rules_setting_id, 'mobileVerifyCode':mobileVerifyCode,'new_mobile': new_mobile,'send_message': send_message, 'YII_CSRF_TOKEN': '<?php echo $token;?>'},
                    'error' : function($e){},
                    'success' : function(data){
                        if (data.success) {
                            alert("设置提醒成功！");
                            location.reload();
                        }else if(data.is_error1) {
                            alert("手机验证码有误，请重新获取！");
                        }else if(data.is_error3) {
                            alert("手机验证码未发送或已失效，请点击获取！");
                        }else {
                            alert("设置提醒成功！");
                            location.reload();
                        }
                    }
                });
            }
        }
    }

    //设置提醒 修改手机号码（获取短信验证码）
    $(function() {
        sendMobileCode("#sendMobileCode2","#new_mobile");
    });


</script>