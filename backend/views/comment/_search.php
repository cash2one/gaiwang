<?php
/* @var $this CommentController */
/* @var $model Comment */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>
<div class="border-info clearfix">
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo Yii::t('comment','订单号'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model,'order_id',array('size'=>20,'maxlength'=>20,'class'=>'text-input-bj  middle')); ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo Yii::t('comment','商家名称'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model,'store_id',array('size'=>11,'maxlength'=>11,'class'=>'text-input-bj  middle')); ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo Yii::t('comment','商品名称'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model,'goods_name',array('size'=>20,'maxlength'=>20,'class'=>'text-input-bj  least')); ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo Yii::t('comment','会员号'); ?>：
            </th>
            <td colspan="2">
                <?php echo $form->textField($model,'member_id',array('size'=>11,'maxlength'=>11,'class'=>'text-input-bj  least')); ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo Yii::t('comment','评论时间'); ?>：
            </th>
            <td colspan="2">
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model'=>$model,
                    'name'=>'create_time',
                ));
                ?>-
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model'=>$model,
                    'name' => 'endTime',
                ));
                ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo Yii::t('comment','评论状态'); ?>：
            </th>
            <td colspan="2" id="tdCommentStatus">
                <?php echo $form->radioButtonList($model,'status',$model::status(),
                    array('empty'=>Yii::t('order','全部'),'separator'=>'')) ?>
            </td>
        </tr>
        </tbody></table>
    <div class="c10">
    </div>
    <?php echo CHtml::submitButton(Yii::t('comment','搜索'),array('class'=>'reg-sub')) ?>
</div>

<?php $this->endWidget(); ?>

<script>
    $(":input[name$='ime]']").addClass('least').removeClass('middle');
</script>