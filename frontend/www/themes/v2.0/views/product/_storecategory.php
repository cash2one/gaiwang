<?php $cid = $this->getQuery('cid', 0); ?>
<?php if (!empty($data)): ?>

	<?php foreach ($data as $key => $val): ?>
    <li tag="1">
	  <?php if (!isset($val['child'])): ?>
          <?php $url = $this->createAbsoluteUrl('/shop/product', array('id' => $storeId, 'cid' => $val['id'])); ?>
      <?php else: ?>
          <?php $url = '#'; ?>
      <?php endif; ?>
      <span class="shopInfo-nav-item"><?php echo CHtml::link(Yii::t('category', $val['name']), Yii::app()->createAbsoluteUrl('/shop/product', array('id' => $storeId, 'cid' => $val['id'])), array('title' => Yii::t('category', $val['name'])));?></span>
      <?php if (isset($val['child'])): ?>
          <div class="shopInfo-nav-float">
              <?php foreach ($val['child'] as $k => $v): ?>
                  <?php echo CHtml::link(Yii::t('category', $v['name']), Yii::app()->createAbsoluteUrl('/shop/product', array('id' => $storeId, 'cid' => $v['id'])), array('title' => Yii::t('category', $v['name']), 'class' => ($v['id'] == $cid) ? 'curr' : ''));?>
                  <?php if(($k+1)%2 != 0){echo '/';}?>
                  <?php if( $k>0 && ($k+1)%2 == 0 ){echo '<br/>';}?>
              <?php endforeach; ?>
          </div>
      <?php endif; ?>
    </li>   
    <?php endforeach; ?>

<?php endif; ?>