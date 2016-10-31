<?php
/* @var $this ScategoryController */
/* @var $model Scategory */

$this->breadcrumbs = array(
        Yii::t('franchiseeGoodsCategory', '线下商品分类管理'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#franchiseeGoodsCategory-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="mainContent">
    <div class="toolbar">
        <b><?php echo Yii::t('franchiseeGoodsCategory', '线下商品分类管理');?></b>
        <span><?php echo Yii::t('franchiseeGoodsCategory', '线下商品信息分类或修改。');?></span>
    </div>
    <?php echo CHtml::link(Yii::t('franchiseeGoodsCategory', '添加分类'), Yii::app()->createAbsoluteUrl('seller/franchiseeGoodsCategory/create'), array('class' => 'mt15 btnSellerAdd')) ?>
    <table id="treeGrid" width="100%" cellspacing="0" cellpadding="0" border="0"></table>
    <script type="text/javascript">
        jQuery(function($) {
            $('#treeGrid').treegrid({
                url: '<?php echo Yii::app()->createAbsoluteUrl('/seller/franchiseeGoodsCategory/getTreeGridData'); ?>',
                idField: 'id',
                treeField: 'name',
                queryParams: {'id': 0, 'franchisee_id': <?php echo $model->franchisee_id ?>, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'},
                columns: [[
                        {field: 'name', title: '<?php echo Yii::t('franchiseeGoodsCategory', '分类名称 ');?>', width: 200},
                        {field: 'description', title: '<?php echo Yii::t('franchiseeGoodsCategory', '描述');?>', width: 200},
                        {field: 'id', title: '<?php echo Yii::t('franchiseeGoodsCategory', '操作');?>', width: 340, formatter: function(value) {
                                return  "<a href='<?php echo $this->createUrl('/seller/franchiseeGoodsCategory/update'); ?>?id=" + value + "\'> <?php echo Yii::t('franchiseeGoodsCategory', '【编辑】 ');?> </a>" +
                                        "<a href='<?php echo $this->createUrl('/seller/franchiseeGoodsCategory/create'); ?>?pid=" + value + "\'> <?php echo Yii::t('franchiseeGoodsCategory', '【添加类别】 ');?> </a>" +
                                        "<a href='<?php echo $this->createUrl('/seller/franchiseeGoodsCategory/delete'); ?>?id=" + value + "\' onclick='if(confirm(\"<?php echo Yii::t('franchiseeGoodsCategory', '确定删除此分类？');?>\")==false)return false;'> <?php echo Yii::t('franchiseeGoodsCategory', '【删除】 ');?> </a>";
                            }}
                    ]],
                onBeforeExpand: function(row) {
                    //动态设置展开查询的url  
                    var url = "<?php echo Yii::app()->createAbsoluteUrl('/seller/franchiseeGoodsCategory/getTreeGridData'); ?>?id=" + row.id + '&YII_CSRF_TOKEN=<?php echo Yii::app()->request->csrfToken; ?>';
                    $("#treeGrid").treegrid("options").url = url;
                    return true;
                },
            });
        });
    </script>
</div>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/js/easyui/themes/default/easyui.css");
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/js/easyui/themes/icon.css");
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/easyui/jquery.easyui.min.js");
?>