<link rel="stylesheet" type="text/css" href="/css/reg.css" />
<link rel="stylesheet" type="text/css" href="/css/jqtransform.css">
<script type="text/javascript" src="/js/jquery.jqtransform.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.jqzoom.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/pdf.js" type="text/javascript"></script>
<style>
    .red {
        color: #F00;
        margin-right: 2px;
    }
</style>
<?php
/* @var $this OfflineSignStoreController */
/* @var $model OfflineSignStore */
/* @var $model OfflineSignEnterprise */
/* @var $model OfflineSignContract */

$this->breadcrumbs = array(
    Yii::t('offlineSignStore', '电子化签约审核列表') =>array('offlineSignStoreExtend/admin'),
    Yii::t('offlineSignStore', '审核资质(运作部)') => array('offlineSignStore/operationDepartmentAudit'),

);

$baseUrl = Yii::app()->baseUrl;
Yii::app()->clientScript->registerCssFile($baseUrl.'/css/jqtransform.css');
?>



<?php if($extendModel->apply_type == OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE) :?>
<?php $this->renderPartial('_operationDepartmentNew',array('extendModel'=>$extendModel,'enterprise_model'=>$enterpriseModel,'contract_model'=>$contractModel,'storeData'=>$storeData))?>


<?php elseif($extendModel->apply_type == OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE):?>
    <?php $this->renderPartial('_operationDepartmentOld',array('storeData'=>$storeData,'extendModel'=>$extendModel,))?>
<?php endif;?>

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
    //不通过审核时处理备注框内容
    $('#btnSignBack').click(function(){
        $('#contentHidden').val($('#content').val());
    });
</script>

<script type="text/javascript">
    $(function(){
        $('.party-cho').jqTransform();

        $("input[name='errors[]']").change(function () {
            var word = "不通过原因：提交的资料有误。有如下地方需要修改:";
            var field = [];
            var count = 0;

            $("input[name='errors[]']").each(function () {
                if ($(this).attr('checked') == 'checked') {
                    count++;
                    field.push($(this).val());
                }
            });

            if (count > 0) {
                $("#content").html(word + field.join('、'));
                $("#btnSignSubmit").attr('style', 'background:#ccc !important');
            } else {
                $("#content").html('');
                $("#btnSignSubmit").attr('style', 'background:#e73232 !important');
            }
        });

        $("#btnSignSubmit").click(function () {
            if($("input[name='errors[]']:checked").length>0){
                return false;
            }
            if($("#status").val() != ''){
                return false;
            }
            $("#status").val("<?php echo OfflineSignAuditLogging::STATUS_PASS; ?>");
            $("errorField").val('');
            $("#auditing_form").submit();
        });

        $("#btnSignBack").click(function () {
            if ($("#content").val() == '') {
                alert("请填写未通过审核原因！");
                return false;
            } else {
                if($("#status").val() != ''){
                    return false;
                }
                $("#status").val("<?php echo OfflineSignAuditLogging::STATUS_NO_PASS; ?>");
                var a = [];
                $("input[name='errors[]']:checked").each(function(){
                    a.push($(this).attr('field'));
                });
                if(a.length>0){
                    $("#errorField").val(a.join(','));
                }
                $("#auditing_form").submit();
            }
        });
    });
</script>
<script>
    $(document).ready(function(){

        <?php foreach($storeData as $num=>$model):?>
        <?php if(isset($model) && $model->error_field):?>
        <?php $modelError = json_decode($model->error_field,true);?>
        <?php foreach($modelError as $value):?>
        <?php $strArr = explode('.',$value);$value = $strArr[0].'.'.$model->id.$strArr[1];?>
        $("li[id='<?php echo $value?>']").addClass('red');
        $("li[id='<?php echo $value?>']").find('.jqTransformCheckbox').click();
        <?php endforeach;?>
        <?php endif;?>
        <?php endforeach;?>


        <?php if(isset($enterpriseModel->license_image) && $enterpriseModel->error_field):?>
        <?php $modelError = json_decode($enterpriseModel->error_field,true);?>
        <?php  foreach($modelError as $value):?>
        $("li[id='<?php echo $value?>']").addClass('red');
        $("li[id='<?php echo $value?>']").find('.jqTransformCheckbox').click();
        <?php endforeach;?>
        <?php endif;?>

        <?php if(isset($contractModel->number) && $contractModel->error_field):?>
        <?php $modelError = json_decode($contractModel->error_field,true);?>
        <?php foreach($modelError as $value):?>
        $("li[id='<?php echo $value?>']").addClass('red');
        $("li[id='<?php echo $value?>']").find('.jqTransformCheckbox').click();
        <?php endforeach;?>
        <?php endif;?>


        <?php if(isset($extendModel) && $extendModel->error_field):?>
        <?php $modelError = json_decode($extendModel->error_field,true);?>
        <?php foreach($modelError as $value):?>
        $("li[id='<?php echo $value?>']").addClass('red');
        $("li[id='<?php echo $value?>']").find('.jqTransformCheckbox').click();
        <?php endforeach;?>
        <?php endif;?>
    });
</script>