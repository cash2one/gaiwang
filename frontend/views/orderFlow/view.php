<?php
/* @var $this OrderFlowController */
/** @var $cart array */
$seting = array();
$rate   = $redPrice = $buyNum = $buyPrice = 0;
?>
<!--------------------------主体---------------------------------->

<div class="main clearfix">
    <div class="main">

        <span class="shopFlowPic_1"></span>

        <div class="shopstate">
            <span class="shopFlowText"><?php echo Yii::t('orderFlow', '购物车状态'); ?>：</span>
            <?php $goodsNum = $cart['goodsCount'];?>
            <span class="shopstateBox fl">
                <a href="#" class="shopstateBg cartStatusPic"
                   style="width:<?php echo $goodsNum / ShopCart::MAX_NUM_LIMIT * 100 ?>%;"></a>
            </span>&nbsp;&nbsp;
            <span class="cartStatusTxt"><?php echo $goodsNum ?>/<?php echo ShopCart::MAX_NUM_LIMIT ?></span>
        </div>
        <div class="clearfix">
            <?php echo CHtml::link(Yii::t('orderFlow', '使用帮助'), $this->createAbsoluteUrl('/help'), array('class' => 'shophelpTip', 'title' => Yii::t('orderFlow', '使用帮助'), 'target' => '_blank'))
            ?>
        </div>

        <div class="shopOrderlt">
            <?php echo CHtml::form('/orderFlow/verify') ?>
            <!--订单详情抬头-->
            <table width="1200" border="0" cellspacing="0" cellpadding="0" class="shopFlowtitleTb">
                <tr>
                    <td width="81" align="center" valign="middle">
                        <input type="checkbox" name="checkbox" checked value="checkbox" onclick="selectAll(this)"/>
                        <?php echo Yii::t('orderFlow', '全选'); ?>
                    </td>
                    <td width="415" align="center" valign="middle"><?php echo Yii::t('orderFlow', '商品'); ?></td>
                    <td width="118" align="center" valign="middle"><?php echo Yii::t('orderFlow', '单价(元)'); ?></td>
                    <td width="176" align="center" valign="middle"><?php echo Yii::t('orderFlow', '数量'); ?></td>
                    <td width="101" align="center" valign="middle"><?php echo Yii::t('orderFlow', '优惠'); ?></td>
                    <td width="101" align="center" valign="middle"><?php echo Yii::t('orderFlow', '小计(元)'); ?></td>
                    <td width="105" align="center" valign="middle"><?php echo Yii::t('orderFlow', '操作'); ?></td>
                </tr>
            </table>

            <!--订单按商家所属1分类-->
            <?php if (!empty($cart['cartInfo'])): ?>
                <?php foreach ($cart['cartInfo'] as $k => $v): ?>
                    <span class="businessTip">
                        <input checked="checked" type="checkbox" value="" onclick="selectGroup(this, 'grp<?php echo $k; ?>');" />
                        <span class="shBspic">
                            <?php echo Yii::t('orderFlow', '商家'); ?>：<?php echo $v['storeName'] ?>
                        </span>
                    </span>
                    <table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" class="shOrderTb">
                        <?php
						$nowTime = time();
						$userId  = YII::App()->getUser()->id;
                        foreach ($v['goods'] as $key => $val):
						    $seting   = ActivityData::getActivityRulesSeting($val['seckill_seting_id']);
							$relation = ActivityData::getActivityProductRelation($val['goods_id']);
                            $val['price'] = Common::rateConvert($val['price']);
							$redPrice     = $quantity = 0;
							$buyNum      += $val['quantity'];
							$buyPrice    += $val['quantity']*$val['price'];
							$redRS = $fastive = array();
							if($val['seckill_seting_id']>0 && !empty($seting) && $seting['category_id']==1 && strtotime($seting['end_dateline'])>=$nowTime  && $relation!=false){//红包商品特殊处理
								$redPrice = number_format($val['oldPrice']*$seting['discount_rate']/100, 2, '.', '');
								$redRS    = ActivityTag::checkCreateRedOrder($userId, $val['goods_id'], $val['seckill_seting_id']);
								$quantity = !empty($redRS) ? $redRS['quantity'] : 0;
							}
							
							if($val['seckill_seting_id']>0 && !empty($seting) && $seting['category_id']==2 && strtotime($seting['end_dateline'])>=$nowTime  && $relation!=false){//应节商品特殊处理
								$fastive  = ActivityTag::checkFestiveActivity($userId, $val['goods_id'], $val['seckill_seting_id']);
								$quantity = !empty($fastive) ? $fastive['quantity'] : 0;
							}
                            ?>
                            <tr id="order_item_<?php echo $val['goods_id']; ?>_<?php echo $val['spec_id']; ?>">
                                <td width="53" align="center">
                                    <?php if ($val['status'] == Goods::STATUS_PASS && $val['is_publish'] == Goods::PUBLISH_YES && $val['life'] == Goods::LIFE_NO && $val['stock'] > 0){ 
										echo CHtml::checkBox('goods_select[]', true, array(
											'class' => 'che',
											'value' => $val['goods_id'] . '-' . $val['spec_id'],
											'id' => 'grp' . $k,
											'data-id' => 'grp' . $k,
											'for' => 'sel_good',
											'onclick' => 'selectGoods()',
										));
									}else{
										 echo Yii::t('orderFlow', '已失效'); 
									}?>
                                </td>
                                <td width="68">
                                    <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $val['thumbnail'], 'c_fill,h_54,w_54'), $val['name'], array('width' => '54', 'height' => '54')) ?>
                                </td>
                                <td width="380" align="left">
                                    <p class="shNameTxt">
                                        <?php echo CHtml::link($val['name'], array('goods/view', 'id' => $val['goods_id']), array('target' => '_blank')) ?>
                                        <span class="spec"><?php echo $val['spec'] ?></span>
                                    </p>
                                </td>
                                <td width="112" align="center" valign="middle">
                                    <?php echo HtmlHelper::formatPrice(''); ?>
                                    <font id="price_<?php echo $val['spec_id']; ?>" for='price'>
                                        <?php echo $val['price']; ?>
                                    </font>
                                    <?php if($redPrice){
										echo '<br/> <font color="#FF0000">￥ -'.$redPrice.'</font>';
								    }else if ($val['price'] != $val['oldPrice']){ ?>
                                        <br/><del><?php echo HtmlHelper::formatPrice($val['oldPrice']) ?></del>
                                    <?php } ?>
                                </td>
                                <td width="181" align="center" valign="middle">
                                    <div class="addinput">
                                        <?php if($val['seckill_seting_id'] > 0 && isset($seting) && strtotime($seting['end_dateline'])>=$nowTime && $relation!=false): ?>
                                        <?php $isRedBag='yes'; ?>
                                        <?php else: ?>
                                        <?php $isRedBag='no'; ?>
                                        <?php endif; ?>
                                        <span class="downBtn">
                                            <?php
                                            echo CHtml::link('-', 'javascript:void(0)', array(
                                                'class' => 'downBtn',
                                                'onclick' => "setAmount.downBtn(
                                            '#qty_item_{$val['spec_id']}',
                                             '#price_{$val['spec_id']}',
                                             '#amount_{$val['spec_id']}',
                                             {$val['id']},
                                             {$val['stock']},
                                             {$val['goods_id']},
                                             {$val['spec_id']},
                                             '{$isRedBag}'
                                             )"));
                                            ?>
                                        </span>
                                        <?php
										$bl = ($val['seckill_seting_id']>0 && isset($seting) && strtotime($seting['end_dateline'])>=$nowTime  && $relation!=false) ? ($seting['buy_limit']-$quantity) : 0;
										//$lm = $bl>0 ? ($bl-$quantity) : 0; 
                                        echo CHtml::textField('qty_item_1', $val['quantity'], array(
                                            'id' => "qty_item_{$val['spec_id']}",
                                            'class' => 'addninput',
                                            'readonly'=>$isRedBag =='yes'? 'readonly' : '',
                                            'onkeyup' => "setAmount.modify(
                                                    '#qty_item_{$val['spec_id']}',
                                                    '#price_{$val['spec_id']}',
                                                    '#amount_{$val['spec_id']}',
                                                    {$val['id']},
                                                    {$val['stock']},
                                                    {$val['goods_id']},
                                                    {$val['spec_id']},
                                                    '{$isRedBag}',
													'{$bl}'
                                                    )",
                                        ))
                                        ?>
                                        <span class="aapBtn">
                                            <?php
                                            echo CHtml::link('+', 'javascript:void(0)', array(
                                                'class' => 'aapBtn',
                                                'onclick' => "setAmount.aapBtn(
                                            '#qty_item_{$val['spec_id']}',
                                             '#price_{$val['spec_id']}',
                                             '#amount_{$val['spec_id']}',
                                             {$val['id']},
                                             {$val['stock']},
                                             {$val['goods_id']},
                                             {$val['spec_id']},
                                             '{$isRedBag}',
											 '{$bl}'
                                             )"));
                                            ?>
                                        </span>
                                    </div>
                                </td>
                                <td width="98" align="center" valign="middle">
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
                                </td>
                                <td width="101" align="center" valign="middle">
                                    <b class="red">
                                        <?php echo HtmlHelper::formatPrice(''); ?>
                                        <font id="amount_<?php echo $val['spec_id']; ?>" for="allprice"><?php echo sprintf('%0.2f', $val['quantity'] * $val['price']); ?></font>
                                    </b>
                                </td>
                                <td width="99" align="center" valign="middle">
                                    <p>
                                        <a href="javascript:void(0)" title="<?php echo Yii::t('orderFlow', '删除'); ?>"
                                           class="ft005aa0"
                                           onClick="delOne(<?php echo $val['goods_id']; ?>,<?php echo $val['spec_id']; ?>,<?php echo intval($k); ?>)"><?php echo Yii::t('orderFlow', '删除'); ?></a>
                                    </p>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                        ?>
                    </table>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="noGoodsInfo">
                    <span class="txt"><?php echo Yii::t('orderFlow', '您的购物车空空的，快去挑选商品吧！'); ?></span>
                </div>
            <?php endif; ?>
            <!--底部 begin-->


            <!--订单状态栏-->
            <span class="shFlaccountsBox clearfix">
                <span class="fl">
                    <input type="checkbox" checked class="mgright5" onclick="selectAll(this);"/>
                    <?php echo Yii::t('orderFlow', '全选'); ?>
                </span>
                <span class="fr">
                    <?php echo Yii::t('orderFlow', '已选商品{a}件合计(不含运费)', array('{a}' => '<font id="total_count">'.$buyNum.'</font>')); ?>
                    ：<b><?php echo HtmlHelper::formatPrice('') ?></b>
                    <font id="Allprice"><?php echo sprintf('%0.2f',$buyPrice);?></font>
                </span>
                <input type="submit" value="" class="shFlaccountsBtn" style="cursor: pointer;" id="shFlaccountsBtn"/>
            </span>
            <?php echo CHtml::endForm() ?>

        </div>
    </div>
</div>
<!-------主体 End------------>
<script type="text/javascript">
    $(document).ready(function () {
        //提交购物车前的检查
        $('#shFlaccountsBtn').click(function () {
            var chk = $('input[type="checkbox"]:checked');
            if (chk.length == 0) {
                alert('<?php echo Yii::t('orderFlow', '至少要选中一项商品'); ?>');
                return false;
            }
            var totalPrice=parseInt($("#Allprice").html());
            if(totalPrice>99999999){
                 alert('<?php echo Yii::t('orderFlow', '订单总额不得大于99999999'); ?>');
                 return false;
                }
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
        downBtn: function (obj, price, amount, id, stock, goods_id, spec_id,isRedBag) {
            var x = this.amount(obj, false);
            if (x >= this.min) {
                $(obj).val(x);
            } else {
                alert("<?php echo Yii::t('orderFlow', '商品数量最少为'); ?>" + this.min);
                $(obj).val(1);
                $(obj).focus();
            }
            cal(obj, price, amount);
            updateCart(goods_id, spec_id, $(obj).val());
            setTimeout('count_total_cart_and_price()', 100);
        },
        aapBtn: function (obj, price, amount, id, stock, goods_id, spec_id,isRedBag, buyLimit) {
            var x = this.amount(obj, true);
            if (x <= stock) {
                $(obj).val(x);
                //红包商品购买数量只能1个
                if(isRedBag=='yes'){
                    if(x > buyLimit && buyLimit>0){
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
            updateCart(goods_id, spec_id, $(obj).val());
            setTimeout('count_total_cart_and_price()', 100);
        },
        modify: function (obj, price, amount, id, stock, goods_id, spec_id,isRedBag, buyLimit) {

            var x = $(obj).val();
            if(!this.reg(x)){
                $(obj).val(1);
                $(obj).focus();
            }
            x = parseInt(x);
            //红包商品购买数量只能1个
            if(isRedBag=='yes'){
                if(x >=buyLimit && buyLimit>0){
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
                if(stock >=1){
                    $(obj).val(1);
                }else{
                    $(obj).val(stock);
                }
                $(obj).focus();
            }

            cal(obj, price, amount);
            updateCart(goods_id, spec_id, $(obj).val());
            setTimeout('count_total_cart_and_price()', 100);
        }

    };
    //计算总商品数 以及金额
    function count_total_cart_and_price() {
        var total_count = 0;
        var total_amount = 0;
        $(".addninput").each(function () {
            var tr = $(this).parent().parent().parent();
            if (tr.find('input[for="sel_good"]').is(":checked") == true) {
                total_count += $(this).val() * 1;
                total_amount += Number(tr.find('font[for="allprice"]').html());
            }
        });
        $(".cartStatusTxt").html($(".addninput").size() + '/' + setAmount.max);
        $(".cartStatusPic").attr('style', 'width:' + $(".addninput").size() / setAmount.max * 100 + '%;');
        //allprice
        $("#Allprice").html(total_amount.toFixed(2));
        $("#total_count").html(total_count);
    }

    /**
     * 删除购物车商品
     * @param goods_id
     * @param spec_id
     * @param store_id
     */
    function delOne(goods_id, spec_id, store_id) {
        var tr = $('#order_item_' + goods_id + '_' + spec_id);
        var table = tr.parent().parent();
        var span = table.prev();
        var tbody = tr.parent();
        $.ajax({
            url: commonVar.deleteCartUrl,
            dataType: 'jsonp',
            jsonp: "callBack",
            jsonpCallback: "jsonpCallback",
            data: {store_id: store_id, spec_id: spec_id, goods_id: goods_id},
            success: function (data) {
                if (data.done) {
                    tr.remove();//移除表格
                    if (tbody.html().length < 200) {
                        span.remove();//移除商家信息
                        table.remove();
                    }
                    $('#Allprice').html(data.amount);
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
     * @param {type} id
     * @param {type} obj
     * @returns {undefined}
     */
    function updateCart(goods_id, spec_id, quantity) {
        $.getJSON("<?php echo $this->createAbsoluteUrl("/cart/updateCart") ?>",
            {goods_id: goods_id, spec_id: spec_id, quantity: quantity},
            function (data) {
                if (data.done) {
                    $('#Allprice').html(data.allprice);
                }
            })
    }
</script>
