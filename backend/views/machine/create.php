<?php
/* @var $this MachineController */
/* @var $model Machine */

$this->breadcrumbs=array(
    Yii::t('brand','盖网通列表 ')=> array('admin'),
    Yii::t('brand','编辑推荐者'), 
);

?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'machine-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('machine', '添加推荐者 ') : Yii::t('machine', '修改推荐者'); ?></td>
    </tr>
    <tr><td colspan="2" class="odd"></td></tr>

    <tr>
        <th class="even" style="width:150px">
            <label for="Machine_ROLE_GATEWANG"><?php echo Yii::T('machine','推荐者GW号(会员)')?>:</label>        
        </th>
        <td class="even">
           <?php  echo $form->TextField($model,'intro_member_id',array('class'=>'text-input-bj  least',));?>
        </td>
    </tr> 
    
    <tr>
        <th class="even" style="width:150px">
            <label for="Machine_ROLE_GATEWANG"><?php echo Yii::T('machine','推荐者GW号(代理商)')?>:</label>        
        </th>
        <td class="even">
            <?php  echo $form->TextField($model,'install_member_id',array('class'=>'text-input-bj  least',));?>
        </td>
    </tr> 
    
    <tr>
        <th class="even" style="width:150px">
            <label for="Machine_ROLE_GATEWANG"><?php echo Yii::T('machine','运维方GW号')?>:</label>        
        </th>
        <td class="even">
            <?php  echo $form->TextField($model,'operate_member_id',array('class'=>'text-input-bj  least',));?>
        </td>
    </tr> 
    <tr>
        <th class="odd"></th>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton(Yii::t('machine', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>          

<?php $this->endWidget(); ?>