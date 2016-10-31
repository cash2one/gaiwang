
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

<!-- 店铺主体start -->
<?php $cid=$this->getParam('cid');?>
  	<div class="shop-main clearfix">
  		<div class="gl-main-left">
			<div class="glm-shopInfo clearfix">
				<div class="glm-shopInfo-title"><?php echo $this->store->name?></div>
				<ul class="shopInfo-score clearfix">
 						<li><?php echo Yii::t('store', '描述')?></li>
 						<li><?php echo Yii::t('store', '服务')?></li>
 						<li><?php echo Yii::t('store', '物流')?></li>
 						<li><span class="shopInfo-font2 description_match"></span></li>
 						<li><span class="shopInfo-font2 serivice_attitude"></span></li>
 						<li><span class="shopInfo-font3 speed_of_delivery"></span></li>
 					</ul>
 					<a href="<?php echo $this->createAbsoluteUrl('shop/view',array('id'=>$this->store->id));?>" title="" class="glm-shopInfo-but glm-shopInfo-but1"><?php echo Yii::t('store', '进店逛逛')?></a>
 					<a href="javascript:void();" title="" class="glm-shopInfo-but glm-shopInfo-but2"><?php echo Yii::t('store', '收藏店铺')?></a>
			</div>
			<div class="shopInfo-nav">
				<div class="shopInfo-nav-title"><?php echo Yii::t('store', '店内分类')?></div>
				<?php 
				       $scate=Scategory::scategoryInfo($this->store->id);
				       if(!empty($scate)):
				  ?>
				<ul class="shopInfo-nav-list">
					<?php foreach ($scate as $key => $val):?>
					<li id="li_<?php echo $val['id']?>" tag="1"> 
						  <span class="shopInfo-nav-item">
						  <a <?php if($cid==$val['id']):?>class="category-selected" <?php endif;?> href="<?php echo $this->createAbsoluteUrl('shop/product', array('id' => $this->store->id,'cid'=>$val['id']))?>">
						  <?php echo $val['name'];?>
						  </a>
						  </span>
						<?php if(isset($val['child']) && !empty($val['child'])):?>
						<div id="div_<?php echo $val['id']?>" class="shopInfo-nav-float">
						 <?php 
						       foreach ($val['child'] as $k => $v):
						   ?>
							<a href="<?php echo $this->createAbsoluteUrl('shop/product', array('id' => $this->store->id,'cid'=>$v['id']))?>" title="" <?php if($cid==$v['id']):?>class="category-selected" <?php endif;?>><?php echo $v['name']?></a>
						    <input type="hidden" id="a_<?php echo $v['id'] ?>" value="<?php echo $val['id'];?>">
						   <?php if(($k+1)%2 != 0 && ($v!==end($val['child']))) {echo '/';}?>
                           <?php if( $k>0 && ($k+1)%2 == 0 ){echo '<br/>';}?>
						   <?php endforeach;?>
						</div>
						<?php endif;?>
					</li>
					<?php endforeach;?>
				</ul>
				<?php endif;?>
			</div>
			<div class="sellingPord">
				<div class="shopInfo-nav-title"><?php echo Yii::t('store', '热销商品')?></div>
				   <?php 
				     $hotGoods=Goods::hotSales($this->store->id, 6);
				    ?>
				<ul class="sellingPord-list">
				   <?php if(!empty($hotGoods)):
				         foreach ($hotGoods as $k=>$v):
				    ?>
					<li>
  				        <?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_60,w_60'), $v['name'], array('height' => '60', 'width' => '60')), $this->createAbsoluteUrl('goods/view', array('id' => $v['id'])), array('class'=>'sellingPord-img','title' => $v['name'])); ?>
						<div class="sellingPord-info">
						<?php echo CHtml::link($v['name'],$this->createAbsoluteUrl('goods/view', array('id' => $v['id'])), array('title' => $v['name'])); ?>
						 <span><?php echo HtmlHelper::formatPrice($v['price']);?></span>
						</div>
					</li>
					<?php 
					    endforeach;
					      endif;
					 ?>
				</ul>
			</div>
		</div>
		<div class="shop-right">
			<div class="shop-right-top clearfix">
				<dl class="gst-sort clearfix">
					<dd <?php if($params['order']=='0' || !isset($params['order'])):?>class='ddSel'<?php endif;?>><?php echo HtmlHelper::generateSortUrl('default', $this->route, $params, $this->_uriProductParams());?></dd>
					<dd <?php if($params['order']=='5'):?>class='ddSel'<?php endif;?>><?php echo HtmlHelper::generateSortUrl('views', $this->route, $params, $this->_uriProductParams())?></dd>
					<dd <?php if($params['order']=='2' || $params['order']=='3'):?>class='ddSel'<?php endif;?>>
					<?php echo HtmlHelper::generateSortUrl('price', $this->route, $params, $this->_uriProductParams())?>
					</dd>
					<dd <?php if($params['order']=='6'):?>class='ddSel'<?php endif;?>><?php echo HtmlHelper::generateSortUrl('update_time', $this->route, $params, $this->_uriProductParams()); ?></dd>
				</dl>
				<dl class="gst-address">
					<dd>
						<div class="gst-range">
							<?php echo HtmlHelper::formatPrice("");?><input type="text"  id="min" value="<?php echo !empty($params['min']) ? $params['min'] : ''; ?>" name="input_txt1" onkeyup="value = value.replace(/[^\d]/g, '')" />
						</div>
						<div class="gst-line">-</div>
						<div class="gst-range"><?php echo HtmlHelper::formatPrice("");?><input type="text" id="max" value="<?php echo!empty($params['max']) ? $params['max'] : ''; ?>" name="input_txt2" onkeyup="value = value.replace(/[^\d]/g, '')" /></div>
					</dd>
				</dl>
				<dl class="gst-sort clearfix">
				<dd style="padding: 0 8px;"><span id="integralSearch"><?php echo Yii::t('store', '确定')?></span></dd>
				</dl>
				<?php 
                   $page=$this->getParam('page');
                   $page=!empty($page) ? $page : 1;
                   $pre=$page-1;
                   $next=$page+1;
                   $next=$next >= $pages->getPageCount() ? $pages->getPageCount():$next;
                   $pre=$pre > 0 ? $pre:1;
                   $nextUrl= $this->createAbsoluteUrl($this->route, array_merge($params, array('page' =>$next)));
                   $preUrl=$this->createAbsoluteUrl($this->route, array_merge($params, array('page' =>$pre)));
                  ?>
		 <div class="gst-title-paging">
			<div class="paging-num"><?php echo $page;?>/<?php echo $pages->getPageCount() ? $pages->getPageCount():1;?></div>
			<a href="<?php echo $pages->getPageCount() ? $preUrl:'#';?>" class="paging-left"></a>
			<a href="<?php echo $pages->getPageCount() ? $nextUrl:'#';?>" class="paging-right"></a>
		</div>
			</div>
		<?php if (!empty($goods)): ?>
			<ul class="shop-hotGoods shop-hotGoods2 clearfix">
			<?php foreach ($goods as $g): ?>
	  			<li>
	  			<?php echo CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $g->thumbnail, 'c_fill,h_230,w_222'), $g->name, array('height' => '230', 'width' => '222')), $this->createAbsoluteUrl('goods/view', array('id' => $g->id)), array('class' => 'shop-hotGoods-img', 'title' => $g->name)); ?>
	  				<p><?php echo HtmlHelper::formatPrice("");?><span><?php echo $g->price; ?></span></p>
	  				<?php echo CHtml::link(Tool::truncateUtf8String($g->name, 26, '..'), $this->createAbsoluteUrl('/goods/view', array('id' => $g->id)), array('class'=>'shop-hotGoods-title','target' => '_blank','title'=>$g->name)); ?>
	  			</li>
	  		<?php endforeach;?>
	  		</ul>
	  		
			<div class="pageList"> 
				<?php
                $this->widget('SLinkPager', array(
                    'cssFile' => false,
                    'header' => '',
                    'firstPageLabel' => Yii::t('store','首页'),
                    'lastPageLabel' => yii::t('store','末页'),
                    'prevPageLabel' => Yii::t('store','上一页'),
                    'nextPageLabel' => Yii::t('store','下一页'),
                    'pages' => $pages,
                    'maxButtonCount' => 5,
                    'htmlOptions' => array(
                        'class' => 'yiiPageer'
                    )
                        )
                );
                ?> 
                <!--  注释掉页码直接跳转 
                <?php if($pages->pageCount>1):?>
				<div class="pageList-info">共<?php echo $pages->pageCount;?>页 到第<input value="<?php echo $page;?>" id="gotoPage" class="page-num"/>页<input type="submit" id="gotoSubmit" value="确定" class="page-but"/></div>           
			    <?php endif;?>
			    -->
			</div>
			<?php else:?>
			 <div class="shop-notfound">
                <div class="inner">
                  <img src="<?php echo DOMAIN; ?>/images/bg/noProTips.gif" alt="图标">
                  <div class="right-box">
                    <p><?php echo Yii::t('store','很抱歉，没找到相关分类的商品哦，要不您换个分类我帮您再找找看')?>。</p>
                    <p><?php echo Yii::t('store','建议您')?>：</p>
                    <p><?php echo Yii::t('store','1.看看输入的文字是否有误')?>。</p>
                    <p><?php echo Yii::t('store','2.重新搜索')?>。</p>
                  </div>
        </div>
      </div>
			<?php endif;?>
		</div>
  	</div>	
  	<!-- 店铺主体end -->
  	
<?php
Yii::app()->clientScript->registerScript('integralSearch', "
$(function() {
    $(\"#integralSearch\").click(function() {
        var min = $(\"#min\").val();
        var max = $(\"#max\").val();
        min = min == '' ? 0 : min;
        max = max == '' ? 0 : max;
        location.assign('" . urldecode($this->createAbsoluteUrl($this->route, array_merge($params, array('min' => "'+min+'", 'max' => "'+max+'")))) . "');
    })	
 						        
 	$(\"#gotoSubmit\").click(function() {				        
        var gotoPage = parseInt($(\"#gotoPage\").val());
 		var pageCount=parseInt(".$pages->pageCount.");			        			        				        
        page = gotoPage == '' ? 1 : gotoPage;
 		page = gotoPage > pageCount ? pageCount : gotoPage;				        			        
        location.assign('" . urldecode($this->createAbsoluteUrl($this->route, array_merge($params, array('page' => "'+page+'")))) . "');
    })
	var aid=$(\"#a_".$cid."\").val();		        						        				        
 	$(\"#div_\"+aid).css('display','block');
	$(\"#li_\"+aid).attr('tag','2');
	$(\"#li_\"+aid).addClass('shopInfo-nav-listSelLi');					        			        						        
});
",CClientScript::POS_END);
?>
<!-- 头部end -->
<script type="text/javascript">

//收藏本店
/*product-v2.0.js处理 了dealCollect方法*/
$(".glm-shopInfo-but2").click(function(){
	var mid="<?php echo Yii::app()->user->id?>";
	if(!parseInt(mid)){
		$('#isjump').val('1');
	    $('.prompt-info2').text('<?php echo Yii::t('store', '请先登录,再进行操作!'); ?>');
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
		},
		error: function(){
			$('.prompt-info2').text('<?php echo Yii::t('store', '无法收藏，请刷新重试！'); ?>');
	        $(".prompt-float,.pordShareBg").show();
		} 
	});
});
</script>