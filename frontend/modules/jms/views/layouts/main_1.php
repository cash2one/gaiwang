<?php
// 加盟商模块布局1文件
/* @var $this Controller */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->keywords; ?>" />
<meta name="Description" content="<?php echo $this->description; ?>" />
<title><?php echo $this->pageTitle; ?></title>
<link href="<?php echo CSS_DOMAIN; ?>global.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_DOMAIN; ?>module.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_DOMAIN; ?>jquery.jcarousel.skin.css" rel="stylesheet" type="text/css" />
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<script>
            document.domain = "<?php echo substr(DOMAIN, 11) ?>";
</script>
<script src="<?php echo DOMAIN; ?>/js/jquery-gate.js" type="text/javascript"></script>
<script src="<?php echo DOMAIN; ?>/js/jquery.jcarousel.min.js" type="text/javascript"></script>
<!--处理IE6中透明图片兼容问题-->
<!--[if IE 6]>
<script type="text/javascript" src="../js/DD_belatedPNG.js" ></script>
<script type="text/javascript">
DD_belatedPNG.fix('img,background,body,div,span,.trans,a,input,i');
</script>
<![endif]-->
<script type="text/javascript">
$(function(){
	if($("#mycarousel li").size()>5){
		$('#mycarousel').jcarousel({
			wrap: 'circular',
			auto: 2
		});
	}else{
		$('#mycarousel').jcarousel({
			auto: 2
		});
	}
	
})
</script>
</head>
    <body>
        <div class="wrap">
            <div class="header">
                <?php $this->renderPartial('//layouts/_top'); ?>
                <?php $this->renderPartial('//layouts/_top2'); ?>
                <?php $this->renderPartial('//layouts/_nav2'); ?>
            </div>
           
             <?php echo $content; ?>
       
            <?php $this->renderPartial('//layouts/_footer'); ?>
        </div>
    </body>
</html>
