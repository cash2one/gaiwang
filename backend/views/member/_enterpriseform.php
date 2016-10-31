<?php
/* @var $this MemberController */
/* @var $model Member */
/* @var $infoModel Enterprise */
/* @var $form CActiveForm */
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->clientScript;
//显示原图的JS插件
$cs->registerCssFile($baseUrl . "/js/swf/js/fancybox/jquery.fancybox-1.3.4.css");
$cs->registerScriptFile($baseUrl . "/js/swf/js/fancybox/jquery.fancybox-1.3.4.pack.js", CClientScript::POS_END);
?>
    <script>
        $(function(){
            $("#license_pic").fancybox();
        });
    </script>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'member-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
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
                $model->birthday = empty($model->birthday) ? null : date('Y-m-d', $model->birthday);
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
    <td colspan="2" align="center" class="title-th">
        <?php echo Yii::t('enterprise','店铺信息'); ?>
    </td>
</tr>

<tr>
    <th style="text-align: right">
        <?php echo $form->labelEx($store,'name'); ?>：
    </th>
    <td>
        <?php echo $form->textField($store,'name',array('class'=>'text-input-bj  middle')); ?>
        <?php echo $form->error($store,'name') ?>
    </td>
</tr>
<tr>
            <th style="text-align: right"><?php echo $form->labelEx($store, 'mobile') ?>：</th>
            <td>
                <?php echo $form->textField($store, 'mobile', array('class' => 'text-input-bj middle')) ?>
                <?php echo $form->error($store, 'mobile') ?>
            </td>
        </tr>
<tr>
    <th style="text-align: right">
        <?php echo Yii::t('enterprise','店铺所在地区'); ?>：
    </th>
    <td>
        <?php
        echo $form->dropDownList($store, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
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
                            $("#Store_city_id").html(data.dropDownCities);
                            $("#Store_district_id").html(data.dropDownCounties);
                        }',
            )));
        ?>

        <?php
        echo $form->dropDownList($store, 'city_id', Region::getRegionByParentId($store->province_id), array(
            'prompt' => Yii::t('enterprise', '选择城市'),
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
        echo $form->dropDownList($store, 'district_id', Region::getRegionByParentId($store->city_id), array(
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
				<?php echo $form->error($store, 'district_id'); ?> 
				<?php echo $form->error($store, 'city_id'); ?>
				<?php echo $form->error($store, 'province_id'); ?>
			</div>
		
    </td>
</tr>


<tr>
    <th style="text-align: right">
        <?php echo $form->labelEx($store,'street'); ?>：
    </th>
    <td>
        <?php echo $form->textField($store,'street',array('class'=>'text-input-bj  middle')); ?>
        <?php echo $form->error($store,'street') ?>
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
        <?php echo $form->labelEx($infoModel,'license'); ?>：
    </th>
    <td>
        <?php echo $form->textField($infoModel,'license',array('class'=>'text-input-bj  middle')); ?>
        <?php echo $form->error($infoModel,'license') ?>
    </td>
</tr>
<tr>
    <th style="text-align: right">
        <?php echo $form->labelEx($infoModel,'license_photo'); ?>：
    </th>
    <td>
        <?php if(!$infoModel->isNewRecord): ?>
        <?php echo $form->hiddenField($infoModel,'license_photo') ?>
        <?php endif; ?>
        <?php //echo $form->fileField($infoModel,'license_photo');
        echo CHtml::fileField('Enterprise[license_photo]','',array('id'=>'Enterprise_license_photo_file'));
        $imgSrc = ATTR_DOMAIN.'/'.$infoModel->license_photo;
        ?>
        <a id="license_pic" href="<?php echo $imgSrc ?>">
        <img width="80" src="<?php echo $imgSrc ?>" >
        </a>
        <?php  //echo Yii::t('enterprise','（请上传500x500像素图片）'); 要求不要没真实限制的提示 ?>
        <?php echo $form->error($infoModel,'license_photo') ?>
    </td>
</tr>

<tr>
    <th style="text-align: right">
        <?php echo Yii::t('enterprise','公司所在地区'); ?>：
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
        <?php echo $form->labelEx($infoModel,'mobile'); ?>：
    </th>
    <td>
        <?php echo $form->textField($infoModel,'mobile',array('class'=>'text-input-bj  middle')); ?>
        <?php echo $form->error($infoModel,'mobile') ?>
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
    <th style="text-align: right">
        <?php echo Yii::t('enterprise','营业执照所在地区'); ?>：
    </th>
    <td>
        <?php
        echo $form->dropDownList($infoModel, 'license_province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
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
                            $("#Enterprise_license_city_id").html(data.dropDownCities);
                            $("#Enterprise_license_district_id").html(data.dropDownCounties);
                        }',
            )));
        ?>

        <?php
        echo $form->dropDownList($infoModel, 'license_city_id', Region::getRegionByParentId($infoModel->license_province_id), array(
            'prompt' => Yii::t('enterprise', '选择城市'),
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('/region/updateArea'),
                'update' => '#Enterprise_license_district_id',
                'data' => array(
                    'city_id' => 'js:this.value',
                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                ),
            )));
        ?>

        <?php
        echo $form->dropDownList($infoModel, 'license_district_id', Region::getRegionByParentId($infoModel->license_city_id), array(
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
				<?php echo $form->error($infoModel, 'license_district_id'); ?> 
				<?php echo $form->error($infoModel, 'license_city_id'); ?>
				<?php echo $form->error($infoModel, 'license_province_id'); ?>
			</div>
		
    </td>
</tr>


<tr>
    <th>
        <?php echo $form->labelEx($infoModel,'license_start_time'); ?>：
    </th>
    <td>
        <?php
        if(!empty($infoModel->license_start_time)) $infoModel->license_start_time = date('Y-m-d H:i:s',intval($infoModel->license_start_time));
        if(!empty($infoModel->license_end_time)) $infoModel->license_end_time = date('Y-m-d H:i:s',intval($infoModel->license_end_time));
        $this->widget('comext.timepicker.timepicker', array(
            'model' => $infoModel,
            'id'=>'Enterprise_license_start_time',
            'name' => 'license_start_time',
        ));
        ?>
        <?php echo $form->error($infoModel,'license_start_time') ?>
    </td>
</tr>
<tr>
    <th>
        <?php echo $form->labelEx($infoModel,'license_end_time'); ?>：
    </th>
    <td>
        <?php
        $this->widget('comext.timepicker.timepicker', array(
            'model' => $infoModel,
            'id'=>'Enterprise_license_end_time',
            'name' => 'license_end_time',
        ));
        ?>
        <?php echo $form->error($infoModel,'license_end_time') ?>
    </td>
</tr>


<tr>
    <th style="text-align: right">
        <?php echo $form->labelEx($infoModel,'business_scope'); ?>：
    </th>
    <td>
        <?php echo $form->textField($infoModel,'business_scope',array('class'=>'text-input-bj  middle')); ?>
        <?php echo $form->error($infoModel,'business_scope') ?>
    </td>
</tr>

<tr>
    <th style="text-align: right">
        <?php echo $form->labelEx($infoModel,'organization'); ?>：
    </th>
    <td>
        <?php echo $form->textField($infoModel,'organization',array('class'=>'text-input-bj  middle')); ?>
        <?php echo $form->error($infoModel,'organization') ?>
    </td>
</tr>

<tr>
    <th style="text-align: right">
        <?php echo $form->labelEx($infoModel,'organization_image'); ?>：
    </th>
    <td>
        <?php if(!$infoModel->isNewRecord): ?>
        <?php echo $form->hiddenField($infoModel,'organization_image') ?>
        <?php endif; ?>
        <?php //echo $form->fileField($infoModel,'organization_image');
        echo CHtml::fileField('Enterprise[organization_image]','',array('id'=>'Enterprise_organization_image_file'));
        $organization_image_imgSrc = ATTR_DOMAIN.'/'.$infoModel->organization_image;
        ?>
        <a id="organization_image" href="<?php echo $organization_image_imgSrc ?>">
        <img width="80" src="<?php echo $organization_image_imgSrc ?>" >
        </a>
        <?php echo $form->error($infoModel,'organization_image') ?>
    </td>
</tr>



<tr>
    <th style="text-align: right">
        <?php echo $form->labelEx($infoModel,'tax_id'); ?>：
    </th>
    <td>
        <?php echo $form->textField($infoModel,'tax_id',array('class'=>'text-input-bj  middle')); ?>
        <?php echo $form->error($infoModel,'tax_id') ?>
    </td>
</tr>

<tr>
    <th style="text-align: right">
        <?php echo $form->labelEx($infoModel,'taxpayer_id'); ?>：
    </th>
    <td>
        <?php echo $form->textField($infoModel,'taxpayer_id',array('class'=>'text-input-bj  middle')); ?>
        <?php echo $form->error($infoModel,'taxpayer_id') ?>
    </td>
</tr>

<tr>
    <th style="text-align: right">
        <?php echo $form->labelEx($infoModel,'tax_image'); ?>：
    </th>
    <td>
        <?php if(!$infoModel->isNewRecord): ?>
        <?php echo $form->hiddenField($infoModel,'tax_image') ?>
        <?php endif; ?>
        <?php //echo $form->fileField($infoModel,'tax_image');
        	echo CHtml::fileField('Enterprise[tax_image]','',array('id'=>'Enterprise_tax_image_file'));
        $tax_image_imgSrc = ATTR_DOMAIN.'/'.$infoModel->tax_image;
        ?>
        <a id="tax_image" href="<?php echo $tax_image_imgSrc ?>">
        <img width="80" src="<?php echo $tax_image_imgSrc ?>" >
        </a>
        <?php echo $form->error($infoModel,'tax_image') ?>
    </td>
</tr>


<tr>
    <th style="text-align: right">
        <?php echo $form->labelEx($store,'category_id'); ?>：
    </th>
    <td>
         <?php
                    echo $form->radioButtonList($store,'category_id',CHtml::listData($category,'id','name'),
                        array(
                            'class'=>'checkboxItem',
                            'separator'=>'&nbsp;',
                            'template'=>'<span>{input} {label}</span>',
                        )) ?>
        <?php echo $form->error($store,'category_id') ?>
    </td>
</tr>

<tr>
    <th style="text-align: right">
        <?php echo $form->labelEx($store,'mode'); ?>：
    </th>
    <td>
         <?php
                    echo $form->radioButtonList($store,'mode',Store::getMode(),
                        array(
                            'class'=>'checkboxItem',
                            'separator'=>'&nbsp;',
                            'template'=>'<span>{input} {label}</span>',
                        )) ?>
        <?php echo $form->error($store,'category_id') ?>
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
<?php
Yii::app()->clientScript->registerScript('categoryTree', "
var dialog = null;
jQuery(function($) {
    $('#seachRefMem').click(function() {
        dialog = art.dialog.open('" . $this->createUrl('/member/getUser') . "', { 'id': 'selectmember', title: '搜索会员', width: '800px', height: '620px', lock: true });
    })
})
 var doClose = function() {
                if (null != dialog) {
                    dialog.close();
                }
            };
 var onSelectBizPMember = function(pid) {};
var onSelectMemeber = function (uid) {
    if (uid) {
        $.ajax({
            cache:false,
            dataType: 'json',
            url:'" . $this->createUrl('/member/getUserName') . "&id='+uid+'&YII_CSRF_TOKEN=" . Yii::app()->request->csrfToken . "',
            success:function(name){
                $('#Member_referrals_id').val(uid);
                $('#RefMemberUsername').val(name);
            }
        })
    }
};
", CClientScript::POS_HEAD);
?>
<script  type="text/javascript" language="javascript" >
<?php if(!empty($infoModel->license_photo)): ?>
$('#ytEnterprise_license_photo').val('<?php echo $infoModel->license_photo;?>');
$('#ytEnterprise_license_photo').attr('id','Enterprise_license_photo');
<?php endif;;?>
<?php if(!empty($infoModel->organization_image)): ?>
$('#ytEnterprise_organization_image').val('<?php echo $infoModel->organization_image;?>');
$('#ytEnterprise_organization_image').attr('id','Enterprise_organization_image');
<?php endif;;?>
<?php if(!empty($infoModel->tax_image)): ?>
$('#ytEnterprise_tax_image').val('<?php echo $infoModel->tax_image;?>');
$('#ytEnterprise_tax_image').attr('id','Enterprise_tax_image');
<?php endif;?>
<?php if(!empty($bankAccount->licence_image)): ?>
$('#ytBankAccount_licence_image').val('<?php echo $bankAccount->licence_image;?>');
$('#ytBankAccount_licence_image').attr('id','BankAccount_licence_image');
<?php endif;?>

</script>