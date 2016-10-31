  <div class="main">
    	<div class="search">
			<div class="searchBox">
			<?php $form=$this->beginWidget('CActiveForm', array(
                  'action'=>Yii::app()->createUrl($this->route,array('search'=>1)),
                  'method'=>'get',
                )); ?>
				<?php echo $form->textField($model,'goods_name',array('placeholder'=>'搜索','class'=>'searchInput')); ?>
				<?php echo CHtml::submitButton('搜索',array('class'=>'searchSubmit')) ?>
			<?php $this->endWidget(); ?>
			</div>
		</div>
    	<ul class="OSList">
    		
    		<?php foreach($orders as $k => $v):
    	     $orderGoods = $v->orderGoods;          
    	?>
    		<li>
    			<div class="OSlistTitle">
    				<div class="OSlistTitleLeft fl"><?php echo $v->store->name;?></div>
    				<div class="OSlistTitleRight fr">
    				      <?php if($v->status==$model::STATUS_CLOSE):
    				           echo $model::status($v->status);?>
    				   <?php else:?>
    				     <?php if($v->pay_status==$model::PAY_STATUS_NO){
    				           echo Yii::t("memberOrder","等待付款");
    				       }else if($v->pay_status==$model::PAY_STATUS_YES && $v->delivery_status==$model::DELIVERY_STATUS_NOT){
    				         echo Yii::t("memberOrder","备货中...");
    				       }else if($v->pay_status==$model::PAY_STATUS_YES && ($v->delivery_status==$model::DELIVERY_STATUS_NOT || $v->delivery_status==$model::DELIVERY_STATUS_WAIT || $v->delivery_status==$model::DELIVERY_STATUS_SEND)){
    				         echo $model::deliveryStatus($v->delivery_status);  
    				       } 
    				       else if($v->delivery_status==$model::DELIVERY_STATUS_RECEIVE && $v->is_comment==$model::IS_COMMENT_NO){
    				         echo Yii::t("memberOrder","等待评价");
    				       }
    				       else if($v->is_comment==$model::IS_COMMENT_YES){
    				          echo Yii::t("memberOrder","订单完成");
    				       }   
    				      ?>
    				  <?php endif;?>
    				</div>
    				<div class="clear"></div>
    			</div>
    			<?php foreach ($orderGoods as $order):?>
    			<a href="<?php echo $this->createAbsoluteUrl('goods/index',array('id'=>$order->goods_id));?>" title="" class="OSProducts">
		    			<?php  echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $order->goods_picture,'c_fill,h_100,w_100'),'',array("class"=>"fl","width"=>"100"))?>
    				<span class="OSProductsRight fl">
    					<span class="OSProductsInfo">
    					<?php echo $order->goods_name;?>
    					</span>
   						<?php if (!empty($order->spec_value)): ?>
                    <?php foreach (unserialize($order->spec_value) as $ksp => $vsp): ?>
                        <?php echo $ksp . ':' . $vsp ?>
                    <?php endforeach; ?>
                <?php endif; ?><br/>
   						  <?php echo HtmlHelper::formatPrice($order['unit_price'])."*".$order['quantity'];?>	   
    				</span>
    			</a>
    			<?php endforeach; ?>
    			<div class="OSlistTitle">
    				<div class="OSlistTitleLeft2 fl">实付（共 <?php echo count($orderGoods);?> 件商品）</div>
    				<div class="OSlistTitleRight fr d32f2f"><?php echo HtmlHelper::formatPrice($v->pay_price) ?></div>
    				<div class="clear"></div>
    			</div>
    			<div class="OSListBtn">
    		    <?php if($v->status!=$model::STATUS_CLOSE):?>
        			<?php if($v->pay_status==$model::PAY_STATUS_NO):?>
        			<?php echo CHtml::link(Yii::t('memberOrder', '去支付'), $this->createAbsoluteUrl('orderConfirm/pay', array('code' => $v->code)),array('class'=>'OSListCheckBtn fr'));?>
        			<?php elseif($v->delivery_status==$model::DELIVERY_STATUS_SEND && $v->status==$model::STATUS_NEW):?>
        			<a href="javascript:void();" data_code="<?php echo $v->code;?>" id="signOrder" class="OSListOnfirmBtn fr">确认收货</a>
        			<?php echo CHtml::link(Yii::t('memberOrder', '查看物流'), $this->createAbsoluteUrl('order/logistics', array('code' => $v->code)),array('class'=>'OSListCheckBtn fr'));?>
        			<?php elseif($v->delivery_status==$model::DELIVERY_STATUS_RECEIVE && $v->is_comment==$model::IS_COMMENT_NO):?>
        			<?php echo CHtml::link(Yii::t('memberOrder', '去评价'), $this->createAbsoluteUrl('order/comment', array('code' => $v->code)),array('class'=>'OSListCheckBtn fr'));?>
        			<?php endif;?>
    	       <?php endif;?>		
    		   <?php echo CHtml::link(Yii::t('memberOrder', '订单详情'), $this->createAbsoluteUrl('order/detail', array('code' => $v->code)),array('class'=>'OSListOnfirmBtn fr'));?>	
    				<div class="clear"></div>
    			</div>
    		</li>
    	<?php endforeach; ?>
    	</ul>
    	<?php
                            $this->widget('WLinkPager', array(
                                'pages' => $pages,
                                'jump' => true,
                                'prevPageLabel' =>  Yii::t('page', '上一页'),
                                'nextPageLabel' =>  Yii::t('page', '下一页'),
                            ))
             ?>      
    </div>
   </div>
    <?php $this->renderPartial('_orderSign'); ?>
  </body>
  	<script src="<?php echo DOMAIN; ?>/js/m/jquery.touchslider.min.js"></script>
  	<script src="<?php echo DOMAIN; ?>/js/m/template.js"></script>
	<script src="<?php echo DOMAIN; ?>/js/m/com.js"></script>
</html>
