<div class="gr-title"><span><?php echo Yii::t('goods', '猜你喜欢');?></span></div>
<ul class="gr-list">
    <?php foreach($collection as $v){?>
    <li>
        <?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_110,w_110'), $v['name'], array('width' => 110, 'height' => 110)), $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])), array('class' => 'gr-list-img', 'title' => $v['name'])); ?>
        <span><?php echo HtmlHelper::formatPrice($v['price']); ?></span>
        <a href="<?php echo  $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])); ?>" title="<?php echo $v['name'];?>"><?php echo Tool::truncateUtf8String($v['name'], 10);?></a>
    </li>
    <?php }?>
</ul>
<a href="javascript:getYouLike();" class="gr-renovateBut"><?php echo Yii::t('goods', '换一批');?></a>