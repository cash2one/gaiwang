<div class="main">
    <div class="container">
        <!-- Category Layout -->
        <div class="gxUITab gxui-tab">
            <a href="<?php echo $this->createUrl('goods/index', array('id' => $id)); ?>">基本信息<i
                    class="arrowTop"></i></a>
            <a href="<?php echo $this->createUrl('goods/detail', array('id' => $id)); ?>" class="selected">详情<i
                    class="arrowTop"></i></a>
            <a href="<?php echo $this->createUrl('goods/comment', array('id' => $id)); ?>">评论<i
                    class="arrowTop"></i></a>
        </div>
        <div class="content detailImg mgtop15">
            <?php
            if(!empty($picture)){
            foreach ($picture as $key => $pic) {
                ?>
                <div class="touchslider-item">
                    <img src="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $pic->path, 'c_fill,h_380,w_400'); ?>" alt="产品图<?php echo $key + 1; ?>"/>
                </div>
            <?php }
            }?>
            <?php echo $data['content']; ?>
        </div>
        <div class="clearfix mgtop20 bottomC"></div>
        <div id="goods_form"></div>
        <input type="hidden" id="goods_id" value="<?php echo $id; ?>"/>
        <div class="payBtn clearfix">
            <a href="javascript:void(0)" class="payNow fl" data-post="0" onclick="buyNow(this)">立即购买</a>
            <a href="javascript:void(0)" class="goCart fr" data-post="0" onclick="Cart(this)">加入购物车</a>
        </div>
    </div>
</div>
<!--颜色选择-->
<div class="setMask"></div>
<div class="setColorItem">
    <div class="OSProducts">
        <a href="#" title="<?php echo $data['name']; ?>" >
            <img width="80" class="fl" src="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $data['thumbnail'], 'c_fill,h_380,w_400');?>"/>
						<span class="OSProductsRight fl">
							<span class="OSProductsInfo"><?php echo $data['name']; ?></span>
							<span class="d32f2f"><?php echo HtmlHelper::formatPrice($data['price']); ?></span>
						</span>
        </a>
    </div>
    <!-- 颜色选择结束 -->
    <div class="ColorList">
        <?php
        if (!empty($newSpec)) {
        ?>
        <?php
        foreach ($newSpec as $key => $value) {
        if ($key !== 'default'){
        ?>
        <p class="specName"><?php echo $key . ":"; ?></p>

        <div class="specValue clearfix">
            <?php
            foreach ($value as $k => $v) {
                if (isset($newSpec['default'][$k]) && $v == $newSpec['default'][$k]) {
                    ?>
                    <span onclick="chooseSpec(this)" class="SelectColorItem" data-id="<?php echo $k;?>"><?php echo $v; ?></span>
                <?php } else { ?>
                    <span onclick="chooseSpec(this)" data-id="<?php echo $k;?>"><?php echo $v; ?></span>
                <?php
                }
            }
            echo "</div>";
            }
            }
            }
            ?>
            <div class="clear"></div>
        </div>
        <!-- 颜色选择结束 -->
        <div class="SelNum">
            <div class="fl SelNumLeft">选择数量<span class="gray">库存
                    （<i class="inventory" id="stock"><?php echo $defaultStock;; ?></i>）
                </span>
            </div>
            <!-- 数量加减 -->
            <div class="fr SelNumRight">
                <div class="fl SelNumJian" id="SelNumJian"></div>
                <input type="text" value="1" class="fl setNum" id="quantity" max="<?php echo $defaultStock; ?>"/>
                <div class="fl SelNumJia" id="SelNumJia"></div>
                <div class="clear"></div>
            </div>
            <!-- 数量加减 -->
            <div class="clear"></div>
        </div>
        <input type="hidden" id="member_id" value="<?php echo $this->getUser()->id; ?>"/>
        <input type="hidden" id="spec_id" value="<?php echo $data['goods_spec_id'];?>"/>
    </div>

<?php Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/m/com.js', CClientScript::POS_HEAD);?>
<?php Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/m/jquery.touchslider.min.js', CClientScript::POS_HEAD);?>
<?php Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/m/template.js', CClientScript::POS_HEAD);?>
<?php Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/m/alertJs.js', CClientScript::POS_HEAD);?>

<script>
    /* spec对象,设置默认的商品规格 */
    var spec = {
        id: "<?php echo $data['goods_spec_id'] ?>",
        price: "<?php echo $data['price'] ?>",
        goods_id: "<?php echo $data['id'] ?>",
        stock: "<?php echo $data['stock'] ?>",
        store_id:"<?php echo $data['store_id'] ?>",  //有多少类规格需要点击选择
        specType:"<?php echo count($data['spec_name']) ?>",  //有多少类规格需要点击选择
        goodsSpec:<?php echo json_encode($goodsSpec) ?>  //商品规格数据
    };
    $(function(){
        /*商品数量选择*/
        $('.SelNumJian').click(function(){
            var setNum=parseInt($(this).siblings(".setNum").val());
            if(setNum>1){
                setNum--;
                $(this).siblings(".setNum").val(setNum);
            }
            else{
                alert("至少要选择一件商品");
            }
        });

        $('.SelNumJia').click(function(){
            var setNum = parseInt($(this).siblings(".setNum").val());
            var maxNum = parseInt($(this).siblings(".setNum").attr("max"));
            var stock = parseInt($('#stock').text());
            if(setNum < maxNum && setNum < stock){
                setNum++;
                $(this).siblings(".setNum").val(setNum);
                //红包商品购买数量只能购买1个 @author binbin.liao
                <?php if($data['at_status'] ==ActivityTag::STATUS_ON && $data['join_activity'] ==Goods::JOIN_ACTIVITY_YES && !empty($data['activity_tag_id'])): ?>
                var nums = parseInt($('#quantity').val());
                if(nums >= 2){
                    alert('<?php echo Yii::t('goods', '红包活动商品只能购买一件'); ?>');
                    $('#quantity').val(1);
                }
                <?php endif;?>
            }else{
                alert("最大库存只有"+setNum+"件");
            }
        });

        //对商品数量作判断
        $("#quantity").keyup(function () {
            if (!this.value.match(/^[0-9]+?$/)) {
                this.value = 1;
            }
            if(parseInt(this.value) === 0){
                this.value = 1;
            }
        }).blur(function () {
            if (!this.value.match(/^[0-9]+?$/)) {
                this.value = 1;
            }
            if(parseInt(this.value) === 0){
                this.value = 1;
            }
        }).change(function () {
            var stock = $('#stock').text();
            /*
            var maxNum=$(this).attr("max");
            if(parseInt(this.value) > maxNum){
                alert("最多只能选择"+parseInt(maxNum)+"件商品");
            }
            */
            if (parseInt(this.value) > parseInt(stock)) {
                alert('<?php echo Yii::t('goods', '最大库存只有'); ?>' + stock + '<?php echo Yii::t('goods', '件'); ?>');
                this.value = stock;
            }
            //红包商品购买数量只能购买1个 @author binbin.liao
            <?php if($data['at_status'] ==ActivityTag::STATUS_ON && $data['join_activity'] ==Goods::JOIN_ACTIVITY_YES && !empty($data['activity_tag_id'])): ?>
            if(parseInt(this.value) >=2){
                alert('<?php echo Yii::t('goods', '红包活动商品只能购买一件'); ?>');
                this.value = 1;
            }
            <?php endif;?>
        });
    });
    function buyNow(obj){
        var length1 = $('.SelectColorItem').length;
        var length2 = $('.specValue').length;
        var tt = $('#quantity');
        var quantity = parseInt(tt.val());
        var maxNum = parseInt(tt.attr('max'));
        var flag = false;
        var p = $(obj);
        if(p.attr('data-post') == 0){
            $(".setMask").animate({
                bottom:"51px"
            });
            $(".setColorItem").animate({
                bottom:"51px"
            });
            if(length1 != 0 && length1 != length2){
                alert('您还有商品属性未选择');
                flag = false;
            }else{
                p.attr('data-post',"1");
            }
        }else if(p.attr('data-post') == 1){
            if(length1 != length2){
                alert('您还有商品属性未选择');
                flag = false;
            }else if(quantity > maxNum){
                alert("库存不足");
                flag = false;
                $(".setMask").animate({
                    bottom: "-100%"
                });
                $(".setColorItem").animate({
                    bottom: "-100%"
                });
                location.reload();
            }else{
                flag = true;
            }
        }
        if(flag){
            buyGoods();
        }
    }

    function buyGoods() {
        var user_id = "<?php echo $this->getUser()->id;?>";
        if (user_id.length <= 0) {
            alert('请先登录');
            <?php Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());?>
            location.href = "<?php echo $this->createUrl('home/login');?>";
        }
        var obj = $('#goods_form');
        var spec_id = $('#spec_id').val();
        var number = parseInt($('.SelNum .setNum').val());
        var html = '<form id="GoodsForm" action="<?php echo $this->createAbsoluteUrl('orderConfirm/index');?>" method="post"><input type="hidden" id="g_id" name="g_id" value="<?php echo $id;?>"><input type="hidden" id="number" name="number" value="' + number + '"/><input type="hidden" id="spec_id" name="spec_id" value="' + spec_id + '"/><input type="hidden" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken; ?>"/></form>';
        obj.append(html);
        $('#GoodsForm').submit();
    }

    function Cart(obj) {
        var length1 = $('.SelectColorItem').length;
        var length2 = $('.specValue').length;
        var tt = $('#quantity');
        var quantity = parseInt(tt.val());
        var maxNum = parseInt(tt.attr('max'));
        var flag = false;
        var p = $(obj);
        if(p.attr('data-post') == 0){
            $(".setMask").animate({
                bottom:"51px"
            });
            $(".setColorItem").animate({
                bottom:"51px"
            });
            if(length1 != 0 && length1 != length2){
                alert('您还有商品属性未选择');
                flag = false;
            }else{
                p.attr('data-post',"1");
            }
        }else if(p.attr('data-post') == 1){
            if(length1 != length2){
                alert('您还有商品属性未选择');
                flag = false;
            }else if(quantity > maxNum){
                alert("库存不足");
                flag = false;
                $(".setMask").animate({
                    bottom: "-100%"
                });
                $(".setColorItem").animate({
                    bottom: "-100%"
                });
                location.reload();
            }else{
                flag = true;
            }
        }
        if(flag){
            submitCart();
        }
    }

    function submitCart() {
        var spec_id = $('#spec_id').val();
        var number = $('.SelNum .setNum').val();
        var goods_id = $('#goods_id').val();
        $.post("<?php echo Yii::app()->createUrl('/m/goods/cart'); ?>", {goods_id: goods_id, number: number, spec_id: spec_id, YII_CSRF_TOKEN: "<?php echo Yii::app()->request->csrfToken;?>"}, function (msg) {
            alert(msg);
            if (msg === '该商品已经在您的购物车中') {
                location.href = "<?php echo $this->createUrl('cart/index');?>";
            }
            if (msg === '请先登录') {
                <?php Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());?>
                location.href = "<?php echo $this->createUrl('home/login');?>";
            }
        });
    }

    function chooseSpec(obj){
        var p = $(obj);
        if(!!p.hasClass("SelectColorItem")){
            p.removeClass("SelectColorItem");
        }else{
            p.addClass("SelectColorItem").siblings("span").removeClass("SelectColorItem");
        }
        //获取库存
        var goodsSpec = getGoodsSpec();
        if (goodsSpec) {
            $("#stock").text(goodsSpec.stock);
            $("#quantity").attr("max",goodsSpec.stock);
            $("#spec_id").val(goodsSpec.id);
            if (goodsSpec.stock <= 0) {
                $(this).parents('li').removeClass("curr").addClass("disabled");
            } else {
                spec.id = goodsSpec.id;
                spec.stock = goodsSpec.stock;
                spec.price = goodsSpec.price;
            }
        }
    }

    /**
     * 获取已选择规格组合的相关价格、库存、goods_spec_id数据
     */
    function getGoodsSpec() {
        //已选择的规格id
        var selectedSpecIds = [];
        $(".ColorList .specValue span.SelectColorItem").each(function () {
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
</script>