<?php
//店铺首页布局文件
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="Keywords" content="<?php echo CHtml::encode($this->keywords) ?>"/>
    <meta name="Description" content="<?php echo CHtml::encode($this->description) ?>"/>
    <title><?php echo CHtml::encode($this->pageTitle) ?></title>
    <link rel="shortcut icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
    <link rel="icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
    <link href="<?php echo CSS_DOMAIN ?>global.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_DOMAIN ?>module.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_DOMAIN; ?>custom.css" rel="stylesheet" type="text/css"/>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <script src="<?php echo DOMAIN ?>/js/jquery.gate.common.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            /* 店铺分类二级菜单*/
            $(".prodMenu dt a").each(function (index) {
                $(this).click(function () {
                    if ($(this).hasClass('iconAdd')) {
                        $(this).removeClass("iconAdd").addClass("iconMinus");
                        $(this).parents('dt').siblings('dd').show();
                    } else {
                        $(this).removeClass("iconMinus").addClass("iconAdd");
                        $(this).parents('dt').siblings('dd').hide();
                    }
                });
            });
        })
    </script>
    <!--处理IE6中透明图片兼容问题-->
    <!--[if IE 6]>
    <script type="text/javascript" src="<?php echo DOMAIN ?>/js/DD_belatedPNG.js"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('.icon_v,.icon_v_h,.adbg,.gwHelp dl dd,.column .category li');
    </script>
    <![endif]-->
    <!--店铺装修背景设置-->
    <?php if ($this->id == 'shop' && isset($this->design)): ?>
        <style type="text/css">
            body {
            <?php if($this->design->DisplayBgImage): ?> background-image: url('<?php echo IMG_DOMAIN.'/'.$this->design->BGImg ?>');
                background-repeat: <?php echo $this->design->BGRepeat ?>;
                background-position: <?php echo $this->design->BGPosition ?>;
            <?php else: ?> background-color: <?php echo $this->design->BGColor ?>;
            <?php endif; ?>
            }
        </style>
    <?php endif; ?>
    <?php if ($this->action->id == 'preview' || $this->action->id == 'storePreview'): ?>
        <style type="text/css">
            .headWrap {
                position: relative;
            }

            .previewImg {
                position: absolute;
                background: url("<?php echo DOMAIN.'/images/bg/yulan.png' ?>") no-repeat;
                width: 149px;
                height: 85px;
                top: 80px;
                left: 100px;
            }
        </style>
    <?php endif; ?>
</head>
<body>
<div class="wrap">
    <div class="header">
        <?php $this->renderPartial('//layouts/_goodstop'); ?>
        <?php $this->renderPartial('//layouts/_top3'); ?>
        <?php $this->renderPartial('//layouts/_nav4'); ?>
    </div>

    <div class="main w1200">
        <?php echo $content; ?>
    </div>
</div>
<!--底部 begin-->
<?php $this->renderPartial('//layouts/_footer'); ?>

<?php $this->renderPartial('//layouts/_gotop'); ?>
<!-- 返回顶部 end-->

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <script src="<?php echo DOMAIN; ?>/js/artDialog/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
    <script type="text/javascript">
        //成功样式的dialog弹窗提示
        art.dialog({
            icon: 'succeed',
            content: '<?php echo Yii::app()->user->getFlash('success'); ?>',
            ok: true,
            okVal: '<?php echo Yii::t('member','确定') ?>',
            title: '<?php echo Yii::t('member','消息') ?>'
        });
    </script>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error')): ?>
    <script src="<?php echo DOMAIN; ?>/js/artDialog/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
    <script type="text/javascript">
        //错误样式的dialog弹窗提示
        art.dialog({
            icon: 'error',
            content: <?php echo json_encode(Yii::app()->user->getFlash('error')); ?>,
            ok: true,
            okVal: '<?php echo Yii::t('member','确定') ?>',
            title: '<?php echo Yii::t('member','消息') ?>'
        });
    </script>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('warning')): ?>
    <script src="<?php echo DOMAIN; ?>/js/artDialog/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
    <script type="text/javascript">
        //警告样式的dialog弹窗提示
        art.dialog({
            icon: 'warning',
            content: '<?php echo Yii::app()->user->getFlash('warning'); ?>',
            ok: true,
            okVal: '<?php echo Yii::t('member','确定') ?>',
            title: '<?php echo Yii::t('member','消息') ?>'
        });
    </script>
<?php endif; ?>

</body>
</html>