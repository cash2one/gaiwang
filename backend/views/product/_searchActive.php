<?php
/* @var $this ProductController */
/* @var $model Product */
/* @var $form CActiveForm */
?>
<style>
    <!--
    .search-form{ line-height:45px; }
    -->
</style>
<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="searchT01">
        <tbody>
           <tr>
                <th width="7%"><?php echo $form->label($model, 'product_name'); ?>：</th>
                <td width="18%">
                    <?php
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'product_name',
                        'source' => $this->createAbsoluteUrl('/product/suggestProducts'),
                        'htmlOptions' => array(
                            'style' => 'width:90%',
                            'class' => 'text-input-bj  least',
                            'maxLength' => '128'
                        ),
                    ));
                    ?>
                </td>
<!--                <th width="7%"><?php //echo $form->label($model, 'seller_name'); ?>：</th>
                <td width="18%">
                    <?php //echo $form->textField($model, 'seller_name', array('style' => 'width:90%', 'class' => 'text-input-bj  least')); ?>
                </td>-->
                <th width="7%"><?php echo $form->label($model, 'seller_name'); ?>：</th>
                <td width="18%">
                    <?php
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'seller_name',
                        'source' => $this->createAbsoluteUrl('/product/suggestStores'),
                        'htmlOptions' => array(
                            'style' => 'width:90%',
                            'class' => 'text-input-bj  least',
                            'maxLength' => '128'
                        ),
                    ));
                    ?>
                </td>
                <th><?php echo $form->label($model, 'g_category_id'); ?>：</th>
                <td>
                    <?php echo $form->textField($model, 'g_category_id', array('style' => 'width:90%', 'class' => 'text-input-bj  least')); ?>
                    <?php echo $form->hiddenField($model, 'true_category_id'); ?>
                </td>
                <th width="7%"><?php echo $form->label($model, 'price'); ?>：</th>
                <td width="18%">
                    <?php echo $form->textField($model, 'price', array('style' => 'width:37%', 'class' => 'text-input-bj  least')); ?> -
                    <?php echo $form->textField($model, 'end_price', array('style' => 'width:37%', 'class' => 'text-input-bj  least')); ?>
                </td>
            </tr>
            <tr>
               <th><?php echo $form->label($model, 'product_id'); ?>：</th>
                <td>
                    <?php echo $form->textField($model, 'product_id', array('class'=>'text-input-bj  least')); ?>
                </td>
                <th><?php echo $form->label($model, 'name'); ?>：</th>
                <td>
                    <?php echo $form->textField($model, 'name', array('class'=>'text-input-bj  middle')); ?>
                </td>
                <th><?php echo $form->label($model, 'category_id'); ?>：</th>
                <td colspan="1">
                    <?php echo $form->dropDownList($model, 'category_id', SeckillCategory::getCategory(), array('empty'=>Yii::t('sellerGoods','全部'),'separator' => '','class'=>'text-input-bj')); ?>
                </td>
                <th><?php echo '活动起止日期'; ?>：</th>
                <td colspan="1">
                    <?php
                    $this->widget('comext.timepicker.timepicker', array(
                        'model' => $model,
                        'name' => 'date_start',
                        'select'=>'date',
                        'cssClass'=>'text-input-bj  least',

                    ));
                    ?> -
                    <?php
                    $this->widget('comext.timepicker.timepicker', array(
                        'model' => $model,
                        'name' => 'date_end',
                        'select'=>'date',
                        'cssClass'=>'text-input-bj  least',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $form->label($model, "status")?>:</th>
                <td colspan="2"><?php echo $form->radioButtonList($model, 'status', SeckillProductRelation::showStatus(),array('separator'=>'','empty'=>Yii::t('sellerGoods','全部'),))?></d>
                <th colspan="6" class="ta_c"><?php echo CHtml::submitButton(Yii::t('user', '搜索'), array('class' => 'reg-sub')); ?></th>
            <tr>
        </tbody>
    </table>
    <?php $this->endWidget(); ?>
</div>
<script src="/js/iframeTools.js" type="text/javascript"></script>
<?php
Yii::app()->clientScript->registerScript('categoryTree', "
var dialog = null;
jQuery(function($) {
    var url = '" . $this->createAbsoluteUrl('/category/categoryTree') . "';
    $('#SeckillProductRelation_g_category_id').click(function() {
        dialog = art.dialog.open(url, {'id': 'SearchCat', title: '搜索类别', width: '640px', height: '600px', lock: true});
    })
})
var onSelectedCat = function(id, name) {
    $('#SeckillProductRelation_g_category_id').val(name);
    $('#SeckillProductRelation_true_category_id').val(id);
};
var doClose = function() {
    if (null != dialog) {
        dialog.close();
    }
};
", CClientScript::POS_HEAD);
?>