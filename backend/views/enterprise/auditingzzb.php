<?php
/* @var $this EnterpriseController */
/* @var $model Enterprise */
/** @var EnterpriseData $enterpriseData */

$enterpriseData = $model->enterpriseData;
$this->breadcrumbs = array(Yii::t('enterprise', '网签审核') => array('admin'), Yii::t('enterprise', '列表'));
?>
<style type="text/css">
  .wantShare{ position:relative;padding-right: 250px}
.wantShare i.arrow{ background-position:0 -260px; width:20px; height:20px; position:absolute; left:183px; top:-13px; display:inline-block;}
.wantShare .wantShareDetail{ border-radius:3px; font-family:"宋体"; width:310px;  background:#fff; text-align:left; position:absolute; right:10px; top:45px; border:1px solid #d5d5d5; box-shadow:0 0 20px #d5d5d5; padding:0 25px 20px; }
.wantShare .wantShareDetail h4{ color:#2a2a2a; font-size:14px; padding-bottom:10px; padding-top:20px;}
.wantShare .wantShareDetail p{ line-height:18px; color:#2a2a2a;}
.wantShare .wantShareDetail p strong{ font-size:12px;}
</style>
<link rel="stylesheet" type="text/css" href="/css/jqtransform.css">
<script type="text/javascript" src="/js/jquery.jqtransform.js"></script>

<div class="com-box">
    <div class="sellerWebSign sellerWebSignIcon">
        <?php if ($role == Enterprise::AUDITING_ROLE_FAWU || $role == Enterprise::AUDITING_ROLE_ZHAOSHANG ): ?>
            <div class="toolbarSign">
                <h3><?php echo Yii::t('enterprise', '温馨提示：'); ?><span class="red"><?php echo Yii::t('enterprise', '若选择不通过此网签纸质合同资质，请概要说明未通过原因；'); ?></span></h3>
            </div>
        <?php endif; ?>
        <?php $form_url = $role == Enterprise::AUDITING_ROLE_ZHAOSHANG ? $this->createAbsoluteUrl('enterprise/auditingZzbZhaoshang', array('id' => $model->id)) : $this->createAbsoluteUrl('enterprise/auditingZzbFawu', array('id' => $model->id)); ?>
        <form id="auditing_form" action="<?php echo $form_url; ?>" method="post">
            <h3 class="mt15 tableTitle"><?php echo Yii::t('enterprise', '商家基本信息'); ?></h3>
            <div class="c10"></div>
            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
                <tbody>
                    <tr>
                        <th><?php echo Yii::t('enterprise', '网店商户类型：'); ?><?php echo Enterprise::getEnterpriseType($model->enterprise_type); ?></th>
                        <td class="ta-r jqtransform"></td>
                    </tr>
                    <tr class="blank">
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <th><?php echo Yii::t('enterprise', '经营类目：'); ?><?php echo Category::getCategoryName($store->category_id); ?></th>
                        <td class="ta-r jqtransform"></td>
                    </tr>
                    <tr class="blank">
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <th><?php echo Yii::t('enterprise', '开店模式：'); ?><?php echo Store::getMode($store->mode); ?></th>
                        <td class="ta-r jqtransform"></td>
                    </tr>
                    <tr class="blank">
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <th><?php echo Yii::t('enterprise', '店铺名称：'); ?><?php echo $store->name; ?></th>
                        <td class="ta-r jqtransform"></td>
                    </tr>
                    <tr class="blank">
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <th><?php echo Yii::t('enterprise', '公司名称：'); ?><?php echo $model->name; ?></th>
                        <td class="ta-r jqtransform"></td>
                    </tr>
                    <tr class="blank">
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <th><?php echo Yii::t('enterprise', '联系人：'); ?><?php echo $model->link_man; ?></th>
                        <td class="ta-r jqtransform"></td>
                    </tr>
                    <tr class="blank">
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <th><?php echo Yii::t('enterprise', '联系电话：'); ?><?php echo $model->link_phone; ?></th>
                        <td class="ta-r jqtransform"></td>
                    </tr>
                    <tr class="blank">
                        <td colspan="2">&nbsp;</td>
                    </tr>
                </tbody>
            </table>

            <br/>
            <span style="display:block;float:right;">
                <?php echo CHtml::link(Yii::t('enterprise', '查看资质电子档详情'), $this->createAbsoluteUrl('enterprise/view', array('id' => $model->id)), array('target' => '_blank', 'style' => 'color:red;text-align:right;')); ?>
            </span>

            <?php if ($role == Enterprise::AUDITING_ROLE_FAWU || $role == Enterprise::AUDITING_ROLE_ZHAOSHANG ): ?>
                <h3 class="mt15 tableTitle">&nbsp;</h3>
                <div class="c10"></div>
                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-reg3">
                    <tbody>
                        <tr>
                            <th>未通过审核原因<span class="red">（选择不通过审核时必填）：</span></th>
                        </tr>
                        <tr>
                            <td>
                                <textarea name="content" id="content" class="textareatxt"></textarea>
                            </td>
                        </tr>

                    </tbody>
                </table>
            <?php endif; ?>

            <div class="mt15 profileDo">
                <input type="hidden" name="status" id="status" value="<?php echo EnterpriseLog::STATUS_NOT_PASS; ?>" />
                <input type="button" value="<?php echo Yii::t('enterprise', '通过审核'); ?>" id="btnSignSubmit" class="btnSignSubmit" />&nbsp;&nbsp;
                <?php if ($role == Enterprise::AUDITING_ROLE_FAWU || $role == Enterprise::AUDITING_ROLE_ZHAOSHANG): ?>
                    <input type="button" value="<?php echo Yii::t('enterprise', '不通过审核'); ?>" id="btnSignBack" class="btnSignBack" />
                <?php endif; ?>
                    <div class="wantShare">
                        <a href=" <?php echo $this->createAbsoluteUrl('enterprise/keyReturn', array('id' => $model->id,'role'=>$role)); ?>" class='keyReturn'style='float: right;text-decoration:underline;text-align: center;line-height: 55px'>一键返回招商审核资质电子档&nbsp;&nbsp;<span id="clock" >?</span></a>
                        <div style="display:block" class="wantShareDetail">
                            <i class="m_icon_v arrow"></i>
                            <span style='font-weight: 700;font-size: 16px'>注意：</span>
                          
                            <p>“一键返回”后，商家将被关店，店铺以及商品有关信息禁止展示在商城网站的任何页面，以及网站搜索结果内。关店后原有已上传数据将冻结，待商家店铺在后续流程中再开店，将恢复展示原有数据。</p>
                        </div>
                    </div>
                
            </div>
        </form>
    </div>

</div>
<script type="text/javascript">
    $(function() {
        $('.jqtransform').jqTransform();

        $("input[name='errors[]']").change(function() {

            var word = '<?php echo Yii::t('enterprise', '不通过原因：提交的资料有误。有如下地方需要修改：'); ?>';
            var count = 0;

            $("input[name='errors[]']").each(function() {
                if ($(this).attr('checked') == 'checked') {
                    count++;
                    word = word + $(this).val() + "、";
                }
            });

            if (count > 0) {
                $("#content").html(word);

            } else {
                $("#content").html('');
            }

        });

        $("#btnSignSubmit").click(function() {
            $("#status").val("<?php echo EnterpriseLog::STATUS_PASS; ?>");
            $("#auditing_form").submit();
        });


        $("#btnSignBack").click(function() {
            $("#status").val("<?php echo EnterpriseLog::STATUS_NOT_PASS; ?>");
            if ($("#content").val() == '') {
                alert("请填写未通过审核原因！");
                return false;
            } else {
                $("#auditing_form").submit();
            }

            return false;
        });





    });



</script>
<script type="text/javascript">
    $(function() {
        $(".wantShare").hover(function() {
            $(".wantShareDetail").css({'display': "block"});
        }, function() {
            $(".wantShareDetail").css({'display': "none"});
        })
    })
    $(function() {
        $(".keyReturn").click(function() {
            if (!confirm("确认把该网签信息返回招商审核资质电子档步骤？"))
            {
                return false;
            }

        })
    })
</script>