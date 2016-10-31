<?php
// 商店菜单导航 弃用
/* @var $this Controller */
/** @var $this->store Store */
/** @var $store Store */
$store = $this->store;

?>
<script type="text/javascript">
    /* $(document).ready(function(e) {
     $(".menuList .subMenu ").bind("mouseenter", function() {
     $(this).find('.subMenubox').show();
     $(this).addClass('hover');
     });
     $(".menuList .subMenu ").bind("mouseleave", function() {
     $(this).find('.subMenubox').hide();
     $(this).removeClass('hover');
     });
     });*/
    $(document).ready(function(e) {
        $(".menuList .subMenu ").bind("mouseenter", function() {
            var carTop = $(this).position().top;
            $(this).find('.subMenubox').show();
            var carHeight = $(this).find('.subMenubox').height();
            var carh = parseInt(carHeight / 1.5);
            carTop = carTop - carh;
            if (carTop < 10)
                carTop = 20;
            $(this).find('.subMenubox').css(("top"), carTop);
            $(this).addClass('hover');

        });
        $(".menuList .subMenu ").bind("mouseleave", function() {
            $(this).find('.subMenubox').hide();
            $(this).removeClass('hover');
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.menuList').hide();
        var isIndex = '';
        if (isIndex == "" || isIndex == null)
        {
            $(".menu").hover(
                    function() {
                        $('.menuList').show();
                        $(this).addClass('hover');
                    }, function() {
                $('.menuList').hide();
                $(this).removeClass('hover');
            });
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#keyword').focus(function() {
            if ($(this).val() == '<?php echo Yii::t('site', '输入品牌或者商品进行搜索'); ?>') {
                $(this).val("");
            }
        });
        $('#keyword').blur(function() {
            if ($(this).val() == "") {
                $(this).val('<?php echo Yii::t('site', '输入品牌或者商品进行搜索'); ?>');
            }
        });
    });
</script>
<?php
if (!$mainCategorys = $this->cache(Category::CACHEDIR)->get(Category::CK_MAINCATEGORY))
    $mainCategorys = Category::generateMainCategoryData();
?>
<div class="navWrap">
    <div class="navContent">
        <div class="menu">
            <span class="name"><?php echo Yii::t('site', '全部商品分类'); ?></span>
            <?php if (!empty($mainCategorys)): ?>
                <div class="menuList" style="display:none;">
                    <ul class="menuBox">
                        <li class="subMenutop"></li>
                        <?php foreach ($mainCategorys as $ck => $cv) : ?>
                            <li class="subMenu">
                                <?php echo CHtml::link($cv['name'], $this->createAbsoluteUrl('/category/list', array('id' => $cv['id'])), array('title' => $cv['name'], 'target' => '_blank', 'class' => 'subname')); ?>
                                <p class="subp">
                                    <?php foreach ($cv['recommends'] as $rk => $rv): ?>
                                        <?php echo CHtml::link($rv['name'], $this->createAbsoluteUrl('/category/view', array('id' => $rv['id'])), array('title' => $rv['name'], 'target' => '_blank')); ?>
                                        <?php if ($rk == 3) break; ?>
                                    <?php endforeach; ?>
                                </p>
                                <div class="subMenubox">
                                    <ul class="items">
                                        <?php if (!empty($cv['childClass'])): ?>
                                            <?php foreach ($cv['childClass'] as $twock => $twocv): ?>
                                                <li class="fix clearfix">
                                                    <h3><?php echo CHtml::link($twocv['name'], $this->createAbsoluteUrl('/category/view', array('id' => $twocv['id'])), array('title' => $twocv['name'], 'target' => '_blank')); ?></h3>
                                                    <p class="subItem">
                                                        <?php if (!empty($twocv['childClass'])): ?>
                                                            <?php foreach ($twocv['childClass'] as $subck => $subcv): ?>
                                                                <?php echo CHtml::link($subcv['name'], $this->createAbsoluteUrl('/category/view', array('id' => $subcv['id'])), array('title' => $subcv['name'], 'target' => '_blank')); ?>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?> 
                                                    </p>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                    <div class="subBrand">
                                        <div class="titleChannel"><h3><?php echo Yii::t('site', '品牌故事'); ?></h3>Gatewang.com</div>
                                        <div class="brandBox">
                                            <div class="tabBrand">
                                                <div class="tabBrandbox">
                                                    <?php foreach ($cv['brands'] as $bk => $bv): ?>
                                                        <?php
                                                        $bk++;
                                                        $id = 'brand' . Tool::shiftWork($ck);
                                                        echo CHtml::link(CHtml::image(IMG_DOMAIN . '/' . $bv['logo'], $bv['name'], array('width' => '80', 'height' => '24')), '', array('title' => $bv['name'], 'target' => '_blank', 'class' => $bk == 1 ? 'curr' : '', 'id' => $id . "$bk", 'onmouseover' => "setTab('$id', $bk, " . count($cv['brands']) . ")", 'encode' => false));
                                                        ?>
                                                    <?php endforeach; ?>
                                                    <?php CHtml::link(Yii::t('site', '更多>>'), $this->createAbsoluteUrl('/brands', array('id' => $cv['id'])), array('class' => 'more')); ?>
                                                </div>
                                                <?php if (!empty($cv['adverts']) && AdvertPicture::isValid($cv['adverts']['start_time'], $cv['adverts']['end_time'])): // 判断广告是否有效  ?>
                                                    <div class="subAdver">
                                                        <a href="<?php echo $cv['adverts']['link']; ?>" title="<?php echo $cv['adverts']['title']; ?>" target="<?php echo $cv['adverts']['target']; ?>">
                                                            <img src="<?php echo ATTR_DOMAIN . '/' . $cv['adverts']['picture']; ?>" width="190" height="250" alt="<?php echo $cv['adverts']['title']; ?>">
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php foreach ($cv['brands'] as $bck => $bcv): ?>
                                                <?php
                                                $bck++;
                                                echo CHtml::tag('div', array('class' => $bck == 1 ? 'conBrand curr' : 'conBrand', 'id' => 'con_brand' . Tool::shiftWork($ck) . '_' . $bck), false, false);
                                                ?>
                                                <?php echo CHtml::image(IMG_DOMAIN . '/' . $bcv['logo'], $bcv['name'], array('width' => '150', 'height' => '45')); ?>
                                                <p><?php echo $bcv['content']; ?></p>
                                                <div class="shopLink">
                                                    <h4><?php echo $bcv['name']; ?></h4>
                                                    <p><?php echo Yii::t('site', '创于'); ?>:<?php echo date('Y年m月', time()); ?></p>
                                                    <p>
                                                        <?php echo CHtml::image(IMG_DOMAIN . '/' . $bcv['logo'], $bcv['name'], array('width' => '80', 'height' => '24')); ?>
                                                        <?php echo CHtml::image(DOMAIN . '/images/bg/brand.jpg', $bcv['name']); ?>
                                                    </p>
                                                    
                                                    <?php CHtml::link(Yii::t('site', '>更多 '), $this->createAbsoluteUrl('brands', array('catid' => $bcv['id'])), array('class' => 'btnMore')); ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                        <li class="subMenubottom"> </li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <form id="home-form" action="<?php echo $this->createAbsoluteUrl('/search/view'); ?>" shopaction="<?php if ($this->store->id) echo $this->createAbsoluteUrl('shop/view', array('id' => $this->store->id)); ?>"  method="get">
            <ul class="nav">
                <li><?php echo CHtml::link(Yii::t('shop', '店铺首页'), $this->createAbsoluteUrl('/shop/view', array('id' => $store->id)), array('title' => Yii::t('shop', '店铺首页'), 'class' => $this->id == 'shop' && $this->action->id == 'view' ? 'curr' : 'no','target'=>'_blank')); ?></li>
                <li><?php echo CHtml::link(Yii::t('shop', '商家介绍'), $this->createAbsoluteUrl('/shop/info', array('id' => $store->id)), array('title' => Yii::t('shop', '商家介绍'), 'class' => $this->id == 'shop' && $this->action->id == 'info' ? 'curr' : 'no','target'=>'_blank')); ?></li>
                <li><?php echo CHtml::link(Yii::t('shop', '所有商品'), $this->createAbsoluteUrl('/shop/product', array('id' => $store->id)), array('title' => Yii::t('shop', '所有商品'), 'class' => $this->id == 'shop' && $this->action->id == 'product' ? 'curr' : 'no','target'=>'_blank')); ?></li>
                <!--<li><?php echo CHtml::link(Yii::t('shop', '实体店'), $this->createAbsoluteUrl('', array('id' => $this->store->id)), array('title' => Yii::t('shop', '实体店'))); ?></li>-->
                <li class="search">
                    <input type="hidden" name="keyword" id="skeyword" value="<?php echo isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : ''; ?>" />
                    <input id="keyword" value="<?php echo isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : ''; ?>" name="q" accesskey="s" autofocus="true" autocomplete="off" aria-haspopup="true" aria-combobox="list"  class="search_txt" x-webkit-speech="" x-webkit-grammar="builtin:translate" lang="zh-CN" /><input class="search_btn" id="search_shop" type="submit" value="<?php echo Yii::t('site', '搜店铺'); ?>" /><input class="search_btna" type="submit" value="<?php echo Yii::t('site', '搜全网'); ?>" />
                </li>
            </ul>
        </form>
        <script>
            $("#search_shop").click(function() {
                $("#skeyword").val($("#keyword").val());
                $("#home-form").attr('action', $("#home-form").attr('shopaction'));
            });
        </script>
    </div>
</div>