<?php
/* @var $this EnterpriseApplyCashController */
/* @var $enterprise Enterprise */
/* @var $model CashHistory */
/* @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberApplyCash', '账户管理'),
    Yii::t('memberApplyCash', '申请提现'),
);

// 商家线下未对账订单供货价总额
//$money = Member::unreconciledCash($this->getUser()->id);
?>
<script src="<?php echo DOMAIN.'/js/jquery.blockUI.js'?>"></script>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberApplyCash', '申请提现') ?></span></a></li>
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
                        'afterValidate' => "js:function(form, data, hasError){
                        if (!hasError) {
                          $('.integralQdBtn').html('正在提交…');
                          $.blockUI({ message: '<div class=\"pay-tip\"><p>正在处理中,请稍候...</p></div>' });
                           return true;
                        }
                    }
                    ",
                    ),
                ));
                ?>
                <table width="890" border="0" cellpadding="0" cellspacing="0" class="tableBank">
                    <tr>
                        <td width="130" height="50" align="right" class="dtEe">
                            <b><?php echo Yii::t('memberApplyCash', '公司名称'); ?>：</b>
                        </td>
                        <td height="50" colspan="2" class="pdleft20"><?php echo $enterprise->name ?></td>
                    </tr>
                    <tr>
                        <td width="130" height="50" align="right" class="dtEe">
                        </td>
                        <td height="50" colspan="2" class="pdleft20">
                            (<?php echo Yii::t('memberApplyCash', '最小提现金额'); ?>:
                            <?php echo HtmlHelper::formatPrice(null).$cashSetting['applyCashUnit'] ?>,
                            <?php echo Yii::t('memberApplyCash', '手续费'); ?>:
                            <?php echo $cashSetting['applyCashFactorage'] ?>%,
                            <?php
                            echo CHtml::link(Yii::t('memberApplyCash','账户明细'), $this->createAbsoluteUrl('/member/wealth/EnterpriseCashDetail'), array('class' => 'ftstyle mgleft5'));
                            ?>
                            )
                        </td>
                    </tr>
                    <tr>
                        <td width="130" height="50" align="right" class="dtEe">
                            <b><?php echo Yii::t('memberApplyCash', '商家收益'); ?>：</b>
                        </td>
                        <td height="50" colspan="2" valign="middle" class="pdleft20">
                            <?php
                            echo $form->textField($model, 'money', array(
                                'class' => 'editinput140 mgright5 cashMoney',
                                'value' => 0,
                                'data-maxMoney' => $businessAccount,
                                'data-factorage' => $cashSetting['applyCashFactorage'],
                                'data-applyCashUnit' => $cashSetting['applyCashUnit'],
                            ));
                            ?>
                            <div class="mgtop5">
                                <span >
                                    <?php echo HtmlHelper::formatPrice(null); ?>
                                    <a style="font-size: 20px" href="javascript:updateMoney('CashHistory_money',-1)" class="red">-</a>
                                    <a style="font-size: 20px" href="javascript:updateMoney('CashHistory_money',1)" class="red">+</a>(
                                    <?php echo Yii::t('memberApplyCash', '账户余额'); ?>:
                                    <b class="cash"><?php echo HtmlHelper::formatPrice(null).$businessAccount; ?> </b>)
                                </span>
                            </div>
                            <div style="clear: both;position: relative">
                                <?php echo $form->error($model, 'money') ?>
                            </div>
                        </td>

                    </tr>
                    <tr>
                        <td width="130" height="50" align="right" class="dtEe">
                            <b><?php echo Yii::t('memberApplyCash', '代理收益'); ?>：</b>
                        </td>
                        <td height="50" colspan="2" valign="middle" class="pdleft20">
                            <?php
                            echo $form->textField($model, 'agentMoney', array(
                                'class' => 'editinput140 mgright5 cashMoney',
                                'value' => 0,
                                'data-maxMoney' => $agentAccount,
                                'data-factorage' => $cashSetting['applyCashFactorage'],
                                'data-applyCashUnit' => $cashSetting['applyCashUnit'],
                            ));
                            ?>
                            <div class="mgtop5">
                                <span>
                                    <?php echo HtmlHelper::formatPrice(null); ?>
                                    <a style="font-size: 20px" href="javascript:updateMoney('CashHistory_agentMoney',-1)" class="red">-</a>
                                    <a style="font-size: 20px" href="javascript:updateMoney('CashHistory_agentMoney',1)" class="red">+</a>
                                </span>
                                (<?php echo Yii::t('memberApplyCash', '账户余额'); ?>:
                                <b class="cash"><?php echo HtmlHelper::formatPrice(null).$agentAccount; ?> </b>)
                            </div>
                            <div style="clear: both;position: relative">
                                <?php echo $form->error($model, 'agentMoney') ?>
                            </div>
                        </td>

                    </tr>
                    <tr>
                        <td width="130" height="50" align="right" class="dtEe">
                            <b><?php echo Yii::t('memberApplyCash', '手续费'); ?>：</b>
                        </td>
                        <td height="50" colspan="2" valign="middle" class="pdleft20">
                            <?php echo $form->textField($model, 'factorage', array('readOnly' => 'true', 'class' => 'editinput140 mgright5', 'value' => 0));
                            ?>
                            <div class="mgtop5">
                                <?php echo HtmlHelper::formatPrice(null).Yii::t('memberApplyCash', ' (自2013年1月12日起， 提现手续费收费比例下调，
                                具体标准按签约合同附件中条款执行)'); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="130" height="50" align="right" class="dtEe">
                            <b><?php echo Yii::t('memberApplyCash', '实扣金额'); ?>：</b>
                        </td>
                        <td height="50" colspan="2" valign="middle" class="pdleft20">
                            <?php echo $form->textField($model, 'score', array('readOnly' => 'true', 'class' => 'editinput140 mgright5', 'value' => 0));
                            ?>
                            <?php echo HtmlHelper::formatPrice(null); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="130" height="50" align="right" class="dtEe">
                            <b><?php echo $form->labelEx($model, 'bank_name'); ?>：</b>
                        </td>
                        <td height="50" colspan="2" valign="middle" class="pdleft20">
                            <?php echo $model->bank_name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="130" height="50" align="right" class="dtEe">
                            <b><?php echo $form->labelEx($model, 'account'); ?>：</b>
                        </td>
                        <td height="50" colspan="2" valign="middle" class="pdleft20">
                            <div>
                            <?php echo $model->account ?>  (<?php echo Yii::t('memberApplyCash', '如需修改银行账户信息，请联系盖网客服'); ?>)
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="130" height="50" align="right" class="dtEe">
                            <b><?php echo $form->labelEx($model, 'account_name'); ?>：</b>
                        </td>
                        <td height="50" colspan="2" valign="middle" class="pdleft20">
                            <?php echo $model->account_name ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="130" height="50" align="right" class="dtEe">
                            <b><?php echo Yii::t('memberApplyCash', '银行所在地区'); ?>：</b>
                        </td>
                        <td height="50" colspan="2" valign="middle" class="pdleft20">
                            <?php echo $model->bank_address ?>
                        </td>
                    </tr>

                </table>

                <div class="clearfix">
                    <?php echo CHtml::link(Yii::t('memberApplyCash', '确定提交'), '', array('class' => 'integralQdBtn')); ?>
                </div>
                <?php $this->endWidget(); ?>


            </div>
            <div class="mbDate1_b"></div>

        </div>

    </div>
</div>
<script>
    $(".integralQdBtn").click(function() {
        if($(this).html()!='正在提交…'){
            $("form").submit();
        }
    });
    $("#CashHistory_money").change(function() {
        updateMoney('CashHistory_money', 0);
    });
    $("#CashHistory_agentMoney").change(function() {
        updateMoney('CashHistory_agentMoney', 0);
    });
    /**
     * 计算最大可提现金额
     * @param money 总金额
     * @param factorage 手续费率
     */
    function maxApplyMoney(money, factorage) {
        return money - money * factorage / 100;
    }
    /**
     * 所有账户的提现金额
     */
    function getTotalMoney() {
        return parseFloat($("#CashHistory_money").val()) + parseFloat($("#CashHistory_agentMoney").val());
    }
    /**
     * 更新兑现积分显示
     * @param count 1,-1,0
     * @returns {boolean}
     */
    function updateMoney(id, count) {
        var $moneyObj = $('#' + id);
        var money = parseFloat($moneyObj.val());//当前体现金额
        var maxMoney = parseFloat($moneyObj.attr('data-maxMoney')); //当前账户余额
        var factorage = parseFloat($moneyObj.attr('data-factorage')); //手续费率
        var applyCashUnit = parseFloat($moneyObj.attr('data-applyCashUnit')); //最小提现金额
        if (isNaN(money)) {
            art.dialog({
                icon: 'error',
                content: '<?php echo Yii::t('memberApplyCash', '请输入正确金额') ?>',
                ok: true,
                lock: true
            });
            return false;
        }
        if (count == 1) {
            money += applyCashUnit;
        } else if (count == -1) {
            money -= applyCashUnit;
        }
        if (money < 0)
            money = 0;
        if (money > maxMoney)
            money = maxMoney;
        if (money > maxApplyMoney(maxMoney, factorage)) {
            money = maxApplyMoney(maxMoney, factorage);
        }
        if (money < applyCashUnit) {
            money = 0;
            alert("<?php echo Yii::t('memberApplyCash', '提现最小金额为:') ?>" + applyCashUnit);
        }
        $moneyObj.val(money.toFixed(2));
        var totalMoney = getTotalMoney();
        var totalMaxMoney = parseFloat($("#CashHistory_money").attr('data-maxMoney')) +
                parseFloat($("#CashHistory_agentMoney").attr('data-maxMoney'));
        totalMaxMoney = (totalMaxMoney - (totalMaxMoney * factorage / 100).toFixed(2)).toFixed(2); //扣除手续费+冻结金额后，本次最大提现金额
        var otherMoney = 0; //其他两个账户的余额
        $(".cashMoney").each(function() {
            if (this.value != $moneyObj.val()) {
                otherMoney += parseFloat(this.value);
            }
        });
        if (totalMoney > totalMaxMoney && totalMoney > 0) {
            $moneyObj.val((totalMaxMoney - otherMoney));
            alert("<?php echo Yii::t('memberApplyCash', '本次最多可以提现：') ?>" + totalMaxMoney);
        }
        $("#CashHistory_factorage").val((getTotalMoney() * factorage / 100).toFixed(2));
        $("#CashHistory_score").val((getTotalMoney() + parseFloat($("#CashHistory_factorage").val())).toFixed(2));

    }
</script>
