<?php
$this->breadcrumbs = array(
    Yii::t('cityShow', '城市馆管理')=>array('/seller/cityshow/list'),
    Yii::t('cityShow', '城市馆列表')
);
?>
<div class="toolbar">
	<b>城市馆列表</b>
</div>
<?php $this->renderPartial('_search', array(
    'model' => $model,
)); ?>
<style>
 .nopass {
	color: #36C;
   }
</style>
<script src="<?php echo DOMAIN ?>/js/artDialog/plugins/iframeTools.source.js" type="text/javascript"></script>
<?php echo CHtml::link(Yii::t('cityShow', '添加城市'), Yii::app()->createAbsoluteUrl('seller/cityshow/create'), array('class' => 'mt15 btnSellerAdd')) ?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
						<tbody><tr>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','日期');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','城市馆标题');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','所在区域');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','所在省份');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','所在城市');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','审核状态');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','开启状态');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','入驻商家');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','主题');?></th>
								<th class="bgBlack" width="15%"><?php echo Yii::t('cityShow','操作');?></th>
							</tr>
							<?php if (!empty($cityShow)):?>
							<?php foreach ($cityShow as $k=> $v):?>
							<tr class="even">
								<td class="ta_c"><?php echo date("Y-m-d G:i:s",$v->create_time);?></td>
								<td class="ta_c"><?php echo $v->title;?></td>
								<td class="ta_c"><?php echo CityshowRegion::getRegionName($v->region);?></td>
								<td class="ta_c"><?php echo Region::getName($v->province)?></td>
								<td class="ta_c"><?php echo Region::getName($v->city)?></td>
								<td class="ta_c"><?php echo CityShow::getStatus($v->status) ?>
								   <?php if($v->status==Cityshow::STATUS_NOPASS):?>
								     <a href="javascript:void();"  data-attr="<?php echo $v->reason;?>" class='nopass'> <?php echo Yii::t('cityShow','不通过原因');?> </a>
								   <?php endif;?>
								</td>
								<td class="ta_c"><?php echo Cityshow::getShow($v->is_show)?></td>
								<td class="ta_c">
								   <a href="<?php echo Yii::app()->createUrl("seller/cityshowStore/storeList", array("csid" => $v->id))?>"><?php echo $countArr[$v->id]['store_count'] ?></a>  
								</td>
								<td class="ta_c">
								  <a href="<?php echo Yii::app()->createUrl("seller/cityshowTheme/list", array("csid" => $v->id))?>"><?php echo $countArr[$v->id]['theme_count']?></a>
								</td>
								<td class="ta_c">
									<a href="<?php echo Yii::app()->createUrl("seller/cityshow/update", array("csid" => $v->id))?>"><?php echo Yii::t('cityShow', '编辑')?></a>&nbsp;&nbsp; 
									<a href="<?php echo Yii::app()->createUrl("seller/cityshow/delete", array("csid" => $v->id))?>" onclick="if(confirm('确定删除?')==false)return false;"><?php echo Yii::t('cityShow', '删除')?></a>&nbsp;&nbsp;
								 <?php if($v->status==Cityshow::STATUS_PASS && $v->is_show==Cityshow::SHOW_YES ):?>
									<a style="color: #36C;" data-attr='<?php echo $this->createAbsoluteUrl('/city/' . $v->encode);?>' href="javascript:void();" class="clip_button"><?php echo Yii::t('cityShow', '复制链接')?></a>
								  <?php else:?>
								     <span style="color: #808080">复制链接</span>
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
<?php Yii::app()->clientScript->registerScriptFile(DOMAIN . "/js/ZeroClipboard.js");?>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/layer/layer.js"></script>
<script type="text/javascript">
    $('.nopass').each(function(){
           $(this).click(function(){
        	   layer.open({
                   content: $(this).attr("data-attr"),
                   title:'<?php echo Yii::t('member','不通过原因') ?>'
               });
            })
        })


      $('.clip_button').each(function(){
    	  var url=$(this).attr('data-attr');
    	  var client = new ZeroClipboard($(this));
          client.on( 'ready', function(event) {
              client.on( 'copy', function(event) {
                  event.clipboardData.setData('text/plain',url);
              } );
              client.on( 'aftercopy', function(event) {
                  myArtDialog();
              } );
          } );
          client.on( 'error', function(event) {
              ZeroClipboard.destroy();
          } );
          })
 function myArtDialog(){ 	  
        art.dialog({
            icon: 'succeed',
            time: 2,
            content: '复制成功',
            height: '80px',
            width:'160px'
        });
     }
  </script>