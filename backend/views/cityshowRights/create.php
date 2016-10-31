<?php
/* @var $this CityshowRightsController */
/* @var $model CityshowRights */

$this->breadcrumbs = array(
    '城市馆权限管理 ',
    '添加商家',
);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $this->pageTitle; ?></title>
    <link rel="shortcut icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
    <link rel="icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/reg.css'); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            var bodyWidth = $(".main").width();
            var ws = bodyWidth - 9;
            $(".t-com").width(ws)
            $(window).resize(function () {
                var bodyWidth = $(".main").width();
                var ws = bodyWidth - 9;
                $(".ws").width(ws)
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tab-come ').each(function () {
                $(this).find('tr:even td').addClass('even');
                $(this).find('tr:odd td').addClass('odd');
                $(this).find('tr:even th').addClass('even');
                $(this).find('tr:odd th').addClass('odd');
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tab-reg ').each(function () {
                $(this).find('tr:even td').css("background", "#eee");
                $(this).find('tr:odd td').css("background", "#fff");
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var $thi = $('body,html').find("#u_title li");
            $($thi).hover(function () {
                $(this).addClass("cur").siblings().removeClass("cur");
                var $as = $("#con .con_listbox").eq($("#u_title li").index(this));
                $as.show().siblings().hide();
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tab-reg2').find('.info').hover(function () {
                $(this).find('td').css({"background": "rgba(255, 184, 0, 0.2)"});
                $(this).next('.user').find('td').css({"background": "rgba(255, 184, 0, 0.2)"});
            }, function () {
                $(this).find('td').removeAttr("style");
                $(this).next('.user').find('td').removeAttr("style");
            });

            $('.tab-reg2').find('.user').hover(function () {
                $(this).find('td').css({"background": "rgba(255, 184, 0, 0.2)"});
                $(this).prev().find('td').css({"background": "rgba(255, 184, 0, 0.2)"});
            }, function () {
                $(this).find('td').removeAttr("style");
                $(this).prev().find('td').removeAttr("style");
            });
        });
    </script>

</head>
<body>
<div class="main">
    <div class="com-box" style="padding:40px;min-height:50px;">
        <?php $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>
</body>

</html>
