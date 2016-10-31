<tr>
    <td rowspan="5">
        <input type="checkbox" name="rights[]" <?php if (in_array('Main.TradeManagement', $rights)): ?>checked="checked"<?php endif; ?> value="Main.TradeManagement" id="MainTradeManagement"><label for="MainTradeManagement">交易管理</label>
    </td>   
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.accountBalance', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.accountBalance" id="SubaccountBalance"><label for="SubaccountBalance">账户余额</label>
    </td>
    <td>
        <?php $this->renderPartial('_accountBalance', array('rights' => $rights)); ?>
    </td>
</tr>
<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.accountFlow', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.accountFlow" id="SubaccountFlow"><label for="SubaccountFlow">交易流水</label>
    </td>
    <td>
        <?php $this->renderPartial('_accountFlow', array('rights' => $rights)); ?>
    </td>
</tr>
<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.accountOfflineTransactions', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.accountOfflineTransactions" id="SubaccountOfflineTransactions"><label for="SubaccountOfflineTransactions">线下交易流水</label>
    </td>
    <td>
        <?php $this->renderPartial('_accountOffline', array('rights' => $rights)); ?>
    </td>
</tr>
<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.accountPosRecord', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.accountPosRecord" id="SubaccountPosRecord"><label for="SubaccountPosRecord">交易对账</label>
    </td>
    <td>
        <?php $this->renderPartial('_accountPos', array('rights' => $rights)); ?>
    </td>
</tr>
<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.accountFlowHistory', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.accountFlowHistory" id="SubaccountFlowHistory"><label for="SubaccountFlowHistory">盖粉转账</label>
    </td>
    <td>
        <?php $this->renderPartial('_accountFlowgf', array('rights' => $rights)); ?>
    </td>
</tr>