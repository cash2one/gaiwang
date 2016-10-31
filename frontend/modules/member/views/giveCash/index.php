<?php
/* @var $this GiveCashController */
/* @var $model GiveCashForm */
/* @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberGiveCash', '账户管理'),
    Yii::t('memberGiveCash', '派发红包'),
);
?>

<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberGiveCash', '派发红包') ?></span></a>
            </li>
        </ul>
    </div>
    <div class="mbRcontent">

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => $this->id . '-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
                <table width="890" border="0" cellpadding="0" cellspacing="0" class="tableBank">
                    <tr>
                        <td width="130" height="50" align="right" class="dtEe">
                            <b><?php echo Yii::t('memberGiveCash', '红包余额'); ?>：</b>
                        </td>
                        <td height="50" colspan="2" class="pdleft20" id="ownMoney">
                            ￥<span data-cash="<?php echo $importMember['cash'] ?>"><?php echo $importMember['cash'] ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="130" height="50" align="right" class="dtEe">
                            <b><?php echo Yii::t('memberGiveCash', '接收人手机号'); ?>：</b>
                        </td>
                        <td height="50" colspan="2" class="pdleft20">
                            <?php echo $form->textField($model, 'mobile', array(
                                'class' => 'integaralIpt1',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('/member/giveCash/findGw'),
                                    'dataType' => 'json',
                                    'data' => array(
                                        'mobile' => 'js:this.value',
                                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                    ),
                                    'success' => 'function(data) {
                                     $("#GiveCashForm_gai_number").html(data.dropDownGW);
                                }',
                                ),
                            )) ?>
                            <?php echo $form->error($model, 'mobile') ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="130" height="50" align="right" class="dtEe">
                            <b><?php echo Yii::t('memberGiveCash', '盖网编号'); ?>：</b>
                        </td>
                        <td height="50" colspan="2" class="pdleft20">
                            <?php echo $form->dropDownList($model, 'gai_number', array(), array('prompt' => Yii::t('memberGiveCash', '请先输入手机号码'),)) ?>
                            <?php echo $form->error($model, 'gai_number') ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="130" height="50" align="right" class="dtEe">
                            <b><?php echo Yii::t('memberGiveCash', '派发金额'); ?>：</b>
                        </td>
                        <td height="50" colspan="2" class="pdleft20">
                            <?php echo $form->textField($model, 'cash', array('class' => 'integaralIpt1')) ?>￥
                            <?php echo $form->error($model, 'cash') ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="130" height="50" align="right" class="dtEe">
                        </td>
                        <td colspan="2">
                            <a href="#" id="addInfo" class="mbDateqd_1 mgleft45 edit"><?php echo Yii::t('memberGiveCash','添加'); ?></a>
                            (<?php echo Yii::t('memberGiveCash','最多可以添加10条'); ?>)
                            <table id="dataTable" style="margin: 20px 0 10px 100px;display: none" width="300"
                                   cellpadding="5" cellspacing="0">
                                <tr>
                                    <th><?php echo Yii::t('memberGiveCash','手机号'); ?></th>
                                    <th><?php echo Yii::t('memberGiveCash','盖网编号'); ?></th>
                                    <th><?php echo Yii::t('memberGiveCash','派发金额'); ?></th>
                                    <th><?php echo Yii::t('memberGiveCash','操作'); ?></th>
                                </tr>
                            </table>
                            <input type="hidden" id="totalMoney" value="0"/>
                        </td>
                    </tr>

                    <tr>
                        <td width="130" height="50" align="right" class="dtEe">
                            <b><?php echo Yii::t('memberGiveCash', '手机验证码'); ?>：</b>
                        </td>
                        <td height="50" colspan="2" class="pdleft20">
                            <?php echo $form->textField($model, 'mobileVerifyCode', array('class' => 'integaralIpt1')) ?>
                            <a href="#" class="sendCode02" style="float: left" id="sendMobileCode">
                                <span data-status="1"><?php echo Yii::t('memberMember', '获取验证码'); ?></span>
                            </a>
                            <?php echo $form->error($model, 'mobileVerifyCode') ?>
                        </td>
                    </tr>
                </table>


                <div class="clearfix">
                    <?php echo CHtml::link('提交', '', array('class' => 'integralQdBtn')); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
            <div class="mbDate1_b"></div>
        </div>

    </div>
</div>
<?php echo $this->renderPartial('/home/_sendMobileCodeJs'); ?>
<script type="text/javascript">
    $(function () {
        sendMobileCode2("#sendMobileCode");
    });
    $(".integralQdBtn").click(function () {
        $("form").submit();
    });
    /**
     * 动态添加数据
     */
    $("#addInfo").click(function () {
        if($("#dataTable tr").length>10){
            alert("<?php echo Yii::t('memberGiveCash','最多可以添加10条'); ?>");
            return false;
        }
        if ($("#" + $('#GiveCashForm_gai_number').val()).get(0)) {
            alert("<?php echo Yii::t('memberGiveCash','已经添加了'); ?>" + $('#GiveCashForm_gai_number').val());
            return false;
        }
        $.ajax({
            dataType: 'json',
            type: 'post',
            data: {
                "GiveCashForm[mobile]": $('#GiveCashForm_mobile').val(),
                "GiveCashForm[cash]": $('#GiveCashForm_cash').val()*1+$('#totalMoney').val()*1,
                "GiveCashForm[gai_number]": $('#GiveCashForm_gai_number').val(),
                "YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
                "ajax": "giveCash-form"
            },
            success: function (data) {
                delete data.GiveCashForm_mobileVerifyCode; //删除最后一个验证码的报错
                if ($.isEmptyObject(data)) {
                    var trHtml = '<tr id="' + $('#GiveCashForm_gai_number').val() + '">';
                    trHtml += '<td>' + $('#GiveCashForm_mobile').val() + '</td>';
                    trHtml += '<td>' + $('#GiveCashForm_gai_number').val() + '</td>';
                    trHtml += '<td>￥' + $('#GiveCashForm_cash').val() + '</td>';
                    trHtml += '<td>' +
                        '<input type="hidden" name="gai_number['+$('#GiveCashForm_gai_number').val()+']" ' +
                        'value="'+$('#GiveCashForm_cash').val()+'"/><a href="#" class="delInfo"><?php echo Yii::t('memberGiveCash','删除'); ?></a></td>';
                    trHtml += '</tr>';

                    $("#dataTable").show();
                    $("#dataTable tr:last").after(trHtml);
                    $("#totalMoney").val(function () {
                        return this.value*1 + $('#GiveCashForm_cash').val()*1;
                    });
                    $("#ownMoney span").html(function(){
                        return ($(this).attr('data-cash')*1 - $("#totalMoney").val()*1).toFixed(2);
                    });
                } else {
                    //显示错误信息
                    $(".errorMessage").hide();
                    for (var x in data) {
                        if (x == 'GiveCashForm_mobileVerifyCode') continue;
                        $("#" + x + "_em_").show().html(data[x][0]);
                    }
                }
            }
        });

    });
    /**
     * 删除
     */
    $("form .delInfo").live('click', function () {
        //返钱
        var money = $(this).parent().find('input').val();
        $("#ownMoney span").html(function(index,value){
            return (value*1 + money*1).toFixed(2);
        });
        $("#totalMoney").val(function(){
            return this.value - money;
        });
        $(this).parent().parent().remove();
        return false;
    });

</script>