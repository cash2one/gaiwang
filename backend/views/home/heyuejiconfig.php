<div class='form'>
<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>
    
    <table width='100%' border='0' class='tab-come' cellspacing='1' cellpadding='0'>
        <tbody>
            <!-- SEO作者 -->
            
            <tr>
                <th style='width:250px;'>
                    <?php echo $form->labelEx($model,'telecom_4g');?>
                </th>
                <td>
                    <?php echo $form->textArea($model,'telecom_4g',  array('class'=>'text-input-bj ','rows'=>10,'cols'=>180));?>
                    <?php echo $form->error($model,'telecom_4g');?>(<?php echo Yii::t('home','以英文逗号分隔的商品id') ?>)
                </td>
            </tr>
            
            <tr>
                <th style='width:250px;'>
                    <?php echo $form->labelEx($model,'telecom_3g');?>
                </th>
                <td>
                    <?php echo $form->textArea($model,'telecom_3g',  array('class'=>'text-input-bj ','rows'=>10,'cols'=>180));?>
                    <?php echo $form->error($model,'telecom_3g');?>(<?php echo Yii::t('home','以英文逗号分隔的商品id') ?>)
                </td>
            </tr>
            
            <tr>
                <td colspan='2'>
                    <?php echo CHtml::submitButton(Yii::t('home','保存'),array('class'=>'reg-sub'))?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php $this->endWidget(); ?>
</div>