<?php
/* @var $this FranchiseeConsumptionRecordController */
/* @var $model FranchiseeConsumptionRecord */

$this->breadcrumbs = array(
    '加盟商管理',
    '加盟商对账管理',
);

Yii::app()->clientScript->registerScript('search', "
$('#franchisee-consumption-record-form').submit(function(){
//	var ajaxRequest = $(this).serialize();
//    ajaxUpdateList('franchisee-consumption-record-grid', ajaxRequest);
//	return false;
});
");
?>
<?php
$this->renderPartial('_search', array(
    'model' => $model,
));
?>
<div id="franchisee-consumption-record-grid">
    <table width="100%" border="0" cellspacing="0" cellpadding="0"
           class="tab-reg2">
        <tr class="tab-reg-title">
            <th style="width: 60px"><label><input type="checkbox" id="cbxAll">全部</label></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '加盟商名称（编号）'); ?></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '消费会员'); ?></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '对账状态'); ?></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '盖网通折扣'); ?></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '会员折扣'); ?></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '账单时间'); ?></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '消费金额'); ?></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '分配金额'); ?></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '应付金额'); ?></th>
        </tr>
        <?php
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $model->search(),
            'itemView' => '_view',
            'template' => "{items}",
        ));
        ?>
    </table>
    
    

    <div class="pager">
        <?php
        //分页
        $this->widget('CLinkPager', array(
            'pages' => $page,
        	'cssFile' => false,
        ))
        ?>  
    </div>

    
</div>



<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl('franchiseeConsumptionRecord/confirm'),
    'method' => 'get',
    'id' => 'franchisee-batch_reconciliation-form',
        ));
?>
<?php echo CHtml::hiddenField('batchReconciliation_ids') ?>
<?php $this->endWidget(); ?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl('franchiseeConsumptionRecord/reBack'),
    'method' => 'post',
    'id' => 'franchisee-reback-form',
        ));
?>
<?php echo CHtml::hiddenField('reback_ids') ?>
<?php $this->endWidget(); ?>



<?php
	$this->renderPartial('/layouts/_export', array(
	    'model' => $model,'exportPage' => $exportPage,'totalCount'=>$totalCount,
	));
?>



<script type="text/javascript">
    $(function() {
        $("#cbxAll").live('change', function() {
            if ($(this).attr("checked"))
            {
                $(".cbbox").attr("checked", "checked");
            }
            else
            {
                $(".cbbox").removeAttr("checked");
            }
        });
        $("#batchReconciliation").click(function() {
            var ids = [];
            $(".cbbox:checked").each(function() {
                ids.push($(this).val());
            });
            if (ids.length)
            {
                $("#batchReconciliation_ids").val(ids);
                $("#franchisee-batch_reconciliation-form").submit();
            }
            else
            {
                art.dialog({
                    content: '请选择需要对账的记录！',
                    ok: true
                });
            }
        });
        $("#reback").click(function(){
        	var ids = [];
            $(".cbbox:checked").each(function() {
                ids.push($(this).val());
            });
            if (ids.length>1){
            	art.dialog({
                    content: '一次只能撤销一个!',
                    ok:true
                });
            }else if(ids.length==1){
            	art.dialog({
                    content: '是否对选中记录进行撤销！',
                    ok: function(){
		                $("#reback_ids").val(ids);
		                $("#franchisee-reback-form").submit();
                    },
                    cancel:true
                });
            }
            else
            {
                art.dialog({
                    content: '请选择需要撤销的记录！',
                    ok: true
                });
            }
        });
    });
    function ajaxUpdateList(id, data)
    {
        jQuery.ajax({
            type: "GET", async: false, cache: false, timeout: 10000, dataType: "html", processData: true,
            url: "<?php echo MANAGE_DOMAIN ?>",
            data: data,
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            },
            success: function(data)
            {
                $("#franchisee-consumption-record-grid").html($(data).find("#franchisee-consumption-record-grid").html());
            }
        });
    }
</script>