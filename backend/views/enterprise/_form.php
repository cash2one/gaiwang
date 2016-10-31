<?php
/* @var $this MemberController */
/* @var $model Member */
/* @var $infoModel Enterprise */
/** @var $enterpriseData enterpriseData */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'member-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
        <tr>
            <td colspan="2" class="title-th" align="center">
                <?php echo Yii::t('member','用户信息'); ?>
            </td>
        </tr>

        <tr>
            <th style="text-align: right"><?php echo $form->labelEx($model, 'username'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'username', array('class' => 'text-input-bj middle')) ?>
                <?php echo $form->error($model, 'username') ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: right"><?php echo $form->labelEx($model, 'mobile') ?>：</th>
            <td>
                <?php echo $form->textField($model, 'mobile', array('class' => 'text-input-bj middle')) ?>
                <?php echo $form->error($model, 'mobile') ?>
            </td>
        </tr>

        <tr>
            <th style="text-align: right"><?php echo $form->labelEx($model, 'identity_type'); ?>:</th>
            <td>
                <?php echo $form->dropDownList($model, 'identity_type', $model::identityType(), array('class' => 'text-input-bj valid')); ?>
                <?php echo $form->error($model, 'identity_type') ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: right"><?php echo $form->labelEx($model, 'identity_number'); ?>:</th>
            <td>
                <?php echo $form->textField($model, 'identity_number', array('class' => 'text-input-bj middle')) ?>
                <?php echo $form->error($model, 'identity_number') ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: right"><?php echo $form->labelEx($model, 'real_name'); ?>:</th>
            <td>
                <?php echo $form->textField($model, 'real_name', array('class' => 'text-input-bj middle')) ?>
                <?php echo $form->error($model, 'real_name') ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: right"><?php echo $form->labelEx($model, 'sex'); ?>:</th>
            <td>
                <?php echo $form->radioButtonList($model, 'sex', $model::gender(), array('separator' => '')) ?>
                <?php echo $form->error($model, 'sex') ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: right"><?php echo $form->labelEx($model, 'birthday'); ?>:</th>
            <td>
                <?php
                $model->birthday = is_numeric($model->birthday) ? date('Y-m-d', $model->birthday) : $model->birthday;
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'birthday',
                    'select' => 'date',
                    'options' => array(
                        'yearRange' => '-100y',
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'birthday') ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: right"><?php echo $form->labelEx($model, 'status'); ?>:</th>
            <td>
                <?php $model->status = $model->isNewRecord ? $model::STATUS_NO_ACTIVE : $model->status ?>
                <?php echo $form->radioButtonList($model, 'status', $model::status(), array('separator' => '')); ?>
                <?php echo $form->error($model, 'status') ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: right"><?php echo $form->labelEx($model, 'type_id'); ?>:</th>
            <td>
                <?php
                $defaultVal = MemberType::fileCache();
                $model->type_id = $model->isNewRecord ? $defaultVal['defaultType'] : $model->type_id
                ?>
                <?php echo $form->radioButtonList($model, 'type_id', CHtml::listData(MemberType::model()->findAll(), 'id', 'name'), array('separator' => '')); ?>
                <?php echo $form->error($model, 'type_id') ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: right"><?php echo $form->labelEx($model, 'grade_id'); ?>:</th>
            <td>
                <?php $model->grade_id = $model->isNewRecord ? MemberGrade::FIRST_ID : $model->grade_id ?>
                <?php echo $form->radioButtonList($model, 'grade_id', CHtml::listData(MemberGrade::model()->findAll(), 'id', 'name'), array('separator' => '')); ?>
                <?php echo $form->error($model, 'grade_id') ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: right"></th>
            <td>
                <?php $model->is_master_account = $model->isNewRecord ? $model::IS_MASTER_ACCOUNT : $model->is_master_account ?>
                <?php echo $form->checkBox($model, 'is_master_account') ?>
                <?php echo $form->label($model, 'is_master_account'); ?>
            </td>
        </tr>

        <tr>
            <th style="text-align: right"><?php echo $form->labelEx($infoModel, 'apply_cash_limit'); ?>:</th>
            <td>
                <?php echo $form->radioButtonList($infoModel, 'apply_cash_limit', Enterprise::getApplyCashList(), array('separator' => '')); ?>
                <?php echo $form->error($infoModel, 'apply_cash_limit') ?>
            </td>
        </tr>


        <tr>
            <td colspan="2" align="center" class="title-th">
                <?php echo Yii::t('enterprise','企业信息'); ?>
            </td>
        </tr>

        <tr>
            <th style="text-align: right">
                <?php echo $form->labelEx($infoModel,'name'); ?>：
            </th>
            <td>
                <?php echo $form->textField($infoModel,'name',array('class'=>'text-input-bj  middle')); ?>
                <?php echo $form->error($infoModel,'name') ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: right">
                <?php echo $form->labelEx($infoModel,'short_name'); ?>：
            </th>
            <td>
                <?php echo $form->textField($infoModel,'short_name',array('class'=>'text-input-bj  middle')); ?>
                <?php echo $form->error($infoModel,'short_name') ?>
            </td>
        </tr>

        <tr>
            <th style="text-align: right">
                <?php echo $form->labelEx($enterpriseData,'license'); ?>：
            </th>
            <td>
                <?php echo $form->textField($enterpriseData,'license',array('class'=>'text-input-bj  middle')); ?>
                <?php echo $form->error($enterpriseData,'license') ?>
            </td>
        </tr>
        <?php $this->renderPartial('_img2',array('form'=>$form,'model'=>$enterpriseData,'field'=>'license_photo')) ?>

        <tr>
            <th style="text-align: right">
                <?php echo Yii::t('enterprise','公司注册地区'); ?> <span class="required">*</span>：
            </th>
            <td>
                <?php
                echo $form->dropDownList($infoModel, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                    'prompt' => Yii::t('enterprise', '选择省份'),
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/region/updateCity'),
                        'dataType' => 'json',
                        'data' => array(
                            'province_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                        'success' => 'function(data) {
                            $("#Enterprise_city_id").html(data.dropDownCities);
                            $("#Enterprise_district_id").html(data.dropDownCounties);
                        }',
                    )));
                ?>

                <?php
                echo $form->dropDownList($infoModel, 'city_id', Region::getRegionByParentId($infoModel->province_id), array(
                    'prompt' => Yii::t('enterprise', '选择城市'),
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/region/updateArea'),
                        'update' => '#Enterprise_district_id',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                    )));
                ?>

                <?php
                echo $form->dropDownList($infoModel, 'district_id', Region::getRegionByParentId($infoModel->city_id), array(
                    'prompt' => Yii::t('enterprise', '选择地区'),
                    'ajax' => array(
                        'type' => 'POST',
                        'data' => array(
                            'city_id' => 'js:this.value',
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ),
                    )));
                ?>

                <div style="display:block;width:300px;float:left;margin-left:400px;">
                    <?php echo $form->error($infoModel, 'district_id'); ?>
                    <?php echo $form->error($infoModel, 'city_id'); ?>
                    <?php echo $form->error($infoModel, 'province_id'); ?>
                </div>

            </td>
        </tr>

        <tr>
            <th style="text-align: right">
                <?php echo $form->labelEx($infoModel,'street'); ?>：
            </th>
            <td>
                <?php echo $form->textField($infoModel,'street',array('class'=>'text-input-bj  middle')); ?>
                <?php echo $form->error($infoModel,'street') ?>
            </td>
        </tr>

        <tr>
            <th style="text-align: right">
                <?php echo $form->labelEx($infoModel,'link_man'); ?>：
            </th>
            <td>
                <?php echo $form->textField($infoModel,'link_man',array('class'=>'text-input-bj  middle')); ?>
                <?php echo $form->error($infoModel,'link_man') ?>
            </td>
        </tr>

        <tr>
            <th style="text-align: right">
                <?php echo $form->labelEx($infoModel,'link_phone'); ?>：
            </th>
            <td>
                <?php echo $form->textField($infoModel,'link_phone',array('class'=>'text-input-bj  middle')); ?>
                <?php echo $form->error($infoModel,'link_phone') ?>
            </td>
        </tr>





        <tr>
            <th style="text-align: right">
                <?php echo $form->labelEx($infoModel,'signing_type'); ?>:
            </th>
            <td>
                <?php if ($infoModel->signing_type == $infoModel::SIGNING_TYPE_SERVICE_FEE): ?>
                    <font color='red'><?php echo $infoModel::getSigningType($infoModel->signing_type); ?> √</font>
                <?php else: ?>
                    <?php echo $form->radioButtonList($infoModel,'signing_type', $infoModel::getSigningType(),array('separator'=>'')); ?>
                    <?php echo $form->error($infoModel,'signing_type') ?>
                <?php endif; ?>
            </td>
        </tr>

        <tr>
            <th style="text-align: right">
                <?php echo $form->labelEx($infoModel,'email'); ?>：
            </th>
            <td>
                <?php echo $form->textField($infoModel,'email',array('class'=>'text-input-bj  middle')); ?>
                <?php echo $form->error($infoModel,'email') ?>
            </td>
        </tr>

        <tr>
            <th style="text-align: right">
                <?php echo $form->labelEx($infoModel,'department'); ?>：
            </th>
            <td>
                <?php echo $form->dropDownList($infoModel,'department',$infoModel::departmentArr(),array(
                    'empty'=>Yii::t('enterprise','请选择'),
                )) ?>
                <?php echo $form->error($infoModel,'department') ?>
            </td>
        </tr>

        <tr>
            <th>
                <?php echo $form->labelEx($infoModel,'service_start_time'); ?>：
            </th>
            <td>
                <?php
                if(!empty($infoModel->service_start_time)) $infoModel->service_start_time = date('Y-m-d H:i:s',intval($infoModel->service_start_time));
                if(!empty($infoModel->service_end_time)) $infoModel->service_end_time = date('Y-m-d H:i:s',intval($infoModel->service_end_time));
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $infoModel,
                    'id'=>'Enterprise_service_start_time',
                    'name' => 'service_start_time',
                ));
                ?>
                <?php echo $form->error($infoModel,'service_start_time') ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($infoModel,'service_end_time'); ?>：
            </th>
            <td>
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $infoModel,
                    'id'=>'Enterprise_service_end_time',
                    'name' => 'service_end_time',
                ));
                ?>
                <?php echo $form->error($infoModel,'service_end_time') ?>
            </td>
        </tr>

        <tr>
            <th>
                <?php echo $form->labelEx($infoModel,'auditing'); ?>:
            </th>
            <td>
                <?php if($infoModel->isNewRecord){
                    $infoModel->auditing = Enterprise::AUDITING_NO;
                }?>
                <?php echo $form->radioButtonList($infoModel,'auditing',Enterprise::auditingArr(),array('separator'=>'')) ?>
                <?php echo $form->error($infoModel,'auditing') ?>
            </td>
        </tr>


        <tr>
            <td colspan="2">
                <?php echo CHtml::submitButton(Yii::t('member','提交'),array('class'=>'reg-sub')) ?>
            </td>
        </tr>
        </tbody>
    </table>
<?php $this->endWidget(); ?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
