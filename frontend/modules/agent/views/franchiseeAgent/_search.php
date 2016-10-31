<div class="form_search">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
      <label for="textfield"></label>
      <p><?php echo $form->label($model, 'name')?>：</p>
      <?php echo $form->textField($model, 'name', array('class' => 'search_box3'))?>
      <p><?php echo $form->label($model, 'gai_number')?>：</p>
      <?php echo $form->textField($model, 'gai_number', array('class' => 'search_box3'))?>
      <?php echo CHtml::submitButton('',array('class'=>'search_button3'));?>
<?php $this->endWidget(); ?>
</div>