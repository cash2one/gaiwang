<?php
/** @var array $goods */
/** @var GoodsController $this */
//处理活动样式
//var_dump($activityInfo);
$titleClass     = '';
$buyButtonALink = '';
$buyUrl         = '';
$join_activity  = 0;
$time_rest_days = 0;
$time_rest_hours    = 0;
$time_rest_minutes  = 0;
$time_rest_seconds  = 0;
$is_special_product = 0;
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
            $buyClass = array('class' => 'pord-but pord-buy pord-buy-not');
			$is_special_product = 1;
        }else{
            $titleClass = 'MX_state_title';
            $buyTitle = Yii::t('goods', '加入购物车');
            $buyClass = array('class' => 'pord-but pord-shoppingCart');
            if($activityInfo['setting']['category_id'] == 3){//秒杀
                $buyClass['id'] = 'button_add_cart_seckill';
				$is_special_product = 1;
            }else{
                $buyClass['id'] = 'button_add_cart';
            }
        }
    }else{
        $titleClass = 'MX_state_title MX_state_title3';
        $buyTitle = Yii::t('goods', '卖光了');
        $buyClass = array('class' => 'pord-but pord-buy pord-buy-not');
        $is_special_product = 1;
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
                'class' => 'pord-but pord-buy buy_hyj',
                'style' => 'position:relative;left:-10px;',
            );
			$is_special_product = 1;
            /*
             * 积分+现金支付也要放到购物车
        } else if (ShopCart::checkSpecialGoods($goods) || ShopCart::checkSpecialGoods($goods['id']) || ($goods['integral_ratio'] < 100 && $goods['integral_ratio'] > 0)) {
            //是否特殊商品或者积分+现金支付商品

            $buyTitle = Yii::t('goods', '立即购买');
            $buyClass= array('id'=>'button_add_cart_special',"title" => $buyTitle, 'class' => 'pord-but pord-buy buy_special');
			$is_special_product = 1;
            */
        } else {
            $buyTitle = Yii::t('goods', '加入购物车');
            $buyClass= array('id'=>'button_add_cart',"title" => $buyTitle, 'class' => 'pord-but pord-shoppingCart');
        }
    } else {
        $buyTitle = Yii::t('goods', '已售完');
        $buyClass= array('class' => 'pord-but pord-buy pord-buy-not');
		$is_special_product = 1;
    }
}
$buyButtonALink = CHtml::link($buyTitle, $buyUrl, $buyClass);
$goodsPrice     = $goods['price'];

$seting   = ActivityData::getActivityRulesSeting($goods['seckill_seting_id']);
$relation = ActivityData::getRelationInfo($goods['seckill_seting_id'],$goods['id']);
$active   = 0;
if( isset($seting) && isset($relation) && $relation['status']==1 && strtotime($seting['end_dateline'])>=time() && ($seting['status']==2 || $seting['status']==3) ){
    $active = 1;
}
$userId =  Yii::app()->user->id;
if( $goods['status'] == Goods::STATUS_AUDIT || $goods['status'] == Goods::STATUS_NOPASS || ($goods['status'] == Goods::STATUS_PASS && $goods['is_publish'] == Goods::PUBLISH_NO) ){//已经下架,条件: 商品审核中, 审核不通过, 审核通过但未发布
?>
<p class="pd-info1" title="<?php echo array_key_exists($goods['name'], Heyue::$goodsName) ? Heyue::$goodsName[$goods['name']] : $goods['name'];?>">
<?php if ($goods['bname']): ?>【<?php echo $goods['bname']; ?>】<?php endif; 
    echo array_key_exists($goods['name'], Heyue::$goodsName) ? Heyue::$goodsName[$goods['name']] : $goods['name'];
?>
</p>
<p class="pd-info2"></p>
<!--下架商品展示start-->
<div class="xj-title"><?php echo Yii::t("goods", "零售价"); ?> <span class="xj-title-font1"><?php echo HtmlHelper::formatPrice($goodsPrice); ?></span></div>
<span class="xj-title-font2"><?php echo Yii::t("goods", "抱歉，该商品已下架"); ?></span>
<span class="xj-title-font3"><?php echo Yii::t("goods", "购买过该商品的人还购买了"); ?></span>
<ul class="xj-title-list clearfix">
    <?php if(!empty($randRecord)){
		foreach($randRecord as $v){	
	?>
	<li>
		<?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_150,w_150'), $v['name'], array('width' => 150, 'height' => 150)), $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])), array('class'=>'shoppingCart-img', 'title' => $v['name'])); ?>
		<a href="<?php echo  $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])); ?>" title="<?php echo $v['name'];?>" class="sc-font1"><?php echo Tool::dCutUtf8String($v['name'],25, '');?></a>
		<span class="sc-font2"><?php echo HtmlHelper::formatPrice($v['price']); ?></span>
	</li>
	<?php }} ?>
</ul>

<script language="javascript">
$(document).ready(function(e) {
    $('#pord-shoppingCart2').css('display','none');
});
</script>
<?php 
}else{//在售商品 
?>

<p class="pd-info1" title="<?php echo array_key_exists($goods['name'], Heyue::$goodsName) ? Heyue::$goodsName[$goods['name']] : $goods['name'];?>">
  <?php if ($goods['bname']): ?>【<?php echo $goods['bname']; ?>】<?php endif; 
      echo array_key_exists($goods['name'], Heyue::$goodsName) ? Heyue::$goodsName[$goods['name']] : $goods['name'];
  ?>
</p>
<p class="pd-info2"></p>
<?php if(!empty($activityInfo)): 
      if($activityInfo['setting']['category_id'] != 1 ) $goodsPrice = ActivityData::getActivityPrice($goods['seckill_seting_id'], $goodsPrice);
?>
<div class="pd-info3"><?php echo $activityInfo['timeTips'];?></div>
<?php endif; ?>
<dl class="pd-info4 clearfix">
    <dt><span class="pd-info8"><?php echo Yii::t("goods", "零售价"); ?></span></dt>
    <dd><span class="pd-info5"><span></span><?php echo HtmlHelper::formatPrice($goodsPrice); ?></span></dd>

    <?php if (($goods['jf_pay_ratio'] < 100 && $goods['jf_pay_ratio'] > 0)): ?>
    <dt><?php echo Yii::t("goods", "会员尊享价"); ?></dt>
    <dd><span class="pd-info6">
            <span>
            <?php echo HtmlHelper::formatPrice($goodsPrice*(1-$goods['jf_pay_ratio']/100)),'+',HtmlHelper::priceConvertIntegral($goodsPrice*($goods['jf_pay_ratio']/100)); ?>
            </span>
            <?php echo Yii::t("goods", "积分"); ?></span>
    </dd>
    <?php endif; ?>
    <?php if($goods['jf_pay_ratio']==0):?>
    <dt><?php echo Yii::t("goods", "换购积分"); ?></dt>
    <dd><span class="pd-info6"><span><?php echo HtmlHelper::priceConvertIntegral($goodsPrice); ?></span><?php echo Yii::t("goods", "积分"); ?></span></dd>
    <?php endif; ?>

    <?php if($join_activity): ?>
    <dt><?php echo Yii::t("goods", "优惠"); ?></dt>
    <dd><?php
		if($activityInfo['setting']['category_id'] == 1){
			echo Yii::t("goods", '支持红包抵用{0}元,不支持积分支付',array('{0}'=>number_format($goodsPrice*$activityInfo['setting']['discount_rate']/100, 2, '.', '')));
		}else{
			if($activityInfo['setting']['discount_rate']>0){
				echo Yii::t("goods", '已打{0}折，活动结束恢复原价',array('{0}'=>($activityInfo['setting']['discount_rate']/10)));
                                if($activityInfo['setting']['category_id'] != SeckillCategory::SECKILL_CATEGORY_TWO){
                                    echo Yii::t('goods',',不支持积分支付');
                                }
			}else{
				echo Yii::t("goods", "支持{0}元限时购",array('{0}'=>$activityInfo['setting']['discount_price']));
                                if($activityInfo['setting']['category_id'] != SeckillCategory::SECKILL_CATEGORY_TWO){
                                    echo Yii::t('goods',',不支持积分支付');
                                }
			}
		} ?>
    </dd>
    <?php endif; ?>
</dl>

<?php echo $this->renderPartial('_freight', array('goods' => $goods)); //运费模板   ?>

<!-- 商品需要选择的参数start -->
<dl class="pd-info4 pd-info10 clearfix" id="pordParameter">
    <dt class="pordParameter-ts">
        <?php echo Yii::t('goods', '请选择您想要的商品信息');?>
        <span></span>
    </dt>
    <?php foreach ($goods['spec_name'] as $k => $v): 
	         if (!isset($goods['goods_spec'][$k])) continue; ?>
    <dt><?php echo $v ?></dt>
    <dd class="color-dd">
      <ul class="prod-property">
	  <?php foreach ($goods['goods_spec'][$k] as $k2 => $v2): ?>
        <?php if (isset($goods['spec_picture'][$k2])): ?>           
                <li>
				<?php
                $pic = IMG_DOMAIN . '/' . $goods['spec_picture'][$k2];;
                echo CHtml::link('' . '<ico></ico>', 'javascript:void(0)', array(
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
            <li>
                <?php echo CHtml::link($v2 . '<ico></ico>', 'javascript:void(0)',
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
    <?php endforeach; ?>
    
    <dt><?php echo Yii::t('goods', '数量'); ?></dt>
    <dd>
        <input type="text" class="pord-num" id="quantity" value="1"/>
        <span class="pord-amount-but">
            <span class="pord-amount-increase"></span>
            <span class="pord-amount-decrease"></span>
        </span>
        <span class="pord-stockNum"><?php echo Yii::t('goods', '库存').'<span id="goods_stock">'.$goods['stock'].'</span>'.Yii::t('goods', '件'); ?></span>
        <?php if(!empty($activityInfo) && $activityInfo['setting']['category_id'] == 3):
                    if($activityInfo['setting']['buy_limit']> 0){
                        echo '<span>('.Yii::t('goods','每个ID限购1次，最多购买{x}件',array('{x}'=>$activityInfo['setting']['buy_limit'])).')</span>';
                    }else{
                        echo '<span>('.Yii::t('goods','每个ID限购1次').')</span>';
                    }
          elseif(!empty($activityInfo) && $activityInfo['setting']['category_id'] == 1 || $activityInfo['setting']['category_id'] == 2):
                    if($activityInfo['setting']['buy_limit']> 0){
                        echo '<span>('.Yii::t('goods','每个ID最多购买{x}件',array('{x}'=>$activityInfo['setting']['buy_limit'])).')</span>';
                    }
		  endif;?>
    </dd>
    <dt class="pord-but-dt">&nbsp;</dt>
    <dd class="pord-but-dd">
        <?php if($is_special_product == 0){?>
        <a href="javascript:void(0)" class="pord-but pord-buy" id="pord-buy"><?php echo Yii::t('goods', '立即购买');?></a>
        <?php }?>
		<?php echo $buyButtonALink;?>
        <a href="javascript:void(0)" class="pord-but pord-Okbut" id="pord-Okbut"><?php echo Yii::t('goods', '确定');?></a>
    </dd>
</dl>
<!-- 商品需要选择的参数end -->
<!--<dl class="pd-info4 pd-info10">
    <dt>服务</dt>
    <dd class="pord-serve">
        <a href="#" title="">店铺保修</a>
        <a href="#" title="">7天无理由退款</a>
        <a href="#" title="">快速发货</a>
    </dd>
</dl>-->
<!-- ------------------------------------------------------------------------------------------------------------------------ -->
<!-- 添加到购物车提示框start -->
<input type="hidden" id="uuuid" value="<?php echo $userId;?>" />
<div class="shoppingCart-float">
    <div class="title"><?php echo Yii::t('goods','添加到购物车');?><img width="32" height="32" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl;?>/images/bgs/shoppingCart_closeBut.jpg"/></div>
    <div class="content">
        <div class="prompt-info">
            <div class="prompt-info-left"><?php echo Yii::t('goods','已将商品添加到购物车');?>~</div>
            <div class="prompt-info-right"><a href="<?php echo $this->createAbsoluteUrl('/orderFlow');?>" title="<?php echo Yii::t('goods','去购物车结算');?>"><?php echo Yii::t('goods','去购物车结算');?></a></div>
        </div>
        <?php echo Yii::t('goods','购买过该商品的人还购买了');?>
        <ul class="clearfix">
            <?php if(!empty($randRecord)){
			    foreach($randRecord as $v){	
			?>
            <li>
                <?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_150,w_150'), $v['name'], array('width' => 150, 'height' => 150)), $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])), array('class'=>'shoppingCart-img', 'title' => $v['name'])); ?>
                <a href="<?php echo  $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])); ?>" title="<?php echo $v['name'];?>" class="sc-font1"><?php echo Tool::dCutUtf8String($v['name'],25, '');?></a>
                <span class="sc-font2"><?php echo HtmlHelper::formatPrice($v['price']); ?></span>
            </li>
            <?php }} ?>
        </ul>
    </div>
</div>
<div style="display:none;">
  <?php echo CHtml::form($this->createAbsoluteUrl('/orderFlow/verify'));
  
  echo CHtml::checkBox('goods_select[]', true, array('value'=>''));
  echo CHtml::textField('qty_item_1', 0, array('value'=>''));
  echo '<input type="submit" id="specialBtn"/>';
  echo CHtml::endForm();
  ?>  
</div>
<?php }?>

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
        goodsSpec:<?php echo json_encode($goodsSpec) ?>,  //商品规格数据
		special:<?php echo $is_special_product;?>,
		special_url:"<?php echo $this->createAbsoluteUrl('/orderFlow/verify');?>"
    };
    /*产品图片放大*/
    $(document).ready(function ($) {
        //商品规格选择
        $("#pordParameter li").click(function () {
			$(this).removeClass("not-itme").addClass("prod-propertyLI");
			$(this).find('a').css({'color':'#000000' ,'cursor': 'pointer'});
			
            //将属性中的图片，放到放大镜位置显示
            var propertyPic = $(this).find('a').attr("data-pic");
            if (propertyPic) {
				var addHtml = '<img width="420" height="420" jqimg="'+showImg(propertyPic, 'c_fill,h_800,w_800')+'" src="'+showImg(propertyPic, 'c_fill,h_800,w_800')+'" />';
                $("#preview").find('.jqzoom').html(addHtml);
            }
            //获取库存
            var goodsSpec = getGoodsSpec();
            if (goodsSpec) {
                $("#goods_stock").html(goodsSpec.stock);
                if (goodsSpec.stock <= 0) {
					$(this).find("ico").hide();
					$(this).find('a').css({'color':'#b8b7bd' ,'cursor': 'not-allowed'});
                    $(this).removeClass("prod-propertyLI").addClass("not-itme");
					//$(this).unbind('click');
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
		$("#pord-buy").click(function(){
            if(!checkSpecSelect()) return false;
            addToCart(spec.id,parseInt($("#quantity").val()), 1);
            return false;
        });
        $("#pord-shoppingCart2").click(function(){
			$('body,html').animate({scrollTop:0},1000);
			<?php if(!empty($activityInfo) && $activityInfo['setting']['category_id']==3): ?>
			$('#button_add_cart_seckill').click();
			<?php elseif($is_special_product == 0): ?>
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
                        layer.alert(data.error);
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
                        layer.alert(data.error);
                    }
                });
            return false;
        });

    });

    // 商品数量选择判断
    $('.pord-amount-increase').click(function () {
        var num    = parseInt($('#quantity').val());
        var maxNum = parseInt($('#goods_stock').text());
        if (num < maxNum) {
            $('#quantity').val(num + 1);
            //红包商品购买数量只能购买1个 @author binbin.liao
            <?php if($goods['seckill_seting_id']>0 && $active==1): ?>
            var nums   = parseInt($('#quantity').val());
			var buyNum = '<?php echo $activityInfo['setting']['buy_limit'];?>';
            if(nums > buyNum && buyNum > 0){
                layer.alert('<?php echo Yii::t('goods', '商品的数量不能超过活动的限制'); ?>');
                $('#quantity').val(buyNum);
            }
            <?php endif;?>
        }
    });
    $('.pord-amount-decrease').click(function () {
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
            layer.alert('<?php echo Yii::t('goods', '最大库存只有'); ?>' + stock + '<?php echo Yii::t('goods', '件'); ?>');
            this.value = stock;
        }else if(parseInt(this.value)<1){
			this.value = 1;
		}
        //红包商品购买数量只能购买1个 @author binbin.liao
        <?php if($goods['seckill_seting_id']>0 && $active==1): ?>
		    var buyNum = '<?php echo $activityInfo['setting']['buy_limit'];?>';
            if(parseInt(this.value) > buyNum && buyNum > 0){
                layer.alert('<?php echo Yii::t('goods', '商品的数量不能超过活动的限制'); ?>');
                this.value = 1;
            }
        <?php endif;?>
    });
    /* 这个地方可能会要加ajax提交  来显示购物车购买几种商品  和总价  可以改上面的那个方法.  这下面的只是演示效果用*/
    function addToCart(spec_id, quantity, v) {

		v = v==1 ? 1 : 0;
        var url = commonVar.addCartUrl;
        $.getJSON(url,
            {goods_id: spec.goods_id, quantity: quantity, spec_id: spec_id,store_id:spec.store_id, special:v}, function (data) {
            if (data.success && data.success < 2) {
				// 头部加载购物车信息
                getCartInfo();
				
				if(data.special == 1){
					//window.location.href = spec.special_url;
					$('#goods_select').val(data.goods_id+'-'+data.spec_id);
					$('#qty_item_1').val(data.num);
					$('#specialBtn').click();
				}else{
					$(".shoppingCart-float").show();
				}
            } else {
				if(data.url){
					if(confirm(data.error)){
						window.location.href = data.url;
		                return true;
					}
				}else{
					layer.alert(data.error);
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
        $("#pordParameter li.prod-propertyLI a.goodsSpec").each(function () {
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
		return checkSpecRule();
        if($("#pordParameter li a.goodsSpec").size() > 0 && $("#pordParameter li.curr a.goodsSpec").size()!=spec.specType){
            layer.alert("<?php echo Yii::t('goods','请选择相关规格') ?>");
            return false;
        }
        var quantity = parseInt($("#quantity").val());
        if (quantity < 1) {
            layer.alert("<?php echo Yii::t('goods', '请填写购买数量'); ?>");
            $("#quantity").val('1');
            return false;
        }
        var max = parseInt($('#goods_stock').text());
        if (quantity > max) {
            layer.alert("<?php echo Yii::t('goods', '您购买的商品数量，超出了该商品库存，请您重新选择商品数量'); ?>");
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
        var html = ' '+time_rest_days+'天'+time_rest_hours+'小时'+time_rest_minutes+'分'+time_rest_seconds+'秒';
        $('.pd-info3 span').html(html);
    }
    function addToCartSeckill(spec_id,quantity) {
        var url_param =
            'goods_id='+ spec.goods_id+
            '&quantity='+ quantity+
            '&spec_id='+ spec_id+
            '&setting_id=<?php echo $goods['seckill_seting_id'];?>';
        window.open('<?php echo $this->createUrl('seckillFlow/addList');?>?'+url_param);
    }
	
	//购买、加入购物车确认是否有选择商品参数(i:需要选择的参数有几项)
	var ISPordshoppingCart="";
	function checkSpecRule(){
		if($(this).attr("id")=="pord-shoppingCart" || $(this).attr("id")=="pord-shoppingCart2"){//是否是点击加入购物车
			ISPordshoppingCart="1";
		}
		var selLength=$(".prod-property").find(".prod-propertyLI").length;//选中的项的数
		var totalLength=$(".prod-property").length;//实际应该选项数
		$(".prod-property li").addClass("ISSelectLi");
		if(selLength<totalLength){
			$("#pordParameter").addClass("pordParameterSel");
			$(".pord-but").hide();
			$("#pord-Okbut").show();
			$(".pordParameter-ts").show();
			return false;
		}else{
			//产品信息都选择了就直接就直接购买或者加入购物车
			if($(this).attr("id")=="pord-shoppingCart"){
				$(".shoppingCart-float").show();
			}
		}
		return true;
	}	
</script>