<?php
// 切换加盟商视图
$this->breadcrumbs = array(
    Yii::t('sellerFranchisee', '加盟商') => array('/seller/franchisee/'),
    Yii::t('sellerFranchisee', '线下商品管理')
);
?>
<div class="toolbar">
	<b> <?php echo $franchisee_model->name;?> <?php echo Yii::t('sellerFranchisee','的线下订单管理');?></b>
	<span><?php echo Yii::t('sellerFranchisee','线下订单管理。');?></span>
	
</div>

<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
						<tbody><tr>
								<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','订单编号');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','顾客手机');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','开单方式');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','销售总价');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('sellerFranchisee','支付总价');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('sellerFranchisee','状态');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('sellerFranchisee','操作');?></th>
							</tr>
							
							<?php foreach ($order_data as $data):?>
							
							<tr class="even">
								<td class="ta_c"><?php echo $data->code;  ?></td>
								<td class="ta_c"><?php echo $data->mobile;  ?></td>
								<td class="ta_c"><b class="red"><?php echo FranchiseeGoodsOrder::getOpentype($data->open_type);?></b></td>
								<td class="ta_c">￥<?php echo $data->seller_price;?></td>
								<td class="ta_c">￥<?php echo $data->pay_price;?></td>
								<td class="ta_c"><b class="red"><?php echo FranchiseeGoodsOrder::getStatus($data->status);?></b></td>
								<td class="ta_c">
								
									<a href="<?php echo Yii::app()->createUrl('/seller/franchiseeOrder/info/',array('code'=>$data->code));?>"><?php echo Yii::t('sellerFranchisee', '查看详情')?></a>
								
								</td>
							</tr>
							
							<?php endforeach;?>
							
					</tbody></table>
					
					
<div class="page_bottom clearfix">
	<div class="pagination">
		<?php
		  $this->widget('CLinkPager',array(   //此处Yii内置的是CLinkPager，我继承了CLinkPager并重写了相关方法
		    'header'=>'',
		    'prevPageLabel' => Yii::t('page', '上一页'),
		    'nextPageLabel' => Yii::t('page', '下一页'),
		    'pages' => $pager,       
		    'maxButtonCount'=>10,    //分页数目
		    'htmlOptions'=>array(
		       'class'=>'paging',   //包含分页链接的div的class
		     )
		  )
		  );
		?>
	</div>
</div>