
<!-- NAVBAR -->
<div class="app-navbar">
    <a href="#" class="nav-logo"><img src="<?php echo DOMAIN; ?>/images/bgs/logo.png" width="215" height="85" alt="盖象商城"></a>
    <div class="app-nav">
        <ul class="nav-items clearfix">
            <li class="nav-item selected"><?php echo CHtml::link(Yii::t('appMain','首页'), $this->createAbsoluteUrl('/'),array('class'=>'nav-link')); ?></li>
            <li class="nav-item"><a href="#app-gemall" class="nav-link">盖象优选APP</a></li>
            <li class="nav-item"><a href="#app-gpay" class="nav-link">盖付通</a></li>
            <li class="nav-item"><a href="#group-app" class="nav-link">盖掌柜</a></li>
            <li class="nav-item"><a href="#more" class="nav-link">更多</a></li>
            <li class="nav-item"><?php echo CHtml::link(Yii::t('appMain','联系我们'), $this->createAbsoluteUrl('/contact'),array('class'=>'nav-link')); ?></li>
        </ul>
    </div>
    <div class="appbg1"></div>
</div>
<!-- END NAVBAR -->
<!-- 盖象商城客户端 -->
<a name="app-gemall"></a>
<div class="app-container app-gemall">
    <h2 class="appname cd2"><img src="<?php echo DOMAIN; ?>/images/bgs/app-gemall-logo.jpg" width="170" height="50" alt="盖象商城">移动端<em class="app-version comment-red">1.0</em></h2>
    <div class="app-content ml65">
        <div class="app-box clearfix">
            <h3 class="app-box-tit ml65">电脑下载</h3>
            <?php if(!empty($gxIosUrl)): ?>
            <a class="btn-download btn-red ml65 hvr-icon-spin" href="<?php echo $gxIosUrl ?>"><i class="ios"></i><p>iPhone</p><p>苹果版下载</p></a>
            <?php else: ?>
                <a class="btn-download btn-red ml65 hvr-icon-spin" href="#" style="background:#666;"><i class="ios"></i><p>iPhone</p><p>即将开放</p></a>
            <?php endif; ?>
            <a class="btn-download btn-red hvr-icon-spin" href="<?php echo $gxAndroidUrl ?>"><i class="android"></i><p>Android</p><p>安卓版下载</p></a>
            <h3 class="app-box-tit ml65 mt30">扫码下载</h3>
            <div class="app-qr ml65">
                <?php
                if(empty($gxIosUrl)){
                    echo CHtml::image(DOMAIN.'/images/bg/APP_wechat02.gif');
                }else{
                    $this->widget('comext.QRCodeGenerator', array(
                        'data' => $gxIosUrl,
                        'size' => 3.6,
                        'imageTagOptions'=>array('width'=>114,'height'=>114),
                    ));
                }

                ?>
                <p class="app-qr-text bgdd">苹果版</p>
            </div>
            <div class="app-qr">
                <?php
                echo CHtml::image(DOMAIN.'/images/bgs/gxscApp.png','',array('width'=>114,'height'=>114));
                ?>
                <p class="app-qr-text bgdd">安卓版</p>
            </div>
        </div>
        <div class="app-product-pic">
            <img class="app-screenshot one" src="<?php echo DOMAIN; ?>/images/bgs/app-gemall-pic.png" width="439" height="355">
            <img class="app-screenshot two magictime tinLeftIn" src="<?php echo DOMAIN; ?>/images/bgs/app-gemall-v1.png" width="283" height="485">
        </div>
    </div>
    <div class="app-features clearfix">
        <ul>
            <li class="fea-item hvr-wobble-top">
                <i class="fea-icon fea-search-red"></i>
                <div class="fea-con">
                    <h4 class="fea-title-zh cd2">智能搜索</h4>
                    <h5 class="fea-title-en">Intelligent search</h5>
                    <p class="fea-intro">精准的搜索筛选最有价值的信息</p>
                </div>
            </li>
            <li class="fea-item hvr-wobble-top">
                <i class="fea-icon fea-mall-red"></i>
                <div class="fea-con">
                    <h4 class="fea-title-zh cd2">积分商城</h4>
                    <h5 class="fea-title-en">Integral mall</h5>
                    <p class="fea-intro">使用积分换购商品，新颖购物方式引领时尚潮流</p>
                </div>
            </li>
            <li class="fea-item hvr-wobble-top">
                <i class="fea-icon fea-hotel-red"></i>
                <div class="fea-con">
                    <h4 class="fea-title-zh cd2">盖鲜汇</h4>
                    <h5 class="fea-title-en">Fresh ingredients</h5>
                    <p class="fea-intro">最新鲜有机的食材，原产地直采全程保鲜速达</p>
                </div>
            </li>
            <li class="fea-item hvr-wobble-top">
                <i class="fea-icon fea-goods-red"></i>
                <div class="fea-con">
                    <h4 class="fea-title-zh cd2">商品分类</h4>
                    <h5 class="fea-title-en">Classification of goods</h5>
                    <p class="fea-intro">一目了然的分类导航，让你逛得舒心，买得放心</p>
                </div>
            </li>
            <li class="fea-item hvr-wobble-top">
                <i class="fea-icon fea-recommend-red"></i>
                <div class="fea-con">
                    <h4 class="fea-title-zh cd2">礼品推荐</h4>
                    <h5 class="fea-title-en">Products recommended</h5>
                    <p class="fea-intro">最实惠最热门的礼品推荐，专属您的送礼方案</p>
                </div>
            </li>
            <li class="fea-item hvr-wobble-top">
                <i class="fea-icon fea-orders-red"></i>
                <div class="fea-con">
                    <h4 class="fea-title-zh cd2">订单跟踪</h4>
                    <h5 class="fea-title-en">Order tracking</h5>
                    <p class="fea-intro">随时随地查看订单，实时掌握订单状态</p>
                </div>
            </li>
        </ul>

    </div>
</div>
<!-- END 盖象商城客户端 -->
<a name="app-gpay"></a>
<div class="appbg2"></div>
<!-- 盖付通客户端 -->
<div class="app-container app-gpay" >
    <h2 class="appname ce9 fr"><img src="<?php echo DOMAIN; ?>/images/bgs/app-gpay-logo.png" width="63" height="63" alt="盖付通">盖付通客户端<em class="app-version comment-orange">2.4</em></h2>
    <div class="app-content c ml65">
        <div class="app-box fr clearfix">
            <h3 class="app-box-tit">电脑下载</h3>
            <a class="btn-download btn-orange hvr-icon-spin" href="<?php echo $isoUrl ?>"><i class="ios"></i><p>iPhone</p><p>苹果版下载</p></a>
            <a class="btn-download btn-orange hvr-icon-spin" href="<?php echo $url_android ?>"><i class="android"></i><p>Android</p><p>安卓版下载</p></a>
            <h3 class="app-box-tit mt30">扫码下载</h3>
            <div class="app-qr">
                <?php
                $this->widget('comext.QRCodeGenerator', array(
                    'data' => $isoUrl,
                    'size' => 3.6,
                    'imageTagOptions'=>array('width'=>114,'height'=>114),
                ));
                ?>
                <p class="app-qr-text bge9">苹果版</p>
            </div>
            <div class="app-qr">
                <?php
                echo CHtml::image(DOMAIN.'/images/bgs/gft.png','',array('width'=>114,'height'=>114));
                ?>
                <p class="app-qr-text bge9">安卓版</p>
            </div>
        </div>
        <div class="app-product-pic">
            <img class="app-screenshot one" src="<?php echo DOMAIN; ?>/images/bgs/app-gpay-v2.png" width="283" height="485">
            <img class="app-screenshot two" src="<?php echo DOMAIN; ?>/images/bgs/app-gpay-pic.png" width="439" height="355">
        </div>
    </div>
    <div class="app-features clearfix">
        <ul>
            <li class="fea-item hvr-wobble-top">
                <i class="fea-icon fea-search-orange"></i>
                <div class="fea-con">
                    <h4 class="fea-title-zh ce9">智能搜索</h4>
                    <h5 class="fea-title-en">Intelligent search</h5>
                    <p class="fea-intro">精准的搜索筛选最有价值的信息</p>
                </div>
            </li>
            <li class="fea-item hvr-wobble-top">
                <i class="fea-icon fea-mall-orange"></i>
                <div class="fea-con">
                    <h4 class="fea-title-zh ce9">积分商城</h4>
                    <h5 class="fea-title-en">Integral mall</h5>
                    <p class="fea-intro">使用积分换购商品，新颖购物方式 引领时尚潮流</p>
                </div>
            </li>
            <li class="fea-item hvr-wobble-top">
                <i class="fea-icon fea-hotel-orange"></i>
                <div class="fea-con">
                    <h4 class="fea-title-zh ce9">酒店预定</h4>
                    <h5 class="fea-title-en">Hotel reservation</h5>
                    <p class="fea-intro">随时随地预定酒店，方便、快捷</p>
                </div>
            </li>
            <li class="fea-item hvr-wobble-top">
                <i class="fea-icon fea-goods-orange"></i>
                <div class="fea-con">
                    <h4 class="fea-title-zh ce9">商品分类</h4>
                    <h5 class="fea-title-en">Classification of goods</h5>
                    <p class="fea-intro">一目了然的分类导航，让你逛得舒心，买得放心</p>
                </div>
            </li>
            <li class="fea-item hvr-wobble-top">
                <i class="fea-icon fea-recommend-orange"></i>
                <div class="fea-con">
                    <h4 class="fea-title-zh ce9">精品推荐</h4>
                    <h5 class="fea-title-en">Products recommended</h5>
                    <p class="fea-intro">最实惠最热门的精品推荐，挖掘您最感兴趣的宝贝</p>
                </div>
            </li>
            <li class="fea-item hvr-wobble-top">
                <i class="fea-icon fea-orders-orange"></i>
                <div class="fea-con">
                    <h4 class="fea-title-zh ce9">订单跟踪</h4>
                    <h5 class="fea-title-en">Order tracking</h5>
                    <p class="fea-intro">随时随地查看订单，实时掌握订单状态</p>
                </div>
            </li>
        </ul>
    </div>
    <div class="appbg3"></div>
    
      <div id="group-app" class="group-app">
    	<div class="w1200">
            <h2 class="appname cd2"><img src="<?php echo DOMAIN; ?>/images/bgs/app_group_logo.png" width="63" height="63" alt="盖象商城">盖掌柜客户端<em class="app-version comment-red">1.0</em></h2>
            <div class="app-content ml65">
              <div class="app-box clearfix">
                <h3 class="app-box-tit ml65">电脑下载</h3>
                <a class="btn-download btn-red ml65 hvr-icon-spin" href="<?php echo $gzgIosUrl ?>" target="_blank"><i class="ios"></i><p>iPhone</p><p>苹果版下载</p></a>
                <a class="btn-download btn-red hvr-icon-spin" href="<?php echo $gzgAndroidUrl ?>" target="_blank"><i class="android"></i><p>Android</p><p>安卓版下载</p></a>
                <h3 class="app-box-tit ml65 mt30">扫码下载</h3>
                <div class="app-qr ml65"><img src="<?php echo DOMAIN; ?>/images/bgs/app_group_ios.jpg" width="114" height="114">
                  <p class="app-qr-text bgdd">苹果版</p>
                </div>
                <div class="app-qr"><img src="<?php echo DOMAIN; ?>/images/bgs/app_group_android.jpg" width="114" height="114">
                  <p class="app-qr-text bgdd">安卓版</p>
                </div>
              </div>
              <div class="app-product-pic">
                <img class="app-screenshot one" src="<?php echo DOMAIN; ?>/images/bgs/app-group-pic.png" width="448" height="363">
                <img class="app-screenshot two magictime tinLeftIn" src="<?php echo DOMAIN; ?>/images/bgs/app-group-v1.png" width="283" height="485">
              </div>
            </div>
            <div class="app-features clearfix">
              <ul>
                <li class="fea-item hvr-wobble-top">
                  <i class="fea-icon fea-search-red"></i>
                  <div class="fea-con">
                    <h4 class="fea-title-zh ce10">更新库存</h4>
                    <h5 class="fea-title-en">Update the inventory</h5>
                    <p class="fea-intro">更新网上可用的库存</p>
                  </div>
                </li>
                <li class="fea-item hvr-wobble-top">
                  <i class="fea-icon fea-mall-red"></i>
                  <div class="fea-con">
                    <h4 class="fea-title-zh ce10">订单查询</h4>
                    <h5 class="fea-title-en">Integral mall</h5>
                    <p class="fea-intro">随时随地查询订单，畅通无阻</p>
                  </div>
                </li>
                <li class="fea-item hvr-wobble-top">
                  <i class="fea-icon fea-hotel-red"></i>
                  <div class="fea-con">
                    <h4 class="fea-title-zh ce10">准时送货</h4>
                    <h5 class="fea-title-en">Hotel reservation</h5>
                    <p class="fea-intro">保证满意的送货速度</p>
                  </div>
                </li>
                <li class="fea-item hvr-wobble-top">
                  <i class="fea-icon fea-goods-red"></i>
                  <div class="fea-con">
                    <h4 class="fea-title-zh ce10">扫码送货</h4>
                    <h5 class="fea-title-en">Classification of goods</h5>
                    <p class="fea-intro">扫一扫，马上送货</p>
                  </div>
                </li>
                <li class="fea-item hvr-wobble-top">
                  <i class="fea-icon fea-recommend-red"></i>
                  <div class="fea-con">
                    <h4 class="fea-title-zh ce10">扫码上架</h4>
                    <h5 class="fea-title-en">Products recommended</h5>
                    <p class="fea-intro">扫一扫商品的一维码，货品上架</p>
                  </div>
                </li>
                <li class="fea-item hvr-wobble-top">
                  <i class="fea-icon fea-orders-red"></i>
                  <div class="fea-con">
                    <h4 class="fea-title-zh ce10">订单跟踪</h4>
                    <h5 class="fea-title-en">Order tracking</h5>
                    <p class="fea-intro">随时随地查看订单，实时掌握订单状态</p>
                  </div>
                </li>
              </ul>
            </div>
        </div>
    </div>
    
    <a name="more"></a>
    <div class="more-app"></div>

</div>
<!-- END 盖付通客户端 -->



<script src="<?php echo DOMAIN; ?>/js/jquery-1.9.1.js"></script>
<script src="<?php echo DOMAIN; ?>/js/jquery.gate.common.js"></script>
<script>$("#myCart").hover(function(){$(this).find(".cartList").show()},function(){$(this).find(".cartList").delay(3000).hide()});$("#morefLinks").click(function(){if($(this).hasClass("moreLinks")){$(".friendsLinks").css("height","auto");$(".friendsLinks").css("overflow"," ");$("#morefLinks").removeClass("moreLinks").addClass("lessLinks")}else{$(".friendsLinks").css("height","20px");$(".friendsLinks").css("overflow","hidden");$("#morefLinks").removeClass("lessLinks").addClass("moreLinks")}});$("#backTop").click(function(){$("body,html").stop().animate({scrollTop:0},500);return false});$(".nav-item").click(function(){$(this).addClass("selected").siblings(".nav-item").removeClass("selected")});</script>

