<div class="gx-floor-main-right">
    <div class="gx-fmr-cp gx-fmr-cp1">
        <div class="gx-fmr-banner gx-fmr-banner02">
            <ul class="slides">
                <?php if (!empty($floor['imgAd'])): //图片广告 ?>
                    <?php foreach ($floor['imgAd'] as $v): if (!AdvertPicture::isValid($v['start_time'], $v['end_time'])) continue; // 如果广告无效则跳过    ?>
                        <li>
                            <a href="<?php echo $v['link']; ?>" title="<?php echo Yii::t('site', $v['title']); ?>" target="<?php echo $v['target']; ?>">
                                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/bgs/loading-img.gif',Yii::t('site', $v['title']),array(
                                    'width'=>'400',
                                    'height'=>'220',
                                    'data-url'=>ATTR_DOMAIN . '/' . $v['picture'],
                                    'class' => 'lazy',
                                )) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <ul class="reNo2-list1 clearfix">
            <?php
            $goods = WebAdData::getCommonData('index-floor-goods-1-'.$cid,3);
            if($goods):
                foreach($goods as $v):
            ?>
            <li>
                <a title="<?php echo $v['title'] ?>" href="<?php echo $v['link'] ?>"  target="<?php echo $v['target'] ?>">
                    <?php
                    echo CHtml::image(Yii::app()->theme->baseUrl.'/images/bgs/loading-img.gif', Yii::t('site', $v['title']), array(
                        'width' => 198,
                        'height' => 219,
                        'title' => Yii::t('site', $v['title']),
                        'class' => 'lazy',
                        'data-url' => ATTR_DOMAIN . '/' . $v['picture'],
                    ))
                    ?>
                </a>
            </li>
            <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <ul class="reNo2-list2 clearfix">
            <?php
            $goods = WebAdData::getCommonData('index-floor-goods-2-'.$cid,5);
            if($goods):
                foreach($goods as $v):
                    ?>
                    <li>
                        <a title="<?php echo $v['title'] ?>" href="<?php echo $v['link'] ?>"  target="<?php echo $v['target'] ?>">
                            <?php
                            echo CHtml::image(Yii::app()->theme->baseUrl.'/images/bgs/loading-img.gif', Yii::t('site', $v['title']), array(
                                'width' => 199,
                                'height' => 170,
                                'title' => Yii::t('site', $v['title']),
                                'class' => 'lazy',
                                'data-url' => ATTR_DOMAIN . '/' . $v['picture'],
                            ))
                            ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
    <?php
    //子栏目，显示三个
    foreach($floor['child'] as $kc=> $vc){
        if($kc>2) break;
        echo '<div class="gx-fmr-cp gx-fmr-cp'.($kc+2).'" id="category_'.$vc['id'].'"><img src="'.Yii::app()->theme->baseUrl.'/images/bgs/loading-img.gif'.'" /></div>';
    };
    ?>
</div>