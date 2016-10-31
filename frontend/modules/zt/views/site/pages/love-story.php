<?php $this->pageTitle = "爱情故事_" . $this->pageTitle;?>
<style type="text/css">
    /*=====
    @Date:2016-01-12
    @content:爱情故事
	@author:林聪毅
 =====*/
    .zt-wrap{width:100%; background:#fff; overflow: hidden;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .love-story-01{height:771px; background:url(<?php echo ATTR_DOMAIN;?>/zt/love-story/love-story-01.jpg) top center no-repeat;}
    .love-story-02{height:849px; background:url(<?php echo ATTR_DOMAIN;?>/zt/love-story/love-story-02.jpg) top center no-repeat;}
    .love-story-03{height:385px; background:url(<?php echo ATTR_DOMAIN;?>/zt/love-story/love-story-03.jpg) top center no-repeat;}
    .love-story-04{height:769px; background:url(<?php echo ATTR_DOMAIN;?>/zt/love-story/love-story-04.jpg) top center no-repeat;}
    .love-story-05{height:499px; background:url(<?php echo ATTR_DOMAIN;?>/zt/love-story/love-story-05.jpg) top center no-repeat;}
    .love-story-06{height:786px; background:url(<?php echo ATTR_DOMAIN;?>/zt/love-story/love-story-06.jpg) top center no-repeat;}
    .love-story-07{height:488px; background:url(<?php echo ATTR_DOMAIN;?>/zt/love-story/love-story-07.jpg) top center no-repeat;}
    .love-story-08{height:802px; background:url(<?php echo ATTR_DOMAIN;?>/zt/love-story/love-story-08.jpg) top center no-repeat;}
    .love-story-09{height:514px; background:url(<?php echo ATTR_DOMAIN;?>/zt/love-story/love-story-09.jpg) top center no-repeat;}
    .love-story-10{height:802px; background:url(<?php echo ATTR_DOMAIN;?>/zt/love-story/love-story-10.jpg) top center no-repeat;}

    .love-story-11{height:654px; background:url(<?php echo ATTR_DOMAIN;?>/zt/love-story/love-story-11.jpg) top center no-repeat;}

    .love-story-01 .zt-con div{position: absolute; display: none;}
    .love-story-01 .dec-01{width: 133px; height: 132px; background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/dec-01.png) no-repeat; left: 400px; top: 200px;}
    .love-story-01 .dec-02{width: 128px; height: 138px; background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/dec-02.png) no-repeat; left: 520px; top: 256px;}
    .love-story-01 .dec-03{width: 103px; height: 119px; background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/dec-03.png) no-repeat; left: 470px; top: 390px;}
    .love-story-01 .dec-04{width: 121px; height: 144px; background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/dec-04.png) no-repeat; left: 320px; top: 470px;}
    .love-story-01 .dec-05{width: 115px; height: 122px; background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/dec-05.png) no-repeat; left: 438px; top: 544px;}
    .love-story-01 .dec-06{width: 141px; height: 140px; background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/dec-06.png) no-repeat; left: 530px; top: 610px;}
    .love-story-01 .dec-07{width: 133px; height: 141px; background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/dec-07.png) no-repeat; left: 640px; top: 558px;}
    .love-story-01 .dec-08{width: 334px; height: 54px; background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/dec-08.png) no-repeat; left: 180px; top: 334px;}
    .love-story-01 .dec-09{width: 165px; height: 14px; background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/dec-09.png) no-repeat; left: 310px; top: 400px;}
    .love-story-01 .dec-10{width: 63px; height: 42px; background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/dec-10.png) no-repeat; left: 648px; top: 300px;}
    .love-story-01 .dec-11{width: 89px; height: 93px; background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/dec-11.png) no-repeat; left: 580px; top: 460px;}
    .love-story-01 .dec-12{width: 177px; height: 100px; background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/dec-12.png) no-repeat; left: 240px; top: 700px;}
    .love-story-04 a,.love-story-06 a,.love-story-08 a,.love-story-10 a{display: none;}
    .love-story-04 .a1{
        width: 249px; height: 246px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos1Good-01.png) no-repeat;
        left: 120px; top: 380px;
    }
    .love-story-04 .a2{
        width: 220px; height: 220px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos1Info-01.png) no-repeat;
        left: 80px; top: 80px;
    }
    .love-story-04 .a3{
        width: 214px; height: 142px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos1Good-02.png) no-repeat;
        left: 510px; top: 190px;
    }
    .love-story-04 .a4{
        width: 282px; height: 237px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos1Info-02.png) no-repeat;
        left: 620px; top: 80px;
    }
    .love-story-04 .a5{
        width: 242px; height: 247px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos1Good-03.png) no-repeat;
        left: 720px; top: 340px;
    }
    .love-story-04 .a6{
        width: 297px; height: 189px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos1Info-03.png) no-repeat;
        left: 510px; top: 460px;
    }
    .love-story-06 .a1{
        width: 220px; height: 220px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos2Good-01.png) no-repeat;
        left: 240px; top: 130px;
    }
    .love-story-06 .a2{
        width: 318px; height: 238px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos2Info-01.png) no-repeat;
        left: 50px; top: 80px;
    }
    .love-story-06 .a3{
        width: 205px; height: 205px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos2Good-02.png) no-repeat;
        left: 190px; top: 460px;
    }
    .love-story-06 .a4{
        width: 265px; height: 231px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos2Info-02.png) no-repeat;
        left: 40px; top: 400px;
    }
    .love-story-06 .a5{
        width: 402px; height: 295px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos2Good-03.png) no-repeat;
        left: 510px; top: 360px;
    }
    .love-story-06 .a6{
        width: 252px; height: 253px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos2Info-03.png) no-repeat;
        left: 580px; top: 80px;
    }
    .love-story-08 .a1{
        width: 239px; height: 309px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos3Good-01.png) no-repeat;
        left: 120px; top: 100px;
    }
    .love-story-08 .a2{
        width: 295px; height: 200px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos3Info-01.png) no-repeat;
        left: 80px; top: 440px;
    }
    .love-story-08 .a3{
        width: 230px; height: 190px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos3Good-02.png) no-repeat;
        left: 520px; top: 180px;
    }
    .love-story-08 .a4{
        width: 318px; height: 205px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos3Info-02.png) no-repeat;
        left: 600px; top: 100px;
    }
    .love-story-08 .a5{
        width: 278px; height: 278px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos3Good-03.png) no-repeat;
        left: 690px; top: 410px;
    }
    .love-story-08 .a6{
        width: 295px; height: 200px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos3Info-03.png) no-repeat;
        left: 510px; top: 400px;
    }
    .love-story-10 .a1{
        width: 236px; height: 196px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos4Good-01.png) no-repeat;
        left: 220px; top: 170px;
    }
    .love-story-10 .a2{
        width: 272px; height: 228px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos4Info-01.png) no-repeat;
        left: 60px; top: 80px;
    }
    .love-story-10 .a3{
        width: 241px; height: 201px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos4Good-02.png) no-repeat;
        left: 50px; top: 500px;
    }
    .love-story-10 .a4{
        width: 216px; height: 232px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos4Info-02.png) no-repeat;
        left: 240px; top: 380px;
    }
    .love-story-10 .a5{
        width: 347px; height: 388px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos4Good-03.png) no-repeat;
        left: 570px; top: 280px;
    }
    .love-story-10 .a6{
        width: 251px; height: 224px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/love-story/pos4Info-03.png) no-repeat;
        left: 530px; top: 100px;
    }
</style>

<div class="zt-wrap">
    <div class="love-story-01">
        <div class="zt-con">
            <div class="dec dec-01"></div>
            <div class="dec dec-02"></div>
            <div class="dec dec-03"></div>
            <div class="dec dec-04"></div>
            <div class="dec dec-05"></div>
            <div class="dec dec-06"></div>
            <div class="dec dec-07"></div>
            <div class="dec dec-08"></div>
            <div class="dec dec-09"></div>
            <div class="dec dec-10"></div>
            <div class="dec dec-11"></div>
            <div class="dec dec-12"></div>
        </div>
    </div>
    <div class="love-story-02"></div>
    <div class="love-story-03"></div>
    <div class="love-story-04">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/265550.html" title="创意闹钟台灯无线蓝牙小音箱LED床头灯插卡小音响" class="a1 pos1Good" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/265550.html" title="创意闹钟台灯无线蓝牙小音箱LED床头灯插卡小音响" class="a2 pos1Info" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/297422.html" title="PARKER 派克 IM黑森林墨水笔 钢笔 礼品笔 派克笔" class="a3 pos1Good" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/297422.html" title="PARKER 派克 IM黑森林墨水笔 钢笔 礼品笔 派克笔" class="a4 pos1Info" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/250641.html" title="韩国爱茉莉 红吕 含光耀护损伤修护洗发水护发乳套装400g+400ml" class="a5 pos1Good" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/250641.html" title="韩国爱茉莉 红吕 含光耀护损伤修护洗发水护发乳套装400g+400ml" class="a6 pos1Info" target="_blank"></a>
        </div>
    </div>
    <div class="love-story-05"></div>
    <div class="love-story-06">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/303994.html" title="Chanel/香奈儿可可小姐唇膏水亮系列3g 口红 滋润保湿 盈润透亮" class="a1 pos2Good" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/303994.html" title="Chanel/香奈儿可可小姐唇膏水亮系列3g 口红 滋润保湿 盈润透亮" class="a2 pos2Info" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/136172.html" title="Dior/迪奥小姐花漾淡香氛 50ml EDT甜心女士香水  柔和花香调" class="a3 pos2Good" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/136172.html" title="Dior/迪奥小姐花漾淡香氛 50ml EDT甜心女士香水  柔和花香调" class="a4 pos2Info" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/67497.html" title="美能格幻想系列6000毫安充电宝超薄时尚移动电源通用型" class="a5 pos2Good" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/67497.html" title="美能格幻想系列6000毫安充电宝超薄时尚移动电源通用型" class="a6 pos2Info" target="_blank"></a>
        </div>
    </div>
    <div class="love-story-07"></div>
    <div class="love-story-08">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/317175.html" title="Apple/苹果 iPhone 6s Plus 5.5英寸全网通手机" class="a1 pos3Good" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/317175.html" title="Apple/苹果 iPhone 6s Plus 5.5英寸全网通手机" class="a2 pos3Info" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/29813.html" title="多媒体 电脑音箱 低音炮音响" class="a3 pos3Good" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/29813.html" title="多媒体 电脑音箱 低音炮音响" class="a4 pos3Info" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/54887.html" title="威戈军刀（WENGER NOBLR）1358拉杆箱 （港澳台均不包邮，需拍差价补运费哦）" class="a5 pos3Good" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/54887.html" title="威戈军刀（WENGER NOBLR）1358拉杆箱 （港澳台均不包邮，需拍差价补运费哦）" class="a6 pos3Info" target="_blank"></a>
        </div>
    </div>
    <div class="love-story-09"></div>
    <div class="love-story-10">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/144479.html" title="茶圣说“天子未尝阳羡茶，百草不敢先开花”江苏宜兴白茶2015新包装500克包邮 金粉贡茶" class="a1 pos4Good" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/144479.html" title="茶圣说“天子未尝阳羡茶，百草不敢先开花”江苏宜兴白茶2015新包装500克包邮 金粉贡茶" class="a2 pos4Info" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/101805.html" title="电炖锅 电炖盅 隔水炖 煮粥锅 预约定时 一锅四胆 DDG-D658 厂家降价促销 小家电家用电器" class="a3 pos4Good" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/101805.html" title="电炖锅 电炖盅 隔水炖 煮粥锅 预约定时 一锅四胆 DDG-D658 厂家降价促销 小家电家用电器" class="a4 pos4Info" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/192503.html" title="浅休新品睡衣男女情侣秋冬季加厚加绒套装时尚外穿保暖内衣家居服" class="a5 pos4Good" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/192503.html" title="浅休新品睡衣男女情侣秋冬季加厚加绒套装时尚外穿保暖内衣家居服" class="a6 pos4Info" target="_blank"></a>
        </div>
    </div>

    <div class="love-story-11"></div>
</div>
<script type="text/javascript">
    $(function(){
        var oLeftArr = [], oTopArr = [];
        var i = 0,index = 0;
        for(i=0;i<7;i++){
            var oLeftCache = 0;
            var oTopCache = 0;
            oLeftCache = parseInt($('.dec').eq(i).css('left'));
            oTopCache = parseInt($('.dec').eq(i).css('top'));
            oLeftArr.push(oLeftCache);
            oTopArr.push(oTopCache);
            $('.dec').eq(i).css('left',oLeftArr[i]+500);
            $('.dec').eq(i).css('top',oTopArr[i]-200);
        }

        headerAni();

        function headerAni(){
            if(index>=7){
                $('.dec:gt(6)').fadeIn(1000);
            }
            else{
                $('.dec').eq(index).show().animate({'left':oLeftArr[index],'top':oTopArr[index]},600,function(){
                    index++;
                    headerAni();
                })
            }
        }
        var scrollTop = 0;
        $(window).scroll(function(){
            scrollTop = $(document).scrollTop();
            if(scrollTop>=1800&&scrollTop<=3000){
                $('.pos1Good,.pos1Info').fadeIn(1500);
            }
            else{
                $('.pos1Good,.pos1Info').fadeOut(500);
            }
            if(scrollTop>=2900&&scrollTop<=4200){
                $('.pos2Good,.pos2Info').fadeIn(1500);
            }
            else{
                $('.pos2Good,.pos2Info').fadeOut(500);
            }
            if(scrollTop>=4100&&scrollTop<=5500){
                $('.pos3Good,.pos3Info').fadeIn(1500);
            }
            else{
                $('.pos3Good,.pos3Info').fadeOut(500);
            }
            if(scrollTop>=5400&&scrollTop<=6800){
                $('.pos4Good,.pos4Info').fadeIn(1500);
            }
            else{
                $('.pos4Good,.pos4Info').fadeOut(500);
            }
        })
    })
</script>