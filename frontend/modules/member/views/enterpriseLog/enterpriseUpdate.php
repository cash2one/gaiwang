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
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->clientScript;
//显示原图的JS插件
$cs->registerCssFile($baseUrl . "/js/swf/js/fancybox/jquery.fancybox-1.3.4.css");
$cs->registerScriptFile($baseUrl . "/js/swf/js/fancybox/jquery.fancybox-1.3.4.pack.js", CClientScript::POS_END);

?>
<script>
    $(function () {
        $("#license_pic").fancybox();
    });
</script>

<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr">
                <a href="javascript:;">
                    <span><?php echo Yii::t('memberMember', '网签'); ?></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="mbRcontent">

        <a href="javascript:void(0)" class="mbTip mgtop10">
            <span class="mbFault"></span>
            亲，请尽快修改在线入驻审核资料，审核成功后，贵公司可享受在盖象商城开店并销售商品等一系列的优质服务。
        </a>
        <hr/>
        温馨提示：以下所需要上传电子版资质仅支持JPG、GIF、PNG格式的图片，大小不能超过 1M
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <?php echo $this->renderPartial('_form', array('enterprise'=>$enterprise,'bankAccount'=>$bankAccount,'store'=>$store)) ?>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>
