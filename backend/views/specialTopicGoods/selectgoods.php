<?php
/* @var $this SpecialTopicGoodsController */
/* @var $model SpecialTopicGoods */
?>
<?php
$this->breadcrumbs = array(
    '专题管理',
    '选择商品',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#select-goods-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route, array('categoryId' => $this->specialCatId)),
        'method' => 'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th>商品名称：</th>
            <td><?php echo $form->textfield($model, 'name', array('class' => 'text-input-bj middle')) ?></td>
            <th>分类名称：</th>
            <td><?php echo CHtml::textField('categoryName', '', array('class' => 'text-input-bj least')) ?></td>
        </tr>
        <tr>
            <th>价格区间：</th>
            <td colspan="3">
                <?php echo CHtml::textField('minPrice', '', array('class' => 'text-input-bj least')) ?> 到
                <?php echo CHtml::textField('maxPrice', '', array('class' => 'text-input-bj least')) ?>
                <?php echo CHtml::submitButton('搜索', array('class' => 'reg-sub')); ?>
            </td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>

<a class="regm-sub" href="javascript:;" onClick="GetCheckbox();"><?php echo Yii::t('specialTopicCategory', '添加选中商品'); ?></a>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'select-goods-grid',
    'dataProvider' => $model->selectGoods(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'header' => '全选',
            'selectableRows' => 2,
            'class' => 'CCheckBoxColumn',
            'headerHtmlOptions' => array('width' => '33px'),
            'checkBoxHtmlOptions' => array('name' => 'selectdel[]'),
        ),
        'name',
        'code',
        array(
            'name' => 'category_id',
            'value' => '$data->category->name'
        ),
        'gai_price',
        'price',
        'stock',
    ),
));
?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<script type='text/javascript'>
    /*<![CDATA[*/
    var GetCheckbox = function() {
        var data = new Array();
        $("input:checkbox[name='selectdel[]']").each(function() {
            if ($(this).attr("checked") == 'checked') {
                data.push($(this).val());
            }
        });
        if (data.length > 0) {
            var url = '<?php echo Yii::app()->createAbsoluteUrl('/specialTopicGoods/addGoods', array('categoryId' => $this->specialCatId)); ?>';
            $.post(url, {'selectdel[]': data, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
                if (data == 'true') {
                    var p = artDialog.open.origin;
                    p.doClose();
                    if (p && p.refreshPage) {
                        p.refreshPage();
                    }
                }
            }, 'json');
        } else {
            alert("请选商品!");
        }
    }
    /*]]>*/
</script>