<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="" />
        <meta name="Description" content="" />
        <link href="<?php echo CSS_DOMAIN; ?>global.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo CSS_DOMAIN; ?>seller.css" rel="stylesheet" type="text/css" />
 </head>
   <body>
   
<div class="toolbar">
	<b>选择商品</b>
</div>
<?php $tid=$this->getParam("tid");?>
<?php $this->renderPartial('_goodsAddSearch', array(
    'model' => $model,
    'tid'=>$tid,
)); ?>
<style>
    .regm-sub{
        border:1px solid #ccc;
        background: #fff;
        padding: 5px;
        border-radius: 3px;
        cursor: pointer;
    }
</style>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/layer/layer.js"></script>
<?php $this->renderPartial('/layouts/_msg'); ?>
 <link href="<?php echo CSS_DOMAIN; ?>global.css" rel="stylesheet" type="text/css" />
 <link href="<?php echo CSS_DOMAIN; ?>seller.css" rel="stylesheet" type="text/css" />
 <input class="regm-sub" type="button" onClick="doAddGoods()" value="<?php echo Yii::t('cityShow','批量添加'); ?>">
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
						<tbody><tr>
						        <th class="bgBlack" width="5%"><input class="regm-sub" type="checkbox" id="checkAll"><?php echo Yii::t('cityShow','编号');?></th>
								<th class="bgBlack" width="5%"><?php echo Yii::t('cityShow','商品ID');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','商品分类');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','商品名称');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','商品图片');?></th>
								<th class="bgBlack" width="10%"><?php echo Yii::t('cityShow','操作');?></th>
							</tr>
							<?php if (!empty($cityShowGoods)):?>
							<?php $i=1;?>
							<?php foreach ($cityShowGoods as $k=> $v):?>
							<tr class="even">
								<td class="ta_c"><input type="checkbox" name="ids[]" value="<?php echo $v->id.'|'.$v->store_id;?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $i;?></td>
								<td class="ta_c"><?php echo $v->id;?></td>
								<td class="ta_c"><?php echo Category::getCategoryName($v->category_id);?></td>
								<td class="ta_c"><?php echo $v->name;?></td>
								<td class="ta_c"><img src="<?php echo IMG_DOMAIN . '/' . $v->thumbnail ?>" width="60" height="60"/></td>
								<td class="ta_c">
								  <a class="regm-sub" href="<?php echo Yii::app()->createUrl("seller/cityshowTheme/goodsDoAdd", array("csid"=>$this->csid,"tid"=>$tid,"gid" => $v->id,"sid"=>$v->store_id))?>"><?php echo Yii::t('cityShow', '添加')?></a>
								</td>
							</tr>
							<?php $i++;?>
							<?php endforeach;?>	
							<?php endif;?>
					</tbody></table>
					
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
<script type="text/javascript">	
$("#checkAll").click(function(){
	  var coll = $("input[name='ids[]']");
	   if ($(this).attr('checked')=='checked'){
	     for(var i = 0; i < coll.length; i++)
	       coll[i].checked = true;
	  }else{
	     for(var i = 0; i < coll.length; i++)
	       coll[i].checked = false;
	  }
 })

 //批量添加商品的动作
	 function doAddGoods(){
        var data = [];
        var url="<?php echo Yii::app()->createUrl("seller/cityshowTheme/goodsMore");?>";
        var tid=<?php echo $this->getParam("tid");?>;
        var csid=<?php echo $this->csid;?>;
        $("input[name='ids[]']").each(function() {
            if (this.checked) {
                data.push($(this).val());
            }
        });
        if (data.length > 0){
        	$.ajax({  
        		type: "POST",  
        		url: url,  
        		dataType: "json",  
        		data: {"ids[]":data,"csid":csid,"tid":tid,"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken; ?>"},  
        		success: function(data){
                  	 layer.alert(data.msg);
                  	 window.location.reload();
                 }
             })
        } else {
            alert("请选择要添加的商品!");
        }
    };
</script>
</body>

</html>