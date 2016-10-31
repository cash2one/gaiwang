<?php
/** @var $model CouponActivity */
	$baseUrl = Yii::app()->baseUrl;
	$cs = Yii::app()->clientScript;
	
	//显示原图的JS插件
	$cs->registerCssFile($baseUrl. "/js/swf/js/fancybox/jquery.fancybox-1.3.4.css"); 			
	$cs->registerScriptFile($baseUrl. "/js/swf/js/fancybox/jquery.fancybox-1.3.4.pack.js");		
	
	$this->breadcrumbs = array(
	    Yii::t('sellerCouponActivity', '盖惠券管理') => array('admin')
	);
	
	//查询静态刷新页面
	Yii::app()->clientScript->registerScript('search', "
		$('#_search_coupon').submit(function(){
			$('#coupon-activity-grid').yiiGridView('update', {
				data: $(this).serialize()
			});
			return false;
		});
	");
?>
<script type="text/javascript">
/**
 * 点击图片显示放大图
 * @param obj 链接对象
 */
function _showBigPic(obj)
{
	$.fancybox({
		href: $(obj).attr("href"),
		'overlayShow'	: true,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	});
	return false;
}

function chooseConfirm(obj){
	var url = obj.href;
	art.dialog({
		title: '<?php echo Yii::t('sellerCouponActivity', '操作提示')?>',
        icon: 'question',
	    content: '<?php echo Yii::t('sellerCouponActivity', '是否通过该盖惠券的审核').'？'?>',
	    button: [
             {
                 name: '<?php echo Yii::t('sellerCouponActivity', '通过')?>',
                 callback: function () {
                	 url += '&status='+<?php echo CouponActivity::COUPON_STATUS_PASS?>;
                	 $.get(url, function(data){
                 		if(data){
             				$(obj).parents()[1].childNodes[8].innerHTML = data;
                            $(obj).hide();
                 		} else {
         					alert('<?php echo Yii::t('sellerCouponActivity', '参数异常，审核失败')?>');
                     	}
         			});
                	 return true;
                 }
             },
             {
                 name: '<?php echo Yii::t('sellerCouponActivity', '不通过')?>',
                 callback: function () {
                	 url += '&status='+<?php echo CouponActivity::COUPON_STATUS_FAIL?>;
                	 $.get(url, function(data){
                 		if(data){
             				$(obj).parents()[1].childNodes[8].innerHTML = data;
                 		} else {
         					alert('<?php echo Yii::t('sellerCouponActivity', '参数异常，审核失败')?>');
                     	}
         			});
           			return true;
                 }
             }
         ]
	});
	return false;
}
</script>

<div class="border-info clearfix search-form">
    <table class="searchTable" cellspacing="0" cellpadding="0">
        <tr>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'id' => '_search_coupon'
            ));
            ?>
            <td>授信额共计：</td>
            <td><?php echo number_format($totalMoney,2);?></td>
            <td>商家参与度：</td>
            <td><?php echo $storeAccountCount.'/'.$storeCount;?></td>
            <td></td>
            <td>商家编号：</td>
            <td><?php echo $form->textField($model, 'member_id', array('class' => 'text-input-bj')); ?></td>
            <td>商家名称：</td>
            <td>
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj')); ?>
            </td>

            <td><?php echo CHtml::submitButton(Yii::t('sellerCouponActivity', '搜索'), array('class' => 'reg-sub')); ?></td>
            <td>
                <?php echo $form->radioButtonList($model, 'c_status', StoreAccount::getStatus(),array('separator' => ' ','onclick' => 'javascript:$("#_search_coupon").submit()')); ?>
            </td>
            <?php $this->endWidget(); ?>
        </tr>
    </table>
</div>

<div class="ctxTable" id="dListTable">
<?php
	$this->widget('GridView',array(
		'id'=>'coupon-activity-grid',
		'itemsCssClass'=>'tab-reg',
		'dataProvider'=>$model->searchCouponCredit(),
		'enableSorting' => false,
		'cssFile'=>false,
		'pager'=>array(
			'class'=>'LinkPager',
			'htmlOptions'=>array('class'=>'pagination'),
		),
		'columns'=>array(
			array(
				'headerHtmlOptions'=>array('width'=>'10%'),
				'name'=>'name',
				'value'=>'$data->name',
			),
            array(
                'headerHtmlOptions'=>array('width'=>'8%'),
                'name'=>'c_money',
                'value'=>'$data->c_money',
                'htmlOptions' => array('align' => 'center'),
            ),
			array(
				'headerHtmlOptions'=>array('width'=>'8%'),
				'name'=>'c_surplus_money',
				'value'=>'$data->c_surplus_money',
				'htmlOptions' => array('align' => 'center'),
			
			),
			array(
				'headerHtmlOptions' => array('width' => '17%'),
				'name' => 'c_ratio',
				'value' => '$data->c_ratio'
			),
			array(
				'headerHtmlOptions' => array('width' => '8%'),
				'name' => 'c_status',
				'value' => 'StoreAccount::getStatus($data->c_status)'
			),
			array(
				'class'=>'CButtonColumn',
				'header' => Yii::t('couponActivity','操作'),
				'headerHtmlOptions' => array('width' => '8%'),
				'template'=>'{view}',
                'htmlOptions' => array('class' => 'tc'),
				'buttons'=>array(
					'view' => array(
						'label' => Yii::t('couponActivity','【查看详情】'),
						'imageUrl' => false,
                        'url'	=>'Yii::app()->createUrl("couponActivity/creditView", array("id"=>$data->id))',
                        'options' => array('id' => 'update','class' => 'regm-sub-a')
					),

				),
			),
		),
	));
?>
</div>