
//监听浏览器
$( document).ready(function() {
	
  function barH() {
	var bodyWidth = $(document).width();
	var bodyHeight = $(document).height();
	var banrW=$('.banr').width(); 
    var temp= $('.banr').is(":hidden");
	var BodyW=bodyWidth-banrW-3;
	//设置主体宽度
	  $('.banr').height(bodyHeight-5);
      $('#dBody,#dCtxFrame').height(bodyHeight-5);
	  if(temp){ 
	        $('#dBody,#dCtxFrame').width(bodyWidth);
	    }else{
	       $('#dBody,#dCtxFrame').width(BodyW);
	  }
	 
    
	//设置隐藏按钮位置
	var btn=bodyHeight/2;
	$('.banr i,.btnzx').animate({ top:btn},500);
	//隐藏侧栏
	$('.banr i').click(function() {
		       $(this).hide();
		       $('.banr').animate({left:-banrW,opacity:0}).hide();
			   $('.btnzx').animate({left:0,opacity:1}).show();
			   $('#dBody,#dCtxFrame').width(bodyWidth);
		});
    //显示菜单
	 $('.btnzx').click(function() {
		      $(this).animate({left:-banrW,opacity:0}).hide();
              $('.banr').animate({left:0,opacity:1});
			  $('.banr,.banr i').show();
			  $('#dBody,#dCtxFrame').width(bodyWidth-banrW-2);
  	});
     }


  //左边菜单;
  $("#navcon .name:first").next('ul').show();
  $("#navcon .name").click(function () {
              $(this).addClass("hover").siblings().removeClass("hover")
			  $(this).next('ul').slideDown().siblings('ul').slideUp();
          });
		  
		   $("#navcon li").click(function () {
              $(this).addClass("hover").siblings().removeClass("hover");
  });
  
  
  var ap=new barH();
  $(window).resize(function(){
	   var ap=new barH();
  });	
});


//操作iframe
    function AdminApp() {
	this.openUrl = function (aUrl) {
		if (!aUrl || $.trim(aUrl) == '') return;
		$('#dCtxFrame').attr('src', aUrl);
	};
}
var app = new AdminApp();
$(window).resize(function () {
	var app = new AdminApp();
	});

	
	
