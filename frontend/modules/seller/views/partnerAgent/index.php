<?php
// 切换加盟商视图
$this->breadcrumbs = array(
    Yii::t('partnerAgent', '商家绑定管理')=>array('/seller/partnerAgent/list'),
    Yii::t('partnerAgent', '商家列表')=>array('/seller/partnerAgent/list')
);
?>
<div class="toolbar">
	<b>商家列表</b>
	<a class="mt15 btnSellerEditor" href="javascript:void()" onclick="exportExcel()"><?php echo Yii::t('sellerFranchiseeGoods','导出EXCEL');?></a>
</div>

<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
						<tbody><tr>
								<th class="bgBlack" width="5%"><?php echo Yii::t('partnerAgent','商家编号');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('partnerAgent','商家名称');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('partnerAgent','开店时间');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('partnerAgent','店铺状态');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('partnerAgent','开店模式');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('partnerAgent','经营类目');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('partnerAgent','月销售额（元）');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('partnerAgent','操作');?></th>
							</tr>
							<?php foreach ($agentList as $k=> $v):?>
							<tr class="even">
								<td class="ta_c"><?php echo $v->username;?></td>
								<td class="ta_c"><a href="<?php echo Yii::app()->createUrl("shop/view", array("id" => $v->id))?>" target="_blank"><?php echo $v->name;?></a></td>
								<td class="ta_c"><?php echo date("Y-m-d G:i:s",$v->create_time);?></td>
								<td class="ta_c"><?php echo Store::status($v->status)?></td>
								<td class="ta_c"><?php echo Store::getMode($v->mode)?></td>
								<td class="ta_c"><?php echo (!empty($v->category_id)) ? $v->category_id  : '/' ?></td>
								<td class="ta_c">￥<?php echo (!empty($account[$v->id])) ? $account[$v->id]  : '0.00' ?>（<?php echo date('Y-m');?>）</td>
								<td class="ta_c">
									<a href="<?php echo Yii::app()->createUrl("seller/partnerAgent/detail", array("id" => $v->id))?>"><?php echo Yii::t('partnerAgent', '商家详情')?></a><br /> 
									<a href="<?php echo Yii::app()->createUrl("seller/partnerAgent/mouthAccount", array("id" => $v->id))?>"><?php echo Yii::t('partnerAgent', '销售额记录')?></a>
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
	<!-- 导出execl表 -->
    <?php 
            $this->renderPartial('/layouts/_export', array(
                    'exportPages' => $exportPages,
            ));
    ?>