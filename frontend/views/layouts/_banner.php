<?php
// 首页大屏幻灯片播放
/* @var $this Controller */
?>
<?php $slide = WebAdData::getSlidesData('index-slide'); //调用接口?>
<div class="indexBanner">
    <div class="flexslider01">
        <ul class="slides">
            <?php if (!empty($slide)): ?>
                <?php foreach ($slide as $key => $val): ?>
                    <li style="background-color:<?php echo isset($val['background']) ? $val['background'] : '' ?>" >
                        <?php if(isset($val['start_time']) && isset($val['picture']) && isset($val['title']) && isset($val['link'])):?><!--判断是否被禁用-->
                        <?php if (AdvertPicture::isValid($val['start_time'], $val['end_time'])): ?>
                            <?php $img = CHtml::image(ATTR_DOMAIN . '/' . $val['picture'], Yii::t('site', $val['title']), array('width' => '1200', 'height' => '440')) ?>
                            <?php echo CHtml::link($img, $val['link'], array('title' => Yii::t('site', $val['title']),'target'=>'_blank')) ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <div class="smallAd">
                            <?php if (!empty($val['cut'])): ?>
                                <?php foreach ($val['cut'] as $k => $v): ?>
                                    <?php if(AdvertPicture::isValid($v['start_time'], $v['end_time'])):?>
                                    <?php $img = CHtml::image(ATTR_DOMAIN . '/' . $v['picture'], Yii::t('site', $v['title']), array('width' => '185', 'height' => '216')) ?>
                                    <?php echo CHtml::link($img, $v['link'], array('title' => Yii::t('site', $v['title']),'target'=>'_blank')) ?>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>    
            <?php endif; ?>
        </ul>
    </div>
</div>