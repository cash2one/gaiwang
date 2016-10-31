<?php 

        $css1 = "";
        $css2 = "";

?>
<li>
	<input type="checkbox" class="cbbox" id="checkbox<?php echo $data->id?>" value="<?php echo $data->id?>"/>
	<div class="opt"<?php echo $css1?>>
            <?php echo CHtml::link('',Yii::app()->createURL('machineAgent/productMachine',array('id'=>$data->machine_id,'product_id'=>$data->id)),array('class'=>'gm','title'=>Yii::t('Machine','关联的盖机')))?>
		<?php echo CHtml::link('',Yii::app()->createURL('machineAgent/productUpdate',array('id'=>$data->machine_id,'product_id'=>$data->id)),array('class'=>'edit','title'=>Yii::t('Public','编辑')))?>
		<?php echo CHtml::link('',Yii::app()->createURL('machineAgent/productRemove',array('id'=>$data->machine_id,'product_id'=>$data->id)),array('class'=>'del','title'=>Yii::t('Machine','解除绑定'),'onclick'=>'return removeAdvert(this,"'.$data->name.'")'))?>
	</div>
	<?php
		$class = ""; 
		$content = Yii::t('Machine','还剩');
		$fontColor = "green";
		$lastDay = ceil(($data->activity_end_time-time())/84600);
		$lastDay = $lastDay <= -0?-$lastDay:$lastDay;
                
		if($data->use_status=='0'){//如果是未使用状态
			$class = "ad-disabled";
		}else if (strtotime($data->activity_end_time)<time()){//如果过期,这里就排除了是未使用的状态
			$content = Yii::t('Machine','过期');
			$class="  ad-expired";
			$fontColor = "red";
		}
	?>
	<a class="ad <?php echo $class;?>" <?php echo $css2?> href="<?php echo $this->createUrl('machineAgent/productUpdate',array('id'=>$data->machine_id,'product_id'=>$data->id))?>" title="<?php echo CHtml::encode($data->content)?>">	
	
		<span class="left">
			<span class="ad-logo">
				<img alt="<?php echo $data->content?>" src='<?php 
                                if(isset($data->thumbnail->path)){
                                    echo GT_IMG_DOMAIN.str_replace("/uploads", "", $data->thumbnail->path);
                                }
                                ?>' />
			</span>
		</span>
		<span class="right">
			<span class="name"><?php echo CHtml::encode($data->name); ?></span> 
			<span><?php echo Yii::t('Machine','库存')?>：<i><?php echo CHtml::encode($data->stock); ?></i></span>  
			<span><?php echo Yii::t('Machine','零售价')?>：<i><?php echo CHtml::encode($data->price); ?></i></span> 
			<span class="day">
				<?php echo $content?>
				<i style="color:<?php echo $fontColor?>"><?php echo $lastDay; ?> </i><?php echo Yii::t('Product','天')?>
			</span> 
		</span>
		<span class="date"><?php echo Yii::t('Machine','开始日期')?>：<i><?php echo CHtml::encode(date('Y-m-d',strtotime($data->activity_start_time))); ?></i></span><?php Yii::app()->language=='en'?"&nbsp;&nbsp;":"&nbsp;&nbsp;&nbsp;&nbsp;"?>
		<span class="date"><?php echo Yii::t('Machine','结束日期')?>：<i><?php echo CHtml::encode(date('Y-m-d',strtotime($data->activity_end_time))); ?></i></span>
		

	</a>
</li> 