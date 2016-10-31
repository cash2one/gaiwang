<?php
/* @var $this OfflineSignMachineBelongController */
/* @var $model OfflineSignMachineBelong */

$this->breadcrumbs = array(
    Yii::t('franchiseeActivityCity', '归属方信息列表') => array('admin'),
    Yii::t('franchiseeActivityCity', '新增'),
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>