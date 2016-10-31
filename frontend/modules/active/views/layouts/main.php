<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="<?php echo $this->keywords; ?>" />
        <meta name="Description" content="<?php echo $this->description; ?>" />
        <title>盖象商城-优品汇</title>
		
        <link href="<?php echo CSS_DOMAIN2; ?>global.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo CSS_DOMAIN2; ?>module.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo CSS_DOMAIN2; ?>seckill.css" rel="stylesheet" type="text/css" />
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
                <?php $this->renderPartial('//layouts/_top'); ?>
                <div class="logoSearch w1200">
                    <!-- 秒杀活动头部 -->
                    <div class="seckillHeader clearfix">
                        <a class="logo fl" href="<?php echo DOMAIN; ?>" title="盖网">
                            <img alt="盖网" src="<?php echo DOMAIN; ?>/images/bgs/seckillLogo.png" width="220" height="85"/>
                        </a>
                        <div class="seckillDeclare fr">                        
                        <?php if( Yii::app()->controller->id != 'seckill'  && $this->getAction()->getId() == 'index'){ ?>
                            <img alt="" src="<?php echo DOMAIN; ?>/images/bgs/seckillDeclare.png" width="560" height="85"/>
                      <?php } else{ ?>
                      <img alt="" src="<?php echo DOMAIN; ?>/images/bgs/seckillDeclare.png" width="560" height="85"/>
                      <?php } ?>
                        </div>				
                    </div>
                </div>
            <!--     <?php if( Yii::app()->controller->id != 'seckill'  && $this->getAction()->getId() == 'index'){ ?>
                <div class="headerTag"></div>
                <?php }?> -->

            </div>

            <?php echo $content; ?>

            <div class="clear"></div>
            <?php $this->renderPartial('//layouts/_footer'); ?>
            <?php $this->renderPartial('//layouts/_gotop'); ?>
        </div>
    </body>
</html>
