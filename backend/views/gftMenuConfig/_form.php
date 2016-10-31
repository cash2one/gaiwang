<?php
/**
 * @var HotelBrandController $this
 * @var HotelBrand $model
 * @var CActiveForm $form
 */
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
        ));
?>
<style type="text/css">
    tr{height:45px;}
</style>
<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <th width="200px">
            <?php echo $form->labelEx($model, 'title'); ?>：
        </th>
        <td>
            <?php echo $form->textField($model, 'title', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'title'); ?>
        </td>
    </tr>
    <tr>
        <th width="200px" align="right">
            <?php echo $form->label($model, 'icon', array('required' => true)); ?>：
        </th>
        <td>
            <?php echo $form->FileField($model, 'icon', array('class' => 'text-input-bj middle')); ?>
            <?php if (!$model->isNewRecord): ?>
                <?php echo CHtml::hiddenField('oldImg', $model->icon)?>
                <?php
                    echo CHtml::image(Tool::showImg(ATTR_DOMAIN . "/" . $model->icon, "c_fill,h_80,w_100"), $model->title, array('width' => 100, 'height' => 80));
                ?>
            <?php endif; ?>
            <?php echo $form->error($model, 'icon', array(), false); ?>
        </td>
    </tr>
    <tr>
        <th width="200px" align="right">
            <?php echo $form->labelEx($model, 'flag'); ?>：
        </th>
        <td>
            <?php echo $form->textField($model, 'flag', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'flag'); ?>
        </td>
    </tr>
    <tr>
        <th width="200px" align="right">
            <?php echo $form->labelEx($model, 'status'); ?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'status',$model::showStatus(),array('separator'=>'<span class="offset-left-60"></span>'))?>
            <?php echo $form->error($model, 'status'); ?>
        </td>
    </tr>
    <tr>
        <th width="130px" align="right">
            <?php echo $form->labelEx($model, 'sort'); ?>：
        </th>
        <td>
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj short')); ?>
            <?php echo $form->error($model, 'sort'); ?>
            <span><font color="red">通用排序，以倒序规则形式，最大值255</font></span>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('hotelBrand', '新增') : Yii::t('hotelBrand', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr> 
</table>
<?php $this->endWidget(); ?>