<div class="form">
<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>
    
    <table width="100%" border="0" class="tab-come" cellspacing="1" cellpadding="0">
            <tbody>
                <tr>
                    <th style="width: 100px">
                        <?php echo $form->labelEx($model,'filterWorld');?>：
                    </th>
                    <td>
                        <div class="validation-summary-valid" data-valmsg-summary="true"><ul><li style="display:none"></li></ul></div>
                        （<?php echo Yii::t('home','多个敏感词用‘,’逗号隔开'); ?>）
                        <?php echo $form->textArea($model,'filterWorld',array('class' => 'text-input-bj text-area','style' => 'height:600px;','rows' => '2', 'cols' => '20'));?>

                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input id="btn_save1" type="submit" value="<?php echo Yii::t('home','保存'); ?>" class="reg-sub" />
                    </td>
                </tr>
            </tbody>
        </table>
    <?php $this->endWidget();?>
</div>