<?php
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/global.css');
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/module.css');
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/cart.css');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="<?php echo empty($this->keywords) ? '' : $this->keywords; ?>" />
    <meta name="Description" content="<?php echo empty($this->description) ? '' : $this->description; ?>" />
    <title><?php echo empty($this->pageTitle) ? '' : $this->pageTitle; ?></title>
</head>
<body class="body-404">
<!-- 头部start -->
<div class="pages-header">
    <div class="w1200">
        <div class="pages-logo mt20"><a href="<?php echo DOMAIN?>"><img src="<?php echo Yii::app()->theme->baseUrl ?>/images/bgs/top_logo.png" width="187" height="56" /></a></div>
    </div>
</div>
<!-- 头部end -->
<div style="display:none;"><?php echo $message ?></div>
<?php
//框架自动提示的文字，包含无法，则统一用：哎呀，你所访问的页面潜水了，请稍后访问
if(stripos($message,'无法')!==false){
    $message = Yii::t('site', '哎呀，你所访问的页面潜水了，请稍后访问 !');
}
?>
<!--主体start-->
<div class="shopping-cart">
    <div class="bankCard">
        <div class="bankCard-conter bankCard-conter2">
            <img src="<?php echo Yii::app()->theme->baseUrl ?>/images/bgs/404.jpg" width="1000" />
            <div class="but-info">
                <span class="but-title"><?php echo CHtml::encode($message) ?></span>
                建议您：</br>
                1.看看输入的文字是否有误</br>
                2.刷新页面重试
                <a href="<?php echo DOMAIN ?>" class="but-404">返回首页</a>
            </div>
        </div>
    </div>
</div>

<div style="display: none">
    <?php echo Tool::authcode($trace) ?>
</div>
<!-- 主体end -->
</body>
</html>