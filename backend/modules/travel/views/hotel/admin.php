<?php
/**
 * @var HotelController $this
 * @var Hotel $model
 */
$this->breadcrumbs = array(
    Yii::t('hotel', '酒店管理') => array('admin'),
    Yii::t('hotel', '酒店列表'),
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
    <a class="regm-sub"
       href="<?php echo Yii::app()->createAbsoluteUrl('travel/hotel/create') ?>"><?php echo Yii::t('hotel', '添加酒店') ?></a>
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
            'name' => 'appearance_pic_url',
            'value' => 'CHtml::image(ATTR_DOMAIN ."/" .$data->appearance_pic_url, $data->chn_name, array("width" => 100,"height" => 80, "style" => "display: inline-block"))',
            'type' => 'raw', // 这里是原型输出
        ),

        array(
            'name' => 'hotel_id',
        ),
        array(
            'name' => 'updated_at',
            'value' => '$data->updated_at',
            'type' => 'datetime',
        ),
        array(
            'name' => 'chn_name',
        ),
        array(
            'name' => '中文地址',
            'value' => 'Tool::truncateUtf8String($data->chn_address,10)',
            //'htmlOptions' => array('title'=>'$data->chn_address'),
        ),
        array(
            'name' => 'sale_state',
            'value' => 'Hotel::getSaleState($data->sale_state)',
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
            'name' => '国家',
            'value' => '$data->mCity->province->nation->name',
        ),
        array(
            'name' => '省份',
            'value' => '$data->mCity->province->name',
        ),
        array(
            'name' => '城市',
            'value' => '$data->mCity->name',
        ),
        array(
            'name' => '来源',
            'value' => 'Hotel::getSource($data->source)',
        ),

        array(
            'class' => 'CButtonColumn',
            'header' => '操作',
            'template' => '{picture}{update}{room}{delete}',
            'updateButtonLabel' => Yii::t('hotel', '编辑'),
            'updateButtonImageUrl' => false,
            'deleteButtonLabel' => Yii::t('hotel', '删除'),
            'deleteButtonImageUrl' => false,
            'deleteConfirmation' => Yii::t('hotel', '此酒店下有客房信息，确认要删除所有客房信息！'),
            'buttons' => array(
                'picture' => array(
                    'label' => Yii::t('hotel', '图片'),
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("travel/hotelPicture/admin",array("hotelId"=>$data->hotel_id))',
                    'visible' => "Yii::app()->user->checkAccess('Travel.Hotel.Admin')"
                ),
                'room' => array(
                    'label' => Yii::t('hotel', '客房'),
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("travel/hotelRoom/admin",array("hotelId"=>$data->hotel_id))',
                    'visible' => "Yii::app()->user->checkAccess('Travel.Hotel.Admin')"
                ),
                'update' => array(
                    'label' => Yii::t('hotel', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('Travel.Hotel.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('hotel', '删除'),
                    'url' => 'Yii::app()->createUrl("travel/hotel/delete",array("hotelId"=>$data->hotel_id))',
                    'visible' => "Yii::app()->user->checkAccess('Travel.Hotel.Delete')"
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

        $('#' + id).mouseout(function () {
            var sort = $('#' + id).val();
            var reg = /^[0-9]*[1-9][0-9]*$/;
            if (sort > 255) sort = 255;

            if (reg.exec(sort) || sort == 0) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->createAbsoluteUrl("travel/hotel/ajaxUpdateSort"); ?>",
                    data: "id=" + id + "&sort=" + sort,
                    success: function (res) {
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
