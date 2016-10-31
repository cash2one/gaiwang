/**
 * 一些js公共方法
 * lng：经度
 * lat：纬度
 * type：适用类型
 * cityname：默认显示城市
 * level：地图等级
 * url：访问地址
 * api：地图api
 */
//显示地图
function _showMap(lng,lat,type,cityname,level,url,api){
	if(type=='use'){
		if(lng==''||lat==''){
			alert('请提经度控件和纬度控件的id');
			return false;
		}

		var lngval = $('#'+lng).val();
		var latval = $('#'+lat).val();
		var sCityname = $('#'+cityname).val()==undefined?"广州":$('#'+cityname).val();
		url = createUrl(url, {lng:lngval,lat:latval,api:api,cityname:encodeURIComponent(sCityname)});
		
	}else{
		var lngval = lng;														
		var latval = lat;
		var sCityname = $('#'+cityname).val()==undefined?"广州":$('#'+cityname).val();
		url = createUrl(url, {lng:lngval,lat:latval,api:api,cityname:encodeURIComponent(sCityname),level:level});
	}

	art.dialog.open(url,{
		title: "盖机地图坐标(当前坐标："+lngval+","+latval+")",
		lock: true,
		width: 740,
		height: 630,
		init:function(){},
		ok:function(){
			var iframe = this.iframe.contentWindow;
			if(!iframe.document.body){
				alert("iframe还没有加载完毕!");
				return false;
			}

			if(type=='use'){
				var newLng = iframe.document.getElementById('lng').value;		//经度
				var newLat = iframe.document.getElementById('lat').value;		//纬度
	
				$('#'+lng).val(newLng);		//赋新值
				$('#'+lat).val(newLat);		//赋新值
			}
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
	for(var i=0;i<newId.length;i++){
		if(i==num&&!isDel){
			isDel = true;
			continue;
		}
		newVal+= newId[i]+",";
	}
	
	$('#'+id).val(newVal.substring(0,newVal.length-1));
	
	$('#_imgshow'+id).find("ul").find('li').each(function(i){
		$(this).find('.delimg').onclick="delImgByPath(this,'"+i+"','+id+')";
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
		newVal+= newId[i]+",";
	}
	
	$('#'+id).val(newVal.substring(0,newVal.length-1));
}

/**
 * 公用删除图片
 */
function publicDelImg(obj,id){
	$(obj).parent().parent().remove();		
	
	var exists_num = $('#_imgshow'+id).find("ul").find('li').length;
	if(exists_num<9){
		if(exists_num!=0){
			var width = $('#_imgshow'+id).width()-130;
			$('#_imgshow'+id).css("width",width+"px");
		}
	}
	if(exists_num==9){
		$('#_imgshow'+id).css("width","1170px");
		$('#_imgshow'+id).css("height","120px");
	}
	if(exists_num>9){
		var height = Math.ceil((exists_num)/9)*120;
		$('#_imgshow'+id).css("height",height+"px");
	}
	
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
	
//	if(route.slice(-1)!=urlFormat) route = route+urlFormat;	
        if(route.slice(-1)==urlFormat){
            route = substr(0,length(route)-1);
        }

        var i = 1;
	for(var key in param)
	{
            if(i>1){
                route += "&"+key+"="+param[key];
            }else{
                route += "?"+key+"="+param[key];
            }
		i++;
	}
	return route;
}




/**
 * 全选
 */
function doChooseAll(obj,className){
	var checked = obj.checked == true?true:false;
	obj.checked = checked;
	$('.'+ className).find("input[type='checkbox']").attr("checked",checked);
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

/**
 * 点击查看显示pdf预览
 * @param obj
 * @private
 */
function _showContract(obj){
	var url = $(obj).attr("href");
	var str = '<div style="display: none;" id="confirmAreaPdf">';
	str += '<p>如果你的pdf没有正常显示<a href="'+url+'">' ;
	str += '请点击这里下载预览</a></p>';
	str += '<div id="myPdfDiv"></div></div>';
	$('body').append(str);
	var myPDF = new PDFObject({
		url: url,
		id: "myPDF",
		width: "800px",
		height: "560px",
		pdfOpenParams: {
			navpanes: 1,
			statusbar: 0,
			view: "FitH",
			pagemode: "thumbs"
		}
	}).embed("myPdfDiv");
	art.dialog({
		content: $('#confirmAreaPdf').html(),
		width: "800px",
		height: "560px",
		lock:true,
		ok:function(){}
	});
	return false;
}

/**
 * 电子化签约用的上传合同预览
 * @param obj
 * @param url
 * @param hiddenId
 * @param modelId
 * @param callbackfun
 */
function uploadContract(obj,url,hiddenId,modelId,callbackfun){
	obj = $(obj);//DOM对象转为jquery对象
	art.dialog.open(url,{
		title: "上传合同",
		lock: true,
		width: 400,
		height: 200,
		init:function(){},
		ok:function(){
			var iframe = this.iframe.contentWindow;
			if(!iframe.document.body){
				alert("iframe还没有加载完毕!");
				return false;
			}
			var errorInfo = $(iframe.document.getElementById('errorInfo')).val();
			if(errorInfo == 0){
				//删除取消的PDF
				var deleteVal = $('#'+hiddenId).val();			//要删除的图片的id
				var indexOf = hiddenId.indexOf('_');
				var length = hiddenId.length;
				var model = hiddenId.substr(0,indexOf);
				var field = hiddenId.substr(indexOf+1,length);

				$.ajax({
					type: 'GET',
					dataType: 'json',
					url: createUrl('/offlineUpload/deleteFile'),
					data: {id: deleteVal,model:model,field:field,modelId:modelId},
					success: function(data) {}
				});
				var pdfUrl = $(iframe.document.getElementById('urlInfo')).val();
				var newFileName = $(iframe.document.getElementById('newFileName')).val();
				var oldFileName = $(iframe.document.getElementById('oldFileName')).val();

				var nextArr = obj.nextAll();//取得兄弟节点
				for(i=0;i<nextArr.length;i++){
					nextArr[i] = $(nextArr[i]);
					//隐藏域表单，用于入库
					if(nextArr[i].attr('type') == 'hidden'){
						nextArr[i].attr('value',newFileName);
					}
				}
				$('#showPdf').text('查看');
				//显示上传的文件名
				$('#pdfName').text(oldFileName);
				$('#dowloandPdf').attr('href',pdfUrl);

				var myPDF = new PDFObject({
					url: pdfUrl,
					id: "myPDF",
					width: "1000px",
					height: "760px",
					pdfOpenParams: {
						navpanes: 1,
						statusbar: 0,
						view: "FitH",
						pagemode: "thumbs"
					}
				}).embed("myPdfDiv");

				//给查看按钮绑定点击事件
				$('#showPdf').click(function(){
					art.dialog({
						width: 800,
						height: 560,
						okVal: '确定',
						content: $("#confirmArea").html(),
						lock: true,
						cancel: true,
						ok: function () {
						}
					})
				});
			}

			if(callbackfun){
				callbackfun();
			}
		},
		cancel:function(){}
	});
}


/**
 * 上传附件图片预览
 * @param obj 当前对象
 * @param url 控制器url
 * @param hiddenId 隐藏表单id
 * @param modelId	当前模型id
 * @param callbackfun 回调
 */
function uploadAnnexPicture(obj,url,hiddenId,modelId,callbackfun,num){
    obj = $(obj);//DOM对象转为jquery对象
    art.dialog.open(url,{
        title: "上传图片",
        lock: true,
        width: 400,
        height: 200,
        init:function(){},
        ok:function(){
            var iframe = this.iframe.contentWindow;
            if(!iframe.document.body){
                alert("iframe还没有加载完毕!");
                return false;
            }
            var errorInfo = $(iframe.document.getElementById('errorInfo')).val();
            if(errorInfo == 0){
                //删除取消的图片
                var deleteVal = $('#'+hiddenId).val();			//要删除的图片的id
                var indexOf = hiddenId.indexOf('_');
                var length = hiddenId.length;
                var model = hiddenId.substr(0,indexOf);
                var field = hiddenId.substr(indexOf+1,length);

                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: createUrl('/offlineUpload/deleteFile'),
                    data: {id: deleteVal,model:model,field:field,modelId:modelId},
                    success: function(data) {}
                });

                var imgUrl = $(iframe.document.getElementById('urlInfo')).val();
                var newFileName = $(iframe.document.getElementById('newFileName')).val();
                var oldFileName = $(iframe.document.getElementById('oldFileName')).val();
                var nextArr = obj.nextAll();//取得兄弟节点
                for(i=0;i<nextArr.length;i++){
                    nextArr[i] = $(nextArr[i]);
                    //隐藏域表单，用于入库
                    if(nextArr[i].attr('type') == 'hidden'){
                        nextArr[i].attr('value',newFileName);
                    }
                }
                $('#showImg'+num).text('查看');
                //显示上传的文件名
                $('#imgName'+num).text(oldFileName);
                //给查看按钮绑定点击事件
                $('#showImg'+num).click(function(){
                    return _showBigPic(this);
                });
                $('#showImg'+num).attr('href',imgUrl);
                for(i=0;i<nextArr.length;i++){
                    nextArr[i] = $(nextArr[i]);
                    //隐藏域表单，用于入库
                    if(nextArr[i].attr('type') == 'hidden'){
                        nextArr[i].attr('value',newFileName);
                    }
                    //用于显示上传的文件
                    if(nextArr[i].attr('class') == 'prc-line'){
                        nextArr[i].html(oldFileName);
                    }
                    //用于预览
                    if(nextArr[i].attr('class') =='fl'){
                        nextArr[i].click(function(){
                            return _showBigPic(this);
                        });
                        nextArr[i].attr('href',imgUrl);
                    }
                }
            }

            if(callbackfun){
                callbackfun();
            }
        },
        cancel:function(){}
    });
}

/**
 * 电子化签约用的上传图片预览
 * @param obj 当前对象
 * @param url 控制器url
 * @param hiddenId 隐藏表单id
 * @param modelId	当前模型id
 * @param callbackfun 回调
 */
function uploadPicture(obj,url,hiddenId,modelId,callbackfun){
	obj = $(obj);//DOM对象转为jquery对象
	art.dialog.open(url,{
		title: "上传图片",
		lock: true,
		width: 400,
		height: 200,
		init:function(){},
		ok:function(){
			var iframe = this.iframe.contentWindow;
			if(!iframe.document.body){
				alert("iframe还没有加载完毕!");
				return false;
			}
			var errorInfo = $(iframe.document.getElementById('errorInfo')).val();
			if(errorInfo == 0){
				//删除取消的图片
				var deleteVal = $('#'+hiddenId).val();			//要删除的图片的id
				var indexOf = hiddenId.indexOf('_');
				var length = hiddenId.length;
				var model = hiddenId.substr(0,indexOf);
				var field = hiddenId.substr(indexOf+1,length);

				$.ajax({
					type: 'GET',
					dataType: 'json',
					url: createUrl('/offlineUpload/deleteFile'),
					data: {id: deleteVal,model:model,field:field,modelId:modelId},
					success: function(data) {}
				});

				var imgUrl = $(iframe.document.getElementById('urlInfo')).val();
				var newFileName = $(iframe.document.getElementById('newFileName')).val();
				var oldFileName = $(iframe.document.getElementById('oldFileName')).val();
				var nextArr = obj.nextAll();//取得兄弟节点
				for(i=0;i<nextArr.length;i++){
					nextArr[i] = $(nextArr[i]);
					//隐藏域表单，用于入库
					if(nextArr[i].attr('type') == 'hidden'){
						nextArr[i].attr('value',newFileName);
					}
					//用于显示上传的文件
					if(nextArr[i].attr('class') == 'prc-line'){
						nextArr[i].html(oldFileName);
					}
					//用于预览
					if(nextArr[i].attr('class') =='fl'){
						nextArr[i].click(function(){
							return _showBigPic(this);
						});
						nextArr[i].attr('href',imgUrl);
					}
				}
			}

			if(callbackfun){
				callbackfun();
			}
		},
		cancel:function(){}
	});
}