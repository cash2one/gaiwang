<?php
/* @var $this FranchiseeController */
/* @var $model Franchisee */
/* @var $form CActiveForm */
$this->breadcrumbs = array(Yii::t('franchisee', '加盟商') => array('admin'), Yii::t('franchisee', '基本信息编辑'));
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'franchisee-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('franchisee', '基本信息编辑'); ?></th>
        </tr>
        <tr>
            <th style="width: 220px"><?php echo $form->labelEx($model, 'name'); ?></th>
            <td><?php echo $model->name; ?></td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'franchisee_brand_id'); ?></th>
            <td>
                <?php echo $form->hiddenField($model, 'franchisee_brand_id', array('value' => $model->franchisee_brand_id ? $model->franchisee_brand_id : '')); ?>
                <?php echo CHtml::textField('name', $model->franchisee_brand_id ? FranchiseeBrand::getFranchiseeBrandName($model->franchisee_brand_id) : '', array('class' => 'text-input-bj middle', 'readonly' => 'true')); ?>
                <?php echo $form->error($model, 'franchisee_brand_id'); ?>
                <?php echo CHtml::button(Yii::t('franchisee', '选择'), array('class' => 'reg-sub', 'id' => 'SetBizBrand')); ?>
                <?php echo CHtml::button(Yii::t('franchisee', '清除'), array('class' => 'reg-sub', 'readonly' => true, 'id' => 'ReSetBizBrand')); ?>
                <script>
                    $("#ReSetBizBrand").click(function() {
                        $("#Franchisee_franchisee_brand_id").val('');
                        $("#name").val('');
                    });
                </script>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'main_course'); ?></th>
            <td>
                <?php echo $form->textField($model, 'main_course', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'main_course'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'categoryId'); ?></th>
            <td>
                <?php $categoryData = FranchiseeCategory::model()->findAll(); ?>
                <?php foreach ($categoryData as $v): ?>
                    <input type="checkbox" name="Franchisee[categoryId][]" value="<?php echo $v->id; ?>" <?php if (in_array($v->id, Franchisee::findCategoryId($model->id))): ?> checked="true" <?php endif; ?>/> <?php echo $v->name; ?>
                <?php endforeach; ?>
                <?php echo $form->error($model, 'categoryId'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'status'); ?></th>
            <td>
                <?php echo $form->dropDownList($model, 'status', Franchisee::getStatus(), array('class' => 'text-input-bj', 'prompt' => '请选择')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'mobile'); ?></th>
            <td>
                <?php echo $form->textField($model, 'mobile', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'mobile'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'url'); ?></th>
            <td>
                <?php echo $form->textField($model, 'url', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'url'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'fax'); ?></th>
            <td>
                <?php echo $form->textField($model, 'fax', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'fax'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'zip_code'); ?></th>
            <td>
                <?php echo $form->textField($model, 'zip_code', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'zip_code'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'tags'); ?></th>
            <td>
                <?php echo $form->textField($model, 'tags', array('class' => 'text-input-bj  longest')); ?>
                <?php echo $form->error($model, 'tags'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'qq'); ?></th>
            <td>
                <?php echo $form->textArea($model, 'qq', array('class' => 'text-input-bj long longest')); ?>
                <span>以逗号分隔，如30994,349850,93802385 </span>
                <?php echo $form->error($model, 'qq'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'keywords'); ?></th>
            <td>
                <?php echo $form->textArea($model, 'keywords', array('class' => 'text-input-bj  longest')); ?>
                <?php echo $form->error($model, 'keywords'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'summary'); ?></th>
            <td>
                <?php echo $form->textArea($model, 'summary', array('class' => 'text-input-bj longest')); ?>
                <?php echo $form->error($model, 'summary'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'notice'); ?></th>
            <td>
                <?php echo $form->textArea($model, 'notice', array('class' => 'text-input-bj longest')); ?>
                <?php echo $form->error($model, 'notice'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'featured_content'); ?></th>
            <td  id="featured_contend_td"> 
                <?php
                $this->widget('comext.wdueditor.WDueditor', array(
                    'model' => $model,
                    'attribute' => 'featured_content',
                ));
                ?>
                <?php echo $form->error($model, 'featured_content'); ?>
                <script type="text/javascript">
                    //处理输入框提示错误的问题
                    $("#featured_contend_td").mouseout(function() {
                        //var str = $(window.frames["baidu_editor_0"].document).find('body').find('p').html();
                        var str = $("#baidu_editor_0").contents().find('body').find('p').html();
                        if (str == '<br>')
                            str = ' ';
                        $("#Franchisee_featured_content").html(str);
                        $("#Franchisee_featured_content").blur();

                    });

                </script>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'description'); ?></th>
            <td  id="contend_td"> 
                <?php
                $this->widget('comext.wdueditor.WDueditor', array(
                    'model' => $model,
                    'attribute' => 'description',
                ));
                ?>
                <?php echo $form->error($model, 'description'); ?>
                <script type="text/javascript">
                    //处理输入框提示错误的问题
                    $("#contend_td").mouseout(function() {
                        //var str = $(window.frames["baidu_editor_0"].document).find('body').find('p').html();
                        var str = $("#baidu_editor_1").contents().find('body').find('p').html();
                        if (str == '<br>')
                            str = ' ';
                        $("#Franchisee_description").html(str);
                        $("#Franchisee_description").blur();

                    });
                </script>
            </td>
        </tr>
        <tr>
            <th></th>
            <td><?php echo CHtml::submitButton(Yii::t('franchisee', '编辑'), array('class' => 'reg-sub')); ?></td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<script type="text/javascript" language="javascript">
                    var doClose = function() {
                        if (null != dialog) {
                            dialog.close();
                        }
                    };
</script>
<?php
Yii::app()->clientScript->registerScript('categoryTree', "
var dialog = null;
jQuery(function($) {

    $('#SetBizBrand').click(function() {
        dialog = art.dialog.open('" . $this->createUrl('/franchiseeBrand/getFranchiseeBrandAll') . "', {'id': 'selectmember', title: '搜索加盟商品牌', width: '800px', height: '620px', lock: true});
    })
})
var onSelectBizBrand = function(id,name) {
    if (id) {
        $('#Franchisee_franchisee_brand_id').val(id);
                $('#name').val(name);
    }
};
", CClientScript::POS_HEAD);
?>

