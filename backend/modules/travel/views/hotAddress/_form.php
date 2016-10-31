<?php
/**
 * @var HotAddressController $this
 * @var HotAddress $model
 * @var CActiveForm $form
 */
$form = $this->beginWidget('ActiveForm', array(
    'id' => 'hotAddress-form',
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
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'name'); ?>：</th>
        <td>
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'name'); ?>
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
                'prompt' => '国家',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('province/ajaxGetProvince'),
                    'dataType' => 'json',
                    'data' => array(
                        'nation_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                    'success' => 'function(data) {
                            $("#HotAddress_province_code").html(data.dropDownProvinces);
                        }'
                )
            ));
            ?>
            <?php
            echo $form->dropDownList($model, 'province_code', isset($province)?$province:array(), array(
                'class' => 'text-input-bj',
                'prompt' => '选择省份',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('city/ajaxGetCity'),
                    'dataType' => 'json',
                    'data' => array(
                        'province_code' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                    'success' => 'function(data) {
                            $("#HotAddress_city_code").html(data.dropDownCities);
                        }'
                )
            ));
            ?>
            <?php echo $form->dropDownList($model, 'city_code', isset($city)?$city:array(), array('class' => 'text-input-bj', 'prompt' => Yii::t('hotel', '选择城市'))); ?>
            <?php echo $form->error($model, 'nation_id'); ?>
            <?php echo $form->error($model, 'province_code'); ?>
            <?php echo $form->error($model, 'city_code'); ?>

        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'introduce'); ?>：</th>
        <td>
            <?php echo $form->textArea($model, 'introduce', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'introduce'); ?>
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
        url += '&lng=' + $('#HotAddress_longitude').val() + '&lat=' + $('#HotAddress_latitude').val();
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
        $('#HotAddress_longitude').val(lng);
        $('#HotAddress_latitude').val(lat);
    };

    var doClose = function () {
        if (null != dialog) {
            dialog.close();
        }
    };
</script>
