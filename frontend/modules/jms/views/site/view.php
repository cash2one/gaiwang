    <!--------------主体 begin---------->	
	
    <div class="main">
		<div class="offLineinNav"><a href="<?php echo Yii::app()->createAbsoluteUrl('/')?>" title="<?php echo Yii::t('jms','盖象商城')?>" target="_blank"><?php echo Yii::t('jms','盖象商城')?></a> > <a href="<?php echo $this->createAbsoluteUrl('index')?>" title="<?php echo Yii::t('jms','盖网通联盟商户')?>" target="_blank"><?php echo Yii::t('jms','盖网通联盟商户')?></a> > <span class="red"><?php echo $franchisee['name']?></span></div>
        <div class="storeIntro">
			<div class="storeAd"><img width=1198 height=400 src="<?php echo Tool::showImg(ATTR_DOMAIN . '/' . $franchisee['thumbnail'],'h_400,w_1200' )?>" alt="<?php echo $franchisee['name']?>"/></div>
			<div class="storeMsg clearfix">
				<div class="storeLogo fl"><div class="logoImg"><img  src="<?php echo Tool::showImg( ATTR_DOMAIN . '/' . $franchisee['logo2'], 'h_170,w_170')?>" alt="<?php echo $franchisee['name']?>"/></div><p><?php echo $franchisee['name']?></p></div>
				<div class="storeAbout fr">
					<h2>商户简介/ABOUT COMPANY</h2>
					<p class="aboutText"><?php echo $franchisee['summary']?></p>
					<div class="discount"><?php echo Yii::t('jms','盖网会员专享：')?><span><?php echo $franchisee['member_discount']/10 ?><?php echo Yii::t('jms','折')?></span></div>
				</div>
			</div>
		</div>
		<div class="mgtop30 clearfix">
			<ul id="mycarousel" class="jcarousel-skin-tango">
				<?php foreach ($pictures as $picture):?>
				<li><img width="200" height="200" src="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $picture['path'], 'h_200,w_200') ?>" alt="<?php echo $franchisee['name']?>"/></li>
				<?php endforeach;?>					
			</ul>				
		</div>
		
		<div class="storeOther mgtop30">
			<div class="sOtherTit"><span class="titleBg"><?php echo Yii::t('jms','商家位置')?></span></div>
			<div class="storeLocation mgtop30 clearfix">
				<div class="storeMap fl">
					<div id="map" class="mapBox"  style="width:897px;height:270px;" ></div>
					<div class="mapMsg mgtop20">
						<h2><?php echo $franchisee['name'] ?></h2>
						<p class="mapText"><?php echo Yii::t('jms','电话：')?><?php echo $franchisee['mobile']?><br/><?php echo Yii::t('jms','地址：')?><?php echo $franchisee['rc_name'].$franchisee['rd_name'].$franchisee['street'] ?></p>
					</div>
				</div>
				<div class="storeLink fr">
					<ul>
				<?php foreach ($difFranchisees as $difFranchisee):?>
					<li><a href="<?php echo $this->createAbsoluteUrl('view',array('id'=>$difFranchisee['id']))?>" title="<?php echo $difFranchisee['name']?>" target="_blank"><img width="223" height="190" class="lazy" data-url="<?php if(!empty($recommend['logo'])) {
                                echo ATTR_DOMAIN . '/'.$recommend['logo'];
                            }else{
                                echo DOMAIN.'/images/bgs/seckill_product_bg.png';
                            }  ?>" alt="<?php echo $recommend['name'] ?>"/></a></li>
				<?php endforeach;?>	
					</ul>
				</div>
			</div>
			
			<div class="sOtherTit mgtop30"><span class="titleBg"><?php echo Yii::t('jms','精品推荐')?></span></div>
			<div class="boutique mgtop30 clearfix">				
				<p class="mgtop30"><?php echo $this->delSlashes($franchisee['featured_content'])?></p>
			</div>
			
			<div class="sOtherTit mgtop30"><span class="titleBg"><?php echo Yii::t('jms','详情介绍')?></span></div>
			<div class="boutique mgtop30 clearfix">				
				<p class="mgtop30"><?php echo $this->delSlashes($franchisee['description'])?><br/><br/><br/><br/><br/></p>
			</div>
		</div>
    </div>

    <div class="clear"></div>
    <!--------------主体 End------------>
 
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