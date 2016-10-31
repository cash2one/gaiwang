<?php
$this->breadcrumbs = array('会员列表', '企业会员审核列表');
?>
<div class="border-info clearfix">
    <?php
    //查询表单提交时间
    Yii::app()->clientScript->registerScript('search', "
					$('#storemember-search-form').submit(function(){
						$('#storemember-grid').yiiGridView('update', {
							data: $(this).serialize()
						});
						return false;
					});
				");
    ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'storemember-search-form',
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <thead>
            <tr>
                <th><?php echo Yii::t('Auditing', '企业会员名称') ?>：</th>
                <td>
                    <?php echo $form->textField($model, 'apply_name', array('class' => 'text-input-bj  middle')) ?>
                </td>
            </tr>
        </thead>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <thead>
            <tr>
                <th><?php echo Yii::t('Auditing', '申请会员编号') ?>：</th>
                <td><?php echo $form->textField($model, 'gai_number', array('class' => 'text-input-bj  least')) ?></td>
            </tr>
        </thead>
    </table>
    <div class="c10"></div>
    <?php echo CHtml::submitButton(Yii::t('Public', '搜索'), array('class' => 'reg-sub', 'id' => 'btn_search')) ?>
    <?php $this->endWidget(); ?>
</div>
<?php echo Yii::app()->user->checkAccess('Member.Pass')?CHtml::button(Yii::t('auditing', '批量通过'), array('class' => 'regm-sub', 'id' => 'batchPass')):'' ?>
<?php echo Yii::app()->user->checkAccess('Member.NotPass')?CHtml::button(Yii::t('auditing', '批量不通过'), array('class' => 'regm-sub', 'id' => 'batchNotPass')):'' ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'storemember-grid',
    'dataProvider' => $model->searchStoreMember(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'selectableRows' => 2,
    'columns' => array(
        array(
            'header' => '全选',
            'htmlOptions' => array('width' => '5%'),
            'headerHtmlOptions' => array('width' => '5%'),
            'class' => 'zii.widgets.grid.CCheckBoxColumn',
            'checkBoxHtmlOptions' => array(
                'name' => 'id[]',
                'value' => '$data->id'
            )
        ),
        array(
            'name' => '企业会员名称',
            'value' => '$data->apply_name'
        ),
        array(
            'name' => 'apply_type',
            'value' => 'Auditing::getApplyType($data->apply_type)'
        ),
        array(
            'name' => '申请代理商的会员编号',
            'value' => '$data->author_name',
        ),
        array(
            'name' => '申请时间',
            'value' => 'date("Y-m-d H:i:s", $data->submit_time)',
        ),
        array(
			'class'=>'CButtonColumn',
			'header' => '操作',
			'headerHtmlOptions' => array('class' => 'tabletd tc'),
			'htmlOptions' => array('class' => 'tc'),
			'template' => '{view}',
			'buttons'=>array(
				'view' => array(
					'label' => '【'.Yii::t('auditing','查看').'】',
					'url' => 'Yii::app()->controller->createUrl("enterprise", array("id"=>$data->primaryKey,"type"=>$data->apply_type ==Auditing::APPLY_TYPE_COMPANY?"add":"update"))',
					'imageUrl' => false,
        			'visible' => "Yii::app()->user->checkAccess('Member.Enterprise')",
				),
			),
		),
    ),
));
?>

<script type="text/javascript">
    var BatchPassUrl = "<?php echo $this->createUrl('pass', array('id' => 1)) ?>";
    BatchPassUrl = BatchPassUrl.substr(0, BatchPassUrl.length - 1);
    var BatchNotPassUrl = "<?php echo $this->createUrl('notPass', array('id' => 1)) ?>";
    BatchNotPassUrl = BatchNotPassUrl.substr(0, BatchNotPassUrl.length - 1);
    $(function() {
        $("#batchPass").click(function() {
            var ids = [];
            $("#storemember-grid .select-on-check:checked").each(function() {
                ids.push($(this).val());
            });
            if (ids.length)
            {
                art.dialog({
                    icon: "question-red",
                    content: "<?php echo Yii::t('auditing', '确认批量通过吗？') ?>",
                    ok: function() {
                        var skipUrl = BatchPassUrl + ids;
                        window.location.href = skipUrl;
                    },
                    cancel: true
                });
            }
            else
            {
                art.dialog({
                    content: "<?php echo Yii::t('auditing', '请选择批量通过的申请！') ?>",
                    ok: true
                });
            }
        });
        $("#batchNotPass").click(function() {
            var ids = [];
            $("#storemember-grid .select-on-check:checked").each(function() {
                ids.push($(this).val());
            });
            if (ids.length)
            {
                var skipUrl = BatchNotPassUrl + ids;
                art.dialog({
                    icon: "question-red",
                    content: '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come"><tr><th colspan="2" align="center" class="title-th even" id="confimTitle"><?php echo Yii::t('auditing', '确认批量不通过吗？') ?></th></tr><tr id="trOpinion"><th class="odd"><?php echo Yii::t('auditing', '原因') ?>：</th><td class="odd"><textarea class="text-input-bj  text-area" style="width: 95%" rows="3" cols="50" id="txtOpinion"></textarea></td></tr></table>',
                    ok: function() {
                        skipUrl += "&txtOpinion=" + $("#txtOpinion").val();
                        window.location.href = skipUrl;
                    },
                    cancel: true
                });
            }
            else
            {
                art.dialog({
                    content: "<?php echo Yii::t('auditing', '请选择批量不通过的申请！') ?>",
                    ok: true
                });
            }
        });
    });
</script>