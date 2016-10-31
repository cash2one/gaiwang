<?php
$this->breadcrumbs = array(
    '加盟商管理',
    '加盟商对账撤销申请管理',
);
?>
<?php
$this->renderPartial('_searchapply', array(
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
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '撤销状态'); ?></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '盖网通折扣'); ?></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '会员折扣'); ?></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '账单时间'); ?></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '消费金额'); ?></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '分配金额'); ?></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '应付金额'); ?></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '申请人'); ?></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '申请时间'); ?></th>
            <th><?php echo Yii::t('franchiseeConsumptionRecord', '审核记录'); ?></th>
        </tr>
        <?php
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $model->search(),
            'itemView' => '_applyview',
            'template' => '{items}',
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
    <?php $this->renderPartial('examineInfo'); ?>
    
</div>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl('franchiseeConsumptionRecord/pass'),
    'method' => 'post',
    'id' => 'franchisee-pass-form',
        ));
?>
<?php echo CHtml::hiddenField('pass_ids') ?>
<?php $this->endWidget(); ?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl('franchiseeConsumptionRecord/fail'),
    'method' => 'post',
    'id' => 'franchisee-fail-form',
        ));
?>
<?php echo CHtml::hiddenField('fail_ids') ?>
<?php $this->endWidget(); ?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl('franchiseeConsumptionRecord/Auditing'),
    'method' => 'post',
    'id' => 'franchisee-auditing-form',
        ));
?>
<?php echo CHtml::hiddenField('auditing_ids') ?>
<?php $this->endWidget(); ?>
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
        $("#pass").click(function() {
            var ids = [];
            var frcids = [];
            $(".cbbox:checked").each(function() {
                ids.push($(this).val());
            });
            if (ids.length>1){
            	art.dialog({
                    content: '一次只能撤销一条记录!',
                    ok: true
                });
            }else if(ids.length==1){
            	art.dialog({
                    content: '是否通过选中记录?',
                    ok: function(){
	                   	 $("#pass_ids").val(ids);
	                     $("#franchisee-pass-form").submit();
                    },
                    cancel:true
                });
            }else{
                art.dialog({
                    content: '请通过选择的撤销记录!',
                    ok: true
                });
            }
        });
        $("#fail").click(function(){
        	var ids = [];
            $(".cbbox:checked").each(function() {
                ids.push($(this).val());
            });
            if (ids.length>1){
            	art.dialog({
                    content: '一次只能拒绝一条撤销记录!',
                    ok: true
                });
            }else if(ids.length==1){
            	art.dialog({
                    content: '是否拒绝选中记录?',
                    ok: function(){
		                $("#fail_ids").val(ids);
		                $("#franchisee-fail-form").submit();
                    },
                    cancel:true
                });
            }
            else
            {
                art.dialog({
                    content: '请拒绝选择的撤销记录!',
                    ok: true
                });
            }
        });
          $("#auditing").click(function() {
            var ids = [];
            var frcids = [];
            $(".cbbox:checked").each(function() {
                ids.push($(this).val());
            });
            if (ids.length>1){
            	art.dialog({
                    content: '一次只能审核一条记录!',
                    ok: true
                });
            }else if(ids.length==1){
            	art.dialog({
                    content: '是否审核选中申请记录?',
                    ok: function(){
	                   	 $("#auditing_ids").val(ids);
	                     $("#franchisee-auditing-form").submit();
                    },
                    cancel:true,
                 
                });
            }else{
                art.dialog({
                    content: '请审核选择的申请记录!',
                    ok: true
                });
            }           
        });
    });
//    function ajaxUpdateList(id, data)
//    {
//        jQuery.ajax({
//            type: "GET", async: false, cache: false, timeout: 10000, dataType: "html", processData: true,
//            url: "<?php echo MANAGE_DOMAIN ?>",
//            data: data,
//            error: function(XMLHttpRequest, textStatus, errorThrown) {
//                alert(errorThrown);
//            },
//            success: function(data)
//            {
//                $("#franchisee-consumption-record-grid").html($(data).find("#franchisee-consumption-record-grid").html());
//            }
//        });
//    }
</script>