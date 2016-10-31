<?php
$this->breadcrumbs = array(
    Yii::t('nationality', '国籍列表') => array('index'),
    Yii::t('nationality', '管理'),
);
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $('#nationality-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>
<?php $this->renderPartial('_search', array('model' => $model));?>

<?php if (Yii::app()->user->checkAccess('HotelAddress.Create')): ?>
    <?php echo CHtml::button('button', array(
        'value' => Yii::t('hotelBrand', '添加'),
        'class' => 'regm-sub',
        'onclick' => "location.href = '" . Yii::app()->createAbsoluteUrl("/nationality/create") . "'",
    )); ?>
    <div class="c10"></div>
<?php endif; ?>
<?php
$this->widget('GridView', array(
    'id' => 'nationality-grid',
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'dataProvider' => $model->search(),
    'columns' => array(
        'name',
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
            'header' => Yii::t('nationality', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('nationality', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('HotelAddress.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('nationality', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('HotelAddress.Delete')"
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
                    url: "<?php echo Yii::app()->createAbsoluteUrl("/nationality/ajaxUpdateSort"); ?>",
                    data: "id=" + id + "&sort=" + sort,
                    success: function(res) {
                        if (res) {
                            $("#" + id).remove();
                            $('.sort-' + id).attr('id', 'sort-' + id);
                            $('.sort-' + id).html(sort);
                            $('#nationality-grid').yiiGridView('update', {data: $(this).serialize()});
                        } else {
                            alert("<?php echo Yii::t('nationality', '编辑失败'); ?>");
                        }
                    }
                });
            } else {
                alert("<?php echo Yii::t('nationality', '请输入正整数'); ?>");
                return;
            }
        })
    }
</script>