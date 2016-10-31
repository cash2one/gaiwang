<?php
/* @var $this FranchiseeGroupbuyController */
/* @var $model FranchiseeGroupbuy */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id.'-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('franchiseeGroupbuy', '发布团购 ') : Yii::t('franchiseeGroupbuy', '编辑团购'); ?></td>
    </tr>
    <tr>
        <th class="odd"><?php echo $form->labelEx($model, 'franchisee_groupbuy_category_id'); ?></th>
        <td class="odd">
            <?php echo $form->hiddenField($model, 'franchisee_groupbuy_category_id', array('value' => $model->franchisee_groupbuy_category_id ? $model->franchisee_groupbuy_category_id : '')); ?>
            <?php echo CHtml::textField('FranchiseeGroupbuyCategoryName', $model->FranchiseeGroupbuyCategoryName ? $model->FranchiseeGroupbuyCategoryName : '', array('class' => 'text-input-bj middle', 'readonly' => 'true')); ?>
            <?php
            echo CHtml::button(Yii::t('franchiseeGroupbuy', '选择'), array('class' => 'reg-sub', 'readonly' => true, 'id' => 'SetRefFranchiseeGroupbuyCategory'));
            ?>
            <?php echo $form->error($model, 'franchisee_groupbuy_category_id'); ?>
        </td>
    </tr>
    <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'name'); ?>
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'original_price'); ?>：
        </th>
        <td class="odd">
            <?php echo $form->textField($model, 'original_price', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'original_price'); ?>
        </td>
    </tr>
    <tr>
        <th class="even">
            <?php echo $form->labelEx($model, 'seller_price'); ?>：
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'seller_price', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'seller_price',array('style'=>'position: absolute;left:220px;top:5px')); ?>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'dead_time'); ?> <span class="required">*</span>：
        </th>
        <td class="odd">
            <?php
            $model->dead_time = $model->isNewRecord ? '' : date('Y-m-d',$model->dead_time);
            $this->widget('comext.timepicker.timepicker', array(
                'model' => $model,
                'name' => 'dead_time',
                'select' => 'date',
            ));
            ?>
            <?php echo $form->error($model, 'dead_time'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'service'); ?> <span class="required">*</span>：
        </th>
        <td class="odd">
            <?php echo $form->checkBox($model, 'no_book'); ?>免预约
            <?php echo $form->checkBox($model, 'anytime_back'); ?>随时退
            <?php echo $form->checkBox($model, 'overdue_back'); ?>过期退
            <?php echo $form->error($model, 'no_book'); ?>
            <?php echo $form->error($model, 'anytime_back'); ?>
            <?php echo $form->error($model, 'overdue_back'); ?>
        </td>
    </tr>

    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'summary'); ?>：
        </th>
        <td class="odd">
            <?php echo $form->textArea($model, 'summary', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'summary'); ?>
        </td>
    </tr>
    <tr>
        <th class="even"><?php echo $form->labelEx($model, 'franchisee_brand_id'); ?></th>
        <td class="even">
            <?php echo $form->hiddenField($model, 'franchisee_brand_id', array('value' => $model->franchisee_brand_id ? $model->franchisee_brand_id : '')); ?>
            <?php echo CHtml::textField('FranchiseeBrandName', $model->FranchiseeBrandName ? $model->FranchiseeBrandName : '', array('class' => 'text-input-bj middle', 'readonly' => 'true')); ?>
            <?php
            echo CHtml::button(Yii::t('franchiseeBrand', '选择'), array('class' => 'reg-sub', 'readonly' => true, 'id' => 'SetRefFranchiseeBrand'));
            ?>
            <?php echo $form->error($model, 'franchisee_brand_id'); ?>
        </td>
    </tr>
    <tr id="belongBrand">
        <?php if(!$model->isNewRecord):?>
        <?php if($franchisee_id):?>
            <th class="odd">支持所属加盟商:</th>
            <td class='odd'>
                <input type="checkbox" id="checkAll" name="checkAll">全选
                <br/>
                <?php echo CHtml::checkBoxList('franchisee_id[]',$franchisee_id,Franchisee::findFranchiseeByBrand($model->franchisee_brand_id),array('separator'=>'&nbsp;&nbsp;','data'=>'checkList'));?>
            </td>
        <?php endif;?>
        <?php endif;?>
    </tr>
    <tr>
        <th class="odd"><?php echo $form->labelEx($model, 'notice'); ?></th>
        <td class="odd">
            <?php
            $this->widget('comext.wdueditor.WDueditor', array(
                'model' => $model,
                'attribute' => 'notice',
            ));
            ?>
            <?php echo $form->error($model, 'notice'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd"><?php echo $form->labelEx($model, 'content'); ?></th>
        <td class="odd">
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
        <th class="odd">
            <?php echo $form->labelEx($model, 'stock'); ?>：
        </th>
        <td class="odd">
            <?php echo $form->textField($model, 'stock', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'stock'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd"><?php echo $form->labelEx($model, 'status'); ?></th>
        <td class="odd">
            <?php echo $form->radioButtonList($model, 'status', FranchiseeGroupbuy::status(), array('separator' => '')); ?>
            <?php echo $form->error($model, 'status'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'thumbnail'); ?>
        </th>
        <td class="odd">
            <?php echo $form->FileField($model, 'thumbnail'); ?>
            <?php if (!$model->isNewRecord): ?>
                <input type="hidden" name="oldImg" value="<?php echo $model->thumbnail; ?>">
                <img src="<?php echo ATTR_DOMAIN; ?>/<?php echo $model->thumbnail ?>" width="100" height="80"/>
            <?php endif; ?>  
            <?php echo $form->error($model, 'thumbnail'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'path'); ?>
        </th>
        <td class="odd">
           <?php 
                $this->widget('common.widgets.CUploadPic',array(
                    'form' => $form,
                    'model' => $model,
                    'attribute' => 'path',
                    'num' => 7,
                    'folder_name' => 'files',
                ));
            ?>
        </td>
    </tr>
    
    <tr>
        <th class="odd"></th>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('franchiseeGroupbuy', '发布') : Yii::t('franchiseeGroupbuy', '保存'), array('class' => 'reg-sub','onclick'=>"return checkFrom();")); ?>
        </td>
    </tr> 
</table>    
<?php $this->endWidget(); ?>

<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<?php
Yii::app()->clientScript->registerScript('categoryTree', "
var dialog = null;
jQuery(function($) {
    //搜索父加盟商
    $('#SetRefFranchiseeBrand').click(function() {
        dialog = art.dialog.open('" . $this->createUrl('/franchiseeBrand/getFranchiseeBrand') . "', { 'id': 'selectmember', title: '搜索所属商家品牌', width: '800px', height: '620px', lock: true });
    })
    $('#SetRefFranchiseeGroupbuyCategory').click(function() {
        dialog = art.dialog.open('" . $this->createUrl('/franchiseeGroupbuyCategory/getFranchiseeGroupbuyCategory') . "', { 'id': 'selectmember', title: '搜索类目', width: '800px', height: '620px', lock: true });
    })
})
var onSelectFranchiseeBrand = function (uid) {
    if (uid) {
        $.ajax({
            cache:false,
            dataType: 'json',
            url:'" . $this->createUrl('/franchiseeBrand/getFranchiseeBrandName') . "&id='+uid+'&YII_CSRF_TOKEN=" . Yii::app()->request->csrfToken . "',
            success:function(data){
                $('#FranchiseeGroupbuy_franchisee_brand_id').val(uid);
                $('#FranchiseeBrandName').val(data.name);
                $('#belongBrand').html(data.html);
            }
        })
    }
};
var onSelectCategory = function (uid) {
    if (uid) {
        $.ajax({
            cache:false,
            dataType: 'json',
            url:'" . $this->createUrl('/franchiseeGroupbuyCategory/getCategory') . "&id='+uid+'&YII_CSRF_TOKEN=" . Yii::app()->request->csrfToken . "',
            success:function(name){
                $('#FranchiseeGroupbuy_franchisee_groupbuy_category_id').val(uid);
                $('#FranchiseeGroupbuyCategoryName').val(name);
            }
        })
    }
};
", CClientScript::POS_HEAD);
?>
<script>
    //所属支持加盟商选择
    $(function(){
        $("#checkAll").live("click",function(){
            var flag = $(this).attr("checked");
            if(!flag){
                $("[data = checkList]:checkbox").attr("checked",false);
            }else{
                $("[data = checkList]:checkbox").attr("checked",true);
            }
        });
    });
    
    function checkFrom() {
        var deadTime   = $('#yw0').val();
        if( $.trim(deadTime) == ''){
		$('#FranchiseeGroupbuy_dead_time_em_').html('到期时间 不可为空白.');
	    $('#FranchiseeGroupbuy_dead_time_em_').css('display', '');
		return false;
	}else{
		$('#FranchiseeGroupbuy_dead_time_em_').css('display', 'none');
	}
    }
</script>