<?php $this->breadcrumbs = array(Yii::t('offlineRoleRelation', '代理列表') => array('admin'), Yii::t('offlineRoleRelation', '列表')); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#offline-role-relation-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
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
            content: '<?php echo Yii::t('offlineRoleController', '请输入会员编号'); ?>：<input type="text" id="agent_gai_number" class="text-input-bjleast">',
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
                                    $('#offline-role-relation-grid').yiiGridView('update');
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

    function aaa(){
		alert(236);
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
                                $('#offline-role-relation-grid').yiiGridView('update');
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
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'offline-role-relation-grid',
    'dataProvider' => $model->searchRole(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'name',
        array('name'=>'depth','value'=>'Region::getAgentLevel($data->depth)'),
        'agent_gai_number',
    	'agent_username',
    	'agent_mobile',
    	array(
    		'name' => Yii::t('home', '操作'),
    		'type' => 'raw',
    		'value' => 'OfflineRoleRelation::createButtons($data->id,$data->agent_gai_number)',
    	),
    ),
));
?>