<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'franchiseeContract-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<style type="text/css">
.tr-label{
    height:50px;
}
.label-ex{
    width:20%;
}
</style>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come" >
    <tbody>
        <tr> <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('franchisee', '添加补充协议用户'); ?></th></tr>
        
        <tr class='.tr-label'>
            <th class='label-ex'>
                <label for="FranchiseeContract_member_id" class="required">盖网编号<span class="required">*</span></label>
            </th>
            <td>
                <?php echo $form->hiddenField($model, 'member_id', array('value' => $model->member_id)); ?>
                <input name="FranchiseeContract[gai_number]" class="text-input-bj middle" type="text" value="<?php echo $model->gai_number ? $model->gai_number : '' ;?>" id="gai_number">
                <?php echo CHtml::button(Yii::t('franchisee', '验证'), array('class' => 'reg-sub', 'id' => 'checkGwNumber')); ?>
                <?php echo $form->error($model, 'member_id'); ?>
            </td>
        </tr>  

        <tr class='.tr-label'>
            <th class='label-ex'><?php echo $form->labelEx($model, 'member_name'); ?></th>
            <td>
                <?php echo $form->textField($model, 'member_name', array('class' => 'text-input-bj  middle','readOnly'=>true)); ?>
                <?php echo $form->error($model, 'member_name'); ?>
            </td>
        </tr>

        <tr class='.tr-label'>
            <th class="odd label-ex"><label class="required"><?php echo Yii::t('franchiseecontract', '合同版本'); ?> <span class="required">*</span></label></th>
            <td>
               <div style="display:block;width:300px;float:left;margin-left:400px;">
                    <?php echo $form->error($model, 'contract_type'); ?> 
                    <?php echo $form->error($model, 'contract_version'); ?>
                </div>
                 <?php echo $form->hiddenField($model, 'contract_id', array('value' => $model->contract_id)); ?>
                <?php
                echo $form->dropDownList($model, 'contract_type', Contract::showType(), array(
                    'prompt' => Yii::t('franchiseecontract', '选择类型'),
                    'class' => 'text-input-bj',
                    'ajax' => array(
                        'type' => 'Get',
                        'url' => $this->createUrl('/franchisee-contract/get-contract-version'),
                        'dataType' => 'json',
                        'data' => array(
                            'type' => 'js:this.value',
                            // 'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => 'function(data) {
                            $("#FranchiseeContract_contract_version").html(data.dropDownVersions);
                        }',
                )));
                ?>
                <?php
                echo $form->dropDownList($model, 'contract_version', array(), array(
                    'prompt' => Yii::t('franchiseecontract', '选择版本'),
                    'class' => 'text-input-bj',
                ));
                ?> 
            </td>
        </tr>

        <tr class='.tr-label'>
            <th class='label-ex'><?php echo $form->labelEx($model, 'number'); ?></th>
            <td>
                <?php echo $form->textField($model, 'number', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'number'); ?>
            </td>
        </tr>

        <tr class='.tr-label'>
            <th class='label-ex'><?php echo $form->labelEx($model, 'protocol_no'); ?></th>
            <td>
                <?php echo $form->textField($model, 'protocol_no', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'protocol_no'); ?>
            </td>
        </tr>

        <tr class='.tr-label'>
            <th class='label-ex'><?php echo $form->labelEx($model, 'a_name'); ?></th>
            <td>
                <?php echo $form->textField($model, 'a_name', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'a_name'); ?>
            </td>
        </tr>
        <tr class=".tr-label a_address" style="display: table-row;">
            <th class="label-ex odd"><label for="FranchiseeContract_a_address" class="required">甲方地址 <span class="required">*</span></label></th>
            <td class="odd">
                <input class="text-input-bj  middle" name="FranchiseeContract[a_address]" id="FranchiseeContract_a_address" type="text" maxlength="255" value="<?php echo $model->a_address; ?>">               
                <div class="errorMessage" id="FranchiseeContract_a_address_em_" style="display:none">甲方地址不能为空</div>           
            </td>
        </tr>
         <tr  class='.tr-label'>
            <th class='label-ex'><?php echo $form->labelEx($model, 'b_name'); ?></th>
            <td>
                <?php echo $form->textField($model, 'b_name', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'b_name'); ?>
            </td>
        </tr>
        <tr class='.tr-label'>
            <th class='label-ex'><?php echo $form->labelEx($model, 'b_address'); ?></th>
            <td>
                <?php echo $form->textField($model, 'b_address', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'b_address'); ?>
            </td>
        </tr>
        <tr class='.tr-label'>
            <th class='label-ex'><?php echo $form->labelEx($model, 'original_contract_time'); ?></th>
            <td>
                <?php
                    $this->widget('comext.timepicker.timepicker', array(
                        'model' => $model,
                        'name' => 'original_contract_time',
                        'select'=>'date',
                    ));
                ?>
                <?php echo $form->error($model, 'original_contract_time'); ?>
            </td>
        </tr>
   
        <tr class='.tr-label'>
            <th class='label-ex'></th>
            <td><?php 
                $butName = $model->isNewRecord ? '创建' : '编辑';
                $id = $model->isNewRecord ? 'reg_sub' : 'confirm_btn';
                echo CHtml::submitButton(Yii::t('franchiseecontract', $butName), array('class' => 'reg-sub','id'=>$id)); 
            ?></td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>

<script type="text/javascript">
jQuery(function($) {
    $('#confirm_btn').click(function() {
        // if(!confirm('确定更改当前编辑的内容？')){
        //     return false;
        // }
        if($('#FranchiseeContract_contract_type').val() == 2 && !$('#FranchiseeContract_a_address').val()){
            $('#FranchiseeContract_a_address_em_').attr('style','');
            return false;
        }
    });

    $('#FranchiseeContract_a_address').blur(function(){
        if(!$(this).val())
            $('#FranchiseeContract_a_address_em_').attr('style','');
    });

    //设置contract id
    $('#FranchiseeContract_contract_version').change(function() {
        var contractId = $(this).find('option:selected').attr('data-contract-id');
        $("#FranchiseeContract_contract_id").val(contractId);
    });
    $('#FranchiseeContract_contract_type').change(function(){
        $('#FranchiseeContract_contract_id').val(''); 
        if($(this).val() == 1){
            $('.a_address').hide();
            $('#FranchiseeContract_a_address').attr('disabled',true);
            $('#FranchiseeContract_a_address_em_').attr('style','display:none');
        }else{
            $('.a_address').show(); 
            $('#FranchiseeContract_a_address').removeAttr('disabled');
        }
    });

    var contract_type = <?php echo $model->contract_type ? $model->contract_type : 0; ?>;
    var values = $('#FranchiseeContract_contract_id').val();
    var selectedVersion = <?php echo $model->contract_version ? $model->contract_version : 0; ?>;
    if(values || contract_type){
        initVersion(selectedVersion);
        $('#FranchiseeContract_contract_id').val(values);
        if($('#FranchiseeContract_contract_type').val() == 1){
            $('.a_address').hide();
            $('#FranchiseeContract_a_address').attr('disabled',true);
        }else{
            $('.a_address').show(); 
            $('#FranchiseeContract_a_address').removeAttr('disabled');
        }
    } 

    function initVersion(selectedVersion){
        var type =  $('#FranchiseeContract_contract_type').val();
        $.ajax({
            url :'/?r=franchisee-contract/get-contract-version',
            type:'get',
            data:{
                    type:type
                },  
            success:function(data){
                $('#FranchiseeContract_contract_version').html(data.dropDownVersions);
                $('#FranchiseeContract_contract_version option').each(function(){
                    if($(this).val()==selectedVersion){
                        $(this).attr('selected',true);
                    }
                });
            },
            error : function() {
                alert("异常！");    
            },    
            dataType:'json'
            });
    }

    //验证GW号
    $("#checkGwNumber").click(function(){
        var gwNumber =  $("#gai_number").val();
        var tipMsg = " 盖网编号不存在，请重新输入";
        $.ajax({
            url :'/?r=franchisee-contract/check-gw-number',
            type:'get',
            data:{
                    gwNumber:gwNumber
                },  
            success:function(data){
                if(data.status == 200){
                    $('#FranchiseeContract_member_name').val(data.data.username);
                    $('#FranchiseeContract_member_id').val(data.data.id);
                }else{
                    $('#FranchiseeContract_member_name').val('');
                    $('#FranchiseeContract_member_id').val('');
                }
                $('#FranchiseeContract_member_id').blur();
            },
            error : function() {
                alert("异常！");    
            },    
            dataType:'json'
        });
    });
   
});

</script>

