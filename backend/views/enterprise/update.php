<?php
/* @var $this EnterpriseController */
/* @var $model Enterprise */

$this->breadcrumbs = array(Yii::t('enterprise', '企业会员') => array('admin'), Yii::t('enterprise', '更新企业信息'));
?>

<?php $this->renderPartial('_form', array(
    'model' => $member,
    'infoModel' => $model,
    'enterpriseData' => $enterpriseData,
)); ?>