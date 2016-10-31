
<?php
$this->breadcrumbs = array(
    Yii::t('appHotCategory', '品质至上分类') => array('admin'),
    $model->isNewRecord ? Yii::t('appHotCategory', '新增') : Yii::t('appHotCategory', '修改')
);
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'appHotCategory-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody><tr><td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('appHotCategory', '添加分类') : Yii::t('appHotCategory', '修改分类'); ?></td></tr></tbody>
    <tbody>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'name'); ?>
            </th>
            <td class="odd">
                <?php $this->renderPartial('depth', array('form' => $form,'model' => $model));?>
            </td>
        </tr>


        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'explain'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textArea($model, 'explain', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'explain'); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'order'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'order', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'order'); ?>
            </td>
        </tr>
        <tr>
            <th class="even">
                <?php echo $form->labelEx($model, 'is_publish'); ?>
            </th>
            <td class="even">
                <?php echo $form->dropDownList($model, 'is_publish', AppHotCategory::getPublish(),array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'is_publish'); ?>
            </td>
        </tr>

        <tr>
            <th class="odd">
                <?php echo $form->labelEx($model, 'picture'); ?>
            </th>
            <td class="odd">
				<?php echo $form->fileField($model, 'picture') ?>
	            <?php echo $form->error($model, 'picture'); ?>
	            <span style="color: Red;">* </span><?php echo Yii::t('appHotCategory', '请上传400*480或者400*400的图片'); ?> 
	            <?php if ($model->picture): ?>
	            <?php echo CHtml::hiddenField('oldFile', $model->picture); ?>
	            <?php echo ATTR_DOMAIN . '/' . $model->picture; ?>
	            <?php if($this->action->id=='update'):?>
	            <img alt="" width="80" height="80" src="<?php echo ATTR_DOMAIN . '/' . $model->picture ?>">
	            <?php endif;?>
	            <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th class="odd"></th>
            <td colspan="2" class="odd">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('appHotCategory', '新增') : Yii::t('appHotCategory', '保存'), array('id'=>'submit','class' => 'reg-sub')); ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    /**
     * 检查分类，最少选择一个顶级分类
     */
    function categoryCheck(){
        var categoryVal = $('#AppHotCategory_depthZero').val();
        if(categoryVal.length <= 0){
            art.dialog({
                icon: 'warning',
                content: '至少选择一个分类',
                lock:true,
                ok:function(){
                    $('#AppHotCategory_depthZero').focus();
                }
            });
            return false;
        }
        return true;
    }

    /**
     * 检查排序
     */
    function orderCheck(){
        var orderVal = $('#AppHotCategory_order').val();
        var re = /^\d+$/;
        if (!re.test(orderVal)) {
            art.dialog({
                icon: 'warning',
                content: '排序数值应为整数',
                lock:true,
                ok:function(){
                    $('#AppHotCategory_order').focus();
                }
            });
            return false;
        }
        return true;
    }

    $('#AppHotCategory_depthZero').change(function(){
        categoryCheck();
    });
    $('#AppHotCategory_order').change(function(){
        orderCheck();
    });

    $('#submit').click(function(){
        if(categoryCheck() && orderCheck())
            $("#submit").submit();
        else
            return false;
    });
</script>