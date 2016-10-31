<?php
// 加盟商模块布局文件
/* @var $this Controller */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="<?php echo $this->keywords; ?>" />
        <meta name="Description" content="<?php echo $this->description; ?>" />
        <title><?php echo $this->pageTitle; ?></title>
        <link href="<?php echo CSS_DOMAIN; ?>global.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo CSS_DOMAIN; ?>module.css" rel="stylesheet" type="text/css" />
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <script>
            document.domain = "<?php echo substr(DOMAIN, 11) ?>";
        </script>
        <script src="<?php echo DOMAIN; ?>/js/jquery-gate.js" type="text/javascript"></script>
        <script src="<?php echo DOMAIN; ?>/js/jquery.flexslider-min.js" type="text/javascript"></script>
        <script src="<?php echo DOMAIN; ?>/js/jqery.offline.js" type="text/javascript"></script>
        <!--处理IE6中透明图片兼容问题-->
        <!--[if IE 6]>
        <script type="text/javascript" src="../js/DD_belatedPNG.js" ></script>
        <script type="text/javascript">
        DD_belatedPNG.fix('img,background,body,div,span,.trans,a,input,i');
        </script>
        <![endif]-->

    </head>
    <body>
        <div class="wrap olbg">
            <div class="header">
                <?php $this->renderPartial('//layouts/_top'); ?>
                <?php $this->renderPartial('//layouts/_top2'); ?>
                <?php $this->renderPartial('//layouts/_nav2'); ?>
            </div>
            <!--	首页轮播图 begin-->
            <div class="flexslider">
                <ul class="slides">
                    <?php
                    $advert = Advert::getConventionalAdCache('jms-index-top');  // 获取加盟商幻灯片广告缓存数据
                    $advert = isset($advert[0]) ? $advert : array();
                    if (!empty($advert)):
                        ?>
                        <?php foreach ($advert as $a): ?>
                            <?php if (AdvertPicture::isValid($a['start_time'], $a['end_time'])): ?>
                                <li <?php echo (isset($a['background']) && $a['background'] != '' ) ? ('style="background:' . $a['background']) : '' ?>">
                                    <a href="<?php echo $a['link'] ?>" title="<?php echo $a['title'] ?>" style="background-image:url(<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>)">
                                        <span class="dotbg"></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif ?>
                </ul>
            </div>
            <!--线下服务首页轮播图 end-->           
            <?php echo $content; ?>
            <?php
            $advertBottom = Advert::getConventionalAdCache('jms-index-bottom');  // 获取加盟商幻灯片广告缓存数据
            $advertBottom = isset($advertBottom[0]) ? $advertBottom[0] : array();
            if (!empty($advertBottom)):
                ?>
                <div class="offLineAd"><a href="<?php echo $advertBottom['link'] ?>" title="<?php echo $advertBottom['title'] ?>" target="_blank"><img width=1200 height=100 src="<?php echo ATTR_DOMAIN . '/' . $advertBottom['picture'] ?>" alt="<?php echo $advertBottom['title'] ?>"/></a></div>
            <?php else: ?>
                <div class="offLineAd"><a href="#" title="" target="_blank"><img width=1200 height=100 src="" alt=""/></a></div>
            <?php endif; ?>
            <div class="clear"></div>
            <?php $this->renderPartial('//layouts/_footer'); ?>
        </div>
    </body>
</html>
