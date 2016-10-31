<?php 
    //首页搜索旁边的小广告
    $searchAds = WebAdData::getLogoData('top_search_ad');  //调用接口
    $searchAd = !empty($searchAds) && AdvertPicture::isValid($searchAds[0]['start_time'], $searchAds[0]['end_time']) ? $searchAds[0] : array();
?>
<div class="pages-header">
    <div class="w1200">
        <div class="pages-logo"><a href="<?php echo DOMAIN?>"><img src="<?php echo Yii::app()->theme->baseUrl?>/images/temp/register_logo.jpg" width="213" height="86" /></a></div>
        <div class="pages-title icon-cart">绑定银行卡</div>
        <?php if(!empty($searchAd)): ?>
            <div class="pages-top">
            <a href="<?php echo $searchAd['link'] ?>" title="<?php echo $searchAd['title'] ?>" target="<?php echo $searchAd['target'] ?>">
            <img src="<?php echo ATTR_DOMAIN.'/'.$searchAd['picture']; ?>" width="190" height="88" /></a>
            </div>
        <?php endif; ?>
    </div>
</div>	 