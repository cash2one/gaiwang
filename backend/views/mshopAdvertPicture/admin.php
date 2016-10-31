<?php $this->breadcrumbs = array(Yii::t('advert', '广告位图片') => array('advertPicture/admin', 'aid' => $model->advert_id), Yii::t('advertPicture', '列表')); ?>

<?php if ($model->advert->type != Advert::TYPE_IMAGE || ($model->advert->type == Advert::TYPE_IMAGE && $model->advert->pictureCount == 0)): ?>
    <?php if ($this->getUser()->checkAccess('AdvertPicture.Create')): ?>
        <input id="Btn_Add" type="button" value="<?php echo Yii::t('advertPicture', '添加广告'); ?>" class="regm-sub" onclick="location.href = '<?php echo $this->createAbsoluteUrl("/advertPicture/create&aid=" . Yii::app()->request->getParam('aid')); ?>'">
    <?php endif; ?>
<?php endif; ?>

<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'advertPicture-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'advert_id',
            'value' => '$data->advert->name'
        ),
        'title',
        array(
            'type' => 'datetime',
            'name' => 'start_time',
            'value' => '$data->start_time'
        ),
        array(
            'type' => 'raw',
            'name' => 'end_time',
            'value' => 'empty($data->end_time) ? "<font color=\'green\'>永不过期</font>" : date("Y-m-d H:i:s", $data->end_time)'
        ),
        array(
            'type' => 'raw',
            'name' => 'status',
            'value' => '!empty($data->end_time) && $data->end_time < time() ? "<font color=\'red\'>过期</font>" : AdvertPicture::getStatus($data->status)',
        ),
        'group',
        'seat',
        'sort',
        array(
            'name' => 'target',
            'value' => 'AdvertPicture::getTarget($data->target)'
        ),
        array(
            'type' => 'raw',
            'name' => 'link',
            'value' => '$data->link ? CHtml::link(Yii::t("advertPicture", "查看链接"), $data->link, array("target" => "_blank")) : ""'
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('AdvertPicture.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('AdvertPicture.Delete')"
                ),
            )
        )
    ),
));
?>
<script type='text/javascript'>
    /*<![CDATA[*/
    var GetCheckbox = function() {
        var data = new Array();
        $("input:checkbox[name='selectdel[]']").each(function() {
            if ($(this).attr("checked") == 'checked') {
                data.push($(this).val());
            }
        });
        if (!confirm('<?php echo Yii::t('advertPicture', '确定要删除这些数据吗?'); ?>'))
            return false;
        if (data.length > 0) {
            $.post('<?php echo Yii::app()->createAbsoluteUrl('/advertPicture/delall'); ?>', {'selectdel[]': data, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'}, function(data) {
                if (data != null && data.success != null && data.success) {
                    $.fn.yiiGridView.update('advertPicture-grid');
                }
            }, 'json');
        } else {
            alert("<?php echo Yii::t('advertPicture', '请选择要删除的数据!'); ?>");
        }
    }
    /*]]>*/
</script>