$(document).ready(function(){
	$('.disabled').each(function(index, el) {
		$(this).attr({
			disabled: 'disabled'
		});
	});

    $(".audit-tableTitle a.check").click(function(){
        $(this).parent().next("div").slideToggle("slow");
        $(this).toggleClass("on");
        $(".audit-tableTitle a.check").html("展开");
        $(".audit-tableTitle a.check.on").html("收起");
    });

    //对公还是对私
	$('.accountPublic').show();
	$('.accountPrivate').hide();
	var payType = $('#OfflineSignEnterprise_account_pay_type');
	if(payType.val() == window.publicPayType){
		$('.accountPublic').show();
		$('.accountPrivate').hide();
	}else{
		$('.accountPublic').hide();
		$('.accountPrivate').show();
	}

	payType.change(function(){
		if(payType.val() == window.publicPayType){
			$('.accountPublic').show();
			$('.accountPrivate').hide();
		}else{
			$('.accountPublic').hide();
			$('.accountPrivate').show();
		}
	});
	payType.change();

	//是否长期
	var isLongTime = $('#OfflineSignEnterprise_license_is_long_time');
	isLongTime.change(function(){
		var endTime = $('#OfflineSignEnterprise_license_end_time');
		if(isLongTime.attr('checked')){
			endTime.attr('disabled','true');
			endTime.attr('value','');
		}else{
			endTime.removeAttr('disabled');
		}
	});
	isLongTime.change();

	//合同结束期限
	var term = $('#OfflineSignContract_contract_term');
	term.change(function(){
		var contractTerm = term.val();
		var benginTime = $('#OfflineSignContract_begin_time').val();
		var url = window.returnEndTimeUrl;
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: url,
			data: {'YII_CSRF_TOKEN': window.csrfToken, contractTerm: contractTerm,benginTime:benginTime},
			success: function(data) {
				if (data) {
					$("#OfflineSignContract_end_time").val(data.endTiem);
				}
			}
		});
	});

	//盖网折扣
	$('.count_discount').change(function(){
		var discountVal = parseInt($('.OfflineSign_discount').val());
		var memDiscount = parseInt($('.OfflineSign_member_discount').val());
		console.log(discountVal,memDiscount);
		$('.OfflineSign_gai_discount').val(memDiscount - discountVal);
	});
	$('.count_discount').change();

	//选择收费方式
	$('.operation_type').change(function(){

		var num = $(this).find('option:selected').val();
		console.log(num);
		$('.select_pay_type').hide();
		$('#select_pay_type_'+num).show();
	});
	$('.operation_type').change();	

	//选择小时
	$('.ad_begin_time_hour').change(function(){
		var hourTime = parseInt($(this).val());
		var endHourTime = hourTime + 3;
		endHourTime = endHourTime >= 24 ? endHourTime-24 : endHourTime;
		$(this).parent().find('.ad_end_time_hour').val(endHourTime);
	});
	$('.ad_begin_time_hour').change();

	//选择分钟
	$('.ad_begin_time_minute').change(function(){
			var minuteTime = parseInt($(this).val());
			$(this).parent().find('.ad_end_time_minute').val(minuteTime);
	});
	$('.ad_begin_time_minute').change();


	//归属方信息修改
	window.dialog = null;
	window.doClose = function() {
    	if (null != dialog) {
        	dialog.close();
    	}
	};
    $('#set-machine_belong_to').click(function() {
        dialog = art.dialog.open(findMachineBelongInfoUrl, { 'id': 'select-belong-to-info', title: '搜索归属方信息', width: '800px', height: '620px', lock: true });
    })
    $('.upda11').click(function() {
        var imgid = $(this).attr("id");
        var url = savestoreInfoUrl + '&id='+imgid;
        dialog = art.dialog.open(url, { 'id': 'save-store-info', title: '编辑加盟商', width: '1000px', height: '620px', lock: true,
            success:function (data) { alert();dialog.close();}
        });
    })

	window.onSelectInfo = function (data) {
        var machine_name = decodeURI(data);
		$('#machine_belong_to').val(machine_name);
		$('#OfflineSignStore_machine_belong_to').val(machine_name);
        $('#OfflineSignStore_machine_belong_to').removeClass('red');
        $('#OfflineSignStore_machine_belong_to').parent().prev().removeClass('red');
        $('#machine_belong_to').removeClass('red');
	};
})