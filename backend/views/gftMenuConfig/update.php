<?php

$this->breadcrumbs = array(Yii::t('gftmenuconfig', '盖付通主菜单列表') => array('list-agreement'), Yii::t('gftmenuconfig', '编辑'));
$this->renderPartial('_form', array('model'=>$model)); 

?>