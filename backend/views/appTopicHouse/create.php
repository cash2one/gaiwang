<?php
/* @var $this OfflineSignStoreController */
/* @var $model OfflineSignStore */
/* @var $model OfflineSignEnterprise */
/* @var $model OfflineSignContract */

$this->breadcrumbs = array(
    Yii::t('appTopicHouse', '仕品') =>array('appTopicHouse/admin'),
    Yii::t('appTopicHouse', '新建'),

);
?>

    <?php $this->renderPartial('_from',array('model'=>$model))?>