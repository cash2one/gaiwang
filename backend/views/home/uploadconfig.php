<style>.tab-come th{text-align: center;}</style>
<div class="form">
<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>
    
    <table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
        <tbody>
            <tr>
                <th style="width:120px">
                    <?php echo $form->labelEx($model,'uploadPath')?>
                </th>
                <td>
                    <?php echo $form->textField($model,'uploadPath',array('class' => 'text-input-bj  long'));?>
                    <?php echo $form->error($model,'uploadPath');?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->labelEx($model,'fileTypes')?>
                </th>
                <td>
                    <?php echo $form->textField($model,'fileTypes',array('class' => 'text-input-bj  long'));?>
                    <?php echo $form->error($model,'fileTypes');?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->labelEx($model,'imageTypes')?>
                </th>
                <td>
                    <?php echo $form->textField($model,'imageTypes',array('class' => 'text-input-bj  long'));?>
                    <?php echo $form->error($model,'imageTypes');?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->labelEx($model,'imageFilesize')?>
                </th>
                <td>
                    <?php echo $form->textField($model,'imageFilesize',array('class' => 'text-input-bj  long'));?>(KB)
                    <?php echo $form->error($model,'imageFilesize');?>

                </td>
            </tr>
             <tr>
                <th>
                    <?php echo $form->labelEx($model,'flashFilesize')?>
                </th>
                <td>
                    <?php echo $form->textField($model,'flashFilesize',array('class' => 'text-input-bj  long'));?>(KB)
                    <?php echo $form->error($model,'flashFilesize');?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->labelEx($model,'flashSize')?>
                </th>
                <td>
                    <?php echo $form->textField($model,'flashSize',array('class' => 'text-input-bj  long'));?>(如:1200x500) 
                    <?php echo $form->error($model,'flashSize');?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form->labelEx($model,'uploadTotal')?>
                </th>
                <td>
                    <?php echo $form->textField($model,'uploadTotal',array('class' => 'text-input-bj  long'));?>
                    <?php echo $form->error($model,'uploadTotal');?>
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