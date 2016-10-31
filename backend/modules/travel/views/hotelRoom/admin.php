<?php
/**
 * @var HotelController $this
 * @var Hotel $model
 */
$this->breadcrumbs = array(
    Yii::t('hotel', '酒店管理') => array('admin'),
    Yii::t('hotel', '房间列表'),
);
?>

<div>
    <table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
        <tr>
            <th class="title-th even" colspan="6"
                style="text-align: center;"><?php echo Yii::t('hotel', '酒店基本信息'); ?></th>
        </tr>
        <tr>
            <th width="13%" align="right"><?php echo '酒店名称' ?>：</th>
            <td width="20%">
                <?php echo $hotel->chn_name; ?>
            </td>
            <th width="13%" align="right"><?php echo '等级' ?>：</th>
            <td width="20%">
                <?php echo $hotel->star; ?>
            </td>
            <th width="14%" align="right"><?php echo '酒店品牌' ?>：</th>
            <td width="20%">
                <?php echo $hotel->plate_id; ?>
            </td>
        </tr>
        <tr>
            <th width="13%" align="right"><?php echo '城市' ?>：</th>
            <td width="20%">
                <?php echo City::model()->find(array('select' => 'name', 'condition' => 'code=:code', 'params' => array(':code' => $hotel->city_code)))->name; ?>
            </td>
            <th width="13%" align="right"><?php echo '详细地址' ?>：</th>
            <td width="20%">
                <?php echo $hotel->chn_address; ?>
            </td>
        </tr>
        <tr>
            <th width="13%" align="right"><?php echo '最高价（今日）' ?>：</th>
            <td width="20%">
                <?php //echo $hotel->chn_name; ?>
            </td>
            <th width="13%" align="right"><?php echo '最低价（今日）' ?>：</th>
            <td width="20%">
                <?php //echo $hotel->star; ?>
            </td>
            <th width="14%" align="right"><?php echo '状态' ?>：</th>
            <td width="20%">
                <?php echo Hotel::getStatus($hotel->status); ?>
            </td>
        </tr>
        <tr>
            <th width="13%" align="right"><?php echo '创建时间' ?>：</th>
            <td width="20%">
                <?php echo date('Y-m-d H:i:s', $hotel->created_at); ?>
            </td>
            <th width="13%" align="right"><?php echo '更新时间' ?>：</th>
            <td width="20%">
                <?php echo date('Y-m-d H:i:s', $hotel->updated_at); ?>
            </td>
        </tr>
    </table>
</div>

<?php if (Yii::app()->user->checkAccess('Hotel.Create') && $hotel->source == Hotel::SOURCE_BY_HAND): ?>
    <a class="regm-sub"
       href="<?php echo Yii::app()->createAbsoluteUrl('travel/hotelRoom/create', array('hotelId' => $hotel->hotel_id)) ?>"><?php echo Yii::t('hotel', '添加房间') ?></a>
    <div class="c10"></div>
<?php endif; ?>

<?php
$this->widget('GridView', array(
    'id' => 'hotel-room-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'ajaxUpdate' => false,
    'columns' => array(
        array(
            'name' => 'hotel_id',
        ),
        array(
            'name' => 'updated_at',
            'value' => '$data->updated_at',
            'type' => 'datetime',
        ),
        array(
            'name' => 'name',
        ),
        'num',
        'acreage',
        'floor',
        'max_num_of_persons',
        'equipment',
        array(
            'name' => '设备描述',
            'value' => 'Tool::truncateUtf8String($data->equipment_desc,10)',
            //'htmlOptions' => array('title'=>'$data->chn_address'),
        ),
        'has_net',
        'flag_add_bed',
        'bed_type',
        'add_bed_num',
        'remark',

        array(
            'class' => 'CButtonColumn',
            'header' => '操作',
            'template' => '{ratePlan}{update}{room}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'deleteConfirmation' => Yii::t('hotel', '此客房下有信息，确认要删除所有信息！'),
            'buttons' => array(
                'ratePlan' => array(
                    'label' => Yii::t('hotel', '价格计划'),
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("travel/ratePlan/admin",array("hotelId"=>$data->hotel_id,"roomId"=>$data->room_id))',
                    'visible' => "Yii::app()->user->checkAccess('HotelRoom.Admin')",
                    'options' => array(
                        'style' => 'width:70px;border-radius:3px;background: url("images/sub-fou.gif");',
                    ),
                ),
                'room' => array(
                    'label' => Yii::t('hotel', '库存'),
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("travel/hotelRoom/setStock",array("roomId"=>$data->room_id))',
                    'visible' => "Yii::app()->user->checkAccess('HotelRoom.Admin')"
                ),
                'update' => array(
                    'label' => Yii::t('hotel', '编辑'),
                    'url' => 'Yii::app()->createUrl("travel/hotelRoom/update",array("roomId"=>$data->room_id))',
                    'visible' => "Yii::app()->user->checkAccess('Hotel.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('hotel', '删除'),
                    'url' => 'Yii::app()->createUrl("travel/hotelRoom/delete",array("roomId"=>$data->room_id))',
                    'visible' => "Yii::app()->user->checkAccess('Hotel.Delete')"
                ),
            ),
        ),
    ),
));
?>

