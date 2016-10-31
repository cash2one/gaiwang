<?php
$this->breadcrumbs = array(
        '红包充值活动' => array('admin'),
        '金额添加历史'
);

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
            <th><?php echo $form->label($model, 'username'); ?>：</th>
            <td><?php echo $form->textField($model, 'username', array('class' => 'text-input-bj')); ?></td>

            <th><?php echo $form->label($model, 'real_name'); ?>：</th>
            <td><?php echo $form->textField($model, 'real_name', array('class' => 'text-input-bj')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th>时间：</th>
            <td>
                <?php
                 $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'beginCreateTime',
                    'select'=>'date',
                    'htmlOptions' => array(
                            'readonly' => 'readonly',
                            'class' => 'text-input-bj  least readonly',
                    )
                ));
                ?>
                到
                <?php
                 $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'toCreateTime',
                    'select'=>'date',
                    'htmlOptions' => array(
                            'readonly' => 'readonly',
                            'class' => 'text-input-bj  least readonly',
                    )
                ));
                ?>
            </td>
        </tr>
    </table>
    <?php echo CHtml::submitButton('搜索', array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'red-envelope-cash-log',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
                'type' => 'datetime',
                'name' => 'create_time',
                'value' => '$data->create_time'
        ),
        'username',
        'real_name',
        'money',
        'total_money',
    ),
));
?>