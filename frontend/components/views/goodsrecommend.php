<?php
// 推荐列表
/** @var $box['goods'] Goods */
if(!empty($box['goods'])): ?>
<div class="proArrange03 clearfix editor" id="proNew">
    <div class="title clearfix">
        <h3><span class="en"></span><?php echo Yii::t('shop',$box['title']); ?></h3>
        <?php echo CHtml::link(Yii::t('shop','更多'),Yii::app()->createAbsoluteUrl('shop/product', array('id' => $this->storeId)),array('class'=>'icon_v more')); ?>
    </div>
    <ul class="content clearfix">
        <?php foreach ($box['goods'] as $v): ?>
            <li>
                <?php
                $url = Yii::app()->createAbsoluteUrl('goods/' . $v['id']);
                $img = CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_170,w_170'),$v['name']);
                echo CHtml::link($img,$url,array('class'=>'img'));
                ?>
                <div class="txt">
                    <?php echo CHtml::link(Tool::truncateUtf8String($v['name'], 12, '..'),$url,array('class'=>'name')) ?>
                    <p><?php echo Yii::t('shop','浏览量：{num}次',array('{num}'=>$v['views'])) ?></p>
                    <p><?php echo Yii::t('shop', '换购积分'); ?>:<span class="red"><?php echo HtmlHelper::priceConvertIntegral($v['price']); ?></span></p>
                    <p><?php echo Yii::t('shop', '价格'); ?>：<span class="red"><?php echo HtmlHelper::formatPrice($v['price']); ?></span></p>
                </div>
                <?php echo CHtml::link(Yii::t('shop', '加入购物车'), "javascript:addCart({$v['id']},{$v['goods_spec_id']});", array('title' => Yii::t('shop', '加入购物车'), 'class' => 'icon_v addCart Carfly')) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>