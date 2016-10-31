<?php
/* @var $this StoreController */
/* @var $model Store */
/* @var $form CActiveForm */
$this->breadcrumbs = array(Yii::t('store', '店铺') => array('admin'), Yii::t('store', '编辑'));
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'store-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
        <tr><th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('store', '基本信息'); ?></th></tr>
        <tr>
            <th style="width: 220px"><?php echo $form->labelEx($model, 'name'); ?></th>
            <td>
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'province_id'); ?></th>
            <td>
                <?php
                echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                    'prompt' => Yii::t('member', Yii::t('address', '选择省份')),
                    'class' => 'text-input-bj',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/region/updateCity'),
                        'dataType' => 'json',
                        'data' => array(
                            'province_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => 'function(data) {
                            $("#Store_city_id").html(data.dropDownCities);
                            $("#Store_district_id").html(data.dropDownCounties);
                        }',
                )));
                ?>
                <?php
                echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                    'prompt' => Yii::t('member', Yii::t('address', '选择城市')),
                    'class' => 'text-input-bj',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/region/updateArea'),
                        'update' => '#Store_district_id',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
                ?>
                <?php
                echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                    'prompt' => Yii::t('member', Yii::t('address', '选择区/县')),
                    'class' => 'text-input-bj',
                    'ajax' => array(
                        'type' => 'POST',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                )));
                ?>
                <div style="display:block;width:300px;float:left;margin-left:380px;">
                    <?php echo $form->error($model, 'district_id', array('style' => 'position: absolute;top:6px;right:132px;')); ?> 
                    <?php echo $form->error($model, 'city_id', array('style' => 'position: absolute;top:6px;right:259px')); ?>
                    <?php echo $form->error($model, 'province_id', array('style' => 'position: absolute;top:6px;')); ?>
                </div>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'street'); ?></th>
            <td>
                <?php echo $form->textField($model, 'street', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'street'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'mobile'); ?></th>
            <td>
                <?php echo $form->textField($model, 'mobile', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'mobile'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->label($model, 'email'); ?></th>
            <td>
                <?php echo $form->textField($model, 'email', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'email'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'order_reminder'); ?></th>
            <td>
                <?php echo $form->textField($model, 'order_reminder', array('class' => 'text-input-bj middle')); ?>(单位：小时)
                <?php echo $form->error($model, 'order_reminder'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'qualifications'); ?></th>
            <td>
                <?php $qualifications = explode(',',$model->qualifications); $quaArray = $model::getQualifications();?>
                <?php foreach ($quaArray as $k=>$v){ ?>
                    <input type="checkbox" name="Store[qualifications][]" value="<?php echo $k; ?>" <?php if (in_array($k, $qualifications)): ?> checked="true" <?php endif; ?>/> <?php echo $v; ?>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'category_id'); ?></th>
            <td>
                <?php
                $category = Category::getTopCategory();
                echo $form->radioButtonList($model, 'category_id', CHtml::listData($category, 'id', 'name'),
                array(
                'class' => 'checkboxItem',
                'separator' => '&nbsp;',
                'template' => '<span>{input} {label}</span>',
                )) ?>
                <?php echo $form->error($model, 'category_id') ?>
            </td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th even"><?php echo Yii::t('store', 'SEO信息'); ?></th>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'keywords'); ?></th>
            <td>
                <?php echo $form->textArea($model, 'keywords', array('class' => 'text-input-bj', 'cols' => 50)); ?>
                <?php echo $form->error($model, 'keywords'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'description'); ?></th>
            <td>
                <?php echo $form->textArea($model, 'description', array('class' => 'text-input-bj', 'cols' => 50)); ?>
                <?php echo $form->error($model, 'description'); ?>
            </td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('store', '审核信息'); ?></th>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'status'); ?></th>
            <td>
                <?php echo $form->radioButtonList($model, 'status', Store::status(), array('separator' => '')); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'sort'); ?></th>
            <td>
                <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj middle')); ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">
                <?php echo CHtml::submitButton(Yii::t('store', '编辑'), array('class' => 'reg-sub')); ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>