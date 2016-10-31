<script src="<?php echo DOMAIN; ?>/js/artDialog/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<?php
//网签
/* @var $this  HomeController */
/** @var $model Member */
/** @var $enterprise Enterprise */
/** @var $form CActiveForm */
/** @var EnterpriseData $enterpriseData */
$enterpriseData = $enterprise->enterpriseData;
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->clientScript;
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>
       <?php echo Yii::t('memberEnterpriseLog', '我的网络店铺签约资质')?>
    </title>
	<link rel="stylesheet" href="<?php echo $this->theme->baseUrl.'/'; ?>styles/global_v20.css"/>
    <link rel="stylesheet" href="<?php echo $this->theme->baseUrl.'/'; ?>styles/member_v20.css"/>
    <style>
        .mbRcontent{
            margin: 0 auto !important;
        }
    </style>
</head>
<body>
    <div class="mbRcontent">
        <div class="mbDate1">
            <div class="mbDate1_c">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'member-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
				<div class="clearfix">
                <ul style="width:230px; border:1px solid #ccc; float:right; margin:50px 46px 0 0; padding:10px;<?php if(!$enterprise->service_id && !isset($this->model->referrals->gai_number)) echo ';display:none;' ?>">
                    <?php if ($enterprise->service_id): ?>
                        <li>
           <?php echo Yii::t('memberEnterpriseLog', '招商人员服务编号')?>：<?php echo $enterprise->service_id ?>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($this->model->referrals->gai_number)): ?>
                        <li>
          <?php echo Yii::t('memberEnterpriseLog', '商铺推荐号')?>：<?php echo $this->model->referrals->gai_number ?>
                        </li>
                    <?php endif; ?>
                </ul>
				</div>
				<h3 style="line-height:30px; text-align:center;"><?php echo Yii::t('memberEnterpriseLog', '我的网络店铺签约资质')?>我的网络店铺签约资质</h3>
                <table width="890" border="0" cellpadding="0" cellspacing="0" class="tableBank updateBase">
                    
                    <tbody>
                    <tr style="height:100px;">
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($enterprise, 'enterprise_type') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo Enterprise::getEnterpriseType($enterprise->enterprise_type); ?>
                        </td>
                    </tr>
                    <tr>
                        <td height="50" colspan="3" align="center" class="dtffe">
                            <b><?php echo Yii::t('memberEnterpriseLog', '经营类目信息'); ?></b>
                        </td>
                    </tr>

                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($store, 'category_id') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20 hobbies" style="line-height: 30px;">
                            <?php echo $cat->name;?>
                        </td>
                    </tr>
                    <?php if($enterpriseData->cosmetics_image): ?>
                        <tr>
                            <td width="140" height="25" align="center" class="dtEe">
                                <?php echo $form->label($enterpriseData, 'cosmetics_image') ?>
                            </td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                                <img src="<?php echo ATTR_DOMAIN . '/' . $enterpriseData->cosmetics_image ?>" id="bank_photo"
                                     width="300px"/>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if($enterpriseData->food_image): ?>
                        <tr>
                            <td width="140" height="25" align="center" class="dtEe">
                                <?php echo $form->label($enterpriseData, 'food_image') ?>
                            </td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                                <img src="<?php echo ATTR_DOMAIN . '/' . $enterpriseData->food_image ?>" id="bank_photo"
                                     width="300px"/>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php if($enterpriseData->jewelry_image): ?>
                        <tr>
                            <td width="140" height="25" align="center" class="dtEe">
                                <?php echo $form->label($enterpriseData, 'jewelry_image') ?>
                            </td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                                <img src="<?php echo ATTR_DOMAIN . '/' . $enterpriseData->jewelry_image ?>" id="bank_photo"
                                     width="300px"/>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php if($enterpriseData->threec_image): ?>
                        <tr>
                            <td width="140" height="25" align="center" class="dtEe">
                                <?php echo $form->label($enterpriseData, 'threec_image') ?>
                            </td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                                <img src="<?php echo ATTR_DOMAIN . '/' . $enterpriseData->threec_image ?>" id="bank_photo"
                                     width="300px"/>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php if($enterpriseData->exists_imported_goods): ?>
                        <tr>
                            <td width="140" height="25" align="center" class="dtEe">
                                <?php echo $form->label($enterpriseData, 'declaration_image') ?>
                            </td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                                <img src="<?php echo ATTR_DOMAIN . '/' . $enterpriseData->declaration_image ?>" id="bank_photo"
                                     width="300px"/>
                            </td>
                        </tr>
                        <tr>
                            <td width="140" height="25" align="center" class="dtEe">
                                <?php echo $form->label($enterpriseData, 'report_image') ?>
                            </td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                                <img src="<?php echo ATTR_DOMAIN . '/' . $enterpriseData->report_image ?>" id="bank_photo"
                                     width="300px"/>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td height="50" colspan="3" align="center" class="dtffe">
                            <b><?php echo Yii::t('memberEnterpriseLog', '开店模式'); ?></b>
                        </td>
                    </tr>

                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($store, 'mode') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20 hobbies">
                            <?php
                            if($store->mode==Store::MODE_NOT){
                                echo Yii::t('memberEnterpriseLog', '请等待商城安排专人与您沟通');
                            }else{
                                echo Store::getMode($store->mode);
                            }
                            ?>
                            <?php
//                                if($store->mode==Store::MODE_CHARGE){
//                                    echo CHtml::link(Yii::t('memberEnterpriseLog','收费版说明'),'#',array('id'=>'feeNotice','class'=>'red'));
//                                }else{
//                                    echo CHtml::link(Yii::t('memberEnterpriseLog','免费版说明'),'#',array('id'=>'freeNotice','class'=>'red'));
//                                }
                             ?>
                        </td>
                    </tr>

                    <tr>
                        <td height="50" colspan="3" align="center" class="dtffe">
                            <b><?php echo Yii::t('memberEnterpriseLog', '店铺信息'); ?></b>
                        </td>
                    </tr>

                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($store, 'name') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo $store->name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($store, 'mobile') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo $store->mobile; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($store, 'email') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo $store->email; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo Yii::t('memberEnterpriseLog', '店铺所在地'); ?>
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo Region::getName($store->province_id, $store->city_id, $store->district_id); ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($store, 'street') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo $store->street; ?>
                        </td>
                    </tr>


                    <tr>
                        <td height="50" colspan="3" align="center" class="dtffe">
                            <b><?php echo Yii::t('memberEnterpriseLog', '公司信息'); ?></b>
                        </td>
                    </tr>

                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($enterprise, 'name') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo $enterprise->name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($enterprise, 'link_phone') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo $enterprise->link_phone; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($enterprise, 'link_man') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo $enterprise->link_man; ?>
                        </td>
                    </tr>


                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo Yii::t('memberEnterpriseLog', '公司所在地'); ?>：
                        </td>

                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo Region::getName($enterprise->province_id, $enterprise->city_id, $enterprise->district_id); ?>

                        </td>
                    </tr>

                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($enterprise, 'street'); ?>：
                        </td>
                        <td class="dtFff pdleft20">
                            <?php echo $enterprise->street; ?>
                        </td>
                    </tr>


                    <tr>
                        <td height="50" colspan="3" align="center" class="dtffe">
                            <b><?php echo Yii::t('memberEnterpriseLog', '营业执照信息（副本）'); ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($enterpriseData, 'license') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo $enterpriseData->license; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($enterpriseData, 'legal_man') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo $enterpriseData->legal_man; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($enterpriseData, 'legal_phone') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo $enterpriseData->legal_phone; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo Yii::t('memberEnterpriseLog', '营业执照注册地'); ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo Region::getName($enterpriseData->license_province_id, $enterpriseData->license_city_id, $enterpriseData->license_district_id); ?>

                        </td>
                    </tr>
                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo Yii::t('memberEnterpriseLog', '营业执照有效期') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo date('Y-m-d', $enterpriseData->license_start_time); ?>
                            - <?php echo date('Y-m-d', $enterpriseData->license_end_time); ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($enterpriseData, 'license_photo') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <img src="<?php echo ATTR_DOMAIN . '/' . $enterpriseData->license_photo ?>"
                                 id="license_photo" width="300px"/>
                        </td>
                    </tr>
                    <?php if($enterprise->enterprise_type==Enterprise::TYPE_ENTERPRISE): ?>
                    <tr>
                        <td height="50" colspan="3" align="center" class="dtffe">
                            <b><?php echo Yii::t('memberEnterpriseLog', '组织机构代码证'); ?></b>
                        </td>
                    </tr>

                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($enterpriseData, 'organization_image') ?>
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <img src="<?php echo ATTR_DOMAIN . '/' . $enterpriseData->organization_image ?>"
                                 id="organization_photo" width="300px"/>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td height="50" colspan="3" align="center" class="dtffe">
                            <b><?php echo Yii::t('memberEnterpriseLog', '开户银行信息'); ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($bankAccount, 'account_name') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo $bankAccount->account_name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($bankAccount, 'account') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo $bankAccount->account; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($bankAccount, 'bank_name') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo $bankAccount->bank_name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td height="30" align="center" class="dtEe">
                            <?php echo Yii::t('memberMember', '开户银行所在地'); ?>：
                        </td>
                        <td colspan="2" class="dtFff pdleft20">
                            <?php echo Region::getName($bankAccount->province_id,$bankAccount->city_id,$bankAccount->district_id);?>
                        </td>
                    </tr>

                    <?php if($enterprise->enterprise_type==$enterprise::TYPE_ENTERPRISE): ?>
                        <tr>
                            <td width="140" height="25" align="center" class="dtEe">
                                <?php echo $form->label($bankAccount, 'licence_image') ?>
                            </td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                                <img src="<?php echo ATTR_DOMAIN . '/' . $bankAccount->licence_image ?>" id="bank_photo"
                                     width="300px"/>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php if($enterprise->enterprise_type==$enterprise::TYPE_INDIVIDUAL): ?>
                        <tr>
                            <td width="140" height="25" align="center" class="dtEe">
                                <?php echo $form->label($enterpriseData, 'identity_image') ?>
                            </td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                                <img src="<?php echo ATTR_DOMAIN . '/' . $enterpriseData->identity_image ?>" id="bank_photo"
                                     width="300px"/>
                            </td>
                        </tr>
                        <tr>
                            <td width="140" height="25" align="center" class="dtEe">
                                <?php echo $form->label($enterpriseData, 'identity_image2') ?>
                            </td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                                <img src="<?php echo ATTR_DOMAIN . '/' . $enterpriseData->identity_image2 ?>" id="bank_photo"
                                     width="300px"/>
                            </td>
                        </tr>
                        <tr>
                            <td width="140" height="25" align="center" class="dtEe">
                                <?php echo $form->label($enterpriseData, 'debit_card_image') ?>
                            </td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                                <img src="<?php echo ATTR_DOMAIN . '/' . $enterpriseData->debit_card_image ?>" id="bank_photo"
                                     width="300px"/>
                            </td>
                        </tr>
                        <tr>
                            <td width="140" height="25" align="center" class="dtEe">
                                <?php echo $form->label($enterpriseData, 'debit_card_image2') ?>
                            </td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                                <img src="<?php echo ATTR_DOMAIN . '/' . $enterpriseData->debit_card_image2 ?>" id="bank_photo"
                                     width="300px"/>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <td height="50" colspan="3" align="center" class="dtffe">
                            <b><?php echo Yii::t('memberEnterpriseLog', '税务登记证'); ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td width="140" height="25" align="center" class="dtEe">
                            <?php echo $form->label($enterpriseData, 'tax_image') ?>：
                        </td>
                        <td height="25" colspan="2" class="dtFff pdleft20">
                            <img src="<?php echo ATTR_DOMAIN . '/' . $enterpriseData->tax_image ?>" id="tax_photo"
                                 width="300px"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;border:none;">
                            <?php echo CHtml::button('关闭', array('onclick' => 'window.close();','style'=>'border:1px solid #ccc;padding:5px 10px;color:#000;margin:20px 0;cursor:pointer;')) ?>
                        </td>
                    </tr>

                    </tbody>
                </table>
                <?php $this->endWidget(); ?>
            </div>

        </div>
    </div>

</body>
<?php Yii::app()->clientScript->registerCoreScript('artDialog') ?>
<script>
    var notice = {
        feeNoticeTitle:"收费版服务说明",
        feeNoticeContent:"<dl><dt><strong>2.5万收费版（全托管服务）</strong></dt>" +
        "<dd>1、拥有商城店铺一间，经营权1年（价值2.5万）；</dd>" +
        "<dd>2、拥有商城首页广告位一个（两个月），由商城分配（价值5万）；</dd>" +
        "<dd>3、为商家上传图片，打理店铺（价值1万）；</dd>" +
        "<dd>4、合同期内优先，不限次参加商城的专题活动；</dd>" +
        "<dd>5、可优先享受商城推出的增值扶持；</dd>" +
        "<dd>6、发布产品数量不限。</dd>" +
        "</dl>",
        freeNoticeTitle:"免费版服务说明",
        freeNoticeContent:"<dl><dt><strong>免费版 （商家自营）</strong></dt>" +
        "<dd>1、拥有商城店铺一间，经营权1年（价值2.5万）；</dd>" +
        "<dd>2、无店铺装修；</dd>" +
        "<dd>3、商家自已上传图片，打理店铺；</dd>" +
        "<dd>4、商家1年内有5次免费的机会参加商城的专题活动；</dd>" +
        "<dd>5、可发布500款产品；</dd>" +
        "<dd>6、可有偿使用广告位，竞价排位，商品推广等。</dd></dl>"
    };
    //收费说明
    $("#feeNotice").click(function(){
        art.dialog({
            title:notice.feeNoticeTitle,
            content:notice.feeNoticeContent,
            lock:true,
            time:10,
            top:'10%'
        });
        return false;
    });
    //免费提醒
    $("#freeNotice").click(function(){
        art.dialog({
            title:notice.freeNoticeTitle,
            content:notice.freeNoticeContent,
            lock:true,
            time:5,
            top:'10%'
        });
        return false;
    });
</script>
</html>
