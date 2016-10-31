<?php
$bankArr=array(
    //借记卡(储蓄卡)
    'jjBank'=>array(
        'CCB'=>'DEBITCARD|CCB',//建设银行
        'ABC'=>'DEBITCARD|ABC',//农业银行
        'BOC'=>'DEBITCARD|BOC',//中国银行
        'CITIC'=>'DEBITCARD|CITIC',//中信银行
        'CEB'=>'DEBITCARD|CEB',//光大银行
        'CIB'=>'DEBITCARD|CIB',//兴业银行
    ),
    //信用卡
    'xyBank'=>array(
        'ICBC'=>'CREDITCARD|ICBC',//工商银行,
        'CCB'=>'CREDITCARD|CCB',//建设银行,
        'ABC'=>'CREDITCARD|ABC',//工商银行,
        'BOC'=>'CREDITCARD|BOC',//中国银行,
        'ICBC'=>'CREDITCARD|ICBC',
        'CITIC'=>'CREDITCARD|CITIC',
        'PSBC'=>'CREDITCARD|PSBC',
        'CEB'=>'CREDITCARD|CEB',
        'CMB'=>'CREDITCARD|CMB',
        'CMBC'=>'CREDITCARD|CMBC',
        'HXB'=>'CREDITCARD|HXB',//华夏银行,
        'GDB'=>'CREDITCARD|GDB',//工商银行,
        'SPDB'=>'CREDITCARD|SPDB',//浦发银行,
        'SHB'=>'CREDITCARD|SHB',//上海银行,
        'BJB'=>'CREDITCARD|BJB',//北京银行,
        'BEA'=>'CREDITCARD|BEA',//东亚银行,
        'NBB'=>'CREDITCARD|NBB',//兴业银行,
        'BSB'=>'CREDITCARD|BSB',
        'CSCB'=>'CREDITCARD|CSCB',
        'CDB'=>'CREDITCARD|CDB',
        'CDRCB'=>'CREDITCARD|CDRCB',
        'CRCB'=>'CREDITCARD|CRCB',
        'CQB'=>'CREDITCARD|CQB',
        'CIB'=>'CREDITCARD|CIB',
    )

);

$banks = array(
'ICBC '=>array('jie'=>1,'xin'=>1),
'ABC'=>array('jie'=>1,'xin'=>1),
'BOC'=>array('jie'=>1,'xin'=>1),
'CCB '=>array('jie'=>1,'xin'=>1),
'PAB'=>array('jie'=>1,'xin'=>1,),
'CIB  '=>array('jie'=>1,'xin'=>1),
'CEB'=>array('jie'=>1,'xin'=>1),
'SPDB'=>array('jie'=>1,'xin'=>1),
'HXB '=>array('jie'=>1,'xin'=>1),
'BOB'=>array('jie'=>1,'xin'=>1),
'CMB'=>array('jie'=>0,'xin'=>1),
'CMBC '=>array('jie'=>0,'xin'=>1),
'ECITIC '=>array('jie'=>0,'xin'=>1),
'SHB'=>array('jie'=>0,'xin'=>1),
'PSBC'=>array('jie'=>0,'xin'=>1),
'GDB'=>array('jie'=>0,'xin'=>1),
);

//建设银行 CCB
//农业银行 ABC
//工商银行 ICBC
//中国银行 BOC
//交通银行 BCOM
//浦发银行 SPDB
//光大银行 CEB
//平安银行 PAB
//兴业银行 CIB
//邮政储蓄 PSBC
//中信银行 ECITIC
//华夏银行 HXB
//招商银行 CMB
//广发银行 GDB
//北京银行 BOB
//上海银行 SHB
//民生银行 CMBC
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery-1.9.1.js',CClientScript::POS_HEAD);
$umCode=$this->getParam('code') ? $this->getParam('code') : '1';
$retUrl=$this->createAbsoluteUrl('quickPay/bindCard',array('code'=>$umCode));
//$this->renderPartial('_bankList',array('code'=>$umCode));
$param=array(
    'service'=>'bind_req_shortcut_front',
    'charset'=>'UTF-8',
    'mer_id'=>UM_MEMBER_ID,
    'version'=>'4.0',
    'mer_cust_id'=>$this->model->gai_number,
);

$uid = Yii::app()->db->createCommand()->select('gai_number')->from("{{member}}")->where("id=:id",array(':id'=>$this->getUser()->id))->queryRow();
$code = rawurlencode(Tool::lowEncrypt($uid['gai_number'],'encrypt'));

?>
<!-- 头部end -->

<!--主体start-->
<div class="shopping-cart">	
    <div class="bankCard">
        <div class="bankCard-title"><?php echo Yii::t('payAgreement','请选择需要绑定银行卡的类别')?>！</div>
            <div class="bankCard-conter">
                <div class="bankCard-category clearfix">
                    <ul>
                        <li class="" tag="1">储蓄卡</li>
                        <li tag="2">信用卡</li>
                    </ul>
                </div>
                <?php $this->beginWidget('ActiveForm',array(
                    'id'=>$this->id . '_form',
                    'action' => $this->createUrl('/member/quickPay/bindGht')
                ))?>
                    <div class="bankCard-list">
                        <div class="bankCard-cp bankCard-cp1">
                            <ul class="bankCard-li clearfix">
                                <?php foreach($banks as $k=>$b):?>
                                <?php if($b['jie']):?>
                                <li>
                                    <input type="radio" class="radio" id="bank_<?php echo strtolower($k)?>" name="bank" value="<?php echo $k?>"/>
                                    <label for="bank_<?php echo strtolower($k)?>"><i class="bank-logo <?php echo $k?>"></i></label>
                                </li>
                                <?php endif;endforeach;?>
                            </ul>
                        </div>
                        <div class="bankCard-cp bankCard-cp2">
                                <ul class="bankCard-li clearfix">
                                    <?php foreach($banks as $k=>$b):?>
                                    <?php if($b['xin']):?>
                                    <li>
                                        <input type="radio" class="radio" name="bank" id="bank_<?php echo $k.'_'.$b['xin']?>" value="<?php echo $k?>"/>
                                        <label for="bank_<?php echo $k.'_'.$b['xin']?>"><i class="bank-logo <?php echo $k?>"></i></label>
                                    </li>
                                    <?php endif;endforeach;?>
                                </ul>
                        </div>
                            <div class="bankCard-box"><input type="submit" class="btn-dete" value="确认银行卡" /></div>
                            <input type="hidden" name="card_type" value="01" id="payagreement_type"/>
                    </div>
                <?php $this->endWidget();?>
            </div>
    </div>
</div>
<!-- 主体end -->
<script type="text/javascript">
    
    $(function(){
        $('.bankCard-category ul li').each(function(){
            if(parseInt($(this).attr('tag')) == parseInt($('#payagreement_type').val())){
                $(this).addClass('bankCard-category-on');
            }
        })
        $('#quickPay_form').submit(function(){
            var flag = false;
            $('.bankCard-li li input').each(function(){
                if($(this).prop('checked')) flag = true;
            });
            if(!flag){layer.alert('请选择银行',{icon:2});return false;}
            return true;
        })
    })
    
//    function getBank(bank){
//        var bankArr= new Array(); //定义一数组
//        bankArr=bank.split("|"); //字符分割
//        $("#payTypes").val(bankArr[0]);
//        $("#gateId").val(bankArr[1]);
//        $.ajax({
//            type:"POST",
//            url:"<?php //echo $this->createAbsoluteUrl('/member/quickPay/signgo') ?>",
//            data:{payTypes:bankArr[0],gateId:bankArr[1],code:"<?php //echo $umCode;?>",YII_CSRF_TOKEN:"<?php //echo Yii::app()->request->csrfToken;?>"},
//            success:function($msg){
//                $("#signTypes").val($msg);
//            }
//        });
//    }
//
//    function getBank1(bank){
//        var bankArr= new Array(); //定义一数组
//        bankArr=bank.split("|"); //字符分割
//        $("#payTypes1").val(bankArr[0]);
//        $("#gateId1").val(bankArr[1]);
//        $.ajax({
//            type:"POST",
//            url:"<?php //echo $this->createAbsoluteUrl('/member/quickPay/signgo') ?>",
//            data:{payTypes:bankArr[0],gateId:bankArr[1],code:"<?php //echo $umCode;?>",YII_CSRF_TOKEN:"<?php //echo Yii::app()->request->csrfToken;?>"},
//            success:function($msg){
//                $("#signTypes1").val($msg);
//            }
//        });
//    }

</script>