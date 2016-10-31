<?php
$code = $model->code ? $model->code : $model->goods_name;
$recently = strtotime('-90 days');
?>
<div class="main-contain">
<div class="return-record">
    <span class="cover-icon"><?php echo Yii::t('memberOrder', '我的退换货记录'); ?></span>
</div>

<div class="order-top">
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
</div>

        
<table class="return-list">
  <thead>
    <tr class="col-name">
      <th class="number"><?php echo Yii::t('memberOrder', '退货编号');?></th>
      <th class="type">
      <?php echo $form->dropDownList($model, 'exchange_type', array(0=>Yii::t('memberOrder', '退换货类型'), 1=>Yii::t('memberOrder', '退货'), 2=>Yii::t('memberOrder', '退款不退货')), array('class' => 'btn-cleck', 'onChange'=>'exchangeSelect();')); ?>
      </th>
      <th class="order"><?php echo Yii::t('memberOrder', '订单编号');?></th>
      <th class="name"><?php echo Yii::t('memberOrder', '商品名称');?></th>
      <th class="time">
      <?php echo $form->dropDownList($model, 'exchange_apply_time', array(0=>Yii::t('memberOrder', '申请时间'), 1=>Yii::t('memberOrder', '最近三个月'), 2=>Yii::t('memberOrder', '三个月以前')), array('class' => 'btn-cleck', 'onChange'=>'exchangeSelect();')); ?>
      </th>
      <th class="statu">
      <?php echo $form->dropDownList($model, 'exchange_status', $exchangeStatus, array('class' => 'btn-cleck', 'empty'=>Yii::t('memberOrder', '全部状态'), 'onChange'=>'exchangeSelect();')); ?>
      </th>
      <th class="operation"><?php echo Yii::t('memberOrder', '操作');?></th>
    </tr>
  </thead>
  <?php
  if(!empty($orders)){
	  foreach ($orders as $k => $v){
		  if($v['flag']==Order::FLAG_ONE && $v['create_time']<1401552000) continue; //历史特殊商品，跳过
		  $orderGoods = $v['orderGoods'];
  ?>
  <tbody class="list-item">
    <tr>
      <td class="number" valign="top"><?php echo $v['exchange_code'];?></td>
      <td class="type" valign="top"><?php if($v['exchange_type']==Order::EXCHANGE_TYPE_REFUND){echo Yii::t('memberOrder', '退款不退货');}else if($v['exchange_type']==Order::EXCHANGE_TYPE_RETURN){echo Yii::t('memberOrder', '退货');}?></td>
      <td class="order" valign="top"><?php echo $v['code'];?></td>
      <td class="name">
       <p class="a1"><?php echo $orderGoods[0]['goods_name'];?></p>
       <p class="a2"><?php if (!empty($orderGoods[0]['spec_value'])): ?>
				  <?php foreach (unserialize($orderGoods[0]['spec_value']) as $ksp => $vsp): ?>
                      <?php echo $ksp . ':' . $vsp,' &nbsp;';?>
                  <?php endforeach; ?>
              <?php endif; ?></p>
      <?php if(count($orderGoods) > 1){ echo '<p class="a2">...</p>';}?>        
      </td>
      <td class="time" valign="top"><?php echo date('Y-m-d H:i:s',$v['exchange_apply_time']);?></td>
      <td class="statu" valign="top">
        <?php 
		    if($v['exchange_type'] == Order::EXCHANGE_TYPE_REFUND){//退款不退货
				echo $exchangeStatus[$v['exchange_status']];
		    }else if($v['exchange_type'] == Order::EXCHANGE_TYPE_RETURN){//退货
				echo $exchangeStatus[$v['exchange_status']];	
		    }
		?>
        <?php if($v['exchange_status'] == Order::EXCHANGE_STATUS_RETURN){?>
        <p class="statu-time"><?php echo Yii::t('memberOrder', '请在');?><i><?php echo $v['return_time'];?></i><?php echo Yii::t('memberOrder', '内退货');?></p>
		<?php }?>
      </td>
      <td class="operation" valign="top">
	  <?php
          if($v['exchange_type'] == Order::EXCHANGE_TYPE_RETURN){//退货
			  echo CHtml::link(Yii::t('memberOrder', '服务详情'), array('/member/exchangeGoods/returnExamine', 'id' => $v['exchange_id']), array('class'=>'pay-btn', 'target'=>'_blank'));
		  }else if($v['exchange_type'] == Order::EXCHANGE_TYPE_REFUND){//退款不退货
			  echo CHtml::link(Yii::t('memberOrder', '服务详情'), array('/member/exchangeGoods/waitReturnNullGoods', 'id' => $v['exchange_id']), array('class'=>'pay-btn', 'target'=>'_blank'));
		  }
	  ?>
      </td>
    </tr>
  </tbody>
  <?php }}else{ ?>
      
  <tbody class="list-item">
  <tr>
      <td colspan="7">
          <div style="height:50px; line-height:50px;font-size:12px;"><?php echo Yii::t('memberOrder', '没有符合条件的商品，请尝试其他搜索条件'); ?></div>
      </td>
  </tr>
  </tbody>
  <?php }?>
</table>

<div class="pageList clearfix">
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
</div>

<script language="javascript">
/*搜索*/
$("#order_search").click(function() {
    $("form.order-seach").submit();
});

function exchangeSelect(){
	var exchangeUrl       = '<?php echo $this->createAbsoluteUrl('/member/exchangeGoods/admin');?>';
	var exchangeType      = $('#Order_exchange_type').val();
	var exchangeApplyTime = $('#Order_exchange_apply_time').val();
	var exchangeStatus    = $('#Order_exchange_status').val();
	
	window.location.href = exchangeUrl+'?Order[exchange_type]='+exchangeType+'&Order[exchange_apply_time]='+exchangeApplyTime+'&Order[exchange_status]='+exchangeStatus;
}
</script>