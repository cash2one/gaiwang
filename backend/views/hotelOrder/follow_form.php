<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>

<script>
    if (typeof success != 'undefined') {
        var p = artDialog.open.origin;
        p.doClose();
    }
</script>
<?php
/* @var $model HotelOrderFollow */
$this->breadcrumbs = array(Yii::t('hotelOrder', '添加订单跟进'));

?>
<style>
    .com-box{min-height: 280px}
</style>

<?php
/** @var CActiveForm $form */
$form = $this->beginWidget('ActiveForm', array(
    'id' => 'hotel-order-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));

?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tr>
        <th style="text-align: right">
            操作人：
        </th>
        <td><?php echo  Yii::app()->user->name ?></td>
    </tr>
    <tr>
        <th style="text-align: right">
            请填写跟进内容：
        </th>
        <td>
            <div>
                <?php echo $form->textArea($model,'content',array('rows'=>10, 'cols'=>100)); ?>
            </div>
            <?php echo $form->error($model, 'content',array('style'=>'position:relative')) ?>
        </td>
    </tr>

    <tr style="text-align: center">
        <td colspan="2" >
            <?php echo CHtml::submitButton(Yii::t('hotelOrder', '提交'), array('class' => 'reg-sub')) ?>
            <?php echo CHtml::button(Yii::t('hotelOrder', '取消'), array('class' => 'reg-sub', 'id'=>'closeForm', 'onclick' => 'btnCancelClick()')); ?>
        </td>

    </tr>
</table>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    var btnCancelClick = function() {
        art.dialog.close();
    }
</script>