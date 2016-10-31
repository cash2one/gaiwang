<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'htmlOptions' => array('class' => 'searchOrder'),
        ));
?>
<div class="upladBox_1">
    <b class="mgleft35"><?php echo Yii::t('memberOrder', '订单编号'); ?>：</b>
    <?php echo $form->textField($model, 'code', array('class' => 'integaralIpt4 mgright15')) ?>
    <b><?php echo Yii::t('memberOrder', '商品名称'); ?>：</b>
    <?php echo $form->textField($model, 'goods_name', array('class' => 'integaralIpt4 mgright15')) ?>
    <b><?php echo Yii::t('memberOrder', '下单时间'); ?>： </b>
    <?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'model' => $model,
        'attribute' => 'create_time',
        'options' => array(
            'dateFormat' => 'yy-mm-dd',
            'changeMonth' => true,
            'changeYear' => true,
        ),
        'htmlOptions' => array(
            'readonly' => 'readonly',
            'class' => 'integaralIpt5',
        )
    ));
    ?>  -  <?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'model' => $model,
        'attribute' => 'end_time',
        'language' => 'zh_cn',
        'options' => array(
            'dateFormat' => 'yy-mm-dd',
            'changeMonth' => true,
            'changeYear' => true,
        ),
        'htmlOptions' => array(
            'readonly' => 'readonly',
            'class' => 'integaralIpt5',
        )
    ));
    ?>
    <?php echo CHtml::link(Yii::t('memberOrder', '搜索'), '', array('class' => 'searchBtn searchBtnright')); ?>
</div>

<div class="upladBox_1 mgtop5">
    <b class="mgleft60"><?php echo Yii::t('memberOrder', '状态'); ?>：</b>
    <?php
    //在订单状态数组头部，加入 “全部”，非0下标开始的数组，用radioButtonList 的 empty ，会导致下标改变
    $orderStatus = Order::status();
    $orderStatus = array_reverse($orderStatus, true);
    $orderStatus[''] = Yii::t('memberOrder', '全部');
    $orderStatus = array_reverse($orderStatus, true);
    ?>
    <?php echo $form->radioButtonList($model, 'status', $orderStatus, array('separator' => '　 ')); ?>
</div>

<?php $this->endWidget(); ?>
<script>
    $(".upladBox_1 a.searchBtn").click(function() {
        $("form.searchOrder").submit();
    });
</script>
