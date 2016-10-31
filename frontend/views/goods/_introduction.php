<div class="tabCon curr" id="tabCon_ul_1">	
    <ul class="proDec">
        <p><?php echo Yii::t('goods', '品牌名称'); ?>：<?php echo $goods['bname']; ?></p>
        <?php if (!empty($goods['attribute'])): ?>
            <p class="proParameters"><?php echo Yii::t('goods', '商品参数'); ?>：</p>
            <p class="parameters">
                <?php foreach ((array) $goods['attribute'] as $k => $attr): ?>
                    <span><?php echo $attr['name'] ?>：<?php echo isset($attr['value']) ? $attr['value'] : null; ?></span>
                <?php endforeach; ?>
            </p>
        <?php endif; ?>
    </ul>
    <div class="Contain"><?php echo Yii::app()->getController()->delSlashes($goods['content']); ?></div>
</div>