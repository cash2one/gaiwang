<?php foreach ($newGoods as $v):?>
<li>
  <?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_60,w_60'), $v['name'], array('width' => 60, 'height' => 60)), $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])), array('class' => 'sellingPord-img', 'title' => $v['name'])); ?>
  <div class="sellingPord-info">
      <a href="<?php echo  $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])); ?>" title="<?php echo $v['name'];?>" target="_blank"><?php echo $v['name']?></a>
      <span><?php echo HtmlHelper::formatPrice($v['price']); ?></span>
  </div>
</li>
<?php endforeach;?>
