<?php $cid = $this->getQuery('cid', 0); ?>
<?php $data = Scategory::scategoryInfo($store['id']); ?>
<?php if (!empty($data)): ?>
    <div class="productSort" id="shopCat">
        <div class="notbg">
            <i class="ico_cog"></i>
            <h1><?php echo Yii::t('goods', '店铺分类'); ?></h1>
            <b>classification of goods</b>
        </div>
        <div class="items">
            <?php foreach ($data as $key => $val): ?>
                <dl class="clearfix">
                    <dt>
                    <?php if (!isset($val['child'])): ?>
                        <?php $url = $this->createAbsoluteUrl('/shop/product', array('id' => $store['id'], 'cid' => $val['id'])); ?>
                    <?php else: ?>
                        <?php $url = '#'; ?>
                    <?php endif; ?>
                    <?php echo CHtml::link(Yii::t('category', $val['name']), $url, array('class' => 'on', 'onclick' => 'showHide(this, "items' . $key . '");')); ?>
                    </dt>
                    <?php if (isset($val['child'])): ?>
                        <dd class="clearfix" id="items<?php echo $key ?>">
                            <?php foreach ($val['child'] as $k => $v): ?>
                                <?php echo CHtml::link(Yii::t('category', $v['name']), Yii::app()->createAbsoluteUrl('/shop/product', array('id' => $store['id'], 'cid' => $v['id'])), array('title' => Yii::t('category', $v['name']), 'class' => ($v['id'] == $cid) ? 'curr' : '')); ?>
                            <?php endforeach; ?>
                        </dd>
                    <?php endif; ?>
                </dl>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>