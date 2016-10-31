<table width="890" border="1" cellpadding="0" cellspacing="0" class="integralTab mgtop10">
    <tbody>
    <tr>
        <th width=200" height="40" align="center" class="tdBg">兑换码</th>
        <th width="200" height="40" align="center" class="tdBg">面值</th>
       
        <th width="200" height="40" align="center" class="tdBg">结果</th>
    </tr>
    <?php foreach ($data as $k => $v): ?>
        <tr>
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['name']; ?>
            </td>
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['money']; ?>
            </td>
         
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['error']; ?>
            </td>
        </tr>
    <?php endforeach; ?>

    <tr>
        <td colspan="5">
            <?php echo CHtml::form(Yii::app()->createAbsoluteUrl('redCompensation/exchangeCodeExport')) ?>
                 <?php echo CHtml::hiddenField('data',serialize($data)) ?>
                 <?php echo CHtml::submitButton('导出Excel',array('class' => 'regm-sub')) ?>
            <?php echo CHtml::endForm() ?>
        </td>
    </tr>

    </tbody>
</table>