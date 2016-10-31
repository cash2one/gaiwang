<?php
/**
 * @var HotelRoomController $this
 * @var HotelRoom $model
 * @var CActiveForm $form
 */
$form = $this->beginWidget('ActiveForm', array(
    'id' => 'hotelRoom-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    //  'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true, // 客户端验证
    ),
));
?>
    <table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
        <tr>
            <th class="title-th even" colspan="2"
                style="text-align: center;"><?php echo Yii::t('hotel', '酒店房间基本信息及属性'); ?></th>
        </tr>
        <tr>
            <th width="120px" align="right"><?php echo $form->labelEx($model, 'name'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj long')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right"><?php echo $form->labelEx($model, 'num'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'num', array('class' => 'text-input-bj long')); ?>
                <?php echo $form->error($model, 'num'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right"><?php echo $form->labelEx($model, 'acreage'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'acreage', array('class' => 'text-input-bj long')); ?>
                <?php echo $form->error($model, 'acreage'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right"><?php echo $form->labelEx($model, 'floor'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'floor', array('class' => 'text-input-bj long')); ?>
                <?php echo $form->error($model, 'floor'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right"><?php echo $form->labelEx($model, 'max_num_of_persons'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'max_num_of_persons', array('class' => 'text-input-bj long')); ?>
                <?php echo $form->error($model, 'max_num_of_persons'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right"><?php echo $form->labelEx($model, 'equipment'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'equipment', array('class' => 'text-input-bj long')); ?>
                <div style="margin-bottom: 20px"><?php echo $form->error($model, 'equipment'); ?></div>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right"><?php echo $form->labelEx($model, 'equipment_desc'); ?>：</th>
            <td>
                <?php echo $form->textArea($model, 'equipment_desc', array('class' => 'text-input-bj long')); ?>
                <?php echo $form->error($model, 'equipment_desc'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right"><?php echo $form->labelEx($model, 'has_net'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'has_net', array('class' => 'text-input-bj long')); ?>
                <?php echo $form->error($model, 'has_net'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right"><?php echo $form->labelEx($model, 'flag_add_bed'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'flag_add_bed', array('class' => 'text-input-bj long')); ?>
                <?php echo $form->error($model, 'flag_add_bed'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right"><?php echo $form->labelEx($model, 'bed_type'); ?>：</th>
            <td>
                <?php echo $form->dropDownList($model, 'bed_type', BaseInfo::getBaseInfo('BedTypeCode'), array('class' => 'text-input-bj long')); ?>
                <?php echo $form->error($model, 'bed_type'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right"><?php echo $form->labelEx($model, 'add_bed_num'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'add_bed_num', array('class' => 'text-input-bj long')); ?>
                <?php echo $form->error($model, 'add_bed_num'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right"><?php echo $form->labelEx($model, 'roomPicture'); ?>：</th>
            <td>
                <?php
                $this->widget('common.widgets.CUploadPic', array(
                    'form' => $form,
                    'model' => $model,
                    'attribute' => 'roomPicture',
                    'num' => 20,
                    'folder_name' => 'travel/hotelPicture',
                    'btn_value' => '上传图片',
                ));
                ?>
                <?php echo $form->error($model, 'roomPicture', array('style' => 'position: relative; display: inline-block'),false,false); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right"><?php echo $form->labelEx($model, 'remark'); ?>：</th>
            <td>
                <?php echo $form->textArea($model, 'remark', array('class' => 'text-input-bj long')); ?>
                <?php echo $form->error($model, 'remark'); ?>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '保存', array('class' => 'reg-sub')); ?>
            </td>
        </tr>
    </table>
<?php $this->endWidget(); ?>