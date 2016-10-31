<?php
/* @var $this SlideController */
/* @var $model Slide */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<div class="toolbar">
    <h3><?php echo Yii::t('sellerSlide', $model->isNewRecord ? '添加店铺首页广告' : '更新店铺首页广告'); ?></h3>
</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt15 sellerT3">
    <tr>
        <th width="10%"><?php echo $form->labelEx($model, 'title'); ?></th>
        <td width="90%">
            <?php echo $form->textField($model, 'title', array('class' => 'inputtxt1', 'style' => 'width:250px;')); ?>
            <?php echo $form->error($model, 'title') ?>
        </td>
    </tr>
    <tr>
        <th width="10%"><?php echo $form->labelEx($model, 'url'); ?></th>
        <td width="90%">
            <?php echo $form->textField($model, 'url', array('class' => 'inputtxt1', 'style' => 'width:250px;')); ?>
            <?php 
                if (!$model->isNewRecord) {
                    echo CHtml::link(Yii::t('sellerSlide', '点击查看链接'), $model->url, array('target' => '_blank'));
                }
            ?>
            <?php echo $form->error($model, 'url') ?>
        </td>
    </tr>
    <tr>
        <th width="10%"><?php echo $form->labelEx($model, 'sort'); ?></th>
        <td width="90%">
            <?php echo $form->textField($model, 'sort', array('class' => 'inputtxt1')); ?>
            <font color="red"><?php echo Yii::t('sellerSlide', '降序排列，值越大则越靠前');?></font>
            <?php echo $form->error($model, 'sort') ?>
        </td>
    </tr>
    <tr>
        <th width="10%"><?php echo $form->labelEx($model, 'picture'); ?></th>
        <td width="90%">
            <?php echo $form->fileField($model, 'picture'); ?>
            <font color="red"><?php echo Yii::t('sellerSlide', '店铺首页滑动广告，请上传比例为1245x415图片为佳');?></font>
            <?php echo $form->error($model, 'picture') ?>
        </td>
    </tr>
    <?php if (!$model->isNewRecord): ?>
    <tr>
        <td  colspan="2" align="center">
            <?php echo CHtml::image(ATTR_DOMAIN . '/' . $model->picture, $model->title, array('width' => 980, 'height' => 340)) ?>
        </td>
    </tr>
    <?php endif; ?>
</table>
<div class="profileDo mt15">
    <?php echo CHtml::submitButton('', array('style' => 'visibility:hidden', 'id' => 'submitFormBtn')) ?>
    <a href="javascript:;" class="sellerBtn03" id="submitBtn">
        <span><?php echo Yii::t('sellerSlide', '提交'); ?></span>
    </a>
    <script>
        $(function() {
            $('#submitBtn').click(function() {
                $("#submitFormBtn").click();
            });
        });
    </script> 
    &nbsp;&nbsp;
    <a href="<?php echo $this->createAbsoluteUrl('/seller/goods/index', array('id' => $model->id)) ?>" class="sellerBtn01">
        <span><?php echo Yii::t('sellerSlide', '返回'); ?></span>
    </a>
</div>
<?php $this->endWidget(); ?>