<?php
/* @var $this CityshowController */
/* @var $model Cityshow */

$this->breadcrumbs=array(
	'城市馆'=>array('admin'),
	'列表',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#cityshow-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>

<?php $this->widget('GridView', array(
	'id'=>'cityshow-grid',
	'dataProvider'=>$model->search(),
	'cssFile' => false,
	'itemsCssClass' => 'tab-reg',
	'columns'=>array(
		'id',
		array(
            'name'=>'create_time',
            'type'=>'dateTime'
        ),
		'title',
        array(
            'name'=>'所属商家',
            'value'=>'$data->manageStore->name'
        ),
        array(
            'name'=>'region',
            'value'=>'$data->cityshowRegion->name',
        ),
		array(
            'name'=>'province',
            'value'=>'Region::getRegionName($data->province)',
        ),
        array(
            'name'=>'city',
            'value'=>'Region::getRegionName($data->city)',
        ),
        array(
            'name'=>'status',
            'value'=>'$data::getStatus($data->status)',
        ),
		array(
			'name'=>'source_type',
			'value'=>'$data::getSourceType($data->source_type)',
		),
        array(
            'name'=>'入驻商家',
            'value'=>'CHtml::link(CityshowStore::countStore($data->id),array("/cityshow/store","id"=>$data->id),array("style"=>"color:blue","title"=>"查看入驻商家"))',
            'type'=>'raw'
            ),
        array(
            'name'=>'主题',
            'value'=>'CHtml::link(CityshowTheme::getThemeCount($data->id),array("/cityshow/theme","id"=>$data->id),array("class"=>"store","style"=>"color:blue","title"=>"查看主题","data-id"=>$data->id))',
            'type'=>'raw'
            ),
        array(
            'name'=>'sort',
            'value'=>'CHtml::link($data->sort,"#",array("class"=>"sort","style"=>"color:blue","title"=>"修改","data-id"=>$data->id))',
            'type'=>'raw'
        ),
        array(
            'name'=>'is_show',
            'value'=>'CHtml::link($data::getShow($data->is_show),"#",array("data-id"=>$data->id,"class"=>"is_show","style"=>"color:blue"))',
            'type'=>'raw'
        ),		
		array(
			'class'=>'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('brand', '审核'),
                    'visible' => "Yii::app()->user->checkAccess('Cityshow.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('brand', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('Cityshow.Delete')"
                ),
            )
		),

	),
));
?>
<script src="<?php echo MANAGE_DOMAIN ?>/js/iframeTools.js"></script>
<script>
  $(function () {
      $(".sort").live('click',function () {
          art.dialog.open("<?php echo $this->createAbsoluteUrl('cityshow/sort') ?>&id=" + $(this).attr("data-id"),{
              title:"修改城市馆排序"
          });
          return false;
      });
      $(".is_show").live('click',function () {
          var status = $(this).html();
          var id = $(this).attr("data-id");
          art.dialog.confirm(status=='启用'? '你确认暂停该城市馆？':"你确认启用该城市馆", function(){
            $.post("<?php echo $this->createAbsoluteUrl('cityshow/changeShow') ?>",{id:id},function (msg) {
                jQuery.fn.yiiGridView.update('cityshow-grid');
                art.dialog.close();
            });
          }, function(){
              art.dialog.tips('你取消了操作');
          });
          return false;
      });
  });
</script>