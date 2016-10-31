<?php
// 切换加盟商视图
$this->breadcrumbs = array(
    Yii::t('sellerFranchisee', '加盟商') => array('/seller/franchisee/'),
    Yii::t('sellerFranchisee', '盖网机列表')
);
?>
<div class="toolbar">
	<b> <?php echo $model->name;?> <?php echo Yii::t('sellerFranchisee','的盖网机列表');?></b>
	<span><?php echo Yii::t('sellerFranchisee','盖网通使用数量及位置。');?></span>
</div>

<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
						<tbody><tr>
								<th class="bgBlack" width="20%"><?php echo Yii::t('sellerFranchisee','名称');?></th>
								<th class="bgBlack" width="30%"><?php echo Yii::t('sellerFranchisee','状态');?></th>
								<th class="bgBlack" width="30%"><?php echo Yii::t('sellerFranchisee','所在地区');?></th>
								<th class="bgBlack" width="20%"><?php echo Yii::t('sellerFranchisee','操作');?></th>
							</tr>
							
							<?php foreach ($machine_data as $data):?>
							
							<tr class="even">
								<td class="ta_c"><?php echo $data->name;  ?></td>
								<td class="ta_c"><b class="red"><?php echo Machine::getMachinestatus($data->status);?></b></td>
								<td class="ta_c"><?php echo Region::getName($data->province_id,$data->city_id,$data->district_id)?></td>
								<td class="ta_c">
								
									<a href="<?php echo Yii::app()->createUrl('/seller/franchisee/machineConsumptionRecord/',array('mid'=>$data->id));?>"><?php echo Yii::t('sellerFranchisee', '查看消费')?></a>
									| <a href="<?php echo Yii::app()->createUrl('/seller/franchisee/machineSigninRecord/',array('mid'=>$data->id));?>"><?php echo Yii::t('sellerFranchisee', '签到记录')?></a>
									| <a href="<?php echo Yii::app()->createUrl('/seller/franchisee/machineRegistrationRecord/',array('mid'=>$data->id));?>"><?php echo Yii::t('sellerFranchisee', '注册记录 ')?></a>
									
									
									
									<!-- 
									<?php if ($data->status==1):?>
									<a href="<?php echo Yii::app()->createUrl('/seller/franchisee/machineStop/',array('id'=>$data->id));?>" class="sellerBtn03"   ><span>停用</span></a>
									<?php else:?>
									<a href="<?php echo Yii::app()->createUrl('/seller/franchisee/machineRun/',array('id'=>$data->id));?>" class="sellerBtn03"   ><span>启用</span></a>
									<?php endif;?>
								 	-->
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