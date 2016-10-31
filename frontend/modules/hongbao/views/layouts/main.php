<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="盖网,网上购物,网上商城,积分兑换,积分消费,手机,笔记本,电脑,数码,服装,手表,化妆品,保健品,盖象商城" />
        <meta name="Description" content="盖网,盖象商城-中国最大的网上购物及积分兑换消费商城，便捷，诚信的服务,为您提供愉悦的网上商城购物体验!" />
        <title>盖象商城</title>
        <link href="<?php echo DOMAIN; ?>/styles/global.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo DOMAIN; ?>/styles/module.css" rel="stylesheet" type="text/css" />
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <script src="<?php echo DOMAIN; ?>/js/jquery.gate.common.js" type="text/javascript"></script>
        <script src="<?php echo DOMAIN; ?>/js/jquery.flexslider-min.js"></script>
        <script src="<?php echo DOMAIN; ?>/js/jquery.nav.js"></script>

        <script type="text/javascript">
            $(function() {
                /*banner 轮播*/
                $(".flexslider03").flexslider({
                    slideshowSpeed: 5000,
                    animationSpeed: 400,
                    directionNav: false,
                    pauseOnHover: true,
                    touch: true
                });

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
            })
        </script>
        <!--处理IE6中透明图片兼容问题-->
        <!--[if IE 6]>
        <script type="text/javascript" src="../js/DD_belatedPNG.js" ></script>
        <script type="text/javascript">
        DD_belatedPNG.fix('.icon_v,.icon_v_h,.gwHelp dl dd,');
        </script>
        <![endif]-->
    </head>
    <body>
        <div class="wrap">
            <div class="header">
                <?php $this->renderPartial('//layouts/_top'); ?>
                <?php $this->renderPartial('/layouts/_nav'); ?>
            </div>	

            <?php echo $content; ?>

            <div class="clear"></div>

            <?php $this->renderPartial('//layouts/_footer'); ?><!--底部 begin-->
        </div>

        <?php $this->renderPartial('//layouts/_gotop'); ?><!-- 返回顶部 end-->
    </body>
</html>
