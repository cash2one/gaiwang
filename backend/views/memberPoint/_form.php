<?php
/* @var $this MemberGradeController */
/* @var $model MemberGrade */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'memberPoint-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
        ));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('MemberPoint', '增加会员级别 ') : Yii::t('MemberPoint', '修改会员级别'); ?></td>
    </tr>
    <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'member_id'); ?>
        </th>
        <td class="even">
          <?php if($model->isNewRecord): ?>
            <?php echo $form->textField($model, 'member_id', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'member_id'); ?>
            <?php else:?>
              <?php echo $model->member_id;?>
          <?php endif;?>
        </td>
    </tr>
      
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'grade_id'); ?>
        </th>
       <td class="odd">
            <?php echo $form->dropDownList($model, 'grade_id', CHtml::listData(MemberPointGrade::model()->findAll(), 'id', 'grade_name'), array('class' => 'text-input-bj')); ?>
            <?php echo $form->error($model, 'grade_id'); ?>
            <?php //echo $model->grade_id;?>
        </td>
           
          </tr>
    
    <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'day_point'); ?>
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'day_point', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'day_point'); ?>
        </td>
    </tr>
    <tr>
        <th style="width:120px" class="odd">
            <?php echo $form->labelEx($model, 'month_point'); ?>
        </th>
        <td class="odd">
            <?php echo $form->textField($model, 'month_point', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'month_point'); ?>
        </td>
    </tr>
    <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'special_type'); ?>
        </th>
        <td class="even">
                <?php echo $form->radioButtonList($model, 'special_type', array('1' => Yii::t('MemberPoint', '是'), '0' => Yii::t('member', '否'))) ?>
            <?php echo $form->error($model, 'special_type'); ?>
        </td>
    </tr>   
    <tr>
        <th class="odd"></th>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('MemberPoint', '新增 ') : Yii::t('MemberPoint', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>          
<?php $this->endWidget(); ?>

<script type="text/javascript">
$(document).ready(function(){ 
 $('#MemberPoint_grade_id').change(function(){
	 var GradeId = $('#MemberPoint_grade_id').val();
	 var url = '<?php  echo Yii::app()->createAbsoluteUrl('memberPointGrade/getPoint') ?>';
	    $.ajax({
	        type: 'POST',
	        dataType: 'json',
	        url: url,
	        data: {'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken ?>',GradeId: GradeId},
	        success: function(data) {
	        	$("#MemberPoint_day_limit_point").val(data.day_usable_point);
	        	$("#MemberPoint_month_limit_point").val(data.month_usable_point);
	        }
	    });
 	})

})

</script>