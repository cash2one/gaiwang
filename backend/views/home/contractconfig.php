<?php $form = $this->beginWidget('CActiveForm', $formConfig); ?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
        <tr>
            <th><?php echo $form->labelEx($model, 'file'); ?></th>
            <td>
                <?php
                $this->widget('comext.wdueditor.WDueditor', array(
                    'model' => $model,
                    'attribute' => 'file',
                ));
                ?>
                <?php echo $form->error($model, 'file',false); ?>
            </td>
        </tr>
        <tr>
            <th></th>
            <td><?php echo CHtml::submitButton(Yii::t('home', '保存'), array('class' => 'reg-sub')); ?></td>
        </tr>
        </tbody>
    </table>
<?php $this->endWidget(); ?>