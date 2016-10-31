<?php
/* @var $this  BankAccountController */
/** @var $model BankAccount */
/** @var $memberModel Member */
/** @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberBankAccount','账户管理')=>'',
    Yii::t('memberBankAccount','银行账户设置'),
);
?>

<div class="mbRight">
	<div class="EntInfoTab">
		<ul class="clearfix">
			<li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberBankAccount','银行账户设置');?></span></a></li>
		</ul>
	</div>
    <div class="mbRcontent">

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => $this->id . '-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
                <table width="890" border="0" cellpadding="0" cellspacing="0" class="tableBank updateBase">

                    <tbody><tr>
                        <td height="50" colspan="3" align="center" class="tdBg">
                            <span><?php echo Yii::t('memberBankAccount',' 银行账户名必须和真实姓名一致，填写后不能修改 '); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="127" height="25" align="center" class="dtEe"><?php echo $form->labelEx($model,'account_name'); ?>：</td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                                <?php echo $model->account_name ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="127" height="25" align="center" class="dtEe"><?php echo $form->labelEx($model,'bank_name'); ?>：</td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                                <?php echo $form->textField($model,'bank_name',array('class'=>'inputtxt')) ?>
                                <?php echo $form->error($model,'bank_name') ?>
                        </td>
                    </tr>
                    <tr>
                        <td height="30" align="center" class="dtEe"><?php echo Yii::t('memberBankAccount','银行所在地区'); ?>：</td>
                        <td colspan="2" class="dtFff pdleft20 province">
                            <?php
                            echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                                'prompt' => Yii::t('memberBankAccount', '选择省份'),
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('/member/region/updateCity'),
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
                            <?php echo $form->error($model, 'province_id'); ?>
                            <?php
                            echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                                'prompt' => Yii::t('memberBankAccount', '选择城市'),
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('/member/region/updateArea'),
                                    'update' => '#BankAccount_district_id',
                                    'data' => array(
                                        'city_id' => 'js:this.value',
                                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                    ),
                                )));
                            ?>
                            <?php echo $form->error($model, 'city_id'); ?>
                            <?php
                            echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                                'prompt' => Yii::t('memberBankAccount', '选择地区'),
                                'ajax' => array(
                                    'type' => 'POST',
                                    'data' => array(
                                        'city_id' => 'js:this.value',
                                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                    ),
                                )));
                            ?>
                            <?php echo $form->error($model, 'district_id'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="127" height="25" align="center" class="dtEe"><?php echo $form->labelEx($model,'account'); ?>：</td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo $form->textField($model,'account',array('class'=>'inputtxt')) ?>
                            <?php echo $form->error($model,'account') ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?php echo CHtml::submitButton('',array('class'=>'bankBtn','style'=>'cursor:pointer')) ?>
                <?php  $this->endWidget(); ?>
            </div>
            <div class="mbDate1_b"></div>

        </div>

    </div>
</div>