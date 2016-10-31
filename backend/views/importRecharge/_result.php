<style>
    .sub {
        background-image: url("../images/sub.gif");
        border: 0 none;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        font-family: "微软雅黑";
        font-size: 14px;
        height: 27px;
        line-height: 27px;
        text-align: center;
        width: 55px;
    }
    a:hover {
        color: white;
        text-decoration: none;
    }
</style>
<br/>
<hr/>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <thead>
        <?php
        $total = 0;
        foreach ($result as $vv) {
            $total = $total + sprintf("%.2f", $vv['money'] / $memberType['official']);
        }
        ?>
        执行结果：总共有<span class="required"><?php echo count($result) ?></span>个账号,总充值积分为:<span class="required"><?php echo $total ?></span> (成功后会以短信形式通知)  
</thead>    
<tr>
    <td>序号</td>
    <td>GW号码</td>
    <td>手机号码</td>
    <td>积分</td>
    <td>导入时间</td>
    <td>状态</td>
</tr>
<?php foreach ($result as $k => $data): ?>
    <tr>
        <td><?php echo $k + 1 ?></td>
        <td><?php echo $data['gai_number'] ?></td>
        <td><?php echo $data['mobile'] ?></td>
        <td><?php echo sprintf("%.2f", $data['money'] / $memberType['official']) ?></td>
        <td><?php echo date('Y-m-d H:i:s', $data['create_time']) ?></td>
        <td><?php echo ImportRechargeRecord::getStatus($data['status']) ?></td>
    </tr>
<?php endforeach; ?>
<tr>
    <td colspan="2">
        <?php echo CHtml::link('上传', Yii::app()->createAbsoluteUrl('/importRecharge/index', array('but' => '1')), array('class' => 'sub')) ?>
        <?php echo CHtml::link('取消', Yii::app()->createAbsoluteUrl('/importRecharge/delete'), array('class' => 'sub')) ?>
    </td>
</tr>
</table>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>



