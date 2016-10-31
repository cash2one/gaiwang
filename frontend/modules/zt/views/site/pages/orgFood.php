<?php $this->pageTitle = "有机食品专题_" . $this->pageTitle;?>
<style type="text/css">
    /*=====
        @Date:2015-12-10
        @content:有机食品
        @author:林聪毅
     =====*/
    .zt-wrap{width:100%; background:#fff; overflow: hidden;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .orgFood-01{height:317px; background:url(<?php echo ATTR_DOMAIN;?>/zt/orgFood/orgFood-01.jpg) top center no-repeat;}
    .orgFood-02{height:316px; background:url(<?php echo ATTR_DOMAIN;?>/zt/orgFood/orgFood-02.jpg) top center no-repeat;}
    .orgFood-03{height:317px; background:url(<?php echo ATTR_DOMAIN;?>/zt/orgFood/orgFood-03.jpg) top center no-repeat;}

    .orgFood-01 .cloud{
        width: 803px; height: 339px;
        position: absolute; left: 90px; top: 0px;
    }

    .orgFood-02 a{width: 105px; height: 131px; top: 116px; display: none;}
    .orgFood-02 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/orgFood/icon-01.png) no-repeat; left: 410px; display: block;}
    .orgFood-02 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/orgFood/icon-02.png) no-repeat; left: 270px;}
    .orgFood-02 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/orgFood/icon-03.png) no-repeat; left: 130px;}
    .orgFood-02 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/orgFood/icon-04.png) no-repeat; left: -20px;}
    .orgFood-02 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/orgFood/icon-05.png) no-repeat; left: -160px;}
    .orgFood-02 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/orgFood/icon-06.png) no-repeat; left: -310px;}

    .orgFood-03 .zt-con div{position: absolute;}
    .orgFood-03 .cat{width: 120px; height: 167px; left: 600px; top: 130px;}
    .orgFood-03 .apple{width: 112px; height: 107px; left: 730px; top: 190px;}
    .orgFood-03 .mushroom{width: 102px; height: 96px; left: 860px; top: 200px;}
    .orgFood-03 .egg{width: 96px; height: 79px; left: 970px; top: 220px;}
    .cloud{
        animation:onMove3 4s ease-in-out infinite;
        -moz-animation:onMove3 4s ease-in-out infinite;
        -webkit-animation:onMove3 4s ease-in-out infinite;
        -ms-animation:onMove3 4s ease-in-out infinite;
        -o-animation:onMove3 4s ease-in-out infinite;
    }
    @-webkit-keyframes onMove3 {
        0% 	{-webkit-transform: translateY(0px)}
        50% {-webkit-transform: translateY(-20px)}
        100%{-webkit-transform: translateY(0px)}
    }
    @-moz-keyframes onMove3 {
        0% 	{-moz-transform: translateY(0px)}
        50% {-moz-transform: translateY(-20px)}
        100%{-moz-transform: translateY(0px)}
    }
    @-ms-keyframes onMove3 {
        0% 	{-ms-transform: translateY(0px)}
        50% {-ms-transform: translateY(-20px)}
        100%{-ms-transform: translateY(0px)}
    }
    @-o-keyframes onMove3 {
        0% 	{-o-transform: translateY(0px)}
        50% {-o-transform: translateY(-20px)}
        100%{-o-transform: translateY(0px)}
    }
</style>

<div class="zt-wrap">
    <div class="orgFood-01">
        <div class="zt-con">
            <div class="cloud"><img src="<?php echo ATTR_DOMAIN;?>/zt/orgFood/cloud.png"/></div>
        </div>
    </div>
    <div class="orgFood-02">
        <div class="zt-con">
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/orgFood-1" class="a1" record="0" target="_blank"></a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/orgFood-2" class="a2" record="0" target="_blank"></a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/orgFood-3" class="a3" record="0" target="_blank"></a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/orgFood-4" class="a4" record="0" target="_blank"></a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/orgFood-5" class="a5" record="0" target="_blank"></a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/orgFood-6" class="a6" record="0" target="_blank"></a>
        </div>
    </div>
    <div class="orgFood-03">
        <div class="zt-con">
            <div class="cat"><img src="<?php echo ATTR_DOMAIN;?>/zt/orgFood/cat.png"/></div>
            <div class="apple"><img src="<?php echo ATTR_DOMAIN;?>/zt/orgFood/apple.png"/></div>
            <div class="mushroom"><img src="<?php echo ATTR_DOMAIN;?>/zt/orgFood/mushroom.png"/></div>
            <div class="egg"><img src="<?php echo ATTR_DOMAIN;?>/zt/orgFood/egg.png"/></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        var oLeft = parseInt($('.orgFood-02 a:eq(0)').css('left'));
        var oTop = parseInt($('.orgFood-02 a:eq(0)').css('top'));

        var len = $('.orgFood-02 a').length;
        var arrIndex = [];

        aniFn(0,0);
        aniFn(1,0);
        aniFn(2,0);
        aniFn(3,0);
        aniFn(4,0);
        aniFn(5,0);
        function aniFn(flag,index){
            var index = index;
            moveFn(flag,10,index);
        }

        function moveFn(flag,speed,index){
            var index = index;
            var _this = $('.orgFood-02 a').eq(flag);
            var timer2 = setInterval(function(){
                if (index==0) {
                    var cacheLeft = parseInt(_this.css('left'));
                    if(cacheLeft<840){
                        if(cacheLeft==410){
                            _this.show();
                        }
                        cacheLeft++;
                        _this.css({'left':cacheLeft});
                    }
                    else if(cacheLeft>=840){
                        index++;
                        _this.css({'left':840});
                        _this.attr('record',index);
                    }
                }
                else if(index==1){
                    var cacheTop = parseInt(_this.css('top'));
                    if(cacheTop<286){
                        cacheTop++;
                        _this.css({'top':cacheTop});
                    }
                    else if(cacheTop>=286){
                        index++;
                        _this.css({'top':286});
                        _this.attr('record',index);
                    }
                }
                else{
                    var cacheLeft = parseInt(_this.css('left'));
                    if(cacheLeft>60){
                        cacheLeft--;
                        _this.css({'left':cacheLeft});
                    }
                    else if(cacheLeft<=60){
                        index=0;
                        _this.hide().css({'left':oLeft,'top':oTop});
                        _this.attr('record',index);
                        clearInterval(timer2);
                        moveFn(flag,speed,index);
                    }
                }
            },speed);
            $('.orgFood-02 a').mouseover(function(){
                arrIndex = [];
                for(i=0;i<len;i++){
                    arrIndex.push($('.orgFood-02 a').eq(i).attr('record'));
                }
                clearInterval(timer2);
            });
        }
        $('.orgFood-02 a').mouseleave(function(){
            aniFn(0,arrIndex[0]);
            aniFn(1,arrIndex[1]);
            aniFn(2,arrIndex[2]);
            aniFn(3,arrIndex[3]);
            aniFn(4,arrIndex[4]);
            aniFn(5,arrIndex[5]);
        });

    })
</script>