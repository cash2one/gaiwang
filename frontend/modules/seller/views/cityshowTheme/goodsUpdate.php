<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="" />
        <meta name="Description" content="" />
        <link href="<?php echo CSS_DOMAIN; ?>global.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo CSS_DOMAIN; ?>seller.css" rel="stylesheet" type="text/css" />
 </head>
   <body>
<?php

$title = Yii::t('cityShow', '编辑排序');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('cityShow', '城市馆商品主题') => array('list'),
    $title,
);
?>
<div class="toolbar">
    <b><?php echo Yii::t('cityShow', '编辑商品顺序'); ?></b>
</div>

<h3 class="mt15 tableTitle"><?php echo Yii::t('cityShow', '城市馆商品'); ?></h3>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
   
    ),
));
?>
<?php $this->renderPartial('/layouts/_msg'); ?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
    <tbody id="themeId">
        <tr>
            <th width="120px">
                <?php echo Yii::t('cityShow', '商品名称'); ?>：
            </th>
            <td>
                 <?php echo $name; ?>
            </td>
        </tr>
       <tr>
            <th width="120px">
                <?php echo $form->labelEx($model, 'sort'); ?>：
            </th>
            <td>
                  <select class="inputtxt1" name="CityshowGoods[sort]">
                    <?php for($i=1;$i<11;$i++):?>
                      <option <?php if($model->sort==$i):?> selected=selected <?php endif;?> value="<?php echo $i;?>"><?php echo $i;?></option> 
                      <?php endfor;?> 
                   </select>
                 <?php echo $form->error($model, 'sort'); ?>
            </td>
        </tr>
    </tbody>
</table>
<div class="profileDo mt15">
 <?php echo CHtml::submitButton(Yii::t('cityShow', '提交'), array('class' => 'sellerBtn06', 'id' => 'submitBtn'));
        ?>
</div>
<?php $this->endWidget() ?>
</body>
</html>