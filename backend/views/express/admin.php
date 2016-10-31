<?php $this->breadcrumbs = array(Yii::t('express', '物流公司管理') => array('admin'), Yii::t('express', '列表')); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#express-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('Express.Create')): ?>
    <input id="Btn_Add" type="button" value="<?php echo Yii::t('express', '添加物流公司'); ?>" class="regm-sub" onclick="location.href = '<?php echo Yii::app()->createAbsoluteUrl("/express/create"); ?>'">
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'express-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'name',
        'code',
        'url',
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('Express.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('Express.Delete')"
                ),
            )
        )
    ),
));
?>