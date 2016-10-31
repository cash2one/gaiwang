<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'address-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'action' => '/member/address/index',
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
        ));
?>
<div class="shopaapaddressBox" style="<?php echo $add ? 'display:none' : 'disyplay:block'; ?>">

    <a href="#" class="shopaapaddressBtn" title="<?php echo Yii::t('address','添加新地址');?>"></a>
    <dl>
        <dt><?php echo Yii::t('address','所在地');?><span class="required">*</span></dt>
        <dd>
            <?php
            echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                'prompt' => Yii::t('member', Yii::t('address', '选择省份')),
                'class' => 'integaralXz mgleft5',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createAbsoluteUrl('/region/updateCity'),
                    'dataType' => 'json',
                    'data' => array(
                        'province_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                    'success' => 'function(data) {
                                        $("#Address_city_id").html(data.dropDownCities);
                                        $("#Address_district_id").html(data.dropDownCounties);
                                    }',
            )));
            ?>
            <?php
            echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                'prompt' => Yii::t('member', Yii::t('address', '选择城市')),
                'class' => 'integaralXz mgleft5',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createAbsoluteUrl('/region/updateArea'),
                    'update' => '#Address_district_id',
                    'data' => array(
                        'city_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
            )));
            ?>
            <?php
            echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                'prompt' => Yii::t('member', Yii::t('address', '选择区/县')),
                'class' => 'integaralXz mgleft5',
                'ajax' => array(
                    'type' => 'POST',
                    'data' => array(
                        'city_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
            )));
            ?>
        </dd>
    </dl>

    <dl>
        <dt><?php echo $form->labelEx($model, 'zip_code'); ?></dt>
        <dd>   
            <?php echo $form->textField($model, 'zip_code', array('class' => 'input_1')); ?>
            <span><?php echo Yii::t('address','大陆地区以外可以不填');?></span>
            <?php echo $form->error($model, 'zip_code'); ?>
        </dd>
    </dl>

    <dl>
        <dt><?php echo $form->labelEx($model, 'street'); ?></dt>
        <dd> 
            <?php echo $form->textArea($model, 'street', array('class' => 'input_2')); ?>
            <?php echo $form->error($model, 'street'); ?>
        </dd>

    </dl>

    <dl>
        <dt><?php echo $form->labelEx($model, 'real_name'); ?></dt>
        <dd>
            <?php echo $form->textField($model, 'real_name', array('class' => 'input_1')); ?>
            <?php echo $form->error($model, 'real_name'); ?>
        </dd>
    </dl>

    <dl>
        <dt><?php echo $form->labelEx($model, 'mobile'); ?></dt>
        <dd> 
            <?php echo $form->textField($model, 'mobile', array('class' => 'input_1')); ?>
            <span class="gay95 mgleft5"><?php echo Yii::t('address','手机号码必填');?></span>
            <?php echo $form->error($model, 'mobile'); ?>
        </dd>
    </dl>

    <dl>
        <dt><?php echo Yii::t('address','设为默认');?>：</dt>
        <dd><?php echo $form->checkBox($model, 'default', array('class' => 'mgright5')); ?><span><?php echo Yii::t('address','设置后系统将在购买时自动选中该收货地址');?></span></dd>
    </dl>
    <?php echo CHtml::submitButton(Yii::t('address','保存'), array('class' => 'shopFladdressQdBtn')); ?>
    <!--                 <a href="#" title="保存" class="shopFladdressQdBtn">保存</a>-->
</div>
<?php $this->endWidget(); ?>     