<?php
/* @var $this SlideController */
/* @var $model Slide */

$this->breadcrumbs = array(Yii::t('sellerSlide', '商家广告') => array('admin'), Yii::t('sellerSlide', '列表'));
?>
<a href="<?php echo $this->createAbsoluteUrl('/seller/slide/create'); ?>" class="mt15 btnSellerAdd"><?php echo Yii::t('sellerSlide', '添加广告') ?></a>
<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top:7px;" class="sellerT3">
    <tbody><tr>
            <th width="20%" class="bgBlack"><?php echo Yii::t('sellerSlide', '标题') ?></th>
            <th width="20%" class="bgBlack"><?php echo Yii::t('sellerSlide', '广告图片') ?></th>
            <th width="20%" class="bgBlack"><?php echo Yii::t('sellerSlide', '链接') ?></th>
            <th width="20%" class="bgBlack"><?php echo Yii::t('sellerSlide', '排序') ?></th>
            <th width="20%" class="bgBlack"><?php echo Yii::t('sellerSlide', '操作') ?></th>
        </tr>
        <?php foreach ($slide as $v): ?>
            <tr>
                <td class="ta_c"><b><?php echo Tool::truncateUtf8String($v->title, 20, '..'); ?></b></td>
                <td class="ta_c"><?php echo CHtml::image(ATTR_DOMAIN . '/' . $v->picture, $v->title, array('width' => 300, 'height' => 35)) ?></td>
                <td class="ta_c"><?php echo CHtml::link(Yii::t('sellerSlide', '广告链接'), $v->url, array('target' => '_blank')); ?></td>
                <td class="ta_c"><?php echo $v->sort; ?></td>
                <td class="ta_c">
                    <?php echo CHtml::link(Yii::t('sellerSlide', '更新'), $this->createAbsoluteUrl('/seller/slide/update', array('id' => $v->id))); ?> |
                    <?php echo CHtml::link(Yii::t('sellerSlide', '删除'), $this->createAbsoluteUrl('/seller/slide/delete', array('id' => $v->id))); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

