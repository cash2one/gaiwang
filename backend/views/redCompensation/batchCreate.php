<?php
$this->breadcrumbs = array(
    '红包补偿' => array('admin'),
    '批量创建红包补偿'
);
?>
<?php $this->renderPartial('_form', array('model' => $model,'modelArr'=>$modelArr)); ?>