<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="优品汇,盖象活动,盖象特价,商城优惠活动,特价,促销,特卖,优惠,特价促销,促销活动,打折商品,每日特价,名品特卖,品牌折扣,限时抢购,打折信息,盖象商城" />
        <meta name="Description" content="盖象商城优品汇-为您提供盖象商城最新、最优惠的活动信息，涵盖了电脑数码、手机家电、食品百货、服饰、母婴、图书等全品特价，促销，特卖，优惠，特价促销，打折活动，盖象商城优品汇为您挑选最实惠以及质量最好的产品，让您买的放心、用的安心！" />
        <title>盖象优品汇_特价_促销_特卖_折扣_抢购 _限时秒杀-盖象商城</title>
		
        <link href="<?php echo $this->theme->baseUrl; ?>/styles/global.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $this->theme->baseUrl; ?>/styles/module.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $this->theme->baseUrl; ?>/styles/seckill.css?t=<?php echo rand(1,1000); ?>" rel="stylesheet" type="text/css" />
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <script>
            document.domain = "<?php echo substr(DOMAIN, 11) ?>";
        </script>

        <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/jquery.cookie.js"></script>
        <script src="<?php echo DOMAIN; ?>/js/jquery.gate.common.js" type="text/javascript"></script>
        <script src="<?php echo DOMAIN; ?>/js/jquery.flexslider-min.js"></script>
        <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/jquery.SuperSlide.2.1.1.js"></script>
        <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/lazyLoad.js"></script>
        <script src="<?php echo $this->theme->baseUrl.'/'; ?>js/jquery.gate.common.js"></script>
        
        <script type="text/javascript">
            $(function() {
                /*头部广告位关闭*/
                $("#topBanner .close").click(function() {
                    $("#topBanner").hide();
                })
                /*购物车列表*/
                $('#myCart').hover(function() {
                    $(this).find('.cartList').show();
                }, function() {
                    $(this).find('.cartList').delay(3000).hide();
                });

                /*banner 轮播*/
                $(".focusSlider,.flexslider01").flexslider({
                    slideshowSpeed: 5000,
                    animationSpeed: 400,

                    pauseOnHover: true,
                    touch: true
                });

                /*新banner轮播*/
                jQuery(".focusBox").slide({mainCell: ".pic", effect: "fold", autoPlay: true, delayTime: 600, trigger: "click"});

                /*底部友情连接显示更多*/
                $("#morefLinks").click(function() {
                    if ($(this).hasClass('moreLinks')) {
                        $(".friendsLinks").css("height", "auto");
                        $(".friendsLinks").css("overflow", " ");
                        $("#morefLinks").removeClass("moreLinks").addClass("lessLinks");
                    } else {
                        $(".friendsLinks").css("height", "20px");
                        $(".friendsLinks").css("overflow", "hidden");
                        $("#morefLinks").removeClass("lessLinks").addClass("moreLinks");
                    }
                })

                /*回到顶部*/
                $("#backTop").click(function() {
                    $('body,html').stop().animate({scrollTop: 0}, 500);
                    return false;
                });

            })
        </script>
        <!--处理IE6中透明图片兼容问题-->
        <!--[if IE 6]>
        <script type="text/javascript" src="../js/DD_belatedPNG.js" ></script>
        <script type="text/javascript">
        DD_belatedPNG.fix('img,background,body,div,span,.trans,a,input,i');
        </script>
        <![endif]-->

    </head>
    <body>
        <div class="wrap seckillWrap">
            <div class="header">
                <?php $this->renderPartial('//layouts/_top_v20'); ?>
                <div class="logoSearch w1200">
                    <!-- 秒杀活动头部 -->
                    <div class="seckillHeader clearfix">
                        <a href="<?php echo DOMAIN?>" title="盖象商城" class="gx-top-logo">
                            <img width="187" height="56" alt="盖象商城" src="<?php echo Yii::app()->theme->baseUrl?>/images/bgs/top_logo.png"/>
                        </a>
                        <a href="/" title="盖象商城" class="YPH-logo">
                            <img alt="优品汇" src="<?php echo Yii::app()->theme->baseUrl?>/images/bgs/YPH_logo.jpg"/>
                        </a>
                        <!--优品汇搜索-->
                        <div class="gx-top-search YPH-search">
                            <div class="gx-top-search-inp clearfix">
                                <form method="get" action="<?php echo $this->createAbsoluteUrl('site/index')?>">
                                    <div class="gx-top-search-inp-left">
                                        <input type="text" name="search" value="<?php echo CHtml::encode($this->getParam('search'))?>"/>
                                    <!--<span title="语音" class="voice-ioc"></span>-->
                                        <input type="hidden" name="category_id" value="<?php echo $this->getParam('category_id')?>">
                                    </div>
                                    <input type="submit" value="" class="gx-top-search-but" style="cursor:pointer" />
                                </form>
                            </div>
                        </div>
<!--                        <a class="logo fl" href="<?php //echo DOMAIN; ?>" title="盖网">
                            <img alt="盖网" src="<?php //echo DOMAIN; ?>/images/bgs/seckillLogo.png" width="220" height="85"/>
                        </a>
                        <div class="seckillDeclare fr">                        
                        <?php //if( Yii::app()->controller->id != 'seckill'  && $this->getAction()->getId() == 'index'){ ?>
                            <img alt="" src="<?php //echo DOMAIN; ?>/images/bgs/seckillDeclare.png" width="560" height="85"/>
                      <?php //} else{ ?>
                      <img alt="" src="<?php //echo DOMAIN; ?>/images/bgs/seckillDeclare.png" width="560" height="85"/>
                      <?php //} ?>
                        </div>				-->
                    </div>
                </div>
            <!--     <?php //if( Yii::app()->controller->id != 'seckill'  && $this->getAction()->getId() == 'index'){ ?>
                <div class="headerTag"></div>
                <?php // }?> -->

            </div>

            <?php echo $content; ?>

            <div class="clear"></div>
            <?php $this->renderPartial('//layouts/_footer_v20'); ?>
        </div>
    </body>
</html>
