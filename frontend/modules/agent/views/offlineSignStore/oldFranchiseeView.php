<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.jqzoom.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/My97DatePicker/WdatePicker.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/pdf.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.js"></script>
<style>
    /*表单错误提示调整*/
    span{
        float: left;
    }
    input{float: left;}
    .errorMessage{float: left;}
    select{float: left;}
</style>
<?php
/* @var $this OfflineSignStoreController */
/* @var $model OfflineSignStore */

$this->breadcrumbs=array(
    '电子化签约申请'=>array('OfflineSignStoreExtend/admin'),
    $model->isNewRecord ? '原有会员新增加盟商 > 新建' : '原有会员新增加盟商 > 编辑',
);

$this->menu=array(
    array('label'=>'List OfflineSignStore', 'url'=>array('index')),
    array('label'=>'Manage OfflineSignStore', 'url'=>array('admin')),
);
?>

    <script type="text/javascript">
        $(document).ready(function () {
            var bodyWidth = $(".main").width();
            var ws = bodyWidth - 9;
            $(".t-com").width(ws);
            $(window).resize(function () {
                var bodyWidth = $(".main").width();
                var ws = bodyWidth - 9;
                $(".ws").width(ws);
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tab-come ').each(function () {
                $(this).find('tr:even td').addClass('even');
                $(this).find('tr:odd td').addClass('odd');
                $(this).find('tr:even th').addClass('even');
                $(this).find('tr:odd th').addClass('odd');
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tab-reg ').each(function () {
                $(this).find('tr:even td').css("background", "#eee");
                $(this).find('tr:odd td').css("background", "#fff");
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var $thi = $('body,html').find("#u_title li");
            $($thi).hover(function () {
                $(this).addClass("cur").siblings().removeClass("cur");
                var $as = $("#con .con_listbox").eq($("#u_title li").index(this));
                $as.show().siblings().hide();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function (e) {
            $('#tabcon tr:even').addClass('odd')
        });

    </script>

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
<div class="toolbar img08"><?php echo CHtml::link(Yii::t('Public','返回'), $this->createURL('offlineSignStoreExtend/admin'), array('class' => 'button_05 floatRight')); ?></div>
            <div class="com-box">
                <!-- com-box -->
                <div class="sign-contract">
                    <div class="sign-top clearfix">
                        <p><strong>请提交以下签约资质审核资料，审核成功后，该商户可享受盖网一系列优质服务。</strong></p>
                        <p><strong>温馨提示：</strong><span class="red" style="float: inherit">*</span> 为必填项。支持上传的图片文件格式jpg、jpeg、gif、bmp，单张图片大小3M以内。</p>
                        <div class="c10"></div>
                    </div>
                    <div class="sign-clear"></div>
                    <div class="c10"></div>
                    <div class="sign-conten">
                        <div class="audit-type clearfix">
                            <div>
                                <span>新增类型</span>
                                <?php echo OfflineSignStoreExtend::getApplyType(OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE) ?>
                            </div>
                            <div>
                                <span>企业名称</span>
                                <?php echo !empty($enterpriseModel)?$enterpriseModel->name:''; ?>
                            </div>
                        </div>
                        <?php if($contractModel):?>
                        <?php $this->renderPartial('_enterpriseInfo',array('enterpriseModel'=>$enterpriseModel,'contractModel'=>$contractModel))?>
                            <br/>
                        <?php endif;?>
                        <?php if($contractModel):?>
                        <?php $this->renderPartial('_contractInfo',array('contractModel'=>$contractModel,'extendModel'=>$extendModel))?>
                    </div>
                            <br/>
                        <?php endif;?>
                        <?php $this->renderPartial('_form',array('model'=>$model,'demoImgs'=>$demoImgs,'extendModel'=>$extendModel,'storeModel'=>$storeModel))?>
                </div>
            </div>
<script>

        $('#lastStep').hide();
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

