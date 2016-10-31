<?php
/** @var $this ShopController */
?>
<div class="main">
    <div class="sliderWrap left">
        <?php
        // 商家服务信息
        $this->widget('application.components.ServiceWidget', array(
            'store' => $this->store,
            'design' => $design->tmpData[DesignFormat::TMP_LEFT_CONTACT],
        ));
        ?>
        <?php
        // 商家分类信息
        $this->widget('application.components.CommonWidget', array(
            'view' => 'scategory',
            'data' => Scategory::scategoryInfo($this->store->id),
        ));
        ?>
        <?php
        // 热门销售
        $this->widget('application.components.HotWidget', array('storeId' => $this->store->id));
        ?>
        <?php
        // 历史浏览
        $this->widget('application.components.CommonWidget', array(
            'view' => 'historybrowse',
            'method' => 'getHistoryBrowse',
        ));
        ?> 
    </div>
    <div class="mainWrap right">
        <div class="newProductList clearfix">
            <div class="rangeItem hbrand clearfix">
                <h1><i class="ico_book"></i>新品上架</h1>
                <span class="more"><a href="<?php echo $this->createAbsoluteUrl('shop/product', array('id' => $this->store->id)) ?>" title="更多推荐" class="mbrand">更多推荐</a></span>
            </div>
            <ul class="newProduct clearfix">
                <?php foreach ($goodsNewest as $v): ?>
                    <li>
                        <div class="libox">
                            <a href="<?php echo $this->createAbsoluteUrl('goods/' . $v['id']) ?>" title="<?php echo $v['name'] ?>" class="imgbox img_m">
                                <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_170,w_170'), $v['name'], array('width' => '170', 'height' => '170')) ?>
                            </a>
                            <p class="integral">换购积分：<span class="jf"><?php echo HtmlHelper::priceConvertIntegral($v['price']); ?></span></p>
                            <p class="price">价格：<?php echo HtmlHelper::formatPrice($v['price']); ?> </p>
                            <p class="names namet"><?php echo CHtml::link(Tool::truncateUtf8String($v['name'], 12, '..'), $this->createAbsoluteUrl('goods/' . $v['id'])); ?></p>
                            <span class="hot"><?php echo Yii::t('shop', '新品'); ?></span>
                        </div> 
                        <?php echo CHtml::link('加入购物车', "javascript:addCart({$v['id']},{$v['goods_spec_id']});", array('title' => '加入购物车', 'class' => 'add_cart Carfly')) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="rangeItem rIbg clearfix">
            <p>
                本店搜索：<input type="text" class="input_txt02" value="<?php echo $params['keyword']; ?>" name="input_txt3"  style="width:150px" />
                积分：<input type="text" class="input_txt02" value="<?php echo!empty($params['min']) ? $params['min'] : ''; ?>" name="input_txt1" onkeyup="value = value.replace(/[^\d]/g, '')" style="width:60px"/>—<input type="text" class="input_txt02" value="<?php echo!empty($params['max']) ? $params['max'] : ''; ?>" name="input_txt2" onkeyup="value = value.replace(/[^\d]/g, '')" style="width:60px"/>
                <input type="button" class="input_btn"  value="搜索" name="btn1" id="gSearch" />
            </p>
        </div>
        <?php if (!empty($goods)): ?>
            <div class="newProductList clearfix">
                <div class="rangeItem hbrand clearfix">
                    <h1><i class="ico_book"></i>热销推荐</h1>
                    <span class="more"><a href="<?php echo $this->createAbsoluteUrl('shop/product', array_merge($this->_uriProductParams(), array('id' => $this->store->id, 'order' => 1))) ?>" title="更多推荐" class="mbrand">更多推荐</a></span>
                </div>
                <ul class="clearfix">
                    <?php foreach ($goods as $g): ?>
                        <li>
                            <div class="libox">
                                <?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $g->thumbnail, 'c_fill,h_170,w_170'), $g->name, array('width' => '170', 'height' => '170')), $this->createAbsoluteUrl('goods/view', array('id' => $g->id)), array('class' => 'imgbox img_m', 'title' => $g->name)); ?>
                                <p class="price"><?php echo HtmlHelper::formatPrice($g->price); ?></p>
                                <p class="name"><?php echo CHtml::link(Tool::truncateUtf8String($g->name, 26, '..'), $this->createAbsoluteUrl('/goods/view', array('id' => $g->id)), array('target' => '_blank')); ?></p>
                                <p>销量：<?php echo $g->sales_volume; ?>件</p>
                                <p class="integral">换购积分:<span class="jf"><?php echo HtmlHelper::priceConvertIntegral($g['price']); ?></span></p>
                                 <?php  $return=Common::convertReturnDiv($g['gai_price'], $g['price'], $g['gai_income']/100);  //这是当前产品的赠送积分?>
                                <p class="integral">返回积分:<span class="jf"><?php echo $return; ?></span></p>   
                            </div>
                            <?php echo CHtml::link('加入购物车', "javascript:addCart({$g['id']},{$g['goods_spec_id']});", array('title' => '加入购物车', 'class' => 'add_cart Carfly')) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="pageList clearfix">
                <?php
                $this->widget('CLinkPager', array(
                    'cssFile' => false,
                    'header' => '',
                    'firstPageLabel' => Yii::t('jf','首页'),
                    'lastPageLabel' => yii::t('jf','末页'),
                    'prevPageLabel' => Yii::t('jf','上一页'),
                    'nextPageLabel' => Yii::t('jf','下一页'),
                    'pages' => $pager,
                    'maxButtonCount' => 5,
                    'htmlOptions' => array(
                        'class' => 'yiiPageer'
                    )
                        )
                );
                ?> 
            </div>
        <?php else: ?>
            <div class="noProTips clearfix">
                <span class="ico_nptips"><img src="<?php echo DOMAIN; ?>/images/bg/noProTips.gif" alt="图标"></span>
                <div class="noProTxt">
                    <h2>很抱歉，没找到相关的商品哦，要不您换个方式搜索我帮您再找找看。</h2>
                    <h3>建议您：</h3>
                    <p>1.看看输入的文字是否有误。</p>
                    <p>2.重新搜索。</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScript('search', "
$(function() {
    $(\"#gSearch\").click(function() {
        var key = $(this).siblings(\"input:first\").val();
        var min = $(this).siblings(\"input[name=input_txt1]\").val();
        var max = $(this).siblings(\"input:last\").val();
        min = min == '' ? 0 : min;
        max = max == '' ? 0 : max;
        location.assign('" . urldecode($this->createAbsoluteUrl($this->route, array_merge($params, array('keyword' => "'+key+'", 'min' => "'+min+'", 'max' => "'+max+'")))) . "');
    });
});
");
?>