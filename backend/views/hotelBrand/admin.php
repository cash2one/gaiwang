<?php
/* @var $this HotelLevelController */
/* @var $model hotelBrand */

$this->breadcrumbs = array(
    Yii::t('hotelBrand', '酒店品牌') => array('admin'),
    Yii::t('hotelBrand', '管理'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#hotel-brand-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>

<?php if (Yii::app()->user->checkAccess('HotelBrand.Create')): ?>
    <?php echo CHtml::button('button', array(
        'value' => Yii::t('hotelBrand', '添加'),
        'class' => 'regm-sub',
        'onclick' => "location.href = '" . Yii::app()->createAbsoluteUrl("/hotelBrand/create") . "'",
    )); ?>
    <div class="c10"></div>
<?php endif; ?>

<?php
$this->widget('GridView', array(
    'id' => 'hotel-brand-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        array(
            'name' => 'logo',
            'value' => 'CHtml::image(Tool::showImg(ATTR_DOMAIN . "/" . $data->logo, "c_fill,h_80,w_100"), $data->name, array("width" => 100, "height" => 80, "style" => "display: inline-block"))',
            'type' => 'raw', //这里是原型输出
        ),
        array(
            'class' => 'DataColumn',
            'name' => 'sort',
            'value' => '$data->sort',
            'evaluateHtmlOptions' => true,
            'htmlOptions' => array(
                'id' => '"sort-{$data->id}"',
                'class' => '"sort-{$data->id}"',
                'onclick' => '"clickEvent({$data->id})"',
            ),
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('hotelBrand', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('hotelBrand', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('HotelBrand.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('hotelBrand', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('HotelBrand.Delete')"
                ),
            )
        )
    ),
));
?>
<script>
    function clickEvent(id) {
        var val = $("#sort-" + id).text();
        $("#sort-" + id).html('');
        $("#sort-" + id).append("<input id='" + id + "' type='text' name='sort' value='" + val + "'/>");
        $("#sort-" + id).removeAttr('id');
        $("#" + id).focus();

        $('#' + id).mouseout(function() {
            var sort = $('#' + id).val();
            var reg = /^[0-9]*[1-9][0-9]*$/;
            if (sort > 255) sort = 255;

            if (reg.exec(sort)) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->createAbsoluteUrl("/HotelBrand/ajaxUpdateSort"); ?>",
                    data: "id=" + id + "&sort=" + sort,
                    success: function(res) {
                        if (res) {
                            $("#" + id).remove();
                            $('.sort-' + id).attr('id', 'sort-' + id);
                            $('.sort-' + id).html(sort);
                            $('#hotel-brand-grid').yiiGridView('update', {data: $(this).serialize()});
                        } else {
                            alert("<?php echo Yii::t('hotelBrand', '编辑失败'); ?>");
                        }
                    }
                });
            } else {
                alert("<?php echo Yii::t('hotelBrand', '请输入正整数'); ?>");
                return;
            }
        })
    }
</script>