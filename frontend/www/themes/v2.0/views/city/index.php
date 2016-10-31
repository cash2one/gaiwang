<!-- 导航start -->
<div class="gx-nav city-channel-nav clearfix">
    <div class="gx-nav-main">
        <div class="navbar">
            城市频道分类
            <ul class="navbar-list">
                <?php
                $cityRegion = CityshowRegion::getShowCityRegion();
                $city = Cityshow::getAllCity();
                ?>
                <?php if ($cityRegion): ?>
                    <?php foreach ($cityRegion as $rid => $region): ?>
                        <li>
                            <p class="nav-item"><?php echo $region ?><span class="arrow-right">&gt</span></p>
                            <?php if(!empty($city) && isset($city[$rid])): ?>
                            <div class="nav-box clearfix">
                                <ul class="region-box">
                                    <?php
                                    //按照省份分组
                                    $province = array();
                                    foreach ($city[$rid] as $v) {
                                        $province[$v['province']][] = $v;
                                    }
                                    ?>
                                    <?php foreach ($province as $pName => $v2): ?>
                                        <li class="clearfix">
                                            <span class="provice"><?php echo $pName ?></span>
                                            <div class="district-list">
                                                <?php //城市
                                                foreach ($v2 as $v3) {
                                                    echo CHtml::link($v3['city'], DOMAIN.'/city/'.$v3['encode'],array('target'=>'_blank'));
                                                }
                                                ?>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<!-- 导航end -->
<script type="text/javascript">
    $(function(){
        /*隐藏头部广告*/
        $(".clear-top-but").click(function(){
            $(".top-advert").slideToggle();
        });
        /*广告图轮播*/
        $('.city-channel-banner').flexslider({
            slideshowSpeed: 5000,
            animationSpeed: 400,
            directionNav: false,
            pauseOnHover: true,
            touch: true
        });
        $(".city-channel-banner .flex-control-nav").css("margin-left",-$(".city-channel-banner .flex-control-nav").width()/2);
        /*产品广告图轮播*/
        $('.prefecture-flex').flexslider({
            slideshowSpeed: 5000,
            animationSpeed: 400,
            directionNav: true,
            pauseOnHover: true,
            touch: true
        });
        $(".prefecture-flex .flex-control-nav").css("margin-left",-$(".prefecture-flex .flex-control-nav").width()/2);
    })
</script>
<!--主体start-->
<div class="gx-main">
    <div class="city-channel-banner">
        <?php //轮播图 ?>
        <?php
        $slides = WebAdData::getSlidesData('city-slide');
        ?>
        <ul class="slides">
            <?php foreach ($slides as $v): ?>
                <li>
                    <?php
                    if(!isset($v['picture'])) continue;
                    //1893x460
                    $img = CHtml::image(ATTR_DOMAIN . '/' . $v['picture'], Yii::t('site', $v['title']), array('width' => '1893', 'height' => '460'));
                    echo CHtml::link($img, $v['link'], array('title' => Yii::t('site', $v['title']), 'target' => $v['target']));
                    ?>
                    <?php if (!empty($v['cut'])): ?>
                    <ul class="advertise-box">

                        <?php foreach ($v['cut'] as $v2): ?>
                            <li>
                                <?php // 205x152.jpg
                                if(!isset($v2['picture'])) continue;
                                $img = CHtml::image(ATTR_DOMAIN . '/' . $v2['picture'], Yii::t('site', $v2['title']), array('width' => '205', 'height' => '152'));
                                echo CHtml::link($img, $v2['link'], array('title' => Yii::t('site', $v2['title']), 'target' => $v2['target']));
                                ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<!--    end 轮播图-->
    <div class="recomment-restaurants">
        <ul class="restaurants clearfix">
            <?php
            $data = WebAdData::getCommonData('city-slide-after',6);
            ?>
            <?php foreach($data as $item): ?>
            <li>
                <?php // 199x368
                $img = CHtml::image(ATTR_DOMAIN . '/' . $item['picture'], Yii::t('site', $item['title']), array('width' => '199', 'height' => '368'));
                echo CHtml::link($img, $item['link'], array('title' => Yii::t('site', $item['title']), 'target' => $item['target']));
                ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="w1200">
        <?php
        $data = WebAdData::getCommonData('city-special',10);
        if(!empty($data)):
        ?>
        <div class="featured-restaurants">
            <p class="title"><span>特色城市馆</span></p>
            <ul class="restaurants-box clearfix">
                <?php foreach($data as $item): ?>
                <li>
                    <?php
                    //70x70
                    $img = CHtml::image(ATTR_DOMAIN . '/' . $item['picture'], Yii::t('site', $item['title']), array('width' => '70', 'height' => '70','class'=>'restaurant-img'));
                    $div = '<div class="restaurant-name">
                            <p class="zh">'.$item['title'].'</p>
                            <p class="eg">'.substr(Tool::getPinyin(str_replace('馆','',$item['title']),false,true),0,10).'</p>
                            </div>';
                    echo CHtml::link($img.$div, $item['link'], array('title' => Yii::t('site', $item['title']), 'target' => $item['target']));
                    ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <?php foreach($cityRegion as $rid => $region): ?>
        <div class="prefecture">
            <p class="title"><span><?php echo $region ?></span></p>
            <div class="prefecture-contain clearfix">
                <div class="sidebar style1">
                    <div class="category">
                        <?php
                        if(isset($city[$rid])){
                            foreach($city[$rid] as $k => $v){
                                if($k > 5 ) break;
                                echo CHtml::link($v['city'].'馆',DOMAIN.'/city/'.$v['encode'],
                                    array('class'=>'item','target'=>'_blank'));
                            }
                        }

                        ?>
                    </div>
                    <div class="ad-area">
                        <?php
                          //205x205
                            $left = WebAdData::getCommonData(Tool::getPinyin($region).'-left',1);
                            $left = isset($left[0]) ? $left[0] : $left;
                            if(!empty($left)){
                                $img = CHtml::image(ATTR_DOMAIN . '/' . $left['picture'], Yii::t('site', $left['title']), array('width' => '205', 'height' => '205'));
                                echo CHtml::link($img, $left['link'], array('title' => Yii::t('site', $left['title']), 'target' => $left['target']));
                            }
                        ?>
                    </div>
                </div>
                <div class="main-content">
                    <div class="prefecture-flex">
                        <ul class="slides">
                            <?php $center = WebAdData::getCommonData(Tool::getPinyin($region) . '-center',3); ?>
                            <?php foreach($center as $v): ?>
                            <li>
                                <?php //372x558
                                $img = CHtml::image(ATTR_DOMAIN . '/' . $v['picture'], Yii::t('site', $v['title']), array('width' => '372', 'height' => '558'));
                                echo CHtml::link($img, $v['link'], array('title' => Yii::t('site', $v['title']), 'target' => $v['target']));
                                ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <ul class="product-list clearfix">
                        <?php $right = WebAdData::getCommonData(Tool::getPinyin($region) . '-right',6); ?>
                        <?php foreach($right as $v): ?>
                            <li>
                                <?php //198x273
                                $img = CHtml::image(ATTR_DOMAIN . '/' . $v['picture'], Yii::t('site', $v['title']), array('width' => '198', 'height' => '273'));
                                echo CHtml::link($img, $v['link'], array('title' => Yii::t('site', $v['title']), 'target' => $v['target']));
                                ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php
        $button = WebAdData::getCommonData('city-gaiwang-channel',3);
        if(!empty($button)):
        ?>
        <div class="featured-channel">
            <p class="title">盖象特色频道</p>
            <ul class="channel-list clearfix">

                <?php foreach($button as $v): ?>
                    <li>
                        <?php //400x222
                        $img = CHtml::image(ATTR_DOMAIN . '/' . $v['picture'], Yii::t('site', $v['title']), array('width' => '400', 'height' => '222'));
                        echo CHtml::link($img, $v['link'], array('title' => Yii::t('site', $v['title']), 'target' => $v['target']));
                        ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>
<!-- 主体end -->