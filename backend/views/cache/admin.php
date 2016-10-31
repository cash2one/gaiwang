<?php
/* @var $this CacheController */

$this->breadcrumbs = array(
    Yii::t('cache', '静态页管理 ') => array('admin'),
    Yii::t('cache', '列表'),
);
?>
<?php if (Yii::app()->user->checkAccess('Cache.GetAllCache')): ?>
    <a class="regm-sub" href="<?php echo $this->createAbsoluteUrl('/cache/getAllCache') ?>"><?php echo Yii::t('cache', '更新所有静态页') ?></a>
<?php endif; ?>
<div class="c10"></div>    
