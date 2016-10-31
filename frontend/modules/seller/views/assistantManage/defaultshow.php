<?php
/* @var $this AssistantController */
/* @var $model Assistant */

$this->breadcrumbs=array(
    Yii::t('sellerAssistantManage','店小二登录'),
    Yii::t('sellerAssistantManage','最近日志'),
);
?>
<div class="toolbar">
    <h3><?php echo Yii::t('sellerAssistantManage','欢迎您登录卖家中心！'); ?></h3>
</div>
<div>
    <dl>
        <dt><?php echo Yii::t('sellerAssistantManage','最近日志'); ?></dt>
        <dd>&nbsp;</dd>
        <?php foreach($logs as $v): ?>
        <dd>
            <?php echo $this->format()->formatDatetime($v->create_time) ?>&nbsp;&nbsp;
            <?php echo $v->title ?>&nbsp;&nbsp;
            <?php echo $v->member_name ?>&nbsp;&nbsp;
        </dd>
        <?php endforeach; ?>
    </dl>
</div>


