<?php
$this->breadcrumbs = array(
    Yii::t('cityShow', '城市馆列表')=>array('/seller/cityshow/list'),
    Yii::t('cityShow', '城市馆商家列表')
);
$res=Cityshow::getInfoById($this->csid);
?>
<div class="toolbar">
	<b>城市馆商家列表-〉<?php echo $res->title?></b>
</div>
<?php $this->renderPartial('_storeSearch', array(
    'model' => $model,
)); ?>
<?php if($res->status==Cityshow::STATUS_PASS && $res->is_show==Cityshow::SHOW_YES):?>
<?php echo CHtml::link(Yii::t('cityShow', '添加商家'), Yii::app()->createAbsoluteUrl('seller/cityshowStore/storeAdd',array('csid'=>$this->csid)), array('class' => 'mt15 btnSellerAdd')) ?>
<?php endif;?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
						<tbody><tr>
								<th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','日期');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','GW号');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','商家名称');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','参与商品');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','操作');?></th>
							</tr>
							<?php if (!empty($cityShowStore)):?>
							<?php foreach ($cityShowStore as $k=> $v):?>
							<tr class="even">
								<td class="ta_c"><?php echo date("Y-m-d G:i:s",$v->create_time);?></td>
								<td class="ta_c"><?php echo $v->gw;?></a></td>
								<td class="ta_c"><?php echo $v->name;?></td>
								<td class="ta_c">
								 <a href="<?php echo Yii::app()->createUrl("seller/cityshowStore/goodsList", array("csid"=>$this->csid,"sid" => $v->id))?>"><?php echo isset($countArr[$v->id]) ? $countArr[$v->id]['goods_count']:0; ?></a>
								</td>
								<td class="ta_c">
								  <?php if($v->status==CityshowStore::STATUS_YES):?>
									<a href="<?php echo Yii::app()->createUrl("seller/cityshowStore/storeDel", array("csid"=>$this->csid,"sid" => $v->id,'s'=>CityshowStore::STATUS_DEL))?>"><?php echo Yii::t('cityShow', '停用')?></a>
								  <?php else:?>
								    <a href="<?php echo Yii::app()->createUrl("seller/cityshowStore/storeDel", array("csid"=>$this->csid,"sid" => $v->id,'s'=>CityshowStore::STATUS_YES))?>"><?php echo Yii::t('cityShow', '启用')?></a>
								  <?php endif;?>
								</td>
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