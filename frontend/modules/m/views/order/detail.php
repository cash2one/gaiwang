	  </div>
   </div>  
	  
	    <div class="main">
	    	<div class="ODItem ODItem1">
	    		<ul>
	    			<li>
	    				<span class="ODInfo ODInfo1">
	    				<?php if($model->status==$model::STATUS_CLOSE):
    				           echo $model::status($model->status);?>
    				    <?php else:?>
                            <?php if($model->pay_status == $model::PAY_STATUS_NO):
                                   echo Yii::t("memberOrder","待付款");?>
                             <?php else:?>     
	    				        <?php if($model->delivery_status==$model::DELIVERY_STATUS_NOT):
	    				            echo Yii::t("memberOrder","备货中...");?>
	    				        <?php else:?>
	    				           <?php echo $model::deliveryStatus($model->delivery_status); ?>
	    			 	         <?php endif;?>
	    			 	    <?php endif;?>     
	    			   <?php endif;?>        
	    				</span>
	    				<span class="ODfont gray">应付款：<?php echo HtmlHelper::formatPrice($model->real_price) ?></span>
	    			</li>
	    			<li>
	    				<span class="ODInfo ODInfo2">收货人：<?php echo CHtml::encode($model->consignee).'&nbsp;&nbsp;'.$model->mobile ?></span>
	    				<span class="ODfont gray"><?php echo $model->address ?></span>
	    			</li>
	    			<li>
	    			   <?php if($model->delivery_status==$model::DELIVERY_STATUS_WAIT || $model->delivery_status==$model::DELIVERY_STATUS_NOT):?>
	    			        <span class="ODInfo ODInfo3">暂无物流信息</span>
	    			   <?php else:?>
	    				  <a href="<?php echo $this->createAbsoluteUrl('order/logistics',array('code'=>$model->code));?>">
		    				<span class="ODInfo ODInfo3">物流信息</span>
		    				<span class="ODfont gray"><?php echo $model->express;?>快递</span>
		    			  </a>
		    		  <?php endif;?>
	    			</li>
	    		</ul>
	    	</div>
	    	<div class="ODItem ODItem2">
	    		<ul>
	    			<li>
	    				<div class="OSlistTitle">
		    				<div class="OSlistTitleLeft fl"><?php echo Tool:: truncateUtf8String($model->store->name,15); ?></div>
		    				<div class="clear"></div>
		    			</div>
	    			</li>
	    			<!-- 产品列表 -->
	    			 <?php if (!empty($model->orderGoods)): ?>
	    			   <?php foreach ($model->orderGoods as $v): ?>
	    			<li>
		    			<a href="<?php echo $this->createAbsoluteUrl('goods/index',array('id'=>$v->goods_id));?>" title="" class="OSProducts">
		    			<?php  echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v->goods_picture,'c_fill,h_80,w_80'),'',array("class"=>"fl","width"=>"80"))?>
		    				<span class="OSProductsRight ODProductsRight fl">
		    					<span class="OSProductsInfo"><?php echo Tool:: truncateUtf8String($v->goods_name,15); ?></span>
		   						<span class="ODItem2Info">
			   						<?php if(!empty($v->spec_value)): ?>
                                            <?php foreach(unserialize($v->spec_value) as $ksp=>$vsp): ?>
                                                <?php echo $ksp.':'.$vsp ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?><br/>
			   						<?php echo HtmlHelper::formatPrice($v->unit_price)."*". $v->quantity;?><span class="ODItem2Price d32f2f"><?php echo (HtmlHelper::formatPrice($v->unit_price*$v->quantity));?></span>
			   					</span>
		    				</span>
		    				<span class="clear"></span>
		    			</a>
	    			</li>
	    			 <?php endforeach; ?>
                    <?php endif; ?>
	    			<!-- 产品列表 -->
	    			<li>
    					<span class="menberLeft fl">红包</span>
    					<span class="menberRight fr">-<?php echo (HtmlHelper::formatPrice($model->other_price)); ?></span>
    					<span class="clear"></span>
	    			</li>
	    			<li>
    					<span class="menberLeft fl">运费</span>
    					<span class="menberRight fr">
    					<?php if(!$model->freight):?>
    					     包邮
    					<?php else:?>
    					<?php echo HtmlHelper::formatPrice($model->freight) ?>
    					<?php endif;?>
    					</span>
    					<span class="clear"></span>
	    			</li>
	    			<li>
    					<span class="menberLeft fl">店铺合计</span>
    					<span class="menberRight fr d32f2f"><?php echo (HtmlHelper::formatPrice($model->pay_price)); ?></span>
    					<span class="clear"></span>
	    			</li>
	    		</ul>
	    	</div>
	    	<div class="ODItem ODItem3">
	    		<div class="ODItem3Title"><span>订单信息</span></div>
	    		<div class="ODItem3Info gray">
	    			<span>
    	    				订单编号：<?php echo $model->code ?><br/>
    	    		  <?php if($model->status!=$model::STATUS_CLOSE && $model->delivery_status==$model::DELIVERY_STATUS_SEND && $model->status==$model::STATUS_NEW):?> 
    	    				成交时间：<?php echo $this->format()->formatDatetime($model->pay_time) ?><br/>
    	    				订单自动确认收货时间：<?php echo $this->format()->formatDatetime($showDay) ?><br/>
    	    		  <?php endif;?>
	    			</span>
	    		</div>
	    	</div>
	    </div>
	    <!-- 底部固定按钮 -->
	  <?php if($model->status!=$model::STATUS_CLOSE):?> 
	    <?php if($model->pay_status == $model::PAY_STATUS_NO):?>
	    <div class="ODFooter">
	    	<div class="OSListBtn"> 
   				<?php echo CHtml::link(Yii::t('memberOrder', '去付款'), $this->createAbsoluteUrl('orderConfirm/pay', array('code' => $model->code)),array('class'=>'OSListOnfirmBtn OCBtn'));?>
   				<div class="clear"></div>
   			</div>
	    </div>
	    <?php elseif($model->delivery_status==$model::DELIVERY_STATUS_SEND && $model->status==$model::STATUS_NEW):?>
	    <div class="ODFooter">
	    	<div class="OSListBtn"> 
   				<?php echo CHtml::link(Yii::t('memberOrder', '查看物流'), $this->createAbsoluteUrl('order/logistics', array('code' => $model->code)),array('class'=>'OSListCheckBtn fr'));?>
   				<a href="javascript:void();" data_code="<?php echo $model->code;?>" id="signOrder"  class="OSListOnfirmBtn fr confirmOrder">确认收货</a>	
   				<div class="clear"></div>
   			</div>
	    </div>
	    <?php elseif($model->delivery_status==$model::DELIVERY_STATUS_RECEIVE && $model->is_comment==$model::IS_COMMENT_NO):?> 
	    <div class="ODFooter">
	    	<div class="OSListBtn"> 
   				<?php echo CHtml::link(Yii::t('memberOrder', '去评价'), $this->createAbsoluteUrl('order/comment', array('code' => $model->code)),array('class'=>'OSListOnfirmBtn OCBtn'));?>	
   			   <div class="clear"></div>
   			</div>
	    </div>
	    <?php endif;?>
	<?php endif;?>    
   </div>
   <?php $this->renderPartial('_orderSign'); ?>
  </body>
</html>
