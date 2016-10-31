<?php
/* @var $this FranchiseeGroupbuyController */
/* @var $model FranchiseeGroupbuy */

$this->breadcrumbs = array(
    Yii::t('franchiseeGroupbuy', '线下团购 ') => array('admin'),
    Yii::t('franchiseeGroupbuy', '列表'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#franchiseeGroupbuy-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('FranchiseeGroupbuy.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/franchiseeGroupbuy/create') ?>"><?php echo Yii::t('franchiseeGroupbuy', '发布团购') ?></a>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'franchiseeGroupbuy-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'id',
        'name',
        array(
            'name' => 'thumbnail',
            'value' => 'CHtml::image(ATTR_DOMAIN.\'/\'.$data->thumbnail,$data->name,array("width"=>100,"height"=>50,"style"=>"margin:auto;"))',
            'type' => 'raw', //这里是原型输出
            'htmlOptions' => array(
                'width' => '150',
//                'style' => 'vertical-align:middle;',
                
            )
        ),
        array(
            'name' => 'status',
            'value' => 'FranchiseeGroupbuy::showStatus($data->status)'
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('FranchiseeGroupbuy.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('FranchiseeGroupbuy.Delete')"
                ),
            )
        )
    ),
));
?>