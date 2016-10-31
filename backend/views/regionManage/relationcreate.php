<?php
$this->breadcrumbs=array(
		Yii::t('RegionManageRelation', '加盟商管理'),
		Yii::t('RegionManageRelation', '添加会员账号'),
);

$form = $this->beginWidget('CActiveForm',array(
		'id'=>'RegionManageRelation-create',
		'enableClientValidation'=>true,
		'clientOptions'=>array( 'validateOnSubmit'=>true,),
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
		'action'=>Yii::app()->createurl("RegionManage/RelationCreate&id=".$id),
));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
<tbody><tr><td colspan="2" class="title-th even" align="center"><?php echo Yii::t('RegionManageRelation', '添加'); ?></td></tr></tbody>
    <tbody>
        <tr>
            <th style="width: 220px" class="odd" >
                <?php echo  $form->labelEx($model, 'username'); ?><span class="required"> * </span>:</span>
            </th>
            <td class="odd">
            <?php  echo $form->TextField($model,'username',array('class'=>'text-input-bj',));?>
            </td>
        </tr>
        <tr>
            <th class="odd"></th>
            <td colspan="2" class="odd">
                <?php echo CHtml::submitButton(Yii::t('RegionManageRelation', '保存'), array('class' => 'reg-sub')); ?>
                <input id="Btn_tui" type="button" value="<?php echo Yii::t('RegionManageRelation', '返回'); ?>" class="reg-sub" onclick="location.href = '<?php echo $this->createAbsoluteUrl("/RegionManage/SaveGW",array("id"=>$id)); ?>'" />
            </td>
        </tr>
    </tbody>
</table>
<?php 
$this->endwidget();
?>