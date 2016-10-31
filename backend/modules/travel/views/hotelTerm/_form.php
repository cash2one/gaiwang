<?php
/**
 * @var HotelTermController $this
 * @var HotelTerm $model
 * @var CActiveForm $form
 */
$form = $this->beginWidget('ActiveForm', array(
    'id' => 'hotelTerm-form',
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
    <?php echo $form->hiddenField($model, 'rateplan_id', array('class' => 'text-input-bj long')); ?>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'time'); ?>：</th>
        <td>
            <?php echo $form->textField($model, 'time', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'time'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'term_content'); ?>：</th>
        <td>
            <?php echo $form->textArea($model, 'term_content', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'term_content'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'room_num'); ?>：</th>
        <td>
            <?php echo $form->textField($model, 'room_num', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'room_num'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'bind_start_date'); ?>：</th>
        <td>
            <?php
            $this->widget('comext.timepicker.timepicker', array(
                'id'=>'bind_start_date',
                'model'=>$model,
                'name' => 'bind_start_date',
                'select'=>'date',
                'htmlOptions' => array(
                    'readonly' => 'readonly',
                    'class' => 'text-input-bj  least readonly',
                )
            ));
            ?>
            <?php echo $form->error($model, 'bind_start_date'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'bind_end_date'); ?>：</th>
        <td>
            <?php
            $this->widget('comext.timepicker.timepicker', array(
                'id'=>'bind_end_date',
                'model'=>$model,
                'name' => 'bind_end_date',
                'select'=>'date',
                'htmlOptions' => array(
                    'readonly' => 'readonly',
                    'class' => 'text-input-bj  least readonly',
                )
            ));
            ?>
            <?php echo $form->error($model, 'bind_end_date'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'term_type'); ?>：</th>
        <td>
            <?php echo $form->dropDownList($model, 'term_type', HotelTerm::getType(),array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'term_type'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'term_name'); ?>：</th>
        <td>
            <?php echo $form->textField($model, 'term_name', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'term_name'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'days'); ?>：</th>
        <td>
            <?php echo $form->textField($model, 'days', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'days'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'book_start_date'); ?>：</th>
        <td>
            <?php
            $this->widget('comext.timepicker.timepicker', array(
                'id'=>'book_start_date',
                'model'=>$model,
                'name' => 'book_start_date',
                'select'=>'date',
                'htmlOptions' => array(
                    'readonly' => 'readonly',
                    'class' => 'text-input-bj  least readonly',
                )
            ));
            ?>
            <?php echo $form->error($model, 'book_start_date'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'book_end_date'); ?>：</th>
        <td>
            <?php
            $this->widget('comext.timepicker.timepicker', array(
                'id'=>'book_end_date',
                'model'=>$model,
                'name' => 'book_end_date',
                'select'=>'date',
                'htmlOptions' => array(
                    'readonly' => 'readonly',
                    'class' => 'text-input-bj  least readonly',
                )
            ));
            ?>
            <?php echo $form->error($model, 'book_end_date'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'need_assure'); ?>：</th>
        <td>
            <?php echo $form->textField($model, 'need_assure', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'need_assure'); ?>
        </td>
    </tr>


    <tr>
        <td colspan="2">
            <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '保存', array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
