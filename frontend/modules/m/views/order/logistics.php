	  </div>
   </div> 
   
	    <div class="main">
	    	<div class="logisticsInfo">
	    	<!-- 
	    		<img class="fl" width="48" src="<?php echo DOMAIN; ?>/images/m/bg/m_img4.jpg"></img>
	    		 -->
	    		<div class="fl">
	    			<?php echo $model->express;?>速递<br/>
	    			运单编号：<?php echo $model->shipping_code;?>
	    		</div>
	    		<div class="clear"></div>
	    	</div>
	    	<div class="ODItem ODItem2">
	    		<ul>
	    			<li>
	    				<div class="OSlistTitle">
		    				<div class="OSlistTitleLeft LILeft fl">订单商品</div>
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
		    					<span class="OSProductsInfo"><?php echo $v->goods_name;?></span>
		   						<span class="ODItem2Info">
			   						<?php if(!empty($v->spec_value)): ?>
                                            <?php foreach(unserialize($v->spec_value) as $ksp=>$vsp): ?>
                                                <?php echo $ksp.':'.$vsp ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?><br/>
			   						<?php echo HtmlHelper::formatPrice($v->unit_price)?>&nbsp;数量：<?php echo  $v->quantity;?><span class="ODItem2Price d32f2f"><?php echo (HtmlHelper::formatPrice($v->unit_price*$v->quantity));?></span>
			   					</span>
		    				</span>
		    				<span class="clear"></span>
		    			</a>
	    			</li>
	    			 <?php endforeach; ?>
                    <?php endif; ?>
	    			<!-- 产品列表 -->
	    		</ul>
	    	</div>
	    	
	    	 <?php if (!empty($model->shipping_code)): ?>
                    <script>
                        $("#express_orstatus").html('<?php echo Yii::t("order","正在查询物流信息.....");?>');
                        $.getJSON("<?php echo $this->createUrl('order/getExpressStatus', array('store_name' => $model->express, 'code' => $model->shipping_code, 'time' => time())); ?>", function(data) {
                            if (data.status != 200) {
                                $("#express_orstatus").html(data.message);
                            } else {
                                var ex_html = '';

                                $.each(data.data, function(i, item) {

                                    ex_html += '<div class="green">' + item.context + '<br/>' + item.time + '<span class="LIIoc2"></span></div>';
                                });

                                $("#express_orstatus").html(ex_html);

                            }
                        });

                    </script>
                    
                <?php endif; ?>
                
	    	<div class="ODItem ODItem2 gray">
	    		<ul>
	    			<li>
	    				<div class="OSlistTitle">
		    				<div class="OSlistTitleLeft LILeft fl">
		    				<?php if(!empty($model->shipping_code)):?>
		    				  <a href="http://m.kuaidi100.com/index_all.html?type=<?php echo $model->express;?>&postid=<?php echo $model->shipping_code;?>&callbackurl=<?php echo 'javascript:history.go(-1);';?>">物流详情</a>
		    				<?php else:?>
		    				             物流单号异常
		    				<?php endif;?>
		    				</div>
		    				<div class="clear"></div>
		    			</div>
	    			</li>
	    			<li class="LIDetails" id="express_orstatus" >
	    				<!-- 物流当前信息 
	    				<div class="green">
	    					已签收,签收人是本人签<br/>
							2014-11-13 18:01:08
							<span class="LIIoc2"></span>
	    				</div>
	    			
	    				<div>
	    					广东广州青龙坊点-的派件员正在派件<br/>
							2014-11-13 18:01:08
							<span class="LIIoc"></span>
	    				</div>
	    				<div>
	    					快件已到达-广东广州青龙坊点<br/>
							2014-11-13 18:01:08
							<span class="LIIoc"></span>
	    				</div>
	    				<div>
	    					快件已到达-广东广州中转部<br/>
							2014-11-13 18:01:08
							<span class="LIIoc"></span>
	    				</div>
	    				<div>
	    					广东广州荔湾点-已收件<br/>
							2014-11-13 18:01:08
							<span class="LIIoc"></span>
	    				</div>
	    				<div>
	    					卖家已发货<br/>
							2014-11-13 18:01:08
							<span class="LIIoc"></span>
	    				</div>-->
	    				
	    			</li>
	    		</ul>
	    	</div>
	    </div>
   </div>
  </body>
</html>
