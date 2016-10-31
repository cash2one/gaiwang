

<!DOCTYPE html>
<html lang="zh-cn" class="no-js">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Type">
    <meta content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <title>“礼”准备好了吗</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="email=no">
    <style type="text/css">
    /* reset */
    * {margin:0; padding:0; outline:none; }
    *:not(input,textarea) {-webkit-touch-callout:inherit; -webkit-user-select:auto; }
    a {color:#878787; text-decoration:none; -webkit-tap-highlight-color:rgba(0, 0, 0, 0); }
    a:hover {text-decoration:none; }
    button,input,select,textarea {font-size:100%; margin:0; padding:0; outline:none; }
    dt,dd {display:inline-block; }
    textarea,input {resize:none; outline:none; }
    textarea {resize:none; -webkit-appearance:none; }
    ul,ol,li {list-style:none; }
    em {font-style:normal; }
    body{ background:#fff; font-family:'Microsoft Yahei',arial,sans-serif; color:#333; -webkit-text-size-adjust:none; text-size-adjust:none; -webkit-touch-callout:inherit; -webkit-user-select:auto; max-width:640px; min-width:320px; margin:0 auto; overflow:hidden; }

    /* loading部分 */
    #loading{
        display:block;
        position:absolute;
        left:0;
        top:0;
        width:100%;
        height:100%;
        color:white;
        background:#FBE8BD; /*loading背景色5fc4d6*/
        font-size:1em;
        text-align:center;
        overflow:hidden;
        z-index:9999;
    }
    .spinner {
        margin:0 auto;
        width:60px;
        height:60px;
        position:relative;
        top:40%;
    }
    .container1 > div, .container2 > div, .container3 > div {
        width:15px;
        height:15px;
        background-color:#fd2d00; /* fd2d00圈的颜色 */
        border-radius:100%;
        position:absolute;
        -webkit-animation:bouncedelay 1.2s infinite ease-in-out;
        animation:bouncedelay 1.2s infinite ease-in-out;
        -webkit-animation-fill-mode:both;
        animation-fill-mode:both;
    }
    .spinner .spinner-container {
        position:absolute;
        width:100%;
        height:100%;
    }
    .container2 {
        -webkit-transform:rotateZ(45deg);
        transform:rotateZ(45deg);
    }
    .container3 {
        -webkit-transform:rotateZ(90deg);
        transform:rotateZ(90deg);
    }
    .circle1 { top:0; left:0; }
    .circle2 { top:0; right:0; }
    .circle3 { right:0; bottom:0; }
    .circle4 { left:0; bottom:0; }
    .container2 .circle1 {
        -webkit-animation-delay:-1.1s;
        animation-delay:-1.1s;
    }
    .container3 .circle1 {
        -webkit-animation-delay:-1.0s;
        animation-delay:-1.0s;
    }
    .container1 .circle2 {
        -webkit-animation-delay:-0.9s;
        animation-delay:-0.9s;
    }
    .container2 .circle2 {
        -webkit-animation-delay:-0.8s;
        animation-delay:-0.8s;
    }
    .container3 .circle2 {
        -webkit-animation-delay:-0.7s;
        animation-delay:-0.7s;
    }
    .container1 .circle3 {
        -webkit-animation-delay:-0.6s;
        animation-delay:-0.6s;
    }
    .container2 .circle3 {
        -webkit-animation-delay:-0.5s;
        animation-delay:-0.5s;
    }
    .container3 .circle3 {
        -webkit-animation-delay:-0.4s;
        animation-delay:-0.4s;
    }
    .container1 .circle4 {
        -webkit-animation-delay:-0.3s;
        animation-delay:-0.3s;
    }
    .container2 .circle4 {
        -webkit-animation-delay:-0.2s;
        animation-delay:-0.2s;
    }
    .container3 .circle4 {
        -webkit-animation-delay:-0.1s;
        animation-delay:-0.1s;
    }
    @-webkit-keyframes bouncedelay {
        0%, 80%, 100% { -webkit-transform:scale(0.0); }
        40% { -webkit-transform:scale(1.0); }
    }
    @keyframes bouncedelay {
        0%, 80%, 100% {
            transform:scale(0.0);
            -webkit-transform:scale(0.0);
        } 40% {
              transform:scale(1.0);
              -webkit-transform:scale(1.0);
          }
    }

    /* 切换页动画效果 */
    .pt-page-moveToTop {
        -webkit-transform-origin:50% 100%;
        -ms-transform-origin:50% 100%;
        transform-origin:50% 100%;
        -webkit-animation:moveToTop .8s both ease;
        animation:moveToTop .8s both ease;
    }
    .pt-page-moveFromTop {
        -webkit-transform-origin:50% 100%;
        -ms-transform-origin:50% 100%;
        transform-origin:50% 100%;
        -webkit-animation:moveFromTop .8s both ease;
        animation:moveFromTop .8s both ease;
    }
    .pt-page-moveToBottom {
        -webkit-transform-origin:50% 0;
        -ms-transform-origin:50% 0;
        transform-origin:50% 0;
        -webkit-animation:moveToBottom .8s both ease;
        animation:moveToBottom .8s both ease;
    }
    .pt-page-moveFromBottom {
        -webkit-transform-origin:50% 0;
        -ms-transform-origin:50% 0;
        transform-origin:50% 0;
        -webkit-animation:moveFromBottom .8s both ease;
        animation:moveFromBottom .8s both ease;
    }

    @-webkit-keyframes moveToTop {
        from { }
        to { -webkit-transform:translateY(-100%); }
    }
    @keyframes moveToTop {
        from { }
        to { -webkit-transform:translateY(-100%); transform:translateY(-100%); }
    }

    @-webkit-keyframes moveFromTop {
        from { -webkit-transform:translateY(-100%); }
    }
    @keyframes moveFromTop {
        from { -webkit-transform:translateY(-100%); transform:translateY(-100%); }
    }

    @-webkit-keyframes moveToBottom {
        from { }
        to { -webkit-transform:translateY(100%); }
    }
    @keyframes moveToBottom {
        from { }
        to { -webkit-transform:translateY(100%); transform:translateY(100%); }
    }

    @-webkit-keyframes moveFromBottom {
        from { -webkit-transform:translateY(100%); }
    }
    @keyframes moveFromBottom {
        from { -webkit-transform:translateY(100%); transform:translateY(100%); }
    }

    /* 布局和动画 */
    #tips{background: #fff;text-align: center;z-index: 99;position: absolute;height: 100%;width: 100%;display: none;}
    .page{position:absolute; width:100%; height:100%; max-width:640px; min-width:320px; margin:0 auto; overflow:hidden; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/bg.jpg) repeat center center; }
    .page::before{content:""; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/topbar.png) no-repeat center 0; position:absolute; top:-1px; width:100%; height:56px; background-size:100% auto; }
    .page{font-size:0; }
    .hide{ visibility:hidden; }

    .page-1 div{position:absolute; left:50%; width:67.2%; margin-left:-33.6%; }
    .page-1 .li2016{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p1_li.png) no-repeat center center; background-size:100% auto; padding:33.6% 0; top:23%; -webkit-transform: translateY(-200%);transform: translateY(-200%);opacity: 0;}
    .page-1 .ready{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p1_ready.png) no-repeat center center; background-size:100% auto; padding:14.2% 0; top:70.3%; -webkit-transform: translateY(200%);transform: translateY(200%);opacity: 0;}

    .page-2 div{position:absolute; left:50%; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p2_banner.png) no-repeat center center; background-size:100% auto;}
    .page-2 .banner{ width:80.9%; padding:12.45% 0; margin-left:-40.45%; top:7.5%; z-index:3; }
    .page-2 .gift{background-image:none; width:100%; padding:23.6% 0; bottom:0; left:0; z-index:1; -webkit-perspective: 1000px;perspective: 1000px;}
    .page-2 .gift .footer{background-image:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p2_gift.png);width:100%;height: 100%;bottom:0; left:0; -webkit-transform: rotateX(100deg);transform: rotateX(100deg);-webkit-transform-style: preserve-3d;-webkit-transform-origin: bottom;transform-style: preserve-3d;transform-origin: bottom;}
    .page-2 .tree{background-image:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p2_tree.png); width:91.875%; padding:42.5% 0; bottom:85%; margin-left:-44.4%; z-index:2; opacity: 0;}
    .page-2 .tree span{position:absolute; }
    .page-2 .tree .a1{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p2_jump.png) no-repeat 0 0; background-size:276% auto; width:8.5%; height:9.2%; left:30.4%; top:7%; }
    .page-2 .tree .a2{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p2_jump.png) no-repeat 0 7.2%; background-size:100% auto; width:23.5%; height:26.5%; left:34.0%; top:14%; }
    .page-2 .tree .a3{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p2_jump.png) no-repeat 0 27.8%; background-size:138% auto; width:17.0%; height:24.1%; left:15.0%; top:18%; }
    .page-2 .tree .a4{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p2_jump.png) no-repeat 0 43.5%; background-size:175% auto; width:13.4%; height:13.3%; right:27.2%; top:18%; }
    .page-2 .tree .a5{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p2_jump.png) no-repeat 0 54.2%; background-size:175% auto; width:13.4%; height:13.7%; right:11.1%; top:24%; }
    .page-2 .tree .a6{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p2_jump.png) no-repeat 0 68.6%; background-size:119% auto; width:19.7%; height:24.3%; right:24.0%; top:30%; }
    .page-2 .tree .a7{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p2_jump.png) no-repeat 0 84.2%; background-size:134% auto; width:17.5%; height:20%; left:32.5%; top:42%; }
    .page-2 .tree .a8{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p2_jump.png) no-repeat 0 92.1%; background-size:193% auto; width:11.9%; height:8.3%; right:34.7%; top:53%; }
    .page-2 .tree .a9{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p2_jump.png) no-repeat 0 100%; background-size:282% auto; width:8.3%; height:8.7%; left:50.0%; top:64%; }

    .page-3 div{position:absolute; left:50%; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p3_banner.png) no-repeat center center; background-size:100% auto;}
    .page-3 .banner{ width:67.2%; padding:9% 0; top:20%; margin-left:-33.6%; }
    .page-3 .text{background-image:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p3_text.png); width:67.2%; padding:35% 0; top:30.3%; margin-left:-33.6%; opacity: 0;}
    .page-3 .btn{background-image:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p3_icon.png); width:46.56%; padding:14.2% 0; top:70.3%; margin-left:-23.3%; opacity: 0;}

    .page-4 div{position:absolute; left:50%; width:54.5%; margin-left:-27.25%; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p4_banner.png) no-repeat center center; background-size:100% auto;}
    .page-4 .banner{ width:76%; margin-left:-38%; padding:20% 0; top:11%; }
    .page-4 .monkey{background-image:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p4_monkey.png); background-size:68% auto; padding:32.2% 0; top:28.3%; opacity:0;}
    .page-4 .text_1{background-image:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p4_text_1.png); padding:18.2% 0; top:62.3%; opacity:0;}
    .page-4 .text_2{background-image:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p4_text_2.png); padding:10.2% 0; top:84.3%; opacity:0;}
    .page-4 .water{position:absolute; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p4_water.png) no-repeat center center; background-size:100% auto; width:42%; padding:14.2% 0; top:-15%; right:-11%; -webkit-clip-path: ellipse(0 0 at 50% 50%);clip-path: ellipse(0 0 at 50% 50%); opacity: 0;}

    .page-5 div,.page-6 div,.page-7 div{position:absolute; left:50%; }
    .page-5 .banner,.page-6 .banner,.page-7 .banner{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p5_banner.png) no-repeat center center; background-size:100% auto;width:80.2%; padding:10% 0; top:16%; margin-left:-40.1%; }
    .page-5 .con,.page-6 .con,.page-7 .con{width:62.5%; height:35%; top:30.3%; margin-left:-31.25%; }
    .apple .fruit{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p5_apple.png) no-repeat center center; background-size:auto 100%;width:100%; height: 100%; left: 0;top: 0;}
    .apple .water1{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/fruit1.png) no-repeat 100% 0; background-size:auto 13%;width:100%; height: 100%; left: -18%;top:15%;overflow: hidden; z-index: 2;border-radius:30%;}
    .apple .water2{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/fruit2.png) no-repeat 0 100%; background-size:auto 14%;width:100%; height: 100%; left: 19%;top:-12%;overflow: hidden; z-index: 2;border-radius:30%;}

    .page-5 .text,.page-6 .text,.page-7 .text{width: 82.8%;top:70.3%; margin-left:-41.4%;}
    .apple .text_l1{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p5_text_left1.png) no-repeat center center; background-size:100% auto;width:70.6%; margin-left:-42.2%;padding:10% 0;z-index: 2;}
    .apple .text_l2{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p5_text_left2.png) no-repeat center center; background-size:100% auto;width:55%; margin-left:-18.2%;margin-top:25%;padding:5% 0;}
    .apple .text_r1{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p5_text_r1.png) no-repeat center center; background-size:100% auto;width:99%; margin-left:-48.5%;margin-top:9%;padding:10% 0;}

    .page-6 .banner{background-image: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p6_banner.png);}
    .loquat .fruit{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p6_loquat.png) no-repeat center center; background-size:auto 100%;width:100%; height: 100%; left: 0;top: 0; }
    .loquat .water1{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/fruit1.png) no-repeat 100% 0; background-size:auto 13%;width:100%; height: 100%; left: -5%;top:50%;overflow: hidden; z-index: 2;border-radius:30%;}
    .loquat .water2{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/fruit2.png) no-repeat 0 100%; background-size:auto 14%;width:100%; height: 100%; left: 6%;top:-47%;overflow: hidden; z-index: 2;border-radius:30%;}

    .loquat .text_l1{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p6_text_l1.png) no-repeat center center; background-size:100% auto;width:99%; margin-left:-51%;padding:11% 0;z-index: 2;}
    .loquat .text_l2{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p6_text_l2.png) no-repeat center center; background-size:100% auto;width:55%; margin-left:-15.2%;margin-top:23%;padding:5% 0;}
    .loquat .text_r1{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p6_text_r1.png) no-repeat center center; background-size:100% auto;width:83%; margin-left:-38.5%;margin-top:8%;padding:10% 0;}
    z-index: 3;
    .page-7 .banner{background-image: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p7_banner.png);}
    .orange .fruit{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p7_orange.png) no-repeat center center; background-size:auto 100%;width:100%; height: 100%; left: 0;top: 0; z-index: 2;}
    .orange .water{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p7_juice.png) no-repeat center 0; background-size:auto 55%;width:110%; height: 100%; left: -7%;top:15%;overflow: hidden; -webkit-clip-path: circle(20%);clip-path: circle(20%);  opacity: 0; }

    .orange .text_l1{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p7_text_l.png) no-repeat center center; background-size:100% auto;width:70%; margin-left:-44%;padding:18% 0;z-index: 2;}
    .orange .text_r1{background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p7_text_r.png) no-repeat center center; background-size:100% auto;width:99%; margin-left:-50.2%;margin-top:6%;padding:12% 0;}


    .page-8 div{position:absolute; left:50%; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p8_banner.png) no-repeat center center; background-size:100% auto;}
    .page-8 .banner{width:80.2%; padding:10% 0; top:16%; margin-left:-40.1%; }
    .page-8 .text{background-image:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p8_text.png); width:67.2%; padding:35% 0; top:30.3%; margin-left:-33.6%; opacity: 0;}
    .page-8 .btn{background-image:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p8_btn.png); width:46.56%; padding:14.2% 0; top:70.3%; margin-left:-23.3%; opacity: 0;}

    .page-9 .text,.page-9 .code,.zt-con a{position:absolute; left:50%; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p9_text.png) no-repeat center center; background-size:100% auto; }
    .page-9 .text{width:76%; margin-left:-38%; padding:20% 0; top:5%; }
    .page-9 .a1{background-image:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p9_apple.png); width:33%; margin-left:-15.6%; padding:18% 0; top:23%; z-index: 3;}
    .page-9 .a2{background-image:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p9_orange.png); width:33%; margin-left:-38%; padding:18% 0; top:40%; z-index: 3;}
    .page-9 .a3{background-image:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p9_loquat.png); width:33%; margin-left:10%; padding:18% 0; top:40%; z-index: 3;}
    .page-9 .code{background-image:url(); opacity: 0; width: 45%;margin-left: -22.5%; top: 67%;z-index: 2;}
    .page-9 .zt-con a span{ position:absolute; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p9_btn.png) no-repeat center center; width:43%; padding:8% 0; background-size:100% auto;  bottom:0; left:50%; margin-left:-28%; }
    .page.page-9.page-current .arrow{display: none;}

    /* 动画部分 */
    .page.page-current .arrow{padding: 2.4% 0;width:9%;position:absolute;left:50%;top:92%;margin-left:-4.5%;z-index:2;background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/arrow.png) no-repeat center center;background-size: 100% auto;-webkit-animation:  moveIconUp ease 1.5s infinite 3s;animation:  moveIconUp ease 1.5s infinite 3s;opacity: 0;}
    .page-1.page-current .li2016{-webkit-animation: upIn 1.2s ease-out 1 forwards 0.2s;animation: upIn 1.2s ease-out 1 forwards 0.2s;}
    .page-1.page-current .ready{-webkit-animation: bottomIn 1.2s ease-out 1 forwards 1.4s;animation: bottomIn 1.2s ease-out 1 forwards 1.4s;}

    .banner{-webkit-transform: translateY(-200%);transform: translateY(-200%);opacity: 0;}
    .page-current .banner{-webkit-animation: upIn 0.8s ease-out 1 forwards ;animation: upIn 0.8s ease-out 1 forwards ;}
    .page-2.page-current .gift .footer{-webkit-animation: rotateXBottom 1s ease-out 1 forwards 0.8s;animation: rotateXBottom 1s ease-out 1 forwards 0.8s;}
    .page-2.page-current .gift .tree{-webkit-animation: scaleBottom 1.2s ease-in-out 1 forwards 1.5s;animation: scaleBottom 1.2s ease-in-out 1 forwards 1.5s;-webkit-transform-origin: bottom;transform-origin: bottom;}
    .page-2.page-current .tree span{-webkit-animation: verical-slow 20s ease-in-out infinite  2.5s;animation: verical-slow 20s ease-in-out infinite  2.5s;}
    .page-2.page-current .tree .a1,.page-2.page-current .tree .a6{-webkit-animation-delay: -5s; animation-delay: -5s; }
    .page-2.page-current .tree .a2,.page-2.page-current .tree .a9{-webkit-animation-delay: -10s;animation-delay: -10s;}
    .page-2.page-current .tree .a4,.page-2.page-current .tree .a7{-webkit-animation-delay: -15s;animation-delay: -15s;}

    .page-3.page-current .text{-webkit-animation: upIn 1s ease-in-out 1 forwards 0.8s;animation: upIn 1s ease-in-out 1 forwards 0.8s;}
    .page-3.page-current .btn{-webkit-animation: bottomIn 1s ease-in-out 1 forwards 1.8s;animation: bottomIn 1s ease-in-out 1 forwards 1.8s;}

    .page-4.page-current .monkey{-webkit-animation: upIn 1s ease-in-out 1 forwards 0.5s;animation: upIn 1s ease-in-out 1 forwards 0.5s;}
    .page-4.page-current .text_1{-webkit-animation: bottomIn 1s ease-in-out 1 forwards 1.2s;animation: bottomIn 1s ease-in-out 1 forwards 1.2s;}
    .page-4.page-current .text_2{-webkit-animation: bottomIn 1s ease-in-out 1 forwards 1.8s;animation: bottomIn 1s ease-in-out 1 forwards 1.8s;}
    .page-4.page-current .water{-webkit-animation: waterClipEllipse 1s ease-in 1 forwards 2.3s;animation: waterClipEllipse 1s ease-in 1 forwards 2.3s;}

    .fruit{opacity: 0;}
    .page-current .fruit{-webkit-animation: scaleBig 1.2s ease-in-out 1 forwards 0.8s;animation: scaleBig 1.2s ease-in-out 1 forwards 0.8s;}
    .page-current .con .water1,.page-current .con .water2{-webkit-animation: noBorderRadius 0.6s ease-in-out 1 forwards 2s;animation: noBorderRadius 0.6s ease-in-out 1 forwards 2s;}

    .page-5 .text>div,.page-6 .text>div,.page-7 .text>div{opacity: 0;}
    .page-current .text_l1{-webkit-animation: leftIn 1s ease-in-out 1 forwards 2s;animation: leftIn 1s ease-in-out 1 forwards 2s;}
    .page-current .text_l2{-webkit-animation: leftIn 1s ease-in-out 1 forwards 2s;animation: leftIn 1s ease-in-out 1 forwards 2s;}
    .page-current .text_r1{-webkit-animation: UpRightIn 1s ease-in-out 1 forwards 2s;animation: UpRightIn 1s ease-in-out 1 forwards 2s;}

    .page-7.page-current .orange .water{-webkit-animation: waterClip 1s ease-in 1 forwards 2.3s;animation: waterClip 1s ease-in 1 forwards 2.3s;}

    .page-8.page-current .text{-webkit-animation: upInBack 1.8s cubic-bezier(0.61, 0.35, 0.71, 0.43) 1 forwards 0.7s;animation: upInBack 1.8s cubic-bezier(0.61, 0.35, 0.71, 0.43) 1 forwards 0.7s;}/* (0.24, 0.61, 0.4, 0.76) */
    .page-8.page-current .btn{-webkit-animation: bottomIn 1s ease-in-out 1 forwards 1.5s;animation: bottomIn 1s ease-in-out 1 forwards 1.5s;}

    .page-9 a{opacity: 0;}
    .page-9.page-current .a1{-webkit-animation: leftIn 1s ease-in 1 forwards 0.8s;animation: leftIn 1s ease-in 1 forwards 0.8s;}
    .page-9.page-current .a2{-webkit-animation: leftIn 1.2s ease-in 1 forwards 1s;animation: leftIn 1.2s ease-in 1 forwards 1s;}
    .page-9.page-current .a3{-webkit-animation: rightIn 1.2s ease-in 1 forwards 1.2s;animation: rightIn 1.2s ease-in 1 forwards 1.2s;}
    .page-9.page-current .code{-webkit-animation: bottomIn 1s ease-out 1 forwards 2.2s;animation: bottomIn 1s ease-out 1 forwards 2.2s;}
    .page-9.page-current .zt-con a span{-webkit-animation: floatMove 1s ease-in-out infinite 0s;animation: floatMove 1s ease-in-out infinite 0s;}


    @-webkit-keyframes moveIconUp {
        0% { -webkit-transform: translateY(100%); transform: translateY(100%);opacity:0;}
        50% { -webkit-transform: translateY(0%); transform: translateY(0%);opacity:1;}
        100% { -webkit-transform: translateY(-100%); transform: translateY(-100%);opacity:0;}
    }
    @keyframes moveIconUp {
        0% { -webkit-transform: translateY(100%); transform: translateY(100%); opacity:0;}
        50% { -webkit-transform: translateY(0%); transform: translateY(0%); opacity:1;}
        100% { -webkit-transform: translateY(-100%); transform: translateY(-100%); opacity:0;}
    }
    @-webkit-keyframes showOut{
        to{opacity:1;}
    }
    @keyframes showOut{
        to{opacity:1;}
    }
    @-webkit-keyframes upIn{
        from{-webkit-transform: translateY(-200%);opacity: 0; }
        to{ -webkit-transform: translateY(0); opacity:1;}
    }
    @keyframes upIn{
        from{transform: translateY(-200%); opacity: 0;}
        to{transform: translateY(0); opacity:1;}
    }
    @-webkit-keyframes upInBack{
        from{
            -webkit-transform:translateY(-100%);
        }
        60% {
            -webkit-transform:translateY(-15%);
        }
        80% {
            -webkit-transform:translateY(-7%);
        }
        70%,85%,95% {
            -webkit-transform:translateY(0%);
        }
        90% {
            -webkit-transform:translateY(-3%);
        }
        100% {
            -webkit-transform:translateY(0);
            opacity: 1;
        }
    }
    @keyframes upInBack{
        from{
            transform:translateY(-100%);
        }
        60% {
            transform:translateY(-15%);
        }
        80% {
            transform:translateY(-7%);
        }
        70%,85%,95% {
            transform:translateY(0%);
        }
        90% {
            transform:translateY(-3%);
        }
        100% {
            transform:translateY(0);
            opacity: 1;
        }
    }
    @-webkit-keyframes bottomIn{
        from{
            -webkit-transform: translateY(200%);
            opacity: 0;
        }
        to{
            -webkit-transform: translateY(0);
            opacity:1;
        }
    }
    @keyframes bottomIn{
        from{
            transform: translateY(200%);
            opacity: 0;
        }
        to{
            transform: translateY(0);
            opacity:1;
        }
    }

    @-webkit-keyframes leftIn{
        from{
            -webkit-transform: translateX(-200%);
            opacity: 0;
        }
        to{
            -webkit-transform: translateX(0);
            opacity:1;
        }
    }
    @keyframes leftIn{
        from{
            transform: translateX(-200%);
            opacity: 0;
        }
        to{
            transform: translateX(0);
            opacity:1;
        }
    }
    @-webkit-keyframes UpRightIn{
        from{
            -webkit-transform: translateY(-30%) translateX(200%);
            opacity: 0;
        }
        to{
            -webkit-transform: translateY(0) translateX(0%);
            opacity:1;
        }
    }
    @-webkit-keyframes UpRightIn{
        from{
            -webkit-transform: translateY(-30%) translateX(200%);
            opacity: 0;
        }
        to{
            -webkit-transform: translateY(0) translateX(0%);
            opacity:1;
        }
    }
    @keyframes littleUpIn{
        from{
            transform: translateY(-30%);
            opacity: 0;
        }
        to{
            transform: translateY(0);
            opacity:1;
        }
    }
    @-webkit-keyframes rightIn{
        from{
            -webkit-transform: translateX(200%);
            opacity: 0;
        }
        to{
            -webkit-transform: translateX(0);
            opacity:1;
        }
    }
    @keyframes rightIn{
        from{
            transform: translateX(200%);
            opacity: 0;
        }
        to{
            transform: translateX(0);
            opacity:1;
        }
    }
    @-webkit-keyframes rotateXBottom{
        to{
            -webkit-transform: rotateX(0);
        }
    }
    @keyframes rotateXBottom{
        to{
            transform: rotateX(0);
        }
    }

    @-webkit-keyframes scaleBottom{
        from{
            -webkit-transform: scale(.1);
        }
        to{
            -webkit-transform: scale(1);
            opacity: 1;
        }
    }
    @keyframes scaleBottom{
        from{
            transform: scale(.1);
        }
        to{
            transform: scale(1);
            opacity: 1;
        }
    }

    @-webkit-keyframes scaleBig{
        from{
            -webkit-transform: scale(.1);
        }
        70%{
            -webkit-transform: scale(1.15);
        }
        to{
            -webkit-transform: scale(1);
            opacity: 1;
        }
    }
    @keyframes scaleBig{
        from{
            transform: scale(.1);
        }
        70%{
            transform: scale(1.15);
        }
        to{
            transform: scale(1);
            opacity: 1;
        }
    }
    @-webkit-keyframes noBorderRadius{
        to{
            border-radius: 0;
        }
    }
    @keyframes noBorderRadius{
        to{
            border-radius: 0;
        }
    }

    @-webkit-keyframes waterClipEllipse{
        to{
            -webkit-clip-path: ellipse(70% 50% at 50% 50%);
            clip-path: ellipse(70% 50% at 50% 50%);
            opacity: 1;
        }
    }
    @keyframes waterClipEllipse{
        to{
            -webkit-clip-path: ellipse(70% 50% at 50% 50%);
            clip-path: ellipse(70% 50% at 50% 50%);
            opacity: 1;
        }
    }
    @-webkit-keyframes waterClip{
        to{
            -webkit-clip-path: circle(100%);
            clip-path: circle(100%);
            opacity: 1;
        }
    }
    @keyframes waterClip{
        to{
            -webkit-clip-path: circle(100%);
            clip-path: circle(100%);
            opacity: 1;
        }
    }
    @keyframes floatMove {
        0% {
            -webkit-transform: translateY(0px);
            transform: translateY(0px);
        }
        50% {-webkit-transform: translateY(13%);
            transform: translateY(13%);
        }
        100% {-webkit-transform: translateY(0px);
            transform: translateY(0px);
        }
    }
    @-webkit-keyframes floatMove {
        0% {
            -webkit-transform: translateY(0px);
            transform: translateY(0px);
        }
        50% {-webkit-transform: translateY(13%);
            transform: translateY(13%);
        }
        100% {-webkit-transform: translateY(0px);
            transform: translateY(0px);
        }
    }
    @-webkit-keyframes verical-slow {
        2% {
            -webkit-transform: translate(0px, 1.5px) rotate(1.5deg);
        }
        4% {
            -webkit-transform: translate(0px, -1.5px) rotate(-0.5deg);
        }
        6% {
            -webkit-transform: translate(0px, 1.5px) rotate(-1.5deg);
        }
        8% {
            -webkit-transform: translate(0px, -1.5px) rotate(-1.5deg);
        }
        10% {
            -webkit-transform: translate(0px, 2.5px) rotate(1.5deg);
        }
        12% {
            -webkit-transform: translate(0px, -0.5px) rotate(1.5deg);
        }
        14% {
            -webkit-transform: translate(0px, -1.5px) rotate(1.5deg);
        }
        16% {
            -webkit-transform: translate(0px, -0.5px) rotate(-1.5deg);
        }
        18% {
            -webkit-transform: translate(0px, 0.5px) rotate(-1.5deg);
        }
        20% {
            -webkit-transform: translate(0px, -1.5px) rotate(2.5deg);
        }
        22% {
            -webkit-transform: translate(0px, 0.5px) rotate(-1.5deg);
        }
        24% {
            -webkit-transform: translate(0px, 1.5px) rotate(1.5deg);
        }
        26% {
            -webkit-transform: translate(0px, 0.5px) rotate(0.5deg);
        }
        28% {
            -webkit-transform: translate(0px, 0.5px) rotate(1.5deg);
        }
        30% {
            -webkit-transform: translate(0px, -0.5px) rotate(2.5deg);
        }
        32% {
            -webkit-transform: translate(0px, 1.5px) rotate(-0.5deg);
        }
        34% {
            -webkit-transform: translate(0px, 1.5px) rotate(-0.5deg);
        }
        36% {
            -webkit-transform: translate(0px, -1.5px) rotate(2.5deg);
        }
        38% {
            -webkit-transform: translate(0px, 1.5px) rotate(-1.5deg);
        }
        40% {
            -webkit-transform: translate(0px, -0.5px) rotate(2.5deg);
        }
        42% {
            -webkit-transform: translate(0px, 2.5px) rotate(-1.5deg);
        }
        44% {
            -webkit-transform: translate(0px, 1.5px) rotate(0.5deg);
        }
        46% {
            -webkit-transform: translate(0px, -1.5px) rotate(2.5deg);
        }
        48% {
            -webkit-transform: translate(0px, -0.5px) rotate(0.5deg);
        }
        50% {
            -webkit-transform: translate(0px, 0.5px) rotate(0.5deg);
        }
        52% {
            -webkit-transform: translate(0px, 2.5px) rotate(2.5deg);
        }
        54% {
            -webkit-transform: translate(0px, -1.5px) rotate(1.5deg);
        }
        56% {
            -webkit-transform: translate(0px, 2.5px) rotate(2.5deg);
        }
        58% {
            -webkit-transform: translate(0px, 0.5px) rotate(2.5deg);
        }
        60% {
            -webkit-transform: translate(0px, 2.5px) rotate(2.5deg);
        }
        62% {
            -webkit-transform: translate(0px, -0.5px) rotate(2.5deg);
        }
        64% {
            -webkit-transform: translate(0px, -0.5px) rotate(1.5deg);
        }
        66% {
            -webkit-transform: translate(0px, 1.5px) rotate(-0.5deg);
        }
        68% {
            -webkit-transform: translate(0px, -1.5px) rotate(-0.5deg);
        }
        70% {
            -webkit-transform: translate(0px, 1.5px) rotate(0.5deg);
        }
        72% {
            -webkit-transform: translate(0px, 2.5px) rotate(1.5deg);
        }
        74% {
            -webkit-transform: translate(0px, -0.5px) rotate(0.5deg);
        }
        76% {
            -webkit-transform: translate(0px, -0.5px) rotate(2.5deg);
        }
        78% {
            -webkit-transform: translate(0px, -0.5px) rotate(1.5deg);
        }
        80% {
            -webkit-transform: translate(0px, 1.5px) rotate(1.5deg);
        }
        82% {
            -webkit-transform: translate(0px, -0.5px) rotate(0.5deg);
        }
        84% {
            -webkit-transform: translate(0px, 1.5px) rotate(2.5deg);
        }
        86% {
            -webkit-transform: translate(0px, -1.5px) rotate(-1.5deg);
        }
        88% {
            -webkit-transform: translate(0px, -0.5px) rotate(2.5deg);
        }
        90% {
            -webkit-transform: translate(0px, 2.5px) rotate(-0.5deg);
        }
        92% {
            -webkit-transform: translate(0px, 0.5px) rotate(-0.5deg);
        }
        94% {
            -webkit-transform: translate(0px, 2.5px) rotate(0.5deg);
        }
        96% {
            -webkit-transform: translate(0px, -0.5px) rotate(1.5deg);
        }
        98% {
            -webkit-transform: translate(0px, -1.5px) rotate(-0.5deg);
        }
        0%, 100% {
            -webkit-transform: translate(0px, 0px) rotate(0deg);
        }
    }
    @keyframes verical-slow {
        2% {
            transform: translate(0px, 1.5px) rotate(1.5deg);
        }
        4% {
            transform: translate(0px, -1.5px) rotate(-0.5deg);
        }
        6% {
            transform: translate(0px, 1.5px) rotate(-1.5deg);
        }
        8% {
            transform: translate(0px, -1.5px) rotate(-1.5deg);
        }
        10% {
            transform: translate(0px, 2.5px) rotate(1.5deg);
        }
        12% {
            transform: translate(0px, -0.5px) rotate(1.5deg);
        }
        14% {
            transform: translate(0px, -1.5px) rotate(1.5deg);
        }
        16% {
            transform: translate(0px, -0.5px) rotate(-1.5deg);
        }
        18% {
            transform: translate(0px, 0.5px) rotate(-1.5deg);
        }
        20% {
            transform: translate(0px, -1.5px) rotate(2.5deg);
        }
        22% {
            transform: translate(0px, 0.5px) rotate(-1.5deg);
        }
        24% {
            transform: translate(0px, 1.5px) rotate(1.5deg);
        }
        26% {
            transform: translate(0px, 0.5px) rotate(0.5deg);
        }
        28% {
            transform: translate(0px, 0.5px) rotate(1.5deg);
        }
        30% {
            transform: translate(0px, -0.5px) rotate(2.5deg);
        }
        32% {
            transform: translate(0px, 1.5px) rotate(-0.5deg);
        }
        34% {
            transform: translate(0px, 1.5px) rotate(-0.5deg);
        }
        36% {
            transform: translate(0px, -1.5px) rotate(2.5deg);
        }
        38% {
            transform: translate(0px, 1.5px) rotate(-1.5deg);
        }
        40% {
            transform: translate(0px, -0.5px) rotate(2.5deg);
        }
        42% {
            transform: translate(0px, 2.5px) rotate(-1.5deg);
        }
        44% {
            transform: translate(0px, 1.5px) rotate(0.5deg);
        }
        46% {
            transform: translate(0px, -1.5px) rotate(2.5deg);
        }
        48% {
            transform: translate(0px, -0.5px) rotate(0.5deg);
        }
        50% {
            transform: translate(0px, 0.5px) rotate(0.5deg);
        }
        52% {
            transform: translate(0px, 2.5px) rotate(2.5deg);
        }
        54% {
            transform: translate(0px, -1.5px) rotate(1.5deg);
        }
        56% {
            transform: translate(0px, 2.5px) rotate(2.5deg);
        }
        58% {
            transform: translate(0px, 0.5px) rotate(2.5deg);
        }
        60% {
            transform: translate(0px, 2.5px) rotate(2.5deg);
        }
        62% {
            transform: translate(0px, -0.5px) rotate(2.5deg);
        }
        64% {
            transform: translate(0px, -0.5px) rotate(1.5deg);
        }
        66% {
            transform: translate(0px, 1.5px) rotate(-0.5deg);
        }
        68% {
            transform: translate(0px, -1.5px) rotate(-0.5deg);
        }
        70% {
            transform: translate(0px, 1.5px) rotate(0.5deg);
        }
        72% {
            transform: translate(0px, 2.5px) rotate(1.5deg);
        }
        74% {
            transform: translate(0px, -0.5px) rotate(0.5deg);
        }
        76% {
            transform: translate(0px, -0.5px) rotate(2.5deg);
        }
        78% {
            transform: translate(0px, -0.5px) rotate(1.5deg);
        }
        80% {
            transform: translate(0px, 1.5px) rotate(1.5deg);
        }
        82% {
            transform: translate(0px, -0.5px) rotate(0.5deg);
        }
        84% {
            transform: translate(0px, 1.5px) rotate(2.5deg);
        }
        86% {
            transform: translate(0px, -1.5px) rotate(-1.5deg);
        }
        88% {
            transform: translate(0px, -0.5px) rotate(2.5deg);
        }
        90% {
            transform: translate(0px, 2.5px) rotate(-0.5deg);
        }
        92% {
            transform: translate(0px, 0.5px) rotate(-0.5deg);
        }
        94% {
            transform: translate(0px, 2.5px) rotate(0.5deg);
        }
        96% {
            transform: translate(0px, -0.5px) rotate(1.5deg);
        }
        98% {
            transform: translate(0px, -1.5px) rotate(-0.5deg);
        }
        0%, 100% {
            transform: translate(0px, 0px) rotate(0deg);
        }
    }

    </style>
</head>
<body>
<div id="page-hd">
    <!-- loading -->
    <div id="loading">
        <div class="spinner">
            <div class="spinner-container container1">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
                <div class="circle4"></div>
            </div>
            <div class="spinner-container container2">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
                <div class="circle4"></div>
            </div>
            <div class="spinner-container container3">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
                <div class="circle4"></div>
            </div>
        </div>
    </div>
    <!-- music -->
    <audio id="music-audio" class="audio" src="<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/music.mp3" autoplay  preload loop></audio>
</div>
<div id="tips">
    <img src="<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/tips.gif" alt="请竖屏观看哦">
    <div>请竖屏观看哦</div>
</div>
<div id="page-content">
    <div class="page page-1">
        <div class="li2016"></div>
        <div class="ready"></div>
        <div class="arrow"></div>
    </div>
    <div class="page page-2 hide">
        <div class="banner"></div>
        <div class="gift">
            <div class="tree">
                <span class="a1">三姑六婆</span>
                <span class="a2">长辈亲人</span>
                <span class="a3">婆婆公公</span>
                <span class="a4">客户</span>
                <span class="a5">伴手礼</span>
                <span class="a6">爸妈</span>
                <span class="a7">丈母娘</span>
                <span class="a8">长辈</span>
                <span class="a9">朋友</span>
            </div>
            <div class="footer"></div>
        </div>
        <div class="arrow"></div>
    </div>
    <div class="page page-3 hide">
        <div class="banner"></div>
        <div class="text"></div>
        <div class="btn"></div>
        <div class="arrow"></div>
    </div>
    <div class="page page-4 hide">
        <div class="banner"></div>
        <div class="monkey"></div>
        <div class="text_1"></div>
        <div class="text_2">
            <span class="water"></span>
        </div>
        <div class="arrow"></div>
    </div>
    <div class="page page-5 hide">
        <div class="banner"></div>
        <div class="con apple">
            <div class="water1"></div>
            <div class="water2"></div>
            <div class="fruit"></div>
        </div>
        <div class="text apple">
            <div class="text_l1"></div>
            <div class="text_l2"></div>
            <div class="text_r1"></div>
        </div>
        <div class="arrow"></div>
    </div>
    <div class="page page-6 hide">
        <div class="banner"></div>
        <div class="con loquat">
            <div class="water1"></div>
            <div class="water2"></div>
            <div class="fruit"></div>
        </div>
        <div class="text loquat">
            <div class="text_l1"></div>
            <div class="text_l2"></div>
            <div class="text_r1"></div>
        </div>
        <div class="arrow"></div>
    </div>
    <div class="page page-7 hide">
        <div class="banner"></div>
        <div class="con orange">
            <div class="water"></div>
            <div class="fruit"></div>
        </div>
        <div class="text orange">
            <div class="text_l1"></div>
            <div class="text_r1"></div>
        </div>
        <div class="arrow"></div>
    </div>
    <div class="page page-8 hide">
        <div class="banner"></div>
        <div class="text"></div>
        <div class="btn"></div>
        <div class="arrow"></div>
    </div>
    <div class="page page-9 hide">
        <div class="text banner"></div>
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/453270.html" class="a1"><span></span></a>
            <a href="http://www.g-emall.com/JF/272473.html" class="a2"><span></span></a>
            <a href="http://www.g-emall.com/JF/437587.html" class="a3"><span></span></a>
        </div>
        <img class="code" src="<?php echo ATTR_DOMAIN;?>/zt/panzhihua-fruit/p9_code.png">
        <div class="arrow"></div>
    </div>
</div>
<script  src="<?php echo $this->theme->baseUrl.'/';?>js/zt/zepto.min.js"></script>
<script  src="<?php echo $this->theme->baseUrl.'/';?>js/zt/touch.js"></script>
<script type="text/javascript">
    /*判断是否竖屏浏览*/
    (function(doc, win) {
        var docEl = doc.documentElement;
        resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize';
        recalc = function() {
            var clientWidth = docEl.clientWidth;
            var clientHeight = !docEl.clientHeight?window.innerHeight:docEl.clientHeight;
//            console.log(clientHeight)
            if (clientHeight <= clientWidth){
                Zepto("#tips").show();
                Zepto("#music-audio").get(0).pause();
            }else{
                Zepto("#tips").hide();
                Zepto("#music-audio").get(0).play();
            }
        };
        if (!doc.addEventListener) return;
        win.addEventListener(resizeEvt, recalc, false);
        doc.addEventListener('DOMContentLoaded', recalc, false);
    })(document, window);



        //配置
        var config = {
            'audio': {
                'icon': 'audio-record-play',
                'text': true
            },
            'loading': 'loading-ic'
        };

        //loading
        window.onload = function() {
            Zepto('#loading').hide();
            Zepto(".page-1").addClass("page-current");
        }
        var pageIndex = 1,
            pageTotal = Zepto('.page').length,
            towards = { up:1, right:2, down:3, left:4},
            isAnimating = false;
        //禁用手机默认的触屏滚动行为
        document.addEventListener('touchmove', function(event) {
            event.preventDefault();
        }, false);

        Zepto(document).swipeUp(function() {
            if (isAnimating) return;
            if (pageIndex < pageTotal) {
                pageIndex += 1;
            } else {
                pageIndex = 1;
            };
            pageMove(towards.up);

        })
        Zepto(document).swipeDown(function() {
            if (isAnimating) return;
            if (pageIndex > 1) {
                pageIndex -= 1;
            } else {
                pageIndex = pageTotal;
            };
            pageMove(towards.down);

        })
        function pageMove(tw){
            var lastPage;
            if (tw == '1') {
                if (pageIndex == 1) {
                    lastPage = ".page-" + pageTotal;
                } else {
                    lastPage = ".page-" + (pageIndex - 1);
                }

            } else if (tw == '3') {
                if (pageIndex == pageTotal) {
                    lastPage = ".page-1";
                } else {
                    lastPage = ".page-" + (pageIndex + 1);
                }

            }
            var nowPage = ".page-" + pageIndex;
            switch (tw) {
                case towards.up:
                    outClass = 'pt-page-moveToTop'; /*向上离去*/
                    inClass = 'pt-page-moveFromBottom'; /*向上进入*/
                    break;
                case towards.down:
                    outClass = 'pt-page-moveToBottom'; /*向下离去*/
                    inClass = 'pt-page-moveFromTop'; /*向下进入*/
                    break;
            }
            isAnimating = true;
            Zepto(nowPage).removeClass("hide");

            Zepto(lastPage).addClass(outClass);
            Zepto(nowPage).addClass(inClass);

            setTimeout(function() {
                Zepto(lastPage).removeClass('page-current');
                Zepto(lastPage).removeClass(outClass);
                Zepto(lastPage).addClass("hide");

                Zepto(nowPage).addClass('page-current');
                Zepto(nowPage).removeClass(inClass);

                isAnimating = false;
            }, 800);
        }


</script>
</body>
</html>

