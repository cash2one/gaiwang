<?php
/**
 * @var $form CActiveForm
 * @var $model FloorConfigForm
 */
$categoryTop = Category::getTopCategory();
$category = array();
$category[0] = '';
$category = array_merge($category,CHtml::listData($categoryTop,'id','name'));
?>
<style>
    th.title-th  {text-align: center;}
</style>
<?php $form = $this->beginWidget('CActiveForm', $formConfig); ?>
留空则不显示
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>

    <?php
    for($i=1;$i<9;$i++):
    ?>
    <tr>
        <th style="width: 180px">
            <?php echo $form->labelEx($model, 'floor_'.$i); ?>：
        </th>
        <td>
            <?php echo $form->dropDownList($model, 'floor_'.$i,$category); ?>
            <?php echo $form->error($model, 'floor_1'.$i); ?>
        </td>
    </tr>
    <?php
    endfor;
    ?>


    <tr>
        <td colspan="2">
            <?php echo CHtml::submitButton(Yii::t('home', '保存'), array('class' => 'reg-sub')) ?>
        </td>
    </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
