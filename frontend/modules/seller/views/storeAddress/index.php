<?php
/* @var $this StoreAddressController */
/* @var $model storeAddress */

$title = Yii::t('storeAddress', '地址库');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('storeAddress', '交易管理 '),
    $title,
);
?>
<div class="toolbar">
    <b><?php echo Yii::t('storeAddress', '地址库'); ?></b>
    <span><?php echo Yii::t('storeAddress', '快递取件地址。'); ?></span>
</div>
<?php echo CHtml::link(Yii::t('storeAddress', '添加地址'), array('/seller/storeAddress/create'), array('class' => 'mt15 btnSellerAdd'));
?>
<?php
$this->widget('GridView', array(
    'id' => 'store-address-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'mt15 sellerT3 goodsIndex',
    'cssFile' => false,
    'pager' => array(
        'class' => 'LinkPager',
        'htmlOptions' => array('class' => 'pagination'),
    ),
    'pagerCssClass' => 'page_bottom clearfix',
    'columns' => array(
        'link_man',
        array(
            'name' => 'province_id',
            'value' => 'Region::getName($data->province_id, $data->city_id, $data->district_id)'
        ),
        'street',
        'zip_code',
        'mobile',
        'store_name',
        array(
            'name' => 'default',
            'value' => 'storeAddress::setDefault($data)',
            'type' => 'raw',
        ),
        'customCUButton' => array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('storeAddress', '操作'),
            'template' => '<p>{update}</p><p>{delete}</p>',
            'updateButtonLabel' => Yii::t('storeAddress', '编辑'),
            'deleteButtonImageUrl' => false,
            'updateButtonImageUrl' => false,
            'headerHtmlOptions' => array('width' => '12%'),
            'afterDelete'=>'function(a,b,data){
                if(data.length>0) alert(data);
            }',
        ),
    ),
));
?>


