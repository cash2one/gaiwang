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
    'dataProvider' => $model->searchDzb($role),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'ajaxUpdate' => false,
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
            'header' => '',
            'template' => '{add}{change}',
            'viewButtonImageUrl' => false,
            'buttons' => array(
                'add' => array(
                    'label' => Yii::t('enterprise', '新增'),
                    'visible' => 'Yii::app()->user->checkAccess("Enterprise.ChangeServiceId") && empty($data->service_id)',
                    'url' => 'Yii::app()->createUrl("enterprise/changeServiceId", array("id"=>$data->id))',
                    'options' => array(
                        'class' => 'regm-sub-a service_id service_add',
                    )
                ),
                'change' => array(
                    'label' => Yii::t('enterprise', '修改'),
                    'visible' => 'Yii::app()->user->checkAccess("Enterprise.ChangeServiceId")&& !empty($data->service_id)',
                    'url' => 'Yii::app()->createUrl("enterprise/changeServiceId", array("id"=>$data->id))',
                    'options' => array(
                        'class' => 'regm-sub-a service_id',
                    )
                ),
            ),
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{view}{auditingZhaoshang}{auditingFawu}{progress}{remarts}',
            'viewButtonImageUrl' => false,
            'buttons' => array(
                'view' => array(
                    'label' => Yii::t('enterprise', '查看详情'),
                    'visible' => 'Yii::app()->user->checkAccess("Enterprise.View") && $data->el_status==EnterpriseLog::STATUS_NOT_PASS ',
                    'options' => array(
                        'class' => 'regm-sub-a',
                    )
                ),
                'auditingZhaoshang' => array(
                    'label' => Yii::t('enterprise', '审核'),
                    'url' => 'Yii::app()->createUrl("enterprise/auditingDzbZhaoshang", array("id"=>$data->id))',
                    'visible' => '$data->progress==' . EnterpriseLog::PROCESS_CHECK_INFO_ZHAOSHANG . ' AND Yii::app()->user->checkAccess("Enterprise.AuditingDzbZhaoshang") && $data->el_status!=EnterpriseLog::STATUS_NOT_PASS',
                    'options' => array(
                        'class' => 'regm-sub-a auditing',
                    )
                ),
                'auditingFawu' => array(
                    'label' => Yii::t('enterprise', '审核'),
                    'url' => 'Yii::app()->createUrl("enterprise/auditingDzbFawu", array("id"=>$data->id))',
                    'visible' => '$data->progress==' . EnterpriseLog::PROCESS_CHECK_INFO_FAWU . ' AND Yii::app()->user->checkAccess("Enterprise.AuditingDzbFawu") && $data->el_status!=EnterpriseLog::STATUS_NOT_PASS',
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
        dialog = art.dialog.open($(this).attr('href'), {'id': 'progress', title: '审核进度', width: '50%', height: '80%', lock: true});
        return false;
    });
    $("a.service_id").on('click', function() {
        dialog = art.dialog.open($(this).attr('href'), {'id': 'service_id', title: '修改', width: '50%', height: '80%', lock: true});
        return false;
    });
      $("a.remarts").on('click', function() {
        dialog = art.dialog.open($(this).attr('href'), {'id': 'service_id', title: '添加备注', width: '50%', height: '80%', lock: true});
        return false;
    });
    //没有设定服务编号的，不让审核
    $(function() {
        $(".auditing").each(function() {
            if ($(this).parent().parent().find('.service_add').length > 0) {
                $(this).css('background', '#ccc');
                $(this).click(function() {
                    alert("请新增招商人员服务编号");
                    return false;
                });
            }
        });
    });
</script>
