
<?php
$this->breadcrumbs = array(
    Yii::t('appTopic', '主题') => array('admin'),
    $model->isNewRecord ? Yii::t('appHotCategory', '新增') : Yii::t('appHotCategory', '修改')
    );
    ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'appHotCategory-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            ),
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
        ?>
        <script type="text/javascript">
            $(document).ready(function(){
               $('#android').show();
               $('#ios').hide();
           });
       </script>
       <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody><tr><td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('appTopic', '添加主题专题') : Yii::t('appTopic', '修改主题专题'); ?></td></tr></tbody>
        <tbody>
            <?php echo $form->hiddenField($model, 'category', array('value' => $categoryId)); ?>
            <tr>
                <th style="width: 220px" class="odd">
                    <?php echo $form->labelEx($model, 'title'); ?>
                </th>
                <td class="odd">
                    <?php echo $form->textField($model, 'title', array('class' => 'text-input-bj  middle')); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </td>
            </tr>
            <tr>
                <th style="width: 220px" class="odd">
                    <?php echo $form->labelEx($model, 'min_title'); ?>
                </th>
                <td class="odd">
                    <?php echo $form->textField($model, 'min_title', array('class' => 'text-input-bj  middle')); ?>
                    <?php echo $form->error($model, 'min_title'); ?>
                </td>
            </tr>
            <tr>
                <th style="width: 220px" class="odd">
                    <?php echo $form->labelEx($model, 'sort'); ?>
                </th>
                <td class="odd">
                    <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj  middle')); ?>
                    <?php echo $form->error($model, 'sort'); ?>
                </td>
            </tr>
            <tr>
                <th class="even">
                    <?php echo $form->labelEx($model, 'status'); ?>
                </th>
                <td class="even">
                    <?php echo $form->dropDownList($model, 'status', AppHotCategory::getPublish(),array('prompt' => '请选择','class' => 'text-input-bj  middle')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </td>
            </tr>

   
        <tr>
            <th width="100" align="right"><?php echo $form->labelEx($model, 'main_img'); ?></th>
            <td>
                <?php echo $form->fileField($model, 'main_img'); ?>
                <?php echo $form->error($model, 'main_img', array(), false); ?>
                <?php
                if (!$model->isNewRecord)
                    echo CHtml::image(ATTR_DOMAIN. '/' .$model->main_img, '', array('width' => '220px', 'height' => '70px'));
                ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->renderPartial($categoryId==1?'_detail_content1':'_detail_content2', array('model' => $model,'categoryId'=>$categoryId,'detail_content'=>isset($detail_content)?$detail_content:'')); ?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
<tr>
    <th class="odd"></th>
    <td colspan="2" class="odd">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('appTopic', '保存') : Yii::t('appTopic', '更新'), array('class' => 'reg-sub','style')); ?>
    </td>
</tr>
</table>
<?php $this->endWidget(); ?>

<script src="/js/iframeTools.js" type="text/javascript"></script>
