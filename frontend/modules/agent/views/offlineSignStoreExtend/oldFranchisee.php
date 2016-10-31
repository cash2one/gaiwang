<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<?php
/* @var $this OfflineSignStoreExtendController */
/* @var $model OfflineSignStoreExtend */

$this->breadcrumbs=array(
    '电子化签约申请'=>array('offlineSignStoreExtend/admin'),
    '原有会员新增加盟商',
);

$this->menu=array(
    array('label'=>'List OfflineSignStoreExtend', 'url'=>array('index')),
    array('label'=>'Create OfflineSignStoreExtend', 'url'=>array('create')),
);
?>
<div class="toolbar img08"><?php echo CHtml::link(Yii::t('Public','返回'), $this->createURL('OfflineSignStoreExtend/selectCreate'), array('class' => 'button_05 floatRight')); ?></div>
<div class="com-box">
    <div class="sign-contract">
        <div class="sign-top clearfix">
            <p><strong>请提交以下签约资质审核资料，审核成功后，该商户可享受盖网一系列优质服务。</strong></p>
            <p><strong>温馨提示：</strong><span class="red" style="float: inherit">*</span> 为必填项。支持上传的图片文件格式jpg、jpeg、gif、bmp，单张图片大小3M以内。</p>
            <div class="c10"></div>
        </div>
        <div class="sign-clear"></div>
        <div class="c30"></div>
        <div class="sign-conten">
            <div class="sign-list">
                <ul>
                    <li><span>会员GW号</span><input type="text" id="GWnumber" name="GWnumber" class="input ml"/></li>
                    <li><span>企业名称</span><input type="text" id="enterpriseName" name="enterpriseName" class="input ml"/></li>
                </ul>
            </div>
            <div class="sign-btn">
                <input id="submit" type="submit" value="搜索" class="btn-sign">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#submit').click(function(){
            var GWnumber = $('#GWnumber').val();
            var enterpriseName = $('#enterpriseName').val();
            var flag = 0;                   //按GW号搜索还是企业名称搜索
            var str = '';                   //GW号或者企业名称
            if(GWnumber.length > 0) {
                flag = 0;
                str = GWnumber;
            }
            if(GWnumber.length == 0 && enterpriseName.length > 0) {
                flag = 1;
                str = enterpriseName;
            }
            if(GWnumber.length == 0 && enterpriseName.length == 0){
                art.dialog({
                    icon: 'warning',
                    content: '请输入会员GW号或企业名称之后搜索',
                    lock:true,
                    ok:true
                });
                return ;
            }
            $.ajax({
                type: "post", async: false, dataType: "json", timeout: 5000,
                url: "<?php echo $this->createUrl('ajaxGetInfo') ?>",
                data: {YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>', flag: flag,str:str},
                success: function(data) {
                    if (data.success) {
                        window.location.href = createUrl("<?php echo $this->createUrl('offlineSignStore/oldFranchiseeView')?>",{enterpriseId:data.enterpriseInfo.eid,memberId:data.enterpriseInfo.mid,extendId:''});
                    } else {
                        art.dialog({
                            icon: 'warning',
                            content: data.error,
                            lock:true,
                            ok:function(){
                                $('#GWnumber').empty();
                                $('#enterpriseName').empty();
                                $('#GWnumber').focus();
                            }
                        });
                    }
                }
            });
        });
    });
</script>

