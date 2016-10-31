<?php 

        $css1 = "";
        $css2 = "";

?>
<li>
	<input type="checkbox" class="cbbox" id="checkbox<?php echo $data->id?>" value="<?php echo $data->id?>"/>
	<div class="opt"<?php echo $css1?>>
	</div>
	<?php
		$class = ""; 
		$content = Yii::t('Product','还剩');
		$fontColor = "green";
		$lastDay = ceil((strtotime($data->activity_start_time)-time())/84600);
		$lastDay = $lastDay == -0?0:$lastDay;
		if($data->use_status=='0'){//如果是未使用状态
			$class = "ad-disabled";
		}else if (strtotime($data->activity_end_time)<time()){//如果过期,这里就排除了是未使用的状态
			$content = Yii::t('Product','过期');
			$class="  ad-expired";
			$fontColor = "red";
		}
	?>
	<a class="ad <?php echo $class;?>" <?php echo $css2?> href="javascript:advertChecked('checkbox<?php echo $data->id?>');" title="<?php echo CHtml::encode($data->content)?>">
		
	
		<span class="left">
			<span class="ad-logo">
				<img alt="<?php echo $data->content?>" src='<?php //echo Tool::urlImageForUploads($data->file->path)?>' />
			</span>
		</span>
		<span class="right">
			<span class="name"><?php echo CHtml::encode($data->name); ?></span> 
			<span><?php echo Yii::t('','')?><?php echo Yii::t('Machine','库存')?>：<i><?php echo CHtml::encode($data->stock); ?></i></span>  
			<span><?php echo Yii::t('Product','零售价')?>：<i><?php echo CHtml::encode($data->price); ?></i></span> 
			<span class="day">
				<?php echo $content?>
				<i style="color:<?php echo $fontColor?>"><?php echo $lastDay; ?> </i><?php echo Yii::t('Product','天')?>
			</span> 
		</span>
		<span class="date"><?php echo Yii::t('Product','开始日期')?>：<i><?php echo CHtml::encode(date('Y-m-d',strtotime($data->activity_start_time))); ?></i></span><?php Yii::app()->language=='en'?"&nbsp;&nbsp;":"&nbsp;&nbsp;&nbsp;&nbsp;"?>
		<span class="date"><?php echo Yii::t('Product','结束日期')?>：<i><?php echo CHtml::encode(date('Y-m-d',strtotime($data->activity_end_time))); ?></i></span>
		

	</a>
</li> 