<?php
/* @var $this SiteController */
/* @var $model SpecialTopic */
/* @var $form CActiveForm */
?>
<?php
// 是否逾期 是：true, 否：false
$overdue = $model->end_time < time() ? true : false;
?>
<div class="specialDetBanner" style="background-color:#c83253">
    <?php echo CHtml::image(ATTR_DOMAIN . '/' . $model->thumbnail, $model->summary, array('width' => 1200, 'height' => 430)) ?>
</div>
<?php if (!empty($data)): ?>
    <div class="specialDetNav">
        <ul class="clearfix">
            <?php foreach ($data as $k => $category): ?>
                <li><?php echo CHtml::link(Yii::t('zt', $category['name']), "#Category{$k}", array('title' => $category['name'])); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<div class="main">
    <?php if (!empty($data)): ?>
        <?php  foreach ($data as $key => $val): ?>
            <div class="specialDetColumn">
                <div class="title" <?php if (!empty($val['thumbnail'])):?> style="background:url(<?php echo ATTR_DOMAIN.'/'.$val['thumbnail']?>) no-repeat;" <?php endif;?> id="Category<?php echo $key; ?>">
                <?php //echo CHtml::link(Yii::t('zt', $val['name']), '#', array('title' => $val['name'])) ?>
                <?php echo CHtml::link('', '#', array('title' => $val['name'])) ?>
                </div>
                <ul class="items clearfix">
                    <?php if (!empty($val['goods'])): ?>
                        <?php foreach ($val['goods'] as $goods): ?>
                            <li>
                                <?php
                                // 如果专题逾期了，则商品无链接
                                $goodsUrl = $overdue === true ? 'javascript:void(0);' : $this->createAbsoluteUrl('/goods/view', array('id' => $goods['id']));
                                $target = $overdue === true ? '_self' : '_blank';
                                ?>
                                <?php
                                echo CHtml::link(Chtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $goods['thumbnail'], 'c_fill,h_225,w_225'), $goods['name'], array(
                                            'width' => '225', 'height' => '225')), $goodsUrl, array('class' => 'img', 'target' => $target));
                                ?>
                                <?php
                                echo CHtml::link($goods['name'], $goodsUrl, array('class' => 'name', 'target' => $target));
                                ?>
                                <div class="txtDo clearfix">
                                    <div class="txt">
                                        <p class="jf"><?php echo Yii::t('zt', '换购积分');?>：<?php echo HtmlHelper::priceConvertIntegral($goods['special_price']); ?></p>
                                        <p class="price"><?php echo Yii::t('zt', '促销价');?>：<?php echo HtmlHelper::formatPrice($goods['special_price']); ?></p>
                                    </div>
                                    <?php
                                    echo CHtml::link(Yii::t('zt', '马上抢购'), $goodsUrl, array('class' => 'buyNow', 'target' => $target));
                                    ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php if (!empty($data)): ?>
    <div class="specialDetBackTop">
        <?php foreach ($data as $k => $category): ?>
            <?php echo CHtml::link($category['name'], "#Category{$k}", array('title' => $category['name'])); ?>
        <?php endforeach; ?>
        <a href="javascript:void(0)" title="<?php echo Yii::t('zt', '返回顶部');?>" class="backTop"></a>
    </div>
<?php endif; ?>