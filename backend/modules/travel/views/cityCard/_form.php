<?php
/**
 * @var CityCardController $this
 * @var CityCard $model
 * @var CActiveForm $form
 */
$form = $this->beginWidget('ActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
        ));
?>
<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
       <tr><th class="title-th even" colspan="2" style="text-align: center;"></th></tr>
    <tr>
        <th width="120px">
            <?php echo $form->labelEx($model, 'name'); ?>：
        </th>
        <td>
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj ','Placeholder'=>'请输入中文名称')); ?>
            <?php echo $form->textField($model,'name_en',array('class'=>'text-input-bj ','Placeholder'=>'请输入英文名称'));?>
            <?php echo $form->error($model, 'name'); ?>
            <?php echo $form->error($model, 'name_en'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right">
            <?php echo $form->label($model, 'city_name', array('required' => true)); ?>：
        </th>
        <td>
            <?php
            echo CHtml::dropDownList('nation',$nation, CHtml::listData(CActiveRecord::model('Nation')->findAll(), 'id', 'name'),
                    array(
                        'class'=>'text-input-bj',
                        'prompt' => '全部',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('updateProvince'),
                            'dataType' => 'json',
                            'data' => array('nation' => 'js:this.value'),
                            'success' => 'function(data) {
                                            $("#province").html(data.dropDownProvince);
                                            $("#city").html(data.dropDownCities);
                                        }',
        )));
            echo CHtml::dropDownList('province',$province->code, CHtml::listData(Province::model()->findAll(array('select'=>'code,name','condition'=>'nation_id=:nation_id','params'=>array(':nation_id'=>$nation->id))), 'code', 'name') ,
                     array(
                         'class'=>'text-input-bj',
                         'prompt' => '全部',
                         'ajax' => array(
                             'type' => 'POST',
                             'url' => $this->createUrl('updateCities'),
                             'update' => '#city',
                             'data' => array('province' => 'js:this.value'),
                         )));       
            echo CHtml::dropDownList('city',$city->code, CHtml::listData(City::model()->findAll(array('select'=>'code,name','condition'=>'province_code=:code','params'=>array(':code'=>$province->code))), 'code', 'name'), array('class'=>'text-input-bj','prompt' => '全部'));
            ?>
    </tr>
   <tr><th class="title-th even" colspan="2" style="text-align: left;"><?php echo Yii::t('citycard', '名片主题'); ?></th></tr>
   <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'description'); ?>：</th>
        <td class="odd">
            <?php $this->widget('comext.wdueditor.WDueditor', array('model' => $model, 'attribute' => 'description')); ?>
            <?php echo $form->error($model, 'description'); ?><br/>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'picture'); ?>：</th>
        <td>
            <?php
            $this->widget('common.widgets.CUploadPic', array(
                'form' => $form,
                'model' => $model,
                'attribute' => 'picture',
                'num' => 5,
                'folder_name' => 'travel/hotelPicture',       
                'btn_value'=>'上传图片',
            ));
            ?>
            <?php echo $form->error($model, 'picture', array('style' => 'position: relative; display: inline-block'), false, false); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('citycard', '新增') : Yii::t('citycard', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr> 
</table>
<?php $this->endWidget(); ?>