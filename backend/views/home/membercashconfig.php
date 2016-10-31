<?php 
//普通会员提现配置 视图
/* @var $form  CActiveForm */
/* @var $model MemberCashConfigForm */
?>
<style>
   th.title-th  {text-align: center;}
</style>
<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
             <tr>
                    <th style="width: 180px">
                        <?php echo $form->labelEx($model,'applyCashUnit');?>：
                    </th>
                    <td>
                        <?php echo $form->textField($model, 'applyCashUnit',array('class'=>'text-input-bj  long')); ?>%
                        <?php echo $form->error($model,'applyCashUnit');?>
                    </td>
                </tr>
                <tr>
                    <th style="width: 180px">
                        <?php echo $form->labelEx($model,'applyCashFactorage');?>：
                    </th>
                    <td>
                        <?php echo $form->textField($model, 'applyCashFactorage',array('class'=>'text-input-bj  long')); ?>%
                        <?php echo $form->error($model,'applyCashFactorage');?>
                    </td>
                </tr>
            <tr>
                <td colspan="2">
                    <?php echo CHtml::submitButton(Yii::t('home','保存'),array('class'=>'reg-sub'))?>
                </td>
            </tr>
        </tbody>
</table>
<?php $this->endWidget(); ?>
