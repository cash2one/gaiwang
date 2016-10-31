<?php
$this->breadcrumbs = array(
    Yii::t('advert', '广告位') => array('admin'),
    $model->isNewRecord ? Yii::t('advert', '新增') : Yii::t('advert', '修改')
);
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id.'-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => false,
    ),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody><tr><td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('advert', '添加广告位') : Yii::t('advert', '修改广告位'); ?></td></tr></tbody>
    <tbody>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'name'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <th class="even">
                <?php echo $form->labelEx($model, 'code'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'code', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'code'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd">
                <?php echo $form->labelEx($model, 'content'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textArea($model, 'content', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'content'); ?>
            </td>
        </tr>
        <tr>
            <th class="even">
                <?php echo $form->labelEx($model, 'type'); ?>
            </th>
            <td class="even">
                <?php echo $form->dropDownList($model, 'type', Advert::getAdvertType(), array('prompt' => '请选择', 'class' => 'text-input-bj')); ?>
                <?php echo $form->error($model, 'type'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd">
                <?php echo $form->labelEx($model, 'status'); ?>
            </th>
            <td class="odd">
                <?php echo $form->radioButtonList($model, 'status', Advert::getAdvertStatus(), array('separator' => '')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </td>
        </tr>
        <tr>
            <th class="even">
                <?php echo $form->labelEx($model, 'width'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'width', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'width'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd">
                <?php echo $form->labelEx($model, 'height'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'height', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'height'); ?>
            </td>
        </tr>
        <tr>
            <th class="even">
                <?php echo $form->labelEx($model, 'direction'); ?>
            </th>
            <td class="even">
                <?php echo $form->radioButtonList($model, 'direction', Advert::getAdvertDirection(), array('separator' => '', 'onclick' => 'toggleTr(this.value);')); ?>
                <?php echo $form->error($model, 'direction'); ?>
            </td>
        </tr>
        <tr id="cityTr">
            <th class="even">
                城市<br />
                加盟商分类
            </th>
            <td class="even">
                <?php echo $form->radioButtonList($model, 'city_id', $model->getActivityCity(), array('separator' => '')); ?>
                <?php echo $form->error($model, 'city_id'); ?><br />                
                <?php echo $form->dropDownList($model, 'franchisee_category_id', CHtml::listData(FranchiseeCategory::model()->findAll('status = :status And parent_id = :pid', array(':status' => FranchiseeCategory::STATUS_ENABLE, ':pid' => 0)), 'id', 'name'), array('separator' => '', 'prompt' => '请选择','class' => 'text-input-bj')); ?>
                <?php echo $form->error($model, 'franchisee_category_id'); ?>
            </td>
        </tr>
        <tr id="categoryTr">
            <th class="even">
                <?php echo $form->labelEx($model, 'category_id'); ?>
            </th>
            <td class="even">
                <?php echo $form->hiddenField($model, 'category_id', array('value' => $model->category_id ? $model->category_id : 0)); ?>
                <?php echo CHtml::textField('category_name', $model->category_id ? Category::model()->find('id = :id', array('id' => $model->category_id))->name : '顶级分类', array('class' => 'text-input-bj', 'readonly' => 'true')); ?>
                <?php echo CHtml::button(Yii::t('advert', '选择'), array('class' => 'reg-sub', 'id' => 'getTree')); ?>
                <?php echo $form->error($model, 'category_id'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd"></th>
            <td colspan="2" class="odd">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('advert', '新增') : Yii::t('advert', '保存'), array('class' => 'reg-sub')); ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        toggleTr($('input[name="Advert[direction]"]:checked').val());
    });
    function toggleTr(value) {
        $("#cityTr").hide();
        $("#categoryTr").hide();
        if (value === '1') {
            $("#cityTr").show();
        } else if (value === '2') {
            $("#categoryTr").show();
        }
    }
</script>
<script src="/js/iframeTools.js" type="text/javascript"></script>
<?php
Yii::app()->clientScript->registerScript('categoryTree', "
var dialog = null;
jQuery(function($) {
        var url = '" . $this->createUrl('/category/categoryTree') . "';
        $('#getTree').click(function() {
            dialog = art.dialog.open(url, {'id': 'SearchCat', title: '搜索类别', width: '640px', height: '600px', lock: true});
        })
})
var onSelectedCat = function(Id, Name) {
    $('#Advert_category_id').val(Id);
    $('#category_name').val(Name);
};
var doClose = function() {
    if (null != dialog) {
        dialog.close();
    }
};
", CClientScript::POS_HEAD);
?>