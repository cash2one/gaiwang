<?php
/* @var $this MemberController */
/* @var $member Member */
/* @var $enterprise Enterprise */
/** @var $enterpriseData enterpriseData */
/* @var $form CActiveForm */
$this->breadcrumbs = array(Yii::t('enterprise', '企业会员') => array('admin'), Yii::t('enterprise', '更新企业信息'));
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'member-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'beforeValidate'=>'js:function(form){
           $(".hiddenTr:hidden").remove(); //移除多余的图片上传控件
           return true;
        }',
    ),
));
?>
<style>
    .hiddenTr{display: none;}
</style>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
    <tr>
        <td colspan="2" class="title-th" align="center">
            <?php echo Yii::t('member','用户信息'); ?>
        </td>
    </tr>

    <tr>
        <th style="text-align: right"><?php echo $form->labelEx($member, 'username'); ?>：</th>
        <td>
            <?php echo $form->textField($member, 'username', array('class' => 'text-input-bj middle')) ?>
            <?php echo $form->error($member, 'username') ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right"><?php echo $form->labelEx($member, 'mobile') ?>：</th>
        <td>
            <?php echo $form->textField($member, 'mobile', array('class' => 'text-input-bj middle')) ?>
            <?php echo $form->error($member, 'mobile') ?>
        </td>
    </tr>

    <tr>
        <th style="text-align: right"><?php echo $form->labelEx($member, 'identity_type'); ?>:</th>
        <td>
            <?php echo $form->dropDownList($member, 'identity_type', $member::identityType(), array('class' => 'text-input-bj valid')); ?>
            <?php echo $form->error($member, 'identity_type') ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right"><?php echo $form->labelEx($member, 'identity_number'); ?>:</th>
        <td>
            <?php echo $form->textField($member, 'identity_number', array('class' => 'text-input-bj middle')) ?>
            <?php echo $form->error($member, 'identity_number') ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right"><?php echo $form->labelEx($member, 'real_name'); ?>:</th>
        <td>
            <?php echo $form->textField($member, 'real_name', array('class' => 'text-input-bj middle')) ?>
            <?php echo $form->error($member, 'real_name') ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right"><?php echo $form->labelEx($member, 'sex'); ?>:</th>
        <td>
            <?php echo $form->radioButtonList($member, 'sex', $member::gender(), array('separator' => '')) ?>
            <?php echo $form->error($member, 'sex') ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right"><?php echo $form->labelEx($member, 'birthday'); ?>:</th>
        <td>
            <?php
            $member->birthday = empty($member->birthday) ? null : date('Y-m-d', ($member->birthday)*1);
            $this->widget('comext.timepicker.timepicker', array(
                'model' => $member,
                'name' => 'birthday',
                'select' => 'date',
                'options' => array(
                    'yearRange' => '-100y',
                ),
            ));
            ?>
            <?php echo $form->error($member, 'birthday') ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right"><?php echo $form->labelEx($member, 'status'); ?>:</th>
        <td>
            <?php $member->status = $member->isNewRecord ? $member::STATUS_NO_ACTIVE : $member->status ?>
            <?php echo $form->radioButtonList($member, 'status', $member::status(), array('separator' => '')); ?>
            <?php echo $form->error($member, 'status') ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right"><?php echo $form->labelEx($member, 'type_id'); ?>:</th>
        <td>
            <?php
            $defaultVal = MemberType::fileCache();
            $member->type_id = $member->isNewRecord ? $defaultVal['defaultType'] : $member->type_id
            ?>
            <?php echo $form->radioButtonList($member, 'type_id', CHtml::listData(MemberType::model()->findAll(), 'id', 'name'), array('separator' => '')); ?>
            <?php echo $form->error($member, 'type_id') ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right"><?php echo $form->labelEx($member, 'grade_id'); ?>:</th>
        <td>
            <?php $member->grade_id = $member->isNewRecord ? MemberGrade::FIRST_ID : $member->grade_id ?>
            <?php echo $form->radioButtonList($member, 'grade_id', CHtml::listData(MemberGrade::model()->findAll(), 'id', 'name'), array('separator' => '')); ?>
            <?php echo $form->error($member, 'grade_id') ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right"></th>
        <td>
            <?php $member->is_master_account = $member->isNewRecord ? $member::IS_MASTER_ACCOUNT : $member->is_master_account ?>
            <?php echo $form->checkBox($member, 'is_master_account') ?>
            <?php echo $form->label($member, 'is_master_account'); ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right"><?php echo $form->labelEx($enterprise, 'apply_cash_limit'); ?>:</th>
        <td>
            <?php echo $form->radioButtonList($enterprise, 'apply_cash_limit', Enterprise::getApplyCashList(), array('separator' => '')); ?>
            <?php echo $form->error($enterprise, 'apply_cash_limit') ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center" class="title-th">
            <?php echo Yii::t('enterprise','公司信息'); ?>
        </td>
    </tr>

    <tr>
        <th style="text-align: right" >
            <?php echo $form->labelEx($enterprise, 'name') ?>：
        </th>
        <td >
            <?php echo $form->textField($enterprise, 'name', array('class' => 'text-input-bj middle', 'placeholder' => '请填写公司完整名称')) ?>
            <?php echo $form->error($enterprise, 'name') ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right">
            <?php echo $form->labelEx($enterprise, 'link_phone') ?>：
        </th>
        <td >
            <?php echo $form->textField($enterprise, 'link_phone', array('class' => 'text-input-bj middle')) ?>
            <?php echo $form->error($enterprise, 'link_phone') ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right">
            <?php echo $form->labelEx($enterprise, 'enterprise_type') ?>：
        </th>
        <td >
            <?php echo Enterprise::getEnterpriseType($enterprise->enterprise_type) ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right" >
            <?php echo $form->labelEx($enterprise, 'link_man') ?>：
        </th>
        <td >
            <?php echo $form->textField($enterprise, 'link_man', array('class' => 'text-input-bj middle')) ?>
            <?php echo $form->error($enterprise, 'link_man') ?>
        </td>
    </tr>

    <tr>
        <th style="text-align: right" >
            <?php echo Yii::t('enterprise', '公司注册地'); ?>
            <span class="required">*</span>：
        </th>

        <td >
            <?php
            echo $form->dropDownList($enterprise, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                'prompt' => Yii::t('enterprise', '选择省份'),
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/region/updateCity'),
                    'dataType' => 'json',
                    'data' => array(
                        'province_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                    'success' => 'function(data) {
                            $("#Enterprise_city_id").html(data.dropDownCities);
                            $("#Enterprise_district_id").html(data.dropDownCounties);
                        }',
                )));
            ?>
            <?php echo $form->error($enterprise, 'province_id'); ?>
            <?php
            echo $form->dropDownList($enterprise, 'city_id', Region::getRegionByParentId($enterprise->province_id), array(
                'prompt' => Yii::t('enterprise', '选择城市'),
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/region/updateArea'),
                    'update' => '#Enterprise_district_id',
                    'data' => array(
                        'city_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                )));
            ?>
            <?php echo $form->error($enterprise, 'city_id'); ?>
            <?php
            echo $form->dropDownList($enterprise, 'district_id', Region::getRegionByParentId($enterprise->city_id), array(
                'prompt' => Yii::t('enterprise', '选择地区'),
                'ajax' => array(
                    'type' => 'POST',
                    'data' => array(
                        'city_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                )));
            ?>
            <?php echo $form->error($enterprise, 'district_id'); ?>
        </td>
    </tr>

    <tr>
        <th style="text-align: right" >
            <?php echo $form->labelEx($enterprise, 'street'); ?>：
        </th>
        <td>
            <?php echo $form->textField($enterprise, 'street', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($enterprise, 'street') ?>
        </td>
    </tr>


    <tr>
        <td colspan="2" align="center" class="title-th" >
            <?php echo Yii::t('enterprise', '营业执照信息'); ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right" >
            <?php echo $form->labelEx($enterpriseData, 'license') ?>：
        </th>
        <td >
            <?php echo $form->textField($enterpriseData, 'license', array('class' => 'text-input-bj middle')) ?>
            <?php echo $form->error($enterpriseData, 'license') ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right" >
            <?php echo $form->labelEx($enterpriseData, 'legal_man') ?>：
        </th>
        <td  >
            <?php echo $form->textField($enterpriseData, 'legal_man', array('class' => 'text-input-bj middle')) ?>
            <?php echo $form->error($enterpriseData, 'legal_man') ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right" >
            <?php echo $form->labelEx($enterpriseData, 'legal_phone') ?>：
        </th>
        <td >
            <?php echo $form->textField($enterpriseData, 'legal_phone', array('class' => 'text-input-bj middle')) ?>
            <?php echo $form->error($enterpriseData, 'legal_phone') ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right" >
            <?php echo Yii::t('enterprise', '营业执照注册地'); ?>
            <span class="required">*</span>：
        </th>
        <td  >
            <?php
            echo $form->dropDownList($enterpriseData, 'license_province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                'prompt' => Yii::t('enterprise', '选择省份'),
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/region/updateCity'),
                    'dataType' => 'json',
                    'data' => array(
                        'province_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                    'success' => 'function(data) {
                            $("#EnterpriseData_license_city_id").html(data.dropDownCities);
                            $("#EnterpriseData_license_district_id").html(data.dropDownCounties);
                        }',
                )));
            ?>
            <?php echo $form->error($enterpriseData, 'license_province_id'); ?>
            <?php
            echo $form->dropDownList($enterpriseData, 'license_city_id', Region::getRegionByParentId($enterpriseData->license_province_id), array(
                'prompt' => Yii::t('enterprise', '选择城市'),
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/region/updateArea'),
                    'update' => '#EnterpriseData_license_district_id',
                    'data' => array(
                        'city_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                )));
            ?>
            <?php echo $form->error($enterpriseData, 'license_city_id'); ?>
            <?php
            echo $form->dropDownList($enterpriseData, 'license_district_id', Region::getRegionByParentId($enterpriseData->license_city_id), array(
                'prompt' => Yii::t('enterprise', '选择地区'),
                'ajax' => array(
                    'type' => 'POST',
                    'data' => array(
                        'city_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                )));
            ?>
            <?php echo $form->error($enterpriseData, 'license_district_id'); ?>
        </td>
    </tr>
    <?php if($enterprise->enterprise_type==Enterprise::TYPE_ENTERPRISE): ?>
    <tr>
        <th style="text-align: right" >
            <?php echo Yii::t('enterprise', '营业执照有效期') ?>
            <span class="required">*</span>：
        </th>
        <td >
            <?php
            $enterpriseData->license_start_time = empty($enterpriseData->license_start_time) ? '' : date('Y-m-d', $enterpriseData->license_start_time);
            $enterpriseData->license_end_time = empty($enterpriseData->license_end_time) ? '' : date('Y-m-d', $enterpriseData->license_end_time);

            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $enterpriseData,
                'language' => Yii::app()->language,
                'attribute' => 'license_start_time',
                'options' => array(
                    'dateFormat' => 'yy-mm-dd',
                    'changeMonth' => true,
                    'changeYear' => true,
                ),
                'htmlOptions' => array(
                    'readonly' => 'readonly',
                    'class' => 'integaralIpt5',
                )
            ));
            ?>-
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $enterpriseData,
                'attribute' => 'license_end_time',
                'options' => array(
                    'dateFormat' => 'yy-mm-dd',
                    'changeMonth' => true,
                    'changeYear' => true,
                ),
                'htmlOptions' => array(
                    'readonly' => 'readonly',
                    'class' => 'integaralIpt5',
                )
            ));
            ?>
            <?php echo $form->error($enterpriseData, 'license_start_time') ?>
            <?php echo $form->error($enterpriseData, 'license_end_time') ?>
        </td>
    </tr>
    <?php endif; ?>

    <?php $this->renderPartial('_img2', array('model' => $enterpriseData, 'field' => 'license_photo', 'form' => $form)); ?>

    <?php if($enterprise->enterprise_type==Enterprise::TYPE_INDIVIDUAL): ?>
        <?php $this->renderPartial('_img2', array('model' => $enterpriseData, 'field' => 'identity_image', 'form' => $form)); ?>
        <?php $this->renderPartial('_img2', array('model' => $enterpriseData, 'field' => 'identity_image2', 'form' => $form)); ?>
        <?php $this->renderPartial('_img2', array('model' => $enterpriseData, 'field' => 'debit_card_image', 'form' => $form)); ?>
        <?php $this->renderPartial('_img2', array('model' => $enterpriseData, 'field' => 'debit_card_image2', 'form' => $form)); ?>
    <?php endif; ?>

    <?php $this->renderPartial('_img2', array('model' => $enterpriseData, 'field' => 'tax_image', 'form' => $form)); ?>
    <tr>
        <td colspan="2" align="center" class="title-th">
                <?php echo Yii::t('enterpriseData','经营类目信息') ?>
        </td>
    </tr>
    <tr>
        <td width="140" height="25" align="center" class="dtEe">
            <?php echo $form->labelEx($store, 'category_id') ?>：
        </td>
        <td height="25" colspan="2" class="dtFff pdleft20 hobbies" style="line-height: 30px;">
            <?php
            $category = Category::getTopCategory();
            echo $form->radioButtonList($store, 'category_id', CHtml::listData($category, 'id', 'name'),
                array(
                    'class' => 'checkboxItem',
                    'separator' => '&nbsp;',
                    'template' => '<span>{input} {label}</span>',
                )) ?>
            <?php echo $form->error($store, 'category_id') ?>
        </td>
    </tr>

    <?php $this->renderPartial('_img2', array('model' => $enterpriseData, 'field' => 'threec_image', 'form' => $form, 'class' => 'hiddenTr')); ?>
    <?php $this->renderPartial('_img2', array('model' => $enterpriseData, 'field' => 'cosmetics_image', 'form' => $form, 'class' => 'hiddenTr')); ?>
    <?php $this->renderPartial('_img2', array('model' => $enterpriseData, 'field' => 'food_image', 'form' => $form, 'class' => 'hiddenTr')); ?>
    <?php $this->renderPartial('_img2', array('model' => $enterpriseData, 'field' => 'jewelry_image', 'form' => $form, 'class' => 'hiddenTr')); ?>
    <tr>
        <td width="140" height="25" align="center" class="dtEe">
            <?php echo $form->labelEx($enterpriseData, 'exists_imported_goods') ?>：
        </td>
        <td height="25" colspan="2" class="dtFff pdleft20 hobbies" style="line-height: 30px;">
            <?php
            if($enterpriseData->isNewRecord) $enterpriseData->exists_imported_goods = EnterpriseData::EXISTS_IMPORTED_GOODS_NO;
            ?>
            <?php echo $form->radioButtonList($enterpriseData,'exists_imported_goods',EnterpriseData::existsImportedGoods(),array('separator'=>' ')) ?>
        </td>
    </tr>
    <?php $this->renderPartial('_img2', array('model' => $enterpriseData, 'field' => 'declaration_image', 'form' => $form, 'class' => 'hiddenTr')); ?>
    <?php $this->renderPartial('_img2', array('model' => $enterpriseData, 'field' => 'report_image', 'form' => $form, 'class' => 'hiddenTr')); ?>
    <?php $this->renderPartial('_img2', array('model' => $enterpriseData, 'field' => 'brand_image', 'form' => $form)); ?>
    <tr>
        <td colspan="2" align="center" class="title-th">
            <?php echo Yii::t('memberMember', '开店模式'); ?>
        </td>
    </tr>
    <tr>
        <td width="140" height="25" align="center" class="dtEe">
            <?php echo $form->labelEx($store, 'mode') ?>：
        </td>
        <td height="25" colspan="2" class="dtFff pdleft20 hobbies">
            <?php echo $form->radioButtonList($store,'mode',Store::getMode()) ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: right">
            <?php echo $form->labelEx($enterprise,'auditing'); ?>:
        </th>
        <td>
            <?php echo $form->radioButtonList($enterprise,'auditing',Enterprise::auditingArr(),array('separator'=>'')) ?>
            <?php echo $form->error($enterprise,'auditing') ?>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <?php echo CHtml::submitButton(Yii::t('member','提交'),array('class'=>'reg-sub')) ?>
        </td>
    </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>

<script>
    var category = {
        appliances:<?php echo Category::TOP_APPLIANCES ?>,
        cosmetics:<?php echo Category::TOP_COSMETICS ?>,
        food:<?php echo Category::TOP_FOOD ?>,
        jewelry:<?php echo Category::TOP_JEWELRY ?>,
        url:"<?php echo Yii::app()->createAbsoluteUrl('enterprise/update2',array('id'=>$enterprise->id)) ?>",
        showUpload:function(c){
            $("#threec_image").hide();
            $("#cosmetics_image").hide();
            $("#food_image").hide();
            $("#jewelry_image").hide();
            switch(c){
                case category.appliances:
                    if($("#threec_image").show().length==0) window.location.href = category.url;
                    break;
                case category.cosmetics:
                    if($("#cosmetics_image").show().length==0) window.location.href = category.url;
                    break;
                case category.food:
                    if($("#food_image").show().length==0) window.location.href = category.url;
                    break;
                case category.jewelry:
                    if($("#jewelry_image").show().length==0) window.location.href = category.url;
                    break;
                default :
                    break;
            }
        }
    };
    var checkCategory = $("#Store_category_id input:checked");
    if(checkCategory.length!==0){
        var c = parseInt(checkCategory.val());
        category.showUpload(c);
    }
    //类目选择，不同类目需要上传不同的证书
    $("#Store_category_id .checkboxItem").click(function(){
        var c = parseInt(this.value);
        category.showUpload(c);
    });
    //是否有进口商品
    $("#EnterpriseData_exists_imported_goods input:last").click(function(){
        $("#declaration_image").show();
        $("#report_image").show();
    });
    $("#EnterpriseData_exists_imported_goods input:first").click(function(){
        $("#declaration_image").hide();
        $("#report_image").hide();
    });
</script>
