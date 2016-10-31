<div class="ImgList" id="_imgshow<?php echo get_class($model).'_'.$attribute?>">
	<?php 
		if(count($imgData)>0){
			foreach($imgData as $key=>$val){
	?>
	<div class="imgbox"> 
		<div class="w_upload">
			<a href="javascript:;" onclick="delImgById(this,'<?php echo $val['id']?>','<?php echo get_class($model).'_'.$attribute?>')" class="item_close"><?php echo Yii::t('Public','删除')?></a>
			<span class="item_box">
				<a class='imga' href='<?php echo GT_IMG_DOMAIN.str_replace("uploads/", "", $val['path'])?>' onclick='return _showBigPic(this)' >
					<img src="<?php echo GT_IMG_DOMAIN.str_replace("uploads/", "", $val['path'])?>" class="imgThumb" />
				</a>
			</span>
		</div>
	</div>
	<?php 
			}
		}
	?>
</div>
<?php echo $form->hiddenField($model,$attribute);//保存数据的隐藏控件，图片分割是使用符号|?>
<?php 
	$userid = Yii::app()->getUser()->getId();
	echo CHtml::button(Yii::t('Public','上传图片'),array(
			"class"=>"button_06",
			"onclick"=>"_fileUpload('".Yii::app()->createUrl('agent/FileManage/index',array('height'=>$height,'width'=>$width,'classify'=>$classify))."','".Yii::app()->createUrl('agent/FileManage/sure',array('classify'=>$classify))."',$num,'".get_class($model)."_".$attribute."','".Yii::app()->request->csrfToken."')",
		)
	)
?>
