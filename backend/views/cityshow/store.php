<?php
/**
 * @author zhenjun_xu <412530435@qq.com>
 *  DateTime 2016/4/23 15:12
 */
/* @var $this CityshowController */
/* @var $model Cityshow */
/** @var array $store */
$store = $model->store;
$this->breadcrumbs = array(
    '城市馆' => array('admin'),
    $model->title,
    '入驻商家',
);
Yii::app()->clientScript->registerScript('search', "
$('#search-form').submit(function(){
	$('#cityshowStore-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route, array('id' => $model->id)),
    'method' => 'get',
    'id' => 'search-form'
)); ?>
<div class="border-info clearfix">
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody>
        <tr>
            <th align="right">
                <?php echo Yii::t('cityshow', '商家名称'); ?>：
            </th>
            <td>
                <?php echo $form->textField($cityshowStore, 'name', array('size' => 20,  'class' => 'text-input-bj  middle')); ?>
            </td>
        </tr>
        </tbody>
    </table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody>
        <tr>
            <th align="right">
                <?php echo Yii::t('cityshow', '商家GW'); ?>：
            </th>
            <td>
                <?php echo $form->textField($cityshowStore, 'gw', array('size' => 20,  'class' => 'text-input-bj  middle')); ?>
            </td>
        </tr>
        </tbody>
    </table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody>
        <tr>
            <th>
                <?php echo $form->label($cityshowStore, '日期'); ?>：
            </th>
            <td>
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $cityshowStore,
                    'name' => 'create_time',
                ));
                ?> - <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $cityshowStore,
                    'name' => 'end_time',
                ));
                ?>
            </td>
        </tr>
        </tbody>
    </table>
    <?php echo CHtml::submitButton(Yii::t('cityshow', '搜索'), array('class' => 'reg-sub')) ?>
</div>

<?php $this->endWidget(); ?>


<?php $this->widget('GridView', array(
    'id' => 'cityshowStore-grid',
    'dataProvider' => $cityshowStore->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'id',
        array(
            'name' => 'create_time',
            'type' => 'dateTime'
        ),
        array('name' => 'GW号', 'value' => '$data->gw'),
        array('name' => '商家名称', 'value' => '$data->name'),
        array(
            'name'=>'参与商品',
            'type'=>'raw',
            'value'=>'CHtml::link(CityshowGoods::countGoods($data->id),"#",array("class"=>"goods","style"=>"color:blue","data-id"=>"$data->id"))'
        ),
        array(
            'name'=>'status',
            'value'=>'CHtml::link($data::status($data->status),"#",array("data-id"=>$data->id,"class"=>"status","style"=>"color:blue"))',
            'type'=>'raw'
        ),
        array(
            'class'=>'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'deleteButtonUrl'=>'Yii::app()->createUrl("cityshow/deleteStore",array("id"=>$data->id))',
            'buttons' => array(
                'delete' => array(
                    'label' => Yii::t('brand', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('Cityshow.DeleteStore')",
                ),
            )
        ),

    ),
));
?>
<script src="<?php echo MANAGE_DOMAIN ?>/js/iframeTools.js"></script>
<script>
    $(".goods").live('click',function () {
        art.dialog.open("<?php echo $this->createAbsoluteUrl('cityshow/goods') ?>&id=" + $(this).attr("data-id"),{
            title:"参与商品",
            width:900,
            height:600,
            lock:true
        });
        return false;
    });
    $(".status").live('click',function () {
        var status = $(this).html();
        var id = $(this).attr("data-id");
        art.dialog.confirm(status=='启用'? '你确认暂停该商家？':"你确认启用该商家", function(){
            $.post("<?php echo $this->createAbsoluteUrl('cityshow/changeStore') ?>",{id:id},function (msg) {
                jQuery.fn.yiiGridView.update('cityshowStore-grid');
                art.dialog.close();
            });
        }, function(){
            art.dialog.tips('你取消了操作');
        });
        return false;
    });
</script>
