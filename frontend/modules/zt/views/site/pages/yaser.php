<style type="text/css">
    /*=====
    @Date:2014-07-09
    @content:雅诗雪沁专题
	@author:林聪毅   
 =====*/
    .zt-wrap{width:100%; background:#fff;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .yaser-01{height:1048px; background:url(<?php echo ATTR_DOMAIN?>/zt/yaser/yaser-01.jpg) top center no-repeat;}
    .yaser-02{height:524px; background:url(<?php echo ATTR_DOMAIN?>/zt/yaser/yaser-02.jpg) top center no-repeat;}
    .yaser-03{height:524px; background:url(<?php echo ATTR_DOMAIN?>/zt/yaser/yaser-03.jpg) top center no-repeat;}
    .yaser-04{height:524px; background:url(<?php echo ATTR_DOMAIN?>/zt/yaser/yaser-04.jpg) top center no-repeat;}
    .yaser-05{height:524px; background:url(<?php echo ATTR_DOMAIN?>/zt/yaser/yaser-05.jpg) top center no-repeat;}
    .yaser-06{height:524px; background:url(<?php echo ATTR_DOMAIN?>/zt/yaser/yaser-06.jpg) top center no-repeat;}
    .yaser-07{height:524px; background:url(<?php echo ATTR_DOMAIN?>/zt/yaser/yaser-07.jpg) top center no-repeat;}

    .yaser-03 a{ width:508px; height:478px;}
    .yaser-03 .a1{left:-10px; top:-140px;}
    .yaser-05 a{ width:508px; height:478px;}
    .yaser-05 .a1{right:-100px; top:-140px;}
    .yaser-07 a{ width:481px; height:455px;}
    .yaser-07 .a1{left:-70px; top:-140px;}

</style>

<div class="zt-wrap">
    <div class="yaser-01"></div>
    <div class="yaser-02"></div>
    <div class="yaser-03">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/57051.html" title="雅诗雪沁YASER椰奶蜂蜜颈蜡 富含天然椰奶蜂蜜易于皮肤吸收,解决颈部细纹、暗黄、干燥、肌肤松驰、脱皮、角质、让颈部肌肤恢复婴儿般细腻柔滑.颈部蜡疗,让年龄成为秘密." class="a1" flag="1" target="_blank"></a>
        </div>
    </div>
    <div class="yaser-04"></div>
    <div class="yaser-05">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/57056.html" title="雅诗雪沁YASER年奶蜂蜜手蜡 富含天然蜂蜜易于皮肤吸收,嫩手神器、滋润防干裂、深层滋养、美白细嫩手部皮肤，防止肌肤干燥粗糙改善手部皮肤多茧疆硬现象，撕出魔法嫩手，“手”护年龄的秘密!" class="a1" flag="2" target="_blank"></a>
        </div>
    </div>
    <div class="yaser-06"></div>
    <div class="yaser-07">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/57055.html" title="雅诗雪沁YASER牛奶蜂蜜足蜡 原创蜡疗文化,开启肌肤护理里程碑.富含天然蜂蜜易于皮肤吸收,嫩足神器、滋润防干裂、深层滋养、美白细嫩足部皮肤，防止肌肤干燥粗糙改善足部皮肤多茧疆硬现象，撕出魔法嫩白小脚丫." class="a1" flag="3" target="_blank"></a>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        var oHeader = $('.header').height();
        var oFooter = $('.footer').height();

        var scrollValue = 0;


        function startMove(e){
            ev = e || window.event;
            if(ev.wheelDelta){//IE/Opera/Chrome
                var scrollDis = 524;
                var totalHeight = 3960;
                if(ev.wheelDelta<0){//向下滚动
                    moveDown(scrollDis,totalHeight);
                }
                else{//向下滚动
                    moveUp(scrollDis,totalHeight);
                }
                return false;
            }else if(ev.detail){//Firefox 
                var scrollDis = 1048;
                var totalHeight = 3436;
                if(ev.detail>0){//向下滚动
                    moveDown(scrollDis,totalHeight);

                }
                else{//向上滚动
                    moveUp(scrollDis,totalHeight);
                }
            }
        }
        /*鼠标滚轮向下移动*/
        function moveDown(dis,total){
            scrollValue += dis;
            if(scrollValue>total){
                scrollValue+=oFooter;
            }
            else if(scrollValue==dis){
                scrollValue += oHeader;
            }
            $('body,html').stop(true,false).animate({scrollTop:scrollValue},500);
        }
        /*鼠标滚轮向上移动*/
        function moveUp(dis,total){
            scrollValue -= dis;
            if(scrollValue<=0){
                scrollValue = 0;
            }
            else if(scrollValue>total){
                scrollValue = total;
            }
            $('body,html').stop(true,false).animate({scrollTop:scrollValue},500)

        }
        /*注册事件*/
        if(document.addEventListener){
            document.addEventListener('DOMMouseScroll',startMove,false);
        }
        window.onmousewheel=document.onmousewheel=startMove;	//IE/Opera/Chrome

        $('.yaser-03 .a1,.yaser-05 .a1, .yaser-07 .a1').hover(function(){
            var src = 'url(<?php echo ATTR_DOMAIN?>/zt/yaser/info-' + $(this).attr('flag') + '.png)';
            $(this).css('background-image',src);
        },function(){
            $(this).css('background-image','none');
        })
    })
</script> 