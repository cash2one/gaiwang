<?php
Yii::app()->clientScript->registerScript('search', "
$('.panel form').submit(function(){
        var ajaxRequest = $(this).serialize();
        $.fn.yiiListView.update(
                'machine-advert-agent-list',
                {data: ajaxRequest}
            )
	return false;
});
");
?>
<div class="panel">
	<?php $form = $this->beginWidget('CActiveForm', array(
		'action' => Yii::app()->createURL($this->route),
		'method'=>'get',
	));?>
	<table cellpadding="0" cellspacing="0" class="searchTable">
		<tr>
			<td class="align-right"><?php echo Yii::t('Public','标题')?>：</td>
			<td align="left" style="width:300px;">
				<?php echo $form->textField($model, 'title', array('class' => 'inputbox width200'))?>
			</td>
			<td class="align-right" style="padding-left:40px;"><?php echo Yii::t('Public','所在地区')?>：</td>
			<td colspan="2">
				<?php
		            echo $form->dropDownList($model, 'province_id', RegionAgent::getRegionByParentId($this->getSession('agent_region')), array(
		                'prompt' => Yii::t('Public','选择省份'),
		                'ajax' => array(
		                    'type' => 'POST',
		                    'url' => $this->createUrl('region/getRegionByParentId'),
		                    'dataType' => 'json',
		                    'data' => array(
		                        'pid' => 'js:this.value',
		            			'type' => 'province',
		                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
		                    ),
		                    'success' => 'function(data) {
		                            $("#MachineAdvertAgent_city_id").html(data.dropDownCities);
		                            $("#MachineAdvertAgent_district_id").html(data.dropDownCounties);
		                        }',
		            )));
				?>
	            <?php 
	            
	            echo $form->dropDownList($model, 'city_id', array(), array(
                    'prompt' => Yii::t('Public','选择城市'),
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('region/getRegionByParentId'),
                        'update' => '#MachineAdvertAgent_district_id',
                        'data' => array(
                            'pid' => 'js:this.value',
	            			'type' => 'city',
                            Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                        ),
                )));
	            ?>
	            <?php 
	            
	            echo $form->dropDownList($model, 'district_id', array(), array(
                    'prompt' => Yii::t('Public','选择区/县'),
                    ));
	            ?>
			</td>
		</tr>
		<tr>
			<td class="align-right"><?php echo Yii::t('Public','状态')?>：</td>
			<td id="tdStatus" class="radio">
				<?php echo $form->radioButtonList($model, 'use_status', MachineAdvertAgent::getUseStatus(),array('separator'=>' '))?>
			</td>
			<td class="align-right"><?php echo Yii::t('Public','服务结束时间')?>：</td>
			<td>
				<?php echo $form->textField($model, 'svc_start_time', array('class' => 'inputbox width150', 'onfocus' => 'WdatePicker()'))?>
				<?php echo $form->textField($model, 'svc_end_time', array('class' => 'inputbox width150', 'onfocus' => 'WdatePicker()'))?>
			</td>
			<td>&nbsp;&nbsp;
				<?php echo CHtml::submitButton(Yii::t('Public','搜索'),array('class'=>'button_04','id'=>'search_button'))?>
		</tr>
	</table>
	<?php echo $form->hiddenField($model, 'category_id')?>
	<?php echo $form->hiddenField($model, 'category_pid')?>
	<?php $this->endWidget();?>
</div>