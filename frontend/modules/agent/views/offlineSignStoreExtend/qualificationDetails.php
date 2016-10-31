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
/* @var $this OfflineSignStoreExtendController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'电子化签约申请'=>array('OfflineSignStoreExtend/admin'),
	' 查看资质详情',
);

$this->menu=array(
	array('label'=>'Create OfflineSignStoreExtend', 'url'=>array('create')),
	array('label'=>'Manage OfflineSignStoreExtend', 'url'=>array('admin')),
);
?>
<script>
    $(function(){
        $(".sign-tableTitle a.check").click(function(){
            $(this).parent().next(".sign-list").slideToggle("slow");
            $(this).toggleClass("on");
            $(".sign-tableTitle a.check.on").html("查看");
            $(".sign-tableTitle a.check").html("收起");
        })
    })
</script>
<div class="toolbar img08"><?php echo CHtml::link(Yii::t('Public','返回列表'), $this->createURL('offlineSignStoreExtend/admin'), array('class' => 'button_05 floatRight')); ?></div>

<div class="com-box">
	<div class="audit-type clearfix">
		<div>
			<span>新增类型</span>
			<?php echo OfflineSignStoreExtend::getApplyType($extendModel->apply_type) ?>
		</div>
		<div>
			<span>企业名称</span>
			<?php  echo $extendModel->enTerName ?>
		</div>
	</div>
	<?php if($contractModel):?>
		<?php $this->renderPartial('_contract', array('contractModel'=>$contractModel,'extendModel'=>$extendModel)); ?>
	<?php endif;?>
	<?php if(!empty($enterpriseModel) && !empty($enterpriseModel->linkman_name)):?>
		<?php $this->renderPartial('_enterprise', array('enterpriseModel'=>$enterpriseModel)); ?>
	<?php endif;?>
	<?php foreach($storeData as $num=>$row):?>
		<?php $this->renderPartial('_store',array('model'=>$row,'num'=>$num))?>
        <br/>
	<?php endforeach;?>
    <div class="audit-tableTitle">附件信息</div>
    <div class="audit-bargain clearfix">
        <?php if($extendModel->apply_type == OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE && !empty($extendModel->upload_contract)):?>
        <ul>
            <li>
                <p class="bargain-cho">联盟商户合同
                </p>
                <p class="bargain-pdf">
                    <?php echo OfflineSignFile::getOldName($extendModel->upload_contract) ?>
                    <a  onclick="return _showContract(this)" href="<?php echo OfflineSignFile::getfileUrl($extendModel->upload_contract) ?>">查看</a>
                </p>
            </li>
            <?php $storeNum = count($storeData); if($storeNum > 1 && !empty($extendModel->upload_contract_img)):$upload_img_arr = explode(',',$extendModel->upload_contract_img);$num = count($upload_img_arr);?>
                <?php for($i=0;$i <$num;$i++):?>
                <li>
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
        <?php if($extendModel->apply_type == OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE && !empty($extendModel->upload_contract_img)):?>
            <ul>
                <?php $storeNum = count($storeData); if(!empty($extendModel->upload_contract_img)):$upload_img_arr = explode(',',$extendModel->upload_contract_img);$num = count($upload_img_arr);?>
                    <?php for($i=0;$i <$num;$i++):?>
                        <li>
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
</div>
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