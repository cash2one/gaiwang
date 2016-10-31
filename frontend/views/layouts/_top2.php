<?php
// 公共用的搜索块
/* @var $this Controller */
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#keyword').focus(function() {
            if ($(this).val() == '<?php echo Yii::t('site', '输入店铺或者宝贝进行搜索'); ?>') {
                $(this).val("");
                $(this).addClass('input_search_curr');
            }
        });
        $('#keyword').blur(function() {
            if ($(this).val() == "") {
                $(this).val('<?php echo Yii::t('site', '输入店铺或者宝贝进行搜索'); ?>');
                $(this).removeClass('input_search_curr');
            }
        });
    });
</script>
<?php
// 头部横幅广告
$topAds = WebAdData::getLogoData('index-top-banner');//调用接口，获取第一行数据
$topAd = !empty($topAds) ? $topAds[0] : array();
// logo旁边广告
$logoAds = WebAdData::getLogoData('index-logo-ad');  //调用接口
$logoAd = !empty($logoAds) ? $logoAds[0] : array();
?>
<div class="logoSearch w1200">
    <?php if (!empty($topAd) && AdvertPicture::isValid($topAd['start_time'], $topAd['end_time'])): ?>
        <div class="topBanner" id="topBanner">
            <?php $img = CHtml::image(ATTR_DOMAIN . '/' . $topAd['picture'], Yii::t('site', $topAd['title']), array('width' => '1200', 'height' => '80')) ?>
            <?php echo CHtml::link($img, $topAd['link'], array('title' => Yii::t('site', $topAd['title']))) ?>
            <i class="icon_v close"></i>
        </div>
    <?php endif; ?>
    <div class="clearfix">
        <?php $img = CHtml::image(DOMAIN . '/images/bgs/logo.png', Yii::t('site', '盖象商城'), array('width' => '215', 'height' => '85')) ?>
        <?php echo CHtml::link($img, DOMAIN, array('title' => Yii::t('site', '盖象商城'), 'class' => 'logo fl','id'=>'gai_link')) ?>
        <?php if (!empty($logoAd) && AdvertPicture::isValid($logoAd['start_time'], $logoAd['end_time'])): ?>
            <div class="adbox fl">
                <?php $img = CHtml::image(ATTR_DOMAIN . '/' . $logoAd['picture'], Yii::t('site', $logoAd['title']), array('width' => '300', 'height' => '110')) ?>
                <?php echo CHtml::link($img, $logoAd['link'], array('title' => Yii::t('site', $logoAd['title']))) ?>
            </div>
        <?php endif; ?>
        <div class="search">
            <form id="home-form" action="<?php echo $this->createAbsoluteUrl('/search/search'); ?>" target="_blank"method="get">
                <div class="searchBg clearfix">
                    <ul class="searchStore" id="searchTab">
                        <li id="goods"><a title="<?php echo Yii::t('site', '宝贝'); ?>" href="javascript:;"><?php echo Yii::t('site', '宝贝'); ?></a><s class="icon_v"></s></li>
                        <li id="store" class="switch" style="display: none;"><a title="<?php echo Yii::t('site', '店铺'); ?>" href="javascript:;"><?php echo Yii::t('site', '店铺'); ?></a></li>
                        <?php echo CHtml::hiddenField('o', '', array('id' => 'options')) ?>
                    </ul>
                    <input id="keyword" type="text" class="textSearch" placeholder="<?php echo Yii::t('site', '输入店铺或者宝贝进行搜索'); ?>" value="<?php echo isset($this->keyword) ? $this->keyword : ''; ?>" name="q" x-webkit-speech
                           x-webkit-grammar="builtin:translate" lang="zh-CN" accesskey="s" autofocus="true"
                           autocomplete="off" aria-haspopup="true" aria-combobox="list"/>
                    <input type="submit" class="btnSearch" value="" />
                </div>
            </form>
            <ul class="hitSearh clearfix">
                <li><?php echo Yii::t('site', '热门搜索'); ?>：</li>
                <?php if (!empty($this->globalkeywords)): ?>
                    <?php foreach ($this->globalkeywords as $val): ?>
                        <li>
                            <?php echo CHtml::link(Yii::t('site', $val), $this->createAbsoluteUrl('/search/search', array('q' => $val)),array('target'=>'_blank')) ?>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <script>
            $(function() {/*选择店铺或者宝贝搜索*/
                var options_name = '<?php echo Yii::app()->request->cookies['optionsName']; ?>';
                if (options_name) {
                    var goods = $('#goods').text();
                    if (goods == options_name) {
                        $('#goods a').text(options_name);
                    } else {
                        $('#goods a').text(options_name);
                        var store = $('#store a').text(goods);
                        $('#options').val(options_name);
                    }
                }

                $('#searchTab').hover(function() {
                    $('#searchTab ul li s').addClass("icon_v");
                    $('#searchTab .switch').show();
                }, function() {
                    $('#searchTab ul li s').removeClass("icon_v");
                    $('#searchTab .switch').hide();
                });
                $('#searchTab .switch a').click(function() {
                    var currContent = $(this).text();
                    var defCont = $('#goods a').text();
                    $('#goods a').text(currContent);
                    $(this).text(defCont);

                    $('#options').val(currContent);
                })
            });
        </script>

        <div class="gateWeixin">
            <a title="<?php echo Yii::t('site', '微信二维码'); ?>" href="javascript:;"><img width="95" height="95" alt="<?php echo Yii::t('site', '微信二维码'); ?>" src="<?php echo DOMAIN; ?>/images/bgs/gxscApp.png" /></a>
            <p><?php echo Yii::t('site', '下载盖象优选APP'); ?></p>
            <p><?php echo Yii::t('site', ''); ?></p>
        </div>
        <div class="gateWeixin">
            <a title="<?php echo Yii::t('site', '微信公众号'); ?>" href="javascript:;"><img width="95" height="95" alt="<?php echo Yii::t('site', '微信公众号'); ?>" src="<?php echo DOMAIN; ?>/images/bgs/gongzhonghao.jpg" /></a>
            <p><?php echo Yii::t('site', '关注微信公众号'); ?></p>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        /*头部广告位关闭*/
        $("#topBanner .close").click(function() {
            $("#topBanner").hide();
        });
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
    })
</script>