
<div class="main">
				<div class="container">				
					<!-- Category Layout -->
					<div class="column">
						<div class="columnContent nobg">
							<ul class="products02 clearfix">
							<?php if(!empty($goods)):
							   foreach ($goods as $good):
							?>
								<li>
									<a class="item" href="<?php echo $this->createAbsoluteUrl('goods/index',array('id'=>$good['id']));?>">
										<?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $good['thumbnail'], 'c_fill,h_170,w_170'), $good['name'])?>
										<div class="itemInfor">
											<p class="proname"><?php echo CHtml::encode($good['name']); ?></p>
										</div>
									</a>
								</li>
                              <?php endforeach;
                                      endif;
                              ?>
																
							</ul>
						</div>						
					</div>
					<div class="category categoryList clearfix">
						<div class="tableTag">
							<div class="tag">
								<div class="columnTit titBg"><span class="pink"></span>
								<?php 
								
								 $cateid=$this->getParam('cid');
								    if(!empty($cate)):
								    echo $cate['name'];
								    else:
								    echo Category::getCategoryName($cateid);
								    endif;
								    ?>
								</div>
								<div class="tagList clearfix">
								<?php 
								  if(!empty($cate['childClass'])): 
								    $cate=array_splice($cate['childClass'],0,7);  
								   foreach($cate as $s):?>
									<a class="item" href="<?php echo $this->createAbsoluteUrl('category/prolist',array('cid'=>$s['id']));?>"><span><?php echo Tool:: truncateUtf8String($s['name'],4,''); ?></span></a>
									<?php endforeach;?>
									<a class="item more" href="<?php echo $this->createAbsoluteUrl('category/morecate',array('cid'=>$cateid));?>"><span class="gray">更多></span></a>
								 <?php else:
					                   $catename=Category::getCategoryName($cateid);
								   ?>
								   <a class="item" href="<?php echo $this->createAbsoluteUrl('category/prolist',array('cid'=>$cateid));?>"><span><?php echo Tool:: truncateUtf8String($catename,4,''); ?></span></a>
								<?php endif;?>
								</div>
							</div>							
						</div>						
					</div>
					<div class="column">
						<div class="columnContent nobg">
							<ul class="products  mgtop15 clearfix" id="goodlist">
							
							<?php 
							    if (!empty($allcategoods)):
							     foreach ($allcategoods as $good):
							     ?>	
								 <li>
									<a class="item" href="<?php echo $this->createAbsoluteUrl('goods/index',array('id'=>$good->id));?>">
										<?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $good->thumbnail, 'c_fill,h_170,w_170'), $good['name'])?>
										<div class="itemInfor">
											<p class="proname"><?php echo Tool:: truncateUtf8String($good->name,20); ?></p>
											<p class="clearfix"><span class="fl price"><b class="red"><?php echo HtmlHelper::formatPrice($good->price) ?></b></span></p>
										</div>
									</a>
								 </li>
								<?php 
								endforeach;
							       endif;
							       ?>	
							</ul>							
						</div>
					</div>
					  
					<?php
                            $this->widget('WLinkPager', array(
                                'pages' => $pages,
                                'jump' => true,
                                'prevPageLabel' =>  Yii::t('page', '上一页'),
                                'nextPageLabel' =>  Yii::t('page', '下一页'),
                            ))
                        ?>
				</div>
			</div>
		</div>

		<script src="<?php echo DOMAIN; ?>/js/m/jquery.touchslider.min.js"></script>		          
        <script src="<?php echo DOMAIN; ?>/js/m/template.js"></script>
		<script src="<?php echo DOMAIN; ?>/js/m/com.js"></script>		
	</body>	
</html>
