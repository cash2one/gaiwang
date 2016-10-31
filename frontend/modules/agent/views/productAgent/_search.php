<?php
Yii::app()->clientScript->registerScript('search', "
$('#productagent-search-form').submit(function(){
        var ajaxRequest = $(this).serialize();
        $.fn.yiiListView.update(
                'product-list',
                {data: ajaxRequest}
            )
	return false;
});
");
?>
<div class="panel">
	<?php
		$form = $this->beginWidget('CActiveForm',array(
			'id' => 'productagent-search-form',
			'action' => Yii::app()->createUrl($this->route),
			'method' => 'get',
		));
	?>
	<table cellpadding="0" cellspacing="0" class="searchTable">
		<tr>
			<td class="align-right"><?php echo Yii::t('Public','标题')?>：</td>
			<td align="left" style="width:400px;">
				<?php echo $form->textField($model, 'name', array('class' => 'inputbox width400'))?>
			</td>
			<td class="align-right" style="padding-left:40px;"><?php echo Yii::t('Public','所在地区')?>：</td>
			<td colspan="2">
				<?php
					echo $form->dropDownList($model, 'province_id', RegionAgent::getRegionByParentId($this->getSession('agent_region')), array(
							'class' => 'input_box2 mt5 dib fl',
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
                                            $("#ProductAgent_city_id").html(data.dropDownCities);
                                            $("#ProductAgent_district_id").html(data.dropDownCounties);
                                        }',
                            )));
                        ?>
 				<?php
					echo $form->dropDownList($model, 'city_id', array(), array(
							'class' => 'input_box2 mt5 dib fl',
                            'prompt' => Yii::t('Public', '选择城市'),
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('region/getRegionByParentId'),
                                'update' => '#ProductAgent_district_id',
                                'data' => array(
                                    'pid' => 'js:this.value',
									'type' => 'city',
                                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                ),
                            )));
				?>
				<?php
					echo $form->dropDownList($model, 'district_id', array(), array(
                            'class' => 'input_box2 mt5 dib fl',
                            'prompt' => Yii::t('Public', '选择地区'),
//                            'ajax' => array(
//                                'type' => 'POST',
//                                'data' => array(
//                                    'city_id' => 'js:this.value',
//                                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
//                                ),
//                            )
                            ));
				?>
			</td>
		</tr>
		<tr>
			<td class="align-right"><?php echo Yii::t('Public','状态')?> ：</td>
			<td id="tdStatus" class="radio">
				<?php echo $form->radioButtonList($model, 'status', CMap::mergeArray(array(''=>Yii::t('Public', '全部')),ProductAgent::getStatus()),array('separator'=>' '))?>
			</td>
			<td class="align-right"><?php echo Yii::t('Product','活动时间')?> ：</td>
			<td>
				<?php
					$this->widget('comext.timepicker.timepicker', array(
						'cssClass' => 'inputbox width100',
						'select' => 'date',
						'model' => $model,
						'id'=>'ProductAgent_activity_start_time',
						'name' => 'activity_start_time',
					));
				?>
				<?php
					$this->widget('comext.timepicker.timepicker', array(
						'cssClass' => 'inputbox width100',
						'select' => 'date',
						'model' => $model,
						'id'=>'ProductAgent_activity_end_time',
						'name' => 'activity_end_time',
					));
				?>
			</td>
			<td>&nbsp;&nbsp;
			<?php echo CHtml::submitButton(Yii::t('Public','搜索'),array('class'=>'button_04','id'=>'submit_button'))?>
		</tr>
	</table>
	<?php echo $form->hiddenField($model, 'category_id')?>
	<?php echo $form->hiddenField($model, 'category_pid')?>
       <?php echo CHtml::hiddenField("id",$model->machine_id)?>
	<?php $this->endWidget();?>	
</div>
	
	
