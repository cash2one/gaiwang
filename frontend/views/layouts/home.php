<?php
// 首页布局文件
/* @var $this Controller */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Author" content="<?php echo empty($this->author) ? '' : $this->author; ?>" />
        <meta name="Keywords" content="<?php echo empty($this->keywords) ? '' : $this->keywords; ?>" />
        <meta name="Description" content="<?php echo empty($this->description) ? '' : $this->description; ?>" />
        <title><?php echo empty($this->title) ? '' : $this->title; ?></title>
        <?php $lang = Yii::app()->user->getState('selectLanguage'); ?>
        <?php if ($lang == HtmlHelper::LANG_EN): ?>
            <link href="<?php echo DOMAIN; ?>/styles/encss/global.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo DOMAIN; ?>/styles/encss/module.css" rel="stylesheet" type="text/css" />
        <?php else: ?>
            <link href="<?php echo DOMAIN; ?>/styles/global.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo DOMAIN; ?>/styles/module.css" rel="stylesheet" type="text/css" />
        <?php endif; ?>
        <script>
            document.domain = "<?php echo substr(DOMAIN, 11) ?>";
        </script>
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <!--<script src="<?php //echo DOMAIN;  ?>/js/jquery-1.9.1.js" type="text/javascript"></script>-->
        <script src="<?php echo DOMAIN; ?>/js/jquery.gate.common.js" type="text/javascript"></script>
        <script src="<?php echo DOMAIN; ?>/js/jquery.flexslider-min.js" type="text/javascript"></script>        

        <script type="text/javascript">
            $(function() {
                /* 二级菜单*/
                $(".menuItem").each(function(index) {
                    $(this).hover(function() {
                        $(this).find('.firMenu').addClass("firMenuCurr");
                        $(this).find('.subMenu').show();
                    },
                            function() {
                                $(this).find('.firMenu').removeClass("firMenuCurr");
                                $(this).find('.subMenu').hide();
                            });
                });
                /*banner 轮播*/
                $(".flexslider01").flexslider({
                    slideshowSpeed: 5000,
                    animationSpeed: 400,
                    directionNav: false,
                    pauseOnHover: true,
                    touch: true
                });

                /*线下服务*/
                $(".nineBox li").hover(function() {
                    $(this).stop().fadeTo(500, 1).siblings().stop().fadeTo(500, 0.2);
                    $(this).children('.title').stop().animate({opacity: 0.5}, 300);
                }, function() {
                    $(this).stop().fadeTo(500, 1).siblings().stop().fadeTo(500, 1);
                    $(this).children('.title').stop().animate({opacity: 0}, 300);
                });

                /*楼层广告位轮播*/
                $(".flexslider02").flexslider({
                    slideshowSpeed: 5000,
                    animationSpeed: 400,
                    directionNav: false,
                    pauseOnHover: true,
                    touch: true
                });
            })
        </script>
        <!--处理IE6中透明图片兼容问题-->
        <!--[if IE 6]>
        <script type="text/javascript" src="../js/DD_belatedPNG.js" ></script>
        <script type="text/javascript">
        DD_belatedPNG.fix('.icon_v,.icon_v_h,.adbg,.gwHelp dl dd,.column .category li');
        </script>
        <![endif]-->
    </head>
    <body>
        <!--<div class="icon_v browserSug" style="display: none">温馨提示：您当前使用的浏览器版本过低，兼容性和安全性较差，盖象商城建议您升级: <a class="red" href="http://windows.microsoft.com/zh-cn/windows/upgrade-your-browser">IE8浏览器</a></div>-->
        </div>
        <div class="wrap">
            <div class="header">
                <?php $this->renderPartial('//layouts/_top'); ?>
                <?php $this->renderPartial('//layouts/_top2'); ?>
                <?php $this->renderPartial('//layouts/_nav'); ?>
            </div>    
            <?php $this->renderPartial('//layouts/_banner'); ?>
            <div class="main w1200">
                <?php echo $content; ?>
            </div>
            <?php $this->renderPartial('//layouts/_footer'); ?>
        </div>
        <?php $this->renderPartial('//layouts/_gotop'); ?>   
    </body>
</html>
