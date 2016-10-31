<style>.tab-come th{text-align: center;}</style>
<dvi class="form">
<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>
    
    <table width="100%" border="0" class="tab-come" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <th style="width: 150px">
                    <?php echo $form->labelEx($model,'upgradeLimitAccount');?>
                </th>
                <td>
                    <?php echo $form->textField($model,'upgradeLimitAccount',array('class'=>'text-input-bj'));?>
                    <?php echo $form->error($model,'upgradeLimitAccount');?>
                </td>
            </tr>
            <tr>
             <td colspan="2">
                 <?php echo CHtml::submitButton(Yii::t('home','保存'),array('class' => 'reg-sub'))?>
            </td>
            </tr>
        </tbody>
    </table>
    
    <?php $this->endWidget();?>
</div>