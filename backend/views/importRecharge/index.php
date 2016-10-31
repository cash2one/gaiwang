<?php
/** @var  CActiveForm $form */
/** @var UploadForm $model */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'importRecharge-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
        <tr>
            <td>
                <?php echo $form->labelEx($model, 'file') ?>
            </td>
            <td>
                <?php echo $form->fileField($model, 'file') ?>
                <span style="color:red">
                	(请使用txt文件导入。 每次导入不能超过20条！)
               		 
                </span>
                <?php echo $form->error($model, 'file', array(), false); ?>
            </td>
        </tr>        
        <tr id="codearea">
        <td>
           	加密串 <span class="required">*</span>
            </td>
            <td>
                <?php echo CHtml::textField('code'); ?>
            </td>
        </tr>
        
        <?php //if(!empty($result)):?>
<!--        <td>
           	是否发送短信给被充值者
            </td>
            <td>
                <?php //echo CHtml::radioButtonList('smg', 0, array(0=>'否',1=>'是')) ?>
            </td>
        </tr>-->
        <?php //endif;?>
        <?php if(empty($result)):?>
        <tr>
            <td colspan="2">
                <?php 
                    echo CHtml::submitButton('确定', array('class' => 'reg-sub')) ?>
            </td>
        </tr>
        <?php endif;?>
        </tbody>
    </table>
<?php $this->endWidget(); ?>

<?php
if(!empty($result))
    $this->renderPartial('_result', array('result' => $result,'memberType'=>$memberType)); 
?>

