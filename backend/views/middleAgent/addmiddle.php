<?php
// 能再来一次吗，我好想哭呀
$this->breadcrumbs = array(
    Yii::t('middleAgent','居间商列表')=>  array('middleAgent/admin'),
     Yii::t('middleAgent','添加居间商')
);
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'middleAgent-form',
//    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
//    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th">
                <?php echo Yii::t('middleAgent', '添加居间商'); ?>
            </th>
        </tr>
        <tr>
            <th><?php echo Yii::t('middleAgent','居间商会员编号'); ?></th>
            <td>
                <?php echo $form->textField($model,'gai_number',array('class'=>'text-input-bj middle','id'=>'middle-agent','autocomplete'=>'Off')); ?>
                <?php //echo CHtml::button('验证',array('class'=>'regm-sub','onclick'=>'location.href=\'' .Yii::app()->createUrl('middleAgent/checkMiddle',array('gai_number'=>'GW67066')).'\'' ));?>
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
        <tr>
            <th><?php echo Yii::t('middleAgent','手机号码'); ?></th>
            <td>
                <span id="mobile_store"></span>
            </td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center;padding-right: 358px;"><?php echo CHtml::submitButton(Yii::t('middleAgent','添加'),array('class'=>'regm-sub','disabled'=>'disabled')); ?></th>
        </tr>
    </tbody>
</table>
<script>
    $('#middle-agent').focus(function(){
        $('#Store_gai_number_em_').css('display','none');
    })
    function checkMiddle(){
        var value = $('#middle-agent').val();
        showmsg();
        if(value === '' || value === undefined || value === null) {
            $('#Store_gai_number_em_').css('display','inline').text('<?php echo Yii::t("middleAgent","居间商会员编号不能为空")?>');
            return;
        }
        $.ajax({
            url:'<?php echo $this->createUrl('middleAgent/checkMiddle');?>',
            data:{gai_number:value,'YII_CSRF_TOKEN':'<?php echo Yii::app()->request->csrfToken;?>'},
            type:'POST',
            dataType:'json',
            success:function(data){
                if(data.error){
                    $('#Store_gai_number_em_').css('display','inline').text(data.msg);
                    $('#middleAgent-form :submit').attr('disabled','disabled');   
                } else {
                    if(data.is_partner){
                        if(confirm('注意！该会员已被设为合作伙伴，若设为居间商，该会员在当合作伙伴期间所招入的企业会员，其对应推荐人也会改为绑定到原居间商。确认继续设为居间商？')){
                            showmsg(data.enterprise,data.mobile);                            
                        } else {
                            $('#Store_gai_number_em_').css('display','inline').text(data.msg);
                            $('#middleAgent-form :submit').attr('disabled','disabled');
                        }
                    } else {
                        showmsg(data.enterprise,data.mobile);
                    }

                }
            }
        })
    }
    function showmsg(enterprise,mobile){
        $('#enterprise_store').text(enterprise);
        $('#mobile_store').text(mobile);
        $('#Store_gai_number_em_').css('display','none').text();
        $('#middleAgent-form :submit').removeAttr('disabled');      
    }
</script>
<?php $this->endWidget(); ?>



