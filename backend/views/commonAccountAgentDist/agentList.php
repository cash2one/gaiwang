<?php
$this->breadcrumbs = array(
    Yii::t('commonAccountAgentDist', '代理管理'),
    Yii::t('commonAccountAgentDist', '代理列表'),
);
Yii::app()->clientScript->registerScript('search', "
$('#common-account-agent-dist-form').submit(function(){
	$('#common-account-agent-dist-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
//	return false;
});
");
?>
<script type="text/javascript">
    function _error(error)
    {
        art.dialog({
            icon: 'error',
            content: error,
            ok: true
        });
    }
    function _success(suss)
    {
        art.dialog({
            icon: 'succeed',
            content: suss,
            ok: true
        });
    }
    function do_Edit(id)
    {
        art.dialog({
            icon: 'question-red',
            content: '<?php echo Yii::t('commonAccountAgentDist', '请输入会员编号'); ?>：<input type="text" id="agent_gai_number" class="text-input-bjleast">',
            ok: function() {
                var cur_agent_gai_number = $("#agent_gai_number").val();
                if (cur_agent_gai_number)
                {
                    jQuery.ajax({
                        type: "get", async: false, dataType: "json", timeout: 5000,
                        url: "<?php echo $this->createUrl('ajaxUpdateAgent') ?>",
                        data: "gai_number=" + cur_agent_gai_number + "&id=" + id,
                        error: function(request, status, error) {
                            alert(request.responseText);
                        },
                        success: function(data) {
                            if (data) {
                                if (data.error == 0)
                                {
                                    $('#common-account-agent-dist-grid').yiiGridView('update');
                                    _success(data.content);
                                }
                                else
                                {
                                    _error(data.content);
                                }
                            } else {
                                alert('更新失败');
                            }
                        }
                    });
                }
                else
                {
                    _error('<?php echo Yii::t('commonAccountAgentDist', '找不到会员'); ?>');
                }
            },
            cancel: true
        });
    }


    function do_Remove(id) {
        art.dialog({
            icon: 'question-red',
            content: '确定要移除代理吗?',
            ok: function() {

                jQuery.ajax({
                    type: "get", async: false, dataType: "json", timeout: 5000,
                    url: "<?php echo $this->createUrl('removeAgent') ?>",
                    data: "id=" + id,
                    error: function(request, status, error) {
                        alert(request.responseText);
                    },
                    success: function(data) {
                        if (data) {
                            if (data.error == 0)
                            {
                                $('#common-account-agent-dist-grid').yiiGridView('update');
                                _success(data.content);
                            }
                            else
                            {
                                _error(data.content);
                            }
                        } else {
                            _error('没有绑定代理数据');
                        }

                    }
                });

            },
            cancel: true
        });
    }


</script>
<div class="border-info clearfix">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'common-account-agent-dist-form',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <td>
                <?php echo $form->label($model, 'agent_gai_number'); ?>：
            </td>
            <td>
                <?php echo $form->textField($model, 'agent_gai_number', array('class' => 'text-input-bj  least')); ?>
            </td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <td>
                <?php echo Yii::t('region', '地址名称') ?>：
            </td>
            <td>
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  least')); ?>
            </td>
        </tr>
    </table>
    <?php echo CHtml::submitButton(Yii::t('home', '搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'common-account-agent-dist-grid',
    'dataProvider' => $model->searchAgent(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
//        'name',
        array(
            'name' => 'name',
            'value' => 'Region::actionGetAreaName($data->parent_id,$data->depth,$data->name)'
        ),
        array(
            'name' => Yii::t('region', '地区级别'),
            'value' => 'Region::getAgentLevel($data->depth)'
        ),
        array(
            'name' => 'agent_gai_number',
            'value' => '$data->agent_gai_number'
        ),
        array(
            'name' => 'agent_username',
            'value' => '$data->agent_username'
        ),
        array(
            'name' => 'agent_mobile',
            'value' => '$data->agent_mobile'
        ),
        array(
            'name' => Yii::t('home', '操作'),
            'type' => 'raw',
            'value' => 'CommonAccountAgentDist::createButtons($data->id)',
        ),
    ),
));
?>

<?php 
	$this->renderPartial('/layouts/_export', array(
	    'model' => $model,'exportPage' => $exportPage,'totalCount'=>$totalCount,
	));
?>