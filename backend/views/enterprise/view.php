<?php

/* @var $this EnterpriseController */
/* @var $model Enterprise */
/** @var $enterpriseData EnterpriseData */
$this->breadcrumbs = array(Yii::t('enterprise', '网签审核') => array('admin'), Yii::t('enterprise', '查看详情'));
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

<div class="sellerWebSign sellerWebSignIcon">
    温馨提示：标红的项目表示不通过的项目
    <h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '商户类型'); ?></h3>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
        <tr>
            <th><?php echo Yii::t('enterprise', '类型：'); ?><?php echo Enterprise::getEnterpriseType($model->enterprise_type); ?></th>
        </tr>
        <tr>
            <th><?php echo Yii::t('enterprise', '推荐人会员号：'); ?><?php echo Enterprise::getReferrals($model->member->referrals_id); ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>
    <div class="c10"></div>
    <h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '网络店铺信息'); ?></h3>

    <div class="c10"></div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
        <tbody>
        <tr id="storeName">
            <th><?php echo Yii::t('enterprise', '店铺名称：'); ?><?php echo $store->name; ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr id="storeMobile">
            <th><?php echo Yii::t('enterprise', '手机号码：'); ?><?php echo $store->mobile; ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr id="storePlace">
            <th><?php echo Yii::t('enterprise', '店铺所在地：'); ?><?php echo Region::getName($store->province_id, $store->city_id, $store->district_id); ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr id="storeAddress">
            <th><?php echo Yii::t('enterprise', '详细地址：'); ?><?php echo $store->street; ?></th>
        </tr>
        </tbody>
    </table>

    <h3 class="mt15 tableTitle">
        <?php if($model->enterprise_type==Enterprise::TYPE_ENTERPRISE){
            echo Yii::t('enterprise', '公司及联系人信息');
        }else{
            echo Yii::t('enterprise', '个体户信息');
        } ?>
    </h3>
    <div class="c10"></div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
        <tbody>
        <tr id="enterpriseName">
            <th><?php echo Yii::t('enterprise', '公司名称：'); ?><?php echo $model->name; ?></th>

        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr id="link_phone">
            <th><?php echo Yii::t('enterprise', '固话：'); ?><?php echo $model->link_phone; ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr id="link_man">
            <th><?php echo Yii::t('enterprise', '固话：'); ?><?php echo $model->link_man; ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr id="enterprisePlace">
            <th><?php echo Yii::t('enterprise', '公司注册地：'); ?><?php echo Region::getName($model->province_id, $model->city_id, $model->district_id); ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr id="enterpriseAddress">
            <th><?php echo Yii::t('enterprise', '详细地址：'); ?><?php echo $model->street; ?></th>
        </tr>
        </tbody>
    </table>

    <h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '营业执照信息（副本）'); ?></h3>

    <div class="c10"></div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
        <tbody>
        <tr id="license">
            <th><?php echo Yii::t('enterprise', '营业执照号：'); ?><?php echo $enterpriseData->license; ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr id="legal_man">
            <th><?php echo Yii::t('enterprise', '法人代表：'); ?><?php echo $enterpriseData->legal_man; ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr id="legal_phone">
            <th><?php echo Yii::t('enterprise', '法人代表联系电话：'); ?><?php echo $enterpriseData->legal_phone; ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr id="licensePlace" >
            <th><?php echo Yii::t('enterprise', '营业执照注册地：'); ?><?php echo Region::getName($enterpriseData->license_province_id, $enterpriseData->license_city_id, $enterpriseData->license_district_id); ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr id="licenseTime">
            <th><?php echo Yii::t('enterprise', '营业执照有效期：'); ?><?php echo date('Y-m-d', $enterpriseData->license_start_time); ?>
                - <?php echo date('Y-m-d', $enterpriseData->license_end_time); ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>

        <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'license_photo')) ?>
        </tbody>
    </table>
    <?php if($model->enterprise_type==Enterprise::TYPE_ENTERPRISE): ?>
    <h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '组织机构代码证'); ?></h3>
    <div class="c10"></div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
        <tbody>
        <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'organization_image')) ?>
        </tbody>
    </table>
    <?php endif; ?>

    <h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '开户银行许可证'); ?></h3>

    <div class="c10"></div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
        <tbody>
        <tr id="account_name">
            <th><?php echo Yii::t('enterprise', '银行开户名：'); ?><?php echo $bankAccount->account_name; ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr id="account">
            <th><?php echo Yii::t('enterprise', '公司银行账号：'); ?><?php echo $bankAccount->account; ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr id="bank_name">
            <th><?php echo Yii::t('enterprise', '开户银行支行名称：'); ?><?php echo $bankAccount->bank_name; ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>

        <tr id="bankPlace">
            <th><?php echo Yii::t('enterprise', '开户银行所在地：'); ?><?php echo Region::getName($bankAccount->province_id, $bankAccount->city_id, $bankAccount->district_id); ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
        <?php if($model->enterprise_type==Enterprise::TYPE_ENTERPRISE): ?>
        <?php echo $this->renderPartial('_img',array('model'=>$bankAccount,'field'=>'licence_image')) ?>
        <?php endif; ?>
        <?php if($model->enterprise_type==Enterprise::TYPE_INDIVIDUAL): ?>
            <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'identity_image')) ?>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'identity_image2')) ?>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'debit_card_image')) ?>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'debit_card_image2')) ?>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
        <?php endif; ?>

        </tbody>
    </table>

    <h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '税务登记证'); ?></h3>

    <div class="c10"></div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
        <tbody>
        <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'tax_image')) ?>
        </tbody>
    </table>

    <h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '经营类目信息'); ?></h3>

    <div class="c10"></div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
        <tbody>
        <tr id="category_id">
            <th><?php echo Yii::t('enterprise', '经营类目：'); ?><?php echo $cat->name; ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
    <?php if($store->category_id==Category::TOP_APPLIANCES): ?>
        <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'threec_image')) ?>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
    <?php endif; ?>
        <?php if($store->category_id==Category::TOP_COSMETICS): ?>
            <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'cosmetics_image')) ?>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
        <?php endif; ?>
        <?php if($store->category_id==Category::TOP_FOOD): ?>
            <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'food_image')) ?>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
        <?php endif; ?>
        <?php if($store->category_id==Category::TOP_JEWELRY): ?>
            <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'jewelry_image')) ?>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
        <?php endif; ?>
        <tr class="">
            <th><?php echo $enterpriseData->getAttributeLabel('exists_imported_goods'),'：',EnterpriseData::existsImportedGoods($enterpriseData->exists_imported_goods) ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
        <?php if($enterpriseData->exists_imported_goods==EnterpriseData::EXISTS_IMPORTED_GOODS_YES): ?>
            <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'declaration_image')) ?>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
            <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'report_image')) ?>
            <tr class="blank">
                <td colspan="2">&nbsp;</td>
            </tr>
        <?php endif; ?>
        <?php if($enterpriseData->brand_image): ?>
            <?php echo $this->renderPartial('_img',array('model'=>$enterpriseData,'field'=>'brand_image')) ?>
        <?php endif; ?>
        </tbody>
    </table>


    <h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '开店模式'); ?></h3>

    <div class="c10"></div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
        <tbody>
        <tr class="">
            <th><?php echo Yii::t('enterprise', '开店模式：'); ?><?php echo Store::getMode($store->mode); ?></th>
        </tr>
        <tr class="blank">
            <td colspan="2">&nbsp;</td>
        </tr>
        </tbody>
    </table>
    <div class="c10"></div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
        <tbody>
        <tr>
            <th>
                <?php if($log->status == EnterpriseLog::STATUS_NO):?>
                    审核结果：<span class="red">正在审核中，请耐心<?php echo $log->content?></span>
                <?php elseif($log->status == EnterpriseLog::STATUS_NOT_PASS):?>
                    <!--审核结果：<span class="red"><?php //echo EnterpriseLog::getStatus(EnterpriseLog::STATUS_NOT_PASS)?></span><br>-->  
                    <span class="red"><b>审核结果：<?php echo $log->content?></b></span>
                <?php endif;?>
            </th>
        </tr>

        </tbody>
    </table>

</div>
<script>
    var errorField = "<?php echo $log->error_field; ?>";
    if($.trim(errorField).length>0){
        errorField = errorField.split(',');

        for(var i=0;i<errorField.length;i++){
            $("#"+errorField[i]).children().attr('style','background:lightpink !important;');
        }
    }
</script>