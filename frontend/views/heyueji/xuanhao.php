<?php
/* @var $this HeyuejiController */
/* @var $form CActiveForm */
$goods = current($cartInfo['cartInfo']);
$goods = current($goods['goods']);
?>
<script src="<?php echo DOMAIN ?>/js/artDialog/jquery.artDialog.js?skin=aero" type="text/javascript"></script>
<script src="<?php echo DOMAIN ?>/js/artDialog/plugins/iframeTools.source.js" type="text/javascript"></script>
<div class="main">
    <div class="contPackage">
        <div class="step01"></div>
        <div class="selectedTitle clearfix">
            <div class="titLeft"><?php echo Yii::t('heyueji', '已选商品'); ?></div>
            <div class="titRigth"><?php echo Yii::t('heyueji', '您选择了'); ?><span class="colore80800">“<?php echo Yii::t('heyueji', '中国电信 - 购机入网送话费'); ?>”</span><?php echo Yii::t('heyueji', '的合约计划'); ?></div>
        </div>
        <div class="selectedProduct">
            <dl class="prodList clearfix">
                <dd class="clearfix">
                    <a href="<?php echo $this->createAbsoluteUrl('/goods/view', array('id' => $goods['goods_id'])); ?>" title="<?php echo $goods['name']; ?>" class="left" target="_blank">
                        <?php echo $goods['name']; ?>
                    </a>
                    <span class="right"><?php echo Yii::t('heyueji', '订单总额'); ?>：<b class="colore80800"><?php echo HtmlHelper::formatPrice($goods['price']+$this->freight); ?></b></span>
                </dd>
            </dl>
        </div>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'heyueji-form',
            'action' => $this->createAbsoluteUrl('/heyueji/createOrder', array('id' => $goods['goods_id'],'spec_id'=>$goods['spec_id'])),
            'method' => 'post',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>
        <!-- 套餐选择第一步 -->
        <div class="package">
            <div id="unp1" style="display: none;">
                <div class="pacgageTitle"><b>1</b><?php echo Yii::t('heyueji', '选择套餐'); ?><a href="javascript:;" class="selectRepeat" id="repeat1">[<?php echo Yii::t('heyueji', '重选') ?>]</a></div>
                <div class="packageList" id="finished1">
                    <div class="packageStep">
                        <ul class="clearfix">
                            <li><b><?php echo Yii::t('heyueji', '合约计划'); ?>：</b> <?php echo Yii::t('heyueji', '广东广州市|中国电信|“购机入网送话费”'); ?></li>
                            <li class="textCenter"><b><?php echo Yii::t('heyueji', '合约期'); ?>：</b><?php echo ($this->type == Heyue::NUMBER_3G) ? Yii::t('heyueji', '24个月') : Yii::t('heyueji', '48个月'); ?></li>
                            <li>
                                <p><b><?php echo ($this->type == Heyue::NUMBER_3G) ? Yii::t('heyueji', '套餐类型：乐享3G上网版') : Yii::t('heyueji', '套餐类型：新乐享4G套餐'); ?> — <span id="money"></span>（<?php echo Yii::t('heyueji', '每月最低消费'); ?><span id="money1"></span>元）</b></p>
                                <p> <?php echo Yii::t('heyueji', '赠送话费'); ?>：￥<span id="g1"></span>(<span id="des1"></span>）</p>
                                <p><?php echo Yii::t('heyueji', '通话'); ?>：<span id="duration"></span>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo Yii::t('heyueji', '短信'); ?>：<span id="msgNum"></span>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo Yii::t('heyueji', '上网流量'); ?>：<span id="flow"></span></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="p1">
                <div class="pacgageTitle"><b>1</b><?php echo Yii::t('heyueji', '选择套餐'); ?></div>
                <?php if ($this->type == Heyue::NUMBER_3G): ?>
                    <?php $this->renderPartial('_3gtaocan', array('taocan' => $taocan)); ?>
                <?php elseif ($this->type == Heyue::NUMBER_4G): ?>
                    <?php $this->renderPartial('_4gtaocan', array('taocan' => $taocan)); ?>
                <?php endif; ?>
            </div>
        </div>
        <!-- 套餐选择第二步 -->
        <div class="unpackage" id="unpackage2"><i>2</i><?php echo Yii::t('heyueji', '选择号码'); ?> </div>
        <div class="package" id="pt2" style="display: none">
            <div class="pacgageTitle"><b>2</b><?php echo Yii::t('heyueji', '选择号码'); ?><a href="javascript:;" class="selectRepeat" id="repeat2">[<?php echo Yii::t('heyueji', '重选'); ?>]</a></div>
            <div class="packageList" id="finished2">
                <div class="packageStep2">
                    <ul class="clearfix">
                        <li><b><?php echo Yii::t('heyueji', '选择号码'); ?>：</b><span class="colore80800" id="numberPhone"></span>（<?php echo Yii::t('heyueji', '盖网价'); ?>：<span id="numberPrice"></span>元，<?php echo Yii::t('heyueji', '包括话费'); ?>：<span id="numberHasfee"></span>元）<span class="colorf19149">  <?php echo Yii::t('heyueji', '号码选定后只为您保留15分钟。请您15分钟内提交订单'); ?></span></li>
                        <li class="textCenter"><b><?php echo Yii::t('heyueji', '入网首月资费') ?>：</b><?php echo Yii::t('heyueji', '广东电信后付费'); ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="p2" style="display: none">
            <div class="package">
                <div class="pacgageTitle"><b>2</b><?php echo Yii::t('heyueji', '选择号码'); ?></div>
                <div class="packageList">
                    <div class="packageAbout clearfix">
                        <ul class="clearfix">
                            <li>
                                <?php echo Yii::t('heyueji', '选择'); ?>：
                                <?php echo CHtml::dropDownList('number', '', Heyue::getHaoduan($this->type), array('onchange' => 'changeSelect()', 'empty' => '-号段-',)); ?>
                                <?php echo CHtml::dropDownList('rules', '', array('AA' => 'AA', 'CBA' => 'CBA'), array('onchange' => 'changeSelect()', 'empty' => '-靓号规则-')); ?>
                            </li>
                        </ul>
                    </div>
                    <?php $this->renderPartial('_number', array('phones' => $phones, 'pages' => $pages)); ?>               
                    <div class="feesWay clearfix">     
                        <div class="feesTitle"><b>入网首月资费方式：</b></div>
                        <div class="feesContent"><input type="radio" checked="checked" /><b><?php echo Yii::t('heyueji', '广东省电信后付费'); ?>，：</b>
                            <?php echo Yii::t('heyueji', '（1）号卡于签收后48小时内激活，激活后按照当月实际使用天数折算，如：月租/30天*使用天数。（流量/分钟数）/30天*使用天数（2）号卡全月施行出库处理。（3）购买了电信后付费产品用户，由于月初电信出账，导致用户可到营业厅或10000号申请提高信用透支额度，默认为0，可调整为月租1.5倍或更高。与信用卡相似。此类号卡预存费用不退还。
                            '); ?>
                        </div>
                        <p><a href="javascript:" class="confirmPhonenum" onclick="showNumber()"><?php echo Yii::t('heyueji', '确认手机号码'); ?></a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- 套餐选择第三步 -->
        <div class="unpackage" id="unpackage3"><i>3</i><?php echo Yii::t('heyueji', '填写个人信息'); ?></div>
        <div class="package" id="p3" style="display: none;">
            <div class="pacgageTitle"><b>3</b><?php echo Yii::t('heyueji', '选择套餐'); ?></div>
            <div class="packageList clearfix">
                <div class="packageAbout">
                    <ul class="clearfix">
                        <li>
                            <b><?php echo $form->labelEx($heyueji, 'username'); ?></b>
                            <?php echo $form->textField($heyueji, 'username', array('class' => 'tellName', 'placeholder' => Yii::t('heyueji', '请填写真实姓名'))); ?>
                        </li>
                        <li>
                            <b><?php echo $form->labelEx($heyueji, 'identityCard'); ?></b>
                            <?php echo $form->textField($heyueji, 'identityCard', array('class' => 'identityNum', 'placeholder' => Yii::t('heyueji', '请填写18位身份证号码'))); ?>
                        </li>
                        <li>
                            <?php echo $form->labelEx($heyueji, 'idPicture1'); ?>
                            <?php
//                            $this->widget('common.widgets.CUploadPic', array(
//                                'attribute' => 'idPicture1',
//                                'model' => $heyueji,
//                                'form' => $form,
//                                'num' => 1,
//                                'img_area' => 2,
//                                'btn_value'=> Yii::t('sellerGoods', '上传身份证正面图片'),
//                                'render' => '_upload',
//                                'folder_name' => 'ID',
//                                'include_artDialog' => true,
//                                'uploadUrl'=>'upload/index',
//                                'uploadSureUrl'=>'upload/sure',
//                            ));
                            ?>
                            <?php echo $form->fileField($heyueji,'idPicture1')?>
                            <a href="#" onclick="exampleID('images/example/idPicture1.jpg')">点击查看示例</a>
                            <?php echo $form->error($heyueji,'idPicture1') ?>
                        </li>
                        <li>
                            <?php echo $form->labelEx($heyueji, 'idPicture2'); ?>
                            <?php echo $form->fileField($heyueji,'idPicture2')?>
                            <a href="#" onclick="exampleID('images/example/idPicture2.gif')">点击查看示例</a>
                            <?php echo $form->error($heyueji,'idPicture2') ?>
                        </li>
                        <li>
                            <?php echo $form->labelEx($heyueji, 'idPicture3'); ?>
                            <?php echo $form->fileField($heyueji,'idPicture3')?>
                            <a href="#" onclick="exampleID('images/example/idPicture3.png')">点击查看示例</a>
                            <?php echo $form->error($heyueji,'idPicture3') ?>
                        </li>
						<li class="packageAboutLiLast">
                            <?php echo $form->checkBox($heyueji, 'readAndAgree'); ?>
                            <span class="color95"><?php echo Yii::t('heyueji', '我已阅读并同意') ?></span>
                            <b style="cursor: pointer;" onclick="showProtocol()">《<?php echo Yii::t('heyueji', '入网协议') ?>》</b>
                        </li>
                    </ul>
                </div>
                <div class="mustKnow">
                    <b style="font-size: 16px;"><?php echo Yii::t('heyueji', '购买须知'); ?>：</b>
                    <div class="aboutKnow" style="font-size: 12px;"> 
                        <p>1、<?php echo Yii::t('heyueji', '按照工信部通讯产品实名制要求，为保证用户的合法权益，请用户认真填写机主本人的姓名、身份证号，阅读、确认相关协议内容。实名制后，可凭借身份证方便在运营商营业厅办理各项业务。若冒用他人证件下单、恶意产生欠费的，我方将通过法律途径追责'); ?></p>
                        <p>2、<?php echo Yii::t('heyueji', '若因用户本身是运营商黑名单用户或是老客户资料不完善导致无法开户的，用户需要前往运营商营业厅解除黑名单限制或完善客户资料后并告知商城客服方可开户、发货，此类订单保留三天，超期将取消订单'); ?></p>
                        <p>3、<?php echo Yii::t('heyueji', '收货时请务必出示用户本人身份证原件及<span style="color:red">回收身份证复印件</span>，不能提供身份证复印件的用户，商城有权拒绝投递订单。配送员会提示您在相关单据上签字确认。以上资料，配送人员将回收并交付运营商妥善保存'); ?></p>
                    </div>
                </div>
                <div class="finishPackage clearfix">
                    <p>
                        <?php echo Yii::t('heyueji', '您已选择') ?>：
                        <b class="colore80800"> <?php echo Yii::t('heyueji', '广东广州市'); ?>；</b>
                        <?php echo ($this->type == Heyue::NUMBER_3G) ? Yii::t('heyueji', '在网24个月') : Yii::t('heyueji', '在网48个月') ?>，
                        <b class="colore80800"><span id="total99"></span>元/月</b> 合约；
                        <b class="colore80800"><?php echo ($this->type == Heyue::NUMBER_3G) ? Yii::t('heyueji', '乐享3G上网版套餐') : Yii::t('heyueji', '新乐享4G上网版套餐') ?>；
                        </b> <?php echo Yii::t('heyueji', '手机号码为') ?>：<b class="colore80800" id="totalPhone"></b>
                    </p>
                    <p class="totalMoney"><?php echo Yii::t('heyueji', '合约总金额'); ?>：<b class="colore80800"><?php echo HtmlHelper::formatPrice($goods['price']+$this->freight); ?></b>&nbsp;<?php if($this->freight > 0){echo Yii::t('heyueji','包含运费'.$this->freight);} ?></p>
                    <p class="clearfix">
                        <?php
                        echo Yii::t('heyueji','将寄送到默认收货地址：');
                        $as = $this->address;
                        echo implode(' ', array($as['province_name'], $as['city_name'], $as['district_name'], $as['street'], '(' . $as['real_name'] . ')', $as['mobile']));
                        ?>
                    </p>
                    <p class="clearfix"><?php echo CHtml::submitButton(Yii::t('heyueji', '去结算'), array('class' => 'goBtn', 'style' => 'cursor:pointer', 'onclick' => 'return check()')); ?></p>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial('//layouts/_msg'); ?>
<script>
    // 显示入网协议
    function showProtocol() {
        var url = "<?php echo $this->createAbsoluteUrl('/heyueji/showProtocol'); ?>";
        art.dialog.open(url, {title: '入网协议', lock: true, width: '1008px', height: '1194px'});
    }
    // 号段及规则修改
    function changeSelect() {
        var url = "<?php echo Yii::app()->request->hostInfo . Yii::app()->request->url; ?>";
        var number = $('select[name="number"]').val();
        var rules = $('select[name="rules"]').val();
        var number_type = '<?php echo $this->type; ?>';
        $.get(url, {'Heyue[number]': number, 'Heyue[rules]': rules, 'Heyue[number_type]': number_type}, function(json) {
            $('#packageDetail').html(json);
            if (json.length == 1230) {
                $('.feesWay').html('<font style="font-weight:bold;">亲，你来晚了哦，没有查到号码!</font>');
            } else {
                $('.feesWay').html('<div class="feesTitle"><b>入网首月资费方式：</b></div><div class="feesContent"><input type="radio" checked="checked" /><b><?php echo Yii::t("Heyue", "广东省电信后付费"); ?>，：</b><?php echo Yii::t("Heyue", "（1）号卡于签收后48小时内激活，激活后按照当月实际使用天数折算，如：月租/30天*使用天数。（流量/分钟数）/30天*使用天数（2）号卡全月施行出库处理。（3）购买了电信后付费产品用户，由于月初电信出账，导致用户可到营业厅或10000号申请提高信用透支额度，默认为0，可调整为月租1.5倍或更高。与信用卡相似。此类号卡预存费用不退还。"); ?></div><p><a href="javascript:" class="confirmPhonenum" onclick="showNumber();" id="aaa"><?php echo Yii::t("Heyue", '确认手机号码'); ?></a></p>');
            }
        });
    }
    function changeBg(obj) {
        $(obj).parent().parent().css('background-color', '#fffacd').siblings().css('background-color', '#fff');
    }
    //显示选择的套餐信息
    function showReturn() {
        var url = "<?php echo $this->createAbsoluteUrl('/heyueji/showTaocan'); ?>";
        var key = $('input[data-name="chk"]:checked').val();
        $.get(url, {'key': key, 'id':<?php echo  $goods['goods_id'] ?>},
        function(data) {
            var json = eval('(' + data + ')');
            $('#money').html(json.fee);
            $('#money1').html(json.fee);
            $('#total99').html(json.fee);
            $('#duration').html(json.duration);
            $('#msgNum').html(json.msgNum);
            $('#flow').html(json.flow);
            $('#g1').html(json.give);
            $('#des1').html(json.retCallRules);
        });
    }
    //显示已经选择的号码
    function showNumber() {
        var id = $('input[data-name="number"]:checked').val();
        var url = "<?php echo $this->createAbsoluteUrl('/heyueji/showNumber'); ?>";
        $.getJSON(url, {id: id}, function(data) {
            if (data.success) {
                $('#numberPhone').html('<b>' + data.number + '</b>');
                $('#totalPhone').html(data.number);
                $('#numberPrice').html(data.price);
                $('#numberHasfee').html(data.hasFee);
                $('#p2').hide();
                $('#pt2').show();
                $('#unpackage3').hide();
                $('#p3').show();
            } else {
                alert(data.error);
            }
        });
    }
</script>
<script>
    $(function() {
        /*套餐重选*/
        $('#repeat1').click(function() {
            $('#unp1').hide();
            $('#p1').show();
            $('#p2').hide();
        });
        /*号码重选*/
        $('#repeat2').click(function() {
            $('#pt2').hide();
            $('#p2').show();
            $('#p3').hide();
        });
        /*确认套餐*/
        $('.btnPackage').click(function() {
            $('#p1').hide();
            $('#unp1').show();
            $('#unpackage2').hide();
            $('#p2').show();
        });
    });

    /**
     * 检查信息公共弹出方法
     * @param {type} msg
     * @returns {undefined}
     */
    function checkInfo(msg) {
        art.dialog({
            lock: true,
            icon: 'warning',
            opacity: 0.1,
            content: msg,
            button: [{name: '关闭', focus: true}]
        });
    }

    /**
     * 提交信息检测
     * @returns {Boolean}
     */
    function check() {
        if ($('input[id="HeyuejiForm_username"]').val() == '') {
            checkInfo('姓名不能为空');
            return false;
        }else{
            var name = $('input[id="HeyuejiForm_username"]').val();
            flag = isChinese(name);
            if(!flag){
                checkInfo('请正确输入您的姓名');
                return false;
            }
        }
        if ($('input[id="HeyuejiForm_identityCard"]').val() == '') {
            checkInfo('身份证号不能为空');
            return false;
        } else {
            var number = $('input[id="HeyuejiForm_identityCard"]').val();
            flag = IdentityCodeValid(number);
            if (!flag) {
                checkInfo('请核对后重新输入身份证号码');
                return false;
            }
        }
        if ($('input[id="HeyuejiForm_readAndAgree"]:checked').length == 0) {
            checkInfo('需要勾选同意用户协议');
            return false;
        }
    }

    //身份证号合法性验证
    //支持15位和18位身份证号
    //支持地址编码、出生日期、校验位验证
    function IdentityCodeValid(code) {
        var city={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江 ",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北 ",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏 ",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外 "};
        var tip = "";
        var pass= true;

        if(!code || !/^[1-9][0-9]{5}(19[0-9]{2}|200[0-9]|2010)(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01])[0-9]{3}[0-9xX]$/i.test(code)){
            tip = "身份证号格式错误";
            pass = false;
        }

        else if(!city[code.substr(0,2)]){
            tip = "地址编码错误";
            pass = false;
        }
        else{
            //18位身份证需要验证最后一位校验位
            if(code.length == 18){
                code = code.split('');
                //∑(ai×Wi)(mod 11)
                //加权因子
                var factor = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2 ];
                //校验位
                var parity = [ 1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2 ];
                var sum = 0;
                var ai = 0;
                var wi = 0;
                for (var i = 0; i < 17; i++)
                {
                    ai = code[i];
                    wi = factor[i];
                    sum += ai * wi;
                }
                var last = parity[sum % 11];
                if(parity[sum % 11] != code[17]){
                    tip = "校验位错误";
                    pass =false;
                }
            }
        }
//            if(!pass) alert(tip);
        return pass;
    }
    //检验汉字
    function isChinese(s)
    {
        var patrn = /^\s*[\u4e00-\u9fa5]{1,15}\s*$/;
        if(!patrn.exec(s))
        {
            return false;
        }
        return true;
    }

    function exampleID(path){
        var www = '<?php echo DOMAIN ?>';
        var content = '<img src='+www+'/'+path+'>';
        art.dialog({
            lock: true,
            icon: 'warning',
            opacity: 0.1,
            content: content,
            button: [{name: '关闭', focus: true}]
        });
    }
</script>

