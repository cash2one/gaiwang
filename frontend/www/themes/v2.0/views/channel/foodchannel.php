<?php
/**
 * @author liao jiawei <569114018@qq.com>
 * Date: 2015/7/28
 * Time: 10:57
 */
?>
<script>
    $(function(){
        $(".food-left-floatLink a").hover(function(){
            $(this).addClass("food-linkSel");
        },function(){
            $(this).removeClass("food-linkSel");
        });
    })
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
    <div class="gx-nav food-nav clearfix">
        <div class="gx-nav-main">
            <div class="gx-nav-left food-nav-left">
                <?php echo Yii::t('channel','饮料食品分类'); ?>
                <div class="phone-nav-left-list food-nav-left-list">
                    <ul class="clearfix">
                        <?php if(!empty($channelNav)){
                            foreach($channelNav as $key => $value){  ?>
                                <li>
                                    <div class="phone-nav-item food-nav-item">
                                        <?php echo Tool::truncateUtf8String($value['name'],6); ?><ico></ico>
                                        <span class="phone-nav-item-img food-nav-item-img"></span>
                                    </div>
                                    <div class="phone-nav-item-child food-nav-item-child">
                                        <div>
                                            <?php if(!empty($value['childClass'])){
                                                foreach($value['childClass'] as $k => $v){ ?>
                                                    <?php echo CHtml::link(Yii::t('channel',$v['name']), $this->createAbsoluteUrl('/category/list', array('id' => $v['id']))); ?>
                                                <?php } } ?>
                                        </div>
                                        <?php if(isset($foodNavAdver[$value['id']]) && !empty($foodNavAdver[$value['id']])){ ?>
                                            <a href="<?php echo $foodNavAdver[$value['id']][0]['link'] ?>" target="<?php echo $foodNavAdver[$value['id']][0]['target'] ?>" >
                                                <img style="display: inline-block;margin-left:-40px;" class="food-nav-item-cpImg" src="<?php echo ATTR_DOMAIN.'/'.$foodNavAdver[$value['id']][0]['picture']; ?>"/>
                                            </a>
                                        <?php } ?>
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
                        <a <?php if($key == 0) echo "class='gx-nav-sel'" ?> target="<?php echo $value['target']; ?>" href="<?php echo $value['link']?>" title="<?php echo $value['title']?>"><?php echo Tool::truncateUtf8String($value['title'],4) ?></a>
                    <?php
                    }
                } ?>
            </div>
        </div>
    </div>
    <!-- 导航end -->

    <div class="indexBanner">
        <div class="phone-flexslider">
            <ul class="slides">

                <?php if(!empty($foodAdver)){
                    foreach($foodAdver as $key => $value){ ?>
                        <li style="background-color:<?php
                        if(!empty($value['background'])) {
                            echo $value['background'];
                        }else{
                            echo '#fdfcc6';
                        } ?>;">
                            <a href="<?php echo $value['link'] ?>" target="<?php echo $value['target'];?>" title="<?php echo $value['title'] ?>" class="food-banneritemImg">
                                <img width="840" height="396" src="<?php echo ATTR_DOMAIN.'/'.$value['picture']; ?>"/ >
                                <?php /*echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $value['picture'], 'c_fill,h_396,w_840'),'',array('width'=>'840px','height'=>'396px'));*/?>
                            </a>
                            <div class="smallAd ">
                                <?php for($i = 0; $i < 3; $i++){ ?>
                                    <?php if(isset($focusAdver[$i]) && !empty($focusAdver[$i])){ ?>
                                        <a href="<?php echo $focusAdver[$i]['link']; ?>"  target="<?php echo $focusAdver[$i]['target']; ?>" title="<?php echo $focusAdver[$i]['title']; ?>"><img width="180" height="131" src="<?php echo ATTR_DOMAIN.'/'.$focusAdver[$i]['picture']; ?>"/></a>
                                    <?php } }?>
                            </div>
                        </li>
                    <?php }
                } ?>

            </ul>
        </div>
    </div>

    <!-- 饮料食品主体start -->
    <div class="gx-main">
        <div class="gx-content">
            <!-- 发现美食start -->
            <div class="food-found">
                <div class="phone-title food-title clearfix"><?php echo Yii::t('channel','发现美食'); ?><img class="phone-infoImg" width="153" height="21" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/images/bgs/food_title1.png"/></div>
                <ul class="clearfix">

                    <?php if(isset($recommendData) && !empty($recommendData)){
                        foreach($recommendData as $key => $value){ ?>
                            <li>
                                <a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $value['id'])); ?>" target="_blank" title="<?php echo $value['name']; ?>">
                                    <img width="214" height="214" src="<?php echo IMG_DOMAIN.'/'.$value['thumbnail']; ?>"/>
                                    <span class="food-line"></span>
							<span class="food-found-info phone-product-info">
								<span class="phone-product-name"><?php echo Tool::truncateUtf8String($value['name'],13); ?></span>
                                <p>￥<span><?php echo $value['price']; ?></span></p>
							</span>
                                </a>
                            </li>
                        <?php }
                    } ?>

                </ul>
            </div>
            <!-- 发现美食end -->

            <!-- 地方特产start -->
            <div class="food-specialty">
                <div class="clearfix">
                    <div class="phone-title food-title food-title2"><?php echo Yii::t('channel','地方特产'); ?><img class="phone-infoImg" width="153" height="21" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/images/bgs/food_title2.png"/></div>
                    <div class="food-right-link">
                        <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 214)); ?>" target="_blank" title="">东北</a>&nbsp;|&nbsp;
                        <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 216)) ?>" target="_blank" title="">华北</a>&nbsp;|&nbsp;
                        <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 219)) ?>" target="_blank" title="">华南</a>&nbsp;|&nbsp;
                        <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 217)) ?>" target="_blank" title="">华东</a>&nbsp;|&nbsp;
                        <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 221)) ?>" target="_blank" title="">西南</a>
                    </div>
                </div>
                <div class="phone-content food-content clearfix">
                    <div class="phone-left">
                        <div class="phone-left-bigImg food-left-bigImg">
                            <?php if(!empty($nativeLeftTop)){ ?>
                                <a href="<?php echo $nativeLeftTop[0]['link'] ?>" target="<?php echo $nativeLeftTop[0]['target']; ?>" title="<?php echo $nativeLeftTop[0]['title'] ?>"><img width="240" height="240" src="<?php echo ATTR_DOMAIN.'/'.$nativeLeftTop[0]['picture'] ?>"/></a>
                            <?php } ?>
                            <div class="phone-fdBgColor food-fdBgColor"></div>
                            <div "<?php if(!empty($nativeLeftTop[0]['background'])) echo "style='background-color:{$value['background']}'"; ?> class="phone-line food-line food-line1 clearfix">
                            <?php if(!empty($channelNativeText)){
                                foreach($channelNativeText as $key => $value){ ?>
                                    <a href="<?php echo $value['link'] ?>" target="<?php echo $value['target']; ?>" title="<?php echo $value['title']; ?>"><?php echo Tool::truncateUtf8String($value['title'],4) ?></a>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="phone-right clearfix">
                    <ul class="food-goodsList1">
                        <?php if(!empty($nativeMain)){
                            foreach($nativeMain as $key => $value){ ?>
                                <li>
                                    <a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $value['id'])); ?>" target="_blank" title="<?php echo $value['name']; ?>" >
                                        <img width="239" height="239" src="<?php echo IMG_DOMAIN.'/'.$value['thumbnail']; ?>"/>
									<span class="food-info">
										<span class="food-info-title phone-product-name"><?php echo Tool::truncateUtf8String($value['name'],14); ?></span>
										<p>￥<span><?php echo $value['price']; ?></span></p>
									</span>
                                    </a>
                                </li>
                            <?php }
                        } ?>
                    </ul>
                    <ul class="food-goodsList2">
                        <?php if(!empty($nativeRight)){
                            foreach($nativeRight as $key => $value){ ?>
                                <li class="food-goodsList2-li2">
                                    <a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $value['id'])); ?>" target="_blank" title="<?php echo $value['name']; ?>">
                                        <img src="<?php echo IMG_DOMAIN.'/'.$value['thumbnail']; ?>"/>
                                            <span class="phone-product-info food-goodsList2-info">
                                                <span class="phone-product-name"><?php echo Tool::truncateUtf8String($value['name'],13); ?></span>
                                                <p>￥<span><?php echo $value['price']; ?></span></p>
                                            </span>
                                    </a>
                                </li>
                            <?php }
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- 地方特产end -->

        <!-- 酒饮冲调start -->
        <div class="food-specialty">
            <div class="clearfix">
                <div class="phone-title food-title food-title2"><?php echo Yii::t('channel','酒饮冲调'); ?><img class="phone-infoImg" width="158" height="21" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/images/bgs/food_title3.png"/></div>
                <div class="food-right-link">
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 231)) ?>" target="_blank" title=""><?php echo Yii::t('channel','白酒'); ?>&nbsp;<?php echo Yii::t('channel','黄酒'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 232)) ?>" target="_blank" title=""><?php echo Yii::t('channel','冲调'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 234)) ?>" target="_blank" title=""><?php echo Yii::t('channel','咖啡'); ?>&nbsp;<?php echo Yii::t('channel','奶茶'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 235)) ?>" target="_blank" title=""><?php echo Yii::t('channel','茗茶'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 236)) ?>" target="_blank" title=""><?php echo Yii::t('channel','啤酒'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 237)) ?>" target="_blank" title=""><?php echo Yii::t('channel','葡萄酒'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 238)) ?>" target="_blank" title=""><?php echo Yii::t('channel','洋酒'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 239)) ?>" target="_blank" title=""><?php echo Yii::t('channel','饮料'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 836)) ?>" target="_blank" title=""><?php echo Yii::t('channel','矿泉水'); ?></a>
                </div>
            </div>
            <div class="phone-content food-content clearfix">
                <div class="phone-left">
                    <div class="phone-left-bigImg food-left-bigImg">
                        <?php if(!empty($drinkLeftTop)){ ?>
                            <a href="<?php echo $drinkLeftTop[0]['link']; ?>" target="<?php echo $drinkLeftTop[0]['target']; ?>" title="<?php echo $drinkLeftTop[0]['title']; ?>"><img width="240" height="360" src="<?php echo ATTR_DOMAIN.'/'.$drinkLeftTop[0]['picture']; ?>"/></a>
                        <?php } ?>
                        <div class="food-left-floatLink clearfix">
                            <?php if(!empty($channelDrinkText)){//food-linkSel
                                foreach($channelDrinkText as $key => $value){ ?>
                                    <a href="<?php echo $value['link'] ?>" target="<?php echo $value['target']; ?>" title=""><span><?php echo Tool::truncateUtf8String($value['title'],4) ?></span></a>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="phone-right clearfix">
                    <ul class="food-goodsList2 food-goodsList3">
                        <?php if(!empty($drinkMain)){
                            foreach($drinkMain as $key => $value){ ?>
                                <li class="food-goodsList2-li3">
                                    <a href= "<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $value['id'])); ?>" target="_blank" title="<?php echo $value['name']; ?>" >
                                        <img width="239" height="180" src="<?php echo IMG_DOMAIN.'/'.$value['thumbnail']; ?>"/>
									<span class="phone-product-info food-goodsList2-info">
										<span class="phone-product-name"><?php echo Tool::truncateUtf8String($value['name'],13); ?></span>
										<p>￥<span><?php echo $value['price'] ?></span></p>
									</span>
                                    </a>
                                </li>
                            <?php }
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- 酒饮冲调end -->

        <!-- 粮油调味start -->
        <div class="food-specialty">
            <div class="clearfix">
                <div class="phone-title food-title food-title2"><?php echo Yii::t('channel','粮油调味'); ?><img class="phone-infoImg" width="153" height="21" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/images/bgs/food_title4.png"/></div>
                <div class="food-right-link">
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 240)) ?>" target="_blank" title=""><?php echo Yii::t('channel','方便食品'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 241)) ?>" target="_blank" title=""><?php echo Yii::t('channel','米面杂粮'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 242)) ?>" target="_blank" title=""><?php echo Yii::t('channel','南北干货'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 243)) ?>" target="_blank" title=""><?php echo Yii::t('channel','食用油'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 244)) ?>" target="_blank" title=""><?php echo Yii::t('channel','调味品'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 245)) ?>" target="_blank" title=""><?php echo Yii::t('channel','有机食品'); ?></a>
                </div>
            </div>
            <div class="phone-content food-content clearfix">
                <div class="phone-left">
                    <div class="phone-left-bigImg food-left-bigImg">
                        <?php if(!empty($grainLeftTop)){ ?>
                            <a href="<?php echo $grainLeftTop[0]['link'] ?>" target="<?php echo $grainLeftTop[0]['target']; ?>" title="<?php echo $grainLeftTop[0]['title'] ?>"><img width="240" height="240" src="<?php echo ATTR_DOMAIN.'/'.$grainLeftTop[0]['picture'] ?>"/></a>
                        <?php } ?>
                        <div <?php if(!empty($grainLeftTop[0]['background'])) echo "style='background-color:{$grainLeftTop[0]['background']};'" ?> class="phone-fdBgColor food-fdBgColor"></div>
                        <div class="phone-line food-line clearfix">
                            <?php if(!empty($channelGrainText)){
                                foreach($channelGrainText as $key => $value){ ?>
                                    <a href="<?php echo $value['link'] ?>" target="<?php echo $value['target']; ?>" title=""><?php echo Tool::truncateUtf8String($value['title'],4) ?></a>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="phone-right clearfix">
                    <ul class="food-goodsList1">
                        <?php if(!empty($grainMain)){
                            foreach($grainMain as $key => $value){ ?>
                                <li>
                                    <a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $value['id'])); ?>" target="_blank" title="<?php echo $value['name']; ?>" >
                                        <img width="239" height="239" src="<?php echo IMG_DOMAIN.'/'.$value['thumbnail']; ?>"/>
									<span class="food-info">
										<span class="food-info-title phone-product-name"><?php echo Tool::truncateUtf8String($value['name'],13); ?></span>
										<p>￥<span><?php echo $value['price']; ?></span></p>
									</span>
                                    </a>
                                </li>
                            <?php }
                        } ?>
                    </ul>
                    <ul class="food-goodsList2">
                        <?php if(!empty($grainRight)){
                            foreach($grainRight as $key => $value){ ?>
                                <li class="food-goodsList2-li2">
                                    <a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $value['id'])); ?>" target="_blank" title="<?php echo $value['name']; ?>">
                                        <img src="<?php echo IMG_DOMAIN.'/'.$value['thumbnail']; ?>"/>
                                            <span class="phone-product-info food-goodsList2-info">
                                                <span class="phone-product-name"><?php echo Tool::truncateUtf8String($value['name'],13); ?></span>
                                                <p>￥<span><?php echo $value['price']; ?></span></p>
                                            </span>
                                    </a>
                                </li>
                            <?php }
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- 粮油调味end -->

        <!-- 休闲零食start -->
        <div class="food-specialty">
            <div class="clearfix">
                <div class="phone-title food-title food-title2"><?php echo Yii::t('channel','休闲零食'); ?><img class="phone-infoImg" width="158" height="21" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/images/bgs/food_title5.png"/></div>
                <div class="food-right-link">
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 246)) ?>" target="_blank" title=""><?php echo Yii::t('channel','饼干'); ?>  <?php echo Yii::t('channel','蛋糕'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 247)) ?>" target="_blank" title=""><?php echo Yii::t('channel','坚果炒货'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 248)) ?>" target="_blank" title=""><?php echo Yii::t('channel','蜜饯果脯'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 249)) ?>" target="_blank" title=""><?php echo Yii::t('channel','肉干肉松'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 250)) ?>" target="_blank" title=""><?php echo Yii::t('channel','糖果、'); ?><?php echo Yii::t('channel','巧克力'); ?></a>&nbsp;|&nbsp;
                    <a href="<?php echo $this->createAbsoluteUrl('/category/list', array('id' => 251)) ?>" target="_blank" title=""><?php echo Yii::t('channel','休闲食品'); ?></a>

                </div>
            </div>
            <div class="phone-content food-content clearfix">
                <div class="phone-left">
                    <div class="phone-left-bigImg food-left-bigImg">
                        <?php if(!empty($snacksLeftTop)){ ?>
                            <a href="<?php echo $snacksLeftTop[0]['link']; ?>" target="<?php echo $snacksLeftTop[0]['target']; ?>" title="<?php echo $snacksLeftTop[0]['title']; ?>"><img width="240" height="360" src="<?php echo ATTR_DOMAIN.'/'.$snacksLeftTop[0]['picture']; ?>"/></a>
                        <?php } ?>
                        <div class="food-left-floatLink clearfix">
                            <?php if(!empty($channelSnacksText)){
                                foreach($channelSnacksText as $key => $value){ ?>
                                    <a href="<?php echo $value['link'] ?>" target="<?php echo $value['target']; ?>" title="<?php echo $value['title'] ?>"><span><?php echo Tool::truncateUtf8String($value['title'],4) ?></span></a>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="phone-right clearfix">
                    <ul class="food-goodsList2 food-goodsList3">
                        <?php if(!empty($snacksMain)){
                            foreach($snacksMain as $key => $value){ ?>
                                <li class="food-goodsList2-li3">
                                    <a href= "<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $value['id'])); ?>" target="_blank" title="<?php echo $value['name']; ?>" >
                                        <img width="239" height="180" src="<?php echo IMG_DOMAIN.'/'.$value['thumbnail']; ?>"/>
									<span class="phone-product-info food-goodsList2-info">
										<span class="phone-product-name"><?php echo Tool::truncateUtf8String($value['name'],13); ?></span>
										<p>￥<span><?php echo $value['price'] ?></span></p>
									</span>
                                    </a>
                                </li>
                            <?php }
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- 休闲零食end -->
    </div>
</div>
<!-- 饮料食品主体end -->
</div>