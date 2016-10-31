<?php
//图片延迟加载
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/lazyLoad.js');
?>
<script type="text/javascript">
    $(function() {
        LAZY.init();
        LAZY.run();
    });
</script>
<script src="<?php echo DOMAIN; ?>/js/m/jquery.touchslider.min.js"></script>
<script src="<?php echo DOMAIN; ?>/js/m/jquery.touchSwipe.min.js"></script>			
<script src="<?php echo DOMAIN; ?>/js/m/template.js"></script>
<script src="<?php echo DOMAIN; ?>/js/m/com.js"></script>		
		<div class="main">
				<div class="container">	
				<?php  if (!empty($advertsSlide)):?>
				<div class="touchslider">
						<div class="touchslider-viewport">
							 <?php
                                        foreach ($advertsSlide as $val):
                                            ?>
                                              <div class="touchslider-item">
                                                <?php if (AdvertPicture::isValid($val['start_time'], $val['end_time'])): ?>
                                                    <?php $img = CHtml::image(ATTR_DOMAIN . '/' . $val['picture'], Yii::t('site', $val['title'])) ?>
                                                    <?php echo CHtml::link($img, $val['link'], array('title' => Yii::t('site', $val['title']))) ?> 
                                              </div>
                                                <?php
                                            endif;
                                         endforeach;
                                     ?>     
						</div>
						  <?php 
						     $count = count($advertsSlide);
						         if($count>1):
						      ?>
						<div class="touchslider-navtag">
                			   <?php for ($i = 0; $i < $count; $i++):?>
                                    <span class="touchslider-nav-item <?php if ($i == 0): ?>touchslider-nav-item-current <?php endif; ?>"></span>
                                 <?php endfor;  ?>
						</div>
						<?php  endif;?>
					</div>	
					<?php  endif;?>				
					<!-- Column layout -->
					
					<div class="column">
					   <?php if (!empty($advertsBrand)):?>
						<div class="columnTxt mgtop10 clearfix"><span class="classTxt red fl">热门品牌</span><!-- <a class="icoMore fr" href="#">更多</a> --></div>
						<div class="columnContent">
							<div class="brandList">
								<ul class="brand">
								  <?php foreach($advertsBrand as $k =>$v):?>  
								  <?php if (AdvertPicture::isValid($v['start_time'], $v['end_time'])): ?>  
								    <li <?php if($k==0):?>class="first"<?php endif;?>><p>
								       <?php $img = CHtml::image(ATTR_DOMAIN . '/' . $v['picture'], Yii::t('site', $v['title'])) ?>
                                       <?php echo CHtml::link($img, $v['link'], array('class'=>'item','title' => Yii::t('site', $v['title']))) ?> 
								    </p></li>
									<?php endif;endforeach;?>
								</ul>
							</div>
						</div>
						<?php endif;?>
						<script type="text/javascript">
							$(function(){
								n=$('.brand li').size();				
								var wh=100*n+"%";
								$('.brand').width(wh);
								var lt=(100/n/5);
								var lt_li=lt+"%";								
								var y=0;
								var w=n/2;						
								$(".brand").swipe( {					
									swipeLeft:function() {
										if(y==-lt*w){
											alert('已经到最后页');
										}else{
											y=y-lt;								
											var t=y+"%";									
											$(this).css({'-webkit-transform':"translate("+t+")",'-webkit-transition':'500ms linear'} );	
										}
									},
									swipeRight:function() {
										if(y==0){
											alert('已经到第一页')	
										}else{
											y=y+lt;
											var t=y+"%";
											$(this).css({'-webkit-transform':"translate("+t+")",'-webkit-transition':'500ms linear'} );	
										}
										
									}
								});
							});						
						</script>	
						<?php if (!empty($advertsStore)):?>
						<div class="columnContent">
						   <ul class="brandProduct clearfix">
							<!-- 图片尺寸：213*245 -->	
							     <?php foreach($advertsStore as $k =>$s):?>
							     <?php if (AdvertPicture::isValid($s['start_time'], $s['end_time'])): ?>    
								    <li <?php if($k==0):?>class="first"<?php endif;?>><p>
								       <?php $img = CHtml::image(ATTR_DOMAIN . '/' . $s['picture'], Yii::t('site', $s['title'])) ?>
                                       <?php echo CHtml::link($img, $s['link'], array('class'=>'item','title' => Yii::t('site', $s['title']))) ?> 
								    </p></li>
									<?php endif;endforeach;?>
							</ul>	
						</div>
					 <?php endif;?>
					</div>				
					<div class="column">
						<div class="columnTxt mgtop10 clearfix"><span class="classTxt purple fl">精彩商城</span><!-- <a class="icoMore fr" href="#">更多</a> --></div>
						<div class="columnContent">
							<ul class="mallClass clearfix">
								<li  class="first"><?php echo CHtml::link(CHtml::image(DOMAIN . "/images/m/temp/caretory01.jpg", "家用电器"), array('category/index', 'cid' => 1),array('class'=>'item')); ?></li>
                                <li><?php echo CHtml::link(CHtml::image(DOMAIN . "/images/m/temp/caretory02.jpg", "服饰鞋帽"), array('category/index', 'cid' => 2),array('class'=>'item')); ?></li>
                                <li><?php echo CHtml::link(CHtml::image(DOMAIN . "/images/m/temp/caretory03.jpg", "个护化妆"), array('category/index', 'cid' => 3),array('class'=>'item')); ?></li>
                                <li><?php echo CHtml::link(CHtml::image(DOMAIN . "/images/m/temp/caretory04.jpg", "手机数码"), array('category/index', 'cid' => 4),array('class'=>'item')); ?></li>
                                <li><?php echo CHtml::link(CHtml::image(DOMAIN . "/images/m/temp/caretory05.jpg", "电脑办公"), array('category/index', 'cid' => 5),array('class'=>'item')); ?></li>
                                <li><?php echo CHtml::link(CHtml::image(DOMAIN . "/images/m/temp/caretory06.jpg", "运动健康"), array('category/index', 'cid' => 6),array('class'=>'item')); ?></li>
                                <li><?php echo CHtml::link(CHtml::image(DOMAIN . "/images/m/temp/caretory07.jpg", "家居安装"), array('category/index', 'cid' => 7),array('class'=>'item')); ?></li>
                                <li><?php echo CHtml::link(CHtml::image(DOMAIN . "/images/m/temp/caretory08.jpg", "饮料食品"), array('category/index', 'cid' => 8),array('class'=>'item')); ?></li>
                                <li><?php echo CHtml::link(CHtml::image(DOMAIN . "/images/m/temp/caretory09.jpg", "礼品箱包"), array('category/index', 'cid' => 9),array('class'=>'item')); ?></li>
                                <li><?php echo CHtml::link(CHtml::image(DOMAIN . "/images/m/temp/caretory10.jpg", "珠宝首饰"), array('category/index', 'cid' => 10),array('class'=>'item'));?></li>
                                <li><?php echo CHtml::link(CHtml::image(DOMAIN . "/images/m/temp/caretory11.jpg", "汽车用品"), array('category/index', 'cid' => 11),array('class'=>'item'));?></li>
                                <li><?php echo CHtml::link(CHtml::image(DOMAIN . "/images/m/temp/caretory12.jpg", "母婴用品"), array('category/index', 'cid' => 12),array('class'=>'item'));?></li>
                                <li><?php echo CHtml::link(CHtml::image(DOMAIN . "/images/m/temp/caretory13.jpg", "休闲旅游"), array('category/index', 'cid' => 14),array('class'=>'item'));?></li>	
							</ul>
						</div>						
					</div>	
					
					<div class="column">
						<div class="columnTxt mgtop10 clearfix"><span class="classTxt orange fl">精品推荐</span><!-- <a class="icoMore fr" href="#">更多</a> --></div>
						<div class="columnContent nobg">
							<ul class="products clearfix">
							   <?php if (!empty($goods)): ?>
                                  <?php foreach ($goods as $k => $v): ?>
								<li>
									<a class="item" href="<?php echo $this->createAbsoluteUrl('goods/index', array('id' => $v->id)); ?>">
										<?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v->thumbnail, 'c_fill,h_380,w_400'), $v->name) ?>
										<div class="itemInfor">
											<p class="proname"><?php echo $v->name; ?></p>
											<p class="clearfix"><span class="fl price"><b class="red"><?php echo HtmlHelper::formatPrice($v->price); ?></b></span></p>											
										</div>
									</a>
								</li>
								 <?php endforeach; ?>
                             <?php endif; ?> 
							</ul>
						</div>						
					</div>				
				</div>
			</div>