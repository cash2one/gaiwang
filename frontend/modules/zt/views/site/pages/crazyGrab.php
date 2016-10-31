<script src="<?php echo DOMAIN ?>/js/jquery-1.7.2.js" type="text/javascript"></script>
<script type="text/javascript">
    function float_nav(dom) {
        var right_nav = $(dom);
        var nav_height = right_nav.height();
        function right_nav_position(bool) {
            var window_height = $(window).height();
            var nav_top = (window_height - nav_height) / 2;
            if (bool) {
                right_nav.stop(true, false).animate({top: nav_top + $(window).scrollTop()}, 700);
            } else {
                right_nav.stop(true, false).animate({top: nav_top}, 600);
            }
            right_nav.show();
        }

        if (!+'\v1' && !window.XMLHttpRequest) {
            $(window).bind('scroll resize', function() {
                if ($(window).scrollTop() > 900) {
                    right_nav_position(true);
                } else {
                    right_nav.hide();
                }
            })
        } else {
            $(window).bind('scroll resize', function() {
                if ($(window).scrollTop() > 900) {
                    right_nav_position();
                } else {
                    right_nav.hide();
                }
            })
        }
    }
    $(function() {
        float_nav("#crazyGrab50")
        float_nav("#crazyGrab51")
    })
</script>
<style type="text/css">
    .zt403{width:100%; background:#d02d48;}
    .pCon{ width:1100px; margin:0 auto; position:relative;}
</style> 
<?php $this->pageTitle = "双十一专场--盖粉狂欢节" . $this->pageTitle; ?>
<script>
    $(function() {
        float_nav("#crazyGrab33")
        float_nav("#crazyGrab34")
    })

</script>

<div class="zt403" id="partTop">			
    <div class="crazyGrab01"></div>
    <div class="crazyGrab02"></div>			
    <div class="crazyGrab03" id="crazyGrab03"></div>
    <div class="crazyGrab04">
        <div class="pCon">	
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/43.html'), array('class' => 'a1', 'title' => '家用电器', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/41.html'), array('class' => 'a2', 'title' => '服装鞋帽', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/42.html'), array('class' => 'a3', 'title' => '个护化妆', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/44.html'), array('class' => 'a4', 'title' => '手机数码', 'target' => '_blank')) ?>
        </div>
    </div>
    <!-- 头部方块链接 -->
    <div class="crazyGrab05">
        <div class="pCon">	
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/39.html'), array('class' => 'a1', 'title' => '电脑办公', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/38.html'), array('class' => 'a2', 'title' => '运动健康', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/40.html'), array('class' => 'a3', 'title' => '家居家装', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/50.html'), array('class' => 'a4', 'title' => '饮料食品', 'target' => '_blank')) ?>
        </div>
    </div>	
    <div class="crazyGrab06">
        <div class="pCon">	        
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/49.html'), array('class' => 'a1', 'title' => '礼品箱包', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/47.html'), array('class' => 'a2', 'title' => '珠宝首饰', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/46.html'), array('class' => 'a3', 'title' => '汽车用品', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/45.html'), array('class' => 'a4', 'title' => '母婴用品', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/48.html'), array('class' => 'a5', 'title' => '休闲旅游', 'target' => '_blank')) ?>
        </div>
    </div>
    <!-- 9.9秒杀区 -->
    <div class="crazyGrab07"></div>
    <div class="crazyGrab08" id="crazyGrab08"></div>			
    <div class="crazyGrab09">
        <div class="pCon">	    
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 49412)), array('class' => 'a1', 'title' => '荣华集团监制金鹏酥香榴莲酥120g', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 49411)), array('class' => 'a2', 'title' => '荣华集团监制金鹏爽口椰蓉酥120g', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 49409)), array('class' => 'a3', 'title' => '荣华集团监制金鹏酥香美味杏仁酥120g', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 49408)), array('class' => 'a4', 'title' => '荣华集团监制金鹏秘制芝麻肉松酥120g', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 34835)), array('class' => 'a5', 'title' => '荣华集团监制金鹏特制陈皮酥120g（使用正宗新会陈皮） ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 34832)), array('class' => 'a6', 'title' => '荣华集团监制金鹏香脆腰果酥120g ', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyGrab10">
        <div class="pCon">      
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 34830)), array('class' => 'a1', 'title' => '荣华集团监制金鹏广州特色西关鸡仔饼120g', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 34827)), array('class' => 'a2', 'title' => '荣华集团监制金鹏松香夏威夷果酥120g', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 60835)), array('class' => 'a3', 'title' => '128g橄榄油蜂蜜曲奇', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 57040)), array('class' => 'a4', 'title' => '雅诗雪沁YASER氨基酸核糖面膜', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 57702)), array('class' => 'a5', 'title' => '雅诗雪沁深层致柔卸妆膏 ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55235)), array('class' => 'a6', 'title' => '菲星便携小包FX001 ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 63626)), array('class' => 'a7', 'title' => '法国薇珂诗薇玻尿酸活养水感蚕丝面膜 ', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyGrab11" id="crazyGrab11"></div>
    <div class="crazyGrab12Wap">
        <div class="pCon">
            <div class="crazyGrab12">             
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 10369)), array('class' => 'a1', 'title' => '【欣悦园】2014采集 新鲜上市 精选特级 新疆特产哈密大枣 秒杀煮粥哈密枣王500g*5包全场包邮 买一送二', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 58458)), array('class' => 'a2', 'title' => '莱仕清肌防御CC霜套', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 62650)), array('class' => 'a3', 'title' => '香港karibu嘉婴宝 儿童超级马桶坐便器 四合一大号儿童坐便器', 'target' => '_blank')) ?>
            </div>
            <div class="crazyGrab13">        
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 10634)), array('class' => 'a1', 'title' => '【欣悦园】新疆和田有机 特级紫玫瑰花茶 纯天然养颜茶叶 玫瑰花茶50g/罐*5罐 买一送二', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 58492)), array('class' => 'a2', 'title' => '法国薇珂诗薇蜗牛修护靓颜美白补水祛痘蚕丝面膜', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 63217)), array('class' => 'a3', 'title' => '宝宝珊瑚绒马甲童 儿童珊瑚绒马甲童 儿背心珊瑚绒 两面穿背心', 'target' => '_blank')) ?>
            </div>
            <div class="crazyGrab14">      
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 56280)), array('class' => 'a1', 'title' => '茂县汶川冰糖心苹果/红富士糖心苹果/茂县苹果/阿坝苹果/新鲜水果/80#果装 10斤包邮', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 59997)), array('class' => 'a2', 'title' => '法国薇珂诗薇薰衣草控油净颜蚕丝面膜', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 63422)), array('class' => 'a3', 'title' => '2面穿 天然有机棉套装 ykk暗扣 婴儿彩棉 宝宝纯棉上衣裤子', 'target' => '_blank')) ?>
            </div>
            <div class="crazyGrab15">               
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 40988)), array('class' => 'a1', 'title' => '中粮 悠采干果组合P6 （哈密大枣、扁桃仁、黑加仑葡萄干、纸皮核桃）', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 62790)), array('class' => 'a2', 'title' => '玛珂化妆品套装', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 61312)), array('class' => 'a3', 'title' => '香港karibu嘉婴宝婴幼儿可折叠式浴盆', 'target' => '_blank')) ?>
            </div>
            <div class="crazyGrab16">           
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 54090)), array('class' => 'a1', 'title' => '六周年dngr2014新款尼克服男水貂翻领兔毛内胆加厚保暖中老年棉服外套', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 60576)), array('class' => 'a2', 'title' => '现代中式 自由组合实木书柜 储物柜 书架 文件柜 书橱 三门书柜 K0619', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 63567)), array('class' => 'a3', 'title' => '5D钻石画圆钻十字绣画最新款花卉客厅钻石绣 百合满园冰清玉洁', 'target' => '_blank')) ?>
            </div>
            <div class="crazyGrab17">
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 60374)), array('class' => 'a1', 'title' => '（纯手工订制）100%进口水貂 整貂 特别款貂皮黑加白套头衫 SSYLD120', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 62667)), array('class' => 'a2', 'title' => '中国十大品牌“玛丽匡特”纤体文胸L1008Y', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 63571)), array('class' => 'a3', 'title' => '最新款5d钻石绣 家和富贵玉兰花十字绣客厅钻石画圆钻贴钻画系列', 'target' => '_blank')) ?>
            </div>
            <div class="crazyGrab18">
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 60380)), array('class' => 'a1', 'title' => '（纯手工订制）100%进口水貂 整貂 甜美款 带帽 裘皮水晶色SSFD107', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 62671)), array('class' => 'a2', 'title' => '中国十大品牌“玛丽匡特”调整文胸QMZ1025', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 56751)), array('class' => 'a3', 'title' => '【全场包邮】美丽雅猎手平板旋转甩水拖把 平板甩水二合一 HC053588', 'target' => '_blank')) ?>
            </div>
            <div class="crazyGrab19">   
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 54084)), array('class' => 'a1', 'title' => '六周年dngr皮毛一体尼克服男羊毛内胆韩版商务修身保暖棉衣棉服外套', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 57994)), array('class' => 'a2', 'title' => '原创设计冬装新款皮毛一体真皮皮草连帽大衣JAO51111', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 54259)), array('class' => 'a3', 'title' => '2014秋冬新款羊毛呢子毛呢大衣中长款毛呢外套女', 'target' => '_blank')) ?>
            </div>
            <div class="crazyGrab20">
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 56117)), array('class' => 'a1', 'title' => '【艳洋数码】正品行货 三星手机 Galaxy S4 GT-i9500 盖世4 黑/白色', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55125)), array('class' => 'a2', 'title' => '【鑫万兴通讯】正品行货 三星手机 Galaxy S4 GT-i9500 盖世4 黑/白色', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55117)), array('class' => 'a3', 'title' => '三星手机 I9300 GALAXY SIII S3 盖世3 兰色 港版" target="_blank', 'target' => '_blank')) ?>
            </div>
            <div class="crazyGrab21">               
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 57153)), array('class' => 'a1', 'title' => '智尚家具 时尚简欧换鞋凳/储物凳/全新ABS材料 2W9-1（颜色拍下留言））', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 56123)), array('class' => 'a2', 'title' => '【艳洋数码】三星手机 Galaxy S4 SCH-i959 电信双模 国行 黑/兰/白色', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 64192)), array('class' => 'a3', 'title' => 'Meizu/魅族4 魅族MX4 32G 双4G版 八核智能手机 5.4寸大屏 黑', 'target' => '_blank')) ?>
            </div>
            <div class="crazyGrab22">          
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 532)), array('class' => 'a1', 'title' => '尚品佳坊 纳米雪银绒蚕丝被', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 63830)), array('class' => 'a2', 'title' => '华为 HUAWEI Ascend P7 移动4G智能手机 TD-LTE/TD-SCDMA/GSM ', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 44018)), array('class' => 'a3', 'title' => '缘沐 天然斐济檀香木8mm108颗佛珠手链手串 白檀同料顺纹 男士款', 'target' => '_blank')) ?>
            </div>
            <div class="crazyGrab23">         
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 53132)), array('class' => 'a1', 'title' => '美丽雅 猎手 经典旋转甩水拖把 HC050389', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 6557)), array('class' => 'a2', 'title' => '尚品佳坊 秋冬新款情侣加厚法兰绒睡衣家居服套装', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 63837)), array('class' => 'a3', 'title' => '华为 荣耀6 4G TD-LTE/TD-SCDMA/GSM（16GB存储）（黑色/白色）', 'target' => '_blank')) ?>
            </div>
            <div class="crazyGrab24">
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 50136)), array('class' => 'a1', 'title' => '瑞士佛朗戈 宠爱系列 F-8108G/L-B', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 48875)), array('class' => 'a2', 'title' => '瑞士军刀2014商务男士公文包 真皮正品男包手提包 头层牛皮电脑包 活动包邮 ', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 49661)), array('class' => 'a3', 'title' => '不锈钢内胆酸奶机家用自制早餐酸奶米酒纳豆机', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 59786)), array('class' => 'a4', 'title' => '进口跑步机上门安装美国sole速尔F80PRO豪华正品家用电动跑步机', 'target' => '_blank')) ?>
            </div>
            <div class="crazyGrab25">    
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 43988)), array('class' => 'a1', 'title' => '印度小叶紫檀老料顺纹金星10mm19颗念珠手链手串女款', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 50962)), array('class' => 'a2', 'title' => '瑞士军刀SWISSGEAR 珍珠尼龙面料14寸超极本iPad专用双层袋竖款电脑包休闲公文包SA-7773黑色 ', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 63674)), array('class' => 'a3', 'title' => 'Povos/奔腾PA1103空气净化器除甲醛pm2.5杀菌负离子氧', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 59814)), array('class' => 'a4', 'title' => '进口椭圆机美国速尔sole家用磁控静音椭圆机E25太空漫步机', 'target' => '_blank')) ?>
            </div>
            <div class="crazyGrab26">       
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 63930)), array('class' => 'a1', 'title' => '秋冬新款 奢侈品男包 全手工牛皮编织手提斜挎包 高端定', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 50747)), array('class' => 'a2', 'title' => '茶树薰衣草', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 57197)), array('class' => 'a3', 'title' => '思维翼二轮平衡车（铅酸版）', 'target' => '_blank')) ?>
            </div>
            <div class="crazyGrab27">
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 64180)), array('class' => 'a1', 'title' => '【万锋】三星Galaxy Note4 N9100 4G双卡双待手机 FDD-LTE/TD-LTE/TD-SCDMA/WCDMA/GSM 双卡双待 公开版 旗舰新品，新一代的S Pen，用心对话！', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 50101)), array('class' => 'a2', 'title' => '瑞士佛朗戈 宠爱系列 F-8079L-A/B', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 63900)), array('class' => 'a3', 'title' => '精品男包 高端奢侈品大品牌 男女适用 编织牛皮休闲电脑手提包', 'target' => '_blank')) ?>
            </div>
            <div class="crazyGrab28">
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 54866)), array('class' => 'a1', 'title' => '奔腾PQ9201高端定制剃须刀全身水洗4D智能浮动刀头配专业鬓角刀', 'target' => '_blank')) ?>
                <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 59808)), array('class' => 'a2', 'title' => 'EVO电动滑板车ES17款（铅酸）', 'target' => '_blank')) ?>
            </div>

        </div>
    </div>
    <div class="crazyGrab29"  id="crazyGrab29"></div>
    <div class="crazyGrab30">
        <div class="pCon">	
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/43.html'), array('class' => 'a1', 'title' => '小家电', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/41.html'), array('class' => 'a2', 'title' => '服装', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/42.html'), array('class' => 'a3', 'title' => '化妆品', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/44.html'), array('class' => 'a4', 'title' => '手机数码', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/39.html'), array('class' => 'a5', 'title' => '电脑', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/38.html'), array('class' => 'a6', 'title' => '运动健康', 'target' => '_blank')) ?>
        </div>		
    </div>
    <div class="crazyGrab31">
        <div class="pCon">
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/40.html'), array('class' => 'a1', 'title' => '家居', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/50.html'), array('class' => 'a2', 'title' => '食品分场', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/49.html'), array('class' => 'a3', 'title' => '箱包分场', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/46.html'), array('class' => 'a4', 'title' => '汽车', 'target' => '_blank')) ?>
        </div>		
    </div>
    <div class="crazyGrab32">
        <div class="pCon">
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/47.html'), array('class' => 'a1', 'title' => '珠宝', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/45.html'), array('class' => 'a2', 'title' => '母婴', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/48.html'), array('class' => 'a3', 'title' => '旅游', 'target' => '_blank')) ?>
        </div>		
    </div>
    <div class="crazyGrab33" id="crazyGrab33"></div>
    <div class="crazyGrab34" id="crazyGrab34">
        <div class="pCon">	
            <a href="#crazyGrab03" class="a1" title="分场进入"></a>
            <a href="#crazyGrab08" class="a2" title="9.9专区"></a>
            <a href="#crazyGrab11" class="a3" title="折扣区"></a>
            <a href="#crazyGrab29" class="a4" title="特惠区"></a>
            <a href="#partTop" class="a5" title="回到底部"></a>
        </div>		
    </div>




</div>

</div>     
