<?php
$this->breadcrumbs = array(
    Yii::t('middleAgent', '合作伙伴列表')=>array('/seller/middleAgent/partner'),
    Yii::t('middleAgent', '合作伙伴的商家列表')=>array('/seller/middleAgent/partnerList')
);
$pid=$this->getParam('id');
?>
<div class="toolbar">
	<b>合作伙伴的商家列表</b>
	<a class="mt15 btnSellerEditor" href="javascript:void()" onclick="exportExcel()"><?php echo Yii::t('middleAgent','导出EXCEL');?></a>
</div>

<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
						<tbody><tr>
								<th class="bgBlack" width="10%"><?php echo Yii::t('middleAgent','商家编号');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('middleAgent','商家名称');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('middleAgent','开店时间');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('middleAgent','店铺状态');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('middleAgent','经营类目');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('middleAgent','月销售额（元）');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('middleAgent','操作');?></th>
							</tr>
							<?php foreach ($partnerAgent as $k=> $v):?>
							<tr class="even">
								<td class="ta_c"><?php echo $v->username;?></td>
								<td class="ta_c"><?php echo $v->name;?></td>
								<td class="ta_c"><?php echo date("Y-m-d G:i:s",$v->create_time);?></td>
								<td class="ta_c"><?php echo Store::status($v->status)?></td>
								<td class="ta_c"><?php echo $v->category_id?></td>
								<td class="ta_c">￥<?php echo (!empty($account[$v->id])) ? $account[$v->id]  : 0 ?>（<?php echo date('Y-m');?>）</td>
								<td class="ta_c">
									<a href="<?php echo Yii::app()->createUrl("seller/middleAgent/detail", array('id' => $v->id))?>"><?php echo Yii::t('middleAgent', '商家详情')?></a><br /> 
									<a href="<?php echo Yii::app()->createUrl("seller/middleAgent/mouthAccount", array('id' => $v->id))?>"><?php echo Yii::t('middleAgent', '销售额记录')?></a><br />
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

<!-- 导出execl表 -->
<div  id="export-all" class="pager" style="display:none;">
        <?php if ($exportPages->getItemCount() > 0): ?>
        <div class="pager">
            （每份<?php echo $exportPages->pageSize; ?>条记录）:
            <?php
            $this->widget('CLinkPager', array(
                'pages' => $exportPages,
                'cssFile' => false,
                'maxButtonCount' => 10000,
                'header' => false,
                'prevPageLabel' => false,
                'nextPageLabel' => false,
                'firstPageLabel' => false,
                'lastPageLabel' => false,
            ))
            ?>  
                <a href="<?php echo Yii::app()->createAbsoluteUrl('/seller/'.$exportPages->route, $exportPages->params) ?>" ><?php echo Yii::t('main', '导出全部') ?></a>
        </div>
        <?php else: ?>
            <?php echo Yii::t('main','没有数据') ?>
        <?php endif; ?>
    </div>
</div>
<script type="text/javascript"  src="/js/iframeTools.source.js"></script>
<script type="text/javascript">
    function exportExcel() {
        art.dialog({
            content: $("#export-all").html(),
            title: '<?php echo Yii::t('main', '导出excel(该窗口在3秒后自动关闭)') ?>',
            time: 3
        }); 
    } 
   </script> 