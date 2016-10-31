<?php
$this->breadcrumbs=array(
	Yii::t('AppHotKey','热搜关键字设置')=>array('AppHotKey/index'),
	Yii::t('AppHotKey','关键字设置'),
);
if($type == 1){
	echo "<script>location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
}
 $form=$this->beginWidget('CActiveForm', array(
		'id'=>'appHotKey-form',
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
                        <?php echo Yii::t('home','热搜关键字设置'); ?>:
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <?php echo $form->textField($model,'title',array('class' => 'text-input-bj long valid'));?>
                        <?php echo $form->error($model,'title');?>(用"|"分割)
                    </td>
                    <td>
                        <?php echo CHtml::submitButton(Yii::t('home','保存'),array('class'=>'reg-sub'))?>
                    </td>
                </tr>
            </tbody>
        </table>
<?php $this->endWidget(); ?>