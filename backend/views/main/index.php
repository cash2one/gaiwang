<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo Yii::t('main', '盖网通后台管理'); ?></title>
        <script type="text/javascript">
            document.domain = '<?php echo SHORT_DOMAIN ?>';
        </script>
        <!--[if IE 6]>
        <script src="http://restest.<?php echo SHORT_DOMAIN ?>/Res/ucenter/images/DD_belatedPNG_0.0.8a.js" mce_src="http://restest.<?php echo SHORT_DOMAIN ?>/Res/ucenter/images/DD_belatedPNG_0.0.8a.js"></script>
        <script type="text/javascript">DD_belatedPNG.fix('*');</script>
        <![endif]-->
        <link rel="stylesheet" type="text/css" href="/css/common.css" />
        <link href="/css/help.css" rel="stylesheet" type="text/css">  
            <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <script src="/js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
            <script src="/js/admin.js" type="text/javascript"></script>
            <script type="text/javascript">
            default_mod = 'system';
            default_url = '<?php echo Yii::app()->createAbsoluteUrl('/site'); ?>';
			//导航响应式--开始
			$(function(){
				$(".nav-yc").hover(function(){
					$(this).find("ul").show();
				},function(){
					$(this).find("ul").hide();
				});
			})
			function adjust(){
				if($(".nav-yc ul li").length>0){//窗体大小变化隐藏菜单是否有值，有值就先还原
					$(".nav-yc ul li").each(function(index,obj){
						$(".nav ul").append($(obj));
						$(".nav ul").append("<li class=hr><span></span></li>");
						$(".nav-yc ul").empty();
					});
				}
				var navW=parseInt($(".nav").css("width"));//导航宽度
				var ulW=parseInt($(".nav ul").css("width"));//导航内容的宽度
			    var liW=$(".nav ul li");
				var liTotal=0;
				var i=0;
			    $(".nav ul li").each(function(index,obj){//隐藏菜单赋值
					liTotal+=parseInt($(obj).css("width"));
				    if(liTotal>(navW-100)){//每个li相加的长度是否大于当前屏幕宽度
						$(obj).next(".hr").detach();
						if($(obj).attr("class")!="hr"){
							$(".nav-yc").show();
							$(".nav-yc ul").append($(obj));//li菜单长度大于屏幕长度就赋值到隐藏菜单
							
						}
				    }else{
							$(".nav-yc").hide();
						}
			    });
			}
			window.onload=function(){  
				window.onresize = adjust;  
				adjust();
			}  
			//导航响应式--结束
            </script>
            <script src="/js/barder.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="dTop">
            <div class="topctx">
                <div class="logo" title="<?php echo Yii::t('main', '盖网通网站管理'); ?>"><img alt="<?php echo Yii::t('main', '盖网通网站管理'); ?>" src="/images/logo.png" /></div>
            </div>
            <div class="pnlInfo">
                <ul class="toolbar uinfo">
                    <li class="ico_quit"><?php echo CHtml::link(Yii::t('main', '退出登录'), $this->createAbsoluteUrl('/site/logout')); ?></li>
                    <li class="ico_home"><a href="<?php echo DOMAIN ?>" target="_blank"><?php echo Yii::t('main', '盖象商城首页'); ?></a></li>
                    <li class="ico_user"><?php echo Yii::t('main', '欢迎'); ?><a href="javascript:void(0)"><?php echo $this->getUser()->name; ?></a></li>
                </ul>
            </div>
        </div>
        <div class="nav">
            <ul id="yw0">
                <li <?php if ($this->action->id == 'userInfo'): ?>class="active"<?php endif; ?>><?php echo CHtml::link(Yii::t('main', '用户信息'), array('/main/userInfo')); ?></li>
                <li class="hr"><span></span></li>

                <?php if (Yii::app()->user->checkAccess('Main.SiteConfigurationManagement')): ?>
                    <li <?php if ($this->action->id == 'siteConfigurationManagement'): ?>class="active"<?php endif; ?>><?php echo CHtml::link(Yii::t('main', '网站配置管理'), array('/main/siteConfigurationManagement')); ?></li>
                    <li class="hr"><span></span></li>
                <?php endif; ?>

                <?php if (Yii::app()->user->checkAccess('Main.Administrators')): ?>
                    <li <?php if ($this->action->id == 'administrators'): ?>class="active"<?php endif; ?>><?php echo CHtml::link(Yii::t('main', '管理员管理'), array('/main/administrators')); ?></li>
                    <li class="hr"><span></span></li>
                <?php endif; ?>

                <?php if (Yii::app()->user->checkAccess('Main.MemberManagement')): ?>
                    <li <?php if ($this->action->id == 'memberManagement'): ?>class="active"<?php endif; ?>><?php echo CHtml::link(Yii::t('main', '会员管理'), array('/main/memberManagement')); ?></li>
                    <li class="hr"><span></span></li>
                <?php endif; ?>

                <?php if (Yii::app()->user->checkAccess('Main.RechargeCashManagement')): ?>
                    <li <?php if ($this->action->id == 'rechargeCashManagement'): ?>class="active"<?php endif; ?>><?php echo CHtml::link(Yii::t('main', '充值兑现管理'), array('/main/rechargeCashManagement')); ?></li>
                    <li class="hr"><span></span></li>
                <?php endif; ?>

                <?php if (Yii::app()->user->checkAccess('Main.MallManagement')): ?>
                    <li <?php if ($this->action->id == 'mallManagement'): ?>class="active"<?php endif; ?>><?php echo CHtml::link(Yii::t('main', '商城管理'), array('/main/mallManagement')); ?></li>
                    <li class="hr"><span></span></li>
                <?php endif; ?>

                <?php if (Yii::app()->user->checkAccess('Main.statisticsManagement')): ?>
                    <li <?php if ($this->action->id == 'statisticsManagement'): ?>class="active"<?php endif; ?>><?php echo CHtml::link(Yii::t('main', '统计管理'), array('/main/statisticsManagement')); ?></li>
                    <li class="hr"><span></span></li>
                <?php endif; ?>    

                <?php if (Yii::app()->user->checkAccess('Main.HotelManagement')): ?>
                    <li <?php if ($this->action->id == 'hotelManagement'): ?>class="active"<?php endif; ?>><?php echo CHtml::link(Yii::t('main', '酒店管理'), array('/main/hotelManagement')); ?></li>
                    <li class="hr"><span></span></li>
                <?php endif; ?>
                
                <?php if (Yii::app()->user->checkAccess('Main.MshopManagement')): ?>
                    <li <?php if ($this->action->id == 'mshopManagement'): ?>class="active"<?php endif; ?>><?php echo CHtml::link(Yii::t('main', '微商城管理'), array('/main/mshopManagement')); ?></li>
                    <li class="hr"><span></span></li>
                <?php endif; ?>

                <?php if (Yii::app()->user->checkAccess('Main.AppManagement')): ?>
                    <li <?php if ($this->action->id == 'appManagement'): ?>class="active"<?php endif; ?>><?php echo CHtml::link(Yii::t('main', 'APP管理'), array('/main/appManagement')); ?></li>
					<li class="hr"><span></span></li>
                <?php endif; ?>

                <?php if (Yii::app()->user->checkAccess('Main.TradeManagement')): ?>
                    <li <?php if ($this->action->id == 'tradeManagement'): ?>class="active"<?php endif; ?>><?php echo CHtml::link(Yii::t('main', '交易管理'), array('/main/tradeManagement')); ?></li>
					<li class="hr"><span></span></li>
                <?php endif; ?>

                <?php if (Yii::app()->user->checkAccess('Main.GroupbuyManagement')): ?>
                    <li <?php if ($this->action->id == 'groupbuyManagement'): ?>class="active"<?php endif; ?>><?php echo CHtml::link(Yii::t('main', '团购管理'), array('/main/groupbuyManagement')); ?></li>
					<li class="hr"><span></span></li>
                <?php endif; ?>

                <?php if (Yii::app()->user->checkAccess('Main.serviceManagement')): ?>
                    <li <?php if ($this->action->id == 'serviceManagement'): ?>class="active"<?php endif; ?>><?php echo CHtml::link(Yii::t('main', '客服管理'), array('/main/serviceManagement')); ?></li>
					<li class="hr"><span></span></li>
                <?php endif; ?>

                 <?php if (Yii::app()->user->checkAccess('Main.sideAgreementManagement')): ?>
                    <li <?php if ($this->action->id == 'sideAgreementManagement'): ?>class="active"<?php endif; ?>><?php echo CHtml::link(Yii::t('main', '补充协议管理'), array('/main/sideAgreementManagement')); ?></li>
					<li class="hr"><span></span></li>
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('Main.GateApp')): ?>
                    <li <?php if ($this->action->id == 'gateApp'): ?>class="active"<?php endif; ?>><?php echo CHtml::link(Yii::t('main', '盖象APP'), array('/main/gateApp')); ?></li>
                     <li class="hr"><span></span></li>
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('Main.GameConfig')): ?>
                    <li <?php if ($this->action->id == 'gameConfig'): ?>class="active"<?php endif; ?>><?php echo CHtml::link(Yii::t('main', '游戏管理'), array('/main/gameConfig')); ?></li>
					<li class="hr"><span></span></li>
                <?php endif; ?>
            </ul>        
			<div class="nav-yc">
				<img class="nav-yc-but" width="25" src="../images/icon.png"/>
				<ul></ul>
			</div>
        </div>
        <div class="c-head"></div>
        <div class="bar-hs2"></div>
        <div id="dLeft" style="float: left">
            <div class="bar-top"></div>
            <div class="navTitle"><em class="ico_mus"></em><?php echo Yii::t('main', '导航目录'); ?></div>
            <div class="bar-hs"></div>
            <div class="actionGroup">
                <?php if (is_array($menus)): ?>
                    <?php $i = 1; ?>
                    <?php foreach ($menus as $key => $value): ?>
                        <?php if (Yii::app()->user->checkAccess(str_replace(' ', '.', ucwords(str_replace('/', ' ', trim($value['url'], '/')))))): ?>
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
                        <?php endif; ?>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="links"><div class="t-hr"></div> <?php echo Yii::t('main', '技术支持：广州涌智信息科技有限公司'); ?></div>
            <div class="bar-footer"></div>
        </div>
        <?php if ($this->action->id == 'hotelManagement'): ?>
            <script type="text/javascript">
                $(function() {
                    $.post("<?php echo $this->createAbsoluteUrl('/hotelOrder/newHotelOrder') ?>", {YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>'}, function(data) {
                        if (data != 0) {
                            $('#total').text(data);
                            $('#assistant').show();
                        }
                    });
                })

                var tim_aip = window.setInterval(realTime, 60000);
                function realTime()
                {
                    $.post("<?php echo $this->createAbsoluteUrl('/hotelOrder/newHotelOrder') ?>", {YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>'}, function(data) {
                        if (data != 0) {
                            $('#total').text(data);
                            $('#assistant').show();
                        }
                    });
                }
            </script>

            <div id="assistant">
                <div class="assBox">
                    <a class="assClose" onclick="document.getElementById('assistant').style.display = 'none'"></a>
                    <p>亲，有<b id="total"></b>条新订单！
                        <!--<a href="#">点击查看</a>-->
                        <?php echo Chtml::link('点击查看', $this->createAbsoluteUrl('/hotelOrder/newList'), array('target' => 'dCtxFrame')) ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
        <!--div id="dSplitbar">
            <a class="btn" href="javascript:app.togSidebar()" title="收起侧边栏"><img src="backoffice/style/images/bar-hs.gif" width="15" height="110" /></a>
        </div-->
        <div id="dBody"><iframe id="dCtxFrame" name="dCtxFrame" frameborder="0" scrolling="yes" class="adminFrame" style="overflow: visible;"></iframe></div>
        <script type="text/javascript">
            app.resize();
            app.loadDefault();
        </script>
    </body>
</html>
