<?php
// 切换加盟商视图
$this->breadcrumbs = array(
    Yii::t('partnerAgent', '商家列表')=>array('/seller/partnerAgent/list'),
    Yii::t('partnerAgent', '销售额记录')
);
?>
<div class="toolbar">

	<b>月销售额历史记录</b>
	<a class="mt15 btnSellerEditor" href="javascript:void()" onclick="exportExcel()"><?php echo Yii::t('middleAgent','导出EXCEL');?></a>
</div>

<div class="toolbar" style="width: 100%">
	历史累计共 <span style="color: red;font-size:20px;font-weight:bold"><?php echo $count;?></span>个月，总销售额 <span style="color: red;font-size:20px;font-weight:bold"><?php echo $allAcount;?></span> 元
</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
						<tbody><tr>
								<th class="bgBlack" width="15%"><?php echo Yii::t('partnerAgent','月份');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('partnerAgent','订单数');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('partnerAgent','销售额（元）');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('partnerAgent','操作');?></th>
							</tr>
							<?php foreach ($accounList as $k=> $v):?>
							<tr class="even">
								<td class="ta_c a_left"><?php echo substr($v->months,0,4).'年'.substr($v->months,-2,2).'月';?></a> 
								<?php if($k==0):?><span class="a_TJ">统计到：<?php echo date("Y-m-d",strtotime('-1 days',time()));?></span><?php endif;?>
								</td>
								
							    <td class="ta_c"><?php echo $v->orderCount;?></td>
								<td class="ta_c">￥<?php echo $v->account;?></td>
								<td class="ta_c"><a href="<?php echo Yii::app()->createUrl("seller/partnerAgent/accountDay", array('id'=>$this->getParam('id'),'m' => $v->months))?>">日销售额详情</a></td>
							</tr>
						   <?php endforeach;?>
					</tbody></table>
					
<div class="page_bottom clearfix">			
	<!-- 导出execl表 -->
    <?php 
            $this->renderPartial('/layouts/_export', array(
                    'exportPages' => $exportPages,
            ));
    ?>