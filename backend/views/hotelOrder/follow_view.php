<?php
$this->breadcrumbs = array(Yii::t('hotelOrder', '订单跟进详情'));
?>
<link rel="stylesheet" type="text/css" href="/css/jqtransform.css">
<script type="text/javascript" src="/js/jquery.jqtransform.js"></script>
<style>
    .com-box{min-height: 350px}
</style>

<!--弹窗 begin-->
<div class="sellerWebSignProgress">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg4">
        <tbody>
        <tr>
            <th width="10%" class="bgOrange">时间</th>
            <th width="10%" class="bgOrange">操作人</th>
            <th width="10%" class="bgOrange">订单状态</th>
            <th width="90%" class="bgOrange">跟进内容</th>
        </tr>
        <?php if($follows): ?>
            <?php foreach ($follows as $v): ?>
            <tr>
                <td class="ta_c" style="text-align: center" ><?php echo $this->format()->formatDatetime($v->create_time); ?></td>
                <td style="text-align: center" ><?php echo $v->creater ?></td>
                <td style="text-align: center" ><?php echo HotelOrder::getOrderStatus($v->status) ?></td>
                <td class="ta_l"  style="word-break:break-all" ><?php echo  CHtml::encode($v->content); ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td class="ta_c" style="text-align: center" colspan="4">无跟进记录</td>

            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>