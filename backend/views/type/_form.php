<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'type-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
        ));
?>
<style type="text/css">
.h26 {
    height: 35px;
}
</style>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">

    <tr>
        <th width="120px" align="right" class="odd">
            <?php echo $form->labelEx($model, 'name'); ?>：
        </th>
        <td class="odd">
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>

    <tr>
        <th width="120px" align="right" class="even">
            <?php echo $form->labelEx($model, 'sort'); ?>：
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj')); ?>
            <?php echo $form->error($model, 'sort'); ?>
        </td>
    </tr>
</table>
<table class="table tb_type2" width="100%" border="0" >
    <thead class="thead">
        <tr>
            <th colspan="3"><label>选择关联规格</label></th>
        </tr>
        <tr>
            <th></th>
            <th>规格名称</th>
            <th>规格值</th>
        </tr>

    </thead>
    <tbody>
        <?php foreach ($specData as $sp): ?>
            <tr>
                <td class="w24"><input type="checkbox" name="spec_id[]" value="<?php echo $sp->id ?>" <?php if(!$model->isNewRecord): if (in_array($sp->id, $specCheck)): ?>checked="checked"<?php endif;  endif;?> ></td>
                <td class="w18pre"><?php echo $sp->name; ?></td>
                <td><?php echo $sp->value; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<table class="table tb_type2" width="100%" border="0" >
    <thead class="thead">
        <tr>
            <th colspan="3"><label>选择关联品牌</label></th>
        </tr>

    </thead>
    <tbody>

        <tr>
            <td>
                <ul class="brandList">
                    <?php foreach ($brand as $b): ?>
                       <li class="w25pre h26 left">
                           <input type="checkbox" name="brand_id[]" value="<?php  echo $b->id ?>"  <?php if(!$model->isNewRecord): if (in_array($b->id, $brandCheck)): ?>checked="checked"<?php endif;  endif;?>/>
                           <label><?php echo $b->name; ?></label>
                       </li>
                    <?php  endforeach; ?>
                </ul>
            </td>

        </tr>

    </tbody>
</table>	
<table>
    <tr>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('type', '新增') : Yii::t('type', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr> 	
</table>
<?php $this->endWidget(); ?>

