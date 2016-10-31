<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<!-- <link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css"> -->
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/My97DatePicker/WdatePicker.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/uploadImg.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/pdf.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.jqzoom.js"></script>

<link rel="stylesheet" type="text/css" href="/css/reg.css" />
<link rel="stylesheet" type="text/css" href="/css/jqtransform.css">
<script type="text/javascript" src="/js/jquery.jqtransform.js"></script>


<?php
/* @var $this OfflineSignStoreController */
/* @var $model OfflineSignStore */
/* @var $model OfflineSignEnterprise */
/* @var $model OfflineSignContract */
$breadcrumbsMap = array(
    OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE => array(
        'breadcrumbs' =>  Yii::t('offlineSignStore', '编辑审核资质(新商户)'),
        'partialView' => '_updateNewApply',
        'enterprise' => '_update_sign_enterpriseinfo',
    ),
    OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE => array(
        'breadcrumbs' =>  Yii::t('offlineSignStore', '编辑审核资质(原有会员增加盟商)'),
        'partialView' => '_updateOldAppy',
    ),
);
$this->breadcrumbs = array(
    Yii::t('offlineSignStore', '电子化签约审核列表') =>array('offlineSignStoreExtend/admin'),
    $breadcrumbsMap[$extendInfoModel->apply_type]['breadcrumbs'],
);

$this->renderPartial($breadcrumbsMap[$extendInfoModel->apply_type][$enterprise],array(
    'storeInfoModel'=>$storeInfoModel,
    'enterpriseInfoModel'=>$enterpriseInfoModel,
    'contractInfoModel'=>$contractInfoModel,
    'extendInfoModel'=>$extendInfoModel,
    'demoImgs'=>$demoImgs,
    'role' => $role,
    'uploadUrl' => Yii::app()->createAbsoluteUrl('/offline-upload/upload'),
));
?>
<script>
    //图片放大镜效果
    $(function(){
        $(".jqzoom").jqueryzoom({xzoom:380,yzoom:410});
        $(".party-prcList ul li img").click(function(){
            var url=$(this).attr("src");
            $(this).parent().parent().parent().parent().parent().find("#preview img").attr("src",url);
        })
    });
</script>
<script type="text/javascript">
    var publicPayType = '<?php echo OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PUBLIC?>';
    var csrfToken = '<?php echo Yii::app()->request->csrfToken ?>';
    var returnEndTimeUrl = '<?php echo $this->createUrl("offlineSignStore/returnEndTime");?>';
    var findMachineBelongInfoUrl = '<?php echo $this->createAbsoluteUrl("/offlineSignMachineBelong/getMachines",array('extendId'=>$extendInfoModel->id)) ?>';
    var  savestoreInfoUrl = '<?php echo $this->createAbsoluteUrl("/offlineSignStoreExtend/saveOldFranchisee",array('role'=>$role)) ?>';
</script>
<script type="text/javascript">
    $(function(){
        $('.t-sub').html('<a class="regm-sub" href="<?php echo $this->createAbsoluteUrl("/offlineSignStoreExtend/admin",array('role'=>$role)) ?>">返回列表</a>');
    });
</script>
<link rel="stylesheet" type="text/css" href="/css/update-offline-sigin-info.css">
<script type="text/javascript" src="/js/update-offline-sigin-info.js"></script>