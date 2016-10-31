<?php
/** @var $this RechargeController */
/** @var $model Recharge */
$this->breadcrumbs = array(
    Yii::t('memberRecharge', '积分管理') => '',
    Yii::t('memberRecharge', '积分充值'),
);
?>
<div class="mbRight">
    <div class="left_1"><a class="curr"><?php echo Yii::t('memberRecharge', '积分充值'); ?></a></div>
    <div class="right_1"></div>
    <div class="mbRcontent">
        <div class="prompt mgtop20"><span class="promptIco"><?php echo Yii::t('memberRecharge', '为了保障您顺利充值，请尽量使用IE浏览器.'); ?></span></div>
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="mgtop20 upladBox"><h3><?php echo Yii::t('memberRecharge', '盖象商城充值中心'); ?></h3>

                    <p><?php echo Yii::t('memberRecharge', '积分充值'); ?></p></div>
                <div class="mgtop20 upladBox">
                    <?php
                    echo CHtml::button(Yii::t('memberRecharge', '充值卡充值'), array(
                        'onclick' => 'location="' . $this->createAbsoluteUrl('/member/prepaidCard/use') . '";',
                        'class' => 'integaralBtn2 mgleft30"',
                    ));
                    ?>
                    <?php echo CHtml::button(Yii::t('memberRecharge', '积分充值'), array('class' => 'integaralBtn1 mgleft30"',)); ?>
                </div>

            </div>
            <div class="mbDate1_b"></div>

        </div>

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">

                <div class="mgtop10 upladBox">
                    <span class="ingegralIcon1"></span><span class="ingegralTxt">
                        <?php echo Yii::t('memberRecharge', '填写充值的金额'); ?></span>
                    <span class="ingegralIcon4"></span><span class="ingegralIcon3"></span>
                    <span class="ingegralTxt"><?php echo Yii::t('memberRecharge', '选择支付方式'); ?></span>
                    <span class="ingegralIcon4"></span>
                    <span class="ingegralIcon2"></span>
                    <span class="ingegralTxt"><?php echo Yii::t('memberRecharge', '充值完成'); ?></span>
                </div>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => $this->id . '-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'afterValidate'=>"js:function(form, data, hasError){
                        if (!hasError) {
                           if($('.payMethodList:visible').length==0){
                                $('.payMethodList').remove();
                           }
                           return true;
                        }
                    }",
                    ),
                ));
                $model->money = 100;
                $model->score = Common::convertSingle('100', $this->getSession('typeId'));
                ?>

                <div class="mgtop40 upladBox">
                    <?php echo $form->labelEx($model, 'money', array('class' => 'w120')); ?>
                    <?php echo $form->textField($model, 'money', array('class' => 'integaralIpt1', 'placeholder' => '正整数')); ?>
                    <?php echo $form->error($model, 'money') ?>
                    <p class="gay95 mgleft55">
                        <?php
                        $tips = Yii::t('memberRecharge', '（￥100元 可以充值 {score}盖网积分）');
                        $tips = str_replace('{score}', $model->score, $tips);
                        echo $tips;
                        ?>
                    </p>
                </div>

                <div class="mgtop20 upladBox">
                    <?php echo $form->labelEx($model, 'score', array('class' => 'w120')); ?>
                    <?php echo $form->textField($model, 'score', array('class' => 'integaralIpt1', 'readOnly' => 'readOnley')); ?>
                </div>

                <div class="mgtop20 upladBox"  id="show_others">
                    <span class="fl mgtop5 w120"><?php echo Yii::t('memberRecharge', '充值GW号'); ?>&nbsp;&nbsp;</span>
                    <?php echo $form->textField($model, 'gai_number', array('class' => 'integaralIpt1')); ?>
                    <?php echo $form->error($model, 'gai_number') ?>
                    <p class="gay95 mgleft55">
                        <?php  echo  Yii::t('memberRecharge', '（GW号为空，则为自己充值）');  ?>
                    </p>
                </div>

                <div class="mgtop20 upladBox">
                    <span class="fl mgtop5">
					<?php echo $form->labelEx($model, 'verifyCode', array('class' => 'w120')); ?></span>
                    <?php echo $form->textField($model,'verifyCode',array('class'=>'integaralIpt2','style'=>'width:100px;')); ?>
                    <span>
                        <?php
                        $this->widget('CCaptcha', array(
                            'showRefreshButton' => false,
                            'clickableImage' => true,
                            'imageOptions' => array(
                                'title' => Yii::t('memberRecharge', '点击换图'),
                                'style' => 'height:32px;width:80px;padding:0 3px;cursor:pointer'
                            )
                        ));
                        ?>
                    </span>
                    <?php echo $form->error($model,'verifyCode') ?>
                </div>

                <div class="upladBox mgtop20 " >
                    <span class="fl  mgtop10 w120"><?php echo Yii::t('memberRecharge', '支付方式'); ?>&nbsp;&nbsp;</span>
                    <div class="payMethodList">
                        <input type="hidden" name="payType" value="<?php echo OnlinePay::PAY_UM_QUICK ?>"/>
                    <ul class="f1">
                        <?php
                        $cardList = PayAgreement::getCardList($this->getUser()->gw);
                        /** @var PayAgreement $v */
                        foreach($cardList as $v): ?>
                            <li class="clearfix" style="height: auto;">
                                <?php echo CHtml::radioButton('quickPay','',array('id'=>'quickPay_'.$v->id,'value'=>$v->id,'style'=>'float:left;margin:18px 0 0 5px;')) ?>
                                <label for="<?php echo 'quickPay_'.$v->id ?>">
                                <div class="<?php echo $v->bank ?> PMImg"></div>
                                <div class="PMNum">****<?php echo $v->bank_num ?></div>
                                <div class="PMType"><?php echo $v::getCardType($v->card_type) ?></div>
                                </label>
                            </li>
                        <?php endforeach; ?>
                        <?php echo $cardList?CHtml::link('不使用快捷支付','#',array('id'=>'otherPay','class'=>'red')):'' ?>
                    </ul>
                    </div>
                    <ul class="fl morePay" style="margin: 10px 5px;<?php echo $cardList?'display:none;':'' ?>">
                    <?php if($payConfig['ipsEnable']!='false'): ?>                        
                        <li class="clearfix">
							<label for="pay_type_1">
								<input name="Recharge[pay_type]" id="pay_type_1" type="radio"
								   value="<?php echo $model::PAY_TYPE_HUXUN ?>" checked class="ingegralIpt1"/>
								<span class="integaralXf1"></span>
								<div class="decTxt fl">
									<p class="bTit">环迅支付</p>
									<p></p>
								</div>
							</label>
						</li>
                    <?php endif; ?>
					
                    <?php if($payConfig['gneteEnable']!='false'): ?>                        
                        <li class="clearfix">
							<label for="pay_type_2">
								<input name="Recharge[pay_type]" id="pay_type_2" type="radio"
								   value="<?php echo $model::PAY_TYPE_YINLIANG ?>" class="ingegralIpt1"/>
								<span class="integaralXf2"></span>
								<div class="decTxt fl">
									<p class="bTit">银联支付</p>
									<p></p>
								</div>
							</label>
						</li>
                    <?php endif; ?>

                    <?php if($payConfig['bestEnable']!='false'): ?>                        
                        <li class="clearfix">
							<label for="pay_type_3">
								<input name="Recharge[pay_type]" id="pay_type_3" type="radio"
								   value="<?php echo $model::PAY_TYPE_YI ?>"  class="ingegralIpt1" checked/>
								<span class="integaralXf3"></span>
								<div class="decTxt fl">
									<p class="bTit">翼支付</p>
									<p></p>
								</div>
							</label>
						</li>
                    <?php endif; ?>

                    <?php if($payConfig['hiEnable']!='false'): ?>                        
                        <li class="clearfix">
							<label for="pay_type_4">
								<input name="Recharge[pay_type]" id="pay_type_4" type="radio"
								   value="<?php echo $model::PAY_TYPE_HI ?>" class="ingegralIpt1"/>
								<span class="integaralXf4"></span>
								<div class="decTxt fl">
									<p class="bTit">金掌柜</p>
									<p></p>
								</div>
							</label>
						</li>
                    <?php endif; ?>

                    <?php if($payConfig['umEnable']!='false'): ?>                       
                        <li class="clearfix">
							<label for="pay_type_5">
								<input name="Recharge[pay_type]" id="pay_type_5" type="radio"
								   value="<?php echo $model::PAY_TYPE_UM ?>" class="ingegralIpt1"/>
								<span class="integaralXf5"></span>
								<div class="decTxt fl">
									<p class="bTit">U付支付</p>
									<p></p>
								</div>
							</label>
						</li>
                    <?php endif; ?>
                    <?php if($payConfig['umQuickEnable']!='false'): ?>
                        <li class="clearfix">
                            <label for="pay_type_6">
                                <input name="Recharge[pay_type]" id="pay_type_6" type="radio"
                                       value="<?php echo $model::PAY_TYPE_UM_QUICK ?>" class="ingegralIpt1"/>
                                <span class="integaralXf5"></span>
                                <div class="decTxt fl">
                                    <p class="bTit">U付一键支付</p>
                                    <p>无需开通网银也能支付</p>
                                </div>
                            </label>
                        </li>
                    <?php endif; ?>
                    <?php if($payConfig['tlzfEnable']!='false'): ?>
                        <li class="clearfix">
                            <label for="pay_type_7">
                                <input name="Recharge[pay_type]" id="pay_type_7" type="radio"
                                       value="<?php echo $model::PAY_TYPE_TL ?>" class="ingegralIpt1"/>
                                <span class="integaralXf6"></span>
                                <div class="decTxt fl">
                                    <p class="bTit">通联支付</p>
                                    <p></p>
                                </div>
                            </label>
                        </li>
                    <?php endif; ?>
                        <li><?php echo $cardList?CHtml::link('使用快捷支付','#',array('id'=>'quickPay','class'=>'red')):'' ?></li>
					</ul>

                </div>

                <div class="upladBox">
                    <?php echo CHtml::submitButton(Yii::t('memberRecharge', '立即充值'), array('class' => 'integaralBtn4')) ?>
                </div>
                <?php $this->endWidget() ?>

            </div>
            <div class="mbDate1_b"></div>

        </div>

    </div>
</div>
<script>
    //Recharge_money
    $("#Recharge_money").keyup(function() {
        if (!$(this).val().match(/^[0-9]+?$/)) {
//            $(this).val('');
        } else {
            $("#Recharge_score").val();
            <?php
            $type = MemberType::fileCache();
             ?>
            var ratio = "<?php echo $type[$this->getSession('typeId')] ?>";
            $("#Recharge_score").val((this.value/ratio).toFixed(2));
        }
    });

    $(function(){
        $("input[name='quickPay']").first().attr('checked','checked');
    });
    $("#otherPay").click(function(){
        $(".morePay").show();
        $(".payMethodList").hide();
        return false;
    });
    $("#quickPay").click(function(){
        $(".morePay").hide();
        $(".payMethodList").show();
        return false;
    });


</script>
