<!--推荐Recommend-->
<?php
//Cache::setRecommendedCache();
//图片延迟加载
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/lazyLoad.js');
?>
<script type="text/javascript">
    $(function() {
        LAZY.init();
        LAZY.run();
    });
</script>
<?php
$recommen=WebAdData::getRecommendData('index-recommend-ad-left', 'index-recommend-ad-center', 'index-recommend-ad-right', 'index-recommend-ad-bottom');//调用接口?>
<div class="recommend">
    <div class="title"><?php echo Yii::t('site', '推荐'); ?><em>RECOMMEND</em></div>
    <div class="recomCon clearfix">
        <div class="recomL clearfix">
            <?php if (!empty($recommen['left'])): ?>
                <?php foreach($recommen['left'] as $k => $rl): ?>
                    <?php $img = CHtml::image(ATTR_DOMAIN . '/' . $rl['picture'], Yii::t('site', $rl['title']), array('width' => '124', 'height' => '172')) ?>
                    <?php echo CHtml::link($img, $rl['link'], array('title' => Yii::t('site', $rl['title']),'class'=>'ad0'.($k + 1),'target'=>'_blank')) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="recomM clearfix">
            <?php if (!empty($recommen['center'])): ?>
                <?php foreach ($recommen['center'] as $k => $v): ?>
                    <?php $img = CHtml::image(ATTR_DOMAIN . '/' . $v['picture'], Yii::t('site', $v['title']), array('width' => 170, 'height' => 172)) ?>
                    <?php echo CHtml::link($img, $v['link'], array('title' => Yii::t('site', $v['title']), 'class' => 'ad0' . ($k + 1),'target'=>'_blank')) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="recomR clearfix">
            <?php if (!empty($recommen['right'])): ?>
                <?php foreach($recommen['right'] as $k => $rr): ?>
                    <?php $img = CHtml::image(ATTR_DOMAIN . '/' . $rr['picture'], Yii::t('site', $rr['title']), array('width' => '124', 'height' => '172')) ?>
                    <?php echo CHtml::link($img, $rr['link'], array('title' => Yii::t('site', $rr['title']), 'class' => 'ad0' . ($k + 1),'target'=>'_blank')) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="adbox">
    <?php if (!empty($recommen['bottom'])): ?>
        <a href="<?php echo $recommen['bottom'][0]['link'] ?>" title="<?php echo Yii::t('site', $recommen['bottom'][0]['title'])?>"target=<?php echo '_blank'; ?>>
            <?php echo CHtml::image(ATTR_DOMAIN . '/' . $recommen['bottom'][0]['picture'], Yii::t('site', $recommen['bottom'][0]['title']), array('width' => '1200', 'height' => '80')) ?>
        </a>
    <?php endif; ?>
</div>


<?php
$offline = WebAdData::getOfflineData(); //调用接口
?>

<?php
//$GaiData = WebAdData::getGaiData('index-floor-gai-flash', 'index-floor-gai-ad', 'index-floor-gai-ad3', 'index-floor-gai-text', 'index-floor-gai-goods'); //调用接口;?>
<!--1F  盖商品  暂时不用-->
<!--<div class="column column_07" id="f1">-->
<!--    <div class="top clearfix">-->
<!--        <h3>盖商品<span class="en">G-emall Product</span></h3>-->
<!--        <div class="recoCat">-->
<!--            --><?php //if (!empty($GaiData['ad-text'])): ?>
<!--                --><?php //foreach ($GaiData['ad-text'] as $k => $v): ?>
<!--                    --><?php //echo CHtml::link(Yii::t('site', $v['text']), $this->createAbsoluteUrl('/search/view', array('q' => $v['text'])), array('target' => $v['target'], 'class' => 'icon_v')) ?>
<!--                --><?php //endforeach; ?>
<!--            --><?php //endif; ?>
<!--        </div>-->
<!--    </div>-->
<!--    <div class="content clearfix">-->
<!--        <div class="leftCon">-->
<!--            --><?php //if(!empty($GaiData['ad-single'])): ?>
<!--                <a href="--><?php //echo $GaiData['ad-single']['link']; ?><!--" title="--><?php //echo Yii::t('site', $GaiData['ad-single']['title']); ?><!--" target="--><?php //echo $GaiData['ad-single']['target']; ?><!--">-->
<!--                    <img src="--><?php //echo ATTR_DOMAIN . '/' . $GaiData['ad-single']['picture']; ?><!--" width="100%" height="150"/>-->
<!--                </a>-->
<!--            --><?php //endif; ?>
<!--            <div class="flexslider02">1-->
<!--                <ul class="slides">-->
<!--                    --><?php //if(!empty($GaiData['ad-flash'])): ?>
<!--                        --><?php
//                            foreach($GaiData['ad-flash'] as $v):
//                                if (!AdvertPicture::isValid($v['start_time'], $v['end_time'])) continue; // 如果广告无效则跳过
//                            ?>
<!--                                <li>-->
<!--                                    <a href="--><?php //echo $v['link']; ?><!--" title="--><?php //echo Yii::t('site', $v['title']); ?><!--" target="--><?php //echo $v['target']; ?><!--">-->
<!--                                        <img src="--><?php //echo ATTR_DOMAIN . '/' . $v['picture']; ?><!--" alt="--><?php //echo Yii::t('site', $v['title']); ?><!--" width="335" height="430"/>-->
<!--                                    </a>-->
<!--                                </li>-->
<!--                        --><?php //endforeach; ?>
<!--                    --><?php //endif; ?>
<!--                </ul>-->
<!--                <span class="adbg"></span>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="rightCon">-->
<!--            <ul class="proArrange01 clearfix">-->
<!--                --><?php //if (!empty($GaiData['goods'])): ?>
<!--                    --><?php //foreach ($GaiData['goods'] as $k => $v): ?>
<!--                        <li>-->
<!--                            --><?php //echo CHtml::link(Yii::t('category', $v['name']), $this->createAbsoluteUrl('/goods/view', array('id' => $v['goods_id'])), array('class' => 'name', 'title' => $v['name'])); ?>
<!--                            <p class="des">--><?php //echo Yii::t('site', $v['description']) ?><!--</p>-->
<!--                            <a class="img" title="--><?php //echo Yii::t('site', $v['description']) ?><!--" target="_blank" href="--><?php //echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['goods_id'])); ?><!--">-->
<!--                                --><?php
//                                echo CHtml::image(DOMAIN . '/images/bg/loading.gif', Yii::t('site', $v['name']), array(
//                                    'width' => 150,
//                                    'height' => 150,
//                                    'title' => Yii::t('site', $v['name']),
//                                    'class' => 'lazy',
//                                    'data-url' => Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_150,w_150'),
//                                ))
//                                ?>
<!--                            </a>-->
<!--                        </li>-->
<!--                    --><?php //endforeach; ?>
<!--                --><?php //endif; ?>
<!--            </ul>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!--<div class="adbox">-->
<!--    --><?php
//        $bottomAd0 = !empty($GaiData['floorBottomCode']) ? $GaiData['floorBottomCode'] : array();
//        if (!empty($bottomAd0)):
//      ?>
<!--        <a href="--><?php //echo $bottomAd0['link'] ?><!--" title="--><?php //echo Yii::t('site', $bottomAd0['title']) ?><!--">-->
<!--            --><?php //echo CHtml::image(ATTR_DOMAIN . '/' . $bottomAd0['picture'], Yii::t('site', $bottomAd0['title']), array('width' => '1200', 'height' => '80')) ?>
<!--        </a>-->
<!--    --><?php //endif; ?>
<!--</div>-->


<?php $arr1F = WebAdData::getFloorData('3', 'floor-1-text', 'index-floor-ad1', 'floor-bottom-ad1', '1'); //调用接口?>

<div class="column column_01" id="f1">
    <?php if (!empty($arr1F)): ?>
        <div class="top clearfix">
            <h3>1F <?php echo !empty($arr1F['parent']) ? Yii::t('site', $arr1F['parent']['short_name']) : ''; ?><span class="en"><?php echo !empty($arr1F['parent']) ? $arr1F['parent']['alias'] : ''; ?></span></h3>
            <div class="recoCat">
                <?php if (!empty($arr1F['textAd'])): ?>
                    <?php foreach ($arr1F['textAd'] as $k => $v): ?>
                        <?php echo CHtml::link(Yii::t('site', $v['text']), $this->createAbsoluteUrl('/search/view', array('q' => $v['text'])), array('target' => $v['target'], 'class' => 'icon_v')) ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="content clearfix">
            <div class="leftCon">
                <ul class="category clearfix">
                    <?php if (!empty($arr1F['child'])): ?>
                        <?php foreach ($arr1F['child'] as $k => $v): ?>
                            <?php if (strlen($v['name']) > 9): ?>
                                <?php $cla = 'numFour'; ?>
                            <?php else: ?>
                                <?php $cla = ''; ?>
                            <?php endif; ?>
                            <li class="ajaxCategory <?php echo $cla ?>" cidvalue="<?php echo $v['id'] ?>" >
                                <?php echo CHtml::link(Yii::t('category', $v['name']), $this->createAbsoluteUrl('/category/view', array('id' => $v['id'])),array('target'=>'_blank')); ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <div class="flexslider02">
                    <ul class="slides">
                        <?php if (!empty($arr1F['imgAd'])): ?>
                            <?php foreach ($arr1F['imgAd'] as $k => $v): if (!AdvertPicture::isValid($v['start_time'], $v['end_time'])) continue; // 如果广告无效则跳过    ?>
                                <li>
                                    <a href="<?php echo $v['link']; ?>" title="<?php echo Yii::t('site', $v['title']); ?>" target="<?php echo $v['target']; ?>">
                                        <img src="<?php echo ATTR_DOMAIN . '/' . $v['picture']; ?>" alt="<?php echo Yii::t('site', $v['title']); ?>" width="335" height="430"/>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <span class="adbg"></span>
                </div>
            </div>
            <div class="rightCon">
                <ul class="proArrange01 clearfix">
                    <?php if (!empty($arr1F['goods'])): ?>
                        <?php foreach ($arr1F['goods'] as $k => $v): ?>
                            <li>
                                <?php echo CHtml::link(Yii::t('category', $v['name']), $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])), array('class' => 'name', 'title' => $v['name'],'target'=>'_blank')); ?>
                                <p class="des"><?php echo Yii::t('site', $v['description']) ?></p>
                                <a class="img" title="<?php echo Yii::t('site', $v['description']) ?>" target="_blank" href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])); ?>">
                                    <?php
                                    echo CHtml::image(DOMAIN . '/images/bg/loading.gif', Yii::t('site', $v['name']), array(
                                        'width' => 150,
                                        'height' => 150,
                                        'title' => Yii::t('site', $v['name']),
                                        'class' => 'lazy',
                                        'data-url' => Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_150,w_150'),
                                    ))
                                    ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>


<div class="adbox">
    <?php if (!empty($arr1F['bottom'])): ?>
        <a href="<?php echo $arr1F['bottom']['link'] ?>" title="<?php echo Yii::t('site', $arr1F['bottom']['title']) ?>">
            <?php echo CHtml::image(ATTR_DOMAIN . '/' . $arr1F['bottom']['picture'], Yii::t('site', $arr1F['bottom']['title']), array('width' => '1200', 'height' => '80')) ?>
        </a>
    <?php endif; ?>
</div>

<!--2F  食品-->
<?php //$arr = array('cId' => 8, 'textCode' => 'floor-2-text', 'indexCode' => 'index-floor-ad2', 'bottomCode' => 'floor-bottom-ad2', 'floor' => 2);     ?>
<?php $arr2F = WebAdData::getFloorData('8', 'floor-2-text', 'index-floor-ad2', 'floor-bottom-ad2', '2'); //调用接口?>
<div class="column column_02" id="f2">
    <?php if (!empty($arr2F)): ?>
        <div class="top clearfix">
            <h3>2F <?php echo !empty($arr2F['parent']) ? Yii::t('site', $arr2F['parent']['short_name']) : ''; ?><span class="en"><?php echo !empty($arr2F['parent']) ? $arr2F['parent']['alias'] : ''; ?></span></h3>
            <div class="recoCat">
                <?php if (!empty($arr2F['textAd'])): ?>
                    <?php foreach ($arr2F['textAd'] as $k => $v): ?>
                        <?php echo CHtml::link(Yii::t('site', $v['text']), $this->createAbsoluteUrl('/search/view', array('q' => $v['text'])), array('target' => $v['target'], 'class' => 'icon_v')) ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="content clearfix">
            <div class="leftCon">
                <ul class="category clearfix">
                    <?php if (!empty($arr2F['child'])): ?>
                        <?php foreach ($arr2F['child'] as $k => $v): ?>
                            <?php if (strlen($v['name']) > 9): ?>
                                <?php $cla = 'numFour'; ?>
                            <?php else: ?>
                                <?php $cla = ''; ?>
                            <?php endif; ?>
                            <li class="ajaxCategory <?php echo $cla ?>" cidvalue="<?php echo $v['id'] ?>" >
                                <?php echo CHtml::link(Yii::t('category', $v['name']), $this->createAbsoluteUrl('/category/view', array('id' => $v['id'])),array('target'=>'_blank')); ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <div class="flexslider02">
                    <ul class="slides">
                        <?php if (!empty($arr2F['imgAd'])): ?>
                            <?php foreach ($arr2F['imgAd'] as $k => $v): if (!AdvertPicture::isValid($v['start_time'], $v['end_time'])) continue; // 如果广告无效则跳过    ?>
                                <li>
                                    <a href="<?php echo $v['link']; ?>" title="<?php echo Yii::t('site', $v['title']); ?>" target="<?php echo $v['target']; ?>">
                                        <img src="<?php echo ATTR_DOMAIN . '/' . $v['picture']; ?>" alt="<?php echo Yii::t('site', $v['title']); ?>" width="335" height="430"/>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <span class="adbg"></span>
                </div>
            </div>
            <div class="rightCon">
                <ul class="proArrange01 clearfix">
                    <?php if (!empty($arr2F['goods'])): ?>
                        <?php foreach ($arr2F['goods'] as $k => $v): ?>
                            <li>
                                <?php echo CHtml::link(Yii::t('category', $v['name']), $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])), array('class' => 'name', 'title' => $v['name'],'target'=>'_blank')); ?>
                                <p class="des"><?php echo Yii::t('site', $v['description']) ?></p>
                                <a class="img" title="<?php echo Yii::t('site', $v['description']) ?>" target="_blank" href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])); ?>">
                                    <?php
                                    echo CHtml::image(DOMAIN . '/images/bg/loading.gif', Yii::t('site', $v['name']), array(
                                        'width' => 150,
                                        'height' => 150,
                                        'title' => Yii::t('site', $v['name']),
                                        'class' => 'lazy',
                                        'data-url' => Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_150,w_150'),
                                    ))
                                    ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="adbox">
    <?php if (!empty($arr2F['bottom'])): ?>
        <a href="<?php echo $arr2F['bottom']['link'] ?>" title="<?php echo Yii::t('site', $arr2F['bottom']['title']) ?>">
            <?php echo CHtml::image(ATTR_DOMAIN . '/' . $arr2F['bottom']['picture'], Yii::t('site', $arr2F['bottom']['title']), array('width' => '1200', 'height' => '80')) ?>
        </a>
    <?php endif; ?>
</div>
<!--3F  家用电器-->
<?php //$arr = array('cId' => 1, 'textCode' => 'floor-3-text', 'indexCode' => 'index-floor-ad3', 'bottomCode' => 'floor-bottom-ad3', 'floor' => 3);     ?>
<?php $arr3F = WebAdData::getFloorData('1', 'floor-3-text', 'index-floor-ad3', 'floor-bottom-ad3', '3'); //调用接口?>
<div class="column column_03" id="f3">
    <?php if (!empty($arr3F)): ?>
        <div class="top clearfix">
            <h3>3F <?php echo !empty($arr3F['parent']) ? Yii::t('site', $arr3F['parent']['short_name']) : ''; ?><span class="en"><?php echo !empty($arr3F['parent']) ? $arr3F['parent']['alias'] : ''; ?></span></h3>
            <div class="recoCat">
                <?php if (!empty($arr3F['textAd'])): ?>
                    <?php foreach ($arr3F['textAd'] as $k => $v): ?>
                        <?php echo CHtml::link(Yii::t('site', $v['text']), $this->createAbsoluteUrl('/search/view', array('q' => $v['text'])), array('target' => $v['target'], 'class' => 'icon_v')) ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="content clearfix">
            <div class="leftCon">
                <ul class="category clearfix">
                    <?php if (!empty($arr3F['child'])): ?>
                        <?php foreach ($arr3F['child'] as $k => $v): ?>
                            <?php if (strlen($v['name']) > 9): ?>
                                <?php $cla = 'numFour'; ?>
                            <?php else: ?>
                                <?php $cla = ''; ?>
                            <?php endif; ?>
                            <li class="ajaxCategory <?php echo $cla ?>" cidvalue="<?php echo $v['id'] ?>" >
                                <?php echo CHtml::link(Yii::t('category', $v['name']), $this->createAbsoluteUrl('/category/view', array('id' => $v['id'])),array('target'=>'_blank')); ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <div class="flexslider02">
                    <ul class="slides">
                        <?php if (!empty($arr3F['imgAd'])): ?>
                            <?php foreach ($arr3F['imgAd'] as $k => $v): if (!AdvertPicture::isValid($v['start_time'], $v['end_time'])) continue; // 如果广告无效则跳过    ?>
                                <li>
                                    <a href="<?php echo $v['link']; ?>" title="<?php echo Yii::t('site', $v['title']); ?>" target="<?php echo $v['target']; ?>">
                                        <img src="<?php echo ATTR_DOMAIN . '/' . $v['picture']; ?>" alt="<?php echo Yii::t('site', $v['title']); ?>" width="335" height="430"/>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <span class="adbg"></span>
                </div>
            </div>
            <div class="rightCon">
                <ul class="proArrange01 clearfix">
                    <?php if (!empty($arr3F['goods'])): ?>
                        <?php foreach ($arr3F['goods'] as $k => $v): ?>
                            <li>
                                <?php echo CHtml::link(Yii::t('category', $v['name']), $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])), array('class' => 'name', 'title' => $v['name'],'target'=>'_blank')); ?>
                                <p class="des"><?php echo Yii::t('site', $v['description']) ?></p>
                                <a class="img" title="<?php echo Yii::t('site', $v['description']) ?>" target="_blank" href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])); ?>">
                                    <?php
                                    echo CHtml::image(DOMAIN . '/images/bg/loading.gif', Yii::t('site', $v['name']), array(
                                        'width' => 150,
                                        'height' => 150,
                                        'title' => Yii::t('site', $v['name']),
                                        'class' => 'lazy',
                                        'data-url' => Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_150,w_150'),
                                    ))
                                    ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="adbox">
    <?php if (!empty($arr3F['bottom'])): ?>
        <a href="<?php echo $arr3F['bottom']['link'] ?>" title="<?php echo Yii::t('site', $arr3F['bottom']['title']) ?>">
            <?php echo CHtml::image(ATTR_DOMAIN . '/' . $arr3F['bottom']['picture'], Yii::t('site', $arr3F['bottom']['title']), array('width' => '1200', 'height' => '80')) ?>
        </a>
    <?php endif; ?>
</div>
<!--4F 服饰-->
<?php //$arr = array('cId' => 2, 'textCode' => 'floor-4-text', 'indexCode' => 'index-floor-ad4', 'bottomCode' => 'floor-bottom-ad4', 'floor' => 4);  ?>
<?php $arr4F = WebAdData::getFloorData('2', 'floor-4-text', 'index-floor-ad4', 'floor-bottom-ad4', '4'); //调用接口?>
<div class="column column_04" id="f4">
    <?php if (!empty($arr4F)): ?>
        <div class="top clearfix">
            <h3>4F <?php echo !empty($arr4F['parent']) ? Yii::t('site', $arr4F['parent']['short_name']) : ''; ?><span class="en"><?php echo !empty($arr4F['parent']) ? $arr4F['parent']['alias'] : ''; ?></span></h3>
            <div class="recoCat">
                <?php if (!empty($arr4F['textAd'])): ?>
                    <?php foreach ($arr4F['textAd'] as $k => $v): ?>
                        <?php echo CHtml::link(Yii::t('site', $v['text']), $this->createAbsoluteUrl('/search/view', array('q' => $v['text'])), array('target' => $v['target'], 'class' => 'icon_v')) ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="content clearfix">
            <div class="leftCon">
                <ul class="category clearfix">
                    <?php if (!empty($arr4F['child'])): ?>
                        <?php foreach ($arr4F['child'] as $k => $v): ?>
                            <?php if (strlen($v['name']) > 9): ?>
                                <?php $cla = 'numFour'; ?>
                            <?php else: ?>
                                <?php $cla = ''; ?>
                            <?php endif; ?>
                            <li class="ajaxCategory <?php echo $cla ?>" cidvalue="<?php echo $v['id'] ?>" >
                                <?php echo CHtml::link(Yii::t('category', $v['name']), $this->createAbsoluteUrl('/category/view', array('id' => $v['id'])),array('target'=>'_blank')); ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <div class="flexslider02">
                    <ul class="slides">
                        <?php if (!empty($arr4F['imgAd'])): ?>
                            <?php foreach ($arr4F['imgAd'] as $k => $v): if (!AdvertPicture::isValid($v['start_time'], $v['end_time'])) continue; // 如果广告无效则跳过    ?>
                                <li>
                                    <a href="<?php echo $v['link']; ?>" title="<?php echo Yii::t('site', $v['title']); ?>" target="<?php echo $v['target']; ?>">
                                        <img src="<?php echo ATTR_DOMAIN . '/' . $v['picture']; ?>" alt="<?php echo Yii::t('site', $v['title']); ?>" width="335" height="430"/>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <span class="adbg"></span>
                </div>
            </div>
            <div class="rightCon">
                <ul class="proArrange01 clearfix">
                    <?php if (!empty($arr4F['goods'])): ?>
                        <?php foreach ($arr4F['goods'] as $k => $v): ?>
                            <li>
                                <?php echo CHtml::link(Yii::t('category', $v['name']), $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])), array('class' => 'name', 'title' => $v['name'],'target'=>'_blank')); ?>
                                <p class="des"><?php echo Yii::t('site', $v['description']) ?></p>
                                <a class="img" title="<?php echo Yii::t('site', $v['description']) ?>" target="_blank" href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])); ?>">
                                    <?php
                                    echo CHtml::image(DOMAIN . '/images/bg/loading.gif', Yii::t('site', $v['name']), array(
                                        'width' => 150,
                                        'height' => 150,
                                        'title' => Yii::t('site', $v['name']),
                                        'class' => 'lazy',
                                        'data-url' => Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_150,w_150'),
                                    ))
                                    ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="adbox">
    <?php if (!empty($arr4F['bottom'])): ?>
        <a href="<?php echo $arr4F['bottom']['link'] ?>" title="<?php echo Yii::t('site', $arr4F['bottom']['title']) ?>">
            <?php echo CHtml::image(ATTR_DOMAIN . '/' . $arr4F['bottom']['picture'], Yii::t('site', $arr4F['bottom']['title']), array('width' => '1200', 'height' => '80')) ?>
        </a>
    <?php endif; ?>
</div>
<!--5F 手机数码-->
<?php //$arr = array('cId' => 4, 'textCode' => 'floor-5-text', 'indexCode' => 'index-floor-ad5', 'bottomCode' => 'floor-bottom-ad5', 'floor' => 5);    ?>
<?php $arr5F = WebAdData::getFloorData('4', 'floor-5-text', 'index-floor-ad5', 'floor-bottom-ad5', '5'); //调用接口?>
<div class="column column_05" id="f5">
    <?php if (!empty($arr5F)): ?>
        <div class="top clearfix">
            <h3>5F <?php echo !empty($arr5F['parent']) ? Yii::t('site', $arr5F['parent']['short_name']) : ''; ?><span class="en"><?php echo !empty($arr5F['parent']) ? $arr5F['parent']['alias'] : ''; ?></span></h3>
            <div class="recoCat">
                <?php if (!empty($arr5F['textAd'])): ?>
                    <?php foreach ($arr5F['textAd'] as $k => $v): ?>
                        <?php echo CHtml::link(Yii::t('site', $v['text']), $this->createAbsoluteUrl('/search/view', array('q' => $v['text'])), array('target' => $v['target'], 'class' => 'icon_v')) ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="content clearfix">
            <div class="leftCon">
                <ul class="category clearfix">
                    <?php if (!empty($arr5F['child'])): ?>
                        <?php foreach ($arr5F['child'] as $k => $v): ?>
                            <?php if (strlen($v['name']) > 9): ?>
                                <?php $cla = 'numFour'; ?>
                            <?php else: ?>
                                <?php $cla = ''; ?>
                            <?php endif; ?>
                            <li class="ajaxCategory <?php echo $cla ?>" cidvalue="<?php echo $v['id'] ?>" >
                                <?php echo CHtml::link(Yii::t('category', $v['name']), $this->createAbsoluteUrl('/category/view', array('id' => $v['id'])),array('target'=>'_blank')); ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <div class="flexslider02">
                    <ul class="slides">
                        <?php if (!empty($arr5F['imgAd'])): ?>
                            <?php foreach ($arr5F['imgAd'] as $k => $v): if (!AdvertPicture::isValid($v['start_time'], $v['end_time'])) continue; // 如果广告无效则跳过    ?>
                                <li>
                                    <a href="<?php echo $v['link']; ?>" title="<?php echo Yii::t('site', $v['title']); ?>" target="<?php echo $v['target']; ?>">
                                        <img src="<?php echo ATTR_DOMAIN . '/' . $v['picture']; ?>" alt="<?php echo Yii::t('site', $v['title']); ?>" width="335" height="430"/>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <span class="adbg"></span>
                </div>
            </div>
            <div class="rightCon">
                <ul class="proArrange01 clearfix">
                    <?php if (!empty($arr5F['goods'])): ?>
                        <?php foreach ($arr5F['goods'] as $k => $v): ?>
                            <li>
                                <?php echo CHtml::link(Yii::t('category', $v['name']), $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])), array('class' => 'name', 'title' => $v['name'],'target'=>'_blank')); ?>
                                <p class="des"><?php echo Yii::t('site', $v['description']) ?></p>
                                <a class="img" title="<?php echo Yii::t('site', $v['description']) ?>" target="_blank" href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])); ?>">
                                    <?php
                                    echo CHtml::image(DOMAIN . '/images/bg/loading.gif', Yii::t('site', $v['name']), array(
                                        'width' => 150,
                                        'height' => 150,
                                        'title' => Yii::t('site', $v['name']),
                                        'class' => 'lazy',
                                        'data-url' => Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_150,w_150'),
                                    ))
                                    ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="adbox">
    <?php if (!empty($arr5F['bottom'])): ?>
        <a href="<?php echo $arr5F['bottom']['link'] ?>" title="<?php echo Yii::t('site', $arr5F['bottom']['title']) ?>">
            <?php echo CHtml::image(ATTR_DOMAIN . '/' . $arr5F['bottom']['picture'], Yii::t('site', $arr5F['bottom']['title']), array('width' => '1200', 'height' => '80')) ?>
        </a>
    <?php endif; ?>
</div>

<!--6F 汽车用品-->
<?php //$arr = array('cId' => 11, 'textCode' => 'floor-6-text', 'indexCode' => 'index-floor-ad6', 'bottomCode' => 'floor-bottom-ad6', 'floor' => 6);     ?>
<?php $arr6F = WebAdData::getFloorData('7', 'floor-6-text', 'index-floor-ad6', 'floor-bottom-ad6', '6'); //调用接口?>
<div class="column column_06" id="f6">
    <?php if (!empty($arr6F)): ?>
        <div class="top clearfix">
            <h3>6F <?php echo !empty($arr6F['parent']) ? Yii::t('site', $arr6F['parent']['short_name']) : ''; ?><span class="en"><?php echo !empty($arr6F['parent']) ? $arr6F['parent']['alias'] : ''; ?></span></h3>
            <div class="recoCat">
                <?php if (!empty($arr6F['textAd'])): ?>
                    <?php foreach ($arr6F['textAd'] as $k => $v): ?>
                        <?php echo CHtml::link(Yii::t('site', $v['text']), $this->createAbsoluteUrl('/search/view', array('q' => $v['text'])), array('target' => $v['target'], 'class' => 'icon_v')) ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="content clearfix">
            <div class="leftCon">
                <ul class="category clearfix">
                    <?php if (!empty($arr6F['child'])): ?>
                        <?php foreach ($arr6F['child'] as $k => $v): ?>
                            <?php if (strlen($v['name']) > 9): ?>
                                <?php $cla = 'numFour'; ?>
                            <?php else: ?>
                                <?php $cla = ''; ?>
                            <?php endif; ?>
                            <li class="ajaxCategory <?php echo $cla ?>" cidvalue="<?php echo $v['id'] ?>" >
                                <?php echo CHtml::link(Yii::t('category', $v['name']), $this->createAbsoluteUrl('/category/view', array('id' => $v['id'])),array('target'=>'_blank')); ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <div class="flexslider02">
                    <ul class="slides">
                        <?php if (!empty($arr6F['imgAd'])): ?>
                            <?php foreach ($arr6F['imgAd'] as $k => $v): if (!AdvertPicture::isValid($v['start_time'], $v['end_time'])) continue; // 如果广告无效则跳过    ?>
                                <li>
                                    <a href="<?php echo $v['link']; ?>" title="<?php echo Yii::t('site', $v['title']); ?>" target="<?php echo $v['target']; ?>">
                                        <img src="<?php echo ATTR_DOMAIN . '/' . $v['picture']; ?>" alt="<?php echo Yii::t('site', $v['title']); ?>" width="335" height="430"/>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <span class="adbg"></span>
                </div>
            </div>
            <div class="rightCon">
                <ul class="proArrange01 clearfix">
                    <?php if (!empty($arr6F['goods'])): ?>
                        <?php foreach ($arr6F['goods'] as $k => $v): ?>
                            <li>
                                <?php echo CHtml::link(Yii::t('category', $v['name']), $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])), array('class' => 'name', 'title' => $v['name'],'target'=>'_blank')); ?>
                                <p class="des"><?php echo Yii::t('site', $v['description']) ?></p>
                                <a class="img" title="<?php echo Yii::t('site', $v['description']) ?>" target="_blank" href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])); ?>">
                                    <?php
                                    echo CHtml::image(DOMAIN . '/images/bg/loading.gif', Yii::t('site', $v['name']), array(
                                        'width' => 150,
                                        'height' => 150,
                                        'title' => Yii::t('site', $v['name']),
                                        'class' => 'lazy',
                                        'data-url' => Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_150,w_150'),
                                    ))
                                    ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="adbox">
    <?php if (!empty($arr6F['bottom'])): ?>
        <a href="<?php echo $arr6F['bottom']['link'] ?>" title="<?php echo Yii::t('site', $arr6F['bottom']['title']) ?>">
            <?php echo CHtml::image(ATTR_DOMAIN . '/' . $arr6F['bottom']['picture'], Yii::t('site', $arr6F['bottom']['title']), array('width' => '1200', 'height' => '80')) ?>
        </a>
    <?php endif; ?>
</div>

<?php if (!empty($offline)): ?>
    <div class="groupDeal" id="f0"><!--线下活动-->
        <div class="title clearfix">
            <h3><?php echo Yii::t('site', '线下活动'); ?><span class="en">GROUP DEAL</span></h3>
            <div class="icon_v citySel">
                <span class="cityName"><i class="icon_v arrow"></i>
                    <?php if (isset($offline['de_city']['name'])): ?>
                        <?php echo Yii::t('site', $offline['de_city']['name']) ?>
                    <?php endif; ?>
                </span>
                <div class="cityList">
                    <?php if (!empty($offline['city'])): ?>
                        <?php $str = ''; ?>
                        <?php foreach ($offline['city'] as $k => $v): ?>
                            <?php $str.= CHtml::link(Yii::t('region', Yii::t('site', $v['name'])), $this->createAbsoluteUrl('/jms/site/list', array('city' => $v['city_id']))) . '|'; ?>
                        <?php endforeach; ?>
                        <?php echo rtrim($str, '|'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="content clearfix">
            <div class="groupDealTab">
                <ul class="tab">
                    <?php if (!empty($offline['parent'])): ?>
                        <?php $n = 1;?>
                        <?php $count = count($offline['parent']) ?>
                        <?php foreach ($offline['parent'] as $k => $v): ?>
                            <?php $curr = ($n == 1) ? 'curr' : '' ?>
                            <?php $cla = (($n % 2) == 0) ? 'even' : 'odd' ?>
                            <li id="one<?php echo $n; ?>" onmouseover="setTab('one', <?php echo $n ?>, <?php echo $count ?>)" class="<?php echo $cla ?> <?php echo $curr ?>"><?php echo Yii::t('site', $v['name']) ?></li>
                            <?php $n++;?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </ul>
                <ul class="category clearfix">
                    <?php if (!empty($offline['child'])): ?>
                        <?php $n = 1; ?>
                        <?php foreach ($offline['child'] as $key => $val): ?>
                            <?php $cla = (($n % 2) == 0) ? 'even' : 'odd' ?>
                            <li class="<?php echo $cla ?>">
                                <?php if (!empty($val)): ?>
                                    <?php $str = ''; ?>
                                    <?php foreach ($val as $k => $v): ?>
                                        <?php $str.= Chtml::link(Yii::t('site', $v['name']), '', array('title' => Yii::t('site', $v['name']))) . '|'; ?>
                                    <?php endforeach; ?>
                                    <?php echo rtrim($str, '|'); ?>
                                <?php endif; ?>
                            </li>
                            <?php $n++;?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="groupDealShow">
                <?php if (!empty($offline['ad'])): ?>
                    <?php $count = count($offline['ad']) ?>
                    <?php $n = 1 ?>
                    <?php foreach ($offline['ad'] as $key => $val): ?>
                        <?php $sty = (1 == $n) ? 'display:block;' : '' ?>
                        <ul id="tabCon_one_<?php echo $n ?>" class="nineBox clearfix" style="<?php echo $sty ?>">
                            <?php if (!empty($val)): ?>
                                <?php foreach ($val as $k => $v): ?>
                                    <?php $k+=1 ?>
                                    <?php if (1 == $k): ?>
                                        <?php $cla = 'bigB' ?>
                                        <?php $wid = '336' ?>
                                        <?php $hei = '336' ?>
                                    <?php else: ?>
                                        <?php $cla = '' ?>
                                        <?php $wid = '' ?>
                                        <?php $hei = '' ?>
                                    <?php endif; ?>
                                    <li class="<?php echo $cla ?>">
                                        <a href="<?php echo $v['link'] ?>" title="<?php echo Yii::t('site', $v['title']) ?>" target="<?php echo '_blank';?>">
                                            <img src="<?php echo ATTR_DOMAIN . '/' . $v['picture']; ?>"  alt="<?php echo Yii::t('site', $v['title']) ?>" width="<?php echo $wid ?>" height="<?php echo $hei ?>"/>
                                        </a>
                                        <span class="title"><?php echo Yii::t('site', $v['title']) ?></span>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                        <?php $n++;?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div><!--id-cityAdv end-->
    </div> 
<?php endif; ?>
<a href="http://gwkey.g-emall.com/#app-gpay" class="app_ad" title="盖付通" target="_blank"></a>
<a href="http://gwkey.g-emall.com/" class="app_ad_02" title="盖象商城APP" target="_blank"></a>
<script type="text/javascript">
    /**
     * ajax 鼠标在分类上悬停，加载更多商品(暂时不用)
     */
<!--    html = '';-->
<!--    obj = '';-->
<!--    i = 1;-->
<!--    $(".ajaxCategory").hover(function () {-->
<!--        var cid = $(this).attr('cidvalue');-->
<!--        var rightCon = $(this).parent().parent().parent().children('.rightCon');-->
<!--        if(i == 1){-->
<!--            html = rightCon.html();-->
<!--            obj = rightCon;-->
<!--            i++;-->
<!--        }-->
<!--        ajaxGetGoods(rightCon,cid);-->
<!--    }, function () {-->
<!--    });-->
<!---->
<!--    function ajaxGetGoods(rightCon,cid){-->
<!--        var url = "--><?php //echo Yii::app()->createAbsoluteUrl('site/ajaxFloor') ?><!--";-->
<!--        url = url + '?cid='+ cid;-->
<!--        $.get( url,function(data,status){-->
<!--            if(status == 'success' && data != ''){-->
<!--                $(rightCon).html(data);-->
<!--            }-->
<!--        });-->
<!--    }-->
<!---->
<!--    $(".column").hover(function(){},function(){-->
<!--        $(obj).html(html);-->
<!--        html = '';-->
<!--        obj = '';-->
<!--        i = 1;-->
<!--    });-->

</script>
