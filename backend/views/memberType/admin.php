<?php $this->breadcrumbs = array(Yii::t('memberType', '会员类型管理') => array('admin'), Yii::t('memberType', '列表')); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#memberType-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'memberType-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'name',
        array('name' => 'exchange', 'value' => 'MemberType::showExchange($data->exchange)'),
        'ratio',
        'sort',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'updateButtonLabel' => Yii::t('prepaidCard', '编辑'),
            'updateButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('MemberType.Update')"
                ),
            )
        ),
    ),
));
?>