<?php
/* @var $this GoodsController */
/* @var $model Goods */
$this->breadcrumbs = array('商品' => array('admin'), '列表');
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#goods-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php // $this->renderPartial('_search', array('model' => $model));        ?>
<?php
$this->widget('GridView', array(
    'id' => 'goods-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        'code',
        array(
            'header' => '商家名称',
            'value' => '$data->store_id',
        ),
        array(
            'header' => '所属分类',
            'value' => '$data->category_id ? $data->category->name : ""',
        ),
        'price',
        'gai_price',
        array(
            'name' => 'show',
            'value' => 'Goods::getShowLink($data->show,$data->id)',
            'type' => 'url',
        ),
        array(
            'name' => 'status',
            'value' => 'Goods::getStatus($data->status)',
        ),
        /*
          'brand_id',
          'sn',
          'content',
          'thumbnail',
          'views',
          'avg_score',
          'is_publish',
          'create_time',
          'update_time',
          'size',
          'weight',
          'is_score_exchange',
          'market_price',
          'gai_price',
          'price',
          'discount',
          'stock',
          'status',
          'show',
          'return_score',
          'fail_cause',
          'sales_volume',
          'freight_template_id',
          'freight_payment_type',
          'gai_income',
          'sort',
          'keywords',
          'description',
          'sign_integral',
          'type_id',
          'attribute',
          'goods_spec_id',
          'spec_picture',
         */
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}',
            'updateButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('goods', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('Express.Update')",
                ),
            ),
        )
    ),
));
?>
<script type="text/javascript">
    function Cancel(id, attrName) {

        $.post("<?php echo Yii::app()->createAbsoluteUrl('/goods/SetCancel') ?>", {id: id, YII_CSRF_TOKEN: "<?php echo Yii::app()->request->csrfToken; ?>"}, function(res) {
            if (res.state == 'success') {
                $parent = $("#" + attrName + id).parent();
                $("#" + attrName + id).remove();
                var attrname = attrName;
                $parent.append('<a href="javascript:show(' + id + ',' + attrname.toString() + ')" style="color:red">设为推荐</a>');
            }

        }, 'json');

    }
    function show(id, attrName) {
        $.post("<?php echo Yii::app()->createAbsoluteUrl('/goods/SetShow') ?>", {id: id, YII_CSRF_TOKEN: "<?php echo Yii::app()->request->csrfToken; ?>"}, function(res) {
            if (res.state == 'success') {
                $parent = $("#" + attrName + id).parent();
                $("#" + attrName + id).remove();
                var attrname = attrName;
                $parent.append("<a href='javascript:Cancel(" + id + "," + attrname.toString() + ")'>取消推荐</a>");
            }

        }, 'json');
    }
</script>