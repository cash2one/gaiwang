<?php $this->breadcrumbs = array('充值兑换管理', '导入充值结果');?>
<table width="890" border="1" cellpadding="0" cellspacing="0" class="integralTab mgtop10">
    <tbody>
    <tr>
        <th width="142" height="40" align="center" class="tdBg">序号</th>
        <th width="142" height="40" align="center" class="tdBg">充值卡卡号</th>
        <th width="142" height="40" align="center" class="tdBg">充值金额</th>
        <th width="142" height="40" align="center" class="tdBg">充值电话号码</th>        
        <th width="142" height="40" align="center" class="tdBg">充值时间</th>
        <th width="142" height="40" align="center" class="tdBg">充值人GW号码</th>
        <th width="142" height="40" align="center" class="tdBg">充值结果</th>
    </tr>
    <?php foreach ($data as $k => $v): ?>
        <tr>
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['num']; ?>
            </td>
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['card_num']; ?>
            </td>
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['money']; ?>
            </td>
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['mobile']; ?>
            </td>                      
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['time']; ?>
            </td>
            <td height="35" align="center" valign="middle" class="bgF4">
                <?php echo $v['gw_num']; ?>
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
        <td colspan="7">
            <?php echo CHtml::form(Yii::app()->createAbsoluteUrl('ImportRecharge/ImportExport')) ?>
                 <?php echo CHtml::hiddenField('data',serialize($data)) ?>
                 <?php echo CHtml::submitButton('导出Excel',array('class' => 'regm-sub','style'=>'float: left')) ?>
            <?php echo CHtml::endForm() ?>
            <div style="float: left;margin: 5px 0 0 7px">
                成功充值<span style="color: red"> <?php echo $success_count?> </span>笔
                失败<span style="color: red"> <?php echo $fail_count?> </span>笔
                成功充值总积分：<span style="color: red"> <?php echo $total_money?> </span>
            </div>
        </td>
    </tr>

    </tbody>
</table>
