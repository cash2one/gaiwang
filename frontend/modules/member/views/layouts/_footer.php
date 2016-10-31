<?php
// 底部
/* @var $this Controller */
?>
<div class="footer clearfix">
    <div class="footLink">
        <div class="gwLinks">
            <?php echo CHtml::link(Yii::t('site', '关于盖网'), $this->createAbsoluteUrl('/about')); ?> | 
			<?php echo CHtml::link(Yii::t('site', '帮助中心'), $this->createAbsoluteUrl('/help')); ?>  |
			<?php echo CHtml::link(Yii::t('site', '网站地图'), $this->createAbsoluteUrl('/sitemap')); ?>  | 
			<?php echo CHtml::link(Yii::t('site', '诚聘英才'), $this->createAbsoluteUrl('/job')); ?>  | 
			<?php echo CHtml::link(Yii::t('site', '联系客服'), $this->createAbsoluteUrl('/contact')); ?>  | 
			<?php echo CHtml::link(Yii::t('site', '免责声明'), $this->createAbsoluteUrl('/statement')); ?>  | 
			<?php echo CHtml::link(Yii::t('site', '隐私保护'), $this->createAbsoluteUrl('/privacy')); ?>
           <!--<p><?php echo  Tool::getConfig('site','copyright');  ?></p>-->
        </div>
		<div class="copyRight w1200"><?php echo Tool::getConfig('site', 'copyright'); ?></div>
		<!--<p class="ico_j"><span class="ico_f1"> </span><span class="ico_f2"> </span><span class="ico_f3"> </span><span class="ico_f4"> </span></p>-->
    </div>
</div>
<?php echo  Tool::getConfig('site', 'statisticsScript'); ?>