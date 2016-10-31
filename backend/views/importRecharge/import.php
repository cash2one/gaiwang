<?php
/** @var  CActiveForm $form */
/** @var UploadForm $model */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'importRecharge-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate'=>'js:function(form){
           if($("#UploadForm_file").val() != "") {
                $("#importRecharge-form").submit();
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
                <?php echo CHtml::link('下载Execl',Yii::app()->createAbsoluteUrl('importRecharge/downLoadExecl'),array('class'=>"regm-sub"))?>
                <span style="color:red">
                    &nbsp;(该功能用于批量生成充值卡并对账户进行充值)
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
           	是否发送短信给被充值者
            </td>
            <td>
                <?php echo CHtml::radioButtonList('smg', 0, array(0=>'否',1=>'是')) ?>
            </td>
        </tr>
        
        <tr>
            <td>
           	编辑后续短信
            </td>
            <td>
                <?php echo CHtml::telField('sms','',array('class' => 'text-input-bj long','maxlength'=>"20")) ?>
                <span style="color:red">
                	(请控制在20个字符以内)               		 
                </span>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <?php echo CHtml::submitButton('确定', array('class' => 'reg-sub')) ?>
                <span style="color:red">
                	(1分钟后进行实际的充值操作)               		 
                </span>
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

