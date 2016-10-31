<?php
$this->breadcrumbs=array(
	Yii::t('AppActiveTitle','活动标题')=>array('AppActiveTitle/index'),
	Yii::t('AppActiveTitle','标题设置'),
);
if($type == 1){
	echo "<script>location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
}
 $form=$this->beginWidget('CActiveForm', array(
		'id'=>'appActiveTitle-form',
		'enableClientValidation' => false,
		'enableAjaxValidation'=>false,
		'clientOptions' => array(
				'validateOnSubmit' => false,
		),

		'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
		
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come">
            <tbody>
                <tr>
                    <td class="title-th" colspan="3">
                        <?php echo Yii::t('home','热卖活动标题设置'); ?>:
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <?php echo $form->textField($model,'title',array('class' => 'text-input-bj long valid'));?>
                        <?php echo $form->error($model,'title');?>
                    </td>
                    <td>
                        <?php echo CHtml::submitButton(Yii::t('home','保存'),array('class'=>'reg-sub'))?>
                    </td>
                </tr>
            </tbody>
        </table>
<?php $this->endWidget(); ?>