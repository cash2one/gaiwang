<?php
/** @var array $typeSpec */
/** @var array $spec */
?>
<?php foreach ($spec as $k => $v): ?>
    <?php $type = $v['type'] == Spec::TYPE_IMG ? 'spec_type_img' : '' ?>
    <dl class="spec-bg spec_group <?php echo $type ?>">
        <dt>
            <?php echo CHtml::hiddenField('sp_name[' . $v['id'] . ']', $v['name']) ?>
            <?php echo CHtml::hiddenField('sp_type[' . $v['id'] . ']', $v['type']) ?>
            <?php echo $v['name'] ?>：
        </dt>
        <dd <?php echo $v['type'] == Spec::TYPE_IMG ? 'data-type="sp_group_val"' : ''; ?> >
            <ul class="spec">
                <?php foreach ($v['spec_value_data'] as $spv): ?>
                    <li>
                        <span class="spec_checkbox">
                            <?php echo CHtml::checkBox('spec_val[' . $v['id'] . '][' . $spv['id'] . ']', false,
                                array('data-id' => $spv['id'], 'value' => $spv['name'], 'data-key' => $k)) ?>
                        </span>
                        <?php echo !empty($spv['thumbnail']) ? CHtml::image(ATTR_DOMAIN . '/' . $spv['thumbnail'], '', array('width' => '16', 'height' => '16')) : '' ?>
                        <span class="spec_name">
                            <input type="text" value="<?php echo $spv['name'] ?>" maxlength="20"
                                   style="border:solid 1px #ccc;">
                        </span>
                    </li>
                <?php endforeach; ?>
                <div class="clear"></div>
                <?php if ($v['type'] == Spec::TYPE_IMG): ?>
                    <table border="0" cellpadding="0" cellspacing="0" class="spec_table" style="display:none;"
                           id="col_img_table">
                        <thead>
                        <tr>
                            <th><?php echo Yii::t('sellerGoods', '颜色'); ?></th>
                            <th class="w250"><?php echo Yii::t('sellerGoods', '图片（无图片可不填）'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($v['spec_value_data'] as $v2): ?>
                            <tr style="display:none;" data-type="file_tr_<?php echo $v2['id'] ?>">
                                <td>
                                    <span class="img">
                                       <?php echo CHtml::image(ATTR_DOMAIN . '/' . $v2['thumbnail'], '', array('width' => '16', 'height' => '16')); ?>
                                    </span>
                                    <span class="pvname"><?php echo $v2['name'] ?></span>
                                </td>
                                <td class="w300">
                                    <input type="file" name="<?php echo $v2['name'] ?>"/>
                                    <span><img class="spec-img" style="border:0;" src="" width="150"/></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="2">
                                <p class="hint" style="padding-left:10px;">
                                    <?php echo Yii::t('sellerGoods', '支持jpg、jpeg、gif、png格式图片。'); ?><br/>
                                    <?php echo Yii::t('sellerGoods', '建议上传尺寸310x310、大小1.00M内的图片。'); ?><br/>
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

<dl id="stock_setting" class="spec-bg" style="display:none">
    <dt><?php echo Yii::t('sellerGoods', '库存配置'); ?>：</dt>
    <dd class="spec-dd">
        <table border="0" cellpadding="0" cellspacing="0" class="spec_table">
            <thead>
            <?php foreach ($typeSpec as $v): ?>
                <th><?php echo $v['name']; ?></th>
            <?php endforeach; ?>
            <th style="display: none"></th>
            <th><span class="red">*</span><?php echo Yii::t('sellerGoods', '库存'); ?></th>
            <th><?php echo Yii::t('sellerGoods', '商品货号'); ?></th>
            </thead>
            <tbody id="spec_table">
            </tbody>
        </table>
    </dd>
</dl>