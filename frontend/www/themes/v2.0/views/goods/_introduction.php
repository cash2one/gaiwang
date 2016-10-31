<div class="pd-info">
    <div class="pd-info-mane"><span class="pd-font1"><?php echo Yii::t('goods', '品牌名称'); ?>:</span><?php echo $goods['bname']; ?></div>
    <?php if (!empty($goods['attribute'])): ?>
    
    <?php foreach ((array) $goods['attribute'] as $k => $attr): ?>
          <span class="pd-font1"><?php echo $attr['name'] ?>：</span> &nbsp;&nbsp;<span class="pd-font1"><?php echo isset($attr['value']) ? $attr['value'] : null; ?></span>
      <?php endforeach; ?>
    <?php endif; ?>    
</div>  
<div class="pd-imgShow">
  <?php echo Yii::app()->getController()->delSlashes($goods['content']); ?>
</div>       
