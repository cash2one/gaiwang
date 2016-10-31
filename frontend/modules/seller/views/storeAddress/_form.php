<?php
/* @var $this StoreAddressController */
/* @var $model StoreAddress */
/* @var $form CActiveForm */
?>

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
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt15 sellerT3">
    <tbody><tr>
        <th width="10%"><?php echo $form->labelEx($model, 'link_man'); ?></th>
        <td width="90%">
            <?php echo $form->textField($model, 'link_man',
                array('size' => 60, 'maxlength' => 128,'class'=>'inputtxt1','style'=>'width:140px;')); ?>
            <?php echo $form->error($model, 'link_man'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo Yii::t('storeAddress','所在地'); ?><b class="red">*</b></th>
        <td>
            <?php
            echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                'prompt' => Yii::t('storeAddress', '选择省份'),
                'class' => 'selectTxt1',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createAbsoluteUrl('/seller/region/updateCity'),
                    'dataType' => 'json',
                    'data' => array(
                        'province_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                    'success' => 'function(data) {
                                        $("#StoreAddress_city_id").html(data.dropDownCities);
                                        $("#StoreAddress_district_id").html(data.dropDownCounties);
                                    }',
                )));
            ?>
            <?php
            echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                'prompt' => Yii::t('storeAddress', '选择城市'),
                'class' => 'selectTxt1',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createAbsoluteUrl('/seller/region/updateArea'),
                    'update' => '#StoreAddress_district_id',
                    'data' => array(
                        'city_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                )));
            ?>
            <?php
            echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                'prompt' => Yii::t('storeAddress', '选择区/县'),
                'class' => 'selectTxt1',
                'ajax' => array(
                    'type' => 'POST',
                    'data' => array(
                        'city_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                )));
            ?>
            <?php echo $form->error($model, 'province_id'); ?>

        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'street'); ?></th>
        <td>
            <?php echo $form->textField($model, 'street',
                array('size' => 40, 'maxlength' => 40,'class'=>'inputtxt1','style'=>'width:320px;')); ?>
            &nbsp;<span class="gray">（<?php echo Yii::t('storeAddress','不需要填写地区资料'); ?>）</span>
            <?php echo $form->error($model, 'street'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'zip_code'); ?></th>
        <td>
            <?php echo $form->textField($model, 'zip_code',
                array('size' => 16, 'maxlength' => 16,'class'=>'inputtxt1','style'=>'width:140px')); ?>
            <?php echo $form->error($model, 'zip_code'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'mobile'); ?></th>
        <td>
            <?php echo $form->textField($model, 'mobile',
                array('size' => 16, 'maxlength' => 16,'class'=>'inputtxt1','style'=>'width:140px')); ?>
            <?php echo $form->error($model, 'mobile'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'store_name'); ?></th>
        <td>
            <?php echo $form->textField($model, 'store_name',
                array('size' => 60, 'maxlength' => 128,'class'=>'inputtxt1','style'=>'width:320px')); ?>
            <?php echo $form->error($model, 'store_name'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'remark'); ?></th>
        <td>
            <?php echo $form->textArea($model, 'remark',
                array('rows' => 6, 'cols' => 50,'class'=>'textareaTxt1','style'=>'width:80%; height:80px;')); ?>
            <?php echo $form->error($model, 'remark'); ?>
        </td>
    </tr>
    </tbody></table>

<div class="profileDo mt15">
    <?php $submit=$model->isNewRecord ? Yii::t('storeAddress', '新增 ') : Yii::t('storeAddress', '保存') ?>
    <a class="sellerBtn03" id="submit"><span><?php echo $submit ?></span></a>&nbsp;
    <?php echo CHtml::submitButton('',array('style'=>'visibility:hidden','id'=>'submitBtn')) ?>
    &nbsp;<a onclick="history.back()" class="sellerBtn01"><span><?php echo Yii::t('storeAddress','返回'); ?></span></a>
</div>
<?php $this->endWidget(); ?>

<script>
    $(function(){
        $('#submit').click(function(){
            $("#submitBtn").click();
        });
    });
</script>