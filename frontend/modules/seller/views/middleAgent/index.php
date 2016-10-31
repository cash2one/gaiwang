<?php
// 切换加盟商视图
$this->breadcrumbs = array(
    Yii::t('middleAgent', '商城居间管理')=>array('/seller/middleAgent/list'),
    Yii::t('middleAgent', '商家列表')=>array('/seller/middleAgent/list')
);
$CookieLevel=$this->getCookie('levelNum');
$getLevel=$this->getParam('l');

$datetime=strtotime(date('Y-m'));
//季度第一天
//$jdFirstDay=strtotime(date('Y-m-d', mktime(0,0,0,date('n')-(date('n')-1)%3,1,date('Y'))));
?>

<div class="toolbar">
   <?php if($getLevel==MiddleAgent::LEVEL_THREE):?>
	<b>三级商家列表</b>
   <?php elseif($getLevel==MiddleAgent::LEVEL_TWO):?>
	<b>二级商家列表</b>
	<?php else:?>
    <b>直招商家列表</b>
   <?php endif;?>
     <!--<a href="<?php echo Yii::app()->createUrl("seller/middleAgent/other")?>">
	 <?php echo "另一种方式";?>
	</a>
	<a class="mt15 btnSellerEditor" href="javascript:void()" onclick="exportExcel()"><?php echo Yii::t('middleAgent','导出EXCEL');?></a>
	-->
	</div>	
<div class="gateAssistant mt15 clearfix">
 <b class="black"><?php echo Yii::t('sellerOrder', '导航助手'); ?>：</b>
   <?php if($CookieLevel>0 && $CookieLevel<=MiddleAgent::LEVEL_THREE):?>
    <a href="<?php echo Yii::app()->createUrl("seller/middleAgent/list", array("l"=>MiddleAgent::LEVEL_PARTNER))?>" class="sellerBtn02">
        <span <?php if(empty($getLevel)):?> style="color: #c90000" <?php endif;?>><?php echo Yii::t('sellerOrder', '直招商家'); ?>(<?php echo MiddleAgent::getMiddleNum($this->midLevId,0); ?>)</span>
    </a>
    <?php endif;?>
    <?php if($CookieLevel==MiddleAgent::LEVEL_ONE):?>
    <a href="<?php echo Yii::app()->createUrl("seller/middleAgent/list", array("l"=>MiddleAgent::LEVEL_TWO))?>" class="sellerBtn02">
        <span <?php if($getLevel==MiddleAgent::LEVEL_TWO):?> style="color: #c90000" <?php endif;?>><?php echo Yii::t('sellerOrder', '二级居间商'); ?>(<?php echo MiddleAgent::getMiddleNum($this->midLevId,2); ?>)</span>
    </a>
    <?php endif;?>
    <?php if($CookieLevel>0 && $CookieLevel<=MiddleAgent::LEVEL_TWO):?>
     <a href="<?php echo Yii::app()->createUrl("seller/middleAgent/list", array("l"=>MiddleAgent::LEVEL_THREE))?>" class="sellerBtn02">
        <span <?php if($getLevel==MiddleAgent::LEVEL_THREE):?> style="color: #c90000" <?php endif;?>><?php echo Yii::t('sellerOrder', '三级居间商'); ?>(<?php echo MiddleAgent::getMiddleNum($this->midLevId,3); ?>)</span>
    </a>
    <?php endif;?>
</div>
	

<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
						<tbody><tr>
								<th class="bgBlack" width="5%"><?php echo Yii::t('middleAgent','商家编号');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('middleAgent','商家名称');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('middleAgent','添加时间');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('middleAgent','店铺状态');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('middleAgent','销售额');?></th>
								<?php if($getLevel==2 || $getLevel==3):?>
								<th class="bgBlack" width="5%"><?php echo Yii::t('middleAgent','所招商家');?></th>
							    <?php endif;?>
							</tr>
							<?php if(!empty($agentList)):?>
							<?php foreach ($agentList as $k=> $v):?>
							<tr class="even">
								<td class="ta_c"><?php echo substr_replace($v->gai_number, '****', 3,5);?></td>
								<td class="ta_c"><a href="<?php echo Yii::app()->createUrl("shop/view", array("id" => $v->store_id))?>" target="_blank"><?php echo $v->username;?></a></td>
								<td class="ta_c"><?php echo date("Y-m-d H:i:s",$v->create_time)?></td>
								<td class="ta_c"><?php echo Store::status($v->status)?></td>
								<td class="ta_c"><?php echo HtmlHelper::formatPrice('');?><?php echo Store::getAcount($v->sid,strtotime(date('Y-m')),strtotime('-1 days',strtotime(date('Y-m-d 23:59:59')))) ?>（<?php echo date('Y-m');?>）</td>
							    <?php if($getLevel==2 || $getLevel==3):?>
							    <td class="ta_c" width="5%">
							    <a href="<?php echo Yii::app()->createUrl("seller/middleAgent/partner", array("lid" => $v->id,"l"=>$getLevel))?>">
								 <?php echo MiddleAgent::getMiddleNum($v->id);?>
								</a>
								</td>
							    <?php endif;?>
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
	<!-- 导出execl表 -->
    <?php 
             $this->renderPartial('/layouts/_export', array(
                    'exportPages' => $exportPages,
            )); 
    ?>