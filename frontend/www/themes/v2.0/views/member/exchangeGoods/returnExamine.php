<?php 
$servicePhone = '400-620-6899';
$on2  = ($result['exchange_status'] >= Order::EXCHANGE_STATUS_WAITING && $result['exchange_status'] <= Order::EXCHANGE_STATUS_DONE) ? 'on' : '';
$on3  = $result['exchange_status'] == Order::EXCHANGE_STATUS_DONE ? 'on' : '';
$time = 0;
?>
<div class="member-contain clearfix">
    <div class="crumbs">
        <span><?php echo Yii::t('member', '您的位置');?>：</span>
        <a href="<?php echo $this->createAbsoluteUrl('/member/site/index');?>"><?php echo Yii::t('member', '首页');?></a>
        <span>&gt</span>
        <a href="<?php echo $this->createAbsoluteUrl('/member/exchangeGoods/admin');?>"><?php echo Yii::t('member', '售后服务');?></a>
        <span>&gt</span>
        <a href="<?php echo $this->createAbsoluteUrl('/member/exchangeGoods/backGoods', array('code'=>$data['code']));?>"><?php echo Yii::t('member', '退换货申请');?></a>
    </div> 
    <div class="returns-product">
        <div class="returns-top">
            <p class="returns-title cover-icon"><?php echo Yii::t('memberOrder', '售后服务详情');?></p>
            <div class="returns-process clearfix">
                <div class="returns-process-item on">
                    <p class="number">1</p>
                    <p class="txtle"><?php echo Yii::t('memberOrder', '买家 提交申请');?></p>
                    <span class="returns-backdrop on"></span>
                </div>
                
                <div class="returns-process-item <?php echo $on2;?>">
                    <p class="number">2</p>
                    <p class="txtle"><?php echo Yii::t('memberOrder', '商家 处理申请');?></p>
                    <span class="returns-backdrop <?php echo $on3;?>"></span>
                </div>
                
                <div class="returns-process-item <?php echo $on3;?>">
                    <p class="number">3</p>
                    <p class="txtle"><?php echo Yii::t('memberOrder', '完成');?></p>
                </div>
            </div>
        </div>
        
        <div class="returns-services">
            <p class="returns-title cover-icon"><?php echo Yii::t('memberOrder', '服务进度');?></p>
            <p class="returns-services-title"><?php echo Yii::t('memberOrder', '本次服务由');?> <span><?php echo $orderInfo['memberInfo']['store_name'] ?></span> <?php echo Yii::t('memberOrder', '为您提供');?></p>
            <div class="returns-services-box">
              <ul>
                <p><span><?php echo Yii::t('memberOrder', '退换货编号');?>：</span><?php echo $result['exchange_code'];?></p>
                <p><span><?php echo Yii::t('memberOrder', '退换货类型');?>：</span><?php echo Yii::t('memberOrder', '退货');?></p>
                <p><span><?php echo Yii::t('memberOrder', '退换货状态');?>：</span><?php echo $exchangeStatus[$result['exchange_status']];?></p>
                
                
              <?php if($result['exchange_status'] == Order::EXCHANGE_STATUS_WAITING){//卖家审核中 ==================================================================================== 
			      $time = $result['exchange_apply_time'] + Order::EX_CHANGE_TIME - time();
			  ?>   
                <p><?php echo Yii::t('memberOrder', '亲爱的客户，请您等待卖家审核结果。');?></p>
                <p class="li"><?php echo Yii::t('memberOrder', '如果卖家同意，待您退货给卖家后，卖家将给您支付');?> 
                  <i><?php echo HtmlHelper::formatPrice($result['exchange_money']);?></i><?php echo Yii::t('memberOrder', '元 退款；');?></p>
                <p class="li"><?php echo Yii::t('memberOrder', '如果卖家拒绝，可根据卖家的拒绝理由再次提出退款申请，或者您可以直接与卖家沟通；');?></p>
                <p class="li"><?php echo Yii::t('memberOrder', '如果卖家在');?> 
                  <i id="returnTime" data="<?php echo $time;?>"><?php echo $result['return_time'];?></i> <?php echo Yii::t('memberOrder', '内未处理，请联系商城客服进行申诉');?></p>
                <p><span><?php echo Yii::t('memberOrder', '您还可以');?>：</span> <a href="javascript:cancalReturn(<?php echo $result['exchange_id'];?>);"><i><?php echo Yii::t('memberOrder', '取消退货申请，取消后将不能再次提交申请！');?></i></a>  <?php echo Yii::t('memberOrder', '如需客服介入，致电');?><span class="blue"><?php echo $servicePhone;?></span></p>
              
              
			  <?php //}else if($result['exchange_status'] == Order::EXCHANGE_STATUS_PASS){//卖家审核通过(这个状态没用) ?>
              <?php }else if($result['exchange_status'] == Order::EXCHANGE_STATUS_RETURN){//等待买家退货 ==================================================================================== 
			      $time = $result['exchange_examine_time'] + Order::EX_CHANGE_TIME - time();
			  ?> 
                <?php
				$form = $this->beginWidget('ActiveForm', array(
					'id' => $this->id . '-form',
					'enableAjaxValidation' => true,
					'enableClientValidation' => true,
					'clientOptions' => array(
						'validateOnSubmit' => true,
					),
					'htmlOptions' => array(
						'enctype' => 'multipart/form-data',
					),
				));
				?>
                <p><?php echo Yii::t('memberOrder', '亲爱的客户，卖家已接纳您的退货申请，请退货给卖家并填写物流信息');?></p>
                <p><span>1、<?php echo Yii::t('memberOrder', '请退货');?></span></p>
                <p><?php echo Yii::t('memberOrder', '未经卖家同意，请不要使用到付或平邮。');?></p>
                <p><?php echo Yii::t('memberOrder', '退货地址');?>   ：<span><?php echo Region::getName($store['province_id'],$store['city_id'],$store['district_id']);?></span>&nbsp;&nbsp;<?php echo $store['street'];?></p>
                <p><?php echo Yii::t('memberOrder', '收件人名');?>   ：<span><?php echo $store['name'];?></span></p>
                <p><?php echo Yii::t('memberOrder', '联系电话');?>   ：<span><?php echo $store['mobile'];?></span></p>
                <p><span>2、<?php echo Yii::t('memberOrder', '请填写退货物流信息');?></span>（<?php echo Yii::t('memberOrder', '逾期未填写，退货申请将会在');?> 
                  <i id="returnTime" data="<?php echo $time;?>"><?php echo $result['return_time'];?></i> <?php echo Yii::t('memberOrder', '后自动取消');?>）</p>
                <br />
                <li><span class="directions"><i>*</i><?php echo Yii::t('memberOrder', '物流公司');?>：</span>
                  <?php echo $form->dropDownList($model,'logistics_company',  Express::getExpress(), array('class'=>'btn-cleck', 'empty'=>Yii::t('memberOrder', '请选择物流公司')))?>
                  <?php echo $form->error($model, 'logistics_company'); ?>
                </li>
                <li><span class="directions"><i>*</i><?php echo Yii::t('memberOrder', '运单号');?>：</span> 
                  <?php echo $form->textField($model, 'logistics_code', array('class' => 'input-number')); ?>
                  <?php echo $form->error($model, 'logistics_code'); ?>
                </li>
                <li><span class="directions"><?php echo Yii::t('memberOrder', '物流说明');?>：</span>
                  <?php echo $form->textArea($model, 'logistics_description', array('class' => 'input-txtle', 'maxlength'=>'200', 'placeholder'=>Yii::t('memberOrder', '0-200汉字。请简要说明物流相关的信息'))); ?>
                  <?php echo $form->error($model, 'logistics_description'); ?>
                </li>
                <li><input name="" type="submit" class="btn-deter" value="<?php echo Yii::t('memberOrder', '提交信息');?>" /></li>
                <p><span><?php echo Yii::t('memberOrder', '您还可以');?>：</span> <a href="javascript:cancalReturn(<?php echo $result['exchange_id'];?>);"><i><?php echo Yii::t('memberOrder', '取消退货申请');?></i></a>  <?php echo Yii::t('memberOrder', '如需客服介入，致电');?><span class="blue"><?php echo $servicePhone;?></span></p>
                <li> <?php echo $form->hiddenField($model, 'exchange_id', array('class' => 'input-number', 'value'=>$result['exchange_id'])); ?></li>
               <?php $this->endWidget(); ?> 
                
              <?php }else if($result['exchange_status'] == Order::EXCHANGE_STATUS_NO){//卖家审核不通过 ==================================================================================== ?>
                <p><?php echo Yii::t('memberOrder', '退货申请不通过，申请失败');?></p>
                <p><span><?php echo Yii::t('memberOrder', '卖家拒绝说明');?>：</span> <?php echo $result['exchange_examine_reason'];?></p>
                <p><?php echo Yii::t('memberOrder', '如需客服介入，致电');?><span class="blue"><?php echo $servicePhone;?></span></p>
               

              <?php }else if($result['exchange_status'] == Order::EXCHANGE_STATUS_REFUND){//等待卖家退款 ==================================================================================== 
			      $time = $result['exchange_examine_time'] + Order::EX_CHANGE_TIME - time();
			  ?>
                <p><?php echo Yii::t('memberOrder', '亲爱的客户，请等待卖家收货和退款。');?></p>
                <p class="li"><?php echo Yii::t('memberOrder', '目前您的商品是安全的。');?></p>
                <p class="li"><?php echo Yii::t('memberOrder', '如果卖家收到货并验货无误，卖家将给您支付');?>
                  <i> <?php echo HtmlHelper::formatPrice($result['exchange_money']);?></i> <?php echo Yii::t('memberOrder', '元 退款。');?></p>
                <p class="li"><?php echo Yii::t('memberOrder', '如果卖家拒绝退款，需要您修改退货申请。');?></p>
                <p class="li"><?php echo Yii::t('memberOrder', '如果卖家在');?>
                  <i id="returnTime" data="<?php echo $time;?>"> <?php echo $result['return_time'];?> </i> <?php echo Yii::t('memberOrder', '内未处理，系统将自动退款给您。');?></p>
                <p class="li"><?php echo Yii::t('memberOrder', '如需客服介入，致电');?> <span class="blue"><?php echo $servicePhone;?></span></p>
                <div class="logistics-info">
                    <p><span><?php echo Yii::t('memberOrder', '物流信息');?></span></p>
                    <div class="log-box clearfix">
                        <span class="log-name"><?php echo Yii::t('memberOrder', '快递公司');?>：<?php echo $result['logistics_company'];?></span>
                        <span class="log-num"><?php echo Yii::t('memberOrder', '运单号');?>：<?php echo $result['logistics_code'];?></span>
                        <span class="log-link"><a href="<?php echo $express[$result['logistics_company']]?>" target="_blank"><?php echo Yii::t('memberOrder', '点击进入物流自助查询');?></a></span>
                    </div>
                    <div class="log-box">
                        <p class="log-more" id="express_more"><a href="<?php echo $this->createAbsoluteUrl('exchangeGoods/lookupExpress', array('code' => $data['code'], 'type'=>2));?>" target="_blank"><?php echo Yii::t('memberOrder', '点击查看物流信息');?></a></p>
                    </div>
                </div>
                <script language="javascript">
				    $(document).ready(function(e) {
                        var url = "<?php echo $this->createUrl('order/getExpressStatus', array('store_name'=>$result['logistics_company'], 'code'=>$result['logistics_code'], 'time'=>time())); ?>";
						
						$.getJSON(url, function(data) {
							if (data.status != 200) {
								$("#express_more").before(data.message);
							} else {
								var html = '';
								$.each(data.data, function(i, item) {
									if(i<3){
									    html += '<p class="log-time"><i class="member-icon"></i>' + item.time + '<span style="padding-left:10px;">' + item.context + '</span></p>';
									}
								});
				
								$("#express_more").before(html);
							}
						});	
                    });
				</script>
                
              <?php }else if($result['exchange_status'] == Order::EXCHANGE_STATUS_CANCEL){//已取消 ==================================================================================== ?>     
                <p><?php echo Yii::t('memberOrder', '退货申请已取消，本次服务结束。');?><span class="block-off"></span><?php echo Yii::t('memberOrder', '如需客服介入，致电');?><span class="blue"><?php echo $servicePhone;?></span></p>
                
                
                
              <?php }else if($result['exchange_status'] == Order::EXCHANGE_STATUS_DONE){//已完成 ==================================================================================== ?> 
                <p><?php echo Yii::t('memberOrder', '退货成功。退款金额');?>：<i><?php echo HtmlHelper::formatPrice($result['exchange_money']);?></i><?php echo Yii::t('memberOrder', '元');?><span class="block-off"></span><?php echo Yii::t('memberOrder', '如需客服介入，致电');?><span class="blue"><?php echo $servicePhone;?></span></p>
                
              <?php }//结束 ?>
              </ul>
            </div>
        </div>

        <?php $this->renderPartial('_orderinfo',array('orderInfo'=>$orderInfo)); ?> 
    </div>
</div>

<script language="javascript">
	function cancalReturn(id){
		layer.confirm('<?php echo Yii::t('memberOrder', '你确定要取消该申请?'); ?>', {
			btn: ['确定','取消'], //按钮
			shade: false, //不显示遮罩
			offset: 'auto'
		}, function(){
			$.ajax({
				type: "POST",
				dataType: 'json', 
				url: "<?php echo $this->createAbsoluteUrl('exchangeGoods/cancelReturnGoods') ?>",
				data: {
					"YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
					"id": id
				},
				success: function(data) {
					layer.alert(data.message);
					window.location.reload();
				}
			});
		}, function(){
			layer.closeAll();
		});
	}
	
	function dealReturnTime(){
		time = $('#returnTime').attr('data');
		if(time > 0){
			$('#returnTime').attr('data', time-1);
			$('#returnTime').html(getTimeStr(time));
		}else{
		    return true;	
		}
	}
	
	function getTimeStr(time){
	    if(time > 0){
            if(time <2){
                history.go(0);
            }
			var d=Math.floor(time/86400);
			var h=Math.floor(time/3600%24);
			var m=Math.floor(time/60%60);
			var s=Math.floor(time%60);
			return d+'天'+h+'小时'+m+'分'+s+'秒'
		}else{
		    return '0天0小时0分0秒';	
		}
	}
	
	<?php
	if($result['exchange_status'] == Order::EXCHANGE_STATUS_WAITING 
	   || $result['exchange_status'] == Order::EXCHANGE_STATUS_RETURN || $result['exchange_status'] == Order::EXCHANGE_STATUS_REFUND){?>
	setInterval('dealReturnTime();',1000);  
	<?php }?>
</script>