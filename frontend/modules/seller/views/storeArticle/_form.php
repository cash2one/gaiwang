<?php
//
/* @var $this StoreArticleController */
/* @var $model StoreArticle */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'store-article-form',
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
        <h3><?php echo $model->isNewRecord ? Yii::t('storeArticle', '添加文章') : Yii::t('storeArticle', '编辑文章') ?> </h3>
    </div>
    <h3 class="mt15 tableTitle"><?php echo Yii::t('storeArticle', '文章信息') ?></h3>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
        <tbody><tr>
                <th width="10%"><b class="red">*</b><?php echo Yii::t('storeArticle', '文章标题') ?></th>
                <td width="90%">
                    <?php echo $form->textField($model, 'title', array('class' => 'inputtxt1', 'style' => 'width:300px')); ?>
                    <?php echo $form->error($model, 'title') ?>
                </td>

            </tr>
            <tr>
                <th><b class="red">*</b><?php echo Yii::t('storeArticle', '排序') ?></th>
                <td width="90%">
                    <?php echo $form->textField($model, 'sort', array('class' => 'inputtxt1', 'style' => 'width:50px')); ?>
                    <?php echo $form->error($model, 'sort') ?>
                </td>
            </tr>
            <tr>
                <th><?php echo Yii::t('storeArticle', '发布') ?></th>
                <td>
                    <?php echo $form->radioButtonList($model, 'is_publish', $model::gender(), array('separator' => ' ')) ?>
                    <?php echo $form->error($model, 'is_publish') ?>
                </td>
            </tr>
            <tr>
                <th><b class="red">*</b><?php echo Yii::t('storeArticle', '内容') ?></th>
                <td id="contend_td">
                    <?php
                    $this->widget('ext.editor.WDueditor', array(
                        'model' => $model,
                        'base_url' => 'http://seller.'.SHORT_DOMAIN,
                        'attribute' => 'content',
	                    'save_path' => 'uploads/files', //默认是'attachments/UE_uploads'
	                    'url' => IMG_DOMAIN . '/files' //默认是ATTR_DOMAIN.'/UE_uploads'
                    ));
                    ?>
                    <?php echo $form->error($model, 'content') ?>  
                </td>
            </tr>
            <tr>
                <th><b class="red">*</b><?php echo Yii::t('storeArticle', '页面关键字') ?></th>
                <td>

                    <?php echo $form->textField($model, 'keywords', array('class' => 'inputtxt1', 'style' => 'width:300px')); ?>
                    <?php echo $form->error($model, 'keywords') ?>
                </td>
            </tr>
            <tr>
                <th><b class="red">*</b><?php echo Yii::t('storeArticle', '页面关描述') ?></th>
                <td>

                    <?php echo $form->textField($model, 'description', array('class' => 'inputtxt1', 'style' => 'width:300px')); ?>
                    <?php echo $form->error($model, 'description') ?>  
                </td>
            </tr>
        </tbody></table>
    <div class="profileDo mt15">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('storeArticle', '新增') : Yii::t('storeArticle', '保存'), array('class' => 'sellerBtn06')); ?>
        &nbsp;&nbsp;
        <!--<a href="#" class="sellerBtn01"><span><?php //echo Yii::t('storeArticle', '返回') ?></span></a>-->
    </div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
//处理输入框提示错误的问题
$("#contend_td").mouseout(function(){
	var str=$(window.frames["baidu_editor_0"].document).find('body').find('p').html();
	if(str==undefined) str=$(document.getElementById("baidu_editor_0").contentDocument).find('body').find('p').html();
	if(str==undefined) return false;
	if(str=='<br>') str = ' ';
	$("#StoreArticle_content").html(str);
	$("#StoreArticle_content").blur();
});
</script>
