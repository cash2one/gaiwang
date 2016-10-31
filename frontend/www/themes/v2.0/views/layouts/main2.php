<?php
/**
 * 专题首页
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
    <title><?php echo empty($this->pageTitle) ? '' : $this->pageTitle; ?></title>
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

            /*商品分类start*/
            $(".gx-nav-left").hover(function(){
                $(".gx-nav-left-list").show();
            },function(){
                $(".gx-nav-left-list").hide();
            });
            $('.gx-nav-left-list li').hover(function(){
                $(this).find('.gx-nav-item').show();
                $(this).find(".gx-nav-class").addClass("gx-nav-classSel");
            },function(){
                $(this).find('.gx-nav-item').delay(3000).hide();
                $(this).find(".gx-nav-class").removeClass("gx-nav-classSel");
            });
            /*商品分类end*/

            /*面包屑商品型号选择start*/
            $(".goods-type").hover(function(){
                $(".goods-type-list").show();
                $(this).addClass("goods-typeSel");
            },function(){
                $(".goods-type-list").hide();
                $(this).removeClass("goods-typeSel");
            });
            /*面包屑商品型号选择end*/

            //尺码更多
            $(".gs-more2").each(function(){
                $(this).click(function(){
                    if($(this).text()=="更多"){
                        $(this).text("");
                        $(this).text("收起");
                        $(this).parents('dl').find("ul").css("height","auto");
                    }else{
                        $(this).text("");
                        $(this).text("更多");
                        $(this).parents('dl').find("ul").css("height","26px");
                    }
                });
            });
            //更多选项
            $(".gs-fdBut span").click(function(){
                $(".gs-moreInfo").toggle();
            });
            /*商品筛选end*/
            //排序点击效果
            $(".gst-sort dd").click(function(){
                $(".gst-sort dd").removeClass("ddSel");
                $(this).addClass("ddSel");
            });
            //列表边框样式
            $(".goods-list-main li").hover(function(){
                $(this).find(".goods-list-border").show();
            },function(){
                $(this).find(".goods-list-border").hide();
            });
            //列表点击小图切换大图
            $(".gs-smallIco img").click(function(){
                $(this).parents().prev("a").find("img").attr("src",$(this).attr("imgSrc"));
            });
            //收货地址选择
            $(".gst-address-info").click(function(){
                $(".gst-address-list").show();
            });
            $(".gst-address-list").hover(function(){
                $(".gst-address-list").show();
            },function(){
                $(".gst-address-list").hide();
                $(".gst-address-lower").find("ul").empty("li");
                $(".gst-address-list li a").removeClass("gst-address-listSel");
            });
            //清除已选的筛选条件
            $(".gs-clearBut").click(function(){
                $(".gs-xz").html("&nbsp;");
            });
            //输入赛选价格显示确定按钮
            $(".gst-range").mousedown(function(){
                $(".gst-range-but").show();
            });
        })
    </script>
    <style> .gx-nav-left-list{display: none;}</style>
</head>

<body>

<?php $this->renderPartial('//layouts/_top_v20'); ?>
<?php $this->renderPartial('//layouts/_top2_v20'); ?>
<?php $this->renderPartial('//layouts/_nav_v20'); ?>

<!-- 首页主体start -->
        <?php echo $content; ?>
<!-- 首页主体end -->
<?php $this->renderPartial('//layouts/_footer_v20'); ?>
</body>
</html>
