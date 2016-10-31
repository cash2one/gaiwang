<?php
/** @var array $goods */
/** @var GoodsController $this */
//处理活动样式
//var_dump($activityInfo);
$titleClass = '';
$buyButtonALink = '';
$buyUrl = '';
$join_activity = 0;
$time_rest_days = 0;
$time_rest_hours = 0;
$time_rest_minutes = 0;
$time_rest_seconds = 0;
if(!empty($activityInfo)){
    $join_activity = 1;
    $time_rest_days = $activityInfo['time']['days'];
    $time_rest_hours = $activityInfo['time']['hours'];
    $time_rest_minutes = $activityInfo['time']['minutes'];
    $time_rest_seconds = $activityInfo['time']['seconds'];
    //参加活动
    if ($goods['stock'] > 0) {
        if($activityInfo['status'] == 'start'){
            $titleClass = 'MX_state_title MX_state_title2';
            $buyTitle = Yii::t('goods', '敬请留意');
            $buyClass = array('class' => 'MX_state_but MX_state_but2');
        }else{
            $titleClass = 'MX_state_title';
            $buyTitle = Yii::t('goods', '加入购物车');
            $buyClass = array('class' => 'MX_state_but');
            if($activityInfo['setting']['category_id'] == 3){//秒杀
                $buyClass['id'] = 'button_add_cart_seckill';
            }else{
                $buyClass['id'] = 'button_add_cart';
            }
        }
    }else{
        $titleClass = 'MX_state_title MX_state_title3';
        $buyTitle = Yii::t('goods', '卖光了');
        $buyClass = array('class' => 'MX_state_but MX_state_but3');
    }
}else{
    //非活动
    if ($goods['stock'] > 0) {
        if (ShopCart::checkHyjGoods($goods['id'])) {
            //是否合约机
            $buyUrl = $this->createUrl('/heyueji/xuanhao', array('id' => $goods['id'],'spec_id'=>$goods['goods_spec_id']));
            $buyTitle = Yii::t('goods', '选择号码和套餐');
            $buyClass= array(
                'id'=>'button_add_cart',
                'class' => 'packageBtn buy_hyj',
                'style' => 'position:relative;left:-10px;',
            );
        } else if (ShopCart::checkSpecialGoods($goods) || ShopCart::checkSpecialGoods($goods['id']) || ($goods['integral_ratio'] < 100 && $goods['integral_ratio'] > 0)) {
            //是否特殊商品或者积分+现金支付商品

            $buyTitle = Yii::t('goods', '立即购买');
            $buyClass= array('id'=>'button_add_cart_special',"title" => $buyTitle, 'class' => 'buyNow buy_special');
        } else {
            $buyTitle = Yii::t('goods', '加入购物车');
            $buyClass= array('id'=>'button_add_cart',"title" => $buyTitle, 'class' => 'MX_state_but');
        }
    } else {
        $buyTitle = Yii::t('goods', '已售完');
        $buyClass= array('class' => 'MX_state_but MX_state_but3');
    }
}
$buyButtonALink = CHtml::link($buyTitle, $buyUrl, $buyClass);
?>
<div id="goods_content" class="MX_state MX_state2 productContent">
        <?php $goodsPrice = $goods['price'];//var_dump($activityInfo);?>
        <?php if(!empty($activityInfo)): ?>
        <?php
            if($activityInfo['setting']['category_id'] != 1)$goodsPrice = ActivityData::getActivityPrice($goods['seckill_seting_id'], $goodsPrice);
        ?>
        <div id="activity_title" class="<?php echo $titleClass;?>">
            <div class="MX_state_title_left"><?php echo $activityInfo['title'];?></div>
            <div class="MX_state_title_right"><?php echo $activityInfo['timeTips'];?></div>
            <div class="clear"></div>
        </div>
        <?php endif; ?>
        <div id="goods_price_info" class="MX_state_main">
            <div class="MX_state_main_title" title="<?php echo array_key_exists($goods['name'], Heyue::$goodsName) ? Heyue::$goodsName[$goods['name']] : $goods['name'];?>">
                <?php if ($goods['bname']): ?>【<?php echo $goods['bname']; ?>】<?php endif; ?>
                <?php echo array_key_exists($goods['name'], Heyue::$goodsName) ? Heyue::$goodsName[$goods['name']] : $goods['name'] ?>
                <?php if($goods['special_topic_id']): ?>
                <span>
                <?php echo CHtml::link($goods['special_name'],
                    array('/zt/site/view','id'=>$goods['special_topic_id']),
                    array('class'=>'red')) ?>
                </span>
                <?php endif; ?>
            </div>
            <div class="MX_state_main_info">
                <?php echo Yii::t("goods", "零售价"); ?>：
                <span id="goods_price" class="MX_state_font1">
                    <?php echo HtmlHelper::formatPrice($goodsPrice); ?>
                </span><p></p>

                <?php if (($goods['jf_pay_ratio'] < 100 && $goods['jf_pay_ratio'] > 0)): ?>
                <?php echo Yii::t("goods", "会员尊享价"); ?>：
                <span id="goods_market_price" class="MX_state_font1">
                    <?php echo HtmlHelper::formatPrice($goodsPrice*(1-$goods['jf_pay_ratio']/100)),'+',HtmlHelper::priceConvertIntegral($goodsPrice*($goods['jf_pay_ratio']/100)); ?> 积分
                </span><p></p>
                <?php else: ?>

                <?php echo Yii::t("goods", "换购积分"); ?>：
                <span id="goods_point_price" class="MX_state_font1">
                    <?php echo HtmlHelper::priceConvertIntegral($goodsPrice); ?>
                </span> <?php echo Yii::t("goods", "积分"); ?><p></p>
                <?php endif; ?>

                <span>
                    <table class="productTable">
                        <?php echo $this->renderPartial('_freight', array('goods' => $goods)); //运费模板   ?>
                    </table>
                </span><p></p>
                <?php if($join_activity == false && $goods['at_status'] ==ActivityTag::STATUS_ON
                && $goods['join_activity'] ==Goods::JOIN_ACTIVITY_YES
                && !empty($goods['activity_tag_id'])): ?>
                <span class="redBag"><?php echo Yii::t("goods", "活动支持"); ?>：<?php echo $goods['at_name'] ?></span><p></p>
                <?php endif; ?>
                <?php if($join_activity): ?>
                <?php echo Yii::t("goods", "优惠"); ?>：
                <span>
                <?php
                if($activityInfo['setting']['category_id'] == 1){
                    //echo Yii::t("goods", '支持红包抵用{0}元',array('{0}'=>bcmul($goodsPrice,bcdiv($activityInfo['setting']['discount_rate'],100,2),2)));
					echo Yii::t("goods", '支持红包抵用{0}元',array('{0}'=>number_format($goodsPrice*$activityInfo['setting']['discount_rate']/100, 2, '.', '')));
                }else{
                    if($activityInfo['setting']['discount_rate']>0){
                        echo Yii::t("goods", '已打{0}折，活动结束恢复原价',array('{0}'=>($activityInfo['setting']['discount_rate']/10)));
                    }else{
                        echo Yii::t("goods", "支持{0}元限时购",array('{0}'=>$activityInfo['setting']['discount_price']));
                    }
                } ?></span><p></p>
                <?php endif; ?>
                <?php echo Yii::t("goods", "商品编号"); ?>：
                <span><?php echo $goods['id']; ?></span><p></p>
            </div>
            <!--是否参加红包活动-->
            <?php if($goods['at_status'] ==ActivityTag::STATUS_ON && $goods['join_activity'] ==Goods::JOIN_ACTIVITY_YES && !empty($goods['activity_tag_id'])): ?>
            <div class="tagOfRedBag"></div>
            <?php endif; ?>
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
                <b id="goods_stock"><?php echo $goods['stock']; ?></b><?php echo Yii::t('goods', '件'); ?>
            </span>
            <?php if(!empty($activityInfo) && $activityInfo['setting']['category_id'] == 3):?>
                <span class="MX_state_font3">(<?php
                    if($activityInfo['setting']['buy_limit']> 0){
                        echo Yii::t('goods','每个ID限购1次，最多购买{x}件',array('{x}'=>$activityInfo['setting']['buy_limit']));
                    }else{
                        echo Yii::t('goods','每个ID限购1次');
                    }
           ?>)</span>
           <?php elseif(!empty($activityInfo) && $activityInfo['setting']['category_id'] == 1 || $activityInfo['setting']['category_id'] == 2):
                    if($activityInfo['setting']['buy_limit']> 0){
                        echo '<span class="MX_state_font3">('.Yii::t('goods','每个ID最多购买{x}件',array('{x}'=>$activityInfo['setting']['buy_limit'])).')</span>';
                    }
		  endif;?>
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
        <?php echo $buyButtonALink;?>
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
<?php
$seting   = ActivityData::getActivityRulesSeting($goods['seckill_seting_id']);
$relation = ActivityData::getRelationInfo($goods['seckill_seting_id'],$goods['id']);
$active   = 0;
if( isset($seting) && isset($relation) && $relation['status']==1 && strtotime($seting['end_dateline'])>=time() && ($seting['status']==2 || $seting['status']==3) ){
    $active = 1;
}
$userId =  Yii::app()->user->id;
?>
<script type="text/javascript">
    var time_rest_days = <?php echo $time_rest_days;?>;
    var time_rest_hours = <?php echo $time_rest_hours;?>;
    var time_rest_minutes = <?php echo $time_rest_minutes;?>;
    var time_rest_seconds = <?php echo $time_rest_seconds;?>;
    if(<?php echo $join_activity;?>){setInterval('timeCount()',1000);}
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
        $("#button_add_cart").click(function(){
            if(!checkSpecSelect()) return false;
            addToCart(spec.id,parseInt($("#quantity").val()));
            return false;
        });
        $(".addCart").click(function(){
			<?php if(!empty($activityInfo) && $activityInfo['setting']['category_id']==3): ?>
			$('#button_add_cart_seckill').click();
			<?php else: ?>
			if(!checkSpecSelect()) return false;
            addToCart(spec.id,parseInt($("#quantity").val()));
            return false;
			<?php endif; ?>
        });

        $("#button_add_cart_seckill").click(function(){
            if(!checkSpecSelect()) return false;
            addToCartSeckill(spec.id,parseInt($("#quantity").val()));
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
            <?php if($goods['seckill_seting_id']>0 && $active==1): ?>
            var nums   = parseInt($('#quantity').val());
			var buyNum = '<?php echo $activityInfo['setting']['buy_limit'];?>';
            if(nums > buyNum && buyNum > 0){
                alert('<?php echo Yii::t('goods', '商品的数量不能超过活动的限制'); ?>');
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
        <?php if($goods['seckill_seting_id']>0 && $active==1): ?>
		    var buyNum = '<?php echo $activityInfo['setting']['buy_limit'];?>';
            if(parseInt(this.value) > buyNum && buyNum > 0){
                alert('<?php echo Yii::t('goods', '商品的数量不能超过活动的限制'); ?>');
                this.value = 1;
            }
        <?php endif;?>
    });
    /* 这个地方可能会要加ajax提交  来显示购物车购买几种商品  和总价  可以改上面的那个方法.  这下面的只是演示效果用*/
    function addToCart(spec_id, quantity) {
		/** 2015-06-26 测试部又要求不跳转登录页*/
		/*<?php if(!isset($userId)){?>
		window.location.href = '<?php echo Yii::app()->createAbsoluteUrl('/member/home/login');?>';
		return true;
		<?php }?>*/

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
				if(data.url){
					if(confirm(data.error)){
						window.location.href = data.url;
		                return true;
					}
				}else{
					alert(data.error);
				}
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
    function timeCount(){
        if((time_rest_seconds == 0 || time_rest_seconds == 5 || time_rest_seconds == 10)
            && time_rest_minutes ==0 && time_rest_hours ==0 && time_rest_days ==0){
            location.reload();
        }
        time_rest_seconds = (parseInt(time_rest_seconds) - 1);
        if(time_rest_seconds < 0){
            time_rest_seconds = 59;
            time_rest_minutes = (parseInt(time_rest_minutes) - 1);
            if(time_rest_minutes < 0){
                time_rest_minutes = 59;
                time_rest_hours = (parseInt(time_rest_hours) - 1);
                if(time_rest_hours < 0){
                    time_rest_hours = 23;
                    time_rest_days = (parseInt(time_rest_days) - 1);
                    if(time_rest_days < 0){
                        time_rest_days = 0;
                    }
                }
            }
        }
        var html = ' '+time_rest_days+' 天 '+time_rest_hours+' 小时 '+time_rest_minutes+' 分 '+time_rest_seconds+' 秒 ';
        $('#activity_title .MX_state_title_right span').html(html);
    }
    function addToCartSeckill(spec_id,quantity) {
        var url_param =
            'goods_id='+ spec.goods_id+
            '&quantity='+ quantity+
            '&spec_id='+ spec_id+
            '&setting_id=<?php echo $goods['seckill_seting_id'];?>';
        window.open('<?php echo $this->createUrl('seckillFlow/addList');?>?'+url_param);
    }
</script>