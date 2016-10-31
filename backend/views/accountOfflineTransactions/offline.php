<?php

/* @var $this AccountFlowController */
/* @var $model AccountFlow */

$this->breadcrumbs = array(
    '联动支付成功支付未生成流水补增流水' => array('offlineTransactions'),

);
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'appHotCategory-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'action'=>array('accountOfflineTransactions/supplementary'),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>

<div style="padding-top: 50px;">
    <a style="visibility: hidden;" id="export_batch_hidden" href="#"></a>
    <span style="padding: 0 60px;font-weight:bold;">1.&nbsp;&nbsp;支付单号:<input type="text" class="text-input-bj middle" name="pay_number" id="pay_number" />&nbsp;&nbsp;
<?php if (Yii::app()->user->checkAccess('AccountOfflineTransactions.Supplementary')): ?>
        <input type="submit" class="reg-sub" style="width:80px;background: red;border-radius:5px;border: 1px solid red" value="补增流水"/>
<?php endif; ?>
    </span>
</div>
<?php $this->endWidget(); ?>