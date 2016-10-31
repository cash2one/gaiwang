<?php
/* @var $this EnterpriseController */
/* @var $model Enterprise */
$this->breadcrumbs = array(Yii::t('enterprise', '网签审核') => array('admin'), Yii::t('enterprise', '列表'));

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#enterprise-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<?php $this->renderPartial('_admintop'); ?>
<br/>
<?php $this->renderPartial('_search', array('model' => $model)); ?>


<?php
$this->widget('GridView', array(
    'id' => 'enterprise-grid',
    'dataProvider' => $model->searchZzb($role),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => Yii::t('enterprise', '更新时间'),
            'value' => 'empty($data->au_time)?date("Y-m-d G:i:s",$data->create_time):date("Y-m-d G:i:s",$data->au_time)'
        ),
        array(
            'name' => '店铺名称',
            'value' => '$data->store_name'
        ),
        array(
            'name' => 'enterprise_type',
            'value' => 'Enterprise::getEnterpriseType($data->enterprise_type)'
        ),
        array(
            'name' => Yii::t('enterprise', '经营类目'),
            'value' => '$data->cat_name'
        ),
        array(
            'name' => '开店模式',
            'value' => 'Store::getMode($data->mode)',
        ),
        array(
            'name' => 'auditing',
            'value' => 'EnterpriseLog::getStatus($data->el_status)'
        ),
        'service_id',
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{auditingZhaoshang}{auditingFawu}{progress}{remarts}',
            'viewButtonImageUrl' => false,
            'buttons' => array(
                'auditingZhaoshang' => array(
                    'label' => Yii::t('enterprise', '审核'),
                    'url' => 'Yii::app()->createUrl("enterprise/auditingZzbZhaoshang", array("id"=>$data->id))',
                    'visible' => '$data->progress==' . EnterpriseLog::PROCESS_CHECK_PAPER_ZHAOSHANG . " AND Yii::app()->user->checkAccess('Enterprise.AuditingZzbZhaoshang')",
                    'options' => array(
                        'class' => 'regm-sub-a',
                    )
                ),
                'auditingFawu' => array(
                    'label' => Yii::t('enterprise', '审核'),
                    'url' => 'Yii::app()->createUrl("enterprise/auditingZzbFawu", array("id"=>$data->id))',
                    'visible' => '$data->progress==' . EnterpriseLog::PROCESS_CHECK_PAPER_FAWU . " AND Yii::app()->user->checkAccess('Enterprise.AuditingZzbFawu')",
                    'options' => array(
                        'class' => 'regm-sub-a',
                    )
                ),
                'progress' => array(
                    'label' => Yii::t('enterprise', '审核进度'),
                    'url' => 'Yii::app()->createUrl("enterprise/progress", array("id"=>$data->id))',
                    'visible' => "Yii::app()->user->checkAccess('Enterprise.Progress')",
                    'options' => array(
                        'class' => 'regm-sub-a',
                        'act' => 'openProgress',
                    )
                ),
                'remarts' => array(
                    'label' => Yii::t('enterprise', '备注'),
                    'url' => 'Yii::app()->createUrl("enterprise/remarts", array("id"=>$data->id))',
                    'options' => array(
                        'class' => 'regm-sub-a remarts',
                    )
                ),
            )
        )
    ),
));
?>
<script  type="text/javascript">
    var dialog = null;
    $("a[act='openProgress']").click(function() {
        dialog = art.dialog.open($(this).attr('href'), {'id': 'progress', title: '审核进度', width: '90%', height: '80%', lock: true});
        return false;
    });
    $("a.remarts").on('click', function() {
        dialog = art.dialog.open($(this).attr('href'), {'id': 'service_id', title: '添加备注', width: '50%', height: '80%', lock: true});
        return false;
    });

</script>
