<?php
/* @var $this OrderRefundController */
/* @var $model OrderRefund */
/* @var $form CActiveForm */
?>
<?php $form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
)); ?>
<div class="border-info clearfix">
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody>
        <tr>
            <th align="right">
                <?php echo $form->label($model, 'code'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'code', array('size' => 60, 'maxlength' => 64, 'class' => 'text-input-bj  middle')); ?>
            </td>
        </tr>
        </tbody>
    </table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody>
        <tr>
            <th align="right">
                GW号：
            </th>
            <td>
                <?php echo $form->textField($model, 'gai_number', array('size' => 60, 'maxlength' => 64, 'class' => 'text-input-bj  middle')); ?>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="c10">
    </div>
    <?php echo CHtml::submitButton('搜索', array('class' => 'reg-sub')) ?>

</div>
<div class="c10">
</div>
<?php $this->endWidget(); ?>
<?php echo CHtml::button('新增退款', array('class' => 'regm-sub addOrderRefund')) ?>
<script src="<?php echo MANAGE_DOMAIN ?>/js/swf/js/artDialog.iframeTools.js"></script>
<script>
    $(function () {
        $(".addOrderRefund").click(function () {
            art.dialog.prompt(' 请输入订单号：', function (data) {
                if (data.length < 20) {
                    alert("订单号有误");
                    return false;
                } else {
                    document.location.href = "<?php echo $this->createAbsoluteUrl('orderRefund/add') ?>&code=" + data;
                }
            }, '');
            return false;

        });
    });
</script>
