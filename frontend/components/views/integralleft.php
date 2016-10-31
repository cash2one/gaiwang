<?php // $data   ?>
<?php if (!empty($data)): ?>
<?php $html = $this->htmlOptions; ?>
    <div class="sliderBox mgtop20">
        <div class="sliderscroll">
            <div class="scrolltop">
                <h1><?php echo $html['title']; ?></h1>
            </div>
            <div class="hotsScrollbox" id="<?php echo $html['id']; ?>">
                <ul class="hotScroll">
                    <?php foreach ($data as $v): ?>
                    <li>
                        <?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_170,w_170'), $v['name'], array('width' => '170', 'height' => '170')), Yii::app()->createAbsoluteUrl('goods/view', array('id' => $v['id'])), array('title' => $v['name'], 'target' => '_blank', 'class' => 'img')); ?>
                        <p class="names"><?php echo CHtml::link(Tool::truncateUtf8String($v['name'], 13, '..'), Yii::app()->createAbsoluteUrl('goods/view', array('id' => $v['id'])), array('target' => '_blank')); ?></p>
                        <p class="integral"><?php echo HtmlHelper::langsTextConvert('换购积分：<span class="jf">{value}</span>', Common::convert($v['price'])); ?></p>
                        <p class="price"><?php echo HtmlHelper::formatPrice($v['price']); ?></p>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <span class="thumb prev"></span>
                <span class="thumb next"></span>
            </div>
        </div>
    </div>
<?php endif; ?>