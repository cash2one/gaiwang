<?php $this->pageTitle = "1月新商户_" . $this->pageTitle;?>
<script src="<?php echo DOMAIN; ?>/js/html5shiv.min.js" type="text/javascript"></script>
<script src="<?php echo DOMAIN; ?>/js/jquery.easing.1.3.js" type="text/javascript"></script>
<script src="<?php echo DOMAIN; ?>/js/jquery.scrollify.js" type="text/javascript"></script>
<script src="<?php echo DOMAIN; ?>/js/awardRotate.js" type="text/javascript"></script>
<style type="text/css">
    /*=====
    @Date:2016-01-12
    @content:1月新商户
	@author:林聪毅
 =====*/
    .zt-wrap{width:100%; background:#fff; overflow: hidden;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con>a{ position:absolute;display:block;}
    .merchant-01{height:206px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-01.jpg) top center no-repeat;}
    .merchant-02{height:206px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-02.jpg) top center no-repeat;}
    .merchant-03{height:206px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-03.jpg) top center no-repeat;}
    .merchant-04{height:206px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-04.jpg) top center no-repeat;}
    .merchant-05{height:426px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-05.jpg) top center no-repeat;}
    .merchant-06{height:426px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-06.jpg) top center no-repeat;}
    .merchant-07{height:426px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-07.jpg) top center no-repeat;}
    .merchant-08{height:514px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-08.jpg) top center no-repeat;}
    .merchant-09{height:294px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-09.jpg) top center no-repeat;}
    .merchant-10{height:293px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-10.jpg) top center no-repeat;}

    .merchant-11{height:339px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-11.jpg) top center no-repeat;}
    .merchant-12{height:340px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-12.jpg) top center no-repeat;}
    .merchant-13{height:339px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-13.jpg) top center no-repeat;}
    .merchant-14{height:294px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-14.jpg) top center no-repeat;}
    .merchant-15{height:293px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-15.jpg) top center no-repeat;}
    .merchant-16{height:293px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-16.jpg) top center no-repeat;}
    .merchant-17{height:293px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-17.jpg) top center no-repeat;}
    .merchant-18{height:293px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-18.jpg) top center no-repeat;}
    .merchant-19{height:290px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-19.jpg) top center no-repeat;}
    .merchant-20{height:259px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-20.jpg) top center no-repeat;}

    .merchant-21{height:258px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-21.jpg) top center no-repeat;}
    .merchant-22{height:288px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/merchant-22.jpg) top center no-repeat;}

    .merchant-06 .rotate{width: 560px; height: 567px; position: absolute; left: 20%; top: -90px;}
    .merchant-06 .pointer{width: 141px; height: 180px; position: absolute; left: 38%; top: 30%; cursor: pointer;}
    .merchant-08 .slideShow{
        width: 1200px; height: 307px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/ulbg.png) repeat-x;
        position: relative; left: -120px; top: 160px; overflow: hidden;
    }
    .merchant-08 ul{width: 1210px; position: absolute;}
    .merchant-08 ul.ulFirst{left: 0px}
    .merchant-08 ul.ulSec{left: 1200px}
    .merchant-08 ul li{display: inline-block; margin: 14px 6px;}
    .merchant-08 ul li a{width: 184px; height: 281px; display: block;}
    .merchant-08 .arrow{
        width: 12px; height: 35px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/arrow.png) no-repeat;
        display: block; position: absolute; top: 44%;
    }
    .merchant-08 .arrow-L{background-position: top left; left: 0;}
    .merchant-08 .arrow-R{background-position: bottom left; right: 0;}
    .merchant-09 a{width: 290px; height: 414px; top: 100px;}
    .merchant-09 .a1{left: -116px;}
    .merchant-09 .a2{left: 186px;}
    .merchant-09 .a3{left: 490px;}
    .merchant-09 .a4{left: 792px;}

    .merchant-11 a{width: 480px; height: 414px; top: 100px;}
    .merchant-11 .a1{left: -4px;}
    .merchant-11 .a2{left: 494px;}
    .merchant-12 a{height: 414px; top: 190px;}
    .merchant-12 .a1{width: 290px; left: -116px;}
    .merchant-12 .a2{width: 438px; left: 190px;}
    .merchant-12 .a3{width: 436px; left: 644px;}
    .merchant-14 a{width: 290px; height: 414px; top: 100px;}
    .merchant-14 .a1{left: -116px;}
    .merchant-14 .a2{left: 186px;}
    .merchant-14 .a3{left: 490px;}
    .merchant-14 .a4{left: 792px;}
    .merchant-16 a{height: 414px; top: 100px;}
    .merchant-16 .a1{width: 290px; left: -118px;}
    .merchant-16 .a2{width: 438px; left: 188px;}
    .merchant-16 .a3{width: 436px; left: 645px;}
    .merchant-18 a{width: 290px; height: 414px; top: 100px;}
    .merchant-18 .a1{left: -116px;}
    .merchant-18 .a2{left: 186px;}
    .merchant-18 .a3{left: 490px;}
    .merchant-18 .a4{left: 792px;}
    .merchant-20 a{width: 290px; height: 414px; top: 105px;}
    .merchant-20 .a1{left: -116px;}
    .merchant-20 .a2{left: 186px;}
    .merchant-20 .a3{left: 490px;}
    .merchant-20 .a4{left: 792px;}

    .merchant-22 a{width: 210px; height: 80px; top: 76px;}
    .merchant-22 .a1{left: 230px;}
    .merchant-22 .a2{left: 526px;}

    .navnavRight{
        width: 197px; height: 535px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/navRight.png) no-repeat;
        position: fixed; left: 82%; top: 20%; opacity: 0.5;
    }
    .navnavRight:hover{opacity: 1;}
    .navnavRight a{width: 87px; height: 20px; background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/navItem.png) no-repeat; left: 58px;}
    .navnavRight .a1{background-position: 0 0; top: 150px;}
    .navnavRight .a1:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/hover-navItem.png) no-repeat;}
    .navnavRight .a2{background-position: 0 -30px; top: 180px;}
    .navnavRight .a2:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/hover-navItem.png) no-repeat 0 -30px;}
    .navnavRight .a3{background-position: 0 -60px; top: 210px;}
    .navnavRight .a3:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/hover-navItem.png) no-repeat 0 -60px;}
    .navnavRight .a4{background-position: 0 -90px; top: 240px;}
    .navnavRight .a4:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/hover-navItem.png) no-repeat 0 -90px;}
    .navnavRight .a5{background-position: 0 -120px; top: 270px;}
    .navnavRight .a5:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/hover-navItem.png) no-repeat 0 -120px;}
    .navnavRight .a6{background-position: 0 -150px; top: 300px;}
    .navnavRight .a6:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/hover-navItem.png) no-repeat 0 -150px;}
    .navnavRight .a7{background-position: 0 -180px; top: 330px;}
    .navnavRight .a7:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/hover-navItem.png) no-repeat 0 -180px;}
    .navnavRight .a8{background-position: 0 -210px; top: 360px;}
    .navnavRight .a8:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant2/hover-navItem.png) no-repeat 0 -210px;}
</style>

<div class="zt-wrap">
    <div class="merchant-01"></div>
    <div class="merchant-02"></div>
    <div class="merchant-03"></div>
    <div class="merchant-04"></div>
    <div class="merchant-05" id="part1"></div>
    <div class="merchant-06">
        <div class="zt-con">
            <div class="rotate">
                <img src="<?php echo ATTR_DOMAIN;?>/zt/merchant2/rotate.png" id="rotate">
                <div class="pointer"><img src="<?php echo ATTR_DOMAIN;?>/zt/merchant2/pointer.png"></div>
            </div>
        </div>
    </div>
    <div class="merchant-07"></div>
    <div class="merchant-08" id="part2">
        <div class="zt-con">
            <div class="slideShow">
                <ul class="ulFirst">
                    <li>
                        <a href="http://www.g-emall.com/JF/408592.html" title="永亮纯棉童巾舒适柔软加厚吸水可爱卡通小毛巾 可定制LOGO" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/merchant2/slideGood-01.png"></a>
                    </li>
                    <li>
                        <a href="http://www.g-emall.com/JF/408598.html" title="永亮毛巾 纯棉洗脸成人酒店加大加厚柔软吸水全棉正品" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/merchant2/slideGood-02.png"></a>
                    </li>
                    <li>
                        <a href="http://www.g-emall.com/JF/405733.html" title="辣木枼片500mg*60粒" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/merchant2/slideGood-03.png"></a>
                    </li>
                    <li>
                        <a href="http://www.g-emall.com/JF/342945.html" title="维钙软胶囊（液体钙.维生素D3）100粒.需要补钙的人群" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/merchant2/slideGood-04.png"></a>
                    </li>
                    <li>
                        <a href="http://www.g-emall.com/JF/396835.html" title="爆款Rhōne柔妮护理洗衣液洗衣凝露 500ML 靓彩护色包邮【薰衣草香】" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/merchant2/slideGood-05.png"></a>
                    </li>
                    <li>
                        <a href="http://www.g-emall.com/JF/384957.html" title="Rhone柔妮 专业洗护三合一旅行套装 60g/60g/70g 沐浴露 洗发水 洗衣液" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/merchant2/slideGood-06.png"></a>
                    </li>
                </ul>
                <ul class="ulSec">
                    <li>
                        <a href="http://www.g-emall.com/JF/394957.html" title="天秀 收腹性感蕾丝内裤产后塑身无痕提臀高腰棉质女士三角裤妈妈裤 TXB1832" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/merchant2/slideGood-07.png"></a>
                    </li>
                    <li>
                        <a href="http://www.g-emall.com/JF/392395.html" title="天秀女士内裤无痕一片式锦纶中腰冰丝三角透气性感绝色防走光 TXB1535" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/merchant2/slideGood-08.png"></a>
                    </li>
                    <li>
                        <a href="http://www.g-emall.com/goods/289340.html" title="奈欧 香蕉牛奶护手霜 85g" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/merchant2/slideGood-09.png"></a>
                    </li>
                    <li>
                        <a href="http://www.g-emall.com/JF/407476.html" title="旺旺贝比玛玛 婴幼儿童专用辅食米饼 50g  五种口味任选" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/merchant2/slideGood-10.png"></a>
                    </li>
                    <li>
                        <a href="http://www.g-emall.com/JF/368468.html" title="蔓越莓 西饼 饼干 曲奇 休闲零食 黄油 糕点 点心250g嘻睐多" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/merchant2/slideGood-11.png"></a>
                    </li>
                    <li>
                        <a href="http://www.g-emall.com/JF/406350.html" title="淳度滋养修复补水孕妇面膜 孕妇保养品 茶籽精华补水去黄面膜一片装" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/merchant2/slideGood-12.png"></a>
                    </li>
                </ul>
                <a href="javascript:void(0)" class="arrow arrow-L"></a>
                <a href="javascript:void(0)" class="arrow arrow-R"></a>
            </div>
        </div>
    </div>
    <div class="merchant-09" id="part3">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/395825.html" title="【创代推荐】正宗阿尔卑斯牛奶硬糖500g/袋 婚庆糖果结婚喜庆糖果" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/392233.html" title="【三只松鼠_纸皮核桃210gx2袋】坚果炒货特产薄皮核桃原味" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/390922.html" title="溪儿小铺 德芙爱意浓醇礼盒66%醇黑巧克力43g*10礼盒装" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/386641.html" title="徐福记凤梨酥特产小吃办公休闲糕点心零食美食品920g大礼包 5包装 包邮 偏远地区除外 水果夹心 买2送1 送沙琪玛" class="a4" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-10"></div>

    <div class="merchant-11" id="part4">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/389184.html" title="蓝月亮洗衣液 洗衣套餐超值6瓶2袋 量贩11斤装 包邮" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/396779.html" title="【洁柔】卫生纸巾卷纸10卷+抽纸3包+手帕纸18包" class="a2" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-12">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/391196.html" title="飞科剃须刀全身水洗飞科电动剃须刀男士刮胡刀充电式胡须刀" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/387096.html" title="双立人 TWIN  Living 20cm深烧锅" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/395790.html" title="MKS蒸脸补水美容仪器家用蒸面器补水喷雾美容冷喷仪蒸脸器冷热喷" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-13"></div>
    <div class="merchant-14" id="part5">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/395930.html" title="高士宝新款韩版潮男士羽绒服加厚立领修身男装男式羽绒棉服外套T14708" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/391708.html" title="2015秋冬季新款短靴女侧拉链马丁靴尖头粗跟高跟真皮靴子" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/390587.html" title="康龙秋冬款女鞋 真皮中跟踝靴粗跟英伦复古女靴子短靴女" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/405626.html" title="木星服饰 新款秋冬男式羊绒大衣高档商务中老年男士羊毛呢大衣毛领外套" class="a4" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-15"></div>
    <div class="merchant-16" id="part6">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/393870.html" title="Olay玉兰油 新生塑颜金纯弹力眼霜15ml 去淡化黑眼圈眼袋细纹紧致" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/387423.html" title="【蜜乐儿】幸福水魔方礼盒" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/385097.html" title="黛莱美水漾莹润保湿" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-17"></div>
    <div class="merchant-18" id="part7">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/384345.html" title="奥特王新款儿童车自行车16寸2-6岁童车小孩女宝宝单车" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/404227.html" title="MamyPoko/妈咪宝贝瞬吸干爽纸尿裤/尿不湿S男宝100片" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/393591.html" title="英国Aptamil爱他美婴幼儿配方奶粉1段（0-6个月宝宝 900g）" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/385318.html" title="好孩子婴儿推车轻便可躺可坐全蓬双向推行避震宝宝手推车C309" class="a4" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-19"></div>
    <div class="merchant-20" id="part8">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/371344.html" title="Asus/华硕 X552 X552MJ2840超薄独显办公学生手提笔记本电脑" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/385235.html" title="惠普（HP）超薄系列 HP14g-ad005TX 14英寸超薄笔记本电脑（i5-5200U 4G 500G 2G独显 win8.1）银色" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/368500.html" title="Kingston/金士顿DDR3 4G 1600笔记本内存条 标准电压1.5V兼容1333" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/387195.html" title="联想黑光面无线鼠标 笔记本台式电脑通用鼠标 省电王正品" class="a4" target="_blank"></a>
        </div>
    </div>

    <div class="merchant-21"></div>
    <div class="merchant-22">
        <div class="zt-con">
            <a href="javascript:void(0)" class="a1 backToTop"></a>
            <a href="http://active.g-emall.com/festive/detail/100" title="【TOUSSADI托莎蒂】TOUSSADI托莎蒂 女款黑色/灰片高档复古太阳镜" class="a2" target="_blank"></a>
        </div>
    </div>
    <div class="navnavRight">
        <div class="zt-con">
            <a href="#part1" class="a1"></a>
            <a href="#part2" class="a2"></a>
            <a href="#part3" class="a3"></a>
            <a href="#part4" class="a4"></a>
            <a href="#part5" class="a5"></a>
            <a href="#part6" class="a6"></a>
            <a href="#part7" class="a7"></a>
            <a href="#part8" class="a8"></a>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        /*抽奖转盘*/
        var rotateTimeOut = function (){
            $('#rotate').rotate({
                angle:0,
                animateTo:2160,
                duration:8000,
                callback:function (){
                    alert('网络超时，请检查您的网络设置！');
                }
            });
        };
        var bRotate = false;

        var rotateFn = function (awards, angles, txt){
            bRotate = !bRotate;
            $('#rotate').stopRotate();
            $('#rotate').rotate({
                angle:0,
                animateTo:angles+1800,
                duration:2000,
                callback:function (){
                    alert(txt);
                    bRotate = !bRotate;
                }
            })
        };

        $('.pointer').click(function (){
            //抽奖
            if(bRotate)return;

            var now = "<?php echo time()?>";
            if(now > 1453478400){
                alert("活动已过期！");
                return;
            }

            isGuest = "<?php echo $this->getUser()->isGuest?>";
            if(isGuest){
                alert("请登录后再抽奖！");
                return;
            }

            $.ajax({
                type:"get",async:false,timeout:5000,dataType:"json",
                url:"<?php echo $this->createAbsoluteUrl("vote/shopping")?>",
                data:{type:"sh"},
                error:function(data){
                    console.log(data);
                },
                success:function(data){
                    if(data.status == 0){
                        alert(data.msg)
                    }
                    if(data.status == 1){
                        rotateFn(data.id, data.angle, data.msg);
                    }
                }
            });
        });

        //轮播产品区
        var timer = null;
        var slideShow = $('.slideShow');
        var ulFirst = $('.slideShow ul:first');
        var ulSec = $('.slideShow ul:last');
        var totalWid = 1200;
        slide();

        function slide(){
            timer = setInterval(function(){
                var ulFirstLeft = parseInt(ulFirst.css('left'));
                var ulSecLeft = parseInt(ulSec.css('left'));
                if(ulFirstLeft<=-1200){
                    ulFirstLeft = 1200;
                }
                else if(ulSecLeft<=-1200){
                    ulSecLeft = 1200;
                }
                ulFirstLeft -= 1;
                ulSecLeft -= 1;
                slideShow.find('ul:first').css({'left':ulFirstLeft});
                slideShow.find('ul:last').css({'left':ulSecLeft});
            },15);
        }

        $('.slideShow').hover(function(){
            clearInterval(timer);
        },function(){
            slide();
        })
        $('.slideShow .arrow-L').click(function(){
            clearInterval(timer);

            var ulFirstLeft = parseInt(ulFirst.css('left'));
            var ulSecLeft = parseInt(ulSec.css('left'));
            if(ulFirstLeft<=-1200){
                ulFirstLeft = 1200;
            }
            else if(ulSecLeft<=-1200){
                ulSecLeft = 1200;
            }

            if(ulFirstLeft<ulSecLeft){
                var oLeft = Math.abs(parseInt(ulFirst.css('left')));
                var moveLeft = (parseInt(oLeft/200)+1)*200;

                ulFirst.animate({'left':-moveLeft},100);
                ulSec.animate({'left':totalWid-moveLeft},100);
            }
            else{
                var oLeft = Math.abs(parseInt(ulSec.css('left')));
                var moveLeft = (parseInt(oLeft/200)+1)*200;

                ulSec.animate({'left':-moveLeft},100);
                ulFirst.animate({'left':totalWid-moveLeft},100);
            }

        })
        $('.slideShow .arrow-R').click(function(){
            clearInterval(timer);

            var ulFirstLeft = parseInt(ulFirst.css('left'));
            var ulSecLeft = parseInt(ulSec.css('left'));
            if(ulFirstLeft>=1000){
                ulFirstLeft = -1200;
            }
            else if(ulSecLeft>=1000){
                ulSecLeft = -1200;
            }
            if(ulFirstLeft>ulSecLeft){
                var oLeft = parseInt(ulFirst.css('left'));
                var moveLeft = (parseInt(oLeft/200)+1)*200;

                ulFirst.animate({'left':moveLeft},100);
                ulSec.animate({'left':moveLeft-totalWid},100);
            }
            else{
                var oLeft = parseInt(ulSec.css('left'));
                var moveLeft = (parseInt(oLeft/200)+1)*200;

                ulSec.animate({'left':moveLeft},100);
                ulFirst.animate({'left':moveLeft-totalWid},100);
            }
        })
    });

    /*回到顶部*/
    $(".backToTop").click(function() {
        $('body,html').stop().animate({scrollTop: 0}, 500);
        return false;
    })
</script>
