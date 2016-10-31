<?php
/** @var array $goods */
/** @var GoodsController $this */
?>
<div class="productContent">
    <h1 class="productName">
        <?php if ($goods['bname']): ?>【<?php echo $goods['bname']; ?>】<?php endif; ?>
        <?php echo array_key_exists($goods['name'], Heyue::$goodsName) ? Heyue::$goodsName[$goods['name']] : $goods['name'] ?>
        <?php if($goods['special_topic_id']): ?>
        <span>
            <?php echo CHtml::link($goods['special_name'],array('/zt/site/view','id'=>$goods['special_topic_id']),array('class'=>'red')) ?>
        </span>
        <?php endif; ?>
    </h1>

    <div class="produtDetail">
        <table class="productTable">
            <tr>
                <td width="70" class="fontsize14"><?php echo Yii::t('goods', '零售价'); ?>：</td>
                <td><strong class="fontSize34"><?php echo HtmlHelper::formatPrice($goods['price']); ?></strong></td>
            </tr>
            <tr class="colorffc5c5" style="display: none;">
                <td><?php echo Yii::t('goods', '市场价'); ?>：</td>
                <td>
                    <del><?php echo HtmlHelper::formatPrice($goods['market_price']); ?></del>
                </td>
            </tr>
            <tr>
                <td><?php echo Yii::t('goods', '换购积分'); ?>：</td>
                <td><strong
                        class="fontSize18"><?php echo HtmlHelper::priceConvertIntegral($goods['price']); ?></strong> <?php echo Yii::t('goods', '盖网积分'); ?>
                </td>
            </tr>
            <?php echo $this->renderPartial('_freight', array('goods' => $goods)); //运费模板   ?>
            <!--是否参加红包活动-->
            <?php if($goods['at_status'] ==ActivityTag::STATUS_ON && $goods['join_activity'] ==Goods::JOIN_ACTIVITY_YES && !empty($goods['activity_tag_id'])): ?>
                <tr class="redBag">
                    <td>活动支持：</td>
                    <td><?php echo $goods['at_name'] ?></td>
                </tr>
            <?php endif; ?>
        </table>
        <!--是否参加红包活动-->
        <?php if($goods['at_status'] ==ActivityTag::STATUS_ON && $goods['join_activity'] ==Goods::JOIN_ACTIVITY_YES && !empty($goods['activity_tag_id'])): ?>
		<div class="tagOfRedBag"></div>
        <?php endif; ?>
    </div>
    <div class="aboutProduct">
        <ul>
<!--            <li>
                <p class="custAccount"><?php echo $goods['sales_volume']; ?></p>

                <p><?php echo Yii::t('goods', '销量'); ?></p>
            </li>-->
            <li>
                <p class="custAccount"><?php //echo $goods['views']; ?></p>

                <p><?php echo Yii::t('goods', '浏览量'); ?></p>
            </li>
            <li>
                <p class="pointAccount"><?php //echo $goods['total_score'] && $goods['comments'] ? (sprintf('%.1f', $goods['total_score'] / $goods['comments'])) : 0; ?></p>

                <p> <?php echo Yii::t('goods', '累计评价'); ?> <span id="point_pd"
                        class="point p_d<?php //echo $goods['total_score'] && $goods['comments'] ? (sprintf('%.1f', $goods['total_score'] / $goods['comments']) * Goods::SCORE_UNIT) : 0 ?>"></span><?php //echo $goods['total_score'] && $goods['comments'] ? (sprintf('%.1f', $goods['total_score'] / $goods['comments'])) : 0; ?><?php echo Yii::t('goods', '分'); ?>
                </p>
            </li>
        </ul>
    </div>
    <!--    商品规格选择-->
    <div class="filterSpec">
        <?php foreach ($goods['spec_name'] as $k => $v): ?>
            <?php if (!isset($goods['goods_spec'][$k])) continue; ?>
            <dl class="items clearfix">
                <dt><?php echo $v ?>：</dt>
                <dd class="clearfix">
                    <ul class="clearfix">
                        <?php foreach ($goods['goods_spec'][$k] as $k2 => $v2): ?>
                            <?php if (isset($goods['spec_picture'][$k2])): ?>
                                <li class="txt sp-img">
                                    <b></b>
                                    <?php
                                    $pic = IMG_DOMAIN . '/' . $goods['spec_picture'][$k2];;
                                    echo CHtml::link('' . '<i></i>', 'javascript:void(0)', array(
                                        'title' => $v2,
                                        'style' => 'background-image:url(' . Tool::showImg($pic, 'c_fill,h_32,w_32') . ')',
                                        'data-pic' => $pic,
                                        'class' => 'goodsSpec',
                                        'data-id' => $k2,
                                        'data-name' => $v2,
                                    ));
                                    ?>
                                </li>
                            <?php else: ?>
                                <li class="txt sp-txt">
                                    <b></b>
                                    <?php echo CHtml::link($v2 . '<i></i>', 'javascript:void(0)',
                                        array(
                                            'class' => 'goodsSpec',
                                            'data-id' => $k2,
                                            'data-name' => $v2,
                                        ));
                                    ?>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </dd>
            </dl>
        <?php endforeach; ?>
    </div>

    <div class="buyAccount clearfix">
        <?php if (!ShopCart::checkHyjGoods($goods['id'])): ?>
            <span class="left"><?php echo Yii::t('goods', '数量'); ?>：
                <input type="text" value="1" style="width:59px" id="quantity"/></span>
            <div class="addAccount left"><i class="plus increase"></i><i class="minus decrease"></i></div>
        <?php endif; ?>
        <span class="left">
            <span class="ie6mgRig"><?php echo Yii::t('goods', '库存'); ?>：
                <b id="goods_stock"><?php //echo $goods['stock']; ?></b><?php echo Yii::t('goods', '件'); ?>
            </span>
            <!--<a href="#" title="" class="keepShop red">收藏该商品</a>-->
        </span>
    </div>
    <div>
        <?php if (ShopCart::checkHyjGoods($goods['id'])): ?>
            <dl class="items clearfix">
                <dt class="pageabc"> &nbsp;&nbsp;
                    <span class="left" style="margin-left:15px;">
                        <?php echo Yii::t('goods', '购买方式: '); ?>
                    </span>
                    <span class="selectedItem"
                          style="display:inline-block;margin-left: 10px;position: relative;top:-5px;">
                        <b></b>
                        <a>购机入网送话费</a>
                     </span>
                </dt>
            </dl>
        <?php endif; ?>
    </div>
    <div class="buyBtn">
        <?php
        if ($goods['stock'] > 0) {
            if (ShopCart::checkHyjGoods($goods['id'])) {
                //是否合约机
                $url = $this->createUrl('/heyueji/xuanhao', array('id' => $goods['id'],'spec_id'=>$goods['goods_spec_id']));
                echo CHtml::link(Yii::t('goods', '选择号码和套餐'), $url, array(
                    'class' => 'packageBtn buy_hyj',
                    'style' => 'position:relative;left:-10px;',
                ));
            } else if (ShopCart::checkSpecialGoods($goods) || ShopCart::checkSpecialGoods($goods['id']) || ($goods['integral_ratio'] < 100 && $goods['integral_ratio'] > 0)) {
                //是否特殊商品或者积分+现金支付商品
                echo CHtml::link(Yii::t('goods', '立即购买'), '#', array("title" => Yii::t('goods', '立即购买'),'class' => 'buyNow buy_special'));
            } else {
                echo CHtml::link(Yii::t('goods', '加入购物车'), '#', array("title" => Yii::t('goods', '加入购物车'), 'class' => 'addCart quickyBuy'));
            }
        } else {
            echo CHtml::link(Yii::t('goods', '已售完'), '#', array('class' => 'packageBtn'));
        }
        ?>
    </div>
    <div class="posRel">
        <div id="messageDlg" style="display:none" class="zindex_wrap">
            <a class="close" onclick="$('#messageDlg').hide();">X</a>

            <div id="messageDlgContent" class="messageDlgContent" style="display:block">
                <h4><?php echo Yii::t('goods', '商品已成功添加到购物车') ?>！</h4>

                <p>
                    <span><?php echo Yii::t('goods', '购物车共') ?><b id="bold_num"></b><?php echo Yii::t('goods', '种商品') ?></span>
                    <span><?php echo Yii::t('goods', '合计') ?><b class="price_mini" id="bold_price"></b></span>
                </p>
                <a id="closeCart" class="btn_03" title="<?php echo Yii::t('goods', '继续挑商品') ?>"
                   onclick="$('#messageDlg').hide();"><?php echo Yii::t('goods', '继续购物') ?></a>
                <a href="<?php echo $this->createAbsoluteUrl('/orderFlow'); ?>" class="btn_04"
                   title="<?php echo Yii::t('goods', '去购物车结算') ?>"><?php echo Yii::t('goods', '去购物车结算') ?></a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    /* spec对象,设置默认的商品规格 */
    var spec = {
        id: "<?php echo $goods['goods_spec_id'] ?>",
        price: "<?php echo $goods['price'] ?>",
        goods_id: "<?php echo $goods['id'] ?>",
        stock: "<?php echo $goods['stock'] ?>",
        store_id:"<?php echo $goods['store_id'] ?>",  //有多少类规格需要点击选择
        specType:"<?php echo count($goods['goods_spec']) ?>",  //有多少类规格需要点击选择
        goodsSpec:<?php echo json_encode($goodsSpec) ?>  //商品规格数据
    };
    /*产品图片放大*/
    $(document).ready(function ($) {
        $('#etalage').etalage({
            thumb_image_width: 418,
            thumb_image_height: 380,
            source_image_width: 800,
            source_image_height: 800,
            click_callback: function (image_anchor, instance_id) {
                alert('回调函数:\nYou clicked on an image with the anchor: "' + image_anchor + '"\n(in Etalage instance: "' + instance_id + '")');
            }
        });
        //商品规格选择
        $(".filterSpec a.goodsSpec").click(function () {
            $(".filterSpec li").removeClass("disabled");
            $(this).parents('li').addClass("curr");
            $(this).parents('li').siblings().removeClass("curr");
            //将属性中的图片，放到放大镜位置显示
            var propertyPic = $(this).attr("data-pic");
            if (propertyPic) {
                var addHtml = '<li class="etalage_thumb etalage_thumb_active after_add" ' +
                    'style="background-image: none; display: list-item; opacity: 1;">' +
                    '<img src="' + showImg(propertyPic, 'c_fill,h_380,w_400') + '" class="etalage_thumb_image"' +
                    ' style="display: inline; width: 418px; height: 380px; opacity: 1;"></li>';
                $("#etalage > li").removeClass('etalage_thumb_active');
                $("#etalage .after_add").remove();
                $("#etalage").append(addHtml);
            }
            //获取库存
            var goodsSpec = getGoodsSpec();
            if (goodsSpec) {
                $("#goods_stock").html(goodsSpec.stock);
                if (goodsSpec.stock <= 0) {
                    $(this).parents('li').removeClass("curr").addClass("disabled");
                } else {
                    spec.id = goodsSpec.id;
                    spec.stock = goodsSpec.stock;
                    spec.price = goodsSpec.price;
                }
            }
        });
        //添加到购物车
        $(".addCart").click(function(){
            if(!checkSpecSelect()) return false;
            addToCart(spec.id,parseInt($("#quantity").val()));
            return false;
        });
        //特殊商品，立即购买
        $(".buy_special").click(function(){
            if(!checkSpecSelect()) return false;
            var url = commonVar.addCartUrl;
            $.getJSON(url,
                {
                    goods_id: spec.goods_id,
                    quantity: parseInt($("#quantity").val()),
                    spec_id: spec.id,
                    store_id:spec.store_id
                }, function (data) {
                    if (data.success) {
                        window.location.href = '<?php echo $this->createAbsoluteUrl('orderFlow/single') ?>?goods_id='+spec.goods_id+'&spec_id='+spec.id;
                    } else {
                        alert(data.error);
                    }
                });
            return false;
        });
        //合约机
        $(".buy_hyj").click(function(){
            if(!checkSpecSelect()) return false;
            var url = commonVar.addCartUrl;
            $.getJSON(url,
                {
                    goods_id: spec.goods_id,
                    quantity: 1,
                    spec_id: spec.id,
                    store_id:spec.store_id
                }, function (data) {
                    if (data.success) {
                        window.location.href = '<?php echo $this->createAbsoluteUrl('heyueji/xuanhao') ?>?id='+spec.goods_id+'&spec_id='+spec.id;
                    } else {
                        alert(data.error);
                    }
                });
            return false;
        });

    });

    // 商品数量选择判断
    $('.increase').click(function () {
        var num = parseInt($('#quantity').val());
        var max = parseInt($('#goods_stock').text());
        if (num < max) {
            $('#quantity').val(num + 1);
            //红包商品购买数量只能购买1个 @author binbin.liao
            <?php if($goods['at_status'] ==ActivityTag::STATUS_ON && $goods['join_activity'] ==Goods::JOIN_ACTIVITY_YES && !empty($goods['activity_tag_id'])): ?>
            var nums = parseInt($('#quantity').val());
            if(nums >= 2){
                alert('<?php echo Yii::t('goods', '红包活动商品只能购买一件'); ?>');
                $('#quantity').val(1);
            }
            <?php endif;?>
        }
    });
    $('.decrease').click(function () {
        var num = parseInt($('#quantity').val());
        if (num > 1) {
            $('#quantity').val(num - 1);
        }
    });
    $("#quantity").keyup(function () {
        if (!this.value.match(/^[0-9]+?$/)) {
            this.value = 1;
        }
    }).blur(function () {
        if (!this.value.match(/^[0-9]+?$/)) {
            this.value = 1;
        }
    }).change(function () {
        var stock = $('#goods_stock').text();
        if (parseInt(this.value) > parseInt(stock)) {
            alert('<?php echo Yii::t('goods', '最大库存只有'); ?>' + stock + '<?php echo Yii::t('goods', '件'); ?>');
            this.value = stock;
        }
        //红包商品购买数量只能购买1个 @author binbin.liao
        <?php if($goods['at_status'] ==ActivityTag::STATUS_ON && $goods['join_activity'] ==Goods::JOIN_ACTIVITY_YES && !empty($goods['activity_tag_id'])): ?>
            if(parseInt(this.value) >=2){
                alert('<?php echo Yii::t('goods', '红包活动商品只能购买一件'); ?>');
                this.value = 1;
            }
        <?php endif;?>
    });
    /* 这个地方可能会要加ajax提交  来显示购物车购买几种商品  和总价  可以改上面的那个方法.  这下面的只是演示效果用*/
    function addToCart(spec_id, quantity) {
        var url = commonVar.addCartUrl;
        $.getJSON(url,
            {goods_id: spec.goods_id, quantity: quantity, spec_id: spec_id,store_id:spec.store_id}, function (data) {
            if (data.success) {
                $('#bold_num').html(data.num);
                $('#bold_price').html(data.price);
                $('#mian_botom_cartcount').html(data.num);//更新右下角购物车的数量
                $('#main_top_cart_count').html(data.num);//更新顶部购物车的数量
                $('#messageDlg').show('slow');
                // 头部加载购物车信息
                getCartInfo();
            } else {
                alert(data.error);
            }
        });
    }
    /**
     * 生成基于URL的图片处理 的网址
     * @param  url  图片地址
     * @param params 以逗号分隔的参数  see:http://avnpc.com/pages/evathumber
     * @returns {string}
     */
    function showImg(url, params) {
        return url.slice(0, -4) + ',' + params + url.slice(-4);
    }

    /**
     * 获取已选择规格组合的相关价格、库存、goods_spec_id数据
     */
    function getGoodsSpec() {
        //已选择的规格id
        var selectedSpecIds = [];
        $(".filterSpec li.curr a.goodsSpec").each(function () {
            selectedSpecIds.push(parseInt($(this).attr('data-id')));
        });
        for (var x in spec.goodsSpec) {
            if (!isNaN(x)) {
                var goodsSpecArray = [];
                var spec_value = spec.goodsSpec[x].spec_value;
                for (var y in spec_value) {
                    goodsSpecArray.push(parseInt(y));
                }
                if (goodsSpecArray.sort().toString() == selectedSpecIds.sort().toString()) {
                    return spec.goodsSpec[x];
                }
            }
        }
        return false;
    }
    /**
     * 检查 商品规格的选择
     * @returns {boolean}
     */
    function checkSpecSelect(){
        if($(".filterSpec li a.goodsSpec").size() > 0 && $(".filterSpec li.curr a.goodsSpec").size()!=spec.specType){
            alert("<?php echo Yii::t('goods','请选择相关规格') ?>");
            return false;
        }
        var quantity = parseInt($("#quantity").val());
        if (quantity < 1) {
            alert("<?php echo Yii::t('goods', '请填写购买数量'); ?>");
            $("#quantity").val('1');
            return false;
        }
        var max = parseInt($('#goods_stock').text());
        if (quantity > max) {
            alert("<?php echo Yii::t('goods', '您购买的商品数量，超出了该商品库存，请您重新选择商品数量'); ?>");
            return false;
        }
        return true;
    }
</script>