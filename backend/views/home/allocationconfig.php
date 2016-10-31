<?php
//积分分配配置 视图
/* @var $form  CActiveForm */
/* @var $model AllocationConfigForm */
?>
<style>
    th.title-th  {text-align: center;}
</style>
<?php $form = $this->beginWidget('CActiveForm', $formConfig); ?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
        <tr>
            <th colspan="2"  class="title-th even">
                <?php echo Yii::t('home', '线上商城分配'); ?>
            </th>
        </tr>
        <tr>
            <th style="width: 150px">
                <?php echo $form->labelEx($model, 'onConsume'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'onConsume', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'onConsume'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'onRef'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'onRef', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'onRef'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'onAgent'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'onAgent', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'onAgent'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'onGai'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'onGai', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'onGai'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'onFlexible'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'onFlexible', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'onFlexible'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'onWeightAverage'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'onWeightAverage', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'onWeightAverage'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'onWeightAverage2'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'onWeightAverage2', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'onWeightAverage2'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'onWeightAverage1'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'onWeightAverage1', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'onWeightAverage1'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'middle_agent'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'middle_agent', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'middle_agent'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'middle_agent2'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'middle_agent2', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'middle_agent2'); ?>(默认跨级居间商推荐分配等于三级直招商户)
            </td>
        </tr>
        <tr>
            <th colspan="2"  class="title-th even">
                <?php echo Yii::t('home', '线上酒店分配'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'hotelOnConsume'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'hotelOnConsume', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'hotelOnConsume'); ?>
            </td>
        </tr>

        <tr>
            <th>
                <?php echo $form->labelEx($model, 'hotelOnRef'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'hotelOnRef', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'hotelOnRef'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'hotelOnBusinessTravel'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'hotelOnBusinessTravel', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'hotelOnBusinessTravel'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'hotelOnGaiIncome'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'hotelOnGaiIncome', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'hotelOnGaiIncome'); ?>
            </td>
        </tr>
        <!-- 新版酒店分配 -->
        <tr>
            <th colspan="2"  class="title-th even">
                <?php echo Yii::t('home', '新版酒店分配'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'hotelOnBusinessTravelAccount'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'hotelOnBusinessTravelAccount', array('class' => 'text-input-bj  least', 'readonly' => 'readonly', 'style' => 'width:200px; background:#eee;')); ?>
                <?php echo $form->hiddenField($model, 'hotelOnBusinessTravelMemberId'); ?>
                <?php echo $form->error($model, 'hotelOnBusinessTravelAccount'); ?>
                <?php echo CHtml::button('绑定商旅收益账户', array('class' => 'reg-sub-01', 'readonly' => true, 'id' => 'setEnterprise')); ?>
                <?php echo $form->error($model, 'hotelOnBusinessTravelMemberId'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'hotelService'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'hotelService', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'hotelService'); ?>
            </td>
        </tr>

        <!-- 大药房分配 -->
        <tr>
            <th colspan="2"  class="title-th even">
                <?php echo Yii::t('home', '大药房分配'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'drugStoreOnBusinessTravelAccount'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'drugStoreOnBusinessTravelAccount', array('class' => 'text-input-bj  least', 'readonly' => 'readonly', 'style' => 'width:200px; background:#eee;')); ?>
                <?php echo $form->hiddenField($model, 'drugStoreOnBusinessTravelMemberId'); ?>
                <?php echo $form->error($model, 'drugStoreOnBusinessTravelAccount'); ?>
                <?php echo CHtml::button('绑定大药房收益账户', array('class' => 'reg-sub-01', 'readonly' => true, 'id' => 'setEnterprise3')); ?>
                <?php echo $form->error($model, 'drugStoreOnBusinessTravelMemberId'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'drugStoreService'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'drugStoreService', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'drugStoreService'); ?>
            </td>
        </tr>

        <!-- 便民服务配置 -->
         <tr>
            <th colspan="2"  class="title-th even">
                <?php echo Yii::t('home', '便民分配'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'eptokOnBusinessTravelAccount'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'eptokOnBusinessTravelAccount',
                     array('class' => 'text-input-bj  least', 'readonly' => 'readonly', 'style' => 'width:200px; background:#eee;')); ?>
                <?php echo $form->hiddenField($model, 'eptokOnBusinessTravelMemberId'); ?>
                <?php echo $form->error($model, 'eptokOnBusinessTravelAccount'); ?>
                <?php echo CHtml::button('绑定便民服务收益账户', array('class' => 'reg-sub-01', 'readonly' => true, 'id' => 'setEnterprise2')); ?>
                <?php echo $form->error($model, 'eptokOnBusinessTravelMemberId'); ?>
            </td>
        </tr>


        <tr>
            <th colspan="2"  class="title-th even">
                <?php echo Yii::t('home', '线下盖网通收益'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'gaiIncome'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'gaiIncome', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'gaiIncome'); ?>
            </td>
        </tr>
        <tr>
            <th colspan="2"   class="title-th even">
                <?php echo Yii::t('home', '线下分配(除去盖网通收益)'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offConsume'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offConsume', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offConsume'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offRef'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offRef', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offRef'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offAgent'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offAgent', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offAgent'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offGai'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offGai', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offGai'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offFlexible'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offFlexible', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offFlexible'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offWeightAverage'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offWeightAverage', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offWeightAverage'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offRefMachine'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offRefMachine', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offRefMachine'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offMachineIncome'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offMachineIncome', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offMachineIncome'); ?>
            </td>
        </tr>
        
        
        
        
        
        
        
         <tr>
            <th colspan="2"   class="title-th even">
                <?php echo Yii::t('home', '线下分配NEW(除去盖网通收益)'); ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offConsumeNew'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offConsumeNew', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offConsumeNew'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offRefNew'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offRefNew', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offRefNew'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offRegion'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offRegion', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offRegion'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offProvince'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offProvince', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offProvince'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offCity'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offCity', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offCity'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offDistrict'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offDistrict', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offDistrict'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offMachineLine'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offMachineLine', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offMachineLine'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offMachineOperation'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offMachineOperation', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offMachineOperation'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'gateMachineRef'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'gateMachineRef', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'gateMachineRef'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offManeuver'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offManeuver', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offManeuver'); ?>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <?php echo CHtml::submitButton(Yii::t('home', '保存'), array('class' => 'reg-sub')) ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
    <script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<?php
Yii::app()->clientScript->registerScript('', "
var isHotel = false;
var isEptok = false;
var isStore = false;
var dialog = null;
var doClose = function() {
    if (null != dialog) {
        dialog.close();
    }
};
jQuery(function($) {
    $('#setEnterprise').click(function() {
        isHotel = true;
        isEptok = false;
        isStore = false;
        dialog = art.dialog.open('" . $this->createAbsoluteUrl('/enterprise/getEnterprise') . "', { 'id': 'selectmemberinfo', title: '搜索会员', width: '800px', height: '620px', lock: true });
    })
    $('#setEnterprise2').click(function() {
        isEptok = true;
        isHotel = false;
        isStore = false;
        dialog = art.dialog.open('" . $this->createAbsoluteUrl('/enterprise/getEnterprise') . "', { 'id': 'selectmemberinfo', title: '搜索会员', width: '800px', height: '620px', lock: true });
    })
     $('#setEnterprise3').click(function() {
        isStore = true;
        isHotel = false;
        isEptok = false;
        dialog = art.dialog.open('" . $this->createAbsoluteUrl('/enterprise/getEnterprise') . "', { 'id': 'selectmemberinfo', title: '搜索会员', width: '800px', height: '620px', lock: true });
    })
})

var onSelectMemeberInfo = function (id) {
    if (id) {
        $.ajax({
            cache:false,
            dataType: 'json',
            url:'" . $this->createAbsoluteUrl('/enterprise/getEnterpriseName') . "&id='+id+'&YII_CSRF_TOKEN=" . Yii::app()->request->csrfToken . "',
            success:function(data){
                if(isHotel){
                    $('#AllocationConfigForm_hotelOnBusinessTravelMemberId').val(data.member_id);
                    $('#AllocationConfigForm_hotelOnBusinessTravelAccount').val(data.name);    
                }else if(isEptok){
                    $('#AllocationConfigForm_eptokOnBusinessTravelMemberId').val(data.member_id);
                    $('#AllocationConfigForm_eptokOnBusinessTravelAccount').val(data.name);
                }else{
                     $('#AllocationConfigForm_drugStoreOnBusinessTravelMemberId').val(data.member_id);
                    $('#AllocationConfigForm_drugStoreOnBusinessTravelAccount').val(data.name);
                }
            }
        })
    }
};
", CClientScript::POS_HEAD);
?>