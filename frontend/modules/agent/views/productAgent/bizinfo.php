<?php 
	Yii::app()->clientScript->registerScript('search', "
	$('#franchisee-form').submit(function(){
		$('#franchisee-grid').yiiGridView('update', {
			data: $(this).serialize()
		});
		return false;
	});
	");
?>
<div class="ctx">
	<div class="optPanel">
		<div class="panel">
			<?php $form=$this->beginWidget('CActiveForm', array(
				'action'=>Yii::app()->createUrl($this->route),
				'method'=>'get',
				'id'=>'franchisee-form'
			)); ?>
			<table cellspacing="0" cellpadding="0" class="searchTable">
				<tr>
					<td class="align-right"><?php echo Yii::t('Franchisee','会员编号')?>：</td>
					<td align="left">
						<?php echo $form->textField($model, 'gai_number', array('class'=>'inputbox width200'))?>
					</td>
					<td style="padding-left: 40px;" class="align-right"><?php echo Yii::t('Public','所在地区')?>：</td>
					<td colspan="2">
						<?php
							echo $form->dropDownList($model, 'province_id', RegionAgent::getRegionByParentId($this->getSession('agent_region')), array(
		                            'prompt' => Yii::t('Public', '选择省份'),
		                            'ajax' => array(
		                                'type' => 'POST',
		                                'url' => $this->createUrl('region/getRegionByParentId'),
		                                'dataType' => 'json',
		                                'data' => array(
		                                    'pid' => 'js:this.value',
											'type' => 'province',
		                                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
		                                ),
		                                'success' => 'function(data) {
		                                            $("#FranchiseeAgent_city_id").html(data.dropDownCities);
		                                            $("#FranchiseeAgent_district_id").html(data.dropDownCounties);
		                                        }',
		                            )));
						?>
		 				<?php
							echo $form->dropDownList($model, 'city_id', array(), array(
		                            'prompt' => Yii::t('Public', '选择城市'),
		                            'ajax' => array(
		                                'type' => 'POST',
		                                'url' => $this->createUrl('region/getRegionByParentId'),
		                                'update' => '#FranchiseeAgent_district_id',
		                                'data' => array(
		                                    'pid' => 'js:this.value',
											'type' => 'city',
		                                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
		                                ),
		                            )));
						?>
						<?php
							echo $form->dropDownList($model, 'district_id', array(), array(
		                            'prompt' => Yii::t('Public', '选择地区'),
//		                            'ajax' => array(
//		                                'type' => 'POST',
//		                                'data' => array(
//		                                    'city_id' => 'js:this.value',
//		                                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
//		                                ),
//		                            )
		                            ));
						?>
					</td>
				</tr>
				<tr>
	                <td class="align-right"><?php echo Yii::t('Public','手机')?> ：</td>
	                <td align="left" style="width:300px;">
	                	<?php echo $form->textField($model,'mobile',array('class'=>'inputbox width100'))?>
	                </td>
	                <td class="align-right"> <?php echo Yii::t('Public','名称')?>：</td>
	                <td>
	                	<?php echo $form->textField($model,'name',array('class'=>'inputbox width100'))?>
	                </td>
					<td id="tdMachineStatus">
						<?php echo CHtml::submitButton(Yii::t('Public','搜索'), array('class'=>'button_04','style'=>'margin-left: 40px;')); ?>
					</td>
		        </tr>
		    </table>
		<?php $this->endWidget(); ?>
		</div>
	</div>
	<div class="ctxTable" id="dListTable">
		<?php $this->widget('application.modules.agent.widgets.grid.GridView', array(
			'id'=>'franchisee-grid',
	    	'itemsCssClass'=>'listTable',
	    	'selectableRows' => 1,
	    	'pager' => array('class' => 'application.modules.agent.widgets.LinkPager','maxButtonCount'=>3),
			'dataProvider'=>$model->searchBiz(),
			'columns'=>array(
				array(
					'header' => Yii::t('Public','选择'),
					'htmlOptions' => array('width' => '5%'),
					'headerHtmlOptions' => array('width' => '5%'),
					'class' => 'application.modules.agent.widgets.grid.CheckBoxColumn',
					'type' => 'radio',
					'checkBoxHtmlOptions' => array(
						'name' => 'id[]',
						'value' => '$data->id'
					)
				),
				array(
					'headerHtmlOptions' => array('width' => '150px','style'=>'font-color:#ffffff'),
					'name' => 'name',
					'value' => '$data->name'
				),
				array(
					'headerHtmlOptions' => array('width' => '120px'),
					'name' => 'province_id',
					'value' => '$data->province_name'
				),
				array(
					'headerHtmlOptions' => array('width' => '120px'),
					'name' => 'city_id',
					'value' => '$data->city_name'
				),
				array(
					'name' => 'district_id',
					'value' => '$data->district_name'
				),
				array(
					'name' => 'street',
					'value' => '$data->street'
				),
			),
		)); ?>
	</div>
</div>
