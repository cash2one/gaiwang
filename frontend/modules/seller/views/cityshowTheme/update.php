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
/** @var $this StoreController */
$title = Yii::t('cityShow', '编辑排序');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('cityShow', '城市馆主题') => array('list'),
    $title,
);
$res=Cityshow::getInfoById($this->csid,'title');
?>
<div class="toolbar">
    <b><?php echo $res->title;?>-〉<?php echo Yii::t('cityShow', '编辑主题'); ?></b>
</div>
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
                <?php echo Yii::t('cityShow', '主题名称'); ?>：
            </th>
            <td>
                 <?php echo $form->textField($model, 'name', array('class' => 'inputtxt1','maxlength'=>10)); ?>
                  <span style="color: red">(<?php echo Yii::t('cityShow', '编辑主题名称会重新审核相关联的城市馆'); ?>)</span>
                 <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
       <tr>
            <th width="120px">
                <?php echo $form->labelEx($model, 'sort'); ?>：
            </th>
            <td>
                  <select class="inputtxt1" name="CityshowTheme[sort]">
                    <?php for($i=1;$i<6;$i++):?>
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
<?php Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/jquery.artDialog.js?skin=aero') ?>
</body>
</html>