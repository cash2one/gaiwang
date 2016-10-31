<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.flexslider-min.js');?>
<style type="text/css">
	/*=====
	    @Date:2014-10-08
	    @content:青岛专题
		@author:林聪毅
	 =====*/
	.zt-wrap{width:100%; background:#fff;}
	.zt-con { width:1100px; margin:0 auto; position:relative; }
	.zt-con a{ position:absolute;display:block;}
	.qingdao-01{height:307px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-01.jpg) top center no-repeat;}
	.qingdao-02{height:306px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-02.jpg) top center no-repeat;}
	.qingdao-03{height:188px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-03.jpg) top center no-repeat;}
	.qingdao-04{height:217px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-04.jpg) top center no-repeat;}
	.qingdao-05{height:216px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-05.jpg) top center no-repeat;}
	.qingdao-06{height:393px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-06.jpg) top center no-repeat;}
	.qingdao-07{height:180px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-07.jpg) top center no-repeat;}
	.qingdao-08{height:328px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-08.jpg) top center no-repeat;}
	.qingdao-09{height:326px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-09.jpg) top center no-repeat;}
	.qingdao-10{height:261px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-10.jpg) top center no-repeat;}

	.qingdao-11{height:260px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-11.jpg) top center no-repeat;}
	.qingdao-12{height:452px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-12.jpg) top center no-repeat;}
	.qingdao-13{height:255px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-13.jpg) top center no-repeat;}
	.qingdao-14{height:133px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-14.jpg) top center no-repeat;}
	.qingdao-15{height:135px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-15.jpg) top center no-repeat;}
	.qingdao-16{height:475px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-16.jpg) top center no-repeat;}
	.qingdao-17{height:260px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-17.jpg) top center no-repeat;}
	.qingdao-18{height:260px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-18.jpg) top center no-repeat;}
	.qingdao-19{height:279px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-19.jpg) top center no-repeat;}
	.qingdao-20{height:278px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-20.jpg) top center no-repeat;}

	.qingdao-21{height:374px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-21.jpg) top center no-repeat;}
	.qingdao-22{height:262px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-22.jpg) top center no-repeat;}
	.qingdao-23{height:262px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-23.jpg) top center no-repeat;}
	.qingdao-24{height:393px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-24.jpg) top center no-repeat;}
	.qingdao-25{height:417px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-25.jpg) top center no-repeat;}
	.qingdao-26{height:285px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-26.jpg) top center no-repeat;}
	.qingdao-27{height:285px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-27.jpg) top center no-repeat;}
	.qingdao-28{height:453px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-28.jpg) top center no-repeat;}
	.qingdao-29{height:521px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-29-1.jpg) top center no-repeat;}
	.qingdao-30{height:478px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-30.jpg) top center no-repeat;}

	.qingdao-31{height:172px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-31.jpg) top center no-repeat;}
	.qingdao-32{height:174px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-32.jpg) top center no-repeat;}
	.qingdao-33{height:175px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-33.jpg) top center no-repeat;}
	.qingdao-34{height:477px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-34.jpg) top center no-repeat;}
	.qingdao-35{height:262px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-35.jpg) top center no-repeat;}
	.qingdao-36{height:261px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-36.jpg) top center no-repeat;}
	.qingdao-37{height:330px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-37.jpg) top center no-repeat;}
	.qingdao-38{height:429px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-38.jpg) top center no-repeat;}
	.qingdao-39{height:262px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-39.jpg) top center no-repeat;}
	.qingdao-40{height:258px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-40.jpg) top center no-repeat;}

	.qingdao-41{height:492px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-41.jpg) top center no-repeat;}
	.qingdao-42{height:259px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-42.jpg) top center no-repeat;}
	.qingdao-43{height:258px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-43.jpg) top center no-repeat;}
	.qingdao-44{height:547px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-44.jpg) top center no-repeat;}
	.qingdao-45{height:512px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-45.jpg) top center no-repeat;}
	.qingdao-46{height:263px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-46.jpg) top center no-repeat;}
	.qingdao-47{height:262px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-47.jpg) top center no-repeat;}
	.qingdao-48{height:288px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-48.jpg) top center no-repeat;}
	.qingdao-49{height:285px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-49.jpg) top center no-repeat;}
	.qingdao-50{height:262px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-50.jpg) top center no-repeat;}

	.qingdao-51{height:260px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-51.jpg) top center no-repeat;}
	.qingdao-52{height:537px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-52.jpg) top center no-repeat;}
	.qingdao-53{height:338px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-53.jpg) top center no-repeat;}
	.qingdao-54{height:185px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-54.jpg) top center no-repeat;}
	.qingdao-55{height:376px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-55.jpg) top center no-repeat;}
	.qingdao-56{height:394px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-56.jpg) top center no-repeat;}
	.qingdao-57{height:496px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-57.jpg) top center no-repeat;}

	.qingdao-06 a{width: 163px; height: 163px; left: 480px; top: 70px;}
	.qingdao-06 .red{background: url(<?php echo ATTR_DOMAIN?>/zt/qingdao/red.png) no-repeat; display: none;}
	.qingdao-06 .blue{background: url(<?php echo ATTR_DOMAIN?>/zt/qingdao/blue.png) no-repeat;}
	.qingdao-07 a{ width:140px; height:120px; top:36px;}
	.qingdao-07 .a1{left:60px;}
	.qingdao-07 .a2{left:264px;}
	.qingdao-07 .a3{left:470px;}
	.qingdao-07 .a4{left:674px;}
	.qingdao-07 .a5{left:882px;}

	.qingdao-12 a{ width:260px; height:320px; top:40px;}
	.qingdao-12 .a1{left:70px; }
	.qingdao-12 .a2{left:420px; }
	.qingdao-12 .a3{left:780px; }
	.qingdao-16 a{ width:270px; height:360px; top:26px;}
	.qingdao-16 .a1{left:50px; }
	.qingdao-16 .a2{left:440px; }
	.qingdao-16 .a3{left:780px; }
	.qingdao-19 a{ width:290px; height:250px; top:0px;}
	.qingdao-19 .a1{left:40px; }
	.qingdao-19 .a2{left:404px; }
	.qingdao-19 .a3{left:766px; }
	.qingdao-20 a{ width:290px; height:250px; top:0px;}
	.qingdao-20 .a1{left:40px; }
	.qingdao-20 .a2{left:404px; }
	.qingdao-20 .a3{left:766px; }

	.qingdao-21 .flexslider .slides li a{ width:290px; height:250px; top:10px;}
	.qingdao-21 .flexslider .slides li .a1{left:1140px; }
	.qingdao-21 .flexslider .slides li .a2{left:1504px; }
	.qingdao-21 .flexslider .slides li .a3{left:1866px; }
	.qingdao-21 .flexslider .slides li .a4{left:2240px; }
	.qingdao-21 .flexslider .slides li .a5{left:2604px; }
	.qingdao-21 .flexslider .slides li .a6{left:2966px; }
	.qingdao-21 span{position: absolute; top: 276px; font-size: 16px; font-weight: bold; z-index: 3;}
	.qingdao-21 .span1{left: 446px;}
	.qingdao-21 .span2{left: 590px;}
	.qingdao-21 .flex-direction-nav li a{width: 28px; height: 27px;}
	.qingdao-21 .flex-direction-nav li a.flex-prev {left:560px; top: 130px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/prev_gray.png) no-repeat scroll bottom center; }
	.qingdao-21 .flex-direction-nav li a.flex-next {left:600px; top: 130px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/next_gray.png) no-repeat scroll top center; }

	.qingdao-24 a{ width:210px; height:280px; top:60px;}
	.qingdao-24 .a1{left:330px; }
	.qingdao-24 .a2{left:580px; }
	.qingdao-25 .flexslider .slides li a{ width:1100px; height:325px; top:10px;}
	.qingdao-25 span{position: absolute; top: 356px; font-size: 16px; font-weight: bold; color: #fff; z-index: 3;}
	.qingdao-25 .flexslider .flex-viewport li{height: 325px;}
	.qingdao-25 .span1{left: 446px;}
	.qingdao-25 .span2{left: 590px;}
	.qingdao-25 .flex-direction-nav li a{width: 28px; height: 27px;}
	.qingdao-25 .flex-direction-nav li a.flex-prev {left:560px; top: 210px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/prev_red.png) no-repeat scroll bottom center; }
	.qingdao-25 .flex-direction-nav li a.flex-next {left:600px; top: 210px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/next_red.png) no-repeat scroll top center; }
	.qingdao-28 .flexslider .slides li a{}
	.qingdao-28 .flexslider .slides li .a1{width: 450px; height: 296px; left:1130px; top: 30px;}
	.qingdao-28 .flexslider .slides li .a2{width: 400px; height: 270px; left:1704px; top: 38px;}
	.qingdao-28 .flexslider .slides li .a3{width: 1100px; height: 327px; left:2200px; top: 0px;}
	.qingdao-28 .flexslider .slides li .a4{width: 240px; height: 290px; left:3548px; top: 30px;}
	.qingdao-28 .flexslider .slides li .a5{width: 240px; height: 290px; left:3840px; top: 30px;}
	.qingdao-28 .flex-viewport{top: 20px;}
	.qingdao-28 span{position: absolute; top: 370px; font-size: 16px; font-weight: bold; z-index: 3; color: #fff;}
	.qingdao-28 .span1{left: 446px;}
	.qingdao-28 .span2{left: 590px;}
	.qingdao-28 .flex-direction-nav li a{width: 28px; height: 27px;}
	.qingdao-28 .flex-direction-nav li a.flex-prev {left:560px; top: 224px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/prev_red.png) no-repeat scroll bottom center; }
	.qingdao-28 .flex-direction-nav li a.flex-next {left:600px; top: 224px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/next_red.png) no-repeat scroll top center; }
	.qingdao-30 .flexslider .slides li a{ width:290px; height:250px;}
	.qingdao-30 .flexslider .slides li .a1{left:1110px; top:30px;}
	.qingdao-30 .flexslider .slides li .a2{left:1514px; top:30px;}
	.qingdao-30 .flexslider .slides li .a3{width: 300px; height: 310px; left:1896px; top: 0px; color: #fff;}
	.qingdao-30 .flexslider .slides li .a4{width: 330px; left:2240px; top:60px;}
	.qingdao-30 .flexslider .slides li .a5{width: 330px; left:2594px; top:60px;}
	.qingdao-30 .flexslider .slides li .a6{width: 330px; left:2948px; top:60px;}
	.qingdao-30 .flex-viewport{top: 20px;}
	.qingdao-30 span{position: absolute; top: 370px; font-size: 16px; font-weight: bold; z-index: 3;}
	.qingdao-30 .span1{left: 446px;}
	.qingdao-30 .span2{left: 590px;}
	.qingdao-30 .flex-direction-nav li a{width: 28px; height: 27px;}
	.qingdao-30 .flex-direction-nav li a.flex-prev {left:560px; top: 222px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/prev_red.png) no-repeat scroll bottom center; }
	.qingdao-30 .flex-direction-nav li a.flex-next {left:600px; top: 222px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/next_red.png) no-repeat scroll top center; }

	.qingdao-34 .flexslider .slides li a{height:290px;}
	.qingdao-34 .flexslider .slides li .a1{width:410px; left:1170px; top: 10px;}
	.qingdao-34 .flexslider .slides li .a2{width:300px; left:1730px; top: 30px;}
	.qingdao-34 .flexslider .slides li .a3{width:390px; left:2270px; top: 40px;}
	.qingdao-34 .flexslider .slides li .a4{width:310px; left:2780px; top: 30px;}
	.qingdao-34 .flex-viewport{top: 20px;}
	.qingdao-34 span{position: absolute; top: 378px; font-size: 16px; font-weight: bold; z-index: 3; color: #fff;}
	.qingdao-34 .span1{left: 446px;}
	.qingdao-34 .span2{left: 590px;}
	.qingdao-34 .flex-direction-nav li a{width: 28px; height: 27px;}
	.qingdao-34 .flex-direction-nav li a.flex-prev {left:560px; top: 230px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/prev_red.png) no-repeat scroll bottom center; }
	.qingdao-34 .flex-direction-nav li a.flex-next {left:600px; top: 230px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/next_red.png) no-repeat scroll top center; }
	.qingdao-37 a{top:0px;}
	.qingdao-37 .a1{width:370px; height:330px; left:160px; }
	.qingdao-37 .a2{width:250px; height:330px; left:550px; }
	.qingdao-38 a{ width:220px; height:360px; top:0px;}
	.qingdao-38 .a1{left:26px; }
	.qingdao-38 .a2{left:450px; }
	.qingdao-38 .a3{left:860px; }

	.qingdao-41 .flexslider .slides li a{ width:340px; height:260px; top: 0px;}
	.qingdao-41 .flexslider .slides li .a1{left:1100px;}
	.qingdao-41 .flexslider .slides li .a2{left:1480px;}
	.qingdao-41 .flexslider .slides li .a3{left:1860px;}
	.qingdao-41 .flexslider .slides li .a4{left:3300px;}
	.qingdao-41 .flexslider .slides li .a5{left:3680px;}
	.qingdao-41 .flexslider .slides li .a6{left:4060px;}
	.qingdao-41 .flexslider .slides li .a7{left:2200px;}
	.qingdao-41 .flexslider .slides li .a8{left:2580px;}
	.qingdao-41 .flexslider .slides li .a9{left:2960px;}
	.qingdao-41 .flex-viewport{top: 20px;}
	.qingdao-41 span{position: absolute; top: 400px; font-size: 16px; font-weight: bold; z-index: 3; color: #fff;}
	.qingdao-41 .span1{left: 446px;}
	.qingdao-41 .span2{left: 590px;}
	.qingdao-41 .flex-direction-nav li a{width: 28px; height: 27px;}
	.qingdao-41 .flex-direction-nav li a.flex-prev {left:560px; top: 240px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/prev_red.png) no-repeat scroll bottom center; }
	.qingdao-41 .flex-direction-nav li a.flex-next {left:600px; top: 240px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/next_red.png) no-repeat scroll top center; }
	.qingdao-44 .flexslider .slides li a{height:334px; top: 0px;}
	.qingdao-44 .flexslider .slides li .a1{width:420px; left:1100px;}
	.qingdao-44 .flexslider .slides li .a2{width:680px; left:1520px;}
	.qingdao-44 .flexslider .slides li .a3{width:420px; left:2200px;}
	.qingdao-44 .flexslider .slides li .a4{width:680px; left:2620px;}
	.qingdao-44 .flexslider .slides li .a5{width:420px; left:3300px;}
	.qingdao-44 .flexslider .slides li .a6{width:680px; left:3720px;}
	.qingdao-44 .flex-viewport{top: 20px;}
	.qingdao-44 span{position: absolute; top: 508px; font-size: 16px; font-weight: bold; z-index: 3; color: #fff;}
	.qingdao-44 .span1{left: 446px;}
	.qingdao-44 .span2{left: 590px;}
	.qingdao-44 .flex-direction-nav li a{width: 28px; height: 27px;}
	.qingdao-44 .flex-direction-nav li a.flex-prev {left:560px; top: 300px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/prev_red.png) no-repeat scroll bottom center; }
	.qingdao-44 .flex-direction-nav li a.flex-next {left:600px; top: 300px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/next_red.png) no-repeat scroll top center; }
	.qingdao-45 .flexslider .slides li a{ width:360px; height:264px; top: 0px;}
	.qingdao-45 .flexslider .slides li .a1{left:1100px;}
	.qingdao-45 .flexslider .slides li .a2{left:1470px;}
	.qingdao-45 .flexslider .slides li .a3{left:1840px;}
	.qingdao-45 .flexslider .slides li .a4{left:2200px;}
	.qingdao-45 .flexslider .slides li .a5{left:2570px;}
	.qingdao-45 .flexslider .slides li .a6{left:2940px;}
	.qingdao-45 .flex-viewport{top: 20px;}
	.qingdao-45 span{position: absolute; top: 420px; font-size: 16px; font-weight: bold; z-index: 3; color: #fff;}
	.qingdao-45 .span1{left: 446px;}
	.qingdao-45 .span2{left: 590px;}
	.qingdao-45 .flex-direction-nav li a{width: 28px; height: 27px;}
	.qingdao-45 .flex-direction-nav li a.flex-prev {left:560px; top: 254px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/prev_red.png) no-repeat scroll bottom center; }
	.qingdao-45 .flex-direction-nav li a.flex-next {left:600px; top: 254px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/next_red.png) no-repeat scroll top center; }
	.qingdao-48 a{}
	.qingdao-48 .a1{width:200px; height:420px; left:94px; top: 50px;}
	.qingdao-48 .a2{width:200px; height:320px; left:424px; top: 150px;}
	.qingdao-48 .a3{width:200px; height:420px; left:752px; top: 50px;}

	.qingdao-52 a{ width:150px; height:150px;}
	.qingdao-52 .a1{left:66px; top:194px;}
	.qingdao-52 .a2{left:240px; top:182px;}
	.qingdao-52 .a3{left:616px; top:184px;}
	.qingdao-52 .a4{left:860px; top:194px;}
	.qingdao-55 a{}
	.qingdao-55 .a1{width: 444px; height: 260px; left: 50px; top: 40px;}
	.qingdao-55 .a2{width: 410px; height: 250px; left: 634px; top: 40px;}
	.qingdao-56 a{ width:256px; height:346px; top:40px;}
	.qingdao-56 .a1{left:60px; }
	.qingdao-56 .a2{left:406px; }
	.qingdao-56 .a3{left:750px; }
	.qingdao-57 .flexslider .slides li a{ width:350px; height:380px; top: 0px;}
	.qingdao-57 .flexslider .slides li .a1{left:1100px;}
	.qingdao-57 .flexslider .slides li .a2{left:1470px;}
	.qingdao-57 .flexslider .slides li .a3{left:1840px;}
	.qingdao-57 .flexslider .slides li .a4{left:2200px;}
	.qingdao-57 .flexslider .slides li .a5{left:2570px;}
	.qingdao-57 .flexslider .slides li .a6{left:2940px;}
	.qingdao-57 .flex-viewport{top: 20px;}
	.qingdao-57 span{position: absolute; top: 420px; font-size: 16px; font-weight: bold; z-index: 3; color: #fff;}
	.qingdao-57 .span1{left: 446px;}
	.qingdao-57 .span2{left: 590px;}
	.qingdao-57 .flex-direction-nav li a{width: 28px; height: 27px;}
	.qingdao-57 .flex-direction-nav li a.flex-prev {left:560px; top: 254px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/prev_red.png) no-repeat scroll bottom center; }
	.qingdao-57 .flex-direction-nav li a.flex-next {left:600px; top: 254px; background:url(<?php echo ATTR_DOMAIN?>/zt/qingdao/next_red.png) no-repeat scroll top center; }

	.flexslider{background: none; height: auto; overflow: visible;}
	.flex-viewport{height: auto;}
	.flexslider .slides li{height: auto;}
	.flexslider .slides li a{height: auto; margin: initial; position: absolute;}

</style>

	<div class="zt-wrap">			
		<div class="qingdao-01"></div>
		<div class="qingdao-02"></div>
		<div class="qingdao-03"></div>
		<div class="qingdao-04"></div>
		<div class="qingdao-05"></div>
		<div class="qingdao-06">
			<div class="zt-con">
                <?php echo CHtml::link('','javascript:void(0)',array('class'=>'red signin')) ?>
                <?php echo CHtml::link('','javascript:void(0)',array('class'=>'blue signin')) ?>
			</div>
		</div>
		<div class="qingdao-07">
			<div class="zt-con">
                <?php echo CHtml::link('','#part2',array('class'=>'a1')) ?>
                <?php echo CHtml::link('','#part1',array('class'=>'a2')) ?>
                <?php echo CHtml::link('','#part3',array('class'=>'a3')) ?>
                <?php echo CHtml::link('','#part4',array('class'=>'a4')) ?>
                <?php echo CHtml::link('','#part5',array('class'=>'a5')) ?>
			</div>
		</div>
		<div class="qingdao-08"></div>
		<div class="qingdao-09"></div>
            <?php echo CHtml::link('<div class="qingdao-10" id="part2"></div>',$this->createAbsoluteUrl('/shop/1453'),array('target'=> '_blank')) ?>
            <?php echo CHtml::link('<div class="qingdao-11"></div>',$this->createAbsoluteUrl('/shop/1453'),array('target'=> '_blank')) ?>
		<div class="qingdao-12">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>84820)),array('class'=>'a1','title'=> '【花姐牌】金钩海米500g 青岛特产虾仁虾干海鲜干货即食海产品 包邮','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>87049)),array('class'=>'a2','title'=> '【花姐牌】海米 青岛特产 新鲜干货海产品 508g（包邮）','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>87043)),array('class'=>'a3','title'=> '【花姐牌】干贝 青岛特产扇贝柱 新鲜干货海产品 500g（包邮）','target'=> '_blank')) ?>
			</div>
		</div>
                <?php echo CHtml::link('<div class="qingdao-13"></div>',$this->createAbsoluteUrl('/shop/1058'),array('class'=>'qingdao-13','target'=> '_blank')) ?>
                <?php echo CHtml::link('<div class="qingdao-14"></div>',$this->createAbsoluteUrl('/shop/1058'),array('class'=>'qingdao-14','target'=> '_blank')) ?>
                <?php echo CHtml::link('<div class="qingdao-15"></div>',$this->createAbsoluteUrl('/shop/1058'),array('class'=>'qingdao-15','target'=> '_blank')) ?>
		<div class="qingdao-16">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>73477)),array('class'=>'a1','title'=> '干贝 500克','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>73476)),array('class'=>'a2','title'=> '虾米2号 500克','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>73486)),array('class'=>'a3','title'=> '鱼片（鳕鱼 面包鱼 小黄花）500克','target'=> '_blank')) ?>
			</div>
		</div>
                <?php echo CHtml::link('<div class="qingdao-17"></div>',$this->createAbsoluteUrl('/shop/2204'),array('target'=> '_blank')) ?>
                <?php echo CHtml::link('<div class="qingdao-18"></div>',$this->createAbsoluteUrl('/shop/2204'),array('target'=> '_blank')) ?>
		<div class="qingdao-19">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>128682)),array('class'=>'a1','title'=> '翡鳕门 野生熟冻智利帝王蟹 新鲜美味 过节送礼佳品 2.5斤左右一只','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>131985)),array('class'=>'a2','title'=> '翡鳕门 野生北极甜虾 口味清甜 肉质饱满Q弹 解冻即食','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>132081)),array('class'=>'a3','title'=> '【翡鳕门】英国进口黄金蟹全部母蟹满黄 野生捕捞熟冻 称重改价','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="qingdao-20">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>128690)),array('class'=>'a1','title'=> '【翡鳕门】新鲜真空包装 去沙线超大虾仁 一斤26-30只 Q弹新鲜','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>128663)),array('class'=>'a2','title'=> '翡鳕门 超嫩龙利鱼柳 肉质细嫩绵软无刺 新鲜 29一片 7两左右','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>128597)),array('class'=>'a3','title'=> '翡鳕门 青岛特色一卤鲜带鱼 带鱼鲞 汤腌风味 调味带鱼','target'=> '_blank')) ?>
			</div>
		</div>

		<div class="qingdao-21">
			<div class="zt-con flexslider">
				<ul class="slides">
					<li>
						<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-1-1.jpg">
            			<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>131969)),array('class'=>'a1','title'=> '翡鳕门 石斑鱼鲞 一卤鲜石斑 进口野生石斑美味方便快捷一蒸就好','target'=> '_blank')) ?>
            			<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>131964)),array('class'=>'a2','title'=> '一卤鲜鲈鱼 汤腌鲈鱼 鲈鱼鲞 野生海鲈鱼  方便美味一蒸就好','target'=> '_blank')) ?>
            			<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>128669)),array('class'=>'a3','title'=> '翡鳕门 野生格陵兰鲽鱼 比目鱼 肉质细嫩新鲜无小刺 适合儿童','target'=> '_blank')) ?>
					</li>
					<li>
						<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-1-2.jpg">
                		<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>128876)),array('class'=>'a4','title'=> '翡鳕门 麻辣黄花鱼 小黄鱼 独门秘制麻辣鲜香肉质软嫩快捷美味','target'=> '_blank')) ?>
                		<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>128830)),array('class'=>'a5','title'=> '翡鳕门 独门秘制腌制鳗鱼 肉质软糯无小刺红烧口味一蒸就好','target'=> '_blank')) ?>
                		<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>128803)),array('class'=>'a6','title'=> '翡鳕门 秘制麻辣鲅鱼 开袋即食口味独特 赚人气半价销售','target'=> '_blank')) ?>
					</li>
				</ul>			
				<span class="span1">上一页</span>
				<span class="span2">下一页</span>
			</div>
		</div>
		<div class="qingdao-22"></div>
		<div class="qingdao-23"></div>
		<div class="qingdao-24">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>72994)),array('class'=>'a1','title'=> '【花姐牌】野生海参（百年海参养殖特供）超豪华海参礼盒','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>87047)),array('class'=>'a2','title'=> '【花姐牌】干鲍 青岛特产 新鲜干货海产品 260g（包邮）','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="qingdao-25">
			<div class="zt-con flexslider">
				<ul class="slides">
					<li>
                		<?php echo CHtml::link(CHtml::image(ATTR_DOMAIN.'/zt/qingdao/slider-2-1.jpg'),$this->createAbsoluteUrl('/goods/view',array('id'=>73474)),array('class'=>'a1','title'=> '鲍鱼（干）500克','target'=> '_blank')) ?>
					</li>
					<li>					
                <?php echo CHtml::link(CHtml::image(ATTR_DOMAIN.'/zt/qingdao/slider-2-2.jpg'),$this->createAbsoluteUrl('/goods/view',array('id'=>73471)),array('class'=>'a2','title'=> '崂峰海参一级2号400克/盒','target'=> '_blank')) ?>
					</li>
					<li>			
                <?php echo CHtml::link(CHtml::image(ATTR_DOMAIN.'/zt/qingdao/slider-2-3.jpg'),$this->createAbsoluteUrl('/goods/view',array('id'=>73472)),array('class'=>'a3','title'=> '崂峰海参一级3号400克/盒','target'=> '_blank')) ?>
					</li>
				</ul>			
				<span class="span1">上一页</span>
				<span class="span2">下一页</span>
			</div>
		</div>
		                <?php echo CHtml::link('<div class="qingdao-53"></div>',$this->createAbsoluteUrl('/shop/3600'),array('target'=> '_blank')) ?>
		                <?php echo CHtml::link('<div class="qingdao-54"></div>',$this->createAbsoluteUrl('/shop/3600'),array('target'=> '_blank')) ?>
				<div class="qingdao-55">
					<div class="zt-con">					
		                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>199977)),array('class'=>'a1','title'=> '1.9kg海鲜大组合礼盒','target'=> '_blank')) ?>
		                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>199971)),array('class'=>'a2','title'=> '1.6kg即食海蜇礼盒','target'=> '_blank')) ?>
					</div>
				</div>
				<div class="qingdao-56">
					<div class="zt-con">					
		                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>199963)),array('class'=>'a1','title'=> '1.2kg天然海蜇礼盒','target'=> '_blank')) ?>
		                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>199960)),array('class'=>'a2','title'=> '1.2kg即食海蜇礼盒','target'=> '_blank')) ?>
		                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>199987)),array('class'=>'a3','title'=> '1.8kg天然海蜇礼盒','target'=> '_blank')) ?>
					</div>
				</div>
				<div class="qingdao-57">
					<div class="zt-con flexslider">
						<ul class="slides">
							<li>
								<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-9-1.png">
		                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>200063)),array('class'=>'a1','title'=> '1.863kg鱼聚福海鱼罐头礼盒','target'=> '_blank')) ?>
		                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>200050)),array('class'=>'a2','title'=> '425g香酥香辣鱼大礼包','target'=> '_blank')) ?>
		                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>200087)),array('class'=>'a3','title'=> '50g紫菜','target'=> '_blank')) ?>
							</li>
							<li>
								<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-9-2.png">
		                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>200026)),array('class'=>'a4','title'=> '618g海鲜酱组合礼盒','target'=> '_blank')) ?>
		                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>200019)),array('class'=>'a5','title'=> '440g海鲜酱组合礼盒','target'=> '_blank')) ?>
		                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>200003)),array('class'=>'a6','title'=> '103g鱼籽酱','target'=> '_blank')) ?>
							</li>
						</ul>			
						<span class="span1">上一页</span>
						<span class="span2">下一页</span>
					</div>
				</div>
		<div class="qingdao-26"></div>
		<div class="qingdao-27"></div>
		<div class="qingdao-28">
			<div class="zt-con flexslider">
				<ul class="slides">
					<li>
						<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-3-1.jpg">
                		<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>66004)),array('class'=>'a1','title'=> '青岛姜丰寿 一级独头黑大蒜','target'=> '_blank')) ?>
                		<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>66010)),array('class'=>'a2','title'=> '青岛姜丰寿 一级独头黑大蒜礼盒','target'=> '_blank')) ?>
					</li>
					<li>
						<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-3-2.jpg">					
                		<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>66011)),array('class'=>'a3','title'=> '青岛姜丰寿 特级独头黑大蒜','target'=> '_blank')) ?>
					</li>
					<li>			
						<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-3-3.jpg">
                		<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>66008)),array('class'=>'a4','title'=> '青岛姜丰寿 一级独头黑大蒜礼盒','target'=> '_blank')) ?>
                		<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>66009)),array('class'=>'a5','title'=> '青岛姜丰寿 一级独头黑大蒜礼盒','target'=> '_blank')) ?>
					</li>
				</ul>			
				<span class="span1">上一页</span>
				<span class="span2">下一页</span>
			</div>
		</div>
		<div class="qingdao-29"></div>
		<div class="qingdao-30">
			<div class="zt-con flexslider">
				<ul class="slides">
					<li>
						<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-4-1.jpg">
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/2407'),array('class'=>'a1','title'=> '慧宝园野生核桃油250ml*2高档礼盒装商务往来专用','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/2407'),array('class'=>'a2','title'=> '慧宝园婴幼儿核桃油野生核桃油 250ml经济装 包邮 孕妇核桃油','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/2407'),array('class'=>'a3','title'=> '慧宝园野生核桃油500ml*2瓶包邮 精美高档礼盒装','target'=> '_blank')) ?>
					</li>
					<li>
						<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-4-2.jpg">
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>78369)),array('class'=>'a4','title'=> '【花姐】                清真羊法排2kg/袋 法式腿羊排羊后腿排羊肉（仅限青岛地区）','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>78401)),array('class'=>'a5','title'=> '【花姐】                清真牛腱肉2.5kg/袋 牛腿肉软硬适中最适合卤味牛肉（仅限青岛地区）','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>78374)),array('class'=>'a6','title'=> '清真牛尾2.5kg/袋 熬汤精品营养丰富牛肉（仅限青岛地区）','target'=> '_blank')) ?>
					</li>
				</ul>			
				<span class="span1">上一页</span>
				<span class="span2">下一页</span>
			</div>
		</div>
                <?php echo CHtml::link('<div class="qingdao-31" id="part1"></div>',$this->createAbsoluteUrl('/shop/2976'),array('target'=> '_blank')) ?>
                <?php echo CHtml::link('<div class="qingdao-32"></div>',$this->createAbsoluteUrl('/shop/2976'),array('target'=> '_blank')) ?>
                <?php echo CHtml::link('<div class="qingdao-33"></div>',$this->createAbsoluteUrl('/shop/2976'),array('target'=> '_blank')) ?>
		<div class="qingdao-34">
			<div class="zt-con flexslider">
				<ul class="slides">
					<li>
						<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-5-1.jpg">
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>182384)),array('class'=>'a1','title'=> '【青岛啤酒】                青岛啤酒出口（美国）小美啤 355ml*24瓶/箱 登州路1厂产  味浓','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>182358)),array('class'=>'a2','title'=> '【青岛啤酒】                青岛啤酒经典1903一厂产 500ml*12瓶/箱','target'=> '_blank')) ?>
					</li>
					<li>					
						<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-5-2.jpg">
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>182338)),array('class'=>'a3','title'=> '【崂山矿泉水】                崂山矿泉水 红矿(精品) 330ml*24瓶/箱','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>182353)),array('class'=>'a4','title'=> '【崂山矿泉水】                崂山矿泉水经典1905 330ml*24瓶/箱','target'=> '_blank')) ?>
					</li>
				</ul>			
				<span class="span1">上一页</span>
				<span class="span2">下一页</span>
			</div>
		</div>
                <?php echo CHtml::link('<div class="qingdao-35"></div>',$this->createAbsoluteUrl('/shop/1722'),array('target'=> '_blank')) ?>
                <?php echo CHtml::link('<div class="qingdao-36"></div>',$this->createAbsoluteUrl('/shop/1722'),array('target'=> '_blank')) ?>
		<div class="qingdao-37">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>82518)),array('class'=>'a1','title'=> '沃林猕猴桃酒-金妍礼盒','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>82383)),array('class'=>'a2','title'=> '沃林蓝莓酒-蓝妍礼盒','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="qingdao-38">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>82403)),array('class'=>'a1','title'=> '沃林蓝莓酒-君沃','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>82401)),array('class'=>'a2','title'=> '沃林蓝莓酒-绅沃礼盒','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>82394)),array('class'=>'a3','title'=> '沃林蓝莓酒-绅沃','target'=> '_blank')) ?>
			</div>
		</div>
                <?php echo CHtml::link('<div class="qingdao-39"></div>',$this->createAbsoluteUrl('/goods/view',array('id'=>82524)),array('target'=> '_blank')) ?>
                <?php echo CHtml::link('<div class="qingdao-40"></div>',$this->createAbsoluteUrl('/goods/view',array('id'=>82524)),array('target'=> '_blank')) ?>

		<div class="qingdao-41">
			<div class="zt-con flexslider">
				<ul class="slides">
					<li>
						<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-6-1.png">
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>83250)),array('class'=>'a1','title'=> '车厘子干120g/桶','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>83255)),array('class'=>'a2','title'=> '芒果干228g/桶','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>83253)),array('class'=>'a3','title'=> '菠萝干228g/桶','target'=> '_blank')) ?>
					</li>
					<li>
						<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-6-2.png">
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>83303)),array('class'=>'a4','title'=> '蓝莓果汁40%礼盒','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>82378)),array('class'=>'a5','title'=> '迷你缤纷美莓礼盒','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>82379)),array('class'=>'a6','title'=> '优先缤纷美莓礼盒','target'=> '_blank')) ?>
					</li>
					<li>
						<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-6-3.png">
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>83265)),array('class'=>'a7','title'=> '猕猴桃果粒酱','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>83264)),array('class'=>'a8','title'=> '蓝莓果粒酱','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>83259)),array('class'=>'a9','title'=> '混合莓干120g/桶','target'=> '_blank')) ?>
					</li>
				</ul>			
				<span class="span1">上一页</span>
				<span class="span2">下一页</span>
			</div>
		</div>
		<div class="qingdao-42" id="part3"></div>
		<div class="qingdao-43"></div>
		<div class="qingdao-44">
			<div class="zt-con flexslider">
				<ul class="slides">
					<li>
						<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-7-1.jpg">
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>73889)),array('class'=>'a1','title'=> '崂山绿茶','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>73900)),array('class'=>'a2','title'=> '崂山绿茶','target'=> '_blank')) ?>
						
					</li>
					<li>
						<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-7-2.jpg">
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>106167)),array('class'=>'a3','title'=> '铁观音(浓香型）','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>106164)),array('class'=>'a4','title'=> '铁观音(清香型）','target'=> '_blank')) ?>
						
					</li>
					<li>
						<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-7-3.jpg">
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>101167)),array('class'=>'a5','title'=> '崂仙韵牌崂山绿茶一级降温茶500g','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>101178)),array('class'=>'a6','title'=> '崂仙韵牌崂山绿茶降温茶500g','target'=> '_blank')) ?>
					</li>
				</ul>			
				<span class="span1">上一页</span>
				<span class="span2">下一页</span>
			</div>
		</div>
		<div class="qingdao-45">
			<div class="zt-con flexslider">
				<ul class="slides">
					<li>
						<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-8-1.png">
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>85324)),array('class'=>'a1','title'=> '蒂芙特DFTA帝芙特 金字塔茶包大听*十五粒装','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>85320)),array('class'=>'a2','title'=> '蒂芙特DFTA帝芙特 金字塔茶包中听*六粒装','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>104526)),array('class'=>'a3','title'=> '金茯茶礼（盒）','target'=> '_blank')) ?>
					</li>
					<li>
						<img src="<?php echo ATTR_DOMAIN?>/zt/qingdao/slider-8-2.png">
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>104542)),array('class'=>'a4','title'=> '生普洱（冰岛）（幼芽）','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>110831)),array('class'=>'a5','title'=> '竹叶青','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>111007)),array('class'=>'a6','title'=> '碧螺春','target'=> '_blank')) ?>
					</li>
				</ul>			
				<span class="span1">上一页</span>
				<span class="span2">下一页</span>
			</div>
		</div>
		<div class="qingdao-46" id="part4"></div>
		<div class="qingdao-47"></div>
		<div class="qingdao-48">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>156459)),array('class'=>'a1','title'=> 'JSK油污清洁剂 油烟净强力去重油污剂 抽油烟机清洗剂 厨房清洁剂 450g','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>156404)),array('class'=>'a2','title'=> 'JSK生物泡沫洗手液450ml*2套装 清洁杀菌抑菌滋润护肤','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>156208)),array('class'=>'a3','title'=> 'JSK女士内裤洗衣液450mlx2套装 内衣洗护液洗涤剂消毒杀菌除异味','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="qingdao-49"></div>
        <?php echo CHtml::link('<div class="qingdao-50" id="part5"></div>',$this->createAbsoluteUrl('/shop/3458'),array('target'=> '_blank')) ?>
        <?php echo CHtml::link('<div class="qingdao-51"></div>',$this->createAbsoluteUrl('/shop/3458'),array('target'=> '_blank')) ?>
		<div class="qingdao-52">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>197751)),array('class'=>'a1','title'=> '团队A线：逛青岛、喝青啤、爬崂山、品清茶青岛一地三日游（太清）成人3-4人成团','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>197953)),array('class'=>'a2','title'=> '团队A线：逛青岛、喝啤酒、爬崂山、品清茶青岛一地三日游（太清）成人5-6人成团','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>197738)),array('class'=>'a3','title'=> '团队A线：逛青岛、喝青啤、爬崂山、品清茶青岛一地三日游（太清）成人1-2人成团','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>198043)),array('class'=>'a4','title'=> '团队B线:环游山东半岛（烟台威海蓬莱青岛崂山）深度四日游 成人5-8人成团','target'=> '_blank')) ?>
			</div>
		</div>
	</div> 

<script type="text/javascript">
	$(function(){
		/*产品轮播*/
		$('.flexslider').flexslider({
			animation: "slide",
			directionNav: true,
			controlNav: false,
			slideshow: false,
			slideshowSpeed: 1000
		});

		var timer = null;
		var onOff = 1;
		timer = setInterval(function(){
			if (onOff) {
				$('.red').show();
				$('.blue').hide();
				onOff=!onOff;
			}
			else{
				$('.blue').show();
				$('.red').hide();
				onOff=!onOff;
			}
		},1000);

		var flag = 1;
		$('.qingdao-30 .flex-next').click(function(){
			if(flag){
				$('.qingdao-29').css({'background':'url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-29-2.jpg)'})
				flag=!flag;
			}
			else{
				$('.qingdao-29').css({'background':'url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-29-1.jpg)'})
				flag=!flag;
			}
		})
		$('.qingdao-30 .flex-prev').click(function(){
			if(flag){
				$('.qingdao-29').css({'background':'url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-29-2.jpg)'})
				flag=!flag;
			}
			else{
				$('.qingdao-29').css({'background':'url(<?php echo ATTR_DOMAIN?>/zt/qingdao/qingdao-29-1.jpg)'})
				flag=!flag;
			}
		})

		// 签到 
		$('.signin').click(function(){
			var isGuest = '<?php echo $this->getUser()->isGuest;?>';
			if(isGuest){
				alert('<?php echo Yii::t("vote","请先登录再签到")?>')
				return false;
			} else{
				var csrf = "<?php echo Yii::app()->request->csrfToken;?>";
				$.post('<?php echo $this->createAbsoluteUrl("/zt/vote/signIn")?>',{YII_CSRF_TOKEN:csrf},function(data){
					alert(data.msg);
				},'json');
			}
		})

	})
</script>