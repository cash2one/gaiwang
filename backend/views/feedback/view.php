<?php
/* @var $this OrderController */
/* @var $model Order */
?>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come" id="tab1">
    <tr>
        <td colspan="8" class="title-th">
            <?php echo Yii::t('feedback', '用户信息'); ?>
        </td>
    </tr>
    <tr>
        <th style="width:100px">
            <?php echo $model->getAttributeLabel('gai_number') ?>：
        </th>
        <td>
            <?php echo $model->gai_number ?>
        </td>
        <th style="width:100px">
            <?php echo $model->getAttributeLabel('username') ?>：
        </th>
        <td >
            <?php echo $model->username ?>
        </td>
        <th style="width:100px">
            <?php echo $model->getAttributeLabel('mobile') ?>：
        </th>
        <td>
            <?php echo $model->mobile ?>
        </td>
        <th style="width:100px">
            <?php echo $model->getAttributeLabel('created') ?>：
        </th>
        <td>
            <?php echo Yii::app()->format->formatDatetime($model->created) ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="8" class="title-th">
            <?php echo Yii::t('feedback', '反馈内容'); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $model->getAttributeLabel('content') ?>：
        </th>
        <td colspan="7">
            <?php echo $model->content ?>
        </td>
    </tr>
    <tr>
        <td colspan="8" class="title-th">
            <?php echo Yii::t('feedback', '附件'); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $model->getAttributeLabel('picture') ?>：
        </th>
         <?php if(!empty($model->picture)):?>
        <td colspan="7">
        <?php $arrpic = explode('|',$model->picture); ?>
        <?php if (!empty($arrpic)): ?>
            <?php foreach ($arrpic as $pic): ?>
            <a href="<?php echo ATTR_DOMAIN . '/' . $pic ?>" target="_blank">
            <img src="<?php echo ATTR_DOMAIN . '/' . $pic?>" style="width:200px;display:inline">
            </a>
            <?php endforeach; ?>
        <?php endif; ?>
        </td>
        <?php else:?>
            <td colspan="7">未上传图片</td>
        <?php endif;?>
    </tr>
    
</table>