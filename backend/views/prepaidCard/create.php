<?php
/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */
/* @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('prepaidCard', '充值卡') => array('admin'),
    Yii::t('prepaidCard', '添加')
);
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'prepaidCard-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
        ));
?>
<div class="tip attention">
    充值卡：会员使用该充值卡充值后，将会自动的从消费会员升级为正式会员！兑现比涉及到乘除关系，因此相互转换会有一些误差，如100元 = 112积分，而112积分=100.8元，以实际金额为准，积分只是展示方式。
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody><tr><td colspan="2" class="title-th even" align="center"><?php echo Yii::t('user', '充值卡信息'); ?></td></tr></tbody>
    <tbody>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'num'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'num', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'num'); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="even">
                <?php echo $form->labelEx($model, 'money'); ?>
            </th>
            <td class="even">
                <?php
                echo $form->textField($model, 'money', array('class' => 'text-input-bj middle', 'onkeyup' => CHtml::ajax(array(
                        'url' => $this->createAbsoluteUrl('/prepaidCard/getScore'),
                        'type' => 'POST',
                        'data' => array(
                            'money' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => "function(res){
                                $('#PrepaidCard_value').val(res)}"
                ))));
                ?>
                <?php echo $form->error($model, 'money'); ?>元（实际金额和积分是按照正式会员的兑现比0.9进行转换，单位选择千盖网通积分后实际金额不能输入！） 
            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'value'); ?>
            </th>
            <td class="odd">
                <?php
                echo $form->textField($model, 'value', array('class' => 'text-input-bj middle', 'onkeyup' => CHtml::ajax(array(
                        'url' => $this->createAbsoluteUrl('/prepaidCard/getMoney'),
                        'type' => 'POST',
                        'data' => array(
                            'value' => 'js:this.value',
                            'unit' => 'js:$("input[name=\'PrepaidCard[unit]\']:checked").val()',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => "function(res){
                            $('#PrepaidCard_money').val(res)}"
                ))));
                ?>
                <?php echo $form->error($model, 'value'); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="even">
                <?php echo $form->labelEx($model, 'unit'); ?>
            </th>
            <td class="even">
                <?php
                echo $form->radioButtonList($model, 'unit', PrepaidCard::getUnit(), array(
                    'separator' => '',
                    'onChange' => CHtml::ajax(
                            array(
                                'type' => 'POST',
                                'dataType' => 'json',
                                'data' => array(
                                    'unit' => 'js:this.value',
                                    'value' => 'js:$("#PrepaidCard_value").val()',
                                    'money' => 'js:$("#PrepaidCard_money").val()',
                                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                ),
                                'url' => array("/prepaidCard/convert"),
                                'success' => "function(res){
                                    if(res){
                                    $('#PrepaidCard_money').val(res.money);
                                    $('#PrepaidCard_value').val(res.value);
                                    if(res.unit==2){
                                        $('#PrepaidCard_money').attr('readonly','readonly')
                                    }else{
                                        $('#PrepaidCard_money').removeAttr('readonly')
                                    }
                                }
                            }",
                ))));
                ?>
                <?php echo $form->error($model, 'unit'); ?>
            </td>
        </tr>

        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'owner_id'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'owner_id', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'owner_id'); ?>（请输入企业会员的会员编号，如果为空则表示充值卡无主。）
            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="even">
                <?php echo $form->labelEx($model, 'version'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'version', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'version'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd"></th>
            <td class="odd"><?php echo CHtml::submitButton(Yii::t('user', '添加'), array('class' => 'reg-sub')); ?></td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>