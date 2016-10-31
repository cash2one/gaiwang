<?php
// 切换加盟商视图
$this->breadcrumbs = array(
    Yii::t('sellerFranchiseeGoods', '加盟商') => array('/seller/franchisee/'),
    Yii::t('sellerFranchiseeGoods', '线下商品管理')
);
?>
<div class="toolbar">
	<b> <?php echo $franchisee_model->name;?> <?php echo Yii::t('sellerFranchiseeGoods','的线下商品管理');?></b>
	<span><?php echo Yii::t('sellerFranchiseeGoods','线下商品管理。');?></span>
	
	<a class="mt15 btnSellerEditor" href="<?php echo Yii::app()->createUrl('/seller/franchiseeGoods/create/');?>"><?php echo Yii::t('sellerFranchiseeGoods','添加商品');?></a>
	
</div>

<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
						<tbody><tr>
								<th class="bgBlack" width="20%"><?php echo Yii::t('sellerFranchiseeGoods','商品名称');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchiseeGoods','封面图片');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchiseeGoods','会员价');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchiseeGoods','销售价');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('sellerFranchiseeGoods','折扣');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('sellerFranchiseeGoods','销量');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchiseeGoods','状态');?></th>
								<th class="bgBlack" width="25%"><?php echo Yii::t('sellerFranchiseeGoods','操作');?></th>
							</tr>
							
							<?php foreach ($goods_data as $data):?>
							
							<tr class="even">
								<td class="ta_c"><?php echo $data->name;  ?></td>
								<td class="ta_c"><?php echo  CHtml::image(IMG_DOMAIN.DS.$data->thumbnail,$data->name,array('width'=>'232px')); ?></td>
								<td class="ta_c">￥<?php echo $data->member_price;?></td>
								<td class="ta_c">￥<?php echo $data->seller_price;?></td>
								<td class="ta_c"><?php echo $data->discount;?></td>
								<td class="ta_c"><?php echo $data->sales_volume;?></td>
								<td class="ta_c"><b class="red"><?php echo FranchiseeGoods::getStatus($data->status);?></b></td>
								<td class="ta_c">
								
									<?php if($data->status == FranchiseeGoods::STATUS_ENABLE){?>
										<a href="<?php echo Yii::app()->createUrl('/seller/franchiseeGoods/disable/',array('id'=>$data->id));?>"><?php echo Yii::t('sellerFranchiseeGoods', '下架')?></a>
									<?php } else {?>
										<a href="<?php echo Yii::app()->createUrl('/seller/franchiseeGoods/enable/',array('id'=>$data->id));?>"><?php echo Yii::t('sellerFranchiseeGoods', '上架')?></a>
									<?php }?>
									| <a href="<?php echo Yii::app()->createUrl('/seller/franchiseeGoods/update/',array('id'=>$data->id));?>"><?php echo Yii::t('sellerFranchiseeGoods', '修改')?></a>
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