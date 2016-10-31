<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<?php
/* @var $this OfflineSignStoreExtendController */
/* @var $model OfflineSignStoreExtend */

$this->breadcrumbs=array(
    '臻致生活'=>array('admin'),
    '列表',
);

$this->menu=array(
    array('label'=>'List AppTopicLife', 'url'=>array('index')),
    array('label'=>'Create AppTopicLife', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#appTopicLife-search-form').submit(function(){
	$('#app-topic-life').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="com-box">
    <div class="clearfix search-form">
        <?php $this->renderPartial('_search',array('model'=>$model)); ?>
    </div>
    <div class="c10"></div>
    <td><?php echo CHtml::link(Yii::t('AppTopicLife','添加专题'),array('AppTopicLife/create'),array('id'=>'xxxxx','class'=>'btn-sign'))?></td>
    <div class="grid-view" id="article-grid">
        <?php
        $this->widget('application.modules.agent.widgets.grid.GridView',array(
            'id'=>'app-topic-life',
            'itemsCssClass' => 'tab-reg',
            'dataProvider' => $model->search(),
            'pagerCssClass' => 'line pagebox',
            'afterAjaxUpdate' => 'function() { useStatus(); }',
            'template' => '{items}{pager}',
            'columns' => array(
                array(
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '10%'),
                    'name' => 'title',
                    'value' => '$data->title',
                ),
                array(
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '15%'),
                    'name' => 'rele_time',
                    'value' => 'AppTopicLife::getReleTime($data->rele_time)',
                ),
                array(
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '15%'),
                    'name' => 'rele_status',
                    'value' => 'AppTopicLife::getReleStatus($data->rele_status)',
                ),
                array(
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '15%'),
                    'name' => 'audit_status',
                    'value' => 'AppTopicLife::getAuditStatus($data->audit_status)',
                ),
                array(
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '9%'),
                    'name' => 'disable',
                    'value' => 'AppTopicLife::getDisable($data->disable)',
                ),
                array(
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '20%'),
                    'name' => '回复',
                    'type' => 'raw',
                    'value' => 'AppTopicLife::getLookProblem($data->audit_status,$data->id)',
                ),
                array(
                    'name' => Yii::t('AppTopicLife', '操作'),
                    'type' => 'raw',
                    'value' => 'AppTopicLife::createButtons($data->id)',
                )
            )
        ));
        ?>
    </div>
</div>
<div style="display: none;" id="confirmArea">
    <style>
        .aui_buttons{
            text-align: center;
        }
        .buttonOff{
            width: 55px;
        }
    </style>
    <div id="remark" class="border-info clearfix search-form">

    </div>
</div>
<script>
    function deleteLife(life_id){
        if(confirm("确定要删除？")){
            //发送ajax验证
            var url = '<?php echo $this->createAbsoluteUrl('/agent/appTopicLife/Delete')?>';
            $.ajax({
                type: "post", async: false, dataType: "json", timeout: 5000,
                url: url,
                data:{YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>',id:life_id},
                success:function(data){
                    if(data.success){
                        alert(data.success);
                    }else{
                        alert(data.error);
                    }
                    window.location.reload();
                }
            });
        }
    }
    function useStatus(life_id){
        //发送ajax验证
        var url = '<?php echo $this->createAbsoluteUrl('/agent/appTopicLife/UseStatus')?>';
        $.ajax({
            type: "post", async: false, dataType: "json", timeout: 5000,
            url: url,
            data:{YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>',id:life_id},
            success:function(data){
                if(data.success){
                    alert(data.success);
                }else{
                    alert(data.error);
                }
                window.location.reload();
            }
        });
    }
    function canNotPass(life_id){
        //发送ajax验证
        var url = '<?php echo $this->createAbsoluteUrl('/agent/appTopicLife/canNotPass')?>';
        $.ajax({
            type: "post", async: false, dataType: "json", timeout: 5000,
            url: url,
            data:{YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>',id:life_id},
            success:function(data){
                $("#remark").html(data);
            }
        });
        art.dialog({
            title: '<?php echo '查看不通过原因' ?>',
            okVal: '<?php echo '确定' ?>',
            content: $("#confirmArea").html(),
            lock: true,
            cancel: true,
            ok: function () {
            }
        })
    }
</script>

