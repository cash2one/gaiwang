<?php
$this->breadcrumbs = array(
    Yii::t('franchiseeGroupbuyCategory', '类目') => array('admin'),
    Yii::t('franchiseeGroupbuyCategory', '列表'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#franchiseeGroupbuyCategory-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('FranchiseeGroupbuyCategory.Create')): ?>
    <input id="Btn_Add" type="button" value="添加类目" class="regm-sub" onclick="location.href = '<?php echo Yii::app()->createAbsoluteUrl("/franchiseeGroupbuyCategory/create"); ?>'">
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'franchiseeGroupbuyCategory-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'summaryText' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        array(
            'name' => 'parent_id',
            'value' => '($data->parent_id>0 && $pk = FranchiseeGroupbuyCategory::model()->findByPk($data->parent_id))?$pk->name : "一级类目"'
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('franchiseeGroupbuyCategory', '重命名'),
                    'visible' => "Yii::app()->user->checkAccess('FranchiseeGroupbuyCategory.Update')"
                ), 
                'delete' => array(
                    'label' => Yii::t('franchiseeGroupbuyCategory', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('FranchiseeGroupbuyCategory.Delete')",
                    'click' => 'function(){
                        $.ajax({
                            type:"GET",
                            url:"javascript:void(0)",
                            data:{id:"$data->id"},
                            dateType:"json",
                            success:function(json){
                                alert(json);
                            }
                        });
                    }'
                ),
            )
        )
    ),
));
?>


