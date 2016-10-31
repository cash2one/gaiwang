<style>
    .tab-come th{text-align: center;}
</style>

<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>

<table width="100%" border="0" class="tab-come" cellspacing="0" cellpadding="0">
    <tbody>

    <tr>
        <th style="width: 180px">
            <?php echo $form->labelEx($model, 'UM_PAY'); ?>：
        </th>

        <th style="width: 120px">
            <?php echo $form->labelEx($model,'um_is_open');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'um_is_open',$model::isOpen(),array('separator'=>''))?>
            <?php echo $form->error($model, 'um_is_open'); ?>
        </td>

        <th style="width: 120px">
            <?php echo $form->labelEx($model,'um_is_recommended');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'um_is_recommended',$model::isRecommend(),array('separator'=>''))?>
            <?php echo $form->error($model, 'um_is_recommended'); ?>
        </td>
    </tr>

    <tr>
        <th style="width: 180px">
            <?php echo $form->labelEx($model, 'TL_PAY'); ?>：
        </th>

        <th style="width: 120px">
            <?php echo $form->labelEx($model,'tl_is_open');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'tl_is_open',$model::isOpen(),array('separator'=>''))?>
            <?php echo $form->error($model, 'tl_is_open'); ?>
        </td>

        <th style="width: 120px">
            <?php echo $form->labelEx($model,'tl_is_recommended');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'tl_is_recommended',$model::isRecommend(),array('separator'=>''))?>
            <?php echo $form->error($model, 'tl_is_recommended'); ?>
        </td>
    </tr>
    <tr>
        <th style="width: 180px">
            <?php echo $form->labelEx($model, 'UNION_PAY'); ?>：
        </th>

        <th style="width: 120px">
            <?php echo $form->labelEx($model,'union_is_open');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'union_is_open',$model::isOpen(),array('separator'=>''))?>
            <?php echo $form->error($model, 'union_is_open'); ?>
        </td>

        <th style="width: 120px">
            <?php echo $form->labelEx($model,'union_is_recommended');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'union_is_recommended',$model::isRecommend(),array('separator'=>''))?>
            <?php echo $form->error($model, 'union_is_recommended'); ?>
        </td>
    </tr>

    <tr>
        <th style="width: 180px">
            <?php echo $form->labelEx($model, 'ALI_PAY'); ?>：
        </th>

        <th style="width: 120px">
            <?php echo $form->labelEx($model,'ali_is_open');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'ali_is_open',$model::isOpen(),array('separator'=>''))?>
            <?php echo $form->error($model, 'ali_is_open'); ?>
        </td>

        <th style="width: 120px">
            <?php echo $form->labelEx($model,'ali_is_recommended');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'ali_is_recommended',$model::isRecommend(),array('separator'=>''))?>
            <?php echo $form->error($model, 'ali_is_recommended'); ?>
        </td>
    </tr>

    <tr>
        <th style="width: 180px">
            <?php echo $form->labelEx($model, 'WX_PAY'); ?>：
        </th>

        <th style="width: 120px">
            <?php echo $form->labelEx($model,'wx_is_open');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'wx_is_open',$model::isOpen(),array('separator'=>''))?>
            <?php echo $form->error($model, 'wx_is_open'); ?>
        </td>

        <th style="width: 120px">
            <?php echo $form->labelEx($model,'wx_is_recommended');?>：
        </th>
        <td>
            <?php echo $form->radioButtonList($model,'wx_is_recommended',$model::isRecommend(),array('separator'=>''))?>
            <?php echo $form->error($model, 'wx_is_recommended'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo CHtml::submitButton(Yii::t('home', '保存'), array('class' => 'reg-sub')) ?>
        </td>
    </tr>
    </tbody>
</table>
<?php $this->endWidget();?>