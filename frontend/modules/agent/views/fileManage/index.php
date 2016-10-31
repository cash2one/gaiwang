	<?php 
		Yii::app()->clientScript->registerCssFile(AGENT_DOMAIN."/agent/css/uploadimg.css");
	
		$cache_imgdata = Yii::app()->fileCache->get(FileManageAgent::FILE_NAME.$this->getUser()->getId());		//读取会员缓存数据
		$i = 0;
		$cache_html = "";
		if(!empty($cache_imgdata)){		//对于上传的缓存数据，我们保存上传图片的名称、路径、分类
			$upload_dir = Yii::getPathOfAlias('uploads');
			foreach ($cache_imgdata as $key=>$val){
				if($model->width!=0&&$model->height!=0){
					if($val['width']*$model->height != $model->width*$val['height'])continue;		//解决这边上传和那边上传不尺寸不同
				}
				$i++;
				$cache_html.="<li onclick='choose(this)'>";
				$cache_html.="<a href='javascript:;'><img src='".$val['path']."' height='100px' width='100px'/></a>";
				$cache_html.="<input type='hidden' value='".$val['filename']."|".$val['randnum']."|".$val['localpath']."' />";
				$cache_html.="</li>";
			}
		}
		$cache_over = $i>5?"overflow-X:auto;":"";			//左右滚动条 
		$cache_height = $i>0?"height:110px;":"";
	?>
	<style>
		*{margin:0; padding:0;}
		li{list-style:none;}
		img{border:none;}
		body {overflow:hidden;}
		em,i{font-style:normal;}
		a{text-decoration:none;}
		/* 图片显示*/
		.imgListBox{ width:560px; height:450px; margin:5px auto 0 auto; border:1px solid #ccc; }
		/*缓存图片*/
		.list{ position:relative; left:0; top:0; width:560px; <?php echo $cache_height?><?php echo $cache_over?>}
		.list li{ width:110px; height:110px; float:left; margin:1px; text-align:center; overflow:hidden; }
		.list li a{ display:block; margin:5px; height:100px; background:url("<?php echo AGENT_DOMAIN?>/agent/images/bg_thumb.jpg") center center no-repeat; }
		.list li img{ align:center; box-shadow:2px 2px 3px rgba(0,0,0,0.3); opacity:.7; filter:alpha(opacity:70); }
		.list li a:hover img{ opacity:1; filter:alpha(opacity:100); }
		/*查询图片*/
		.items li{ width:110px; height:110px; float:left; margin:1px; text-align:center; overflow:hidden; }
		.items li a{ display:block; margin:5px; height:100px; background:url("<?php echo AGENT_DOMAIN?>/agent/images/bg_thumb.jpg") center center no-repeat; }
		.items li img{ align:center; box-shadow:2px 2px 3px rgba(0,0,0,0.3); opacity:.7; filter:alpha(opacity:70); }
		.items li a:hover img { opacity:1; filter:alpha(opacity:100); }
		/*选中图片*/
		.imghover{ background: red; }
		/*分页样式*/
		.gt-pager li.jump { left: 10px; position: relative; }
		.img_gt-summary{ }
		/*滚动样式*/
		.overdiv{overflow-X:auto;}
		/*高度样式*/
		.heightdiv{height:110px;}
	</style>
	<div id=con>
		<!-- 标签名称 -->
		<ul id=tags>
			<li class=selectTag><a onClick="selectTag('tagContent0',this)" href="javascript:void(0)">图片空间</a> </li>
		  	<li><a onClick="selectTag('tagContent1',this)" href="javascript:void(0)">添加图片</a> </li>
		</ul>
		<!-- 标签内容 -->
		<div id=tagContent>
			<div class="tagContent selectTag" id=tagContent0>
					<?php $this->renderPartial('_search',array(
				    'model'=>$model,
				));?>
				<div class="imgListBox" id="thumbnails">
					<ul class="list">
						<?php echo $cache_html?>
					</ul>
					<div style="clear:both"></div>
					<?php
						//图片集，以及查询显示的地方 
						$this->widget('application.modules.agent.widgets.ListView', array(
							'dataProvider'=>$model->search(),
							'itemView'=>'_view',
							'id' => 'filemanage_list',
							'summaryCssClass' => 'img_gt_summary',
							'pager'=> array(
								'class'=>'application.modules.agent.widgets.LinkPager',
								'maxButtonCount' => 5
							)
						)); 
					?>
				</div>
			</div>
			<div class="tagContent" id=tagContent1>
				<?php
					$this->renderPartial('create',
						array(
							'model'=>$model,
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
</script>