<?php
/* 商店头部 */
/** @var  $this ShopController */
/** @var $this->store Store */
/** @var $store Store */
$store = $this->store;
//客服联系
$contact = isset($design) ? $design->tmpData[DesignFormat::TMP_LEFT_CONTACT] : $this->design->tmpData[DesignFormat::TMP_LEFT_CONTACT];
$qq = '';
if (isset($contact['CustomerData']) && isset($contact['CustomerData'][0])) {
    $qq = $contact['CustomerData'][0]['ContactNum'];
}

$des = $store['comments'] == 0.00 || empty($store) ? 1 : $store['description_match'] / $store['comments'];
$ser = $store['comments'] == 0.00 || empty($store) ? 1 : $store['serivice_attitude'] / $store['comments'];
$spe = $store['comments'] == 0.00 || empty($store) ? 1 : $store['speed_of_delivery'] / $store['comments'];

Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/raty/lib/jquery.raty.min.js');
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#keyword').focus(function() {
            if ($(this).val() == '<?php echo Yii::t('site', '输入店铺或者商品进行搜索'); ?>') {
                $(this).val("");
            }
        });
        $('#keyword').blur(function() {
            if ($(this).val() == "") {
                $(this).val('<?php echo Yii::t('site', '输入店铺或者商品进行搜索'); ?>');
            }
        });
    });
</script>
<div class="logoSearch w1200">
    <div class="clearfix">
        <?php $img = CHtml::image(DOMAIN . '/images/bgs/logo.png', Yii::t('site', '盖象商城'), array('width' => '215', 'height' => '85')) ?>
        <?php echo CHtml::link($img, DOMAIN, array('title' => Yii::t('site', '盖象商城'), 'class' => 'logo fl')) ?>
        <div class="busiService clearfix fl">
            <div class="busiInfo fl">
                <p class="companyNam"><?php echo CHtml::link(Yii::t('site', $store['name']), $this->createAbsoluteUrl('/shop/' . $store['id'])) ?></p>
                <p><?php echo Yii::t('site', '描述服务物流') ?></p>
                <div class="busiPoint">
                    <span class="down"><?php //echo sprintf('%.2f',$des) ?><i class="icon_v"></i></span>
                    <span class="balance"><?php //echo sprintf('%.2f',$ser) ?><i class="icon_v"></i></span>
                    <span class="up"><?php //echo sprintf('%.2f',$spe) ?><i class="icon_v"></i></span>
                </div>
            </div>
            <?php if ($qq): ?>
                <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $qq ?>&site=qq&menu=yes" target="_blank" title="QQ" class="icon_v_h qq"></a>
            <?php endif; ?>
        </div>

        <div class="search02">
            <?php
            echo CHtml::form($this->createAbsoluteUrl('/shop/view', array('id' => $this->store['id'])), 'get', array(
                'id' => 'home-form',
                'data-shopAction' => isset($store['id']) ? $this->createAbsoluteUrl('/shop/view', array('id' => $this->store['id'])) : null,
            ))
            ?>
            <div class="icon_v_h searchBg clearfix">
                <?php
                echo CHtml::textField('keyword', $this->getParam('keyword'), array(
                    'id' => 'keyword',
                    'accesskey' => 's',
                    'autofocus' => 'true',
                    'autocomplete' => 'off',
                    'aria-haspopup' => 'true',
                    'aria-combobox' => 'list',
                    'class' => 'textSearch',
                    'x-webkit-speech' => '',
                    'x-webkit-grammar' => 'builtin:translate',
                    'lang' => 'zh-CN',
                ))
                ?>
                <input type="button" id="search_store" class="btnSearchStore" value="<?php echo Yii::t('site', '搜店铺'); ?>" />
                <input type="button" id="search_all" class="btnSearch" value="<?php echo Yii::t('site', '搜全网'); ?>" />
            </div>
            <?php echo CHtml::endForm(); ?>
            <ul class="hitSearh clearfix">
                <li><?php echo Yii::t('site', '热门搜索'); ?>：</li>
<!--                --><?php //if (!empty($this->globalkeywords)): ?>
<!--                    --><?php //foreach ($this->globalkeywords as $val): ?>
<!--                        <li>-->
<!--                            --><?php //echo CHtml::link(Yii::t('site', $val), $this->createAbsoluteUrl('/search/search', array('q' => $val))) ?>
<!--                        </li>-->
<!--                    --><?php //endforeach; ?>
<!--                --><?php //endif; ?>
            </ul>
        </div>
        <script>
            $("#search_all").click(function() {
                var keyword = $('#keyword').val();
                var url = '<?php echo urldecode($this->createAbsoluteUrl('/search/search', array('q' => "'+keyword+'"))); ?>';
                location.href = url;
            });
        </script>
        <script>
            $("#search_store").click(function() {
                var keyword = $('#keyword').val();
                var url = '<?php echo urldecode($this->createAbsoluteUrl('/search/search', array('o' => '店铺', 'q' => "'+keyword+'"))); ?>';
                location.href = url;
            });
        </script>
        <div class="gateWeixin">
            <a title="<?php echo Yii::t('site', '微信公众号'); ?>" href="javascript:;"><img width="95" height="95" alt="<?php echo Yii::t('site', '微信公众号'); ?>" src="<?php echo DOMAIN; ?>/images/bgs/gongzhonghao.jpg" /></a>
            <p><?php echo Yii::t('site', '关注微信公众号'); ?></p>

        </div>
    </div>
</div>
