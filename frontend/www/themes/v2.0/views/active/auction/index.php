<script type="text/javascript">
    $(function () {
        /*banner 轮播*/
        $(".jpBanner .phone-flexslider").flexslider({
            slideshowSpeed: 5000,
            animationSpeed: 400,
            pauseOnHover: true,
            touch: true,
            directionNav: true
        });

    })

</script>
<?php $status = AuctionData::checkActivityStatus($time);?>


<div class="indexBanner jpBanner">
    <div class="phone-flexslider">
        <ul class="slides clearfix">
            <?php
            if (!empty($picAdvert)):
                ?>
                <?php foreach ($picAdvert as $a): ?>
                    <li>
                        <a href="<?php echo $a['link'] ?>" title="" class="food-banneritemImg" target="_blank"><img width="1200" height="350" src="<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>"/></a>
                    </li>
                <?php endforeach; ?>
            <?php endif ?>

        </ul>
    </div>
</div>

<div class="gx-main jp-main">
    <div class="w1200">
        <?php if( $status == AuctionData::AUCTION_ACTIVE_STATUS_THREE){?>
            <div class="jp-title1"></div>
        <?php }else if($status == AuctionData::AUCTION_ACTIVE_STATUS_TWO){?>
            <div class="jp-title2"></div>
        <?php }else{?>
            <div class="jp-title3"></div>
        <?php }?>
            <?php if (!empty($some_product)): ?>
                <ul class="jp-list clearfix" id="more">
                    <?php
                    $now = time();
                    foreach ($some_product as $v):
                        $endTime = AuctionData::getAuctionEndTime($time['id'], $v['goods_id']);
                    ?>
                        <li>
                            <?php $url = Yii::app()->createUrl('/active/auction/detail', array('setting_id' => $v['rules_setting_id'], 'goods_id' => $v['goods_id']));?>
                            <?php if ($status == AuctionData::AUCTION_ACTIVE_STATUS_FOUR || $now >= $endTime){?>
                                <a href="javascript:void(0);">
                            <?php }else {?>
                                    <a href="<?php echo $url ;?>" target="_blank">
                            <?php }?>
                                <img class="lazy" alt="<?php echo $v['name'];?>" data-url="<?php echo IMG_DOMAIN . '/' . $v['thumbnail'] ?>" />
                                <span class="jp-bg"></span>
                                <span class="jp-title"><?php echo Tool::truncateUtf8String($v['name'], 20) ?></span>
                                
                                <span class="jp-info">                                    
                                    <?php echo Yii::t('auction', '起拍价');?>：<span class="jp-font1">￥<span><?php echo $v['start_price'] ?></span></span><br/>
                                    <?php if( $status == AuctionData::AUCTION_ACTIVE_STATUS_THREE):?>    
                                        <?php
                                        //$t = (strtotime($time['date_end'].' '.$time['end_time'])) - $now;
                                        $t = $endTime - time();
                                        if ($t > 0) {
                                            $d = floor($t / 86400);
                                            $h = floor($t / 3600);
                                            $m = floor($t / 60 % 60);
                                            $s = $t % 60;
                                            echo "<p class=\"remain-time remain-time2\" type=\"isCome\" id=\"" . $time['id'] . "\" data-time=\"{$t}\">距结束 {$d}天{$h}时{$m}分{$s}秒</p>";
                                            $blank = 1;
                                        }
                                        ?>
                                    <?php elseif($status == AuctionData::AUCTION_ACTIVE_STATUS_TWO):?>
                                        <?php
                                            $t = (strtotime($time['date_start'].' '.$time['start_time'])) - $now;
                                            if ($t > 0) {
                                                $d = floor($t / 86400);
                                                $h = floor($t / 3600);
                                                $m = floor($t / 60 % 60);
                                                $s = $t % 60;
                                                echo "<p class=\"remain-time remain-time2\" type=\"noCome\" id=\"" . $time['id'] . "\" data-time=\"{$t}\">还剩 {$d}天{$h}时{$m}分{$s}秒 开拍</p>";
                                                $blank = 1;
                                            }
                                        ?>
                                    <?php endif;?>
                                </span>
                                <?php
                                    $class = '';
                                    if ($status==AuctionData::AUCTION_ACTIVE_STATUS_TWO){
                                        $class = 'jp-ioc2';
                                    }
                                    if ($status==AuctionData::AUCTION_ACTIVE_STATUS_FOUR || $endTime <= $now){
                                        $class = 'jp-ioc3';
                                    }

                                ?>
                                <span class="jp-ioc <?php echo  $class;?>"></span>
                            </a>
                        </li>

                    <?php endforeach; ?>
                </ul>                
            <?php endif; ?>
            <div class="pageList mt50 clearfix">
                <?php
                    $this->widget('SLinkPager', array(
                        'header' => '',
                        'cssFile' => false,
                        'firstPageLabel' => Yii::t('page', '首页'),
                        'lastPageLabel' => Yii::t('page', '末页'),
                        'prevPageLabel' => Yii::t('page', '上一页'),
                        'nextPageLabel' => Yii::t('page', '下一页'),
                        'maxButtonCount' => 5,
                        'pages' => $pages,
                        'showJump' => false,
                        'htmlOptions' => array(
                                'class' => 'yiiPageer'
                        )
                    ));
                ?>  
            </div>
    </div>
    
</div>
<script type="text/javascript">
    $(function() {
        setRemainTime();
    });
    //倒计时
    function setRemainTime() {
        $('p.remain-time').each(function (index, element) {
            ts = $(this).attr('data-time');
            var type= this.getAttribute('type');
            
            if (ts > 0) {
                d = Math.floor(ts / 86400);
                h = Math.floor(ts / 3600 % 24);
                m = Math.floor(ts / 60 % 60);
                s = ts % 60;
                
                if(type=='isCome'){
                    html = '距结束 ' + d + '天' + h + '时' + m + '分' + s + '秒';
                }
                if(type == 'noCome')
                    html = '还剩 ' + d + '天' + h + '时' + m + '分' + s + '秒 开拍';               
              
                $(this).html(html);
                $(this).attr('data-time', ts - 1);
            } else {
//                $(this).html('');
                window.location.reload();
            }
        });
        setTimeout("setRemainTime()", 1000);
    }

    //初始化
    $(document).ready(function (e) {
        LAZY.init();
        LAZY.run();
    });

</script>