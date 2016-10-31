<?php
/* @var $this OrderRefundController */
/* @var $model OrderRefund */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'orderRefund-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => "js:function(form, data, hasError){
                if(hasError) return false;
                if(confirm('确定要新增吗？即将扣除该用户余额，该操作不可取消')){
                    return true;
                }else{
                    return false
                }
            }",
        ),
    )); ?>
    <table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">

        <tr>
            <th width="120px" align="right" class="odd">
                <?php echo $form->labelEx($model, 'code'); ?>：
            </th>
            <td class="odd">
                <?php echo $model->code; ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right" class="odd">
                盖网gw号：
            </th>
            <td class="odd">
                <?php echo $model->gai_number; ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right" class="odd">
                用户名：
            </th>
            <td class="odd">
                <?php echo $order->member->username; ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right" class="even">
                <?php echo $form->labelEx($model, 'money'); ?>：
            </th>
            <td class="even">
                <?php echo $form->textField($model,'money',array('class'=>'text-input-bj  middle'))?>
                (
                 付款金额：<?php echo HtmlHelper::formatPrice($order->pay_price) ?>&nbsp;&nbsp;
                 积分支付：<?php echo HtmlHelper::formatPrice($order->jf_price) ?>&nbsp;&nbsp;
                 已退款金额：<?php echo HtmlHelper::formatPrice($returnMoney) ?>
                )
                <?php echo $form->error($model,'money') ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right" class="odd">
                备注：
            </th>
            <td class="odd">
                <?php echo $form->textArea($model,'remark') ?>
                <?php echo $form->error($model,'remark') ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="odd">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('hotel', '新增') : Yii::t('hotel', '保存'), array('class' => 'reg-sub addSubmit')); ?>
                <?php echo CHtml::button('返回',array('class'=>'reg-sub','onclick'=>'history.back()')) ?>
            </td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>

</div><!-- form -->

