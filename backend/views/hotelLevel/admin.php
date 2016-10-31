<?php
/* @var $this HotelLevelController */
/* @var $model HotelLevel */

$this->breadcrumbs = array(
    Yii::t('hotelLevel', '酒店等级') => array('admin'),
    Yii::t('hotelLevel', '管理'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#hotel-level-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>

<?php if ($this->getUser()->checkAccess('HotelLevel.Create')): ?>
    <?php echo CHtml::button('button', array(
        'value' => Yii::t('hotelLevel', '添加'),
        'class' => 'regm-sub',
        'onclick' => "location.href = '" . Yii::app()->createAbsoluteUrl("/hotelLevel/create") . "'",
    )); ?>
    <div class="c10"></div>
<?php endif; ?>

<?php
$this->widget('GridView', array(
    'id' => 'hotel-level-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'summaryText' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        'description',
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
            'header' => Yii::t('hotelLevel','操作'),
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('hotelLevel', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('HotelLevel.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('hotelLevel', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('HotelLevel.Delete')"
                ),
            ),
            'template' => '{update}{delete}',
            'updateButtonLabel' => Yii::t('hotelLevel', '编辑'),
            'updateButtonImageUrl' => false,
            'deleteButtonLabel' => Yii::t('hotelLevel', '删除'),
            'deleteButtonImageUrl' => false,
        ),
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
                    url: "<?php echo Yii::app()->createAbsoluteUrl("/HotelLevel/ajaxUpdateSort"); ?>",
                    data: "id=" + id + "&sort=" + sort,
                    success: function(res) {
                        if (res) {
                            $("#" + id).remove();
                            $('.sort-' + id).attr('id', 'sort-' + id);
                            $('.sort-' + id).html(sort);
                            $('#hotel-level-grid').yiiGridView('update', {data: $(this).serialize()});
                        } else {
                            alert("<?php echo Yii::t('hotelLevel', '编辑失败'); ?>");
                        }
                    }
                });
            } else {
                alert("<?php echo Yii::t('hotelLevel', '请输入正整数'); ?>");
                return;
            }
        })
    }
</script>