<?php
// 公共用的top块
/* @var $this Controller */
?>
<script type="text/javascript">
    $(function() {
        /*购物车列表*/
        $('#myCart').hover(function() {
            $(this).find('.cartList').show();
        }, function() {
            $(this).find('.cartList').delay(3000).hide();
        });
    });
</script>
<div class="guideWrap">
    <div class="guideWel clearfix">
        <div class="welcome fl">
            <span class="welcomeGw"><?php echo Yii::t('site', '想你了，欢迎来到盖象！'); ?></span>&nbsp;
<!--            --><?php //if ($this->getUser()->id): ?>
              <span class="lgName"> <?php //echo $this->getUser()->name; ?></span>
<!--            --><?php //else: ?>
                <?php echo CHtml::link(Yii::t('site', '请登录'), array('/member/site'), array('title' => Yii::t('site', '请登录'),'id'=>'site_')) ?>&nbsp;
                <?php echo CHtml::link(Yii::t('site', '免费注册'), array('/member/home/register'), array('title' => Yii::t('site', '免费注册'),'id'=>'register_')); ?>
<!--            --><?php //endif; ?>
            &nbsp;
            <?php
            //if (!$this->getUser()->isGuest)
                echo CHtml::link(Yii::t('site', '退出'), array('/member/home/logout'),array('id'=>'logout_'));
            ?>
            <!--
                        想你了，欢迎来到盖象！&nbsp;&nbsp;<a title="请登录" href="#">请登录</a>&nbsp;&nbsp;<a href="#"  title="免费注册" target="_blank">免费注册</a>-->
        </div>
        <ul class="guide clearfix">
            <?php $this->renderPartial('//layouts/_cart'); ?>
            <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/ShoppingCart.js" ></script>
            <li class="icon_v myaccount">
                <?php echo CHtml::link(Yii::t('site', '我的盖象'), array('/member/site'), array('title' => Yii::t('site', '我的盖象'))) ?>
            </li>
            <li class="business">
                <?php echo CHtml::link(Yii::t('site', '商家入驻'), $this->createAbsoluteUrl('/help/article/join.html'), array('title' => Yii::t('site', '商家入驻'))) ?>
                <a href="#"></a>
            </li>
            <li class="icon_v collect">
                <a onclick="addFavorite(this,window.location, document.title)" href="javascript:void(0)"><?php echo Yii::t('site', '收藏盖象'); ?></a>
            </li>
            <li class="language">
                <?php
                $url = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
                $url = str_replace('http://','',$url);
                $domain = str_replace('http://','',DOMAIN).'/';
                $zh = $domain.'index.php';
                $zh_ = $domain.'index.php/';
                $lang = Yii::app()->user->getState('selectLanguage');
                if($url == $zh || $url == $zh_){
                    echo CHtml::dropDownList('select_language', $lang, HtmlHelper::languageInfo(),array('id'=>'select_language_id'));
                }else{
                    echo CHtml::dropDownList('select_language', $lang, HtmlHelper::languageInfo(), array('onchange' => '$.get("' . $this->createAbsoluteUrl('site/selectLanguage') . '",{language:this.value},function(data){
                    window.location.reload();
                })'));
                }
                ?>
            </li>

            <script  type="text/javascript">
                function addFavorite(obj,sURL,title) {
                    var url = encodeURI(sURL);
                    var B = {
                        FF : /Firefox/.test(window.navigator.userAgent)
                    };
                    obj.onmousedown = null;
                    if (B.FF ) {
                        obj.setAttribute("rel", "sidebar"), obj.title = title, obj.href = url;
                    }else{
                        try {
                            window.external.addFavorite(url, title);
                        } catch (e) {
                            try {
                                window.sidebar.addPanel(title, url, "");
                            } catch (e) {
                                alert("<?php echo Yii::t('site', '加入收藏失败，请使用Ctrl+D进行添加,或手动在浏览器里进行设置.'); ?>");
                            }
                        }
                    }
                }
            </script>
            <li class="share">
                <!-- Baidu Button BEGIN -->
                <div id="bdshare" class="bdshare_b left" style="line-height:12px;">
                    <img src="http://bdimg.share.baidu.com/static/images/type-button-1.jpg?cdnversion=20120831" />
                    <a class="shareCount"></a>
                </div>
                <script type="text/javascript" id="bdshare_js" data="type=button&amp;uid=6822010" ></script>
                <script type="text/javascript" id="bdshell_js"></script>
                <script type="text/javascript">
                    document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date() / 3600000);
                </script>
                <!-- Baidu Button END -->
            </li>
        </ul>
    </div>
</div>
<div class="clear"></div>
<script type="text/javascript">
    /**获取登陆用户信息**/
    $(function(){
            setTimeout(function(){
                $.ajax({
                    url:"<?php echo $this->createAbsoluteUrl("/site/Select")?>",
                    dataType:'jsonp',
                    jsonp:"callBack",
                    jsonpCallback:"jsonpCallback",
                    success:function(data){
                        if(data.status==1){
                            $('#site_').hide();
                            $('#register_').hide();
                            $('#logout_').show();
                            $('.lgName').empty();
                            $('.lgName').append(data.username);
                        }else{
                            $('.lgName').empty();
                            $('#logout_').hide();
                            $('#site_').show();
                            $('#register_').show();
                        }
                    }
                })
            },500);
        }
    );

        /*产品详情页多语言跳转*/
        $("#select_language_id").change(function(){
            var lang = this.value;
            jQuery.ajax({
                type:"get",async:false,timeout:5000,
                url:"<?php echo $this->createAbsoluteUrl("site/selectLanguage");?>",
                data: "language="+lang,
                error:function(request,status,error){
                    alert(request.responseText);
                },
                success:function(data){}
            });
            var good_id = $('#goodsId').attr('value');
            var goods = "<?php echo DOMAIN ?>"+"/JF/"+good_id+".html";
            var goods_tw = "<?php echo DOMAIN ?>"+"/JF/"+good_id+"_tw.html";
            var goods_en = "<?php echo DOMAIN ?>"+"/JF/"+good_id+"_en.html";
//            var hre = window.location.href;

                if(lang == 2){
                    location.href = goods_tw;
                }else if(lang == 3){
                    location.href = goods_en;
                }else{
                    location.href = goods;
                }
        });
        /*生成静态页时用来改变语言值*/
    $(function(){
        var langss = "<?php echo Yii::app()->language?>";
        var valus = "";
        if(langss == "zh_tw"){
            valus = 2;
        }else if(langss == "en"){
            valus = 3;
        }else{
            valus = 1;
        }
        $("#select_language_id").attr("value",valus);
        $("#select_language").attr("value",valus);
    });
</script>