<?php 
	//单独查询的数据的处理
	$machineid = $data->id;
	if (isset($machine[$machineid])){
		$last_sign_time = date('Y-m-d H:i:s', $machine[$machineid]['last_sign_time']);			//最后签到时间
		$stop_status_count = $machine[$machineid]['stop_status_count'];							//异常个数
		$monitor_path = $machine[$machineid]['monitor_path'];									//最近一次图片
	}else{
		$last_sign_time = 0;												//最后签到时间
		$stop_status_count = 0;																	//异常个数
		$monitor_path = '';																		//最近一次图片
	}
	
	$provinceName = isset($region[$data->province_id])?$region[$data->province_id]:"";			//省
	$cityName = isset($region[$data->city_id])?$region[$data->city_id]:"";						//市
	$districtName = isset($region[$data->district_id])?$region[$data->district_id]:"";			//区
?>
<li style="margin-top: 10px; margin-left:35px;" class="<?php if($data->run_status == MachineAgent::RUN_STATUS_OPERATION):?>listing_move<?php else:?>listing_cease<?php endif;?> fl">
	<div class="move_status">
		<div class="move_left fl">
			<input type="checkbox" class="cbbox" id="dcbbox_69">
                        <a class="move_left_a<?php echo $data->run_status?>" title="最后签到时间：<?php echo date('Y-m-d H:i:s', $data->last_sign_time)?>" href="<?php echo $this->createUrl('machineAgent/staticCount',array('id'=>$data->id))?>"><?php echo MachineAgent::getRunStatus($data->run_status)?></a>
				  <?php if($stop_status_count):?>
				 
                                  <?php echo CHtml::link( $data->stop_status_count,$this->createUrl('machineMonitorAgent/index',array('status'=>2,'machineNmae'=>$data->name)),array('class'=>'move_left_a4','title'=>'今天共有'.$data->stop_status_count.'个异常发生。点击查询详情'))?>
                                  
				  <?php endif;?>		  
		</div>
                
            <span style="float: left;margin-top:8px;position: relative;left:-20px;"><a href="<?php echo $this->createUrl('machineMonitorAgent/monitorList',array('id'=>$data->id,'machineName'=>$data->name))?>" style="color:#666;"><?php echo Yii::t('Machine','监控图')?></a></span>
            
            <div class="move_right fr" style="width:120px;">
                        <?php echo CHtml::link('',array('machineAgent/rcCount','machine_id'=>$data->id),array('class'=>'move_right_a4 fl','title'=>  Yii::t('Franchisee','加盟商运营数据')));?>
			<?php 
    				$this->widget('application.modules.agent.widgets.CBDMap',array(
    					'lng'=>$data->loc_lng,
    					'lat'=>$data->loc_lat,
    					'level' => 18
    				)); 
			?>
                        <?php echo CHtml::link('','javascript:doEdit('.$data->id.')',array('class'=>'move_right_a2 fl','title'=>Yii::t('Public','编辑')))?>
			<?php echo CHtml::link('',$this->createUrl('machineAgent/advertList',array('id'=>$data->id)),array('class'=>'move_right_a3 fl','title'=>Yii::t('Machine','资源管理')))?>
		</div>
	</div>
	<div class="move_content">
		<div class="move_content_left fl">
			<?php if($data->monitor_path):?>
                    <a href='<?php echo $data->monitor_path ? Tool::showGtImg($data->monitor_path) : ""?>' onclick="return _showBigPic(this)" id="ShowImg<?php echo $data->id?>">
                        <img width="50" height="89" src="<?php echo $data->monitor_path != "" ? Tool::showGtImg($data->monitor_path, 50, 89) : ""?>"></a>
			<?php endif;?>
		</div>
		<div class="move_content_right fl">
			<div class="move_content_right1">
				<?php echo CHtml::link($data->name, 'javascript:doEdit('.$data->id.')', array('title'=>$data->name))?>
			</div>
			<div class="move_content_right2">
				<?php echo CHtml::link($data->biz_name, array('machineAgent/index','MachineAgent[biz_name]'=>$data->biz_name), array('title'=>$data->biz_name))?>	
			</div>
			<div class="move_content_right3">
				<?php echo CHtml::link($data->province_name,array('machineAgent/index','MachineAgent[province_id]'=>$data->province_id))?>&nbsp;
				<?php echo CHtml::link($data->city_name,array('machineAgent/index','MachineAgent[province_id]'=>$data->province_id,'MachineAgent[city_id]'=>$data->city_id))?>&nbsp;
				<?php echo CHtml::link($data->district_name,array('machineAgent/index','MachineAgent[province_id]'=>$data->province_id,'MachineAgent[city_id]'=>$data->city_id,'MachineAgent[district_id]'=>$data->district_id))?>&nbsp;
			</div>
		</div>
	</div>
</li>