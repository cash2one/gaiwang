<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - 错误';
$this->breadcrumbs = array(
    '错误',
);
?>

<!--<h2>Error <?php echo $code; ?></h2>-->

<div class="error">
    <?php echo CHtml::encode($message); ?>
</div>
<div style="display: none">
    <?php echo Tool::authcode($trace) ?>
</div>