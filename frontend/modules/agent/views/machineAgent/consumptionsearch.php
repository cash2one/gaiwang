<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));
?>
<?php echo $form->hiddenField($model, 'id', array('size' => 56, 'maxlength' => 56)); ?>
<div class="form_search">
    <label for="textfield"></label>
    <p><?php echo Yii::t('Agent', '时间') ?>：</p>
    <?php
    // $this->widget('comext.timepicker.timepicker', array(
    // 	  'id' => 'createtime',
    //     'cssClass' => 'datefield search_box3',
    //     'model' => $model,
    //     'name' => 'create_time',
    //     'select'=>'date',
    //     'options'=>array(
    //     	'readonly'=>true,
    //     )
    // ));
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'model' => $model,
        'attribute' => 'create_time',
        'language' => 'zh_cn',
        'options' => array(
            'dateFormat' => 'yy-mm',
            'changeMonth' => true,
        ),
        'htmlOptions' => array(
            'readonly' => 'readonly',
            'class' => 'datefield search_box3',
        )
    ));
    ?>
    <!--<p style="margin-left:10px">─</p>--> 
    <?php
    // $this->widget('comext.timepicker.timepicker', array(
    // 	  'id' => 'endtime',
    //     'cssClass' => 'datefield search_box3',
    //     'model' => $model,
    //     'name' => 'endTime',
    //     'select'=>'date',
    //     'options'=>array(
    //     	'readonly'=>true,
    //     )
    // ));
//    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
//        'model' => $model,
//        'attribute' => 'end_time',
//        'language' => 'zh_cn',
//        'options' => array(
//            'dateFormat' => 'yy-mm-dd',
//            'changeMonth' => true,
//        ),
//        'htmlOptions' => array(
//            'readonly' => 'readonly',
//            'class' => 'datefield search_box3',
//        )
//    ));
    ?>
    <?php echo CHtml::submitButton("", array("class" => "search_button3")) ?>
    &nbsp;&nbsp;&nbsp;
    <?php echo CHtml::link("全部", "", array("class" => "button_04")) ?>
</div>
<?php $this->endWidget(); ?>

<style type="text/css">
    .ui-datepicker-calendar {
        display: none;
    </style>
    <script type="text/javascript">
        $(function() {
            $('#MachineAgent_create_time').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm',
                showButtonPanel: true,
                closeText: '关闭',
                onClose: function(dateText, inst) {
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    //                     $(this).datepicker('setDate', month);
                    month++
                    month = month >= 10 ? month : '0' + month;
                    $("#MachineAgent_create_time").val(year + '-' + month);
                }
            });
        });


        $('.button_04').click(function() {
            $('#MachineAgent_create_time').val('');
            $('.search_button3').click();
        });
    </script>