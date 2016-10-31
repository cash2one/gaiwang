<?php
/**
 * 酒店改版V2.0
 *
 * @var $this HotelController
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="<?php echo empty($this->keywords) ? '' : $this->keywords; ?>" />
    <meta name="Description" content="<?php echo empty($this->description) ? '' : $this->description; ?>" />
    <title><?php echo empty($this->pageTitle) ? '' : $this->pageTitle; ?></title>
    <link href="<?php echo $this->theme->baseUrl.'/'; ?>styles/global.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->theme->baseUrl.'/'; ?>styles/module.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->theme->baseUrl.'/'; ?>styles/hotel.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo $this->theme->baseUrl.'/'; ?>js/jquery.gate.common.js"></script>
    <script src="<?php echo $this->theme->baseUrl.'/'; ?>js/jquery-gate.js"></script>
    <script src="<?php echo $this->theme->baseUrl.'/'; ?>js/jquery.flexslider-min.js"></script>
    <script src="<?php echo $this->theme->baseUrl.'/'; ?>js/jquery.nav.js"></script>
        <script>
            $(function(){
            	 $(".yiiPageer").css("float",'none');
            	 
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
                    $(".gs-more2").click(function(){
                            if($(this).text()=="更多"){
                                    $(this).text("");
                                    $(this).text("收起");
                                    $(".gs-sizeList").css("height","auto");
                            }else{
                                    $(this).text("");
                                    $(this).text("更多");
                                    $(".gs-sizeList").css("height","26px");
                            }
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
                    $(".gst-range").click(function(){
                        $(".gst-range-but").show();
                    });
            })
        </script>
        <style> .gx-nav-left-list{display: none;}</style>
</head>

<body>
<?php
// 头部横幅广告
$topAds = WebAdData::getLogoData('index-top-banner');//调用接口，获取第一行数据
$topAd = !empty($topAds) && AdvertPicture::isValid($topAds[0]['start_time'], $topAds[0]['end_time']) ? $topAds[0] : array();
?>
<?php if(!empty($topAd)): ?>
<div class="top-advert">
    <img width="100%" height="70"  src="<?php echo ATTR_DOMAIN . '/' . $topAd['picture']; ?>"/>
    <div class="clear-top-advert">
        <div>
            <?php echo CHtml::link('<span style="width:1200px;height:70px;display:block;"></span> ',$topAd['link'],
                array('target'=>$topAd['target'],'title'=>$topAd['title'])); ?>
            <span class="clear-top-but" style="z-index: 9999"></span>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $this->renderPartial('//layouts/_top_v20'); ?>
<div class="logoSearch w1200">
        <div class="clearfix">
            <a title="<?php echo Yii::t('hotel', '盖象商城')?>" class="hotel-logo fl" id="gai_link" href="<?php echo DOMAIN ?>"><img width="215" height="85" src="<?php echo $this->theme->baseUrl.'/'; ?>images/bgs/logo.png" alt="<?php echo Yii::t('hotel', '盖象商城')?>"></a>
            <div class="hotel-title fl">
                 <?php echo Yii::t('hotel', '至优旅游')?>  
            </div> 
            <div class="hotel-tel fr">
                <p class="phoneIco"><?php echo Tool::getConfig('hotelparams', 'hotelServiceTel'); ?></p><?php echo Yii::t('hotel', '服务时间: '),Tool::getConfig('hotelparams', 'hotelServiceTime');?></div>
            </div>
 </div>
 <?php //$this->renderPartial('//layouts/_nav_v20'); ?>    
<!-- 首页主体start -->
<div class="gx-main">
    <div class="gx-content  clearfix">
        <?php echo $content; ?>
    </div>
</div>
<!-- 首页主体end -->
<?php $this->renderPartial('//layouts/_footer_v20'); ?>

</body>
</html>
