<?php
//Cache::setRecommendedCache();
//图片延迟加载

// Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/lazyLoad.js');
?>


<!--//图片延迟加载-->
<!-- 
<script type="text/javascript">
    $(function() {
        LAZY.init();
        LAZY.run();
    });
</script> -->
<script type="text/javascript">
    /*banner 轮播*/
    
    $(window).scroll(function() {
        var url = '/festive/AjaxProduct';
        var code = $(this).attr("data-code");
        var scrollTop = $(this).scrollTop();
        var scrollHeight = $(document).height();
        var windowHeight = $(this).height();
        var num = $('#content li').length;
        var lock = true;
        if ($(this).scrollTop() + $(window).height() == $(document).height()) {
            if (num < 300) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: url,
                    data: {code: code, YII_CSRF_TOKEN: "<?php echo Yii::app()->request->csrfToken ?>", id: num},
                    success: function(data) {
                        if (data) {
                            $("#content").empty();
                            for (i = 0; i < data.length; i++) {
                                var name = data[i]['name']
                                var id = data[i]['id']
                                
                                var img = "<?php echo ATTR_DOMAIN.'/';?>" +data[i]['picture']
                                var html = "<li class='ending'><p class='grabEnd grabEnd2'></p><p class='time'><span>00天00时00分00秒</span></p><a class='itemImg' href='#'><img width='380' height='285' alt='' src='" + img + "' /></a>\n\
                                <p class='name clearfix'><span class='txtl'>" + name + "</span></p></li>"
                                $("#content").append(html);
                            }
                            LAZY.init();
                            LAZY.run();

                        } else {

                        }
                    }
                });
}
}
});

</script>


<div class="main">
    <!-- 秒杀活动大广告图 -->
    
    <div class="spikeBanner" id="spikeBanner">
        <div class="flexslider01">
            <ul class="slides">
              <?php
              
              $picAdvert = isset($picAdvert[0]) ? $picAdvert: array();
              if (!empty($picAdvert)):
                ?>
            <?php foreach ($picAdvert as $a): ?>
                <?php if (AdvertPicture::isValid($a['start_time'], $a['end_time'])): ?>
                    <li style="background:<?php echo isset($a['background'])?$a['background']:'#000'; ?>;"><a href="<?php echo $a['link'] ?>" target="_blank"><span><img src="<?php echo ATTR_DOMAIN . '/' . $a['picture'] ?>" width="1200" height="440"></span></a></li>
                    
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif ?>

    </ul>
</div>
</div>


</div>
<!-- 秒杀活动大广告图结束 -->
<div class="clear"></div>

<div class="spikeProducts">
    <?php if (!empty($pmComing)) { ?>
    <div class="spikeprcd">
        <p class="title clearfix">
            <span class="txtl">正在进行的拍卖活动</span>
            <span class="txtr">惊喜不断</span>
        </p>
        <ul class="clearfix">
            <?php foreach ($pmComing as $k => $v) {
                $url = 'festive/detail';
                if( isset($v['category_id']) && $v['category_id'] == ActivityData::ACTIVE_AUCTION){
                    $url = 'auction/index';
                }
            ?>
            <li>
                <?php if($v['status'] == AuctionData::AUCTION_ACTIVE_STATUS_THREE):?>
                    <p class="time"><span class="settime" type ='pmgoing' endTime="<?php echo $v['time']; ?>"></span></p>
                <?php elseif($v['status'] == AuctionData::AUCTION_ACTIVE_STATUS_TWO):?>     
                    <p class="time"><span class="settime" type ='upgoing' endTime="<?php echo $v['time']; ?>"></span></p>
                <?php endif;?>
                <a class="itemImg" target="_blank" href="<?php echo $v['link']?$v['link']:str_replace('.html', '', $this->createAbsoluteUrl($url,array('id'=>$v['id'])));?>">
                    <img width="380" height="285" alt="" class="lazy" src="<?php echo ATTR_DOMAIN . '/' . $v['picture'] ; ?>" />

                </a>
                <p class="name clearfix">
                    <span class="txtl"><?php echo $v['name']; ?></span>
                    <span class="txtr" style="width: 86px;"><?php echo $v['remark'];?></span>                                
                </p>
            </li>
            <?php } ?>

        </ul>
    </div>
    <?php } ?>
    <?php if (!empty($ongoing)) { ?>
    <div class="spikeprcd">
        <p class="title clearfix">
            <span class="txtl">正在进行的其他活动</span>
            <span class="txtr">惊喜不断</span>
        </p>
        <ul class="clearfix">
            <?php foreach ($ongoing as $k => $v) {
                $url = 'festive/detail';
                if( isset($v['category_id']) && $v['category_id'] == ActivityData::ACTIVE_AUCTION){
                    $url = 'auction/index';
                }
            ?>
            <li>
                <p class="time"><span class="settime" type ='going' endTime="<?php echo $v['time']; ?>"></span></p>
                <a class="itemImg" target="_blank" href="<?php echo $v['link']?$v['link']:str_replace('.html', '', $this->createAbsoluteUrl($url,array('id'=>$v['id'])));?>">
                    <img width="380" height="285" alt="" class="lazy" src="<?php echo ATTR_DOMAIN . '/' . $v['picture'] ; ?>" />

                </a>
                <p class="name clearfix">
                    <span class="txtl"><?php echo $v['name']; ?></span>
                    <span class="txtr" style="width: 86px;"><?php echo $v['remark'];?></span>
                </p>
            </li>
            <?php } ?>

        </ul>
    </div>
    <?php } ?>
    <?php if (!empty($upComing)) { ?>
    <div class="spikeprcd">
        <p class="title clearfix">
            <span class="txtl">即将推出的活动</span>
            <span class="txtr">更多惊喜</span>
        </p>
        <ul class="clearfix">
            <?php foreach ($upComing as $k => $v) {
                $url = 'festive/detail';
                if( isset($v['category_id']) && $v['category_id'] == ActivityData::ACTIVE_AUCTION){
                    $url = 'auction/index';
                }
            ?>
            <li>
                <p class="time"><span class="settime" type='coming' endTime="<?php echo $v['time']; ?>"  time="<?php echo time(); ?>"> </span></p>
                <a class="itemImg" target="_blank" href="<?php echo str_replace('.html', '', $this->createAbsoluteUrl($url,array('id'=>$v['id'])));?>">
                 <img width="380" height="285" alt=""  class="lazy" src="<?php echo ATTR_DOMAIN . '/' . $v['picture'] ; ?>" />
             </a>

             <p class="name clearfix">
                <span class="txtl"><?php echo $v['name']; ?></span>
                <span class="txtr" style="width: 86px;"><?php echo $v['remark'];?></span>
            </p>
        </li>
        <?php } ?>
    </ul>
</div>
<?php } ?>
<?php if (!empty($over)) { ?>
<div class="spikeprcd">
    <p class="title clearfix">
        <span class="txtl">致我们逝去的活动</span>
        <span class="txtr"> 值得回味</span>
    </p>
    <ul class="clearfix" id="content">
        <?php foreach ($over as $k => $v) { ?>
        <li class="ending">
            <p class="grabEnd grabEnd2"></p>
            <p class="time"><span>00天00时00分00秒</span></p>
            <a class="itemImg" href="#">
                <img width="380" height="285" alt=""  class="lazy" src="<?php echo ATTR_DOMAIN . '/' . $v['picture'] ; ?>" />
            </a>
            <p class="name clearfix">
                <span class="txtl"><?php echo $v['name']; ?> </span>
            </p>
        </li>
        <?php } ?>


    </ul>
</div>
<?php } ?>

<div class="h50"></div>
</div>



</div>
<script language="javascript">
    $(function() {
        updateEndTime();
    });
//倒计时函数
function updateEndTime()
{
    // var date = new Date();
    //     var time = date.getTime();  //当前时间距1970年1月1日之间的毫秒数

        $(".settime").each(function(i) {
            var endTime = this.getAttribute("endTime")
            var lag = endTime; 
            var endTime = this.getAttribute("endTime")-1; //结束时间字符串
            //转换为时间日期类型
            // var endDate1 = eval('new Date(' + endDate.replace(/\d+(?=-[^-]+$)/, function(a) {
            //     return parseInt(a, 10) - 1;
            // }).match(/\d+/g) + ')');

            // var endTime = endDate1.getTime(); //结束时间毫秒数
            $(this).attr('endTime',endTime)
            //当前时间和结束时间之间的秒数
            // alert(lag);
            var type= this.getAttribute('type');

            if (lag > 0)
            {
                var second = Math.floor(lag % 60);
                var minite = Math.floor((lag / 60) % 60);
                var hour = Math.floor((lag / 3600) % 24);
                var day = Math.floor((lag / 3600) / 24);
                if(type=='going' || type == 'pmgoing'){
                    $(this).html('仅剩'+ day + "天" + hour + "小时" + minite + "分" + second + "秒");
                }
                if(type == 'coming' || type == 'upgoing')
                    $(this).html(day + "天" + hour + "小时" + minite + "分" + second + "秒 开始");
            }
            else{
                // $(this).parent('li').remove();
                window.location.reload();
            }
        });
setTimeout("updateEndTime()", 1000);
}
</script>