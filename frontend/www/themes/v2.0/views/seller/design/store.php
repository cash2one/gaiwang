<!-- content -->

<script src="<?php echo $this->theme->baseUrl; ?>/js/jquery.flexslider-min.js"></script>
<script src="<?php echo $this->theme->baseUrl; ?>/js/shop-v2.0.js"></script>
<?php
//Tool::pr($design->tmpData[DesignFormat::TMP_LEFT_CONTACT]);
?>
<div id="template1" class="">
    <div class="t1-blank10"></div>
    <div class="shop_entity_box">
        <!-- 实体店介绍 -->
        <div class="" id="synopsis">
            <div class="title">
                <img src="<?php echo $this->theme->baseUrl;?>/images/bgs/st_title1.png" alt=""/>
            </div>
            <div class="cons">
                <p>
                    <?php if (isset($design->tmpData[DesignFormat::TMP_STORE_SYNOPSIS]['synopsis'])): ?>
                        <?php echo CHtml::encode($design->tmpData[DesignFormat::TMP_STORE_SYNOPSIS]['synopsis']) ?>
                    <?php else: ?>
                        <?php echo Yii::t('sellerDesign','掌柜在辛苦搬货，没空更新...'); ?>
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
           <div class="title"><img src="<?php echo $this->theme->baseUrl;?>/images/bgs/st_title2.png" width="910"/></div>
            <?php if ($slides): ?>
                <div class="zhans">
                    <div id="t1-feature-910x500" class="t1-wrap mod t1-feature-910x500">
                         <ul class="slides">
                            <?php foreach ($slides as $k => $v): ?>
                                <li><a href="<?php echo $v['Link']?>">
                                        <?php echo CHtml::image(IMG_DOMAIN . '/' . $v['ImgUrl'], isset($v['Title']) ? $v['Title'] : null) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <div class="editTipsImg" style="height: 415px;"></div>
            <?php endif; ?>

        </div>
        <script type="text/javascript" src="<?php echo $this->theme->baseUrl;?>/js/slides.min.jquery.js"></script>
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
            <div class="title"><img src="<?php echo $this->theme->baseUrl;?>/images/bgs/st_title3.png" alt=""/></div>
            <div>
                <div class="std-contact">
                   <ul class="clearfix">
					<li class="std-contact-liBG1">
						<?php echo Yii::t('sellerDesign','QQ在线客服'); ?>
						<span><?php echo Yii::t('sellerDesign','实时沟通，在线解答您的问题'); ?></span>
						<?php if(isset($design->tmpData[DesignFormat::TMP_LEFT_CONTACT]['CustomerData'])):?>
                                <?php foreach ($design->tmpData[DesignFormat::TMP_LEFT_CONTACT]['CustomerData'] as $k => $v): ?>
                                        <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $v['ContactNum'] ?>&amp;site=qq&amp;menu=yes"
                                           class="qqon">
                                            <?php echo CHtml::image('http://wpa.qq.com/pa?p=2:' . $v['ContactNum'] . ':41', '点击这里给我发消息') ?>
                                        </a>
                                <?php endforeach; ?>
                                <?php endif;?>
					</li>
					<li class="std-contact-liBG2">
						<?php echo Yii::t('sellerDesign','邮箱联系'); ?>
						<span><?php echo Yii::t('sellerDesign','发邮邮件的方式联系我们'); ?></span>
						 <?php if (!empty($emailList)): ?>
                                    <?php foreach ($emailList as $v): ?>
                                      <span class="std-contact-link"><span>EMAIL :</span> <?php echo $v ?></span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
					</li>
					<li class="std-contact-liBG3">
						<?php echo Yii::t('sellerDesign','电话联系'); ?>
						<span><?php echo Yii::t('sellerDesign','电话方式联系我们'); ?></span>
						 <?php if (!empty($customerPhone)): ?>
                                    <?php foreach ($customerPhone as $v): ?>
                                        <span class="std-contact-link"><span><?php echo $v['ContactName'] ?> :</span><?php echo $v['ContactNum'] ?></span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
					</li>
				</ul>
                </div>
            </div>
        </div>

        <!-- 商家地图 -->
        <div class="editor" id="storeMap">
            <div class="title"><img src="<?php echo $this->theme->baseUrl;?>/images/bgs/st_title4.png"/></div>
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
    <?php  if ($this->currentDesign->status == Design::STATUS_EDITING): ?>
    $(document).ready(function () {
        bindHover($('#synopsis'), 'setSynopsis()');
        //设置实体店幻灯片
        bindHover($('#t1-feature'), 'setMainSlide1()');
        //设置联系方式
        bindHover($('#storeContact'), 'setContact()');
        //设定实体店经纬度
        bindHover($('#storeMap'), 'mapEdit()');
    });
    <?php endif; ?>
    var setSynopsis = function () {
        var url = '<?php echo $this->createAbsoluteUrl('/seller/design/storeInfo',array('id'=>$this->currentDesign->id)) ?>';
        dialog = art.dialog.open(url, { 'id': 'SetSynopsis', title: '<?php echo Yii::t('sellerDesign','设置实体店介绍'); ?>', width: '650px', height: '300px', lock: true });
    };

    var setMainSlide1 = function () {
        var url = '<?php echo $this->createAbsoluteUrl('/seller/design/storeSlide',array('id'=>$this->currentDesign->id)) ?>';
        dialog = art.dialog.open(url, { 'id': 'SearchCat', title: '<?php echo Yii::t('sellerDesign','设置幻灯片'); ?>', width: '640px', height: '465px', lock: true });
    };


    var setContact = function () {
        var url = '<?php echo $this->createAbsoluteUrl('/seller/design/storeContact',array('id'=>$this->currentDesign->id)) ?>';
        dialog = art.dialog.open(url, { 'id': 'SearchCat', title: '<?php echo Yii::t('sellerDesign','设置联系方式'); ?>', width: '640px', height: '760px', lock: true });
    };

    var mapEdit = function () {
        var url = '<?php echo $this->createAbsoluteUrl('/seller/design/storeMap',array('id'=>$this->currentDesign->id)) ?>';
        dialog = art.dialog.open(url, {
            'title': '<?php echo Yii::t('sellerDesign','设定经纬度'); ?>',
            'lock': true,
            'window': 'top',
            'width': 800,
            'height': 300,
            'border': true
        });
    };


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