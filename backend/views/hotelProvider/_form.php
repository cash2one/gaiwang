<?php
/**
 * @var HotelProviderController $this
 * @var HotelProvider $model
 * @var CActiveForm $form
 */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'hotelProvider-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <th style="width:120px">
            <?php echo $form->labelEx($model, 'name'); ?>：
        </th>
        <td>
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    <?php if ($model->isNewRecord): ?>
        <tr>
            <th style="width:120px"> <?php echo $form->labelEx($model, 'member_id'); ?>：</th>
            <td>
                <?php echo $form->hiddenField($model, 'member_id'); ?>
                <?php echo CHtml::textField('enterpriseName', '', array('class' => 'text-input-bj middle', 'readonly' => 'readonly', 'style' => 'background:#eee;')); ?>
                <?php echo CHtml::button('选择企业会员', array('class' => 'reg-sub-01', 'readonly' => true, 'id' => 'setEnterprise')); ?>&nbsp;&nbsp;<b>（绑定以后不能修改，请谨慎操作！）</b>
                <?php echo $form->error($model, 'member_id'); ?>
            </td>
        </tr>
    <?php endif; ?>
    <tr>
        <th style="width:120px"><?php echo $form->labelEx($model, 'sort'); ?>：</th>
        <td>
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'sort'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '保存', array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<?php
Yii::app()->clientScript->registerScript('', "
var dialog = null;
var doClose = function() {
    if (null != dialog) {
        dialog.close();
    }
};
jQuery(function($) {
    $('#setEnterprise').click(function() {
        dialog = art.dialog.open('" . $this->createAbsoluteUrl('/enterprise/getEnterprise') . "', { 'id': 'selectmemberinfo', title: '搜索企业会员', width: '800px', height: '620px', lock: true });
    })
})

var onSelectMemeberInfo = function (id) {  
    if (id) {
        $.ajax({
            cache:false,
            dataType: 'json',
            url:'" . $this->createAbsoluteUrl('/enterprise/getEnterpriseName') . "&id='+id+'&YII_CSRF_TOKEN=" . Yii::app()->request->csrfToken . "',
            success:function(data){
                $('#HotelProvider_member_id').val(data.member_id);
                $('#enterpriseName').val(data.name);
            }
        })
    }
};
", CClientScript::POS_HEAD);
?>