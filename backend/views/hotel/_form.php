<?php
/**
 * @var HotelController $this
 * @var Hotel $model
 * @var HotelPicture $pictures
 * @var CActiveForm $form
 */
$form = $this->beginWidget('CActiveForm', array(
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
            echo $form->dropDownList($model, 'countries_id', CHtml::listData(Region::model()->findAll("parent_id = :pid", array(':pid' => 0)), 'id', 'name'), array(
                'class' => 'text-input-bj',
                'prompt' => Yii::t('hotel', '国家'),
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/region/updateProvince'),
                    'dataType' => 'json',
                    'data' => array(
                        'countries_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                    'success' => 'function(data) {
                            $("#Hotel_province_id").html(data.dropDownProvinces);
                            $("#Hotel_city_id").html(data.dropDownCities);
                            $("#Hotel_district_id").html(data.dropDownCounties);
                        }'
                )
            ));
            ?>
            <?php
            echo $form->dropDownList($model, 'province_id', $province, array(
                'class' => 'text-input-bj',
                'prompt' => Yii::t('hotel', '选择省份'),
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/region/updateCity'),
                    'dataType' => 'json',
                    'data' => array(
                        'province_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                    'success' => 'function(data) {
                            $("#Hotel_city_id").html(data.dropDownCities);
                            $("#Hotel_district_id").html(data.dropDownCounties);
                        }'
                )
            ));
            ?>
            <?php
            echo $form->dropDownList($model, 'city_id', $city, array(
                'class' => 'text-input-bj',
                'prompt' => Yii::t('hotel', '请选择'),
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/region/updateArea'),
                    'update' => '#Hotel_district_id',
                    'data' => array(
                        'city_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                )
            ));
            ?>
            <?php echo $form->dropDownList($model, 'district_id', $district, array('class' => 'text-input-bj', 'prompt' => Yii::t('hotel', '请选择'))); ?>
            <?php echo $form->error($model, 'countries_id'); ?>
            <?php echo $form->error($model, 'province_id'); ?>
            <?php echo $form->error($model, 'city_id'); ?>
            <?php echo $form->error($model, 'district_id'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'phone'); ?>：</th>
        <td>
            <?php echo $form->textField($model, 'phone', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'phone'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'street'); ?>：</th>
        <td>
            <?php echo $form->textField($model, 'street', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'street'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right">
            <?php echo CHtml::label(Yii::t('hotel', '经纬度'), false, array('required' => true)); ?>：
        </th>
        <td>
            <?php echo Yii::t('hotel', '纬度') ?>:
            <?php echo $form->textField($model, 'lat', array('class' => 'text-input-bj middle')); ?>
            <?php echo Yii::t('hotel', '经度') ?>:
            <?php echo $form->textField($model, 'lng', array('class' => 'text-input-bj middle')); ?>
            <input type="button" value="<?php echo Yii::t('hotel', '选择经纬度') ?>" onclick="mark_click()" class="regm-sub" />
            <?php echo $form->error($model, 'lat'); ?>
            <?php echo $form->error($model, 'lng'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'address_id'); ?>：</th>
        <td>
            <?php
            echo $form->dropDownList($model, 'address_id', CHtml::listData(HotelAddress::model()->findAll(array('order' => 'sort desc')), 'id', 'name'), array('class' => 'text-input-bj', 'empty' => Yii::t('hotel', '请选择'))
            );
            ?>
            <?php echo $form->error($model, 'address_id'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'level_id'); ?>：</th>
        <td>
            <?php
            echo $form->radioButtonList($model, 'level_id', CHtml::listData(HotelLevel::model()->findAll(array('order' => 'sort DESC')), 'id', 'name'), array('separator' => '&nbsp;&nbsp;')
            );
            ?>
            <?php echo $form->error($model, 'level_id'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'brand_id'); ?>：</th>
        <td>
            <?php
            echo $form->dropDownList($model, 'brand_id', CHtml::listData(HotelBrand::model()->findAll(array('order' => 'sort DESC')), 'id', 'name'), array('class' => 'text-input-bj', 'empty' => Yii::t('hotel', '请选择'))
            );
            ?>
            <?php echo $form->error($model, 'brand_id'); ?>
        </td>
    </tr>
    <tr>
        <th width="200px" align="right"><?php echo $form->labelEx($model, 'grade_id'); ?>：</th>
        <td>
            <?php echo $form->radioButtonList($model, 'grade_id', CHtml::listData(MemberGrade::model()->findAll(), 'id', 'name'), array('separator' => '&nbsp;&nbsp;')); ?>
            <?php echo $form->error($model, 'grade_id'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'parking_lot'); ?>：</th>
        <td>
            <?php echo $form->radioButtonList($model, 'parking_lot', Hotel::getParkingLot(), array('separator' => '&nbsp;&nbsp;')); ?>
            <?php echo $form->error($model, 'parking_lot'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'pickup_service'); ?>：</th>
        <td>
            <?php echo $form->radioButtonList($model, 'pickup_service', Hotel::getPickupService(), array('separator' => '&nbsp;&nbsp;')); ?>
            <?php echo $form->error($model, 'pickup_service'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'meeting_room'); ?>：</th>
        <td>
            <?php echo $form->radioButtonList($model, 'meeting_room', Hotel::getMeetingRoom(), array('separator' => '&nbsp;&nbsp;')); ?>
            <?php echo $form->error($model, 'meeting_room'); ?>
        </td>
    </tr>
    <tr><th class="title-th even" colspan="2" style="text-align: center;"><?php echo Yii::t('hotel', '展示信息'); ?></th></tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'thumbnail'); ?>：</th>
        <td>
            <?php echo $form->fileField($model, 'thumbnail') ?>
            <?php if (!$model->isNewRecord): ?>
                <?php $img = Tool::showImg(ATTR_DOMAIN . '/' . $model->thumbnail, 'c_fill,w_100,h_80') ?>
                <?php
                echo CHtml::link(CHtml::image($img), ATTR_DOMAIN . DS . $model->thumbnail, array('onclick' => 'return _showBigPic(this)'));
                ?>
            <?php endif; ?>
            <?php echo $form->error($model, 'thumbnail', array(), false); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($pictures, 'path'); ?>：</th>
        <td>
            <?php
            $this->widget('common.widgets.CUploadPic', array(
                'form' => $form,
                'model' => $pictures,
                'attribute' => 'path',
                'num' => 5,
                'folder_name' => 'files',
            ));
            ?>
            <?php echo $form->error($pictures, 'path', array('style' => 'position: relative; display: inline-block'), false, false); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'content'); ?>：</th>
        <td class="odd">
            <?php $this->widget('comext.wdueditor.WDueditor', array('model' => $model, 'attribute' => 'content')); ?>
            <?php echo $form->error($model, 'content'); ?><br/>
        </td>
    </tr>	
    <tr><th class="title-th" colspan="2" style="text-align: center;"><?php echo Yii::t('hotel', '状态信息'); ?></th></tr>

    <?php if(!$model->isNewRecord):?>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'status'); ?>：</th>
        <td>
            <?php echo $form->radioButtonList($model, 'status', Hotel::getStatus(), array('separator' => '&nbsp;&nbsp;')); ?>
            <?php echo $form->error($model, 'status'); ?>
        </td>
    </tr>
    <?php endif ?>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'sort'); ?>：</th>
        <td>
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj')); ?>
            <font color="red">（此处值为（0-255）,值越高则越靠前）</font>
            <?php echo $form->error($model, 'sort'); ?>
        </td>
    </tr>
    <tr><th class="title-th" colspan="2" style="text-align: center;"><?php echo Yii::t('hotel', 'SEO优化搜索信息'); ?></th></tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'keywords'); ?>：</th>
        <td>
            <?php echo $form->textField($model, 'keywords', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'keywords'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'description'); ?>：</th>
        <td>
            <?php echo $form->textArea($model, 'description', array('class' => 'text-area text-area2')); ?>
            <?php echo $form->error($model, 'description'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('hotel', '新增') : Yii::t('hotel', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>

<script type="text/javascript" language="javascript" src="/js/iframeTools.source.js"></script>
<script type="text/javascript" language="javascript">
                var mark_click = function() {
                    var url = '<?php echo Yii::app()->createAbsoluteUrl('/map/show') ?>';
                    url += '&lng=' + $('#Hotel_lng').val() + '&lat=' + $('#Hotel_lat').val();
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
                    $('#Hotel_lng').val(lng);
                    $('#Hotel_lat').val(lat);
                };

                var doClose = function() {
                    if (null != dialog) {
                        dialog.close();
                    }
                };

                function uploadifyRemove(fileId, attrName) {
                    if (confirm('本操作不可恢复，确定继续？')) {
                        $.post("<?php echo Yii::app()->createAbsoluteUrl('/hotel/remove') ?>", {imageId: fileId, YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken; ?>'}, function(res) {
                            $("#" + attrName + fileId).remove();
                        }, 'json');
                    }
                }
                function uploadifyRemove2(fileId, attrName) {
                    $("#" + attrName + fileId).remove();
                }
</script>

