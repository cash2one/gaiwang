<?php
/**
 * @var $form CActiveForm
 * @var CityController $this
 * @var City $model
 */
$this->breadcrumbs = array(
    Yii::t('city', '城市') => array('admin'),
    $model->isNewRecord ? Yii::t('city', '新增') : Yii::t('city', '修改')
);
?>
<?php
$form = $this->beginWidget('ActiveForm', array(
    'id' => 'city-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => false,
    ),
));
?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
        <tr>
            <td colspan="2" class="title-th even"
                align="center"><?php echo $model->isNewRecord ? Yii::t('city', '添加城市') : Yii::t('city', '修改城市'); ?></td>
        </tr>
        </tbody>
        <tbody>
        <?php if ($model->isNewRecord || $model->creater): ?>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo CHtml::label('所属省份', false, array('required' => true)); ?>：
            </th>
            <td class="odd">
                <?php
                echo $form->dropDownList($model, 'nation_id', CHtml::listData(Nation::model()->findAll(), 'id', 'name'), array(
                    'class' => 'text-input-bj',
                    'prompt' => '选择国家',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('province/ajaxGetProvince'),
                        'dataType' => 'json',
                        'data' => array(
                            'nation_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => 'function(data) {
                            $("#City_province_code").html(data.dropDownProvinces);
                        }'
                    )
                ));
                ?>
                <?php
                echo $form->dropDownList($model, 'province_code', isset($province)?$province:array(), array(
                    'class' => 'text-input-bj',
                    'prompt' =>'选择省份',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('city/ajaxGetCity'),
                        'dataType' => 'json',
                        'data' => array(
                            'province_code' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => 'function(data) {
                            $("#City_code").html(data.dropDownCities);
                        }'
                    )
                ));
                ?>
                <?php echo $form->error($model, 'nation_id'); ?>
                <?php echo $form->error($model, 'province_code'); ?>

            </td>
        </tr>
        <?php endif ?>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'name'); ?>
            </th>
            <td class="odd">
                <?php if (!$model->isNewRecord && !$model->creater): ?>
                    <?php echo $model->name ?>
                <?php else: ?>
                    <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle',)); ?>
                    <?php echo $form->error($model, 'name'); ?>
                <?php endif ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'code'); ?>
            </th>
            <td class="odd">
                <?php if (!$model->isNewRecord && !$model->creater): ?>
                    <?php echo $model->code ?>
                <?php else: ?>
                    <?php echo $form->textField($model, 'code', array('class' => 'text-input-bj  middle')); ?>
                    <?php echo $form->error($model, 'code'); ?>
                <?php endif ?>

            </td>
        </tr>
        <tr>
            <th class="even">
                <?php echo $form->labelEx($model, 'sort'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'sort'); ?>
            </td>
        </tr>

        <tr>
            <th class="odd"></th>
            <td colspan="2" class="odd">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('advert', '新增') : Yii::t('advert', '保存'), array('class' => 'reg-sub')); ?>
            </td>
        </tr>
        </tbody>
    </table>
<?php $this->endWidget(); ?>