
<?php  $this->pageTitle="盖象商城-超级品牌月" ?>

<style>
/*=====
    @Date:2016-09-13
    @content:
	@author:刘泉辉
 =====*/
.zt-wrap{width:100%; background:#fff; overflow: hidden;}
.zt-con { width:968px; margin:0 auto; position:relative; }
.zt-con a{ position:absolute;display:block;}
.brend-month-01{height:360px; background:url(<?php echo ATTR_DOMAIN;?>/zt/brend-month/1.jpg) top center no-repeat;}
.brend-month-02{height:360px; background:url(<?php echo ATTR_DOMAIN;?>/zt/brend-month/2.jpg) top center no-repeat;}
.brend-month-03{height:360px; background:url(<?php echo ATTR_DOMAIN;?>/zt/brend-month/3.jpg) top center no-repeat;}

.brend-month-03 .a1{left:-35px; width:94px; height:94px; top:168px;border-radius: 50%;display: block;background: url(<?php echo ATTR_DOMAIN;?>/zt/brend-month/01.jpg) no-repeat;}
.brend-month-03 .a2{left:258px; width:129px; height:129px; top:215px;border-radius: 50%;display: block;background: url(<?php echo ATTR_DOMAIN;?>/zt/brend-month/02.jpg) no-repeat;}
.brend-month-03 .a3{left:628px; width:113px; height:113px; top:178px;border-radius: 50%;display: block;background: url(<?php echo ATTR_DOMAIN;?>/zt/brend-month/03.jpg) no-repeat;}
.brend-month-03 .a4{left:911px; width:86px; height:86px; top:232px;border-radius: 50%;display: block;background: url(<?php echo ATTR_DOMAIN;?>/zt/brend-month/04.jpg) no-repeat;}

.a1:hover{
	-webkit-animation:jump 0s;
	animation: jump 0s;
}
.a2:hover{
	-webkit-animation:jump 0s;
	animation: jump 0s;
}
.a3:hover{
	-webkit-animation:jump 0s;
	animation: jump 0s;
}
.a4:hover{
	-webkit-animation:jump 0s;
	animation: jump 0s;
}
.jump{
	animation: jump 1s ease-in-out infinite;
  	-webkit-animation: jump 1s ease-in-out infinite;
}
@keyframes jump {
  0%,100%{transform: translateY(-10px);}
  50% {transform: translateY(10px);}
}
@-webkit-keyframes jump {
  0%,100%{-webkit-transform: translateY(-10px);}
  50% {-webkit-transform: translateY(10px);}
}

</style>

	<div class="zt-wrap">			
		<div class="brend-month-01"></div>
		<div class="brend-month-02"></div>
		<div class="brend-month-03">
              <div class="zt-con">
				<a href="<?php echo $this->createAbsoluteUrl('/zt/site/brend-month_1')?>" title="运动" class="a1 jump" target="_blank"></a>
				<a href="<?php echo $this->createAbsoluteUrl('/zt/site/brend-month_2')?>" title="电器" class="a2 jump" target="_blank"></a>
				<a href="<?php echo $this->createAbsoluteUrl('/zt/site/brend-month_3')?>" title="生活" class="a3 jump" target="_blank"></a>
				<a href="<?php echo $this->createAbsoluteUrl('/zt/site/brend-month_4')?>" title="护肤" class="a4 jump" target="_blank"></a>
			</div>
		</div>
	</div>   
   <!--主体 End -->
   