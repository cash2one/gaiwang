<?php

$this->breadcrumbs = array(Yii::t('franchiseecontract', '协议相关商户列表') => array('list-agreement'), Yii::t('franchiseecontract', '编辑协议相关商户'));
$this->renderPartial('_form', array('model'=>$model)); 

?>