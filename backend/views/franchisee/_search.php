<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table width="100%" cellpadding="0" cellspacing="0" class="searchT01">
        <tr>
            <th width="8%"><?php echo $form->label($model, 'name'); ?>：</th>
            <td width="23%"><?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle', 'style' => 'width:90%')); ?></td>
            <th width="8%"><?php echo $form->label($model, 'code'); ?>：</th>
            <td width="30%"><?php echo $form->textField($model, 'code', array('class' => 'text-input-bj  middle', 'style' => 'width:90%')); ?></td>
            <th width="8%"><?php echo $form->label($model, 'member_id'); ?>：</th>
            <td width="23%"><?php echo $form->textField($model, 'member_id', array('class' => 'text-input-bj  middle', 'style' => 'width:90%', 'maxlength' => '15')); ?></td>
        </tr>
        <tr>
            <th><?php echo $form->label($model, 'mobile'); ?>：</th>
            <td><?php echo $form->textField($model, 'mobile', array('class' => 'text-input-bj  middle', 'style' => 'width:90%')); ?></td>
            <th><?php echo $form->label($model, 'create_time'); ?>：</th>
            <td>
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'startTime',
                ));
                ?> -
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'endTime',
                ));
                ?>
            </td>
            <th width="8%"><?php echo $form->label($model, 'is_recommend'); ?>：</th>
            <td width="25%"><?php echo $form->dropDownList($model, 'is_recommend', Franchisee::getRecommend(), array('class' => 'text-input-bj ', 'style' => 'width:94%', 'prompt' => '请选择')); ?></td>
        </tr>
        <tr>
            <th colspan="6" class="ta_c"><?php echo CHtml::submitButton(Yii::t('franchisee', '搜索'), array('class' => 'reg-sub')); ?>
                <?php echo CHtml::linkButton(Yii::t('franchisee', '导出搜索'), array('id'=>"exportSearch",'class' => 'regm-sub')); ?>
            </th>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>
<style>
    #yw1{width: 120px;}
    #yw2{width: 120px;}
</style>