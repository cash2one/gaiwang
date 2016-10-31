
<!-- 购物车 数量 改变  wyee 2015/3/31 -->
<script type="text/javascript">

//购物车数量显示

function CartNumUpdate(type,goodId,specId,stock){
	var goodId=parseInt(goodId);
	var specId=parseInt(specId);
	var specNewId=parseInt($("#specId_"+goodId+"-"+specId).val());
	var goodsType=$("#goodsType_"+goodId+"-"+specId).val();
	var setNum=parseInt($("#quantity_"+goodId+"-"+specId).val());
	var stock=parseInt(stock);
	var maxNum=50;
	if(type=='2'){
		if(goodsType=='hb_goods'){ 
                alert("红包商品只能购买一个");
                $('#quantity_'+goodId+"-"+specId).val(1);
		  }else if(setNum < maxNum && setNum < stock){
			setNum++;
			$("#quantity_"+goodId+"-"+specId).val(setNum);
         }else{
			alert("库存不足，最大库存只有"+setNum+"件");
		}	
	 }
	if(type=='1'){
		if(setNum>1){
			setNum--;
			$("#quantity_"+goodId+"-"+specId).val(setNum);
		}else{
			alert("至少要选择一件商品");
		}
	}
	updateData(goodId,specNewId,setNum);
}

//购物车Ajax实现数量改变
function updateData(goodId,specId,num){
	var goodId=parseInt(goodId);
	var specId=parseInt(specId);
	var num=parseInt(num);
	$.ajax({
		 type: "POST",
         url: "<?php echo $this->createAbsoluteUrl('cart/updateCart') ?>",
         data:{
             "YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken ?>",
             "goodId": goodId,
             "specId": specId,
             "num":num,
             "actionType":1,
         },
         dataType:"json",
         success: function(res){
             if(res.msgCode==1){
                   alert(res.msg);
                 } 
         },
         error: function(res) {
             alert(res.msg);
         },
	});
}

//购物车商品属性显示，Ajax读取数据显示在遮罩层
 function editSpec(goodId,specId,specData){
                    var goodId=goodId;
                    var specId=specId;
                    var specData=specData;
                    $.ajax({
                        type: "POST",
                        url: "<?php echo $this->createAbsoluteUrl('cart/editSpec') ?>",
                        data:{
                            "YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
                            "goodId": goodId,
                            "specId": specId,
                            "specData":specData,
                        },
                        dataType:"json",
                        success: function(msg) {
                            var tt=msg;
                            var thumbnail = "<?php echo DOMAIN . '/';?>" + tt.thumbnail;
                            var obj = $('.setColorItem .OSProducts');
                            var p = $('.setColorItem .ColorList');
                            var hidden = '<input type="hidden" id="spec_id" value="' + specId + '"/><input type="hidden" id="g_id" value="' + goodId+ '"/><input type="hidden" id="goods_type" value="' + tt.flag+ '"/>';
                            obj.append(hidden);
                            obj.find('img').attr('src', thumbnail);
                            obj.find('a').attr('title', tt.name);
                            obj.find('.OSProductsInfo').text(tt.name);
                            obj.find('.d32f2f').text('￥' + tt.price);
                            obj.find('.SCPriced').text('￥' + tt.market_price);
                            obj.find('.specData').text(specData);
                            var code = " ";
                            for (key in tt.spec) {
                                if (key != 'ori_spec') {
                                    code += '<p class="specName">' + key + '</p><p class="specValue clearfix">';
                                }
                                for (k in tt.spec[key]) {
                                    if (key != 'ori_spec') {
                                        code += '<span onclick="chooseSpec(this)" data-id="'+ k +'">' + tt.spec[key][k] + '</span>';
                                    }
                                }
                            }
                            code += '</p>';
                            p.html(code);
                            for (key in tt.spec) {
                                if (key == 'ori_spec') {
                                    for (k in tt.spec[key]) {
                                        var pp = p.find('.specValue span');
                                        pp.each(function (i) {
                                            if (pp.eq(i).text() == $.trim(tt.spec[key][k])) {
                                                pp.eq(i).addClass('SelectColorItem').attr('data-stock',"1");
                                            }
                                        });
                                    }
                                }
                            }
                        },
                         error: function(msg) {
                                        alert(msg.errorMsg);
                        },
                    });

                    $(".setMask").animate({
                        bottom: "0px"
                    });
                    $(".setColorItem").animate({
                        bottom: "0px"
                    }); 
                 
               }

 //购物车商品属性改变
 function updateAction(){
       var goodId=$("#g_id").val();//商品Id
       var specId=$("#spec_id").val();//商品属性
       var specValue='';//商品属性值
       $('.SelectColorItem').each(function (i) {
    	   specValue += $('.SelectColorItem').eq(i).text() + '|';
       });
       $.ajax({
    		 type: "POST",
             url: "<?php echo $this->createAbsoluteUrl('cart/updateCart') ?>",
             data:{
                 "YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken ?>",
                 "goodId": goodId,
                 "specId": specId,
                 'specValue':specValue,
                 "actionType":2,
             },
             dataType:"json",
             success: function(res){
            	 $('#specNew_'+goodId+"-"+specId).html(res.msg);
            	 $('#specId_'+goodId+"-"+specId).val(res.specNewId);
             },
             error: function(res) {
                 alert(res.msg);
                  },
    	}); 
 }

 //删除购物车商品

 function deleteRecord() {
     alert('您确定要删除购物车商品吗？');
     var arr = new Array();
     $('.cartThisSel').each(function () {
         if ($(this).attr("num") == 2) {
             var goods_id = $(this).attr("data_goodid");
             arr.push(goods_id);
         }
     });
     //ajax删除选中的商品
     $.post("<?php echo Yii::app()->createUrl('/m/cart/delete'); ?>", {goods_id: arr, YII_CSRF_TOKEN: "<?php echo Yii::app()->request->csrfToken;?>"}, function (msg) {
         alert(msg);
         window.location.reload();
     });
 }
 
//属性选择样式显示
 function chooseSpec(obj) {
     var p = $(obj);
     if (p.hasClass("SelectColorItem")) {
         p.removeClass("SelectColorItem");
         p.removeAttr("data-stock");
     } else {
         p.addClass("SelectColorItem").siblings("span").removeClass("SelectColorItem");
         p.attr("data-stock", 1).siblings("span").removeAttr("data-stock");
     }
 }

//删除失效产品
 function deleteUnValidGoods(){
	    confirm('您确定要清空失效商品吗');
	    var goodsId=$("#goodsIdStrs").val();
	    $.post("<?php echo Yii::app()->createUrl('/m/cart/deleteUnValiad'); ?>", {goods_id: goodsId, YII_CSRF_TOKEN: "<?php echo Yii::app()->request->csrfToken;?>"}, function (msg) {
	         alert(msg);
	         window.location.reload();
	     });
     }


</script>
