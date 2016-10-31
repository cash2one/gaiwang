<?php
/** @var $this Controller */
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/global.css');
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/module.css');
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/cart.css');
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile($this->theme->baseUrl.'/js/layer/layer.js');
$seting = array();
$rate = $redPrice = $buyNum = $buyPrice = 0;
?>
<div class="pages-header">
    <div class="w1200">
        <div class="pages-logo">
            <a href="<?php echo DOMAIN ?>" title="<?php echo Yii::t('site', '盖象商城') ?>" class="gx-top-logo"
               id="gai_link">
                <img width="187" height="56" alt="<?php echo Yii::t('site', '盖象商城') ?>"
                     src="<?php echo $this->theme->baseUrl . '/'; ?>images/bgs/top_logo.png"/>
            </a>
        </div>
        <div class="pages-title"><?php echo Yii::t('orderFlow', '购物车'); ?></div>
        <div class="shopping-process clearfix">
            <div class="process-li icon-cart on"><?php echo Yii::t('orderFlow', '查看购物车'); ?></div>
            <span class="process-out process-out01"></span>

            <div class="process-li icon-cart"><?php echo Yii::t('orderFlow', '确认订单'); ?></div>
            <span class="process-out process-out02"></span>

            <div class="process-li icon-cart"><?php echo Yii::t('orderFlow', '支付'); ?></div>
            <span class="process-out process-out03"></span>

            <div class="process-li icon-cart"><?php echo Yii::t('orderFlow', '确认收货'); ?></div>
            <span class="process-out process-out04"></span>

            <div class="process-li icon-cart"><?php echo Yii::t('orderFlow', '完成'); ?></div>
        </div>
    </div>
</div>
<div class="shopping-cart">

    <?php if (!empty($cart['cartInfo'])): ?>
        <div class="viewCart-regret" style="display: none;"  >
            <span><i class="icon-cart"></i>抱歉，您购物车中的部分商品或者赠品暂时缺货，请结算其他商品</span>
        </div>
        <div class="viewCart" id="cartShow">
            <div class="viewCart-title">全部商品</div>
            <div class="viewCart-top">
                <div class="check">
                    <input type="checkbox" class="btn-check"  checked onclick="selectAll(this)" />
                </div>
                <div class="name">全选</div>
                <div class="price">单价（元）</div>
                <div class="quantity">数量</div>
                <div class="coupon">优惠</div>
                <div class="money">金额（元）</div>
                <div class="operating">操作</div>
            </div>
            <?php //循环显示店铺订单 ?>
            <?php echo CHtml::form($this->createAbsoluteUrl('/orderFlow/verify')) ?>
            <?php foreach ($cart['cartInfo'] as $k => $v): ?>
                <div class="viewCart-shop">
                    <div class="title clearfix">
                        <input type="checkbox" class="btn-check" value="" name=""  checked onclick="selectGroup(this, 'grp<?php echo $k; ?>');">
                        <p class="name icon-cart">店铺：<?php echo Chtml::link(Tool::truncateUtf8String($v['storeName'],10),array('shop/view','id'=>$k),array('target'=>'_blank')) ?></p>
                    </div>

                    <div class="viewCart-product">
                        <?php
                        $nowTime = time();
                        $userId = YII::App()->getUser()->id;
                        foreach ($v['goods'] as $key => $val):
                            $seting = ActivityData::getActivityRulesSeting($val['seckill_seting_id']);
                            $relation = ActivityData::getActivityProductRelation($val['goods_id']);
                            $val['price'] = Common::rateConvert($val['price']);
                            $val['oldPrice'] = Common::rateConvert($val['oldPrice']);
                            $redPrice = $quantity = 0;
                            $buyNum += $val['quantity'];
                            $buyPrice += $val['quantity'] * $val['price'];
                            $redRS = $fastive = array();
                            if ($val['seckill_seting_id'] > 0 && !empty($seting) && $seting['category_id'] == 1 && strtotime($seting['end_dateline']) >= $nowTime && $relation != false) {//红包商品特殊处理
                                $redPrice = number_format($val['oldPrice'] * $seting['discount_rate'] / 100, 2, '.', '');
                                $redRS = ActivityTag::checkCreateRedOrder($userId, $val['goods_id'], $val['seckill_seting_id']);
                                $quantity = !empty($redRS) ? $redRS['quantity'] : 0;
                            }

                            if ($val['seckill_seting_id'] > 0 && !empty($seting) && $seting['category_id'] == 2 && strtotime($seting['end_dateline']) >= $nowTime && $relation != false) {//应节商品特殊处理
                                $fastive = ActivityTag::checkFestiveActivity($userId, $val['goods_id'], $val['seckill_seting_id']);
                                $quantity = !empty($fastive) ? $fastive['quantity'] : 0;
                            }
                            ?>
                            <div class="viewCart-item clearfix"
                                 id="order_item_<?php echo $val['goods_id']; ?>_<?php echo $val['spec_id']; ?>">
                                <div class="check">
                                    <?php if ($val['status'] == Goods::STATUS_PASS && $val['is_publish'] == Goods::PUBLISH_YES && $val['life'] == Goods::LIFE_NO && $val['stock'] > 0) {
                                        echo CHtml::checkBox('goods_select[]', true, array(
                                            'class' => 'btn-check',
                                            'value' => $val['goods_id'] . '-' . $val['spec_id'],
                                            'id' => 'grp' . $k,
                                            'data-id' => 'grp' . $k,
                                            'for' => 'sel_good',
                                            'onclick' => 'selectGoods()',
                                            'data-goods_id'=>$val['goods_id'],
                                            'data-spec_id'=>$val['spec_id'],
                                            'data-store_id'=>$k,
                                        ));
                                    } else {
                                        echo '<p>', Yii::t('orderFlow', '已失效'), '</p>';
                                    } ?>
                                </div>
                                <div class="name clearfix">
                                    <div class="left">
                                        <?php
                                        $img = CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $val['thumbnail'], 'c_fill,h_96,w_88'), $val['name'], array('width' => '88', 'height' => '96'));
                                        echo CHtml::link($img, array('goods/view', 'id' => $val['goods_id']), array('target' => 'blank'));
                                        ?>

                                    </div>
                                    <div class="right">
                                        <p class="product-name"> <?php echo CHtml::link(Tool::truncateUtf8String($val['name'],20),array('goods/view', 'id' => $val['goods_id']), array('target' => 'blank')); ?></p>
                                        <p class="product-gift"><?php echo $val['spec'] ?></p>
                                        <?php if($val['jf_pay_ratio']>0 && $val['jf_pay_ratio']<100): ?>
                                        <p class="product-gift">积分+现金 商品</p>
                                        <?php endif; ?>
                                        <?php if($val['jf_pay_ratio']>100): ?>
                                            <p class="product-gift">现金 商品</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="price">
                                    <font id="price_<?php echo $val['spec_id']; ?>" for='price'>
                                        <?php echo $val['price']; ?>
                                    </font>
                                    <?php if ($redPrice) {
                                        echo '<br/> <font color="#FF0000"> -' . $redPrice . '</font>';
                                    } else if (bccomp($val['price'],$val['oldPrice'],2)!=0) {?>
                                        <br/>
                                        <del><?php echo $val['oldPrice'] ?></del>
                                    <?php } ?>
                                </div>

                                <div class="quantity">

                                    <?php if ($val['seckill_seting_id'] > 0 && isset($seting) && strtotime($seting['end_dateline']) >= $nowTime && $relation != false): ?>
                                        <?php $isRedBag = 'yes'; ?>
                                    <?php else: ?>
                                        <?php $isRedBag = 'no'; ?>
                                    <?php endif; ?>
                                    <span class="less">
                                            <?php
                                            echo CHtml::link('-', 'javascript:void(0)', array(
                                                'onclick' => "setAmount.downBtn(
                                            '#qty_item_{$val['spec_id']}',
                                             '#price_{$val['spec_id']}',
                                             '#amount_{$val['spec_id']}',
                                             {$val['id']},
                                             {$val['stock']},
                                             {$val['goods_id']},
                                             {$val['spec_id']},
                                             '{$isRedBag}',
                                             '#grp{$k}')",
                                                'style'=>'width:22px;height:22px;line-height:22px;display:block;'
                                            ));
                                            ?>
                                    </span>
                                    <span>
                                    <?php
                                    $bl = ($val['seckill_seting_id'] > 0 && isset($seting) && strtotime($seting['end_dateline']) >= $nowTime && $relation != false) ? ($seting['buy_limit'] - $quantity) : 0;
                                    //$lm = $bl>0 ? ($bl-$quantity) : 0;
                                    echo CHtml::textField('qty_item_1', $val['quantity'], array(
                                        'id' => "qty_item_{$val['spec_id']}",
                                        'class' => 'input-number',
                                        'readonly' => $isRedBag == 'yes' ? 'readonly' : '',
                                        'onkeyup' => "setAmount.modify(
                                                    '#qty_item_{$val['spec_id']}',
                                                    '#price_{$val['spec_id']}',
                                                    '#amount_{$val['spec_id']}',
                                                    {$val['id']},
                                                    {$val['stock']},
                                                    {$val['goods_id']},
                                                    {$val['spec_id']},
                                                    '{$isRedBag}',
													    '{$bl}',
                                                    '#grp{$k}')",
                                    ))
                                    ?>
                                    </span>
                                    <span class="add">
                                        <?php
                                        echo CHtml::link('+', 'javascript:;', array(
                                            'onclick' => "setAmount.aapBtn(
                                        '#qty_item_{$val['spec_id']}',
                                         '#price_{$val['spec_id']}',
                                         '#amount_{$val['spec_id']}',
                                         {$val['id']},
                                         {$val['stock']},
                                         {$val['goods_id']},
                                         {$val['spec_id']},
                                         '{$isRedBag}',
                                         '{$bl}',
                                         '#grp{$k}')",
                                            'style'=>'width:22px;height:22px;line-height:22px;display:block;'
                                            ));
                                        ?>
                                    </span>

                                </div>
                                <div class="coupon">
                                    <?php
                                    //专题活动
                                    if(isset($val['special_name'])){
                                        echo $val['special_name'];
                                        //红包活动
                                    }elseif($val['seckill_seting_id'] > 0 && isset($seting) && strtotime($seting['end_dateline'])>=$nowTime  && $relation!=false){
                                        echo !empty($seting) ? $seting['name'] : '无';
                                    }else{
                                        echo Yii::t('orderFlow', '无');
                                    }
                                    ?>
                                </div>

                                <div class="money">
                                    <span id="amount_<?php echo $val['spec_id']; ?>" for="allprice"><?php echo sprintf('%0.2f', $val['quantity'] * $val['price']); ?></span>
                                </div>

                                <div class="operating">
                                    <a href="javascript:void(0);" class="keep" name="<?php echo $val['goods_id'];?>" type ="<?php echo $val['id'];?>">移入收藏夹</a>
                                    <a href="javascript:void(0);" class="delete">删除</a>

                                    <div class="play-delete">
                                        <div class="play-top clearfix">
                                            <div class="left">
                                                提示
                                            </div>
                                            <div class="right icon-cart"></div>
                                        </div>
                                        <div class="play-message">是否删除当前商品？</div>
                                        <div class="play-box clearfix">
                                            <?php
                                            echo CHtml::link(Yii::t('orderFlow', '删除'),'javascript:void(0)',array(
                                                'class'=>'btn-delete',
                                                'onClick'=>'delOne('.$val['goods_id'].','.$val['spec_id'].','.$k.')',
                                                'id'=>'del'.$val['id'],
                                            ));
                                            ?>
                                            <a href="#none" class="btn-keep" name="<?php echo $val['goods_id'];?>" type ="<?php echo $val['id'];?>">移到我的收藏</a>
                                        </div>
                                    </div>
                                    <div class="play-keep">
                                        <div class="play-top clearfix">
                                            <div class="left">
                                                提示
                                            </div>
                                            <div class="right icon-cart"></div>
                                        </div>
                                        <div class="play-message"></div>
                                        <div class="play-box clearfix">
                                            <a href="#none" class="btn-dete">确定</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    </div>

                </div>
            <?php endforeach; ?>
            <?php echo CHtml::endForm() ?>

            <div class="viewCart-bottom clearfix">
                <div class="left">
                    <div class="check"><input type="checkbox" class="btn-check"  checked  onclick="selectAll(this)" /></div>
                    <div class="select">全选</div>
                    <div class="linka"><a href="javascript:void(0)" onclick="deleteSelected()" >删除选中的商品</a></div>
                    <div class="linka"><a href="javascript:void(0)" onclick="collectSelected()">移入收藏夹</a></div>
                </div>
                <div class="right">
                    <div class="altogether">共<span id="total_count"><?php echo $buyNum; ?></span>件商品</div>
                    <div class="price" style="width:auto">
                        总价（不含运费）：<?php echo HtmlHelper::formatPrice('') ?><span id="all_price"><?php echo sprintf('%0.2f',$buyPrice) ?></span>
                    </div>
                    <a href="#" class="btn-dete" id="shFlaccountsBtn">去结算</a>
                </div>
            </div>

        </div>
    <?php endif; ?>
    <div class="viewCart-empty" <?php echo !empty($cart['cartInfo']) ? 'style="display:none;"':"" ?>>
    <span><i class="icon-cart"></i><?php echo Yii::t('orderFlow', '购物车里空空如也，赶紧去'); ?>
        <a href="<?php echo DOMAIN ?>"><?php echo Yii::t('orderFlow', '逛逛吧'); ?>&gt;</a>
    </span>
    </div>

    <div class="viewCart" <?php echo !empty($cartHistory)?"":"style='display:none'" ?>>
        <div class="viewCart-deleted">
            <p class="title">已删除商品，您可以重新购买</p>
            <span id="insert-deleted"></span>
            <?php if(!empty($cartHistory)): ?>
            <?php foreach($cartHistory as $vc): ?>
                <div class="deleted-item clearfix">
                    <p class="picture">
                        <?php
                        $img = CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $vc['thumbnail'], 'c_fill,h_48,w_44'), '', array('width' => '44', 'height' => '48'));
                        echo CHtml::link($img, array('goods/view', 'id' => $vc['goods_id']), array('target' => 'blank'));
                        ?>
                    </p>
                    <p class="name">
                        <?php echo CHtml::link(Tool::truncateUtf8String($vc['name'],20),array('goods/view','id'=>$vc['goods_id']),array('target'=>'_blank')); ?>
                    </p>
                    <p class="price"><?php echo HtmlHelper::formatPrice($vc['price']) ?></p>
                    <p class="quantity">1</p>
                    <p class="again">
                        <?php echo CHtml::link('重新购买','javascript:void(0);',array(
                            'onclick'=>'reBuy('.$vc['goods_id'].','.$vc['spec_id'].','.$vc['store_id'].')'
                        )); ?>
                    </p>
                    <p class="keep">
                        <?php echo  CHtml::link(Yii::t('cart','移入收藏夹'),'javascript:void(0);',array(
                            'data-id'=>$vc['goods_id'],
                            'data-spec_id'=>$vc['spec_id'],
                            'data-store_id'=>$vc['store_id'],
                        )); ?>
                    </p>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>

    <div id="delTmp" style="display: none">
        <div class="deleted-item clearfix"  >
            <p class="picture"></p>
            <p class="name"></p>
            <p class="price"></p>
            <p class="quantity"></p>
            <p class="again"></p>
            <p class="keep"></p>
        </div>
    </div>

    <div class="about-product">
        <div class="title clearfix">
            <div class="left">猜你喜欢的</div>
            <div class="right icon-cart randRecord">换一批</div>
        </div>
        <div class="about-item clearfix">
            <ul class="bot-list">
                <?php foreach(Goods::getRandRecord(4) as $v): ?>
                <li>
                    <p class="img">
                        <a href="<?php echo Yii::app()->createAbsoluteUrl('/goods/view',array('id'=>$v['id'])) ?>" target="_blank" >
                            <img width="200" height="170" src="<?php echo Tool::showImg(IMG_DOMAIN.'/'.$v['thumbnail'],'c_fill,h_170,w_200') ?>">
                        </a>
                    </p>
                    <p class="name">
                        <?php echo CHtml::link(Tool::truncateUtf8String($v['name'],12),array('goods/view','id'=>$v['id'])); ?>
                    </p>
                    <p class="price"><?php echo HtmlHelper::formatPrice($v['price']) ?></p>
                    <p class="cart icon-cart" data-goods_id="<?php echo $v['id'] ?>" data-spec_id="<?php echo $v['goods_spec_id'] ?>" ></p>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

</div>
<?php echo CHtml::hiddenField('collectIds','',array('id'=>'collectIds')) ?>
<!--浮动菜单-->
<div class="pay-fd pay-fd2">
    <a href="#gx-top-title"></a>
<!--    <a href="--><?php //echo $this->createAbsoluteUrl('/help/feedback') ?><!--" title="修改意见" target="_blank"></a>-->
</div>
<script type="text/javascript">
    /*移入收藏夹str*/
    /**获取价格信息**/
    $(document).ready(function () {
        //收藏商品
        $(".viewCart-item .operating .keep,.play-delete .play-box .btn-keep").click(function () {
            var id = $(this).attr("name");
            var delid = $(this).attr("type");
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createAbsoluteUrl('/member/GoodsCollect/collect');?>',
                data: {'id': id},
                dataType: 'jsonp',
                jsonp: "jsoncallBack",
                jsonpCallback: "dealCollect",
                success: function (data) {
                    if (data['success'] == true) {
                        $(".play-keep .play-message").text('<?php echo Yii::t('orderFlow', '成功移到我的收藏!'); ?>');
                        setTimeout(function () {
                            $("#collectIds").val(id);
                            $('#del' + delid).trigger("click");
                        }, 1500);
                    } else {
                        if(data['error']){
                            alert(data['error']);
                            document.location.reload();
                        }
                        $(".play-keep .play-message").text(data['msg']);
                    }
                }
            });
        });
        //已删除商品，移入收藏
        $(".deleted-item .keep a").live('click', function () {
            var $id = $(this);
            var id = $id.attr("data-id");
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createAbsoluteUrl('/member/GoodsCollect/collect');?>',
                data: {'id': id, spec_id: $id.attr('data-spec_id'), store_id: $id.attr('data-store_id')},
                dataType: 'jsonp',
                jsonp: "jsoncallBack",
                jsonpCallback: "dealCollect",
                success: function (data) {
                    if (data['success'] == true) {
                        $id.parent().parent().remove();
                        if ($(".deleted-item .keep a:visible").length == 0) $(".viewCart-deleted").hide();
                        alert('<?php echo Yii::t('orderFlow', '成功移到我的收藏!'); ?>');
                    } else {
                        alert(data['msg']);
                    }
                }
            });
        });
    });


    //批量收藏商品
    function collectSelected() {
        var goodsList = [];
        var goodsList2 = [];
        $(".viewCart-product .btn-check").each(function () {
            var that = $(this);
            if (this.checked) {
                goodsList.push({
                    goods_id: that.attr('data-goods_id'),
                });
                goodsList2.push(that.attr('data-goods_id'));
            }
        });
        if (goodsList.length > 0) {
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createAbsoluteUrl('/member/GoodsCollect/collectSelected');?>',
                data: {'goodsData': goodsList},
                dataType: 'jsonp',
                jsonp: "jsoncallBack",
                jsonpCallback: "dealCollect",
                success: function (data) {
                    $("#collectIds").val(goodsList2.join(','));
                    deleteSelected();
                    alert(data['msg']);
                }
            });
        } else {
            alert("请选择商品");
        }
    }
    /*移入收藏夹end*/


    $(document).ready(function () {
        //是否显示：抱歉，您购物车中的部分商品或者赠品暂时缺货，请结算其他商品
        setInterval(function () {
            if ($('.viewCart-item .check p').length > 0) {
                $(".viewCart-regret").show();
            } else {
                $(".viewCart-regret").hide();
            }
        }, 1000);

        //提交购物车前的检查
        $('#shFlaccountsBtn').click(function () {
            var chk = $('.check input[type="checkbox"]:checked');
            if (chk.length == 0) {
                alert('<?php echo Yii::t('orderFlow', '至少要选中一项商品'); ?>');
                return false;
            }
            var totalPrice = parseInt($("#all_price").html());
            if (totalPrice > 99999999) {
                alert('<?php echo Yii::t('orderFlow', '订单总额不得大于99999999'); ?>');
                return false;
            }
            $(".viewCart form").submit();
        });
        setTimeout('count_total_cart_and_price()', 100);
    });
    /* reduce_add */
    var setAmount = {
        min: 1,
        max: 20,
        reg: function (x) {
            return new RegExp("^[0-9]{1,5}$").test(x);
        },
        amount: function (obj, mode) {
            var x = $(obj).val();
            if (this.reg(x)) {
                if (mode) {
                    x++;
                } else {
                    x--;
                }
            } else {
                alert("<?php echo Yii::t('orderFlow', '请输入正确的数量！'); ?>");
                $(obj).val(1);
                $(obj).focus();
            }
            return x;
        },
        downBtn: function (obj, price, amount, id, stock, goods_id, spec_id, isRedBag, checkbox) {
            var x = this.amount(obj, false);
            if (x >= this.min) {
                $(obj).val(x);
            } else {
                alert("<?php echo Yii::t('orderFlow', '商品数量最少为'); ?>" + this.min);
                $(obj).val(1);
                $(obj).focus();
            }
            cal(obj, price, amount);
            if ($(checkbox).prop('checked')) updateCart(goods_id, spec_id, $(obj).val());
            setTimeout('count_total_cart_and_price()', 100);
        },
        aapBtn: function (obj, price, amount, id, stock, goods_id, spec_id, isRedBag, buyLimit, checkbox) {
            var x = this.amount(obj, true);
            if (x <= stock) {
                $(obj).val(x);
                //红包商品购买数量只能1个
                if (isRedBag == 'yes') {
                    if (x > buyLimit && buyLimit > 0) {
                        alert('<?php echo Yii::t('orderFlow', '活动商品不能超过限制购买数量'); ?>');
                        $(obj).val(buyLimit);
                    }
                }
            } else {
                alert("<?php echo Yii::t('orderFlow', '库存数量'); ?>：" + stock + "，<?php echo Yii::t('orderFlow', '您已经超出库存数量'); ?>");
                $(obj).val(stock);
                $(obj).focus();
            }
            cal(obj, price, amount);
            if ($(checkbox).prop('checked')) updateCart(goods_id, spec_id, $(obj).val());
            setTimeout('count_total_cart_and_price()', 100);
        },
        modify: function (obj, price, amount, id, stock, goods_id, spec_id, isRedBag, buyLimit, checkbox) {

            var x = $(obj).val();
            if (!this.reg(x)) {
                $(obj).val(1);
                $(obj).focus();
            }
            x = parseInt(x);
            //红包商品购买数量只能1个
            if (isRedBag == 'yes') {
                if (x >= buyLimit && buyLimit > 0) {
                    alert('<?php echo Yii::t('orderFlow', '活动商品不能超过限制购买数量'); ?>');
                    $(obj).val(buyLimit);
                    $(obj).focus();
                }
            }
            if (x < this.min) {
                alert("<?php echo Yii::t('orderFlow', '商品数量最少为'); ?>" + this.min);
                $(obj).val(1);
                $(obj).focus();
            }
            if (x > stock) {
                alert("<?php echo Yii::t('orderFlow', '库存数量'); ?>：" + stock + "，<?php echo Yii::t('orderFlow', '您已经超出库存数量'); ?>");
                if (stock >= 1) {
                    $(obj).val(1);
                } else {
                    $(obj).val(stock);
                }
                $(obj).focus();
            }
            cal(obj, price, amount);
            if ($(checkbox).prop('checked')) updateCart(goods_id, spec_id, $(obj).val());
            setTimeout('count_total_cart_and_price()', 100);
        }

    };
    //计算总商品数 以及金额
    function count_total_cart_and_price() {
        var total_count = 0;
        var total_amount = 0;
        $(".input-number").each(function () {
            var tr = $(this).parent().parent().parent();
            if (tr.find('input[for="sel_good"]').is(":checked") == true) {
                total_count += $(this).val() * 1;
                total_amount += Number(tr.find('span[for="allprice"]').html());
            }
        });
        $("#all_price").html(total_amount.toFixed(2));
        $("#total_count").html(total_count);
    }

    //删除商品后，进入历史记录显示
    function afterDel(data) {
        if (data.del) {
            $(".deleted-item:visible").remove();
            var i = 0;
            for (var x in data.del) {
                i++;
                if (i > 3) break;
                var tmp = $("#delTmp");
                var item = data.del[x];
                tmp.find(".picture").html(item.img);
                tmp.find(".name").html(item.url);
                tmp.find(".price").html(item.price);
                tmp.find(".quantity").html(item.quantity);
                tmp.find(".again").html(item.again);
                tmp.find(".keep").html(item.keep);
                $("#insert-deleted").before(tmp.html());
                $(".viewCart").show();
            }
        }
        //检查是否删除完了
        if ($(".viewCart-product").length == 0) {
            $("#cartShow").hide();
            $(".viewCart-empty").show();
        }
        if ($(".viewCart-deleted .deleted-item").length > 0) {
            $(".viewCart-deleted").show();
        }

    }
    //删除算中商品
    function deleteSelected() {
        var goodsList = [];
        $(".viewCart-product .btn-check").each(function () {
            var that = $(this);
            if (this.checked) {
                goodsList.push({
                    store_id: that.attr('data-store_id'),
                    goods_id: that.attr('data-goods_id'),
                    spec_id: that.attr('data-spec_id')
                });
            }
        });
        if (goodsList.length > 0) {
            $.ajax({
                url: "<?php echo $this->createAbsoluteUrl('cart/deleteSelected') ?>",
                dataType: 'jsonp',
                jsonp: "callBack",
                jsonpCallback: "jsonpCallback",
                data: {goodsData: goodsList, collectIds: $("#collectIds").val()},
                success: function (data) {
                    if (data.done) {
                        for (var x in goodsList) {
                            var tr = $('#order_item_' + goodsList[x].goods_id + '_' + goodsList[x].spec_id);
                            var table = tr.parent();
                            var span = table.prev();
                            var tbody = tr.parent();
                            tr.remove();//移除表格
                            if (tbody.html().length < 200) {
                                span.remove();//移除商家信息
                                table.remove();
                            }
                        }
                        afterDel(data);
                        setTimeout('count_total_cart_and_price()', 100);
                        getCartInfo();
                    } else {
                        alert(data.error);
                    }
                }
            });
        } else {
            alert("请选择商品");
        }
    }

    /**
     * 删除购物车商品
     * @param goods_id
     * @param spec_id
     * @param store_id
     */
    function delOne(goods_id, spec_id, store_id) {
        var tr = $('#order_item_' + goods_id + '_' + spec_id);
        var table = tr.parent();
        var span = table.prev();
        var tbody = tr.parent();
        $.ajax({
            url: commonVar.deleteCartUrl,
            dataType: 'jsonp',
            jsonp: "callBack",
            jsonpCallback: "jsonpCallback",
            data: {store_id: store_id, spec_id: spec_id, goods_id: goods_id, collectIds: $("#collectIds").val()},
            success: function (data) {
                if (data.done) {
                    tr.remove();//移除表格
                    if (tbody.html().length < 200) {
                        span.remove();//移除商家信息
                        table.remove();
                    }
                    $('#all_price').html(data.amount);
                    afterDel(data);
                    setTimeout('count_total_cart_and_price()', 100);
                    getCartInfo();
                } else {
                    alert(data.error);
                }
            }
        });
    }

    /**
     * 联动 总价 和  小结的价格
     * @param {type} quantity
     * @returns {undefined}
     */
    function cal(quantity, price, am) {
        var price = $(price).html();
        var quantity = $(quantity).val();
        var amount = (quantity * price).toFixed(2);
        $(am).html(amount);
    }
    /**
     * 分组全选
     * @param {type} checkbox
     * @param {type} obj
     * @returns {undefined}
     */
    function selectGroup(checkbox, obj) {
        $('input[data-id="' + obj + '"]').prop('checked', $(checkbox).prop('checked'));
        setTimeout('count_total_cart_and_price()', 100);
    }
    /**
     * 全选
     * @param {type} checkbox
     */
    function selectAll(checkbox) {
        $('input[type=checkbox]').prop('checked', $(checkbox).prop('checked'));
        setTimeout('count_total_cart_and_price()', 100);
    }

    /**
     * 选择商品联动价格
     */
    function selectGoods() {
        setTimeout('count_total_cart_and_price()', 100);
    }


    /**
     * 更新购物车数量
     * @param goods_id
     * @param spec_id
     * @param quantity
     */
    function updateCart(goods_id, spec_id, quantity) {
        $.getJSON("<?php echo $this->createAbsoluteUrl("/cart/updateCart") ?>",
            {goods_id: goods_id, spec_id: spec_id, quantity: quantity},
            function (data) {
                if (data.done) {
                    $('#all_price').html(data.allprice);
                }
            })
    }

    function reBuy(goods_id, spec_id, store_id) {
        $.getJSON("<?php echo $this->createAbsoluteUrl("/cart/reBuy") ?>",
            {goods_id: goods_id, spec_id: spec_id, store_id: store_id, quantity: 1},
            function (data) {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.error);
                }
            }
        );
    }
    //猜你喜欢，换一批
    $(".randRecord").click(function () {
        $.getJSON("<?php echo Yii::app()->createAbsoluteUrl('site/ajaxRandGoods',array('num'=>4,'img'=>'c_fill,h_170,w_200')) ?>&t="+Math.random(), [], function (data) {
            var html = '';
            if (data.length > 0) {
                for (var x in data) {
                    html += '<li>';
                    html += '<p class="img">';
                    html += '<a href="' + data[x].url + '" target="_blank">';
                    html += '<img width="200" height="170" src="' + data[x].src + '" />';
                    html += '</a>';
                    html += '</p>';
                    html += '<p class="name">';
                    html += data[x].name;
                    html += '</p>';
                    html += '<p class="price">' + data[x].price + '</p>';
                    html += '<p class="cart icon-cart" data-goods_id="' + data[x].id + '" data-spec_id="' + data[x].spec_id + '"></p>';
                    html += '</li>';
                }
                $("ul.bot-list").html(html);
            }
        });
    });
    $(".about-item p.icon-cart").live('click', function () {
        var goodsId = $(this).attr('data-goods_id');
        var specId = $(this).attr('data-spec_id');
        $.ajax({
            url: commonVar.addCartUrl,
            dataType: 'json',
            data: {quantity: 1, spec_id: specId, goods_id: goodsId},
            success: function (data) {
                if (data.error) {
                    alert(data.error);
                } else {
                    layer.alert("添加购物车成功");
                    document.location.reload();
                }
            },
            error: function (x1, x2, x3) {
                console.log(x1);
                console.log(x2);
                console.log(x3);
                alert("添加购物车失败");
            }
        });
    });
</script>