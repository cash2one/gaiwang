<?php
/* @var $this GameStoreItemsController */
/* @var $model GameStoreItems */
/* @var $form CActiveForm */
?>
<div class="seachToolbar">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'post',
    ));
    ?>
    <table width="60%" border="0" cellspacing="0" cellpadding="0" class="sellerT5">
        <tr >
            <th width="15%" ><p style="width:115px;text-align:center;" ><?php echo Yii::t('GameOrderDetail', '手机号：')?></p></th>
            <td width="30%">
                <?php echo $form->textField($model, 'mobile', array('class' => 'inputtxt1','style'=>"width:230px;")); ?>
            </td>&nbsp;&nbsp;
            <td width="55%"><?php echo CHtml::submitButton(Yii::t('GameStoreItems', '搜索'), array('class' => 'sellerBtn06')); ?></td>
        </tr>
    </table>

    <?php $this->endWidget(); ?>
</div>