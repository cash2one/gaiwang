
<?php $this->pageTitle = "盖象商城-盖网2016品牌宣传片" ;?>
<style>
/*=====
    @Date:2016-07-15
    @content:盖网2016品牌宣传片
	@author:林聪毅
 =====*/
.zt-wrap{width:100%; background:#fff; overflow: hidden;}
.zt-con { width:1200px; margin:0 auto; position:relative; }
.zt-con a{ position:absolute;display:block;}
.trailer-01{height:609px; background:url(<?php echo ATTR_DOMAIN;?>/zt/trailer/trailer-01.jpg) top center no-repeat;}
.trailer-02{height:270px; background:url(<?php echo ATTR_DOMAIN;?>/zt/trailer/trailer-02.jpg) top center no-repeat;}
.trailer-03{height:269px; background:url(<?php echo ATTR_DOMAIN;?>/zt/trailer/trailer-03.jpg) top center no-repeat;}
.trailer-04{height:487px; background:url(<?php echo ATTR_DOMAIN;?>/zt/trailer/trailer-04.jpg) top center no-repeat;}
.trailer-05{height:365px; background:url(<?php echo ATTR_DOMAIN;?>/zt/trailer/trailer-05.jpg) top center no-repeat;}
.trailer-06{height:925px; background:url(<?php echo ATTR_DOMAIN;?>/zt/trailer/trailer-06.jpg) top center no-repeat;}
.trailer-07{height:275px; background:url(<?php echo ATTR_DOMAIN;?>/zt/trailer/trailer-07.jpg) top center no-repeat;}
.trailer-08{height:343px; background:url(<?php echo ATTR_DOMAIN;?>/zt/trailer/trailer-08.jpg) top center no-repeat;}

.trailer-02 a{width: 1060px; height: 500px; top: 20px;}
.trailer-02 .a1{left: 70px;}
.layer{width: 100%; height: 100%; position: fixed; left: 0px; top: 0px; z-index: 99; background-color: #1c1c1c; display: none;}
.tipsWrap{width: 1180px; height: 590px; position: fixed; left: 50%; top: 50%; margin-left: -590px; margin-top: -295px; z-index: 100; display: none;}
.closeWin{width: 290px; height: 64px; display: block; position: absolute; left: 426px; top: 424px; background-color: #fff; opacity: 0; z-index: 101;}

</style>
	<div class="zt-wrap">			
		<div class="trailer-01"></div>
		<div class="trailer-02">
			<div class="zt-con">
				<a href="javascript:void(0)" class="a1"></a>
			</div>
		</div>
		<div class="trailer-03"></div>
		<div class="trailer-04"></div>
		<div class="trailer-05"></div>
		<div class="trailer-06">
			<div class="zt-con">
				<img src="<?php echo ATTR_DOMAIN;?>/zt/trailer/ani.gif">
			</div>
		</div>
		<div class="trailer-07"></div>
		<div class="trailer-08"></div>
	</div>
	<div class="layer"></div> 
	<div class="tipsWrap">
		<img src="<?php echo ATTR_DOMAIN;?>/zt/trailer/tips.gif">
		<a href="javascript:void(0)" class="closeWin"></a>
	</div> 
   <!--------------主体 End------------>
<script type="text/javascript">
$(function(){
	$('.trailer-02 .a1').click(function(){
		$('.layer').show();
		$('.tipsWrap').show();
	})
	$('.closeWin').click(function(){
		$('.layer').hide();
		$('.tipsWrap').hide();
	})
})
</script>
