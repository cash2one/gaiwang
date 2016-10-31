<!--<script type="text/javascript" src="/js/artDialog/jquery.artDialog.js?skin=aero"></script>-->
<?php Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/jquery.artDialog.js') ?>
<script type="text/javascript">
    /**
     * 删除
     */
    function delCheck(obj) {
        var id = $(obj).attr('href');
        var myUrl = "<?php echo MANAGE_DOMAIN ?>/?r=business/delete&id=" + id;
        art.dialog({
            icon: 'question',
            content: '确认删除？',
            lock: true,
            ok: function() {
                window.location.href = myUrl;
                //location.href = myUrl;
            },
            cancel: function() {
            }
        });
        return false;
    }
</script>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#business-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>
<?php
$this->renderPartial('_search', array(
    'model' => $model,
));
?>
<?php if ($this->getUser()->checkAccess('Business.Create')): ?>
    <input id="Btn_Add" type="button" value="<?php echo Yii::t('user', '添加'); ?>" class="regm-sub" onclick="location.href = '<?php echo Yii::app()->createAbsoluteUrl("/business/create"); ?>'">
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'business-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
//    'ajaxUpdate' => true,
    'columns' => array(
        array(
            'headerHtmlOptions' => array('width' => '73%'),
            'name' => 'store',
            'value' => '$data->store'
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => '操作',
            'template' => '{previewIndex}{previewStore}{previewDelete}{export}',
            'updateButtonImageUrl' => false,
            'buttons' => array(
                'previewIndex' => array(
                    'label' => Yii::t('design', '查看'),
                    'options' => array('class' => 'regm-sub'),
                    'url' => 'Yii::app()->controller->createUrl("check", array("id"=>$data->id))',
                ),
                'previewStore' => array(
                    'label' => Yii::t('design', '编辑'),
                    'options' => array('class' => 'regm-sub'),
                    'url' => 'Yii::app()->controller->createUrl("update", array("id"=>$data->id))',
                ),
                'previewDelete' => array(
                    'label' => Yii::t('user', '删除'),
                    'options' => array('class' => 'regm-sub','onclick' => 'return delCheck(this)'),
                    //'url' => 'Yii::app()->controller->createUrl("delete", array("id"=>$data->id))',
                     'url' => '$data->id',
                ),
                'export' => array(
                    'label' => Yii::t('design', '导出'),
                    'options' => array('class' => 'regm-sub design_pass'),
                    // 'url' => 'Yii::app()->createUrl("/design/changeStatus",array("id"=>$data->id,"pass"=>"yes"))',
                    'url' => 'Yii::app()->controller->createUrl("export", array("id"=>$data->id))',
                ),
            )
        ),
    ),
));
?>