<script src="<?php echo $this->theme->baseUrl; ?>/js/jquery.flexslider-min.js"></script>
<script src="<?php echo $this->theme->baseUrl; ?>/js/shop-v2.0.js"></script>
<?php
//实体店
$design = $this->design;
$assetsUrl = Yii::app()->getModule('seller')->assetsUrl;
?>

<div class="shop-main clearfix">
		<div class="std-con">
			<div class="std-title std-title1"></div>
			<div class="std-info1">
			<?php if (isset($design->tmpData[DesignFormat::TMP_STORE_SYNOPSIS]['synopsis'])): ?>
                        <?php echo CHtml::encode($design->tmpData[DesignFormat::TMP_STORE_SYNOPSIS]['synopsis']) ?>
                    <?php else: ?>
                        <?php echo Yii::t('store', '掌柜在辛苦搬货，没空更新...')?>
                    <?php endif; ?>
				
			</div>
         <!-- 实体店幻灯片 -->
            <?php
            $slides = $design->tmpData[DesignFormat::TMP_STORE_SLIDE];
            $slides = isset($slides['Imgs']) ? $slides['Imgs'] : null;
            ?>
			<div class="std-title std-title2"></div>	
			<div class="std-banner shop-banner">
			<?php if ($slides): ?>
				 <ul class="slides">
				  <?php foreach ($slides as $k => $v): ?>
					<li><a href="<?php echo $v['Link']?>">
					     <?php echo CHtml::image(IMG_DOMAIN . '/' . $v['ImgUrl'], isset($v['Title']) ? $v['Title'] : null) ?>
					   </a>
					</li>
				  <?php endforeach; ?>
				</ul>
				<?php else: ?>
				<img width="1121" src="<?php echo $this->theme->baseUrl;?>/images/bgs/st_showDefaultImg.jpg" alt=""/>
			    <?php endif; ?>
			</div>
			<!-- 实体店联系方式 -->
			 <?php
                $tmpStore = $design->tmpData[DesignFormat::TMP_STORE_CONTACT];
                $tmpMain = $design->tmpData[DesignFormat::TMP_LEFT_CONTACT];
                $zipCode = isset($tmpStore['ZipCode']) ? $tmpStore['ZipCode'] : '';
                $emailList = isset($tmpStore['CustomerEmail']) ? $tmpStore['CustomerEmail'] : array();
                $customerPhone = isset($tmpStore['CustomerPhone']) ? $tmpStore['CustomerPhone'] : array();
              ?>
			<div class="std-title std-title3"></div>
			<div class="std-contact">
				<ul class="clearfix">
					<li class="std-contact-liBG1">
						    <?php echo Yii::t('store', 'QQ在线客服')?>
						<span><?php echo Yii::t('store', '实时沟通，在线解答您的问题')?></span>
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
						<?php echo Yii::t('store', '邮箱联系')?>
						<span><?php echo Yii::t('store', '发邮件的方式联系我们')?></span>
						<div>
						<?php if (!empty($emailList)): ?>
                                    <?php foreach ($emailList as $v): ?>
						      <a class="std-contact-link"><span>EMAIL :</span><?php echo $v;?></a>
						   <?php endforeach; ?>
                                <?php endif; ?>
                         </div>
					</li>
					<li class="std-contact-liBG3">
						<?php echo Yii::t('store', '电话联系')?>
						<span><?php echo Yii::t('store', '电话方式联系我们')?></span>
						<div>
						  <?php if (!empty($customerPhone)): ?>
                                    <?php foreach ($customerPhone as $v): ?>
                                        <a class="std-contact-link"><span><?php echo $v['ContactName'] ?> :</span><?php echo $v['ContactNum'] ?></a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                       </div>         
					</li>
				</ul>
			</div>
        <!-- 商家地图 -->
        <div class="std-title std-title4"></div>
           <div id="container" style="width:1121px; height:351px; border: #ccc solid 1px;"><img width="1121" src="../images/temp/st_mapImg.jpg"/></div>
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