<?php
$this->breadcrumbs = array(
    Yii::t('offlineSignStore', ' POS差异流水对账') => array('admin'),
    Yii::t('offlineSignStore', ' 增补流水'),
);
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'article-form',
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
));
?>
<?php if(!empty($posJson)):?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
    <tr>
        <th style="width: 220px" class="odd even">
            <label for="PosAudit_terminal_number">装机编号</label>        </th>
        <td class="odd even">
            <input class="text-input-bj  middle" name="PosAudit[ShopID]" id="PosAudit_ShopID" type="text" value="<?php if(!empty($postArr['ShopID'])) echo $postArr['ShopID'];?>">            <div class="errorMessage" id="PosAudit_ShopID_em_" style="display:none"></div>        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="odd even">
            <label for="PosAudit_terminal_number">GW帐号</label>        </th>
        <td class="odd even">
            <input class="text-input-bj  middle" name="PosAudit[Name]" id="PosAudit_GWnumber" type="text" value="<?php if(!empty($postArr['Name'])) echo $postArr['Name'];?>">            <div class="errorMessage" id="PosAudit_GWnumber_em_" style="display:none"></div>        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="odd even">
            <label for="PosAudit_terminal_number">消费金额</label>        </th>
        <td class="odd even">
            <input class="text-input-bj  middle" name="PosAudit[Amount]" id="PosAudit_Amount" type="text" value="<?php if(!empty($postArr['Amount'])) echo $postArr['Amount'];?>">            <div class="errorMessage" id="PosAudit_Amount_em_" style="display:none"></div>        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="odd even">
            <label for="PosAudit_terminal_number">手机号码</label>        </th>
        <td class="odd even">
            <input class="text-input-bj  middle" name="PosAudit[UserPhone]" id="PosAudit_UserPhone" type="text" value="<?php if(!empty($postArr['UserPhone'])) echo $postArr['UserPhone'];?>">            <div class="errorMessage" id="PosAudit_UserPhone_em_" style="display:none"></div>        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="odd even">
            <label for="PosAudit_terminal_number">银行卡号</label>        </th>
        <td class="odd even">
            <input class="text-input-bj  middle" name="PosAudit[CardNum]" id="PosAudit_CardNum" type="text" value="<?php if(!empty($postArr['CardNum'])) echo $postArr['CardNum'];?>">            <div class="errorMessage" id="PosAudit_CardNum_em_" style="display:none"></div>        </td>
    </tr>
    <tr>
        <th></th>
        <td><?php echo CHtml::submitButton(Yii::t('home', '提交'), array('class' => 'reg-sub')); ?></td>
    </tr>
    </tbody>
</table>
<?php endif;?>
<?php $this->endWidget(); ?>