<?php
/**
 * @author zhenjun_xu <412530435@qq.com>
 *  DateTime 2016/4/23 15:12
 */
/* @var $this CityshowController */
/* @var $model CityshowGoods */
/** @var CActiveForm $form */
$this->breadcrumbs = array(
    '城市馆' => array('admin'),
);
if($cityshow){
    $this->breadcrumbs[] = $cityshow->title;
}
if($cityshowStore){
    $this->breadcrumbs[] = $cityshowStore->store->name;
}
if($theme){
    $this->breadcrumbs[] = '主题：'.$theme->name;
}
$this->breadcrumbs[] = "商品";
//$this->breadcrumbs = array(
//    '城市馆' => array('admin'),
//    $cityshow->title,
//    $cityshowStore->store->name,
//    '商品',
//);
Yii::app()->clientScript->registerScript('search', "
$('#search-form').submit(function(){
	$('#goods-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route, array('id' => $model->store_id)),
    'method' => 'get',
    'id' => 'search-form'
)); ?>
<div class="border-info clearfix">
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody>
        <tr>
            <th align="right">
                <?php echo Yii::t('cityshow', '商品id'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'goods_id', array('size' => 20, 'class' => 'text-input-bj  middle')); ?>
            </td>
        </tr>
        </tbody>
    </table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody>
        <tr>
            <th align="right">
                <?php echo Yii::t('cityshow', '商品名称'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'name', array('size' => 20, 'class' => 'text-input-bj  middle')); ?>
            </td>
        </tr>
        </tbody>
    </table>
    <?php echo CHtml::submitButton(Yii::t('cityshow', '搜索'), array('class' => 'reg-sub')) ?>
</div>

<?php $this->endWidget(); ?>


<?php $this->widget('GridView', array(
    'id' => 'goods-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array('name'=>'商品id','value'=>'$data->goods_id'),
        'sort',
        array('name'=>'商品名称','value'=>'$data->name'),
        array('name'=>'主题','value'=>'$data->theme->name'),
        array(
            'name'=>'商品图片',
            'value'=>'CHtml::image(Tool::showImg(IMG_DOMAIN."/".$data->thumbnail,"c_fill,h_70,w_70"))',
            'type'=>'raw',
            ),
        array(
            'name'=>'状态'
,            'value'=>'Goods::getStatus($data->g_status)'
        ),
    ),
));
?>

