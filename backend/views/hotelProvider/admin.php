<?php
$this->breadcrumbs = array(
    Yii::t('HotelProvider', '酒店供应商列表') => array('admin'),
    Yii::t('HotelProvider', '管理'),
);
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $('#hotel-provider-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>

<?php if (Yii::app()->user->checkAccess('HotelProvider.Create')): ?>
    <?php echo CHtml::button('button', array(
        'value' => Yii::t('hotelLevel', '添加'),
        'class' => 'regm-sub',
        'onclick' => "location.href = '" . Yii::app()->createAbsoluteUrl("/hotelProvider/create") . "'",
    )); ?>
    <div class="c10"></div>
<?php endif; ?>

<?php
$this->widget('GridView', array(
    'id' => 'hotel-provider-grid',
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'dataProvider' => $model->search(),
    'columns' => array(
        'name',
        array(
            'name' => 'member_id',
            'value' => '!$data->member_id ? "" : $data->member->gai_number',
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
            'header' => Yii::t('home', '操作'),
            'template' => '{update}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('hotelProvider', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('HotelProvider.Update')"
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
                    url: "<?php echo Yii::app()->createAbsoluteUrl("/hotelProvider/ajaxUpdateSort"); ?>",
                    data: "id=" + id + "&sort=" + sort,
                    success: function(res) {
                        if (res) {
                            $("#" + id).remove();
                            $('.sort-' + id).attr('id', 'sort-' + id);
                            $('.sort-' + id).html(sort);
                            $('#hotel-provider-grid').yiiGridView('update', {data: $(this).serialize()});
                        } else {
                            alert("<?php echo Yii::t('hotelProvider', '编辑失败'); ?>");
                        }
                    }
                });
            } else {
                alert("<?php echo Yii::t('hotelProvider', '请输入正整数'); ?>");
                return;
            }
        })
    }
</script>