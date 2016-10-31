<?php
/* @var $this SeckillAuctionActivityController */
/* @var $model SecKillRulesSeting */
/* @var $form CActiveForm */

$form = $this->beginWidget('ActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    //'clientOptions' => array(
    //'validateOnSubmit' => true,
    //),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
));

$startPicker = $endPicker = 1;
$now         = time();
$startTime   = strtotime($dataProvider['date_start'].' '.$dataProvider['start_time']);
$endTime     = strtotime($dataProvider['date_end'].' '.$dataProvider['end_time']);

if($dataProvider['status']==4 || $dataProvider['status']==3 || ($now>=$endTime || ($now>=$startTime && $now<=$endTime))){
    $startPicker = 0;
}
if($dataProvider['status']==4  || $now>=$endTime ){
    $endPicker = 0;
}
?>


    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come">
        <tr>
            <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('translateIdentify', '基本信息'); ?></th>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'name'); ?></th>
            <td>
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle', 'maxlength'=>10, 'value'=>$dataProvider['name'], 'placeholder'=>'最多10个字符')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $labels['status']; ?></th>
            <td>
                <?php echo $model->getStatusArray($dataProvider['status']);?>
            </td>
        </tr>
		<tr><th></th><td><font style="color:#F00; font-size:16px; font-weight:bold;">若活动图片不需修改时,请勿重复上传.</font></td></tr>
		<tr>
			<th><?php echo $labels['picture']; ?></th>
			<td><?php if($endPicker==1){?>
				<?php echo $form->fileField($model, 'picture'); ?>
				<span><font color='red'>请上传小于1M的文件图片, 尺寸:380*354, 格式:jpg、jpeg、gif、png</font></span>
				<?php echo $form->error($model, 'picture', array(), false); ?>
				<?php }?>
				<?php echo CHtml::image(ATTR_DOMAIN . '/' . $dataProvider['picture'], '', array('width' => '220px', 'height' => '170px'));?>
			</td>
		</tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'remark'); ?></th>
            <td>
                <?php echo $form->textField($model, 'remark', array('class' => 'text-input-bj  middle', 'maxlength'=>6, 'value'=>$dataProvider['remark'], 'placeholder'=>'最多6个字符')); ?>
                <?php echo $form->error($model, 'remark'); ?>
            </td>
        </tr>
        <tr class="datePeriod">
            <th><?php echo $form->labelEx($model, 'start_time');?>
            </th>
            <td>
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'id' => 'SeckillRulesSeting_start_time',
                    'name' => 'start_time',
                    'options' => array(
                        'value'=>$dataProvider['date_start'].' '.$dataProvider['start_time'],
                        'disabled' => $startPicker ? '' : 'disabled',
                        'minDate' => date('Y-m-d'),
                    ),
                    'htmlOptions' => array(
                        'class' => 'datefield text-input-bj middle hasDatepicker',
                    )
                ));
                echo $form->error($model, 'start_time');
                ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'end_time'); ?></th>
            <td>
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'id' => 'SeckillRulesSeting_end_time',
                    'name' => 'end_time',
                    'options' => array(
                        'value'=>$dataProvider['date_end'].' '.$dataProvider['end_time'],
                        'disabled' => $endPicker ? '' : 'disabled',
                        'minDate' => date('Y-m-d'),
                    ),
                    'htmlOptions' => array(
                        'class' => 'datefield text-input-bj middle hasDatepicker',
                    )
                ));
                echo $form->error($model, 'end_time');
                ?>
            </td>
        </tr>

        <tr>
            <th><?php echo $form->labelEx($model, 'sort'); ?></th>
            <td>
                <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj  middle', 'value'=>(intval($dataProvider['sort'])==99999 ? 0 : $dataProvider['sort']))); ?><span> 请填写0-10000之间的整数</span>
                <?php echo $form->error($model, 'sort'); ?>
            </td>
        </tr>
        <tr>
            <th width="140" class="odd"><?php echo $form->labelEx($model, 'description'); ?></th>
            <td>
                <?php echo $form->textArea($model, 'description', array('class' => 'text-input-bj  text-area', 'style'=>'width:80%', 'value'=>$dataProvider['description'])); ?>
                <?php echo $form->error($model, 'description'); ?>
            </td>
        </tr>

        <tr>
            <th></th>
            <td>
                <?php if($endPicker==1){ if($this->getUser()->checkAccess('SeckillAuctionActivity.SeckillAuctionUpdate')) {?>
                    <input type="submit" onclick="return checkUpdateForm();" value="<?php echo Yii::t('seckillAuctionActivity', '修改');?>" class="reg-sub" />
                <?php }}else{?>
                    <font style="color:#F00; font-size:16px; font-weight:bold;">活动已过期或已结束,不能修改.</font>
                <?php }?>
            </td>
        </tr>
    </table>


<?php $this->endWidget(); ?>