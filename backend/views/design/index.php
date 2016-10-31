<?php
/* @var $this DesignController */
/* @var $model Design */
$this->breadcrumbs = array(
    Yii::t('design', '商铺管理 '),
    Yii::t('design', '商铺装修列表'),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#design-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/js/plugins/iframeTools.js"></script>
<?php
$this->renderPartial('_search', array(
    'model' => $model,
));
?>
<style>
    .tab-reg a.regm-sub:hover, .tab-reg a.regm-sub {
        background: url("<?php echo MANAGE_DOMAIN ?>/images/sub-fou.gif") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
        width: 83px;
    }
</style>
<?php
$this->widget('GridView', array(
    'id' => 'design-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'ajaxUpdate' => true,
    'columns' => array(
        array(
            'class' => 'zii.widgets.grid.CCheckBoxColumn',
            'selectableRows' => 2,
            'disabled' => '$data->status!=Design::STATUS_AUDITING',
            'headerTemplate' => '{item} ' . Yii::t('design', '全选'),
            'checkBoxHtmlOptions' => array(
                'name' => 'id[]',
                'value' => '$data->id',
                'class' => 'design_id',
            )
        ),
        array(
            'name'=>  Yii::t('design','盖网编号'),
            'value'=>'$data->gw',
        ),
        array(
            'name'=>  Yii::t('design','会员名'),
            'value'=>'$data->username'
        ),
        'storeName',
        'mobile',
        
        array('name' => 'status', 'value' => 'Design::status($data->status)'),
        array('name' => 'create_time', 'type' => 'dateTime'),
        array(
            'class' => 'CButtonColumn',
            'template' => '{previewIndex}{previewStore}{pass}{notPass}',
            'updateButtonImageUrl' => false,
            'buttons' => array(
                'previewIndex' => array(
                    'label' => Yii::t('design', '预览首页'),
                    'options' => array('class' => 'regm-sub', 'target' => '_blank'),
                    'url' => 'DOMAIN."/shop/previewBackend/".$data->store_id.".html?tmpId=".$data->id',
                    'visible' => '$data->status==Design::STATUS_AUDITING'
                ),
                'previewStore' => array(
                    'label' => Yii::t('design', '预览实体店'),
                    'options' => array('class' => 'regm-sub', 'target' => '_blank'),
                    'url' => 'DOMAIN."/shop/storePreviewBackend/".$data->store_id.".html?tmpId=".$data->id',
                    'visible' => '$data->status==Design::STATUS_AUDITING'
                ),
                'pass' => array(
                    'label' => Yii::t('design', '通过'),
                    'options' => array('class' => 'regm-sub design_pass'),
                    'url' => 'Yii::app()->createUrl("/design/changeStatus",array("id"=>$data->id,"pass"=>"yes"))',
                    'visible' => '$data->status==Design::STATUS_AUDITING && Yii::app()->user->checkAccess("Design.ChangeStatus")'
                ),
                'notPass' => array(
                    'label' => Yii::t('design', '不通过'),
                    'options' => array('class' => 'regm-sub design_not_pass'),
                    'url' => 'Yii::app()->createUrl("/design/changeStatus",array("id"=>$data->id,"pass"=>"no"))',
                    'visible' => '$data->status==Design::STATUS_AUDITING && Yii::app()->user->checkAccess("Design.ChangeStatus")'
                ),
            )
        ),
    ),
));
?>

<script>
    //审核通过
    $(".design_pass").live("click", function() {
        $.post(this.href, {YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>'}, function(data) {
            if (data) {
                alert(data.error);
            } else {
                location.reload();
            }
        });
        return false;
    });
    //审核不通过
    $(".design_not_pass").live("click", function() {
        var url = this.href;
        art.dialog.prompt('<?php echo Yii::t('design', '原因'); ?>：', function(data) {
            $.post(url, {YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>', remark: data}, function(msg) {
                if (msg) {
                    alert(msg.error);
                } else {
                    location.reload();
                }
            });
        }, '');
        return false;
    });
</script>