<?php

$getLevel=$this->getParam('l');
$lid=$this->getParam('lid');
$name=MiddleAgent::getStoreNameByLid($lid);

  $dhbanner=array(Yii::t('middleAgent', '商家居间管理')=>array('/seller/middleAgent/list'));
  $str=MiddleAgent::getLevel($getLevel)."居间商--";
if($getLevel==MiddleAgent::LEVEL_THREE){
    $str.=$name.'--'.Yii::t('middleAgent', '直招商家列表');
    array_push($dhbanner, $str);
 }else{
     $str.=$name.'--'.Yii::t('middleAgent', '所有商家列表');
    array_push($dhbanner, $str);
 }
$this->breadcrumbs =  $dhbanner;

$datetime=strtotime(date('Y-m'));
//季度第一天
//$jdFirstDay=strtotime(date('Y-m-d', mktime(0,0,0,date('n')-(date('n')-1)%3,1,date('Y'))));
$dateEnd =strtotime('-1 days',strtotime(date('Y-m-d 23:59:59')));
?>
 
<div class="toolbar">
<!--	<a class="mt15 btnSellerEditor" href="javascript:void()" onclick="exportExcel()"><?php echo Yii::t('middleAgent','导出EXCEL');?></a>
	 -->
	</div>	
<div class="gateAssistant mt15 clearfix">
  <b class="black"><?php echo Yii::t('sellerOrder', '所在位置'); ?>：</b>  
  <b class="black"> <?php echo $str;?></b>
</div>
	

<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
						<tbody><tr>
								<th class="bgBlack" width="5%"><?php echo Yii::t('middleAgent','商家编号');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('middleAgent','商家名称');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('middleAgent','添加时间');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('middleAgent','店铺状态');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('middleAgent','销售额');?></th>
								<?php if($getLevel==2):?>
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
							    <?php if($getLevel==2):?>
							    <td class="ta_c" width="5%">
							      <?php if($v->level==MiddleAgent::LEVEL_PARTNER): echo "直招"?>    
							      <?php else:?>
							         <?php $num=MiddleAgent::getMiddleNum($v->id,MiddleAgent::LEVEL_PARTNER);?>
							         <?php if(empty($num)):?>
							                <?php echo $num;?>
							             <?php else:?>
        							         <a href="<?php echo Yii::app()->createUrl("seller/middleAgent/partner", array("lid" => $v->id,"l"=>MiddleAgent::LEVEL_THREE))?>">
        								       <?php echo $num;?>
        								     </a>
    								     <?php endif;?>
							      <?php endif;?>
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