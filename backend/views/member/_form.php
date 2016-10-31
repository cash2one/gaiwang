<?php
/* @var $this MemberController */
/* @var $model Member */
/* @var $bankModel BankAccount */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'member-form',
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
            <th colspan="2" style="text-align: center" class="title-th">
                <?php if ($model->isNewRecord): ?>
                    <?php echo Yii::t('member', '添加普通会员'); ?>
                <?php else: ?>
                    <?php echo Yii::t('member', '修改普通会员'); ?>
                <?php endif; ?>
            </th>
        </tr>
        <tr>
            <th style="width: 220px"><?php echo $form->labelEx($model, 'username'); ?></th>
            <td>
                <?php echo $form->textField($model, 'username', array('class' => 'text-input-bj middle')) ?>
                <?php echo $form->error($model, 'username') ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'mobile') ?></th>
            <td>
                <?php echo $form->textField($model, 'mobile', array('class' => 'text-input-bj middle')) ?>
                <?php echo $form->error($model, 'mobile') ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'identity_type'); ?></th>
            <td>
                <?php echo $form->dropDownList($model, 'identity_type', $model::identityType(), array('class' => 'text-input-bj valid')); ?>
                <?php echo $form->error($model, 'identity_type') ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'identity_number'); ?></th>
            <td>
                <?php echo $form->textField($model, 'identity_number', array('class' => 'text-input-bj middle')) ?>
                <?php echo $form->error($model, 'identity_number') ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'real_name'); ?></th>
            <td>
                <?php echo $form->textField($model, 'real_name', array('class' => 'text-input-bj middle')) ?>
                <?php echo $form->error($model, 'real_name') ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'sex'); ?></th>
            <td>
                <?php echo $form->radioButtonList($model, 'sex', $model::gender(), array('separator' => '')) ?>
                <?php echo $form->error($model, 'sex') ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'birthday'); ?></th>
            <td>
                <?php
                $model->birthday = empty($model->birthday) ? null : date('Y-m-d', $model->birthday);
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'birthday',
                    'select' => 'date',
                    'options' => array(
                        'yearRange' => '-100y',
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'birthday') ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'status'); ?></th>
            <td>
                <?php $model->status = $model->isNewRecord ? $model::STATUS_NO_ACTIVE : $model->status ?>
                <?php echo $form->radioButtonList($model, 'status', $model::status(), array('separator' => '')); ?>
                <?php echo $form->error($model, 'status') ?>
                &nbsp;(清除手机号码，1.先把状态改为"删除”，保存。2.再次修改，删除手机号，可为空保存)
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'type_id'); ?></th>
            <td>
                <?php
                $defaultVal = MemberType::fileCache();
                $model->type_id = $model->isNewRecord ? $defaultVal['defaultType'] : $model->type_id
                ?>
                <?php echo $form->radioButtonList($model, 'type_id', CHtml::listData(MemberType::model()->findAll(), 'id', 'name'), array('separator' => '')); ?>
                <?php echo $form->error($model, 'type_id') ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'grade_id'); ?></th>
            <td>
                <?php $model->grade_id = $model->isNewRecord ? MemberGrade::FIRST_ID : $model->grade_id ?>
                <?php echo $form->radioButtonList($model, 'grade_id', CHtml::listData(MemberGrade::model()->findAll(), 'id', 'name'), array('separator' => '')); ?>
                <?php echo $form->error($model, 'grade_id') ?>
            </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <?php $model->is_master_account = $model->isNewRecord ? $model::IS_MASTER_ACCOUNT : $model->is_master_account ?>
                <?php echo $form->checkBox($model, 'is_master_account') ?>
                <?php echo $form->label($model, 'is_master_account'); ?>
            </td>
        </tr>
        <tr>
            <th></th>
            <td><?php echo CHtml::submitButton($model->isNewRecord?Yii::t('member', '添加'):Yii::t('member', '更新'), array('class' => 'reg-sub')) ?></td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
