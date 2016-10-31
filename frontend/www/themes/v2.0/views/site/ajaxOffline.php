
<?php if($data): ?>
<?php
$goods = array_chunk($data,5);
?>
    <?php foreach($goods as $k=>$v): ?>
<ul class="gx-fmr-cp-list<?php echo $k+1 ?> gx-fmr-cp-list1-2">
    <?php foreach($v as $k2=>$v2): ?>
        <li <?php echo $k2 == 2 ? 'class="gx-fmr-liNORightLine"' : '' ?>>
                <?php
                $height = $k==0 ? 220:170;
                $img =  CHtml::image(ATTR_DOMAIN.'/'.$v2['picture'], Yii::t('site', $v2['title']), array(
                    'width' => 199,
                    'height' => $height,
                    'title' => Yii::t('site', $v2['title']),
                    'class' => 'lazy',
                ));
                echo CHtml::link($img,$v2['link'],array('target'=>$v2['target']));
                ?>
        </li>
    <?php endforeach; ?>
</ul>
<?php endforeach; ?>
<?php endif; ?>