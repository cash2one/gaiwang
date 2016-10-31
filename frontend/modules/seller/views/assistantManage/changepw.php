<?php
/* @var $this AssistantController */
/* @var $model Assistant */

$this->breadcrumbs=array(
    Yii::t('sellerAssistantManage','店小二管理'),
    Yii::t('sellerAssistantManage','修改密码'),
);

?>
    <div class="toolbar">
        <h3><?php echo Yii::t('sellerAssistantManage','修改密码'); ?></h3>
    </div>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
    <tbody>
    <tr>
        <th width="10%"><?php echo $form->labelEx($model, 'oldPassword'); ?></th>
        <td width="90%">
            <?php echo $form->passwordField($model, 'oldPassword', array('class'=>'inputtxt1','style'=>'width:300px','value'=>'')); ?>
            <?php echo $form->error($model, 'oldPassword'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'newPassword'); ?></th>
        <td>
            <?php echo $form->passwordField($model, 'newPassword', array('class'=>'inputtxt1','style'=>'width:300px','value'=>'')); ?>
            <?php echo $form->error($model, 'newPassword'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'confirmPassword'); ?></th>
        <td>
            <?php echo $form->passwordField($model, 'confirmPassword', array('class'=>'inputtxt1','style'=>'width:300px')); ?>
            <?php echo $form->error($model, 'confirmPassword'); ?>
        </td>
    </tr>


    </tbody>
</table>

<div class="profileDo mt15">
    <a href="#" class="sellerBtn03 submitBt"><span><?php echo Yii::t('sellerAssistantManage','保存'); ?></span></a>&nbsp;&nbsp;
</div>
<?php $this->endWidget(); ?>

<script>
    $(".submitBt").click(function(){
        $("form").submit();
    });
</script>