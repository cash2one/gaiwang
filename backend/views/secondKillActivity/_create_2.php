<?php
/* @var $this SecondKillActivityController */
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
        <th><?php echo $form->labelEx($model, 'singup_start_time'); ?></th>
        <td>
          <?php
		  $this->widget('comext.timepicker.timepicker', array(
			  'model' => $model,
			  'id' => 'SeckillRulesSeting_singup_start_time',
			  'name' => 'singup_start_time',
			  'options' => array(
			      'minDate' => date('Y-m-d'),
			  ),
			  'htmlOptions' => array(
				  'class' => 'datefield text-input-bj middle hasDatepicker',
			  )
		 ));
        ?>
        <?php echo $form->error($model, 'singup_start_time'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'singup_end_time'); ?></th>
        <td>
          <?php
		  $this->widget('comext.timepicker.timepicker', array(
			  'model' => $model,
			  'id' => 'SeckillRulesSeting_singup_end_time',
			  'name' => 'singup_end_time',
			  'options' => array(
			      'minDate' => date('Y-m-d'),
			  ),
			  'htmlOptions' => array(
				  'class' => 'datefield text-input-bj middle hasDatepicker',
			  )
		 ));
        ?>
        <?php echo $form->error($model, 'singup_end_time'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'allow_singup'); ?></th>
        <td>
            <?php echo $form->checkBox($model,'allow_singup', array('value'=>1, 'checked'=>'checked') );?>
            <?php echo $form->error($model, 'allow_singup'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'product_category_id'); ?></th>
        <td>
            <?php echo $form->checkBoxList($model, 'product_category_id[]', CHtml::listData(ActiveCategoryForm::getConfigCategory(),'id','name'), array('separator' => ' ','checkAll'=>'全选', 'labelOptions' => array('class' => 'labelForRadio')));?>
            <div id="SeckillRulesSeting_product_category_id_em_" class="errorMessage" style="display:none"></div>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'mp'); ?><span class="required">*</span></th>
        <td><input type="radio" id="SeckillRulesSeting_discount" name="SeckillRulesSeting[discount]" checked="checked" value="1" /><?php echo $form->labelEx($model, 'discount_rate'); ?>
            <?php echo $form->textField($model, 'discount_rate', array('class' => 'text-input-bj  middle', 'value'=>'', 'placeholder'=>'', 'onkeyup'=>"this.value=dealPoint(this.value);")); ?> 折 (请填写0.1-10的数,小数点后保留一位)
            <?php echo $form->error($model, 'discount_rate'); ?>
        </td>
    </tr>
    <tr>
        <th></th>
        <td><input type="radio" id="SeckillRulesSeting_discount" name="SeckillRulesSeting[discount]" value="2" /><?php echo $form->labelEx($model, 'discount_price'); ?>
            <?php echo $form->textField($model, 'discount_price', array('class' => 'text-input-bj  middle', 'value'=>'', 'placeholder'=>'', 'onkeyup'=>"this.value=dealPoint(this.value);")); ?> 元 (请填写0.01-1000的数,小数点后保留两位)
            <?php echo $form->error($model, 'discount_price'); ?>
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
        <th><?php echo $form->labelEx($model, 'buy_limit'); ?></th>
        <td>
            <?php echo $form->dropDownList($model, 'buy_limit', array(1=>'1个',2=>'2个',3=>'3个',4=>'4个',5=>'5个', 0=>'不限'), array('class' => 'listbox')); ?>
            <?php echo $form->error($model, 'buy_limit'); ?>
        </td>
    </tr>
    <tr> <!--商家受限-->
        <th><?php echo $form->labelEx($model, 'seller'); ?></th>
        <td>
            <?php echo $form->textField($model, 'seller', array('class' => 'text-input-bj  middle')); ?>(0为不受限)
            <?php echo $form->error($model, 'seller'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'limit_num'); ?></th>
        <td>
            <?php echo $form->textField($model, 'limit_num', array('class' => 'text-input-bj  middle', 'onkeyup'=>"this.value=this.value.replace(/\D/g,'');")); ?>
            <?php echo $form->error($model, 'limit_num'); ?>
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
        <th><?php echo $form->labelEx($model, 'link'); ?></th>
        <td>
            <?php echo $form->textField($model, 'link', array('class' => 'text-input-bj  long')); ?>
            <?php echo $form->error($model, 'link'); ?>
        </td>
    </tr>
    <tr>
        <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('translateIdentify', '活动模板底图'); ?></th>
    </tr>
    <tr><th></th><td><font style="color:#F00; font-size:16px; font-weight:bold;">活动页面的底图,若已上传过图片,不需修改时,请勿重复上传.</font></td></tr>
    <tr>
        <th>主图：</th>
        <td>
            <?php echo $form->fileField($model, 'banner1'); ?>
            <span>请上传小于3M的文件图片, 尺寸:1800*500, 格式:jpg、jpeg、gif、png</span>
        </td>
    </tr>
    <tr>
        <th>标题底图1：</th>
        <td>
            <?php echo $form->fileField($model, 'banner2', array('disabled'=>'disabled')); ?>
            <span>请上传小于3M的文件图片, 尺寸:1800*160, 格式:jpg、jpeg、gif、png</span>
        </td>
    </tr>
    <tr>
        <th>标题底图2：</th>
        <td>
            <?php echo $form->fileField($model, 'banner3'); ?>
            <span>请上传小于3M的文件图片, 尺寸:1800*235, 格式:jpg、jpeg、gif、png</span>
        </td>
    </tr>
    <tr>
        <th>标题底图3：</th>
        <td>
            <?php echo $form->fileField($model, 'banner4'); ?>
            <span>请上传小于3M的文件图片, 尺寸:1800*235, 格式:jpg、jpeg、gif、png</span>
        </td>
    </tr>
    <tr>
        <th></th>
        <td>
          <input type="submit" onclick="return checkCreateForm();" id="add" value="<?php echo Yii::t('secondKillActivity', '添加');?>" class="reg-sub" />
        </td>
    </tr>
  </table>


<?php $this->endWidget(); ?>