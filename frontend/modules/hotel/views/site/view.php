<?php
/**
 * @var Hotel $hotel 酒店实例
 */
Yii::app()->clientScript->registerScript('list_switch', "
    /* 展开酒店客房信息 */
    $('.hbtnLook').click(function(){
        var room_detail = $(this).parents('li').next('.hotelIntroTxt');
        var t = $(room_detail).is(':hidden') ? '" . Yii::t('hotelSite', '收起') . "' : '" . Yii::t('hotelSite', '查看') . "';
        $(this).text(t);
        $(room_detail).slideToggle();
    });
");
?>
<div class="main">
    <div class="hotelSliderMain mgtop10 fl">
        <div class="hotelDetail nobor">
            <div class="detailCon">
                <?php
                echo CHtml::link(CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $hotel['thumbnail'], 'c_fill,h_140,w_140'), $hotel['name'], array('width' => '140', 'height' => '140', 'style' => 'opacity: 1')), 'javascript:void(0);', array('class' => 'smallimage', 'rel' => Tool::showImg(ATTR_DOMAIN . '/' . $hotel['thumbnail'], 'c_fill,h_500,w_500')));
                ?>
                <div class="msgCon">
                    <h2>
                        <i class="ico_hotels"></i><?php echo $hotel['name'] ?><b>[<?php echo $hotel['level_name']; ?>]</b>
                    </h2>

                    <p>
                        <i class="ico_htaddr"></i><?php echo Yii::t('hotelSite', '酒店地址'); ?>
                        ：<?php echo $hotel['province_name']; ?><?php echo $hotel['city_name']; ?><?php echo $hotel['street']; ?>
                    </p>

                    <p class="pingf">
                        <?php $graded = $hotel['total_score'] && $hotel['comments'] ? sprintf('%.2f', $hotel['total_score'] / $hotel['comments']) : 0; ?>
                    <u title="<?php echo Yii::t('hotelSite', '综合评分'); ?><?php echo $graded; ?>" class="pingcons">
                        <em style="width:<?php echo $graded * 20; ?>%"></em>
                    </u>
                    <u class="color_gray">
                        <?php echo $graded; ?><?php echo Yii::t('hotelSite', '分 ( 共{a}人点评了)', array('{a}' => '<b>' . $hotel['comments'] . '</b>')); ?>
                    </u>
                    </p>
                </div>
                <div class="tipCon">
                    <b><?php echo Common::convert($hotel['min_price']) ?></b><?php echo Yii::t('hotelSite', '积分起'); ?>
                    <p><?php echo HtmlHelper::formatPrice($hotel['min_price']) ?></p>
                    <a href="javascript:void(0);" class="hbtnSubmit" onclick="booking();"><?php echo Yii::t('hotelSite', '立即预订'); ?></a>
                    <script>
                        function booking() {
                            $("html,body").animate({scrollTop: $("#hotelDetailTab").offset().top}, 1000, function() {
                                $('#room_reserve').trigger('click');
                            });
                        }
                    </script>
                </div>
                <div class="line">
                    <span class="hotelServer fl">
                        <em><?php echo Yii::t('hotelSite', '酒店提供服务'); ?>：</em>
                        <?php if ($hotel['parking_lot']): ?>
                            <i class="hs01" title="<?php echo Yii::t('hotelSite', '停车场'); ?>"></i>
                        <?php endif; ?>
                        <?php if ($hotel['pickup_service']): ?>
                            <i class="hs02" title="<?php echo Yii::t('hotelSite', '接机服务'); ?>"></i>
                        <?php endif; ?>
                    </span>
                    <div style="line-height:12px; margin-left:30px;" class="bdshare_b fr" id="bdshare">
                        <img src="http://bdimg.share.baidu.com/static/images/type-button-1.jpg?cdnversion=20120831">
                        <a class="shareCount" title="<?php echo Yii::t('hotelSite', '累计分享0次'); ?>"></a>
                    </div>
                    <script data="type=button&amp;uid=6822010" id="bdshare_js" type="text/javascript"></script>
                    <script id="bdshell_js" type="text/javascript"></script>
                    <script type="text/javascript">
                        document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date() / 3600000);
                    </script>
                </div>
            </div>
            <?php if (!empty($pictures)): ?>
                <div class="HotelPicBox clearfix">
                    <div class="picCon">
                        <ul class="clearfix">
                            <?php
                            $size = array(
                                1 => array('w' => 460, 'h' => 282),
                                2 => array('w' => 225, 'h' => 140),
                                3 => array('w' => 140, 'h' => 140),
                                4 => array('w' => 140, 'h' => 140),
                                5 => array('w' => 225, 'h' => 140),
                            );
                            ?>
                            <?php foreach ($pictures as $i => $img): ?>
                                <?php $i++; ?>
                                <?php
                                if ($i > 5) {
                                    break;
                                }
                                ?>
                                <li class="pc0<?php echo $i; ?>">
                                    <?php
                                    echo CHtml::link(
                                    CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $img['path'], "c_fill,h_{$size[$i]['h']},w_{$size[$i]['w']}"), '', array('width' => $size[$i]['w'], 'height' => $size[$i]['h'])), 'javascript:void(0);', array('class' => 'smallimage', 'rel' => Tool::showImg(IMG_DOMAIN . '/' . $img['path'], 'c_fill,h_500,w_500'))
                                    );
                                    ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <span class="picNum">
                        <a href="javascript:void(0);" onclick="look_all_pic();" title="<?php echo Yii::t('hotelSite', '查看更多酒店图片'); ?>">
                            <?php echo Yii::t('hotelSite', '酒店图片'); ?>(<?php echo count($pictures) > 5 ? 5 : count($pictures); ?>)
                        </a>
                        <script>
                            function look_all_pic() {
                                $("html,body").animate({scrollTop: $("#hotelDetailTab").offset().top}, 1000, function() {
                                    $('#all_pictures').trigger('click');
                                });
                            }
                        </script>
                    </span>
                </div>
            <?php endif; ?>
            <div class="HotelIntroBox">
                <span class="HIntro"><?php echo Yii::t('hotelSite', '酒店简介'); ?></span>
                <?php echo $hotel['content'] ?>
            </div>
        </div>

        <div id="hotelDetailTab" class="hotelDetail nbt">
            <div class="hotelTabMbg">
                <div class="hotelTabmenu">
                    <a class="curr" href="javascript:void(0);" id="room_reserve"><?php echo Yii::t('hotelSite', '房型预订'); ?></a>
                    <a href="javascript:void(0);" id="all_pictures"><?php echo Yii::t('hotelSite', '酒店图片'); ?></a>
                    <a href="javascript:void(0);"><?php echo Yii::t('hotelSite', '住客评价'); ?></a>
                </div>
                <div class="fr"></div>
            </div>
            <div class="Htab" style="display: block;">
                <div class="hotelList">
                    <?php if (!empty($rooms)): ?>
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
                        <ul class="clearfix">
                            <?php foreach ((Array) $rooms->getData() as $key => $room): ?>
                                <?php
                                // 判断是否开启特定活动， 如果是，则使用活动价格
                                if (HotelRoom::isActivity($room->activities_start, $room->activities_end))
                                    $room->unit_price = $room->activities_start;
                                ?>
                                <li class="items clearfix">
                                    <span class="wfl w210"><i class="ico_img"></i><a href="javascript:void(0);" title="<?php echo $room->name ?>"><?php echo $room->name ?></a></span>
                                    <span class="wfl w60"><?php echo HotelRoom::getBed($room->bed) ?></span>
                                    <span class="wfl w60"><?php echo HotelRoom::getBreakFast($room->breadfast) ?></span>
                                    <span class="wfl w60"><?php echo HotelRoom::getNetwork($room->network) ?></span>
                                    <span class="wfl w85"><em><?php echo HtmlHelper::formatPrice($room->unit_price) ?></em></span>
                                    <span class="wfl w85"><b><?php echo Common::convert($room->unit_price) ?></b></span>
                                    <span class="wfl w100"><span class="ico_fan"><i><?php echo $room->estimate_back_credits ?><?php echo Yii::t('hotelSite', '分'); ?></i></span></span>
                                    <span class="wfl w140">
                                        <?php echo CHtml::link(Yii::t('hotelSite', '预订'), $this->createAbsoluteUrl('/hotel/order/create', array('id' => $room->id)), array('class' => 'hbtnSubmit')) ?>
                                        <a class="hbtnLook" href="javascript:void(0);"><?php echo Yii::t('hotelSite', '查看'); ?></a>
                                    </span>
                                </li>
                                <div class="hotelIntroTxt clearfix">
                                    <?php if (!empty($room->pictures)): ?>
                                        <div class="Himglist">
                                            <?php foreach ($room->pictures as $pic): ?>
                                                <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $pic->path, "c_fill,h_100,w_120"), $room->name, array('width' => 120, 'height' => 100)); ?>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="HserCon">
                                        <?php echo $room->content ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div><?php echo Yii::t('hotelSite', '暂无客房！'); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="Htab" style="display: none;">
                <?php if (!empty($pictures)): ?>
                    <div id="hotelAblum" class="hotelAblum">
                        <ul class="imgbox">
                            <?php foreach ($pictures as $pic): ?>
                                <li>
                                    <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $pic['path'], "c_fill,h_350,w_830"), '', array('width'=>'830','height'=>'350','style'=>'display: inline;'))?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="picNum"><span class="DB_current">0</span>/<span class="DB_total">0</span></div>
                        <div class="thumb">
                            <span class="sprev" style="display: none;"></span>
                            <div class="thimgbox">
                                <ul class="thumMove">
                                    <?php foreach ($pictures as $val): ?>
                                        <li>
                                            <?php
                                            echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $val['path'], "c_fill,h_62,w_84"), $hotel['name']), Tool::showImg(IMG_DOMAIN . '/' . $val['path'], "c_fill,h_350,w_830")
                                            );
                                            ?>
                                        </li>
                                    <?php endforeach; ?>
                                    <div class="thumLine" style="left: 0px;"></div>
                                </ul>
                            </div>
                            <span class="snext"></span>
                        </div>
                        <script type="text/javascript">
                            $('#hotelAblum').DB_gallery({
                                thumWidth: 94,
                                thumGap: 1,
                                thumMoveStep: 1,
                                moveSpeed: 1000,
                                fadeSpeed: 1000
                            });
                        </script>
                    </div>
                <?php else: ?>
                    <div><?php echo Yii::t('hotelSite', '暂无图片！'); ?></div>
                <?php endif; ?>
            </div>
            <div class="Htab" style="display: none;">
                <div class="hotelCommend">
                    <div class="review02">
                        <h2><?php echo Yii::t('hotelSite', '酒店综合评价'); ?></h2>
                        <p class="reviewScore">
                            <?php $graded = $hotel['total_score'] && $hotel['comments'] ? sprintf('%.2f', $hotel['total_score'] / $hotel['comments']) : 0; ?>
                        <u class="pingcons" title="<?php echo Yii::t('hotelSite', '综合评分'); ?><?php echo $graded; ?>">
                            <em style="width:<?php echo $graded * 20; ?>%"></em>
                        </u>
                        <u class="color_gray"><?php echo $graded; ?><?php echo Yii::t('hotelSite', '分'); ?></u>
                        </p>
                    </div>
                    <?php echo $this->renderPartial('_comments', array('dataProvider' => $comments)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="sliderright">
        <?php
        $advert = Advert::getConventionalAdCache('hotel-detail-ad'); // 酒店详细页右侧广告缓存数据
        $detailAd = isset($advert[0]) ? $advert[0] : array();
        if (!empty($detailAd) && AdvertPicture::isValid($detailAd['start_time'], $detailAd['end_time'])):
            ?>
            <div class="sliderAdver mgtop10">
                <?php echo CHtml::link(CHtml::image(ATTR_DOMAIN . '/' . $detailAd['picture'], $detailAd['title'], array('width' => '352', 'height' => '150')), $detailAd['link'], array('title' => $detailAd['title'], 'target' => $detailAd['target'])); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($hotel['lng']) && !empty($hotel['lat'])): ?>
            <div id="map" class="sliderMap mgtop10"></div>
            <script src="http://api.map.baidu.com/api?v=1.3" type="text/javascript"></script>
            <script src="http://api.map.baidu.com/getscript?v=1.3&ak=&services=&t=20131115060845" type="text/javascript"></script>
            <link href="http://api.map.baidu.com/res/13/bmap.css" type="text/css" rel="stylesheet">
            <script type="text/javascript">
                            function initMap() {
                                var lng = <?php echo $hotel['lng'] ?>;
                                var lat = <?php echo $hotel['lat'] ?>;
                                createMap(lng, lat);
                                setMapEvent();
                                addMapControl();
                            }
                            function createMap(lng, lat) {
                                var map = new BMap.Map("map"); //在百度地图容器中创建一个地图
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
                            initMap();
            </script>
        <?php endif; ?>
    </div>
</div>
