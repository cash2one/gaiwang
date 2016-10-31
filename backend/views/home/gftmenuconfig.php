<?php 
//是否开启菜单选项 视图
?>
<style>
   th.title-th  {text-align: center;}
   .offset-left-100{
        margin-left: 100px;
   }
   .offset-left-60{
        margin-left: 60px;
   }
</style>
<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
    <tr>
        <th style="width: 140px">
            <?php echo $form->labelEx($model,'is_open');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'is_open',$model::isOpen(),array('separator'=>'<span class="offset-left-60"></span>'))?>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <?php echo CHtml::submitButton(Yii::t('home','保存'),array('class'=>'reg-sub offset-left-100'))?>
        </td>
    </tr>
    </tbody>
</table>

<?php $this->endWidget(); ?>
