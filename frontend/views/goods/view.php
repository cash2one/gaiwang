<?php
/** @var $this GoodsController */
Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/product_detail.js');
//图片延迟加载
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/lazyLoad.js');
//正则替换图片地址，做延迟加载
$goods['content'] =  preg_replace('/src="|\'('.str_replace('/','\/',IMG_DOMAIN).'.+?\.jpg|gif|bmp|bnp|png)"|\'/i','src="'.DOMAIN.'/images/bgs/loading-img.gif""  class="lazy" data-url="${2}',$goods['content']);
?>
<script type="text/javascript">
    $(function() {
        LAZY.init();
        LAZY.run();
    });
</script>
<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>style.css" />
<div class="main">
    <div class="wrapperProd clearfix">
        <div class="prodLeft">
            <?php echo $this->renderPartial('_albums', array('gallery' => $gallery,'goods' => $goods)); //相册图片   ?>
        </div>
        <div class="prodMidd">
            <input type="hidden" value="<?php echo $goods['id']; ?>" id="goodsId">
            <?php
            /*echo $this->renderPartial('_core', array(
                'goods' => $goods,
                'goodsSpec'=>$goodsSpec,
//                'comments'=>$comments
            )); //商品信息
            */
            /*
            echo $this->renderPartial('_activity-0521-2', array(
                'goods' => $goods,
                'goodsSpec'=>$goodsSpec,
                'activityInfo'=>ActivityData::getGoodsInfo($goods['id'],3)
            )); //商品信息
            */
            ?>
        </div>
        <div class="prodRight">
            <?php echo $this->renderPartial('_storeinfo', array('design' => $design)); //商家信息   ?>
        </div>
    </div>
    <div class="wrapperDetail">
        <div class="detailLeft">
            <?php //echo $this->renderPartial('_storecategory', array('store' => $this->store)); //商家商品分类   ?>
            <?php
                //if($this->_beginCache('hotSales')){
                //    echo $this->renderPartial('_hotsales', array('goods' => $goods)); //热门销售
                 //   Tool::cache('goods');//设置缓存目录
                //    $this->endCache();
              //  }
            ?>
        </div>
        <div class="detailRight">
            <?php
            // <!--优惠券-->
//            $this->widget('application.components.CommonWidget', array(
//                'view' => 'coupon',
//                'modelClass' => 'CouponActivity',
//                'criteriaOptions'=>array(
//                    'select'=>'id,update_time,`name`,price,`condition`,valid_start,valid_end,sendout,excess,`status`,thumbnail,state',
//                    'order'=>'create_time DESC',
//                    'condition'=>'store_id=:storeId and status=:status and valid_end>=:endTime',
//                    'params'=>array(
//                        ':storeId'=>$this->store->id,
//                        ':status'=>CouponActivity::COUPON_STATE_YES,
//                        ':endTime'=>time(),
//                    ),
//                )
//            ));
            ?>
            <div class="productService" id="proTab">
                <ul class="tabMenu clearfix"id="menuTab">
                    <li id="ul1" onclick="setTab('ul', 1, 5)" class="curr"><span class="tbmenu01"><?php echo Yii::t('goods', '商品介绍'); ?></span></li>
                    <li id="ul2" onclick="setTab('ul', 2, 5)" class=""><span class="tbmenu02"><?php echo Yii::t('goods', '维权介入'); ?></span></li>
                    <li id="ul3" onclick="setTab('ul', 3, 5)" class=""><span class="tbmenu03"><?php echo Yii::t('goods', '商品咨询'); ?></span></li>
                    <li id="ul4" onclick="setTab('ul', 4, 5)" class=""><span class="tbmenu04"><?php echo Yii::t('goods', '累计评价'); ?>
                    <?php //if($this->_beginCache('commentsCount')){ echo $comments->totalItemCount; $this->endCache();} ?></span></li>
                    <li id="ul5" onclick="setTab('ul', 5, 5)" class="" style="display: none"><span class="tbmenu05"><?php echo Yii::t('goods', '成交记录'); ?>
                    （<?php  // 不显示成交记录 if($this->_beginCache('completesCount')){echo $completes->totalItemCount;$this->endCache();}  ?>）</span></li>

                    <?php if(ShopCart::checkHyjGoods($goods['id'])):?>
                        <style>
                            .heye a{color:#fff;}.heye a：visited{color:#fff;}.heye a:hover{color:#fff;}.heye a:active{color:#fff;}</style>
                        <li class="buyQuickly" id="quickly">
                            <font class="heye">
                                <a class="buy_hyj" href="<?php echo Yii::app()->createUrl('/heyueji/xuanhao',array('id'=>$goods['id'],'spec_id'=>$goods['goods_spec_id']));?>">
                                    <?php echo Yii::t('goods','选择号码和套餐');?>
                                </a>
                            </font>
                        </li>
                    <?php else:?>
                        <li class="buyQuickly addCart" id="quickly" onclick="$('body,html').animate({scrollTop:0},1000);"><?php echo Yii::t('goods', '立即购买'); ?></li>
                    <?php endif;?>

                </ul>
                <div class="tabMain">
                    <?php echo $this->renderPartial('_introduction', array('goods' => $goods)); //商品介绍   ?>
                    <!--                    --><?php //echo $this->renderPartial('_adults'); //维权 ?>
                    <div class="tabCon" id="tabCon_ul_2"></div>
                    <div class="tabCon clearfix" id="tabCon_ul_3">
                        <?php
                        //if($this->_beginCache('guestbooks')){
//                            echo $this->renderPartial('_guestbooks', array('dataProvider' => $guestBooks)); //商品咨询
//                            $this->endCache();
//                        }
                        ?>

                        <iframe src="<?php echo Yii::app()->createAbsoluteUrl('product/guest',array('id'=>$goods['id'],'goodsName'=>$goods['name']))?>" width="942px" height="360px" marginwidth=0 marginheight=0></iframe>
                    </div>
                    <?php
                    //if($this->_beginCache('comments')){
                        //echo $this->renderPartial('_comments', array('dataProvider' => $comments)); //评价
                        //$this->endCache();
                    //}-
                     ?>

                    <?php
                    /**
                     * 不显示成交记录
                     */
//                    if($this->_beginCache('completes')){
//                        echo $this->renderPartial('_completes', array('dataProvider' => $completes));
//                        $this->endCache();
//                    }
                    ?>
                </div>
            </div>

		</div>
    </div>
</div>
<input type="hidden" value="" id="redirectUrl">

<script type="text/javascript">
    /**获取价格信息**/
    getGoodsInfo();
    function getGoodsInfo(){
        $.ajax({
            type:"GET",
            cache : false,
            async : false,
            data:{
                skip: 1,
                id: <?php echo $goods['id']; ?>
            },
            url:"<?php echo $this->createAbsoluteUrl('goods/GetGoodsx');?>",
            success:function(json) {
                $(".prodMidd").prepend(json);
            }
        });
    }
    /**获取店铺库存、评价等信息**/
    $(function(){
            jQuery.ajax({
                type:"get",async:false,timeout:5000,dataType: "json",
                url:"<?php echo $this->createAbsoluteUrl("/product/stockScore",array('goodId'=>$goods['id'],'storeId'=>$goods['store_id']));?>",
//                data: "language="+lang,
                error:function(request,status,error){
                    alert(request.responseText);
                },
                success:function(data){
                        $('.hitSearh').append(data.globalkeywords);
//                        alert(JSON.stringify(data.stock));
                        var scoreView = 'point p_d'+data.scoreView;
//                        $('#goods_stock').html(data.stock);
                        $('.custAccount').html(data.views);
                        $('.pointAccount').html(data.score);
                        $('#point_pd').attr('class',scoreView);
                        $('#point_pd').after(data.score);
                        $('.like').html(data.descriptionMatch);
                        $('.like2').html(data.seriviceAttitude);
                        $('.like3').html(data.speedDelivery);
                        $('#store_score').prepend(data.avg_score);
                        $('#star1').raty({readOnly: true, path: '<?php echo DOMAIN ?>/js/raty/lib/img/', score: data.avg_score});
                        $('.tbmenu04').append('('+data.count+')');
                        data.descriptionMatch == 0 ? $('.down').prepend(1) : $('.down').prepend(data.descriptionMatch);
                        data.seriviceAttitude == 0 ? $('.balance').prepend(1) : $('.balance').prepend(data.seriviceAttitude);
                        data.speedDelivery == 0 ? $('.up').prepend(1) : $('.up').prepend(data.speedDelivery);
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
                    alert(request.responseText);
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
//                data: "language="+lang,
            error:function(request,status,error){
                alert(request.responseText);
            },
            success:function(data){
                $('.detailLeft').append(data);
            }
        });
    });

    /**火热销量**/
    $(function(){
        jQuery.ajax({
            type:"get",async:false,timeout:5000,
            url:"<?php echo $this->createAbsoluteUrl("/product/hotsales",array('id'=>$this->store['id']));?>",
//                data: "language="+lang,
            error:function(request,status,error){
                alert(request.responseText);
            },
            success:function(data){
                $('.detailLeft').append(data);
            }
        });
    });

    /**维权介入**/
    adults = true;
    $('.tbmenu02').click(function(){
        if(adults == true){
            jQuery.ajax({
                type:"get",async:false,timeout:5000,
                url:"<?php echo $this->createAbsoluteUrl("/product/adults");?>",
//                data: "language="+lang,
                error:function(request,status,error){
                    alert(request.responseText);
                },
                success:function(data){
                    $('#tabCon_ul_2').append(data);
                }
            });
            adults = false;
        }
    });

    /**商品咨询列表**/
    guest = true;
    $('.tbmenu03').click(function(){
        if(guest == true){
            jQuery.ajax({
                type:"get",async:false,timeout:5000,
                url:"<?php echo $this->createAbsoluteUrl("/product/guestList",array('id'=>$goods['id']));?>",
//                data: "language="+lang,
                error:function(request,status,error){
                    alert(request.responseText);
                },
                success:function(data){
                    $('#tabCon_ul_3').prepend(data);
                }
            });
            guest = false;
        }
    });

    /**商品评论列表**/
    commemt = true;
    $('.tbmenu04').click(function(){
        if(commemt == true){
            jQuery.ajax({
                type:"get",async:false,timeout:5000,
                url:"<?php echo $this->createAbsoluteUrl("/product/commentList",array('id'=>$goods['id']));?>",
//                data: "language="+lang,
                error:function(request,status,error){
                    alert(request.responseText);
                },
                success:function(data){
                    $('#tabCon_ul_3').after(data);
                }
            });
            commemt = false;
        }
    });
</script>




