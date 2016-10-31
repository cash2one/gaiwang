<?php
/* @var $this CityshowRightsController */
/* @var $model CityshowRights */
/* @var $form CActiveForm */
?>

<?php $form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id'=>'search_form',
)); ?>

<div class="border-info clearfix">
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody>
        <tr>
            <th align="right">
                <?php echo Yii::t('cityshow', '商家GW号'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'gw', array('size' => 20, 'class' => 'text-input-bj  middle')); ?>
            </td>
        </tr>
        </tbody>
    </table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody>
        <tr>
            <th align="right">
                <?php echo Yii::t('cityshow', '名称'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'store_name', array('size' => 20, 'class' => 'text-input-bj  middle')); ?>
            </td>
        </tr>
        </tbody>
    </table>
    <?php echo CHtml::submitButton(Yii::t('cityshow', '搜索'), array('class' => 'reg-sub')) ?>
</div>

<?php $this->endWidget(); ?>
