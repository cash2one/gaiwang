<?php
// 切换加盟商视图
$this->breadcrumbs = array(
    Yii::t('sellerFranchisee', '加盟商') => array('/seller/franchisee/'),
    Yii::t('sellerFranchisee', '盖网售货机商品管理')
);
?>
<div class="toolbar">
	<b> <?php echo $model->name;?> <?php echo Yii::t('sellerFranchisee','的盖网售货机商品管理');?></b>
	<span><?php echo Yii::t('sellerFranchisee','盖网售货机商品管理。');?></span>
	
	<a class="mt15 btnSellerEditor" href="<?php echo Yii::app()->createUrl('/seller/franchisee/vendingMachineGoodsAdd/',array('mid'=>$machine_model->id));?>"><?php echo Yii::t('sellerFranchisee','添加商品');?></a>
	
	<?php echo CHtml::button(Yii::t('sellerOrder', "返回"),array('class'=>'mt15 btnSellerEditor','onclick'=>'history.go(-1)', 'style'=>"float:right"))?>
	
	
</div>

<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
						<tbody><tr>
								<th class="bgBlack" width="20%"><?php echo Yii::t('sellerFranchisee','商品名称');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','封面图片');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','售价');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('sellerFranchisee','库存');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('sellerFranchisee','已售');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','状态');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','操作');?></th>
							</tr>
							
							
								<?php foreach ($machine_goods_data as $data):?>
								
								<tr class="even">
									<td class="ta_c"><span title="<?php echo $data->name;  ?>"><?php echo mb_substr($data->name, 0,20,'utf-8') ; echo mb_strlen($data->name)>20?'...':'';  ?></span></td>
									<td class="ta_c"><?php echo  CHtml::image(IMG_DOMAIN.DS.$data->thumb,$data->name,array('width'=>'232px')); ?></td>
									<td class="ta_c">￥<?php echo $data->price;?></td>
									<td class="ta_c"><?php echo $data->stock;?></td>
									<td class="ta_c"><?php echo $data->sold;?></td>
									<td class="ta_c"><b class="red"><?php echo VendingMachineGoods::getStatus($data->status);?></b></td>
									<td class="ta_c">
									
										<?php if($data->status == VendingMachineGoods::STATUS_ENABLE){?>
											<a href="<?php echo Yii::app()->createUrl('/seller/franchisee/vendingMachineGoodsDisable/',array('id'=>$data->id,'mid'=>$data->machine_id));?>"><?php echo Yii::t('sellerFranchisee', '下架')?></a>
										<?php } else {?>
											<a href="<?php echo Yii::app()->createUrl('/seller/franchisee/vendingMachineGoodsEnable/',array('id'=>$data->id,'mid'=>$data->machine_id));?>"><?php echo Yii::t('sellerFranchisee', '上架')?></a>
										<?php }?>
										| <a href="<?php echo Yii::app()->createUrl('/seller/franchisee/vendingMachineGoodsEdit/',array('id'=>$data->id,'mid'=>$data->machine_id));?>"><?php echo Yii::t('sellerFranchisee', '修改')?></a>
										
										| <a href="<?php echo Yii::app()->createUrl('/seller/franchisee/vendingMachineGoodsStockBalance/',array('mid'=>$data->machine_id,'id'=>$data->id));?>"><?php echo Yii::t('sellerFranchisee', '库存流水')?></a>
										
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