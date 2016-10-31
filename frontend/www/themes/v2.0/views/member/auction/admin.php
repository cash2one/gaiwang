<style>
	.payment a{text-decoration:underline;
	            color:blue;}
	.order-more {text-decoration:underline;
	            color:blue;
				margin-left:40px;
				cursor:pointer;
				}
	.time-item {margin:0px;
	            padding:0px;
				border:0px;
				outline:0px;
				font-size:100%;
				background:transparent;
				color:red;}
	.time-item2 {margin:0px;
	            padding:0px;
				border:0px;
				outline:0px;
				font-size:100%;
				background:transparent;
				color:red;}
	.actives{
		        margin-left:80px
	}
	.light-color{
		        color:#AAAAAA;
	}
</style>
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
	<?php if($data && $rules):?>
    <table class="myorder-list">
        <thead>
        <tr class="col-name">
            <th class="quantity"><?php echo Yii::t('auction', '出价时间'); ?></th>
            <th class="quantity"><?php echo Yii::t('auction', '竞拍商品'); ?></th>
            <th class="quantity"><?php echo Yii::t('auction', '起拍价'); ?></th>
            <th class="quantity"><?php echo Yii::t('auction', '加价幅度'); ?></th>
            <th class="payment"><?php echo Yii::t('auction', '我的出价'); ?></th>
            <th class="payment"><?php echo Yii::t('auction', '我的冻结积分'); ?></th>
	        <th class="payment"><?php echo Yii::t('auction', '当前最高价'); ?></th>
	        <th class="payment"><?php echo Yii::t('auction', '是否中标'); ?></th>
	        <th class="payment"><?php echo Yii::t('auction', '支付状态'); ?></th>
	        <th class="payment"><?php echo Yii::t('auction', '操作'); ?></th>
        </tr>
        </thead>
		
        <?php foreach($rules as $rules_value) :?>
        <tbody class="list-item">
        <tr class="sep-row">
            <td colspan="10"></td>
        </tr>

        <tr class="order-hd">
            <td colspan="10">
                <b class="dealtime"><?php echo Tool::truncateUtf8String($rules_value['srm_name'],7);?></b>
	        <?php if ($rules_value['start_time'] <= date('Y-m-d H:i:s') && date('Y-m-d H:i:s',$rules_value['auction_end_time']) >= date('Y-m-d H:i:s') && $rules_value['is_force'] ==0 ):?><!--竞拍进行中 未强行结束 begin-->
                <span class="order-num">
		            (<?php echo Yii::t('auction','距结束');?>
	                <strong class="time-item" data-time="<?php echo $rules_value['auction_end_time'] - time();?>">0天0时0分0秒</strong>）
                </span><!--倒计时模块-->
                <span class="actives"><?php echo Yii::t('auction', '竞拍进行中'); ?></span>
	        <?php endif ?><!--竞拍进行中 未强行结束end-->
			
			<?php if ($rules_value['start_time'] <= date('Y-m-d H:i:s') && date('Y-m-d H:i:s',$rules_value['auction_end_time']) >= date('Y-m-d H:i:s') && $rules_value['is_force'] ==1 ):?><!--竞拍进行中 强行结束 begin-->
			    <span class="order-num">（<?php echo $rules_value['start_time'];?> <?php echo Yii::t('auction','开拍');?>）</span>
	            <span class="actives"><?php echo Yii::t('auction', '竞拍结束'); ?></span>
			<?php endif ?><!--竞拍进行中 强行结束end-->
			
			<?php if (date('Y-m-d H:i:s',$rules_value['auction_end_time']) < date('Y-m-d H:i:s') && $rules_value['is_force'] ==1) :?><!--竞拍结束 强制结束begin-->
	            <span class="order-num">（<?php echo $rules_value['start_time'];?> <?php echo Yii::t('auction','开拍');?>）</span>
	            <span class="actives"><?php echo Yii::t('auction', '竞拍结束'); ?></span>
	        <?php endif ?><!--竞拍结束 强制结束end-->
			
			<?php if (date('Y-m-d H:i:s',$rules_value['auction_end_time']) < date('Y-m-d H:i:s') && $rules_value['is_force'] ==0) :?><!--竞拍结束 未强制结束begin-->
	            <span class="order-num">（<?php echo $rules_value['start_time'];?> <?php echo Yii::t('auction','开拍');?>）</span>
	            <span class="actives"><?php echo Yii::t('auction', '竞拍结束'); ?></span>
	        <?php endif ?><!--竞拍结束 未强制结束end-->
				<?php if(Order::adminOrderCount($rules_value['goods_id'],$rules_value['rules_setting_id'],Yii::app()->user->id)>5): ?>
            <span class="order-more" tag="1">更多</span>
				<?php endif ?>
            </td>
        </tr><?php $flag=true;?>


        <?php
	      foreach($data as $val) :
		?>
        <?php if($rules_value['goods_id'] == $val['goods_id'] && $rules_value['rules_setting_id'] == $val['rules_setting_id']): ?><!--活动名称下对应的记录 begin-->
		<tr class="order-bd">
	        <td class="quantity" ><?php echo date('Y-m-d H:i:s',$val['auction_time'])?></td>
			<td class="quantity" ><?php echo Tool::truncateUtf8String($val['goods_name'],20);?></td>
			<td class="quantity" >￥<?php echo $val['start_price']?></td>
	        <td class="quantity" >￥<?php echo $val['price_markup']?></td>
	        <td class="payment">￥<?php echo $val['sum_price']?></td>
	        <td class="payment"><?php echo HtmlHelper::priceConvertIntegral($val['sum_price']); ?> <?php echo Yii::t('auction', '积分'); ?>（<?php echo Yii::t('auction', '状态'); ?>：<?php echo SeckillAuctionRecord::getStatusArray($val['is_return'])?>）</td>
		    <td class="payment">￥<?php echo $val['price']?>（<?php echo Yii::t('auction', '出价者'); ?>：<?php echo substr_replace($val['gai_number'],'****', 3, 4)?>）</td>
	        
			<!--竞拍进行中 未强制结束begin-->
	        <?php if ($rules_value['start_time'] <= date('Y-m-d H:i:s') && date('Y-m-d H:i:s',$rules_value['auction_end_time']) >= date('Y-m-d H:i:s') && $rules_value['is_force'] ==0 ) :?>

		    <td class="payment">/</td>
		    <td class="payment">/</td>
		    <?php if($flag==true){?>
			<?php $flag=false;?>
			<td class="payment"><a href="<?php echo Yii::app()->createUrl('/active/auction/detail', array('setting_id' => $val['rules_setting_id'], 'goods_id' => $val['goods_id'])) ?>"><?php echo Yii::t('auction', '继续出价'); ?></a></td>
            <?php }else{?>
            <td class="payment">/</td>
            <?php } ?>
			
	        <?php endif ?>
	        <!--竞拍进行中 未强制结束end-->
			
			<!--竞拍进行中 强制结束begin-->
	        <?php if ($rules_value['start_time'] <= date('Y-m-d H:i:s') && date('Y-m-d H:i:s',$rules_value['auction_end_time']) >= date('Y-m-d H:i:s') && $rules_value['is_force'] ==1 ) :?>

		    <td class="payment">/</td>
		    <td class="payment">/</td>
			<td class="payment">/</td>
	        <?php endif ?>
	        <!--竞拍进行中 强制结束end-->
			
	        <!--竞拍结束/中标 begin-->
	        <?php if(date('Y-m-d H:i:s',$rules_value['auction_end_time']) < date('Y-m-d H:i:s') && $val['auction_status'] ==1 && $rules_value['is_force'] ==0 && empty($val['auction_order_code'])) :?>
		    <?php if($val['reserve_price'] <= $val['price']):?>
			<td class="payment"><?php echo Yii::t('auction', '已中标'); ?></td>
		    <td class="payment"><?php echo Yii::t('auction', '未生成订单'); ?></td>
		    <td class="payment" id="time-item3" data-time3="<?php echo $rules_value['auction_end_time']+600 - time();?>"><span class="light-color"><?php echo Yii::t('auction','中标后若未能看到拍品的支付入口，请在竞拍结束5分钟后刷新页面再进行查阅。');?></span>
            </td>
			<?php else:?>
			<td class="payment"><?php echo Yii::t('auction','因最终拍卖价格达不到商品保留价，故此件商品拍卖不成立。');?></td>
			<td class="payment">/</td>
			<td class="payment">/</td>
			<?php endif ?>
	        <?php endif ?>
			
			<!--竞拍结束 强制结束begin-->
			<?php if(date('Y-m-d H:i:s',$rules_value['auction_end_time']) < date('Y-m-d H:i:s') && $rules_value['is_force'] ==1) :?>
		    <td class="payment">/</td>
		    <td class="payment">/</td>
		    <td class="payment">/</td>
	        <?php endif ?>
			<!--竞拍结束 强制结束end-->
		   
	        <?php if(date('Y-m-d H:i:s',$rules_value['auction_end_time']) < date('Y-m-d H:i:s') && $val['auction_status'] ==1 && !empty($val['auction_order_code']) && $val['pay_status'] ==2 && $rules_value['is_force'] ==0) :?>
		    <td class="payment"><?php echo Yii::t('auction', '已中标'); ?></td>
		    <td class="payment"><?php echo Yii::t('auction', '已支付'); ?></td>
		    <td class="payment">/</td>
	        <?php endif ?>
		   
	        <?php if(date('Y-m-d H:i:s',$rules_value['auction_end_time']) < date('Y-m-d H:i:s') && $val['auction_status'] ==1 && !empty($val['auction_order_code']) && $val['pay_status'] ==1 && $rules_value['is_force'] ==0 && $val['order_status']==1) :?><!--新订单-->
		    <td class="payment"><?php echo Yii::t('auction', '已中标'); ?></td>
		    <td class="payment"><?php echo Yii::t('auction', '未支付'); ?></td>
		    <td class="payment">
		    <a href="<?php echo Yii::app()->createUrl('/order/payv2', array('code' => $val['order_code']));?>"><?php echo Yii::t('auction','马上支付');?></a>
		    <?php echo Yii::t('auction','还剩');?>
		        <strong class="time-item2" data-time2="<?php echo $val['order_time']+259200-time();?>">
	            0天0时0分0秒
		        </strong><!--倒计时模块-->
		    <?php echo Yii::t('auction','停止支付，冻结积分将上缴平台');?>
		    </td>
			<?php endif ?>
			 
			<?php if(date('Y-m-d H:i:s',$rules_value['auction_end_time']) < date('Y-m-d H:i:s') && $val['auction_status'] ==1 && !empty($val['auction_order_code']) && $val['pay_status'] ==1 && $rules_value['is_force'] ==0 && $val['order_status']==3) :?><!--关闭交易-->
		    <td class="payment"><?php echo Yii::t('auction', '已中标'); ?></td>
		    <td class="payment"><?php echo Yii::t('auction', '未支付'); ?></td>
			<td class="payment">
		    <?php echo Yii::t('auction','逾时未支付，冻结积分已上缴平台');?>
		    </td>
			<?php endif ?>
			
	       
			<!--竞拍结束/中标 end-->
		
	        <!--竞拍结束/未中标 begin-->
	        <?php if(date('Y-m-d H:i:s',$rules_value['auction_end_time']) < date('Y-m-d H:i:s') && $val['auction_status'] ==2 && $rules_value['is_force'] ==0) :?>
		    <td class="payment"><?php echo Yii::t('auction', '未中标'); ?></td>
		    <td class="payment">/</td>
		    <td class="payment">/</td>
	        <?php endif ?>
	        <!--竞拍结束/未中标 end-->
        </tr>
        <?php endif ?><!--活动名称下对应的记录 end-->
        <?php endforeach ?>
        </tbody>

        <?php endforeach ?>
    </table>
	
	<?php else:?>
    <table class="myorder-list">
		<thead>
		<tr class="col-name">
			<th class="quantity"><?php echo Yii::t('auction', '出价时间'); ?></th>
			<th class="quantity"><?php echo Yii::t('auction', '竞拍商品'); ?></th>
			<th class="quantity"><?php echo Yii::t('auction', '起拍价'); ?></th>
			<th class="quantity"><?php echo Yii::t('auction', '加价幅度'); ?></th>
			<th class="payment"><?php echo Yii::t('auction', '我的出价'); ?></th>
			<th class="payment"><?php echo Yii::t('auction', '我的冻结积分'); ?></th>
			<th class="payment"><?php echo Yii::t('auction', '当前最高价'); ?></th>
			<th class="payment"><?php echo Yii::t('auction', '是否中标'); ?></th>
			<th class="payment"><?php echo Yii::t('auction', '支付状态'); ?></th>
			<th class="payment"><?php echo Yii::t('auction', '操作'); ?></th>
		</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
	<div style ="text-align:center;margin-top:10px;"><?php echo Yii::t('auction','暂无记录');?></div>
    <?php endif ?>
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
	/*计时方法*/

	function dealTimes(){
		$('.time-item').each(function(index, element) {
			ts = $(this).attr('data-time');
			if(ts > 0){
				d = Math.floor(ts/86400);
				h = Math.floor(ts/3600%24);
				m = Math.floor(ts/60%60);
				s = ts%60;

				html = d+'天'+h+'小时'+m+'分钟'+s+'秒';
				$(this).html(html);
				$(this).attr('data-time', ts-1);
			}else{
				window.location.reload();
				$(this).html('');
			}
		});
	}
	function dealTimes2(){
		$('.time-item2').each(function(index, element) {
			ts = $(this).attr('data-time2');
			if(ts > 0){
				d = Math.floor(ts/86400);
				h = Math.floor(ts/3600%24);
				m = Math.floor(ts/60%60);
				s = ts%60;

				html = d+'天'+h+'小时'+m+'分钟'+s+'秒';
				$(this).html(html);
				$(this).attr('data-time2', ts-1);
			}
			if(ts==0){
				window.location.reload();
				$(this).html('');
			}
		});
	}
	
	function dealTimes3(){
		$('#time-item3').each(function(index, element) {
			ts = $(this).attr('data-time3');
		    if(ts > 0){
				window.location.reload();
				$(this).html('');
			}
		});
	}

	$(function(){
		setInterval('dealTimes();', 1000);
		setInterval('dealTimes2();', 1000);
		setInterval('dealTimes3();', 60000);
	/*	$('.list-item').find('tr:gt(6)').each(function(){
			$(this).hide();
		});*/

		$(".order-more").each(function(){
			var num=$(this).attr("tag");
			if(num==1){
				$(this).parents('tr.order-hd').nextAll('tr.order-bd:gt(4)').hide();
			}
		});
        //显示隐藏的竞拍记录
        $(".order-more").click(function(){
            var num=$(this).attr("tag");
            if(num==1){
				$(this).parents('tr.order-hd').nextAll().show();
                $(this).attr("tag","2");
                $(this).text("收起");
            }else{
				$(this).parents('tr.order-hd').nextAll('tr.order-bd:gt(4)').hide();
                $(this).attr("tag","1");
                $(this).text("更多");
            }

        });
	});

</script>     

 