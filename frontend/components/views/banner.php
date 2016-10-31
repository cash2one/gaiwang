<?php
//店铺首页 幻灯展示
Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/jquery.flexslider-min.js')
?>
<style type="text/css">
    /* flexslider */
    #banner{ width:100%; height:415px; margin:0 auto; position:relative; overflow:hidden;}
    #banner{ position:relative; height:415px; background:url(/images/bgs/loading.gif) 50% no-repeat; overflow:hidden;}
    #banner .slides{ position:relative; z-index:1;}
    #banner .slides li{ height:415px; text-align:center; }
    #banner .flex-control-nav{ position:absolute; bottom:16px; z-index:2; text-align:center; left:50%; margin-left:-50px;}
    #banner .flex-control-nav li{display:inline; width:14px; height:14px; margin:0 5px; float:left;  }
    #banner .flex-control-nav a{display:block; width:12px; height:12px; border:1px solid #c83253; border-radius:6px; overflow:hidden; cursor:pointer; font-size:0; _background:#000;}
    #banner .flex-control-nav .flex-active,#banner .flex-control-nav a:hover { background:#c83253;  }
    #banner .flex-direction-nav{display:none; }
    #banner .slides li a{ display:block; position:relative; width:100%; margin:0 auto; }
    #banner .slides li a img{ width:1200px; margin:0 auto;}
</style>
<div class="bannerSlide02 editor" id="banner">
    <ul class="slides">
        <?php foreach($data as $k=> $v): ?>
        <li>
            <?php
            $title = isset($v['Title']) ? $v['Title'] : $k + 1 ;
            $imgUrl = substr($v['ImgUrl'],0,5)=='files'?$v['ImgUrl']:'files/'.$v['ImgUrl'];
            $img = CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $imgUrl,'c_fill,h_415,w_1200'),$title);
            echo CHtml::link($img,$v['Link'],array('target'=>'_blank')) ?>
        </li>
        <?php endforeach; ?>
    </ul>
</div>
<script type="text/javascript">
    /*banner 轮播*/
    $("#banner").flexslider({
        slideshowSpeed: 5000,
        animationSpeed: 400,
        directionNav: true,
        pauseOnHover: true,
        touch: true
    });
</script>