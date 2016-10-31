<?php
$this->breadcrumbs = array(
    '充值卡转账' => array('admin'),
    ($this->action->id=='create')?'充值卡转账申请':'旧余额转账申请',
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>