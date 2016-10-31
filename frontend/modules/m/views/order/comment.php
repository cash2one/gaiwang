<div class="main">	
	    <?php
   $form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
 ?>	
	    	<div class="OAInfo">
	    		<span><?php echo $store->name;?></span> <br/>
				订单号：<?php echo  $order->code;?><br/>
				订单金额：<?php echo $order->real_price;?>
	    	</div>
			<div class="OAItemMain clearfix">
				<span class="OAItemTitle fl">综合评价</span>
				<div class="OAItemMainLeft">
					<?php for($i=1;$i<=5;$i++):?>
								<img onclick="getComment(1,<?php echo $i;?>)"  width="20" src="<?php echo DOMAIN; ?>/images/m/bg/<?php if($i<=3):?>m_ioc16.png<?php else:?>m_ioc17.png<?php endif;?>" num="<?php echo $i;?>"></img>
					<?php endfor;?>	
				     <input type="hidden" id="store_score_1" value="3" name="StoreRating[description_match]">
				     <input type="hidden" id="store_score_2" value="3" name="StoreRating[service_attitude]">
				     <input type="hidden" id="store_score_3" value="3" name="StoreRating[speed_of_delivery]">
				</div>
				<div class="OAItemMainRight">					
				</div>
			</div>
			
			<div class="ODItem ODItem2 OCList OAList">
	    		<ul class="orderAppraise">
	    		  <?php foreach($order->orderGoods as $key => $good):?>
					<li>
		    			<a href="<?php echo $this->createUrl('order/detail',array('code' =>$order->code));?>" title="" class="OSProducts">
		    				<?php echo CHtml::image(IMG_DOMAIN . '/' . $good['goods_picture'], '', array('width' => '80', 'class' => 'fl')) ?>
		    				<span class="OSProductsRight ODProductsRight fl">
		    					<span class="OSProductsInfo"><?php echo $good['goods_name'];?></span>
		   						<span class="ODItem2Info">
		   						 <?php if (!empty($good['spec_value'])): ?>
                                        <?php foreach (unserialize($good['spec_value']) as $ksp => $vsp): ?>
                                            <?php echo $ksp . ': ' . $vsp ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
			   						<?php echo HtmlHelper::formatPrice($good['unit_price'])?><br/>
									数量：<?php echo $good['quantity'];?><span class="ODItem2Price d32f2f"><?php echo HtmlHelper::formatPrice($good['unit_price']*$good['quantity'])?></span>
			   					</span>
		    				</span>
		    				<span class="clear"></span>
		    			</a>
						<div class="OAItemMain clearfix">
							<span class="OAItemTitle fl">商品质量</span>
							<div class="OAItemMainLeft">
							<?php for($i=1;$i<=5;$i++):?>
								<img  onclick="getComment(2,<?php echo $i;?>,<?php echo $key?>)" width="20" src="<?php echo DOMAIN; ?>/images/m/bg/<?php if($i<=3):?>m_ioc16.png<?php else:?>m_ioc17.png<?php endif;
								?>" num="<?php echo $i;?>"></img>
							<?php endfor;?>	
							<?php echo $form->error($model, "[$key]score") ?>
							</div>
							<div class="OAItemMainRight">					
							</div>
						</div>
						<div class="OAItemMain">
						<?php echo $form->textArea($model, "[$key]content", array('rows' => '3','Placeholder'=>'点击发表意见...'))?>
						</div>
						<?php echo $form->error($model, "[$key]content") ?>
						<div  class="clear"></div>
						<?php echo $form->hiddenField($model, "[$key]score", array('value' => "3")) ?>
						<?php echo $form->hiddenField($model, "[$key]goods_id", array('value' => $good['goods_id'])) ?>
                        <?php echo $form->hiddenField($model, "[$key]spec_value", array('value' => Tool::authcode($good['spec_value']))) ?>
	    			</li>
				 <?php endforeach;?>
				</ul>
	    	<?php echo CHtml::submitButton(Yii::t('memberComment', '确认评价'), array('class' => 'loginSub','id'=>'gotoSubmit')) ?>
	    </div>
   <?php $this->endWidget(); ?>
    </div>

  </body>
  <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/m/jquery-2.1.1.min.js"></script>
  <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/m/member.js"></script>
  <script type="text/javascript">
    function getComment(ctype,score,key){
           if(ctype==1){
              $("input[id^='store_score']").val(score);
               }
           if(ctype==2){
        	   $("#Comment_"+key+"_score").val(score);    
               }
        }
  </script>
</html>
