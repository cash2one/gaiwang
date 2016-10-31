<?php
$slide = WebAdData::getSlidesData('index-slide'); //调用接口
$news = WebAdData::getCommonData('index_news'); //公告
?>
<!-- banner start -->
<div class="gx-indexBanner">
    <!-- 公告滚动start -->
    <div class="gx-IA-info" style="left: 1369px;">
        <div class="scrollbox">
            <ul id="scrollMsg">
                <?php if ($news): ?>
                    <?php foreach ($news as $v): ?>
                        <li>
                            <span>【<?php echo $v['group']==0 ? Yii::t('site','公告'):Yii::t('site','优惠') ?>】</span>
                            <?php echo CHtml::link($v['title'],$v['link'],array('target'=>$v['target'])); ?>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <script type="text/javascript" src="<?php echo $this->theme->baseUrl.'/'; ?>js/jquery.rollGallery_yeso.js"></script>
        <script type="text/javascript">
            $(document).ready(function($){
                $("#scrollMsg").rollGallery({
                    direction:"top",
                    speed:2000
                });
            });
        </script>
    </div>
    <!-- 公告滚动end -->
    <ul class="slides">
        <?php
        if (!empty($slide)):
            foreach ($slide as $k => $v):
                if(!isset($v['start_time'])) continue;
                if (!AdvertPicture::isValid($v['start_time'], $v['end_time'])) continue;
                ?>
                <li style="background-color:<?php echo isset($v['background']) ? $v['background'] : '' ?>">
                    <a href="<?php echo $v['link'] ?>" title="<?php echo $v['title'] ?>" target="<?php echo $v['target'] ?>" style="display: block;position: relative;width: 100%;margin: 0 auto;">
                        <img src="<?php echo ATTR_DOMAIN . '/' . $v['picture']; ?>" width="1200" height="448" style="margin: 0 auto;width:1200px;display:block;"/>
                    </a>
                    <!-- banner右侧的广告位start -->
                    <div class="gx-IA-right-main" style="left: 1369px;">
                        <div class="gx-IA-right-mainWh">
                            <div class="gx-IA-right">
                                <?php if (!empty($v['cut'])): ?>
                                    <?php foreach ($v['cut'] as  $v2): ?>
                                        <?php if(AdvertPicture::isValid($v2['start_time'], $v2['end_time'])):?>
                                            <?php $img = CHtml::image(ATTR_DOMAIN . '/' . $v2['picture'], Yii::t('site', $v2['title']), array('width' => '180', 'height' => '190')) ?>
                                            <?php echo CHtml::link($img, $v2['link'], array('title' => Yii::t('site', $v2['title']),'target'=>$v2['target'])) ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- banner右侧的广告位end -->
                </li>
                <?php
            endforeach;
        endif;
        ?>

    </ul>
</div>
<!-- banner end -->