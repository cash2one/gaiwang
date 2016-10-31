<?php
/* @var $this MachineController */
/* @var $model Machine */
/* @var $form CActiveForm */
?>

<div class="border-info clearfix search-form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th align="right"><?php echo $form->label($model, 'name'); ?>：</th>
            <td><?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th align="right">盖网通地区：</th>
            <td>
            <?php
                echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                    'prompt' => Yii::t('machine', '选择省份'),
                    'class' => 'text-input-bj',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/region/updateCity'),
                        'dataType' => 'json',
                        'data' => array(
                            'province_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => 'function(data) {
                            $("#Machine_city_id").html(data.dropDownCities);
                            $("#Machine_district_id").html(data.dropDownCounties);
                        }',
                )));
                ?>
                <?php
                echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                    'prompt' => Yii::t('machine', '选择城市'),
                    'class' => 'text-input-bj',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/region/updateArea'),
                        'update' => '#Machine_district_id',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
                ?>
                <?php
                echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                    'prompt' => Yii::t('machine', '选择地区'),
                    'class' => 'text-input-bj',
                    'ajax' => array(
                        'type' => 'POST',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
                ?> 
            </td>
        </tr>
    </table>
     
    <!--  <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th align="right"><?php echo $form->label($model, 'city_id'); ?>：</th>
            <td><?php echo $form->textField($model, 'city_id', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th align="right"><?php echo $form->label($model, 'district_id'); ?>：</th>
            <td><?php echo $form->textField($model, 'district_id', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>-->
    
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th align="right"><?php echo $form->label($model, 'biz_name'); ?>：</th>
            <td><?php echo $form->textField($model, 'biz_name', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th align="right"><?php echo $form->label($model, 'intro_member_id'); ?>：</th>
            <td><?php echo $form->textField($model, 'intro_member_id', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <td><?php echo CHtml::submitButton(Yii::t('machine', '搜索'), array('class' => 'reg-sub')); ?></td>
        </tr>
    </table>
    
    <?php $this->endWidget(); ?>
<?php $form = $this->beginWidget('CActiveForm',array(
		'id'=>'Export-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array('validateonSubmit'=>true),
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));?>

 <table cellpadding="0" cellspacing="0" class="searchTable"> 
        <tr> 
           <th width="20%"> 
               导入盖机推荐人:&nbsp;&nbsp;<font color="red">*</font> 
            </th> 
            <td width="50%"> 
                <?php echo CHtml::activeFileField($model, 'file'); ?> 
               <?php echo $form->error($model,'file');?> 
            </td> 
             <td> 
                <?php echo CHtml::button('导入', array('submit' => array('/Machine/Import')
                		                              , 'class'=>'reg-sub'
                )); ?>
            </td> 
        </tr> 
    </table> 
     <?php $this->endWidget();?>
</div>