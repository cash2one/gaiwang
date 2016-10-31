<?php

/* @var $this AccountFlowController */
/* @var $model AccountFlow */

$this->breadcrumbs = array(
    'POS差异流水对账' => array('admin'),
    '列表',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#accountFlow-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl('accountPosRecord/updateData'),
        'method' => 'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
        <tr>
            <th><?php echo $form->label($model, 'updateTime'); ?></th>
            <td>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'posStartTime',
                    'language' => 'zh_cn',
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'changeMonth' => true,
                    ),
                    'htmlOptions' => array(
                        'readonly' => 'readonly',
                        'class' => 'text-input-bj  least',
                    )
                ));
                ?> -
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'posEndTime',
                    'language' => 'zh_cn',
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'changeMonth' => true,
                    ),
                    'htmlOptions' => array(
                        'readonly' => 'readonly',
                        'class' => 'text-input-bj  least',
                    )
                ));
                ?>
            </td>
        </tr>
        </tbody>
    </table>
    <?php echo CHtml::submitButton('更新数据', array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>
<input class="reg-sub" name="yt1" style="display: none" value="查文件" onclick="lookfile()">
<?php

$this->widget('GridView', array(
    'id' => 'accountFlow-grid',
    'dataProvider' => $modelData,
    'filter' => $model,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'filter' => false,
            'name' => '加盟商名称',
            'value' => 'PosAudit::getMachineName($data->terminal_number,PosAudit::AGENT_TYPE)',
        ),
        array(
            'filter' => false,
            'name' => '盖机名称',
            'value' => 'PosAudit::getMachineName($data->terminal_number,PosAudit::MACHINE_TYPE)',
        ),
        array(
            'filter' => false,
            'name' => 'terminal_transaction_serial_number',
            'value' => '$data->terminal_transaction_serial_number'
        ),
        array(
            'filter' => false,
            'name' => 'transaction_time',
            'value' => '$data->transaction_datetime'
        ),
        array(
            'filter' => false,
            'name' => 'amount',
            'value' => '$data->amount',
        ),
        array(
            'htmlOptions' => array('class' => 'tc','id'=>'status'),
            'filter' => false,
            'name' => 'status',
            'value' => 'PosAudit::getProcessType($data->status)'
        ),
        array(
            'filter' => false,
            'name' => '操作',
            'type' => 'raw',
            'value' => 'PosAudit::createButton($data->id,$data->status)',
        ),
    ),
));
?>

<div style="display: none;" id="confirmFile">
    <style>
        .aui_buttons{
            text-align: center;
        }
        .buttonOff{
            width: 55px;
        }
    </style>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-come">
        <tbody>
            <?php if(!empty($files)):?>
                <?php foreach($files as $val):?>
            <tr class="confirmTR" style="background:#FFF;">
                <td><a href="<?php echo ATTR_DOMAIN . DS . 'posrecon' . DS . $val;?>"><?php echo $val;?></a></td>
            </tr>
                    <?php endforeach;?>
            <?php endif;?>
        </tbody>
    </table>
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
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-come">
        <tbody>
        <tr class="confirmTR" style="background:#FFF;">
            <td>
                <textarea id="remark" cols="70" rows="25"></textarea>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    function updateStatus(id){
        //发送ajax修改跟进状态
        var url = '<?php echo $this->createAbsoluteUrl('/accountPosRecord/updateStatus')?>';
        $.ajax({
            type: "post", async: false, dataType: "json", timeout: 5000,
            url: url,
            data:{YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>',id:id},
            success:function(data){
                if(data.success) {
                    if(status == 1)
                    art.dialog({icon: 'success', content: data.success, ok: true});
                    window.location.reload();//刷新当前页面.
                }
                else
                    art.dialog({icon: 'warning', content: data.error, ok:true});
            }
        });
    }
    function addRemark(id){
        //发送ajax验证
        var url = '<?php echo $this->createAbsoluteUrl('/accountPosRecord/addRemarks')?>';
        $.ajax({
            type: "post", async: false, dataType: "json", timeout: 5000,
            url: url,
            data:{YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>',id:id,remark:'data'},
            success:function(data){
                $("#remark").html(data);
            }
        });
        art.dialog({
            title: '<?php echo '添加备注内容' ?>',
            okVal: '<?php echo '确定' ?>',
            cancelVal: '<?php echo '取消' ?>',
            content: $("#confirmArea").html(),
            lock: true,
            cancel: true,
            ok: function () {
                //数据检验
                var remarkContent = $('#remark').val();
                if (remarkContent == '请输入备注内容' || remarkContent.length > 2000) {
                    art.dialog({
                        icon: 'warning',
                        content: '请注意备注内容不能为空或长度不能超过200',
                        lock: true,
                        ok: function () {
                            $('#remark').focus();
                        }
                    });
                    return false;
                }
                //发送ajax验证
                var url = '<?php echo $this->createAbsoluteUrl('/accountPosRecord/addRemarks') ?>';
                $.ajax({
                    type: "post", async: false, dataType: "json", timeout: 5000,
                    url: url,
                    data:{YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>',id:id,remark:remarkContent},
                    success:function(data){
                        if(data.success)
                            art.dialog({icon: 'success', content: data.success, ok:true});
                        else
                            art.dialog({icon: 'warning', content: data.error, ok:true});
                    }
                });

            }
        })
    }
    function lookfile(){
        art.dialog({
            title: '<?php echo '添加备注内容' ?>',
            okVal: '<?php echo '确定' ?>',
            cancelVal: '<?php echo '取消' ?>',
            content: $("#confirmFile").html(),
            lock: true,
            cancel: true,
            ok: function () {

            }
        })
    }
</script>
