<?php
/**
 * @var HotelController $this
 * @var Hotel $model
 */
$this->breadcrumbs = array(
    Yii::t('hotel', '酒店管理') => array('admin'),
    Yii::t('hotel', '管理'),
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $('#hotel-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>
<div class="search-form"><?php $this->renderPartial('_search', array('model' => $model)); ?></div>

<?php if (Yii::app()->user->checkAccess('Hotel.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/hotel/create') ?>"><?php echo Yii::t('hotel', '添加酒店') ?></a>
    <div class="c10"></div>
<?php endif; ?>

<?php
$this->widget('GridView', array(
    'id' => 'hotel-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'name' => 'thumbnail',
            'value' => 'CHtml::image(Tool::showImg(ATTR_DOMAIN . "/" . $data->thumbnail, "c_fill,h_80,w_100"), $data->name, array("width" => 100,"height" => 80, "style" => "display: inline-block"))',
            'type' => 'raw', // 这里是原型输出
        ),
        array(
            'name' => 'name',
            'value' => 'CHtml::link($data->name, "http://hotel." . SHORT_DOMAIN . "/site/view/" . $data->id, array("target" => "_blank"))',
            'type' => 'raw',
        ),
       array(
            'name' => 'countries_id',
            'value' => 'Region::getName($data->countries_id)',
        ),
        array(
            'name' => 'province_id',
            'value' => 'Region::getName($data->province_id)',
        ),
        array(
            'name' => 'city_id',
            'value' => 'Region::getName($data->city_id)',
        ),
        array(
            'name' => 'update_time',
            'value' => 'date("Y-m-d H:i:s",$data->update_time)',
        ),
        array(
            'class' => 'DataColumn',
            'name' => 'sort',
            'value' => '$data->sort',
            'evaluateHtmlOptions' => true,
            'htmlOptions' => array(
                'id' => '"sort-{$data->id}"',
                'class' => '"sort-{$data->id}"',
                'onclick' => '"clickEvent({$data->id})"',
            ),
        ),
        array(
            'name' => 'status',
            'value' => '"<span style=\'" . ($data->status == Hotel::STATUS_PUBLISH ? \'color: Green\' : \'color: Red\') . "\'>" . Hotel::getStatus($data->status) . "</span>"',
            'type' => 'raw',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => '操作',
            'template' => '{update}{room}{delete}',
            'updateButtonLabel' => Yii::t('hotel', '编辑'),
            'updateButtonImageUrl' => false,
            'deleteButtonLabel' => Yii::t('hotel', '删除'),
            'deleteButtonImageUrl' => false,
            'deleteConfirmation' => Yii::t('hotel', '此酒店下有客房信息，确认要删除所有客房信息！'),
            'buttons' => array(
                'room' => array(
                    'label' => Yii::t('hotel', '客房'),
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("/hotelRoom/admin",array("hotelId"=>$data->id))',
                    'visible' => "Yii::app()->user->checkAccess('HotelRoom.Admin')"
                ),
                'update' => array(
                    'label' => Yii::t('hotel', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('Hotel.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('hotel', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('Hotel.Delete')"
                ),
            ),
        ),
    ),
));
?>
<script>
    function clickEvent(id) {
        var val = $("#sort-" + id).text();
        $("#sort-" + id).html('');
        $("#sort-" + id).append("<input id='" + id + "' type='text' name='sort' value='" + val + "'/>");
        $("#sort-" + id).removeAttr('id');
        $("#" + id).focus();

        $('#' + id).mouseout(function() {
            var sort = $('#' + id).val();
            var reg = /^[0-9]*[1-9][0-9]*$/;
            if (sort > 255) sort = 255;

            if (reg.exec(sort) || sort==0) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->createAbsoluteUrl("/hotel/ajaxUpdateSort"); ?>",
                    data: "id=" + id + "&sort=" + sort,
                    success: function(res) {
                        if (res) {
                            $("#" + id).remove();
                            $('.sort-' + id).attr('id', 'sort-' + id);
                            $('.sort-' + id).html(sort);
                            $('#hotel-grid').yiiGridView('update', {data: $(this).serialize()});
                        } else {
                            alert("<?php echo Yii::t('hotel', '编辑失败'); ?>");
                        }
                    }
                });
            } else {
                alert("<?php echo Yii::t('hotel', '请输入(0-255)的数字'); ?>");
                return;
            }
        })
    }
</script>
