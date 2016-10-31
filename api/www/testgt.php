<?php

//echo base64_encode('116.255.156.243:8080');
//echo time();echo '<br/>';
//echo strtotime('2014-07-08');
//$dm = 'http://api.gaiwang.com';
$host = $_SERVER['HTTP_HOST'];
$dm = 'http://'.$host.'/bit/index?';
if(isset($_GET['w']) && $_GET['w']){
    $dm = 'http://'.$host.'/bit/wndex?';
}
$dm = 'http://'.$host;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>
gatetong
</title><link href="Styles/Site.css" rel="stylesheet" type="text/css" />
<style>
form{margin-left:350px;}
.btm{width:200px;}
.s1{background-color: #ffd1ab;}
.s2{background-color: #F4CB48;}
.s3{background-color: #fef1ec;}
.s4{background-color: #505050;}
.s5{background-color: #3b57a8;}
</style>
<script type="text/javascript" src="http://www.gatewang.com/js/jquery.js"></script>
<script type="text/javascript" src="http://files.cnblogs.com/china-li/jquery.form.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $(".make").bind("click", function () {
            $(this).parent().attr('id','form-id');
            var rsa = $('#form-id').children('input[name="rsa"]').val();
            if(rsa !== undefined){
                var rsa_ary = rsa.split(',');
                $.each(rsa_ary,function(i,item){
                    var v = $('#form-id').children('input[name="'+item+'"]').val();
                    if(item == 'CheckCode' && $('#phonecode').val() == undefined){
                        $.ajax({
                            url: "<?php echo $dm;?>/tool/ajaxGetCode",
                            type: "POST",
                            async: false,
                            success: function(result){
                                $('#form-id').children('input[name="'+item+'"]').val(result);
                            }
                        });
                    }
                    else if(v != ''){
                        if(item == 'Code'){
                            $.ajax({
                                url: "<?php echo $dm;?>/tool/ajaxGetMCode",
                                type: "POST",
                                data: "code="+v,
                                async: false,
                                success: function(result){
                                    $('#form-id').children('input[name="'+item+'"]').val(result);
                                }
                            });
                        }else{
                            $.ajax({
                                url: "<?php echo $dm;?>/tool/ajaxEncode",
                                type: "POST",
                                data: "code="+v,
                                async: false,
                                success: function(result){
                                    $('#form-id').children('input[name="'+item+'"]').val(result);
                                }
                            });
                        }
                    }
                });
            }
            $('#form-id').attr('id','ctl01');
            return false;
        });

        $(".makePhoneCode").bind("click", function () {
            var phone = $(this).parent().children('input[name="UserPhone"]').val();
            $(this).parent().children('input[name="CheckCode"]').attr('id','phonecode');
            $.ajax({
                url: "<?php echo $dm;?>/tool/ajaxGetPhoneCode",
                type: "POST",
                data: "phone="+phone,
                success: function(result){
                    $('#phonecode').val(result);
                }
            });
        });
        $(".reload").bind("click", function () {
            location.reload(true);
        });
    });
</script>
</head>
<body>
<div>
<hr>
<div class = 's1'>
    push
    <form method="post" action="<?php echo $dm;?>/push" id="ctl01" target="_blank">
        token<input type='text' name='token' value=''/><br/>
        message<input type='text' name='message' value=''/><br/>
        psw<input type='text' name='psw' value=''/><br/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    push
    <form method="post" action="<?php echo $dm;?>/pushx" id="ctl01" target="_blank">
        token<input type='text' name='token' value=''/><br/>
        message<input type='text' name='message' value=''/><br/>
        psw<input type='text' name='psw' value=''/><br/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    integral/deduct
    <form method="post" action="<?php echo $dm;?>/integral/deduct" id="ctl01" target="_blank">
        CheckCode<input type='text' name='CheckCode' value=''/><br/>
        Money<input type='text' name='Money' value='100'/><br/>
        Symbol<input type='text' name='Symbol' value='RMB'/>RMB或HKD<br/>
        MachineId<input type='text' name='MachineId' value='1'/>盖网机id<br/>
        MachineSN<input type='text' name='MachineSN' value='sn123456789000'/>流水号<br/>
        FranchiseeId<input type='text' name='FranchiseeId' value='1'/>加盟商id<br/>
        UserPhone<input type='text' name='UserPhone' value='18620709802'/><br/>
        Name<input type='text' name='Name' value=''/>gai_number<br/>
        rsa<input type='text' name='rsa' value='CheckCode'/><br/>
        <br/>
        <input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    integral/income
    <form method="post" action="<?php echo $dm;?>/integral/income" id="ctl01" target="_blank">
        CheckCode<input type='text' name='CheckCode' value=''/><br/>
        Symbol<input type='text' name='Symbol' value='RMB'/>RMB或HKD<br/>
        CardNum<input type='text' name='CardNum' value=''/>盖网机id<br/>
        CardPwd<input type='text' name='CardPwd' value=''/>流水号<br/>
        UserPhone<input type='text' name='UserPhone' value='18620709802'/><br/>
        Name<input type='text' name='Name' value=''/>gai_number<br/>
        rsa<input type='text' name='rsa' value='CheckCode,CardPwd'/><br/>
        <br/>
        <input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    integral/list
    <form method="post" action="<?php echo $dm;?>/integral/list" id="ctl01" target="_blank">
        CheckCode<input type='text' name='CheckCode' value=''/><br/>
        Symbol<input type='text' name='Symbol' value='RMB'/>RMB或HKD<br/>
        UserPhone<input type='text' name='UserPhone' value='18620709802'/><br/>
        Name<input type='text' name='Name' value=''/>gai_number<br/>
        rsa<input type='text' name='rsa' value='CheckCode'/><br/>
        <br/>
        <input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
</div>
<hr />
<hr />
<hr>
<div class = 's2'>
    user/register
    <form method="post" action="<?php echo $dm;?>/user/register" id="ctl01" target="_blank">
        CheckCode<input type='text' name='CheckCode' value=''/><br/>
        BizId<input type='text' name='BizId' value='1'/>加盟商id<br/>
        machineId<input type='text' name='machineId' value='1'/>盖网机id<br/>
        UserPhone<input type='text' name='UserPhone' value='18620709802'/><br/>
        rsa<input type='text' name='rsa' value='CheckCode'/><br/>
        <br/><input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    member/addressList
    <form method="post" action="<?php echo $dm;?>/member/address" id="ctl01" target="_blank">
        UserName<input type='text' name='UserName' value='yangming'/><br/>
        Flag<input type='text' name='Flag' value='1'/>1：添加 2：修改 3：删除<br/>
        ReceiveID<input type='text' name='ReceiveID' value=''/>flag > 1<br/>
        ReceiveName<input type='text' name='ReceiveName' value=''/>flag < 3<br/>
        ReceivePhone<input type='text' name='ReceivePhone' value=''/>flag < 3<br/>
        ReceiveProvinceID<input type='text' name='ReceiveProvinceID' value=''/>flag < 3<br/>
        ReceiveCityID<input type='text' name='ReceiveCityID' value=''/>flag < 3<br/>
        ReceiveDistrictID<input type='text' name='ReceiveDistrictID' value=''/>flag < 3<br/>
        ReceiveAddr<input type='text' name='ReceiveAddr' value=''/>flag < 3<br/>
        Default<input type='text' name='Default' value='0'/>flag < 3<br/>
        rsa<input type='text' name='rsa' value='UserName'/><br/>
        <br/><input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    member/GetCoupon
    <form method="post" action="<?php echo $dm;?>/member/getCoupon" id="ctl01" target="_blank">
        Code<input type='text' name='Code' value='yangming,123456,'/><br/>
        rsa<input type='text' name='rsa' value='Code'/><br/>
        <br/><input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
</div>
<hr />
<hr />
<hr>
<div class = 's3'>
</div>
<hr />
<hr />
<hr>
<div class = 's4'>

</div>
<hr />
<hr />
<hr>
<div class = 's5'>

</div>


</div>
</body>

