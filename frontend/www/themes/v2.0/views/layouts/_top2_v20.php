<?php
?>
<div class="gx-top-logoSearch clearfix">
    <a href="<?php echo DOMAIN ?>" title="<?php echo Yii::t('site','盖象商城') ?>" class="gx-top-logo" id="gai_link">
        <img width="187" height="56" alt="<?php echo Yii::t('site','盖象商城') ?>" src="<?php echo $this->theme->baseUrl.'/'; ?>images/bgs/top_logo.png"/>
    </a>
    <?php
    //logo 旁边的图片广告
    $logoAds = WebAdData::getLogoData('index-logo-ad');  //调用接口
    $logoAd = !empty($logoAds) && AdvertPicture::isValid($logoAds[0]['start_time'], $logoAds[0]['end_time']) ? $logoAds[0] : array();
    if($this->id=='city'){
        $logoAd = array();//城市频道不显示广告，显示固定文字
        echo '<span class="page-title">城市频道</span>';
    }
    ?>
    <?php if(!empty($logoAd)): ?>
        <a href="<?php echo $logoAd['link'] ?>" title="<?php echo $logoAd['title'] ?>" class="gx-top-advert1" target="<?php echo $logoAd['target'] ?>">
            <img width="150" height="70" src="<?php echo ATTR_DOMAIN.'/'.$logoAd['picture']; ?>"/>
        </a>
    <?php endif; ?>
    <div class="gx-top-search">
        <div class="gx-top-search-inp clearfix">
            <form id="home-form" action="<?php echo $this->createAbsoluteUrl('/search/search'); ?>" target="_blank" method="get">
                <div class="gx-top-search-inp-left">
                    <input  maxlength="50" type="text" placeholder="<?php echo Yii::t('site', '输入关键词进行搜索'); ?>" value="<?php echo isset($this->keyword) ? $this->keyword : ''; ?>" name="q"  accesskey="s" autofocus="true" />
                </div>
                <input type="submit" value="" class="gx-top-search-but" style="cursor:pointer"/>
            </form>
        </div>

        <div class="gx-top-search-tj">
            <?php if (!empty($this->globalkeywords)):
                 foreach ($this->globalkeywords as $k=> $val):
                     if($k>6) break;
                    echo CHtml::link(Tool::truncateUtf8String(Yii::t('site', $val),9), array('/search/search', 'q' => $val,'target'=>'_blank'));
                 endforeach;
             endif; ?>
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
<?php
//如果搜索关键词为空，从搜索热门词随机获取一个
Yii::app()->clientScript->registerScript('searchCheck','
$("#home-form").submit(function(){
    var q = $(this).find("input").val();
    if(q.length==0){
        var words = '.json_encode($this->globalkeywords).';
        var n = Math.floor(Math.random() * words.length + 1)-1;
        $(this).find("input[name=q]").val(words[n]);
    }
});
',CClientScript::POS_END);
?>