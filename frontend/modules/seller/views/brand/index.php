<?php
/* @var $this BrandController */
/* @var $model Brand */

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#brand-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="toolbar">
    <b><?php echo Yii::t('sellerBrand', '商品品牌列表') ?></b>
    <span><?php echo Yii::t('sellerBrand', '对所添加的品牌进行审核查询。') ?></span>
</div>

<?php
$this->renderPartial('_search', array(
    'model' => $model,
));
?>

<a href="/brand/create" class="mt15 btnSellerAdd"><?php echo Yii::t('sellerBrand', '添加品牌') ?></a>

<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top:7px;" class="sellerT3">
    <tbody><tr>
            <th width="20%" class="bgBlack"><?php echo Yii::t('sellerBrand', '简码') ?></th>
            <th width="20%" class="bgBlack"><?php echo Yii::t('sellerBrand', '品牌名称') ?></th>
            <th width="20%" class="bgBlack"><?php echo Yii::t('sellerBrand', '品牌Logo') ?></th>
            <th width="20%" class="bgBlack"><?php echo Yii::t('sellerBrand', '操作') ?></th>
            <th width="20%" class="bgBlack"><?php echo Yii::t('sellerBrand', '品牌状态') ?></th>
        </tr>
        <?php foreach ($brandInfo as $v): ?>
            <tr>
                <td class="ta_c"><?php echo $v->code ?></td>
                <td class="ta_c"><b><?php echo $v->name ?></b></td>
                <td class="ta_c"><?php echo CHtml::image(IMG_DOMAIN . '/' . $v->logo, $v->name, array('width' => 100, 'height' => 35)) ?></td>
                <td class="ta_c"><?php echo CHtml::link('<span>' . Yii::t('sellerBrand', '编辑') . '</span>', $this->createAbsoluteUrl('/seller/brand/update', array('id' => $v->id)), array('class' => 'sellerBtn01')) ?></td> 
                <td class="ta_c"><?php echo Brand::showStatus($v->status) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="page_bottom clearfix">
    <div class="pagination">
        <?php
        $this->widget('CLinkPager', array(
            'header' => '',
            'cssFile' => false,
            'firstPageLabel' => Yii::t('page', '首页'),
            'lastPageLabel' => Yii::t('page', '末页'),
            'prevPageLabel' => Yii::t('page', '上一页'),
            'nextPageLabel' => Yii::t('page', '下一页'),
            'pages' => $pages,
            'maxButtonCount' => 13
                )
        );
        ?>
    </div>
</div>

