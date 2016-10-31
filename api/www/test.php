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
member
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
<script type="text/javascript" src="http://www.gaiwang.com/js/jquery.js"></script>
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
    <hr>
    sms/send
    <form method="post" action="<?php echo $dm;?>/sms/send" id="ctl01" target="_blank">
        UserPhone<input type='text' name='UserPhone' value='18620709802'/><br/>
        rsa<input type='text' name='rsa' value='UserPhone'/><br/>
        <br/>
        <input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>

    <hr>
    RegCheck
    <form method="post" action="<?php echo $dm;?>/register/RegCheck" id="ctl01" target="_blank">
        Flag<input type='text' name='Flag' value='2'/>//1用户名,2手机号<br/>
        Value<input type='text' name='Value' value='18620709802'/><br/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>

    <hr>
    register
    <form method="post" action="<?php echo $dm;?>/register" id="ctl01" target="_blank">
        UserName<input type='text' name='UserName' value='yangming'/><br/>
        Pwd<input type='text' name='Pwd' value='123456'/><br/>
        UserPhone<input type='text' name='UserPhone' value='18620709802'/><br/>
        Recommend<input type='text' name='Recommend' value='GW80000007'/><br/>
        CheckCode<input type='text' name='CheckCode' value=''/><br/>
        rsa<input type='text' name='rsa' value='UserName,Pwd,UserPhone,CheckCode'/><br/>
        <br/>
        <input class="makePhoneCode" type="button" value='makePhoneCode'/>
        <input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    register/router
    <form method="post" action="<?php echo $dm;?>/register/router" id="ctl01" target="_blank">
        UserName<input type='text' name='UserName' value='yangming'/><br/>
        Pwd<input type='text' name='Pwd' value='123456'/><br/>
        UserPhone<input type='text' name='UserPhone' value='18620709802'/><br/>
        Recommend<input type='text' name='Recommend' value='GW80000007'/><br/>
        Country<input type='text' name='Country' value='1'/><br/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>

    <hr>
    islogin
    <form method="post" action="<?php echo $dm;?>/member/isLogin" id="ctl01" target="_blank">
    <br/><input class="btm" type="submit" value='go'/><br/>
    </form>

    <hr>
    登陆
    <form method="post" action="<?php echo $dm;?>/login" id="ctl01" target="_blank">
    UserName<input type='text' name='UserName' value='yangming'/><br/>
    Pwd<input type='text' name='Pwd' value='123456'/><br/>
    rsa<input type='text' name='rsa' value='UserName,Pwd'/><br/>
    <br/><input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
    <br/><input class="btm" type="submit" value='go'/><br/>
    </form>

    <hr>
    member/view
    <form method="post" action="<?php echo $dm;?>/member/view" id="ctl01" target="_blank">
        UserName<input type='text' name='UserName' value='yangming'/><br/>
        rsa<input type='text' name='rsa' value='UserName'/><br/>
        <br/><input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
</div>

<hr />
<hr />
<hr>
<div class = 's2'>
    member/addressList
    <form method="post" action="<?php echo $dm;?>/member/addressList" id="ctl01" target="_blank">
        Code<input type='text' name='Code' value='yangming,123456,'/><br/>
        rsa<input type='text' name='rsa' value='Code'/><br/>
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
    Advert
    <form method="post" action="<?php echo $dm;?>/advert" id="ctl01" target="_blank">
        AdType<input type='text' name='AdType' value='HomeToLeft0,HomeToTop1'/><br/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    goods/type
    <form method="post" action="<?php echo $dm;?>/goods/type" id="ctl01" target="_blank">
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    goods/list
    <form method="post" action="<?php echo $dm;?>/goods/list" id="ctl01" target="_blank">
        Key<input type='text' name='Key' value=''/>关键词<br/>
        GoodsTypeID<input type='text' name='GoodsTypeID' value=''/>分类<br/>
        Count<input type='text' name='Count' value=''/>每页数量<br/>
        PageNow<input type='text' name='PageNow' value=''/>当前页<br/>
        Order<input type='text' name='Order' value=''/>1 ? DESC : ASC<br/>
        Orderby<input type='text' name='Orderby' value=''/>0 ? sales_volume : price<br/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    goods/view
    <form method="post" action="<?php echo $dm;?>/goods/view" id="ctl01" target="_blank">
        GoodsID<input type='text' name='GoodsID' value='5275'/><br/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    goods/comment
    <form method="post" action="<?php echo $dm;?>/goods/comment" id="ctl01" target="_blank">
        GoodsID<input type='text' name='GoodsID' value='5275'/><br/>
        Count<input type='text' name='Count' value=''/>每页数量<br/>
        PageNow<input type='text' name='PageNow' value=''/>当前页<br/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>

    <hr>
    hotel/city
    <form method="post" action="<?php echo $dm;?>/hotel/city" id="ctl01" target="_blank">
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    hotel/Address
    <form method="post" action="<?php echo $dm;?>/hotel/address" id="ctl01" target="_blank">
        CityID<input type='text' name='CityID' value='38'/><br/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    hotel/list
    <form method="post" action="<?php echo $dm;?>/hotel/list" id="ctl01" target="_blank">
        CityID<input type='text' name='CityID' value='38'/><br/>
        Key<input type='text' name='Key' value=''/>关键词<br/>
        HotAreaID<input type='text' name='HotAreaID' value=''/>热门地区ID<br/>
        BrandID<input type='text' name='BrandID' value=''/>酒店品牌<br/>
        MinPoints<input type='text' name='MinPoints' value=''/>积分范围的最小值<br/>
        MaxPoints<input type='text' name='MaxPoints' value=''/>积分范围的最大值<br/>
        Count<input type='text' name='Count' value='5'/>每页数量<br/>
        PageNow<input type='text' name='PageNow' value=''/>当前页<br/>
        Order<input type='text' name='Order' value=''/><br/>
        Orderby<input type='text' name='Orderby' value=''/><br/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    hotel/view
    <form method="post" action="<?php echo $dm;?>/hotel/view" id="ctl01" target="_blank">
        HotelID<input type='text' name='HotelID' value='11'/><br/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    hotel/comment
    <form method="post" action="<?php echo $dm;?>/hotel/comment" id="ctl01" target="_blank">
        HotelID<input type='text' name='HotelID' value='11'/><br/>
        Count<input type='text' name='Count' value='5'/>每页数量<br/>
        PageNow<input type='text' name='PageNow' value=''/>当前页<br/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
</div>
<hr />
<hr />
<hr>
<div class = 's4'>
    下单
    <form method="post" action="<?php echo $dm;?>/order/build" id="ctl01" target="_blank">
        Code<input type='text' name='Code' value='yqhaox,123456,'/><br/>
        ReceiveName<input type='text' name='ReceiveName' value='收货'/><br/>
        ReceivePhone<input type='text' name='ReceivePhone' value='18620709802'/><br/>
        ReceiveCityID<input type='text' name='ReceiveCityID' value='gdfg'/><br/>
        ReceiveAddr<input type='text' name='ReceiveAddr' value='gdfg'/><br/>
        GoodsID1<input type='text' name='GoodsID1' value='8585'/><br/>
        Count1<input type='text' name='Count1' value='2'/><br/>
        GoodsID2<input type='text' name='GoodsID2' value=''/><br/>
        Count2<input type='text' name='Count2' value=''/><br/>
        ReceiveCityID<input type='text' name='ReceiveCityID' value='65'/><br/>
        rsa<input type='text' name='rsa' value='Code,GoodsID1,GoodsID2'/><br/>
        <br/><input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    order/cancle
    <form method="post" action="<?php echo $dm;?>/order/cancle" id="ctl01" target="_blank">
        Code<input type='text' name='Code' value='yqhaox,123456,'/><br/>
        TypeFlag<input type='text' name='TypeFlag' value='1'/>1: 商品订单 2：酒店订单 3：站内信<br/>
        OrderCode<input type='text' name='OrderCode' value=''/>:>1 id<br/>
        rsa<input type='text' name='rsa' value='Code,OrderCode'/><br/>
        <br/><input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    hotelorder/create
    <form method="post" action="<?php echo $dm;?>/HotelOrder/create" id="ctl01"  target="_blank">
        <?php
        $ary = array(
            'Code' => 'yangming,123456,4565',
            'HotelD' => '413',
            'RoomTypeID' => 1545,
            'RoomNum' => 1,
            'CheckInTime' => '2014-08-27',
            'CheckOutTime' => '2014-08-28',
            'ComeTimeStart' => '15:00',
            'ComeTimeEnd' => '22:00',
            'ContactName' => '李欣',
            'ContactPhone' => '15310555189',
            'Number' => '1',
            'CheckInName1' => '李欣1',
            'IDCardType1' => '身份证',
            'IDCardNum1' => '512301197311060016',
            'CheckInName2' => '李欣2',
            'IDCardType2' => '身份证',
            'IDCardNum2' => '512301197311060016',
            'CheckInName3' => '李欣3',
            'IDCardType3' => '身份证',
            'IDCardNum3' => '512301197311060016',
            'rsa' => 'Code,HotelD'
        );
        foreach($ary as $k => $v){
            echo $k."<input type='text' name='".$k."' value='".$v."'/><br/>";
        }
        ?>
        <br/><input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
</div>
<hr />
<hr />
<hr>
<div class = 's5'>
    <hr>
    order/list
    <form method="post" action="<?php echo $dm;?>/order/list" id="ctl01"  target="_blank">
        UserName<input type='text' name='UserName' value='yangming'/><br/>
        TypeFlag<input type='text' name='TypeFlag' value='1'/>1: 商品订单 2：酒店订单 3：站内信<br/>
        StatusFlag<input type='text' name='StatusFlag' value='0'/>0：全部 1：待付款 2：待评价 3：待收货<br/>
        Count<input type='text' name='Count' value=''/>每页数量<br/>
        PageNow<input type='text' name='PageNow' value=''/>当前页<br/>
        rsa<input type='text' name='rsa' value='UserName'/><br/>
        <br/><input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    order/view
    <form method="post" action="<?php echo $dm;?>/order/view" id="ctl01"  target="_blank">
        UserName<input type='text' name='UserName' value='yqhaox'/><br/>
        TypeFlag<input type='text' name='TypeFlag' value='1'/><br/>
        OrderCode<input type='text' name='OrderCode' value=''/>1: code; 2,3: id<br/>
        MessageID<input type='text' name='MessageID' value=''/><br/>
        rsa<input type='text' name='rsa' value='UserName,OrderCode,MessageID'/><br/>
        <br/><input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>
    <hr>
    支付
    <form method="post" action="<?php echo $dm;?>/pay" id="ctl01" target="_blank">
        Code<input type='text' name='Code' value='yangming,123456,'/><br/>
        PayPwd<input type='text' name='PayPwd' value='123456'/><br/>
        Flag<input type='text' name='Flag' value='1'/><br/>
        OrderCode1<input type='text' name='OrderCode1' value='80'/>orderid<br/>
        OrderCode2<input type='text' name='OrderCode2' value=''/><br/>
        rsa<input type='text' name='rsa' value='Code,PayPwd,OrderCode1,OrderCode2'/><br/>
        <br/><input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form><hr>
    签收
    <form method="post" action="<?php echo $dm;?>/order/check" id="ctl01" target="_blank" >
        Code<input type='text' name='Code' value='yqhaox,123456,'/><br/>
        OrderCodeShow<input type='text' name='OrderCode' value=''/>code<br/>
        rsa<input type='text' name='rsa' value='Code,OrderCode'/><br/>
        <br/><input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form><hr>
    order/recede退货
    <form method="post" action="<?php echo $dm;?>/order/recede" id="ctl01"  target="_blank">
        Code<input type='text' name='Code' value='yqhaox,123456,'/><br/>
        UserName<input type='text' name='UserName' value='yqhaox'/><br/>
        OrderCode<input type='text' name='OrderCode' value=''/>code<br/>
        Reason<input type='text' name='Reason' value='退货理由'/>退货理由<br/>
        Freight<input type='text' name='Freight' value=''/>愿意承担的运费<br/>
        rsa<input type='text' name='rsa' value='Code,UserName,OrderCode'/><br/>
        <br/><input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form><hr>
    order/refund退款
    <form method="post" action="<?php echo $dm;?>/order/refund" id="ctl01"  target="_blank">
        Code<input type='text' name='Code' value='yqhaox,123456,'/><br/>
        TypeFlag<input type='text' name='TypeFlag' value='1'/>1: 商品订单 2：酒店订单<br/>
        OrderCode<input type='text' name='OrderCode' value=''/>code<br/>
        Reason<input type='text' name='Reason' value='退货理由'/>退款理由<br/>
        rsa<input type='text' name='rsa' value='Code,OrderCode'/><br/>
        <br/><input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form><hr>
    order/createComment
    <form method="post" action="<?php echo $dm;?>/order/createComment" id="ctl01" target="_blank">
        UserName<input type='text' name='UserName' value='yqhaox'/><br/>
        OrderCode<input type='text' name='OrderCode' value=''/>code<br/>
        Content<input type='text' name='Content' value='xxxxxx'/><br/>
        DescriptionGrade<input type='text' name='DescriptionGrade' value='5'/>描述相符分数<br/>
        ServiceGrade<input type='text' name='ServiceGrade' value='5'/>服务相符分数<br/>
        DeliverGrage<input type='text' name='DeliverGrage' value='5'/>发货速度分数<br/>
        GoodsGrade<input type='text' name='GoodsGrade' value='5'/><br/>
        rsa<input type='text' name='rsa' value='UserName,OrderCode'/><br/>
        <br/><input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form><hr>
    <hr>
    hotelOrder/createComment
    <form method="post" action="<?php echo $dm;?>/hotelOrder/createComment" id="ctl01" target="_blank">
        UserName<input type='text' name='UserName' value='yqhaox'/><br/>
        OrderCode<input type='text' name='OrderCode' value=''/>orderId<br/>
        Content<input type='text' name='Content' value='xxxxxxxx'/>内容<br/>
        Grade<input type='text' name='Grade' value='4.5'/>评分<br/>
        rsa<input type='text' name='rsa' value='UserName,OrderCode'/><br/>
        <br/><input class="make" type="button" value='make'/>
        <input class="reload" type="button" value='reload'/>
        <br/><input class="btm" type="submit" value='go'/><br/>
    </form>


</div>


<hr>
评论
<form method="post" action="<?php echo $dm;?>/order/CreateComment" id="ctl01" target="_blank">
UserName<input type='text' name='UserName' value='yangming'/><br/>
OrderCodeShow<input type='text' name='OrderCode' value=''/><br/>
DescriptionGrade<input type='text' name='DescriptionGrade' value='4.5'/><br/>
ServiceGrade<input type='text' name='ServiceGrade' value='5'/><br/>
DeliverGrage<input type='text' name='DeliverGrage' value='5'/><br/>
Content<input type='text' name='Content' value='fffff'/><br/>
GoodsGrade<input type='text' name='GoodsGrade' value='5'/><br/>
<br/><input class="btm" type="submit" value='go'/><br/>
</form>



<hr>
评论
<form method="post" action="<?php echo $dm;?>/goods/List" id="ctl01" target="_blank">
GoodsTypeID<input type='text' name='GoodsTypeID' value=''/><br/>
Count<input type='text' name='Count' value=''/><br/>
PageNow<input type='text' name='PageNow' value=''/><br/>
Order<input type='text' name='Order' value=''/><br/>
Orderby<input type='text' name='Orderby' value=''/><br/>
<br/><input class="btm" type="submit" value='go'/><br/>
</form>

<hr>
评论
<form method="post" action="<?php echo $dm;?>/goods/view" id="ctl01" target="_blank">
GoodsID<input type='text' name='GoodsID' value=''/><br/>
<br/><input class="btm" type="submit" value='go'/><br/>
</form>





<hr>
order/view
<form method="post" action="<?php echo $dm;?>/order/cancle" id="ctl01"  target="_blank">
    Code<input type='text' name='Code' value='yangming,123456,1'/><br/>
    TypeFlag<input type='text' name='TypeFlag' value='1'/><br/>
    MessageID<input type='text' name='MessageID' value='1'/><br/>
    <br/><input class="btm" type="submit" value='go'/><br/>
</form>

    <hr>
        
notice/list
<form method="post" action="<?php echo $dm;?>/notice/list" id="ctl01"  target="_blank">
    Code<input type='text' name='Code' value='2'/><br/>
    <br/><input class="btm" type="submit" value='go'/><br/>
</form>

</div>
</body>

