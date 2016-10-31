
			<div class="main">
				<div class="container">				
					<!-- Category Layout -->					
					<div class="category categoryList clearfix">						
						<div class="tableTag">
						<?php 
						 if(!empty($scate)):
						  foreach($scate as $two):?>
							<div class="tag">
								<div class="columnTit"><span class="pink"></span><a class="item" href="<?php echo $this->createAbsoluteUrl('store/proList',array('id'=>$store->id,'cid'=>$two['id']));?>"><span><?php echo $two['name'];?></span></a></div>
								<div class="tagList clearfix">
								  <?php 
								  if(!empty($two['child'])):
								  foreach ($two['child'] as $three):?>
									<a class="item" href="<?php echo $this->createAbsoluteUrl('store/proList',array('id'=>$store->id,'cid'=>$three['id']));?>"><span><?php echo $three['name'];?></span></a>
							      <?php endforeach;
							        endif;
							      ?>		
								</div>
							</div>
                       <?php endforeach;?>	
                       <?php endif;?>		
						</div>
					</div>
				</div>
			</div>
		<script src="<?php echo DOMAIN; ?>/js/m/com.js"></script>
		<script src="<?php echo DOMAIN; ?>/js/m/jquery.touchslider.min.js"></script>
	</body>
</html>
