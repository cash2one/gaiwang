<!-- BANNER -->

<div class="offlineBanner" style="<?php echo (!empty($bannerAdv) || !empty($bestWelcomeRecommend) || !empty($bestRecommend) || !empty($notice)) ? 'display:block;' : 'display:none;'; ?>background: url(<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/images/bgs/slidebg1893x509.png) 50% 0 no-repeat;">
    <div class="inner">
        <ul class="slides">
            <?php if(!empty($bannerAdv)){
               foreach($bannerAdv as $key => $value) {
                   if(!empty($value['id'])) {
                       ?>
                       <li>
                           <a href="<?php echo $value['link']; ?>" target="_blank" >
                               <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $value['picture'], 'c_fill,h_450,w_913'),'',array('width'=>'913px','height'=>'450px','alt'=>$value['title']));?>
                           </a>
                       </li>
                   <?php
                   }
               }
            } ?>
        </ul>
        <!-- banner右侧的广告位start -->
        <div class="banner-right">
            <?php if(!empty($bestWelcomeRecommend)){  ?>
                    <div class="br-wrap">
                        <a href="<?php echo $bestWelcomeRecommend[0]['link']; ?>" title="<?php echo Yii::t('site', "最受欢迎推荐"); ?>">
                            <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $bestWelcomeRecommend[0]['picture'], 'c_fill,h_190,w_285'),'',array('width'=>'285px','height'=>'190px'));?>

                            <p class="color-block fw f16 wh tc lh36"><i class="icon icon-pop h16"></i><span class="h16"><?php echo Yii::t('site', "最受欢迎推荐"); ?></span>
                            </p>
                        </a>
                    </div>
                <?php }
            if(!empty($bestRecommend)){ ?>
            <div class="br-wrap">
                <a href="<?php echo $bestRecommend[0]['link']; ?>" title="<?php echo Yii::t('site', "配餐中心推荐"); ?>">
                    <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $bestRecommend[0]['picture'], 'c_fill,h_190,w_285'),'',array('width'=>'285px','height'=>'190px'));?>
                    <p class="color-block fw f16 wh tc lh36"><i class="icon icon-chef h16"></i><span class="h16"><?php echo Yii::t('site', "配餐中心推荐"); ?></span></p>
                </a>
            </div>
            <?php } ?>
            <!-- 公告滚动start -->
            <div class="banner-info">
                <div class="info-inner">
                    <div class="scrollbox">
                        <ul id="scrollMsg">
                            <?php if(!empty($notice)){ ?>
                                <?php foreach($notice as $key => $value){ ?>
                                <li><a href="<?php echo $value['link'] ?>" target="_blank"> <span>【<?php echo Yii::t('site', "公告"); ?>】</span><?php echo $value['title']; ?></a></li>
                            <?php }
                            } ?>
                        </ul>
                    </div>
                    <script type="text/javascript" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/js/jquery.rollGallery_yeso.js"></script>
                    <script type="text/javascript">
                        $(document).ready(function($) {
                            $("#scrollMsg").rollGallery({
                                direction: "top",
                                speed: 2000
                            });
                        });
                    </script>
                </div>
            </div>
            <!-- 公告滚动end -->
        </div>
        <!-- banner右侧的广告位end -->
        <script>
            $('.offlineBanner .inner').flexslider({
                animation: "slide",
                slideshowSpeed: 5000,
                directionNav: false,
                pauseOnHover: true,
                touch: true
            });
        </script>
    </div>
</div>
<!-- END BANNER -->
<?php $statusShow = (!empty($mainA) || !empty($mainB) || !empty($mainC) || !empty($mainD) || !empty($mainE) || !empty($mainF)) ? 'display:block;' : 'display:none;' ; ?>
<div class="hd" style="<?php echo $statusShow; ?>">
    <div class="w1200">
        <span class="hr"></span>
        <img width="461" height="138" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/images/bgs/restaurant-title.jpg" alt="<?php echo Yii::t('site', "舌尖上的餐厅"); ?>" />
        <span class="hr"></span>
    </div>
</div>
<!-- RESTAURANT LIST -->
<div class="restaurants wh fw">
    <div class="w1200" style="<?php echo $statusShow; ?>">
        <div class="r-left l rel mb10 mr10">
            <div class="r-info">
            <?php if(!empty($mainA)){ ?>
                <a class="r-name" href="#">
                    <h3><?php echo mb_substr($mainA[0]['title'],0,18,'utf-8') ?></h3>
                </a>
                <p><?php if($mainA[0]['text']) echo mb_substr($mainA[0]['text'],0,70,'utf-8'); ?></p>
            </div>
            <a class="r-bg" href="<?php echo $mainA[0]['link'] ?>">

                <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $mainA[0]['picture'], 'c_fill,h_390,w_390'),'',array('width'=>'390px','height'=>'390px','alt'=>$mainA[0]['title']));?>
            </a>
            <?php } ?>
        </div>
        <div class="r-right l rel">
            <ul class="r-right-items">
                <?php if(!empty($mainB)){ ?>
                <li class="w285 l rel mb10 mr10">
                    <a href="<?php echo $mainB[0]['link'] ?>" target="_blank">
                        <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $mainB[0]['picture'], 'c_fill,h_190,w_285'),'',array('width'=>'285px','height'=>'190px','alt'=>$mainB[0]['title']));?>
                    </a>
                    <p class="color-block lh36 fw wh tc"><?php echo mb_substr($mainB[0]['title'],0,16,'utf-8') ?></p>
                    <span class="r-right-recommend"><?php echo Yii::t('site', "推荐"); ?></span>
                </li>
                <?php }
                if(!empty($mainC)){ ?>
                <li class="w210 l rel mb10 mr10">
                    <a href="<?php echo $mainC[0]['link'] ?>" target="_blank">

                        <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $mainC[0]['picture'], 'c_fill,h_190,w_210'),'',array('width'=>'210px','height'=>'190px','alt'=>$mainC[0]['title']));?>
                    </a>
                    <p class="color-block lh36 fw wh tc"><?php echo mb_substr($mainC[0]['title'],0,10,'utf-8') ?></p>
                    <span class="hide"><?php echo Yii::t('site', "推荐"); ?></span>
                </li>
                <?php }
                if(!empty($mainD)){ ?>
                <li class="w285 l rel mb10 mr10">
                    <a href="<?php echo $mainD[0]['link'] ?>" target="_blank">

                        <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $mainD[0]['picture'], 'c_fill,h_190,w_285'),'',array('width'=>'285px','height'=>'190px','alt'=>$mainD[0]['title']));?>
                    </a>
                    <p class="color-block lh36 fw wh tc"><?php echo mb_substr($mainD[0]['title'],0,12,'utf-8') ?></p>
                    <span class="hide"><?php echo Yii::t('site', "推荐"); ?></span>
                </li>
                <?php }
                if(!empty($mainE)){
                    foreach($mainE as $key => $value){ ?>
                    <li class="w395 l rel mb10 mr10">
                        <a href="<?php echo $value['link'] ?>" target="_blank">

                            <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $value['picture'], 'c_fill,h_190,w_395'),'',array('width'=>'395px','height'=>'190px','alt'=>$value['title']));?>
                        </a>
                        <p class="color-block lh36 fw wh tc"><?php echo mb_substr($value['title'],0,12,'utf-8') ?></p>
                        <span class="hide"><?php echo Yii::t('site', "推荐"); ?></span>
                    </li>
                    <?php }
                } ?>
            </ul>
        </div>
        <!-- GOOD FOOD -->
        <div class="good-food cl">
            <?php if(!empty($mainF)){ ?>
            <a href="<?php echo $mainF[0]['link']; ?>" target="_blank">

                <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $mainF[0]['picture'], 'c_fill,h_170,w_1200'),'',array('width'=>'1200px','height'=>'170px','alt'=>$mainF[0]['title']));?>
            </a>
            <p><?php //if(isset($mainF[0]['text'])) echo mb_substr($mainF[0]['text'],0,200,'utf-8') ?></p>
            <?php } ?>
        </div>
        <!-- END GOOD FOOD -->
    </div>
</div>
<!-- END RESTAURANT LIST -->
<!-- LOCAL LIFE -->
<div class="hd">
    <div class="w1200">
        <span class="hr"></span>
        <img width="461" height="136" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/images/bgs/localLife-title.jpg" alt="<?php echo Yii::t('site', "本地生活"); ?> " />
        <span class="city"><?php echo Yii::t('site', "精彩")?><?php

            if($this->city){
                foreach($this->offlineCity as $fcity){
                    if($this->city == $fcity['city_id']) {
                        echo substr($fcity['name'],0,6);
                    }
                };
            }else{
                echo '广州';
            }

            ?></span>
        <span class="hr"></span>
    </div>
</div>
<div class="local-life">
    <div class="w1200">
        <div class="main">
            <?php if(!empty($newsFranchisees['list'])){ ?>
                <?php foreach($newsFranchisees['list'] as $key => $value){ ?>

                    <div class="item">
                        <div class="item-inner">
                            <a class="abs" href="<?php echo $value['id']; ?>" target="_blank" title="<?php echo $value['name']; ?>">
                            <div class="info cl">
                                <div class="clearfix">
                                    <a class="logo" href="<?php echo $value['id']; ?>" target="_blank" title="<?php echo $value['name'];?>">
                                        <?php echo CHtml::image(Tool::showImg($value['logo'], 'c_fill,h_68,w_138'),'',array('width'=>'138px','height'=>'68px','alt'=>$value['name']));?>
                                    </a>
                                    <div class="left-box">
                                        <em class="discount"><?php echo ($value['member_discount']/10).Yii::t('site', "折"); ?></em>
                                    </div>
                                </div>
                                <div class="description cl"><?php echo $value['summary']; ?></div>
                                <div class="right-box">
                                    <p class="views" style="color:#000000"><?php echo $value['visit_count'].Yii::t('site', "次"); ?></p>
                                </div>
                                <b class="tag <?php echo $value['bussbgclass']; ?>"></b>
                            </div>
                            </a>
                            <a class="abs" href="<?php echo $value['id']; ?>" target="_blank" title="<?php echo $value['name']; ?>">
                                <?php echo CHtml::image(Tool::showImg($value['thumbnail'], 'c_fill,h_210,w_610'),'',array('width'=>'610px','height'=>'210px','alt'=>$value['name']));?>
                            </a>
                        </div>
                    </div>

            <?php } ?>
            <div class="pageList mt50 clearfix" style="margin-top: 29px;margin-bottom: 29px;">
                <?php
                $this->widget('SLinkPager', array(
                    'cssFile' => false,
                    'header' => '',
                    'firstPageLabel' => Yii::t('category','首页'),
                    'lastPageLabel' => Yii::t('category','末页'),
                    'prevPageLabel' => Yii::t('category','上一页'),
                    'nextPageLabel' => Yii::t('category','下一页'),
                    'pages' => $newsFranchisees['page'],
                    'maxButtonCount' => 5,
                    'htmlOptions' => array(
                        'class' => 'yiiPageer',
                    )
                ));
                ?>
                </div>
            <?php
            } ?>
        </div>
        <?php if(!empty($cityRecommends)) {
         ?>
        <div class="side">
            <h3 class="title"><?php echo Yii::t('site', "盖网推荐"); ?></h3>

            <?php foreach ($cityRecommends as $key => $recommend) { ?>

                <div class="sd-item">
                    <a href="<?php echo $this->createAbsoluteUrl('view',array('id'=>$recommend['id']));?>" target="_blank" title="<?php echo $recommend['name']; ?>">
                        <?php $url = !empty($recommend['logo']) ? Tool::showImg(ATTR_DOMAIN . '/'.$recommend['logo'], 'c_fill,h_110,w_220') : DOMAIN.'/images/bgs/seckill_product_bg.png';
                        echo CHtml::image($url,'',array('width'=>'220px','height'=>'110px','alt'=>$recommend['name']));?>
                    </a>
                    <p class="color-block fw wh tc"><?php echo Tool::truncateUtf8String($recommend['name'],15); ?></p>
                </div>
                <?php } ?>
        </div>
        <?php } ?>
    </div>
</div>
<!-- END LOCAL LIFE -->
<script>
$(function(){

    LAZY.init();
    LAZY.run();
})
</script>
