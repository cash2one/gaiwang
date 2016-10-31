<div class="gx-floor-main-right">
    <div class="gx-fmr-cp gx-fmr-cp1 clearfix">
        <div class="gx-fmr-banner">
            <ul class="slides">
                <?php if (!empty($floor['imgAd'])): //图片广告 ?>
                    <?php foreach ($floor['imgAd'] as $v): if (!AdvertPicture::isValid($v['start_time'], $v['end_time'])) continue; // 如果广告无效则跳过    ?>
                        <li>
                            <a href="<?php echo $v['link']; ?>" title="<?php echo Yii::t('site', $v['title']); ?>" target="<?php echo $v['target']; ?>">
                                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/bgs/loading-img.gif',Yii::t('site', $v['title']),array(
                                    'width'=>'400',
                                    'height'=>'390',
                                    'data-url'=>ATTR_DOMAIN . '/' . $v['picture'],
                                    'class' => 'lazy',
                                )) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <div class="gx-fmr-list">
            <?php
            $goods = WebAdData::getCommonData('index-floor-goods-1-'.$cid,3);
            $goods = $goods ? $goods :array();
            ?>
            <ul class="gx-fmr-list-ul1 clearfix">
                <?php foreach ($goods as $k2=>$v2): ?>
                    <li <?php echo $k2 == 2 ? 'class="gx-fmr-liNORightLine"' : '' ?>>
                        <?php if(!isset($v2['title'])) continue; ?>
                        <a class="img" title="<?php echo Yii::t('site', $v2['title']) ?>" target="_blank" href="<?php echo $v2['link']; ?>">
                            <?php
                            echo CHtml::image(Yii::app()->theme->baseUrl.'/images/bgs/loading-img.gif', Yii::t('site', $v2['title']), array(
                                'width' => 199,
                                'height' => 220,
                                'title' => Yii::t('site', $v2['title']),
                                'class' => 'lazy',
                                'data-url' => ATTR_DOMAIN . '/' . $v2['picture'],
                            ))
                            ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php
            $goods = WebAdData::getCommonData('index-floor-goods-2-'.$cid,3);
            $goods = $goods ? $goods :array();
            ?>
            <ul class="gx-fmr-list-ul2 clearfix">
                <?php foreach ($goods as $k2=>$v2): ?>
                    <li <?php echo $k2 == 2 ? 'class="gx-fmr-liNORightLine"' : '' ?>>
                        <?php if(!isset($v2['title'])) continue; ?>
                        <a class="img" title="<?php echo Yii::t('site', $v2['title']) ?>" target="_blank" href="<?php echo $v2['link']; ?>">
                            <?php
                            echo CHtml::image(Yii::app()->theme->baseUrl.'/images/bgs/loading-img.gif', Yii::t('site', $v2['title']), array(
                                'width' => 199,
                                'height' => 170,
                                'title' => Yii::t('site', $v2['title']),
                                'class' => 'lazy',
                                'data-url' => ATTR_DOMAIN . '/' . $v2['picture'],
                            ))
                            ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

        </div>
    </div>
    <?php
    //子栏目，显示三个
    foreach($floor['child'] as $kc=> $vc){
        if($kc>2) break;
        echo '<div class="gx-fmr-cp gx-fmr-cp'.($kc+2).'" id="category_'.$vc['id'].'"><img src="'.Yii::app()->theme->baseUrl.'/images/bgs/loading-img.gif'.'" /></div>';
    };
    ?>
</div>