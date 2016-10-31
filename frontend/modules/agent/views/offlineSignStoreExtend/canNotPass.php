<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.jqzoom.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/pdf.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.js"></script>
<?php
/* @var $this OfflineSignEnterpriseController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    '电子化签约申请'=>array('OfflineSignStoreExtend/admin'),
    '不通过原因 ',
);

$this->menu=array(
    array('label'=>'Create OfflineSignStoreExtend', 'url'=>array('create')),
    array('label'=>'Manage OfflineSignStoreExtend', 'url'=>array('admin')),
);
?>
<style>

    .btnSignSubmit {
        background: #e73232;
        width: 220px;
        height: 55px;
        line-height: 55px;
        cursor: pointer;
        border-radius: 5px;
        color: #fff;
        font-size: 20px;
        border: 0 none;
    }
</style>
<div class="toolbar img08"><?php echo CHtml::link(Yii::t('Public','返回列表'), $this->createURL('offlineSignStoreExtend/admin'), array('class' => 'button_05 floatRight')); ?></div>

<div class="com-box">
    <div class="audit-type clearfix">
        <div>
            <span>新增类型</span>
            <?php echo OfflineSignStoreExtend::getApplyType($extendModel->apply_type) ?>
        </div>
        <div>
            <span>企业名称</span>
            <?php echo $extendModel->enTerName ?>
        </div>
    </div>
    <?php if($contractModel):?>
        <?php $this->renderPartial('_contract', array('contractModel'=>$contractModel,'extendModel'=>$extendModel)); ?>
    <?php endif;?>
    <?php if(isset($enterpriseModel->license_image)):?>
        <?php $this->renderPartial('_enterprise', array('enterpriseModel'=>$enterpriseModel)); ?>
    <?php endif;?>
    <?php foreach($storeData as $num=>$row):?>
        <?php $this->renderPartial('_store',array('model'=>$row,'num'=>$num))?>
    <?php endforeach;?>
    <div class="audit-tableTitle">附件信息</div>
    <div class="audit-bargain clearfix">
        <?php if($extendModel->apply_type == OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE):?>
            <ul>
                <li id="ex.upload_contract">
                    <p class="bargain-cho">联盟商户合同
                    </p>
                    <p class="bargain-pdf">
                        <?php echo OfflineSignFile::getOldName($extendModel->upload_contract) ?>
                        <a  onclick="return _showContract(this)" href="<?php echo OfflineSignFile::getfileUrl($extendModel->upload_contract) ?>">查看</a>
                    </p>
                </li>
                <?php $storeNum = count($storeData); if($storeNum > 1 && !empty($extendModel->upload_contract_img)):$upload_img_arr = explode(',',$extendModel->upload_contract_img);$num = count($upload_img_arr);?>
                    <?php for($i=0;$i <$num;$i++):?>
                        <li  id="ex.upload_contract_img<?php echo $upload_img_arr[$i]?>">
                            <p class="bargain-cho">盖网通铺设场所及优惠约定-附件 <?php echo $i+1;?>
                            </p>
                            <p class="bargain-pdf">
                                <?php echo OfflineSignFile::getOldName($upload_img_arr[$i]) ?>
                                <a  onclick="return _showBigPic(this)" href="<?php echo OfflineSignFile::getfileUrl($upload_img_arr[$i]) ?>">查看</a>
                            </p>
                        </li>
                    <?php endfor;?>
                <?php endif;?>
            </ul>
        <?php endif;?>
        <?php if($extendModel->apply_type == OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE):?>
            <ul>
                <?php $storeNum = count($storeData); if(!empty($extendModel->upload_contract_img)):$upload_img_arr = explode(',',$extendModel->upload_contract_img);$num = count($upload_img_arr);?>
                    <?php for($i=0;$i <$num;$i++):?>
                        <li id="ex.upload_contract_img<?php echo $upload_img_arr[$i]?>">
                            <p class="bargain-cho">盖网通铺设场所及优惠约定-附件 <?php echo $i+1;?>
                            </p>
                            <p class="bargain-pdf">
                                <?php echo OfflineSignFile::getOldName($upload_img_arr[$i]) ?>
                                <a  onclick="return _showBigPic(this)" href="<?php echo OfflineSignFile::getfileUrl($upload_img_arr[$i]) ?>">查看</a>
                            </p>
                        </li>
                    <?php endfor;?>
                <?php endif;?>
            </ul>
        <?php endif;?>
    </div>
    <div class="audit-tableTitle">审核结果：未通过</div>
    <div class="audit-bargain clearfix">
        <?php echo OfflineSignStoreExtend::NoPassExtend($extendModel->id);?>

    </div>
    <?php
    if($extendModel->status == OfflineSignStoreExtend::STATUS_NOT_BY_CONTRACT){
        if($extendModel->apply_type == OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE){
            $url = $this->createUrl('offlineSignStoreExtend/uploadContract', array('storeExtendId' => $_GET['id']));
            $button_name = '重新打印并上传合同';
        }else {
            $url = $this->createUrl('offlineSignStoreExtend/uploadContract', array('storeExtendId' => $_GET['id']));
            $button_name = '重新打印并上传合同';
        }
    }
    else{
        if($extendModel->apply_type == OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE){
            $url = $this->createUrl('offlineSignStore/OldFranchiseeUNLL',array('id'=>$_GET['id']));
            $button_name = '修改资质';
        }else {
            $url = $this->createUrl('offlineSignContract/newFranchiseeUpdate/', array('id' => $_GET['id']));
            $button_name = '修改资质';
        }
    }
    ?>
    <div class="audit-btn">
        <input type="button" value="<?php echo $button_name?>" id="update_details" class="btnSignSubmit" onclick="returnHref()"/>
    </div>
</div>
<script>

    function returnHref(){

        window.location.href ='<?php echo $url;?>'
    }

	$(document).ready(function(){

        <?php foreach($storeData as $num=>$model):?>
		<?php if(isset($model) && $model->error_field):?>
		<?php $modelError = json_decode($model->error_field,true);?>
		<?php foreach($modelError as $value):?>
        <?php $strArr = explode('.',$value);$value = $strArr[0].'.'.$model->id.$strArr[1];?>
		$("li[id='<?php echo $value?>']").addClass('red');
		<?php endforeach;?>
		<?php endif;?>
        <?php endforeach;?>


		<?php if(isset($enterpriseModel->license_image) && $enterpriseModel->error_field):?>
		<?php $modelError = json_decode($enterpriseModel->error_field,true);?>
		<?php  foreach($modelError as $value):?>
		$("li[id='<?php echo $value?>']").addClass('red');
		<?php endforeach;?>
		<?php endif;?>

		<?php if(isset($contractModel->number) && $contractModel->error_field):?>
		<?php $modelError = json_decode($contractModel->error_field,true);?>
		<?php foreach($modelError as $value):?>
		$("li[id='<?php echo $value?>']").addClass('red');
		<?php endforeach;?>
		<?php endif;?>


        <?php if(isset($extendModel) && $extendModel->error_field):?>
        <?php $modelError = json_decode($extendModel->error_field,true);?>
        <?php foreach($modelError as $value):?>
        $("li[id='<?php echo $value?>']").addClass('red');
        <?php endforeach;?>
        <?php endif;?>
	});
</script>
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