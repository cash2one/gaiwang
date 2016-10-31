	$(function(){
				/*店铺广告轮播*/
			    $('.shop-banner').flexslider({
				    slideshowSpeed: 5000,
				    animationSpeed: 400, 
				    directionNav: true
				});
				//店铺广告轮播左右按钮显示、隐藏
				$(".shop-banner").hover(function(){
					$(this).find(".flex-direction-nav").show();
					},function(){
						$(this).find(".flex-direction-nav").hide();
					});
				//鼠标滑过商品效果
				$(".shop-hotGoods2 li").hover(function(){
					$(this).addClass("selLi");
				},function(){
					$(this).removeClass("selLi");
				});
				
			})