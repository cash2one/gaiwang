<?php $class = isset($class) ? $class : ''; ?>
<tr id="<?php if(get_class($model)=='BankAccount'){echo 'bankImage';}else{echo $field;} ?>" class="<?php echo $class ?>">
    <td width="140" height="25" align="center" class="dtEe">
        <?php echo $form->labelEx($model, $field) ?>：
    </td>
    <td height="25" colspan="2" class="dtFff pdleft20 hobbies" style="line-height: 30px;">
        <?php
        $this->widget('common.widgets.CUploadPic', array(
            'attribute' => $field,
            'model'=>$model,
            'form'=>$form,
            'num' => 1,
            'img_area' => 2,
            'btn_value'=> Yii::t('sellerGoods', '上传图片'),
            'render' => '_upload',
            'folder_name' => 'enterprise',
            'include_artDialog'=>false,
            'uploadUrl'=>'/member/upload/index',
            'uploadSureUrl'=>'/member/upload/sure',
        ));
        ?>
        <?php echo Yii::t('memberMember', '(请确保图片清晰)');; ?>
        <?php echo CHtml::link('查看示例',  '#', array('class' => 'red picTips','id'=>'picTips_'.$field)); ?>
        <?php echo $form->error($model, $field, array(), false) ?>
    </td>
</tr>