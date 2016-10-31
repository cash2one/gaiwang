<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'franchiseeCategory-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <caption class=" title-th">
        <?php echo $model->isNewRecord ? Yii::t('franchiseeCategory', '新增加盟商分类') : Yii::t('franchiseeCategory', '加盟商分类编辑'); ?>
    </caption>
    <tbody>
        <tr>
            <th style="text-align: center" class="even"><?php echo $form->labelEx($model, 'parent_id'); ?></th>
            <td class="even">
                <?php echo $form->hiddenField($model, 'parent_id', array('value' => $model->parent_id ? $model->parent_id : 0)); ?>
                <?php echo CHtml::textField('parentName', $model->parentName ? $model->parentName : '顶级分类', array('class' => 'text-input-bj', 'readonly' => 'true')); ?>
                <?php echo $form->error($model, 'parent_id'); ?>
                <?php
                echo CHtml::button(Yii::t('franchiseeCategory', '选择'), array('class' => 'reg-sub', 'id' => 'getTree'));
                ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: center" class="odd">
                <?php echo $form->labelEx($model, 'name'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: center" class="even">
                <?php echo $form->labelEx($model, 'thumbnail'); ?>
            </th>
            <td class="even">
                <?php //echo $form->fileField($model, 'thumbnail') ?>
                <?php echo CHtml::activeFileField($model, 'thumbnail'); ?> 
                <?php echo $form->error($model, 'thumbnail'); ?>
                <br/>
                <?php
                if (!$model->isNewRecord) {
//                    echo CHtml::hiddenField('oldThumbnail', $model->thumbnail);
                    echo CHtml::image(ATTR_DOMAIN . DS . $model->thumbnail, $model->name, array('width' => '120px'));
                }
                ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: center" class="odd">
                <?php echo $form->labelEx($model, 'content'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textArea($model, 'content', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'content'); ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: center" class="odd">
                <?php echo $form->labelEx($model, 'status'); ?>
            </th>
            <td class="odd">
                <?php echo $form->radioButtonList($model, 'status', FranchiseeCategory::getStatusOptions(), array('separator' => '')); ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: center" class="odd">
                <?php echo $form->labelEx($model, 'show'); ?>
            </th>
            <td class="odd">
                <?php echo $form->radioButtonList($model, 'show', FranchiseeCategory::getIndexShowOptions(), array('separator' => '')); ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: center" class="even">
                <?php echo $form->labelEx($model, 'sort'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj  middle')); ?>
                <span style="color: Red">
                    	（此处值越高则越靠前，最高值为255）
                </span>
            </td>
        </tr>
        <tr>
            <th style="text-align: center" class="even">
                <?php echo $form->labelEx($model, 'bgclass'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'bgclass', array('class' => 'text-input-bj  middle')); ?>
                <span style="color: Red">
                    	（此处不填时，请默认为：food）
                </span>
            </td>
        </tr>
        <tr>
            <th style="text-align: center" class="even">
                <?php echo $form->labelEx($model, 'bussbgclass'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'bussbgclass', array('class' => 'text-input-bj  middle')); ?>
                <span style="color: Red">
                    	（此处不填时，请默认为：food）
                </span>
            </td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center;" class="title-th odd">
                SEO优化搜索信息
            </th>
        </tr>
        <tr>
            <th style="text-align: center" class="even">
                <?php echo $form->labelEx($model, 'keywords'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'keywords', array('size' => 60, 'maxlength' => 128, 'class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'keywords'); ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: center" class="odd">
                <?php echo $form->labelEx($model, 'description'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'description', array('size' => 60, 'maxlength' => 256, 'class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'description'); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="odd">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('franchiseeCategory', '新增') : Yii::t('franchiseeCategory', '保存'), array('class' => 'reg-sub')); ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
<script src="/js/iframeTools.js" type="text/javascript"></script>
<?php
Yii::app()->clientScript->registerScript('categoryTree', "
var dialog = null;
jQuery(function($) {
        var url = '" . $this->createUrl('/franchiseeCategory/categoryTree',array('pid'=>0)) . "';
        $('#getTree').click(function() {
            dialog = art.dialog.open(url, {'id': 'SearchCat', title: '搜索类别', width: '640px', height: '600px', lock: true});
        })
})
var onSelectedCat = function(Id, Name) {
    $('#FranchiseeCategory_parent_id').val(Id);
    $('#parentName').val(Name);
};
var doClose = function() {
    if (null != dialog) {
        dialog.close();
    }
};
", CClientScript::POS_HEAD);
?>