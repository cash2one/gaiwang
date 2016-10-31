<div id="_imgshow<?php echo $id?>" class="_uploadimgListBox">
	<ul class="_uploadList">
		<?php
			$count = 0;							//初始化有多少显示图片
			if(!empty($imgpath)){
				foreach ($imgpath as $key=>$val){//循环显示已经存在的图片
					$i = rand();
					if (is_array($val)){		//如果是数组，则表示是2维数组
						$count+=count($val); 
						foreach ($val as $key2=>$val2){
							echo "<li onmouseover='showDelImg(\"delimg".$i."\")' onmouseout='hideDelImg(\"delimg".$i."\")'>
							<img id='delimg".$i."' class='delimg' src='".Yii::app()->baseUrl."/images/cross_circle.png' title='删除图片' onclick='delImgByPath(this,\"".$i."\",\"".$id."\")'/>
							<a class='imga' href='".Tool::urlImageForUploads($val2['path'])."' onclick='return _showBigPic(this)' ><img src='".Tool::urlImageForUploads($val2['path'],'100','100')."' style='width:100px;height:100px;'/></a>
							</li>";
							$i++;
						}
					}else{//反之为1维数组
						echo "<li onmouseover='showDelImg(\"delimg".$i."\")' onmouseout='hideDelImg(\"delimg".$i."\")'>
						<div style='position:relative;'>
						<img id='delimg".$i."' class='delimg' src='".Yii::app()->baseUrl."/images/cross_circle.png' title='删除图片' onclick='delImgByPath(this,\"".$i."\",\"".$id."\")'/>
						<a class='imga' href='".Tool::urlImageForUploads($imgpath['path'])."'  onclick='return _showBigPic(this)' ><img src='".Tool::urlImageForUploads($imgpath['path'],'100','100')."' style='width:100px;height:100px;'/></a>
						</div></li>";
						break;
						$count++; 
					}
					$i++;
				}
			}else if(!empty($imgData)){
				$data = array();
				foreach ($imgData as $key=>$val){
					$data[$val['id']]=$val['path'];
				}
				$forData = explode(",",$imgid);
				$count = count($forData);
				foreach ($forData as $key=>$val){//循环显示已经存在的图片
					$i = rand();
					echo "<li onmouseover='showDelImg(\"delimg".$val.$i."\")' onmouseout='hideDelImg(\"delimg".$val.$i."\")'>
					<div style='position:relative;'>
					<img id='delimg".$val.$i."' class='delimg' src='".Yii::app()->baseUrl."/images/cross_circle.png' title='删除图片' onclick='delImgById(this,\"".$val."\",\"".$id."\")'/>
					<a class='imga' href='".Tool::urlImageForUploads("$data[$val]")."'  onclick='return _showBigPic(this)' ><img src='".Tool::urlImageForUploads("$data[$val]",'100','100')."' style='width:100px;height:100px;'/></a>
					</div></li>";
				}
			}
			$count = $count==0?1:$count;
		?>
	</ul>
</div>
<?php if ($id==''){//如果没有填写id，那么就自己创建一个默认id的隐藏文本控件来保存选择的图片在表中对应的主键。如果传递了，就直接更改传递的id所对应的控件的值?>
<input type="hidden" id="<?php echo FileManage::VALUE_NAME?>" />
<?php }?>
<input type="button" class='button_06' value="<?php echo Yii::t('Public', '上传图片')?>" 
onclick="_fileUpload('<?php echo Yii::app()->createUrl('/agent/filemanage/index',array('classify'=>$classify,'height'=>$height,'width'=>$width))?>',<?php echo $num?>,'<?php echo Yii::app()->createUrl('agent/filemanage/sure')?>','<?php echo $id==''?FileManage::VALUE_NAME:$id?>','<?php echo Yii::app()->request->csrfToken?>')" />
<script>
$(function(){
	$('#_imgshow<?php echo $id?>').css("width","<?php echo $count>9?"1170px":($count*130)."px";?>");
	$('#_imgshow<?php echo $id?>').css("height","<?php echo $count>9?(ceil($count/9)*120)."px":"120px";?>");
});
</script>