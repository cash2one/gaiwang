
  	<!--主体start-->  	
      <div class="main-contain">  
        <div class="withdraw-contents">
        	<div class="crumbs crumbs-en">
              <span><?php echo Yii::t('memberWealth', '您的位置') ?>：</span>
              <a><?php echo Yii::t('memberWealth', '企业管理') ?></a>
              <span>&gt</span>
              <a><?php echo Yii::t('memberWealth', '申请提现') ?></a>
            </div>
            <?php

                $form = $this->beginWidget('ActiveForm', array(
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
                <?php 
                    $numberStr=$cashSetting['applyCashGwnumbers'];
                    $numberArr=explode(',', $numberStr);
                    if(in_array($gai_number,$numberArr)){
                       $cashSetting['applyCashUnit']=0; 
                    } 
                 ?>
            <div class="accounts-box">
                <p class="accounts-title cover-icon"><?php echo Yii::t('memberWealth', '申请提现') ?></p>
                <div class="apply-box">
                    <p><span class="apply-left">
                     <?php echo Yii::t('memberApplyCash', '公司名称'); ?>：</span>
                           <?php echo Yii::t('memberApplyCash', $enterprise->name); ?>
                     <span class="apply-message">
                      (<?php echo Yii::t('memberApplyCash', '最小提现金额'); ?>:
                            <?php echo HtmlHelper::formatPrice(null).$cashSetting['applyCashUnit'] ?>,
                            <?php echo Yii::t('memberApplyCash', '手续费'); ?>:
                            <?php echo $cashSetting['applyCashFactorage'] ?>%,
                            <?php
                            echo CHtml::link(Yii::t('memberApplyCash','账户明细'), $this->createAbsoluteUrl('/member/enterprise/enterpriseCashDetail'));
                            ?>
                            )
                     </span></p>
                    <p><span class="apply-left"><?php echo Yii::t('memberWealth', '商家收益') ?>：</span>
                    <span class="apply-money"><?php echo HtmlHelper::formatPrice(null); ?></span>
                    <input onclick="updateMoney('CashHistory_money',-1)" type="button" class="btn-add" value="-" />
                    <?php
                            echo $form->textField($model, 'money', array(
                                'class' => 'input-business',
                                'value' => 0,
                                'data-maxMoney' => $businessAccount,
                                'data-factorage' => $cashSetting['applyCashFactorage'],
                                'data-applyCashUnit' => $cashSetting['applyCashUnit'],
                            ));
                            ?>
                   <input onclick="updateMoney('CashHistory_money',1)" type="button" class="btn-less" value="+" />  （<?php echo Yii::t('memberWealth', '账号余额') ?>：<?php echo HtmlHelper::formatPrice(null).$businessAccount; ?>）
                            
                    </p>
                    <p>
                    <span class="apply-left"><?php echo Yii::t('memberWealth', '代理收益') ?>：</span>
                    <span class="apply-money"><?php echo HtmlHelper::formatPrice(null); ?></span>
                     <input onclick="updateMoney('CashHistory_agentMoney',-1)" type="button" class="btn-add" value="-" />
                        <?php
                            echo $form->textField($model, 'agentMoney', array(
                                'class' => 'input-proxy',
                                'value' => 0,
                                'data-maxMoney' => $agentAccount,
                                'data-factorage' => $cashSetting['applyCashFactorage'],
                                'data-applyCashUnit' => $cashSetting['applyCashUnit'],
                            ));
                            ?>
                     <input onclick="updateMoney('CashHistory_agentMoney',1)" type="button" class="btn-less" value="+" />（<?php echo Yii::t('memberWealth', '账号余额') ?>：<?php echo HtmlHelper::formatPrice(null).$agentAccount; ?>）
                    </p>
                    <p><span class="apply-left"><?php echo Yii::t('memberWealth', '手续费') ?>：</span>
                    <span class="apply-money"><?php echo HtmlHelper::formatPrice(null); ?></span>
                    <?php echo $form->textField($model, 'factorage', array('readOnly' => 'true', 'class' => 'input-fee', 'value' => 0));?>
                    </p>
                    <p><span class="apply-left"><?php echo Yii::t('memberWealth', '实扣金额') ?>：</span>
                    <span class="apply-money"><?php echo HtmlHelper::formatPrice(null); ?></span>
                      <?php echo $form->textField($model, 'score', array('readOnly' => 'true', 'class' => 'input-real', 'value' => 0));?>
                      <?php echo Yii::t('memberApplyCash', ' (自2013年1月12日起， 提现手续费收费比例下调,具体标准按签约合同附件中条款执行)')?>
                    </p>
                    <p><span class="apply-left"><i>*</i><?php echo $form->label($model, 'bank_name'); ?>：</span><?php echo $model->bank_name; ?></p>
                    <p><span class="apply-left"><i>*</i><?php echo $form->label($model, 'account'); ?>：</span><?php echo $model->account ?><span class="apply-message">(<?php echo Yii::t('memberApplyCash', '如需修改银行账户信息，请联系盖网客服'); ?>)</span></p>
                    <p><span class="apply-left"><i>*</i><?php echo $form->label($model, 'account_name'); ?>：</span><?php echo $model->account_name ?></p>
                    <p><span class="apply-left"><?php echo Yii::t('memberApplyCash', '银行所在地区'); ?>：</span><?php echo $model->bank_address ?></p>
                    <p class="apply-btn"><input id="submitCash" name="" type="button" value="<?php echo Yii::t('memberWealth', '确认提交') ?>" class="btn-deter" /></p>
                </div>
            </div>
         <?php $this->endWidget(); ?>
        
      </div>      
    </div>  
    <!-- 主体end -->
  <script>
    $("#submitCash").click(function() {
        if($(this).html()!='正在提交…'){
            $("#enterprise-form").submit();
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
        	layer.alert('<?php echo Yii::t('memberApplyCash', '请输入正确金额') ?>',{icon:2});
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
               if(applyCashUnit>maxMoney){
            	   layer.alert('<?php echo Yii::t('memberApplyCash', '账户金额不足，不能体现') ?>',{icon:2});
                  }else{
                   layer.alert("<?php echo Yii::t('memberApplyCash', '提现最小金额为:') ?>" + applyCashUnit,{icon:2});
                  }
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
            layer.alert("<?php echo Yii::t('memberApplyCash', '本次最多可以提现：') ?>" + totalMaxMoney,{icon:2});
        }
        $("#CashHistory_factorage").val((getTotalMoney() * factorage / 100).toFixed(2));
        $("#CashHistory_score").val((getTotalMoney() + parseFloat($("#CashHistory_factorage").val())).toFixed(2));

    }
</script>
  