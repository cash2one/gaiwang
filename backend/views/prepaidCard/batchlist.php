<?php
/** @var  CActiveForm $form */
/** @var UploadForm $model */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'bacth-prepaid-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate'=>'js:function(form){
           if($("#UploadForm_file").val() != "") {
                $("#bacth-prepaid-form").submit();
                $("input[type=\'submit\']").css("cursor","not-allowed").attr("disabled","disabled");
                return true;
            }            
        }',
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
        <tr>
            <td style="width:240px;">请下载该Execl表格式进行填写充值信息</td>
            <td>
                <?php echo CHtml::link('下载Execl',Yii::app()->createAbsoluteUrl('PrepaidCard/downLoadExecl'),array('class'=>"regm-sub"))?>
                <span style="color:red">
                    &nbsp;(该功能只用于批量生成充值卡，不会作为充值功能使用)
                </span>
            </td>
            
        </tr>
        <tr>
            <td>
                <?php echo $form->labelEx($model, 'file') ?>
            </td>
            <td>
                <?php echo $form->fileField($model, 'file') ?>
                <span style="color:red">
                    (请使用标准格式的2007/2010 excel文件导入，标准文件名为xx.xls，批号必须是正整数，不能有其他字符！每次导入不能超过500条！)
               		 
                </span>
                <?php echo $form->error($model, 'file', array(), false); ?>
            </td>
        </tr>
        <tr>
            <td>
                申请日期 <span class="required">*</span>
            </td>
            <td>
                <?php
                    $this->widget('comext.timepicker.timepicker', array(
                        'model' => $model,
                        'name' => 'apply_time',
                        'select' => 'date',
                        'options' => array(
                            'value' => date("Y-m-d", time()),
                        ),
                    ));
                ?>
                <?php echo $form->error($model, 'apply_time'); ?>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <?php echo CHtml::submitButton('确定', array('class' => 'reg-sub')) ?>
            </td>
        </tr>
        
        </tbody>
    </table>
<?php $this->endWidget(); ?>
<script type="text/javascript">
<!--
$("input[name='isencode']").change(function(){
	if($(this).val()==1) $("#codearea").show();
	else $("#codearea").hide();
	
});
	
//-->
</script>

