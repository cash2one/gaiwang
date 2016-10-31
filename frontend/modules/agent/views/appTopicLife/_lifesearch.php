<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'appTopicLife-search-form',
        'action'=>Yii::app()->createUrl($this->route,array('id'=>$lifeId)),
        'method'=>'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
        <tr>
            <th><?php echo $form->label($model, 'nickname'); ?>：</th>
            <td><?php echo $form->textField($model, 'nickname', array('class' => 'text-input-bj  least')); ?></td>
            <th><?php echo $form->label($model, 'create_time'); ?>：</th>
            <td>
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'create_time',
                    'select' => 'date',
                ));
                // echo $form->textField($model,'online_time',array('class'=> 'text-input-bj  long valid','placeholder'=>"2016-08-08(请输入所示日期格式)"));?>
                <?php echo $form->error($model, 'create_time'); ?>
            </td>
            <th><?php echo $form->label($model, 'status'); ?>：</th>
            <td><?php echo $form->dropDownList($model, 'status', AppTopicProblem::getReplystatus(), array('prompt' => '全部')); ?></td>
            <th colspan="6" class="ta_c"><?php echo CHtml::submitButton(Yii::t('franchisee', '搜索'), array('class' => 'reg-sub')); ?></th>
        </tr>
        </tbody>
    </table>
    <?php $this->endWidget(); ?>
</div>
