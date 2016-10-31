<?php
/* @var $this AppHotCategoryController */
/* @var $model AppHotCategory */
$this->breadcrumbs = array(Yii::t('AppHotCategory', '品质至上管理') => array('admin'), Yii::t('AppHotCategory', '品质至上列表'));
Yii::app()->clientScript->registerScript('search', "
$('#AppHotCategory-form').submit(function(){
	$('#AppHotCategory-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('AppHotCategory.Create')): ?>
    <a class="regm-sub" href="<?php echo $this->createAbsoluteUrl('/AppHotCategory/create') ?>"><?php echo Yii::t('AppHotCategory', '添加分类') ?></a>
<?php endif; ?>
<script type='text/javascript'>
    function del(){
        var category_name = $(this.parentNode.parentNode)[0].children[0].innerHTML;
        var url = this.href;
        art.dialog({
            content: '是否删除热卖分类{'+category_name+'}',
            ok: function(){
                location.href = url;
            },
            cancel: true
        });
        return false;
    }
</script>

<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'AppHotCategory-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'name',
            'value'=>'$data->name',
        ),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'order',
            'value'=>'$data->order',
        ),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'is_publish',
            'value'=>'AppHotCategory::getPublish($data->is_publish)',
        ),
        array(
            'headerHtmlOptions' => array('width' => '25%'),
            'name'=>'picture',
            'value'=>'ATTR_DOMAIN . "/" .$data->picture ',
        ),
        array(
            'headerHtmlOptions' => array('width' => '15%'),
            'name'=>'create_time',
            'value'=>'AppHotCategory::stampToDate($data->create_time)',
        ),
        array(
            'headerHtmlOptions' => array('width' => '15%'),
            'name'=>'update_time',
            'value'=>'AppHotCategory::stampToDate($data->update_time)',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('AppHotCategory', '操作'),
            'template'=>'{update} {delete}',
            'updateButtonImageUrl' => true,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'visible' => "Yii::app()->user->checkAccess('AppHotCategory.Update')",
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                ),
                'delete' => array(
                    'visible' => "Yii::app()->user->checkAccess('AppHotCategory.Delete')",
                    'options' => array('style' => 'width:83px; background: url("images/sub-fou.gif");'),
                    'click'=>'del',
                ),
                'view' => array(
                    'visible' => 'false'
                )
            )
        )
    ),
));
?>