<li>
	<input type="checkbox" class="cbbox" value="<?php echo $data->id?>"/>
	<div class="opt">
		<?php if ($data->advert_type!=MachineAdvertAgent::ADVERT_TYPE_VOTE){//投票系统首页轮播不需要绑定盖机?>
		<?php echo CHtml::link('',$this->createURL('MachineAdvertAgent/bindMachine',array('id'=>$data->id,'adtype'=>$data->advert_type)),array('class'=>'gm','title'=>Yii::t('Public','绑定盖机')))?>
		<?php }?>
		<?php echo CHtml::link('',$this->createURL('MachineAdvertAgent/update',array('id'=>$data->id,'adtype'=>$data->advert_type)),array('class'=>'edit','title'=>Yii::t('Public','编辑')))?>
		<?php echo CHtml::link('',$this->createURL('MachineAdvertAgent/delete',array('id'=>$data->id,'adtype'=>$data->advert_type)),array('class'=>'del','title'=>Yii::t('Public','删除'),'onclick'=>'return deleteAdvert(this,"'.$data->title.'")'))?>
	</div>
	<?php    
                $class = ""; 
		$content = Yii::t('Public','还剩');
		$fontColor = "green";
		$lastDay = ceil((strtotime($data->svc_end_time)-time())/86400);
                if((strtotime($data->svc_end_time)>time())){
                    $lastDay = $lastDay - 1;
                }
                $lastDay =  abs($lastDay);
                if (strtotime($data->svc_end_time)<time()){
			$content = Yii::t('Public','已过期');
			$fontColor = "red";
		} 
               if($data->use_status=='0'){
                   $class = "ad-disabled";
               }  else {
                   if(strtotime($data->svc_end_time)<time()){
                       $class="  ad-expired";
                   } 
               }
        
	?>
	<a class="ad <?php echo $class;?>" href="<?php echo $this->createUrl('MachineAdvertAgent/update',array('id'=>$data->id,'adtype'=>$data->advert_type))?>" title="<?php echo CHtml::encode($data->coupon_content)?>">
		
		<?php if ($data->advert_type==MachineAdvertAgent::ADVERT_TYPE_COUPON){//优惠劵?>
		<span class="left">
			<span class="ad-logo">
				<img alt="<?php echo $data->coupon_content?>" src='<?php echo $data->filepath ? Tool::showGtImg($data->filepath, 100, 100) : ""?>' />
			</span>
		</span>
		<span class="right">
			<span class="name"><?php echo CHtml::encode($data->title); ?></span> 
			<span><?php echo Yii::t('Public','数量')?>：<i><?php echo CHtml::encode($data->coupon_quantity); ?></i></span>  
			<span><?php echo Yii::t('Public','剩余')?>：<i><?php echo CHtml::encode($data->coupon_quantity-$data->coupon_use_count); ?></i></span> 
			<span class="day">
				<?php echo $content?>
				<i style="color:<?php echo $fontColor?>"><?php echo $lastDay; ?> </i><?php echo Yii::t('Public','天')?>
			</span> 
		</span>
		<span class="date"><?php echo Yii::t('Public','开始日期')?>：<i><?php echo substr($data->svc_start_time, 0,10); ?></i></span><?php Yii::app()->language=='en'?"&nbsp;&nbsp;":"&nbsp;&nbsp;&nbsp;&nbsp;" ?>
		<span class="date"><?php echo Yii::t('Public','结束日期')?>：<i><?php echo substr($data->svc_end_time, 0,10); ?></i></span>
		<?php }?>
		
		<?php if ($data->advert_type==MachineAdvertAgent::ADVERT_TYPE_SIGN|$data->advert_type==MachineAdvertAgent::ADVERT_TYPE_VOTE){//首页轮播(投票系统首页轮播)?>
		<span class="left">
			<span class="ad-logo">
				<img alt="<?php echo $data->description?>" src='<?php echo $data->filepath ? Tool::showGtImg($data->filepath, 100, 100) : ""?>' />
			</span>
		</span>
		<span class="right">
			<span class="name"><?php echo CHtml::encode($data->title); ?></span> 
			<span><?php echo Yii::t('Public','开始日期')?>：<i><?php echo substr($data->svc_start_time, 0,10); ?></i></span>  
			<span><?php echo Yii::t('Public','结束日期')?>：<i><?php echo substr($data->svc_end_time, 0,10); ?></i></span> 
			<span class="day">
				<?php echo $content?>
				<i style="color:<?php echo $fontColor?>"><?php echo $lastDay; ?> </i><?php echo Yii::t('Public','天')?>
			</span> 
		</span>
		<?php }?>
	</a>
</li> 