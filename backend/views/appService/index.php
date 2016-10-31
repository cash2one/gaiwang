<?php
/* @var $this AppServiceController */

$this->breadcrumbs = array(
		Yii::t('AppService', '售后&咨询'),
		 Yii::t('AppService', AppService::getPublish($model->type)));
if($type == 1){
	echo "<script>location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
}
?>
<?php $form=$this->beginWidget('CActiveForm', array(
     'id'=>'appService-form',
     'enableClientValidation' => false,
     'enableAjaxValidation'=>false,
     'clientOptions' => array(
               'validateOnSubmit' => false,
     ),
	
     'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
        <tr>
            <th><?php echo $form->labelEx($model, 'content'); ?></th>
            <td>
                <?php
                $this->widget('comext.wdueditor.WDueditor', array(
                    'model' => $model,
                    'attribute' => 'content',
                ));
                ?>
                <?php echo $form->error($model, 'content'); ?>
            </td>
        </tr>
        
        <tr colspan="2">
        <th class="odd"></th>
        <td>
         <?php echo CHtml::submitButton(Yii::t('AppService', '保存'), array('class' => 'reg-sub','style')); ?>
       </td>
        </tr>
      </tbody>
 </table>
 <?php $this->endWidget();?>
