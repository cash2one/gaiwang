<?php
/**
 * 首页 layout
 *
 * @var $this SiteController
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="<?php echo empty($this->keywords) ? '' : $this->keywords; ?>" />
    <meta name="Description" content="<?php echo empty($this->description) ? '' : $this->description; ?>" />
    <title><?php echo empty($this->title) ? '' : $this->title; ?></title>
    <link href="<?php echo $this->theme->baseUrl.'/'; ?>styles/gxIndex.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo $this->theme->baseUrl.'/'; ?>js/jquery-1.9.1.js" type="text/javascript"></script>
    <script src="<?php echo $this->theme->baseUrl.'/'; ?>js/jquery.gate.common.js"></script>
    <script src="<?php echo $this->theme->baseUrl.'/'; ?>js/jquery.flexslider-min.js"></script>
    <script src="<?php echo $this->theme->baseUrl.'/'; ?>js/jquery.nav.js"></script>
    <script>
        $(function(){
            /*头部广告隐藏start*/
            $(".clear-top-but").click(function(){
                $(".top-advert").slideToggle();
            });
            /*头部广告隐藏end*/
            /*大广告图start*/
            $('.gx-indexBanner').flexslider({
                slideshowSpeed: 5000,
                animationSpeed: 400,
                pauseOnHover: true,
                touch: true,
                directionNav: true
            });
            /*大广告图end*/
            /*商品分类start*/
            $('.gx-nav-left-list li').hover(function(){
                $(this).find('.gx-nav-item').show();
                $(this).find(".gx-nav-class").addClass("gx-nav-classSel");

            },function(){
                $(this).find('.gx-nav-item').delay(3000).hide();
                $(this).find(".gx-nav-class").removeClass("gx-nav-classSel");
            });
            /*商品分类start*/

            /*左侧悬浮菜单start*/
            $('#redEnvNav').onePageNav();
            //根据个数自动设置高度 .gxEnvNavWrap
            $(".gxEnvNavWrap").css('height',$(".gxEnvNavWrap li").length*30);

            $(window).bind('scroll resize',function(){
                if($(window).scrollTop()>1300){
                    $(".redEnvNavWrap").show();
                }else{
                    $(".redEnvNavWrap").hide();
                }
            })
            /*左侧悬浮菜单end*/

            /*楼层品牌logo轮播start*/
            $('.gx-brand').flexslider({
                slideshowSpeed: 5000,
                animationSpeed: 400,
                directionNav: false,
                pauseOnHover: true,
                touch: true,
                controlNav: false,
                directionNav: true
            });
            /*楼层品牌logo轮播end*/

            /*楼层产品轮播start*/
            $('.gx-fmr-banner').flexslider({
                slideshowSpeed: 5000,
                animationSpeed: 400,
                directionNav: false,
                pauseOnHover: true,
                touch: true,
                directionNav: true
            });
            $(".gx-fmr-banner,.gx-indexBanner").hover(function(){
                $(this).find(".flex-direction-nav").show();
            },function(){
                $(this).find(".flex-direction-nav").hide();
            });
            /*楼层产品轮播end*/
            /*楼层产品切换start*/
            $(".gx-floor-title ul li").click(function(){
                $(this).parents("ul").find("li").removeClass("gx-floor-titleSel");
                $(this).addClass("gx-floor-titleSel");
                var dqTag=$(this).attr("tag");
                $(this).parents('.reColumn').find(".gx-floor-main-right .gx-fmr-cp").hide();
                $(this).parents('.reColumn').find(".gx-floor-main-right .gx-fmr-cp"+dqTag+"").show();
            });
            /*楼层产品切换end*/
            $(document).ready(function($){
                var wh1=$(".reColumn1 .flex-control-nav").width()/2;
                var wh2=$(".reColumn2 .flex-control-nav").width()/2;
                var wh3=$(".reColumn3 .flex-control-nav").width()/2;
                var wh4=$(".reColumn4 .flex-control-nav").width()/2;
                var wh5=$(".reColumn5 .flex-control-nav").width()/2;
                var wh6=$(".reColumn6 .flex-control-nav").width()/2;
                var wh7=$(".reColumn7 .flex-control-nav").width()/2;
                var wh8=$(".reColumn8 .flex-control-nav").width()/2;
                var wh9=$(".reColumn9 .flex-control-nav").width()/2;
                $(".reColumn1 .flex-control-nav").css("margin-left",-wh1+"px");
                $(".reColumn2 .flex-control-nav").css("margin-left",-wh2+"px");
                $(".reColumn3 .flex-control-nav").css("margin-left",-wh3+"px");
                $(".reColumn4 .flex-control-nav").css("margin-left",-wh4+"px");
                $(".reColumn5 .flex-control-nav").css("margin-left",-wh5+"px");
                $(".reColumn6 .flex-control-nav").css("margin-left",-wh6+"px");
                $(".reColumn7 .flex-control-nav").css("margin-left",-wh7+"px");
                $(".reColumn8 .flex-control-nav").css("margin-left",-wh8+"px");
                $(".reColumn9 .flex-control-nav").css("margin-left",-wh9+"px");
                var BannerWh=$(".gx-indexBanner .flex-control-nav").width()/2;
                $(".BannerWh .flex-control-nav").css("margin-left",-BannerWh+"px");
            });

            function adjust(){
                var YX=parseInt($(".gx-IA-right-main").offset().left);
                var ZX=parseInt($(".gx-nav-left-list").offset().left);
                var GX=parseInt($(".gx-top-logoSearch").offset().left);

                $(".gx-indexBanner .flex-direction-nav .flex-next").css("left",(YX-40));//右边切换图标位置
                $(".gx-indexBanner .flex-direction-nav .flex-prev").css("left",(ZX+210));//左边边切换图标位置
                $(".gx-IA-right-main").css("left",(GX+1020));//大背景图右边广告位置
                $(".gx-IA-info").css("left",(GX+1020));//大背景图右边广告下面文字走马灯位置

                var icoWh=parseInt($(".gx-indexBanner .flex-control-nav").width());
                var bannerWh=parseInt($(".gx-indexBanner").width());
                $(".gx-indexBanner .flex-control-nav").css("margin-left",((bannerWh-icoWh)/2)+8);
            }
            window.onload=function(){
                window.onresize = adjust;
                adjust();
            }
        })
    </script>

</head>

<body>

<?php $this->renderPartial('//layouts/_top_v20'); ?>
<?php $this->renderPartial('//layouts/_top2_v20'); ?>
<?php $this->renderPartial('//layouts/_nav_v20'); ?>
<?php $this->renderPartial('//layouts/_banner'); ?>

<!-- 首页主体start -->
<div class="gx-main">
    <div class="gx-content">
        <?php echo $content; ?>
    </div>
</div>
<!-- 首页主体end -->

<?php $this->renderPartial('//layouts/_footer_v20'); ?>


</body>
</html>
