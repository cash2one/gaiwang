<div class='form'>
<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>
    
    <table width='100%' border='0' class='tab-come' cellspacing='1' cellpadding='0'>
        <tbody>
            <!-- SEO作者 -->
            <tr>
                <td style='width:250px;'>
                    <?php echo $form->labelEx($model,'stock_time');?>
                </td>
                <td>
                    <?php echo $form->textField($model,'stock_time',  array('class'=>'text-input-bj '));?>
                    <?php echo $form->error($model,'stock_time');?>
                </td>
            </tr>
            <tr>
                <td style='width:250px;'>
                    <?php echo $form->labelEx($model,'specialGoods');?>
                </td>
                <td>
                    <?php echo $form->textArea($model,'specialGoods',  array('class'=>'text-input-bj ','rows'=>10,'cols'=>180));?>
                    <?php echo $form->error($model,'specialGoods');?>(<?php echo Yii::t('home','以英文逗号分隔的商品id') ?>)
                </td>
            </tr>

            <tr>
                <td style='width:250px;'>
                    <?php echo $form->labelEx($model,'payJfRatio');?>
                </td>
                <td>
                    <?php echo $form->textField($model,'payJfRatio',  array('class'=>'text-input-bj '));?>%
                    <?php echo $form->error($model,'payJfRatio');?>
                </td>
            </tr>

            <tr>
                <td style='width:250px;'>
                    <?php echo $form->labelEx($model,'shopId_13_14');?>
                </td>
                <td>
                    <?php echo $form->textArea($model,'shopId_13_14',  array('class' => 'text-input-bj','rows'=>5,'cols'=>180));?>
                    <?php echo $form->error($model,'shopId_13_14');?>(<?php echo Yii::t('home','以英文逗号分隔的商家id') ?>)
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