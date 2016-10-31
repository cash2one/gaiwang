<style>.tab-come th{text-align: center;}</style>
<div class="form">
<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>
    
    <table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
        <tbody>
            <tr>
                <th style="width: 120px">
                    <?php echo $form->labelEx($model,'freightQQ');?>
                </th>
                <td>
                    <?php echo $form->textField($model,'freightQQ',array('class' => 'text-input-bj  middle'));?>
                    <?php echo $form->error($model,'freightQQ');?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->labelEx($model,'freightPhone');?>
                </th>
                <td>
                    <?php echo $form->textField($model,'freightPhone',array('class' => 'text-input-bj  middle'));?>
                    <?php echo $form->error($model,'freightPhone');?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo CHtml::submitButton(Yii::t('home','保存'),array('class' => 'reg-sub'));?>
                </td>
            </tr>
        </tbody>
    </table>  
    
    <?php $this->endWidget();?>
</div>