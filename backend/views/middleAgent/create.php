<?php
$name = $this->action->id=='create' ? '添加居间商':'添加直招商户';
$this->breadcrumbs = array(
    Yii::t('middleAgent','居间商列表')=>  array('middleAgent/admin'),
    $name
);
/** @var $model MiddleAgent  */
/** @var CActiveForm $form */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'middleAgent-form',
//    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
    <tr>
        <th colspan="2" style="text-align: center" class="title-th">
            <?php echo $name; ?>
        </th>
    </tr>
    <?php if(isset($model->parent)): ?>
    <tr>
        <th><?php echo Yii::t('middleAgent','所属上级'); ?></th>
        <td>
            <?php echo $model->parent->member->username ?>
            (<?php echo $model->parent->member->gai_number ?>)
        </td>
    </tr>
    <?php endif; ?>
    <?php if($this->action->id=='createPartner'): ?>
        <tr>
            <th><?php echo Yii::t('middleAgent','所属上级'); ?></th>
            <td>
                <?php echo $model->member->username ?>
                (<?php echo $model->member->gai_number ?>)
            </td>
        </tr>
    <?php endif; ?>
    <tr>
        <th><?php echo Yii::t('middleAgent','居间商会员编号'); ?></th>
        <td>
            <?php echo $form->textField($model,'gai_number',array('class'=>'text-input-bj middle','id'=>'middle-agent','autocomplete'=>'Off')); ?>
            <?php echo CHtml::button('验证',array('class'=>'regm-sub','onclick'=>'checkMiddle()'));?>
            <?php echo $form->error($model, 'gai_number'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo Yii::t('middleAgent','会员名称'); ?></th>
        <td>
            <span id="enterprise_store"></span>
        </td>
    </tr>
    <?php if($this->action->id!='createPartner'): ?>
    <tr>
        <th><?php echo Yii::t('middleAgent','居间商级别'); ?></th>
        <td>
            <?php echo $form->dropDownList($model,'level',MiddleAgent::getLevel(),array('class'=>'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'level'); ?>
        </td>
    </tr>
    <?php endif; ?>
    <tr>
        <th><?php echo Yii::t('middleAgent','手机号码'); ?></th>
        <td>
            <span id="mobile_store"></span>
            <?php echo $form->hiddenField($model,'store_id') ?>
            <?php echo $form->hiddenField($model,'member_id') ?>
        </td>
    </tr>
    <tr>
        <th colspan="2" style="text-align: center;padding-right: 358px;"><?php echo CHtml::submitButton(Yii::t('middleAgent','添加'),array('class'=>'regm-sub','disabled'=>'disabled')); ?></th>
    </tr>
    </tbody>
</table>
<script>
    $('#middle-agent').focus(function(){
        $('#MiddleAgent_gai_number_em_').css('display','none');
    });
    function checkMiddle(){
        var value = $('#middle-agent').val();
        showmsg();
        if(value === '' || value === undefined || value === null) {
            $('#MiddleAgent_gai_number_em_').css('display','inline').text('<?php echo Yii::t("middleAgent","居间商会员编号不能为空")?>');
            return;
        }
        $.ajax({
            url:'<?php echo $this->createUrl('middleAgent/check');?>',
            data:{gai_number:value,'YII_CSRF_TOKEN':'<?php echo Yii::app()->request->csrfToken;?>'},
            type:'POST',
            dataType:'json',
            success:function(data){
                if(data.error){
                    $('#MiddleAgent_gai_number_em_').css('display','inline').text(data.msg);
                    $('#middleAgent-form :submit').attr('disabled','disabled');
                } else {
                    $("#MiddleAgent_store_id").val(data.store_id);
                    $("#MiddleAgent_member_id").val(data.member_id);
                    showmsg(data.username,data.mobile);
                }
            }
        })
    }
    function showmsg(username,mobile){
        $('#enterprise_store').text(username);
        $('#mobile_store').text(mobile);
        $('#MiddleAgent_gai_number_em_').css('display','none').text();
        $('#middleAgent-form :submit').removeAttr('disabled');
    }
</script>
<?php $this->endWidget(); ?>