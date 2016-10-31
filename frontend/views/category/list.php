<div class="main clearfix">
    <div class="sliderWrap left">
        <?php $this->renderPartial('//layouts/_left', array('id' => $id, 'hot' => array(), 'recently' => array())); ?>
    </div>
    <div class="mainWrap right">
        <div class="filterMark clearfix">
            <span class="label">
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'homeLink' => false,
                    'separator' => ' > ',
                    'links' => array_merge(array(Yii::t('category','商品分类') => 'javascript:;'), $this->breadcrumbs),
                    'htmlOptions' => array('class' => ''),
                ));
                ?>
            </span>
            <div id="condition"></div>
            <span class="totalNum"><?php echo HtmlHelper::langsTextConvert(Yii::t('category','相关商品') .'{value}'. Yii::t('category','件'), $goodsCount) ?></span>
        </div>
        <?php if (!empty($sales)): ?>
            <div class="filterBox clearfix">
                <span class="topsell"><?php echo Yii::t('category','销量Top3');?></span>
                <ul class="clearfix">
                    <?php foreach ($sales as $sg): ?>
                        <li class="clearfix">
                            <?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $sg['thumbnail'], 'c_fill,h_140,w_140'), $sg['name'], array('width' => '140', 'height' => '140')), $this->createAbsoluteUrl('goods/view', array('id' => $sg['id'])), array('title' => $sg['name'], 'class' => 'box140x140 img_m')); ?>
                            <div class="txt">
                                <p class="price"><?php echo HtmlHelper::formatPrice($sg['price']); ?></p>
                                <p class="names namet">
                                    <?php echo CHtml::link($sg['name'], $this->createAbsoluteUrl('goods/view', array('id' => $sg['id']))); ?>
                                </p>
                                <p class="integral"><span class="jf"><?php echo Yii::t('category', '换购积分：') . HtmlHelper::priceConvertIntegral($sg['price']); ?></span></p>

                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <div class="rangeItem clearfix">
            <?php echo HtmlHelper::generateSortUrl('default', $this->route, $params, $this->_uriParamsCriterion(), 'abg'); ?>
            <?php echo HtmlHelper::generateSortUrl('sales_volume', $this->route, $params, $this->_uriParamsCriterion(), '', array('class' => 'range')); ?>
            <?php echo HtmlHelper::generateSortUrl('price', $this->route, $params, $this->_uriParamsCriterion(), '', array('class' => 'pricerange')); ?>
            <?php echo HtmlHelper::generateSortUrl('comments', $this->route, $params, $this->_uriParamsCriterion(), '', array('class' => 'range')); ?>
            <p>
                <?php echo Yii::t('category','积分');?>：<input type="text" class="input_txt" value="<?php echo!empty($params['min']) ? $params['min'] : ''; ?>" name="input_txt1" onkeyup="value = value.replace(/[^\d]/g, '')" /> —
                <input type="text" class="input_txt" value="<?php echo!empty($params['max']) ? $params['max'] : ''; ?>" name="input_txt2" onkeyup="value = value.replace(/[^\d]/g, '')" />
                <input type="button" class="input_btn"  value="<?php echo Yii::t('category','搜索');?>" name="btn1" id="integralSearch" />
            </p>
            <!--<span><a href="#" title="图片" class="picshow"><i></i>图片</a><a href="#" title="列表" class="listshow"><i></i>列表</a></span>-->
        </div>
        <?php if (!empty($goods)): ?>
            <div class="productList clearfix">
                <ul class="clearfix">
                    <?php foreach ($goods as $gk => $g): ?>
                        <li>
                            <div class="libox">
                                <?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $g['thumbnail'], 'c_fill,h_140,w_140'), $g['name'], array('width' => '170', 'height' => '170')), $this->createAbsoluteUrl('goods/view', array('id' => $g['id'])), array('class' => 'imgbox img_m', 'title' => $g['name'])); ?>
                                <p class="price"><?php echo HtmlHelper::formatPrice($g['price']); ?></p>
                                <p class="name"><?php echo CHtml::link(Tool::truncateUtf8String($g['name'], 26, '..'), $this->createAbsoluteUrl('goods/view', array('id' => $g['id'])), array('title' => $g['name'], 'target' => '_blank')) ?></p>
                                <p><?php // echo HtmlHelper::langsTextConvert(Yii::t('category','销量').'：{value}'.Yii::t('category','件'), $g['sales_volume']); ?></p>
                                <p class="integral"><?php echo Yii::t('category','换购积分');?>:<span class="jf"><?php echo HtmlHelper::priceConvertIntegral($g['price']); ?></span></p>
                            </div>　
                            <?php echo CHtml::link(Yii::t('category','加入购物车'), "javascript:addCart({$g['id']},{$g['goods_spec_id']});", array('title' => Yii::t('category','加入购物车'), 'class' => 'add_cart Carfly')); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="pageList clearfix">
                <?php
                $this->widget('CLinkPager', array(
                    'cssFile' => false,
                    'header' => '',
                    'firstPageLabel' => Yii::t('category','首页'),
                    'lastPageLabel' => Yii::t('category','末页'),
                    'prevPageLabel' => Yii::t('category','上一页'),
                    'nextPageLabel' => Yii::t('category','下一页'),
                    'pages' => $pager,
                    'maxButtonCount' => 5,
                    'htmlOptions' => array(
                        'class' => 'yiiPageer'
                    )
                        )
                );
                ?>
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