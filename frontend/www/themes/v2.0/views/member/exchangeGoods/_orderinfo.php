
<div class="order-details">
    <div class="order-header">
        <span class="title"><?php echo Yii::t('member', '订单信息')?></span>
        <span class="order-num"><?php echo Yii::t('member', '订单编号')?>：<?php echo $orderInfo['memberInfo']['code']; ?></span>
        <?php echo CHtml::link(Yii::t('site','查看详情'),'#',array('id'=>'order-more','class'=>'more')); ?>
        <div class="order-more-box">
            <p><?php echo Yii::t('member', '成交时间')?>： <?php echo date('Y-m-d H:i:s',$orderInfo['memberInfo']['create_time']) ?></p>
            <?php if($orderInfo['memberInfo']['pay_time']>0){?>
            <p><?php echo Yii::t('member', '付款时间')?>： <?php echo date('Y-m-d H:i:s',$orderInfo['memberInfo']['pay_time']); ?></p>
            <?php }?>
			<?php if($orderInfo['memberInfo']['delivery_time']>0){?>
            <p><?php echo Yii::t('member', '发货时间')?>： <?php echo date('Y-m-d H:i:s',$orderInfo['memberInfo']['delivery_time']); ?></p>
            <?php }?>
            <?php if($orderInfo['memberInfo']['sign_time']>0){?>
            <p><?php echo Yii::t('member', '完结时间')?>： <?php echo date('Y-m-d H:i:s',$orderInfo['memberInfo']['sign_time']); ?></p>
            <?php }?>
        </div>
    </div>
    <div class="order-des">
        <p><?php echo Yii::t('member', '收货人名')?>： <?php echo $orderInfo['memberInfo']['consignee'] ?>，<?php echo $orderInfo['memberInfo']['mobile'] ?></p>
        <p><?php echo Yii::t('member', '收货地址')?>： <?php echo $orderInfo['memberInfo']['address'] ?></p>
        <p><?php echo Yii::t('member', '买家留言')?>： <?php echo $orderInfo['memberInfo']['remark'] ?></p>
        <p><?php echo Yii::t('member', '商家名称')?>： <?php echo $orderInfo['memberInfo']['store_name'] ?></p>
        <p><?php echo Yii::t('member', '商家城市')?>： <?php echo $orderInfo['memberInfo']['store_city_name'] ?></p>
        <p><?php echo Yii::t('member', '联系电话')?>： <?php echo $orderInfo['memberInfo']['store_mobile'] ?></p>
    </div>
    <table class="order-tab">
        <thead>
        <tr class="col-name">
            <th class="product"><?php echo Yii::t('member', '商品')?></th>
            <th class="price"><?php echo Yii::t('member', '单价')?></th>
            <th class="quantity"><?php echo Yii::t('member', '数量')?></th>
            <th class="privilege"><?php echo Yii::t('member', '优惠')?></th>
            <th class="freight"><?php echo Yii::t('member', '运费（元）')?></th>
            <th class="operation"><?php echo Yii::t('member', '实付款（元）')?></th>
        </tr>
        </thead>
        <tbody>
        <tr class="sep-row">
            <td colspan="6"></td>
        </tr>
        <tr class="order-hd">
            <td colspan="6">
                <b class="dealtime"><?php echo date('Y-m-d',$orderInfo['memberInfo']['create_time']) ?></b>
                <span class="order-num"><?php echo Yii::t('member', '订单号')?>：<?php echo $orderInfo['memberInfo']['code']; ?></span>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('shop/'.$orderInfo['memberInfo']['store_id']) ?>" class="shop link"><?php echo $orderInfo['memberInfo']['store_name'] ?></a>
            </td>
        </tr>

        <?php 
		if(!empty($orderInfo['orderList'])){
			$count = count($orderInfo['orderList']);
		    foreach($orderInfo['orderList'] as $key => $value){ 
		        $discount  = $value['source_type'] == Order::SOURCE_TYPE_AUCTION ? '' : '无';
				$actName   = '';
				if($value['rules_setting_id'] > 0){//有参加活动
					$setting = ActivityData::getActiveBySettingId($value['rules_setting_id']);
				    if(!empty($setting)){
						$actName   = $setting['name'];
                        if($value['source_type'] != Order::SOURCE_TYPE_AUCTION) {//拍卖活动不显示优惠信息
                            if ($setting['category_id'] == ActivityData::ACTIVE_RED) {//红包活动
                                $discount = Yii::t('memberOrder', '红包消费比例: ') . ($setting['discount_rate']) . '%';
                            } else {//应节活动 秒杀活动
                                if ($setting['discount_rate'] > 0) {//商品打折
                                    $discount = Yii::t('memberOrder', '商品打折: ') . ($setting['discount_rate'] / 10) . Yii::t('memberOrder', '折');
                                } else {//限定价格
                                    $discount = Yii::t('memberOrder', '限定价格 : ') . (HtmlHelper::formatPrice($setting['discount_price'])) . Yii::t('memberOrder', '元');
                                }
                            }
                        }
					}
				}	
		?>
		  <?php if($key < 1){?>    
          <tr class="order-bd">
              <td class="product">
                  <a href="<?php echo Yii::app()->createAbsoluteUrl('/goods/view',array('id'=>$value['goods_id'])) ?>" title="<?php echo $value['goods_name'] ?>">

                      <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $value['goods_picture'], 'c_fill,h_90,w_90'),'',array('class'=>'product-img')); ?>
                  </a>
                  <div class="product-txt">
                      <a href="<?php echo Yii::app()->createAbsoluteUrl('/goods/view',array('id'=>$value['goods_id'])) ?>" class="product-name link"><?php echo $value['goods_name'] ?></a>
                      <p class="color-classify">
                          <?php
                              $str = '';
                              if(!empty($value['spec_value'])){
  
                                  foreach(unserialize($value['spec_value']) as $k => $v){
                                      $str .= $k.':'.$v.'　';
                                  }
                                  echo $str;
                              };
                          ?>
                      </p>
                  </div>
              </td>
              <td class="price"><?php echo HtmlHelper::formatPrice($value['unit_price']); ?></td>
              <td class="quantity"><?php echo $value['quantity'] ?></td>
              <td class="privilege">
                  <?php echo $actName.($actName ? '<br/>' : '').$discount;?>
              </td>
              <td class="freight" rowspan="<?php echo $count;?>" >
                  <?php 
				  echo $orderInfo['memberInfo']['freight'];
				  /*if ($orderInfo['memberInfo']['freight_payment_type'] != Goods::FREIGHT_TYPE_MODE){
						echo Goods::freightPayType($orderInfo['memberInfo']['freight_payment_type'] > 1 ? $orderInfo['memberInfo']['freight_payment_type'] : 1);
				  }else{
                       echo HtmlHelper::formatPrice($orderInfo['memberInfo']['freight']).' <p>'.FreightType::mode($orderInfo['memberInfo']['mode']).'</p>';
				  }*/?>
              </td>
              <td class="operation orange" rowspan="<?php echo $count;?>">
                  <p><?php echo HtmlHelper::formatPrice(number_format(($orderInfo['memberInfo']['pay_price']), 2, '.', '')); ?></p>
              </td>
          </tr>
          <?php }else{?>
          <tr class="order-bd">
              <td class="product">
                  <a href="<?php echo Yii::app()->createAbsoluteUrl('/goods/view',array('id'=>$value['goods_id'])) ?>" title="<?php echo $value['goods_name'] ?>"><img
                          src="<?php echo ATTR_DOMAIN.'/'.$value['goods_picture']; ?>" class="product-img" alt="<?php echo $value['goods_name'] ?>"/></a>
                  <div class="product-txt">
                      <a href="<?php echo Yii::app()->createAbsoluteUrl('/goods/view',array('id'=>$value['goods_id'])) ?>" class="product-name link"><?php echo $value['goods_name'] ?></a>
                      <p class="color-classify">
                          <?php
                              $str = '';
                              if(!empty($value['spec_value'])){
  
                                  foreach(unserialize($value['spec_value']) as $k => $v){
                                      $str .= $k.':'.$v.'　';
                                  }
                                  echo $str;
                              };
                          ?>
                      </p>
                  </div>
              </td>
              <td class="price"><?php echo HtmlHelper::formatPrice($value['unit_price']); ?></td>
              <td class="quantity"><?php echo $value['quantity'] ?></td>
              <td class="privilege">
                  <?php echo $actName.'<br/>'.$discount;?>
              </td>
          </tr>
          <?php }?>
        <?php }} ?>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        </tbody>
    </table>
</div>
