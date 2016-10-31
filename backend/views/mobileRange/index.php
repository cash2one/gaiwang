<?php
$this->breadcrumbs = array(
		Yii::t('MobileRange', '便民服务'),
		Yii::t('MobileRange', '号码段管理'),
); 

$form=$this->beginWidget('CActiveForm', array( 
        'id'=>'add-form', 
        'enableClientValidation'=>true, 
        'clientOptions'=>array( 'validateOnSubmit'=>true,), 
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
		'method' => 'get', 
    ));  
   ?>
<div class="border-info clearfix search-form">
<table class="searchTable">
	<tr>
	    <th class="align-right"><?php echo Yii::t('MobileRange','省份')?>：</th>
		<td>
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

                )));
                ?>
		</td>
		</td>
		<th class="align-right"><?php echo Yii::t('MobileRange','城市')?>：</th>
		<td>
		<?php  echo $form->TextField($model,'un_city_name',array('class'=>'text-input-bj  least',));?>
		</td>
		<th class="align-right"><?php echo Yii::t('MobileRange','号码段')?>：</th>
		<td>
		<?php  echo $form->TextField($model,'number_prefix',array('class'=>'text-input-bj  least',));?>
		</td>
		<th class="align-right"><?php echo Yii::t('MobileRange','运营商(1移动,2联通,3电信)')?>：</th>
		<td>
		<?php  echo $form->TextField($model,'operator',array('class'=>'text-input-bj  least',));?>
		</td>
		<td>
		<?php echo CHtml::submitButton(Yii::t('MobileRange','搜索'),array('class'=>'reg-sub','id'=>'search_button'));?>
		</td>
	</tr>
</table>
<?php $this->endwidget();

$form=$this->beginWidget('CActiveForm', array(
		'id'=>'add-form1',
		'enableClientValidation'=>true,
		'clientOptions'=>array( 'validateOnSubmit'=>true,),
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>

     <table class="searchTable"> 
        <tr> 
           <th width="20%" class="align-right"> 
                选择文件:&nbsp;&nbsp;<font color="red">*</font> 
            </th> 
            <td width="50%"> 
<!--             <input type="file" name="repair_attached_file" id="repair_attached_file" /> -->
                <?php echo CHtml::activeFileField($model, 'file'); ?> 
               <?php echo $form->error($model,'file');?> 
            </td> 
            <td> 
                <?php echo CHtml::button('导入', array('submit' => array('/MobileRange/Import')
                		                              , 'class'=>'reg-sub'
                )); ?>
            </td> 
        </tr> 
    </table> 
</div>
    <?php $this->endWidget();?>
<?php


$this->widget('GridView', array(
		'id' => 'Mobile-Range',
		'dataProvider' => $model->search(),
		'cssFile' => false,
		'itemsCssClass' => 'tab-reg',
		'columns' => array(
				array(
						'headerHtmlOptions' => array('width' => '25%'),
						'name'=>'un_province_name',
				),
				array(
						'headerHtmlOptions' => array('width' => '10%'),
						'name'=>'un_city_name',
				),
				array(
						'headerHtmlOptions' => array('width' => '10%'),
						'name'=>'un_city_number',
				),
				array(
						'headerHtmlOptions' => array('width' => '15%'),
						'name'=>'operator',
				),
				array(
						'headerHtmlOptions' => array('width' => '15%'),
						'name'=>'number_prefix',
				),
		),
));
?>