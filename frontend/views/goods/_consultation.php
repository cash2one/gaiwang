<div class="tabCon clearfix"  id="tabCon_ul_3">
    <ul class="comments">
        <li>
            <span class="ico_consulting"></span>
            <div class="zxcn">
                <h2>[咨询内容]:<span class="zxtit_time">盖网会员：GW8****415 2013/8/19 17:47:03</span></h2>
                <p class="comtxt">你们可以给装IOS几的系统呢</p>
            </div>
            <div class="zxcn reply">
                <span class="ico_shit"></span>
                <p class="comtxt">盖网回复：您好！您这边可以联系商城在线客服或者致电客服，客服热线：020-38011600-818
                    客服工作日时间都是正常工作的
                </p>
                <p class="comtime">2012-12-12 12:15:20</p>
            </div>
        </li>
        <li>
            <span class="ico_consulting"></span>
            <div class="zxcn">
                <h2>[咨询内容]:<span class="zxtit_time">盖网会员：GW8****415 2013/8/19 17:47:03</span></h2>
                <p class="comtxt">你们可以给装IOS几的系统呢</p>
            </div>
            <div class="zxcn reply">
                <span class="ico_shit"></span>
                <p class="comtxt">盖网回复：您好！您这边可以联系商城在线客服或者致电客服，客服热线：020-38011600-818
                    客服工作日时间都是正常工作的
                </p>
                <p class="comtime">2012-12-12 12:15:20</p>
            </div>
        </li>
        <li>
            <span class="ico_consulting"></span>
            <div class="zxcn">
                <h2>[咨询内容]:<span class="zxtit_time">盖网会员：GW8****415 2013/8/19 17:47:03</span></h2>
                <p class="comtxt">你们可以给装IOS几的系统呢</p>
            </div>
            <div class="zxcn reply">
                <span class="ico_shit"></span>
                <p class="comtxt">盖网回复：您好！您这边可以联系商城在线客服或者致电客服，客服热线：020-38011600-818
                    客服工作日时间都是正常工作的
                </p>
                <p class="comtime">2012-12-12 12:15:20</p>
            </div>
        </li>
        <li>
            <span class="ico_consulting"></span>
            <div class="zxcn">
                <h2>[咨询内容]:<span class="zxtit_time">盖网会员：GW8****415 2013/8/19 17:47:03</span></h2>
                <p class="comtxt">你们可以给装IOS几的系统呢</p>
            </div>
            <div class="zxcn reply">
                <span class="ico_shit"></span>
                <p class="comtxt">盖网回复：您好！您这边可以联系商城在线客服或者致电客服，客服热线：020-38011600-818
                    客服工作日时间都是正常工作的
                </p>
                <p class="comtime">2012-12-12 12:15:20</p>
            </div>
        </li>
        <li>
            <span class="ico_consulting"></span>
            <div class="zxcn">
                <h2>[咨询内容]:<span class="zxtit_time">盖网会员：GW8****415 2013/8/19 17:47:03</span></h2>
                <p class="comtxt">你们可以给装IOS几的系统呢</p>
            </div>
            <div class="zxcn reply">
                <span class="ico_shit"></span>
                <p class="comtxt">盖网回复：您好！您这边可以联系商城在线客服或者致电客服，客服热线：020-38011600-818
                    客服工作日时间都是正常工作的
                </p>
                <p class="comtime">2012-12-12 12:15:20</p>
            </div>
        </li>
    </ul>
    <div class="messConsulting">
        <form id="goods-form" action="/JF/11229.html" method="post">
            <div style="display:none"><input type="hidden" value="" name="YII_CSRF_TOKEN"></div>
            <span class="title">咨询商品: </span>
            <script>
                //点击旁边的刷选验证码
                function changeVeryfyCode() {

                    jQuery.ajax({
                        url: "http://member.gatewang.com/home/captcha/refresh/1",
                        dataType: 'json',
                        cache: false,
                        success: function(data) {
                            jQuery('#verifyCodeImg').attr('src', data['url']);
                            jQuery('body').data('captcha.hash', [data['hash1'], data['hash2']]);
                        }
                    });
                    return false;
                }
            </script>

            <textarea class="mess_textbox" id="txtContent" name="Guestbook[content]"></textarea> 
            <div class="errorMessage" id="Guestbook_content_em_" style="display:none"></div> 
            <input value="智能自动移动空气净化器 科沃斯 沁宝A320" name="Guestbook[goodsName]" id="Guestbook_goodsName" type="hidden"> 
            <div class="VerifiCode">
                <label for="Guestbook_verifyCode" class="required">验证码 <span class="required">*</span></label>：
                <input name="Guestbook[verifyCode]" id="Guestbook_verifyCode" type="text">&nbsp;
                <a onclick="changeVeryfyCode()" class="changeCode" style="cursor: pointer">
                    <img alt="点击换图" title="点击换图" id="verifyCodeImg" src="<?php echo DOMAIN ?>/goods/captcha.html?v=538e9937c8820"> </a>
                <div class="errorMessage" id="Guestbook_verifyCode_em_" style="display:none"></div>
            </div>
            <p><input class="btnMessConsult" type="submit" name="yt0" value="发表咨询"></p>
        </form> 
    </div><!--messConsulting end-->

    <ul class="yiiPageer">
        <li class="first selected"><a href="#">首页</a></li>
        <li class="previous"><a href="#">上一页</a></li>
        <li class="page"><a href="#">1</a></li>
        <li class="page"><a href="#">2</a></li>
        <li class="page"><a href="#">3</a></li>
        <li class="page"><a href="#">4</a></li>
        <li class="page"><a href="#">5</a></li>
        <li class="next"><a href="#">下一页</a></li>
        <li class="last"><a href="#">末页</a></li>
    </ul>
</div>