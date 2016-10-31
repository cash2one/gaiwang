<?php
    if(isset($_GET['city']) && $_GET['city'] > 0 ){
        $city = $_GET['city'];
    } else{
        $city = $this->city;
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="<?php echo empty($this->keywords) ? '' : $this->keywords; ?>" />
    <meta name="Description" content="<?php echo empty($this->description) ? '' : $this->description; ?>" />
    <title><?php echo empty($this->title) ? '' : $this->title; ?></title>
    <?php $lang = Yii::app()->user->getState('selectLanguage'); ?>
    <?php if ($lang == HtmlHelper::LANG_EN): ?>
        <!--<link href="<?php /*echo DOMAIN; */?>/styles/encss/global.css" rel="stylesheet" type="text/css" />-->
        <link href="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/styles/module.css" rel="stylesheet" type="text/css" />
    <?php else: ?>
        <!--<link href="<?php /*echo DOMAIN.Yii::app()->theme->baseUrl; */?>/styles/global.css" rel="stylesheet" type="text/css" />-->
        <link href="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/styles/module.css" rel="stylesheet" type="text/css" />
    <?php endif; ?>
    <link href="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/styles/line.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/js/jquery-1.9.1.js" type="text/javascript"></script>
    <script src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/js/jquery.gate.common.js"></script>
    <script src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/js/jquery.flexslider-min.js"></script>
    <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/jquery.SuperSlide.2.1.1.js"></script>
    <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/lazyLoad.js"></script>
    <!--[if lt IE 9]>
    <style>
        /*IE 8 兼容rgba的样式*/
        .color-block { background:transparent; filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000,endColorstr=#99000000); zoom: 1; }
    </style>
    <![endif]-->
</head>

<body class="offline">
<!-- 头部start -->
<?php $this->renderPartial('//layouts/_top_v20'); ?>
<div class="line-head-bg clearfix">
    <div class="gx-top-logoSearch">
        <div class="gx-top-logoarea">

            <a href="<?php echo DOMAIN ?>" title="<?php echo Yii::t('site','盖象商城'); ?>" class="gx-logo"><img width="187" height="56" alt="<?php echo Yii::t('site','盖象商城'); ?>" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/images/bgs/top_logo.png" /></a>
            <div class="gx-top-extra">
                <span class="gx-top-extra-channel"><?php echo Yii::t('site','线下服务'); ?></span>
                <label><?php echo Yii::t('site','定位'); ?>:</label>
                <div class="dropdown">

                    <div class="dropdown-text">
                        <?php foreach($this->offlineCity as $fcity){
                            if($this->city == $fcity['city_id']) {
                                echo substr($fcity['name'],0,6);
                            }
                        };?>
                        <span class="dropdown-caret caret"></span></div>
                    <ul class="dropdown-list" style="display: none;">
                        <?php foreach($this->offlineCity as $fcity): ?>
                        <li><a <?php echo ($this->city == $fcity['city_id'])? 'class="curr"':'' ?> href="<?php echo $this->createAbsoluteUrl('index',array('city'=>$fcity['city_id'])) ?>" title="<?php echo $fcity['name']?>"><?php echo substr($fcity['name'],0,6)?></a></li>
                        <?php endforeach;?>
                    </ul>

                </div>
            </div>
        </div>
        <div class="gx-top-search">
            <div class="gx-top-search-inp" style="margin-bottom: 20px;">
                <form action="<?php echo $this->createAbsoluteUrl('list',array('city'=>$city))?>" method="post">
                <div class="gx-top-search-inp-left">
                    <input name="keyword" id="search_value" type="text" />
                    <span title="<?php echo Yii::t('site','语音'); ?>" class="voice-ioc"></span>
                </div>
                <input type="submit"  class="gx-top-search-btn" value="<?php echo Yii::t('site','搜索线下'); ?>">
                </form>
            </div>
        </div>
        <?php
        //搜索旁边的小广告
        $searchAds = WebAdData::getLogoData('top_search_ad');  //调用接口
        $searchAd = !empty($searchAds) && AdvertPicture::isValid($searchAds[0]['start_time'], $searchAds[0]['end_time']) ? $searchAds[0] : array();
        ?>
        <?php if(!empty($searchAd)): ?>
            <a href="<?php echo $searchAd['link'] ?>" title="<?php echo $searchAd['title'] ?>" target="<?php echo $searchAd['target'] ?>" class="gx-top-advert2">
                <img width="190" height="88" src="<?php echo ATTR_DOMAIN.'/'.$searchAd['picture']; ?>"/>
            </a>
        <?php endif; ?>
    </div>
</div>
<!-- 头部end -->
<!-- NAVBAR -->
<div class="navbar rel">
    <div class="navbar-inner">
        <dl>
            <dt><a href="<?php echo $this->createAbsoluteUrl('index',array('city'=>$this->city)) ?>" title="<?php echo Yii::t('site','盖网通联盟商户'); ?>"><?php echo Yii::t('site','盖网通联盟商户'); ?></a><div></div></dt>
            <?php foreach ($this->categorys as $category):?>
                <dd <?php if(isset($_GET['cat']) && $_GET['cat'] == $category['id']){ echo "class='selected'"; } ?> >
                    <a href="<?php echo $this->createAbsoluteUrl('list',array('cat'=>$category['id'],'city'=>$this->city)) ?>">
                        <i class="icon icon-<?php echo empty($category['bgclass']) ? 'food' : $category['bgclass']; ?>"></i><span><?php echo Yii::t('jms',$category['name'])?></span>
                    </a></dd>
            <?php endforeach;?>
        </dl>
    </div>
</div>
<!-- END NAVBAR -->
<?php echo $content; ?>

<?php $this->renderPartial('//layouts/_footer_v20'); ?>
</body>

</html>
