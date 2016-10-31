<?php
/* @var $this StoreArticleController */
/* @var $model StoreArticle */
/* @var $form CActiveForm */
?>

<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'store_id'); ?></th>
            <td><?php echo $form->textField($model, 'store_id', array('class' => 'text-input-bj  least')); ?></td>
        </tr>　
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'title'); ?></th>
            <td><?php echo $form->textField($model, 'title', array('class' => 'text-input-bj  least')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'status'); ?></th>
            <td><?php echo $form->radioButtonList($model, 'status', StoreArticle::status(), array('separator' => '')); ?></td>
        </tr>
    </table>   
    <?php echo CHtml::submitButton(Yii::t('store', '搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>