<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="盖网,网上购物,网上商城,积分兑换,积分消费,手机,笔记本,电脑,数码,服装,手表,化妆品,保健品,盖象商城"/>
    <meta name="Description" content="盖网,盖象商城-中国最大的网上购物及积分兑换消费商城，便捷，诚信的服务,为您提供愉悦的网上商城购物体验!"/>
    <title><?php echo CHtml::encode($this->pageTitle) ?></title>
    <link href="<?php echo DOMAIN.Yii::app()->theme->baseUrl;?>/styles/global.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo DOMAIN.Yii::app()->theme->baseUrl;?>/styles/module.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo DOMAIN.Yii::app()->theme->baseUrl;?>/styles/member.css" rel="stylesheet" type="text/css"/>

    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <script src="<?php echo DOMAIN.Yii::app()->theme->baseUrl;?>/js/jquery.gate.common.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl;?>/js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo DOMAIN ?>/js/jquery.tips.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/layer/layer.js"></script>

</head>
<body>
<!-- 头部start -->

<?php $this->renderPartial('//layouts/_top_v20'); ?>

<div class="member-top">
    <div class="w1200 clearfix">
        <a href="<?php echo $this->createAbsoluteUrl('/member/site/index');?>" class="member-logo"></a>
        <div class="member-nav fl clearfix">
            <a href="<?php echo $this->createAbsoluteUrl('/member/site/index'); ?>"><?php echo Yii::t('site', '首页');?></a>
            <a href="<?php echo $this->createAbsoluteUrl('/member/goodsCollect'); ?>"><?php echo Yii::t('site', '我的收藏');?></a>
            <a href="<?php echo $this->createAbsoluteUrl('/member/member/accountSafe'); ?>"><?php echo Yii::t('site', '账户安全');?></a>
            <a href="<?php echo $this->createAbsoluteUrl('/member/message/index'); ?>"><?php echo Yii::t('site', '消息');?>（<span id="message_num">0</span>）</a>
        </div>
        <form action="<?php echo $this->createAbsoluteUrl('/search/search'); ?>" class="member-search clearfix" method="get">
            <input type="text" class="search-input" name="q" placeholder="<?php echo Yii::t('site', '输入关键词进行搜索'); ?>" />
            <input type="submit" class="search-btn" value="<?php echo Yii::t('site', '搜索');?>"/>
        </form>
    </div>
</div>
<!-- 头部end -->

<?php echo $content ?>

<!-- 底部start -->
<?php $this->renderPartial('//layouts/_footer_v20'); ?>
<?php $this->renderPartial('//member/layouts/_msg'); ?>
<!-- 底部end -->

<script language="javascript">
$(document).ready(function(e) {
    $.ajax({
		type: "GET",
		dataType: "json",
		url: "<?php echo $this->createAbsoluteUrl('/member/site/getNewMessage') ?>",
		data: {},
		success: function(data) {
			$('#message_num').html(data.count);
		}
	});
});
</script>
</body>
</html>