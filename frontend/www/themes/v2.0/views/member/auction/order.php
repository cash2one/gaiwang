<style>
.layui-layer-border{ width:260px; height:160px;}
.layui-layer-btn a:hover{ color:#fff;}
</style>
<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */
$code = $model->code ? $model->code : $model->goods_name;

$maxPage  = ceil($pages->itemCount/$pages->pageSize);
$page     = isset($_GET['page']) ? intval($_GET['page']) : 1;
$prevPage = ($page-1) < 1 ? 1 : $page-1;
$nextPage = ($page+1) > $maxPage ? $maxPage : $page+1;
?>

<?php $this->renderPartial('_msg'); ?>
<div class="main-contain">
 <ul class="order-nav clearfix">
      <li>
          <a href="<?php
                        echo $this->createAbsoluteUrl('auction/admin')
                        ?>" class="<?php if($this->getAction()->getId() == 'admin'){ echo 'active';}?>">
              <span><?php echo Yii::t('memberOrder', '我的竞拍记录'); ?></span>
              <i class="interval"></i>
          </a>
      </li>
      <li>
          <a href="<?php
                        echo $this->createAbsoluteUrl('auction/order')
                        ?>" class="<?php if($this->getAction()->getId() == 'order'){ echo 'active';}?>">
              <span><?php echo Yii::t('memberOder', '我的竞拍订单'); ?></span>
              <i class="interval"></i>
          </a>
      </li>  
  </ul>
  <div class="order-top  clearfix">
    <?php
	$form = $this->beginWidget('ActiveForm', array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
		'htmlOptions' => array('class' => 'order-seach clearfix'),
			));
	?>
    <?php echo $form->textField($model, 'code', array('class' => 'order-input', 'placeholder'=>Yii::t('memberOrder', '输入商品名称或者订单号进行搜索'), 'value'=>$code)) ?>
    <input type="button" class="seach-btn" id="order_search" value="<?php echo Yii::t('memberOrder', '订单搜索'); ?>"/>
    <?php $this->endWidget(); ?>
      <!--<div class="page-btn">
      <?php if($maxPage > 1){?>
          <button class="prev" onclick="pagePrev();"><i class="member-icon prev-icon"></i>上一页</button>
          <button class="next" onclick="pageNext();">下一页<i class="member-icon next-icon"></i></button>
      <?php }?>
      </div>-->
      <div class="page-btn">
		  <?php
          $this->widget('SLinkPager', array(
              'pages' => $pages,
              'onlyPN' => true,
              'prevPageLabel' =>  Yii::t('page', '上一页'),
              'nextPageLabel' =>  Yii::t('page', '下一页'),
              'htmlOptions' => array('class' => 'yiiPageer', 'style'=>'margin-top:0;'),
          ))
          ?>
      </div>
  </div>
  <table class="myorder-list">
      <thead>
      <tr class="col-name">
          <th class="product"><?php echo Yii::t('memberOrder', '商品'); ?></th>
          <th class="price"><?php echo Yii::t('memberOrder', '起拍价'); ?></th>
          <th class="quantity"><?php echo Yii::t('memberOrder', '数量'); ?></th>
          <th class="payment"><?php echo Yii::t('memberOrder', '实付款'); ?></th>
          <th class="status"><?php echo Yii::t('memberOrder', '交易状态'); ?></th>
          <th class="operation"><?php echo Yii::t('memberOrder', '交易操作'); ?></th>
      </tr>
      </thead>
      
      <?php
	  if(!empty($orders)){
		  foreach ($orders as $k => $v){
			  if($v['flag']==Order::FLAG_ONE && $v['create_time']<1401552000) continue; //历史特殊商品，跳过
			  $orderGoods = $v->orderGoods;
			  $logistics  = array('express'=>$v['express'], 'shipping_code'=>$v['shipping_code'], 'k'=>$k);
			  ?>
      <tbody class="list-item">
      <tr class="sep-row">
          <td colspan="6"></td>
      </tr>
      <tr class="order-hd">
          <td colspan="6">
              <b class="dealtime"><?php echo date('Y-m-d', $v['create_time']);?></b>
              <span class="order-num"><?php echo Yii::t('memberOrder', '订单号'); ?>： <?php echo $v->code; ?></span>
              <?php $store = Order::getStoreInfo($v->orderGoods[0]['goods_id']);?>
              <a href="<?php echo $this->createAbsoluteUrl('/shop/' . $store['id']);?>" class="shop link" title="<?php echo $store['name'];?>" target="_blank"><?php echo Tool::dCutUtf8String($store['name'], 10);?></a>&nbsp;&nbsp;
			  <?php echo Yii::t('memberOrder', '返还积分'); ?>：<?php echo Common::convertSingle(Order::amountReturnByMember($v->attributes,$this->model->attributes,$orderGoods)); ?><?php echo Yii::t('memberOrder', '盖网积分'); ?>

		   </td>

      </tr>
      <?php $this->renderPartial('_ordergoods', array('order' => $v,'orderGoods'=>$orderGoods, 'logistics'=>$logistics)) ?>
      </tbody>
      <?php }}else{ ?>
      
      <tbody class="no-product">
      <tr class="sep-row">
          <td colspan="6"></td>
      </tr>
      <tr>
          <td colspan="6">
              <div class="no-product-tip"><?php echo Yii::t('memberOrder', '没有找到订单'); ?></div>
          </td>
      </tr>
      </tbody>
      <?php }?>
  </table>
  <div class="pageList mt50 clearfix">
  <?php
	  $this->widget('SLinkPager', array(
		  'header' => '',
		  'cssFile' => false,
		  'firstPageLabel' => Yii::t('page', '首页'),
		  'lastPageLabel' => Yii::t('page', '末页'),
		  'prevPageLabel' => Yii::t('page', '上一页'),
		  'nextPageLabel' => Yii::t('page', '下一页'),
		  'maxButtonCount' => 5,
		  'pages' => $pages,
		  'htmlOptions' => array(
			  'class' => 'yiiPageer'
		  )
	  ));
  ?>  
  </div>
  
  <!--提醒卖家发货弹窗start-->
  <div class="remind-box">
      <div class="remind-title"><span><?php echo Yii::t('memberOrder', '提醒卖家发货'); ?></span></div>
      <div class="remind-content"><?php echo Yii::t('memberOrder', '已通知卖家发货，请耐心等待'); ?></div>
      <div class="remind-footer">
          <button class="confirm-btn"><?php echo Yii::t('memberOrder', '确认'); ?></button>
      </div>
  </div>
  <!--提醒卖家发货弹窗end-->
</div>

<script language="javascript">
var osLeft = ($(window).width()-260)/2 + 'px'; 
var osTop  = ($(window).height()-160)/2 + 'px';

/*搜索*/
$("#order_search").click(function() {
    $("form.order-seach").submit();
});

/*上一页*/
function pagePrev(){
   	window.location.href = '<?php echo $this->createAbsoluteUrl('auction/admin', array('Order[code]'=>$code, 'page'=>$prevPage));?>';
}

/*下一页*/
function pageNext(){
	window.location.href = '<?php echo $this->createAbsoluteUrl('auction/admin', array('Order[code]'=>$code, 'page'=>$nextPage));?>';
}

/*查看物流*/
$(".logistics-area").hover(
    function () {
		var n = $(this).attr('data-value');
	    $('#link_'+n).css("color", "#d72226");
		showExpress(n);
	    $("#logistics_"+n).show();
    },function(){
		var n = $(this).attr('data-value');
		$('#link_'+n).css("color", "#333333");
	    $("#logistics_"+n).hide();
    }
);

function showExpress(k){
	var durl  = $('#url_'+k).val();
	var eurl  = $('#exp_'+k).val();
	if(durl != ''){
	    $.getJSON(durl, function(data) {
			if (data.status != 200) {
				/*layer.alert(data.message);*/
				$('#express_'+k).html('<li class="logistics-item">'+data.message+'</li>');
			} else {
				$('#express_'+k).html('');
				var html = '';
				$.each(data.data, function(i, item) {
					if(i<3){
					    html += '<li class="logistics-item">'+item.context+'<br/>'+item.time+'</li>';
					}
				});
				
				html += '<li class="logistics-item"><?php echo Yii::t('memberOrder', '以上为最新跟踪消息');?><a href="'+eurl+'" class="link all-logistics" target="_blank"><?php echo Yii::t('memberOrder', '查看更多');?></a></li>';
				$('#express_'+k).append(html);
			}
		});
	}	
}

//ajax 取消订单
$(".cancelOrder").click(function() {
	var order_code = $(this).attr("data_code");
    
	layer.confirm('<?php echo Yii::t('memberOrder', '你确定要取消该订单么?'); ?>', {
		btn: ['<?php echo Yii::t('memberOrder', '确定'); ?>','<?php echo Yii::t('memberOrder', '取消'); ?>'], //按钮
		shade: false,
		offset:[osTop,osLeft]
	}, function(){
		$.ajax({
			type: "POST",
			url: "<?php echo $this->createAbsoluteUrl('order/cancel') ?>",
			data: {
				"YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
				"code": order_code
			},
			success: function(msg) {
				layer.alert(msg);
				location.reload();
			}
		});
		
	}, function(){
		layer.closeAll();
	});
});

//ajax 签收订单
$(".signOrder").click(function() {
	var order_code = $(this).attr("data_code");
	
	layer.confirm('<?php echo Yii::t('memberOrder', '你确定要签收该订单么？'); ?>', {
		btn: ['<?php echo Yii::t('memberOrder', '确定'); ?>','<?php echo Yii::t('memberOrder', '取消'); ?>'], //按钮
		shade: false,
	    offset:[osTop,osLeft]
	}, function(){
		$.ajax({
			type: "POST",
			url: "<?php echo $this->createAbsoluteUrl('order/sign') ?>",
			data: {
				"YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
				"code": order_code
			},
			success: function(msg) {
				layer.alert(msg);
				location.reload();
			},
			error: function(){
				layer.alert('<?php echo Yii::t('memberOrder', '退换货申请中或退换货成功状态,不能确认收货!'); ?>');
			}
		});
	}, function(){
		layer.closeAll();
	});
});

//取消退货
$(".cancelReturn").click(function(){
	var order_code = $(this).attr("data_code");
	
	layer.confirm('<?php echo Yii::t('memberOrder', '你确定要取消退货么？'); ?>', {
		btn: ['<?php echo Yii::t('memberOrder', '确定'); ?>','<?php echo Yii::t('memberOrder', '取消'); ?>'], //按钮
		shade: false,
	    offset:[osTop,osLeft]
	}, function(){
		$.ajax({
			type: "POST",
			url: "<?php echo $this->createAbsoluteUrl('order/cancelReturn') ?>",
			data: {
				"YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
				"code": order_code
			},
			success: function(msg) {
				layer.alert(msg);
				location.reload();
			}
		});
	}, function(){
		layer.closeAll();
	});
});

function setRemainTime(){
	$('p.remain-time').each(function(index, element) {
        ts = $(this).attr('data-time');
		if(ts > 0){
			d = Math.floor(ts/86400);
			h = Math.floor(ts/3600%24);
			m = Math.floor(ts/60%60);
			s = ts%60;
			
			html = '剩'+d+'天'+h+'小时'+m+'分钟'+s+'秒';
			$(this).html(html);
		    $(this).attr('data-time', ts-1);
		}else{
		    $(this).html('');	
		}
    });
}

$(document).ready(function(e) {
	$(".logistics-details").hover(function () {
		$(this).parent().find(".logistics").css("color", "#d72226");
	}, function () {
		$(this).parent().find(".logistics").css("color", "#333");
		$(this).hide();
	});
	
	setInterval('setRemainTime();', 1000);
});
</script>