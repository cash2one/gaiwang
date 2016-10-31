<?php
// 切换加盟商视图
$this->breadcrumbs = array(
    Yii::t('sellerFranchisee', '加盟商') => array('/seller/franchisee/'),
    Yii::t('sellerFranchisee', '加盟商图片空间')
);
?>
<div class="toolbar">
	<b> <?php echo $model->name;?> <?php echo Yii::t('sellerFranchisee','的图片空间');?></b>
	<span><?php echo Yii::t('sellerFranchisee','加盟商的产品图片列表。');?></span>
</div>


<script type="text/javascript" src="/js/swf/js/artDialog.js?skin=blue"></script>
<script type="text/javascript" src="/js/swf/js/artDialog.iframeTools.js"></script>
<script type="text/javascript" src="/js/swf/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'franchisee-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>



<?php 
           $this->widget('seller.widgets.CUploadPicFull',array(
            	'form' => $form,
            	'model' => $model,
            	'attribute' => 'path',
//            	'upload_width' => 730,
//            	'upload_height' => 280,
            	'num' => 5,
            	'folder_name' => 'files',
           ));
      	?>



<?php $this->endWidget();?>

<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
	<tbody><tr>
			<th class="bgBlack ta_l" width="100%"><?php echo Yii::t('sellerFranchisee','图片列表');?></th>
		</tr>
		<tr>
			<td>
				<div class="productArr02">
					<ul class="clearfix">
					
					<?php foreach ($imgs_data as $img):?>
						<li>
							<div class="img"><img src="<?php echo IMG_DOMAIN.'/'.$img->path?>" width="100" height="100"/></div>
							<p class="name"><?php $img_pramas = explode('/', $img->path); echo array_pop($img_pramas);?></p>
						</li>
					<?php endforeach;?>
						
					</ul>
				</div>
			</td>
		</tr>
</tbody></table>
<div class="page_bottom clearfix">
	<div class="pagination">
		<?php
		  $this->widget('CLinkPager',array(   //此处Yii内置的是CLinkPager，我继承了CLinkPager并重写了相关方法
		    'header'=>'',
		    'prevPageLabel' => Yii::t('page','上一页'),
		    'nextPageLabel' => Yii::t('page','下一页'),
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