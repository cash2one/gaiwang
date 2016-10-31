<?php
/* @var $this FranchiseeConsumptionRecordController */
/* @var $model FranchiseeConsumptionRecord */
/* @var $form CActiveForm */
?>
<div class="border-info clearfix">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'franchisee-consumption-record-form',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <thead>
            <tr>
                <th>
                    <?php echo $form->label($model, 'franchisee_name'); ?>：
                </th>
                <td>
                    <?php echo $form->textField($model, 'franchisee_name', array('class' => 'text-input-bj  middle')); ?>
                </td>
            </tr>
        </thead>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <thead>
            <tr>
                <th>
                    <?php echo $form->label($model, 'franchisee_code'); ?>：
                </th>
                <td>
                    <?php echo $form->textField($model, 'franchisee_code', array('class' => 'text-input-bj')); ?>
                </td>
            </tr>
        </thead>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <thead>
            <tr>
                <th>
                    <?php echo $form->label($model, 'franchisee_mobile'); ?>：
                </th>
                <td>
                    <?php echo $form->textField($model, 'franchisee_mobile', array('class' => 'text-input-bj least')); ?>
                </td>
            </tr>
        </thead>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody><tr>
                <th>
                    <?php echo $form->label($model, 'franchisee_province_id'); ?>：
                </th>
                <td>
                    <?php
                    echo $form->dropDownList($model, 'franchisee_province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                        'prompt' => Yii::t('member', '选择省份'),
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('/region/updateCity'),
                            'dataType' => 'json',
                            'data' => array(
                                'province_id' => 'js:this.value',
                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                            ),
                            'success' => 'function(data) {
	                            $("#FranchiseeConsumptionRecord_franchisee_city_id").html(data.dropDownCities);
	                        }',
                    )));
                    ?>
                    <?php echo $form->error($model, 'franchisee_province_id'); ?>
                    <?php
                    echo $form->dropDownList($model, 'franchisee_city_id', Region::getRegionByParentId($model->franchisee_province_id), array(
                        'prompt' => Yii::t('member', '选择城市'),
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('/region/updateArea'),
                            'update' => '#FranchiseeConsumptionRecord_franchisee_district_id',
                            'data' => array(
                                'city_id' => 'js:this.value',
                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                            ),
                    )));
                    ?>
                    <?php echo $form->error($model, 'franchisee_city_id'); ?>
                    <?php
                    echo $form->dropDownList($model, 'franchisee_district_id', Region::getRegionByParentId($model->franchisee_city_id), array(
                        'prompt' => Yii::t('member', '选择地区'),
                        'ajax' => array(
                            'type' => 'POST',
                            'data' => array(
                                'city_id' => 'js:this.value',
                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                            ),
                    )));
                    ?>
                    <?php echo $form->error($model, 'franchisee_district_id'); ?>
                </td>
            </tr>
        </tbody></table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <thead>
            <tr>
                <th>
                    <?php echo $form->label($model, 'status'); ?>：
                </th>
                <td id="tdDistStatus">
                    <?php echo $form->radioButtonList($model, 'status', FranchiseeConsumptionRecord::getCheckStatus(), array('separator' => '')) ?>
                </td>
            </tr>
        </thead>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <thead>
            <tr>
                <th>
                    <?php echo $form->label($model, 'start_time'); ?>：
                </th>
                <td>
                    <?php
                    $this->widget('comext.timepicker.timepicker', array(
	                    'model'=>$model,
	                    'name'=>'start_time',
	                ));
                    ?> -
                    <?php
                    $this->widget('comext.timepicker.timepicker', array(
	                    'model'=>$model,
	                    'name'=>'end_time',
	                ));
                    ?>
                </td>
                <th>
                    <?php echo $form->label($model, 'gai_number');?>
                </th>
                <td>
                    <?php echo $form->textField($model, 'gai_number', array('class' => 'text-input-bj least'));?>
                </td>
<!--                <th>-->
<!--                    --><?php //echo $form->label($model, 'data_style'); ?><!--：-->
<!--                </th>-->
<!--                <td>-->
<!--                    --><?php //echo $form->dropDownList($model, 'data_style', FranchiseeConsumptionRecord::getLookStyle());?>
<!--                </td>-->
                <th>
                    <?php echo $form->label($model, 'record_type'); ?>：
                </th>
                <td id="tdDistStatus"> 
                    <?php echo $form->dropDownList($model, 'record_type', FranchiseeConsumptionRecord::getRecordType(), array('separator' => '')) ?>
                </td>
            </tr>
        </thead>
    </table>
    <div class="c10">
    </div>
    <?php echo CHtml::submitButton(Yii::t('franchisee', '搜索'), array('class' => 'reg-sub')); ?>
    <?php if (Yii::app()->user->checkAccess('FranchiseeConsumptionRecord.Confirm')): ?>
        <?php echo CHtml::Button(Yii::t('franchiseeConsumptionRecord', '批量对账'), array('class' => 'regm-sub', 'id' => 'batchReconciliation')); ?>
    <?php endif; ?>
    <?php if (Yii::app()->user->checkAccess('FranchiseeConsumptionRecord.ReBack')): ?>
        <?php echo CHtml::Button(Yii::t('franchiseeConsumptionRecord', '申请撤销'), array('class' => 'regm-sub', 'id' => 'reback')); ?>
    <?php endif; ?>
    <?php $this->endWidget(); ?>
</div>