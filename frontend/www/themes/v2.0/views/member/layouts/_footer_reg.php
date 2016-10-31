<?php
// 底部
/* @var $this Controller */
?>

<!-- 底部start -->
<div class="pages-footer">
    <div class="w1200">
        <div class="links">
            <?php echo CHtml::link(Yii::t('site', '关于盖网'), $this->createAbsoluteUrl('/about'), array('target' => '_blank')); ?>
            |
            <?php echo CHtml::link(Yii::t('site', '帮助中心'), $this->createAbsoluteUrl('/help'), array('target' => '_blank')); ?>
            |
            <?php echo CHtml::link(Yii::t('site', '网站地图'), $this->createAbsoluteUrl('/sitemap'), array('target' => '_blank')); ?>
            |
            <?php echo CHtml::link(Yii::t('site', '诚聘英才'), $this->createAbsoluteUrl('/job'), array('target' => '_blank')); ?>
            |
            <?php echo CHtml::link(Yii::t('site', '联系客服'), $this->createAbsoluteUrl('/contact'), array('target' => '_blank')); ?>
            |
            <?php echo CHtml::link(Yii::t('site', '免责声明'), $this->createAbsoluteUrl('/statement'), array('target' => '_blank')); ?>
            |
            <?php echo CHtml::link(Yii::t('site', '隐私保护'), $this->createAbsoluteUrl('/privacy'), array('target' => '_blank')); ?>
            |
            <?php //echo CHtml::link(Yii::t('site', '家长监护'), $this->createAbsoluteUrl('/yaopin/site/gameSupervise.html')),'|'; ?>
            <?php
            //访问统计脚本
            echo  Tool::getConfig('site', 'statisticsScript');
            ?>
        </div>
        <div class="copyright">
            Copyright&copy;g-emall.com&nbsp;|&nbsp;增值电信业务经营许可证：粤B2-20140364&nbsp;|&nbsp;粤ICP备14049968号-2&nbsp;|&nbsp;互联网药品信息服务资格证&nbsp;|&nbsp;网络文焕经营许可证&nbsp;|&nbsp;穗公网监备案证第440700500100
        </div>
    </div>
</div>
<!-- 底部end -->
