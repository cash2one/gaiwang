<li>
    <div class="cn1">
        <a href="javascript:;" class="w60x60 img_m">
            <?php if (!empty($data['head_portrait'])): ?>
                <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $data['head_portrait'], 'c_fill,h_64,w_64'), Yii::t('goods', '头像'), array('width' => 64, 'height' => 64)); ?>
            <?php else: ?>
                <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/head_portrait/default.jpg', 'c_fill,h_64,w_64'), Yii::t('goods', '头像'), array('width' => 64, 'height' => 64)); ?>
            <?php endif; ?>
        </a>
        <?php echo substr($data['gai_number'], 0, 3) . '****' . substr($data['gai_number'], -3); ?>
    </div>
    <div class="cn2">
        <h2>[<?php echo Yii::t('goods', '客户评价') ?>]:</h2>
        <p class="comtxt">
            <?php if (!empty($data['spec_value'])): ?>
                <span style="color:#999;display: inline-block">[
                    <?php foreach (unserialize($data['spec_value']) as $ksp => $vsp): ?>
                        <?php echo $ksp . ': ' . $vsp ?>
                    <?php endforeach; ?>]
                </span>
            <?php endif; ?>
            <?php echo Tool::banwordReplace($data['content'], '*'); ?>
        </p>
        <span class="point p_d<?php echo $data['score'] * 10; ?>"></span><?php echo $data['score']; ?>分
        <p class="comtime"><?php echo date('Y-m-d H:i:s', $data['create_time']); ?></p>
    </div>
</li>