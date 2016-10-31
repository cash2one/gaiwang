<?php
/* @var $this AppHotCategoryController */
/* @var $model AppHotCategory */
$this->breadcrumbs = array(Yii::t('AppTopic', '主题'), Yii::t('AppTopicHouse', '仕品'));
Yii::app()->clientScript->registerScript('search', "
$('#AppTopic-form').submit(function(){
	$('#AppTopic-house').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php if (Yii::app()->user->checkAccess('AppTopicHouse.Create')): ?>
    <a class="regm-sub" onclick="return reTure()" href="<?php echo $this->createAbsoluteUrl('/AppTopicHouse/create/') ?>"><?php echo Yii::t('AppTopicHouse', '添加馆') ?></a>
<?php endif; ?>
<?php if (Yii::app()->user->checkAccess('AppTopicHouse.TitlePic')): ?>
    <a class="regm-sub" href="<?php echo $this->createAbsoluteUrl('/AppTopicHouse/TitlePic/') ?>"><?php echo Yii::t('AppTopicHouse', '添加标题图片') ?></a>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'AppTopic-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'headerHtmlOptions' => array('width' => '25%'),
            'name'=>'title',
            'value'=>'$data->title',
        ),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'commodity_num',
            'value'=>'$data->commodity_num',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('AppTopic', '操作'),
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'template' => '{addgoods}{update}{delete}',
            'buttons' => array(
                'addgoods' => array(
                    'label' => Yii::t('AppHotCategory', '商品'),
                    'url' => 'Yii::app()->createUrl("appTopicHouse/addGoodsView",array("id"=>$data->id))',
                    'visible' => "Yii::app()->user->checkAccess('AppTopicHouse.Goods')"
                ),
                'update' => array(
                    'label' => Yii::t('AppHotCategory', '更新'),
                    'visible' => "Yii::app()->user->checkAccess('AppTopicHouse.Update')",
                ),
                'delete' => array(
                    'label' => Yii::t('AppHotCategory', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('AppTopicHouse.Delete')"
                ),
                'view' => array(
                    'visible' => 'false'
                )
            )
        )
    ),
));
?>
<script>
    function reTure(){
        var houseSum = <?php echo AppTopicHouse::getHouseSum();?>;
        if(houseSum == <?php echo AppTopicHouse::HOUSE_SUM;?>) {
            alert('只能添加3个馆');
            return false;
        }
        return true;
    }
</script>

