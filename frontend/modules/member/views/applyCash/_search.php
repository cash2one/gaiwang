<?php
/* @var $this EnterpriseApplyCashController */
/* @var $model CashHistory */
/* @var $form CActiveForm */

?>



<div class="upladaapBoxBg mgtop20 ">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
    )); ?>
    <div class="upladBox_1">
        <b class="mgleft20"><?php echo $form->label($model,'account_name'); ?>：</b>
        <?php echo $form->textField($model,'account_name',array('class'=>'integaralIpt4 mgright15')); ?>

        <b><?php echo $form->label($model,'apply_time'); ?>： </b>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'apply_time',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
            ),
            'htmlOptions' => array(
                'readonly' => 'readonly',
                'class' => 'integaralIpt5',
            )
        ));
        ?>  -  <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'end_time',
            'language' => 'zh_cn',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
            ),
            'htmlOptions' => array(
                'readonly' => 'readonly',
                'class' => 'integaralIpt5',
            )
        ));
        ?>

        <?php echo CHtml::link(Yii::t('memberApplyCash','搜索'),'',array('class'=>'searchBtn searchBtnright')); ?>
    </div>
    <div class="upladBox_1 mgtop5">
        <b class="mgleft20"><?php echo $form->label($model,'status'); ?>：</b>
        <?php
        //在状态数组头部，加入 “全部”，非0下标开始的数组，用radioButtonList 的 empty ，会导致下标改变
        $status = $model::status();
        $status = array_reverse($status,true);
        $status[''] = Yii::t('memberApplyCash','全部');
        $status = array_reverse($status,true);
        ?>
        <?php echo $form->radioButtonList($model,'status',$status,array('separator'=>' ')) ?>
    </div>
    <?php $this->endWidget(); ?>
</div>


<script>
    $(".searchBtn").click(function(){
        $('form').submit();
    });
</script>