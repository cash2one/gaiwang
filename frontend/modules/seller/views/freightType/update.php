<?php
/** @var $this FreightTypeController */
/** @var $model FreightType */
/** @var $templateModel FreightTemplate */
/** @var $form CActiveForm */
$title = Yii::t('freightType', '运费详情');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('freightType', '交易管理 '),
    Yii::t('freightType', '运费模版 '),
    $title,
    Yii::t('freightType', '默认运费设置'),
);
//多货币转换
$model->default_freight = Common::rateConvert($model->default_freight);
$model->added_freight = Common::rateConvert($model->added_freight);

?>
<div class="toolbar">
    <h3><?php echo $templateModel->name ?> - <?php echo $model::mode($model->mode) ?>
        - <?php echo Yii::t('freightType', '默认运费设置') ?></h3>
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
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt15 sellerT3">
    <tbody>
        <tr>
            <th width="10%">
                <?php echo $form->labelEx($model, 'default'); ?>
            </th>
            <td width="90%">
                <?php echo $form->textField($model, 'default', array('class' => 'inputtxt1',
                    'style' => 'width:140px;'));
                ?>
                <?php echo Yii::t('freightType', '（请输入大于0.01的正实数）'); ?>
<?php echo $form->error($model, 'default') ?>
            </td>
        </tr>
        <tr>
            <th width="10%">
<?php echo $form->labelEx($model, 'default_freight'); ?>
            </th>
            <td width="90%">
                <?php echo $form->textField($model, 'default_freight', array('class' => 'inputtxt1',
                    'style' => 'width:140px;'));
                ?>
<?php echo $form->error($model, 'default_freight') ?>
            </td>
        </tr>
        <tr>
            <th width="10%">
                <?php echo $form->labelEx($model, 'added'); ?>
            </th>
            <td width="90%">
                <?php echo $form->textField($model, 'added', array('class' => 'inputtxt1', 'style' => 'width:140px;')); ?>
<?php echo Yii::t('freightType', '（请输入大于0.01的正实数）'); ?>
<?php echo $form->error($model, 'added') ?>
            </td>
        </tr>
        <tr>
            <th width="10%">
                <?php echo $form->labelEx($model, 'added_freight'); ?>
            </th>
            <td width="90%">
<?php echo $form->textField($model, 'added_freight', array('class' => 'inputtxt1', 'style' => 'width:140px;')); ?>
<?php echo $form->error($model, 'added_freight') ?>
            </td>
        </tr>

    </tbody>
</table>

<div class="profileDo mt15">
    <a id="submit" class="sellerBtn03"><span><?php echo Yii::t('freightType', '保存'); ?></span></a>&nbsp;&nbsp;
    <a href="<?php echo $this->createAbsoluteUrl('freightType/view', array('id' => $model->id)); ?>" class="sellerBtn01">
        <span><?php echo Yii::t('freightType', '返回'); ?></span></a>
</div>
<?php $this->endWidget(); ?>
<script>
    $("#submit").click(function() {
        $('form').submit();
    });
</script>
