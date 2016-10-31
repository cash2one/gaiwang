
</div>
</div>
<div class="main">
	    	<ul class="recList">
	    <?php if(!empty($model)):?>
	    	<?php foreach ($model as $red):?>	
	    		<li>
	    			<div class="fl">
	    				<span><?php echo Activity::getType($red->type) ?></span>
	    				<?php echo date('Y-m-d',$red->create_time);?>
	    			</div>
	    			<div class="fr">+<?php echo HtmlHelper::formatPrice($red->money)?></div>
	    			<div class="clear"></div>
	    		</li>
	      <?php endforeach;?>
	      <?php else:?>
	           <a href="<?php echo $this->createAbsoluteUrl('member/index');?>" >暂无领取红包，赶紧分享领取红包吧！</a>	
	    <?php endif;?>
	    	</ul>
	    
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
  </body>
  	<script src="<?php echo DOMAIN; ?>/js/m/jquery.touchslider.min.js"></script>		          
	<script src="<?php echo DOMAIN; ?>/js/m/template.js"></script>
	<script src="<?php echo DOMAIN; ?>/js/m/com.js"></script>
</html>
