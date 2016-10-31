<?php if($arr): ?>
<?php
$goods = array_chunk($arr,5);
?>
    <?php foreach($goods as $k=>$v): ?>
<ul class="gx-fmr-cp-list<?php echo $k+1 ?>">
    <?php foreach($v as $k2=>$v2): ?>
        <li <?php echo $k2 == 2 ? 'class="gx-fmr-liNORightLine"' : '' ?>>
            <a class="img" title="<?php echo Yii::t('site', $v2['description']) ?>" target="_blank" href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v2['id'])); ?>">
                <div class="gx-fmr-cp-item-info">
                    <?php echo Tool::truncateUtf8String($v2['name'],8) ?>
                    <p><?php echo HtmlHelper::formatPrice($v2['price']) ?></p>
                </div>
                <?php
                echo CHtml::image( Tool::showImg(IMG_DOMAIN . '/' . $v2['thumbnail'], 'c_fill,h_135,w_135'), Yii::t('site', $v2['name']), array(
                    'width' => 135,
                    'height' => 135,
                    'title' => Yii::t('site', $v2['name']),
                    'class' => 'lazy',
                ))
                ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
<?php endforeach; ?>
<?php endif; ?>


