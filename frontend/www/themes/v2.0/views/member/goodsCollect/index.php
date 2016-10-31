<?php $this->renderPartial('//layouts/_msg'); ?>
<!--主体start-->
<div class="member-contain clearfix">
    <ul class="collection-tab clearfix">
        <li class="active"><a href="<?php echo $this->createAbsoluteUrl('/member/goodsCollect');?>" class="tab-item"><?php echo Yii::t('Collect', '收藏的商品')?></a></li>
        <li><a href="<?php echo $this->createAbsoluteUrl('/member/storeCollect');?>" class="tab-item"><?php echo Yii::t('Collect', '收藏的店铺')?></a></li>
    </ul>
    <ul class="col-product clearfix">
    <?php if(!empty($goods)):?>
        <?php foreach ($goods as $g): ?>
        <li id="good<?php echo $g['store_id']?>">
            <div class="product-img" data-attr="<?php echo $g['store_id']?>">
                <?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $g['thumbnail'], 'c_fill,h_166,w_176'), $g['name'], array('height' => '166', 'width' => '176')), $this->createAbsoluteUrl('/goods/view', array('id' => $g['id'])), array('title' => $g['name'],'target'=>'_blank')); ?>                
                <div id="delButton_<?php echo $g['store_id']; ?>" style="display:none">
                 <button class="delect-btn" value="<?php echo $g['store_id']; ?>"></button>    
            </div>
            </div>
            <div class="produtc-txt">
                <?php echo CHtml::link(Tool::truncateUtf8String($g['name'], 100, '..'), $this->createAbsoluteUrl('/goods/view', array('id' => $g['id'])), array('class'=>'product-name','target' => '_blank','title'=>$g['name'])); ?>
                <p class="price"><?php echo HtmlHelper::formatPrice($g['price']); ?></p>
            </div>
        </li>
        <?php endforeach; ?>
    <?php else:?>
        <li style="font-size: 20px; padding-top: 100px; text-align: center;width:100%"><?php echo Yii::t('Collect', '您还没收藏任何商品');?>，去<a href="<?php echo DOMAIN?>" target="_blank" style="color: #ff6600;">逛逛吧&gt;&gt;</a></li>
    <?php endif;?>
        <li id="defaultGoods" style="display:none;font-size: 20px; padding-top: 100px; text-align: center;width:100%"><?php echo Yii::t('Collect', '您还没收藏任何商品');?>，去<a href="<?php echo DOMAIN?>" target="_blank" style="color: #ff6600;">逛逛吧&gt;&gt;</a></li>
    </ul>
    <input type="hidden" value="<?php echo count($goods);?>" id="goodsCount">
    <div class="pageList mb50 clearfix" style="margin-bottom:30px">
             <?php
                $this->widget('SLinkPager', array(
                    'cssFile' => false,
                    'header' => '',
                    'firstPageLabel' => Yii::t('jf','首页'),
                    'lastPageLabel' => yii::t('jf','末页'),
                    'prevPageLabel' => Yii::t('jf','上一页'),
                    'nextPageLabel' => Yii::t('jf','下一页'),
                    'pages' => $pages,
                    'maxButtonCount' => 5,
                    'htmlOptions' => array(
                        'class' => 'yiiPageer',
                    )
                        )
                );
                ?> 
    </div>
    <!--删除收藏确认弹窗start-->
    <div class="confirm-box">
        <div class="confirm-content tx-center">您确定删除该收藏？
        </div>
        <div class="confirm-footer">
            <button class="confirm-btn">确认</button>
            <button class="cancel-btn">取消</button>
        </div>
    </div>
    <!--删除收藏确认弹窗end-->
</div>
<!-- 主体end -->

<script type="text/javascript">
$(function () {
	//分页居中
	 var yiiPageerW=parseInt($(".yiiPageer").css("width"));
	 var pageListInfoW=parseInt($(".pageList-info").css("width"));
	 var pageListW=parseInt($(".pageList").css("width"));
	 var num=(pageListW-(yiiPageerW+pageListInfoW))/2;
	 $(".pageList").css("padding-left",num);
    //页面布局
    $(".col-product li:nth-child(6n+1)").css("margin-left", "0");
    
    //删除收藏商品str
    $(".product-img").mouseover(function(){
        var gid=$(this).attr("data-attr");
        $("#delButton_"+gid).css('display','block');
    });
    $(".product-img").mouseout(function(){
        $("div[id^=delButton_]").css('display','none');
   });
    
    $(".delect-btn").click(function () {
    	$(".confirm-box").show();
        $(".confirm-btn").attr('data-id',$(this).val()); 
    });
    $(".confirm-btn").click(function () {        
    	$.ajax({
  		    type: 'GET',
  		    url: "/GoodsCollect/delete",
  		    data: {id:$(".confirm-btn").attr('data-id')},
  		    dataType: 'json',
    		async: false,
            success: function(data){                
                if(data['success']==true){
                	$("#good"+$(".confirm-btn").attr('data-id')).hide(300);
                	$("#goodsCount").val(parseInt($("#goodsCount").val())-1);
                }else{
                	alert(data['msg']);
                }
                if($("#goodsCount").val()==0){
                	$("#defaultGoods").css("display","block");
                 }
            }
  		});       
    	$(".confirm-box").hide();
    });    
    $(".cancel-btn").click(function () {
        $(".confirm-box").hide();
    });
    //删除收藏商品end  
});

</script>
