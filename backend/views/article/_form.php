<?php
/* @var $this ArticleController */
/* @var $model Article */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'article-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
        ));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr> <th class="title-th even" colspan="2" style="text-align: center;"> 基本信息</th> </tr>
    <tr>
        <th width="120px" align="right" class="odd">
            <?php echo $form->labelEx($model, 'title'); ?>：
        </th>
        <td class="odd">
            <?php echo $form->textField($model, 'title', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'title'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right" class="even">
            <?php echo $form->labelEx($model, 'category_id'); ?>：
        </th>
        <td class="even">
            <?php echo $form->dropDownList($model, 'category_id', ArticleCategory::getTreeCategories(), array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'category_id'); ?>
        </td>
    </tr>
    <tr>
        <th width="170px" align="right" class="odd">
            <?php echo $form->labelEx($model, 'alias'); ?>：
        </th>
        <td class="odd">
            <?php echo $form->textField($model, 'alias', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'alias'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right" class="even">
            <?php echo $form->labelEx($model, 'content'); ?>：
        </th>
        <td class="even" id="contend_td">
            <?php
            $this->widget('comext.wdueditor.WDueditor', array(
                'model' => $model,
                'attribute' => 'content',
            ));
            ?>
			
			<script type="text/javascript">
				//处理输入框提示错误的问题
				$("#contend_td").mouseout(function() {
					//var str = $(window.frames["baidu_editor_0"].document).find('body').find('p').html();
					var str = $("#baidu_editor_0").contents().find('body').find('p').html();
					if (str == '<br>')
						str = ' ';
					$("#Article_content").html(str);
					$("#Article_content").blur();
			
				});
			
			</script>
			
        </td>
    </tr>
    <tr>
        <th width="120px" align="right" class="odd">
            <?php echo $form->labelEx($model, 'summary'); ?>：
        </th>
        <td class="odd">
            <?php echo $form->textArea($model, 'summary', array('class' => 'text-input-bj long')); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right" class="even">
            <?php echo $form->labelEx($model, 'thumbnail'); ?>：
        </th>
        <td class="even">
            <?php echo CHtml::activeFileField($model, 'thumbnail'); ?> 
            <?php if (!$model->isNewRecord): ?>
                <input type="hidden" name="oldImg" value="<?php echo $model->thumbnail; ?>">
                <img src="<?php echo ATTR_DOMAIN . '/' . $model->thumbnail ?>" width="60" height="60"/>
            <?php endif; ?>  
        </td>
    </tr>
    <tr> <th class="title-th even" colspan="2" style="text-align: center;"> SEO优化信息</th> </tr>
    <tr>
        <th width="120px" align="right" class="odd">
            <?php echo $form->labelEx($model, 'keywords'); ?>：
        </th>
        <td class="odd">
            <?php echo $form->textField($model, 'keywords', array('class' => 'text-input-bj long')); ?>

        </td>
    </tr>
    <tr>
        <th width="120px" align="right" class="even">
            <?php echo $form->labelEx($model, 'description'); ?>：
        </th>
        <td class="even">
            <?php echo $form->textArea($model, 'description', array('class' => 'text-input-bj long')); ?>
        </td>
    </tr>
    <tr>
        <th class="odd"></th>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('article', '新增') : Yii::t('article', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr> 
</table>    
<?php $this->endWidget(); ?>
