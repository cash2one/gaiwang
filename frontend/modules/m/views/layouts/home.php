<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
        <link rel="bookmark" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
        <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/global.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/comm.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/member.css"/>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>
        <div class="wrap">
            <div class="header" id="js-header">
                <div class="mainNav">
                    <div class="topNav clearfix">
                        <?php if ($this->action->id != 'agreement'): ?>
                            <a class="icoBlack fl" href="<?php echo $this->createAbsoluteUrl('member/index'); ?>"></a>
                        <?php else: ?>
                            <a class="icoBlack fl" href="javascript:history.go(-1);"></a>
                        <?php endif; ?>
                        <a class="TxtTitle fl" href="javascript:void(0);"><?php echo $this->showTitle; ?></a>
                    </div>
                </div>
            </div>
            <!--content start -->
            <?php echo $content; ?>
            <!--content end -->
            <?php
            Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/m/member.js', CClientScript::POS_HEAD);
            ?>
        </div>
    </body>
</html>
