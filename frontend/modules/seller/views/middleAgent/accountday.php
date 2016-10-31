<?php
$this->breadcrumbs = array(
    Yii::t('middleAgent', '月销售额列表')=>array('/seller/middleAgent/mouthAccount'),
    Yii::t('middleAgent', '日销售额记录')
);
$m=$this->getParam('m');
$id=$this->getParam('id');
?>
<div class="toolbar">
	<b>日销售额历史记录</b>
	<a class="mt15 btnSellerEditor" href="javascript:void()" onclick="exportExcel()"><?php echo Yii::t('middleAgent','导出EXCEL');?></a>
</div> 
<div class="toolbar" style="width: 100%">
	<span style="color: red;font-size:16px;font-weight:bold"><?php echo substr($m,0,4).'年'.substr($m,-2,2).'月';?></span>，
	     总销售额 <span style="color: red;font-size:20px;font-weight:bold"><?php echo $total_price?></span> 元，     
</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
						<tbody><tr>
								<th class="bgBlack" width="10%"><?php echo Yii::t('middleAgent','日期');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('middleAgent','订单数');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('middleAgent','销售额（元）');?></th>
							</tr>
							<?php foreach ($accounDayList as $k=> $v):?>
							<tr class="even">
								<td class="ta_c"><?php echo $v['date'];?></td>
							    <td class="ta_c"><?php echo $v['num'];?></td>
								<td class="ta_c"><?php echo $v['total_price'];?></td>
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