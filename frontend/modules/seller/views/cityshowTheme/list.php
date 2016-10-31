<?php
$this->breadcrumbs = array(
    Yii::t('cityShow', '城市馆列表')=>array('/seller/cityshow/list'),
    Yii::t('cityShow', '主题列表')
);
$id=$this->csid;
$res=Cityshow::getInfoById($this->csid);
?>
<div class="toolbar">
	<b>主题列表-〉<?php echo $res->title?></b>
</div>
<?php $this->renderPartial('_search', array(
    'model' => $model,
)); ?>
<?php if($this->themeNum < 5 && $res->is_show==Cityshow::SHOW_YES):?>
<?php echo CHtml::link(Yii::t('cityShow', '添加主题'), Yii::app()->createAbsoluteUrl('seller/cityshowTheme/create',array("csid" =>$id)), array('class' => 'mt15 btnSellerAdd')) ?>
<?php endif;?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
						<tbody><tr>
						        <th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','排序');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','日期');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','所在城市馆');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','主题');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','参与商品');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','操作');?></th>
							</tr>
							<?php if (!empty($cityShowTheme)):?>
							<?php foreach ($cityShowTheme as $k=> $v):?>
							<tr class="even">
								<td class="ta_c"><?php echo $v->sort;?></td>
								<td class="ta_c"><?php echo date("Y-m-d G:i:s",$v->create_time);?></td>
								<td class="ta_c"><?php echo $v->title;?></td>
								<td class="ta_c"><?php echo $v->name;?></td>
								<td class="ta_c">
								 <a href="<?php echo Yii::app()->createUrl("seller/cityshowTheme/goodsList", array("csid"=>$this->csid,"tid" => $v->id))?>"><?php echo isset($countArr[$v->id]) ? $countArr[$v->id]['goods_count'] : 0;?></a>		  
								</td>
								<td class="ta_c">
									<a  href="javascript:void();"  onclick="goodsUpdate(this)" data-url="<?php echo Yii::app()->createUrl("seller/cityshowTheme/update", array("csid"=>$this->csid,"tid" => $v->id))?>"><?php echo Yii::t('partnerAgent', '编辑')?></a>&nbsp;&nbsp;
									<a  href="<?php echo Yii::app()->createUrl("seller/cityshowTheme/delete", array("csid"=>$this->csid,"tid" => $v->id))?>"><?php echo Yii::t('cityShow', '删除')?></a>
								</td>
							</tr>
							<?php endforeach;?>	
							<?php endif;?>
					</tbody></table>				
<div class="page_bottom clearfix">
	<div class="pagination">
		<?php
		  $this->widget('CLinkPager',array(
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
<script src="<?php echo DOMAIN ?>/js/artDialog/plugins/iframeTools.source.js" type="text/javascript"></script>
<script>
    function goodsUpdate(url){
    	art.dialog.open($(url).attr('data-url'),
    	    	{
	    	     width:"700px",
	    	     height:"200px",
	    	     title:"编辑城市馆主题",
	    	     lock:true,
	    	     close:function(){
	    	    	 window.location.reload(true);
		    	     }
	    	     });
        return false;
        }
</script>