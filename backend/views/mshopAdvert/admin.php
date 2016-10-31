<?php $this->breadcrumbs = array(Yii::t('advert', '广告位') => array('admin'), Yii::t('advert', '列表')); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#advert-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('MshopAdvert.Create')): ?>
    <input id="Btn_Add" type="button" value="<?php echo Yii::t('advert', '创建广告位'); ?>" class="regm-sub" onclick="location.href = '<?php echo $this->createAbsoluteUrl("/mshopAdvert/create"); ?>'" />
<?php endif; ?>
<?php if (Yii::app()->user->checkAccess('MshopAdvert.GenerateAllAdvertCache')): ?>
    <!--<a class="regm-sub" href="<?php // echo $this->createAbsoluteUrl('/advert/generateAllAdvertCache') ?>"><?php echo Yii::t('advert', '更新所有广告缓存') ?></a>-->
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'advert-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'name',
        'code',
        'content',
        array('name' => 'type', 'value' => 'Advert::getAdvertType($data->type)'),
        'width',
        'height',
        array('name' => 'direction', 'value' => 'Advert::getAdvertDirection($data->direction)'),
        array('name' => 'city_id', 'value' => 'Region::getName($data->city_id)'),
        array('name' => 'franchisee_category_id', 'value' => 'FranchiseeCategory::getFanchiseeCategoryName($data->franchisee_category_id )'),
        array('name' => 'category_id', 'value' => 'Category::getCategoryName($data->category_id )'),
        array('name' => 'status', 'value' => 'Advert::getAdvertStatus($data->status)'),
        array(
            'type' => 'raw',
            'name' => Yii::t('advert', '正在投放广告'),
            'value' => '$data->direction != Advert::TYPE_GOODS ? (" ".CHtml::link( $data->pictureCount, array("/MshopadvertPicture/admin","aid"=>"$data->id") ,array("class"=>"reg-sub" ))):" 无 "',
            'visible' => "Yii::app()->user->checkAccess('MshopAdvertPicture.Admin')",
        ),
        array(
            'type' => 'raw',
            'name' => Yii::t('advert', '正在投放商品'),
            'value' => '($data->direction == 5 || $data->direction == 11) && $data->type == Advert::TYPE_GOODS ? (" ".CHtml::link( $data->goodsCount, array("/MshopadvertGoods/admin","aid"=>"$data->id") ,array("class"=>"reg-sub" ))):" 无 "',
            'visible' => "Yii::app()->user->checkAccess('MshopAdvertGoods.Admin')",
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'deleteConfirmation' => Yii::t('advert', '删除广告位将连同删除所有所属广告，请谨慎操作！'),
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('MshopAdvert.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('MshopAdvert.Delete')"
                ),
            )
        )
    ),
));
?>