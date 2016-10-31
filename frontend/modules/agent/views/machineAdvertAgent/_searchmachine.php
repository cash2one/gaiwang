<div class="optPanel search-form" style="display: block;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>$this->createUrl($this->route),
	'method'=>'get',
)); ?>
	<div class="toolbar img01"><?php echo Yii::t('Machine','盖机管理');?></div>
        <div class="panel">
            <table cellspacing="0" cellpadding="0" class="searchTable">
                <tr>
                    <td class="align-right"><?php echo $form->label($model, 'name')?>：</td>
                    <td align="left">
                        <?php echo $form->textField($model, 'name', array('class'=>'inputbox width200'))?>
                    </td>
                    <td style="padding-left: 40px;" class="align-right"><?php echo Yii::t('Public','所在地区')?>：</td>
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
			                            $("#MachineAgent_city_id").html(data.dropDownCities);
			                            $("#MachineAgent_district_id").html(data.dropDownCounties);
			                        }',
			            )));
			            ?>
			            <?php 
			            echo $form->dropDownList($model, 'city_id', array(), array(
		                    'prompt' => Yii::t('Public','选择城市'),
		                    'ajax' => array(
		                        'type' => 'POST',
		                        'url' => $this->createUrl('region/getRegionByParentId'),
		                        'update' => '#MachineAgent_district_id',
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
                    <td class="align-right"><?php echo $form->label($model, 'biz_name')?>：</td>
                    <td><?php echo $form->textField($model, 'biz_name', array('class'=>'inputbox width200'))?></td>
                    <td class="align-right"><?php echo $form->label($model, 'run_status')?>：</td>
                    <td class="radio" id="tdMachineStatus">
                        <?php echo $form->radioButtonList($model,'run_status',CMap::mergeArray(array(''=>Yii::t('Public','全部')),  MachineAgent::getRunStatus()), array('separator'=>' ')); ?>
                        <?php echo CHtml::submitButton(Yii::t('Public','搜索'), array('class'=>'button_04','style'=>'margin-left: 40px;')); ?>
                    </td>
                    
                </tr>
            </table>
            <?php $form->hiddenField($model,'advertid');?>
            <?php $form->hiddenField($model,'adtype');?>
       </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->