
<?php
$res=Cityshow::getInfoById($this->csid);
$this->breadcrumbs = array(
    Yii::t('cityShow', '城市馆列表')=>array('/seller/cityshow/list'),
    Yii::t('cityShow', '城市馆-'.$res['title'].'-商家商品列表')
);
$tid=intval($this->getParam("tid"));
$nameArr=CityshowTheme::model()->findByPk($tid);

?>
<div class="toolbar">
	<b>商品列表-<?php echo $nameArr->name;?></b>
</div>
<?php $this->renderPartial('_goodsSearch', array(
    'model' => $model,
    'tid'=>$tid    
)); ?>
<?php if($res->status==Cityshow::STATUS_PASS && $res->is_show==Cityshow::SHOW_YES):?>
<a href="javascript:void()" class="mt15 btnSellerAdd" onclick="goodsIframe(this)" data-url="<?php echo Yii::app()->createAbsoluteUrl('seller/cityshowTheme/goodsAdd',array('csid'=>$this->csid,'tid'=>$tid));?>">
<?php echo Yii::t('cityShow','添加商品');?>
</a>
<div style="color: red;font-size:13px">提示：在盖象优选APP端，每个主题按照排序降序显示前6条商品信息；在PC端，显示前8条</div>
<?php endif;?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
						<tbody><tr>
								<th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','商品ID');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','排序');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','商家GW号');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','商品名称');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','商品图片');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','是否上架');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','审核状态');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','操作');?></th>
							</tr>
							<?php if (!empty($cityShowGoods)):?>
							<?php foreach ($cityShowGoods as $k=> $v):?>
							<tr class="even">
								<td class="ta_c"><?php echo $v->goods_id;?></td>
								<td class="ta_c"><?php echo $v->sort;?></a></td>
								<td class="ta_c"><?php echo $v->gw;?></td>
								<?php if($v['life']==Goods::LIFE_NO):?>
								<td class="ta_c"><?php echo $v->name;?></td>
								<?php else:?>
								<td class="ta_c" style="text-decoration: line-through"><?php echo $v->name;?></td>
								<?php endif;?>
								<td class="ta_c"><img src="<?php echo IMG_DOMAIN . '/' . $v->thumbnail ?>" width="60" height="60"/></td>
								<td class="ta_c"><?php echo Goods::publishStatus($v->publish) ?></td>
								<td class="ta_c"><?php echo Goods::getStatus($v->g_status) ?></td>
								<td class="ta_c">
								 <a href="javascript:void();" onclick="goodsUpdate(this)" data-url="<?php echo Yii::app()->createUrl("seller/cityshowTheme/goodsUpdate", array("csid"=>$this->csid,"tid"=>$tid,"gid" => $v->id))?>"><?php echo Yii::t('cityShow', '修改排序')?></a>
							     <a href="<?php echo Yii::app()->createUrl("seller/cityshowTheme/goodsDel", array("csid"=>$this->csid,'tid'=>$tid,"gid" => $v->id))?>"><?php echo Yii::t('cityShow', '删除')?></a>
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
<script src="<?php echo DOMAIN ?>/js/artDialog/plugins/iframeTools.source.js" type="text/javascript"></script>
<script>
    function goodsIframe(url){
        art.dialog.open($(url).attr('data-url'),{width:"1000px",height:"800px",title:"添加商品",lock:true,close:function(){
	    	 window.location.reload(true);
	     }});
        return false;
    }
    function goodsUpdate(url){
    	art.dialog.open($(url).attr('data-url'),
    	   {
          	  width:"700px",
          	  height:"300px",
          	  title:"商品修改排序",
          	  lock:true,
          	  close:function(){
	    	    window.location.reload(true);
	     }});
        return false;
        }
</script>