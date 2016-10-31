<?php
/**
 * @var $form CActiveForm
 * @var HotelPictureController $this
 * @var HotelPicture $model
 */
$this->breadcrumbs = array(
    Yii::t('hotelPicture', '酒店图片') => array('admin'),
    $model->isNewRecord ? Yii::t('hotelPicture', '新增') : Yii::t('hotelPicture', '修改')
);
?>
<?php
$form = $this->beginWidget('ActiveForm', array(
    'id' => 'hotelPicture-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
        <tr>
            <td colspan="2" class="title-th even"
                align="center"><?php echo $model->isNewRecord ? Yii::t('hotelPicture', '添加酒店图片') : Yii::t('hotelPicture', '修改酒店图片'); ?></td>
        </tr>
        </tbody>
        <tbody>
        <tr>
            <th style="width: 220px" class="odd">
                酒店名
            </th>
            <td class="odd">
                <?php echo $hotelName->chn_name; ?>
            </td>
        </tr>
        <?php if ($model->isNewRecord): ?>
            <tr>
                <th width="120px" align="right"><?php echo $form->labelEx($model, 'path'); ?>：</th>
                <td>
                    <?php
                    $this->widget('common.widgets.CUploadPic', array(
                        'form' => $form,
                        'model' => $model,
                        'attribute' => 'path',
                        'num' => 20,
                        'folder_name' => 'travel/hotelPicture',
                        'btn_value' => '上传图片',
                    ));
                    ?>
                    <?php echo $form->error($model, 'path', array('style' => 'position: relative; display: inline-block'), false, false); ?>
                </td>
            </tr>
        <?php else: ?>
            <tr>
                <th style="width: 220px" class="odd">
                    图片
                </th>
                <td class="odd">
                    <?php echo CHtml::image(IMG_DOMAIN . "/" . $model->path, "", array("width" => 100, "height" => 80, "style" => "display: inline-block")) ?>
                </td>
            </tr>
        <?php endif ?>

        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'type'); ?>
            </th>
            <td class="odd">
                <?php echo $form->dropDownList($model, 'type', CHtml::listData(BaseInfo::model()->findAll(array('select' => 'name,code', 'condition' => 'type=:type', 'params' => array(':type' => 'HotelImageType'))), 'code', 'name'), array('class' => 'text-input-bj  middle', 'prompt' => '选择类型')); ?>
                <?php echo $form->error($model, 'type'); ?>
            </td>
        </tr>

        <tr>
            <th style="width: 220px" class="odd">
                房间
            </th>
            <td class="odd">
                <?php echo $form->dropDownList($model, 'room_id', CHtml::listData(HotelRoom::model()->findAll(array('select' => 'room_id,name', 'condition' => 'hotel_id=:hotel_id', 'params' => array(':hotel_id' => $model->hotel_id))), 'room_id', 'name'), array('class' => 'text-input-bj  middle', 'prompt' => '选择房间')); ?>
                <?php echo $form->error($model, 'room_id'); ?>
            </td>
        </tr>
        <?php if (!$model->isNewRecord): ?>
            <tr>
                <th style="width: 220px" class="odd">
                    <?php echo $form->label($model, 'sort') ?>
                </th>
                <td class="odd">
                    <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj  middle')); ?>
                    <?php echo $form->error($model, 'sort'); ?>
                </td>
            </tr>
        <?php endif ?>
        <tr>
            <th class="odd"></th>
            <td colspan="2" class="odd">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('advert', '新增') : Yii::t('advert', '保存'), array('class' => 'reg-sub')); ?>
            </td>
        </tr>
        </tbody>
    </table>
<?php $this->endWidget(); ?>