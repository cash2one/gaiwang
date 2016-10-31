<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $this->pageTitle?></title>
    <link href="<?php echo $this->module->assetsUrl ?>/css/site.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->module->assetsUrl ?>/css/header.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->module->assetsUrl ?>/css/css.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->module->assetsUrl ?>/css/style.css" rel="stylesheet" type="text/css" />
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <script src="<?php echo $this->module->assetsUrl; ?>/js/jquery-cms.js" type="text/javascript"></script>
  
    <script type="text/javascript">
        $(document).ready(function () {
            var bodyWidth = $(".main").width();
            var ws = bodyWidth - 9;
            $(".t-com").width(ws);
            $(window).resize(function () {
                var bodyWidth = $(".main").width();
                var ws = bodyWidth - 9;
                $(".ws").width(ws);
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
        $(document).ready(function (e) {
            $('#tabcon tr:even').addClass('odd')
        });
        
    </script>

</head>
<body class="body_page">
        <div class="page">
    <div class="main">
    <!-- 页头 -->
    	<div class="header">  
    	<!-- logo_box -->
    	<div class="unit logo_box"><a href="javascript:void(0)"><img src=<?php echo Yii::app()->language=='en'?$this->module->assetsUrl."/images/logo_en.jpg":$this->module->assetsUrl."/images/logo.jpg"?> width="263" height="60" alt="logo" /></a></div>
        <!-- logo_box end -->
        
        <!-- user_box 用户信息 -->
    	<div class="unit user_box">
        	<div class="unit user_photo">
             <img alt="用户头像" width="38px" height="38px" src="<?php echo $this->module->assetsUrl ?>/images/user_38x38.jpg" />
            </div>
            <div class="unit userinfo"><?php echo Yii::t('User','欢迎您')?>，<span><?php echo Yii::app()->user->getName()?></span>
            <br />
            <?php echo CHtml::link(Yii::t('User', '盖网首页'),DOMAIN)?>
            <p>|</p>
            <?php echo CHtml::link(Yii::t('User', '退出登录'), array('site/logout'));?>
            </div>
        </div>
        <!-- user_box end -->
    </div>
    <!-- 页头结束 -->

    <!-- 左菜单栏 -->
    <div class="left_sidebar">
            <ul class="nav">
            	<?php 
            	$left_menus = $this->getMenu();
            	foreach ($left_menus as $parent_name=>$items):
            	?>
            	<li class="list <?php if($this->curMenu === $parent_name):?>thismenu<?php endif;?>">
            		<a href="javascript:void(0)"><img src="<?php echo $this->module->assetsUrl.'/images/icon/'.$items['icon']?>" width="16" height="16" alt="icon" /><?php echo $parent_name?> </a>
            		<ol class="child dn nav2"><!--  thismenu2 -->
            			<?php foreach ($items['children'] as $name=>$item):?>
            				<li class="list <?php if(strtolower("/".$this->id."/".$this->action->id)==strtolower($item['0']))echo "thismenu2"?>"><?php echo CHtml::link($name, $item);?></li>
            			<?php endforeach;?>
            		</ol>
            	</li>
            	<?php endforeach;?>
                </ul> 
        </div>
        <!-- 左菜单栏结束 -->
        
        <!-- 主体 -->
         <div class="container">    
          		<?php
                    $this->widget('application.modules.agent.widgets.AgentBreadcrumbs', array(
                        'homeLink' => false,
                        'separator' => '<p>></p>',
                        'links' => $this->breadcrumbs,
                    	'htmlOptions' => array(
                    		'class'=>'line top_title'
                    	),
                    ));
                    ?>
				<?php echo $content;?>
        </div>
    <!-- 主体结束 -->

    
  </div>
 </div>
</body>
</html>
