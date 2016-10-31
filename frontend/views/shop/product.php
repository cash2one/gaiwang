<?php
/** @var $this ShopController */
?>
<div class="main">
    <div class="k15"></div>
    <div class="sliderWrap left">
        <?php
        // 商家服务信息
        $this->widget('application.components.ServiceWidget', array('store' => $this->store));
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
        <div class="filterMark clearfix">
            <span class="label">
              <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'tagName' => 'span',
                    'homeLink' => false,
                    'separator' => ' > ',
                    'links' => array_merge(array(Yii::t('shop','店铺分类') => 'javascript:;'), $this->breadcrumbs),
                    'htmlOptions' => array('class' => false),
                ));
                ?>
               
            </span>
            <div id="condition"></div>
            <span class="totalNum"><?php echo HtmlHelper::langsTextConvert('相关商品 {value} 件', $count) ?></span>
        </div>
        <?php //$this->renderPartial('_filter') 产品特征筛选卡 暂时隐藏 ?>
        <div class="rangeItem clearfix">
            <?php echo HtmlHelper::generateSortUrl('default', $this->route, $params, $this->_uriProductParams(), 'abg'); ?>
            <?php echo HtmlHelper::generateSortUrl('sales_volume', $this->route, $params, $this->_uriProductParams(), '', array('class' => 'range')); ?>
            <?php echo HtmlHelper::generateSortUrl('price', $this->route, $params, $this->_uriProductParams(), '', array('class' => 'pricerange')); ?>
            <?php echo HtmlHelper::generateSortUrl('comments', $this->route, $params, $this->_uriProductParams(), '', array('class' => 'range')); ?>
            <p>
                积分：<input type="text" class="input_txt" value="<?php echo!empty($params['min']) ? $params['min'] : ''; ?>" name="input_txt1" onkeyup="value = value.replace(/[^\d]/g, '')" /> —
                <input type="text" class="input_txt" value="<?php echo!empty($params['max']) ? $params['max'] : ''; ?>" name="input_txt2" onkeyup="value = value.replace(/[^\d]/g, '')" />
                <input type="button" class="input_btn"  value="搜索" name="btn1" id="integralSearch" />
            </p>
            <!--<span><a href="#" title="图片" class="picshow"><i></i>图片</a><a href="#" title="列表" class="listshow"><i></i>列表</a></span>-->
        </div>
        <?php if (!empty($goods)): ?>
            <div class="newProductList clearfix">
                <ul>
                    <?php foreach ($goods as $g): ?>
                        <li>
                            <div class="libox">
                                <?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $g->thumbnail, 'c_fill,h_170,w_170'), $g->name, array('height' => '170', 'width' => '170')), $this->createAbsoluteUrl('goods/view', array('id' => $g->id)), array('class' => 'imgbox img_m', 'title' => $g->name)); ?>
                                <p class="price"><?php echo HtmlHelper::formatPrice($g->price); ?></p>
                                <p class="name"><?php echo CHtml::link(Tool::truncateUtf8String($g->name, 26, '..'), $this->createAbsoluteUrl('/goods/view', array('id' => $g->id)), array('target' => '_blank')); ?></p>
                                <p>销量：<?php echo $g->sales_volume; ?>件</p> 
                                <p class="integral">换购积分:<span class="jf"><?php echo HtmlHelper::priceConvertIntegral($g['price']); ?></span></p>
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
                    'pages' => $pages,
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
                    <h2>很抱歉，没找到相关分类的商品哦，要不您换个分类我帮您再找找看。</h2>
                    <h3>建议您：</h3>
                    <p>1.看看输入的文字是否有误。</p>
                    <p>2.重新搜索。</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScript('integralSearch', "
$(function() {
    $(\"#integralSearch\").click(function() {
        var min = $(this).siblings(\"input:first\").val();
        var max = $(this).siblings(\"input:last\").val();
        min = min == '' ? 0 : min;
        max = max == '' ? 0 : max;
        location.assign('" . urldecode($this->createAbsoluteUrl($this->route, array_merge($params, array('min' => "'+min+'", 'max' => "'+max+'")))) . "');
    });
});
");
?>