<?php
$this->breadcrumbs = array('充值兑换管理', '生成批量充值');
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id . '-form',
    'method' => 'post',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        )));
?>
<style>
    li{
        padding: 5px;
    }    
    #box .hid{display:none;}
    #box .show{display:block;}
    select{
        border: 1px solid #CCC;
        line-height: 19px;
        padding: 3px 5px;
        font-family: "微软雅黑";
        border-radius: 3px;
        background: url(../images/bg-form-field.gif) repeat-x left top #FFF;
    }
    #importRecharge-form label{text-align: left;width:60px;display: inline-block;}
    #importRecharge-form .m1, #importRecharge-form .m3{width: 36px}
</style>
执行结果：总共有<span class="required" id="GWnum">0</span>个账号,总充值积分为:<span class="required" id="jifen">0</span> (成功后会以短信形式通知)
<ul id="box"> 
    <li><?php echo $form->labelEx($model, 'money',array('class' => 'm1')) ?>:
        <?php echo $form->textField($model, 'money', array('class' => 'text-input-bj jfs', 'onblur' => 'countM(this)')); ?>
        <?php echo $form->labelEx($model, 'mobile') ?>:
        <?php echo $form->textField($model, 'mobile', array('class' => 'text-input-bj  middle mb', 'maxLength' => '11', 'onblur' => 'findGW(this)')); ?>
        <?php echo $form->labelEx($model, 'gai_number',array('class' => 'm3')); ?>: 
        <?php echo $form->textField($model, 'gai_number', array('class' => 'text-input-bj middle', 'readonly' => 'true')); ?>
        <?php echo $form->error($model, 'money'); ?>
        <?php echo $form->error($model, 'mobile'); ?><br>
    </li>
    <?php
    if ($this->action->id == 'index'):
        foreach ($modelArr as $k => $rechange):
            ?>
            <li><?php echo $form->labelEx($rechange, 'money',array('class' => 'm1')) ?>:
                <?php echo $form->textField($rechange, "[arr][$k]money", array('class' => 'text-input-bj jfs', 'onblur' => 'countM(this)')); ?>
                <?php echo $form->labelEx($rechange, 'mobile') ?>:
                <?php echo $form->textField($rechange, "[arr][$k]mobile", array('class' => 'text-input-bj  middle mb', 'maxLength' => '11','numid'=>'num'.$k, 'onblur' => 'findGW(this)')); ?>
                <?php echo $form->labelEx($rechange, 'gai_number',array('class' => 'm3')); ?>:
                <?php echo $form->hiddenField($rechange, "[arr][$k]num", array('value' => '', 'id' => 'num'.$k)); ?>
                <?php echo $form->textField($rechange, "[arr][$k]gai_number", array('class' => 'text-input-bj middle gainum', 'readonly' => 'true')); ?>
                <?php echo $form->error($rechange, "[arr][$k]money"); ?>
                <?php echo $form->error($rechange, "[arr][$k]mobile"); ?><br>
            </li>
        <?php endforeach ?>        
    <?php endif ?>
</ul>
<!--<a href="#" id="tog">展开</a>-->
<input type="button" id="tog" value="显示更多"/>


<div>
    <br>
    <?php echo CHtml::submitButton('确定', array('class' => 'reg-sub', 'id' => 'but')) ?>    
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">

    var len = $("#box li").length;
    function int() {
        for (i = 5; i < len; i++) {
            $("#box li").eq(i).addClass("hid");
        }
    }
    $("#tog").click(function() {
        var t = $(this).val();
        if (t == "显示更多") {
            $("#box .hid").addClass("show");
            $(this).val("隐藏更多");
        } else {
            $("#box .hid").removeClass("show");
            $(this).val("显示更多");
        }
    });
    int();//初始化隐藏多余标签

    function countM(obj) {
//        var money = $(obj).val();
        var m = $('.jfs').filter(function () {
            return $(this).val() !== '';
        });
        var count = 0;
        m.each(function () {
            if ($(this).siblings('.jfs').val() !== '')
                count += parseInt(this.value);
        })

        $('#jifen').text(count);
    }

    function findGW(obj) {
        var mobile = $(obj).val();
        if (mobile === '') {
            $(obj).siblings('.gainum').replaceWith('<?php echo $form->textField($model, 'gaiNumber', array('class' => 'text-input-bj middle gainum', 'readonly' => 'true')); ?>');
            $(obj).siblings('#ImportRechargeRecord_gai_number').replaceWith('<?php echo $form->textField($model, 'gai_number', array('class' => 'text-input-bj middle', 'readonly' => 'true')); ?>');
            var g = $('.mb').filter(function () {
                return $(this).val() !== '';
            });
            $('#GWnum').text(g.length);
            return false;
        }
        
        var numid = $(obj).attr('numid');       

        var baseUrl = '<?php echo $this->createUrl('/importRecharge/findGW'); ?>';
        $.ajax({
            cache: false,
            dataType: 'json',
            url: baseUrl + '&mobile=' + mobile + '&YII_CSRF_TOKEN=' + '<?php echo Yii::app()->request->csrfToken ?>',
            success: function (data) {
//                console.log(data.length);
                if (data.length === 0) {
                    if ($(obj).siblings('#ImportRechargeRecord_gai_number').val() === '') {
                        alert('手机号码不存在，请重新输入');
                    } else if ($(obj).siblings('.gainum').val() === '') {
                        alert('手机号码不存在，请重新输入');
                    }
                    $(obj).siblings('.gainum').replaceWith('<?php echo $form->textField($model, 'gaiNumber', array('class' => 'text-input-bj middle gainum', 'readonly' => 'true')); ?>');
                    $(obj).siblings('#ImportRechargeRecord_gai_number').replaceWith('<?php echo $form->textField($model, 'gai_number', array('class' => 'text-input-bj middle', 'readonly' => 'true')); ?>');
                    return false;
                } else if (data.length > 1) {
//                        console.log(data);                        
                    var gnum = '';
                    gnum += '<select name="sel" id="ImportRechargeRecord_gai_number" >';
                    for (var v = 0; v < data.length; v++) {
                        gnum += '<option>' + data[v].gai_number + '</option>';
                    }
                    gnum += '</select>';
                    $(obj).siblings('#ImportRechargeRecord_gai_number').replaceWith(gnum);

                    var str = '';
                    str += '<select name="sels" class="gainum" onChange="setDemoTextVal(this.options[this.selectedIndex].text,\''+numid+'\')">';
                    for (var k = 0; k < data.length; k++) {
                        str += '<option value=' + data[k].gai_number + '>' + data[k].gai_number + '</option>';
                    }
                    str += '</select>';
                    $(obj).siblings('.gainum').replaceWith(str);
                    $('#'+numid).val(data[0].gai_number);
                   
                } else if (data.length = 1) {
                    $(obj).siblings('#ImportRechargeRecord_gai_number').replaceWith('<?php echo $form->textField($model, 'gai_number', array('class' => 'text-input-bj middle', 'readonly' => 'true')); ?>');
                    $(obj).siblings('#ImportRechargeRecord_gai_number').val(data[0].gai_number);
                    $(obj).siblings('.gainum').replaceWith('<?php echo $form->textField($model, 'gaiNumber', array('class' => 'text-input-bj middle gainum', 'readonly' => 'true')); ?>');
                    $(obj).siblings('.gainum').val(data[0].gai_number);
                }

                var g = $('.mb').filter(function () {
                    return $(this).val() !== '';
                });

                $('#GWnum').text(g.length);

                if ($(obj).siblings('.jfs').val() === '') {
                    alert('积分不能为空白');
                }
            }
        })
        
    }
    
    function setDemoTextVal(text,id)
    {
        $('#'+id).val(text);
    }
</script>


