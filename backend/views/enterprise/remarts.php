<script>
    if (typeof success != 'undefined') {
        parent.location.reload();
        art.dialog.close();
    }
</script>
<?php $this->breadcrumbs = array(
    Yii::t('enterprise', '添加备注'),
);

?>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>

<?php
/** @var CActiveForm $form */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'enterprise-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tr>
            <th style="text-align: right">
                请添加备注内容：
            </th>
            <td>
                <?php // echo $form->textField($model, 'service_id', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50,'id'=>'content')); ?>
                <?php echo $form->error($model, 'content') ?>
            </td>
        </tr>

        <tr style="text-align: center">
            <td colspan="2" >
                <?php echo CHtml::submitButton(Yii::t('enterprise', '提交'), array('class' => 'reg-sub','id'=>'yw0')) ?>
                 <?php echo CHtml::button(Yii::t('enterprise', '取消'), array('class' => 'reg-sub', 'onclick' => 'btnCancelClick()')); ?>
            </td>
         
        </tr>
    </table>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    var btnCancelClick = function() {
        art.dialog.close();
    }

    $('#yw0').submit(function(){
        if (!$('#content').val()) {
            alert('<?php echo Yii::t('enterprise', '请输入备注内容');?>');
            return false;
        }
   
	});

</script>
