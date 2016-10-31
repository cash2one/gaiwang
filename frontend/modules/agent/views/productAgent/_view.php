<li>
	<input type="checkbox" class="cbbox" value="<?php echo $data->id?>"/>
	<div class="opt">
		<?php echo CHtml::link('',Yii::app()->createURL('productAgent/bindMachine',array('id'=>$data->id)),array('class'=>'gm','title'=>Yii::t('Product','绑定盖机')))?>
		<?php echo CHtml::link('',Yii::app()->createURL('productAgent/update',array('id'=>$data->id)),array('class'=>'edit','title'=>Yii::t('Public','编辑')))?>
		<?php echo CHtml::link('',Yii::app()->createURL('productAgent/delete',array('id'=>$data->id)),array('class'=>'del','title'=>Yii::t('Public','删除'),'onclick'=>'return deleteAdvert(this,"'.$data->name.'")'))?>
		<?php echo CHtml::link('',Yii::app()->createURL('productAgent/copy',array('id'=>$data->id)),array('class'=>'copy','title'=>Yii::t('Public','复制')))?>
	</div>
	<?php
		$class = ""; 
		$content = Yii::t('Product','还剩');
		$fontColor = "green";
		$lastDay = ceil((strtotime($data->activity_end_time)-time())/84600);
		if($lastDay<0)$content = Yii::t('Product','过期');
		$lastDay = $lastDay <= -0?-$lastDay:$lastDay;
		if($data->status=='0'|$data->status=='2'){//如果是待审核或者未通过
			$class = "ad-disabled";
		}else if (strtotime($data->activity_end_time)<time()){//如果过期,这里就排除了是待审核或者未通过
			$class="  ad-expired";
			$fontColor = "red";
		}
	?>
	<a class="ad <?php echo $class;?>" href="<?php echo Yii::app()->createUrl('productAgent/update',array('id'=>$data->id))?>" title="<?php echo CHtml::encode($data->name)?>">
		<span class="left">
			<span class="ad-logo">
				<img alt="" src='<?php 
                                if(isset($data->thumbnail->path)){
                                    echo GT_IMG_DOMAIN.str_replace("/uploads", "/100x100", $data->thumbnail->path);
                                }else{
                                    echo '';
                                }
                                ?>'/>
			</span>
		</span>
		<span class="right">
			<span class="name product"><?php echo CHtml::encode($data->name); ?></span> 
			<span><?php echo Yii::t('Product','库　存')?>：<i><?php echo CHtml::encode($data->stock); ?></i></span>  
			<span><?php echo Yii::t('Product','零售价')?>：<i><?php echo CHtml::encode($data->price); ?></i></span> 
			<span class="day">
	                                    <?php echo $content?>
				<i style="color:<?php echo $fontColor?>"><?php echo $lastDay?></i><?php echo Yii::t('Product','天')?>
				<i style="margin-left:3px"><?php echo ProductAgent::getStatus($data->status); ?></i>
			</span> 
		</span>
		<span class="date"><?php echo Yii::t('Product','开始日期')?>：<i><?php echo CHtml::encode(date('Y-m-d',strtotime($data->activity_start_time))); ?></i></span>
                <?php 
                        if(Yii::app()->language=='en'){
                            echo "&nbsp;&nbsp;";
                        }  else {
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                        }
                        ?> 
		<span class="date"><?php echo Yii::t('Product','结束日期')?>：<i><?php echo CHtml::encode(date('Y-m-d',strtotime($data->activity_end_time))); ?></i></span> 
	</a>
</li> 