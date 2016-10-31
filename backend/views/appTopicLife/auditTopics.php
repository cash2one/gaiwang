
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'appTopicLife-form',
    'enableClientValidation' => false,
    'enableAjaxValidation'=>false,
    'clientOptions' => array(
        'validateOnSubmit' => false,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
        <tr>
            <th style="width: 220px">标题</th>
            <td>

               <?php echo $model->title ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px">专题图片</th>
            <td>
                <?php
                if($model->topic_img != ''){
                    echo CHtml::image(ATTR_DOMAIN. '/' .$model->topic_img, '', array('width' => '220px', 'height' => '70px'));
                }?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px">作者</th>
            <td>
                <?php echo $model->author ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px">专业证明</th>
            <td>
                <?php echo $model->profess_proof ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px">头像</th>
            <td>
                <?php
                if($model->comHeadUrl != ''){
                    echo CHtml::image(ATTR_DOMAIN. '/' .$model->comHeadUrl, '', array('width' => '220px', 'height' => '70px'));
                }?>
            </td>
        </tr>
        <tr>
            <th colspan="2" style='text-align:center;background-color:red'>商品信息</th>
        </tr>
        <?php if(isset($goodsList) && !empty($goodsList)):?>
        <?php foreach($goodsList as $val):?>

        <tr>
        <th style="width: 220px" class="odd">
            商品排序：
        </th>
        <td class="odd">
            <?php echo $val['goodOrder'];?>
        </td>
        </tr>
         <tr>
        <th style="width: 220px" class="odd">
            商品ID：
        </th>
        <td class="odd">
            <?php echo $val['goodsIds'];?>
        </td>
        </tr>
         <tr>
        <th style="width: 220px" class="odd">
            商品图片：
        </th>
        <td class="odd">
            <img width="220px" height="70px" src="<?php echo ATTR_DOMAIN.'/'.$val['goodsImgs']?>" alt="">
        </td>
        </tr>
        <tr>
        <td colspan="4">-----------------------------------------------------------------------------------------------</td>
        </tr>

    <?php endforeach;?>
    <?php endif?>

        <tr>
        <th style="width: 220px"><?php echo $form->labelEx($model, 'audit_status'); ?></th>
        <td>
            <?php echo $form->dropDownList($model,'audit_status',AppTopicLife::getAuditStatus(),array('class'=> 'text-input-bj  long valid'));?>
            <?php echo $form->error($model, 'audit_status'); ?>
        </td>
        </tr>
        <tr><td colspan="2"></td></tr>
        <tr><td colspan="2"></td></tr>
        <tr>
        <th style="width: 220px"><?php echo $form->labelEx($model, 'error_field'); ?></th>
        <td>
            <?php echo $form->textArea($model,'error_field',array('class'=> 'text-input-bj  long valid'));?>
            <?php echo $form->error($model, 'error_field'); ?>
        </td>
        </tr>
        <tr>
        <th class="odd"></th>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton(Yii::t('appTopicCar', '提交'), array('class' => 'reg-sub','style')); ?>
        </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>

<script type="text/javascript">

    $("form").submit(function(){
        var errorFlag = false;
        AppTopicLife_audit_status = $('#AppTopicLife_audit_status');
        if(AppTopicLife_audit_status.val() == 0){
            AppTopicLife_error_field = $('#AppTopicLife_error_field');
           if(AppTopicLife_error_field.val() == ""){
               errorFlag = true;
               AppTopicLife_error_field.after('<div class= "errorMessage" >当审核不通过时请填写不通过原因</div>');
           }
        }
        if(errorFlag){
            return false;
        }else{
            return true;
        }

    });
</script>