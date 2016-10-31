/**
 * jsonp 获取购物车信息，网站右上角并设置相关显示
 */
function getCartInfo() {
    $.ajax({
        url:commonVar.loadCartUrl,
        contentType: "application/json; charset=utf-8;",
        dataType:'jsonp',
        jsonp:"jsonpCallback",
        jsonpCallback:"setCartCallback",
        success:function(data){
            //$(".gx-top-shopping-num").html(data.num);
            //$(".gx-FDShopping-num").html(data.num);
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
}

function setCartCallback(data){
	$(".gx-top-shopping-num").html(data.num);
    $(".gx-FDShopping-num").html(data.num);
}

//删除购物车
function deleteCart(store_id, spec_id, goods_id) {
    $.ajax({
        url:commonVar.deleteCartUrl,
        dataType:'jsonp',
        jsonp:"jsonpCallback",
        jsonpCallback:"delCartCallback",
        data:{store_id:store_id, spec_id:spec_id, goods_id:goods_id},
        success:function(data){
            //if(!data.done) console.log(data);
            //getCartInfo();
        }
    });
}

function delCartCallback(data){
	getCartInfo();
}

//添加到购物车
function addCart(gid, sid){
    $.ajax({
        url:commonVar.addCartUrl,
        dataType:'jsonp',
        jsonp:"jsoncallBack",
        jsonpCallback:"activeJump",
        data:{quantity:1, spec_id:sid, goods_id:gid},
        success:function(data){
            if(data.error) alert(data.error);
		}
    });
}

/**参加活动的商品,直接跳转到商品详情页,不加入购物车了*/
function activeJump(data){
	if(data.url){
	    window.location.href = data.url;	
	}else if(data.login){
		window.location.href = data.login;
	}
}

setTimeout('getCartInfo()',2000);
/*$(document).ready(function () {
    //过一秒多再去请求购物车信息，不然页面有图片不存在，会报错
    setTimeout('getCartInfo()',2000);
});*/