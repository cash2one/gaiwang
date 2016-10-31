<?php
/**
 * 迷你layout，只包含最简单的头部跟尾部，不包含logo
 *
 * @var $this Controller
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="<?php echo empty($this->keywords) ? '' : $this->keywords; ?>" />
    <meta name="Description" content="<?php echo empty($this->description) ? '' : $this->description; ?>" />
    <title><?php echo empty($this->pageTitle) ? '' : $this->pageTitle; ?></title>
    <script src="<?php echo $this->theme->baseUrl.'/'; ?>js/jquery.gate.common.js"></script>
</head>

<body>

<?php $this->renderPartial('//layouts/_top_v20'); ?>
<?php $this->renderPartial('//layouts/_msg'); ?>

<!-- 首页主体start -->
<?php echo $content; ?>
<!-- 首页主体end -->
<?php $this->renderPartial('//layouts/_footer_v20'); ?>

</body>
</html>
