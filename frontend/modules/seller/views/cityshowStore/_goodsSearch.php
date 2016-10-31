<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route,array('csid'=>$this->csid,'sid'=>$sid)),
    'method' => 'get',
        ));
?>
<div class="seachToolbar" style="margin-right: 1100px">

    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="sellerT5">
        <tbody>
            <tr>
                <th><?php echo Yii::t('cityShow', '商品查询'); ?>：
                  <select class="inputtxt1" name="type">
                      <option <?php if($this->getParam('type')==1): ?> selected=selected <?php endif;?> value="1"><?php echo Yii::t('cityShow', '商品ID'); ?></option>
                      <option <?php if($this->getParam('type')==2): ?> selected=selected <?php endif;?> value="2"><?php echo Yii::t('cityShow', '商品名称'); ?></option>
                   </select>
                </th>
                <td width="30%">
                   <?php //echo $form->textField($model, 'name', array('style' => 'width:90%', 'class' => "inputtxt1")); ?>
                   <input type="text" name="name" class="inputtxt1" value="<?php echo $this->getParam('name')?>" >
                </td>       
                <td width="26%"> <?php echo CHtml::submitButton(Yii::t('cityShow', '搜索'), array('class' => 'sellerBtn06')); ?> &nbsp;&nbsp;
            </tr>
        </tbody>
    </table>

</div>
<?php $this->endWidget(); ?>