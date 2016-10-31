<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title></title>
    <style type="text/css">
        html, body {
            background: #f3f3f3 none repeat scroll 0 0;
        }
        dl dt{
            font-weight:bold ;
        }
        hr{color:red;}
        table th{
            background: #212121;
            color:#fff;
            padding:10px;
        }
        table td{
            border: 1px solid #bdbdbd;
            padding:5px;
            font-size:12px;
        }
    </style>
</head>

<body>
<dl>
    <dt>
        宝贝审核记录
    </dt>
    <dd>记录宝贝通过审核的时间，未通过审核的时间与原因等明细。</dd>
</dl>
<hr/>
<ul>
    <li><strong>商品名称</strong>：<?php echo $goods['name'] ?></li>
    <li><strong>商品编号</strong>：<?php echo $goods['id'] ?></li>
</ul>
<?php if(!empty($audits)): ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come">
        <tr>
            <th class="title-th odd" >提交时间</th>
            <th class="title-th odd" >审核时间</th>
            <th class="title-th odd" width="60">价格</th>
            <th class="title-th odd" width="60">审核状态</th>
            <th class="title-th odd" >审核结果</th>
        </tr>

        <?php foreach($audits as $v): ?>
            <tr>
                <td><?php echo Yii::app()->format->formatDateTime($v['add_time']) ?></td>
                <td><?php echo Yii::app()->format->formatDateTime($v['created']) ?></td>
                <td><?php echo HtmlHelper::formatPrice($v['price']) ?></td>
                <td><?php echo Goods::getStatus($v['status']) ?></td>
                <td style="color:red;"><?php echo $v['content'] ?></td>
            </tr>
        <?php endforeach; ?>

    </table>
    <br/>
    <span class="tips" style="font-size:12px;color:#03000d;">
        备注：如对以上审核持有异议，请将店铺名、商品id及原因写明并发送至盖象商城公共审核邮箱：Operation.Guangzhou@g-emall.com
    </span>
<?php else: ?>
    <hr/>
    暂无记录
<?php endif; ?>
</body>
</html>