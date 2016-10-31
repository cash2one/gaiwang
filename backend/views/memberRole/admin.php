<?php $this->breadcrumbs = array(Yii::t('memberRole', '会员角色管理') => array('admin'), Yii::t('memberRole', '列表')); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#memberRole-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('MemberRole.Create')): ?>
    <input id="Btn_Add" type="button" value="<?php echo Yii::t('memberRole', '添加会员角色'); ?>" class="regm-sub" onclick="location.href = '<?php echo Yii::app()->createAbsoluteUrl("/memberRole/create"); ?>'">
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'memberRole-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'name',
        'code',
        array('name' => 'thumbnail', 'value' => 'CHtml::image(ATTR_DOMAIN."/".$data->thumbnail, $data->name,
         array("width" => "22px", "height" => "22px","class"=>"roleImg"))', 'type' => 'raw'),
        'deadline',
        'description',
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('MemberRole.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('MemberRole.Delete')"
                ),
            )
        )
    ),
));
?>