<?php 
	if ($data->advert_type==  MachineAdvertAgent::ADVERT_TYPE_VEDIO || $data->advert_type==  MachineAdvertAgent::ADVERT_TYPE_LOCALVEDIO ){
		$css1 = " style='top:68px;'";		
		$css2 = " style='height:114px;'";
	}else{
		$css1 = "";
		$css2 = "";
	}
?>
<li style="margin-left:60px;">
	<input type="checkbox" class="cbbox" value="<?php echo $data->id?>"/>
	<div class="opt"<?php echo $css1?>>
		<?php 
			if ($data->advert_type==MachineAdvertAgent::ADVERT_TYPE_LOCALVEDIO){
				echo CHtml::link('',$this->createURL('machineAgent/advertUpdateLocal',array('id'=>$data->machine_id,'advert_id'=>$data->id)),array('class'=>'edit','title'=>  Yii::t('Public','编辑')));
				echo CHtml::link('',$this->createURL('machineAgent/advertRemoveLocal',array('id'=>$data->machine_id,'advert_id'=>$data->id)),array('class'=>'del','title'=>  Yii::t('Public','解除绑定'),'onclick'=>'return removeAdvert(this,"'.$data->title.'")'));
			}else{
				echo CHtml::link('',$this->createURL('machineAgent/advertMachine',array('id'=>$data->machine_id,'advert_id'=>$data->id,'adtype'=>$data->advert_type)),array('class'=>'gm','title'=>  Yii::t('Machine','关联的盖机')));
				echo CHtml::link('',$this->createURL('machineAgent/advertUpdate',array('id'=>$data->machine_id,'advert_id'=>$data->id,'adtype'=>$data->advert_type)),array('class'=>'edit','title'=>  Yii::t('Public','编辑')));
				echo CHtml::link('',$this->createURL('machineAgent/advertRemove',array('id'=>$data->machine_id,'advert_id'=>$data->id,'adtype'=>$data->advert_type)),array('class'=>'del','title'=>  Yii::t('Public','解除绑定'),'onclick'=>'return removeAdvert(this,"'.$data->title.'")'));
			}
		?>
		<?php //echo CHtml::link('',Yii::app()->createURL('machineAgent/advertMachine',array('id'=>$data->machine_id,'advert_id'=>$data->id,'adtype'=>$data->advert_type)),array('class'=>'gm','title'=>Yii::t('Machine','关联的盖机')))?>
		<?php //echo CHtml::link('',Yii::app()->createURL('machineAgent/advertUpdate',array('id'=>$data->machine_id,'advert_id'=>$data->id,'adtype'=>$data->advert_type)),array('class'=>'edit','title'=>Yii::t('Public','编辑')))?>
		<?php //echo CHtml::link('',Yii::app()->createURL('machineAgent/advertRemove',array('id'=>$data->machine_id,'advert_id'=>$data->id,'adtype'=>$data->advert_type)),array('class'=>'del','title'=>Yii::t('Machine','解除绑定'),'onclick'=>'return removeAdvert(this,"'.$data->title.'")'))?>
	</div>
	<?php
		$class = ""; 
		$content = Yii::t('Product','还剩');
		$fontColor = "green";
		$lastDay = ceil((strtotime($data->svc_end_time)-time())/86400);
		$lastDay = $lastDay <= -0?-$lastDay:$lastDay;
		if($data->use_status=='0'){//如果是未使用状态
			$class = "ad-disabled";
		}else if (strtotime($data->svc_end_time)<time()){//如果过期,这里就排除了是未使用的状态
			$content = Yii::t('Product','过期');
			$class="  ad-expired";
			$fontColor = "red";
		}
		
		if ($data->advert_type==MachineAdvertAgent::ADVERT_TYPE_LOCALVEDIO){
			$url = $this->createURL('machineAgent/advertUpdateLocal',array('id'=>$data->machine_id,'advert_id'=>$data->id));
		}else{
			$url = $this->createUrl('machineAgent/advertUpdate',array('id'=>$data->machine_id,'advert_id'=>$data->id,'adtype'=>$data->advert_type));
		}
	?>
	<a class="ad <?php echo $class;?>" <?php echo $css2?> href="<?php echo $url?>" title="<?php echo CHtml::encode($data->coupon_content)?>">
		
		<?php if ($data->advert_type==  MachineAdvertAgent::ADVERT_TYPE_COUPON){//优惠劵?>
		<span class="left">
			<span class="ad-logo">
                            <img alt="<?php echo $data->coupon_content?>" src='<?php echo $data->filepath ? Tool::showGtImg($data->filepath, 100, 100) : "" ?>' width="100px" height="100px"/>
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
                            <img alt="<?php echo $data->description?>" src='<?php echo $data->filepath ? Tool::showGtImg($data->filepath, 100, 100) : ""?>' width="100px" height="100px"/>
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
		<span class="date" style="float:right;margin-right:5px;"><?php echo Yii::t('Product','结束日期')?>：<i><?php echo $endDate ?></i></span>
		<?php }?>
		
		<?php if ($data->advert_type==  MachineAdvertAgent::ADVERT_TYPE_LOCALVEDIO){//视频?>
		<span class="right" style="width:278px; height:80px;">
			<span class="name"><?php echo CHtml::encode($data->title); ?></span>
			<span class="day" style="right:5px; float:right; display:inline;">
				<?php echo Yii::t('Product','还剩')?>
				<i style="color:green"><?php echo Yii::t('Product','不限'); ?> </i><?php echo Yii::t('Product','天')?>
			</span>
		</span>
		<span class="date"><?php echo Yii::t('Product','开始日期')?>：<i><?php echo Yii::t('Product','不限'); ?></i></span>&nbsp;&nbsp;&nbsp;
		<span class="date" style="float:right;margin-right:5px;"><?php echo Yii::t('Product','结束日期')?>：<i><?php echo Yii::t('Public','不限') ?></i></span>
		<?php }?>
	</a>
</li> 