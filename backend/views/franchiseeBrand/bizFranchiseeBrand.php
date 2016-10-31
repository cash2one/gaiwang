<?php
$this->breadcrumbs = array(
    Yii::t('franchisee', '加盟商品牌'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
//        if (!$('#FranchiseeBrand_name').val()) {
//            alert('" . Yii::t('franchisee', '请输入加盟商品牌名称') . "');
//            return false;
//        }
	$('#franchiseeBrand-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<script type="text/javascript">
    var btnOKClick = function(obj) {
        var tmp = obj.hash.replace('#', '').split('-');
        var id = tmp[0];
        var name = tmp[1];
//        alert('id = ' + id + ',name = ' + name);
        if (!id) {
            alert(<?php echo Yii::t('franchisee', "请选择加盟商"); ?>);
            return false;
        }
        var p = artDialog.open.origin;
        if (p && p.onSelectBizBrand) {
//            alert(id);
            p.onSelectBizBrand(id,name);
        }
        p.doClose();
    }

    var btnCancelClick = function() {
        art.dialog.close();
    }
</script>
<?php
$this->renderPartial('_search', array(
    'model' => $model,
));
?>

<?php
$this->widget('GridView', array(
    'id' => 'franchiseeBrand-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'class' => 'CButtonColumn',
            'template' => '{select}',
            'buttons' => array(
                'select' => array(
                    'label' => '选择',
                    'url' => '"#".$data->id."-".$data->name', 
                    'options' => array(
                        'class' => 'reg-sub',
                        'onclick' => "btnOKClick(this)",
                    ),
                ),
            ),
        ),
        'id',
        'name',
        'pinyin',
    ),
));
?>