<?php
/**
 * @var HotelController $this
 * @var Hotel $model
 * @var HotelPicture $pictures
 * @var CActiveForm $form
 */
$form = $this->beginWidget('ActiveForm', array(
    'id' => 'hotel-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true, // 客户端验证
    ),
));
?>
<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
<tr>
    <th class="title-th even" colspan="2" style="text-align: center;"><?php echo Yii::t('hotel', '基本信息及属性'); ?></th>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'sale_state'); ?>：</th>
    <td>
        <?php echo $form->dropDownList($model, 'sale_state', Hotel::getSaleState(), array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'sale_state'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'chn_name'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'chn_name', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'chn_name'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'eng_name'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'eng_name', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'eng_name'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'chn_address'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'chn_address', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'chn_address'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'eng_address'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'eng_address', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'eng_address'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'introduce'); ?>：</th>
    <td >
        <?php $this->widget('comext.wdueditor.WDueditor', array('model' => $model, 'attribute' => 'introduce')); ?>
        <div style="margin-bottom: 20px"><?php echo $form->error($model, 'introduce'); ?></div>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'telephone'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'telephone', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'telephone'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'web_site_url'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'web_site_url', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'web_site_url'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'star'); ?>：</th>
    <td>
        <?php echo $form->dropDownList($model, 'star', BaseInfo::getBaseInfo('StarCodes'), array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'star'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'layer_high'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'layer_high', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'layer_high'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'room_amount'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'room_amount', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'room_amount'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'pracice_date'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'pracice_date', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'pracice_date'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'fitment_date'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'fitment_date', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'fitment_date'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'parent_hotel_group'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'parent_hotel_group', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'parent_hotel_group'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'plate_id'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'plate_id', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'plate_id'); ?>
    </td>
</tr>

<tr>
    <th width="120px" align="right">
        <?php echo CHtml::label(Yii::t('hotel', '酒店所在地区'), false, array('required' => true)); ?>：
    </th>
    <td>
        <?php
        echo $form->dropDownList($model, 'nation_id', CHtml::listData(Nation::model()->findAll(), 'id', 'name'), array(
            'class' => 'text-input-bj',
            'prompt' => Yii::t('hotel', '国家'),
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('province/ajaxGetProvince'),
                'dataType' => 'json',
                'data' => array(
                    'nation_id' => 'js:this.value',
                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                ),
                'success' => 'function(data) {
                            $("#Hotel_province_code").html(data.dropDownProvinces);
                        }'
            )
        ));
        ?>
        <?php
        echo $form->dropDownList($model, 'province_code', isset($province)?$province:array(), array(
            'class' => 'text-input-bj',
            'prompt' => Yii::t('hotel', '选择省份'),
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('city/ajaxGetCity'),
                'dataType' => 'json',
                'data' => array(
                    'province_code' => 'js:this.value',
                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                ),
                'success' => 'function(data) {
                            $("#Hotel_city_code").html(data.dropDownCities);
                        }'
            )
        ));
        ?>
        <?php
        echo $form->dropDownList($model, 'city_code', isset($city)?$city:array(), array(
            'class' => 'text-input-bj',
            'prompt' => Yii::t('hotel', '选择城市'),
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('city/ajaxGetDisAndBus'),
                'dataType' => 'json',
                'data' => array(
                    'city_code' => 'js:this.value',
                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                ),
                'success' => 'function(data) {
                            $("#Hotel_distinct").html(data.dropDownDistrict);
                            $("#Hotel_business").html(data.dropDownBusiness);
                        }'
            )
        ));
        ?>
        <?php echo $form->dropDownList($model, 'distinct', isset($district)?$district:array(), array('class' => 'text-input-bj', 'prompt' => Yii::t('hotel', '选择行政区'))); ?>
        <?php echo $form->dropDownList($model, 'business', isset($business)?$business:array(), array('class' => 'text-input-bj', 'prompt' => Yii::t('hotel', '选择商业区'))); ?>
        <?php echo $form->error($model, 'nation_id'); ?>
        <?php echo $form->error($model, 'province_code'); ?>
        <?php echo $form->error($model, 'city_code'); ?>
        <?php echo $form->error($model, 'district'); ?>
        <?php echo $form->error($model, 'business'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'foreign_info'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'foreign_info', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'foreign_info'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'check_in_time'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'check_in_time', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'check_in_time'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'check_out_time'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'check_out_time', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'check_out_time'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'no_smoking_floor'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'no_smoking_floor', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'no_smoking_floor'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'appearance_pic_url'); ?>：</th>
    <td>
        <?php echo CHtml::activeFileField($model, 'appearance_pic_url'); ?>
        <?php echo $form->error($model, 'appearance_pic_url'); ?>
        <?php
        if (!$model->isNewRecord) {
            echo CHtml::hiddenField('appearance_pic_url_old', $model->appearance_pic_url);
            echo "<br>";
            echo CHtml::image(ATTR_DOMAIN . '/' . $model->appearance_pic_url, $model->chn_name, array('width' => '160px', 'height' => '80px'));
        }
        ?>

    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'service_fixture'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'service_fixture', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'service_fixture'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'room_fixture'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'room_fixture', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'room_fixture'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'free_service'); ?>：</th>
    <td>
        <?php echo $form->textField($model, 'free_service', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'free_service'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'other_fixture'); ?>：</th>
    <td>
        <?php echo $form->textArea($model, 'other_fixture', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'other_fixture'); ?>
    </td>
</tr>

<tr>
    <th width="120px" align="right">
        <?php echo CHtml::label('经纬度', false, array('required' => true)); ?>：
    </th>
    <td>
        <?php echo '纬度' ?>:
        <?php echo $form->textField($model, 'longitude', array('class' => 'text-input-bj middle')); ?>
        <?php echo '经度' ?>:
        <?php echo $form->textField($model, 'latitude', array('class' => 'text-input-bj middle')); ?>
        <input type="button" value="<?php echo '选择经纬度' ?>" onclick="mark_click()" class="regm-sub"/>
        <?php echo $form->error($model, 'longitude'); ?>
        <?php echo $form->error($model, 'latitude'); ?>
    </td>
</tr>
<tr>
    <th width="120px" align="right"><?php echo $form->labelEx($model, 'traffic_info'); ?>：</th>
    <td>
        <?php echo $form->textArea($model, 'traffic_info', array('class' => 'text-input-bj long')); ?>
        <?php echo $form->error($model, 'traffic_info'); ?>
    </td>
</tr>
<tr>
    <td colspan="2">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '保存', array('class' => 'reg-sub')); ?>
    </td>
</tr>
</table>
<?php $this->endWidget(); ?>

<script type="text/javascript" language="javascript" src="/js/iframeTools.source.js"></script>
<script type="text/javascript" language="javascript">
    var mark_click = function () {
        var url = '<?php echo Yii::app()->createAbsoluteUrl('/map/show') ?>';
        url += '&lng=' + $('#Hotel_longitude').val() + '&lat=' + $('#Hotel_latitude').val();
        dialog = art.dialog.open(url, {
            'title': '设定经纬度',
            'lock': true,
            'window': 'top',
            'width': 740,
            'height': 600,
            'border': true
        });
    };

    var onSelected = function (lat, lng) {
        $('#Hotel_longitude').val(lng);
        $('#Hotel_latitude').val(lat);
    };

    var doClose = function () {
        if (null != dialog) {
            dialog.close();
        }
    };

    function uploadifyRemove(fileId, attrName) {
        if (confirm('本操作不可恢复，确定继续？')) {
            $.post("<?php echo Yii::app()->createAbsoluteUrl('/hotel/remove') ?>", {
                imageId: fileId,
                YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken; ?>'
            }, function (res) {
                $("#" + attrName + fileId).remove();
            }, 'json');
        }
    }
    function uploadifyRemove2(fileId, attrName) {
        $("#" + attrName + fileId).remove();
    }
</script>

