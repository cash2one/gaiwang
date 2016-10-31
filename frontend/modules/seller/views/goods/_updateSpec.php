<?php
/** @var array $typeSpec */
/** @var array $spec */
/** @var Goods $model */
/** @var array $goodsSpec */
?>
<?php foreach ($spec as $k => $v): ?>
    <?php $type = $v['type'] == Spec::TYPE_IMG ? 'spec_type_img' : '' ?>
    <dl class="spec-bg spec_group <?php echo $type ?>">
        <dt>
        <?php echo CHtml::hiddenField('sp_name[' . $v['id'] . ']', $v['name']) ?>
        <?php echo CHtml::hiddenField('sp_type[' . $v['id'] . ']', $v['type']) ?>
        <?php echo Yii::t('sellerGoods', $v['name']); ?>：
        </dt>
        <dd <?php echo $v['type'] == Spec::TYPE_IMG ? 'data-type="sp_group_val"' : ''; ?> >
            <ul class="spec">
                <?php foreach ($v['spec_value_data'] as $spv): ?>
                    <li>
                        <span class="spec_checkbox">
                            <?php echo CHtml::checkBox('spec_val[' . $v['id'] . '][' . $spv['id'] . ']', $spv['checked'], array('data-id' => $spv['id'], 'value' => $spv['name'], 'data-key' => $k))
                            ?>
                        </span>
                        <?php
                        if (!empty($spv['thumbnail'])) {
                            echo CHtml::image((substr($spv['thumbnail'], 0, 9) == 'specValue' ? ATTR_DOMAIN : IMG_DOMAIN) . '/' . $spv['thumbnail'], '', array('width' => '16', 'height' => '16'));
                        }
                        ?>
                        <span class="spec_name"><?php
                            if ($spv['checked']) {
                                echo Yii::t('sellerGoods', $spv['name']);
                            } else {
                                echo CHtml::textField('', Yii::t('sellerGoods', $spv['name']), array('style' => 'style="border:solid 1px #ccc;"', 'maxlength' => 20));
                            }
                            ?></span>
                    </li>
                <?php endforeach; ?>
                <div class="clear"></div>
                <?php if ($v['type'] == Spec::TYPE_IMG): ?>
                    <table border="0" cellpadding="0" cellspacing="0" class="spec_table" style="display:none;" id="col_img_table">
                        <thead>
                            <tr>
                                <th><?php echo Yii::t('sellerGoods', '颜色'); ?></th>
                                <th class="w250"><?php echo Yii::t('sellerGoods', '图片（无图片可不填）'); ?></th>
                                <th><?php echo Yii::t('sellerGoods', '已有图片'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($v['spec_value_data'] as $v2):
                                $show = $v2['checked'] ? '' : 'style="display:none"';
                                ?>
                                <tr <?php echo $show ?> data-type="file_tr_<?php echo $v2['id'] ?>">
                                    <td>
                                        <span class="pvname"><?php echo Yii::t('sellerGoods', $v2['name']); ?></span>
                                    </td>
                                    <td class="w300">
                                        <input type="file" name="<?php echo Yii::t('sellerGoods', $v2['name']); ?>"/>
                                        <span>
                                            <img class="spec-img" style="border:0;" src="" height="150"/>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="img">
                                            <?php echo CHtml::image((substr($v2['thumbnail'], 0, 9) == 'specValue' ? ATTR_DOMAIN : IMG_DOMAIN) . '/' . $v2['thumbnail'], '', array('height' => '150')); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3">
                                    <p class="hint" style="padding-left:10px;">
                                        <?php echo Yii::t('sellerGoods', '支持jpg、jpeg、gif、png格式图片。'); ?><br/>
                                        <?php echo Yii::t('sellerGoods', '建议上传310*310像素的图片,大小1.00M内的图片。'); ?><br/>
                                        <?php echo Yii::t('sellerGoods', '商品详细页选中颜色图片后，颜色图片将会在商品展示图区域展示。'); ?>
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php endif; ?>
            </ul>
        </dd>
    </dl>

<?php endforeach; ?>

<dl id="stock_setting" class="spec-bg" <?php echo empty($goodsSpec['spec_value_array']) ? 'style="display:none"' : '' ?> >
    <dt><?php echo Yii::t('sellerGoods', '库存配置'); ?>：</dt>
    <dd class="spec-dd">
        <table border="0" cellpadding="0" cellspacing="0" class="spec_table">
            <thead>
                <?php foreach ($typeSpec as $v): ?>
                <th><?php echo Yii::t('sellerGoods',$v['name']); ?></th>
            <?php endforeach; ?>
            <th style="display: none"></th>
            <th><span class="red">*</span><?php echo Yii::t('sellerGoods', '库存'); ?></th>
            <th><?php echo Yii::t('sellerGoods', '商品货号'); ?></th>
            </thead>
            <tbody id="spec_table">
                <?php foreach ($goodsSpec as $k => $v): ?>
                    <?php if (!is_numeric($k) || empty($v['spec_value'])) continue ?>
                    <tr>
                        <?php foreach ($v['spec_value'] as $k2 => $v2): ?>
                            <td>
                                <?php
                                echo Yii::t('sellerGoods',$v2);
                                echo CHtml::hiddenField('spec[i_' . $k . '][sp_value][' . $k2 . ']', $v2);
                                ?>
                            </td>
                        <?php endforeach; ?>
                        <td style="display: none">
                            <?php echo CHtml::textField('spec[i_' . $k . '][price]', $v['price'], array('class' => 'text')) ?>
                        </td>
                        <td>
                            <?php echo CHtml::textField('spec[i_' . $k . '][stock]', $v['stock'], array('class' => 'text spec_stock')) ?>
                        <td>
                            <?php echo CHtml::textField('spec[i_' . $k . '][sku]', $v['code'], array('class' => 'text')) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </dd>
</dl>