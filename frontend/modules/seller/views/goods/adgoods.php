<?php
/** @var  $this GoodsController */
/** @var $model Goods */
$title = Yii::t('sellerGoods', '推荐广告商品');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('sellerGoods', '宝贝列表 '),
    $title,
);
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
<div class="mainContent">
<div class="toolbar">
    <h3><?php echo Yii::t('sellerGoods', '推荐首页广告'); ?></h3>
</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
    <tbody>
        <tr>
            <th width="10%"><?php echo $form->label($model, 'name'); ?></th>
            <td><?php echo $model->name ?></td>
        </tr>
        <tr>
            <th width="10%"><?php echo $form->labelEx($model, 'advert_picture'); ?></th>
            <td>
                <?php echo $form->fileField($model, 'advert_picture'); ?>
                <?php echo $form->error($model, 'advert_picture',array(),false); ?>
                <font color="red"><?php echo Yii::t('sellerGoods', '请上传比例为390x155图片'); ?></font>
            </td>
        </tr>
        <?php 
            $e = $model->getErrors();
            if (empty($e) && !empty($model->advert_picture)):
        ?>
        <tr>
            <td colspan="2">
                <?php echo CHtml::image(ATTR_DOMAIN . '/' .$model->advert_picture, '', array('width' => '390', 'height' => '155'))?>
            </td>
        </tr>
        <?php endif; ?>
        <tr>
            <th width="10%"><?php echo $form->labelEx($model, 'is_advert'); ?></th>
            <td>
                <?php echo $form->radioButtonList($model, 'is_advert', $model->adGoodsStatus(), array('separator' => ' ')); ?>
                <?php echo $form->error($model, 'is_advert'); ?>
            </td>
        </tr>
        <tr>
            <th width="10%"><?php echo $form->labelEx($model, 'sort'); ?></th>
            <td>
                <?php echo $form->textField($model, 'sort', array('class' => 'inputtxt1')); ?>
                <?php echo $form->error($model, 'sort'); ?>
            </td>
        </tr>
        <tr>
            <th width="10%"><?php echo $form->labelEx($model, 'status'); ?></th>
            <td>
                <?php echo $model->getStatus($model->status); ?>
            </td>
        </tr>
        <?php 
        $f = array('is_advert'=>'', 'advert_picture' => '');
        if (!empty($e) && !array_intersect_key($f, $e)):
        ?>
        <tr>
            <td colspan="2">
                <?php echo CHtml::errorSummary($model, Yii::t('sellerGoods', '宝贝信息错误：'), '', array('firstError' => true)); ?>
            </td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
<div class="profileDo mt15">
    <?php echo CHtml::submitButton('',array('style'=>'visibility:hidden','id'=>'submitFormBtn')) ?>
    <a href="javascript:;" class="sellerBtn03" id="submitBtn">
        <span><?php echo Yii::t('sellerGoods', '提交'); ?></span>
    </a>
    <script>
        $(function(){
            $('#submitBtn').click(function(){$("#submitFormBtn").click();});
        });
    </script> 
    &nbsp;&nbsp;
    <a href="<?php echo $this->createAbsoluteUrl('/seller/goods/index', array('id' => $model->id)) ?>" class="sellerBtn01">
        <span><?php echo Yii::t('sellerGoods', '返回'); ?></span>
    </a>
</div>
</div>

<?php $this->endWidget() ?>
