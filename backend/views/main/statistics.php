<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo Yii::t('main','盖网通后台管理'); ?></title>
        <script type="text/javascript">
            document.domain = '<?php echo SHORT_DOMAIN; ?>';
        </script>
        <!--[if IE 6]>
        <script src="http://restest.<?php echo SHORT_DOMAIN ?>/Res/ucenter/images/DD_belatedPNG_0.0.8a.js" mce_src="http://restest.<?php echo SHORT_DOMAIN ?>/Res/ucenter/images/DD_belatedPNG_0.0.8a.js"></script>
        <script type="text/javascript">DD_belatedPNG.fix('*');</script>
        <![endif]-->
        <link rel="stylesheet" type="text/css" href="/css/common.css" />
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <script src="/js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
        <script src="/js/admin.js" type="text/javascript"></script>
        <script src="/js/barder.js" type="text/javascript"></script>
    </head>
    <body>
        <!--顶部-->
        <div id="dTop">
            <div class="topctx">
                <div class="logo" title="<?php echo Yii::t('main','盖网通网站管理'); ?>"><img alt="<?php echo Yii::t('main','盖网通网站管理'); ?>" src="/images/logo.png" /></div>
            </div>
            <div class="pnlInfo">
                <ul class="toolbar uinfo">
                    <li class="ico_quit"><?php echo CHtml::link(Yii::t('main','退出登录'), array('/site/logout')); ?></li>
                    <li class="ico_home"><a href="<?php echo SHORT_DOMAIN ?>" target="_blank"><?php echo Yii::t('main','盖网通首页'); ?></a></li>
                    <li class="ico_user"><?php echo Yii::t('main','欢迎'); ?><a href="javascript:void(0)"><?php echo $this->getUser()->name; ?></a></li>
                </ul>
            </div>
        </div>
        <!-- 导航 -->
        <div class="nav">
            <?php
            $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => Yii::t('main','用户信息'), 'url' => array('/main/userInfo')),
                    array('label' => '', 'itemOptions' => array('class' => 'hr')),
                    array('label' => Yii::t('main','网站配置管理'), 'url' => array('/main/siteConfigurationManagement')),
                    array('label' => '', 'itemOptions' => array('class' => 'hr')),
                    array('label' => Yii::t('main','管理员管理'), 'url' => array('/main/administrators')),
                    array('label' => '', 'itemOptions' => array('class' => 'hr')),
                    array('label' => Yii::t('main','会员管理'), 'url' => array('/main/memberManagement')),
                    array('label' => '', 'itemOptions' => array('class' => 'hr')),
                    array('label' => Yii::t('main','充值兑现管理'), 'url' => array('/main/rechargeCashManagement')),
                    array('label' => '', 'itemOptions' => array('class' => 'hr')),
                    array('label' => Yii::t('main','商城管理'), 'url' => array('/main/mallManagement')),
                    array('label' => '', 'itemOptions' => array('class' => 'hr')),
                    array('label' => Yii::t('main','统计管理'), 'url' => array('/main/statisticsManagement')),
                    array('label' => '', 'itemOptions' => array('class' => 'hr')),
                    array('label' => Yii::t('main','酒店管理'), 'url' => array('/main/hotelManagement')),
                    array('label' => '', 'itemOptions' => array('class' => 'hr')),
                    array('label' => Yii::t('main','微商城管理'), 'url' => array('/main/mshopManagement')),
                    array('label' => '', 'itemOptions' => array('class' => 'hr')),
                    array('label' => Yii::t('main','APP管理'), 'url' => array('/main/appManagement')),
                    array('label' => '', 'itemOptions' => array('class' => 'hr')),
                    array('label' => Yii::t('main','交易管理'), 'url' => array('/main/TradeManage')),
                    array('label' => '', 'itemOptions' => array('class' => 'hr')),
                    array('label' => Yii::t('main','团购管理'), 'url' => array('/main/groupbuyManage')),
                ),
            ));
            ?>
        </div>
        <!-- 导航 end -->
        <!--主体-->
        <div class="c-head"></div>
        <div class="bar-hs2"></div>
        <div id="dLeft" style="float: left">
            <div class="bar-top"></div>
            <div class="navTitle"><em class="ico_mus"></em><?php echo Yii::t('main','导航目录'); ?></div>
            <div class="bar-hs"></div>
            <div class="actionGroup">
                <?php if (is_array($menus)): ?>
                    <?php $i = 1; ?>
                    <?php foreach ($menus as $key => $value): ?>
                        <h3 <?php if ($i == 1): ?>class="hover"<?php endif; ?>><em class="ico-1"></em><a href="javascript:void(0)"><?php echo $key; ?></a></h3>
                        <div class="ctx" <?php if ($i == 1): ?>style="display: block;"<?php endif; ?>>
                            <ul>
                                <?php foreach ($value['sub'] as $k => $v): ?>
                               
                                    <?php if (Yii::app()->user->checkAccess(str_replace(' ', '.', ucwords(str_replace('/', ' ', trim($v, '/')))))): ?>
                                    <li class="item"><a href="javascript:app.openUrl('<?php echo Yii::app()->createUrl($v); ?>')">▪ <?php echo $k; ?></a></li>  
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="links"><div class="t-hr"></div> <?php echo Yii::t('main','技术支持:广州涌智信息科技有限公司'); ?></div>
            <div class="bar-footer"></div>
        </div>
        <!--div id="dSplitbar">
            <a class="btn" href="javascript:app.togSidebar()" title="收起侧边栏"><img src="backoffice/style/images/bar-hs.gif" width="15" height="110" /></a>
        </div-->
        <div id="dBody">
        	<iframe id="dCtxFrame" name="dCtxFrame" frameborder="0" scrolling="yes" class="adminFrame" style="overflow: visible;" src="<?php echo Yii::app()->createUrl('statistics/index')?>"></iframe>
        </div>
    </body>
</html>
