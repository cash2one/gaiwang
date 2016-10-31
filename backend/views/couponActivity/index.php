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

<?php
	//查询 
	$this->renderPartial('_search',array('model' => $model));
?>

<div class="ctxTable" id="dListTable">
<?php
	$this->widget('GridView',array(
		'id'=>'coupon-activity-grid',
		'itemsCssClass'=>'tab-reg',
		'dataProvider'=>$model->search(),
		'enableSorting' => false,
		'cssFile'=>false,
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
                'name'=>'storeName',
                'value'=>'$data->storeName',
                'htmlOptions' => array('align' => 'center'),

            ),
			array(
				'headerHtmlOptions'=>array('width'=>'8%'),
				'name'=>'thumbnail',
				'value'=>'CouponActivity::thumbnailHtml($data->thumbnail)',
				'htmlOptions' => array('align' => 'center'),
			
			),
			array(
				'headerHtmlOptions' => array('width' => '17%'),
				'name' => 'name',
				'value' => '$data->name'
			),
			array(
				'headerHtmlOptions' => array('width' => '8%'),
				'name' => 'money',
				'value' => 'CouponActivity::priceHtml($data->money)'
			),
			array(
				'headerHtmlOptions' => array('width' => '8%'),
				'name' => 'condition',
				'value' => 'CouponActivity::conditionHtml($data->condition)'
			),
			array(
				'headerHtmlOptions' => array('width' => '18%'),
				'name' => 'valid_start',
				'value' => 'CouponActivity::validHtml($data)'
			),
			array(
				'headerHtmlOptions' => array('width' => '10%'),
				'name' => 'sendout',
				'value' => '$data->sendout'
			),
			array(
				'headerHtmlOptions' => array('width' => '10%'),
				'name' => 'status',
				'value' => 'CouponActivity::getCouponStatus($data->status)',
			),
			array(
				'class'=>'CButtonColumn',
				'header' => Yii::t('Public','操作'),
				'headerHtmlOptions' => array('width' => '8%'),
				'template'=>'{update}',
				'deleteConfirmation'=>Yii::t('Public','是否通过该盖惠券的审核').'?',  //暂停领取提示
				'buttons'=>array(
					'update' => array(		//为了有弹出框才这么写的
						'label' => Yii::t('Public','审核'),
						'options' => array('id' => 'update','onclick' => 'return chooseConfirm(this)'),
						'visible' => 'Yii::app()->user->checkAccess("CouponActivity.Update") && $data->status != CouponActivity::COUPON_STATUS_PASS',
						'imageUrl' => false,
					),
				),
			),
		),
	));
?>
</div>