<?php

/* @var $this PromotionStatisticsController */
/* @var $model PromotionStatistics */
$this->breadcrumbs = array(
    Yii::t('promotionStatistics', '统计管理'),
    Yii::t('promotionStatistics', ' 推广渠道列表') => array('admin'),
    Yii::t('promotionStatistics', '添加推广渠道'),
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>