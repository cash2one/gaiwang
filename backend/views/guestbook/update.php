<?php

/* @var $this GuestbookController */
/* @var $model Guestbook */

$this->breadcrumbs = array(
    Yii::t('guestbook', '商品咨询管理 ') => array('admin'),
    Yii::t('guestbook', '产品咨询编辑'),
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>