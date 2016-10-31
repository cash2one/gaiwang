<!--<table width="890" border="1" cellpadding="0" cellspacing="0" class="integralTab mgtop10">-->
    <tbody>
    <tr>
        <th width="142" height="40" align="center" class="tdBg">用户名</th>
        <th width="142" height="40" align="center" class="tdBg">GW号码</th>
        <th width="142" height="40" align="center" class="tdBg">手机号码</th>
        <th width="142" height="40" align="center" class="tdBg">密码</th>
        <th width="142" height="40" align="center" class="tdBg">结果</th>
    </tr>
    <?php foreach ($data as $k => $v): ?>
        <tr>
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['username']; ?>
            </td>
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['gai_number']; ?>
            </td>
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['mobile']; ?>
            </td>
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['password']; ?>
            </td>
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['error']; ?>
            </td>
        </tr>
    <?php endforeach; ?>

    <tr>
        <td colspan="5">
            <?php echo CHtml::form(Yii::app()->createAbsoluteUrl('member/batchCreateExport')) ?>
                 <?php echo CHtml::hiddenField('data',serialize($data)) ?>
                 <?php echo CHtml::submitButton('导出Excel',array('class' => 'regm-sub')) ?>
            <?php echo CHtml::endForm() ?>
        </td>
    </tr>

    </tbody>
</table>
