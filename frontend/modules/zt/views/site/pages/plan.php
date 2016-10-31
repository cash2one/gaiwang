<?php $this->pageTItle = "秋冬服装专题_" . $this->pageTitle;?>
<style type="text/css">
    /*=====
    @Date:2015-11-26
    @content:秋冬服饰首页
	@author:林聪毅
 =====*/
    .zt-wrap{width:100%; background:#fff;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .plan-01{height:250px; background:url(<?php echo ATTR_DOMAIN;?>/zt/plan/plan-01.jpg) top center no-repeat;}
    .plan-02{height:250px; background:url(<?php echo ATTR_DOMAIN;?>/zt/plan/plan-02.jpg) top center no-repeat;}
    .plan-03{height:250px; background:url(<?php echo ATTR_DOMAIN;?>/zt/plan/plan-03.jpg) top center no-repeat;}
    .plan-04{height:250px; background:url(<?php echo ATTR_DOMAIN;?>/zt/plan/plan-04.jpg) top center no-repeat;}

    .plan-01 .layout{
        width: 1400px; height: 818px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/plan/layout.png) no-repeat;
        left: 0px; top: 100px; z-index: 10; display: none;
    }
    .plan-01 a{width: 249px; height: 249px;}
    .plan-01 .a1{left: 187px; top: 55px;}
    .plan-01 .a1.active{background: url(<?php echo ATTR_DOMAIN;?>/zt/plan/border-01.png) no-repeat;}
    .plan-01 .a2{left: 582px; top: 55px;}
    .plan-01 .a2.active{background: url(<?php echo ATTR_DOMAIN;?>/zt/plan/border-02.png) no-repeat;}
    .plan-01 .a3{left: 965px; top: 55px;}
    .plan-01 .a3.active{background: url(<?php echo ATTR_DOMAIN;?>/zt/plan/border-03.png) no-repeat;}
    .plan-01 .a4{left: 397px; top: 296px;}
    .plan-01 .a4.active{background: url(<?php echo ATTR_DOMAIN;?>/zt/plan/border-04.png) no-repeat;}
    .plan-01 .a5{left: 793px; top: 296px;}
    .plan-01 .a5.active{background: url(<?php echo ATTR_DOMAIN;?>/zt/plan/border-05.png) no-repeat;}
    .plan-01 .a6{left: 187px; top: 509px;}
    .plan-01 .a6.active{background: url(<?php echo ATTR_DOMAIN;?>/zt/plan/border-06.png) no-repeat;}
    .plan-01 .a7{left: 582px; top: 509px;}
    .plan-01 .a7.active{background: url(<?php echo ATTR_DOMAIN;?>/zt/plan/border-07.png) no-repeat;}
    .plan-01 .a8{left: 965px; top: 509px;}
    .plan-01 .a8.active{background: url(<?php echo ATTR_DOMAIN;?>/zt/plan/border-08.png) no-repeat;}

    .plan-02 a{ width:650px; height:650px; top:40px;}
    .plan-02 .a1{left:680px; }
</style>

<div class="zt-wrap">
    <div class="plan-01">
        <div class="zt-con layout">
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/plan1" class="a1" target="_blank"></a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/plan2" class="a2" target="_blank"></a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/plan3" class="a3" target="_blank"></a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/plan4" class="a4" target="_blank"></a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/plan5" class="a5" target="_blank"></a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/plan6" class="a6" target="_blank"></a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/plan7" class="a7" target="_blank"></a>
            <a href="http://zt.g-emall.com/site/leather" class="a8" target="_blank"></a>
        </div>
    </div>
    <div class="plan-02">
        <div class="zt-con">
            <a href="连接" title="名字" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="plan-03"></div>
    <div class="plan-04"></div>
</div>

<script type="text/javascript">
    $(function(){
        $('.layout a').hover(function(){
            $(this).addClass('active');
        },function(){
            $(this).removeClass('active');
        })
        $('.plan-02 a').mouseover(function(){
            $('.layout').slideDown(500);
        });
        $('.layout').mouseleave(function(){
            $(this).slideUp(1000);
        })
    })
</script>