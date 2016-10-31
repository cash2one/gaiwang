<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<!-- <link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css"> -->
<link href="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.js"></script>
<?php
/* @var $this OfflineSignStoreController */
/* @var $model OfflineSignStore */
/* @var $model OfflineSignEnterprise */
/* @var $model OfflineSignContract */

$this->breadcrumbs = array(
    Yii::t('appTopicHouse', '佳品') =>array('appTopicHouse/admin'),
    Yii::t('appTopicHouse', '更新'),

);

$baseUrl = Yii::app()->baseUrl;
Yii::app()->clientScript->registerCssFile($baseUrl.'/css/jqtransform.css');
?>

<?php $this->renderPartial('_from',array('model'=>$model))?>