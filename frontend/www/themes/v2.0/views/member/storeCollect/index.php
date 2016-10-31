<script type="text/javascript">
 $(function(){
		//分页居中
	 var yiiPageerW=parseInt($(".yiiPageer").css("width"));
	 var pageListInfoW=parseInt($(".pageList-info").css("width"));
	 var pageListW=parseInt($(".pageList").css("width"));
	 var num=(pageListW-(yiiPageerW+pageListInfoW))/2;
	 $(".pageList").css("padding-left",num);
	 })
</script>

<?php $this->renderPartial('//layouts/_msg'); ?>
<div class="member-contain clearfix">
    <ul class="collection-tab clearfix">
        <li><a href="<?php echo $this->createAbsoluteUrl('/member/goodsCollect');?>" class="tab-item"><?php echo Yii::t('Collect', '收藏的商品')?></a></li>
        <li class="active"><a href="<?php echo $this->createAbsoluteUrl('/member/storeCollect');?>" class="tab-item"><?php echo Yii::t('Collect', '收藏的店铺')?></a></li>
    </ul>
    <div class="col-shop-list">
    <?php if(!empty($store)):?>
        <?php foreach ($store as $s):?>
        <div class="col-shop clearfix" id="store<?php echo $s['tid']?>" <?php if($i>3){echo 'style="display:none"';}?>>
            <div class="shop-info">                              
                <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $s['logo'], 'c_fill,h_70,w_208'), $s['name'], array('height' => '70', 'width' => '208'));?> 
                <p class="shop-name" style="line-height:2.5em" title="<?php echo $s['name'];?>"><?php echo Tool::truncateUtf8String($s['name'],27, '...');?></p>
                <?php echo CHtml::link('去店铺看看', $this->createAbsoluteUrl('/shop/view', array('id' => $s['id'])), array('class'=>'shop-btn','target' => '_blank')); ?>
                <a href="javascript:void(0)" class="shop-btn cancel-collect-shop" id="<?php echo $s['tid']; ?>">取消收藏</a>
            </div>
            <div class="hot-product">
                <div class="hp-header clearfix">
                    <b class="title">热卖商品</b>
                    <a href="javascript:getgoods(<?php echo $s['id']; ?>);" class="change">换一换</a>
                </div>
                <?php 
                $goods = Yii::app()->db->createCommand()->select('g.id,g.store_id,g.name,g.gai_price,g.price,g.thumbnail')
                ->from('{{goods}} g')
                ->where('g.store_id = :goods_id', array(':goods_id' => $s['id']))
                ->order('rand() limit '.$this->getgoods)
                ->queryAll();
                ?>
                <ul class="hp-list clearfix" id="getgoods<?php echo $s['id'];?>">
                    <?php foreach ($goods as $g):?>
                    <li>
                        <a href="<?php echo Yii::app()->createAbsoluteUrl('/goods/view/',array('id' => $g['id']))?>" title="<?php echo Tool::truncateUtf8String($g['name'], 100, '..');?>">
                            <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $g['thumbnail'], 'c_fill,h_122,w_174'), $g['name'], array('height' => '122', 'width' => '174'));?> 
                            <p class="hp-name"><?php echo Tool::truncateUtf8String($g['name'], 100, '..');?></p>
                            <p class="hp-price"><?php echo HtmlHelper::formatPrice($g['price']); ?></p>
                        </a>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <?php $i=$i+1;?>
        <?php endforeach;?>
        <?php if(count($store)>3):?>
        <div class="more-area">
            <a href="javascript:void(0)" class="more-shops" id="moreadd">查看更多</a>
        </div>
        <?php endif;?>
    <?php else:?>
          <div style="font-size: 20px; padding-top: 100px; text-align: center;width:100%"><?php echo Yii::t('Collect', '您还没收藏任何店铺');?>，去<a href="<?php echo DOMAIN?>" target="_blank" style="color: #ff6600;">逛逛吧&gt;&gt;</a></div>
    <?php endif;?>
          <div id="defaultStore" style="display:none;font-size: 20px; padding-top: 100px; text-align: center;width:100%"><?php echo Yii::t('Collect', '您还没收藏任何店铺');?>，去<a href="<?php echo DOMAIN?>" target="_blank" style="color: #ff6600;">逛逛吧&gt;&gt;</a></div>
      <input type="hidden" value="<?php echo count($store);?>" id="storeCount">
    </div>
<!-- 主体end -->
    <!--取消收藏确认弹窗start-->
    <div class="confirm-box">
        <div class="confirm-content tx-center">您确定取消该收藏？
        </div>
        <div class="confirm-footer">
            <button class="confirm-btn">确认</button>
            <button class="cancel-btn">取消</button>
        </div>
    </div>
    <!--删除收藏确认弹窗end-->
</div>
<script>
    /**换商品*/
	function getgoods(id){
		$.ajax({
  		    type: 'GET',async:false,timeout:5000,
  		    url: "/StoreCollect/getgoods",
  		    data: {id:id},
    		error:function(request,status,error){
               alert(request.responseText);
            },
            success: function(data){
            	$("#getgoods"+id).html(data);
            }
  		});       
	}

	   /**加载更多商铺*/
    $(function(){
        var a=3; b=4; c=5;
        $("#moreadd").click(function(){
        	//$('.col-shop').eq(a).css('display', 'block');
        	$('.col-shop').eq(a).show(300);
        	$('.col-shop').eq(b).show(300);
        	$('.col-shop').eq(c).show(300);
        	a=a+3;
        	b=b+3;
        	c=c+3;
        });
    });

	/**取消收藏str**/
	 $(function () {
         //取消收藏弹窗
         $(".cancel-collect-shop").click(function () {
             var id=$(this).attr("id");
             $(".confirm-box").show();
             $(".confirm-btn").attr('cancel-collect-shop',id); 
         })
         $(".confirm-btn").click(function () {
        	 $.ajax({
        		    type: 'GET',
        		    url: "/StoreCollect/delete",
        		    data: {id:$(".confirm-btn").attr('cancel-collect-shop')},
        		    dataType: 'json',
        		    async: false,
                  success: function(data){
                	  if(data['success']==true){
                		  $("#store"+$(".confirm-btn").attr('cancel-collect-shop')).hide(300);
                		  $("#storeCount").val(parseInt($("#storeCount").val())-1);
                        }else{
                        	alert(data['msg']);
                       } 
                	  if($("#storeCount").val()==0){
                        	$("#moreadd").css("display","none");
                        	$("#defaultStore").css("display","block");
                         }                       
                  }
        		});       
             $(".confirm-box").hide();
         })
         $(".cancel-btn").click(function () {
             $(".confirm-box").hide();
         })
     })
     /**取消收藏end**/
    </script>
