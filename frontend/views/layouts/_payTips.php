<div id="tabs1">
    <div class="main1box">
        <?php echo $this->renderPartial($bankPay) ?>
        <div class="shopflPasswordBox">
            <dl class="clearfix">
                <dt><?php echo Yii::t('orderFlow', '盖网支付密码'); ?>：</dt>
                <dd>
                    <p>&nbsp;</p>
                    <p>
                        <input id="password3" type="password" name="password3" class="input_1"/>
                        <?php echo CHtml::link(Yii::t('orderFlow', '修改支付密码'), $this->createAbsoluteUrl('/member/member/password'), array('class' => 'shopflxgBtn', 'title' => Yii::t('orderFlow', '修改支付密码'))) ?>
                    <p>
                    <p><span id="error" class=""></span></p>
                </dd>
            </dl>
            <div class="do">
                <input type='button' name='button' onclick="paySubmit();" value='' class='shopflpaymentBtn'/>
            </div>
        </div>
    </div>
    <div class="shopflIntegraltitle"><font><?php echo Yii::t('orderFlow', '使用积分支付'); ?></font></div>
    <div class="shopflsamllTip">
        <b><?php echo Yii::t('orderFlow', '尊敬的盖网用户，在盖网支付订单，可有以下三种支付方式，请您按需选用：') ?></b>

        <p><?php echo Yii::t('orderFlow', '1、积分全额支付：在<font class="red">“选择积分支付”</font>前面方框点击，出现<font class="red">“√”</font>即可；') ?></p>

        <p><?php echo Yii::t('orderFlow', '2、现金全额支付：去除<font class="red">“选择积分支付”</font>前面方框内的<font class="red">“√”</font>，选择<font class="red">“环讯支付”</font>，进入<font class="red">“环讯支付”</font>页面，操作支付步骤；') ?></p>

        <p><?php echo Yii::t('orderFlow', '3、积分与现金共同支付（根据您的积分余额或您的意愿，进行积分与现金共同支付操作）：') ?></p>

        <p><?php echo Yii::t('orderFlow', '①点击<font class="red">“选择积分支付”</font>前面方框，出现<font class="red">“√”</font>；') ?></font></p>

        <p><?php echo Yii::t('orderFlow', '②输入您欲支付的积分数额，<font class="red">“实际付款”</font>会相应地告知您现金部分需支付的金额，需选择<font class="red">“环讯支付”</font>支付现金部分；') ?></p>

        <p><?php echo Yii::t('orderFlow', '③在<font class="red">“支付密码”</font>中输入您的积分支付密码，按<font class="red">“确认提交”</font>，页面“环讯支付”页面；') ?></p>

        <p><?php echo Yii::t('orderFlow', '④根据<font class="red">“环讯支付”</font>提示的操作流程完成支付步骤。') ?></p>
    </div>
</div>


<script>
    /*第一种形式 第二种形式 更换显示样式*/
    function setTabon(m, n) {
        var tli = document.getElementById("menu" + m).getElementsByTagName("li");
        var mli = document.getElementById("main" + m).getElementsByTagName("ul");
        for (i = 0; i < tli.length; i++) {
            tli[i].className = i == n ? "hover" : "";
            mli[i].style.display = i == n ? "block" : "none";
        }
    }

    //创建一个showhidediv的方法，直接跟ID属性
    function showhidediv(id) {
        var age = document.getElementById("shopflcomm_1");
        var name = document.getElementById("shopflcomm_2");
        if (id == 'name') {
            if (name.style.display == 'none') {
                age.style.display = 'none';
                name.style.display = 'block';
            }
        } else {
            if (age.style.display == 'none') {
                name.style.display = 'none';
                age.style.display = 'block';
            }
        }
    }

    var selectPay = function() {
        if ($('input[name="selectAccount"]').val()) {
            $('input[class="mgright5"]').attr('checked', true);
            $('input[name="selectAccount"]').attr({readonly: "readonly"});
        }
    }
</script>