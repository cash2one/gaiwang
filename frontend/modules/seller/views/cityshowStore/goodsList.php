<?php
$res=Cityshow::getInfoById($this->csid,'title');
$this->breadcrumbs = array(
    Yii::t('cityShow', '城市馆管理')=>array('/seller/cityshow/list'),
    Yii::t('cityShow', '城市馆-'.$res['title'].'-商家商品列表')
);
$sid=$this->getParam("sid");
$name=CityshowStore::getStoreNameBySid($sid);
?>
<div class="toolbar">
	<b><?php echo $name;?>-商品列表</b>
</div>
<?php $this->renderPartial('_goodsSearch', array(
    'model' => $model,
    'sid'=>$sid
)); ?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
						<tbody><tr>
								<th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','商品ID');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','排序');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','商家GW号');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','商品名称');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','商品图片');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','是否上架');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','审核状态');?></th>
							</tr>
							<?php if (!empty($cityShowGoods)):?>
							<?php foreach ($cityShowGoods as $k=> $v):?>
							<tr class="even">
								<td class="ta_c"><?php echo $v->goods_id;?></td>
								<td class="ta_c"><?php echo $v->sort;?></a></td>
								<td class="ta_c"><?php echo $v->gw;?></td>
								<?php if($v['life']==Goods::LIFE_NO):?>
								<td class="ta_c"><?php echo $v->name;?></td>
								<?php else:?>
								<td class="ta_c" style="text-decoration: line-through"><?php echo $v->name;?></td>
								<?php endif;?>
								<td class="ta_c"><img src="<?php echo IMG_DOMAIN . '/' . $v->thumbnail ?>" width="60" height="60"/></td>
								<td class="ta_c"><?php echo Goods::publishStatus($v->publish) ?></td>
								<td class="ta_c"><?php echo Goods::getStatus($v->g_status) ?></td>
							</tr>
							<?php endforeach;?>	
							<?php endif;?>
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