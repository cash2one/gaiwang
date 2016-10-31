<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/My97DatePicker/WdatePicker.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/pdf.js" type="text/javascript"></script>
<?php
/* @var $this OfflineSignStoreController */
/* @var $model OfflineSignStore */

$this->breadcrumbs=array(
    '电子化签约申请'=>array('OfflineSignStoreExtend/admin'),
    '审核进度',
);

$this->menu=array(
    array('label'=>'List OfflineSignStore', 'url'=>array('index')),
    array('label'=>'Manage OfflineSignStore', 'url'=>array('admin')),
);
?>
<div class="toolbar img08"><?php echo CHtml::link(Yii::t('Public','返回列表'), $this->createURL('offlineSignStore/admin'), array('class' => 'button_05 floatRight')); ?></div>
<div class="com-box">
    <p class="sign-title">该单位的电子化签约申请正在审核中，请耐心等待。 相关明细请查看审核进度详情。</p>
    <div class="audit-type clearfix">
        <p><span class="sign-title" style=" padding-right: 15px;">新增类型</span><?php echo OfflineSignStore::getApplyType($storeInfo['apply_type'])?></p>
        <p><span class="sign-title" style=" padding-right: 15px;">企业名称</span><?php echo $storeInfo['name'] ? $storeInfo['name'] : $storeInfo['b_name'] ?></p>
    </div>
    <div class="sign-clear"></div>
    <p class="sign-title">审核进度</p>

    <div class="sign-plan clearfix">
        <p class="sign-plan-bg"></p>
        <?php foreach(OfflineSignStore::getAuditStatus() as $key => $value):?>
            <p
            <?php if($key<=$storeInfo['audit_status']):?>
                <?php echo 'class="on"'?>
            <?php endif;?>
            >
            <?php echo $value?><span></span></p>
        <?php endforeach;?>
    </div>
    <p class="sign-title">进度详情</p>
    <div class="sign-details">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg4">
            <tbody>
            <tr>
                <th width="15%" class="bgOrange">时间</th>
                <th width="85%" class="bgOrange">事件</th>
            </tr>
            <?php 
            $count = count($data);
            foreach($data as $value):?>
            <tr>
                <td class="ta_c"><?php echo date("Y-m-d H:i:s",$value->create_time)?></td>
                <td class="ta_l">
                    <?php echo OfflineSignAuditLogging::_showEvent($value)?>
                    <?php if($value->behavior == '2001' && $value->status == OfflineSignAuditLogging::STATUS_NO_PASS):?>
                        <p class="why"><?php echo $value->remark;?></p>
                    <?php endif;?>
                    <?php if($value->behavior == '1101'):?>
                        <p class="why">
                            温馨提示：请下载并打印您的合同，同时请加盖相关盖章，以备后续扫描、上传相关资质进行审核。
                        <a href="<?php echo $this->createUrl('offlineSignContract/printView',array('contractId'=>$storeInfo['cid'],'name'=>$storeInfo['b_name']))?>">打印合同</a>
                        </p>
                    <?php endif;?>
                    <?php 
                        $count -= 1;
                        $mark =false;
                        if($storeInfo['audit_status'] == OfflineSignStore::AUDIT_STATUS_SUB_ELECTR ){
                            $count==0 && $mark = true;
                        }
                        //当为上传合同或者上传合同有问题状态为为提交合同时，可以上传合同并且只能有一个
                        if( $mark ){
                    ?>
                        <p class="why">
                            温馨提示：请把您已加盖相关盖章的合同资质扫描并上传，以备进行审核。
                            <a href="<?php echo $this->createUrl('offlineSignStore/uploadContract',array('storeId'=>$model->id,'name'=>$storeInfo['name']))?>">上传合同</a>
                        </p>
                    <?php } ?>
                </td>
            </tr>
            <?php endforeach;?>

            </tbody>
        </table>
    </div>

</div>