<?php
/* @var $this CityshowRightsController */
/* @var $model CityshowRights */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'cityshowRights-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <th><?php echo $form->labelEx($model, 'gw'); ?></th>
        <td>
            <?php echo $form->textField($model, 'gw', array('class' => 'text-input-bj middle')); ?>
            <input type="button" value="检测" id="check" style="padding:5px"/>
            <?php echo $form->error($model, 'gw'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'store_name'); ?></th>
        <td>
            <?php echo $form->textField($model, 'store_name', array('class' => 'text-input-bj middle', 'readOnly' => 'readOnly', 'style' => 'background:#ccc')); ?>
            <?php echo $form->error($model, 'store_name'); ?>
        </td>
    </tr>

    <tr>
        <th></th>
        <td colspan="2">
            <?php echo CHtml::submitButton(Yii::t('brand', '添加 '), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>

<?php $this->endWidget(); ?>

<script>
    //检测商家
    $("#check").click(function () {
        $("#CityshowRights_gw").focus();
        $(this).focus();
        setTimeout(function () {
            var gw = $("#CityshowRights_gw").val();
            if (gw && !$("#CityshowRights_gw_em_:visible").html()) {
                $.getJSON("<?php echo $this->createAbsoluteUrl('check')?>", {gw: gw}, function (data) {
                    if (data.tips == 'success') {
                        $("#CityshowRights_store_name").val(data.msg);
                    } else {
                        $("#CityshowRights_gw_em_").show().html(data.msg)
                    }
                });
            }
        }, 500);
    });
    <?php if (Yii::app()->user->hasFlash('success')): ?>
        alert('<?php echo Yii::app()->user->getFlash('success'); ?>');
    <?php endif; ?>
    <?php if (Yii::app()->user->hasFlash('error')): ?>
        alert('<?php echo Yii::app()->user->getFlash('error'); ?>');
    <?php endif; ?>
    if(typeof done != 'undefined'){
        $("#CityshowRights_store_name").val('');
        $("#CityshowRights_gw").val('');
        parent.$('#cityshow-rights-grid').yiiGridView('update');
    }
</script>


