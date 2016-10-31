<?php
//图片延迟加载
/** @var $this Controller */
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/lazyLoad.js');
?>
<script type="text/javascript">
    $(function() {
        LAZY.init();
        LAZY.run();
    });
</script>
<!-- 限时秒杀模块statr -->
<?php
$seckill_time = WebAdData::getCommonData('index_seckill_time');
$seckill = WebAdData::getCommonData('index_seckill');
if(!empty($seckill_time)):
?>
<div class="gx-ms clearfix">
    <div class="gx-ms-left">
        <?php
        $img =  CHtml::image(ATTR_DOMAIN.'/'.$seckill_time[0]['picture'],'',array('width'=>200,'height'=>160));
        echo CHtml::link($img,$seckill_time[0]['link'],array('target'=>$seckill_time[0]['target']))
        ?>
    </div>
    <div class="gx-ms-right clearfix">
        <ul>
            <?php if(!empty($seckill)): ?>
            <?php foreach($seckill as $k => $v):
                    if($k>3) break;
                    ?>
            <li>
                <?php
                $img =  CHtml::image(ATTR_DOMAIN.'/'.$v['picture'],$v['title'],array('width'=>249,'height'=>160));
                echo CHtml::link($img,$v['link'],array('target'=>$v['target']))
                ?>
            </li>
            <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php endif; ?>
<!-- 限时秒杀模块end -->

<!-- 盖象推荐模块start -->
<?php
$recommend=WebAdData::getRecommendData('','index-recommend-ad-center','','');//调用接口
$recommend = $recommend['center'];
?>
<div class="gx-recommend clearfix">
    <img width="238" height="34" src="<?php echo $this->theme->baseUrl.'/'; ?>images/bgs/gx_recommendIoc.png"/>
    <ul>
        <?php
        $i = 1;
        foreach($recommend as $k => $v):
            if(!AdvertPicture::isValid($v['start_time'],$v['end_time'])) continue;
            $i++;
            if($i>13) break;
        ?>
        <li style="display: block;">
            <a href="<?php echo $v['link'] ?>" title="<?php echo $v['title'] ?>" target="<?php echo $v['target'] ?>" >
                <img width="200" height="220" src="<?php echo ATTR_DOMAIN.'/'.$v['picture'] ?>" alt="<?php echo $v['title'] ?>"/>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>
<!-- 盖象推荐模块end -->
<?php

?>
<!-- 商品楼层start -->
<div class="gx-floor">
    <?php
    /** @var array $floors */
    $floors = Tool::getConfig('floor'); //获取楼层配置数据
    foreach($floors as $k=>$v){
        if(empty($v)) unset($floors[$k]); //删除空白的，不显示楼层
    }
    $category = Category::getTopCategory();
    $category = CHtml::listData($category,'id','name');
    $i = 0;

    foreach ($floors as $v):
        $i++;
        $floor = WebAdData::getFloorData($v, 'floor-text-'.$v, 'index-floor-ad-' . $v, 'floor-bottom-ad-'.$v); //调用接口
        $brands = $floor['brand']; //品牌
        ?>
        <div class="reColumn reColumn<?php echo $i ?>" id="reNo<?php echo $i; ?>">
            <div class="gx-floor-title">
                <img width="66" height="35" src="<?php echo $this->theme->baseUrl . '/'; ?>images/bgs/gx-lcTitle<?php echo $i ?>.png"/>
                <span class="gx-floor-title-font gx-floor-title-font<?php echo $i ?>"><?php echo $category[$v] ?></span>
                <ul>
                    <li class="gx-floor-titleSel" tag="1">热门</li>
                    <?php
                    //子栏目，显示三个
                    foreach($floor['child'] as $kc=> $vc){
                        if($kc>2) break;
                        echo '<li tag="'.($kc+2).'" data-cid="'.$vc['id'].'" class="ajaxFloor">'.$vc['name'].'</li>';
                    };
                    ?>
                </ul>
            </div>
            <div class="gx-floor-main clearfix">
                <div class="gx-floor-main-left">
                    <div class="gx-brand clearfix">
                        <ul class="slides">
                            <?php if (!empty($brands)):  //品牌图片显示 ?>
                                <?php $brands = array_chunk($brands, 4); ?>
                                <?php foreach ($brands as $vb): ?>
                                    <li>
                                        <?php
                                        foreach ($vb as $b) {
                                            $img = CHtml::image(ATTR_DOMAIN.'/'.$b['picture'],$b['title'],array('width'=>140,'height'=>42));
                                            echo CHtml::link($img,$b['link'],array('target'=>$b['target']));
                                        }
                                        ?>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="gx-fmlTypeList">
                        <ul>
                            <?php if (!empty($floor['textAd'])): //文字广告 ?>
                                <?php foreach ($floor['textAd'] as $kt => $vt):
                                        if($kt>9) break;
                                    ?>
                                    <li><?php echo CHtml::link(Tool::truncateUtf8String(Yii::t('site', $vt['text']),5),$vt['link'], array('target' => $vt['target'])) ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <?php
                /** @var int $r  r 根据楼层数，1,2,3-1,2,3，反复变 ，右侧热门商品，有三种不同的布局*/
                $r = $i;
                switch($i){
                    case 1:
                        $r = 1;
                        break;
                    case 2:
                        $r = 2;
                        break;
                    case 3:
                        $r = 3;
                        break;
                    case 4:
                        $r = 1;
                        break;
                    case 5:
                        $r = 2;
                        break;
                    case 6:
                        $r = 3;
                        break;
                    case 7:
                        $r = 3;
                        break;
                    case 8:
                        $r = 2;
                        break;
                    default:
                        $r = 1;

                }
                $this->renderPartial('_right_'.$r,array('floor'=>$floor,'cid'=>$v));
                ?>
            </div>
        </div>
        <?php
    endforeach;
    ?>
    <?php
    $offline = WebAdData::getOfflineData(); //线下服务，调用接口
    //盖网通说按城市来做广告不好做现在,暂时把城市对应改成餐饮、住宿、娱乐、美容
    $offline['city'][0]['name'] = Yii::t('site','餐饮');
    $offline['city'][1]['name'] = Yii::t('site','住宿');
    $offline['city'][2]['name'] = Yii::t('site','娱乐');
    $offline['city'][3]['name'] = Yii::t('site','美容');
    ?>
    <div class="reColumn reColumn<?php echo $i+1 ?>" id="reNo<?php echo $i+1 ?>">
        <div class="gx-floor-title">
            <img width="66" height="35" src="<?php echo $this->theme->baseUrl.'/'; ?>images/bgs/gx-lcTitle<?php echo $i+1 ?>.png"/>
            <span class="gx-floor-title-font gx-floor-title-font<?php echo $i+1 ?>"><?php echo Yii::t('site','线下服务') ?></span>
            <ul>
                <?php foreach($offline['city'] as $k=>$v):
                       if($k>3) break;
                    ?>
                <li  class="ajaxOffline <?php echo $k==0?'gx-floor-titleSel':''; ?>" tag="<?php echo $k+1 ?>" data-city_id="<?php echo $v['city_id'] ?>"><?php echo $v['name'] ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="gx-floor-main clearfix">
            <div class="gx-floor-main-left">
                <div class="gx-brand clearfix">
                    <ul class="slides">
                        <?php if (!empty($offline['logo'])):  //品牌图片显示 ?>
                            <?php $logo = array_chunk($offline['logo'], 4); ?>
                            <?php foreach ($logo as $vb): ?>
                                <li>
                                    <?php
                                    foreach ($vb as $b) {
                                        $img = CHtml::image(ATTR_DOMAIN.'/'.$b['picture'],$b['title'],array('width'=>140,'height'=>42));
                                        echo CHtml::link($img,$b['link'],array('target'=>$b['target']));
                                    }
                                    ?>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="gx-fmlTypeList">
                    <ul>
                        <?php if (!empty($offline['keyword'])): //文字广告 ?>
                            <?php foreach ($offline['keyword'] as $vt): ?>
                                <?php if(!isset($vt['text'])) continue; ?>
                                <li><?php echo CHtml::link(Tool::truncateUtf8String(Yii::t('site', $vt['text']),5),$vt['link'], array('target' => $vt['target'])) ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="gx-floor-main-right">
                <div class="gx-fmr-cp gx-fmr-cp1 clearfix">
                    <div class="gx-fmr-banner">
                        <ul class="slides">
                            <?php
                                $slide = $offline['slideData'][$offline['city'][0]['city_id']];
                                $slide = current($slide);
                            ?>
                            <?php if (!empty($slide['ad'])): //图片广告 ?>
                                <?php foreach ($slide['ad'] as $v): if (!AdvertPicture::isValid($v['start_time'], $v['end_time'])) continue; // 如果广告无效则跳过    ?>
                                    <li>
                                        <a href="<?php echo $v['link']; ?>" title="<?php echo Yii::t('site', $v['title']); ?>" target="<?php echo $v['target']; ?>">
                                            <img src="<?php echo ATTR_DOMAIN . '/' . $v['picture']; ?>" alt="<?php echo Yii::t('site', $v['title']); ?>" width="400" height="390"/>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="gx-fmr-list">
                        <ul class="gx-fmr-list-ul1">
                            <?php
                            $data = Advert::getOfflineDefaultAdvert($offline['city'][0],'index_offline_ad1');
                            $data = array_shift($data);
                            if(!empty($data)):
                            ?>
                            <?php  foreach($data['ad'] as $k=>$v):
                                if($k>2) break;
                                ?>
                            <li <?php echo $k==2?'class="gx-fmr-liNORightLine"':'' ?>>
                                    <?php
                                        $img = CHtml::image(ATTR_DOMAIN.'/'.$v['picture'],'',array('width'=>199,'height'=>220));
                                        echo CHtml::link($img,$v['link'],array('target'=>$v['target']))
                                    ?>
                            </li>
                            <?php endforeach;
                            endif;
                            ?>
                        </ul>
                        <ul  class="gx-fmr-list-ul2">

                            <?php
                            $data = Advert::getOfflineDefaultAdvert($offline['city'][0],'index_offline_ad2');
                            $data = array_shift($data);
                            if(!empty($data)):
                            ?>
                            <?php foreach($data['ad'] as $k=>$v):
                                if($k>2) break;
                                ?>
                                <li <?php echo $k==2?'class="gx-fmr-liNORightLine"':'' ?>>
                                    <?php
                                    $img = CHtml::image(ATTR_DOMAIN.'/'.$v['picture'],'',array('width'=>199,'height'=>170));
                                    echo CHtml::link($img,$v['link'],array('target'=>$v['target']))
                                    ?>
                                </li>
                            <?php endforeach;
                            endif;
                            ?>

                        </ul>
                    </div>
                </div>

                <?php
                //子栏目，显示三个
                unset($offline['city'][0]);
                foreach($offline['city'] as $kc=> $vc){
                    if($kc>3) break;
                    echo '<div class="gx-fmr-cp gx-fmr-cp'.($kc+1).'" id="city_'.$vc['city_id'].'"><img src="'.Yii::app()->theme->baseUrl.'/images/bgs/loading-img.gif'.'" /></div>';
                };
                ?>
            </div>
        </div>
    </div>
</div>
<!-- 商品楼层end -->
<!-- 猜你喜欢模块start -->
<div class="gx-bot-module clearfix">
    <?php echo $this->renderPartial('//site/_doyoulike')?>
</div>
<!-- 猜你喜欢模块end -->

<!-- 左侧浮动楼层statr -->
<div class="redEnvNavWrap gxEnvNavWrap">
    <ul id="redEnvNav" class="redEnvNav">
        <?php
        $i=0;
        foreach($floors as $k=>$v):
            $i++;
        ?>
        <li <?php echo $i==1 ? 'class="current"':'' ?>>
            <?php
            echo CHtml::link($category[$v],'#reNo'.$i,array('class'=>'no'.$i,'title'=>$category[$v]));
            ?>
        </li>
        <?php
        endforeach; ?>
        <li><a href="#reNo<?php echo $i+1 ?>" class="no<?php echo $i+1 ?>" title="线下服务">线下服务</a></li>
    </ul>
</div>
<!-- 左侧浮动楼层end -->


<!-- 右侧浮动菜单statr -->
<?php $this->renderPartial('/layouts/_right_v20'); ?>
<!-- 右侧浮动菜单end -->

<script>
    //商品楼层数据异步加载
    $(".ajaxFloor").click(function(){
        var cid = ($(this).attr('data-cid'));
        var url = "<?php echo Yii::app()->createAbsoluteUrl('site/ajaxFloor') ?>";
        if(!$("#category_"+cid).attr('data-loaded')){
            $.get(url,{cid:cid},function(data,status){
                if(status == 'success' && data != ''){
                    $("#category_"+cid).html(data).attr('data-loaded','1');
                }else{
                    console.log(data);
                    $("#category_"+cid).html('暂无数据');
                }
            });
        }

    });
    //线下服务数据异步加载
    $(".ajaxOffline").click(function(){
        var cid = ($(this).attr('data-city_id'));
        var tag = $(this).attr('tag');
        var url = "<?php echo Yii::app()->createAbsoluteUrl('site/ajaxOffline') ?>";
        if(!$("#city_"+cid).attr("data-loaded")){
            $.get(url,{cid:cid,tag:tag},function(data,status){
                if(status == 'success' && $.trim(data) != ''){
                    $("#city_"+cid).html(data).attr('data-loaded','1');
                }else{
                    $("#city_"+cid).html('暂无数据');
                }
            });
        }
    });
</script>