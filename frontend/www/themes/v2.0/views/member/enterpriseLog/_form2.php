<?php
/** @var $model Member */
/** @var $enterprise Enterprise */
/** @var $enterpriseData EnterpriseData */
/** @var $form CActiveForm */
/** @var BankAccount $bankAccount */
$uploadTips = Yii::t('memberMember', '(请确保图片清晰)');
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/artDialog/plugins/iframeTools.js', CClientScript::POS_END);
$form = $this->beginWidget('ActiveForm', array(
    'id' => 'member-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'beforeValidate' => 'js:function(form){
           $(".hiddenTr:hidden").remove(); //移除多余的图片上传控件
           return true;
        }',
    ),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
        ));
?>
<style>
    .hiddenTr{display: none;}
    .menavRiht span{color:#fff;!important;}
</style>

<table width="890" border="0" cellpadding="0" cellspacing="0" class="tableBank updateBase">
    <tbody>
        <tr>
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo Yii::t('enterpriseLog', '网店商户类型') ?>：
            </td>
            <td height="25" colspan="2" class="dtFff pdleft20 hobbies" style="line-height: 30px;">
                <?php if ($enterpriseData->isNewRecord) { ?>
                    <ul class="clearfix">
                        <li class=""><?php
                            echo CHtml::link(Yii::t('enterpriseLog', '企业'), array('enterpriseLog/enterprise'), array('onclick' => 'return confirm("请注意！更改网店商户类型后，原有的资料将会清空")'));
                            ?></li>
                        <li class="current"><?php echo Yii::t('enterpriseLog', '个体工商户') ?></li>
                    </ul>
                <?php } elseif (isset($lastOne->status) && $lastOne->status == EnterpriseLog::STATUS_NOT_PASS && isset($lastOne->progress) && $lastOne->progress != EnterpriseLog::PROCESS_CLOSE_STORE) { ?>
                   <ul class="clearfix">
                        <li class=""><?php
                            echo CHtml::link(Yii::t('enterpriseLog', '企业'), array('enterpriseLog/enterprise'), array('onclick' => 'return confirm("请注意！更改网店商户类型后，原有的资料将会清空")'));
                            ?></li>
                        <li class="current"><?php echo Yii::t('enterpriseLog', '个体工商户') ?></li>
                    </ul>
                <?php } else { ?>
                    <ul>
                        <li class="current"><?php echo Yii::t('enterpriseLog', '个体工商户') ?></li>
                    </ul>
                <?php } ?>
            </td>
        </tr>
        <?php
//经营类目
        $this->renderPartial('_category', array('form' => $form, 'enterpriseData' => $enterpriseData, 'store' => $store, 'enterprise' => $enterprise));
        ?>
        <tr>
            <td height="50" colspan="3" align="center" class="dtffe">
                <b><?php echo Yii::t('memberMember', '开店模式'); ?></b>
            </td>
        </tr>
        <tr>
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo $form->labelEx($store, 'mode') ?>：
            </td>
            <td height="25" colspan="2" class="dtFff pdleft20 hobbies">
                <?php echo Yii::t('memberEnterpriseLog', '待您提交资料后，商城将安排专人与您沟通。') ?>
                <!--        --><?php
                //echo Yii::t('memberEnterpriseLog','商城目前分为 {0} 与 {1} 两种开店模式，待您提交资料后，商城将安排专员与您进行沟通采用哪种开店模式，请留意。',array(
//            '{0}'=>CHtml::link(Yii::t('memberEnterpriseLog','收费版'),'#',array('id'=>'feeNotice','class'=>'red')),
//            '{1}'=>CHtml::link(Yii::t('memberEnterpriseLog','免费版'),'#',array('id'=>'freeNotice','class'=>'red')),
//        )); 
                ?>
            </td>
        </tr>
        <tr>
            <td height="50" colspan="3" align="center" class="dtffe">
                <b><?php echo Yii::t('memberMember', '店铺信息'); ?></b>
            </td>
        </tr>

        <tr id="storeName">
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo $form->labelEx($store, 'name') ?>：
            </td>
            <td height="25" colspan="2" class="dtFff pdleft20">
                <?php echo $form->textField($store, 'name', array('class' => 'inputtxt', 'placeholder' => '请填写完整店铺名称')) ?>
                <?php echo $form->error($store, 'name') ?>
            </td>
        </tr>

        <tr id="storeMobile">
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo $form->labelEx($store, 'mobile') ?>：
            </td>
            <td height="25" colspan="2" class="dtFff pdleft20">
                <?php echo $form->textField($store, 'mobile', array('class' => 'inputtxt')) ?>
                <?php echo $form->error($store, 'mobile') ?>
            </td>
        </tr>

        <tr id="storeEmail">
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo $form->labelEx($store, 'email') ?>：
            </td>
            <td height="25" colspan="2" class="dtFff pdleft20">
                <?php echo $form->textField($store, 'email', array('class' => 'inputtxt')) ?>
                <?php echo $form->error($store, 'email') ?>
                (注:<span style="color:red;">请填写店铺管理人员的联系邮箱</span>,店铺状态及新订单提醒将发到该邮箱。)
            </td>
        </tr>

        <tr id="storePlace">
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo Yii::t('memberMember', '店铺所在地'); ?>
                <span class="required">*</span>：
            </td>
            <td height="25" colspan="2" class="dtFff pdleft20">
                <?php
                echo $form->dropDownList($store, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                    'prompt' => Yii::t('memberMember', '选择省份'),
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/member/region/updateCity'),
                        'dataType' => 'json',
                        'data' => array(
                            'province_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => 'function(data) {
                            $("#Store_city_id").html(data.dropDownCities);
                            $("#Store_district_id").html(data.dropDownCounties);
                        }',
                )));
                ?>
                <?php echo $form->error($store, 'province_id'); ?>
                <?php
                echo $form->dropDownList($store, 'city_id', Region::getRegionByParentId($store->province_id), array(
                    'prompt' => Yii::t('memberMember', '选择城市'),
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/member/region/updateArea'),
                        'update' => '#Store_district_id',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
                ?>
                <?php echo $form->error($store, 'city_id'); ?>
                <?php
                echo $form->dropDownList($store, 'district_id', Region::getRegionByParentId($store->city_id), array(
                    'prompt' => Yii::t('memberMember', '选择地区'),
                    'ajax' => array(
                        'type' => 'POST',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
                ?>
                <?php echo $form->error($store, 'district_id'); ?>
            </td>
        </tr>

        <tr id="storeAddress">
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo $form->labelEx($store, 'street') ?>：
            </td>
            <td height="25" colspan="2" class="dtFff pdleft20">
                <?php echo $form->textField($store, 'street', array('class' => 'inputtxt')) ?>
                <?php echo $form->error($store, 'street') ?>
            </td>
        </tr>


        <tr>
            <td height="50" colspan="3" align="center" class="dtffe">
                <b><?php echo Yii::t('memberMember', '个体户信息'); ?></b>
            </td>
        </tr>
        <tr id="enterpriseName">
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo $form->labelEx($enterprise, 'name') ?>：
            </td>
            <td height="25" colspan="2" class="dtFff pdleft20">
                <?php echo $form->textField($enterprise, 'name', array('class' => 'inputtxt', 'placeholder' => '请填写公司完整名称')) ?>
                <?php echo $form->error($enterprise, 'name') ?>
            </td>
        </tr>
        <tr id="link_phone">
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo $form->labelEx($enterprise, 'link_phone') ?>：
            </td>
            <td height="25" colspan="2" class="dtFff pdleft20">
                <?php echo $form->textField($enterprise, 'link_phone', array('class' => 'inputtxt')) ?>
                <?php echo $form->error($enterprise, 'link_phone') ?>
            </td>
        </tr>
        <tr id="link_man">
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo $form->labelEx($enterprise, 'link_man') ?>：
            </td>
            <td height="25" colspan="2" class="dtFff pdleft20">
                <?php echo $form->textField($enterprise, 'link_man', array('class' => 'inputtxt')) ?>
                <?php echo $form->error($enterprise, 'link_man') ?>
            </td>
        </tr>

        <tr id="enterprisePlace">
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo Yii::t('memberMember', '公司注册地'); ?>
                <span class="required">*</span>：
            </td>

            <td height="25" colspan="2" class="dtFff pdleft20">
                <?php
                echo $form->dropDownList($enterprise, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                    'prompt' => Yii::t('memberMember', '选择省份'),
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/member/region/updateCity'),
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
                    'prompt' => Yii::t('memberMember', '选择城市'),
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/member/region/updateArea'),
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
                    'prompt' => Yii::t('memberMember', '选择地区'),
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

        <tr id="enterpriseAddress">
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo $form->labelEx($enterprise, 'street'); ?>：
            </td>
            <td>
                <?php echo $form->textField($enterprise, 'street', array('class' => 'inputtxt')); ?>
                <?php echo $form->error($enterprise, 'street') ?>
            </td>
        </tr>


        <tr>
            <td height="50" colspan="3" align="center" class="dtffe">
                <b><?php echo Yii::t('memberMember', '营业执照信息'); ?></b>
            </td>
        </tr>
        <tr id="license">
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo $form->labelEx($enterpriseData, 'license') ?>：
            </td>
            <td height="25" colspan="2" class="dtFff pdleft20">
                <?php echo $form->textField($enterpriseData, 'license', array('class' => 'inputtxt')) ?>
                <?php echo $form->error($enterpriseData, 'license') ?>
            </td>
        </tr>
        <tr id="legal_man">
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo $form->labelEx($enterpriseData, 'legal_man') ?>：
            </td>
            <td height="25" colspan="2" class="dtFff pdleft20">
                <?php echo $form->textField($enterpriseData, 'legal_man', array('class' => 'inputtxt')) ?>
                <?php echo $form->error($enterpriseData, 'legal_man') ?>
            </td>
        </tr>
        <tr id="legal_phone">
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo $form->labelEx($enterpriseData, 'legal_phone') ?>：
            </td>
            <td height="25" colspan="2" class="dtFff pdleft20">
                <?php echo $form->textField($enterpriseData, 'legal_phone', array('class' => 'inputtxt')) ?>
                <?php echo $form->error($enterpriseData, 'legal_phone') ?>
            </td>
        </tr>
        <tr id="licensePlace">
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo Yii::t('memberMember', '营业执照注册地'); ?>
                <span class="required">*</span>：
            </td>
            <td height="25" colspan="2" class="dtFff pdleft20">
                <?php
                echo $form->dropDownList($enterpriseData, 'license_province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                    'prompt' => Yii::t('memberMember', '选择省份'),
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/member/region/updateCity'),
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
                    'prompt' => Yii::t('memberMember', '选择城市'),
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/member/region/updateArea'),
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
                    'prompt' => Yii::t('memberMember', '选择地区'),
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
        <?php $this->renderPartial('_uploadImg', array('model' => $enterpriseData, 'field' => 'license_photo', 'form' => $form)); ?>

        <tr>
            <td height="50" colspan="3" align="center" class="dtffe">
                <b><?php echo Yii::t('memberMember', '开户银行信息'); ?></b>
            </td>
        </tr>
        <tr id="account_name">
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo $form->labelEx($bankAccount, 'account_name') ?>：
            </td>
            <td height="25" colspan="2" class="dtFff pdleft20">
                <?php echo $form->textField($bankAccount, 'account_name', array('class' => 'inputtxt')) ?>
                <?php echo $form->error($bankAccount, 'account_name') ?>
            </td>
        </tr>
        <tr id="account">
            <td width="140" height="25" align="center" class="dtEe">
                <label class="required" for="BankAccount_account">法人银行账号 <span class="required">*</span></label>
            </td>
            <td height="25" colspan="2" class="dtFff pdleft20">
                <?php echo $form->textField($bankAccount, 'account', array('class' => 'inputtxt')) ?>
                <?php echo $form->error($bankAccount, 'account') ?>
            </td>
        </tr>
        <tr id="bank_name">
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo $form->labelEx($bankAccount, 'bank_name') ?>：
            </td>
            <td height="25" colspan="2" class="dtFff pdleft20">
                <?php echo $form->textField($bankAccount, 'bank_name', array('class' => 'inputtxt')) ?>
                <?php echo $form->error($bankAccount, 'bank_name') ?>
            </td>
        </tr>
        <tr id="bankPlace">
            <td height="30" align="center" class="dtEe">
                <?php echo Yii::t('memberEnterpriseLog', '开户银行所在地'); ?>
                <span class="required">*</span>：
            </td>
            <td colspan="2" class="dtFff pdleft20">
                <?php
                echo $form->dropDownList($bankAccount, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                    'prompt' => Yii::t('memberEnterpriseLog', '选择省份'),
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

                <?php
                echo $form->dropDownList($bankAccount, 'city_id', Region::getRegionByParentId($bankAccount->province_id), array(
                    'prompt' => Yii::t('memberEnterpriseLog', '选择城市'),
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

                <?php
                echo $form->dropDownList($bankAccount, 'district_id', Region::getRegionByParentId($bankAccount->city_id), array(
                    'prompt' => Yii::t('memberEnterpriseLog', '选择地区'),
                    'ajax' => array(
                        'type' => 'POST',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
                ?>
                <?php echo $form->error($bankAccount, 'district_id'); ?>
            </td>
        </tr>

        <?php $this->renderPartial('_uploadImg', array('model' => $enterpriseData, 'field' => 'identity_image', 'form' => $form)); ?>
        <?php $this->renderPartial('_uploadImg', array('model' => $enterpriseData, 'field' => 'identity_image2', 'form' => $form)); ?>
        <?php $this->renderPartial('_uploadImg', array('model' => $enterpriseData, 'field' => 'debit_card_image', 'form' => $form)); ?>
        <?php $this->renderPartial('_uploadImg', array('model' => $enterpriseData, 'field' => 'debit_card_image2', 'form' => $form)); ?>

        <tr>
            <td height="50" colspan="3" align="center" class="dtffe">
                <b><?php echo Yii::t('memberMember', '税务登记证'); ?></b>
            </td>
        </tr>

        <?php $this->renderPartial('_uploadImg', array('model' => $enterpriseData, 'field' => 'tax_image', 'form' => $form)); ?>


        <tr>
            <td width="140" height="25" align="center" class="dtEe">
                <?php echo Yii::t('memberHome', '条款') ?>：
            </td>
            <td class="do">
                <?php echo $form->checkBox($enterprise, 'agree'); ?>
                <?php echo Yii::t('memberHome', '同意 ') . CHtml::link(Yii::t('memberHome', '《商城管理规范》'), $this->createUrl('/help/article/enterpriseRules'), array('target' => '_blank')); ?>
                <?php echo $form->error($enterprise, 'agree'); ?>
            </td>
        </tr>


    </tbody>
</table>
<table>
    <tr>
        <td >
            <?php
            echo CHtml::submitButton(Yii::t('memberMember', '保存资料'), array(
                'class' => 'enterPriseBtn',
                'style' => 'cursor:pointer;margin:10px 0 0 400px',
                'id' => 'formSubmit'))
            ?>
        </td>

    </tr>
</table>


<?php $this->endWidget(); ?>

<script type="text/javascript">
    var category = {
        appliances:<?php echo Category::TOP_APPLIANCES ?>,
        cosmetics:<?php echo Category::TOP_COSMETICS ?>,
        food:<?php echo Category::TOP_FOOD ?>,
        jewelry:<?php echo Category::TOP_JEWELRY ?>,
        url: "<?php echo Yii::app()->createAbsoluteUrl('/member/enterpriseLog/enterprise') ?>",
        showUpload: function(c) {
            $("#threec_image").hide();
            $("#cosmetics_image").hide();
            $("#food_image").hide();
            $("#jewelry_image").hide();
            switch (c) {
                case category.appliances:
                    if ($("#threec_image").show().length == 0)
                        window.location.href = category.url;
                    break;
                case category.cosmetics:
                    if ($("#cosmetics_image").show().length == 0)
                        window.location.href = category.url;
                    break;
                case category.food:
                    if ($("#food_image").show().length == 0)
                        window.location.href = category.url;
                    break;
                case category.jewelry:
                    if ($("#jewelry_image").show().length == 0)
                        window.location.href = category.url;
                    break;
                default :
                    break;
            }
        }
    };
    var checkCategory = $("#Store_category_id input:checked");
    if (checkCategory.length !== 0) {
        var c = parseInt(checkCategory.val());
        category.showUpload(c);
    }
    //类目选择，不同类目需要上传不同的证书
    $("#Store_category_id .checkboxItem").click(function() {
        var c = parseInt(this.value);
        category.showUpload(c);
    });
    //是否有进口商品
    $("#EnterpriseData_exists_imported_goods input:last").click(function() {
        $("#declaration_image").show();
        $("#report_image").show();
    });
    $("#EnterpriseData_exists_imported_goods input:first").click(function() {
        $("#declaration_image").hide();
        $("#report_image").hide();
    });
    if ($("#EnterpriseData_exists_imported_goods input:last").get(0).checked) {
        $("#declaration_image").show();
        $("#report_image").show();
    }
    var notice = {
        feeNoticeTitle: "收费版服务说明",
        feeNoticeContent: "<dl><dt><strong>2.5万收费版（全托管服务）</strong></dt>" +
                "<dd>1、拥有商城店铺一间，经营权1年（价值2.5万）；</dd>" +
                "<dd>2、拥有商城首页广告位一个（两个月），由商城分配（价值5万）；</dd>" +
                "<dd>3、为商家上传图片，打理店铺（价值1万）；</dd>" +
                "<dd>4、合同期内优先，不限次参加商城的专题活动；</dd>" +
                "<dd>5、可优先享受商城推出的增值扶持；</dd>" +
                "<dd>6、发布产品数量不限。</dd>" +
                "</dl>",
        freeNoticeTitle: "免费版服务说明",
        freeNoticeContent: "<dl><dt><strong>免费版 （商家自营）</strong></dt>" +
                "<dd>1、拥有商城店铺一间，经营权1年（价值2.5万）；</dd>" +
                "<dd>2、无店铺装修；</dd>" +
                "<dd>3、商家自已上传图片，打理店铺；</dd>" +
                "<dd>4、商家1年内有5次免费的机会参加商城的专题活动；</dd>" +
                "<dd>5、可发布500款产品；</dd>" +
                "<dd>6、可有偿使用广告位，竞价排位，商品推广等。</dd></dl>"
    };
    //收费说明
    $("#feeNotice").click(function() {
        art.dialog({
            title: notice.feeNoticeTitle,
            content: notice.feeNoticeContent,
            lock: true,
            time: 10,
            top: '10%'
        });
        return false;
    });
    //免费提醒
    $("#freeNotice").click(function() {
        art.dialog({
            title: notice.freeNoticeTitle,
            content: notice.freeNoticeContent,
            lock: true,
            time: 5,
            top: '10%'
        });
        return false;
    });

<?php if ($store->isNewRecord): ?>
        $("#Store_street").live('change', function() {
            $("#Enterprise_street").val($(this).val());
        });
<?php endif; ?>


</script>
