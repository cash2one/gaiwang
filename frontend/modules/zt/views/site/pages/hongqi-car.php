
<?php $this->pageTitle = "红旗汽车_" . $this->pageTitle;?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>红旗汽车</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->theme->baseUrl.'/'; ?>styles/swiper.min.css">

    <!-- Demo styles -->
    <script type="text/javascript">
    //隐藏头尾部
    $(function(){
        $('.gx-top-title,.gx-top-logoSearch,.gx-nav,.gx-bottom').hide();
    });
     </script>
<style>	
  html, body {position: relative; height: 100%; background-color: #000;}
    body {margin: 0; padding: 0;}
    .swiper-container {
        width: 100%;
        height: 100%;
        margin-left: auto;
        margin-right: auto;
    }
    .swiper-slide {
    	position: relative;
        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
    .swiper-slide img{width: 1900px; height: 980px;}
    .backHomepage{width: 295px; height: 148px; display: block; background:url(<?php echo ATTR_DOMAIN;?>/zt/hongqi-car/backHomepage.png) no-repeat; position: absolute; left: 6%; bottom: 6%;}
    </style>
</head>
<body>
    <!-- Swiper -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="<?php echo ATTR_DOMAIN;?>/zt/hongqi-car/hongqi-car-01.jpg" alt='红旗汽车'></div>
            <div class="swiper-slide"><img src="<?php echo ATTR_DOMAIN;?>/zt/hongqi-car/hongqi-car-02.jpg" alt='红旗汽车'></div>
            <div class="swiper-slide"><img src="<?php echo ATTR_DOMAIN;?>/zt/hongqi-car/hongqi-car-03.jpg" alt='红旗汽车'></div>
            <div class="swiper-slide"><img src="<?php echo ATTR_DOMAIN;?>/zt/hongqi-car/hongqi-car-04.jpg" alt='红旗汽车'></div>
            <div class="swiper-slide"><img src="<?php echo ATTR_DOMAIN;?>/zt/hongqi-car/hongqi-car-05.jpg" alt='红旗汽车'></div>
            <div class="swiper-slide">
            	<img src="<?php echo ATTR_DOMAIN;?>/zt/hongqi-car/hongqi-car-06.jpg" alt='红旗汽车'>
            	<a class="backHomepage" href="http://www.g-emall.com/"></a>
            </div>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        
    </div>
	
	<script src="<?php echo $this->theme->baseUrl.'/'; ?>js/jquery-1.9.1.js"></script>
    <!-- Swiper JS -->
    <script src="<?php echo $this->theme->baseUrl.'/'; ?>js/swiper.jquery.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        direction: 'vertical',
        slidesPerView: 1,
        paginationClickable: true,
        /*spaceBetween: 30,*/
        mousewheelControl: true
    });
    </script>
</body>
</html>