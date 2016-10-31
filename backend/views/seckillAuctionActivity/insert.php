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
?>



  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come">
    <tr>
        <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('translateIdentify', '基本信息'); ?></th>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'name'); ?></th>
        <td>
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle', 'maxlength'=>10, 'placeholder'=>'最多10个字符')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'status'); ?></th>
        <td>
            <?php echo $form->dropDownList($model, 'status', $model->getStatusArray(), array('class' => 'listbox')); ?>
            <?php echo $form->error($model, 'status'); ?>
        </td>
    </tr>
	<tr>
        <th><?php echo $form->labelEx($model, 'picture'); ?></th>
        <td>
            <?php echo $form->fileField($model, 'picture'); ?>
            <span><font color='red'>请上传小于1M的文件图片, 尺寸:380*354, 格式:jpg、jpeg、gif、png</font></span>
			<?php echo $form->error($model, 'picture', array(), false); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'remark'); ?></th>
        <td>
            <?php echo $form->textField($model, 'remark', array('class' => 'text-input-bj  middle', 'maxlength'=>6, 'placeholder'=>'最多6个字符')); ?>
            <?php echo $form->error($model, 'remark'); ?>
        </td>
    </tr>
    <tr class="datePeriod">
        <th><?php echo $form->labelEx($model, 'start_time'); ?></th>
        <td>
            <?php
			$this->widget('comext.timepicker.timepicker', array(
				'model' => $model,
				'id' => 'SeckillRulesSeting_start_time',
				'name' => 'start_time',
				'options' => array(
				    'minDate' => date('Y-m-d'),
				),
				'htmlOptions' => array(
					'class' => 'datefield text-input-bj middle hasDatepicker',
				)
			));
		?>
        <?php echo $form->error($model, 'start_time'); ?>
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
				    'minDate' => date('Y-m-d'),
				),
				'htmlOptions' => array(
					'class' => 'datefield text-input-bj middle hasDatepicker',
				)
			));
		?>
        <?php echo $form->error($model, 'end_time'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'sort'); ?></th>
        <td>
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj  middle', 'onkeyup'=>"this.value=this.value.replace(/\D/g,'');")); ?><span> 请填写0-10000之间的整数</span>
            <?php echo $form->error($model, 'sort'); ?>
        </td>
    </tr>


    <tr>
        <th width="140" class="odd"><?php echo $form->labelEx($model, 'description'); ?></th>
        <td>
            <?php echo $form->textArea($model, 'description', array('class' => 'text-input-bj  text-area', 'style'=>'width:80%')); ?>
            <?php echo $form->error($model, 'description'); ?>

        </td>
    </tr>

    <tr>
        <th></th>
        <td>
            <?php echo $form->hiddenField($model, 'seller', array('value' => '1')); ?>
          <input type="submit" onclick="return checkCreateForm();" id="add" value="<?php echo Yii::t('seckillAuctionActivity', '添加');?>" class="reg-sub" />
        </td>
    </tr>
  </table>


<?php $this->endWidget(); ?>