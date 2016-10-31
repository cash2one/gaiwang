<?php $class = isset($class) ? $class : ''; ?>
<tr id="<?php echo $field ?>" class="<?php echo $class ?>">
    <th style="text-align: right">
        <?php echo $form->labelEx($model,$field); ?>：
    </th>
    <td>

        <?php
        $this->widget('common.widgets.CUploadPic', array(
            'form' => $form,
            'model' => $model,
            'attribute' => $field,
            'num' => 1,
            'img_area' => 2,
            'folder_name' => 'enterprise',
            'btn_value'=> Yii::t('enterprise', '上传图片'),
        ));
        ?>
        <?php echo $form->error($model,$field,array('style'=>'width:500px;margin:-15px 0 0 0;')); ?>
    </td>
</tr>