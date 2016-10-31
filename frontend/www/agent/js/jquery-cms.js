//手风琴
$(function() {
//导航下拉
$('.nav').find('.list').live('click', function() {
    $(this).find('ol:first').show();
	$(this).addClass("thismenu").siblings('.list').find('ol').hide().end().removeClass("thismenu");
});

    if ($('.list').hasClass("thismenu")) {
        $('.thismenu').find('ol:first').show();
    };
})