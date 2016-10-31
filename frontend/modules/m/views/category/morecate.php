
			<div class="main">
				<div class="container">				
					<!-- Category Layout -->					
					<div class="category categoryList clearfix">						
						<div class="tableTag">
						<?php 
						 if(!empty($morecate)):
						  foreach($morecate as $two):
						    if(!empty($two['childClass'])):
						?>
							<div class="tag">
								<div class="columnTit"><span class="pink"></span><?php echo $two['name'];?></div>
								<div class="tagList clearfix">
								  <?php foreach ($two['childClass'] as $three):?>
									<a class="item" href="<?php echo $this->createAbsoluteUrl('category/prolist',array('cid'=>$three['id']));?>"><span><?php echo $three['name'];?></span></a>
							      <?php endforeach;?>	
								</div>
							</div>
							<?php endif;?>
                       <?php endforeach;?>
                       <?php else:?>
                            <div class="tag">
                            <div class="columnTit"><span class="pink">暂无</span>分类</div>
                            </div>
                       <?php endif;?>
						</div>
					</div>
				</div>
			</div>
		<script src="<?php echo DOMAIN; ?>/js/m/com.js"></script>
		<script src="<?php echo DOMAIN; ?>/js/m/jquery.touchslider.min.js"></script>
	</body>
</html>
