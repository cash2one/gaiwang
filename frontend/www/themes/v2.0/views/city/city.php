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
            directionNav: true,
            pauseOnHover: true,
            touch: true
        });
        $(".flex-control-nav").css("margin-left",-$(".flex-control-nav").width()/2);
        /*列表边框样式*/
        $(".goods-list-main li").hover(function(){
            $(this).find(".goods-list-border").show();
        },function(){
            $(this).find(".goods-list-border").hide();
        });
    })
</script>
<!--主体start-->
<div class="gx-main">
    <div class="restaurant-wrap">
        <div class="w1200">
           <?php $bgImg= !empty($cityInfo['background_img']) ? $cityInfo['background_img'] :'';  ?>
           <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $bgImg, 'c_fill,h_126,w_1200',array('class'=>'restaurant-img')),$cityInfo['title']);?>
        </div>
    </div>
    <div class="city-channel-banner">
        <ul class="slides">
        <?php 
            $bannerArr=unserialize($cityInfo['top_banner']);
              if(!empty($bannerArr)):
                foreach ($bannerArr as $k => $v):
                  $imgUrl=isset($v['ImgUrl']) ? $v['ImgUrl'] :'';
                  $link=isset($v['Link']) ? $v['Link'] :'';
           ?>
            <li>
               <!--  <a href="<?php echo $link;?>" title="<?php echo $cityInfo['title'];?>">
                   <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $imgUrl, 'c_fill,h_460,w_1893'),$cityInfo['title']);?>
                </a>-->  
                <?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $imgUrl, 'c_fill,h_460,w_1893'),$cityInfo['title']), $link, array('title' => Yii::t('site', $cityInfo['title']), 'target' => '_blank'));  ?>
            </li>
         <?php endforeach;endif;?>  
        </ul>
    </div>
    <div class="w1200">
       <?php if(!empty($cityGoods)):
              foreach ($cityGoods as $k =>$v):
               ?>
        <div class="channel-category">
            <p class="title"><?php echo $v['theme_name']?></p>
            <ul class="goods-list-main clearfix">
               <?php if(!empty($v['theme_goods'])):
                    
                    if(count($v['theme_goods']) > 10) $v['theme_goods']=array_slice($v['theme_goods'], 0,10);
                     foreach ($v['theme_goods'] as $g):
                      $img=!empty($g['thumbnail']) ? $g['thumbnail'] :'';
                  ?>
                 <li>
                    <?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $img, 'c_fill,h_225,w_225'), $g['goods_name'], array('height' => '225', 'width' => '225','class'=>'gs-list-bigImg')), $this->createAbsoluteUrl('goods/view', array('id' => $g['goods_id'])), array('title' => $g['goods_name'])); ?>
                    <div class="goods-list-info">
                        <p class="gs-price"><?php echo HtmlHelper::formatPrice($g['price']);?></p>
                        <p class="gs-details"><?php echo $g['goods_name']?></p>
                        <a href="<?php echo $this->createAbsoluteUrl('shop/product', array('id' =>$g['store_id']))?>" title="<?php echo $g['store_name']?>"><?php echo $g['store_name']?>&nbsp;></a>
                    </div>
                    <div class="goods-list-border"></div>
                 </li>
                <?php endforeach;?>
               <?php endif;?> 
            </ul>
        </div>
         <?php endforeach;?>
        <?php endif;?>
    </div>
</div>
<!-- 主体end -->