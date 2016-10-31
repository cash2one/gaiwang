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
                <th width="7%"><?php echo $form->label($model, 'name'); ?>：</th>
                <td width="18%">
                    <?php echo $form->textField($model, 'name', array('style' => 'width:90%', 'class' => 'text-input-bj  least')); ?>
                </td>
                <th width="7%"><?php echo $form->label($model, 'code'); ?>：</th>
                <td width="18%">
                    <?php echo $form->textField($model, 'code', array('style' => 'width:90%', 'class' => 'text-input-bj  least')); ?>
                </td>
                <th width="7%"><?php echo $form->label($model, 'store_id'); ?>：</th>
                <td width="18%">
                    <?php
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'store_id',
                        'source' => $this->createAbsoluteUrl('/product/suggestStores'),
                        'htmlOptions' => array(
                            'style' => 'width:90%',
                            'class' => 'text-input-bj  least',
                            'maxLength' => '128'
                        ),
                    ));
                    ?>
                </td>
                <th width="7%"><?php echo $form->label($model, 'gai_price'); ?>：</th>
                <td width="18%">
                    <?php echo $form->textField($model, 'gai_price', array('style' => 'width:37%', 'class' => 'text-input-bj  least')); ?> -
                    <?php echo $form->textField($model, 'endGaiPrice', array('style' => 'width:37%', 'class' => 'text-input-bj  least')); ?>
                </td>
            <tr>
            <tr>

                <th><?php echo $form->label($model, 'price'); ?>：</th>
                <td>
                    <?php echo $form->textField($model, 'price', array('style' => 'width:37%', 'class' => 'text-input-bj  least')); ?> -
                    <?php echo $form->textField($model, 'endPrice', array('style' => 'width:37%', 'class' => 'text-input-bj  least')); ?>
                </td>
                <th><?php echo $form->label($model, 'stock'); ?>：</th>
                <td>
                    <?php echo $form->textField($model, 'stock', array('style' => 'width:37%', 'class' => 'text-input-bj  least')); ?> -
                    <?php echo $form->textField($model, 'endStock', array('style' => 'width:37%', 'class' => 'text-input-bj  least')); ?>
                </td>
                <th><?php echo $form->label($model, 'category_id'); ?>：</th>
                <td>
                    <?php echo $form->textField($model, 'category_id', array('style' => 'width:90%', 'class' => 'text-input-bj  least')); ?>
                </td>
                <th><?php echo $form->label($model, 'brand_id'); ?>：</th>
                <td>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'brand_id',
                        'source' => $this->createAbsoluteUrl('/product/suggestBrands'),
                        'htmlOptions' => array(
                            'style' => 'width:90%',
                            'class' => 'text-input-bj  least',
                            'maxLength' => '128'
                        ),
                    ));
                    ?>
                </td>
            <tr>
            <tr>
                <th><?php echo $form->label($model, 'show'); ?>：</th>
                <td>
                    <?php echo $form->radioButtonList($model, 'show', Product::getShow(), array('separator' => '')); ?>
                </td>
                <th><?php echo $form->label($model, 'is_publish'); ?>：</th>
                <td>
                    <?php echo $form->radioButtonList($model, 'is_publish', Goods::publishStatus(), array('separator' => '')); ?>
                </td>
                <!--<th><?php /*echo $form->label($model, 'status'); */?>：</th>-->
                <!--<td colspan="3">
                    <?php /*echo $form->radioButtonList($model, 'status', Goods::getNewStatus(), array('separator' => '')); */?>
                </td>-->
                <th><?php echo $form->label($model, 'create_time'); ?>：</th>
                <td colspan="1">
                    <?php
                    $this->widget('comext.timepicker.timepicker', array(
                        'model' => $model,
                        'name' => 'time_start',
                        'select'=>'datetime',
                        'cssClass'=>'text-input-bj  least',

                    ));
                    ?> -
                    <?php
                    $this->widget('comext.timepicker.timepicker', array(
                        'model' => $model,
                        'name' => 'time_end',
                        'select'=>'datetime',
                        'cssClass'=>'text-input-bj  least',
                    ));
                    ?>
                </td>
                <th><?php echo $form->label($model, 'id'); ?>：</th>
                <td >
                    <?php echo $form->telField($model, 'id',array('style' => 'width:90%', 'class' => 'text-input-bj  least')); ?>
                </td>
            <tr>
              <tr>
                  <th><?php echo $form->label($model, 'active_status'); ?>：</th>
                <td colspan="1">
                    <?php echo $form->radioButtonList($model, 'active_status', SeckillProductRelation::showStatus(), array('separator' => '')); ?>
                </td>

                <th><?php echo $form->label($model, 'status'); ?>：</th>
                <td colspan="3">
                    <?php echo $form->radioButtonList($model, 'status', Goods::getNewStatus(), array('separator' => '')); ?>
                    <?php echo $form->checkBox($model, 'change_field',array())?><?php echo $form->label($model, 'change_field'); ?>
                </td>
            </tr>



            <tr>
                <th colspan="8" class="ta_c"><?php echo CHtml::submitButton(Yii::t('user', '搜索'), array('class' => 'reg-sub')); ?></th>
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
    $('#Product_category_id').click(function() {
        dialog = art.dialog.open(url, {'id': 'SearchCat', title: '搜索类别', width: '640px', height: '600px', lock: true});
    })
})
var onSelectedCat = function(id, name) {
    $('#Product_category_id').val(name);
};
var doClose = function() {
    if (null != dialog) {
        dialog.close();
    }
};
", CClientScript::POS_HEAD);
?>