<script src="<?php echo DOMAIN ?>/js/jquery-1.7.2.js" type="text/javascript"></script>
<script type="text/javascript">
function float_nav(dom){
	var right_nav=$(dom);
	var nav_height=right_nav.height();
	function right_nav_position(bool){
		var window_height=$(window).height();
		var nav_top=(window_height-nav_height)/2;
		if(bool){
			right_nav.stop(true,false).animate({top:nav_top+$(window).scrollTop()},700);
		}else{
			right_nav.stop(true,false).animate({top:nav_top},600);
		}	
		right_nav.show();
	}
	
	if(!+'\v1' && !window.XMLHttpRequest ){
		$(window).bind('scroll resize',function(){
			if($(window).scrollTop()>900){
				right_nav_position(true);			
			}else{
				right_nav.hide();	
			}
		})
	}else{
		$(window).bind('scroll resize',function(){
			if($(window).scrollTop()>900){
				right_nav_position();
			}else{
				right_nav.hide();
			}
		})
	}
}
$(function(){
	float_nav("#crazyNational50")
	float_nav("#crazyNational51")
})
</script>
<style type="text/css">
    .zt403{width:100%; background:#ef0954;}
    .pCon{ width:1100px; margin:0 auto; position:relative;}
</style> 
<?php $this->pageTitle = "十一专场--全民疯抢" . $this->pageTitle; ?>
<div class="zt403" id="partTop">			
    <div class="crazyNational01"></div>
    <div class="crazyNational02"></div>			
    <div class="crazyNational03"></div>
    <div class="crazyNational04"></div>
    <!-- 头部方块链接 -->
    <div class="crazyNational05">
        <div class="pCon">
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/UTen.html'), array('class' => 'a1', 'title' => '盖网优生活', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/nationalFood.html'), array('class' => 'a2', 'title' => '食在盖网 美在中国', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/bagsPreferential.html'), array('class' => 'a3', 'title' => '箱包会', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/nationalCloth.html'), array('class' => 'a4', 'title' => '美在盖网--服装专版', 'target' => '_blank')) ?>
        </div>
    </div>	
    <div class="crazyNational06">
        <div class="pCon">     
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/jewelNational.html'), array('class' => 'a1', 'title' => '魅力盖粉贵族人生', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/nationalDigital.html'), array('class' => 'a2', 'title' => '手指间精彩--数码专版', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/houseAppliance.html'), array('class' => 'a3', 'title' => '有爱才有家 有爱才有TA', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/travelNational.html'), array('class' => 'a4', 'title' => '十一去哪儿', 'target' => '_blank')) ?>
        </div>
    </div>
    <!-- 9.9秒杀区 -->
    <div class="crazyNational07"></div>
    <div class="crazyNational08" id="part0">
        <div class="pCon"> 
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 57040)), array('class' => 'a1', 'title' => '雅诗雪沁YASER氨基酸核糖面膜', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55235)), array('class' => 'a2', 'title' => '菲星便携小包FX001', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 47048)), array('class' => 'a3', 'title' => '（盖网通联）ASUS/华硕礼品礼盒 触摸灯+触摸笔套装 USB触摸灯 USB灯 活动进行中9.9块包邮哦 5个起提包邮', 'target' => '_blank')) ?>
        </div>
    </div>			
    <div class="crazyNational09">
        <div class="pCon">
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 57068)), array('class' => 'a1', 'title' => '红色健康 无果枸杞芽茶 地字30', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 57075)), array('class' => 'a2', 'title' => '武宁长枣', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational10">
        <div class="pCon">        
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 56649)), array('class' => 'a1', 'title' => '鸡仔饼280g广东特产 本店任选五件以上免邮费 休闲食品', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 56540)), array('class' => 'a2', 'title' => '漫悠仕-真皮机票夹', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 54327)), array('class' => 'a3', 'title' => '戴蒙蒂诺 特级初榨橄榄油250ml', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 52791)), array('class' => 'a4', 'title' => '蓝百蓓自然臻纯野生蓝莓果干 袋装80g ', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational11">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55029)), array('class' => 'a1', 'title' => '元朗雪印果仁条 盒装150g', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 52880)), array('class' => 'a2', 'title' => '天立 中华老字号 天津独流特产 天立妙手捞汁 800ml ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 57073)), array('class' => 'a3', 'title' => '兰君果业 新疆特产和田骏枣五星大枣 袋装380g  ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 57071)), array('class' => 'a4', 'title' => '中华老字号 天福号自立袋米粉肉 袋装200g  ', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational12">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 57070)), array('class' => 'a1', 'title' => '天福号 中华老字号 自立袋苏式熏鱼 200g ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 44452)), array('class' => 'a2', 'title' => '【万锋】品胜Pisen 移动电源 充电曲奇(M)(苹果白) ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 58813)), array('class' => 'a3', 'title' => '川味香肠 ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 58814)), array('class' => 'a4', 'title' => '川味腊肉 ', 'target' => '_blank')) ?>
        </div>
    </div>
    <!-- 1F -->
    <div class="crazyNational13" id="part1">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/nationalFood.html'), array('class' => 'a1', 'title' => '食品分场', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational14">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 56555)), array('class' => 'a1', 'title' => 'MF788型（五对10只）香港天龙行正宗太湖大闸蟹', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 51658)), array('class' => 'a2', 'title' => '茅台酒（53度）飞天 ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 41222)), array('class' => 'a3', 'title' => '南非/戈蓝酒庄 “宝樽”系列 希拉2009 西拉100%  ', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational15">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 50588)), array('class' => 'a1', 'title' => '南洋风马来西亚进口燕窝 5A级燕窝 25克售 包邮  ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 53889)), array('class' => 'a2', 'title' => '德国菲斯特桃红起泡酒 ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 34885)), array('class' => 'a3', 'title' => '锦昌 醇香型大红袍 500克/斤 ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 54321)), array('class' => 'a4', 'title' => '戴蒙蒂诺 特级初榨橄榄油3L', 'target' => '_blank')) ?>
        </div>
    </div>
    <!-- 2F -->
    <div class="crazyNational16" id="part2">
        <div class="pCon">          
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/bagsPreferential.html'), array('class' => 'a1', 'title' => '箱包分场', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational17">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 53320)), array('class' => 'a1', 'title' => '比飞Befly高档尊贵品质头层真牛皮时尚商务休闲男士款手提单肩斜跨包包  ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 50901)), array('class' => 'a2', 'title' => '瑞士军刀（SWISSGEAR） SA-092807 大容量防水单杆背包15.6寸拉杆双肩电脑旅行背包', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational18">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 30618)), array('class' => 'a1', 'title' => '2014新款潮女头层牛皮包真皮女包 撞色单肩包 斜跨包 手提包包 逛街购物包袋多颜色选择', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 53323)), array('class' => 'a2', 'title' => '比飞Befly高档尊贵品质进口真牛皮男士商务公文手提单肩包包 ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 38630)), array('class' => 'a3', 'title' => '新款牛皮男包 商务休闲单肩包男 斜挎包男士背包 平板电脑手提包包 ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 48354)), array('class' => 'a4', 'title' => '翡兰格丽2014春新款时尚手提包小香风菱格链条包潮流单肩真皮女包 ', 'target' => '_blank')) ?>
        </div>
    </div>
    <!-- 3F -->
    <div class="crazyNational19" id="part3">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/nationalCloth.html'), array('class' => 'a1', 'title' => '服装分场', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational20">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55798)), array('class' => 'a1', 'title' => '欧洲站2014秋季新品 时尚百搭 圆领纯色长袖外套 连衣裙', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 54056)), array('class' => 'a2', 'title' => '六周年dngr皮毛一体尼克服男澳洲羊毛内胆水貂翻领保暖冬装棉衣男外套 ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 25311)), array('class' => 'a3', 'title' => '锦墨年华 幸福涂鸦围巾 ', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational21">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55513)), array('class' => 'a1', 'title' => '泛德诗正品女装时尚简约气质宽松毛呢大衣外套', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55521)), array('class' => 'a2', 'title' => '泛德诗 韩版时尚女装超显瘦气质修身针织毛衣连衣裙', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55520)), array('class' => 'a3', 'title' => '泛德诗2013秋冬新款韩版超显瘦羊毛呢外套气质中长款呢大衣 ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55375)), array('class' => 'a4', 'title' => '泛德诗2014新款韩版时尚蝴蝶结双排扣毛呢外套 ', 'target' => '_blank')) ?>
        </div>
    </div>
    <!-- 4F -->
    <div class="crazyNational22" id="part4">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/jewelNational.html'), array('class' => 'a1', 'title' => '珠宝分场', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational23">
        <div class="pCon">		

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55621)), array('class' => 'a1', 'title' => '采用施华洛世奇元素 时尚心玄之舞 水晶项链 女生礼物', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55474)), array('class' => 'a2', 'title' => '采用施华洛世奇元素水晶 毛衣链 七彩冰菱 衣服配饰 首饰', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 53273)), array('class' => 'a3', 'title' => '【欧希】采用施华洛世奇元素 新款七夕首饰手链 女生礼物 ', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational24">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 48629)), array('class' => 'a1', 'title' => '瑞士佛朗戈 追风系列 F-8099G-A/B', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 49845)), array('class' => 'a2', 'title' => '瑞士佛朗戈 宠爱系列 F-8009G-B', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 31623)), array('class' => 'a3', 'title' => 'Heaven海文珠宝 银粉晶耳坠 ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 31657)), array('class' => 'a4', 'title' => 'Heaven海文珠宝 银玛瑙耳坠', 'target' => '_blank')) ?>
        </div>
    </div>
    <!-- 5F -->
    <div class="crazyNational25" id="part5">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/nationalDigital.html'), array('class' => 'a1', 'title' => '数码分场', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational26">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55232)), array('class' => 'a1', 'title' => '菲星学习平板电脑E712 IPS屏，极速双核，九门功课同步，名师讲堂', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55209)), array('class' => 'a2', 'title' => '菲星平板电脑P715 支持联通移动卡', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational27">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55228)), array('class' => 'a1', 'title' => '菲星平板电脑P716 支持联通移动卡，双卡双待', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 40512)), array('class' => 'a2', 'title' => '卡西欧Casio TR350S 自拍神器 （1210万像素 3.0英寸超高清LCD 21mm广角） 经典自拍神器·拍出唯一最美的你!', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 28052)), array('class' => 'a3', 'title' => '手机【菲盛数码】三星 GALAXY Note 3 N9009 电信版 内存16G 黑色 双模双待 ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 56966)), array('class' => 'a4', 'title' => '明松 联想 C470 2957U/4G DDR3/500G/1G独显/Rambo/WIN8/21.5”黑/白', 'target' => '_blank')) ?>
        </div>
    </div>
    <!-- 6F -->
    <div class="crazyNational28" id="part6">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/houseAppliance.html'), array('class' => 'a1', 'title' => '家电分场', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational29">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55230)), array('class' => 'a1', 'title' => '鸿智纯平触摸方煲(白) HR-FD31 3L', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55507)), array('class' => 'a2', 'title' => '韩国CUCKOO/福库 CRP-J0651FR 智能多功能高压电饭煲 3.5L 语音功能', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 34494)), array('class' => 'a3', 'title' => '客满堂不锈钢彩钢电热水壶SL-083-15S1 1.5L/1350W 白色  ', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational30">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 43070)), array('class' => 'a1', 'title' => '红果 DJ16B-A02D超薄无网正品多功能豆浆机', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 43071)), array('class' => 'a2', 'title' => '红果 DJ16B-A05 全不锈钢双重不锈钢豆浆机', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 41816)), array('class' => 'a3', 'title' => '三瑞风 蒸汽地拖机1500W ST-1501', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 41815)), array('class' => 'a4', 'title' => ' 三瑞风 除螨吸尘机机 300W', 'target' => '_blank')) ?>
        </div>
    </div>
    <!-- 7F -->
    <div class="crazyNational31" id="part7">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/view', array('id' => 35)), array('class' => 'a1', 'title' => '化妆品分场', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational32">
        <div class="pCon">          
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 57385)), array('class' => 'a1', 'title' => '丸美金质眼精华弹力蛋白系列眼霜18ml去眼袋鱼尾纹提拉紧致正品', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 50067)), array('class' => 'a2', 'title' => '专柜名品 SU植村秀 泡沫隔离霜30g升级版 底妆液 浅肤色 美白', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 41942)), array('class' => 'a3', 'title' => '雅诗兰黛鲜活营养红石榴日霜50ml ', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational33">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 50075)), array('class' => 'a1', 'title' => '法国Avene 雅漾舒护活泉水喷雾300ml 保湿补水大喷 舒缓', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 45326)), array('class' => 'a2', 'title' => '丸美防晒霜 嫩白防晒乳SPF30PA+++ 40G送金沙海蓝冰河睡眠面膜80G', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55221)), array('class' => 'a3', 'title' => '生物活性锌精华液', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 54967)), array('class' => 'a4', 'title' => '喀撒丽活性锌补水胶原蚕丝面膜 ', 'target' => '_blank')) ?>
        </div>
    </div>
    <!-- 8F -->
    <div class="crazyNational34" id="part8">
        <div class="pCon">           
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/view', array('id' => 33)), array('class' => 'a1', 'title' => '母婴分场', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational35">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 24601)), array('class' => 'a1', 'title' => '金装多美怡正品幼儿奶粉营养补充易吸收幼儿羊奶粉 ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 53477)), array('class' => 'a2', 'title' => '薇姿Otbaby爱心特惠礼盒（蚊香器+蚊香液*2）宝宝驱蚊套装 新生儿驱蚊器促销 婴儿纯天然蚊香液无刺激味', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 53487)), array('class' => 'a3', 'title' => '薇姿otbaby倍护舒爽护臀膏 婴儿专用护臀膏 不含激素 快速舒缓尿布疹35ml', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational36">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 53879)), array('class' => 'a1', 'title' => '薇姿otbaby奶瓶奶嘴无菌洁净液 婴儿奶瓶清洗剂 宝宝奶瓶消毒液300ML', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 16948)), array('class' => 'a2', 'title' => '神奇万花筒24粒 万花筒积木 多棱镜观察缤纷世界', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 57953)), array('class' => 'a3', 'title' => '婴儿衣服送礼/天然有机彩棉套装/纯棉儿童有机棉单排扣/可开档', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 58248)), array('class' => 'a4', 'title' => '超大正品/momscare时尚妈咪包多功能妈咪袋/安全孕产包妈妈包包邮', 'target' => '_blank')) ?>
        </div>
    </div>
    <!-- 9F -->
    <div class="crazyNational37" id="part9">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/UTen.html'), array('class' => 'a1', 'title' => 'U生活分场', 'target' => '_blank')) ?>
        </div>
    </div>

    <div class="crazyNational38">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 57630)), array('class' => 'a1', 'title' => '丸美眼霜新生弹力眼霜15ml去鱼尾细纹眼袋 弹滑紧致正品包邮', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 44312)), array('class' => 'a2', 'title' => '丸美日化 巧克力丝滑睡眠面膜 150g', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational39">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 43406)), array('class' => 'a1', 'title' => '卡姿兰 蜗牛色彩调控霜CC霜 30g', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 45002)), array('class' => 'a2', 'title' => '百变 信封式抓绒睡袋 颜色随机发货', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55517)), array('class' => 'a3', 'title' => '2014泛德诗女装弹力修身超显瘦百搭小脚牛仔裤', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55519)), array('class' => 'a4', 'title' => '泛德诗正品 时尚女裤微弹超显瘦百搭小脚牛仔裤', 'target' => '_blank')) ?>
        </div>
    </div>
    <!-- 10F -->
    <div class="crazyNational40" id="part10">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/view', array('id' => 36)), array('class' => 'a1', 'title' => '家居分场', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational41">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 384)), array('class' => 'a1', 'title' => '尚而居 CED台灯', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 40818)), array('class' => 'a2', 'title' => '(MU-031) Disney迪士尼 黄色维尼三件套', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 40831)), array('class' => 'a3', 'title' => '(MU-028) Disney迪士尼 俏皮米奇四件套', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational42">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 29561)), array('class' => 'a1', 'title' => '岫玉25圆粘子加热床垫 天然岫玉锗石电热保健床垫 ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 29543)), array('class' => 'a2', 'title' => '岫玉六角粘子加热床垫 天然岫玉锗石电热远红外线保健床垫', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 29599)), array('class' => 'a3', 'title' => '岫玉、合成矿物质结合加热床垫 天然岫玉锗石电热远红外线保健床垫', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 45319)), array('class' => 'a4', 'title' => '爱尚家具 俬游记 北美水曲柳 木蜡油涂料 实木餐桌', 'target' => '_blank')) ?>
        </div>
    </div>
    <!-- 11F -->
    <div class="crazyNational43" id="part11">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/view', array('id' => 34)), array('class' => 'a1', 'title' => '汽车分场', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational44">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 51236)), array('class' => 'a1', 'title' => '途雅车载香水-奔放香榭丽舍-古龙 ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 51244)), array('class' => 'a2', 'title' => '途雅车载香水-杜乐丽华尔兹—玫瑰', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 44448)), array('class' => 'a3', 'title' => '扬新（YAS）手机车载支架-K2 手机平板通用', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational45">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 56970)), array('class' => 'a1', 'title' => '明松 任e行H1行车记录仪 超高清 迷你车载 1080p夜视王超广角停车监控  ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 15944)), array('class' => 'a2', 'title' => '电子狗K550', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 56978)), array('class' => 'a3', 'title' => '明松 易图GS-908 蓝牙预警仪流动固定测速一体云电子狗GPS追踪查车 ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 55907)), array('class' => 'a4', 'title' => '菲星行车记录仪HD-M8 2.7寸高清屏，既是相机又是记录仪 ', 'target' => '_blank')) ?>
        </div>
    </div>
    <!-- 12F -->
    <div class="crazyNational46" id="part12">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/zt/site/travelNational.html'), array('class' => 'a1', 'title' => '线下分场', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational47">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/hotel'), array('class' => 'a1', 'title' => '酒店预定', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/jms/site/index', array('city' => 278)), array('class' => 'a2', 'title' => '成都区', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/jms/site/index', array('city' => 237)), array('class' => 'a3', 'title' => '广州区', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational48">
        <div class="pCon">					

            <?php echo CHtml::link('', $this->createAbsoluteUrl('/jms/site/index', array('city' => 176)), array('class' => 'a1', 'title' => '青岛区', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/jms/site/index', array('city' => 3542)), array('class' => 'a2', 'title' => '永康区', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/jms/site/index', array('city' => 275)), array('class' => 'a3', 'title' => '重庆区', 'target' => '_blank')) ?>

        </div>
    </div>
    <div class="crazyNational49"></div>
    <div class="crazyNational50" id="crazyNational50">
        <div class="pCon">					
         
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 57637)), array('class' => 'a1', 'title' => '美国进口蜂蜜 钻石小溪 454g 百花蜂蜜 ', 'target' => '_blank')) ?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 50136)), array('class' => 'a2', 'title' => '瑞士佛朗戈 宠爱系列 F-8108G/L-B ', 'target' => '_blank')) ?>
        </div>
    </div>
    <div class="crazyNational51" id="crazyNational51">
        <div class="pCon">					
            <a href="#part0" class="a1" title="9.9元专区"></a>
            <a href="#part1" class="a2" title="1F食品"></a>
            <a href="#part2" class="a3" title="2F箱包"></a>
            <a href="#part3" class="a4" title="3F箱包"></a>
            <a href="#part4" class="a5" title="4F珠宝"></a>
            <a href="#part5" class="a6" title="5F数码"></a>
            <a href="#part6" class="a7" title="6F家电"></a>
            <a href="#part7" class="a8" title="7F化妆品"></a>
            <a href="#part8" class="a9" title="8F母婴"></a>
            <a href="#part9" class="a10" title="9FU生活"></a>
            <a href="#part10" class="a11" title="10F家居"></a>
            <a href="#part11" class="a12" title="11F汽车"></a>
            <a href="#part12" class="a13" title="12F线下"></a>
            <a href="#partTop" class="a14" title="返回顶部"></a>
        </div>
    </div>
</div>  
