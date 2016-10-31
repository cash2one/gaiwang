<?php
/** @var $this GoodsController */
Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/product_detail.js', CClientScript::POS_END);
//图片延迟加载
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/lazyLoad.js', CClientScript::POS_END);
//正则替换图片地址，做延迟加载
$goods['content'] =  preg_replace('/src="|\'('.str_replace('/','\/',IMG_DOMAIN).'.+?\.jpg|gif|bmp|bnp|png)"|\'/i','src="'.Yii::app()->theme->baseUrl.'/images/bgs/loading-img.gif""  class="lazy" data-url="${2}',$goods['content']);
?>
<script type="text/javascript">
    $(function() {
        LAZY.init();
        LAZY.run();
    });
</script>

<div class="gx-content clearfix">
  <div class="goods-left">
      <div class="gl-prodDisplay clearfix">
          <!--缩图开始-->
          <?php echo $this->renderPartial('_albums', array('gallery' => $gallery,'goods' => $goods)); //相册图片   ?>
          <!--缩图结束-->
          
          <input type="hidden" value="<?php echo $goods['id']; ?>" id="goodsId">
          <input type="hidden" value="1" id="clickTab">
          <div class="gl-prodDetails">
          </div>
          <!-- 添加到购物车提示框end -->
      </div>
      
      <div class="gl-main clearfix">
          <div class="gl-main-left">
              <div class="glm-shopInfo clearfix">
                  <div class="glm-shopInfo-title"><a href="<?php echo $this->createAbsoluteUrl('/shop/' . $this->store['id']);?>"><?php echo Yii::t('site', $this->store['name']);?></a></div>
                  <ul class="shopInfo-score clearfix">
                      <li><?php echo Yii::t('goods', '描述');?></li>
                      <li><?php echo Yii::t('goods', '服务');?></li>
                      <li><?php echo Yii::t('goods', '物流');?></li>
                      <li><span class="shopInfo-font2 description_match"></span></li>
                      <li><span class="shopInfo-font2 serivice_attitude"></span></li>
                      <li><span class="shopInfo-font3 speed_of_delivery"></span></li>
                  </ul>
                  <a href="<?php echo $this->createAbsoluteUrl('/shop/' . $this->store['id']);?>" title="" class="glm-shopInfo-but glm-shopInfo-but1"><?php echo Yii::t('goods', '进店逛逛');?></a>
                  <a href="javascript:void(0);" title="" class="glm-shopInfo-but glm-shopInfo-but2"><?php echo Yii::t('goods', '收藏店铺');?></a>
              </div>
              <div class="shopInfo-nav">
                  <div class="shopInfo-nav-title"><?php echo Yii::t('goods', '店铺分类'); ?></div>
                  <ul class="shopInfo-nav-list" id="shopCategory"></ul>
              </div>
              <div class="sellingPord">
                  <div class="shopInfo-nav-title"><?php echo Yii::t('category','热销商品')?></div>
                  <ul class="sellingPord-list" id="hotSales"></ul>
              </div>
              <div class="sellingPord">
                  <div class="shopInfo-nav-title"><?php echo Yii::t('goods','新品推荐')?></div>
                  <ul class="sellingPord-list" id="newGoods"></ul>
              </div>
          </div>
          <div class="gl-main-right">
              <div class="pordDetails-title clearfix">
                  <ul class="pordDetailsTab">
                      <li class="pdTab1 curr" onclick="setTab2('pdTab',1,4)"><?php echo Yii::t('goods', '商品详情'); ?></li>
                      <li class="pdTab2" onclick="setTab2('pdTab',2,4)"><?php echo Yii::t('goods', '累计评价'); ?><span id="ljpj">(0)</span></li>
                      <li class="pdTab3" onclick="setTab2('pdTab',3,4)"><?php echo Yii::t('goods', '维权介入'); ?></li>
                      <li class="pdTab4" onclick="setTab2('pdTab',4,4)"><?php echo Yii::t('goods', '商品咨询'); ?><span id="spzx">(0)</span></li>
                  </ul>
                  <div class="phone-order">
                      <?php /*echo Yii::t('goods','手机下单');*/?><!--<div class="phone-order-erw"><ico></ico></div>
                      <div class="phone-order-erwBig">
					  <?php /*$this->widget('comext.QRCodeGenerator', array(
							'data' => Yii::app()->createAbsoluteUrl('m/goods/index/'.$goods['id']),
							'size' => 3.0,
						));*/?>
                     </div>-->
                  </div>
              </div>
              <div class="pordDetails-content">
                  <div id="tabCon_pdTab_1">
                  <?php echo $this->renderPartial('_introduction', array('goods' => $goods)); //商品介绍   ?>
                  </div>
                  <div id="tabCon_pdTab_2">
                      <div class="pdTab2-comment clearfix">
                          <div class="pdTab2-comment-left">
                              <?php echo Yii::t('goods','与描述相符');?>:<div id="goods_pj"></div>
                          </div>
                          <div class="pdTab2-comment-right">
                              <?php echo Yii::t('goods','买家印象');?>:<p></p>
                              <ul class="clearfix" id="buyers_impression">
                                  
                              </ul>
                          </div>
                      </div>
                      <div class="pdTab2-tab clearfix">
                          <ul>
                              <li id="com1" class="curr" onclick="setTab('com',1,2)"><?php echo Yii::t('goods','全部评价');?><span id="ljpj2">(0)</span></li>
                              <li id="com2" onclick="setTab('com',2,2)"><?php echo Yii::t('goods','有图评价');?><span id="ljpj_img">(0)</span></li>
                          </ul>
                          <span class="pdTab2-tab-but" id="orderTime" tag="1"><?php echo Yii::t('goods','按时间排');?></span>
						  <span class="pdTab2-tab-but" id="orderUpvote" tag="1"><?php echo Yii::t('goods','按点赞排');?></span>
                      </div>
                      <div class="pdTab2-tab-content">
                        <div id="tabCon_com_1"></div>
                        <div id="tabCon_com_2"></div>
                      </div>
                  </div>
                  <div id="tabCon_pdTab_3"></div>
                  <div id="tabCon_pdTab_4">
                      <div class="pdtab4-content" id="guestbookcontent">
                          <p class="pdtab4-info1"><?php echo Yii::t('goods', '温馨提示:因厂家更改产品包装、产地或者更换随机附件等没有任何提前通知，且每位咨询者购买情况、提问时间等不同，
                          为此以下回复仅对提问者3天内有效，其他网友仅供参考！若由此给您带来不便请多多谅解，谢谢！');?></p>
                          <ul id="guestbookview">  
                          </ul>
                          <iframe src="<?php echo Yii::app()->createUrl('product/guest',array('id'=>$goods['id'],'goodsName'=>$goods['name']))?>" width="735px" height="360px" marginwidth=0 marginheight=0></iframe>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="goods-right">
      <div class="gr-title"><span><?php echo Yii::t('goods', '猜你喜欢');?></span></div>
      <ul class="gr-list" id="guest-you-like">
          
      </ul>
      <a href="javascript:getYouLike();" class="gr-renovateBut"><?php echo Yii::t('goods', '换一批');?></a>
  </div>
  </div>
  
<input type="hidden" value="" id="redirectUrl">
<!-- 浮动菜单 -->
<div class="pordDisplay-floatNav">
    <div class="floatNav-main">
        <div class="glm-shopInfo-title glm-shopInfo-title2"><?php echo Yii::t('site', $this->store['name']);?></div>
        <div class="pordDetails-title pordDetails-title2 clearfix">
            <ul class="pordDetailsTab">
                <li class="pdTab1 curr" onclick="setTab2('pdTab',1,4),pdTabclick()"><?php echo Yii::t('goods', '商品详情'); ?></li>
                <li class="pdTab2" onclick="setTab2('pdTab',2,4),pdTabclick()"><?php echo Yii::t('goods', '累计评价'); ?><span id="ljpjnav">(0)</span></li>
                <li class="pdTab3" onclick="setTab2('pdTab',3,4),pdTabclick()"><?php echo Yii::t('goods', '维权介入'); ?></li>
                <li class="pdTab4" onclick="setTab2('pdTab',4,4),pdTabclick()"><?php echo Yii::t('goods', '商品咨询'); ?><span id="spzxnav">(0)</span></li>
            </ul>
            <div class="phone-order">
                <?php /*echo Yii::t('goods','手机下单');*/?><!--<div class="phone-order-erw"><ico></ico></div>
                <div class="phone-order-erwBig">
                <?php /*$this->widget('comext.QRCodeGenerator', array(
                        'data' => Yii::app()->createAbsoluteUrl('m/goods/index/'.$this->goods['id']),
                        'size' => 3.0,
                    ));*/?>
                </div>-->
            </div>
        </div>
        <a href="javascript:;" title="<?php echo Yii::t('goods', '加入购物车'); ?>" class="pord-but pord-shoppingCart pord-shoppingCart2" id="pord-shoppingCart2"><?php echo Yii::t('goods', '加入购物车'); ?></a>
    </div>
</div>

<!--提示框start-->
<div class="prompt-float">
    <div class="prompt-float-content">
        <div class="prompt-float-title">
            <?php echo Yii::t('goods', '提示'); ?>
            <span class="prompt-float-close"></span>
        </div>
        <span class="prompt-info2"></span>
        <input type="hidden" id="isjump" value="0" />
        <input type="button" onclick="goodsJump();" value="<?php echo Yii::t('goods', '确定'); ?>" class="prompt-float-but"/>
    </div>
</div>
<!--提示框end-->
    
<script type="text/javascript">
    /**获取价格信息**/
     $(document).ready(function(){
        $.ajax({
            type:"GET",
            cache : false,
            async : false,
            data:{
                skip: 1,
                id: <?php echo $goods['id']; ?>
            },
            url:"<?php echo $this->createAbsoluteUrl('goods/GetGoodsv');?>",
            success:function(json) {
                $(".gl-prodDetails").prepend(json);
            }
        });
		getYouLike(0);
		
		//收藏本店
		$(".glm-shopInfo-but2").click(function(){
			if(!$('#uuuid').val()){
				$('#isjump').val('1');
			    $('.prompt-info2').text('<?php echo Yii::t('goods', '请先登录,再进行操作!'); ?>');
	            $(".prompt-float,.pordShareBg").show();
				return ;
			}
			
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createAbsoluteUrl('/member/StoreCollect/collect');?>',
				data: {'id': <?php echo $this->store['id'];?>},
				dataType: 'jsonp',
				jsonp:"jsoncallBack",
				jsonpCallback:"dealCollect",
				success: function (data){
				}
			});
		});
		
		//收藏商品
		$(".gl-prodDispla-collect").click(function(){
			if(!$('#uuuid').val()){
				$('#isjump').val('1');
			    $('.prompt-info2').text('<?php echo Yii::t('goods', '请先登录,再进行操作!'); ?>');
	            $(".prompt-float,.pordShareBg").show();
				return;	
			}
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createAbsoluteUrl('/member/GoodsCollect/collect');?>',
				data: {'id': <?php echo $this->goods['id'];?>},
				dataType: 'jsonp',
				jsonp:"jsoncallBack",
				jsonpCallback:"dealCollect",
				success: function (data){
				}
			});
		});
		
    });
	
    /**获取店铺库存、评价等信息**/
    $(document).ready(function(){
            jQuery.ajax({
                type:"get",async:false,timeout:5000,dataType: "json",
                url:"<?php echo $this->createAbsoluteUrl("/product/stockScore",array('goodId'=>$goods['id'],'storeId'=>$goods['store_id']));?>",
                error:function(request,status,error){
                    layer.alert(request.responseText);
                },
                success:function(data){
					    var keyWords = data.globalkeywords;
						    keyWords = keyWords.replace(/<li>/g, '');
							keyWords = keyWords.replace(/<\/li>/g, '');
                        $('.gx-top-search-tj').append(keyWords);
                        $('#ljpj,#ljpj2,#ljpjnav').html('('+data.count+')');
						$('#spzx,#spzxnav').html('('+data.consult+')');
						$('#ljpj_img').html('('+data.countImg+')');
/* 						$('.description_match').prepend(data.descriptionMatch);
						$('.serivice_attitude').prepend(data.seriviceAttitude);
						$('.speed_of_delivery').prepend(data.speedDelivery); */
						$('#goods_pj').prepend(data.goodsAvgScore);
                }
            });
        }
    );

        /*改变盖象图表默认链接*/
        $(function() {
            var langs = "<?php echo Yii::app()->language?>";
            var domain = "<?php echo DOMAIN?>";
            var good_id = $('#goodsId').attr('value');
            var href = "";
            if(langs == "zh_tw"){
                href = domain+"/"+"index_tw.html";
            }else if(langs == "en"){
                href = domain+"/"+"index_en.html";
            }else{
                href = domain;
            }
            $(".logo fl").attr("href",href);
        });

    /**更新浏览记录**/
    $(function(){
            jQuery.ajax({
                type:"get",async:false,timeout:5000,
                url:"<?php echo $this->createAbsoluteUrl("/product/view",array('id'=>$goods['id']));?>",
//                data: "language="+lang,
                error:function(request,status,error){
                    layer.alert(request.responseText);
                },
                success:function(){
                }
            });
        }
    );

    /**店铺分类**/
    $(function(){
        jQuery.ajax({
            type:"get",async:false,timeout:5000,
            url:"<?php echo $this->createAbsoluteUrl("/product/category",array('id'=>$this->store['id']));?>",
            error:function(request,status,error){
                layer.alert(request.responseText);
            },
            success:function(data){
                $('#shopCategory').append(data);
            }
        });
    });

    /**火热销量**/
    $(function(){
        jQuery.ajax({
            type:"get",async:false,timeout:5000,
            url:"<?php echo $this->createAbsoluteUrl("/product/hotSales",array('id'=>$this->store['id']));?>",
//                data: "language="+lang,
            error:function(request,status,error){
                layer.alert(request.responseText);
            },
            success:function(data){
                $('#hotSales').append(data);
            }
        });
    });
	
	/**新品推存*/
   $(function(){
		  jQuery.ajax({
			  type:"get",async:false,timeout:5000,
			  url:"<?php echo $this->createAbsoluteUrl("/product/newGoods",array('id'=>$this->store['id']));?>",
			  error:function(request,status,error){
				  layer.alert(request.responseText);
			  },
			  success:function(data){
				  $('#newGoods').append(data);
			  }
		  });
	  });
	
    /**维权介入**/
    adults = true;
    $('.pdTab3').click(function(){
        if(adults == true){
            jQuery.ajax({
                type:"get",async:false,timeout:5000,
                url:"<?php echo $this->createAbsoluteUrl("/product/adults");?>",
//                data: "language="+lang,
                error:function(request,status,error){
                    layer.alert(request.responseText);
                },
                success:function(data){
                    $('#tabCon_pdTab_3').append(data);
                }
            });
            adults = false;
        }
    });

    /**商品咨询列表**/
    guest = true;
    $('.pdTab4').click(function(){
        if(guest == true){
            jQuery.ajax({
                type:"get",async:false,timeout:5000,
                url:"<?php echo $this->createAbsoluteUrl("/product/guestList",array('id'=>$goods['id']));?>",
//                data: "language="+lang,
                error:function(request,status,error){
                    layer.alert(request.responseText);
                },
                success:function(data){
                    $('#guestbookview').prepend(data);
                }
            });
            guest = false;
        }
    });

    /**商品评论列表**/
    var commemt = true;
    $('.pdTab2,#com1').click(function(){
		var ou = $('#orderUpvote').attr('tag');
		var ot = $('#orderTime').attr('tag');
		var clickTab =  $('#clickTab').val();
		
		if(clickTab == 1){ ou = 0;}else{ ot = 0;}
        //if(commemt == true){
            jQuery.ajax({
                type:"get",async:false,timeout:5000,
                url:"<?php echo $this->createAbsoluteUrl("/product/commentListNew",array('id'=>$goods['id']));?>"+'?vote='+ou+'&time='+ot,
                error:function(request,status,error){
                    layer.alert(request.responseText);
                },
                success:function(data){
                    $('#tabCon_com_1').html(data);
                }
            });
            //commemt = false;
        //}
    });
	
	/**商品评论有图片列表**/
    var commemt2 = true;
    $('#com2').click(function(){
		var ou = $('#orderUpvote').attr('tag');
		var ot = $('#orderTime').attr('tag');
		var clickTab =  $('#clickTab').val();
		
		if(clickTab == 1){ ou = 0;}else{ ot = 0;}
        //if(commemt2 == true){
            jQuery.ajax({
                type:"get",async:false,timeout:5000,
                url:"<?php echo $this->createAbsoluteUrl("/product/imgCommentListNew",array('id'=>$goods['id']));?>"+'?vote='+ou+'&time='+ot,
                error:function(request,status,error){
                    layer.alert(request.responseText);
                },
                success:function(data){
                    $('#tabCon_com_2').html(data);
					$('#tabCon_com_2').css('display','block');
                }
            });
            //commemt2 = false;
        //}
    });
	
	/**猜你喜欢*/
	function getYouLike(k){
		var likeUrl = k>0 ? '<?php echo $this->createAbsoluteUrl("/Goods/GetYouLike",array('id'=>$goods['id'], 'flash'=>1));?>&t='+Math.random() : '<?php echo $this->createAbsoluteUrl("/Goods/GetYouLike",array('id'=>$goods['id']));?>?t='+Math.random();
	    jQuery.ajax({
                type:"get",async:false,timeout:5000,
                url:likeUrl,
                error:function(request,status,error){
                    layer.alert(request.responseText);
                },
                success:function(data){
                    $('#guest-you-like').html(data);
                }
            });	
	}
	
	/*买家印象*/
	$(function(){
		jQuery.ajax({
                type:"get",async:false,timeout:5000,
                url: "<?php echo $this->createAbsoluteUrl("/Goods/BuyesImpression",array('id'=>$goods['id']));?>",
                error:function(request,status,error){
                    layer.alert(request.responseText);
                },
                success:function(data){
                    $('#buyers_impression').html(data);
                }
            });
	});
	
	/*点赞*/
	function doVote(v){
	    $.ajax({
			type: 'GET',
			url: "<?php echo $this->createAbsoluteUrl("/product/userVote");?>",
			data: {'val':v},
			cache: false,
			dataType: 'json',
			success: function (data){
				if(data.success == true){
					var arr = v.split('|');
					var val = parseInt($('.pdTab2-tab-content').find('.vote_'+arr[0]).html()) + 1;
				    $('.pdTab2-tab-content').find('.vote_'+arr[0]).html(val);
				}
				$('.prompt-info2').text(data.msg);
				$('#isjump').val('0');
	            $(".prompt-float,.pordShareBg").show();
			}
	  });	
	}
</script>