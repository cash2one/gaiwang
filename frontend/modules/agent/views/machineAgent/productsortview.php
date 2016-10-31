<?php
	$class = ""; 
	if($data->use_status=='0'){//如果是未使用状态
		$class = "ad-disabled";
	}else if ($data->activity_end_time<time()){//如果过期,这里就排除了是未使用的状态
		$class="  ad-expired";
	}
?>
<li class="sort">
	<?php echo CHtml::hiddenField("product_id[]",$data->id)?>
	<a class="ad <?php echo $class;?> " href="javascript:;" title="<?php echo CHtml::encode($data->content)?>">
		<span class="left">
			<span class="ad-logo">
				<img src='<?php //echo Tool::urlImageForUploads($data->thumbnail->path)?>' alt="" />
			</span>
			<span class="name"><?php echo CHtml::encode($data->name); ?> </span>
		</span>
	</a>
</li> 
                                
                            