<?php 
//支付接口配置 视图
/* @var $form  CActiveForm */
/* @var $model PayAPIConfigForm */
?>
<style>
   th.title-th  {text-align: center;}
</style>
<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
    <tr>
        <th colspan="2" class="title-th even">
            <?php echo Yii::t('home','支付接口配置'); ?>
        </th>
    </tr>
    <tr>
        <th style="width: 140px">
            <?php echo $form->labelEx($model,'ipsEnable');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'ipsEnable',$model::apiStatus(),array('separator'=>''))?>
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $form->labelEx($model,'gneteEnable');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'gneteEnable',$model::apiStatus(),array('separator'=>''))?>
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $form->labelEx($model,'bestEnable');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'bestEnable',$model::apiStatus(),array('separator'=>''))?>
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $form->labelEx($model,'hiEnable');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'hiEnable',$model::apiStatus(),array('separator'=>''))?>
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $form->labelEx($model,'umEnable');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'umEnable',$model::apiStatus(),array('separator'=>''))?>
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $form->labelEx($model,'umQuickEnable');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'umQuickEnable',$model::apiStatus(),array('separator'=>''))?>
        </td>
    </tr>
    
    <tr>
        <th>
            <?php echo $form->labelEx($model,'tlzfEnable');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'tlzfEnable',$model::apiStatus(),array('separator'=>''))?>
        </td>
    </tr>
    
    <tr>
        <th>
            <?php echo $form->labelEx($model,'tlzfKjEnable');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'tlzfKjEnable',$model::apiStatus(),array('separator'=>''))?>
        </td>
    </tr>
    
     <tr>
        <th>
            <?php echo $form->labelEx($model,'ghtEnable');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'ghtEnable',$model::apiStatus(),array('separator'=>''))?>
        </td>
    </tr>
    
      <tr>
        <th>
            <?php echo $form->labelEx($model,'ghtKjEnable');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'ghtKjEnable',$model::apiStatus(),array('separator'=>''))?>
        </td>
    </tr>
    
    <tr>
        <th>
            <?php echo $form->labelEx($model,'ghtQuickEnable');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'ghtQuickEnable',$model::apiStatus(),array('separator'=>''))?>
        </td>
    </tr>
    
    <tr>
        <th>
            <?php echo $form->labelEx($model,'ebcEnable');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'ebcEnable',$model::apiStatus(),array('separator'=>''))?>
        </td>
    </tr>
    

    <tr>
        <th>
            <?php echo $form->labelEx($model,'ip');?>：
        </th>
        <td>
            <?php echo $form->textField($model,'ip',array('class'=>'text-input-bj  long'))?>
            <?php echo $form->error($model,'ip') ?>(http://ip或者域名/)
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
