<?php
/* @var $this StoreArticleController */
/* @var $model StoreArticle */

$this->breadcrumbs = array('商铺文章' => array('admin'), '编辑');
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'store-article-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
//    'clientOptions' => array(
//        'validateOnSubmit' => true,
//    ),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
        <tr><td colspan="2" class="even"></td></tr>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th odd">文章信息</th>
        </tr>
        <tr>
            <th width="25%" class="even"><?php echo $form->labelEx($model, 'title'); ?></th>
            <td class="even">
                <?php echo $form->textField($model, 'title', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'title'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd"><?php echo $form->labelEx($model, 'sort'); ?></th>
            <td class="odd">
                <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'sort'); ?>
            </td>
        </tr>　
        <tr>
            <th class="odd"><?php echo $form->labelEx($model, 'is_publish'); ?></th>
            <td class="odd">
                <?php echo $form->radioButtonList($model, 'is_publish', $model::gender(), array('separator' => ' ')) ?>
                <?php echo $form->error($model, 'is_publish') ?>
            </td>
        </tr>
        <tr>
            <th class="even"><?php echo $form->labelEx($model, 'content'); ?></th>
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
				        $("#StoreArticle_content").html(str);
				        $("#StoreArticle_content").blur();
				
				    });
				
				</script>
				
            </td>
			
			
        </tr>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th even">页面基本信息</th>
        </tr>
        <tr>
            <th class="odd"><?php echo $form->labelEx($model, 'keywords'); ?></th>
            <td class="odd">
                <?php echo $form->textField($model, 'keywords', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'keywords'); ?>
            </td>
        </tr>
        <tr>
            <th class="even"><?php echo $form->labelEx($model, 'description'); ?></th>
            <td class="even">
                <?php echo $form->textField($model, 'description', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'description'); ?>
            </td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th odd">审核信息</th>
        </tr>
        <tr>
            <th class="even"><?php echo $form->labelEx($model, 'status'); ?></th>
            <td class="even">
                <?php echo $form->radioButtonList($model, 'status', StoreArticle::status(), array('separator' => '')); ?>
            </td>
        </tr>
        <tr>
            <td class="even"></td>
            <td colspan="2" class="even">
                <?php echo CHtml::submitButton(Yii::t('storeArticle', '编辑'), array('class' => 'reg-sub')); ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>