<?php
/** @var $model CashHistory */
/** @var $infoModel Enterprise */
/** @var $form  CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'member-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-come">
    <tbody>
    <tr>
        <td class="title-th odd" style="text-align: center" colspan="2">
            <?php echo Yii::t('cashHistory','企业会员基本信息'); ?>
        </td>
    </tr>

    <tr>
        <th width="100" align="right" class="even">
            <?php echo Yii::t('cashHistory','商家名称'); ?>：
        </th>
        <td class="even">
            <?php echo $infoModel->name ?>
        </td>
    </tr>
    <tr>
        <th width="100" align="right" class="odd">
            <?php echo Yii::t('cashHistory','联系方式'); ?>：
        </th>
        <td class="odd">
            <?php echo $infoModel->mobile ?>
        </td>
    </tr>
    <tr>
        <td class="title-th even" style="text-align: center" colspan="2">
            <?php echo Yii::t('cashHistory','银行帐号信息'); ?>
        </td>
    </tr>
    <tr>
        <th width="100" align="right">
            <?php echo Yii::t('cashHistory','开户行'); ?>：
        </th>
        <td>
            <?php echo $model->bank_name ?>
        </td>
    </tr>
    <tr>
        <th width="100" align="right">
            <?php echo Yii::t('cashHistory','银行地址'); ?>：
        </th>
        <td>
            <?php echo $model->bank_address ?>
        </td>
    </tr>
    <tr>
        <th width="100" align="right">
            <?php echo Yii::t('cashHistory','账户名'); ?>：
        </th>
        <td>
            <?php echo $model->account_name ?>
        </td>
    </tr>
    <tr>
        <th width="100" align="right">
            <?php echo Yii::t('cashHistory','银行帐号'); ?>：
        </th>
        <td>
            <?php echo $model->account ?>
        </td>
    </tr>
    <tr>
        <td class="title-th odd" style="text-align: center" colspan="2">
            <?php echo Yii::t('cashHistory','商家申请提现信息'); ?>
        </td>
    </tr>
    <tr>
        <th width="100" align="right" class="even">
            <?php echo Yii::t('cashHistory','申请金额'); ?>：
        </th>
        <td class="even">
            ￥ <?php echo $model->money ?>
        </td>
    </tr>
    <tr>
        <th width="100" align="right" class="odd">
            <?php echo Yii::t('cashHistory','手续费'); ?>：
        </th>
        <td class="odd">
            ￥ <?php echo $fee = sprintf('%0.2f',$model->money*$model->factorage/100) ?>
        </td>
    </tr>
    <tr>
        <th width="100" align="right" class="even">
            <?php echo Yii::t('cashHistory','手续费率'); ?>：
        </th>
        <td class="even">
            <?php echo $model->factorage ?>%
        </td>
    </tr>
    <tr>
        <th width="100" align="right" class="odd">
            <?php echo Yii::t('cashHistory','实际扣除'); ?>：
        </th>
        <td class="odd">
            ￥ <?php echo $model->money+$fee; ?>
        </td>
    </tr>
    <tr>
        <th width="100" align="right" class="even">
            <?php echo Yii::t('cashHistory','应转账金额'); ?>：
        </th>
        <td style="color: Red; font-weight: bold;" class="even">
            ￥ <?php echo $model->money ?>
        </td>
    </tr>
    <tr>
        <td class="title-th odd" style="text-align: center" colspan="2">
            <?php echo Yii::t('cashHistory','操作'); ?>
        </td>
    </tr>
    <tr>
        <th width="100" align="right" class="even">
            <?php echo Yii::t('cashHistory','原因'); ?>：
        </th>
        <td class="even">
            <?php if(in_array($model->status,array($model::STATUS_APPLYING,$model::STATUS_TRANSFERING,$model::STATUS_CHECKED))): ?>
                <?php echo $form->textArea($model,'reason',array('rows'=>'3','cols'=>'20','class'=>'text-input-bj  text-area valid')) ?>
                <br />
                <a class="copyToReason" href="#" ><?php echo Yii::t('cashHistory','余额不足'); ?></a>
                &nbsp; &nbsp; &nbsp; &nbsp;
                <a class="copyToReason" href="#" ><?php echo Yii::t('cashHistory','帐号信息不对'); ?></a>
            <?php else: ?>
                <?php echo $model->reason ?>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th width="100" align="right" class="odd">
            <?php echo Yii::t('cashHistory','状态'); ?>：
        </th>
        <td id="tdStatus" class="odd">
            <?php if(in_array($model->status,array($model::STATUS_APPLYING,$model::STATUS_TRANSFERING,$model::STATUS_CHECKED))): ?>
                <?php $status = $model::status();
                ?>
                <?php echo $form->radioButtonList($model,'status',$status,array('separator'=>' ')); ?>
            <?php else: ?>
                <?php echo $model::status($model->status) ?>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th width="100" align="right" class="even">
            <?php if(in_array($model->status,array($model::STATUS_APPLYING,$model::STATUS_TRANSFERING,$model::STATUS_CHECKED))): ?>
                <?php echo CHtml::submitButton('保存',array('class'=>'reg-sub')) ?>
            <?php endif; ?>
        </th>

        <td style="color: Red; font-weight: bold;" class="even">
        </td>
    </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>

<script>
    $(".copyToReason").click(function () {
        $("#CashHistory_reason").val($(this).html());
        return false;
    });
    $(":input[type='submit']").click(function () {
        var status = $("#CashHistory_status input:checked").val();
        var reason = $("#CashHistory_reason").val();
        if (status ==<?php echo $model::STATUS_TRANSFERED ?> || status ==<?php echo $model::STATUS_FAIL ?>) {
            if (confirm("<?php echo Yii::t('cashHistory','您确认已审核，并保存信息？'); ?>")) {
                if (reason == "") {
                    alert("<?php echo Yii::t('cashHistory','请填写原因信息，若成功填写转账人等信息，若失败填写失败原因'); ?>");
                    return false;
                }
            }
            else {
                return false;
            }
        }
        return true;
    });
</script>