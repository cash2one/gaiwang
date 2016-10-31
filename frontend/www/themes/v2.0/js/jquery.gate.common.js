
// tab 切换 所有涉及到tab切换的请套用此方法
function setTab(name, cursel, n) {
    var i, menu, con;
    for (i = 1; i <= n; i++) {
        menu = $("#" + name + i);
        con = $("#tabCon_" + name + "_" + i);
        if (i === cursel) {
            $("#" + name + i).addClass("curr");
            $("#tabCon_" + name + "_" + i).css({
                "display": 'block'
            });
        } else {
            $("#" + name + i).removeClass("curr");
            $("#tabCon_" + name + "_" + i).css({
                "display": 'none'
            });
        }
    }
}

function setTab2(name,cursel,n){
    for(i=1;i<=n;i++){
        var menu=$("."+name+i);
        var con=$("#tabCon_"+name+"_"+i);
        if(i==cursel){
            $("."+name+i).addClass("curr");
            $("#tabCon_"+name+"_"+i).css({"display":'block'});
        }else{
            $("."+name+i).removeClass("curr");
            $("#tabCon_"+name+"_"+i).css({"display":'none'});
        }
    }
}



/*针对ie6.7 升级浏览器提示*/
$(function () {
    if (navigator.appName === "Microsoft Internet Explorer") {
        if (navigator.appVersion.split(";")[1].replace(/[ ]/g, "") === "MSIE6.0" || navigator.appVersion.split(";")[1].replace(/[ ]/g, "") === "MSIE7.0") {
            $("body").prepend('<div class="icon_v browserSug">温馨提示：您当前使用的浏览器版本过低，兼容性和安全性较差，盖象商城建议您升级: <a class="red" href="http://windows.microsoft.com/zh-cn/windows/upgrade-your-browser">IE8浏览器</a></div>');
        }
    }


    /*--------------岳秀---------------------*/
    /*导航我的盖象、收藏夹、商家支持显示下拉内容start*/
    $(".gx-top-mygx").hover(function () {
        $(".gx-top-ycItem").hide();
        $(".gx-top-language-list").hide();
        $(this).addClass("gx-top-mygx-sel");
        $(this).find(".gx-top-ycItem").show();
    }, function () {
        $(this).removeClass("gx-top-mygx-sel");
        $(this).find(".gx-top-ycItem").hide();
    });
    /*导航我的盖象、收藏夹、商家支持显示下拉内容end*/

    /*导航语言切换效果start*/
    $(".gx-top-language").click(function () {
        $(".gx-top-ycItem").hide();
        $(".gx-top-mygx").removeClass("gx-top-mygx-sel");
        $(this).find(".gx-top-language-list").toggle();
    });
    $(document).not($(".gx-top-language")).click(function () {
        if ($(this).find(".gx-top-language-list").css('display') === "block") {
            $(".gx-top-language-list").hide();
        }
    });
    $(".gx-top-language").click(function (event) {
        event.stopPropagation();
    });
    /*导航语言切换效果end*/

    /*--------------岳秀---------------------*/

    /*【关于盖象|联系客服|诚聘英才|免责声明|隐私声明】侧边栏导航 by吴晓兵 2015-06-10*/
    $("#about-sidebar a:not(:last-child)").append("<span class='link-line'></span>");

    /*【帮助中心】内容索引 by吴晓兵 2015-06-15*/
    $(".help-content .content-top a:not(:last-child)").after("<span>&gt</span>");

    /*【帮助中心】左侧导航手风琴功能 by吴晓兵 2015-06-17*/
    $(".help-sidebar .sub-helplist li").each(function () {
        if ($(this).hasClass("active")) {
            $(this).find(".subitem-name").css("color", "#ee5228");
            $(this).find(".subitem-name").append("<i class='help-sidebar-icon angle'></i>");
        } else {
            $(this).hover(function () {
                $(this).find(".subitem-name").css("color", "#ee5228");
                $(this).find(".subitem-name").append("<i class='help-sidebar-icon angle'></i>");
            }, function () {
                $(this).find(".subitem-name").css("color", "#373737");
                $(this).find(".subitem-name i").remove();
            });
        }
    });
    $("#helplist li").click(function () {
        if ($(this).hasClass("active")) {
            if ($(this).find(".sub-helplist").css("display") === "none") {
                $(this).find(".sub-helplist").slideDown();
                $(this).find(".help-sidebar-icon").removeClass("add");
                $(this).find(".help-sidebar-icon").addClass("minus");
            } else {
                //$(this).find(".sub-helplist").slideUp();
                //$(this).find(".help-sidebar-icon").removeClass("minus");
                $(this).find(".help-sidebar-icon").addClass("add");
            }
        } else {
            $(this).addClass("active");
            $(this).find(".sub-helplist").slideDown();
            $(this).find(".help-sidebar-icon").removeClass("add");
            $(this).find(".help-sidebar-icon").addClass("minus");
            $(this).siblings().removeClass("active");
            $(this).siblings().find(".sub-helplist").slideUp();
            $(this).siblings().find(".help-sidebar-icon").removeClass("minus");
            $(this).siblings().find(".help-sidebar-icon").addClass("add");
        }
    });
    /*订单详情-查看更多订单信息 by吴晓兵 2015-06-26*/
    $("#order-more").hover(function () {
        $(".order-more-box").show();
    }, function () {
        $(".order-more-box").hide();
    });
});

/*--------------梁楚崇，结算,购物车，我的盖象模块---------------------*/


$(function () {

    /*注册页面，点击发送短信*/
    $(".btn-send").click(function () {
        // sendTime();
        $(".btn-send").addClass("on");
        $(".btn-sendt").removeClass("on");
    });

    /*注册页面，检测注册账户为空*/
    $(".register-company .input-name").blur(function () {
        keypress1();
    });

    /*注册页面，检测注册密码少于6位*/
    $(".register-company .input-password").blur(function () {
        keypress2();
    });


    /*注册页面，点击查看密码*/
    $(".eyea").click(function () {
        var b = $(".input-password").val();
        var a = "<input name='' type='text' class='input-password' maxlength='12' />";
        $(".input-password").replaceWith(a);
        $(".input-password").val(b);
        $(".eyea").addClass("on");
        $(".eyeb").removeClass("on");
    });

    /*注册页面，点击隐藏密码*/
    $(".eyeb").click(function () {
        var b = $(".input-password").val();
        var a = "<input name='' type='password' class='input-password' maxlength='12' />";
        $(".input-password").replaceWith(a);
        $(".input-password").val(b);
        $(".eyeb").addClass("on");
        $(".eyea").removeClass("on");
    });

    /*购物车页面，点击删除，点击收藏*/
    $(".viewCart-item .operating .keep").click(function () {
        $(this).parent().find(".play-keep").show();
    });

    $(".viewCart-item .operating .delete").click(function () {
        $(this).parent().find(".play-delete").show();
    });

    $(".play-delete .play-top .right,.btn-delete").click(function () {
        $(this).parents(".play-delete").hide();
    });

    $(".play-keep .play-top .right,.btn-dete").click(function () {
        $(this).parents(".play-keep").hide();
    });

    $(".play-delete .play-box .btn-keep").click(function () {
        $(this).parents(".play-delete").hide();
        $(this).parent().parent().parent().find(".play-keep").show();
    });


    /*购物车页面，点击优惠券出现，隐藏*/
    $(".viewCart-coupon #coupon-title").click(function () {

        if ($(this).attr("class") === "coupon-title") {
            $(this).parent().find(".coupon-box").css("display", "block");
            $(this).removeClass("coupon-title");
            $(this).addClass("coupon-title-on");
        } else {
            $(this).parent().find(".coupon-box").css("display", "none");
            $(this).removeClass("coupon-title-on");
            $(this).addClass("coupon-title");
        }

    });

    /*购物车页面，点击领取优惠券*/
    $(".viewCart-coupon .coupon-box ul li .right .coupon-receive").click(function () {
        $(this).html("领取成功");
        $(this).addClass("coupon-receive-on");
    });


    /*绑定银行卡页面，点击选择银行
    $(".bankCard-li ul li").click(function () {
        $(this).parent().parent().find("li").removeClass("on");
        $(this).addClass("on");
    });*/


    /*支付页面，点击选择支付方式*/
    $(".orders-payments .orders-payments-item").click(function () {

        $(".orders-payments .orders-payments-item").removeClass("on");
        $(this).addClass("on");
    });

    $(".orders-payments .orders-payments-item").not(".orders-payments-item.third").click(function () {

        $(".orders-payments .orders-payments-item").removeClass("on");
        $(this).addClass("on");
        $(".orders-payments-item .orders-payments-bottom ul li").removeClass("on");

    });

    $(".orders-payments-item .orders-payments-bottom ul li").click(function () {
        $(".orders-payments-item .orders-payments-bottom ul li").removeClass("on");
        $(this).addClass("on");
    });


    /*注册页面，检测注册密码少于6位*/
    $(".orders-payments-item .payments-top .input-password").blur(function () {
        keypress3();
    });


    /*支付跳转弹窗出现和关闭*/

    $(".order-submit .orders-payments .btn-dete").click(function () {
        $(".order-submit-pop").css("display", "block");
    });
    $(".order-submit-pop .order-pop .order-pop-title .right span,.order-submit-pop .other-link").click(function () {
        $(".order-submit-pop").css("display", "none");
    });


    /*结算页面，点击打开更多收货地址*/
    $(".address-more").click(function () {
        $(".orders-address-only.first").css("display", "none");
        $(".orders-address-more").css("display", "block");
        $(".address-box .address-up").css("display", "block");
        $(".address-box .address-more").css("display", "none");
    });

    /*结算页面，点击回收更多收货地址*/
    $(".address-up").click(function () {
        $(".orders-address-more").css("display", "none");
        $(".orders-address-only.first").css("display", "block");
        $(".address-box .address-more").css("display", "block");
        $(".address-box .address-up").css("display", "none");

    });

    /*结算页面，点击设为默认收货地址*/
//    $(".orders-address-only ul li .seton,.orders-address-only ul li .select").click(function () {
//        $(".orders-address-only.bd ul li").removeClass("on");
//        $(this).parent().addClass("on");
//
//    });

    /*结算页面，点击弹出新加地址窗口*/
    $(".orders-address-top .right").click(function () {
        $(".address-pop").css("display", "block");
    });

    /*结算页面，点击关闭弹出新加地址窗口*/
    $(".address-title .right-close,.address-pop .address-center .btn-dete,.address-pop .address-center .btn-delete").click(function () {
        $(".address-pop").css("display", "none");
    });


    /*购物车页面，点击选中某个商品*/

    $(".viewCart #btn-check").change(function () {
        if ($(this).prop("checked")) {
            $(this).parent().parent().css("background", "#fff8f8");
        } else {
            $(this).parent().parent().css("background", "#ffffff");
        }
    });


    /*提现列表状态选择*/
    $(".withdraw-box .select-status span").click(function () {
        $(this).parent().find("span").removeClass("on");
        $(this).addClass("on");
        var data=$(this).attr("data-id");
        $("#statusValue").val(data);
    });

    /*收货地址页面，点击打开添加地址窗口*/
    $(".address-title .address-btn").click(function () {
        $('.address-pop').find('input[type="text"]').val('');
        $('#Address_street').val('');
        $(".address-receiving .address-pop").css("display", "block");
    });

    /*收货地址页面，点击删除地址*/
    $(".address-receiving .address-item .item-top .btn-delete").click(function () {
        $(".address-receiving .delete-pop").css("display", "block");
    });

    /*收货地址页面，点击打开编辑地址窗口*/
    $(".btn-editor").click(function () {
        $(".address-receiving .editor-pop").css("display", "block");
    });

    /*企业基本信息页面，点击编辑*/
    $(".info-btn .btn-editor").click(function () {
        $(".company-box .company-info").css("display", "none");
        $(".company-box .company-editor").css("display", "block");

        $(".person-box .person-info").css("display", "none");
        $(".person-box .person-editor").css("display", "block");

    });

    /*企业基本信息页面，点击保存*/
    $(".info-btn .btn-delete").click(function () {
        $(".company-box .company-info").css("display", "block");
        $(".company-box .company-editor").css("display", "none");

        $(".person-box .person-info").css("display", "block");
        $(".person-box .person-editor").css("display", "none");
    });


});


/*发送短信计时方法*/
// var countdown = 64;
// var settime;

// function sendTime() {
//     var mobile2 = $('#Member_mobile2').val();

//     if(mobile2 == ''){
//         $('#Member_mobile').val();
//     }
//     if(mobile2 == '') return true;

//     if (countdown == 0) {
//         $('#sendMobileCode2,#sendMobileCode').removeAttr("disabled");
//         $('#sendMobileCode2,#sendMobileCode').val("获取验证码");

//         clearTimeout(settime);
//         countdown = 64;
//         return;
//     } else {
//         $('#sendMobileCode2,#sendMobileCode').attr("disabled", true);
//         $('#sendMobileCode2,#sendMobileCode').val("发送中(" + countdown + ")");
//         countdown--;
//     }
//     settime = setTimeout(function() {sendTime();},1000);
// }

/*会员注册输入资料检测用户名是否为空*/
function keypress1() {
    var text1 = $(".input-name").val();
    if (text1 === "") {
        $(".phoneMessage").css("display", "block");
    } else {
        $(".phoneMessage").css("display", "none");
    }
}

/*会员注册输入资料检测密码长度*/
function keypress2() {
    var text1 = $(".input-password").val();
    var len; //记录剩余字符串的长度
    if (text1.length >= 6) {
        $(".passwordMessage").css("display", "none");
    } else {
        $(".passwordMessage").css("display", "block");
    }
}

/*计算输入框的字数*/
function lengthNum() {
    var length = 58;
    var num = $(".input-problem").val().length;
    var lastNum = length - num;
    $(".feedback-opinion .right span").html(lastNum);
}


/*绑定银行卡切换*/
$(function () {
    /*楼层产品切换start*/
    $(".bankCard-category ul li").click(function () {
        $(this).parents("ul").find("li").removeClass("bankCard-category-on");
        //支付类别选择，第三方，储蓄卡，信用卡
        var bankType=parseInt($(this).attr('data-attr'));
        $("#orderFormBankType").val(bankType);
        
        $(this).addClass("bankCard-category-on");
        var dqTag = $(this).attr("tag");
        $(this).parents('.bankCard-conter').find(".bankCard-list .bankCard-cp").hide();
        $(this).parents('.bankCard-conter').find(".bankCard-list .bankCard-cp" + dqTag + "").show();
        $('.bankCard-li li').each(function(){
          $(this).children('input').removeAttr('checked');
        });
        $('#payagreement_type').val('0'+dqTag);
    });
    /*楼层产品切换end*/
});


/*支付密码输入检测是否为空*/
function keypress3() {
    var text1 = $(".orders-payments-item .payments-top .input-password").val();
    if (text1 === "") {
        $(".enter-password").css("display", "block");
    } else {
        $(".enter-password").css("display", "none");
    }
}

/*--------------梁楚崇end---------------------*/


/*--------------锦东,线下业务模块---------------------*/

$(function () {
    // 下拉菜单
    $('.dropdown').mouseover(function () {
        $('.dropdown-list').show();
    }).mouseout(function () {
        $('.dropdown-list').hide();
    });

    // 导航条点击高亮效果
    $('.navbar dd').click(function () {
        $(this).removeClass('selected').addClass('selected')
            .siblings().removeClass('selected');
    });

    // 加载更多
    $('.loadmore a').click(function (e) {
        e.preventDefault();
        $.getJSON('data.json', function (obj) {
            $('.loadmore').before(gethtml(obj));
        });
    });
});

// 自定义函数，传入参数为json对象，用于生成要拼接的html代码
/* json 数据格式
 * {
 *   "p1": {
 *    "name": "君澜",
 *    "logo_path": "../images/temp/junlan223x58.jpg",
 *    "description": "瑠RYU位于上海奢华生活地标外滩5号3层，名字中的“瑠”意为宝石，希望宾客在每一个角落都能找到属于自己的诞生石...",
 *    "discount": "8.5",
 *    "views": "32345",
 *    "pic_path": "../images/temp/junlan610x298.jpg",
 *    "tag": "food"
 *  }
 * }
 */
function gethtml(obj) {
    var items = [],
        str = '';
    $.each(obj, function (k, v) {
        str = '';
        str += '<div class=\"item\">';
        str += '<div class=\"item-inner\">';
        str += '<div class=\"info\">';
        str += '<a class=\"logo\" href=\"#\" target=\"_blank\" title=\"' + v.name + '\"><img width=\"223\" height=\"58\" src=\"' + v.logo_path + '\" alt=\"' + v.name + '\"><\/a>';
        str += '<p class=\"description\">' + v.description + '<\/p>';
        str += '<div class=\"left-box\"><em class=\"discount\">' + v.discount + '折<\/em><\/div>';
        str += '<div class=\"right-box\"><p class=\"views\">' + v.views + '次<\/p><\/div>';
        str += '<b class=\"tag ' + v.tag + '\"><\/b>';
        str += '<\/div>';
        str += '<a class=\"pic\" href=\"#\" target=\"_blank\" title=\"君澜\"><img width=\"610\" height=\"298\" src=\"' + v.pic_path + '\" alt=\"君澜\"><\/a>';
        str += '<\/div>';
        str += '<\/div>';
        items.push(str);
    });
    return items.join('');
}

/*--------------锦东,线下业务end---------------------*/

$(function () {
    //应节性活动页面鼠标选中商品显示效果
    $(".hd_list ul li").hover(function () {
        $(this).find(".hd_item_fd").toggle();
    }, function () {
        $(this).find(".hd_item_fd").toggle();
    });
});
