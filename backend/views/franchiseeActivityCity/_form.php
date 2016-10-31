<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'franchiseeActivityCity-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <caption class=" title-th">
        <?php echo $model->isNewRecord ? Yii::t('franchiseeActivityCity', '新增线下活动城市') : Yii::t('franchiseeActivityCity', '线下活动城市编辑'); ?>
    </caption>
    <tr>
        <td colspan="2" class="even"></td>
    </tr>
    <tr>
        <th width="14%" class="odd">
            <?php echo $form->labelEx($model, 'province_id'); ?>
        </th>
        <td class="odd">
            <input type="hidden" value="1" id="CountryId">
            <?php
            echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                'prompt' => Yii::t('franchiseeActivityCity', '选择省份'),
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/region/updateCity'),
                    'dataType' => 'json',
                    'data' => array(
                        'province_id' => 'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                    'success' => 'function(data) {
                            $("#FranchiseeActivityCity_city_id").html(data.dropDownCities);
                        }',
                ))
            );
            ?>
            <?php echo $form->error($model, 'province_id',array('style'=>'right:630px;')); ?>
            <?php
            if ($model->isNewRecord) :
                echo $form->dropDownList($model, 'city_id', array(), array('prompt' => Yii::t('franchiseeActivityCity', '选择城市'),));
            else :
                echo $form->dropDownList($model, 'city_id', CHtml::listData(Region::model()->findAll("parent_id=:pid", array(':pid' => $model->province_id)), 'id', 'name'));
            endif;
            ?>

            <?php echo $form->error($model, 'city_id',array('style'=>'right:505px;')); ?>
        </td>
    </tr>
    <tr>
        <th width="14%" class="even">
            <?php echo $form->labelEx($model, 'default'); ?>
        </th>
        <td class="even">
            <?php echo $form->radioButtonList($model, 'default', FranchiseeActivityCity::getDefaultOptions(), array('separator' => '')); ?>
            <?php echo $form->error($model, 'default'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('franchiseeActivityCity', '新增') : Yii::t('franchiseeActivityCity', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
