<div class="main-contain main-contain2">
        <div class="withdraw-contents">
            <div class="accounts-box accounts-box4">
                <p class="accounts-title accounts-title2 cover-icon"><?php echo Yii::t('memberHotelOrder', '酒店详情')?></p>
				 <div class="mbDate1">
					<div class="mbDate1_c">
						<div class="mgtop20 upladBox pdbottom10 "><h3><?php echo Yii::t('memberHotelOrder', '入住信息')?></h3></div>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableBank">
							   <tr>
									 <td width="98" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '联系人') ?>：</td>
									 <td width="420" height="35" class="pdleft20 bgF4"><?php echo $model->contact; ?></td>
									 <td width="100" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '联系方式') ?>：</td>
									 <td height="35" class="pdleft20 bgF4"><?php echo $model->mobile; ?></td>
							   </tr>
							   <tr>
									 <td width="100" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '入住人') ?>：</td>
									 <td width="215" height="35" class="pdleft20 bgF4 pdtop10 pdbottom10">
										<p><?php echo HotelOrder::analysisLodgerInfo($model->people_infos, "<br />"); ?></p>
										<p><?php echo Yii::t('memberHotelOrder', '共{num}人', array('{num}' => $model->peoples)); ?></p>
									 </td>
									 <td width="80" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '入离时间') ?>：</td>
									 <td height="35" class="pdleft20 bgF4">
									  <?php
                                            echo Yii::t('memberHotelOrder', '{settled} 至 {leave} {night}晚', array(
                                                '{settled}' => date('Y-m-d', $model->settled_time),
                                                '{leave}' => date('Y-m-d', $model->leave_time),
                                                '{night}' => "&nbsp;&nbsp;" . HotelCalculate::liveDays($model->leave_time, $model->settled_time),
                                            ));
                                            ?>
									 </td>
							   </tr>
						</table>
						<div class="mgtop10 upladBox pdbottom10 "><h3><?php echo Yii::t('memberHotelOrder', '洒店及客房信息')?></h3></div>
						 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableBank integralTab">
						   <tr>
								 <td width="80" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '酒店名称')?>：</td>
								 <td width="340" height="35" class="bgF4 pdleft20 bgF4 pdtop10 pdbottom10">
								 <?php
                                  echo CHtml::link(CHtml::image(Tool::showImg(!$model->hotel ? '' : ATTR_DOMAIN . '/' . $model->hotel->thumbnail, 'c_fill,h_100,w_100'), $model->hotel_name, array(
                                    'class' => 'fl', 'width' => '86', 'height' => '86')), $this->createAbsoluteUrl('/hotel/site/view', array('id' => $model->hotel_id)), array('class' => 'fl mgright5', 'style' => 'border:1px solid #ccc'));
                                  ?>
									<a href="#"  class="fl"title="<?php echo $model->hotel_name; ?>"><?php echo $model->hotel_name; ?></a></td>
								 <td width="80" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '酒店位置')?>： </td>
								 <td width="296" height="35" class="bgF4 pdleft20"><?php echo Region::getName(!$model->hotel ? 0 : $model->hotel->province_id) ?>-<?php echo Region::getName(!$model->hotel ? 0 : $model->hotel->city_id) ?>-<?php echo!$model->hotel ? '' : $model->hotel->street; ?> </td>
								 
						   </tr>
							<tr>
								 <td width="80" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '客房名称')?>：</td>
								 <td width="340" height="35" class="bgF4 pdleft20 bgF4 pdtop10 pdbottom10">
									<?php
                                      echo CHtml::link(CHtml::image(Tool::showImg(!$model->room ? '' : ATTR_DOMAIN . '/' . $model->room->thumbnail, 'c_fill,h_100,w_100'), $model->room_name, array(
                                        'class' => 'fl', 'width' => '86', 'height' => '86')), $this->createAbsoluteUrl('/hotel/site/view', array('id' => $model->hotel_id)), array('class' => 'fl mgright5', 'style' => 'border:1px solid #ccc;'));
                                ?>
									<a href="<?php echo $this->createAbsoluteUrl('/hotel/site/view', array('id' => $model->hotel_id)) ?>"  class="fl"title="<?php echo $model->room_name; ?>"><?php echo $model->room_name; ?></a></td>
								 <td width="80" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '客房价格')?>： </td>
								 <td width="296" height="35" class="bgF4 pdleft20"><?php echo HtmlHelper::formatPrice($model->unit_price); ?>/天 </td>
								 
						   </tr>
						</table> 
						<div class="mgtop10 upladBox pdbottom10 "><h3><?php echo Yii::t('memberHotelOrder', '交易信息'); ?></h3></div>
						 <?php
                                if ($model->status == HotelOrder::STATUS_SUCCEED && $model->score == 0):
                                    $form = $this->beginWidget('ActiveForm', array(
                                        'id' => $this->id . '-form',
                                        'enableAjaxValidation' => true,
                                        'enableClientValidation' => true,
                                        'clientOptions' => array(
                                            'validateOnSubmit' => true,
                                        ),
                                    ));
                                endif;
                                ?>		 
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableBank integralTab">
						   <tr>
								 <td width="80" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '订单编号'); ?>：</td>
								 <td width="300" height="35" class="bgF4 pdleft20 "><?php echo $model->code; ?></td>
								 <td width="80" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '下单时间'); ?>： </td>
								 <td width="296" height="35" class="bgF4 pdleft20"><?php echo date('Y-m-d H:i:s', $model->create_time) ?></td>
								 
						   </tr>
							<tr>
								 <td width="80" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '订单状态'); ?>：</td>
								 <td width="300" height="35" class="bgF4 pdleft20"><?php echo HotelOrder::getOrderStatus($model->status) ?></td>
								 <td width="80" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '支付状态'); ?>： </td>
								 <td width="296" height="35" class="bgF4 pdleft20"><?php echo HotelOrder::getPayStatus($model->pay_status) ?></td>
								 
						   </tr>
							<tr>
								 <td width="80" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '订单总价'); ?>：</td>
								 <td width="300" height="35" class="bgF4 pdleft20"><?php echo HtmlHelper::formatPrice($model->total_price); ?></td>
								 <td width="80" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '支付时间'); ?>： </td>
								 <td width="296" height="35" class="bgF4 pdleft20"><?php echo $model->pay_time ? date('Y-m-d H:i:s', $model->pay_time) : ''; ?></td>
								 
						   </tr>
						     
							<tr>
								 <td width="80" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '已支付价格'); ?>：</td>
								 <td width="300" height="35" class="bgF4 pdleft20"><?php echo HtmlHelper::formatPrice($model->payed_price); ?></td>
								 <td width="80" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '未支付价格'); ?>： </td>
								 <td width="296" height="35" class="bgF4 pdleft20"><?php echo HtmlHelper::formatPrice($model->unpay_price); ?></td>
								 
						   </tr>
						     
							<tr>
								 <td width="80" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '手续费'); ?>：</td>
								 <td width="716" height="35" class="bgF4 pdleft20" colspan="3"><?php echo HtmlHelper::formatPrice($model->refund); ?></td>
								
								 
						   </tr>
						   <?php if ($model->status == HotelOrder::STATUS_SUCCEED && $model->score == 0): ?>
							<tr>
								 <td width="500" height="35" align="center" class="dtEe" colspan="3">
									  <div class="hlstar mgtop10" id="hlstar" style="margin: 25px;">
										<span class="fl"><?php echo Yii::t('memberHotelOrder', '我要打分'); ?></span>
										 <?php echo $form->error($model, 'score'); ?>
										<ul>
											<li><a>1</a></li>
											<li><a>2</a></li>
											<li><a>3</a></li>
											<li><a>4</a></li>
											<li><a>5</a></li>
										</ul>
										<span></span>
										 <p></p>
									   </div>
									    <?php echo $form->textArea($model, 'comment', array('class' => 'reviewtxt','maxlength'=>100)) ?>
                                        <?php echo $form->error($model, 'comment'); ?>
								 </td>
								 <td width="296" height="35" class="bgF4 pdleft20">
								     <?php echo $form->hiddenField($model, 'score'); ?>
                                     <?php echo CHtml::submitButton(Yii::t('memberHotelOrder', '我要点评'), array('class' => 'hbtnSubmit')); ?>
								 </td>
						   </tr>
						    <?php else:?> 
						    <tr>
								 <td width="80" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '订单评分'); ?>：</td>
								 <td width="716" height="35" class="bgF4 pdleft20" colspan="3"><?php echo $model->score; ?></td>	 
						   </tr>
						   <tr>
								 <td width="80" height="35" align="center" class="dtEe"><?php echo Yii::t('memberHotelOrder', '评价内容'); ?>：</td>
								 <td width="716" height="35" class="bgF4 pdleft20" colspan="3"><?php echo Tool::banwordReplace($model->comment, '*'); ?></td>	 
						   </tr>
						   <?php endif;?>
						 </table> 
			       <?php
                      if ($model->status == HotelOrder::STATUS_SUCCEED && $model->score == 0) {
                            $this->endWidget();
                               }
                       ?>
					</div>
		        </div>
            </div>
        </div>
      </div>
<!-- 主体end -->
      
      <!--星级打分 start-->
	<script type="text/javascript"> 
	window.onload = function (){

		var oStar = document.getElementById("hlstar");
		var aLi = oStar.getElementsByTagName("li");
		var oUl = oStar.getElementsByTagName("ul")[0];
		var oSpan = oStar.getElementsByTagName("span")[1];
		var oP = oStar.getElementsByTagName("p")[0];
		var i = iScore = iStar = 0;
		var aMsg = [
					"很不满意|差得太离谱，与卖家描述的严重不符，非常不满",
					"不满意|部分有破损，与卖家描述的不符，不满意",
					"一般|质量一般，没有卖家描述的那么好",
					"满意|质量不错，与卖家描述的基本一致，还是挺满意",
					"非常满意|质量非常好，与卖家描述的完全一致，非常满意"
					]
		
		for (i = 1; i <= aLi.length; i++){
			aLi[i - 1].index = i;
			
			//鼠标移过显示分数
			aLi[i - 1].onmouseover = function (){
				fnPoint(this.index);
				//浮动层显示
				oP.style.display = "block";
				//计算浮动层位置
				oP.style.left = oUl.offsetLeft + this.index * this.offsetWidth - 104 + "px";
				//匹配浮动层文字内容
				oP.innerHTML = "<em>" + this.index + " 分 " + aMsg[this.index - 1].match(/(.+)\|/)[1] + "</em>" + aMsg[this.index - 1].match(/\|(.+)/)[1]
			};
			
			//鼠标离开后恢复上次评分
			aLi[i - 1].onmouseout = function (){
				fnPoint();
				//关闭浮动层
				oP.style.display = "none"
			};
			
			//点击后进行评分处理
			aLi[i - 1].onclick = function (){
				iStar = this.index;
				oP.style.display = "none";
				oSpan.innerHTML = "<strong>" + (this.index) + " 分</strong> (" + aMsg[this.index - 1].match(/\|(.+)/)[1] + ")"
				 $("#HotelOrder_score").val(this.index);
				}
		}
		
		//评分处理
		function fnPoint(iArg){
			//分数赋值
			iScore = iArg || iStar;
			for (i = 0; i < aLi.length; i++) aLi[i].className = i < iScore ? "on" : "";	
		}
		
	};
	</script>
	<!--星级打分 end-->
</body>
</html>