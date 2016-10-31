<?php
/* @var $this BankAccountController */
/* @var $bankModel BankAccount */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'bankAccount-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
    <tr>
        <td colspan="2" class="title-th" align="center">
            <?php echo Yii::t('member','银行账户信息'); ?>
        </td>
    </tr>
     <tr>
        <th>
            <?php echo $form->labelEx($bankModel,'bank_code'); ?>：
        </th>
        <td>
             <?php echo $form->dropDownList(bankModel,'bank_code',BankAccount::bankList(),array('class'=>'text-input-bj  middle')) ?>
             <?php echo $form->error(bankModel, 'bank_code'); ?>
        </td>
    </tr>
    
    <tr>
        <th>
            <?php echo $form->labelEx($bankModel,'account_name'); ?>：
        </th>
        <td>
            <?php echo $form->textField($bankModel,'account_name',
                array('class'=>'text-input-bj middle','readOnly'=>'readOnly')
            ) ?>
            <?php echo $form->error($bankModel,'account_name') ?>
            (<?php echo Yii::t('member','账户名与真实名字必须一致'); ?>)
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $form->labelEx($bankModel,'bank_name'); ?>：
        </th>
        <td>
            <?php echo $form->textField($bankModel,'bank_name',array('class'=>'text-input-bj middle')) ?>
            <?php echo $form->error($bankModel,'bank_name') ?>
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $form->labelEx($bankModel,'account'); ?>：
        </th>
        <td>
            <?php echo $form->textField($bankModel,'account',array('class'=>'text-input-bj middle')) ?>
            <?php echo $form->error($bankModel,'account') ?>
        </td>
    </tr>
    <tr>
        <th>
            <?php echo Yii::t('member','银行所在地区'); ?>：
        </th>
        <td>
            <?php
            echo $form->dropDownList($bankModel, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                'prompt' => Yii::t('member', '选择省份'),
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/region/updateCity'),
                    'dataType' => 'json',
                    'data' => array(
                        'province_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                    'success' => 'function(data) {
                            $("#BankAccount_city_id").html(data.dropDownCities);
                            $("#BankAccount_district_id").html(data.dropDownCounties);
                        }',
                )));
            ?>

            <?php
            echo $form->dropDownList($bankModel, 'city_id', Region::getRegionByParentId($bankModel->province_id), array(
                'prompt' => Yii::t('member', '选择城市'),
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/region/updateArea'),
                    'update' => '#BankAccount_district_id',
                    'data' => array(
                        'city_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                )));
            ?>

            <?php
            echo $form->dropDownList($bankModel, 'district_id', Region::getRegionByParentId($bankModel->city_id), array(
                'prompt' => Yii::t('member', '选择地区'),
                'ajax' => array(
                    'type' => 'POST',
                    'data' => array(
                        'city_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                )));
            ?>






        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo CHtml::submitButton('提交',array('class'=>'reg-sub')) ?>
        </td>
    </tr>
    </tbody>
    </table>
<?php $this->endWidget(); ?>
