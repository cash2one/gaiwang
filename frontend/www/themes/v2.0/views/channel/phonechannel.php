<script>
    function adjust(){
        var ZX=parseInt($(".phone-nav-left-list").offset().left);
        var YX=parseInt($(".smallAd").offset().left);

        $(".indexBanner .phone-flexslider .flex-direction-nav .flex-prev").css("left",(ZX+210));//左边边切换图标位置
        $(".indexBanner .phone-flexslider .flex-direction-nav .flex-next").css("left",(YX-40));//右边切换图标位置
    }

    window.onload=function(){
        window.onresize = adjust;
        adjust();
    }
</script>
<div class="main clearfix">

    <!-- 导航start -->
    <div class="gx-nav clearfix">
        <div class="gx-nav-main">
            <div class="gx-nav-left phone-nav-left">
                <?php echo Yii::t('channel','手机数码分类'); ?>
                <div class="phone-nav-left-list">
                    <ul class="clearfix">
                        <?php if(!empty($channelNav)){
                            foreach($channelNav as $key => $value){  ?>
                                <li>
                                    <div class="phone-nav-item">
                                        <?php echo Tool::truncateUtf8String($value['name'],6,''); ?><ico></ico>
                                        <span class="phone-nav-item-img"></span>
                                    </div>
                                    <div class="phone-nav-item-child">
                                        <?php if(!empty($value['childClass'])){
                                            foreach($value['childClass'] as $k => $v){ ?>
                                                <?php echo CHtml::link(Yii::t('site',$v['name']), $this->createAbsoluteUrl('/category/list', array('id' => $v['id']),array('target'=>'_blank'))); ?>
                                            <?php } } ?>
                                    </div>
                                </li>
                            <?php }
                        } ?>
                    </ul>
                </div>
            </div>
            <div class="gx-nav-right clearfix">

                <?php if(!empty($topText)){
                    foreach($topText as $key => $value) {
                        ?>
                        <a <?php if($key == 0) echo "class='gx-nav-sel'" ?> href="<?php echo $value['link']?>" title="<?php echo $value['title']?>" target="<?php echo $value['target'] ?>"><?php echo Tool::truncateUtf8String($value['title'],4,''); ?></a>
                    <?php
                    }
                } ?>

            </div>
        </div>
    </div>
    <!-- 导航end -->

    <div class="indexBanner">
        <div class="phone-flexslider">
            <ul class="slides"><?php if(!empty($value['background'])) echo "style='background-color:{$value['background']}'"; ?>
                <?php if(!empty($phoneAdver)){
                    foreach($phoneAdver as $key => $value){ ?>
                        <li style="background-color:<?php
                        if(!empty($value['background'])) {
                            echo $value['background'];
                        }else{
                            echo '#c7d4f4';
                        } ?>;">
                            <a href="<?php echo $value['link'] ?>" title="<?php echo $value['title'] ?>" target="<?php echo $value['target'] ?>"><img src="<?php echo ATTR_DOMAIN.'/'.$value['picture']; ?>" alt="" width="840" height="396"/></a>
                            <div class="smallAd ">
                                <?php for($i = 0; $i < 3; $i++){ ?>
                                    <?php if(isset($focusAdver[$i]) && !empty($focusAdver[$i])){ ?>
                                        <a href="<?php echo $focusAdver[$i]['link']; ?>"  target="<?php echo $focusAdver[$i]['target']; ?>" title="<?php echo $focusAdver[$i]['title']; ?>"><img src="<?php echo ATTR_DOMAIN.'/'.$focusAdver[$i]['picture']; ?>"  alt="" width="180" height="131" /></a>
                                    <?php } }?>
                            </div>
                        </li>
                    <?php }
                } ?>
            </ul>
        </div>
    </div>

    <!-- 手机数码主体start -->
    <div class="gx-main">
        <div class="gx-content">
            <!-- 热门推荐start -->
            <div class="phone-recommend">
                <div class="phone-title"><?php echo Yii::t('channel','热门推荐'); ?></div>
                <ul class="clearfix">
                    <?php if(isset($recommendData) && !empty($recommendData)){
                        foreach($recommendData as $key => $value){ ?>
                            <li>
                                <a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $value['id'])); ?>" target="_blank" title="<?php echo $value['name']; ?>"><img width="212" height="212" src="<?php echo IMG_DOMAIN.'/'.$value['thumbnail']; ?>"/></a>
                                <div class="phone-recommend-info">
                                    <div class="con">
                                        <a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $value['id'])); ?>" title="<?php echo $value['name']; ?>" target="_blank"><span class="phone-product-name"><?php echo Tool::truncateUtf8String($value['name'],30,'') ?></span></a>
                                        ￥<?php echo $value['price'] ?>
                                    </div>
                                </div>
                            </li>
                        <?php }
                    } ?>
                </ul>
            </div>
            <!-- 热门推荐end -->

            <!-- 手机start -->
            <div class="phone-module">
                <div class="phone-title clearfix"><?php echo Yii::t('channel','手机'); ?><img class="phone-infoImg" width="160" height="21" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/images/bgs/phone_title1.png"/></div>
                <div class="phone-content clearfix">
                    <div class="phone-left">
                        <div class="phone-left-bigImg">
                            <?php if(!empty($phoneLeftTop)){ ?>
                            <a href="<?php echo $phoneLeftTop[0]['link'] ?>" target="<?php echo $phoneLeftTop[0]['target']; ?>" title="<?php echo $phoneLeftTop[0]['title'] ?>">
                                <img width="240" height="450" src="<?php echo ATTR_DOMAIN.'/'.$phoneLeftTop[0]['picture']; ?>"/></a>
                            <?php } ?>
                            <div class="phone-fdBgColor"></div>
                            <div class="phone-line clearfix">
                                <?php if(!empty($channelPhoneText)){
                                    foreach($channelPhoneText as $key => $value){ ?>
                                    <a href="<?php echo $value['link'] ?>" target="<?php echo $value['target']; ?>" title=""><?php echo Tool::truncateUtf8String($value['title'],4,'') ?></a>
                                <?php }
                                } ?>
                            </div>
                        </div>
                            <?php if(!empty($phoneLeftDown)){ ?>
                        <a href="<?php echo $phoneLeftDown[0]['link'] ?>"  target="<?php echo $phoneLeftDown[0]['target']; ?>" title="<?php echo $phoneLeftDown[0]['title'] ?>">
                            <img width="240" height="151" src="<?php echo ATTR_DOMAIN.'/'.$phoneLeftDown[0]['picture']; ?>"/></a>
                        <?php } ?>
                    </div>
                    <div class="phone-right">
                        <div class="clearfix">
                            <div class="phone-activity phone-activity1">
                                <div class="phone-flexslider">
                                    <ul class="slides">

                                        <?php if(!empty($phoneLeftBig)){
                                            foreach($phoneLeftBig as $key => $value){ ?>
                                                <li>
                                                    <a href="<?php echo $value['link'] ?>" target="<?php echo $value['target']; ?>" title="<?php echo $value['title'] ?>"><img width="720" height="300" alt="<?php echo $value['title'] ?>" src="<?php echo ATTR_DOMAIN.'/'.$value['picture']; ?>"/></a>
                                                </li>
                                        <?php   }
                                        } ?>
                                    </ul>
                                </div>
                                <!--<a href="#" title="" class="phone-activity-but">开卖提醒<ico></ico></a>
                                <div class="phone-activity-countdown"><span>还有5天</span></div>-->
                            </div>
                            <div class="phone-product-right">
                                <?php if(!empty($phoneCate)){ ?>
                                <a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $phoneCate[0]['id'])); ?>" title="<?php echo $phoneCate[0]['name'] ?>">
									<span class="phone-product-info">
										<?php echo Tool::truncateUtf8String($phoneCate[0]['name'],13,'') ?>
										<p>￥<span><?php echo $phoneCate[0]['price'] ?></span></p>
									</span>
                                    <img width="239" height="239" src="<?php echo ATTR_DOMAIN.'/'.$phoneCate[0]['thumbnail']; ?>" />
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                        <ul class="phone-product clearfix">
                            <?php if(!empty($phoneCate)){
                                foreach($phoneCate as $key => $value){
                                    if($key > 0) { ?>
                                        <li>
                                            <a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $value['id'])); ?>" title="<?php echo $value['name'] ?>">
                                                <img width="239" height="239"
                                                     src="<?php echo IMG_DOMAIN.'/'.$value['thumbnail']; ?>"/>
									<span class="phone-product-info">
										<span class="phone-product-name"><?php echo Tool::truncateUtf8String($value['name'],11,'') ?></span>
										<p>￥<span><?php echo $value['price'] ?></span></p>
									</span>
                                            </a>
                                        </li>

                                    <?php
                                    }
                                }
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- 手机end -->

            <!-- 摄影摄像start -->
            <div class="phone-module">
                <div class="phone-title clearfix"><?php echo Yii::t('channel','摄影摄像'); ?><img class="phone-infoImg" width="125" height="21" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/images/bgs/phone_title2.png"/></div>
                <div class="phone-content clearfix">
                    <div class="phone-left">
                        <div class="phone-left-bigImg phone-left-bigImg2">
                            <?php if(!empty($photographyLeftTop)){ ?>
                            <a href="<?php echo $photographyLeftTop[0]['link'] ?>" target="<?php echo $photographyLeftTop[0]['target']; ?>" title="<?php echo $photographyLeftTop[0]['title'] ?>">
                                <img width="240" height="300" src="<?php echo ATTR_DOMAIN.'/'.$photographyLeftTop[0]['picture']; ?>"/></a>
                            <?php } ?>
                            <div class="phone-fdBgColor"></div>
                            <div class="phone-line phone-line2 clearfix">
                                <?php if(!empty($channelPhotographyText)){
                                    foreach($channelPhotographyText as $key => $value) { ?>
                                        <a href="<?php echo $value['link'] ?>" target="<?php echo $value['target']; ?>" title="<?php echo $value['title']; ?>"><?php echo Tool::truncateUtf8String($value['title'],4,'') ?></a>
                                    <?php
                                    }
                                } ?>
                            </div>
                        </div>
                    </div>
                    <div class="phone-right">
                        <div class="clearfix">
                            <div class="phone-activity phone-activity2">
                                <div class="phone-flexslider">
                                    <ul class="slides">
                                        <?php if(!empty($photographyLeftBig)){
                                            foreach($photographyLeftBig as $key => $value) {
                                                ?>
                                                <li>
                                                    <a href="<?php echo $value['link'] ?>" target="<?php echo $value['target']; ?>" title="<?php echo $value['title'] ?>"><img width="480" height="300" alt="<?php echo $value['title'] ?>"
                                                                              src="<?php echo ATTR_DOMAIN.'/'.$value['picture']; ?>"/></a>
                                                </li>
                                            <?php
                                            }
                                        } ?>
                                    </ul>
                                </div>
                                <!--<a href="#" title="" class="phone-activity-but phone-activity-but2">立即抢购<ico></ico></a>-->
                            </div>
                            <div class="phone-product-right phone-product-right2">
                                <?php if(!empty($photographyLeftRight)){ ?>
                                <a href="<?php echo $photographyLeftRight[0]['link'] ?>" title="<?php echo $photographyLeftRight[0]['title'] ?>" target="<?php echo $photographyLeftRight[0]['target'] ?>">
                                    <img width="479" height="300" src="<?php echo ATTR_DOMAIN.'/'.$photographyLeftRight[0]['picture']; ?>"/>
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <ul class="phone-product phone-product2 clearfix">

                        <?php if(!empty($photographyCate)){
                            foreach($photographyCate as $key => $value) {
                                ?>
                                <li>
                                    <a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $value['id'])); ?>" title="<?php echo $value['name'];?>">
                                        <img width="239" height="239"
                                             src="<?php echo IMG_DOMAIN.'/'.$value['thumbnail']; ?>"/>
									<span class="phone-product-info">
										<span class="phone-product-name"><?php echo Tool::truncateUtf8String($value['name'],12,'') ?></span>
                                        <p>￥<span><?php echo $value['price'] ?></span></p>
									</span>
                                    </a>
                                </li>
                            <?php
                            }
                        } ?>
                    </ul>
                </div>
            </div>
            <!-- 摄影摄像end -->

            <!-- 手机配件start -->
            <div class="phone-module">
                <div class="phone-title clearfix"><?php echo Yii::t('channel','手机配件'); ?><img class="phone-infoImg" width="105" height="21" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/images/bgs/phone_title3.png"/></div>
                <div class="phone-content clearfix">
                    <div class="phone-left">
                        <div class="phone-left-bigImg">
                            <?php if(!empty($partsLeftTop)){ ?>
                            <a href="<?php echo $partsLeftTop[0]['link'];?>" target="<?php echo $partsLeftTop[0]['target'];?>" title="<?php echo $partsLeftTop[0]['title'];?>"><img width="240" height="450" src="<?php echo ATTR_DOMAIN.'/'.$partsLeftTop[0]['picture']; ?>"/></a>
                            <?php } ?>
                            <div class="phone-fdBgColor"></div>
                            <div class="phone-line phone-line2 clearfix">
                                <?php if(!empty($channelPartsText)){
                                    foreach($channelPartsText as $key => $value) { ?>
                                        <a href="<?php echo $value['link'] ?>" target="<?php echo $value['target']; ?>" title="<?php echo $value['title']; ?>"><?php echo Tool::truncateUtf8String($value['title'],4,'') ?></a>
                                    <?php
                                    }
                                } ?>
                            </div>
                        </div>
                        <?php if(!empty($partsLeftDown)){ ?>
                        <a href="<?php echo $partsLeftDown[0]['link']?>" target="<?php echo $partsLeftDown[0]['target']?>" title="<?php echo $partsLeftDown[0]['title']?>">
                            <img width="240" height="151" src="<?php echo ATTR_DOMAIN.'/'.$partsLeftDown[0]['picture']; ?>"/></a>
                        <?php } ?>
                    </div>
                    <div class="phone-right">
                        <div class="clearfix">
                            <div class="phone-activity phone-activity1">
                                <div class="phone-flexslider">
                                    <ul class="slides">
                                        <?php if(!empty($partsLeftBig)){
                                            foreach($partsLeftBig as $key => $value) {
                                                ?>
                                                <li>
                                                    <a href="<?php echo $value['link'] ?>" target="<?php echo $value['target']; ?>" title="<?php echo $value['title'] ?>"><img width="720" height="300" alt="<?php echo $value['title'] ?>"
                                                                              src="<?php echo ATTR_DOMAIN.'/'.$value['picture']; ?>"/></a>
                                                </li>
                                            <?php
                                            }
                                        } ?>
                                    </ul>
                                </div>
                                <!--<a href="#" title="" class="phone-activity-but">开卖提醒<ico></ico></a>
                                <div class="phone-activity-countdown"><span>还有5天</span></div>-->
                            </div>
                            <div class="phone-product-right">
                                <?php if(!empty($partsCate)){ ?>
                                <a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $partsCate[0]['id'])); ?>" title="<?php echo $partsCate[0]['name'];?>">
									<span class="phone-product-info">
										<?php echo Tool::truncateUtf8String($partsCate[0]['name'],12,'') ?>
										<p>￥<span><?php echo $partsCate[0]['price'];?></span></p>
									</span>
                                    <img width="239" height="239" src="<?php echo ATTR_DOMAIN.'/'.$partsCate[0]['thumbnail']; ?>"/>
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                        <ul class="phone-product clearfix">
                            <?php if(!empty($partsCate)){
                                foreach($partsCate as $key => $value) {
                                    if($key > 0) {
                                        ?>
                                        <li>
                                            <a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $value['id'])); ?>"
                                               title="<?php echo $value['name']; ?>">
                                                <img width="239" height="239"
                                                     src="<?php echo IMG_DOMAIN . '/' . $value['thumbnail']; ?>"/>
									<span class="phone-product-info">
										<span class="phone-product-name"><?php echo Tool::truncateUtf8String($value['name'], 12,'') ?></span>
                                        <p>￥<span><?php echo $value['price']; ?></span></p>
									</span>
                                            </a>
                                        </li>
                                    <?php
                                    }
                                }
                            } ?>

                        </ul>
                    </div>
                </div>
            </div>
            <!-- 手机配件end -->

            <!-- 数码配件start -->
            <div class="phone-module">
                <div class="phone-title clearfix"><?php echo Yii::t('channel','数码配件'); ?><img class="phone-infoImg" width="127" height="21" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/images/bgs/phone_title4.png"/></div>
                <div class="phone-content clearfix">
                    <div class="phone-left">
                        <div class="phone-left-bigImg phone-left-bigImg2">
                            <?php if(!empty($digitalLeftTop)){ ?>
                                <a href="<?php echo $digitalLeftTop[0]['link'] ?>" target="<?php echo $digitalLeftTop[0]['target']; ?>" title="<?php echo $digitalLeftTop[0]['title'] ?>">
                                    <img width="240" height="300" src="<?php echo ATTR_DOMAIN.'/'.$digitalLeftTop[0]['picture']; ?>"/></a>
                            <?php } ?>
                            <div class="phone-fdBgColor"></div>
                            <div class="phone-line phone-line2 clearfix">
                                <?php if(!empty($channelDigitalText)){
                                    foreach($channelDigitalText as $key => $value) { ?>
                                        <a href="<?php echo $value['link'] ?>" target="<?php echo $value['target']; ?>" title="<?php echo $value['title']; ?>"><?php echo Tool::truncateUtf8String($value['title'],4,'') ?></a>
                                    <?php
                                    }
                                } ?>
                            </div>
                        </div>
                    </div>
                    <div class="phone-right">
                        <div class="clearfix">
                            <div class="phone-activity phone-activity2">
                                <div class="phone-flexslider">
                                    <ul class="slides">
                                        <?php if(!empty($digitalLeftBig)){
                                            foreach($digitalLeftBig as $key => $value) {
                                                ?>
                                                <li>
                                                    <a href="<?php echo $value['link'] ?>" target="<?php echo $value['target']; ?>" title="<?php echo $value['title'] ?>"><img width="480" height="300" alt="<?php echo $value['title'] ?>"
                                                                                                                                      src="<?php echo ATTR_DOMAIN.'/'.$value['picture']; ?>"/></a>
                                                </li>
                                            <?php
                                            }
                                        } ?>
                                    </ul>
                                </div>
                                <!--<a href="#" title="" class="phone-activity-but phone-activity-but2">立即抢购<ico></ico></a>-->
                            </div>
                            <div class="phone-product-right phone-product-right2">
                                <?php if(!empty($digitalLeftRight)){ ?>
                                <a href="<?php echo $digitalLeftRight[0]['link']; ?>"  target="<?php echo $digitalLeftRight[0]['target']; ?>" title="<?php echo $digitalLeftRight[0]['title']; ?>">
                                    <img width="479" height="300" src="<?php echo ATTR_DOMAIN.'/'.$digitalLeftRight[0]['picture']; ?>"/>
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <ul class="phone-product phone-product2 clearfix">
                        <?php if(!empty($digitalCate)){
                            foreach($digitalCate as $key => $value) {
                                ?>
                                <li>
                                    <a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $value['id'])); ?>" title="<?php echo $value['name']; ?>">
                                        <img width="239" height="239"
                                             src="<?php echo IMG_DOMAIN.'/'.$value['thumbnail']; ?>"/>
									<span class="phone-product-info">
										<span class="phone-product-name"><?php echo Tool::truncateUtf8String($value['name'],13,'') ?></span>
                                        <p>￥<span><?php echo $value['price']; ?></span></p>
									</span>
                                    </a>
                                </li>
                            <?php
                            }
                        } ?>
                    </ul>
                </div>
            </div>
            <!-- 数码配件end -->
        </div>
    </div>
    <!-- 手机数码主体end -->


</div>