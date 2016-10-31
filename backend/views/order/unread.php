<?php
/* @var $this OrderController */
/* @var $model Order */
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#order-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
//	return false;
});
");
?>

<div class="search-form" >
    <?php
    /* @var $this OrderController */
    /* @var $model Order */
    /* @var $form CActiveForm */
    ?>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
    )); ?>
    <div class="border-info clearfix">
        <table cellspacing="0" cellpadding="0" class="searchTable">
            <tbody><tr>
                <th align="right">
                    <?php echo $form->label($model,'code'); ?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'code',array('size'=>60,'maxlength'=>64,'class'=>'text-input-bj  middle')); ?>
                </td>
            </tr>
            </tbody></table>
        <table cellspacing="0" cellpadding="0" class="searchTable">
            <tbody><tr>
                <th align="right">
                    <?php echo Yii::t('order','商铺名称'); ?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'store_id',array('size'=>11,'maxlength'=>11,'class'=>'text-input-bj  least')); ?>
                </td>
            </tr>
            </tbody></table>
        <table cellspacing="0" cellpadding="0" class="searchTable">
            <tbody><tr>
                <th align="right">
                    <?php echo Yii::t('order','买家会员编码'); ?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'member_id',array('size'=>11,'maxlength'=>11,'class'=>'text-input-bj  least')); ?>
                </td>
            </tr>
            </tbody></table>
        <table cellspacing="0" cellpadding="0" class="searchTable">
            <tbody><tr>
                <th align="right">
                    <?php echo $form->label($model,'create_time'); ?>：
                </th>
                <td colspan="2">
                    <?php
                    $this->widget('comext.timepicker.timepicker', array(
                        'name' => 'start_create',
                        'select'=>'date',
                    ));
                    ?>-
                    <?php
                    $this->widget('comext.timepicker.timepicker', array(
                        'name' => 'end_create',
                        'select'=>'date'
                    ));
                    ?>
                </td>
            </tr>
            </tbody></table>

        <div class="c10">
        </div>
        <?php echo CHtml::submitButton('搜索',array('class'=>'reg-sub')) ?>
    </div>
    <div class="c10">
    </div>
    <?php $this->endWidget(); ?>
    <script>
        $(":input[name$=create]").addClass('least').removeClass('middle');
    </script>
</div><!-- search-form -->
<?php
?>
<?php
$this->widget('GridView', array(
    'id' => 'order-grid',
    'dataProvider' => $model->search(Order::IS_READ_NO),
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'name' => 'code',
            'value' => '$data->real_price>=20000?"<span class=\"ico_sb\">".$data->code."</span>":$data->code',
            'type' => 'raw',
        ),
        array('name'=>'member_id','header'=>'买家会员编号'),
        array('name'=>'store_id','header'=>'店铺名称'),
        array(
            'name' => 'create_time',
            'type' => 'dateTime',
        ),
        array(
            'name' => 'refund_status',
            'value' => 'Order::refundStatus($data->refund_status)',
        ),
        array(
            'name' => 'return_status',
            'value' => 'Order::returnStatus($data->return_status)',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'viewButtonImageUrl' => false,
            'buttons' => array(
                'view' => array(
                    'label' => Yii::t('order', '查看'),
                    'visible' => "Yii::app()->user->checkAccess('Order.View')"
                ),
            )
        ),
    ),
));
?>
<script>
    function prepaidCardUsedLookUp(gai_number) {
        //弹出添加等窗口    
        var dialog = art.dialog({id: 'N3690', title: '充值记录', width: '90%', height: '90%', background: '#333', opacity: 0.40});
        $.ajax({
            url: "<?php echo $this->createUrl('recharge/admin') ?>&Recharge[member_id]=" + gai_number,
            success: function(data) {
                dialog.content(data);
                $(".aui_state_focus").css('width', '90%');
                $(".aui_content").css('width', '90%');

            },
            cache: false
        });
    }
    //设置订单状态不同的颜色
    setInterval(function() {
        $(".status").each(function(att, value) {
            switch (parseInt($(this).attr('data-status'))) {
                case <?php echo Order::STATUS_CLOSE ?>:
                    $(this).css('color', 'red');
                    break;
                case <?php echo Order::STATUS_NEW ?>:
                    $(this).css('color', 'blue');
                    break;
                case <?php echo Order::STATUS_COMPLETE ?>:
                    $(this).css('color', 'green');
                    break;
            }
        });
    }, 1000);

    //隐藏导出菜单
    function hide_excel() {
        if ($("span.empty").html() == '没有找到数据.') {
            $("div.summary").hide();
        }
    }
    setInterval('hide_excel()', 1000);

</script>

<?php 
	$this->renderPartial('/layouts/_export', array(
	    'model' => $model,'exportPage' => $exportPage,'totalCount'=>$totalCount,
	));
?>
