<script src="<?php echo DOMAIN; ?>/js/jquery.flexslider-min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        /*头部广告位关闭*/
        $("#topBanner .close").click(function() {
            $("#topBanner").hide();
        })
        /*购物车列表*/
        $('#myCart').hover(function() {
            $(this).find('.cartList').show();
        }, function() {
            $(this).find('.cartList').delay(3000).hide();
        });
        /*菜单*/
        $("#allMenu").hover(function() {
            $("#menuList02").css('display', 'block');
        }, function() {
            $("#menuList02").css('display', 'none');
        })
        $("#menuList02").hover(function() {
            $(this).css('display', 'block');
        }, function() {
            $(this).css('display', 'none');
        })

        /*gameBanner 轮播*/
        $(".gameFlexslider").flexslider({
            slideshowSpeed: 5000,
            animationSpeed: 400,
            directionNav: false,
            pauseOnHover: true,
            touch: true
        });
        /*底部友情连接显示更多*/
        $("#morefLinks").click(function() {
            if ($(this).hasClass('moreLinks')) {
                $(".friendsLinks").css("height", "auto");
                $(".friendsLinks").css("overflow", " ");
                $("#morefLinks").removeClass("moreLinks").addClass("lessLinks");
            } else {
                $(".friendsLinks").css("height", "20px");
                $(".friendsLinks").css("overflow", "hidden");
                $("#morefLinks").removeClass("lessLinks").addClass("moreLinks");
            }
        })

        /*回到顶部*/
        $("#backTop").click(function() {
            $('body,html').stop().animate({scrollTop: 0}, 500);
            return false;
        });
    })
</script>
<div class="gameBanner">
    <div class="gameFlexslider">
        <ul class="slides">
            <li><img src="../images/temp/game1200X400_01.png" alt="深山逃生" width="1200" height="400"/></li>
            <li><img src="../images/temp/game1200X400_02.png" alt="赛尔号" width="1200" height="400"/></li>
            <li><img src="../images/temp/game1200X400_03.png" alt="神仙道" width="1200" height="400"/></li>
            <li><img src="../images/temp/game1200X400_04.png" alt="三国战记" width="1200" height="400"/></li>
        </ul>
    </div>
    <div class="gameLogin">
        <h3>游戏通行证登录</h3>
        <div class="info">
            <p class="mt10"><input type="text" class="txt" value="用户名"/></p>
            <p class="mt10"><input type="text" class="txt" value="密码"/></p>
            <p class="mt10 forgetPass"><a href="#">忘记登录密码？</a></p>
            <p class="mt10"><input type="button" value="登录" class="btnSubmit"/></p>
            <p class="mt10 chargeCenter"><a href="#">进入充值中心</a></p>
            <p class="mt10"><a href="#" class="btnRegister">免费注册</a></p>
        </div>
    </div>
</div>
<div class="main w1200">
    <div class="recomGame mt10">
        <h3>推荐游戏<span class="en">Recommendation Game </span></h3>
        <ul class="items clearfix">
            <li>
                <a href="#"><img src="../images/temp/game01.jpg" /></a>
                <p class="tit">七十二变</p>
                <p class="orange">角色扮演</p>
                <p class="des">七十二变</p>
            </li>
            <li>
                <a href="#"><img src="../images/temp/game02.jpg" /></a>
                <p class="tit">2012生存记</p>
                <p class="orange">角色扮演</p>
                <p class="des">2012生存记</p>
            </li>
            <li>
                <a href="#"><img src="../images/temp/game03.jpg" /></a>
                <p class="tit">问剑</p>
                <p class="orange">角色扮演</p>
                <p class="des">经典传奇全新微端技术的即时战斗网页游戏</p>
            </li>
            <li>
                <a href="#"><img src="../images/temp/game04.jpg" /></a>
                <p class="tit">war-child</p>
                <p class="orange">角色扮演</p>
                <p class="des">时空逆战，斩断光年</p>
            </li>
            <li>
                <a href="#"><img src="../images/temp/game05.jpg" /></a>
                <p class="tit">战国七雄</p>
                <p class="orange">角色扮演</p>
                <p class="des">战国七雄尽在掌握</p>
            </li>
            <li>
                <a href="#"><img src="../images/temp/game06.jpg" /></a>
                <p class="tit">风华绝代</p>
                <p class="orange">角色扮演</p>
                <p class="des">攻城掠地，打造帝国新纪元</p>
            </li>
            <li>
                <a href="#"><img src="../images/temp/game07.jpg" /></a>
                <p class="tit">幽龙术士</p>
                <p class="orange">角色扮演</p>
                <p class="des">战天斗地，亦魔亦仙！</p>
            </li>
            <li>
                <a href="#"><img src="../images/temp/game08.jpg" /></a>
                <p class="tit">战乱七杀</p>
                <p class="orange">角色扮演</p>
                <p class="des">在武侠世界里,快意恩仇,纵马肆意。</p>
            </li>
        </ul>
    </div>
    <div class="mt10 clearfix">
        <div class="rankList mt10">
            <h3>热门游戏排行</h3>
            <div class="hotList">
                <a href="#" class="clearfix" title="战国七雄"><div class="fl"><i>1</i>战国七雄</div><span>动作</span> </a>
                <a href="#" class="clearfix" title="问剑"><div class="fl"><i>2</i>问剑</div><span>冒险</span> </a>
                <a href="#" class="clearfix" title="七十二变"><div class="fl"><i>3</i>七十二变</div><span>角色</span> </a>
                <a href="#" class="clearfix" title="战乱七杀 "><div class="fl"><i>4</i>战乱七杀</div><span>动作</span> </a>
                <a href="#" class="clearfix" title="幽龙术士"><div class="fl"><i>5</i>幽龙术士 </div><span>冒险</span> </a>
                <a href="#" class="clearfix" title="古代绝色"><div class="fl"><i>6</i>古代绝色</div> <span>角色</span> </a>
                <a href="#" class="clearfix" title="2033仙游记"><div class="fl"><i>7</i>2033仙游记</div><span>动作</span> </a>
                <a href="#" class="clearfix" title="龙族射手"><div class="fl"><i>8</i>龙族射手</div><span>冒险</span> </a>
                <a href="#" class="clearfix" title="魔界传说"><div class="fl"><i>9</i>魔界传说</div> <span>动作</span> </a>
                <a href="#" class="clearfix" title="舞动七月"><div class="fl"><i>10</i>舞动七月</div><span>冒险</span> </a>
            </div>
        </div>		
        <div class="hotGame">
            <h3>热门游戏<span class="en">Hot Game </span></h3>
            <ul class="items clearfix">
                <li>
                    <a href="#"><img src="../images/temp/gameHot216X95_01.jpg" /></a>
                    <p class="tit">魔界传说</p>
                    <a href="#" class="btnPlayGame">进入游戏</a>
                </li>
                <li>
                    <a href="#"><img src="../images/temp/gameHot216X95_02.jpg" /></a>
                    <p class="tit">龙族射手</p>
                    <a href="#" class="btnPlayGame">进入游戏</a>
                </li>
                <li class="mgRig0">
                    <a href="#"><img src="../images/temp/gameHot216X95_03.jpg" /></a>
                    <p class="tit">2033仙游记</p>
                    <a href="#" class="btnPlayGame">进入游戏</a>
                </li>
                <li>
                    <a href="#"><img src="../images/temp/gameHot216X95_04.jpg" /></a>
                    <p class="tit">舞动七月</p>
                    <a href="#" class="btnPlayGame">进入游戏</a>
                </li>
                <li>
                    <a href="#"><img src="../images/temp/gameHot216X95_05.jpg" /></a>
                    <p class="tit">古代绝色</p>
                    <a href="#" class="btnPlayGame">进入游戏</a>
                </li>
                <li class="mgRig0">
                    <a href="#"><img src="../images/temp/gameHot216X95_06.jpg" /></a>
                    <p class="tit">秦时明月</p>
                    <a href="#" class="btnPlayGame">进入游戏</a>
                </li>
            </ul>
        </div>

    </div>
</div>