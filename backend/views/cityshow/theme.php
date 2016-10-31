<?php
/**
 * @author zhenjun_xu <412530435@qq.com>
 * Date: 2016/4/24
 * Time: 13:46
 */
/* @var $this CityshowController */
/* @var $model Cityshow */
/** @var $theme CityshowTheme */
$this->breadcrumbs = array(
    '城市馆' => array('admin'),
    $model->title,
    '主题',
);
Yii::app()->clientScript->registerScript('search', "
$('#search-form').submit(function(){
	$('#cityshowTheme-grid').yiiGridView('update', {
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
                <?php echo Yii::t('cityshow', '主题名称'); ?>：
            </th>
            <td>
                <?php echo $form->textField($theme, 'name', array('size' => 20, 'class' => 'text-input-bj  middle')); ?>
            </td>
        </tr>
        </tbody>
    </table>
    <?php echo CHtml::submitButton(Yii::t('cityshow', '搜索'), array('class' => 'reg-sub')) ?>
</div>

<?php $this->endWidget(); ?>


<?php
$this->widget('GridView', array(
    'id' => 'cityshowTheme-grid',
    'dataProvider' => $theme->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'sort',
        'name',
        array('name' => '所在馆', 'value' => '$data->cityshow->title'),
        array(
            'name' => '参与商品',
            'type' => 'raw',
            'value' => 'CHtml::link(CityshowGoods::countGoods($data->id,"theme_id"),"#",array("class"=>"goods","style"=>"color:blue","data-id"=>$data->id,"data-cid"=>$data->cityshow_id))'
        ),
        array(
            'name' => '操作',
            'type' => 'raw',
            'value'=>'CHtml::link("修改排序","#",array("class"=>"sort","style"=>"color:blue","title"=>"修改","data-id"=>$data->id))',
        ),
    ),
));
?>
<script src="<?php echo MANAGE_DOMAIN ?>/js/iframeTools.js"></script>
<script>
    $(".goods").live('click', function () {
        var url = "<?php echo $this->createAbsoluteUrl('cityshow/goods') ?>&theme_id=" + $(this).attr("data-id") + "&cityshow_id=" + $(this).attr("data-cid");
        art.dialog.open(url, {
            title: "参与商品",
            width: 900,
            height: 600,
            lock: true
        });
        return false;
    });
    $(".sort").live('click', function () {
        art.dialog.open("<?php echo $this->createAbsoluteUrl('cityshow/themeSort') ?>&id=" + $(this).attr("data-id"),{
            title:"修改城市馆排序"
        });
        return false;
    });
</script>

