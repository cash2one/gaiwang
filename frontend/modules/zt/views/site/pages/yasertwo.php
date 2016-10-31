<style type="text/css">
	/*=====
	    @Date:2014-07-09
	    @content:雅诗雪沁专题
		@author:林聪毅
	 =====*/
	.zt-wrap{width:100%; background:#fff;}
	.zt-con { width:968px; margin:0 auto; position:relative; }
	.zt-con a{ position:absolute;display:block;}
	.yaser-01{height:1048px; background:url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/yaser-01.jpg) top center no-repeat;}
	.yaser-02{height:1048px; background:url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/yaser-02.jpg) top center no-repeat;}
	.yaser-03{height:1048px; background:url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/yaser-03.jpg) top center no-repeat;}
	.yaser-04{height:1048px; background:url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/yaser-04.jpg) top center no-repeat;}


	.yaser-01 .opa{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/opacity-1.png) no-repeat; width: 886px; height: 819px; 
		position: absolute; top: 40px; left: 0px; opacity: 0; filter:alpha(opacity:0); 
	}
	.yaser-01 .moveUp{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/moveUp-1.png) no-repeat; width: 703px; height: 352px;
		position: absolute; top: 900px; left: 100px; opacity: 0; filter:alpha(opacity:0);  
	}
	.yaser-01 .moveLeft{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/moveLeft-1.png) no-repeat; width: 169px; height: 50px;
		position: absolute; top: 230px; left: 1100px; opacity: 0; filter:alpha(opacity:0); 
	}
	.yaser-02 .opa{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/opacity-2.png) no-repeat; width: 517px; height: 517px; 
		position: absolute; top: 340px; left: 0px; opacity: 0; filter:alpha(opacity:0); 
	}
	.yaser-02 .moveRight{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/moveRight-2.png) no-repeat; width: 567px; height: 75px;
		position: absolute; top: 180px; left: -800px; opacity: 0; filter:alpha(opacity:0); 
	}
	.yaser-02 .moveUp{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/moveUp-2.png) no-repeat; width: 422px; height: 151px;
		position: absolute; top: 940px; left: 660px; opacity: 0; filter:alpha(opacity:0); 
	}
	.yaser-02 .moveLeft{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/moveLeft-2.png) no-repeat; width: 670px; height: 346px;
		position: absolute; top: 120px; left: 1100px; opacity: 0; filter:alpha(opacity:0); 
	}
	.yaser-03 .opa{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/opacity-3.png) no-repeat; width: 565px; height: 476px; 
		position: absolute; top: 390px; left: 500px; opacity: 0; filter:alpha(opacity:0); 
	}
	.yaser-03 .moveRight{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/moveRight-3.png) no-repeat; width: 623px; height: 337px;
		position: absolute; top: 80px; left: -800px; opacity: 0; filter:alpha(opacity:0); 
	}
	.yaser-03 .moveUp{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/moveUp-3.png) no-repeat; width: 405px; height: 147px;
		position: absolute; top: 940px; left: -70px; opacity: 0; filter:alpha(opacity:0);  
	}
	.yaser-03 .moveLeft{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/moveLeft-3.png) no-repeat; width: 573px; height: 75px;
		position: absolute; top: 160px; left: 1100px; opacity: 0; filter:alpha(opacity:0);  
	}
	.yaser-04 .opa{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/opacity-4.png) no-repeat; width: 414px; height: 512px;
		position: absolute; top: 340px; left: -40px; opacity: 0; filter:alpha(opacity:0); 
	}
	.yaser-04 .moveRight{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/moveRight-4.png) no-repeat; width: 575px; height: 73px;
		position: absolute; top: 140px; left: -800px; opacity: 0; filter:alpha(opacity:0);  
	}
	.yaser-04 .moveUp{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/moveUp-4.png) no-repeat; width: 305px; height: 206px;
		position: absolute; top: 940px; left: 370px; opacity: 0; filter:alpha(opacity:0);  
	}
	.yaser-04 .moveLeft{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/moveLeft-4.png) no-repeat; width: 803px; height: 627px;
		position: absolute; top: 190px; left: 1100px; opacity: 0; filter:alpha(opacity:0);  
	}
	.yaser-04 .moveDown{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/moveDown-4.png) no-repeat; width: 576px; height: 329px;
		position: absolute; top: -300px; left: 460px; opacity: 0; filter:alpha(opacity:0); 
	}
	.hover{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/hover.png) no-repeat; width: 118px; height: 132px;
		position: absolute; opacity: 0; filter:alpha(opacity:0); 
	}
	.yaser-02 .hover{top: 40px; left: -80px}
	.yaser-03 .hover{top: 40px; left: 460px}
	.yaser-04 .hover{top: 100px; left: -80px}
	.icon{
		background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/icon.png) no-repeat; width: 38px; height: 32px;
		position: absolute; opacity: 0; filter:alpha(opacity:0);
		animation:scaleIcon 2s linear infinite;
		-moz-animation:scaleIcon 2s linear infinite;
		-webkit-animation:scaleIcon 2s linear infinite;
		-ms-animation:scaleIcon 2s linear infinite;
		-o-animation:scaleIcon 2s linear infinite;
	}
	@-webkit-keyframes scaleIcon {
		0% 	{-webkit-transform: scale(1);}
		50% {-webkit-transform: scale(1.3);}
		100%{-webkit-transform: scale(1);}
	}
	@-moz-keyframes scaleIcon {
		0% 	{-moz-transform: scale(1);}
		50% {-moz-transform: scale(1.3);}
		100%{-moz-transform: scale(1);}
	}
	@-ms-keyframes scaleIcon {
		0% 	{-ms-transform: scale(1);}
		50% {-ms-transform: scale(1.3);}
		100%{-ms-transform: scale(1);}
	}
	@-o-keyframes scaleIcon {
		0% 	{-o-transform: scale(1);}
		50% {-o-transform: scale(1.3);}
		100%{-o-transform: scale(1);}
	}
	.yaser-02 .icon{top: 80px; left: -50px}
	.yaser-03 .icon{top: 80px; left: 500px}
	.yaser-04 .icon{top: 140px; left: -50px}

	.yaser-02 .a1{width:508px; height:478px; background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/info-1.png) no-repeat; left:20px; top:20px; display: none;}
	.yaser-03 .a1{width:508px; height:478px; background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/info-2.png) no-repeat; right:-20px; top:20px; display: none;}
	.yaser-04 .a1{width:481px; height:455px; background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/info-3.png) no-repeat; left:-70px; top:100px; display: none;}

	.sub-nav a{background: url(<?php echo ATTR_DOMAIN?>/zt/yasertwo/nav.png) no-repeat; width: 70px; height: 68px; position: fixed; left: 60px;}
	.sub-nav .a1{top: 100px;}
	.sub-nav .a2{top: 168px; background-position: 0 -70px;}
	.sub-nav .a3{top: 236px; background-position: 0 -137px; height: 67px}
	.sub-nav .a4{top: 303px; background-position: 0 -204px;}
	.sub-nav .a5{top: 371px; background-position: 0 -276px;}
</style>
<div class="zt-wrap">			
	<div class="yaser-01">
		<div class="zt-con">
			<div class="opa"></div>
			<div class="moveUp"></div>
			<div class="moveLeft"></div>
		</div>
	</div>
	<div class="yaser-02">
		<div class="zt-con">
			<div class="opa">
				<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>'57051')),array('class'=>'a1','target'=>'_blank'))?>
			</div>
			<div class="moveRight"></div>
			<div class="moveUp"></div>
			<div class="moveLeft"></div>
			<div class="hover"></div>
			<div class="icon"></div>
		</div>
	</div>
	<div class="yaser-03">
		<div class="zt-con">
			<div class="opa">
				<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>'57056')),array('class'=>'a1','target'=>'_blank'))?>
			</div>
			<div class="moveRight"></div>
			<div class="moveUp"></div>
			<div class="moveLeft"></div>
			<div class="hover"></div>
			<div class="icon"></div>
		</div>
	</div>
	<div class="yaser-04">
		<div class="zt-con">
			<div class="opa">
				<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>'57055')),array('class'=>'a1','target'=>'_blank'))?>
			</div>
			<div class="moveRight"></div>
			<div class="moveUp"></div>
			<div class="moveLeft"></div>
			<div class="moveDown"></div>
			<div class="hover"></div>
			<div class="icon"></div>
		</div>
	</div>
	<div class="sub-nav">
		<a href="javascript:void(0)" class="a1"></a>
		<a href="javascript:void(0)" class="a2"></a>
		<a href="javascript:void(0)" class="a3"></a>
		<a href="javascript:void(0)" class="a4"></a>
		<a href="<?php echo DOMAIN;?>" class="a5"></a>
	</div>
</div>
<script type="text/javascript">
$(function(){
	var scrollValue = 0;
	var distance = $('.yaser-01').height();

	var chromeIndex = 1;
	var fireFoxIndex = 0;

	function startMove(e){ 
	    ev = e || window.event;
		
	    if(ev.wheelDelta){			//IE||Opera||Chrome
	    	var scrollDis = distance/2;
	    	var totalHeight = 3144;
	        if(ev.wheelDelta<0){	//向下滚动
	        	moveDown(scrollDis,totalHeight);
	        	moveDownAni();
	        } 
	        else{					//向上滚动
	        	moveUp(scrollDis,totalHeight,2620);
	        	moveUpAni();
	        }
	        return false;
	    }else if(ev.detail){		//fireFox
	    	var scrollDis = distance;
	    	var totalHeight = 3144
	        if(ev.detail>0){		//向下滚动
	        	moveDown(scrollDis,totalHeight);
	        	moveDownAni();
	        }
	        else{					//向上滚动
	        	moveUp(scrollDis,totalHeight,2096);
	        	moveUpAni();
	        }
	        return false;
	    } 
	}
	$('.header,.footer').hide();
	/*鼠标滚轮向下移动*/
	function moveDown(dis,total){
		scrollValue += dis;
    	if(scrollValue>total){
    		scrollValue = total;
    	}
    	else if(scrollValue==distance*3){
    		scrollValue = total
    	}
    	$('body,html').stop(true,false).animate({scrollTop:scrollValue},800);
	}
	/*鼠标滚轮向上移动*/
	function moveUp(dis,total,val){
		scrollValue -= dis;
    	if(scrollValue<=0){
    		scrollValue = 0;
    	}
    	else if(scrollValue==total-dis){
    		scrollValue = val;
    	}
    	$('body,html').stop(true,false).animate({scrollTop:scrollValue},800)
    	
	}
	/*注册事件*/ 
	if(document.addEventListener){ 
	    document.addEventListener('DOMMouseScroll',startMove,false);	//Chrome/ff
	}
	window.onmousewheel=document.onmousewheel=startMove;	//IE/Opera/Chrome

	$('.yaser-02 .opa,.yaser-03 .opa, .yaser-04 .opa').hover(function(){
		$(this).find('a').show();	
	},function(){
		$(this).find('a').hide();
	})

	/*动画部分*/

	var arrMoveLeft = [];
	var arrMoveUp = [];
	var arrMoveRight = [];
	var arrMoveDown = [];
	var arrHover = [];
	var arrIcon = [];
	var i = 0;
	
	var totalLen = $('.moveLeft').length;

	for(i=0;i<totalLen;i++){
		arrMoveLeft.push(parseInt($('.moveLeft').eq(i).css('left')));
	}
	for(i=0;i<totalLen;i++){
		arrMoveUp.push(parseInt($('.moveUp').eq(i).css('top')));
	}
	for(i=0;i<totalLen+1;i++){
		if(i==0)
			arrMoveRight.push(0);
		else
			arrMoveRight.push(parseInt($('.moveRight').eq(i-1).css('left')));
	}
	for(i=0;i<totalLen;i++){
		if(i==totalLen-1)
			arrMoveDown.push(parseInt($('.moveDown').eq(0).css('top')))
		else
			arrMoveDown.push(0);
	}
	for(i=0;i<totalLen;i++){
		if(i==0)
			arrHover.push(0);
		else
			arrHover.push(parseInt($('.hover').eq(i-1).css('top')));
	}
	for(i=0;i<totalLen;i++){
		if(i==0)
			arrIcon.push(0);
		else
			arrIcon.push(parseInt($('.icon').eq(i-1).css('top')));
	}

	part1Move();
	
	function part1Move(){
		$('.yaser-01').find('.opa').stop(false,false).animate({opacity:1},1300);
		$('.yaser-01').find('.moveUp').stop(false,false).animate({opacity:1,top:460},1000);
		$('.yaser-01').find('.moveLeft').stop(false,false).animate({opacity:1,left:720},1000);
		
	}
	function part1Reset(index){		
		$('.yaser-01').find('.opa').css({'opacity':0});
		$('.yaser-01').find('.moveUp').css({'opacity':0,'top':arrMoveUp[index]});
		$('.yaser-01').find('.moveLeft').css({'opacity':0,'left':arrMoveLeft[index]});	
	}

	function part2Move(){
		$('.yaser-02').find('.opa').stop(false,false).animate({opacity:1},1300);
		$('.yaser-02').find('.moveRight').stop(false,false).animate({opacity:1,left:-50},1000);
		$('.yaser-02').find('.moveUp').stop(false,false).animate({opacity:1,top:640},1000);
		$('.yaser-02').find('.moveLeft').stop(false,false).animate({opacity:1,left:420},1000);
		$('.yaser-02').find('.hover').stop(false,false).animate({opacity:1,top:400},1000);
		$('.yaser-02').find('.icon').stop(false,false).animate({opacity:1,top:540},1000);
	}
	function part2Reset(index){		
		$('.yaser-02').find('.opa').css({'opacity':0});
		$('.yaser-02').find('.moveRight').css({'opacity':0,'left':arrMoveRight[index]});
		$('.yaser-02').find('.moveUp').css({'opacity':0,'top':arrMoveUp[index]});
		$('.yaser-02').find('.moveLeft').css({'opacity':0,'left':arrMoveLeft[index]});
		$('.yaser-02').find('.hover').css({'opacity':0,'top':arrHover[index]});
		$('.yaser-02').find('.icon').css({'opacity':0,'top':arrIcon[index]});
	}

	function part3Move(){
		$('.yaser-03').find('.opa').stop(false,false).animate({opacity:1},1300);
		$('.yaser-03').find('.moveRight').stop(false,false).animate({opacity:1,left:-120},1000);
		$('.yaser-03').find('.moveUp').stop(false,false).animate({opacity:1,top:640},1000);
		$('.yaser-03').find('.moveLeft').stop(false,false).animate({opacity:1,left:540},1000);
		$('.yaser-03').find('.hover').stop(false,false).animate({opacity:1,top:400},1000);
		$('.yaser-03').find('.icon').stop(false,false).animate({opacity:1,top:540},1000);
	}
	function part3Reset(index){		
		$('.yaser-03').find('.opa').css({'opacity':0});
		$('.yaser-03').find('.moveRight').css({'opacity':0,'left':arrMoveRight[index]});
		$('.yaser-03').find('.moveUp').css({'opacity':0,'top':arrMoveUp[index]});
		$('.yaser-03').find('.moveLeft').css({'opacity':0,'left':arrMoveLeft[index]});
		$('.yaser-03').find('.hover').css({'opacity':0,'top':arrHover[index]});
		$('.yaser-03').find('.icon').css({'opacity':0,'top':arrIcon[index]});
	}

	function part4Move(){
		$('.yaser-04').find('.opa').stop(false,false).animate({opacity:1},1300);
		$('.yaser-04').find('.moveRight').stop(false,false).animate({opacity:1,left:-40},1000);
		$('.yaser-04').find('.moveUp').stop(false,false).animate({opacity:1,top:570},1000);
		$('.yaser-04').find('.moveLeft').stop(false,false).animate({opacity:1,left:630},1000);
		$('.yaser-04').find('.moveDown').stop(false,false).animate({opacity:1,top:50},1000);
		$('.yaser-04').find('.hover').stop(false,false).animate({opacity:1,top:340},1000);
		$('.yaser-04').find('.icon').stop(false,false).animate({opacity:1,top:480},1000);
	}
	function part4Reset(index){		
		$('.yaser-04').find('.opa').css({'opacity':0});
		$('.yaser-04').find('.moveRight').css({'opacity':0,'left':arrMoveRight[index]});
		$('.yaser-04').find('.moveUp').css({'opacity':0,'top':arrMoveUp[index]});
		$('.yaser-04').find('.moveLeft').css({'opacity':0,'left':arrMoveLeft[index]});
		$('.yaser-04').find('.moveDown').css({'opacity':0,'top':arrMoveDown[index]});
		$('.yaser-04').find('.hover').css({'opacity':0,'top':arrHover[index]});
		$('.yaser-04').find('.icon').css({'opacity':0,'top':arrIcon[index]});
	}

	function moveDownAni(){
		if(scrollValue>0&&scrollValue<=1048){
    		part1Reset(0);
    		part2Move();
    	}
    	else if(scrollValue>1048&&scrollValue<=2096){
    		part2Reset(1);
    		part3Move();	
    	}
    	else if(scrollValue>2096){
    		part3Reset(2);
    		part4Move();
    	}
	}

	function moveUpAni(){
		if(scrollValue<1048&&scrollValue>=0){
    		part2Reset(1);
    		part1Move();
    	}
    	else if(scrollValue<2096&&scrollValue>=1048){
    		part3Reset(2);
    		part2Move();
    	}
    	if(scrollValue<2620&&scrollValue>=2096){
    		part4Reset(3);
    		part3Move();
    	}
	}

	function onOff(bool){
		bool = !bool;
	}

	$('.sub-nav a').hover(function(){
		$(this).stop(true,true).animate({width:200},1000);
	},function(){
		$(this).stop(true,true).animate({width:70},1000);
	})
	
})
</script>  