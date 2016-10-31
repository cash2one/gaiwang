<?php
/* @var $this CityshowRightsController */
/* @var $model CityshowRights */

$this->breadcrumbs = array(
    '城市馆权限管理' => array('admin'),
    '列表',
);

Yii::app()->clientScript->registerScript('search', "
$('#search-form').submit(function(){
	$('#cityshow-rights-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php $this->renderPartial('_search', array(
    'model' => $model,
)); ?>
<?php if ($this->getUser()->checkAccess('CityshowRights.Create')): ?>
<div>
    <?php echo CHtml::button(Yii::t('cityshow', '添加商家'), array('class' => 'regm-sub add')) ?>
    说明：添加到列表的商家在卖家平台可看到城市馆管理模块，未在列表内的商家不能看到。
</div>
<?php endif; ?>
<?php $this->widget('GridView', array(
    'id' => 'cityshow-rights-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array('name'=>'create_time','type'=>'dateTime'),
        'gw',
        'store_name',
        array(
            'class'=>'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{delete}',
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'delete' => array(
                    'label' => Yii::t('brand', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('CityshowRights.Delete')"
                ),
            )
        ),
    ),
)); ?>
<script src="<?php echo MANAGE_DOMAIN ?>/js/iframeTools.js"></script>
<script>
    $(".add").click(function () {
        art.dialog.open("<?php echo $this->createAbsoluteUrl('create') ?>",{title:"添加商家",width:600,height:200});
    });
</script>