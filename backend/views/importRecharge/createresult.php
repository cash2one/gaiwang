<?php $this->breadcrumbs = array('充值兑换管理', '生成批量充值结果');?>
<table width="890" border="1" cellpadding="0" cellspacing="0" class="integralTab mgtop10">
    <tbody>
    <tr>
        <th width="142" height="40" align="center" class="tdBg">积分</th>
        <th width="142" height="40" align="center" class="tdBg">手机号码</th>
        <th width="142" height="40" align="center" class="tdBg">GW号码</th>
        <th width="142" height="40" align="center" class="tdBg">充值结果</th>
    </tr>
    <?php foreach ($data as $k => $v): ?>
        <tr>
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['money']; ?>
            </td>
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['mobile']; ?>
            </td>
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['gaiNumber']; ?>
            </td>
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['error']; ?>
            </td>
        </tr>
    <?php endforeach; ?>    
        <tr>
            执行结果：
        </tr>

    <tr>
        <td colspan="5">
            <?php //echo CHtml::form(Yii::app()->createAbsoluteUrl('member/batchCreateExport')) ?>
                 <?php //echo CHtml::hiddenField('data',serialize($data)) ?>
            <?php //echo CHtml::endForm() ?>
        </td>
    </tr>

    </tbody>
</table>
