<?php
//网签
/* @var $this  HomeController */
/** @var $model Member */
/** @var $enterprise Enterprise */
/** @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberMember', '账号管理') => '',
    Yii::t('memberMember', '基本信息修改'),
);
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr">
                <a href="javascript:;">
                    <span><?php echo Yii::t('memberMember', '网络店铺签约'); ?></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="mbRcontent">

        <a href="javascript:void(0)" class="mbTip mgtop10" style="cursor:default;margin-bottom:20px;">
            <span class="mbFault"></span>
            <?php echo Yii::t('enterpriseLog','您好，请尽快提交在线入驻审核资料，审核成功后，贵公司可享受在盖象商城开店并销售商品等一系列的优质服务。'); ?>
        </a>

        <div style="padding-left:50px;color:#ccc;">
            <?php echo Yii::t('enterpriseLog','温馨提示：以下所需要上传电子版资质仅支持JPG、GIF、PNG格式的图片，大小不能超过2M。'); ?>
            <?php if(!$bankAccount->isNewRecord): ?>
                <strong style="color:orange;">请修改以下标橙色的项目</strong>。
            <?php endif; ?>
        </div>

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <?php echo $this->renderPartial('_form2', array(
                    'enterprise'=>$enterprise,
                    'bankAccount'=>$bankAccount,
                    'store'=>$store,
                    'enterpriseData'=>$enterpriseData,
                    'lastOne'=>$lastOne
                )) ?>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>
<?php $this->renderPartial('_uploadTips') ?>