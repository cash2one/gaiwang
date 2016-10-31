<?php
// 返回顶部
/* @var $this Controller */
?>
<div class="backTop">
    <div class="bL">
        <a href="javascript:void(0)" title="<?php echo Yii::t('site', '返回顶部'); ?>" class="icon_v_h a1" id="backTop"></a>
        <?php echo CHtml::link('', $this->createAbsoluteUrl('/contact'), array('class' => 'icon_v_h a2', 'target' => '_blank', 'title' => Yii::t('site', '联系客服'))); ?>
        <?php echo CHtml::link('<span class="num" id="mian_botom_cartcount">0</span>', $this->createAbsoluteUrl('/orderFlow'), array('class' => 'icon_v_h a3', 'target' => '_blank', 'title' => Yii::t('site', '查看购物车'))); ?>
    </div>
    <?php //首页才显示 ?>
    <?php if ($this->id == 'site' && isset($this->action->id) && !isset($this->module->id)): ?>
        <div class="bR">
            <a href="#f0" title="<?php echo Yii::t('site', '线下'); ?>"><?php echo Yii::t('site', '线下'); ?></a>
            <a href="#f1" title="1F" class="curr">1F</a>
            <a href="#f2" title="2F">2F</a>
            <a href="#f3" title="3F">3F</a>
            <a href="#f4" title="4F">4F</a>
            <a href="#f5" title="5F">5F</a>
            <a href="#f6" title="6F">6F</a>
        </div>
    <?php endif; ?>
</div>
<script type="text/javascript">
	$(function() {
		/*回到顶部*/
		$("#backTop").click(function() {
			$('body,html').stop().animate({scrollTop: 0}, 500);
			return false;
		});
	})
</script>