<?php
Yii::app()->clientScript->registerScript('list_switch', "
    /* 展开收起酒店信息 */
    var listmain = $('.hotelDetail').find('.hotelList');
    $(listmain).find('.switch').toggle(
        function() {
            var gbName = '" . Yii::t('hotelSite', '关闭部分房型') . "';
            $(this).siblings('.hotelList ul').removeClass('room_off');
            $(this).addClass('sw_on').removeClass('sw_off')
            $(this).find('.text').html(gbName)
        },
        function() {
            var zkName = '" . Yii::t('hotelSite', '展开全部房型') . "';
            $(this).siblings('.hotelList ul').addClass('room_off');
            $(this).addClass('sw_off').removeClass('sw_on')
            $(this).find('.text').html(zkName)
        }
    );
");
?>
<div class="main">
    <div class="clear"></div>
    <div class="hotelContain clearfix">
        <div class="hotelBook">
            <h2><?php echo Yii::t('hotelSite', '至优旅游'); ?></h2>
            <form action="/" method="post" id="hotel_search_form">
                <div class="hBookTab">
                    <ul class="tabmenu clearfix">
                        <li class="curr"><a href="javascript:;"><?php echo Yii::t('hotelSite', '国内·酒店'); ?></a></li>
                    </ul>
                    <div class="tabBox">
                        <div class="tabCon">
                            <dl class="clearfix">
                                <dt><?php echo Yii::t('hotelSite', '所在地区'); ?>：</dt>
                                <dd>
                                    <?php echo CHtml::textField('city', $params['city'], array('class' => 'inputtxt', 'autocomplete' => 'off', 'id' => 'citySelect')); ?>
                                    <script>
                                         var Vcity = {};
                                         Vcity.allCity = <?php  echo json_encode($city) ?>;
                                    </script>
                                    <script src="<?php echo DOMAIN . '/js/getCityjs.js'; ?>" type="text/javascript"></script>
                                </dd>
                            </dl>
                            <dl class="clearfix">
                                <dt><?php echo Yii::t('hotelSite', '酒店名称'); ?>：</dt>
                                <dd><?php echo CHtml::textField('name', $params['name'], array('class' => 'inputtxt', 'autocomplete' => 'off')); ?></dd>
                            </dl>
                            <dl class="clearfix">
                                <dt><?php echo Yii::t('hotelSite', '积分区间'); ?>：</dt>
                                <dd>
                                    <?php
                                        if (($params['max'] < $params['min']) || ($params['max'] == $params['min'])) {
                                            $params['min'] = $params['max'] = '';
                                        }
                                        $checked = ($params['min'] == '' && $params['max'] == '') ? true : false;
                                        $radio = CHtml::radioButton('i_all', $checked, array('class' => 'radio', 'onclick' => "document.getElementById('min').value = '';document.getElementById('max').value = '';"));
                                        echo CHtml::tag('label', array('for' => 'i_all'), $radio. Yii::t('hotelSite', '不限'));
                                    ?>
                                    <?php echo CHtml::textField('min', $params['min'], array('class' => 'inputtxt W70', 'onmousedown' => "document.getElementById('i_all').checked = false;", 'onkeyup' => "value = value.replace(/[^\d]/g, '')")); ?>
                                    &mdash;
                                    <?php echo CHtml::textField('max', $params['max'], array('class' => 'inputtxt W70', 'onmousedown' => "document.getElementById('i_all').checked = false;", 'onkeyup' => "value = value.replace(/[^\d]/g, '')")); ?>
                                </dd>
                            </dl>
                            <dl class="clearfix">
                                <dt><?php echo Yii::t('hotelSite', '更多筛选'); ?>：</dt>
                                <dd></dd>
                            </dl>
                            <dl class="Hstar clearfix">
                                <dt><?php echo Yii::t('hotelSite', '星级'); ?>：</dt>
                                <dd>
                                    <?php
                                        echo CHtml::dropDownList('level', $params['level'],
                                            HotelLevel::getLevelOptions(), array('class' => 'selectTxt01', 'empty' => array(0 => Yii::t('hotelSite', '不限')))
                                        );
                                    ?>
                                </dd>
                            </dl>
                            <dl class="Hstar clearfix">
                                <dt><?php echo Yii::t('hotelSite', '热点'); ?>：</dt>
                                <dd>
                                    <?php
                                        echo CHtml::dropDownList('address', $params['address'],
                                            HotelAddress::getAddressOptions(), array('class' => 'selectTxt01', 'empty' => array(0 => Yii::t('hotelSite', '不限')))
                                        );
                                    ?>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="btn">
                        <?php echo CHtml::link(Yii::t('hotelSite', '搜索'), 'javascript:void(0);', array('class' => 'HotelBtnbg', 'onClick' => 'hotelSearch();')); ?>
                    </div>
                </div>
            </form>
            <script type="text/javascript">
                function hotelSearch() {
                    var city = $('#hotel_search_form #citySelect').val(),
                        name = $('#hotel_search_form #name').val(),
                        min = $('#hotel_search_form #min').val(),
                        max = $('#hotel_search_form #max').val(),
                        level = $('#hotel_search_form #level').val(),
                        address = $('#hotel_search_form #address').val();
                    <?php
                        $url = urldecode($this->createAbsoluteUrl('/hotel/site/index',
                                    array_merge($params, array(
                                            'city' => "'+city+'",
                                            'name' => "'+name+'",
                                            'min' => "'+min+'",
                                            'max' => "'+max+'",
                                            'level' => "'+level+'",
                                            'address' => "'+address+'"
                                        )
                                    )
                              ));
                        echo "location.assign('$url');\n";
                    ?>
                }
            </script>
        </div>
        <?php
            $advert = Advert::getConventionalAdCache('hotel-index-slide'); // 获取酒店幻灯片广告缓存数据
            if (!empty($advert)):
        ?>
            <!-- 幻灯片代码 begin -->
            <div class="hotelAdver">
                <ul class="imgbox">
                    <?php
                        foreach ($advert as $a): if (!AdvertPicture::isValid($a['start_time'], $a['end_time'])) {
                            continue;
                        }
                    ?>
                    <li><?php echo CHtml::link(CHtml::image(ATTR_DOMAIN . '/' . $a['picture'], $a['title'], array('width' => '775', 'height' => '345')), $a['link'], array('title' => $a['title'], 'target' => $a['target'])) ?></li>
                    <?php endforeach; ?>
                </ul>
                <div class="thumb"></div>
                <script type="text/javascript">
                    $(document).ready(function (e) {
                        $(".hotelAdver .imgbox li").each(function (i) {
                            $(".hotelAdver .thumb").append("<i></i>");
                        });
                        $('.hotelAdver .imgbox li').imgChange({thumbObj: '.hotelAdver .thumb i', curClass: 'curr', effect: 'fade', speed: 1000, changeTime: 3000})
                    });
                </script>
            </div>
            <!-- 幻灯片代码 end -->
        <?php endif; ?>

        <div class="hotelService clearfix">
            <div class="hsIcon"><h3 class="no1"><?php echo Yii::t('hotelSite', '品质之选'); ?></h3></div>
            <div class="hsIcon"><h3 class="no2"><?php echo Yii::t('hotelSite', '丰富之选'); ?></h3></div>
            <div class="hsIcon"><h3 class="no3"><?php echo Yii::t('hotelSite', '安心之选'); ?></h3></div>
            <div class="hsIcon no4 clearfix">
                <div class="hSTime fl">
                  <!-- 
                    <p>
                        <?php echo Yii::t('hotelSite', '咨询服务时间'); ?>：<?php echo $this->getConfig('hotelparams', 'hotelServiceTime') ?>
                    </p>
                     -->
                    [<?php echo Yii::t('hotelSite', '本公司酒店房源由第三方提供'); ?>]
                </div>
                <!--  
                <div class="hSPhone fl"> 
                    <p class="phoneIco">
                        <?php echo Yii::t('hotelSite', '预订咨询电话'); ?>
                    </p>
                    <?php echo $this->getConfig('hotelparams', 'hotelServiceTel') ?>
                </div>
                -->
				<div class="servRepTime"><?php echo Yii::t('hotelSite','一经下单，盖象将会在服务时间的2小时内回复确认') ?>
                              
                                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <!--酒店预订首页侧栏部分 begin-->
    <div class="sliderleft">
        <?php $leftAdvert = Advert::getConventionalAdCache('hotel-left-ad'); ?>
        <?php if (!empty($leftAdvert) && AdvertPicture::isValid($leftAdvert[0]['start_time'], $leftAdvert[0]['end_time'])): ?>
            <div class="sliderAdver">
                <?php echo CHtml::link(CHtml::image(ATTR_DOMAIN . '/' . $leftAdvert[0]['picture']), $leftAdvert[0]['link'], array('target' => $leftAdvert[0]['target'])); ?>         
            </div>
        <?php endif; ?>
        
        <div class="hotelSlider">
            <span class="hotelTit">
                <i class="ico_reddot"></i><?php echo Yii::t('hotelSite', '热门酒店信息'); ?>
            </span>
            <ul class="hotelMsg tabHor">
                <?php foreach ($hotHotel as $key => $val): ?>
                    <li>
                        <div class="tipMsg">
                            <span class="tipTit">
                                <?php echo CHtml::link($val['name'], $this->createAbsoluteUrl('view', array('id' => $val['id'])), array('class' => 'ico_graydot')); ?>
                                <?php if ($key <= 2): ?>
                                    <i class="ico_top1">Top<?php echo $key + 1; ?></i>
                                <?php endif; ?>
                            </span>
                            <span class="tipCon">
                                <b><?php echo Common::convert($val['min_price']) ?></b>/<?php echo Yii::t('hotelSite', '积分起'); ?>
                            </span>
                        </div>
                        <div class="allMsg">
                            <?php
                            echo CHtml::link(CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $val['thumbnail'], 'c_fill,h_80,w_100'), $val['name'], array('width' => 100, 'height' => 80)),
                                $this->createAbsoluteUrl('view', array('id' => $val['id'])), array(
                                    'target' => '_blank', 'class' => 'imgbox',
                                )
                            );
                            ?>
                            <div class="allText">
                                <p class="name">
                                    <?php echo CHtml::link($val['name'], $this->createAbsoluteUrl('view', array('id' => $val['id'])), array('target' => '_blank', 'class' => 'ico_Tit')) ?>
                                    <?php if ($key <= 2): ?>
                                        <i class="ico_top1">Top<?php echo $key + 1; ?></i>
                                    <?php endif; ?>
                                </p>
                                <p>
                                    <em class="ico_price"></em><font><?php echo HtmlHelper::formatPrice($val['min_price']) ?></font><span class="tipCon"><b><?php echo Common::convert($val['min_price']) ?></b>/<?php echo Yii::t('hotelSite', '积分起'); ?></span>
                                </p>
                                <p class="pingf">
                                    <u class="pingcons" title="<?php echo Yii::t('hotelSite', '综合评分'); ?>
                                        <?php echo $val['total_score'] && $val['comments'] ? sprintf('%.2f', $val['total_score'] / $val['comments']) : 0 ?>">
                                        <em style="width:<?php echo $val['total_score'] && $val['comments'] ? sprintf('%.2f', $val['total_score'] / $val['comments']) * 20 : 0 ?>%"></em>
                                    </u>
                                    <u class="color_gray">
                                        <?php echo $val['total_score'] && $val['comments'] ? sprintf('%.2f', $val['total_score'] / $val['comments']) : 0 ?>
                                        <?php echo Yii::t('hotelSite', '分'); ?>/<?php echo Yii::t('hotelSite', '共{a}人点评', array('{a}' => '<b>' . $val['comments'] . '</b>')); ?>
                                    </u>
                                </p>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="hotelSlider">
            <span class="hotelTit">
                <i class="ico_reddot"></i><?php echo Yii::t('hotelSite', '最新上线'); ?>
            </span>
            <ul class="hotelMsg tabHor">
                <?php foreach ($newHotel as $key => $val): ?>
                    <li>
                        <div class="tipMsg">
                            <span class="tipTit">
                                <?php echo CHtml::link($val['name'], $this->createAbsoluteUrl('view', array('id' => $val['id'])), array('class' => 'ico_graydot')); ?>
                                <?php if ($key <= 2): ?>
                                    <i class="ico_top1">Top<?php echo $key + 1; ?></i>
                                <?php endif; ?>
                            </span>
                            <span class="tipCon">
                                <b><?php echo Common::convert($val['min_price']) ?></b>/<?php echo Yii::t('hotelSite', '积分起'); ?>
                            </span>
                        </div>
                        <div class="allMsg">
                            <?php
                            echo CHtml::link(CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $val['thumbnail'], 'c_fill,h_80,w_100'), $val['name'], array('width' => 100, 'height' => 80)),
                                $this->createAbsoluteUrl('view', array('id' => $val['id'])), array(
                                    'target' => '_blank', 'class' => 'imgbox',
                                )
                            );
                            ?>
                            <div class="allText">
                                <p class="name">
                                    <?php echo CHtml::link($val['name'], $this->createAbsoluteUrl('view', array('id' => $val['id'])), array('target' => '_blank', 'class' => 'ico_Tit')) ?>
                                    <?php if ($key <= 2): ?>
                                        <i class="ico_top1">Top<?php echo $key + 1; ?></i>
                                    <?php endif; ?>
                                </p>
                                <p>
                                    <em class="ico_price"></em><font><?php echo HtmlHelper::formatPrice($val['min_price']) ?></font><span class="tipCon"><b><?php echo Common::convert($val['min_price']) ?></b>/<?php echo Yii::t('hotelSite', '积分起'); ?></span>
                                </p>
                                <p class="pingf">
                                    <u class="pingcons" title="<?php echo Yii::t('hotelSite', '综合评分'); ?>
                                        <?php echo $val['total_score'] && $val['comments'] ? sprintf('%.2f', $val['total_score'] / $val['comments']) : 0 ?>">
                                        <em style="width:<?php echo $val['total_score'] && $val['comments'] ? sprintf('%.2f', $val['total_score'] / $val['comments']) * 20 : 0 ?>%"></em>
                                    </u>
                                    <u class="color_gray">
                                        <?php echo $val['total_score'] && $val['comments'] ? sprintf('%.2f', $val['total_score'] / $val['comments']) : 0 ?>
                                        <?php echo Yii::t('hotelSite', '分'); ?>/<?php echo Yii::t('hotelSite', '共{a}人点评', array('{a}' => '<b>' . $val['comments'] . '</b>')); ?>
                                    </u>
                                </p>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="hotelSlider">
            <span class="hotelTit">
                <i class="ico_reddot"></i>
                酒店预订意见反馈邮箱地址
            </span>
            <div class="hotelEmail">
                booking.complain@zhiu100.com
            </div>
        </div>
    </div>
    <!--酒店预订首页侧栏部分 end-->

    <!--酒店预订首页主栏部分 begin-->
    <div class="hotelSliderMain mgtop10">
        <div class="hotelTit">
            <?php $allClass = $params['order'] > 0 ? '' : 'allSort'; ?>
            <?php echo CHtml::link(Yii::t('hotelSite', '全部酒店'), $this->createAbsoluteUrl('/hotel'), array('class' => $allClass)); ?>
            <?php echo HtmlHelper::generateSortUrl('score', $this->route, $params, $this->_standardRequestParams(), '', array('class' => '')); ?>
            <?php echo HtmlHelper::generateSortUrl('integral', $this->route, $params, $this->_standardRequestParams(), '', array('class' => '')); ?>
            <span class="checkbox">
                <?php  echo CHtml::checkBox('sort_hot', ($params['hot'] == '1' ? true : false), array('class' => 'check')); ?><?php echo CHtml::label(Yii::t('hotelSite', '热门酒店'), 'sort_hot'); ?><i class="ico_top1">TOP</i>
                <?php  echo CHtml::checkBox('sort_new', ($params['new'] == '1' ? true : false), array('class' => 'check')); ?><?php echo CHtml::label(Yii::t('hotelSite', '全新上线'), 'sort_new'); ?><i class="ico_top2">NEW</i>
            </span>
        </div>
        <script type="text/javascript">
            $("#sort_hot").click(function () {
                <?php $hot = $params['hot'] == 1 ? 0 : 1; ?>
                location.href = "<?php echo $this->createAbsoluteUrl('/hotel/site/index', array_merge($params, array('hot' => $hot))); ?>";
            })
            $("#sort_new").click(function () {
                <?php $new = $params['new'] == 1 ? 0 : 1; ?>
                location.href = "<?php echo $this->createAbsoluteUrl('/hotel/site/index', array_merge($params, array('new' => $new))); ?>";
            })
        </script>

        <?php if (!empty($hotels)): ?>
            <?php foreach ($hotels as $hotel): ?>
                <div class="hotelDetail bdt">
                    <div class="detailCon clearfix">
                        <?php
                            echo CHtml::link(CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $hotel['thumbnail'], 'c_fill,h_140,w_140'), $hotel['name'], array('width' => '140', 'height' => '140')),
                                $this->createAbsoluteUrl('view', array('id' => $hotel['id'])), array('class' => 'smallimage', 'rel' => Tool::showImg(ATTR_DOMAIN . '/' . $hotel['thumbnail'], 'c_fill,h_500,w_500')));
                        ?>
                        <div class="msgCon">
                            <h2>
                                <i class="ico_hotels"></i>
                                <?php echo CHtml::link($hotel['name'], $this->createAbsoluteUrl('view', array('id' => $hotel['id']))) ?><b>[<?php echo $hotel['level_name']; ?>]</b>
                                <span class="hotelServer">
                                    <?php if ($hotel['parking_lot']): ?>
                                        <i class="hs01" title="<?php echo Yii::t('hotelSite', '停车场'); ?>"></i>
                                    <?php endif; ?>
                                    <?php if ($hotel['pickup_service']): ?>
                                        <i class="hs02" title="<?php echo Yii::t('hotelSite', '接机服务'); ?>"></i>
                                    <?php endif; ?>
                                </span>
                            </h2>
                            <p><i class="ico_htaddr"></i>
                                <?php echo Yii::t('hotelSite', '酒店地址'); ?>：
                                <?php echo $hotel['province_name'] . $hotel['city_name'] . $hotel['street']; ?>
                                <?php if ($hotel['lng'] != '' && $hotel['lat'] != ''): ?>
                                    <?php echo CHtml::link(Yii::t('hotelSite', '查看地图'), '', array('class' => 'showMap sm_off', 'onclick' => "initMap({$hotel['lng']}, {$hotel['lat']}, {$hotel['id']},this)")) ?>
                                <?php endif; ?>
                            </p>
                            <p class="pingf">
                                <?php $graded = $hotel['total_score'] && $hotel['comments'] ? sprintf('%.2f', $hotel['total_score'] / $hotel['comments']) : 0; ?>
                                <u class="pingcons"title="<?php echo Yii::t('hotelSite', '综合评分'); ?> <?php echo $graded; ?>">
                                    <em style="width:<?php echo $graded * 20; ?>%"></em>
                                </u>
                                <u class="color_gray">
                                    <?php echo Yii::t('hotelSite', '{graded}分', array('{graded}' => $graded));  ?>
                                    ( <?php echo Yii::t('hotelSite', '共{a}人点评了', array('{a}' => '<b>' . $hotel['comments'] . '</b>')); ?>)
                                </u>
                            </p>
                        </div>
                        <div class="tipCon">
                            <b><?php echo Common::convert($hotel['min_price']) ?></b><?php echo Yii::t('hotelSite', '积分起'); ?>
                            <p><?php echo HtmlHelper::formatPrice($hotel['min_price']) ?></p>
                        </div>
                    </div>
                    <div id="MapBox<?php echo $hotel['id'] ?>" style="width: 803; height: 300px;display: none"></div>
                    <div class="hotelList">
                        <span class="hotelTh clearfix">
                            <i class="w210"><?php echo Yii::t('hotelSite', '房型'); ?></i>
                            <i class="w60"><?php echo Yii::t('hotelSite', '床型'); ?></i>
                            <i class="w60"><?php echo Yii::t('hotelSite', '早餐'); ?></i>
                            <i class="w60"><?php echo Yii::t('hotelSite', '网络'); ?></i>
                            <i class="w85"><?php echo Yii::t('hotelSite', '价格'); ?></i>
                            <i class="w85"><?php echo Yii::t('hotelSite', '积分'); ?></i>
                            <i class="w100"><?php echo Yii::t('hotelSite', '预估返赠'); ?></i>
                            <i class="w140"><?php echo Yii::t('hotelSite', '操作'); ?></i>
                        </span>
                        <?php if (!empty($hotel['rooms'])): ?>
                            <ul class="room_off clearfix">
                                <?php foreach ($hotel['rooms'] as $key => $room): ?>
                                    <?php
                                    // 判断是否开启特定活动， 如果是，则使用活动价格
                                    if (HotelRoom::isActivity($room['activities_start'], $room['activities_end']))
                                        $room['unit_price'] = $room['activities_price'];
                                    ?>
                                    <li class="items clearfix">
                                        <span class="wfl w210">
                                            <i class="ico_img"></i>
                                            <?php echo CHtml::link($room['name'], $this->createAbsoluteUrl('view', array('id' => $hotel['id'])),array('title'=>$room['name'])) ?>
                                        </span>
                                        <span class="wfl w60"><?php echo HotelRoom::getBed($room['bed']) ?></span>
                                        <span class="wfl w60"><?php echo HotelRoom::getBreakFast($room['breadfast']) ?></span>
                                        <span class="wfl w60"><em><?php echo HotelRoom::getNetwork($room['network']) ?></em></span>
                                        <span class="wfl w85"><em><?php echo HtmlHelper::formatPrice($room['unit_price']) ?></em></span>
                                        <span class="wfl w85"><b><?php echo Common::convert($room['unit_price']) ?></b></span>
                                        <span class="wfl w100">
                                            <span class="ico_fan"><i><?php echo $room['estimate_back_credits'] ?>分</i></span>
                                        </span>
                                        <span class="wfl w140">
                                            <?php echo CHtml::link(Yii::t('hotelSite', '预订'), $this->createAbsoluteUrl('/hotel/order/create', array('id' => $room['id'])), array('class' => 'hbtnSubmit')) ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php if ($key > 4): ?>
                                <span class="switch sw_off">
                                    <?php echo CHtml::link(Yii::t('hotelSite', '展开全部房源'), 'javascript:void(0);', array('class' => 'text')); ?>
                                    <strong>（<?php echo count($hotel['rooms']); ?>）</strong>
                                </span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="pageList">
                <?php
                $this->widget('CLinkPager', array(
                        'cssFile' => false,
                        'header' => '',
                        'firstPageLabel' => Yii::t('hotelSite', '首页'),
                        'lastPageLabel' => Yii::t('hotelSite', '末页'),
                        'prevPageLabel' => Yii::t('hotelSite', '上一页'),
                        'nextPageLabel' => Yii::t('hotelSite', '下一页'),
                        'pages' => $pages,
                        'maxButtonCount' => 5,
                        'htmlOptions' => array(
                            'class' => 'yiiPageer'
                        )
                    )
                );
                ?>
            </div>
        <?php else: ?>
            <div class="hotelDetail bdt" style="text-align: center;"><?php echo Yii::t('hotelSite', '没有相关酒店！'); ?></div>
        <?php endif; ?>
    </div>
    <!--酒店预订首页主栏部分 end-->
</div>
<script src="http://api.map.baidu.com/api?v=1.3" type="text/javascript"></script>
<script src="http://api.map.baidu.com/getscript?v=1.3&ak=&services=&t=20131115060845" type="text/javascript"></script>
<link href="http://api.map.baidu.com/res/13/bmap.css" type="text/css" rel="stylesheet">

<script type="text/javascript">

    function initMap(lng, lat, id, obj) {
        if ($("#MapBox" + id).css("display") === 'none') {
            var gbName = '<?php echo Yii::t('hotelSite', '收起地图'); ?>';
            $("#MapBox" + id).show();
            $(obj).addClass('sm_on').removeClass('sm_off');
            $(obj).html(gbName);
        } else {
            var zkName = '<?php echo Yii::t('hotelSite', '查看地图'); ?>';
            $("#MapBox" + id).hide();
            $(obj).addClass('sm_off').removeClass('sm_on');
            $(obj).html(zkName);
        }
        createMap(lng, lat, id);
        setMapEvent();
        addMapControl();
    }

    function createMap(lng, lat, id) {
        var map = new BMap.Map("MapBox" + id); //在百度地图容器中创建一个地图
        var point = new BMap.Point(lng, lat); //定义一个中心点坐标
        map.centerAndZoom(point, 15); //设定地图的中心点和坐标并将地图显示在地图容器中

        var marker1 = new BMap.Marker(new BMap.Point(lng, lat));  // 创建标注
        var label = new BMap.Label('<?php echo Yii::t('hotelSite', '酒店位置'); ?>', {"offset": new BMap.Size(10, -20)});
        marker1.setLabel(label);
        marker1.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
        map.addOverlay(marker1);
        label.setStyle({
            borderColor: "#808080",
            color: "#333",
            cursor: "pointer"
        });

        window.map = map; //将map变量存储在全局
    }

    //地图事件设置函数：
    function setMapEvent() {
        map.enableDragging(); //启用地图拖拽事件，默认启用(可不写)
        map.enableScrollWheelZoom(); //启用地图滚轮放大缩小
        map.enableDoubleClickZoom(); //启用鼠标双击放大，默认启用(可不写)
        map.enableKeyboard(); //启用键盘上下左右键移动地图
    }

    //地图控件添加函数：
    function addMapControl() {
        //向地图中添加缩放控件
        var ctrl_nav = new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_LEFT, type: BMAP_NAVIGATION_CONTROL_LARGE});
        map.addControl(ctrl_nav);
        //向地图中添加比例尺控件
        var ctrl_sca = new BMap.ScaleControl({anchor: BMAP_ANCHOR_BOTTOM_LEFT});
        map.addControl(ctrl_sca);
    }

</script>
