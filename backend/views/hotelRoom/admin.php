<?php
/**
 * @var Hotel $hotel
 * @var HotelRoomController $this
 */
$this->breadcrumbs = array(
    Yii::t('hotelRoom', '酒店管理') => array('hotel/admin'),
    Yii::t('hotelRoom', '客房列表'),
 
    //<a href="javascript:history.back()" class="regm-sub">返回列表</a>
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#hotel-room-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<table class="tab-come" width="100%" cellspacing="0" cellpadding="0" border="0">
    <caption class=" title-th"><?php echo Yii::t('hotelRoom', '酒店基本信息'); ?></caption>
    <tbody>
        <tr>
            <th class="even"><?php echo $hotel->getAttributeLabel('name'); ?>： </th>
            <td class="even"><?php echo $hotel->name; ?></td>
            <th class="even"><?php echo $hotel->getAttributeLabel('level_id'); ?>： </th>
            <td class="even"><?php echo $hotel->level ? $hotel->level->name : ''; ?></td>
            <th class="even"><?php echo $hotel->getAttributeLabel('brand_id'); ?>： </th>
            <td class="even"><?php echo $hotel->brand ? $hotel->brand->name : ''; ?></td>
        </tr>
        <tr>
            <th class="odd"><?php echo $hotel->getAttributeLabel('province_id'); ?>： </th>
            <td class="odd"><?php echo $hotel->province ? $hotel->province->name : ''; ?></td>
            <th class="odd"><?php echo $hotel->getAttributeLabel('city_id'); ?>： </th>
            <td class="odd"><?php echo $hotel->city ? $hotel->city->name : ''; ?></td>
            <th class="odd"><?php echo $hotel->getAttributeLabel('street'); ?>： </th>
            <td class="odd"><?php echo $hotel->street; ?></td>
        </tr>
        <tr>
            <th class="even"><?php echo $hotel->getAttributeLabel('max_price'); ?>： </th>
            <td class="even"><?php echo $hotel->max_price; ?></td>
            <th class="even"><?php echo $hotel->getAttributeLabel('min_price'); ?>： </th>
            <td class="even"><?php echo $hotel->min_price; ?></td>
            <th class="even"><?php echo $hotel->getAttributeLabel('status'); ?>： </th>
            <td class="even"><span style="color: <?php echo $hotel->status == Hotel::STATUS_PUBLISH ? 'Green' : 'Red'; ?>"><?php echo Hotel::getStatus($hotel->status); ?></td>
        </tr>
        <tr>
            <th class="odd"><?php echo $hotel->getAttributeLabel('create_time'); ?>： </th>
            <td class="odd"><?php echo date('Y-m-d H:i:s', $hotel->create_time) ?></td>
            <th class="odd"><?php echo $hotel->getAttributeLabel('update_time'); ?>： </th>
            <td class="odd"><?php echo $hotel->update_time ? date('Y-m-d H:i:s', $hotel->update_time) : ''; ?></td>
            <th class="odd"> </th>
            <td class="odd"></td>
        </tr>
    </tbody>
</table>
<div class="c10"></div>
<?php if (Yii::app()->user->checkAccess('HotelRoom.Create')): ?>
    <?php echo CHtml::button('button', array(
        'value' => Yii::t('hotelRoom', '添加客房'),
        'class' => 'regm-sub',
        'onclick' => "location.href = '" . Yii::app()->createAbsoluteUrl("/hotelRoom/create", array('hotelId' => $hotel->id)) . "'",
    )); 
     echo CHtml::button('button', array(
        'value' => Yii::t('hotelRoom', '返回列表'),
        'class' => 'regm-sub',
        'onclick' =>"history.back()",
    )); ?>
    
    <div class="c10"></div>
<?php endif; ?>
<?php
$this->widget('GridView', array(
    'id' => 'hotel-room-grid',
    'dataProvider' => $dataProvider,
    'cssFile' => false,
    'itemsCssClass' => "tab-reg",
    'columns' => array(
        'name',
        array(
            'name' => 'thumbnail',
            'value' => 'CHtml::image(Tool::showImg(ATTR_DOMAIN . "/" . $data->thumbnail, "c_fill,h_60,w_60"), $data->name, array("width" => 60, "height" => 60, "style" => "display: inline-block;"))',
            'type' => 'raw', // 这里是原型输出
        ),
        'num',
        array(
            'name' => 'unit_price',
            'value' => 'HotelRoom::isActivity($data->activities_start, $data->activities_end) ? "<font color=\'red\'>" . Yii::t(\'hotelRoom\', \'特价\') . "$data->activities_price</font>" : $data->unit_price',
            'type' => 'raw'
        ),
        'estimate_price',
        array(
            'name' => 'breadfast',
            'value' => 'HotelRoom::getBreakfast($data->breadfast)',
        ),
        array(
            'name' => 'network',
            'value' => 'HotelRoom::getNetwork($data->network)',
        ),
        array(
            'name' => 'update_time',
            'value' => '$data->update_time ? date("Y-m-d H:i:s",$data->update_time) : ""',
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
            'value' => '"<span style=\'" . ($data->status == HotelRoom::STATUS_PUBLISH ? \'color: Green\' : \'color: Red\') . "\'>" . HotelRoom::getStatus($data->status) . "</span>"',
            'type' => 'raw',
        ),
        array(
            'class' => 'CButtonColumn',
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('hotelRoom', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('HotelRoom.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('hotelRoom', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('HotelRoom.Delete')"
                ),
            ),
            'template' => '{update}{delete}',
            'updateButtonLabel' => Yii::t('hotelRoom', '编辑'),
            'updateButtonImageUrl' => false,
            'deleteButtonLabel' => Yii::t('hotelRoom', '删除'),
            'deleteButtonImageUrl' => false,
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

            if (reg.exec(sort)) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->createAbsoluteUrl("/hotelRoom/ajaxUpdateSort"); ?>",
                    data: "id=" + id + "&sort=" + sort,
                    success: function(res) {
                        if (res) {
                            $("#" + id).remove();
                            $('.sort-' + id).attr('id', 'sort-' + id);
                            $('.sort-' + id).html(sort);
                            $('#hotel-room-grid').yiiGridView('update', {data: $(this).serialize()});
                        } else {
                            alert("<?php echo Yii::t('hotelRoom', '编辑失败'); ?>");
                        }
                    }
                });
            } else {
                alert("<?php echo Yii::t('hotelRoom', '请输入正整数'); ?>");
                return;
            }
        })
    }
</script>
