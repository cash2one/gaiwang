<script src="<?php echo DOMAIN; ?>/js/jquery.flexslider-min.js" type="text/javascript"></script>
<style type="text/css">
	/*=====
	    @Date:2015-06-29
	    @content:幸福的家
		@author:高小明
	 =====*/
	.zt-wrap{width:100%;}
	.zt-con { width:1100px; margin:0 auto; position:relative; }
	.zt-con a{ position:absolute;display:block;}
	.happy-home-01{height:200px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-01.jpg) top center no-repeat;}
	.happy-home-02{height:200px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-02.jpg) top center no-repeat;}
	.happy-home-03{height:200px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-03.jpg) top center no-repeat;}
	.happy-home-04{height:200px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-04.jpg) top center no-repeat;}
	.happy-home-05{height:200px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-05.jpg) top center no-repeat;}
	.happy-home-06{height:200px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-06.jpg) top center no-repeat;}
	.happy-home-07{height:200px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-07.jpg) top center no-repeat;}
	.happy-home-08{height:123px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-08.jpg) top center no-repeat;}
	.happy-home-10{height:263px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-10.jpg) top center no-repeat;}
	.happy-home-12{height:317px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-12.jpg) top center no-repeat;}
	.happy-home-13{height:1131px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-13.jpg) top center no-repeat; position:relative;}
	.happy-home-14{height:238px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-14.jpg) top center no-repeat;}

	.happy-home-15{height:1147px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-15.jpg) top center no-repeat; position:relative;}
	.happy-home-16{height:149px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-16.jpg) top center no-repeat;}
	.happy-home-17{height:1248px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-17.jpg) top center no-repeat; position:relative;}
	.happy-home-18{height:251px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-18.jpg) top center no-repeat;}
	.happy-home-19{height:1271px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-19.jpg) top center no-repeat; position:relative;}
	.happy-home-20{height:286px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-20.jpg) top center no-repeat;}
	.happy-home-21{height:1143px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-21.jpg) top center no-repeat; position:relative;}
	.happy-home-22{height:446px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-22.jpg) top center no-repeat;}
	.happy-home-23{height:250px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-23.jpg) top center no-repeat;}
	.happy-home-24{height:250px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-24.jpg) top center no-repeat;}
	.happy-home-25{height:250px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-25.jpg) top center no-repeat;}
	.happy-home-26{height:250px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-26.jpg) top center no-repeat;}

	.happy-home-09{height:1032px; width:100%; margin:0 auto; position:relative; overflow:hidden;}
	.happy-home-flexslider-01{ position:relative; height:1032px; overflow:hidden;}
	.happy-home-flexslider-01 .slides{ position:relative; z-index:1;}
	.happy-home-flexslider-01 .slides li{ height:1032px; text-align:center; background-position:top center; background-repeat:no-repeat; }
	.happy-home-flexslider-01 .flex-control-nav{ display:none;}
	.happy-home-flexslider-01 .flex-direction-nav{position:absolute; z-index:3; width:1100px; top:355px; left:50%; margin-left:-550px;}
	.happy-home-flexslider-01 .flex-direction-nav li a{display:block; width:55px;height:70px;overflow:hidden; cursor:pointer; position:absolute; z-index:9;}
	.happy-home-flexslider-01 .flex-direction-nav li a.flex-prev{left:0; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pre-next.png) left top no-repeat; opacity:1}
	.happy-home-flexslider-01 .flex-direction-nav li a.flex-next{right:0; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pre-next.png) right top no-repeat; opacity:1}
	.happy-home-flexslider-01 .flex-direction-nav li a.flex-prev:hover,.happy-home-flexslider-01 .flex-direction-nav li a.flex-next:hover{ opacity:0.8;}
	.happy-home-09 .zt-con .a1{ width:103px; height:73px; left:615px; top:519px; z-index:3;}
	.happy-home-09 .zt-con .a1 .happy-home-num{ left:28px; top:-6px; }
	.happy-home-09 .zt-con .a2{ width:81px; height:29px; left:841px; top:444px; z-index:2;}
	.happy-home-09 .zt-con .a2 .happy-home-num{ left:68px; top:6px; }
	.happy-home-09 .zt-con .a3{ width:88px; height:16px; left:509px; top:575px; z-index:3;}
	.happy-home-09 .zt-con .a3 .happy-home-num{ left:68px; top:-13px; }
	.happy-home-09 .zt-con .a4{ width:782px; height:230px; left:270px; top:345px; z-index:1;}
	.happy-home-09 .zt-con .a4 .happy-home-num{ left:761px; top:136px; }
	.happy-home-09 .zt-con .a5{ width:196px; height:218px; left:-12px; top:432px;}
	.happy-home-09 .zt-con .a5 .happy-home-num{ left:133px; top:-3px; }
	.happy-home-09 .zt-con .a6{ width:522px; height:184px; left:237px; top:558px; z-index:2;}
	.happy-home-09 .zt-con .a6 .happy-home-num{ left:506px; top:39px; }
	.happy-home-09 .zt-con .a7{ width:96px; height:77px; left:355px; top:515px; z-index:3;}
	.happy-home-09 .zt-con .a7 .happy-home-num{ left:82px; top:-5px; }
	.happy-home-09 .zt-con .a8{ width:72px; height:72px; left:532px; top:385px; z-index:2;}
	.happy-home-09 .zt-con .a8 .happy-home-num{ left:64px; top:29px; }
	.happy-home-09 .zt-con .a9{ width:283px; height:182px; left:346px; top:363px;}
	.happy-home-09 .zt-con .a9 .happy-home-num{ left:270px; top:-8px; }
	.happy-home-09 .zt-con .a10{ width:407px; height:142px; left:281px; top:536px;}
	.happy-home-09 .zt-con .a10 .happy-home-num{ left:331px; top:19px; }
	.happy-home-09 .zt-con .a11{ width:227px; height:325px; left:680px; top:354px;}
	.happy-home-09 .zt-con .a11 .happy-home-num{ left:206px; top:-7px; }

	.happy-home-10 a{ width:224px; height:71px; top:18px; left:68px;}
	.happy-home-10 .a2{ left:294px; width:235px;}
	.happy-home-10 .a3{ left:532px; width:210px;}
	.happy-home-10 .a4{ left:744px; width:238px;}
	.happy-home-10 .a5{ left:68px; width:224px; top:92px;}
	.happy-home-10 .a6{ left:294px; width:235px; top:92px;}
	.happy-home-10 .a7{ left:532px; width:210px; top:92px;}
	.happy-home-10 .a8{ left:744px; width:238px; top:92px;}

	.happy-home-11{height:1186px; width:100%; margin:0 auto; position:relative; overflow:hidden;}
	.happy-home-flexslider-02{ position:relative; height:1186px; overflow:hidden;}
	.happy-home-flexslider-02 .slides{ position:relative; z-index:1;}
	.happy-home-flexslider-02 .slides li{ height:1186px; text-align:center; background-position:top center; background-repeat:no-repeat; }
	.happy-home-flexslider-02 .flex-control-nav{ display:none;}
	.happy-home-flexslider-02 .flex-direction-nav{position:absolute; z-index:3; width:1100px; top:355px; left:50%; margin-left:-550px;}
	.happy-home-flexslider-02 .flex-direction-nav li a{display:block; width:55px;height:70px;overflow:hidden; cursor:pointer; position:absolute; z-index:9;}
	.happy-home-flexslider-02 .flex-direction-nav li a.flex-prev{left:0; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pre-next.png) left top no-repeat; opacity:1}
	.happy-home-flexslider-02 .flex-direction-nav li a.flex-next{right:0; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pre-next.png) right top no-repeat; opacity:1}
	.happy-home-flexslider-02 .flex-direction-nav li a.flex-prev:hover,.happy-home-flexslider-02 .flex-direction-nav li a.flex-next:hover{ opacity:0.8;}
	.happy-home-11 .zt-con .a1{ width:213px; height:130px; left:34px; top:219px;}
	.happy-home-11 .zt-con .a1 .happy-home-num{ left:197px; top:10px; }
	.happy-home-11 .zt-con .a2{ width:516px; height:316px; left:388px; top:547px; z-index:2;}
	.happy-home-11 .zt-con .a2 .happy-home-num{ left:256px; top:142px; }
	.happy-home-11 .zt-con .a3{ width:326px; height:238px; left:307px; top:385px; z-index:1;}
	.happy-home-11 .zt-con .a3 .happy-home-num{ left:60px; top:88px; }
	.happy-home-11 .zt-con .a4{ width:138px; height:110px; left:604px; top:546px; z-index:5;}
	.happy-home-11 .zt-con .a4 .happy-home-num{ left:83px; top:-4px; }
	.happy-home-11 .zt-con .a5{ width:36px; height:45px; left:750px; top:582px; z-index:5;}
	.happy-home-11 .zt-con .a5 .happy-home-num{ left:25px; top:-3px; }
	.happy-home-11 .zt-con .a6{ width:48px; height:28px; left:467px; top:450px; z-index:3;}
	.happy-home-11 .zt-con .a6 .happy-home-num{ left:14px; top:-5px; }
	.happy-home-11 .zt-con .a7{ width:30px; height:63px; left:428px; top:413px; z-index:3;}
	.happy-home-11 .zt-con .a7 .happy-home-num{ left:7px; top:-5px }
	.happy-home-11 .zt-con .a8{ width:16px; height:50px; left:399px; top:426px; z-index:2;}
	.happy-home-11 .zt-con .a8 .happy-home-num{ left:0; top:-5px; }
	.happy-home-11 .zt-con .a9{ width:23px; height:53px; left:378px; top:424px; z-index:2;}
	.happy-home-11 .zt-con .a9 .happy-home-num{ left:2px; top:-5px; }
	.happy-home-11 .zt-con .a10{ width:17px; height:68px; left:352px; top:410px; z-index:2;}
	.happy-home-11 .zt-con .a10 .happy-home-num{ left:0; top:-5px; }
	.happy-home-11 .zt-con .a11{ width:57px; height:64px; left:288px; top:413px; z-index:2;}
	.happy-home-11 .zt-con .a11 .happy-home-num{ left:15px; top:-5px; }
	.happy-home-11 .zt-con .a12{ width:418px; height:640px; left:208px; top:179px; z-index:1;}
	.happy-home-11 .zt-con .a12 .happy-home-num{ left:130px; top:100px; }

	.happy-home-12 a{ width:181px; height:72px; top:11px; left:105px;}
	.happy-home-12 .a2{ left:289px; width:195px;}
	.happy-home-12 .a3{ left:486px; width:167px;}
	.happy-home-12 .a4{ left:656px; width:195px;}
	.happy-home-12 .a5{ left:854px; width:166px;}
	.happy-home-12 .a6{ width:181px; height:72px; left:105px; top:85px;}
	.happy-home-12 .a7{ left:289px; width:195px; top:85px;}
	.happy-home-12 .a8{ left:486px; width:167px; top:85px;}
	.happy-home-12 .a9{ left:656px; width:195px; top:85px;}
	.happy-home-12 .a10{ left:854px; width:166px; top:85px;}
	.happy-home-12 .a11{ width:181px; height:72px; left:105px; top:156px;}
	.happy-home-12 .a12{ left:289px; width:195px; top:156px;}
	.happy-home-12 .a13{ left:486px; width:167px; top:156px;}

	.happy-home-13 .zt-con .a1{ width:93px; height:313px; left:586px; top:341px;}
	.happy-home-13 .zt-con .a1 .happy-home-num{ left:37px; top:-1px; }
	.happy-home-13 .zt-con .a2{ width:98px; height:317px; left:916px; top:444px;}
	.happy-home-13 .zt-con .a2 .happy-home-num{ left:68px; top:20px; }
	.happy-home-13 .zt-con .a3{ width:80px; height:110px; left:319px; top:421px; }
	.happy-home-13 .zt-con .a3 .happy-home-num{ left:59px; top:0; }
	.happy-home-13 .zt-con .a4{ width:60px; height:42px; left:750px; top:599px;}
	.happy-home-13 .zt-con .a4 .happy-home-num{ left:50px; top:11px; }
	.happy-home-13 .zt-con .a5{ width:72px; height:88px; left:100px; top:550px;}
	.happy-home-13 .zt-con .a5 .happy-home-num{ left:25px; top:-3px; }
	.happy-home-13 .zt-con .a6{ width:105px; height:125px; left:787px; top:456px;}
	.happy-home-13 .zt-con .a6 .happy-home-num{ left:14px; top:-5px; }
	.happy-home-13 .zt-con .a7{ width:70px; height:42px; left:678px; top:596px;}
	.happy-home-13 .zt-con .a7 .happy-home-num{ left:40px; top:-5px }
	.happy-home-13 .zt-con .a8{ width:65px; height:65px; left:177px; top:552px;}
	.happy-home-13 .zt-con .a8 .happy-home-num{ left:37px; top:11px; }

	.happy-home-14 a{ width:224px; height:71px; top:13px; left:83px;}
	.happy-home-14 .a2{ left:308px; width:235px;}
	.happy-home-14 .a3{ left:547px; width:214px;}
	.happy-home-14 .a4{ left:760px; width:238px;}
	.happy-home-14 .a5{ left:83px; width:224px; top:87px;}
	.happy-home-14 .a6{ left:308px; width:235px; top:87px;}
	.happy-home-14 .a7{ left:547px; width:214px; top:87px;}
	.happy-home-14 .a8{ left:760px; width:238px; top:87px;}

	.happy-home-15 .zt-con .a1{ width:384px; height:246px; left:642px; top:450px; z-index:1;}
	.happy-home-15 .zt-con .a1 .happy-home-num{ left:37px; top:-1px; }
	.happy-home-15 .zt-con .a2{ width:417px; height:556px; left:47px; top:266px; z-index:1;}
	.happy-home-15 .zt-con .a2 .happy-home-num{ left:68px; top:20px; }
	.happy-home-15 .zt-con .a3{ width:55px; height:29px; left:897px; top:450px; z-index:3;}
	.happy-home-15 .zt-con .a3 .happy-home-num{ left:59px; top:0; }
	.happy-home-15 .zt-con .a4{ width:57px; height:37px; left:279px; top:521px; z-index:2;}
	.happy-home-15 .zt-con .a4 .happy-home-num{ left:50px; top:11px; }
	.happy-home-15 .zt-con .a5{ width:56px; height:38px; left:760px; top:440px; z-index:3;}
	.happy-home-15 .zt-con .a5 .happy-home-num{ left:25px; top:-3px; }
	.happy-home-15 .zt-con .a6{ width:60px; height:28px; left:383px; top:576px; z-index:3;}
	.happy-home-15 .zt-con .a6 .happy-home-num{ left:14px; top:-5px; }
	.happy-home-15 .zt-con .a7{ width:122px; height:81px; left:797px; top:402px; z-index:2;}
	.happy-home-15 .zt-con .a7 .happy-home-num{ left:40px; top:-5px }
	.happy-home-15 .zt-con .a8{ width:48px; height:27px; left:660px; top:454px; z-index:2;}
	.happy-home-15 .zt-con .a8 .happy-home-num{ left:37px; top:11px; }

	.happy-home-16 a{ width:181px; height:72px; top:4px; left:93px;}
	.happy-home-16 .a2{ left:277px; width:195px;}
	.happy-home-16 .a3{ left:474px; width:167px;}
	.happy-home-16 .a4{ left:644px; width:195px;}
	.happy-home-16 .a5{ left:842px; width:166px;}

	.happy-home-17 .zt-con .a1{ width:59px; height:97px; left:854px; top:510px; }
	.happy-home-17 .zt-con .a1 .happy-home-num{ left:44px; top:-7px; }
	.happy-home-17 .zt-con .a2{ width:57px; height:60px; left:822px; top:595px;}
	.happy-home-17 .zt-con .a2 .happy-home-num{ left:28px; top:0; }
	.happy-home-17 .zt-con .a3{ width:320px; height:497px; left:22px; top:381px;}
	.happy-home-17 .zt-con .a3 .happy-home-num{ left:59px; top:0; }
	.happy-home-17 .zt-con .a4{ width:85px; height:60px; left:458px; top:544px; z-index:2;}
	.happy-home-17 .zt-con .a4 .happy-home-num{ left:50px; top:11px; }
	.happy-home-17 .zt-con .a5{ width:74px; height:99px; left:458px; top:455px; z-index:1;}
	.happy-home-17 .zt-con .a5 .happy-home-num{ left:25px; top:-3px; }
	.happy-home-17 .zt-con .a6{ width:37px; height:84px; left:983px; top:566px;}
	.happy-home-17 .zt-con .a6 .happy-home-num{ left:14px; top:-5px; }
	.happy-home-17 .zt-con .a7{ width:81px; height:48px; left:742px; top:601px;}
	.happy-home-17 .zt-con .a7 .happy-home-num{ left:40px; top:-5px }

	.happy-home-18 a{ width:224px; height:71px; top:29px; left:81px;}
	.happy-home-18 .a2{ left:306px; width:235px;}
	.happy-home-18 .a3{ left:545px; width:212px;}
	.happy-home-18 .a4{ left:758px; width:238px;}
	.happy-home-18 .a5{ left:81px; width:224px; top:103px;}
	.happy-home-18 .a6{ left:306px; width:235px; top:103px;}
	.happy-home-18 .a7{ left:545px; width:212px; top:103px;}
	.happy-home-18 .a8{ left:758px; width:238px; top:103px;}

	.happy-home-19 .zt-con .a1{ width:175px; height:56px; left:297px; top:571px; }
	.happy-home-19 .zt-con .a1 .happy-home-num{ left:100px; top:18px; }
	.happy-home-19 .zt-con .a2{ width:86px; height:86px; left:152px; top:533px;}
	.happy-home-19 .zt-con .a2 .happy-home-num{ left:57px; top:14px; }
	.happy-home-19 .zt-con .a3{ width:44px; height:37px; left:481px; top:581px;}
	.happy-home-19 .zt-con .a3 .happy-home-num{ left:32px; top:9px; }
	.happy-home-19 .zt-con .a4{ width:62px; height:51px; left:468px; top:736px;}
	.happy-home-19 .zt-con .a4 .happy-home-num{ left:34px; top:8px; }
	.happy-home-19 .zt-con .a5{ width:54px; height:65px; left:91px; top:721px;}
	.happy-home-19 .zt-con .a5 .happy-home-num{ left:28px; top:-3px; }
	.happy-home-19 .zt-con .a6{ width:45px; height:78px; left:46px; top:706px;}
	.happy-home-19 .zt-con .a6 .happy-home-num{ left:41px; top:-5px; }
	.happy-home-19 .zt-con .a7{ width:80px; height:78px; left:297px; top:710px;}
	.happy-home-19 .zt-con .a7 .happy-home-num{ left:68px; top:-5px }
	.happy-home-19 .zt-con .a8{ width:50px; height:50px; left:422px; top:741px;}
	.happy-home-19 .zt-con .a8 .happy-home-num{ left:15px; top:-5px }
	.happy-home-19 .zt-con .a9{ width:26px; height:60px; left:142px; top:720px;}
	.happy-home-19 .zt-con .a9 .happy-home-num{ left:3px; top:-5px }
	.happy-home-19 .zt-con .a10{ width:103px; height:66px; left:53px; top:552px;}
	.happy-home-19 .zt-con .a10 .happy-home-num{ left:58px; top:4px }
	.happy-home-19 .zt-con .a11{ width:52px; height:96px; left:245px; top:523px;}
	.happy-home-19 .zt-con .a11 .happy-home-num{ left:39px; top:11px }
	.happy-home-19 .zt-con .a12{ width:25px; height:74px; left:194px; top:710px;}
	.happy-home-19 .zt-con .a12 .happy-home-num{ left:2px; top:4px }
	.happy-home-19 .zt-con .a13{ width:32px; height:74px; left:243px; top:710px;}
	.happy-home-19 .zt-con .a13 .happy-home-num{ left:6px; top:4px }
	.happy-home-19 .zt-con .a14{ width:25px; height:74px; left:220px; top:710px;}
	.happy-home-19 .zt-con .a14 .happy-home-num{ left:2px; top:4px }
	.happy-home-19 .zt-con .a15{ width:24px; height:74px; left:171px; top:710px;}
	.happy-home-19 .zt-con .a15 .happy-home-num{ left:2px; top:4px }

	.happy-home-20 a{ width:181px; height:72px; top:4px; left:80px;}
	.happy-home-20 .a2{ left:264px; width:195px;}
	.happy-home-20 .a3{ left:460px; width:167px;}
	.happy-home-20 .a4{ left:630px; width:195px;}
	.happy-home-20 .a5{ left:828px; width:166px;}
	.happy-home-20 .a6{ width:181px; height:72px; left:80px; top:78px;}
	.happy-home-20 .a7{ left:264px; width:195px; top:78px;}
	.happy-home-20 .a8{ left:460px; width:167px; top:78px;}
	.happy-home-20 .a9{ left:630px; width:195px; top:78px;}
	.happy-home-20 .a10{ left:828px; width:166px; top:78px;}
	.happy-home-20 .a11{ width:181px; height:72px; left:80px; top:152px;}
	.happy-home-20 .a12{ left:264px; width:195px; top:152px;}
	.happy-home-20 .a13{ left:460px; width:167px; top:152px;}
	.happy-home-20 .a14{ left:630px; width:195px; top:152px;}
	.happy-home-20 .a15{ left:828px; width:166px; top:152px;}

	.happy-home-21 .zt-con .a1{ width:453px; height:340px; left:66px; top:499px; z-index:1;}
	.happy-home-21 .zt-con .a1 .happy-home-num{ left:128px; top:95px; }
	.happy-home-21 .zt-con .a2{ width:327px; height:388px; left:674px; top:301px; z-index:1; }
	.happy-home-21 .zt-con .a2 .happy-home-num{ left:213px; top:61px; }
	.happy-home-21 .zt-con .a3{ width:246px; height:264px; left:233px; top:463px; z-index:2;}
	.happy-home-21 .zt-con .a3 .happy-home-num{ left:160px; top:58px; }
	.happy-home-21 .zt-con .a4{ width:170px; height:154px; left:882px; top:581px; z-index:3;}
	.happy-home-21 .zt-con .a4 .happy-home-num{ left:70px; top:40px; }
	.happy-home-21 .zt-con .a5{ width:78px; height:86px; left:172px; top:489px; z-index:3; }
	.happy-home-21 .zt-con .a5 .happy-home-num{ left:52px; top:24px; }
	.happy-home-21 .zt-con .a6{ width:233px; height:131px; left:696px; top:665px; z-index:2;}
	.happy-home-21 .zt-con .a6 .happy-home-num{ left:159px; top:76px; }
	.happy-home-21 .zt-con .a7{ width:233px; height:184px; left:478px; top:652px; z-index:3;}
	.happy-home-21 .zt-con .a7 .happy-home-num{ left:175px; top:54px; }

	.happy-home-22 a{ width:224px; height:71px; top:5px; left:92px;}
	.happy-home-22 .a2{ left:317px; width:235px;}
	.happy-home-22 .a3{ left:556px; width:212px;}
	.happy-home-22 .a4{ left:769px; width:238px;}
	.happy-home-22 .a5{ left:92px; width:224px; top:77px;}
	.happy-home-22 .a6{ left:317px; width:235px; top:77px;}

	.happy-home-23 .a1{ width:964px; height:309px; top:0; left:70px;}
	.happy-home-24 .a1{ width:964px; height:230px; top:63px; left:70px;}
	.happy-home-25 .a1{ width:528px; height:309px; top:48px; left:70px;}
	.happy-home-25 .a2{ width:433px; height:309px; top:48px; left:598px;}


	.happy-home-big-img-show-01{ width:967px; height:284px;  position:absolute; z-index:2; top:718px; left:50%; margin-left:-483px; background:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-big-img-show-01.png) right top no-repeat; overflow:hidden;}
	.happy-home-big-img-show-01 .show{ display:block; width:950px; height:194px; position:absolute; right:2px; top:72px; overflow:hidden; }
	.happy-home-big-img-show-02{ width:964px; height:284px;  position:absolute; z-index:2; top:894px; left:50%; margin-left:-482px; overflow:hidden;}
	.happy-home-big-img-show-02 .show{ display:block; width:964px; height:284px; position:absolute; right:0; top:0; overflow:hidden; }
	.happy-home-big-img-show-03{ width:964px; height:284px;  position:absolute; z-index:2; top:818px; left:50%; margin-left:-482px; overflow:hidden;}
	.happy-home-big-img-show-03 .show{ display:block; width:964px; height:284px; position:absolute; right:0; top:0; overflow:hidden; }
	.happy-home-big-img-show-04{ width:961px; height:283px;  position:absolute; z-index:2; top:814px; left:50%; margin-left:-480px; overflow:hidden;}
	.happy-home-big-img-show-04 .show{ display:block; width:961px; height:283px; position:absolute; right:0; top:0; overflow:hidden; }
	.happy-home-big-img-show-05{ width:961px; height:283px;  position:absolute; z-index:2; top:948px; left:50%; margin-left:-480px; overflow:hidden;}
	.happy-home-big-img-show-05 .show{ display:block; width:961px; height:283px; position:absolute; right:0; top:0; overflow:hidden; }
	.happy-home-big-img-show-06{ width:961px; height:283px;  position:absolute; z-index:2; top:948px; left:50%; margin-left:-480px; overflow:hidden;}
	.happy-home-big-img-show-06 .show{ display:block; width:961px; height:283px; position:absolute; right:0; top:0; overflow:hidden; }
	.happy-home-big-img-show-07{ width:961px; height:283px;  position:absolute; z-index:2; top:814px; left:50%; margin-left:-480px; overflow:hidden;}
	.happy-home-big-img-show-07 .show{ display:block; width:961px; height:283px; position:absolute; right:0; top:0; overflow:hidden; }

	@keyframes glow{
	    0% {
	       opacity:0;     
	    }
	    100% {
			opacity:1;    
	    }
	}
	.happy-home-num{ display:block; height:18px; width:18px; line-height:18px; border-radius:18px; color:#000; border:1px solid #000; background:#fff; text-align:center; font-style:normal; position:absolute; left:0; top:0; animation:glow 1s infinite alternate ease-in-out; }
</style>
<div class="zt-wrap">
	<div class="happy-home-01"></div>
	<div class="happy-home-02"></div>			
	<div class="happy-home-03"></div>
	<div class="happy-home-04"></div>
	<div class="happy-home-05"></div>
	<div class="happy-home-06"></div>
	<div class="happy-home-07"></div>
	<div class="happy-home-08"></div>
	<div class="happy-home-09" id="happy-home-09">
		<div class="happy-home-flexslider-01">
			<ul class="slides">
				<li style="background-image:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-09-01.jpg);">
					<div class="zt-con">
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),1),$this->createAbsoluteUrl('/goods/view',array('id'=>'122741')),array('class'=>'a1','target'=>'_blank', 'data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-09-01.jpg','title'=>'【人情味】茶香礼盒1号'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),2),$this->createAbsoluteUrl('/goods/view',array('id'=>'101323')),array('class'=>'a2','target'=>'_blank', 'data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-09-02.jpg','title'=>'盖航数码电子 小米（MI）7.9英寸平板 WIFI 64GB 白色'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),3),$this->createAbsoluteUrl('/goods/view',array('id'=>'127539')),array('class'=>'a3','target'=>'_blank', 'data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-09-03.jpg','title'=>'【华为】华为（HUAWEI）P8 青春移动4G标配版 手机【艳洋数码】'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),4),$this->createAbsoluteUrl('/goods/view',array('id'=>'101004')),array('class'=>'a4','target'=>'_blank', 'data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-09-04.jpg','title'=>'进口中厚皮沙发多功能真皮客厅组合沙发 储物皮艺沙发'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),5),$this->createAbsoluteUrl('/goods/view',array('id'=>'68441')),array('class'=>'a5','target'=>'_blank','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-09-05.jpg' ,'title'=>'【御品工匠】高档实木杂志架 中式报刊架 报纸架 展示架 现代简约书报架 书架层架 K0482'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),6),$this->createAbsoluteUrl('/goods/view',array('id'=>'45508')),array('class'=>'a6','target'=>'_blank','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-09-06.jpg' ,'title'=>'【俬游记】爱尚家具 俬游记 北美水曲柳 木蜡油涂料 天然火烧岩实木茶几 TT001'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),7),$this->createAbsoluteUrl('/goods/view',array('id'=>'142332')),array('class'=>'a7','target'=>'_blank','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-09-07.jpg' ,'title'=>'【新兴茶庄】新茶 特级 正宗武夷山大红袍 茶叶'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),8),$this->createAbsoluteUrl('/goods/view',array('id'=>'97507')),array('class'=>'a8','target'=>'_blank','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-09-08.jpg' ,'title'=>'艾益生随身灸温灸仪悬灸仪汉灸仪艾灸盒艾灸仪'))?>
					</div>
				</li>
				<li style="background-image:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-09-02.jpg);">
					<div class="zt-con">
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),9),$this->createAbsoluteUrl('/goods/view',array('id'=>'47172')),array('class'=>'a9','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-09-09.jpg','target'=>'_blank', 'title'=>'Skyworth/创维55寸 8核4K酷开系统智能液晶电视平板电视 土豪金  a353'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),11),$this->createAbsoluteUrl('/goods/view',array('id'=>'46583')),array('class'=>'a10','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-09-11.jpg' ,'target'=>'_blank','title'=>'爱尚家具 俬游记 北美水曲柳 木蜡油涂料 实木天然火烧岩电视柜'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),10),$this->createAbsoluteUrl('/goods/view',array('id'=>'45566')),array('class'=>'a11','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-09-10.jpg' ,'target'=>'_blank','title'=>'【俬游记】爱尚家具 俬游记 北美水曲柳 木蜡油涂料 实木装饰柜 TVH002'))?>
						
					</div>
				</li>
			</ul>
			<div class="happy-home-big-img-show-01" id="happy-home-show-09">
				<?php echo CHtml::link(CHtml::tag('img',array('src'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-09-01.jpg')),$this->createAbsoluteUrl('/goods/view',array('id'=>'122741')),array('class'=>'show','title'=>'【人情味】茶香礼盒1号','target'=>'_blank'))?>

			</div>
		</div>
	</div>

	<div class="happy-home-10">
		<div class="zt-con">
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'12460','id'=>'1933')),array('class'=>'a1','title'=>'闽侯县青口赫山韵茗茶店','target'=>'_blank'))?>				
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15660','id'=>'678')),array('class'=>'a2','title'=>'爱尚家居','target'=>'_blank'))?>				
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15677','id'=>'1016')),array('class'=>'a3','title'=>'艳洋数码','target'=>'_blank'))?>				
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15676','id'=>'1065')),array('class'=>'a4','title'=>'安吉递铺','target'=>'_blank'))?>				
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15700','id'=>'194')),array('class'=>'a5','title'=>'创士诺','target'=>'_blank'))?>				
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/122741'),array('class'=>'a6','title'=>'【人情味】茶香礼盒1号','target'=>'_blank'))?>				
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/1662'),array('class'=>'a7','title'=>'上海百秘健康科技有限公司','target'=>'_blank'))?>				
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15696','id'=>'1062')),array('class'=>'a8','title'=>'大连市西岗区名美办公设备商行','target'=>'_blank'))?>				

		</div>
	</div>
	<div class="happy-home-11" id="happy-home-11">
		<div class="happy-home-flexslider-02">
			<ul class="slides">
				<li style="background-image:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-11-01.jpg);">
					<div class="zt-con">
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),1),$this->createAbsoluteUrl('/goods/view',array('id'=>'93873')),array('class'=>'a1','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-11-01.jpg','title'=>'海尔无氟变频壁挂式空调 1.5P海尔薄翼超薄双智能变频空调，阿里小智&海尔U+强强联手，打造全网第一台超薄双智能空调；14.8cm超薄机身，一体化无接缝设计，薄出真时尚；智能云控制，人机交互打造健康生态圈；23分贝超静音，静享舒适生活；1分钟速冷。','target'=>'_blank'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),2),$this->createAbsoluteUrl('/goods/view',array('id'=>'91748')),array('class'=>'a2','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-11-02.jpg','title'=>'全棉四件套-欧时力蓝','target'=>'_blank'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),3),$this->createAbsoluteUrl('/goods/view',array('id'=>'64814')),array('class'=>'a3','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-11-03.jpg','title'=>'欧式床 高端大气上档次','target'=>'_blank'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),4),$this->createAbsoluteUrl('/goods/view',array('id'=>'112882')),array('class'=>'a4','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-11-04.jpg','title'=>'【苗市电脑】华硕（ASUS）VM590L4510 15.6英寸笔记本 I7 4510U GT840M','target'=>'_blank'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),5),$this->createAbsoluteUrl('/goods/view',array('id'=>'101581')),array('class'=>'a5','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-11-05.jpg','title'=>'盖航数码电子 Huawei/华为荣耀6 H60-L02 八核智能手机16G 新品国行 联通版(黑色/白色)','target'=>'_blank'))?>
						
					</div>
				</li>
				<li style="background-image:url(<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-11-02.jpg);">
					<div class="zt-con">
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),6),$this->createAbsoluteUrl('/goods/view',array('id'=>'105441')),array('class'=>'a6','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-11-06.jpg','title'=>'正品贝妮美肌芦荟胶300ml(2起包邮） 舒缓补水保湿祛痘 晒后修复褪红 可抹伤口','target'=>'_blank'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),7),$this->createAbsoluteUrl('/goods/view',array('id'=>'57777')),array('class'=>'a7','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-11-07.jpg','title'=>'法国专柜正品 Bioderma/贝德玛卸妆水500ml 两款可选 （舒妍，净妍）','target'=>'_blank'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),8),$this->createAbsoluteUrl('/goods/view',array('id'=>'83678')),array('class'=>'a8','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-11-08.jpg','title'=>'美妍名品 葡萄柚精油10ml 排毒利尿消脂塑体控油收缩毛孔单方精油','target'=>'_blank'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),9),$this->createAbsoluteUrl('/goods/view',array('id'=>'132589')),array('class'=>'a9','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-11-09.jpg','title'=>'【麻麻爱】        高地薰衣草精油5ml 保加利亚进口 舒压助眠 淡化痘印 祛退疤痕 驱虫抑菌 家庭必备 包邮','target'=>'_blank'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),10),$this->createAbsoluteUrl('/goods/view',array('id'=>'134821')),array('class'=>'a10','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-11-10.jpg','title'=>'丽琪尔 Le Légier焕颜紧致爽肤水 120ml 爽肤 精华水 紧致抗皱 抗衰老','target'=>'_blank'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),11),$this->createAbsoluteUrl('/goods/view',array('id'=>'69845')),array('class'=>'a11','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-11-11.jpg','title'=>'丽姿生物 fibroin蚕丝蛋白面膜贴 美白补水抗皱紧致 祛斑抗衰老','target'=>'_blank'))?>
						<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),12),$this->createAbsoluteUrl('/goods/view',array('id'=>'121813')),array('class'=>'a12','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-11-12.jpg','title'=>'梳妆台520-2','target'=>'_blank'))?>
						
					</div>
				</li>
			</ul>
			<div class="happy-home-big-img-show-02" id="happy-home-show-11">
				<?php echo CHtml::link(CHtml::tag('img',array('src'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-11-01.jpg')),$this->createAbsoluteUrl('/goods/view',array('id'=>'93873')),array('class'=>'show','title'=>'海尔无氟变频壁挂式空调 1.5P海尔薄翼超薄双智能变频空调，阿里小智&海尔U+强强联手，打造全网第一台超薄双智能空调；14.8cm超薄机身，一体化无接缝设计，薄出真时尚；智能云控制，人机交互打造健康生态圈；23分贝超静音，静享舒适生活；1分钟速冷。','target'=>'_blank'))?>
				
			</div>
		</div>
	</div>
	<div class="happy-home-12">
		<div class="zt-con">
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/1837'),array('class'=>'a1','title'=>'比蒂家纺家居店','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/2001'),array('class'=>'a2','title'=>'昌福家纺','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15558','id'=>'23')),array('class'=>'a3','title'=>'宅享家居','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/2095'),array('class'=>'a4','title'=>'西安利健健康护理旗舰店','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/2586'),array('class'=>'a5','title'=>'昌隽羊胚胎美妆旗舰店','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15117','id'=>'1082')),array('class'=>'a6','title'=>'瞬道贸易','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'6575','id'=>'1352')),array('class'=>'a7','title'=>'广东丽姿生物科技有限公司','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15605','id'=>'1579')),array('class'=>'a8','title'=>'美妍名品','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'11379','id'=>'2091')),array('class'=>'a9','title'=>'宏佳商贸','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'9977','id'=>'1743')),array('class'=>'a10','title'=>'生活日记电器','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'14531','id'=>'1084')),array('class'=>'a11','title'=>'瑞琪儿','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15560','id'=>'1091')),array('class'=>'a12','title'=>'东润美华木业','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15684','id'=>'1957')),array('class'=>'a13','title'=>'汇购电器商城','target'=>'_blank'))?>	
			
		</div>
	</div>
	<div class="happy-home-13" id="happy-home-13">
		<div class="zt-con">
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),1),$this->createAbsoluteUrl('/goods/view',array('id'=>'92643')),array('class'=>'a1','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-13-01.jpg','title'=>'试衣镜全身镜 简约欧式穿衣镜挂壁式落地镜','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),2),$this->createAbsoluteUrl('/goods/view',array('id'=>'140586')),array('class'=>'a2','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-13-02.jpg','title'=>'Eupa/灿坤 蒸汽挂烫机 挂式电熨斗 家用熨衣服 TSK-7729HZ 厂家直发 正品保障','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),3),$this->createAbsoluteUrl('/goods/view',array('id'=>'125714')),array('class'=>'a3','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-13-03.jpg','title'=>'雷洛世都新款夏季男装条纹短袖T恤 纯棉免烫条纹圆领修身T恤 男LT5217','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),4),$this->createAbsoluteUrl('/goods/view',array('id'=>'128505')),array('class'=>'a4','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-13-04.jpg','title'=>'15夏季新男女情侣全透气休闲鞋 超轻时尚慢跑鞋全网面防滑运动鞋男','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),5),$this->createAbsoluteUrl('/goods/view',array('id'=>'116889')),array('class'=>'a5','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-13-05.jpg','title'=>'【2014冬季】热销新款韩版时尚女士水桶毛球单肩斜跨软面女包','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),6),$this->createAbsoluteUrl('/goods/view',array('id'=>'123088')),array('class'=>'a6','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-13-06.jpg','title'=>'【阮杭服饰】2015夏装新款女式宽松大码真丝t恤中年妈妈装薄款短袖','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),7),$this->createAbsoluteUrl('/goods/view',array('id'=>'136572')),array('class'=>'a7','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-13-07.jpg','title'=>'侨兰圣菲2015女鞋新款潮春夏尖头平底鞋浅口单鞋春季韩版女鞋LQ1526','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),8),$this->createAbsoluteUrl('/goods/view',array('id'=>'86403')),array('class'=>'a8','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-13-08.jpg','title'=>'【爱国仕】全国包邮贝壳包水波纹女包简约单肩真皮包包女式欧美潮斜挎手提包','target'=>'_blank'))?>
		</div>	
		<div class="happy-home-big-img-show-03" id="happy-home-show-13">
			<?php echo CHtml::link(CHtml::tag('img',array('src'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-13-01.jpg')),$this->createAbsoluteUrl('/goods/view',array('id'=>'92643')),array('class'=>'show','title'=>'试衣镜全身镜 简约欧式穿衣镜挂壁式落地镜','target'=>'_blank'))?>

		</div>
	</div>
	<div class="happy-home-14">
		<div class="zt-con">	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/1893'),array('class'=>'a1','title'=>'金圣马商务男装','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/1869'),array('class'=>'a2','title'=>'路伊梵旗舰店','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'12779','id'=>'999')),array('class'=>'a3','title'=>'POKER HOUSE','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'14553','id'=>'2646')),array('class'=>'a4','title'=>'侨兰圣菲','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/2506'),array('class'=>'a5','title'=>'雷洛世都旗舰店','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'13927','id'=>'1956')),array('class'=>'a6','title'=>'爵伦仕服饰','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15672','id'=>'1733')),array('class'=>'a7','title'=>'爱国仕箱包','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15380','id'=>'1475')),array('class'=>'a8','title'=>'阮杭服饰','target'=>'_blank'))?>	

		</div>
	</div>
	<div class="happy-home-15" id="happy-home-15">
		<div class="zt-con">
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),1),$this->createAbsoluteUrl('/goods/view',array('id'=>'45531')),array('class'=>'a1','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-15-01.jpg','title'=>'俬游记】 爱尚家具 俬游记 北美水曲柳 木蜡油涂料 实木书桌','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),2),$this->createAbsoluteUrl('/goods/view',array('id'=>'110715')),array('class'=>'a2','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-15-02.jpg','title'=>'含姗亚JS1212#书柜','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),3),$this->createAbsoluteUrl('/goods/view',array('id'=>'118479')),array('class'=>'a3','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-15-03.jpg','title'=>'【LOGO数码】小米移动电源 10400毫安 大容量 通用型移动手机充电宝充电器"','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),4),$this->createAbsoluteUrl('/goods/view',array('id'=>'116843')),array('class'=>'a4','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-15-04.jpg','title'=>'【齐平数码】Casio/卡西欧 EX-100 EX100自拍神器 数码相机 正品货行顺丰包邮','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),5),$this->createAbsoluteUrl('/goods/view',array('id'=>'89282')),array('class'=>'a5','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-15-05.jpg','title'=>'【数码之家】爽目电脑护眼仪-2015款，情人节礼物、春节礼品、防电脑视疲劳、防蓝光无频闪 笔记本-香槟金 爽目电脑护眼仪，用了都说好！香槟金/贵妃灰色 二色可选','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),6),$this->createAbsoluteUrl('/goods/view',array('id'=>'64007')),array('class'=>'a6','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-15-06.jpg','title'=>'【数码之家】普耐尔S6四核 学习机 平板电脑 小学初中高中 学生电脑点读机词典','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),7),$this->createAbsoluteUrl('/goods/view',array('id'=>'70844')),array('class'=>'a7','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-15-07.jpg','title'=>'【万锋】华硕Asus V451LN4510 14英寸游戏本（i7-4510u 750+7200转 4G内存 4g显卡）多彩轻薄，游戏机皇同样可以时尚清新7200rpm硬盘，较普通物理硬盘读取速度提升33%！','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),8),$this->createAbsoluteUrl('/goods/view',array('id'=>'123895')),array('class'=>'a8','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-15-08.jpg','title'=>'【  华为】        【互联通讯】华为手机Mate7  电信4G版（曜石黑）','target'=>'_blank'))?>
		</div>
		<div class="happy-home-big-img-show-04" id="happy-home-show-15">
			<?php echo CHtml::link(CHtml::tag('img',array('src'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-15-01.jpg')),$this->createAbsoluteUrl('/goods/view',array('id'=>'45531')),array('class'=>'show','title'=>'【俬游记】 爱尚家具 俬游记 北美水曲柳 木蜡油涂料 实木书桌','target'=>'_blank'))?>

		</div>
	</div>
	<div class="happy-home-16">
		<div class="zt-con">
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15371','id'=>'1844')),array('class'=>'a1','title'=>'LOGO数码','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/2026'),array('class'=>'a2','title'=>'齐平电子经营部','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15678','id'=>'976')),array('class'=>'a3','title'=>'数码之家','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'3765','id'=>'567')),array('class'=>'a4','title'=>'广州万锋','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15726','id'=>'1362')),array('class'=>'a5','title'=>'匠艺百年','target'=>'_blank'))?>	

		</div>
	</div>
	<div class="happy-home-17" id="happy-home-17">
		<div class="bg-01"></div>
		<div class="bg-02"></div>
		<div class="zt-con">
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),1),$this->createAbsoluteUrl('/goods/view',array('id'=>'79190')),array('class'=>'a1','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-17-01.jpg','title'=>'笛梵】1958 意大利 笛梵DIFO 香氛魅惑沐浴露美国费洛蒙香型300*2套盒','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),2),$this->createAbsoluteUrl('/goods/view',array('id'=>'116161')),array('class'=>'a2','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-17-02.jpg','title'=>'欲颜加木瓜先天愈合精油皂','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),3),$this->createAbsoluteUrl('/goods/view',array('id'=>'56751')),array('class'=>'a3','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-17-03.jpg','title'=>'【最新爆款】【全场包邮】美丽雅猎手平板旋转甩水拖把 平板甩水二合一 HC053588','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),4),$this->createAbsoluteUrl('/goods/view',array('id'=>'101355')),array('class'=>'a4','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-17-04.jpg','title'=>'{包邮}日本进口 花王乐而雅瞬吸干爽棉柔护翼F系列卫生巾 全面透气 绵柔亲夫40cm 7枚装','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),5),$this->createAbsoluteUrl('/goods/view',array('id'=>'56077')),array('class'=>'a5','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-17-05.jpg','title'=>'尚美 施华蔻羊绒脂滋养修护尊享套装','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),6),$this->createAbsoluteUrl('/goods/view',array('id'=>'60364')),array('class'=>'a6','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-17-06.jpg','title'=>'韩国Dongkook Dental Project漱口水250ml清新口气杀菌去口臭 新包装','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),7),$this->createAbsoluteUrl('/goods/view',array('id'=>'112201')),array('class'=>'a7','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-17-07.jpg','title'=>'100%纯棉毛巾套装 城市漫步三件套','target'=>'_blank'))?>
		</div>
		<div class="happy-home-big-img-show-05" id="happy-home-show-17">
			<?php echo CHtml::link(CHtml::tag('img',array('src'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-17-01.jpg')),$this->createAbsoluteUrl('/goods/view',array('id'=>'79190')),array('class'=>'show','title'=>'【笛梵】        1958 意大利 笛梵DIFO 香氛魅惑沐浴露美国费洛蒙香型300*2套盒','target'=>'_blank'))?>

		</div>
	</div>
	<div class="happy-home-18">
		<div class="zt-con">
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15370','id'=>'1328')),array('class'=>'a1','title'=>'意大利笛梵（DIFO）旗舰店','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/2028'),array('class'=>'a2','title'=>'欲颜加商贸','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'11612','id'=>'1742')),array('class'=>'a3','title'=>'圣黛雅添正品PAPA专卖店','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'3951','id'=>'431')),array('class'=>'a4','title'=>'毛毛虫商贸','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15667','id'=>'1147')),array('class'=>'a5','title'=>'得の屋旗舰店','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'4405','id'=>'1022')),array('class'=>'a6','title'=>'尚美缤纷化妆品店','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15693','id'=>'1013')),array('class'=>'a7','title'=>'鑫荣晶日用品店','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15849','id'=>'1814')),array('class'=>'a8','title'=>'威海市恒隆进出口有限公司','target'=>'_blank'))?>	

		</div>
	</div>
	<div class="happy-home-19">
		<div class="happy-home-19" id="happy-home-19">
			<div class="zt-con">
				<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),1),$this->createAbsoluteUrl('/goods/view',array('id'=>'66181')),array('class'=>'a1','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-19-01.jpg','title'=>'JOHN BOSS 炫彩锅具两件套 熟铁不粘锅 炒锅30cm汤锅22cm tp3022','target'=>'_blank'))?>
				<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),2),$this->createAbsoluteUrl('/goods/view',array('id'=>'66818')),array('class'=>'a2','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-19-02.jpg','title'=>'JOHN BOSS 蒸英雄多功能蒸锅 HG-2611Z 双层特价','target'=>'_blank'))?>
				<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),3),$this->createAbsoluteUrl('/goods/view',array('id'=>'81576')),array('class'=>'a3','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-19-03.jpg','title'=>'荣事达净洗机 RSD-S60A 正品包邮 降解瓜果、蔬菜表面残留农药、去除肉类食品中的各种激素、添加剂等功效。','target'=>'_blank'))?>
				<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),4),$this->createAbsoluteUrl('/goods/view',array('id'=>'52269')),array('class'=>'a4','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-19-04.jpg','title'=>'宁安堡中宁枸杞贡果礼盒装送礼首选460g','target'=>'_blank'))?>
				<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),5),$this->createAbsoluteUrl('/goods/view',array('id'=>'74270')),array('class'=>'a5','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-19-05.jpg','title'=>'柒号名品 台湾进口 三点一刻 美式浓缩咖啡 二合一速溶咖啡84克*3盒','target'=>'_blank'))?>
				<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),6),$this->createAbsoluteUrl('/goods/view',array('id'=>'91157')),array('class'=>'a6','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-19-06.jpg','title'=>'黑加仑葡萄干新疆特产纯天然特级无核大提子干零食干果260g','target'=>'_blank'))?>
				<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),7),$this->createAbsoluteUrl('/goods/view',array('id'=>'69057')),array('class'=>'a7','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-19-07.jpg','title'=>'【包邮】2014五常稻花香大米5kg东北大米非转基因大米新米无抛光','target'=>'_blank'))?>
				<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),8),$this->createAbsoluteUrl('/goods/view',array('id'=>'111756')),array('class'=>'a8','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-19-08.jpg','title'=>'【买二送一】 包邮 农家自制五谷 红豆薏米粉1000g营养低卡代餐粉饱腹','target'=>'_blank'))?>
				<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),9),$this->createAbsoluteUrl('/goods/view',array('id'=>'87241')),array('class'=>'a9','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-19-09.jpg','title'=>'【攀枝花】浓香型白酒青花瓷陈酿','target'=>'_blank'))?>
				<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),10),$this->createAbsoluteUrl('/goods/view',array('id'=>'69698')),array('class'=>'a10','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-19-10.jpg','title'=>'【虎牌】        虎牌电饭煲 TIGER/虎牌 JBA-A10C 智能预约定时电饭锅全面加热 3L','target'=>'_blank'))?>
				<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),11),$this->createAbsoluteUrl('/goods/view',array('id'=>'70686')),array('class'=>'a11','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-19-11.jpg','title'=>'上新啦！100%正品九阳多功能料理/榨汁/豆浆机 全国联保','target'=>'_blank'))?>
				<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),12),$this->createAbsoluteUrl('/goods/view',array('id'=>'54573')),array('class'=>'a12','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-19-12.jpg','title'=>'52°五粮液酒 500ml','target'=>'_blank'))?>
				<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),13),$this->createAbsoluteUrl('/goods/view',array('id'=>'52372')),array('class'=>'a13','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-19-13.jpg','title'=>'【茅台】 53°飞天茅台酒 500ml','target'=>'_blank'))?>
				<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),14),$this->createAbsoluteUrl('/goods/view',array('id'=>'85957')),array('class'=>'a14','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-19-14.jpg','title'=>'泸州老窖52度高度酒 小酒版 白酒特价 鉴赏级酒品 整箱（30瓶）包邮','target'=>'_blank'))?>
				<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),15),$this->createAbsoluteUrl('/goods/view',array('id'=>'85954')),array('class'=>'a15','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-19-15.jpg','title'=>'泸州老窖 52度白酒 鉴赏级酒品 精酿 裸瓶 12瓶整箱','target'=>'_blank'))?>
			</div>
			<div class="happy-home-big-img-show-06" id="happy-home-show-19">
				<?php echo CHtml::link(CHtml::tag('img',array('src'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-19-01.jpg')),$this->createAbsoluteUrl('/goods/view',array('id'=>'66181')),array('class'=>'show','title'=>'JOHN BOSS 炫彩锅具两件套 熟铁不粘锅 炒锅30cm汤锅22cm tp3022','target'=>'_blank'))?>

			</div>
		</div>
	</div>
	<div class="happy-home-20">
		<div class="zt-con">	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'5926','id'=>'372')),array('class'=>'a1','title'=>'泽东贸易','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'8690','id'=>'1649')),array('class'=>'a2','title'=>'卡拉卡微店','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15449','id'=>'2237')),array('class'=>'a3','title'=>'天美时净化专家','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'2667','id'=>'496')),array('class'=>'a4','title'=>'深圳市众鑫网土特产有限公司','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15600','id'=>'1456')),array('class'=>'a5','title'=>'柒号名品','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15656','id'=>'1927')),array('class'=>'a6','title'=>'林小妹铺子','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/1342'),array('class'=>'a7','title'=>'一家老店','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/934'),array('class'=>'a8','title'=>'半岛集团-凯利华食品（香港）有限公司','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'12266','id'=>'1949')),array('class'=>'a9','title'=>'上海馋味食品有限公司','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15679','id'=>'1070')),array('class'=>'a10','title'=>'至信虎牌专卖店','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'11702','id'=>'2137')),array('class'=>'a11','title'=>'迈享酒窖','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15682','id'=>'247')),array('class'=>'a12','title'=>'速腾贸易','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15701','id'=>'2205')),array('class'=>'a13','title'=>'风语顺','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'7061','id'=>'1376')),array('class'=>'a14','title'=>'魔方网络','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/1700'),array('class'=>'a15','title'=>'攀西特产店','target'=>'_blank'))?>	


		</div>
	</div>
	<div class="happy-home-21" id="happy-home-21">
		<div class="zt-con">
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),1),$this->createAbsoluteUrl('/goods/view',array('id'=>'139902')),array('class'=>'a1','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-21-01.jpg','title'=>'迪士尼 冰丝凉席婴儿凉席宝宝卡通凉席学生凉席单人凉席童床凉席','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),2),$this->createAbsoluteUrl('/goods/view',array('id'=>'6513')),array('class'=>'a2','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-21-02.jpg','title'=>'【如宝】        美国ZOOPER（如宝）婴儿手推车 SL800E春意','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),3),$this->createAbsoluteUrl('/goods/view',array('id'=>'142224')),array('class'=>'a3','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-21-03.jpg','title'=>'粉红色连衣裙','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),4),$this->createAbsoluteUrl('/goods/view',array('id'=>'91547')),array('class'=>'a4','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-21-04.jpg','title'=>'爱玩宝贝 乐高得宝式大颗粒拼插塑料积木玩具 儿童益智玩具创意礼物 开心牧场','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),5),$this->createAbsoluteUrl('/goods/view',array('id'=>'54279')),array('class'=>'a5','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-21-05.jpg','title'=>'飘飘龙玩偶泰迪熊 结婚礼物毛绒玩具 美式情侣熊70cm（下单请备注男款或者女款）二选一','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),6),$this->createAbsoluteUrl('/goods/view',array('id'=>'11802')),array('class'=>'a6','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-21-06.jpg','title'=>'日本原单切水果玩具 切切乐 过家家蔬菜磁性切切看334-12','target'=>'_blank'))?>
			<?php echo CHtml::link(CHtml::tag('i',array('class'=>'happy-home-num'),7),$this->createAbsoluteUrl('/goods/view',array('id'=>'109790')),array('class'=>'a7','data-img'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-21-07.jpg','title'=>'遥控工程车','target'=>'_blank'))?>
			
		</div>
		<div class="happy-home-big-img-show-07" id="happy-home-show-21">
			<?php echo CHtml::link(CHtml::tag('img',array('src'=>'<?php echo ATTR_DOMAIN;?>/zt/happy-home/happy-home-pro-21-01.jpg')),$this->createAbsoluteUrl('/goods/view',array('id'=>'139902')),array('class'=>'show','title'=>'迪士尼 冰丝凉席婴儿凉席宝宝卡通凉席学生凉席单人凉席童床凉席','target'=>'_blank'))?>

		</div>
	</div>
	<div class="happy-home-22">
		<div class="zt-con">
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15484','id'=>'58')),array('class'=>'a1','title'=>'珠海德费雅贸易有限公司','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'7639','id'=>'999')),array('class'=>'a2','title'=>'POKER HOUSE','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'7662','id'=>'55')),array('class'=>'a3','title'=>'始信贸易','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15550','id'=>'962')),array('class'=>'a4','title'=>'凤巢精品屋','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15551','id'=>'102')),array('class'=>'a5','title'=>'汕头市澄海区兆盛服饰商行','target'=>'_blank'))?>	
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/shop/product',array('cid'=>'15530','id'=>'308')),array('class'=>'a6','title'=>'科奇玩具','target'=>'_blank'))?>	

		</div>
	</div>
	<div class="happy-home-23">
		<div class="zt-con">
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>'80495')),array('class'=>'a1','title'=>'尊享港澳四天三晚双人品质游 6月30号前使用有效','target'=>'_blank'))?>					
		</div>
	</div>
	<div class="happy-home-24">
		<div class="zt-con">
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>'86917')),array('class'=>'a1','title'=>'深港澳珠5天4夜游','target'=>'_blank'))?>					
		</div>
	</div>
	<div class="happy-home-25">
		<div class="zt-con">
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>'129864')),array('class'=>'a1','title'=>'车载 空气净化器 家居 电脑 负离子 除甲醛 除二手 烟味 异味 迷你 USB 厂家直销一件代发','target'=>'_blank'))?>					
			<?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>'65877')),array('class'=>'a2','title'=>'JOHN BOSS诺亚舟旅行壶套装 户外运动壶1500ml+运动毛巾 真空保温','target'=>'_blank'))?>					

		</div>
	</div>
	<div class="happy-home-26"></div>
</div>  
<script type="text/javascript">
	/*本专题需要引入的js*/
	$(function(){
		$(".happy-home-flexslider-01").flexslider({
			slideshowSpeed: 500000,
			animationSpeed: 400, 
			directionNav: true, 
			pauseOnHover: true,
			touch: true 
		});
		
		$(".happy-home-flexslider-02").flexslider({
			slideshowSpeed: 500000,
			animationSpeed: 400, 
			directionNav: true, 
			pauseOnHover: true,
			touch: true 
		});
		
		$("#happy-home-09 .zt-con a").hover(function(){
			var href = $(this).attr('href');
			var title = $(this).attr('title');
			var imghref = $(this).attr('data-img');
			$("#happy-home-show-09 a").attr('href',href);
			$("#happy-home-show-09 a").attr('title',title);
			$("#happy-home-show-09 a img").attr('src',imghref);
		})
		
		$("#happy-home-11 .zt-con a").hover(function(){
			var href = $(this).attr('href');
			var title = $(this).attr('title');
			var imghref = $(this).attr('data-img');
			$("#happy-home-show-11 a").attr('href',href);
			$("#happy-home-show-11 a").attr('title',title);
			$("#happy-home-show-11 a img").attr('src',imghref);
		})
		$("#happy-home-13 .zt-con a").hover(function(){
			var href = $(this).attr('href');
			var title = $(this).attr('title');
			var imghref = $(this).attr('data-img');
			$("#happy-home-show-13 a").attr('href',href);
			$("#happy-home-show-13 a").attr('title',title);
			$("#happy-home-show-13 a img").attr('src',imghref);
		})
		$("#happy-home-15 .zt-con a").hover(function(){
			var href = $(this).attr('href');
			var title = $(this).attr('title');
			var imghref = $(this).attr('data-img');
			$("#happy-home-show-15 a").attr('href',href);
			$("#happy-home-show-15 a").attr('title',title);
			$("#happy-home-show-15 a img").attr('src',imghref);
		})
		$("#happy-home-17 .zt-con a").hover(function(){
			var href = $(this).attr('href');
			var title = $(this).attr('title');
			var imghref = $(this).attr('data-img');
			$("#happy-home-show-17 a").attr('href',href);
			$("#happy-home-show-17 a").attr('title',title);
			$("#happy-home-show-17 a img").attr('src',imghref);
		})
		$("#happy-home-19 .zt-con a").hover(function(){
			var href = $(this).attr('href');
			var title = $(this).attr('title');
			var imghref = $(this).attr('data-img');
			$("#happy-home-show-19 a").attr('href',href);
			$("#happy-home-show-19 a").attr('title',title);
			$("#happy-home-show-19 a img").attr('src',imghref);
		})
		$("#happy-home-21 .zt-con a").hover(function(){
			var href = $(this).attr('href');
			var title = $(this).attr('title');
			var imghref = $(this).attr('data-img');
			$("#happy-home-show-21 a").attr('href',href);
			$("#happy-home-show-21 a").attr('title',title);
			$("#happy-home-show-21 a img").attr('src',imghref);
		})
	})
</script>