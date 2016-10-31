<?php $form = $this->beginWidget('ActiveForm', $formConfig); ?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th">
                <?php echo Yii::t('home', '网站基本信息配置'); ?>
            </th>
        </tr>
        <tr>
            <th style="width: 220px"><?php echo $form->labelEx($model, 'name'); ?></th>
            <td>
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  long valid')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'domain'); ?></th>
            <td>
                <?php echo $form->textField($model, 'domain', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'domain'); ?>
            </td>
        </tr>

        <tr>
            <th><?php echo $form->labelEx($model, 'phone'); ?></th>
            <td>
                <?php echo $form->textField($model, 'phone', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'phone'); ?>
                <?php echo Yii::t('home', '（多个电话用半角“,”分割）'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'service_time'); ?></th>
            <td>
                <?php echo $form->textField($model, 'service_time', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'service_time'); ?>
            </td>
        </tr>

        <tr>
            <th><?php echo $form->labelEx($model, 'copyright'); ?></th>
            <td>
                <?php echo $form->textArea($model, 'copyright', array('class' => 'text-input-bj', 'cols' => 60)); ?>
                <?php echo $form->error($model, 'copyright'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'icp'); ?></th>
            <td>
                <?php echo $form->textArea($model, 'icp', array('class' => 'text-input-bj', 'cols' => 60)); ?>
                <?php echo $form->error($model, 'icp'); ?>
            </td>
        </tr>

        <tr>
            <th></th>
            <td><?php echo CHtml::submitButton(Yii::t('home', '保存'), array('class' => 'reg-sub')); ?></td>
        </tr>
        </tbody>
    </table>
<?php $this->endWidget(); ?>