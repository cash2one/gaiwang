$(function(){
	/*头部广告隐藏start*/
	$(".clear-top-but").click(function(){
		$(".top-advert").slideToggle();
	});
	/*头部广告隐藏end*/
	
	//商家详情
	$(".shopInfo-content").hover(function(){
		$(".shopInfo-float").show();
	},function(){
		$(".shopInfo-float").hide();
	});
	//手机逛店
	$(".shopInfo-phone").hover(function(){
		$(".shopInfo-phone-float").show();
	},function(){
		$(".shopInfo-phone-float").hide();
	});
	//提示框关闭
	$(".prompt-float-close,.prompt-float-but").click(function(){
		$(".prompt-float,.pordShareBg").hide();
	});

	//选择商品参数
	$(".prod-property li").click(function(){
		$(this).parents(".prod-property").find("li").removeClass("prod-propertyLI");
		$(this).parents(".prod-property").find("ico").hide();
		$(this).addClass("prod-propertyLI");
		$(this).find("ico").show();
		//是否选择全部商品参数
		var selLength=$(".prod-property").find(".prod-propertyLI").length;//选中的项的数
		var totalLength=$(".prod-property").length;//实际应该选项数
		if(selLength==totalLength){//全选确定按钮为可点击
			$(".pord-Okbut").css("background","#c20005");
			}
	});
	$(".pord-Okbut").click(function(){
		if(ISPordshoppingCart=="1"){
			$(".shoppingCart-float").show();
		}else{
		    closeSpecClass();	
		}
	});
	$(".shoppingCart-float .title img").click(function(){
		$(".shoppingCart-float").hide();
	});
	$(".pordShare .title img").click(function(){
		$(".pordShare,.pordShareBg").hide();
	});

	//分享浮动窗口
	$(".gl-prodDispla-share").click(function(){
		//$(".pordShare,.pordShareBg").show();
		$('.bshare-sinaminiblog').get(0).click();
	});
	
	//关闭未选择商品参数提示
	$(".pordParameter-ts span").click(function(){
		$("#pordParameter").removeClass("pordParameterSel");
		$(".pord-but").show();
		$(".pordParameter-ts").hide();
		$("#pord-Okbut").hide();
	});
	
	//店内分类
	$(".shopInfo-nav-list li").click(function(){
		$(this).find(".shopInfo-nav-float").toggle();
		if($(this).attr("tag")==1){
			$(this).addClass("shopInfo-nav-listSelLi");
			$(this).attr("tag","2")
		}else{
			$(this).removeClass("shopInfo-nav-listSelLi");
			$(this).attr("tag","1")
		}
	});

	//手机下单
	$(".phone-order").hover(function(){
		$(".phone-order-erwBig").show();
	},function(){
		$(".phone-order-erwBig").hide();
	});

	//评价排序按钮
	$(".pdTab2-tab-but").click(function(){
		if($(this).attr("tag")=="1"){
			$(this).attr("tag","2");
			$(this).addClass("pdTab2-tab-butSel");
		}else{
			$(this).attr("tag","1");
			$(this).removeClass("pdTab2-tab-butSel");
		}
		
		if($(this).attr('id') == 'orderTime'){$('#clickTab').val(1);}else{$('#clickTab').val(2);}
		if($('#com1').hasClass('curr') == true){
		    $('#com1').click();	
		}else if($('#com2').hasClass('curr') == true){
		    $('#com2').click();		
		}
	});
	
	//用户晒的图片放大、缩小
	$('#tabCon_com_1,#tabCon_com_2').delegate(".pdTab2-ImgShow ul li img","click",function(){
		$(this).parents(".pdTab2-ImgShow").find(".pdTab2-ImgShow-float").attr("src","");
		$(this).parents(".pdTab2-ImgShow").find(".pdTab2-ImgShow-float").find("img").attr("src",$(this).attr("src"));
		$(this).parents(".pdTab2-ImgShow").find(".pdTab2-ImgShow-float").show();
    }); 
	$('#tabCon_com_1,#tabCon_com_2').delegate(".pdTab2-ImgShow-float","click",function(){
		$(this).hide();
	});
	
	/**点赞按钮*/
	$('#tabCon_com_1,#tabCon_com_2').delegate(".clickVote","click",function(){  
		var rel = $(this).next().attr('rel');
		doVote(rel);
	});

	//收货地址选择
	$(".gst-address-info").click(function(){
		$(".gst-address-list").show();
	});
	$(".gst-address-list").hover(function(){
		$(".gst-address-list").show();
	},function(){
		$(".gst-address-list").hide();
		$(".gst-address-lower").find("ul").empty("li");
		$(".gst-address-list li a").removeClass("gst-address-listSel");
	});
    
	//鼠标移上去城市变红色
	$(".gst-address-info a").hover(function(){
		$(this).css('color','#F00');
	});
	$(".gst-address-info a").mouseout(function(){
		$(this).css('color','#000');
	});
	$(".gst-address-lower").on('mouseover', 'a', function(){
	    $(this).css('color','#F00');
	});
	$(".gst-address-lower").on('mouseout', 'a', function(){
	    $(this).css('color','#FFF');
	});
});

//点击规格确定按钮的时候关闭提示框
function closeSpecClass(){
	$("#pordParameter").removeClass("pordParameterSel");
	$(".pord-but").show();
	$(".pordParameter-ts").hide();
	$("#pord-Okbut").hide();
}

//收货地选择
function addAddress(obj){
	$(".gst-address-list li a").removeClass("gst-address-listSel");
	$(obj).addClass("gst-address-listSel");
	$(".gst-address-list").find(".gst-address-lower").find("ul").empty("li");
	var liItem = allCity[obj.id];
	
	$(obj).parents("li").nextAll(".gst-address-lower").eq(0).find("ul").append(liItem);
}

//窗口滚动浮动菜单显示和隐藏
$(function(){
   $(window).scroll(function(){  
	 var vtop=$(document).scrollTop();
	 if(vtop>1000){
		 $(".pordDisplay-floatNav").show();
		 }else{
			 $(".pordDisplay-floatNav").hide();
			 }
	})
});

function pdTabclick(){
	$(document).scrollTop("800");
}

$(function(){ 
	var page=1;
	var picNum=$(".pic_lists ul li").length;
	var page_count=parseInt(picNum/4);
	var contentWh=$(".pic_content").css("width");

	$(".right_btn").click(function(){
		if(page_count>=page){
			$(".pic_lists").animate({left:'-'+(parseInt(page)*parseInt(contentWh))+"px"},"normal");
			page++;
		} 
	});
	
	$(".left_btn").click(function(){
		if(page>1){
			var zWidth=parseInt($(".pic_lists").css("left"))+parseInt(contentWh);
			$(".pic_lists").animate({left:zWidth+'px'},"normal");
			page--;
		}
	});
});
//<!-- 图片左右滚动end -->

//---------图片放大和小图左右切换效果start
//详情页图片放大
function preview2(img){
	$("#preview .jqzoom img").attr("src",$(img).attr("src"));
	$("#preview .jqzoom img").attr("jqimg",$(img).attr("bimg"));
}

/*处理收藏*/
function dealCollect(data){
	if(data.success == true){
		if($('.shop-collect').attr("tag")=="0" && data.type == 1){
			$('.shop-collect').addClass("shop-collectSel");
			$('.shop-collect').attr("tag","1");
		}
		if($('.gl-prodDispla-collect').attr("tag")=="0" && data.type == 2){
			$('.gl-prodDispla-collect').addClass('gl-prodDispla-collectSel');
			$('.gl-prodDispla-collect').attr("tag","1");
		}
	}
	$('.prompt-info2').text(data.msg);
	$(".prompt-float,.pordShareBg").show();
}

$(function(){
	$(".jqzoom").jqueryzoom({xzoom:420,yzoom:419});
});

//图片预览小图移动效果,页面加载时触发
$(function(){
	var tempLength = 0; //临时变量,当前移动的长度
	var viewNum = 5; //设置每次显示图片的个数量
	var moveNum = 1; //每次移动的数量
	var moveTime = 300; //移动速度,毫秒
	var scrollDiv = $(".spec-scroll .items ul"); //进行移动动画的容器
	var scrollItems = $(".spec-scroll .items ul li"); //移动容器里的集合
	var moveLength = scrollItems.eq(0).width() * moveNum; //计算每次移动的长度
	var countLength = (scrollItems.length - viewNum) * scrollItems.eq(0).width(); //计算总长度,总个数*单个长度
	  
	//下一张
	$(".spec-scroll .next").bind("click",function(){
		if(tempLength < countLength){
			if((countLength - tempLength) > moveLength){
				scrollDiv.animate({left:"-=" + moveLength + "px"}, moveTime);
				tempLength += moveLength;
			}else{
				scrollDiv.animate({left:"-=" + (countLength - tempLength) + "px"}, moveTime);
				tempLength += (countLength - tempLength);
			}
		}
	});
	//上一张
	$(".spec-scroll .prev").bind("click",function(){
		if(tempLength > 0){
			if(tempLength > moveLength){
				scrollDiv.animate({left: "+=" + moveLength + "px"}, moveTime);
				tempLength -= moveLength;
			}else{
				scrollDiv.animate({left: "+=" + tempLength + "px"}, moveTime);
				tempLength = 0;
			}
		}
	});
});
//---------------图片放大和小图左右切换效果end
