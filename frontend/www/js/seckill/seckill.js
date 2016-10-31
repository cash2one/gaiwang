$(function(){
	//应节性活动页面鼠标选中商品显示效果
	$(".hd_list ul li").hover(function(){
		$(this).find(".hd_item_fd").toggle();
	},function(){
		$(this).find(".hd_item_fd").toggle();
	});
});