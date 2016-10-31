<?php
$this->breadcrumbs = array(
    Yii::t('middleAgent','居间商列表')=>  array('middleAgent/admin'),
    Yii::t('middleAgent','修改居间商')
);
/** @var CActiveForm $form */
/** @var MiddleAgent $model  */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'middleAgent-form',
//    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th">
                <?php echo Yii::t('middleAgent', '修改居间商'); ?>
            </th>
        </tr>
        <tr>
            <th><?php echo Yii::t('middleAgent','居间商会员编号'); ?></th>
            <td>
                <?php echo $model->member->gai_number; ?>
            </td>
        </tr>
        <tr>
            <th><?php echo Yii::t('middleAgent','会员名称'); ?></th>
            <td>
                <?php echo $model->member->username ?>
            </td>
        </tr>
        <tr>
            <th><?php echo Yii::t('middleAgent','居间商级别'); ?></th>
            <td>
                <?php echo $form->dropDownList($model,'level',MiddleAgent::getLevel(),array('class'=>'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'level'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo Yii::t('middleAgent','手机号码'); ?></th>
            <td>
                <?php echo $model->member->mobile ?>
            </td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center;padding-right: 358px;"><?php echo CHtml::submitButton(Yii::t('middleAgent','修改'),array('class'=>'regm-sub')); ?></th>
        </tr>
        </tbody>
    </table>
    <script>
<?php $this->endWidget(); ?>