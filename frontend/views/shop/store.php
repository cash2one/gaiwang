<?php
//实体店
$design = $this->design;
$assetsUrl = Yii::app()->getModule('seller')->assetsUrl;
?>
<link rel="stylesheet" href="<?php echo $assetsUrl ?>/css/store.css"/>
<style>
    .mainbj .title{height: 100%;border:none;}
</style>
<div id="template1" class="mainbj">
    <div class="t1-blank10"></div>
    <div class="shop_entity_box">
        <!-- 实体店介绍 -->
        <div class="editor" id="synopsis">
            <div class="title">
                <img src="<?php echo $assetsUrl ?>/images/bg/shop_t1.gif" alt=""/>
            </div>
            <div class="cons">
                <p>
                    <?php if (isset($design->tmpData[DesignFormat::TMP_STORE_SYNOPSIS]['synopsis'])): ?>
                        <?php echo CHtml::encode($design->tmpData[DesignFormat::TMP_STORE_SYNOPSIS]['synopsis']) ?>
                    <?php else: ?>
                        暂无介绍
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <!-- 实体店幻灯片 -->
        <?php
        $slides = $design->tmpData[DesignFormat::TMP_STORE_SLIDE];
        $slides = isset($slides['Imgs']) ? $slides['Imgs'] : null;
        ?>
        <div class="editor" id="t1-feature">
            <div class="title"><img src="<?php echo $assetsUrl ?>/images/bg/shop_t2.gif" width="910"/>
            </div>
            <?php if ($slides): ?>
                <div class="zhans">
                    <div id="t1-feature-910x500" class="t1-wrap mod t1-feature-910x500">
                        <div class="slides_container">
                            <?php foreach ($slides as $k => $v): ?>
                                <div class="<?php echo $k == 0 ? 'curr' : null ?>">
                                    <a href="javascript:void(0);">
                                        <?php echo CHtml::image(IMG_DOMAIN . '/' . $v['ImgUrl'], isset($v['Title']) ? $v['Title'] : null) ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="pagination">
                            <?php foreach ($slides as $k => $v): ?>
                                <i><?php echo $k + 1 ?></i>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="editTipsImg" style="height: 415px;"></div>
            <?php endif; ?>

        </div>
        <script type="text/javascript" src="<?php echo $assetsUrl ?>/js/slides.min.jquery.js"></script>
        <!-- 实体店联系方式 -->
        <?php
        $tmpStore = $design->tmpData[DesignFormat::TMP_STORE_CONTACT];
        $tmpMain = $design->tmpData[DesignFormat::TMP_LEFT_CONTACT];
        $provinceId = isset($tmpStore['ProvinceId']) ? $tmpStore['ProvinceId'] : '';
        $cityId = isset($tmpStore['CityId']) ? $tmpStore['CityId'] : '';
        $districtId = isset($tmpStore['DistrictId']) ? $tmpStore['DistrictId'] : '';
        $street = isset($tmpStore['Street']) ? $tmpStore['Street'] : '';
        $zipCode = isset($tmpStore['ZipCode']) ? $tmpStore['ZipCode'] : '';
        $emailList = isset($tmpStore['CustomerEmail']) ? $tmpStore['CustomerEmail'] : array();
        $customerPhone = isset($tmpStore['CustomerPhone']) ? $tmpStore['CustomerPhone'] : array();
        ?>
        <div class="editor" id="storeContact">
            <div class="title"><img src="<?php echo $assetsUrl ?>/images/bg/shop_t3.gif" alt=""/></div>
            <div class="dz_con">
                <span class="as">
                    地址：
                    <strong>
                        <?php echo Region::getName($provinceId, $cityId, $districtId) ?>
                        <?php echo $street ?>
                    </strong>
                </span>
                <span class="as">
                     邮编：<strong><?php echo $zipCode ?></strong>
                </span>

                <div class="gzf_bj clearfix">
                    <ul>
                        <li><span class="k1">QQ方式联系我们</span>
                            <dl>
                            <?php if(isset($design->tmpData[DesignFormat::TMP_LEFT_CONTACT]['CustomerData'])):?>
                                <?php foreach ($design->tmpData[DesignFormat::TMP_LEFT_CONTACT]['CustomerData'] as $k => $v): ?>
                                    <dd>
                                        <?php echo $v['ContactPrefix'] ?>
                                        <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $v['ContactNum'] ?>&amp;site=qq&amp;menu=yes"
                                           class="qqon">
                                            <?php echo CHtml::image('http://wpa.qq.com/pa?p=2:' . $v['ContactNum'] . ':41', '点击这里给我发消息') ?>
                                        </a>
                                    </dd>
                                <?php endforeach; ?>
                                <?php endif;?>
                            </dl>
                        </li>
                        <li><span class="k2">邮箱方式联系我们</span>
                            <dl>
                                <?php if (!empty($emailList)): ?>
                                    <?php foreach ($emailList as $v): ?>
                                        <dd> <?php echo $v ?></dd>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </dl>
                        </li>
                        <li><span class="k3">电话方式联系我们</span>
                            <dl>
                                <?php if (!empty($customerPhone)): ?>
                                    <?php foreach ($customerPhone as $v): ?>
                                        <dd> <?php echo $v['ContactName'] ?>:<?php echo $v['ContactNum'] ?></dd>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </dl>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- 商家地图 -->
        <div class="editor" id="storeMap">
            <div class="title"><img src="<?php echo $assetsUrl ?>/images/bg/shop_t4.gif"/></div>
            <div class="map">
                <div style="width:1118px; height:351px; border: #ccc solid 1px;" id="container"></div>
            </div>
        </div>
        <!-- end -->
    </div>
</div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
<script type="text/javascript">
    //实体店介绍

    function initMap() {
        createMap();
        setMapEvent();
        addMapControl();
    }
    <?php
     $mapData = $design->tmpData[DesignFormat::TMP_STORE_MAP];
     $label = isset($mapData['Lable']) ? $mapData['Lable'] : '';
     $x = isset($mapData['POS_X']) ? $mapData['POS_X'] : '';
     $y = isset($mapData['POS_Y']) ? $mapData['POS_Y']: '';
    ?>
    function createMap() {
        var map = new BMap.Map("container"); //在百度地图容器中创建一个地图
        var point = new BMap.Point('<?php echo $x ?>', '<?php echo $y ?>'); //定义一个中心点坐标
        map.centerAndZoom(point, 15); //设定地图的中心点和坐标并将地图显示在地图容器中

        var marker1 = new BMap.Marker(new BMap.Point('<?php echo $x ?>', '<?php echo $y ?>'));  // 创建标注
        var label = new BMap.Label('<?php echo $label ?>', { "offset": new BMap.Size(10, -20) });
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
        var ctrl_nav = new BMap.NavigationControl({ anchor: BMAP_ANCHOR_TOP_LEFT, type: BMAP_NAVIGATION_CONTROL_LARGE });
        map.addControl(ctrl_nav);
        //向地图中添加比例尺控件
        var ctrl_sca = new BMap.ScaleControl({ anchor: BMAP_ANCHOR_BOTTOM_LEFT });
        map.addControl(ctrl_sca);
    }

    initMap();

</script>