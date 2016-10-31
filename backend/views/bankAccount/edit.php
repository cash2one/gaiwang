<?php
/* @var $this BankAccountController */
/* @var $bankModel BankAccount */
/* @var $form CActiveForm */
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->clientScript;
//显示原图的JS插件
$cs->registerCssFile($baseUrl . "/js/swf/js/fancybox/jquery.fancybox-1.3.4.css");
$cs->registerScriptFile($baseUrl . "/js/swf/js/fancybox/jquery.fancybox-1.3.4.pack.js", CClientScript::POS_END);
?>
<script>
    $(function(){
        $(".pic").fancybox();
        $(".pic img").css('display','inline');
    });
</script>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'bankAccount-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
    <tr>
        <td colspan="2" class="title-th" align="center">
            <?php echo Yii::t('bankAccount','会员信息'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo Yii::t('bankAccount','盖网通编号') ?>：</th>
        <td><?php echo $memberModel->gai_number ?></td>
    </tr>

    <tr>
        <td colspan="2" class="title-th" align="center">
            <?php echo Yii::t('bankAccount','银行账户信息'); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $form->labelEx($bankModel,'bank_code'); ?>：
        </th>
        <td>
             <?php echo $form->dropDownList($bankModel,'bank_code',BankAccount::bankList(),array('class'=>'text-input-bj  middle')) ?>
             <?php echo $form->error($bankModel, 'bank_code'); ?>
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $form->labelEx($bankModel,'account_name'); ?>：
        </th>
        <td>
            <?php echo $form->textField($bankModel,'account_name',
                array('class'=>'text-input-bj middle')
            ) ?>
            <?php echo $form->error($bankModel,'account_name') ?>
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
            <?php // echo Yii::t('bankAccount','银行所在地区'); ?>
           <label class="required"><?php echo Yii::t('franchisee', '银行所在地区'); ?> <span class="required">*</span>：</label>
        </th>
        <td>
            <?php
            echo $form->dropDownList($bankModel, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                'prompt' => Yii::t('bankAccount', '选择省份'),
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
                'prompt' => Yii::t('bankAccount', '选择城市'),
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
                'prompt' => Yii::t('bankAccount', '选择地区'),
                'ajax' => array(
                    'type' => 'POST',
                    'data' => array(
                        'city_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                )));
            ?>
            <div style="display:inline-block;" class="bank_province">
                <?php echo $form->error($bankModel, 'district_id'); ?>
                <?php echo $form->error($bankModel, 'city_id'); ?>
                <?php echo $form->error($bankModel, 'province_id'); ?>
            </div>
        </td>
    </tr>

    <tr>
        <th>
            <?php echo $form->labelEx($bankModel, 'licence_image') ?>
        </th>
        <td >
            <?php echo $form->fileField($bankModel, 'licence_image') ?>
            <?php if (!empty($bankModel->licence_image)): ?>
                <?php $imgSrc= ATTR_DOMAIN .'/'. $bankModel->licence_image; ?>
                <a class="pic blue" href="<?php echo $imgSrc ?>">
                    <img width="80" src="<?php echo $imgSrc ?>" >
                    (<?php echo Yii::t('enterprise','预览') ?>)
                </a>
            <?php endif; ?>
            <?php echo $form->error($bankModel, 'licence_image', array(), false) ?>
            <?php echo $form->hiddenField($bankModel,'licence_image') ?>
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
