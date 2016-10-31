<?php
/* @var $this BrandController */
/* @var $model Brand */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'brand-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('brand', '创建品牌 ') : Yii::t('brand', '修改品牌'); ?></td>
    </tr>
    <tr>
        <th style="width:220px"><?php echo $form->labelEx($model, 'name'); ?></th>
        <td>
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj middle')); ?>
            (<?php echo Yii::t('brand', '只限于输入20个字符'); ?>)
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'code'); ?></th>
        <td>
            <?php echo $form->textField($model, 'code', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'code'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'logo'); ?></th>
        <td>
            <?php echo $form->FileField($model, 'logo'); ?>
            <?php if (!$model->isNewRecord && $model->logo): ?>
                <input type="hidden" name="oldImg" value="<?php echo $model->logo; ?>" />
                <img src="<?php echo IMG_DOMAIN . '/' . $model->logo ?>" width="100" height="35" />
            <?php endif; ?>  
            <?php echo $form->error($model, 'logo'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'category_id'); ?></th>
        <td>
            <?php
            $topCategory = Category::getTopCategory();
            foreach ($topCategory as $k => $v)
                $topCategory[$k] = $v['name'];
            ?>
            <?php echo $form->dropDownList($model, 'category_id', $topCategory, array('separator' => '', 'prompt' => '请选择', 'class' => 'text-input-bj')); ?>
            <?php echo $form->error($model, 'category_id'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'store_id'); ?></th>
        <td>
            <?php echo $form->hiddenField($model, 'store_id', array('value' => $model->store_id)); ?>
            <?php echo CHtml::textField('storeName', isset($model->store) ? $model->store->name : '', array('class' => 'text-input-bj middle', 'readonly' => 'true')); ?>
            <?php echo $form->error($model, 'store_id'); ?>
            <?php echo CHtml::button(Yii::t('brand', '选择'), array('class' => 'reg-sub', 'id' => 'SetStore')); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'sort'); ?></th>
        <td>
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'sort'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'status'); ?></th>
        <td>
            <?php echo $form->radioButtonList($model, 'status', Brand::status(), array('separator' => '')); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'content'); ?></th>
        <td>
            <?php
            $this->widget('comext.wdueditor.WDueditor', array(
                'model' => $model,
                'attribute' => 'content',
            ));
            ?>
            <?php echo $form->error($model, 'content'); ?>
        </td>
    </tr>
    <tr>
        <th></th>
        <td colspan="2">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('brand', '添加 ') : Yii::t('brand', '编辑'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>          
<?php $this->endWidget(); ?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<?php
Yii::app()->clientScript->registerScript('categoryTree', "
var doClose = function() {
    if (null != dialog) {
        dialog.close();
    }
};
var dialog = null;
jQuery(function($) {
    //搜索父加盟商
    $('#SetStore').click(function() {
        dialog = art.dialog.open('" . $this->createUrl('/store/getStore') . "', {'id': 'selectmember', title: '搜索父加盟商', width: '800px', height: '620px', lock: true});
    })
})

var onSelectStore = function(pid) {
    if (pid) {
        $.ajax({
            cache:false,
            dataType: 'json',
            url:'" . $this->createUrl('/store/getStoreName') . "&id='+pid+'&YII_CSRF_TOKEN=" . Yii::app()->request->csrfToken . "',
            success:function(name){
                $('#Brand_store_id').val(pid);
                $('#storeName').val(name);
            }
        })
    }
};
", CClientScript::POS_HEAD);
?>