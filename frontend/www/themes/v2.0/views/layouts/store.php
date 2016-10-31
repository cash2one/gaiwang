<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="<?php echo CHtml::encode($this->keywords) ?>" />
    <meta name="Description" content="<?php echo CHtml::encode($this->description) ?>" />
    <title><?php echo CHtml::encode($this->pageTitle) ?></title>
    <link rel="shortcut icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
    <link rel="icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
    
    <link href="<?php echo $this->theme->baseUrl; ?>/styles/global.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->theme->baseUrl; ?>/styles/module.css" rel="stylesheet" type="text/css" />
    
    <script src="<?php echo $this->theme->baseUrl; ?>/js/jquery-1.9.1.js" type="text/javascript"></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/jquery.gate.common.js"></script>
    <script type="text/javascript" src="<?php echo $this->theme->baseUrl; ?>/js/jquery.jqzoom.js"></script><!-- 图片放大 -->
    <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/lazyLoad.js"></script>
    <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/raty/lib/jquery.raty.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/layer/layer.js"></script>
  </head>
  
  <body>
  <?php $this->renderPartial('//layouts/_top_v20'); ?>
  <?php $this->renderPartial('//layouts/_top3_v20'); ?>
  <?php $this->renderPartial('//layouts/_nav4_v20'); ?>
  <?php if($this->id=='shop'):?>
  <?php $this->renderPartial('//layouts/scateoryNav_v20'); ?>
  <?php endif;?> 	
  	<!-- 商品主体start -->
	<div <?php if($this->id!='shop'):?> class="gx-main" <?php endif;?>>
		<?php echo $content; ?>
	</div>
	<!-- 商品主体end -->
  
  	<!-- 底部start -->
	<?php $this->renderPartial('//layouts/_footer_v20'); ?>
  	<!-- 底部end -->
    
    <?php $this->renderPartial('//layouts/_right_v20'); ?>
     
    <?php if (Yii::app()->user->hasFlash('success')): ?>
    <script src="<?php echo DOMAIN; ?>/js/artDialog/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
    <script type="text/javascript">
        //成功样式的dialog弹窗提示
		layer.alert('<?php echo Yii::app()->user->getFlash('success'); ?>');
    </script>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error')): ?>
    <script src="<?php echo DOMAIN; ?>/js/artDialog/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
    <script type="text/javascript">
        //错误样式的dialog弹窗提示
		layer.alert('<?php echo json_encode(Yii::app()->user->getFlash('error')); ?>');
    </script>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('warning')): ?>
    <script src="<?php echo DOMAIN; ?>/js/artDialog/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
    <script type="text/javascript">
        //警告样式的dialog弹窗提示
		layer.alert('<?php echo Yii::app()->user->getFlash('warning'); ?>');
    </script>
<?php endif; ?> 
  </body>
</html>
<script src="<?php echo $this->theme->baseUrl; ?>/js/product-v2.0.js"></script>
