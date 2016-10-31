<?php 
$this->breadcrumbs = array(
		Yii::t('MobileFlowRechargeconfig', '便民服务'),
		Yii::t('MobileFlowRechargeconfig', '流量充值价格表'),
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
		<th class="align-right"><?php echo Yii::t('MobileFlowRechargeconfig','流量值')?>：</th>
		<td>
		<?php  echo $form->TextField($model,'amount',array('class'=>'text-input-bj  least',));?>
		</td>
		<th class="align-right"><?php echo Yii::t('MobileFlowRechargeconfig','运营商(1移动,2联通,3电信)')?>：</th>
		<td>
		<?php  echo $form->TextField($model,'operator',array('class'=>'text-input-bj  least',));?>
		</td>
		<td>
		<?php echo CHtml::submitButton(Yii::t('MobileFlowRechargeconfig','搜索'),array('class'=>'reg-sub','id'=>'search_button'));?>
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
     <table> 
        <tr> 
           <th width="20%"> 
               选择文件:&nbsp;&nbsp;<font color="red">*</font> 
            </th> 
            <td width="50%"> 
                <?php echo CHtml::activeFileField($model, 'file'); ?> 
               <?php echo $form->error($model,'file');?> 
            </td> 
             <td> 
                <?php echo CHtml::button('导入', array('submit' => array('/MobileFlowRechargeConfig/Import')
                		                              , 'class'=>'reg-sub'
                )); ?>
            </td> 
        </tr> 
    </table> 
   </div>
    <?php $this->endWidget();?>
<?php


$this->widget('GridView', array(
		'id' => 'Mobile-Flow-Recharge-Config',
		'dataProvider' => $model->search(),
		'cssFile' => false,
		'itemsCssClass' => 'tab-reg',
		'columns' => array(
				 array(
						'headerHtmlOptions' => array('width' => '25%'),
						'name'=>'id',
				), 
				array(
						'headerHtmlOptions' => array('width' => '25%'),
						'name'=>'operator',
				),
				array(
						'headerHtmlOptions' => array('width' => '25%'),
						'name'=>'amount',
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