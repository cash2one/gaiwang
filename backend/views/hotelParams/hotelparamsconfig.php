<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'hotelParams-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
)
);
?>
<table width='100%' border='0' class='tab-come' cellspacing='1' cellpadding='0'>
    <tbody>    
        <tr> <th class="title-th even" colspan="2" style="text-align: center;"> <?php echo Yii::t('hotelParams', '酒店价格系数配置'); ?> </th> </tr>
        <tr>
            <th width="200px" align="right" class="odd">
                <?php echo $form->labelEx($model, 'orderRation'); ?>：
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'orderRation', array('class' => 'text-input-bj long')); ?>
                <?php echo $form->error($model, 'orderRation'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right" class="even">
                <?php echo $form->labelEx($model, 'checkOutFees'); ?>：
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'checkOutFees', array('class' => 'text-input-bj long')); ?>
                <?php echo $form->error($model, 'checkOutFees'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right" class="odd">
                <?php echo $form->labelEx($model, 'luckRation'); ?>：
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'luckRation', array('class' => 'text-input-bj long')); ?>
                <?php echo $form->error($model, 'luckRation'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right" class="even">
                <?php echo $form->labelEx($model, 'luckMoneyRation'); ?>：
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'luckMoneyRation', array('class' => 'text-input-bj long')); ?>
                <?php echo $form->error($model, 'luckMoneyRation'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right" class="odd">
                <?php echo $form->labelEx($model, 'autoComplete'); ?>：
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'autoComplete', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'autoComplete'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'hotelOnBusinessTravelAccount'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'hotelOnBusinessTravelAccount', array('class' => 'text-input-bj  least', 'readonly' => 'readonly', 'style' => 'width:200px; background:#eee;')); ?>
                <?php echo $form->hiddenField($model, 'hotelOnBusinessTravelMemberId'); ?>
                <?php echo $form->error($model, 'hotelOnBusinessTravelAccount'); ?>
                <?php // if (!Tool::getConfig('hotelparams', 'hotelOnBusinessTravelMemberId')): ?>
                    <?php echo CHtml::button('绑定商旅收益账户', array('class' => 'reg-sub-01', 'readonly' => true, 'id' => 'setEnterprise')); ?>
                    <?php echo $form->error($model, 'hotelOnBusinessTravelMemberId'); ?>
                <?php // endif; ?>

            </td>
        </tr>
        <tr>
            <th class="title-th even" colspan="2" style="text-align: center;"> <?php echo Yii::t('hotelParams', '其他参数配置'); ?></th>
        </tr>
        <tr>
            <th width="120px" align="right" class="odd">
                <?php echo $form->labelEx($model, 'pricerange'); ?>：
            </th>
            <td class="odd">
                <?php echo $form->textField($model,'pricerange',array('class' => 'text-input-bj  long'));?>  (例：100-200|200-300|)
                <?php echo $form->error($model, 'pricerange'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right" class="odd">
                <?php echo $form->labelEx($model, 'hotelServiceTel'); ?>：
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'hotelServiceTel', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'hotelServiceTel'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right" class="odd">
                <?php echo $form->labelEx($model, 'hotelServiceTime'); ?>：
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'hotelServiceTime', array('class' => 'text-input-bj middle')); ?>（时间格式：9:30-18:30）
                <?php echo $form->error($model, 'hotelServiceTime'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right" class="odd">
                <?php echo $form->labelEx($model, 'latestStayTime'); ?>：
            </th>
            <td class="odd">
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'latestStayTime',
                    'select' => 'time',
                    'options' => array(
//                        'timeFormat' => 'hh:mm:ss',
                    ),
                ));
                ?>（时间格式：18:30:00）
                <?php echo $form->error($model, 'latestStayTime'); ?>
            </td>
        </tr>
        <tr>
            <th width="120px" align="right" class="odd">
                <?php echo $form->labelEx($model, 'duration'); ?>：
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'duration', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'duration'); ?> （示例格式 : 30/分钟）
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php echo CHtml::submitButton("保存", array('class' => 'reg-sub')); ?>
            </td>
        </tr>
    </tbody>
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
        dialog = art.dialog.open('" . $this->createAbsoluteUrl('/enterprise/getEnterprise') . "', { 'id': 'selectmemberinfo', title: '搜索会员', width: '800px', height: '620px', lock: true });
    })
})

var onSelectMemeberInfo = function (id) {  
    if (id) {
        $.ajax({
            cache:false,
            dataType: 'json',
            url:'" . $this->createAbsoluteUrl('/enterprise/getEnterpriseName') . "&id='+id+'&YII_CSRF_TOKEN=" . Yii::app()->request->csrfToken . "',
            success:function(data){
                $('#HotelParamsConfigForm_hotelOnBusinessTravelMemberId').val(data.member_id);
                $('#HotelParamsConfigForm_hotelOnBusinessTravelAccount').val(data.name);
            }
        })
    }
};
", CClientScript::POS_HEAD);
?>