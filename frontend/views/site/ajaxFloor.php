<?php if($arr): ?>
<ul class="proArrange01 clearfix">
    <?php foreach ($arr as $k => $v): ?>
        <li>
            <?php echo CHtml::link(Yii::t('category', $v['name']), $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])), array('class' => 'name', 'title' => $v['name'])); ?>
            <p class="des"><?php echo Yii::t('site', $v['description']) ?></p>
            <a class="img" title="<?php echo Yii::t('site', $v['description']) ?>" target="_blank" href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])); ?>">
                <?php
                echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_150,w_150'), Yii::t('site', $v['name']), array(
                    'width' => 150,
                    'height' => 150,
                    'title' => Yii::t('site', $v['name']),
                   'class' => 'lazy',
                   'data-url' => Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_150,w_150'),
                ))
                ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>