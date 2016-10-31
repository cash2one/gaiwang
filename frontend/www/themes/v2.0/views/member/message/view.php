<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="盖网,网上购物,网上商城,积分兑换,积分消费,手机,笔记本,电脑,数码,服装,手表,化妆品,保健品,盖网商城" />
    <meta name="Description" content="盖网,盖网商城-中国最大的网上购物及积分兑换消费商城，便捷，诚信的服务,为您提供愉悦的网上商城购物体验!" />
    <title><?php echo empty($this->title) ? '' : $this->title; ?>-<?php echo Yii::t('memberMessage','系统信息');?></title>
    <link href="<?php echo $this->theme->baseUrl.'/'; ?>styles/global.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->theme->baseUrl.'/'; ?>styles/module.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->theme->baseUrl.'/'; ?>styles/register.css"/>
    <link rel="stylesheet" href="<?php echo $this->theme->baseUrl.'/'; ?>styles/member.css" />
    <script src="<?php echo $this->theme->baseUrl.'/'; ?>js/jquery-1.9.1.js" type="text/javascript"></script>
    <script src="<?php echo $this->theme->baseUrl.'/'; ?>js/jquery.gate.common.js"></script>
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
                success:function(data){}
            });
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
</head>
<body>
<div class="gx-top-title clearfix" id="gx-top-title">
    <div class="gx-top-title-main clearfix">
        <?php echo CHtml::link(Yii::t('site','盖象首页'),DOMAIN,array('class'=>'gx-top-home')); ?>
        <div class="gx-top-welcome">
            <span class="lgName"></span>
            <?php echo Yii::t('site','想你了，欢迎来到盖象!') ?>&nbsp;&nbsp;
            <?php echo CHtml::link(Yii::t('site','请登录'),array('/member/home/login'),array('id'=>'site_')); ?>&nbsp;
            <?php echo CHtml::link(Yii::t('site', '注册'), array('/member/home/register'), array('id'=>'register_','class'=>'gx-top-register')); ?>
            <?php echo CHtml::link(Yii::t('site', '退出'), array('/member/home/logout'),array('id'=>'logout_')); ?>
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
                    <?php echo CHtml::link('收藏的商品',array('member/goodsCollect'),array('target'=>'_blank')); ?><br/>
                    <?php echo CHtml::link('收藏的店铺',array('member/storeCollect'),array('target'=>'_blank')); ?><br/>
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
<div class="pages-header">
    <div class="w1200 clearfix">
        <div class="pages-logo"><a href="<?php echo DOMAIN; ?>"><img src="<?php echo $this->theme->baseUrl.'/'; ?>images/temp/register_logo.jpg" width="213" height="86" /></a></div>
        <div class="pages-title icon-cart"><?php echo Yii::t('memberMessage','系统信息');?></div>
        <?php
        //搜索旁边的小广告
        $searchAds = WebAdData::getLogoData('top_search_ad');  //调用接口
        $searchAd = !empty($searchAds) && AdvertPicture::isValid($searchAds[0]['start_time'], $searchAds[0]['end_time']) ? $searchAds[0] : array();
        ?>
        <?php if(!empty($searchAd)): ?>
            <a href="<?php echo $searchAd['link'] ?>" title="<?php echo $searchAd['title'] ?>" target="<?php echo $searchAd['target'] ?>" class="fr">
                <img width="190" height="88" src="<?php echo ATTR_DOMAIN.'/'.$searchAd['picture']; ?>"/>
            </a>
        <?php endif; ?>
    </div>
</div>
<div class="gx-main">
    <div class="pt15">
        <div class="message-contain">
            <div class="message-title">
                <p><?php echo $model->message->title ?></p>
                <p class="date"><?php echo date("Y/m/d H:i:s", $model->message->create_time); ?></p>
            </div>
            <div class="message-content">
                <?php if(get_magic_quotes_gpc() == false){
                    echo stripslashes($model->message->content);
                }else{
                    echo $model->message->content;
                } ; ?>

            </div>
        </div>
    </div>
</div>
<!-- 底部start -->
<div class="pages-footer">
    <div class="w1200">
        <div class="links">
            <?php echo CHtml::link(Yii::t('site', 'app下载'), $this->createAbsoluteUrl('/gwkey')); ?> |
            <?php echo CHtml::link(Yii::t('site', '关于盖网'), $this->createAbsoluteUrl('/about')); ?> |
            <?php echo CHtml::link(Yii::t('site', '帮助中心'), $this->createAbsoluteUrl('/help')); ?>  |
            <?php echo CHtml::link(Yii::t('site', '网站地图'), $this->createAbsoluteUrl('/sitemap')); ?>  |
            <?php echo CHtml::link(Yii::t('site', '诚聘英才'), $this->createAbsoluteUrl('/job')); ?>  |
            <?php echo CHtml::link(Yii::t('site', '联系客服'), $this->createAbsoluteUrl('/contact')); ?>  |
            <?php echo CHtml::link(Yii::t('site', '免责声明'), $this->createAbsoluteUrl('/statement')); ?> |
            <?php echo CHtml::link(Yii::t('site', '隐私保护'), $this->createAbsoluteUrl('/privacy')); ?> |
            <?php //echo CHtml::link(Yii::t('site', '家长监护'), $this->createAbsoluteUrl('/yaopin/site/gameSupervise.html')),'|'; ?>
            <?php
            //访问统计脚本
            echo  Tool::getConfig('site', 'statisticsScript');
            ?>
        </div>
        <div class="copyright">
            Copyright©g-emall.com  |
            珠海横琴新区盖网通传媒有限公司  |
            增值电信业务经营许可证：<a>粤B2-20140364 </a>
            <a href="http://www.miitbeian.gov.cn/state/outPortal/loginPortal.action" target="_blank"> 粤ICP备14049968号-2</a> |
            <a href="http://att.e-gatenet.cn/UE_uploads/2015/04/28/14301999255090.jpg" target="_blank"> 互联网药品信息服务资格证</a> |
            <a href="http://att.e-gatenet.cn/UE_uploads/2015/04/28/14301999306973.jpg" target="_blank"> 网络文化经营许可证</a> |
            <a href='http://www.gzjd.gov.cn/wlaqjc/open/validateSite.do' target="_blank">穗公网监备案证第44070050010060号</a>
        </div>
    </div>
</div>
<!-- 底部end -->
</body>
</html>
