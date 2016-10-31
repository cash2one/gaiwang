<style>
.layui-layer-border{ width:260px; height:160px;}
.layui-layer-btn a:hover{ color:#fff;}
</style>
<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */
$pages=$data->pagination;
//Tool::p($pages);
$code = $model->code ? $model->code : $model->hotel_name;
?>
<div class="main-contain">
  <ul class="order-nav clearfix">
          <li>
                <a href="<?php
                        echo $this->createAbsoluteUrl('hotelOrder/index', array(
                            'on' => 'all'))
                        ?>" class="<?php if($this->getParam('on') == 'all' || $this->getParam('on') == ''){ echo 'active';}?>">
              <span><?php echo Yii::t('memberOrder', '全部订单'); ?></span>
              <i class="interval"></i>
              </a>
            </li>
            <li>
                 <a href="<?php
                        echo $this->createAbsoluteUrl('HotelOrder/index', array(
                            'HotelOrder[status]' =>HotelOrder::STATUS_NEW,
                            'on' => 'new'))
                        ?>" class="<?php if($this->getParam('on') == 'new'){ echo 'active';}?>">
              <span><?php echo Yii::t('memberOrder', '新订单'); ?></span>
              <em class="tm-h"><?php echo $newNum;?></em>
              <i class="interval"></i>
                     </a>
            </li>
            <li>
             <a href="<?php
                        echo $this->createAbsoluteUrl('HotelOrder/index', array(
                            'HotelOrder[status]'=>HotelOrder::STATUS_VERIFY,
                            'on' => 'verify'))
                        ?>" class="<?php if($this->getParam('on') == 'verify'){ echo 'active';}?>">
              <span><?php echo Yii::t('memberOrder', '订单确认'); ?></span>
              <em class="tm-h"><?php echo $verifyNum;?></em>
              <i class="interval"></i>
               </a>   
            </li>
            <li>
                <a href="<?php
                        echo $this->createAbsoluteUrl('HotelOrder/index', array(
                           'HotelOrder[status]' => HotelOrder::STATUS_SUCCEED,
                            'on' => 'complete'))
                        ?>" class="<?php if($this->getParam('on') == 'complete'){ echo 'active';}?>">
              <span><?php echo Yii::t('memberOrder', '订单完成'); ?></span>
              <em class="tm-h"><?php echo $successNum;?></em>
              <i class="interval"></i>
               </a>   
            </li>
            <li>
                <a href="<?php
                        echo $this->createAbsoluteUrl('HotelOrder/index', array(
                           'HotelOrder[status]' => HotelOrder::STATUS_CLOSE,
                            'on' => 'close'))
                        ?>" class="<?php if($this->getParam('on') == 'close'){ echo 'active';}?>">
              <span><?php echo Yii::t('memberOrder', '订单关闭'); ?></span>
              <em class="tm-h"><?php echo $closeNum;?></em>
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
    <?php echo $form->textField($model, 'code', array('class' => 'order-input', 'placeholder'=>Yii::t('memberOrder', '输入酒店名称或者订单号进行搜索'), 'value'=>$code)) ?>
    <input type="button" class="seach-btn" id="order_search" value="<?php echo Yii::t('memberOrder', '订单搜索'); ?>"/>
    <?php $this->endWidget(); ?>
    <?php $dataModel=$data->getData();?>
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
                <th class="product"><?php echo Yii::t('memberHotelOrder', '酒店及客房名称') ?></th>
                <th class="price"><?php echo Yii::t('memberHotelOrder', '总金额') ?></th>
                <th class="quantity"><?php echo Yii::t('memberHotelOrder', '入住时间') ?></th>
                <th class="payment"><?php echo Yii::t('memberHotelOrder', '支付状态') ?></th>
                <th class="status"><?php echo Yii::t('memberHotelOrder', '订单状态') ?></th>
                <th class="operation"><?php echo Yii::t('memberHotelOrder', '交易操作') ?></th>
      </tr>
      </thead>
     <?php if (!empty($dataModel)): ?>
         <?php foreach ($dataModel as $val): ?>
      <tbody class="list-item">
				<tr class="sep-row">
					<td colspan="6"></td>
				</tr>
				<tr class="order-hd">
					<td colspan="6">
						<b class="dealtime"><?php echo date('Y-m-d H:i:s', $val->create_time) ?></b>
						<span class="order-num"><?php echo Yii::t('memberHotelOrder', '订单编号') ?>：<?php echo $val->code ?></span>
					</td>
				</tr>
				<tr class="order-bd">
					<td class="product Hproduct">
						<a href="<?php echo $this->createAbsoluteUrl('/hotel/site/view', array('id' => $val->hotel_id)); ?>" title="<?php echo $val->hotel_name ?> - <?php echo $val->room_name ?>"><?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $val->hotel->thumbnail, 'c_fill,h_88,w_88')) ?></a>
						<div class="product-txt">
							<a href="<?php echo $this->createAbsoluteUrl('/hotel/site/view', array('id' => $val->hotel_id)); ?>" class="product-name link"><?php echo $val->hotel_name ?> - <?php echo $val->room_name ?> </a>
						</div>
					</td>
					<td class="price"><?php echo HtmlHelper::formatPrice($val->total_price) ?></td>
					<td class="quantity"><?php echo date('Y-m-d', $val->settled_time) ?> - <?php echo date('Y-m-d', $val->leave_time) ?></td>
					<td class="status"><?php echo HotelOrder::getPayStatus($val->pay_status) ?></td>
					<td class="status"><?php echo HotelOrder::getOrderStatus($val->status) ?></td>
					<td class="status">
					 <p>
					 <?php if ($val->status == HotelOrder::STATUS_NEW): ?>
                            <?php if ($val->pay_status == HotelOrder::PAY_STATUS_NO): ?>
                                <?php echo CHtml::link(Yii::t('memberHotelOrder', '支付'), $this->createAbsoluteUrl('/hotel/order/pay', array('code' => $val->code))) ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($val->status == HotelOrder::STATUS_SUCCEED): ?>
                            <?php if ($val->score == HotelOrder::IS_COMMENT_NO): ?>
                                <?php echo CHtml::link(Yii::t('memberHotelOrder', '评价'), $this->createAbsoluteUrl('/member/hotelOrder/view', array('id' => $val->id))) ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php echo CHtml::link(Yii::t('memberHotelOrder', '订单详情'), $this->createAbsoluteUrl('/member/hotelOrder/view', array('id' => $val->id))) ?>
						</p>
					</td>
				</tr>
            </tbody>
      <?php endforeach;else: ?>
      <tbody class="no-product">
      <tr class="sep-row">
          <td colspan="6"></td>
      </tr>
      <tr>
          <td colspan="6">
              <div class="no-product-tip"><?php echo Yii::t('memberOrder', '没有找到酒店订单'); ?></div>
          </td>
      </tr>
      </tbody>
      <?php endif;?>
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
</div>
<script type="text/javascript">
  
/*搜索*/
$("#order_search").click(function() {
    $("form.order-seach").submit();
});
</script>