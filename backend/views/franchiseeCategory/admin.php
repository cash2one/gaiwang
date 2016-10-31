<?php
$this->breadcrumbs = array(
    Yii::t('franchiseeCategory', '加盟商管理') => array('admin'),
    Yii::t('franchiseeCategory', '加盟商分类列表'),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#franchisee-category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php // $this->renderPartial('_search', array('model' => $model));   ?>
<?php if (Yii::app()->user->checkAccess('FranchiseeCategory.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/franchiseeCategory/create') ?>"><?php echo Yii::t('franchiseeActivityCity', '添加分类') ?></a>
<?php endif; ?>
<?php if (Yii::app()->user->checkAccess('FranchiseeCategory.GenerateAllCategoryCache')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/franchiseeCategory/generateAllCategoryCache') ?>"><?php echo Yii::t('category', '更新分类缓存') ?></a>
<?php endif; ?>
<div class="c10"></div>
<table id="treeGrid"></table>
<script type="text/javascript">
    jQuery(function($) {
        $('#treeGrid').treegrid({
            url: '<?php echo Yii::app()->createAbsoluteUrl('/franchiseeCategory/getCityTreeGrid'); ?>',
            idField: 'id',
            treeField: 'text',
            queryParams: {'id': 0, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'},
            columns: [[
                    {field: 'text', title: '分类名称', width: 200},
                    {field: 'show', title: '首页显示', width: 100, align: 'center', formatter: function(value) {
                            return value == 1 ? '是' : '否';
                        }},
                    {field: 'status', title: '状态', width: 50, align: 'center', formatter: function(value) {
                            return value == 1 ? '<?php echo Category::showStatus(1); ?>' : '<?php echo Category::showStatus(0); ?>';
                        }},
                    {field: 'sort', title: '排序', width: 50, align: 'center'},
                    {field: 'id', title: '操作', width: 340, formatter: function(value, row) {
                    if(row.parent_id == 0){
                        return  "<a href='<?php echo $this->createUrl('franchiseeCategory/update'); ?>&id=" + value + "\'> 【编辑】 </a>" +
                            "<a href='<?php echo $this->createUrl('franchiseeCategory/create'); ?>&parent_id=" + value + "\'> 【添加子类别】 </a>" +
                            "<a href='<?php echo $this->createUrl('franchiseeCategory/delete'); ?>&id=" + value + "\' onclick='return confirm(\"<?php echo Yii::t('franchiseeCategory', '确定要删除分类及所属子类数据吗?') ?>\");'> 【删除】 </a>";
                    }else{
                        return  "<a href='<?php echo $this->createUrl('franchiseeCategory/update'); ?>&id=" + value + "\'> 【编辑】 </a>" +
                            "<a href='<?php echo $this->createUrl('franchiseeCategory/delete'); ?>&id=" + value + "\' onclick='return confirm(\"<?php echo Yii::t('franchiseeCategory', '确定要删除分类及所属子类数据吗?') ?>\");'> 【删除】 </a>";
                    }

                    }}
                ]],
            onBeforeExpand: function(row) {
                //动态设置展开查询的url  
                var url = "<?php echo Yii::app()->createAbsoluteUrl('/franchiseeCategory/getCityTreeGrid'); ?>&id=" + row.id + '&YII_CSRF_TOKEN=<?php echo Yii::app()->request->csrfToken; ?>';
                $("#treeGrid").treegrid("options").url = url;
                return true;
            },
        });
    });
</script>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/js/easyui/themes/default/easyui.css");
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/js/easyui/themes/icon.css");
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/easyui/jquery.easyui.min.js");
?>