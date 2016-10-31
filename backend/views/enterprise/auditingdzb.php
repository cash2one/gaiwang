<?php

/* @var $this EnterpriseController */
/* @var $model Enterprise */
/** @var  $enterpriseData EnterpriseData */
$enterpriseData = $model->enterpriseData;
$this->breadcrumbs = array(Yii::t('enterprise', '网签审核') => array('admin'), Yii::t('enterprise', '列表'));
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->clientScript;
//显示原图的JS插件
$cs->registerCssFile($baseUrl . "/js/swf/js/fancybox/jquery.fancybox-1.3.4.css");
$cs->registerScriptFile($baseUrl . "/js/swf/js/fancybox/jquery.fancybox-1.3.4.pack.js", CClientScript::POS_END);
$tips = Yii::t('enterprise', '(上传图片需确保清晰，文字可辨并有清晰的红色公章。)');
?>
<script>
    $(function () {
        $(".pic").fancybox();
        $(".pic img").css('display', 'inline');
    });
</script>
<link rel="stylesheet" type="text/css" href="/css/jqtransform.css">
<script type="text/javascript" src="/js/jquery.jqtransform.js"></script>


<div class="sellerWebSign sellerWebSignIcon">
    <div class="toolbarSign">
        <h3><?php echo Yii::t('enterprise', '温馨提示：'); ?><span
                class="red"><?php echo Yii::t('enterprise', '1、若以下信息有误，请勾选有误项目，并概要说明不通过审核的原因；2、审核时请为商家选择开店模式。'); ?></span></h3>
    </div>
    <?php $form_url = $role == Enterprise::AUDITING_ROLE_ZHAOSHANG ? $this->createAbsoluteUrl('enterprise/auditingDzbZhaoshang', array('id' => $model->id)) : $this->createAbsoluteUrl('enterprise/auditingDzbFawu', array('id' => $model->id)); ?>
    <form id="auditing_form" action="<?php echo $form_url; ?>" method="post">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
            <tr>
                <th><?php echo Yii::t('enterprise', '网店商户类型：'); ?><?php echo Enterprise::getEnterpriseType($model->enterprise_type); ?></th>
                <td class="ta-r jqtransform"></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('enterprise','招商人员服务编号') ?>:<?php echo $model->service_id ?></th>
                <td class="" ></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('enterprise','推荐人会员号') ?>:<?php isset($model->member->referrals->gai_number) && print($model->member->referrals->gai_number)  ?></th>
                <td class="ta-l jqtransform" ></td>
            </tr>
        </table>


        <h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '经营类目信息'); ?></h3>

        <div class="c10"></div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
            <tbody>
            <tr class="">
                <th><?php echo Yii::t('enterprise', '经营类目：'); ?><?php echo $cat->name; ?></th>
                <td class="ta-r jqtransform">
                    <?php echo CHtml::checkBox('errors[]',false,array('value'=>Yii::t('enterprise', '经营类目'),'data-field'=>'category_id')) ?>
                </td>
            </tr>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <?php if ($store->category_id == Category::TOP_APPLIANCES): ?>
                <tr class="">
                    <?php echo $this->renderPartial('_img', array('model' => $enterpriseData, 'field' => 'threec_image', 'tr' => '1')) ?>
                    <td class="ta-r jqtransform">
                        <?php echo CHtml::checkBox('errors[]', false, array('value' => $enterpriseData->getAttributeLabel('threec_image'),'data-field'=>'threec_image')) ?>
                    </td>
                </tr>
                <tr class="blank">
                    <td colspan="2">&nbsp;</td>
                </tr>
            <?php endif; ?>
            <?php if ($store->category_id == Category::TOP_COSMETICS): ?>
                <tr class="">
                    <?php echo $this->renderPartial('_img', array('model' => $enterpriseData, 'field' => 'cosmetics_image', 'tr' => '1')) ?>
                    <td class="ta-r jqtransform">
                        <?php echo CHtml::checkBox('errors[]', false, array('value' => $enterpriseData->getAttributeLabel('cosmetics_image'),'data-field'=>'cosmetics_image')) ?>
                    </td>
                </tr>
                <tr class="blank">
                    <td colspan="2">&nbsp;</td>
                </tr>
            <?php endif; ?>
            <?php if ($store->category_id == Category::TOP_FOOD): ?>
                <tr class="">
                    <?php echo $this->renderPartial('_img', array('model' => $enterpriseData, 'field' => 'food_image', 'tr' => '1')) ?>
                    <td class="ta-r jqtransform">
                        <?php echo CHtml::checkBox('errors[]', false, array('value' => $enterpriseData->getAttributeLabel('food_image'),'data-field'=>'food_image')) ?>
                    </td>
                </tr>
                <tr class="blank">
                    <td colspan="2">&nbsp;</td>
                </tr>
            <?php endif; ?>
            <?php if ($store->category_id == Category::TOP_JEWELRY): ?>
                <tr class="">
                    <?php echo $this->renderPartial('_img', array('model' => $enterpriseData, 'field' => 'jewelry_image', 'tr' => '1')) ?>
                    <td class="ta-r jqtransform">
                        <?php echo CHtml::checkBox('errors[]', false, array('value' => $enterpriseData->getAttributeLabel('jewelry_image'),'data-field'=>'jewelry_image')) ?>
                    </td>
                </tr>
                <tr class="blank">
                    <td colspan="2">&nbsp;</td>
                </tr>
            <?php endif; ?>
            <tr class="">
                <th><?php echo $enterpriseData->getAttributeLabel('exists_imported_goods'), '：', EnterpriseData::existsImportedGoods($enterpriseData->exists_imported_goods) ?></th>
            </tr>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <?php if ($enterpriseData->exists_imported_goods == EnterpriseData::EXISTS_IMPORTED_GOODS_YES): ?>
                <tr class="">
                    <?php echo $this->renderPartial('_img', array('model' => $enterpriseData, 'field' => 'declaration_image', 'tr' => '1')) ?>
                    <td class="ta-r jqtransform">
                        <?php echo CHtml::checkBox('errors[]', false, array('value' => $enterpriseData->getAttributeLabel('declaration_image'),'data-field'=>'declaration_image')) ?>
                    </td>
                </tr>
                <tr class="blank">
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <?php echo $this->renderPartial('_img', array('model' => $enterpriseData, 'field' => 'report_image', 'tr' => '1')) ?>
                    <td class="ta-r jqtransform">
                        <?php echo CHtml::checkBox('errors[]', false, array('value' => $enterpriseData->getAttributeLabel('report_image'),'data-field'=>'report_image')) ?>
                    </td>
                </tr>
                <tr class="blank">
                    <td colspan="2">&nbsp;</td>
                </tr>
            <?php endif; ?>
            <?php if($enterpriseData->brand_image): ?>
                <tr class="">
                    <?php echo $this->renderPartial('_img', array('model' => $enterpriseData, 'field' => 'brand_image', 'tr' => '1')) ?>
                    <td class="ta-r jqtransform">
                        <?php echo CHtml::checkBox('errors[]', false, array('value' => $enterpriseData->getAttributeLabel('brand_image'),'data-field'=>'brand_image')) ?>
                    </td>
                </tr>
                <tr class="blank">
                    <td colspan="2">&nbsp;</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>


        <h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '开店模式'); ?></h3>

        <div class="c10"></div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
            <tbody>
            <tr class="">
                <th>
                    <?php echo Yii::t('enterprise', '开店模式：');
                    if(Enterprise::AUDITING_ROLE_FAWU==$role){
                        echo Store::getMode($store->mode);
                    }else{
                        $mode = Store::getMode();
                        array_pop($mode);
                        echo CHtml::radioButtonList('StoreMode',$store->mode,$mode,array('separator'=>' '));
                    }
                    ?>
                </th>
                <td class="ta-r jqtransform">

                </td>
            </tr>
            </tbody>
        </table>

        <h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '网络店铺信息'); ?></h3>

        <div class="c10"></div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
            <tbody>
            <tr>
                <th><?php echo Yii::t('enterprise', '店铺名称：'); ?><?php echo $store->name; ?></th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '店铺名称'); ?>" type="checkbox" data-field="storeName"/>
                </td>

            </tr>
            <tr>
                <th><?php echo Yii::t('enterprise', '手机号码：'); ?><?php echo $store->mobile; ?></th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '店铺手机号码'); ?>" type="checkbox" data-field="storeMobile"/>
                </td>

            </tr>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <th><?php echo Yii::t('enterprise', '店铺所在地：'); ?>
                    <?php echo Region::getName($store->province_id, $store->city_id, $store->district_id); ?>
                </th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '公司注册地'); ?>" type="checkbox" data-field="storePlace"/>
                </td>
            </tr>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <th><?php echo Yii::t('enterprise', '详细地址：'); ?><?php echo $store->street; ?></th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '详细地址'); ?>" type="checkbox" data-field="storeAddress"/>
                </td>
            </tr>
            </tbody>
        </table>


        <h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '公司及联系人信息'); ?></h3>

        <div class="c10"></div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
            <tbody>
            <tr>
                <th><?php echo Yii::t('enterprise', '公司名称：'); ?><?php echo $model->name; ?></th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '公司名称'); ?>" type="checkbox" data-field="enterpriseName"/>
                </td>

            </tr>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <th><?php echo Yii::t('enterprise', '固话：'); ?><?php echo $model->link_phone; ?></th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '固话'); ?>" type="checkbox" data-field="link_phone"/>
                </td>
            </tr>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <th><?php echo Yii::t('enterprise', '联系人：'); ?><?php echo $model->link_man; ?></th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '联系人'); ?>" type="checkbox" data-field="link_man"/>
                </td>
            </tr>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <th><?php echo Yii::t('enterprise', '公司注册地：'); ?>
                    <?php echo Region::getName($model->province_id, $model->city_id, $model->district_id); ?>
                </th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '公司注册地'); ?>" type="checkbox" data-field="enterprisePlace"/>
                </td>
            </tr>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <th><?php echo Yii::t('enterprise', '详细地址：'); ?><?php echo $model->street; ?></th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '详细地址'); ?>" type="checkbox" data-field="enterpriseAddress"/>
                </td>
            </tr>
            </tbody>
        </table>

        <h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '营业执照信息（副本）'); ?></h3>

        <div class="c10"></div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
            <tbody>
            <tr class="">
                <th><?php echo Yii::t('enterprise', '营业执照号：'); ?><?php echo $enterpriseData->license; ?></th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '营业执照号'); ?>" type="checkbox" data-field="license"/>
                </td>
            </tr>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr class="">
                <th><?php echo Yii::t('enterprise', '法人代表：'); ?><?php echo $enterpriseData->legal_man; ?></th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '法人代表'); ?>" type="checkbox" data-field="legal_man"/>
                </td>
            </tr>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr class="">
                <th><?php echo Yii::t('enterprise', '法人代表联系电话：'); ?><?php echo $enterpriseData->legal_phone; ?></th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '法人代表联系电话'); ?>" type="checkbox" data-field="legal_phone"/>
                </td>
            </tr>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <th><?php echo Yii::t('enterprise', '营业执照注册地：'); ?>
                    <?php echo Region::getName($enterpriseData->license_province_id, $enterpriseData->license_city_id, $enterpriseData->license_district_id); ?>
                </th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '营业执照注册地'); ?>" type="checkbox" data-field="licensePlace"/>
                </td>
            </tr>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <th><?php echo Yii::t('enterprise', '营业执照有效期：'); ?><?php echo date('Y-m-d', $enterpriseData->license_start_time); ?>
                    - <?php echo date('Y-m-d', $enterpriseData->license_end_time); ?></th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '营业执照有效期'); ?>" type="checkbox" data-field="licenseTime"/>
                </td>
            </tr>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <?php echo $this->renderPartial('_img', array('model' => $enterpriseData, 'field' => 'license_photo', 'tr' => '')) ?>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '营业执照号电子版'); ?>" type="checkbox" data-field="license_photo"/>
                </td>
            </tr>
            </tbody>
        </table>
        <?php if ($model->enterprise_type == Enterprise::TYPE_ENTERPRISE): ?>
            <h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '组织机构代码证'); ?></h3>

            <div class="c10"></div>
            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
                <tbody>
                <tr>
                    <?php echo $this->renderPartial('_img', array('model' => $enterpriseData, 'field' => 'organization_image', 'tr' => '')) ?>
                    <td class="ta-r jqtransform">
                        <input name="errors[]" value="<?php echo Yii::t('enterprise', '组织机构代码证电子版'); ?>" type="checkbox" data-field="organization_image"/>
                    </td>
                </tr>
                </tbody>
            </table>
        <?php endif; ?>

        <h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '开户银行信息'); ?></h3>

        <div class="c10"></div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
            <tbody>
            <tr class="">
                <th><?php echo Yii::t('enterprise', '银行开户名：'); ?><?php echo $bankAccount->account_name; ?></th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '银行开户名'); ?>" type="checkbox" data-field="account_name"/>
                </td>
            </tr>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr class="">
                <th><?php echo Yii::t('enterprise', '公司银行账号：'); ?><?php echo $bankAccount->account; ?></th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '公司银行账号'); ?>" type="checkbox" data-field="account"/>
                </td>
            </tr>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr class="">
                <th><?php echo Yii::t('enterprise', '开户银行支行名称：'); ?><?php echo $bankAccount->bank_name; ?></th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '开户银行支行名称'); ?>" type="checkbox" data-field="bank_name"/>
                </td>
            </tr>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>

            <tr class="">
                <th><?php echo Yii::t('enterprise', '开户银行所在地：'); ?><?php echo Region::getName($bankAccount->province_id, $bankAccount->city_id, $bankAccount->district_id); ?></th>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '开户银行所在地'); ?>" type="checkbox" data-field="bankPlace"/>
                </td>
            </tr>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <?php if ($model->enterprise_type == Enterprise::TYPE_ENTERPRISE): ?>
            <tr>
                <?php echo $this->renderPartial('_img', array('model' => $bankAccount, 'field' => 'licence_image', 'tr' => '')) ?>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '开户银行许可证电子版'); ?>" type="checkbox" data-field="bankImage"/>
                </td>
            </tr>
            <?php endif; ?>
            <?php if ($model->enterprise_type == Enterprise::TYPE_INDIVIDUAL): ?>
                <tr class="">
                    <?php echo $this->renderPartial('_img', array('model' => $enterpriseData, 'field' => 'identity_image', 'tr' => '')) ?>
                    <td class="ta-r jqtransform">
                        <?php echo CHtml::checkBox('errors[]', false, array('value' => $enterpriseData->getAttributeLabel('identity_image'),'data-field'=>'identity_image')) ?>
                    </td>
                </tr>
                <tr class="blank">
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr class="">
                    <?php echo $this->renderPartial('_img', array('model' => $enterpriseData, 'field' => 'identity_image2', 'tr' => '')) ?>
                    <td class="ta-r jqtransform">
                        <?php echo CHtml::checkBox('errors[]', false, array('value' => $enterpriseData->getAttributeLabel('identity_image2'),'data-field'=>'identity_image2')) ?>
                    </td>
                </tr>
                <tr class="blank">
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr class="">
                    <?php echo $this->renderPartial('_img', array('model' => $enterpriseData, 'field' => 'debit_card_image', 'tr' => '')) ?>
                    <td class="ta-r jqtransform">
                        <?php echo CHtml::checkBox('errors[]', false, array('value' => $enterpriseData->getAttributeLabel('debit_card_image'),'data-field'=>'debit_card_image')) ?>
                    </td>
                </tr>
                <tr class="blank">
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr class="">
                    <?php echo $this->renderPartial('_img', array('model' => $enterpriseData, 'field' => 'debit_card_image2', 'tr' => '')) ?>
                    <td class="ta-r jqtransform">
                        <?php echo CHtml::checkBox('errors[]', false, array('value' => $enterpriseData->getAttributeLabel('debit_card_image2'),'data-field'=>'debit_card_image2')) ?>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '税务登记证'); ?></h3>

        <div class="c10"></div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
            <tbody>
            <tr>
                <?php echo $this->renderPartial('_img', array('model' => $enterpriseData, 'field' => 'tax_image', 'tr' => '')) ?>
                <td class="ta-r jqtransform">
                    <input name="errors[]" value="<?php echo Yii::t('enterprise', '税务登记证电子版'); ?>" type="checkbox" data-field="tax_image"/>
                </td>
            </tr>
            </tbody>
        </table>



        <h3 class="mt15 tableTitle">&nbsp;</h3>

        <div class="c10"></div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
            <tbody>
            <tr>
                <th><?php echo Yii::t('enterprise', '未通过审核原因'); ?>
                    <span class="red">(<?php echo Yii::t('enterprise', '选择不通过审核时必填'); ?>)：</span></th>
            </tr>
            <tr>
                <td>
                    <textarea name="content" id="content" class="textareatxt"></textarea>
                </td>
            </tr>

            </tbody>
        </table>


        <div class="mt15 profileDo">
            <input type="hidden" name="status" id="status" value="<?php echo EnterpriseLog::STATUS_NOT_PASS; ?>"/>
            <input type="hidden" name="errorField" id="errorField" value=""/>

            <input type="button" value="<?php echo Yii::t('enterprise', '通过审核'); ?>" id="btnSignSubmit"
                   class="btnSignSubmit"/>&nbsp;&nbsp;
            <input type="button" value="<?php echo Yii::t('enterprise', '不通过审核'); ?>" id="btnSignBack"
                   class="btnSignBack"/>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(function () {
        $('.jqtransform').jqTransform();

        $("input[name='errors[]']").change(function () {

            var word = '<?php echo Yii::t('enterprise', '不通过原因：提交的资料有误。有如下地方需要修改：');?>';
            var field = [];
            var count = 0;

            $("input[name='errors[]']").each(function () {
                if ($(this).attr('checked') == 'checked') {
                    count++;
                    field.push($(this).val());
                }
            });

            if (count > 0) {
                $("#content").html(word+field.join('、'));
                $("#btnSignSubmit").attr('style','background:#ccc !important');
            } else {
                $("#content").html('');
                $("#btnSignSubmit").attr('style','background:#e73232 !important');
            }

        });

        $("#btnSignSubmit").click(function () {
            if($("input[name='errors[]']:checked").length>0){
                return false;
            }
            <?php if($role==Enterprise::AUDITING_ROLE_ZHAOSHANG): ?>
            if($("#StoreMode input:checked").length==0){
                alert("请选择开店模式");
                $("#StoreMode_0").focus();
                return false;
            }
            <?php endif; ?>
            $("#status").val("<?php echo EnterpriseLog::STATUS_PASS; ?>");
            $("errorField").val('');
            $("#auditing_form").submit();
        });


        $("#btnSignBack").click(function () {
            $("#status").val("<?php echo EnterpriseLog::STATUS_NOT_PASS; ?>");
            <?php if($role==Enterprise::AUDITING_ROLE_ZHAOSHANG): ?>
            if($("#StoreMode input:checked").length==0){
                alert("请选择开店模式");
                $("#StoreMode_0").focus();
                return false;
            }
            <?php endif; ?>
            if ($("#content").val() == '') {
                alert("请填写未通过审核原因！");
                return false;
            } else {
                var a = [];
                $("input[name='errors[]']:checked").each(function(){
                    a.push($(this).attr('data-field'));
                });
                if(a.length>0){
                    $("#errorField").val(a.join(','));
                }
                $("#auditing_form").submit();
            }

            return false;
        });


    });


</script>