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
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<?php if (Yii::app()->user->checkAccess('OrderMember.Create')): ?>
    <input id="Btn_Add" type="button" value="<?php echo Yii::t('OrderMember', '添加订单用户'); ?>" class="regm-sub" onclick="location.href = '<?php echo Yii::app()->createAbsoluteUrl("/orderMember/create"); ?>'">
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'order-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'code',
    	'member_id',
        'real_name',
    	'mobile',
    	array(
    		 'name' => '周岁',
    		 'value' => '(date("Y")+1)-substr("$data->identity_number",6,4)',
    		 'type' => 'raw',
    	),
        array(
            'name' => 'sex',
            'value' => '"<span class=\"status\" data-status=\"$data->sex\">".OrderMember::getMemberSex($data->sex)."</span>"',
            'type' => 'raw',
        ),
    	'identity_number',
        array('name' => 'create_time', 'type' => 'dateTime'),
        array(
            'class' => 'CButtonColumn',
            //'template' => '{view}{update}{delete}',
        	'template' => '{update}{delete}',
            'htmlOptions' => array('style'=>'width:120px','class'=>'button-column'),
            'viewButtonImageUrl' => false,
            'deleteConfirmation' => Yii::t('OrderMember', '确定删除该订单用户信息吗？'),
            'buttons' => array(
                /*'view' => array(
                    'label' => Yii::t('OrderMember', '查看'),
                    'visible' => "Yii::app()->user->checkAccess('OrderMember.View')"
                ),*/
            	'update' => array(
            		'label' => Yii::t('OrderMember', '编辑'),
            		'imageUrl' => false,
            		'visible' => "Yii::app()->user->checkAccess('OrderMember.Update')"
            	),
                'delete' => array(
                    'label' => Yii::t('OrderMember', '删除'),
                    'imageUrl' => false,
                    'visible' => "Yii::app()->user->checkAccess('OrderMember.Delete')"
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
    'model' => $model, 'exportPage' => $exportPage, 'totalCount' => $totalCount,
));
?>