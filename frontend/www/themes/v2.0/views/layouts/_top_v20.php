
<!-- 头部广告start -->
<?php if($this->id=='site' && !$this->module):?>
<?php
// 头部横幅广告
$topAds = WebAdData::getLogoData('index-top-banner');//调用接口，获取第一行数据
$topAd = !empty($topAds) && AdvertPicture::isValid($topAds[0]['start_time'], $topAds[0]['end_time']) ? $topAds[0] : array();
?>
<?php if(!empty($topAd)): ?>
<div class="top-advert">
    <img width="100%" height="70"  src="<?php echo ATTR_DOMAIN . '/' . $topAd['picture']; ?>"/>
    <div class="clear-top-advert">
        <div>
            <?php echo CHtml::link('<span style="width:1200px;height:70px;display:block;"></span> ',$topAd['link'],
                array('target'=>$topAd['target'],'title'=>$topAd['title'])); ?>
            <span class="clear-top-but" style="z-index: 9999"></span>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>
<!-- 头部广告end -->

<!-- 头部start -->
<div class="gx-top-title clearfix" id="gx-top-title" style="">
    <div class="gx-top-title-main clearfix">
        <?php echo CHtml::link(Yii::t('site','盖象首页'),DOMAIN,array('class'=>'gx-top-home')); ?>
        <div class="gx-top-welcome">
            <span class="lgName"></span>
            <?php echo Yii::t('site','想你了，欢迎来到盖象!') ?>&nbsp;&nbsp;
            <?php echo CHtml::link(Yii::t('site','请登录'),array('/member/home/login'),array('id'=>'site_')); ?>&nbsp;
            <?php echo CHtml::link(Yii::t('site', '注册'), array('/member/home/register'), array('id'=>'register_','class'=>'gx-top-register')); ?>
            <?php echo CHtml::link(Yii::t('site', '退出'), array('/member/home/logout'),array('id'=>'logout_','style'=>'display:none')); ?>
        </div>
        <div class="gx-top-nav">
            <?php echo CHtml::link(Yii::t('site','购物车').'<span class="gx-top-shopping-num">0</span>',array('/orderFlow'),
                array('class'=>'gx-top-shopping','title'=>Yii::t('site','购物车'))); ?>
            <div class="gx-top-mygx">
                <?php echo CHtml::link(Yii::t('site','我的盖象'),array('/member/site')); ?><span></span>
                <div class="gx-top-ycItem clearfix">
                    <?php echo CHtml::link(Yii::t('site','我的订单'),array('/member/order/admin')); ?><br/>
                    <?php echo CHtml::link(Yii::t('site','我的钱包'),array('/member/redEnvelope')); ?><br/>
                </div>
            </div>
            <div class="gx-top-mygx gx-top-mygx2">
                收藏夹<span></span>
                <div class="gx-top-ycItem clearfix">
                    <?php echo CHtml::link('收藏的商品',array('/member/goodsCollect'),array('target'=>'_blank')); ?><br/>
                    <?php echo CHtml::link('收藏的店铺',array('/member/storeCollect'),array('target'=>'_blank')); ?><br/>
                </div>
            </div>
            <div class="gx-top-mygx">
                <?php echo Yii::t('site','商家支持') ?><span></span>
                <div class="gx-top-ycItem clearfix">
                    <?php echo CHtml::link(Yii::t('site','商家入驻'),array('/help/article/join')); ?><br/>
                    <?php echo CHtml::link(Yii::t('site','合作加盟'),array('/help/article/affiliate')); ?><br/>
                    <?php echo CHtml::link(Yii::t('site','盖网终端机'),array('/help/article/machine')); ?><br/>
                </div>
            </div>
            <?php echo CHtml::link(Yii::t('site','手机APP'),array('/gwkey'),array('class'=>'gx-top-app')); ?>
            <div class="gx-top-language">
                <?php
                //语言选择
                $url = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
                $url = str_replace('http://','',$url);
                $domain = str_replace('http://','',DOMAIN).'/';
                $zh = $domain.'index.php';
                $zh_ = $domain.'index.php/';
                switch(Yii::app()->language){
                    case 'en':
                        $lang = HtmlHelper::LANG_EN;
                        break;
                    case 'zh_tw':
                        $lang = HtmlHelper::LANG_ZH_TW;
                        break;
                    default:
                        $lang = HtmlHelper::LANG_ZH_CN;
                }
                if($url == $zh || $url == $zh_){
                    echo CHtml::dropDownList('select_language', $lang, HtmlHelper::languageInfo(),array('id'=>'select_language_id','style'=>'border:none;'));
                }else{
                    echo CHtml::dropDownList('select_language', $lang, HtmlHelper::languageInfo(), array('style'=>'border:none;','onchange' => '$.get("' . $this->createAbsoluteUrl('site/selectLanguage') . '",{language:this.value},function(data){
                    window.location.reload();
                })'));
                }
                ?>
            </div>
        </div>
    </div>
</div>


<!-- 头部end -->

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
    /*首页多语言跳转*/
    $("#select_language_id").change(function(){
        var lang = this.value;
        jQuery.ajax({
            type:"get",async:false,timeout:5000,
            url:"<?php echo $this->createAbsoluteUrl("site/selectLanguage");?>",
            data: "language="+lang,
            error:function(request,status,error){
                alert(request.responseText);
            },
            success:function(data){
                var index = "<?php echo DOMAIN ?>"+"/";
                var index_tw = "<?php echo DOMAIN ?>"+"/index_tw.html";
                var index_en = "<?php echo DOMAIN ?>"+"/index_en.html";
                var hre = window.location.href;
                if(hre == index || hre == index_tw || hre == index_en){
                    if(lang == 2){
                        location.href = "<?php echo DOMAIN ?>"+"/index_tw.html";
                    }else if(lang == 3){
                        location.href = "<?php echo DOMAIN ?>"+"/index_en.html";
                    }else{
                        location.href = "<?php echo DOMAIN ?>";
                    }
                }else{
                    location.reload();
                }
            }
        });

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

        /*改变盖象图表默认链接*/
        var langs = "<?php echo Yii::app()->language?>";
        var domain = "<?php echo DOMAIN?>";
        var href = "";
        if(langs == "zh_tw"){
            href = domain+"/"+"index_tw.html";
        }else if(langs == "en"){
            href = domain+"/"+"index_en.html";
        }else{
            href = domain;
        }
        $("#gai_link").attr("href",href);
    });
	
	//购物车的一些连接
	var commonVar = {
        reloadTips: '<div class="loading reload"></div>',
        addCartUrl: '<?php echo Yii::app()->createAbsoluteUrl('/cart/addCart') ?>',
        loadCartUrl: '<?php echo Yii::app()->createAbsoluteUrl('/cart/loadCart') ?>',
        deleteCartUrl: '<?php echo Yii::app()->createAbsoluteUrl('/cart/del') ?>'
    }
</script>
<script src="<?php echo $this->theme->baseUrl; ?>/js/ShoppingCart.js"></script>