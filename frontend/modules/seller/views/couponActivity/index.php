<?php
	$baseUrl = Yii::app()->baseUrl;
	$cs = Yii::app()->clientScript;
	
	//显示原图的JS插件
	$cs->registerCssFile($baseUrl. "/js/swf/js/fancybox/jquery.fancybox-1.3.4.css"); 			
	$cs->registerScriptFile($baseUrl. "/js/swf/js/fancybox/jquery.fancybox-1.3.4.pack.js");	
	
	$this->breadcrumbs = array(
	    Yii::t('sellerCouponActivity', '盖惠券管理') => array('/seller/couponActivity/index')
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

//开启或暂停盖惠券
function osCoupon(url,state){
	var content = state == 1 ? '<?php echo Yii::t('sellerCouponActivity', '确定开启当前的盖惠券红包的领取').'？'?>' : '<?php echo Yii::t('sellerCouponActivity', '确定暂停送出当前的盖惠券红包').'？'?>';
	if (confirm(content)){
		$.get(url, function(data){
    		if(data === "1"){
    			$("#_search_coupon").submit();
    		} else {
				alert(data);
        	}
		});
	}
	return false;
}
</script>

<div class="toolbar">
	<span>
		<?php 
			echo Yii::t('sellerCouponActivity','盖网授权总派发金额') . '：￥' . $model->gaiMoney . ',  '.
			Yii::t('sellerCouponActivity','我已创建的盖惠券金额') . '：￥' . $model->shopMoney . ',  '.
			Yii::t('sellerCouponActivity','用户已领取盖惠券金额') . '：￥' . $userMoney ; 
		?>
	</span>
</div>

<?php
	//查询 
	$this->renderPartial('_search',array('model' => $model, 'gaiMoney' => $model->gaiMoney, 'shopMoney' => $model->shopMoney));
?>

<div class="ctxTable" id="dListTable">
<?php
	$this->widget('GridView',array(
		'id'=>'coupon-activity-grid',
		'itemsCssClass'=>'mt15 sellerT3 goodsIndex',
		'dataProvider'=>$model->search(),
		'enableSorting' => false,
		'cssFile'=>false,
		'pagerCssClass'=>'page_bottom clearfix',
		'pager'=>array(
			'class'=>'LinkPager',
			'htmlOptions'=>array('class'=>'pagination'),
		),
		'columns'=>array(
			array(
				'headerHtmlOptions'=>array('width'=>'10%'),
				'name'=>'update_time',
				'value'=>'date("Y-m-d H:i:s", $data->update_time)',
			),
			array(
				'headerHtmlOptions'=>array('width'=>'8%'),
				'name'=>'thumbnail',
				'value'=>'CouponActivity::thumbnailHtml($data->thumbnail)',
				'htmlOptions' => array('align' => 'center'),
			
			),
			array(
				'headerHtmlOptions' => array('width' => '15%'),
				'name' => 'name',
				'value' => '$data->name'
			),
			array(
				'headerHtmlOptions' => array('width' => '6%'),
				'name' => 'price',
				'value' => 'CouponActivity::priceHtml($data->price)'
			),
			array(
				'headerHtmlOptions' => array('width' => '6%'),
				'name' => 'condition',
				'value' => 'CouponActivity::conditionHtml($data->condition)'
			),
			array(
				'headerHtmlOptions' => array('width' => '15%'),
				'name' => 'valid_start',
				'value' => 'CouponActivity::validHtml($data)'
			),
			array(
				'headerHtmlOptions' => array('width' => '14%'),
				'name' => 'num',
				'value' => 'CouponActivity::numHtml($data)'
			),
			array(
				'headerHtmlOptions' => array('width' => '10%'),
				'name' => 'status',
				'value' => 'CouponActivity::statusHtml($data)'
			),
			array(
				'class'=>'CButtonColumn',
				'header' => Yii::t('Public','操作'),
				'template'=>'{update} {delete} {open} {stop}',
				'deleteConfirmation'=>Yii::t('sellerCouponActivity','确定删除当前盖惠券').'?',
				'buttons'=>array(
					'update' => array(
						'label' => '【'.Yii::t('Public','编辑').'】',
						'url' => 'Yii::app()->controller->createUrl("update", array("id"=>$data->primaryKey))',
						'visible' => '$data->status != CouponActivity::COUPON_STATUS_NEW',
						'imageUrl' => false
					),
					'delete'=>array(
						'label'=>"【". "删除"."】",
						'url' => 'Yii::app()->controller->createUrl("delete",array("id"=>$data->primarykey))',
//						'visible' => '$data->status != CouponActivity::COUPON_STATUS_NEW',
						'visible' => '1<>1',
						'imageUrl' => false,
					),
					'open' => array(
						'label' => '【'.Yii::t('Public','开启领取').'】',
						'url' => 'Yii::app()->controller->createUrl("os", array("id"=>$data->primaryKey,"state"=>CouponActivity::COUPON_STATE_YES))',
						'visible' => '$data->status == CouponActivity::COUPON_STATUS_PASS && $data->state == CouponActivity::COUPON_STATE_NO',
						'options' => array('onclick' => 'return osCoupon(this.href,1)'),
						'imageUrl' => false
					),
					'stop' => array(
						'label' => '【'.Yii::t('Public','暂停领取').'】',
						'url' => 'Yii::app()->controller->createUrl("os", array("id"=>$data->primaryKey,"state"=>CouponActivity::COUPON_STATE_NO))',
						'visible' => '$data->status == CouponActivity::COUPON_STATUS_PASS && $data->state == CouponActivity::COUPON_STATE_YES',
						'options' => array('onclick' => 'return osCoupon(this.href,0)'),
						'imageUrl' => false
					),
				),
			),
		),
	));
?>
</div>