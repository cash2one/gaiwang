<?php
/**
 * 注册 layout
 *
 * @var $this HomeController
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content=""/>
    <meta name="Description" content=""/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link href="<?php echo $this->theme->baseUrl.'/'; ?>styles/global.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->theme->baseUrl.'/'; ?>styles/module.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->theme->baseUrl.'/'; ?>styles/register.css" rel="stylesheet" type="text/css" />
</head>

<body class="login-page">

<!-- 首页主体start -->

        <?php echo $content; ?>

<!-- 首页主体end -->

<?php $this->renderPartial('/layouts/_footer_reg'); ?>

</body>
</html>
