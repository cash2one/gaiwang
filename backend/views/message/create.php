<?php
/* @var $this MessageController */
/* @var $model Message */
/* @var $form CActiveForm */
$this->breadcrumbs = array(
    '会员管理' => array('member'),
    '群发站内信',
);
?>

<div class="tip attention">群发站内信功能会给所有的盖网通会员都发送站内信，群发后无法取消，请慎用！</div>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'message-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
    <tr>
        <th class="even"><?php echo $form->labelEx($model, 'receipt_time'); ?></th>
        <td class="even">
            <?php
            $this->widget('comext.timepicker.timepicker', array(
                'model' => $model,
                'name' => 'receipt_time',
                'id'=>'Message_receipt_time',
                'htmlOptions' => array(
                    'readonly' => 'readonly',
                    'class' => 'text-input-bj  least',
                )
            ));
            new timepicker
            ?>
            <?php echo $form->error($model, 'receipt_time'); ?>
        </td>
    </tr>

    <tr>
        <th width="14%" class="odd"><?php echo $form->labelEx($model, 'receiveId'); ?></th>
        <td class="odd">
            <?php echo $form->textArea($model, 'receiveId', array('class' => 'text-input-bj long')); ?>
            <span style="color: Red; margin-right:10px">手动输入的会员编号请以","隔开</span>
            <input type="button" value="选择" id="btnOK" onclick="btnSearchMem()" class="reg-sub">
            <br/>
            <input type="checkbox" value="1" id="select_all" name="select_all">选择全部会员
            <?php echo $form->error($model, 'receiveId'); ?>
        </td>
    </tr>
    <tr>
        <th class="even"><?php echo $form->labelEx($model, 'title'); ?></th>
        <td class="even">
            <?php echo $form->textField($model, 'title', array('class' => 'text-input-bj long')); ?>
            <span style="color: Red; margin-right:10px">标题最少要1个字，最多不能超过255个字</span>
            <?php echo $form->error($model, 'title'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd"><?php echo $form->labelEx($model, 'content'); ?></th>
        <td>
            <?php
            $this->widget('comext.wdueditor.WDueditor', array(
                'model' => $model,
                'attribute' => 'content',
            ));
            ?>
            <?php echo $form->error($model, 'content'); ?>

            <br/>
        </td>
    </tr>
    <tr>
        <th></th>
        <td class="even">
            <input id="btn_save" type="submit" value="提交" class="reg-sub">
        </td>
    </tr>
    </tbody>
</table>
<div id="AttaGIDs"></div>
<?php $this->endWidget(); ?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<script type="text/javascript">
    $("#btn_save").click(function () {
        $("#Message_content").val(editor_Message_content.getContent());
    });
    $("#select_all").click(function () {
        if ($(this).attr('checked') == 'checked') {
            $("#Message_receiveId").val('全部会员');
            $("#btnOK").attr('disabled', 'disabled');
        } else {
            $("#Message_receiveId").val('');
            $("#btnOK").attr('disabled', false);
        }
    });

    var dialog = null;
    var btnSearchMem = function () {
        var url = '<?php echo $this->createAbsoluteUrl('/message/getMember'); ?>';
        dialog = art.dialog.open(url, {
            'id': 'searchMembers',
            title: '选择接收会员',
            width: '640px',
            height: '600px',
            lock: true
        });
    };

    var selSearchMen = function (ids) {
        var douhao = '';
        if ($("#Message_receiveId").val() != '') douhao = ',';
        $("#Message_receiveId").val($("#Message_receiveId").val() + douhao + ids);
    };


    //输入框占位的问题
    setInterval(function () {
        $("#edui1").css('z-index', '1');
    }, 2000);


</script>