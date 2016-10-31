<?php 
$this->breadcrumbs = array(
		Yii::t('MobileMoneyRechargeconfig', '便民服务'),
		Yii::t('MobileMoneyRechargeconfig', '话费充值价格表'),
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
	    <th class="align-right"><?php echo Yii::t('MobileMoneyRechargeconfig','省市名')?>：</th>
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
		<th class="align-right"><?php echo Yii::t('MobileMoneyRechargeconfig','面值')?>：</th>
		<td>
		<?php  echo $form->TextField($model,'price',array('class'=>'text-input-bj  least',));?>
		</td>
		<th class="align-right"><?php echo Yii::t('MobileMoneyRechargeconfig','运营商(1移动,2联通,3电信)')?>：</th>
		<td>
		<?php  echo $form->TextField($model,'operator',array('class'=>'text-input-bj  least',));?>
		</td>
		<td>
		<?php echo CHtml::submitButton(Yii::t('MobileMoneyRechargeconfig','搜索'),array('class'=>'reg-sub','id'=>'search_button'));?>
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
           <th width="20%"> 
                选择文件:&nbsp;&nbsp;<font color="red">*</font> 
            </th> 
            <td width="50%"> 
                <?php echo CHtml::activeFileField($model, 'file'); ?> 
               <?php echo $form->error($model,'file');?> 
            </td> 
             <td> 
                <?php echo CHtml::button('导入', array('submit' => array('/MobileMoneyRechargeConfig/Import')
                		                              , 'class'=>'reg-sub'
                )); ?>
            </td> 
        </tr> 
        
    </table> 
 </div>

    <?php $this->endWidget();?>
<?php


$this->widget('GridView', array(
		'id' => 'Mobile-Money-Recharge-Config',
		'dataProvider' => $model->search(),
		'cssFile' => false,
		'itemsCssClass' => 'tab-reg',
		'columns' => array(
				 array(
						'headerHtmlOptions' => array('width' => '25%'),
						'name'=>'name',
				), 
				array(
						'headerHtmlOptions' => array('width' => '25%'),
						'name'=>'operator',
				),
				array(
						'headerHtmlOptions' => array('width' => '10%'),
						'name'=>'price',
				),
				array(
						'headerHtmlOptions' => array('width' => '15%'),
						'name'=>'pay_percent',
				),
		),
));
?>