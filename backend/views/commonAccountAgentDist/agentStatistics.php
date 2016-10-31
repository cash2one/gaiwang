	<script type="text/javascript">
		function exportExcel(){
			var chooseDate = $('#search_time').val();
			if(chooseDate==""){
				alert("请选择指定日期");
				return;
			}
			window.open("<?php echo Yii::app()->createUrl('commonAccountAgentDist/agentDayExcel')?>&date="+chooseDate);
		}
	</script>
	<div class="border-info clearfix">
		<?php
			Yii::app()->clientScript->registerScript('search', "
				$('#agent-search-form').submit(function(data){
					var week = ['星期一','星期二','星期三','星期四','星期五','星期六','星期日']
					var chooseDate = $('#search_time').val();
					if(chooseDate==''){
						alert('请选择指定日期');
						return false;
					}
					var mydate = new Date(chooseDate.replace(/-/g,'/'));
					$('.icon_where').html(chooseDate+' '+week[mydate.getDay()-1]);
					$('#agent-day-grid').yiiGridView('update', {
						data: $(this).serialize()
					});
					return false;
				});
			");
		?>
		<?php 
			$form=$this->beginWidget('CActiveForm', array(
				'id'=>'agent-search-form',
			    'action'=>Yii::app()->createUrl($this->route),
			    'method'=>'get',
			)); 
		?>
		<table cellpadding="0" cellspacing="0" class="searchTable">
			<tr>
				<td>时间：</td>
				<td>
					<?php
						$this->widget('comext.timepicker.timepicker', array(
							'cssClass' => 'text-input-bj least datefield',
							'id'=>'search_time',
							'name'=>'AgentDay[statistics_date]',
							'select' => 'date',
//							'model' => $model,
//							'name' => 'statistics_date',
							'options' => array('value'=>$date),
						));
					?>
				</td>
			</tr>
		</table>
		<?php echo CHtml::submitButton(Yii::t('Publi', '搜索'),array('class'=>'reg-sub'))?>
		<?php echo CHtml::button(Yii::t('Publi', '导出Excel'),array('class'=>'regm-sub','onclick'=>'exportExcel()'))?>
		<?php $this->endWidget(); ?>
	</div>
	<div class="c10"></div>
	<div align="right" style="line-height:1.5;"><span style="font-size:larger" class="icon_where"><?php echo $date." 星期".$weekDay;?></span></div>
	
		
		<div id="agent-day-grid" class="grid-view">
			<table class="tab-reg">
				<thead>
					<tr>
						<th>账户</th>
						<th>盖网通(元)</th>
						<th>盖网通(元)</th>
						<th>合计(元)</th>
						<th>余额(元)</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($data)){$i=0;?>
		            	<?php foreach ($data as $row){?>
		            	<?php $i++;?>
		                <tr class="<?php echo $i%2?"odd":"even"?>">
		                    <td style="text-align:left;width:500px">
		                    	<?php 
									if ($row['depth'] == 0) {
										$width = "20px";
									}else if ($row['depth'] == 1) {
										$width = "50px";
									}else if ($row['depth'] == 2) {
										$width = "100px";
									}else{
										$width = "160px";
									}
									$name = $row['depth'] == 0? $row['name']:"-".$row['name'];
									echo "<span style='margin-left:$width'>$name</span>";
		                    	?>
		                    </td>
		                    <td><?php echo $row['machine_money']?></td>
		                    <td><?php echo $row['gai_money']?></td>
		                    <td><?php echo $row['gai_money']+$row['machine_money']?></td>
		                    <td><?php echo $row['cash']?></td>
		                </tr>
		                <?php };?>
	                <?php }?>
	           </tbody>
           </table>
			<?php if (!empty($data)){?>
			<div class="pager">
				<?php
					$this->widget('LinkPager',array('pages'=>$pages));
				?>
				<?php }?>
			</div>
		</div>
	<?php
//		$this->widget('GridView', array(
//			    'id' => 'agent-day-grid',
//			    'dataProvider' => $model->search(),
//			    'cssFile' => false,
//			    'itemsCssClass' => 'tab-reg',
//			    'columns' => array(
//					array(
//						'htmlOptions' => array('style' => 'text-align:left','width'=>'500px'),
//						'name' => Yii::t('AgentDay', '账户'),
//						'value' => 'AgentDay::getCity($data)',
//						'type' => 'raw',
//					),
//					array(
//						'name' => Yii::t('AgentDay', '盖网通(元)'),
//						'value' => '$data->machine_money1',
//					),
//					array(
//						'name' => Yii::t('AgentDay', '盖网(元)'),
//						'value' => '$data->gai_money1',
//					),
//			        array(
//			            'name' => Yii::t('AgentDay', '合计(元)'),
//			            'value' => '$data->machine_money+$data->gai_money',
//			        ),
//			        array(
//			            'name' => Yii::t('AgentDay', '余额(元)'),
//			            'value' => '$data->cash',
//			        ),
//		       ),
//		    )
//		);
	?>
	
	
<script type="text/javascript">
<!--
function showExport(){
	exportExcel();
}
//-->
</script>
	