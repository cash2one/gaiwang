<?php
// 底部
/* @var $this Controller */

$links = WebAdData::getLinkData(); //调用接口
$helpInfo = WebAdData::getHelpData(); //调用接口
?>
<div class="footer">
    <div class="gwEnsure w1200 clearfix">
        <div class="icon_v safeCert">
            <p><?php echo Yii::t('site', '安全认证'); ?></p>
            <p class="en">Safety certification</p>
        </div>
        <div class="icon_v quaGoods">
            <p><?php echo Yii::t('site', '优质商品'); ?></p>
            <p class="en">High quality goods</p>
        </div>
        <div class="icon_v perUpdate">
            <p><?php echo Yii::t('site', '周期更新'); ?></p>
            <p class="en">Periodic updates</p>
        </div>
        <div class="icon_v fastDeli">
            <p><?php echo Yii::t('site', '快速送达'); ?></p>
            <p class="en">Fast delivery</p>
        </div>
        <div class="icon_v service">
            <p class="tel"><?php echo Tool::getConfig('site', 'phone') ?></p>
            <p class="time"><!--<?php echo Yii::t('site', '全国免费客服热线'); ?><br>-->
                <?php echo Yii::t('site', '服务时间'); ?>: <?php echo Tool::getConfig('site', 'service_time') ?></p>
        </div>
    </div>
    <div class="gwHelp w1200 clearfix">
        <?php if (!empty($helpInfo)): ?>
            <?php $count = count($helpInfo) ?>
            <?php $x = 1 ?>
            <?php foreach ($helpInfo as $h): ?>
                <?php $cla = $count == $x ? 'last' : '' ?>
                <dl class="<?php echo $cla ?>">
                    <dt><?php echo Yii::t('site', $h['name']); ?></dt>
                    <?php $i = 1; ?>
                    <?php foreach ($h['child'] as $c): ?>
                        <?php if ($i <= 3): ?>
                            <dd><?php echo CHtml::link(Yii::t('help', $c['title']), array('/help/article/view', 'alias' => $c['alias']), array('title' => Yii::t('help', $c['title']))); ?></dd>
                        <?php endif; ?>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </dl>
                <?php $x++ ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="footLink">
        <div class="gwLinks w1200">
            <?php echo CHtml::link(Yii::t('site', 'app下载'), $this->createAbsoluteUrl('/gwkey')); ?> |
            <?php echo CHtml::link(Yii::t('site', '关于盖网'), $this->createAbsoluteUrl('/about')); ?> |
            <?php echo CHtml::link(Yii::t('site', '帮助中心'), $this->createAbsoluteUrl('/help')); ?>  |
            <?php echo CHtml::link(Yii::t('site', '网站地图'), $this->createAbsoluteUrl('/sitemap')); ?>  |
            <?php echo CHtml::link(Yii::t('site', '诚聘英才'), $this->createAbsoluteUrl('/job')); ?>  |
            <?php echo CHtml::link(Yii::t('site', '联系客服'), $this->createAbsoluteUrl('/contact')); ?>  |
            <?php echo CHtml::link(Yii::t('site', '免责声明'), $this->createAbsoluteUrl('/statement')); ?> |
			<?php echo CHtml::link(Yii::t('site', '隐私保护'), $this->createAbsoluteUrl('/privacy')); ?> |
            <?php echo CHtml::link(Yii::t('site', '家长监护'), $this->createAbsoluteUrl('/yaopin/site/gameSupervise.html')); ?> |
            <?php echo  Tool::getConfig('site', 'statisticsScript'); ?>
        </div>
        <?php if (!isset($this->module->id) && $this->id == 'site'): ?>
            <div class="friendsLinks w1200">
                <span><?php echo Yii::t('site', '友情链接') ?>：</span>
                <?php if (!empty($links)): ?>
                    <?php $str = ''; ?>
                    <?php foreach ($links as $l): ?>
                        <?php $str .= CHtml::link(Yii::t('help', $l['name']), $l['url'], array('target' => '_blank', 'title' => Yii::t('help', $l['name']))) . '|'; ?>
                    <?php endforeach; ?>
                    <?php echo rtrim($str, '|'); ?>
                <?php endif; ?>
                <span class="icon_v_h moreLinks" id="morefLinks"></span>
            </div>
        <?php endif; ?>
        <div class="copyRight w1200"><?php echo Tool::getConfig('site', 'copyright'); ?></div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
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
    })
</script>
