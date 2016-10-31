<?php
/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */
/* @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('prepaidCard', '代收付管理') => array('admin'),
    Yii::t('prepaidCard', '批量代付')
);
?>
<?php
$form = $this->beginWidget('ActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        /*'beforeValidate' => "js:function(form){
          for(var i=0;i<10;i++){
          var account_no=$('account_no_0').val();
          var account_name=$('account_name_'+i).val();
          var amout=$('amout_'+i).val();
            alert(account_no);
	   }  
         }"*/
    ),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody><tr><td colspan="2" class="title-th even" align="center"><?php echo Yii::t('user', '代付信息'); ?></td></tr></tbody>
    <tbody>
    <?php for($i=1;$i<11;$i++):?>
        <tr>
            <th style="width: 220px" class="odd">
               <span style="color: red">(<?php echo $i;?>)</span> <?php echo $form->labelEx($model, 'bank_code'); ?>
            </th>
            <td class="odd">
                <?php //echo $form->dropDownList($model,'bank_code',$model::bankList(),array('class'=>'text-input-bj  middle')) ?>
              <select class="text-input-bj  middle" name='ThirdPayment[<?php echo $i;?>][bank_code]'>
              <?php $bankList=$model::bankList();?>
                 <?php foreach($bankList as $k => $v):?>
                 <option value="<?php echo $k?>"><?php echo $v;?></option>
                 <?php endforeach;?>
              </select>
            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'account_no'); ?>
            </th>
            <td class="odd">
               <input class="text-input-bj  middle" id="account_no_<?php echo $i;?>" type="text" value="" name="ThirdPayment[<?php echo $i;?>][account_no]"> 
            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="even">
                <?php echo $form->labelEx($model, 'account_name'); ?>
            </th>
            <td class="even">
                <input class="text-input-bj  middle" id="account_name_<?php echo $i;?>" type="text" value="" name="ThirdPayment[<?php echo $i;?>][account_name]">
            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="even">
                <?php echo $form->labelEx($model, 'bankType'); ?>
            </th>
            <td class="even">
                <input class="text-input-bj  middle" type="text" id="bankType_<?php echo $i;?>" value="" name="ThirdPayment[<?php echo $i;?>][bankType]">
            </td>
        </tr>
         <tr>
            <th style="width: 220px" class="even">
                <?php echo $form->labelEx($model, 'cardId'); ?>
            </th>
            <td class="even">
                <input class="text-input-bj  middle" type="text" id="cardId_<?php echo $i;?>" value="" name="ThirdPayment[<?php echo $i;?>][cardId]">
            </td>
        </tr>
         <tr>
            <th style="width: 220px" class="even">
                <?php echo $form->labelEx($model, 'mobile'); ?>
            </th>
            <td class="even">
                <input class="text-input-bj  middle" type="text" id="mobile_<?php echo $i;?>" value="" name="ThirdPayment[<?php echo $i;?>][mobile]">
            </td>
        </tr>
         <tr>
            <th style="width: 220px" class="even">
                <?php echo $form->labelEx($model, 'amout'); ?>
            </th>
            <td class="even">
                <input class="text-input-bj  middle" type="text" id="amout_<?php echo $i;?>" value="0" name="ThirdPayment[<?php echo $i;?>][amont]">
            </td>
        </tr> 
<?php endfor;?>
        <?php echo $form->hiddenField($model, 'payment_type', array('class' => 'text-input-bj middle')); ?>
        <tr>
            <th class="odd"></th>
            <td class="odd"><?php echo CHtml::submitButton(Yii::t('user', '提交'), array('class' => 'reg-sub','id'=>'submitButton')); ?></td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>