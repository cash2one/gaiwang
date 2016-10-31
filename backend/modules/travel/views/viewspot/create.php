<?php


$this->breadcrumbs = array(
    Yii::t('viewspot', '城市名片管理') => array('cityCard/admin'),
    Yii::t('viewspot', '新增景点'),
);
?>
<?php $this->renderPartial('_form', array( 'model'=>$model,'business'=>$business,'id'=>$id)); 
?>

