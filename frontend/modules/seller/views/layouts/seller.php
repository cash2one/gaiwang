<?php
// 店家布局文件
/* @var $this SController */
?>
<!--[if lt IE 8]><script>window.location.href="http://seller.<?php echo SHORT_DOMAIN ?>/home/notSupported"</script><![endif]-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="" />
        <meta name="Description" content="" />
        <title><?php echo CHtml::encode($this->pageTitle) ?></title>
        <link rel="shortcut icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
            <link rel="icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
                <link href="<?php echo CSS_DOMAIN; ?>global.css" rel="stylesheet" type="text/css" />
                <link href="<?php echo CSS_DOMAIN; ?>seller.css" rel="stylesheet" type="text/css" />
                <link href="<?php echo CSS_DOMAIN; ?>custom.css" rel="stylesheet" type="text/css"/>
                <link href="<?php echo CSS_DOMAIN; ?>custom-seller.css" rel="stylesheet" type="text/css"/>
                <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
                <!--处理IE6中透明图片兼容问题-->
                <!--[if IE 6]>
                <script type="text/javascript" src="../js/DD_belatedPNG.js" ></script>
                <script type="text/javascript">
                    DD_belatedPNG.fix('.logo img,.menu dl dt a,.menu dl dd ul li a');
                </script>
                <![endif]-->
                <script type="text/javascript">
                    function showHide01(m, objname, n) {
                        for (var i = 0; i <= n; i++) {
                            $("#" + objname + i).css('display', 'none');
                        }
                        $("#" + objname + m).css('display', 'block');
                        $("#menu dl").removeClass('curr');
                        $("#" + objname + m).parent().addClass('curr');
                    }
                    $(function() {
                        var height = parseInt($(document).height()) - 81;
                        $("#menu").css('height', height);
                    })
                </script>
                </head>
                <body>
                    <div class="wrap">
                        <div class="header">
                            <div class="bg">
                                <table width="100%" height="80" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class="logo"><img src="<?php echo DOMAIN; ?>/images/bg/logo_seller.png" width="318" height="62" /></td>
                                        <td class="td_quickmenu">
                                            <div class="admin clearfix" style="width:auto;">
                                                <b class="b1">
                                                    <img src="<?php echo isset($this->getUser()->avatar) ? Tool::showImg(ATTR_DOMAIN . '/' . $this->getUser()->avatar, 'c_fill,h_38,w_38') : null ?>" style="width:38px;height:38px;" />
                                                </b>
                                                <div class="info_wrap">
                                                    <div class="welcome" style="width:auto;height: 20px;overflow: hidden">
                                                        <?php echo Yii::t('seller', '欢迎您，'); ?>
                                                        <span><?php echo $this->getUser()->name; ?></span>
                                                    </div>
                                                    <span class="info clearfix">
                                                        <?php echo CHtml::link(Yii::t('seller', '盖象商城'), DOMAIN, array('target' => '_blank')); ?>&nbsp;|&nbsp;
                                                        <?php echo CHtml::link(Yii::t('seller', '退出登录'), array('/seller/home/logout')); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="main clearfix">
                            <div class="menu" id="menu">
                                <div class="menu_wrap">
                                    <?php
                                    Tool::pr($this->getSession('isCityshow'));
                                    $menus = include(Yii::getPathOfAlias('application') . DS . 'config' . DS . 'sellerMenu.php');
                                    if (!$this->getSession('franchiseeId')) {
                                        unset($menus['bizManage']);
                                    }
                                    if (!$this->getSession('assistantId'))
                                        unset($menus['assistantInfo']);
                                    if($this->getSession('isCityshow'))
                                        unset($menus['cityShowManage']);
                                    if($this->getSession('isMidAgent')==Store::STORE_ISMIDDLEMAN_NO)
                                        unset($menus['middleAgentManage']);
                                   
                                    ?>
                                    <?php $i = 0; ?>
                                    <?php foreach ($menus as $k => $menu): ?>
                                        <?php if (!AssistantPermission::checkAssistant($k)) continue; //检查店小二权限 ?>
                                        <?php $showMenu = $this->showMenu($menu['children']); ?>
                                        <dl class="<?php echo $menu['class'] ?> <?php echo $showMenu ? 'curr' : '' ?>">
                                            <dt>
                                                <a onclick="showHide01(<?php echo $i ?>, 'items', 6);" class="on"><?php echo $menu['name'] ?></a>
                                            </dt>
                                            <dd id="items<?php echo $i; ?>" style="display: <?php echo $showMenu ? 'block' : 'none' ?>" >
                                                <ul>
                                                    <?php foreach ($menu['children'] as $val => $url): ?>
                                                        <?php
                                                        $link = is_array($url) ? $url['value'] : $url;
                                                        if (!AssistantPermission::checkAssistant($link))
                                                            continue; //检查店小二权限
                                                        ?>
                                                        <li>
                                                            <?php echo CHtml::link($val, $this->createAbsoluteUrl($link)) ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </dd>
                                        </dl>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                            <div class="workground">
                                <div class="workground_wrap">
                                    <div class="position">
                                        <?php echo Yii::t('seller', '当前位置'); ?>：
                                        <?php
                                        $acts = array('create', 'update', 'edit','detail','mouthAccount','accountDay','parterList', 'storeAdd');
                                        $action = $this->getAction()->id;
                                        if (in_array($action, $acts) || (isset($this->showBack) && $this->showBack == true))
                                            echo CHtml::link(Yii::t('seller', '返回列表'), 'javascript:history.back()', array('class' => 'regm-sub'));
                                        ?>
                                        <?php
                                        $this->widget('zii.widgets.CBreadcrumbs', array(
                                            'homeLink' => false,
                                            'links' => $this->breadcrumbs,
                                            'tagName' => 'span',
                                            'inactiveLinkTemplate' => '<b>{label}</b>',
                                            'separator' => ' &gt; ',
                                        ));
                                        ?>

                                    </div>
                                    <div class="mainContent">
                                        <?php echo $content; ?>
                                        <script>
                    //给普通超链接添加颜色
                    $(".mainContent a").each(function() {
                        var that = $(this);
                        if (that.find('span').length == 0 && that.attr('class') == undefined && !that.parent().hasClass('selected')) {
                            that.css('color', '#3366CC');
                        }
                    });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--弹窗提示-->
                    <?php $this->renderPartial('/layouts/_msg'); ?>
                    <?php
                    $tips = isset($this->storeId) ? Design::getTipsStatus($this->storeId) : '';
                    ?>
                    <script>
                        //店铺装修
                        var $designLink = $(".menu dl dd ul li a[href='http://seller.<?php echo SHORT_DOMAIN ?>/design/main']");
                        $designLink.attr('target', '_blank');
                        $designLink.append('<span style="color: #fff; background: #c22e2e; display: inline-block; padding: 0 5px;"><?php echo $tips ?></span>');
                    </script>
                </body>
                </html>