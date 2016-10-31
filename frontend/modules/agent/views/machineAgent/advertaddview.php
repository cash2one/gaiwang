<?php 
	if ($data->advert_type==  MachineAdvertAgent::ADVERT_TYPE_VEDIO){
		$css1 = " style='top:68px;'";		
		$css2 = " style='height:114px;'";
	}else{
		$css1 = "";
		$css2 = "";
	}
?>
<li>
	<input type="checkbox" class="cbbox" id="checkbox<?php echo $data->id?>" value="<?php echo $data->id?>"/>
	<div class="opt"<?php echo $css1?>>
	</div>
	<?php
		$class = ""; 
		$content = Yii::t('Product','还剩');
		$fontColor = "green";
		$lastDay = ceil((strtotime($data->svc_end_time)-time())/84600);
		$lastDay = $lastDay == -0?0:$lastDay;
		if($data->use_status=='0'){//如果是未使用状态
			$class = "ad-disabled";
		}else if (strtotime($data->svc_end_time)<time()){//如果过期,这里就排除了是未使用的状态
			$content = Yii::t('Product','过期');
			$class="  ad-expired";
			$fontColor = "red";
		}
	?>
	<a class="ad <?php echo $class;?>" <?php echo $css2?> href="javascript:advertChecked('checkbox<?php echo $data->id?>');" title="<?php echo CHtml::encode($data->coupon_content)?>">
		
		<?php if ($data->advert_type==  MachineAdvertAgent::ADVERT_TYPE_COUPON){//优惠劵?>
		<span class="left">
			<span class="ad-logo">
                            <img alt="<?php echo $data->coupon_content?>" src='<?php echo $data->filepath ? Tool::showGtImg($data->filepath, 100, 100) : ""?>' />
			</span>
		</span>
		<span class="right">
			<span class="name"><?php echo CHtml::encode($data->title); ?></span> 
			<span><?php echo Yii::t('Machine','数量')?>：<i><?php echo CHtml::encode($data->coupon_quantity); ?></i></span>  
			<span><?php echo Yii::t('Machine','剩余')?>：<i><?php echo CHtml::encode($data->coupon_quantity-$data->coupon_use_count); ?></i></span> 
			<span class="day">
				<?php echo $content?>
				<i style="color:<?php echo $fontColor?>"><?php echo $lastDay; ?> </i><?php echo Yii::t('Product','天')?>
			</span> 
		</span>
		<span class="date"><?php echo Yii::t('Product','开始日期')?>：<i><?php echo CHtml::encode(date('Y-m-d',strtotime($data->svc_start_time))); ?></i></span><?php Yii::app()->language=='en'?"&nbsp;&nbsp;":"&nbsp;&nbsp;&nbsp;&nbsp;"?>
		<span class="date"><?php echo Yii::t('Product','结束日期')?>：<i><?php echo CHtml::encode(date('Y-m-d',strtotime($data->svc_end_time))); ?></i></span>
		<?php }?>
		
		<?php if ($data->advert_type==  MachineAdvertAgent::ADVERT_TYPE_SIGN){//签到?>
		<span class="left">
			<span class="ad-logo">
				<img alt="<?php echo $data->description?>" src='<?php echo $data->filepath ? Tool::showGtImg($data->filepath, 100, 100) : ""?>' />
			</span>
		</span>
		<span class="right">
			<span class="name"><?php echo CHtml::encode($data->title); ?></span> 
			<span><?php echo Yii::t('Product','开始日期')?>：<i><?php echo CHtml::encode(date('Y-m-d',strtotime($data->svc_start_time))); ?></i></span>  
			<span><?php echo Yii::t('Product','结束日期')?>：<i><?php echo CHtml::encode(date('Y-m-d',strtotime($data->svc_end_time))); ?></i></span> 
			<span class="day">
				<?php echo $content?>
				<i style="color:<?php echo $fontColor?>"><?php echo $lastDay; ?> </i><?php echo Yii::t('Product','天')?>
			</span> 
		</span>
		<?php }?>
		
		<?php if ($data->advert_type==  MachineAdvertAgent::ADVERT_TYPE_VEDIO){//视频?>
			<?php 
				$beginDate = CHtml::encode(date('Y-m-d',strtotime($data->svc_start_time)));
				$endDate = CHtml::encode(date('Y-m-d',strtotime($data->svc_end_time)));
				if($endDate=='1970-01-01'){
					$content = Yii::t('Product','还剩');
					$endDate = $lastDay = Yii::t('Product','不限');
					$fontColor = "green";
				}
				
				$beginDate = $beginDate == '1970-01-01'?Yii::t('Product','不限'):$beginDate;
			?>
		<span class="right" style="width:278px; height:80px;">
			<span class="name"><?php echo CHtml::encode($data->title); ?></span>
			<span class="day" style="right:5px; float:right; display:inline;">
				<?php echo $content?>
				<i style="color:<?php echo $fontColor?>"><?php echo $lastDay; ?> </i><?php echo Yii::t('Product','天')?>
			</span>
		</span>
		<span class="date"><?php echo Yii::t('Product','开始日期')?>：<i><?php echo $beginDate; ?></i></span><?php Yii::app()->language=='en'?"&nbsp;&nbsp;":"&nbsp;&nbsp;&nbsp;&nbsp;"?>
		<span class="date" style="float:right;margin-right:8px;"><?php echo Yii::t('Product','结束日期')?>：<i><?php echo $endDate ?></i></span>
		<?php }?>
	</a>
</li> 