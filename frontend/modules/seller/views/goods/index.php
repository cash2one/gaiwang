<?php
/** @var  $this GoodsController */
/** @var $model Goods */
$title = Yii::t('sellerGoods', '我的宝贝列表');
$this->pageTitle = $title.'-'.$this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('sellerGoods', '宝贝管理 '),
    $title,
);
?>
<div class="toolbar">
    <b><?php echo Yii::t('sellerGoods','我的宝贝列表'); ?></b>
    <span><?php echo Yii::t('sellerGoods','集合上架宝贝信息及修改'); ?>。</span>
</div>
<?php $this->renderPartial('_search', array(
    'model' => $model,
)); ?>
<?php
//var_dump($model->sellerSearch($this->storeId));die;
$this->widget('GridView', array(
    'id' => 'goods-grid',
    'dataProvider' => $model->sellerSearch($this->storeId),
    'itemsCssClass' => 'mt15 sellerT3 goodsIndex',
    'cssFile'=>false,
    'pager'=>array(
        'class'=>'LinkPager',
        'htmlOptions'=>array('class'=>'pagination'),
    ),
    'pagerCssClass'=>'page_bottom clearfix',
    'columns' => array(
        'id',
        array(
            'name'=>'name',
            'value'=>'CHtml::link($data->name,
            Yii::app()->createAbsoluteUrl(\'/goods/\'.$data->id),array("target"=>"_blank"))',
            'headerHtmlOptions'=>array('width'=>'24%'),
            'type'=>'raw'
        ),
        array(
            'name'=>'thumbnail',
            'value'=>'CHtml::image(Tool::showImg(IMG_DOMAIN."/".$data->thumbnail,"c_fill,h_70,w_70"))',
            'type'=>'raw',
            'headerHtmlOptions'=>array('width'=>'15%'),
        ),
        array(
            'name'=>'is_publish',
            'value'=>'Goods::publishStatus($data->is_publish)',
            'type'=>'raw',
            'headerHtmlOptions'=>array('width'=>'7%'),
        ),
        array(
            'name'=>'stock',
            'value'=>'"<b class=\"red\">{$data->stock}</b>"',
            'type'=>'raw',
            'headerHtmlOptions'=>array('width'=>'5%'),
        ),
        array(
            'name'=>'sales_volume',
            'value'=>'"<b class=\"red\">{$data->sales_volume}</b>"',
            'type'=>'raw',
            'headerHtmlOptions'=>array('width'=>'5%'),
        ),
       array(
           'name'=> 'market_price',
           'value'=>'HtmlHelper::formatPrice($data->market_price)',
           'headerHtmlOptions'=>array('width'=>'5%'),
       ),
        array(
            'name'=>'price',
            'value'=>'HtmlHelper::formatPrice($data->price)',
            'headerHtmlOptions'=>array('width'=>'5%'),
        ),
        array(
            'name'=>'gai_price',
            'value'=>'HtmlHelper::formatPrice($data->gai_price)',
            'headerHtmlOptions'=>array('width'=>'5%'),
        ),
        array(
            'name' => 'status',
            'value' => 'Goods::getStatus($data->status)."<br/>".CHtml::link("审核记录","javascript:;",array("class"=>"audit blue","onclick"=>"audit(this)","data-url"=>Yii::app()->createUrl("/seller/goods/audit",array("goods_id"=>$data->id))))',
            'headerHtmlOptions'=>array('width'=>'8%'),
            'type'=>'raw'
        ),
        array(
            'name' => 'active_status',
            'value' => 'Goods::getActiveStatus($data->active_status,$data->date_end,$data->end_time,$data->seting_status,$data->date_start,$data->start_time,$data->categoryName)',
            'headerHtmlOptions'=>array('width'=>'12%'),
            'type'=>'raw',
        ),
        'customCUButton' => array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('sellerGoods','操作'),
            'template' => '<p>{updateBase}</p><p>{updateImportant}</p><p>{delete}  {preview}</p>',
            'deleteButtonLabel' => Yii::t('sellerGoods','删除'),
            'deleteButtonImageUrl' => false,
            'headerHtmlOptions'=>array('width'=>'12%'),
            'buttons'=>array(
                'updateBase'=>array(
                    'label'=>Yii::t('sellerGoods','基本信息编辑'),
                    'url'=>'Yii::app()->createAbsoluteUrl("/seller/goods/updateBase",array("id"=>$data->id))',
                ),
                'updateImportant'=>array(
                    'label'=>Yii::t('sellerGoods','重要信息编辑'),
                    'url'=>'Yii::app()->createAbsoluteUrl("/seller/goods/updateImportant",array("id"=>$data->id))',
                ),
                'preview'=>array(
                    'label'=>Yii::t('sellerGoods','预览'),
                    'url'=>'Yii::app()->createAbsoluteUrl("/goods/view",array("id"=>$data->id,"preview"=>Yii::app()->user->getState("enterpriseId")))',
                    'options'=>array('target'=>'_blank'),
                ),
            ),
        ),

    ),
));
?>
<script src="<?php echo DOMAIN ?>/js/artDialog/plugins/iframeTools.source.js" type="text/javascript"></script>
<script>
    function audit(url){
        art.dialog.open($(url).attr('data-url'),{width:"700px",height:"500px",lock:true});
        return false;
    }
</script>
