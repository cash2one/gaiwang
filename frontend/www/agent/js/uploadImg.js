/**
 * 上传图片
 * @param openUrl 	访问图片地址
 * @param picNum  	选择多少个图片
 * @param uploadUrl	上传地址
 * @param oid		保存图片id的控件id
 * @param csrfToken	crsf验证码
 * @param classify	图片类型
 */
function _fileUpload(openUrl,uploadUrl,picNum,oid,csrfToken,imgarea){
	art.dialog.open(openUrl,{
		title:'图片管理',
		lock:true,
		//在open方法中，init会等待iframe加载完毕后执行
		init:function(){//可以再这个地方写窗体加载之后的事件
		},
		ok:function(){
			var iframe = this.iframe.contentWindow;
			if(!iframe.document.body){
				alert('iframe还没有加载完毕');
				return false;
			};

			//获取选中图片，如果选中的是临时图片则需要传送数据图片本来的名称，图片类别，图片临时路径。如果是已有图片需传送图片路径及图片id
			var imgsData = '';			//总的数据综合			
			//var imgfile_paths = '';		//选中的图片路径集合
			var dataid = new Array();			//保存图片的在数据库中对应的ID
			var imgHtml = new Array();			//保存图片创建HTML文本
			var num = picNum;	//允许选择个图片的个数
			var cache_num = 0;
			$(iframe.document.getElementById('thumbnails')).find('li').each(function(){
				if($(this).hasClass('imghover')){//如果图片被选中
					if($(this).find('img')[0].id==""){//表示选中的是临时图片
						var name_class = $(this).find('input[type=hidden]')[0].value.split("|");
						imgsData+= $(this).find('img')[0].src+",";				//图片显示路径
						imgsData+= name_class[0]+",";							//图片本来的名称
						imgsData+= name_class[1]+",";							//缓存随机数
						imgsData+= name_class[2]+"||";							//本地路径
//						imgsData+= $(this).find('img')[0].src+","+name_class[0]+","+name_class[1]+",'',''||";
					}else{//已经上传的图片，有完整路径有略缩图路径
						//图片显示路径路径,图片id,保存到图片表里面的数据
						imgsData+= $(this).find('img')[0].src+","+$(this).find('img')[0].id.substring(1)+","+$(this).find('img')[0].alt+"||";
					}
					cache_num++;
				}
			});

			if(num>0){
				if(cache_num>num){
					alert('只能选择'+num+'个图片!');
					return false;
				}
			}
			
			if(imgsData.length>0){		//如果有数据就将数据上传
				var html = "";
				jQuery.ajax({
					type:"post",async:false,dataType:"json",timeout:5000,
					url:uploadUrl,
					data:"imgdata="+encodeURIComponent(imgsData)+"&YII_CSRF_TOKEN="+csrfToken,
					error:function(request,status,error){
						alert(request.responseText);
					},
					success:function(data){
						var randnum;
						for(var i=0;i<data.length;i++){
							randnum = Math.ceil(Math.random()*1000);
							dataid.push(data[i]['id']);
							
							html = "<div class='imgbox'>"; 
							html+= "<div class='w_upload'>";
							html+= "<a href='javascript:;' onclick='delImgById(this,\""+data[i]['id']+"\",\""+oid+"\")' class='item_close'>删除</a>";
							html+= "<span class='item_box'>";
							html+= "<a class='imga' href='"+data[i]['realpath']+"' onclick='return _showBigPic(this)' >";
							html+= "<img src='"+data[i]['realpath']+"' class='imgThumb' />";
							html+= "</a>";
							html+= "</span>";
							html+= "</div>";
							html+= "</div>";
							
							imgHtml.push(html);
						}
					}
				});
			}
			if(dataid.length>0){
				var exists_num = $('#_imgshow'+oid).find('.item_close').length;
				var choose_num = imgHtml.length;
				
				if(exists_num+choose_num>num){
					$('#'+oid).val('');
					$('#_imgshow'+oid).html('');
				}
				
				for(var i=0;i<choose_num;i++){
					$('#'+oid).val()==""?$('#'+oid).val(dataid[i]):$('#'+oid).val($('#'+oid).val()+"|"+dataid[i]);
					$('#_imgshow'+oid).append(imgHtml[i]);
				}
//				var exists_num1 = $('#_imgshow'+oid).find("ul").find('li').length;
				
//				if(exists_num1<9){
//					var width = exists_num1*130;
//					$('#_imgshow'+oid).css("width",width+"px");
//					$('#_imgshow'+oid).css("height","120px");
//				}
//				if(exists_num1==9){
//					$('#_imgshow'+oid).css("width","390px");
//					$('#_imgshow'+oid).css("height","120px");
//				}
//				if(exists_num1>9){
//					var height = Math.ceil((exists_num1)/9)*120;
//					$('#_imgshow'+oid).css("height",height+"px");
//				}
			}
			//$('#_imgshow'+oid).show();
		},
		cancel:true
	});
}

/**
 * 显示上传删除图片
 * @param delid
 */
function showDelImg(delid){
	$('#'+delid).addClass("showdelimg");
}

/**
 * 隐藏上传删除图片
 * @param delid
 */
function hideDelImg(delid){
	$('#'+delid).removeClass("showdelimg");
}

/**
 * 兼容原来直接传递上传图片path显示图片的删除图片的方法
 * @param obj	删除的图片对象
 * @param num	删除的第几个图片
 * @param id	保存数据的id
 */
function delImgByPath(obj,num,id){
	var newId = publicDelImg(obj,id);
	var newVal = '';
	var isDel = false;
	for(var i=0;i<newId.length;i++){			//循环，重新拼接新的结果集
		if(i==num&&!isDel){						//当找到当前删除图片值得时候，并且没有进行删除则改变删除状态，进入下一次删除
			isDel = true;
			continue;
		}
		newVal+= newId[i]+"|";
	}
	
	$('#'+id).val(newVal.substring(0,newVal.length-1));
	
	var i=0;
	$('#_imgshow'+id).find(".item_close").each(function(){
		$(this).onclick="delImgByPath(this,"+i+",'+id+')";
		i++;
	});
}

/**
 * 删除传递图片id显示图片的方法
 * @param obj	删除的图片对象
 * @param colid	删除的图片id
 * @param id	保存数据的id
 */
function delImgById(obj,colid,id){
	var newId = publicDelImg(obj,id);
	
	var newVal = '';
	var isDel = false;
	for(var i=0;i<newId.length;i++){
		if(newId[i]==colid&&!isDel){
			isDel = true;
			continue;
		}
		newVal+= newId[i]+"|";
	}
	
	$('#'+id).val(newVal.substring(0,newVal.length-1));
}

/**
 * 公用删除图片
 */
function publicDelImg(obj,id){
	$(obj).parent().parent().remove();		
	
//	var exists_num = $('#_imgshow'+id).find("ul").find('li').length;
//	if(exists_num<9){
//		if(exists_num!=0){
//			var width = $('#_imgshow'+id).width()-130;
//			$('#_imgshow'+id).css("width",width+"px");
//		}
//	}
//	if(exists_num==9){
//		$('#_imgshow'+id).css("width","1170px");
//		$('#_imgshow'+id).css("height","120px");
//	}
//	if(exists_num>9){
//		var height = Math.ceil((exists_num)/9)*120;
//		$('#_imgshow'+id).css("height",height+"px");
//	}
	
	var oldVal = $('#'+id).val();
	
	if(oldVal.indexOf(",")>=0){
		var newId = oldVal.split(",");
	}else if(oldVal.indexOf("|")>=0){
		var newId = oldVal.split("|");
	}else{
		var newId = oldVal.split(";");
	}
	return newId;
}

/*
 * 生成url的js方法
 */
function createUrl(route, param)
{
	var urlFormat = "/";
	if(route.slice(-1)!=urlFormat) route = route+urlFormat;	
	for(var key in param)
	{
		route += key+urlFormat+param[key]+urlFormat;
	}
	return route;
}

/**
 * 点击图片显示放大图
 * @param obj 链接对象
 */
function _showBigPic(obj)
{
	$.fancybox({
		href: $(obj).attr("href"),
		'overlayShow'	: true,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	});
	return false;
}