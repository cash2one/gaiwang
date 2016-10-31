<?php
/* @var $this ProductController */
/* @var $goods $goods */
/** @var  $form CActiveForm */

$this->breadcrumbs = array(
    '商品' => array('admin'),
    '商品审核记录'
);
?>
<style>
    td{
        text-align:center;
    }
</style>
<ul>
    <li style="margin:10px;"><strong>商品名称:</strong><?php echo $goods->name ?></li>
    <li style="margin:10px;"><strong>商品编号:</strong><?php echo $goods->id; ?></li>
</ul>
<?php if(!empty($audits)): ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come">
    <tr>
        <th class="title-th odd" >审核人员</th>
        <th class="title-th odd" >提交时间</th>
        <th class="title-th odd" >审核时间</th>
        <th class="title-th odd" >价格</th>
        <th class="title-th odd" >审核状态</th>
        <th class="title-th odd" >审核结果</th>
    </tr>

    <?php foreach($audits as $v): ?>
    <tr>
        <td ><?php echo $v['username'] ?></td>
        <td><?php echo Yii::app()->format->formatDateTime($v['add_time']) ?></td>
        <td><?php echo Yii::app()->format->formatDateTime($v['created']) ?></td>
        <td>￥<?php echo $v['price'] ?></td>
        <td><?php echo Goods::getStatus($v['status']) ?></td>
        <td style="color:red;"><?php echo $v['content'] ?></td>
    </tr>
    <?php endforeach; ?>

</table>
<?php else: ?>
    <hr/>
暂无记录
<?php endif; ?>

<script>
    $(function(){
        $(".com-box").attr("style",'min-height:auto;');
    });
</script>
