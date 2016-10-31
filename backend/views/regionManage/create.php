<?php
$this->breadcrumbs=array(
		Yii::t('RegionManage', '加盟商管理'),
		Yii::t('RegionManage', '添加大区'),
);
if(isset($type)){
	$url = '/RegionManage/saveregion&id='.$model->id;
}else{
	$url = 'RegionManage/createregion';
 }
$form = $this->beginWidget('CActiveForm',array(
		'id'=>'RegionManage-create',
		'enableClientValidation'=>true,
		'clientOptions'=>array( 'validateOnSubmit'=>true,),
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
		'action'=>Yii::app()->createurl($url),
));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody><tr><td colspan="2" class="title-th even" align="center"><?php echo Yii::t('RegionManage', '添加大区'); ?></td></tr></tbody>
    <tbody>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'name'); ?>
            </th>
            <td class="odd">
            <?php  echo $form->TextField($model,'name',array('class'=>'text-input-bj',));
                    echo $form->error($model,'name')?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo Yii::t('RegionManage', '所属会员GW号 '); ?></span>
            </th>
            <td class="odd">
            <?php  echo $form->TextField($model,'member_gw',array('class'=>'text-input-bj',));?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo Yii::t('RegionManage', '请选择此大区所属城市 '); ?><span class="required">*</span>
            </th>
            <td >
            <?php // if(isset($type)){
//             	echo $form->CheckBoxList($model,'city_id',Region::getRegionByParentId(Region::PROVINCE_PARENT_ID),array('separator'=>'-'));
//             }else{
            	echo $form->CheckBoxList($model,'city_id',Region::getRegionByParentId(Region::PROVINCE_PARENT_ID),array('separator'=>'-'));
           // }
            ?>
            </td>
        </tr>
        <tr>
            <th class="odd"></th>
            <td colspan="2" class="odd">
                <?php echo CHtml::submitButton(Yii::t('offlineRole', '保存'), array('class' => 'reg-sub')); ?>
            </td>
        </tr>
    </tbody>
</table>
<?php 
$this->endwidget();
?>
