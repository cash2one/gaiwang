<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
.list{ height:auto; }
</style>
	<?php 
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl."/agent/js/swf/css/uploadimg.css");
		//取出所有图片
//		$cache_imgdata = Yii::app()->fileCache->get(FranchiseeUploadController::FILE_NAME.$this->getUser()->getId());		//读取会员缓存数据
		$imgs = $img_model->searchAll()->getData();
//		var_dump($imgs);
		
		$i = 0;
		$cache_html = "";
		if(!empty($imgs)){		//对于上传的缓存数据，我们保存上传图片的名称、路径、分类
			foreach ($imgs as $key=>$val){
				$i++;
				$cache_html.="<li onclick='choose(this)' imgid='{$val->id}'>";
				$cache_html.="<a href='javascript:;'><img src='".IMG_DOMAIN.'/'.$val['path']."' height='100px' width='100px'/></a>";

				$cache_html.="</li>";
			}
		}
		$cache_over = $i>5?"overflow-X:auto;":"";			//左右滚动条 
		$cache_height = $i>0?"height:110px;":"";
	?>
	<style>
		/*缓存图片*/
		.list{ position:relative; left:0; top:0; width:560px; height:700px; <?php echo $cache_height?><?php echo $cache_over?>}
	</style>
	<div id=con>
		<!-- 标签名称 -->
		<ul id=tags>
			<li class=selectTag><a onClick="selectTag('tagContent0',this)" href="javascript:void(0)"><?php echo Yii::t('sellerFranchiseeUpload', '图片空间');?></a> </li>
		  	<li><a onClick="selectTag('tagContent1',this)" href="javascript:void(0)"><?php echo Yii::t('sellerFranchiseeUpload', '添加图片');?></a> </li>
		</ul>
		<!-- 标签内容 -->
		<div id=tagContent>
			<div class="tagContent selectTag" id=tagContent0>
				<div class="imgListBox" id="thumbnails">
					<ul class="list" style="height:420px;">
						<?php echo $cache_html?>
					</ul>
				</div>
				
				<div class="aui_buttons" style="padding:10px;"><a href="javascript:;" style="font-size:14px;" onclick="delImg()" ><?php echo Yii::t('sellerFranchiseeUpload', '删除图片');?></a></div>
				
			</div>
			<div class="tagContent" id=tagContent1>
				<?php
					$this->renderPartial('create',
						array(
							'height'=>$height,
							'width'=>$width,
							'img_format'=>$img_format,
							'folder_name'=>$folder_name,
						)
					);
				?>
			</div>
		</div>
	</div>

<script type=text/javascript>
	//切换标签
	function selectTag(showContent,selfObj){
		// 标签
		var tag = document.getElementById("tags").getElementsByTagName("li");
		var taglength = tag.length;
		for(i=0; i<taglength; i++){
			tag[i].className = "";
		}
		selfObj.parentNode.className = "selectTag";
		// 标签内容
		for(i=0; j=document.getElementById("tagContent"+i); i++){
			j.style.display = "none";
		}
		document.getElementById(showContent).style.display = "block";
	}

	//点击图片
	function choose(obj){
		$(obj).hasClass('imghover')?$(obj).removeClass('imghover'):$(obj).addClass('imghover');
	}


	/**
	 * 删除传递图片
	 */
	function delImg(){
		var ids = '0';
		$("li[class='imghover']").each(function(i){
			ids += ','+$(this).attr('imgid');
		});


		$.getJSON("<?php echo $this->createUrl('/seller/franchiseeUpload/del');?>?ids="+ids, function(data){
			if(data.state=='success'){
				location.reload();
			}	  
		});
			

		
		
	}


	
</script>