<!-- PAGE HEADER -->

<div class="company-box">
    <div class="w1200">
        <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN.'/'.$franchisee['thumbnail'], 'c_fill,h_250,w_754'),'',array('width'=>'754px','height'=>'250px','alt'=>$franchisee['name'],'class'=>"SL-img"));?>
        <div class="company clearfix">
            <h1><?php echo $franchisee['name']; ?></h1>
            <div class="clearfix">
                <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN.'/'.$franchisee['logo'], 'c_fill,h_68,w_138'),'',array('width'=>'138px','height'=>'68px','alt'=>$franchisee['name'],'class'=>"logo SL-logo"));?>
                <div class="left-box">
                    <em class="discount discount2"><?php echo $franchisee['member_discount']/10 ?><?php echo Yii::t('jms','折'); ?></em>
                </div>
                <div>
                    <p class="description cl"><?php echo $franchisee['summary']; ?></p>
                    <div class="clearfix">
                        <div class="right-box">
                            <div class="inner">
                                <p class="views"><?php echo $franchisee['visit_count'].Yii::t('site', "次");; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="SL-info clearfix cl">
            <p class="address"><i class="icon icon-address"></i><?php echo Yii::t('site', "餐厅地址"); ?>：<?php echo $franchisee['rc_name'].$franchisee['rd_name'].$franchisee['street']; ?></p>
            <p class="tel"><i class="icon icon-tel"></i><?php echo Yii::t('site', "联系电话");?>：<?php echo $franchisee['mobile']; ?></p>
        </div>
        <!--小图片左右切换-->
        <script>
            $(function(){
                var SLImgNum=$(".SL-showImg-list ul li").length;
                var SLNxet=$(".SL-showImg-next");
                var SLPrev=$(".SL-showImg-prev");
                var leftz=0;
                var I=0;
                $(".SL-showImg-next").click(function(){
                    if((SLImgNum-1)>I){
                        $(".SL-showImg-list ul").animate({left: (leftz-=210)}, "10000");
                        I+=1;
                    }
                });
                $(".SL-showImg-prev").click(function(){
                    if(I>0){
                        $(".SL-showImg-list ul").animate({left: (leftz+=210)}, "10000");
                        I-=1;
                    }
                });
            });
        </script>

        <!--小图片左右切换-->
        <div class="SL-showImg clearfix">
            <div class="SL-showImg-prev"></div>
            <div class="SL-showImg-list">
                <?php if(!empty($pictures)){ ?>
                <ul class="clearfix">
                    <?php foreach($pictures as $key => $picture) { ?>
                    <li><?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $picture['path'], 'c_fill,h_200,w_200'),'',array('width'=>'200px','height'=>'200px'));?>
                        </li>
                    <?php } ?>
                </ul>
                <?php } ?>
            </div>
            <div class="SL-showImg-next"></div>
        </div>
<!-- END PAGE HEADER -->
<!-- CONTENT -->
<div class="content">
    <div class="w1200">
        <div class="main">
            <div class="map">
                <h3 class="title"><?php echo Yii::t('site', "商家位置"); ?></h3>
                <div id="map" style="width: 944px;height: 330px" class="inner">

                </div>
                <h3 class="title"><?php echo Yii::t('site', "商家介绍"); ?></h3>
                <?php echo $this->delSlashes($franchisee['description'])?>
            </div>
        </div>
        <div class="side">
            <h3 class="title"><?php echo Yii::t('site', "盖网推荐"); ?></h3>
            <?php if(!empty($difFranchisees)){
               foreach($difFranchisees as $key => $recommend) { ?>
                   <div class="sd-item">
                       <a href="<?php echo $this->createAbsoluteUrl('view',array('id'=>$recommend['id']));?>" target="_blank" title="<?php echo $recommend['name']; ?>">
                           <?php $url = !empty($recommend['logo']) ? Tool::showImg(ATTR_DOMAIN . '/'.$recommend['logo'], 'c_fill,h_110,w_220') : DOMAIN.'/images/bgs/seckill_product_bg.png';
                           echo CHtml::image($url,'',array('width'=>'220px','height'=>'110px','alt'=>$recommend['name']));?>
                       </a>
                       <p class="color-block fw wh tc"><?php echo Tool::truncateUtf8String($recommend['name'],15); ?></p>
                   </div>
               <?php
               }}?>
        </div>
    </div>
</div>
<!-- END CONTENT -->
    </div>
<?php if (!empty($franchisee['lng']) && !empty($franchisee['lat'])): ?>

    <script src="http://api.map.baidu.com/api?v=1.3" type="text/javascript"></script>
    <!-- 加载百度地图样式信息窗口 -->
    <script type="text/javascript" src="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js"></script>
    <link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />
    <script type="text/javascript">
        function initMap() {
            var lng = <?php echo $franchisee['lng'] ?>;
            var lat = <?php echo $franchisee['lat'] ?>;
            createMap(lng, lat);
            setMapEvent();
            addMapControl();
        }
        function createMap(lng, lat) {
            var map = new BMap.Map("map"); //在百度地图容器中创建一个地图
            var point = new BMap.Point(lng, lat); //定义一个中心点坐标
            map.centerAndZoom(point, 15); //设定地图的中心点和坐标并将地图显示在地图容器中

            var marker1 = new BMap.Marker(new BMap.Point(lng, lat));  // 创建标注
            var label = new BMap.Label('<?php echo $franchisee['name']?>', {"offset": new BMap.Size(10, -20)});
            marker1.setLabel(label);
            marker1.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
            map.addOverlay(marker1);
            label.setStyle({
                borderColor: "#808080",
                color: "#333",
                cursor: "pointer"
            });
            //带检索的信息窗口
            marker1.addEventListener("mouseover", function () {
                var content = '<?php echo $franchisee['rc_name'].$franchisee['rd_name'].$franchisee['street'] ?>';
                var searchInfoWindow = new BMapLib.SearchInfoWindow(map, content, {
                    title:'<?php echo $franchisee['name']?>',
                    width: 290, //宽度
                    height: 40, //高度
                    panel : "panel", //检索结果面板
                    enableAutoPan : true, //自动平移
                    enableSendToPhone: true, //是否显示发送到手机按钮
                    searchTypes :[
                        BMAPLIB_TAB_TO_HERE,  //到这里去
                        BMAPLIB_TAB_SEARCH,   //周边检索
                        BMAPLIB_TAB_FROM_HERE //从这里出发
                    ]
                });
                searchInfoWindow.open(point);
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