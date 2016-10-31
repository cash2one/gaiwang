<?php
//图片延迟加载
/** @var $this Controller */
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/lazyLoad.js');
?>
<!-- 限时秒杀模块statr -->
<script type="text/javascript">    
    $(function() {
        LAZY.init();
        LAZY.run();
    });
    
    $(function () {
        /*大广告图start*/
        $('.zy-banner').flexslider({
            slideshowSpeed: 5000,
            animationSpeed: 400,
            directionNav: false,
            pauseOnHover: true,
            touch: true,
        });
        /*大广告图end*/

        /*商品分类start*/
        $(".gx-nav-left").hover(function () {
            $(".gx-nav-left-list").show();
        }, function () {
            $(".gx-nav-left-list").hide();
        });
        $('.gx-nav-left-list li').hover(function () {
            $(this).find('.gx-nav-item').show();
            $(this).find(".gx-nav-class").addClass("gx-nav-classSel");

        }, function () {
            $(this).find('.gx-nav-item').delay(3000).hide();
            $(this).find(".gx-nav-class").removeClass("gx-nav-classSel");
        });
        /*商品分类end*/
    })

</script>
<style>
    .gx-nav-left-list{display: none;}
    .zy-productList2-zj img{height:100%;}
</style>
<?php $this->renderPartial('//layouts/_nav_v20'); ?>
<div class="zy-banner">
    <ul class="slides">

        <?php
        if (!empty($autotrophyAdver)) {
            foreach ($autotrophyAdver as $key => $value) {
                ?>
                <li style="background-color:<?php
                if (!empty($value['background'])) {
                    echo $value['background'];
                } else {
                    echo '#350000';
                }
                ?>;">
                    <a href="<?php echo $value['link'] ?>" target="<?php echo $value['target']; ?>" title="<?php echo $value['title'] ?>" class="food-banneritemImg">
                        <img width="1200" height="394" src="<?php echo ATTR_DOMAIN . '/' . $value['picture']; ?>"/ >
                        <?php /* echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $value['picture'], 'c_fill,h_396,w_840'),'',array('width'=>'840px','height'=>'396px')); */ ?>
                    </a>
                </li>
                <?php
            }
        }
        ?>

    </ul>
</div>

<!-- 首页主体start -->
<div class="zy-main">
    <img class="zy_title zy_title1" width="210" height="25" src="<?php echo DOMAIN . Yii::app()->theme->baseUrl; ?>/images/bgs/zy_title01.jpg" />
    <div class="zy-brand clearfix">
        <?php
        if (!empty($ownAdver)):
            ?>
            <?php foreach ($ownAdver as $a): ?>
                <a href="<?php echo $a['link'] ?>" title="" target="_blank"><img width="298" height="359" src="<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>"/></a>
            <?php endforeach; ?>
        <?php endif ?>
    </div>
    <img class="zy_title zy_title2" width="252" height="24" src="<?php echo DOMAIN . Yii::app()->theme->baseUrl; ?>/images/bgs/zy_title02.jpg" />
    <div class="zy-tj clearfix">
        <div class="zy-tj-left fl">
            <?php if (!empty($recommendLeftTopAdver)):?>
                <?php foreach ($recommendLeftTopAdver as $a): ?>
                    <a class="zy-img1" href="<?php echo $a['link'] ?>" title="" target="_blank"><img src="<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>"/></a>
                <?php endforeach; ?>      
            <?php else:?>
                    <a class="zy-img1" href="#" title="" style="width:237px;height:400px"></a>
            <?php endif;?>
            <?php if (!empty($recommendLeftUnderAdver)): ?>
                <?php foreach ($recommendLeftUnderAdver as $a): ?>
                    <a class="zy-img2" href="<?php echo $a['link'] ?>" title="" target="_blank"><img src="<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>"/></a>
                <?php endforeach; ?>
            <?php else:?>
                    <a class="zy-img2" href="#" title="" style="width:237px;height:155px"></a>
            <?php endif;?>
        </div>
        <div class="zy-tj-right fl">
            <div class="zy-tj-right-advert clearfix">
                <?php if (!empty($recommendMiddleTopAdver)): ?>
                    <?php foreach ($recommendMiddleTopAdver as $a): ?>
                        <a href="<?php echo $a['link'] ?>" class="zy-img3" title="" target="_blank"><img width="721" height="300" src="<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>"/></a>
                    <?php endforeach; ?>
                <?php else:?>
                        <a href="#" class="zy-img3"></a>
                <?php endif;?>
                <?php if (!empty($recommendRightTopAdver)): ?>
                    <?php foreach ($recommendRightTopAdver as $a): ?>
                        <a href="<?php echo $a['link'] ?>" class="zy-img4" title="" target="_blank"><img width="240" height="300" src="<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>"/></a>
                    <?php endforeach; ?>
                <?php else:?>
                        <a href="#" class="zy-img4"></a>
                <?php endif;?>
            </div>
                <?php if (!empty($recommendGoodsAdv)):?>
                  <div class="zy-productList zy-productList2-zj clearfix">
                   <?php foreach ($recommendGoodsAdv as $v):?>
                      <a href="<?php echo $v['link'] ?>" title="<?php echo $v['title'] ?>" target="_blank">
                            <img width="239" height="181" src="<?php echo ATTR_DOMAIN . '/' . $v['picture'] ?>"/>
                        </a>
                     <?php endforeach;?>
                     </div>
                <?php else:?>
                  <?php if (!empty($recommendGoods)):?>
                  <div class="zy-productList clearfix">
                     <?php foreach ($recommendGoods as $v): ?>
                        <a href="<?php echo $this->createAbsoluteUrl('goods/view', array('id' => $v['id'])) ?>" title="<?php echo $v['name'] ?>" target="_blank">
                            <img width="239" height="181" src="<?php echo IMG_DOMAIN . '/' . $v['thumbnail'] ?>"/>
                            <span class="zy-info">
                                <span class="zy-font1"><?php echo $v['name'] ?></span>
                                <span class="zy-font3">￥<?php echo $v['price'] ?></span>
                            </span>
                        </a>
                     <?php endforeach; ?>   
                   </div>   
                  <?php endif;?>
              <?php endif;?>  
        </div>        
    </div>
    <img class="zy_title zy_title2" width="195" height="25" src="<?php echo DOMAIN . Yii::app()->theme->baseUrl; ?>/images/bgs/zy_title03.jpg" />
    <div class="zy-tm">
        <div class="zy-tm-gz">
            <?php if (!empty($tmLeftTopAdver)): ?>
                <?php foreach ($tmLeftTopAdver as $a): ?>
                    <a href="<?php echo $a['link'] ?>" class="zy-img5" title="" target="_blank"><img width="240" height="300" src="<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>"/></a>
                <?php endforeach; ?>
            <?php else:?>
                    <a href="#" class="zy-img5"></a>
            <?php endif;?>
            <?php if (!empty($tmMiddleTopAdver)): ?>
                <?php foreach ($tmMiddleTopAdver as $a): ?>
                    <a href="<?php echo $a['link'] ?>" class="zy-img6" title="" target="_blank"><img width="481" height="300" src="<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>"/></a>
                <?php endforeach; ?>
            <?php else:?>
                    <a href="#" class="zy-img6"></a>
            <?php endif;?>
            <?php if (!empty($tmRightTopAdver)): ?>
                <?php foreach ($tmRightTopAdver as $a): ?>
                    <a href="<?php echo $a['link'] ?>" class="zy-img7" title="" target="_blank"><img width="479" height="300" src="<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>"/></a>
                <?php endforeach; ?>
            <?php else:?>
                    <a href="#" class="zy-img7"></a>
            <?php endif;?>
        </div>
    </div>
        <?php if (!empty($tmGoodsAdv)):?>
        <div class="zy-productList zy-productList2-zj zy-tm-productList clearfix">
              <?php foreach ($tmGoodsAdv as $v):?>
                <a href="<?php echo $v['link'] ?>" title="<?php echo $v['title'] ?>" target="_blank">
                    <img width="239" height="181" src="<?php echo ATTR_DOMAIN . '/' . $v['picture'] ?>"/>
                </a>
              <?php endforeach;?>
              </div>
         <?php else:?>
            <?php if (!empty($tmGoods)):?>
             <div class="zy-productList zy-tm-productList clearfix">
               <?php foreach ($tmGoods as $v): ?>
                <a href="<?php echo $this->createAbsoluteUrl('goods/view', array('id' => $v['id'])) ?>" title="<?php echo $v['name'] ?>" target="_blank">
                    <img width="239" height="181" src="<?php echo IMG_DOMAIN . '/' . $v['thumbnail'] ?>"/>
                    <span class="zy-info">
                        <span class="zy-font1"><?php echo $v['name'] ?></span>
                        <span class="zy-font3">￥<?php echo $v['price'] ?></span>
                    </span>
                </a>
             <?php endforeach; ?>
             </div>
         <?php endif;?>
         <?php endif;?>
    <img class="zy_title zy_title2" width="254" height="24" src="<?php echo DOMAIN . Yii::app()->theme->baseUrl; ?>/images/bgs/zy_title04.jpg" />
    <div class="zy-tj clearfix">
        <div class="zy-tj-left zy-tm-gz2 fl">
            <?php if (!empty($czLeftTopAdver)):?>
                <?php foreach ($czLeftTopAdver as $a): ?>
                    <a class="zy-img1" href="<?php echo $a['link'] ?>" title="" target="_blank"><img src="<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>"/></a>
                <?php endforeach; ?>                
            <?php else:?>
                    <a class="zy-img1" href="#" title="" style="width:237px;height:400px"></a>
            <?php endif;?>
            <?php if (!empty($czLeftUnderAdver)): ?>
                <?php foreach ($czLeftUnderAdver as $a): ?>
                    <a class="zy-img2" href="<?php echo $a['link'] ?>" title="" target="_blank"><img src="<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>"/></a>
                <?php endforeach; ?>
            <?php else:?>
                    <a class="zy-img2" href="#" title="" style="width:237px;height:155px"></a>
            <?php endif;?>
        </div>
        <div class="zy-tj-right fl">
            <div class="zy-tj-right-advert clearfix">
                <?php if (!empty($czMiddleTopAdver)): ?>
                    <?php foreach ($czMiddleTopAdver as $a): ?>
                        <a href="<?php echo $a['link'] ?>" class="zy-img3" title="" target="_blank"><img width="721" height="300" src="<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>"/></a>
                    <?php endforeach; ?>
                <?php else:?>
                        <a href="#" class="zy-img3"></a>
                <?php endif;?>
                <?php if (!empty($czRightTopAdver)): ?>
                    <?php foreach ($czRightTopAdver as $a): ?>
                        <a href="<?php echo $a['link'] ?>" class="zy-img4" title="" target="_blank"><img width="240" height="300" src="<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>"/></a>
                    <?php endforeach; ?>
                <?php else:?>
                        <a href="#" class="zy-img4"></a>
                <?php endif;?>
            </div>
                  <?php if (!empty($czGoodsAdv)):?>
                   <div class="zy-productList zy-productList2-zj clearfix">
                      <?php foreach ($czGoodsAdv as $v):?>
                        <a href="<?php echo $v['link'] ?>" title="<?php echo $v['title'] ?>" target="_blank">
                            <img width="239" height="181" src="<?php echo ATTR_DOMAIN . '/' . $v['picture'] ?>"/>
                        </a>
                      <?php endforeach;?>
                      </div>
                 <?php else:?>
                    <?php if (!empty($czGoods)):?>
                     <div class="zy-productList clearfix">
                       <?php foreach ($czGoods as $v): ?>
                        <a href="<?php echo $this->createAbsoluteUrl('goods/view', array('id' => $v['id'])) ?>" title="<?php echo $v['name'] ?>" target="_blank">
                            <img width="239" height="181" src="<?php echo IMG_DOMAIN . '/' . $v['thumbnail'] ?>"/>
                            <span class="zy-info">
                                <span class="zy-font1"><?php echo $v['name'] ?></span>
                                <span class="zy-font3">￥<?php echo $v['price'] ?></span>
                            </span>
                        </a>
                    <?php endforeach; ?>
                    </div>
                <?php endif;?>
              <?php endif;?>
        </div>
    </div>
    <img class="zy_title zy_title2" width="254" height="25" src="<?php echo DOMAIN . Yii::app()->theme->baseUrl; ?>/images/bgs/zy_title05.jpg" />
    <div class="zy-tm">
        <div class="zy-tm-gz">
            <?php if (!empty($msLeftTopAdver)): ?>
                <?php foreach ($msLeftTopAdver as $a): ?>
                    <a href="<?php echo $a['link'] ?>" class="zy-img5" title="" target="_blank"><img width="240" height="300" src="<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>"/></a>
                <?php endforeach; ?>
            <?php else:?>
                    <a href="#" class="zy-img5"></a>
            <?php endif;?>
            <?php if (!empty($msMiddleTopAdver)): ?>
                <?php foreach ($msMiddleTopAdver as $a): ?>
                    <a href="<?php echo $a['link'] ?>" class="zy-img6" title="" target="_blank"><img width="481" height="300" src="<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>"/></a>
                <?php endforeach; ?>
            <?php else:?>
                    <a href="#" class="zy-img6"></a>
            <?php endif;?>
            <?php if (!empty($msRightTopAdver)): ?>
                <?php foreach ($msRightTopAdver as $a): ?>
                    <a href="<?php echo $a['link'] ?>" class="zy-img7" title="" target="_blank"><img width="479" height="300" src="<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>"/></a>
                <?php endforeach; ?>
            <?php else:?>
                    <a href="#" class="zy-img7"></a>
            <?php endif;?>
        </div>
             <?php if (!empty($msGoodsAdv)):?>
              <div class="zy-productList zy-productList2-zj zy-tm-productList clearfix">
                  <?php foreach ($msGoodsAdv as $v):?>
                    <a href="<?php echo $v['link'] ?>" title="<?php echo $v['title'] ?>" target="_blank">
                        <img width="239" height="181" src="<?php echo ATTR_DOMAIN . '/' . $v['picture'] ?>"/>
                    </a>
                  <?php endforeach;?>
                  </div>
              <?php else:?>
                 <?php if (!empty($msGoods)):?>
                 <div class="zy-productList zy-tm-productList clearfix">
                   <?php foreach ($msGoods as $v): ?>
                    <a href="<?php echo $this->createAbsoluteUrl('goods/view', array('id' => $v['id'])) ?>" title="<?php echo $v['name'] ?>" target="_blank">
                        <img width="239" height="181" src="<?php echo IMG_DOMAIN . '/' . $v['thumbnail'] ?>"/>
                        <span class="zy-info">
                            <span class="zy-font1"><?php echo $v['name'] ?></span>
                            <span class="zy-font3">￥<?php echo $v['price'] ?></span>
                        </span>
                    </a>
                <?php endforeach; ?>
                </div>
            <?php endif;?>
         <?php endif;?>
    </div>
</div>