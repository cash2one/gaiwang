<?php
/*
 *城市列表视图 
 * @var CityCardController $this
 * @var CityCard $model 
 */

$this->breadcrumbs = array(
    Yii::t('citycard', '城市名片列表') => array('admin'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#travel-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

?>
<div class="search-form"><?php $this->renderPartial('_search', array('model' => $model)); ?></div>
<?php if (Yii::app()->user->checkAccess('CityCard.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('travel/cityCard/create') ?>"><?php echo Yii::t('citycard', '添加城市名片') ?></a>
    <div class="c10"></div>
<?php endif; ?>

<?php
$this->widget('GridView', array(
    'id' => 'travel-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'summaryText' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        'city_name',
       
        array(
            'class' => 'CButtonColumn',
            'header' => '操作',
            'buttons' => array(
                'view' => array(
                    'label' => Yii::t('citycard', '景点'),
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("travel/ViewSpot/admin", array("cityCardId"=>$data->id))',
                    'visible' => "Yii::app()->user->checkAccess('ViewSopt.Admin')"
                ),
                'update' => array(
                    'label' => Yii::t('citycard', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('CityCard.Update')"
                ),             
                'delete' => array(
                    'label' => Yii::t('citycard', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('CityCard.Delete')"
                ),
            ),
            'template' => '{update}{view}{delete}',
            'updateButtonLabel' => Yii::t('citycard', '编辑'),
            'updateButtonImageUrl' => false,         
            'deleteButtonLabel' => Yii::t('citycard', '删除'),
            'deleteButtonImageUrl' => false,
        ),
        
    ),
));
?>

