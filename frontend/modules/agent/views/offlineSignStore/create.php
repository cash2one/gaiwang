<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.jqzoom.js"></script>

<?php
/* @var $this OfflineSignStoreController */
/* @var $model OfflineSignStore */

$this->breadcrumbs=array(
	'电子化签约申请'=>array('OfflineSignStoreExtend/admin'),
	'新商户生成信息录入 > 盖机与店铺信息',
);

$this->menu=array(
	array('label'=>'List OfflineSignStore', 'url'=>array('index')),
	array('label'=>'Manage OfflineSignStore', 'url'=>array('admin')),
);
?>
<div class="com-box">
	<!-- com-box -->
	<div class="sign-contract">
		<div class="sign-top clearfix">
			<p><strong>请提交以下签约资质审核资料，审核成功后，该商户可享受盖网一系列优质服务。</strong></p>
			<p><strong>温馨提示：</strong><span class="red" style="float: inherit">*</span> 为必填项。支持上传的图片文件格式jpg、jpeg、gif、bmp，单张图片大小3M以内。</p>
			<div class="c10"></div>
			<div class="contract-list clearfix">
				<p>1、合同信息<span></span></p>
				<p>2、企业与帐号信息<span></span></p>
				<p class="on">3、盖机与店铺信息</p>
			</div>
		</div>
        <script>
            $(function(){
                $(".sign-tableTitle a.check").click(function(){
                    $(this).parent().next(".sign-list").slideToggle("slow");
                    $(this).toggleClass("on");
                    $(".sign-tableTitle a.check").html("查看");
                    $(".sign-tableTitle a.check.on").html("收起");
                })
            })
        </script>
<?php $this->renderPartial('_form', array('model'=>$model,'extendModel' => $extendModel,'demoImgs' => $demoImgs,'storeModel'=>$storeModel)); ?>
	</div>
</div>
<script>
    /**
     * 删除指定加盟商
     */
    function deleteChoose(obj){
        art.dialog({
            title: "<?php echo Yii::t('Public','删除')?>",
            icon: 'question',
            content: "<?php echo Yii::t('Public','确认删除')?>?",
            lock: true,
            ok: function(){
                location.href=obj.href;
            },
            cancel: function(){}
        });
        return false;
    }
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
