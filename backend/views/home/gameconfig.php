<style>
.tab-come th{text-align: center;}
</style>

<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>

    <script type="text/javascript" src="/js/EMSwitchBox.js"></script>
    <script type="text/javascript">
 $(document).ready(
     function () {
         $('.show-checkbox').EMSwitchBox({ onLabel: '开', offLabel: '关' });
     });
    </script>
    
    <table width="100%" border="0" class="tab-come" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <th>
                    <?php echo $form->labelEx($model,'gameSwitch');?>：
                </th>
                <td>
                    <?php echo $form->checkBox($model,'gameSwitch',array('class' => 'show-checkbox'))?>
                </td>
            </tr>
            
        </tbody>
    </table>
    <?php echo CHtml::submitButton(Yii::t('home','保存'),array('class' => 'reg-sub'));?>
    <?php $this->endWidget();?>