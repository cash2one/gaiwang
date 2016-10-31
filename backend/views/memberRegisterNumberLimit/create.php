<?php
$this->breadcrumbs=array(
		Yii::t('MemberRegisterNumberLimit','注册号段管理'),
		Yii::t('MemberRegisterNumberLimit','生成新号码段'),
);
if(isset($type)){
	$url = '/MemberRegisterNumberLimit/MemberUpdate&id='.$model->id;
}else{
	$url = '/MemberRegisterNumberLimit/membercreate';
}

$form = $this->beginWidget('CActiveForm',array(
		'id'=>'Search-Form',
		'enableClientValidation'=>true,
		'clientOptions'=>array('validateOnsubmit'=>true),
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
		'action'=>Yii::app()->createurl($url),
));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
       <tr>
        <th ><?php echo $form->labelEx($model, 'number_start'); ?></th>
        <td><?php echo $form->TextField($model,'number_start',array('class'=>'text-input-bj  least'));
                  echo $form->error($model,'number_start');
        ?></td>
       </tr>
       
       <tr>
        <th  ><?php echo $form->labelEx($model, 'number_end'); ?></th>
        <td><?php echo $form->TextField($model,'number_end',array('class'=>'text-input-bj  least'));
        echo $form->error($model,'number_end');
        ?></td>
       </tr>
       
       <tr>
         <th c><?php echo $form->labelEx($model, 'status'); ?></th>
         <td><?php echo $form->radioButtonList($model, 'status',array('0'=>'未开放','1'=>'开放'),array('separator'=>'')); ?></td>
       </tr>
       
        <tr>
            <th class="odd"></th>
            <td colspan="2" class="odd">
                <?php echo CHtml::submitButton(Yii::t('MemberRegisterNumberLimit', '保存'), array('class' => 'reg-sub')); ?>
                <input type="button" value="<?php echo Yii::t('MemberRegisterNumberLimit', '返回'); ?>" class="reg-sub" onclick="location.href = '<?php echo $this->createAbsoluteUrl("/MemberRegisterNumberLimit/index"); ?>'" />
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget();?>
