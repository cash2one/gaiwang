<?php 
/* @var $this Controller */
    $infos = Article::getHelpInfo();
    $alias=$this->getParam('alias');
    $article = Article::fileCache($alias);
    $keywords=isset($article['keywords']) ? $article['keywords'] : '';
    $description=isset($article['description']) ? $article['description'] : '';
    $title=isset($article['title']) ? $article['title'] : '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="<?php echo empty($keywords) ? '盖象,网上购物,网上商城,积分兑换,积分消费,帮助中心,购物指南,盖象商城' : $keywords; ?>" />
    <meta name="Description" content="<?php echo empty($description) ? '盖象商城（G-emall.com）帮助中心是盖象商城为用户开设的网上购物的帮助平台，提供常见问题查询，商家合作入驻加盟指引，购物指南，盖象商城积分使用说明，自助服务受理等服务，同时提供盖象商城客服人工在线咨询及24小时服务热线，服务热线：400-620-6899' : $description; ?>" />
    <title><?php echo empty($title) ? '帮助中心-盖象商城' : $title.'_帮助中心-盖象商城'; ?></title>
    <link href="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/styles/global.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/styles/module.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/styles/help.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/js/jquery-1.9.1.js" type="text/javascript"></script>
    <script src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/js/jquery.gate.common.js"></script>
    <script type="text/javascript">
        $(function () {
            /*【常用自动服务】布局 by吴晓兵 2015-06-12*/
            $(".auto-service li:last-child").css("padding-right", "0");
        })
    </script>
    <script>
		$(function(){
			$(".nav-ul li").hover(function(){
				$(this).addClass("nav-itemSel");
				$(this).find(".nav-item-zj").show();
			},function(){
				$(this).removeClass("nav-itemSel");
				$(this).find(".nav-item-zj").hide();
			});
		});
	</script>
    <!--[if lt IE 9]>
    <style>
        /*IE 8 兼容rgba的样式*/
        .color-block { background:transparent; filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000,endColorstr=#99000000); zoom: 1; }
    </style>
    <![endif]-->
</head>
<body>
<!-- 头部start -->
<?php $this->renderPartial('//layouts/_top_v20'); ?>
<div class="help-top">
    <div class="w1200 clearfix">
        <a href="<?php echo DOMAIN ?>" title="盖象商城" class="help-logo"></a>
        <span class="help-logo-title"><?php echo Yii::t('help', '帮助中心')?></span>
    </div>
</div>
<div class="help-nav">
	<ul class="nav-ul">
		<li <?php if($this->id =='site'): ?>class="nav-itemSel" <?php endif;?>>
		   <a style="color: #f6f6f6" href="<?php echo $this->createAbsoluteUrl('/help/site/');?>">首页</a>
		</li>
		 <?php foreach ($infos as $v):?>
		 <li <?php if (isset($article['category_id']) && ($article['category_id'] == $v['id'])): ?> class="nav-itemSel" <?php endif; ?>>
			<?php echo Yii::t('help', $v['name']) ?>
			<div class="nav-item-zj">
			   <?php foreach ($v['child'] as $c): ?>
				  <?php echo CHtml::link(isset($article['alias']) && $article['alias'] == $c['alias'] ? Yii::t('help', $c['title']) : Yii::t('help', $c['title']) , $this->createAbsoluteUrl('/help/article/view', array('alias' => $c['alias']))); ?>
				<?php endforeach; ?>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<?php if($this->id !='site'):?>
<div class="gx-main" style="padding-top:40px;padding-bottom:50px;">
   <div class="help-contain clearfix">
   <?php $this->renderPartial('/layouts/_left',array('infos'=>$infos,'article'=>$article)); ?>
   <?php echo $content; ?>
   </div>
 </div>
 <?php else:?>
 <div class="gx-main">
   <div class="help-contain clearfix">
   <?php echo $content; ?>
   </div>
 </div>
 <?php endif;?>
<?php $this->renderPartial('//layouts/_footer_v20'); ?>
</body>
</html>
