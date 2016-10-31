<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'hotelAddress-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'name'); ?>：
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    <tr>
        <th style="width:120px" class="odd">
            <?php echo $form->labelEx($model, 'content'); ?>：
        </th>
        <td class="odd">
            <?php echo $form->textArea($model, 'content', array('class' => 'text-area text-area2')); ?>
            <?php echo $form->error($model, 'content'); ?>
        </td>
    </tr>
    <tr>
        <th style="width:120px" class="even">
            <?php echo Yii::t('hotelAddress', '所在地区') ?><span class="required">*</span>：
        </th>
        <td class="even">
            <?php
            echo $form->dropDownList($model, 'countries_id', CHtml::listData(Region::model()->findAll("parent_id=:pid", array(':pid' => 0)), 'id', 'name'), array(
                'prompt' => '选择国家',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/region/updateProvince'),
                    'dataType' => 'json',
                    'data' => array(
                        'countries_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                    'success' => 'function(data) {
                            $("#HotelAddress_province_id").html(data.dropDownProvinces);
                            $("#HotelAddress_city_id").html(data.dropDownCities);
                            $("#User_region_id").html(data.dropDownRegions);
                        }',
            )));
            ?>
            <?php echo $form->error($model, 'countries_id'); ?>
            <?php
            if ($model->isNewRecord) {
                echo $form->dropDownList($model, 'province_id', array(), array(
                    'prompt' => '选择省份',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/region/updateCity'),
                        'dataType' => 'json',
                        'data' => array(
                            'province_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => 'function(data) {
                            $("#HotelAddress_city_id").html(data.dropDownCities);
                            $("#User_region_id").html(data.dropDownRegions);
                        }',
                )));
            } else {
                echo $form->dropDownList($model, 'province_id', CHtml::listData(Region::model()->findAll("parent_id=:pid", array(':pid' => $model->countries_id)), 'id', 'name'), array(
                    'prompt' => '选择省份',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/region/updateCity'),
                        'dataType' => 'json',
                        'data' => array(
                            'province_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => 'function(data) {
                            $("#HotelAddress_city_id").html(data.dropDownCities);
                            $("#User_region_id").html(data.dropDownRegions);
                        }',
                )));
            }
            ?>
            <?php echo $form->error($model, 'province_id'); ?>
            <?php
            if ($model->isNewRecord) {
                echo $form->dropDownList($model, 'city_id', array(), array(
                    'prompt' => '选择城市',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/region/updateArea'),
                        //'update' => '#HotelAddress_region_id',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
            } else {
                echo $form->dropDownList($model, 'city_id', CHtml::listData(Region::model()->findAll("parent_id=:pid", array(':pid' => $model->province_id)), 'id', 'name'), array(
                    'prompt' => '选择城市',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/region/updateArea'),
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
            }
            ?>
            <?php echo $form->error($model, 'city_id'); ?>
        </td>

    </tr>
    <tr>
        <th style="width:120px" class="odd">
            <?php echo Yii::t('hotelAddress', '经纬度') ?><span class="required">*</span>：
        </th>
        <td class="odd"><?php echo Yii::t('hotelAddress', '纬度') ?>:
            <?php echo $form->textField($model, 'lat', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'lat'); ?>
            <?php echo Yii::t('hotelAddress', '经度') ?>:
            <?php echo $form->textField($model, 'lng', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'lng'); ?>
            <input type="button" value="<?php echo Yii::t('hotelAddress', '选择经纬度') ?>" onclick="mark_click()" class="regm-sub" />
        </td>

    </tr>
    <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'sort'); ?>：
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'sort'); ?>
        </td>
    </tr>

    <tr>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '保存', array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<script type="text/javascript" language="javascript">
                var mark_click = function() {
                    if ($('#HotelAddress_lng').val()) {
                        var lng = $('#HotelAddress_lng').val();
                    } else {
                        var lng = '<?php echo $this->lng; ?>';
                    }
                    if ($('#HotelAddress_lat').val()) {
                        var lat = $('#HotelAddress_lat').val();
                    } else {
                        var lat = '<?php echo $this->lat; ?>';
                    }
                    if ($('#LocLng').val()) {
                        var lng = $('#LocLng').val();
                    }
                    if ($('#LocLat').val()) {
                        var lat = $('#LocLat').val();
                    }

                    var url = '<?php echo Yii::app()->createAbsoluteUrl('/map/show') ?>';
                    url += '&lng=' + lng + '&lat=' + lat;
                    dialog = art.dialog.open(url, {
                        'title': '设定经纬度',
                        'lock': true,
                        'window': 'top',
                        'width': 740,
                        'height': 600,
                        'border': true
                    });
                };

                var onSelected = function(lat, lng) {
                    $('#HotelAddress_lng').val(lng);
                    $('#HotelAddress_lat').val(lat);
                };

                var doClose = function() {
                    if (null != dialog) {
                        dialog.close();
                    }
                };
</script>

