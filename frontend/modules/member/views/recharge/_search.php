

<div class="upladaapBoxBg mgtop20 ">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
    )); ?>
    <div class="upladBox_1"><b class="mgleft20"><?php echo Yii::t('memberRecharge','积分数'); ?>：</b>
        <?php echo $form->textField($model,'score',array('class'=>'integaralIpt4 ')); ?>  -  
        <?php echo $form->textField($model,'endScore',array('class'=>'integaralIpt4 mgright15')); ?>
        <b><?php echo Yii::t('memberRecharge','创建时间'); ?>：</b>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'create_time',
            'language'=>Yii::app()->language,
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
            'attribute' => 'endTime',
            'language'=>Yii::app()->language,
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
            ),
            'htmlOptions' => array(
                'readonly' => 'readonly',
                'class' => 'integaralIpt5 mgright15',
            )
        ));
        ?>

        <?php echo CHtml::link(Yii::t('memberRecharge','搜索'),'',array('class'=>'searchBtn searchBtnright_1')); ?>

    </div>
    <div class="upladBox_1 mgtop5"><b class="mgleft20"><?php echo Yii::t('memberRecharge','状态'); ?>：</b>
        <?php echo $form->radioButtonList($model,'status',$model::getStatus(),array('separator'=>' ')) ?>
    </div>
    <?php $this->endWidget(); ?>
</div>

<script>
    $(".searchBtn").click(function(){
        $("form").submit();
    });
</script>