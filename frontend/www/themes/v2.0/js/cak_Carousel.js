$(document).ready(function(){
	var num=$('.brend-month-03_span span').length;
	var i_mun=0;
	var timer_banner=null;

	$('.cak_brend-month-03-menu li:gt(0)').hide();//页面加载隐藏所有的li 除了第一个
	
//底下小图标点击切换
	$('.brend-month-03_span span').click(function(){
		$(this).addClass('brend-month-03_span_one')
			   .siblings('span').removeClass('brend-month-03_span_one');
		var i_mun1=$('.brend-month-03_span span').index(this);
		$('.cak_brend-month-03-menu li').eq(i_mun1).fadeIn('slow')
			                   .siblings('li').fadeOut('slow');

		i_mun=i_mun1;
	});
   //自动播放函数
	function bannerMoveks(){
		timer_banner=setInterval(function(){
			move_banner()
		},5000)
	};
	bannerMoveks();//开始自动播放

	//鼠标移动到banner上时停止播放
	$('.brend-month-03').mouseover(function(){
		clearInterval(timer_banner);
	});

	//鼠标离开 banner 开启定时播放
	$('.brend-month-03').mouseout(function(){
		bannerMoveks();
	});
//banner 点击执行函数
   function move_banner(){
			if(i_mun==num-1){
				i_mun=-1
			}
			//大图切换
			$('.cak_brend-month-03-menu li').eq(i_mun+1).fadeIn('slow')
									   .siblings('li').fadeOut('slow');
			//小图切换
			$('.brend-month-03_span span').eq(i_mun+1).addClass('brend-month-03_span_one')
					   .siblings('span').removeClass('brend-month-03_span_one');

			i_mun++
		}
})















