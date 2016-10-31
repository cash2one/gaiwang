<link href="http://www.g-emall.com/css/style.css" rel="stylesheet">
<div class="main">
    <div class="wrapperProd clearfix">
        <div class="prodLeft">
            <div class="picturesShow clearfix">
                <div class="picturesShow clearfix">
                    <img src="http://img03.taobaocdn.com/imgextra/i3/1699086763/T28WROXABaXXXXXXXX_!!1699086763.jpg" width="418" height="458"/>
                </div>   
            </div>       
        </div>
        <div class="prodMidd">
            <input type="hidden" id="goodsId" value="60332">
            <div class="productContent">
                <h1 class="productName">【药品保健】 太龙 双黄连口服液 20ml*10支 流感 感冒发烧咳嗽咽喉肿痛药  </h1>

                <div class="produtDetail">
                    <table class="productTable">
                        <tbody><tr>
                                <td width="70" class="fontsize14">促销价：</td>
                                <td><strong class="fontSize34"></strong></td>
                            </tr>
                            <tr class="colorffc5c5">
                                <td>市场价：</td>
                                <td>
                                    <del></del>
                                </td>
                            </tr>
                            <tr>
                                <td>换购积分：</td>
                                <td><strong class="fontSize18"></strong> 盖网积分                </td>
                            </tr>
                            <tr>
                                <td>运费：</td>
                                <td>
                                    <span class="pr freight">
                                        包邮                    </span>
                                </td>
                            </tr>        </tbody></table>
                </div>
                <div class="aboutProduct">
                    <ul>
                        <li>
                            <p class="custAccount">0</p>

                            <p>销量</p>
                        </li>
                        <li>
                            <p class="pointAccount">0</p>

                            <p> 累计评价 <span class="point p_d0"></span>0分                </p>
                        </li>
                        <li>
                            <p class="gitPoint">0.13</p>

                            <p>赠送盖网积分</p>
                        </li>
                    </ul>
                </div>
                <!--    商品规格选择-->
                <div class="filterSpec">
                </div>

                <div class="buyAccount clearfix">
                    <span class="left">数量：
                        <input type="text" id="quantity" style="width:59px" value="1" disabled="disabled"></span>
                    <div class="addAccount left"><i class="plus increase"></i><i class="minus decrease"></i></div>
                    <span class="left">
                        <span class="ie6mgRig">库存：
                            <b id="goods_stock">99</b>件            </span>
                        <!--<a href="#" title="" class="keepShop red">收藏该商品</a>-->
                    </span>
                </div>
                <div>
                </div>
                <div class="buyBtn">
                    <a href="#" class="addCart quickyBuy" title="加入购物车">加入购物车</a>    </div>
                <div class="posRel">
                    <div class="zindex_wrap" style="display:none" id="messageDlg">
                        <a onclick="$('#messageDlg').hide();" class="close">X</a>

                        <div style="display:block" class="messageDlgContent" id="messageDlgContent">
                            <h4>商品已成功添加到购物车！</h4>

                            <p>
                                <span>购物车共<b id="bold_num"></b>种商品</span>
                                <span>合计<b id="bold_price" class="price_mini"></b></span>
                            </p>
                            <a onclick="$('#messageDlg').hide();" title="继续挑商品" class="btn_03" id="closeCart">继续购物</a>
                            <a title="去购物车结算" class="btn_04" href="http://www.g-emall.com/orderFlow.html">去购物车结算</a>
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                        /* spec对象,设置默认的商品规格 */
                        var spec = {
                        id: "81029",
                                price: "10.00",
                                goods_id: "60332",
                                stock: "99",
                                store_id:"1142", //有多少类规格需要点击选择
                                specType:"0", //有多少类规格需要点击选择
                                goodsSpec:{"0":{"id":"81029", "goods_id":"60332", "spec_name":"", "price":"10.00", "stock":"99", "sale_num":"0", "code":"", "spec_value":""}, "spec_value_array":[]}  //商品规格数据
                        };
                        /*产品图片放大*/
                        $(document).ready(function ($) {
                $('#etalage').etalage({
                thumb_image_width: 418,
                        thumb_image_height: 380,
                        source_image_width: 800,
                        source_image_height: 800,
                        click_callback: function (image_anchor, instance_id) {
                        alert('回调函数:\nYou clicked on an image with the anchor: "' + image_anchor + '"\n(in Etalage instance: "' + instance_id + '")');
                        }
                });
                        //商品规格选择
                        $(".filterSpec a.goodsSpec").click(function () {
                $(".filterSpec li").removeClass("disabled");
                        $(this).parents('li').addClass("curr");
                        $(this).parents('li').siblings().removeClass("curr");
                        //将属性中的图片，放到放大镜位置显示
                        var propertyPic = $(this).attr("data-pic");
                        if (propertyPic) {
                var addHtml = '&lt;li class="etalage_thumb etalage_thumb_active after_add" ' +
                        'style="background-image: none; display: list-item; opacity: 1;"&gt;' +
                        '&lt;img src="' + showImg(propertyPic, 'c_fill,h_380,w_400') + '" class="etalage_thumb_image"' +
                        ' style="display: inline; width: 418px; height: 380px; opacity: 1;"&gt;&lt;/li&gt;';
                        $("#etalage &gt; li").removeClass('etalage_thumb_active');
                        $("#etalage .after_add").remove();
                        $("#etalage").append(addHtml);
                }
                //获取库存
                var goodsSpec = getGoodsSpec();
                        if (goodsSpec) {
                $("#goods_stock").html(goodsSpec.stock);
                        if (goodsSpec.stock & lt; = 0) {
                $(this).parents('li').removeClass("curr").addClass("disabled");
                } else {
                spec.id = goodsSpec.id;
                        spec.stock = goodsSpec.stock;
                        spec.price = goodsSpec.price;
                }
                }
                });
                        //添加到购物车
                        $(".addCart").click(function(){
                if (!checkSpecSelect()) return false;
                        addToCart(spec.id, parseInt($("#quantity").val()));
                        return false;
                });
                        //特殊商品，立即购买
                        $(".buy_special").click(function(){
                if (!checkSpecSelect()) return false;
                        var url = commonVar.addCartUrl;
                        $.getJSON(url,
                        {
                        goods_id: spec.goods_id,
                                quantity: parseInt($("#quantity").val()),
                                spec_id: spec.id,
                                store_id:spec.store_id
                        }, function (data) {
                        if (data.success) {
                        window.location.href = 'http://www.g-emall.com/orderFlow/single.html?goods_id=' + spec.goods_id + '&amp;spec_id=' + spec.id;
                        } else {
                        alert(data.error);
                        }
                        });
                        return false;
                });
                        //合约机
                        $(".buy_hyj").click(function(){
                if (!checkSpecSelect()) return false;
                        var url = commonVar.addCartUrl;
                        $.getJSON(url,
                        {
                        goods_id: spec.goods_id,
                                quantity: 1,
                                spec_id: spec.id,
                                store_id:spec.store_id
                        }, function (data) {
                        if (data.success) {
                        window.location.href = 'http://www.g-emall.com/heyueji/xuanhao.html?id=' + spec.goods_id + '&amp;spec_id=' + spec.id;
                        } else {
                        alert(data.error);
                        }
                        });
                        return false;
                });
                });
                        // 商品数量选择判断
                        $('.increase').click(function () {
                var num = parseInt($('#quantity').val());
                        var max = parseInt($('#goods_stock').text());
                        if (num & lt; max) {
                $('#quantity').val(num + 1);
                }
                });
                        $('.decrease').click(function () {
                var num = parseInt($('#quantity').val());
                        if (num & gt; 1) {
                $('#quantity').val(num - 1);
                }
                });
                        $("#quantity").keyup(function () {
                if (!this.value.match(/^[0-9]+?$/)) {
                this.value = 1;
                }
                }).blur(function () {
                if (!this.value.match(/^[0-9]+?$/)) {
                this.value = 1;
                }
                }).change(function () {
                var stock = $('#goods_stock').text();
                        if (parseInt(this.value) & gt; parseInt(stock)) {
                alert('最大库存只有' + stock + '件');
                        this.value = stock;
                }
                });
                        /* 这个地方可能会要加ajax提交  来显示购物车购买几种商品  和总价  可以改上面的那个方法.  这下面的只是演示效果用*/
                                function addToCart(spec_id, quantity) {
                                var url = commonVar.addCartUrl;
                                        $.getJSON(url,
                                        {goods_id: spec.goods_id, quantity: quantity, spec_id: spec_id, store_id:spec.store_id}, function (data) {
                                        if (data.success) {
                                        $('#bold_num').html(data.num);
                                                $('#bold_price').html(data.price);
                                                $('#mian_botom_cartcount').html(data.num); //更新右下角购物车的数量
                                                $('#main_top_cart_count').html(data.num); //更新顶部购物车的数量
                                                $('#messageDlg').show('slow');
                                                // 头部加载购物车信息
                                                getCartInfo();
                                        } else {
                                        alert(data.error);
                                        }
                                        });
                                }
                        /**
                         * 生成基于URL的图片处理 的网址
                         * @param  url  图片地址
                         * @param params 以逗号分隔的参数  see:http://avnpc.com/pages/evathumber
                         * @returns {string}
                         */
                        function showImg(url, params) {
                        return url.slice(0, - 4) + ',' + params + url.slice( - 4);
                        }

                        /**
                         * 获取已选择规格组合的相关价格、库存、goods_spec_id数据
                         */
                        function getGoodsSpec() {
                        //已选择的规格id
                        var selectedSpecIds = [];
                                $(".filterSpec li.curr a.goodsSpec").each(function () {
                        selectedSpecIds.push(parseInt($(this).attr('data-id')));
                        });
                                for (var x in spec.goodsSpec) {
                        if (!isNaN(x)) {
                        var goodsSpecArray = [];
                                var spec_value = spec.goodsSpec[x].spec_value;
                                for (var y in spec_value) {
                        goodsSpecArray.push(parseInt(y));
                        }
                        if (goodsSpecArray.sort().toString() == selectedSpecIds.sort().toString()) {
                        return spec.goodsSpec[x];
                        }
                        }
                        }
                        return false;
                        }
                        /**
                         * 检查 商品规格的选择
                         * @returns {boolean}
                         */
                        function checkSpecSelect(){
                        if ($(".filterSpec li a.goodsSpec").size() & gt; 0 & amp; & amp; $(".filterSpec li.curr a.goodsSpec").size() != spec.specType){
                        alert("请选择相关规格");
                                return false;
                        }
                        var quantity = parseInt($("#quantity").val());
                                if (quantity & lt; 1) {
                        alert("请填写购买数量");
                                $("#quantity").val('1');
                                return false;
                        }
                        var max = parseInt($('#goods_stock').text());
                                if (quantity & gt; max) {
                        alert("您购买的商品数量，超出了该商品库存，请您重新选择商品数量");
                                return false;
                        }
                        return true;
                        }
            </script>        </div>
        <div class="prodRight">
            <div class="prodSec">
                <div class="tit">
                    <p class="secSeller">安全认证商家</p>
                    <p class="secSellerEn">Safety CE business</p></div>
                <div class="sellerAbout">
                    <p class="compName">药品保健</p>
                    <ul class="evaluate clearfix">
                        <li class="like">0</li>
                        <li class="like2">0</li>
                        <li class="like3">0</li>
                    </ul>
                    <ul class="der clearfix">
                        <li>描述相符</li>
                        <li>服务态度</li>
                        <li class="margRig">发货速度</li>
                    </ul>

                    <span id="star1" title="Not rated yet!" style="width: 100px;"><img src="http://www.g-emall.com/js/raty/lib/img/star-off.png" alt="1" title="Not rated yet!">&nbsp;<img src="http://www.g-emall.com/js/raty/lib/img/star-off.png" alt="2" title="Not rated yet!">&nbsp;<img src="http://www.g-emall.com/js/raty/lib/img/star-off.png" alt="3" title="Not rated yet!">&nbsp;<img src="http://www.g-emall.com/js/raty/lib/img/star-off.png" alt="4" title="Not rated yet!">&nbsp;<img src="http://www.g-emall.com/js/raty/lib/img/star-off.png" alt="5" title="Not rated yet!"><input type="hidden" name="score" readonly="readonly"></span>
                    <strong>  0分</strong>

                    <script>
                                // $('#star1').raty({readOnly: true, path: 'http://www.g-emall.com/js/raty/lib/img/', score: 0});
                    </script>
                    <div class="goShop">
                        <a href="#" class="inShop">进入店铺</a>            <!--<a href="#" class="keepShop">收藏店铺</a>-->
                    </div>
                </div>
            </div>        </div>
    </div>
    <div class="wrapperDetail">
        <div class="detailLeft">
            <div id="shopCat" class="productSort">
                <div class="notbg">
                    <i class="ico_cog"></i>
                    <h1>店铺分类</h1>
                    <b>classification of goods</b>
                </div>
                <div class="items">
                    <dl class="clearfix">
                        <dt>
                        <?php echo CHtml::link(Yii::t('site', '中西药品'), $this->createAbsoluteUrl('/yaopin/site/productListYaoPin01.html'), array('title' => Yii::t('site', '中西药品'), 'class' => 'on')); ?>
                        </dt>
                    </dl>
                    <dl class="clearfix">
                        <dt>
                        <?php echo CHtml::link(Yii::t('site', '健康保健'), $this->createAbsoluteUrl('/yaopin/site/productListYaoPin02.html'), array('title' => Yii::t('site', '健康保健'), 'class' => 'on')); ?>
                        </dt>
                    </dl>
                    <dl class="clearfix">
                        <dt>  
                        <?php echo CHtml::link(Yii::t('site', '医疗器械'), $this->createAbsoluteUrl('/yaopin/site/productListYaoPin03.html'), array('title' => Yii::t('site', '医疗器械'), 'class' => 'on')); ?>
                        </dt>
                    </dl>
                </div>
            </div>
        </div>
        <div class="detailRight">
            <div id="proTab" class="productService mt10"> 
                <ul id="menuTab" class="tabMenu clearfix">
                    <li class="" onclick="setTab('ul', 1, 5)" id="ul1"><span class="tbmenu01">商品介绍</span></li>
                    <li class="" onclick="setTab('ul', 2, 5)" id="ul2"><span class="tbmenu02">维权介入</span></li>
                    <li class="" onclick="setTab('ul', 3, 5)" id="ul3"><span class="tbmenu03">商品咨询</span></li>
                    <li class="" onclick="setTab('ul', 4, 5)" id="ul4"><span class="tbmenu04">累计评价（0）</span></li>
                    <li class="curr" onclick="setTab('ul', 5, 5)" id="ul5"><span class="tbmenu05">成交记录（0）</span></li>
                    <li onclick="$('body,html').animate({scrollTop:0}, 1000);" id="quickly" class="buyQuickly addCart" style="display: none;">立即购买</li>

                </ul> 
                <div class="tabMain"> 
                    <div id="tabCon_ul_1" class="tabCon curr" style="display: none;">	
                        <ul class="proDec">
                            <p>品牌名称：药品保健</p>
                        </ul>
                        <div class="Contain">
                            <p style="\&quot;margin:10px">
                                <span style="\&quot;font-size:13px;font-family:symbol;color:#666666\&quot;">·</span>品名称：太龙 双黄连口服液 20ml*...<br/>
                                <span style="\&quot;font-size:13px;font-family:symbol;color:#666666\&quot;">·</span>产品剂型: 口服液<br/>
                                <span style="\&quot;font-size:13px;font-family:symbol;color:#666666\&quot;">·</span>使用剂量: 一次20毫升（2支），一日3次：小儿酌减<br/>
                                <span style="\&quot;font-size:13px;font-family:symbol;color:#666666\&quot;">·</span>品牌: 太龙<br/>
                                <span style="\&quot;font-size:13px;font-family:symbol;color:#666666\&quot;">·</span>套餐类型: 标准装<br/>
                                <span style="\&quot;font-size:13px;font-family:symbol;color:#666666\&quot;">·</span>有效期: 24个月<br/>
                                <span style="\&quot;font-size:13px;font-family:symbol;color:#666666\&quot;">·</span>用法: 口服<br/>
                                <span style="\&quot;font-size:13px;font-family:symbol;color:#666666\&quot;">·</span>药品名称: 双黄连口服液<br/>
                                <span style="\&quot;font-size:13px;font-family:symbol;color:#666666\&quot;">·</span>药品通用名: 双黄连口服液<br/>
                                <span style="\&quot;font-size:13px;font-family:symbol;color:#666666\&quot;">·</span>适用人群: 不限<br/>
                                <span style="\&quot;font-size:13px;font-family:symbol;color:#666666\&quot;">·</span>批准文号: 国药准字Z41020565<br/>
                                <span style="\&quot;font-size:13px;font-family:symbol;color:#666666\&quot;">·</span>生产企业: 河南太龙药业股份有限公司<br/>
                                <span style="\&quot;font-size:13px;font-family:symbol;color:#666666\&quot;">·</span>规格: 20ml*10支/盒<br/>
                                <span style="\&quot;font-size:13px;font-family:symbol;color:#666666\&quot;">·</span>类别: 中药<br/>
                            </p>
                            <p>
                                <img title="1.png" style="float:none;" src="http://img03.taobaocdn.com/imgextra/i3/1699086763/T28WROXABaXXXXXXXX_!!1699086763.jpg"></p>
                            <p>
                                <img title="5.jpg" style="float:none;" src="http://img02.taobaocdn.com/imgextra/i2/1699086763/T2Ytp9XrJaXXXXXXXX_!!1699086763.jpg"></p>
                            <p>
                                <img title="2.png" style="float:none;" src="http://img02.taobaocdn.com/imgextra/i2/1699086763/T2cGaUXc0cXXXXXXXX_!!1699086763.jpg"></p>
                            <p><br></p><p><br></p><p><br></p><p><br></p><p style="\&quot;margin:10px"><span style="\&quot;font-size:12px;font-family:宋体;color:#666666\&quot;"><br></span><br></p><p><br></p></div>
                    </div>                    <div id="tabCon_ul_2" class="tabCon" style="display: none;">
                        <ul class="wq">
                            <li>
                                <div class="wqTit">
                                    <span class="ico_onlineServ"></span>
                                    <span class="Serv">在线服务</span>
                                </div>
                                <div class="wqCon">
                                    <h3>在线客服：通过在线解答的方式为您提供咨询服务</h3>
                                    <div class="dianhua-wq  kefuinfo"><div class="wqkefu"><span style="font-size:14px;">在线客服<br></span></div><div class="wqcom"><p><span style="font-size:14px;">在线客服：通过在线解答的方式为您提供咨询服务</span></p><p><span style="font-size:14px;">工作时间：周一至周日 AM 9：30 - AM 12：00 PM 13：30 - PM 18：30</span></p><p><span style="font-size:14px;">服务范围：售前、售后、维权</span></p></div></div><div class="dianhua-wq rig"><div class="phone"><span style="font-size:14px;">020-29106899</span></div><div class="wqcom"><p><span style="font-size:14px;">电话客服：通过电话的方式为您提供咨询服务</span></p><p><span style="font-size:14px;">工作时间：周一至周日 AM 9：30 - AM 12：00 PM 13：30 - PM 18：30</span></p><p><span style="font-size:14px;">服务范围：售前，售后、维权</span></p></div></div><p><br></p>                <p class="service clearfix">
                                    </p>
                                </div>
                            </li>
                            <li class="noline">
                                <div class="wqTit">
                                    <span class="ico_phoServ"></span>
                                    <span class="Serv">电话服务</span>
                                </div>
                                <div class="wqCon">
                                    <h3>在线客服：通过在线解答的方式为您提供咨询服务</h3>
                                    <div class="dianhua-wq  kefuinfo"><div class="wqkefu"><span style="font-size:14px;">在线客服<br></span></div><div class="wqcom"><p><span style="font-size:14px;">在线客服：通过在线解答的方式为您提供咨询服务</span></p><p><span style="font-size:14px;">工作时间：周一至周日 AM 9：30 - AM 12：00 PM 13：30 - PM 18：30</span></p><p><span style="font-size:14px;">服务范围：售前、售后、维权</span></p></div></div><div class="dianhua-wq rig"><div class="phone"><span style="font-size:14px;">020-29106899</span></div><div class="wqcom"><p><span style="font-size:14px;">电话客服：通过电话的方式为您提供咨询服务</span></p><p><span style="font-size:14px;">工作时间：周一至周日 AM 9：30 - AM 12：00 PM 13：30 - PM 18：30</span></p><p><span style="font-size:14px;">服务范围：售前，售后、维权</span></p></div></div><p><br></p>                <h1>400-620-6899</h1>
                                </div>
                            </li>
                        </ul>
                    </div>                    <div id="tabCon_ul_3" class="tabCon clearfix" style="display: none;">
                        <div id="guestGookLists" class="">
                            <ul class="comments">
                                <span class="empty">对不起，目前还没有相关咨询信息！</span></ul><div title="/JF/60332.html" style="display:none" class="keys"></div>
                        </div>                            <div style="width:942px; margin: 0 auto; padding: 15px 0; overflow: hidden;" class="messConsulting">
                            <form method="post" action="/JF/60332.html" id="goods-form">
                                <div style="display:none"><input type="hidden" name="YII_CSRF_TOKEN" value="693182d23538b1ffcbef493cd7bc29ce4682c312"></div>                            <span class="title">咨询商品: </span>
                                <script>
                                                    //点击旁边的刷选验证码
                                                            function changeVeryfyCode() {
                                                            jQuery.ajax({
                                                            url: "http://member.g-emall.com/home/captcha/refresh/1",
                                                                    dataType: 'json',
                                                                    cache: false,
                                                                    success: function (data) {
                                                                    jQuery('#verifyCodeImg').attr('src', data['url']);
                                                                            jQuery('body').data('captcha.hash', [data['hash1'], data['hash2']]);
                                                                    }
                                                            });
                                                                    return false;
                                                            }
                                </script>
                                <textarea id="Guestbook_content" name="Guestbook[content]" class="mess_textbox"></textarea>                            <div style="display:none" id="Guestbook_content_em_" class="errorMessage"></div>                            <input type="hidden" id="Guestbook_goodsName" name="Guestbook[goodsName]" value="山东东阿阿胶250g铁盒正品阿胶块OTC滋阴补气血阿胶片">                            <div class="VerifiCode">
                                    <label class="required" for="Guestbook_verifyCode">验证码 <span class="required">*</span></label>：
                                    <input type="text" id="Guestbook_verifyCode" name="Guestbook[verifyCode]">&nbsp;
                                    <a style="cursor: pointer" class="changeCode" onclick="changeVeryfyCode()">
                                        <img src="http://www.g-emall.com/goods/captcha.html?v=54bdf4eb4f4dd" id="verifyCodeImg" title="点击换图" alt="点击换图">                                </a>
                                    <div style="display:none" id="Guestbook_verifyCode_em_" class="errorMessage"></div>                            </div>
                                <p><input type="submit" value="发表咨询" name="yt0" class="btnMessConsult"></p>
                            </form>                        </div>
                    </div>

                    <div id="tabCon_ul_4" class="tabCon" style="display: none;">
                        <div id="commentLists" class="">
                            <ul class="comments">
                                <span class="empty">对不起，目前还没有相关评论信息！</span></ul><div title="/JF/60332.html" style="display:none" class="keys"></div>
                        </div></div>                    <div id="tabCon_ul_5" class="tabCon" style="display: block;">
                        <div id="completeLists" class="">
                            <ul class="record">
                                <span class="empty">对不起，目前还没有相关成交记录信息！</span></ul><div title="/JF/60332.html" style="display:none" class="keys"></div>
                        </div></div>                </div> 
            </div> 

        </div>
    </div>
</div>

<input type="hidden" id="redirectUrl" value="">