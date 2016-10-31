<?php
$this->breadcrumbs = array(
    Yii::t('sellerGoods', '商品搜索'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
        if (!$('#Goods_name').val()) {
            alert('" . Yii::t('sellerGoods', '请输入商品名') . "');
            return false;
        }
	$('#goods-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<script type="text/javascript" language="javascript" src="<?php echo DOMAIN ?>/js/iframeTools.source.js"></script>
<script type="text/javascript">
    var btnOKClick = function(obj) {
        var keyword = obj.hash.replace('#', '');

var id = keyword.match(/.+\$\*1\$\*/g).toString();
id = id.replace('\$\*1\$\*','');

var name = keyword.match(/\$\*1\$\*.+\$\*2\$\*/g).toString();
name = name.replace('\$\*1\$\*','');
name = name.replace('\$\*2\$\*','');

var thumb = keyword.match(/\$\*2\$\*.+\$\*3\$\*/g).toString();
thumb = thumb.replace('\$\*2\$\*','');
thumb = thumb.replace('\$\*3\$\*','');

var spec_id = keyword.match(/\$\*3\$\*.+/g).toString();
spec_id = spec_id.replace('\$\*3\$\*','');

        if (!id) {
            alert(<?php echo Yii::t('sellerGoods', "请选择商品"); ?>);
            return false;
        }
        var p = artDialog.open.origin;
        if (p && p.onSelectGoods) {
            p.onSelectGoods(id,name,thumb,spec_id);
        }
        p.doClose();
    }

    var btnCancelClick = function() {
        art.dialog.close();
    }
</script>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

<div class="seachToolbar">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="sellerT5">
        <tbody>
        <tr>	
          <th width="7%" class="ta_r"><?php echo Yii::t('sellerGoods', '请输入商品名'); ?>：</th>
            <td width="18%">
           			<?php echo $form->textField($model, 'g_name', array('class' => 'inputtxt1')); ?>
                    <?php echo CHtml::submitButton(Yii::t('sellerGoods', '搜索'), array('class' => 'reg-sub')); ?>
                    <?php echo CHtml::button(Yii::t('sellerGoods', '取消'), array('class' => 'reg-sub', 'onclick' => 'btnCancelClick()')); ?>
            </td>
            </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>

<?php
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
        array(
            'class' => 'CButtonColumn',
            'template' => '{select}',
            'buttons' => array(
                'select' => array(
                    'label' => Yii::t('sellerGoods','选择'),
					'url' => '"#".$data->goods_id."$*1$*".$data->g_name."$*2$*".$data->g_thumbnail."$*3$*".$data->id',
                    'options' => array(
                        'class' => 'reg-sub',
                        'onclick' => "btnOKClick(this)",
                    ),
                ),
            ),
        ),
        array(
			'name'=>Yii::t('sellerGoods','商品名'),
			'value'=>'$data->g_name',
		),
		array(
			'name'=>Yii::t('sellerGoods','规格'),
			'value'=>'GoodsSpec::buildSpecOutputStr($data->spec_name,$data->spec_value)',
// 			'value'=>'var_dump($data->spec_name,$data->spec_value)',
		),
array(
		'name'=>Yii::t('sellerGoods','规格零售价'),
		'value'=>'$data->price',
),
    ),
));


?>