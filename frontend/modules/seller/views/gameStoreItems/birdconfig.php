<?php
/* @var $this GameStoreItemsController */
/* @var $model GameStoreItems */
$title = Yii::t('GameStoreItems', '弹弓打鸟');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('GameStoreItems', '店铺商品') => array('index'),
    $title,
);
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id .'-form',
//     'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
<div class="mainContent">
    <div class="toolbar">
        <h3><?php echo Yii::t('gameStoreItems', '弹弓打鸟'); ?> </h3>
    </div>
    <h3 class="mt15 tableTitle"><?php echo Yii::t('gameStoreItems', '触发概率') ?></h3>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
        <tbody><tr>
            <th width="10%"><b class="red">*</b><?php echo Yii::t('gameStoreItems', '抢水果成功触发概率') ?></th>
            <td width="90%">
                <?php echo $form->textField($model, 'success', array('class' => 'inputtxt1', 'style' => 'width:300px')); ?>(填1-100之间的数字，1表示百分之1)
                <?php echo $form->error($model, 'success') ?>
            </td>
        </tr>
        <tr>
            <th width="10%"><b class="red">*</b><?php echo Yii::t('gameStoreItems', '抢水果失败触发概率') ?></th>
            <td width="90%">
                <?php echo $form->textField($model, 'fail', array('class' => 'inputtxt1', 'style' => 'width:300px')); ?>(填1-100之间的数字，1表示百分之1)
                <?php echo $form->error($model, 'fail') ?>
            </td>
        </tr>

        </tbody></table>
    <div class="profileDo mt15">
        <?php echo CHtml::submitButton(Yii::t('gameStoreItems', '保存'), array('class' => 'sellerBtn06')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(function(){
        $('.breadcrumbs').before('<a class="regm-sub" href="javascript:history.back()">返回列表</a>');
    });
</script>
