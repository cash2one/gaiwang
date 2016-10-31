<?php

$this->breadcrumbs = array(
    Yii::t('citycard', '城市名片管理') => array('admin'),
    Yii::t('citycard', '添加名片'),
);
?>
<?php $this->renderPartial('_form', array( 'model'=>$model, )); 
?>
