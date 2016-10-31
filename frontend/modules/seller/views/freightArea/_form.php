<?php
/** @var $this FreightAreaController */
/** @var $model FreightArea */
/** @var $typeModel FreightType */
/** @var $form CActiveForm */

//多货币转换
$model->default_freight = Common::rateConvert($model->default_freight);
$model->added_freight = Common::rateConvert($model->added_freight);

?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
<style>
    .location{
        display: inline-block;
        padding:5px;
    }
    .city{
        border:1px solid #C90000;
        width:500px;
        margin:5px auto;
        padding:5px;
        display: none;
        position: relative;
    }
    .city a.close{
        position: absolute;
        bottom: 0;
        right: 5px;
    }
</style>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt15 sellerT3">
    <tbody>
    <tr>
        <th width="10%">
            <?php echo $form->labelEx($model, 'default'); ?>
        </th>
        <td width="90%">
            <?php echo $form->textField($model, 'default', array('class' => 'inputtxt1',
                'style' => 'width:140px;')); ?>
            <?php echo Yii::t('freightType', '（请输入大于0.01的正实数）'); ?>
            <?php echo $form->error($model, 'default') ?>
        </td>
    </tr>
    <tr>
        <th width="10%">
            <?php echo $form->labelEx($model, 'default_freight'); ?>
        </th>
        <td width="90%">
            <?php echo $form->textField($model, 'default_freight', array('class' => 'inputtxt1',
                'style' => 'width:140px;')); ?>
            <?php echo $form->error($model, 'default_freight') ?>
        </td>
    </tr>
    <tr>
        <th width="10%">
            <?php echo $form->labelEx($model, 'added'); ?>
        </th>
        <td width="90%">
            <?php echo $form->textField($model, 'added', array('class' => 'inputtxt1', 'style' => 'width:140px;')); ?>
            <?php echo Yii::t('freightType', '（请输入大于0.01的正实数）'); ?>
            <?php echo $form->error($model, 'added') ?>
        </td>
    </tr>
    <tr>
        <th width="10%">
            <?php echo $form->labelEx($model, 'added_freight'); ?>
        </th>
        <td width="90%">
            <?php echo $form->textField($model, 'added_freight', array('class' => 'inputtxt1', 'style' => 'width:140px;')); ?>
            <?php echo $form->error($model, 'added_freight') ?>
        </td>
    </tr>
    <tr>
        <th width="10%">
            <?php echo Yii::t('freightType','地区'); ?>
        </th>
        <td width="90%">
            <?php
                if($this->action->id=='create'){
                    $this->renderPartial('_addarea',array('typeModel'=>$typeModel));
                }else{
                    $this->renderPartial('_updatearea',array('typeModel'=>$typeModel,'areaArray'=>$areaArray));
                }
            ?>
        </td>
    </tr>

    </tbody>
</table>

<div class="profileDo mt15">
    <a id="submit" class="sellerBtn03"><span><?php echo Yii::t('freightType','保存'); ?></span></a>&nbsp;&nbsp;
    <a href="<?php echo $this->createAbsoluteUrl('freightType/view',array('id'=>$typeModel->id) ) ?>" class="sellerBtn01">
        <span><?php echo Yii::t('freightType','返回'); ?></span></a>
</div>
<?php $this->endWidget(); ?>
<script>
    $("#submit").click(function(){
        if($("#FreightArea_location_id input:checked").length==0){
            art.dialog({icon:'error',content:'<?php echo Yii::t('freightType','请选择地区'); ?>',ok:true,okVal:'<?php echo Yii::t('member','确定') ?>',title:'<?php echo Yii::t('member','消息') ?>'});
            return false;
        }
        $('form').submit();
    });
    //地区选择
    $("#FreightArea_location_id .location").click(function(){
        var that = $(this).find('input');
        if(that.attr('checked') || that.attr('disabled')){
            $("#city_"+that.val()).show();
            $("#city_"+that.val()+' input').attr('checked','checked');
        }else{
            $("#city_"+that.val()).hide();
            $("#city_"+that.val()+' input').removeAttr('checked');
        }
        $(".location input[disabled]").removeAttr('checked')
    });
    //关闭
    $("a.close").click(function(){
        $(this).parent().hide();
    });
</script>
