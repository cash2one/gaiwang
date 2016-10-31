<?php
/* @var $this  HomeController */
/** @var $model Member */
/** @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberMember', '账号管理') => '',
    Yii::t('memberMember', '基本信息修改'),
);
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberMember','基本信息修改');?></span></a></li>
        </ul>
    </div>
    <div class="mbRcontent">
        <?php if ( empty($model->mobile)): ?>
            <a href="javascript:void(0)" class="mbTip mgtop10">
                <span class="mbFault"></span>
                <?php echo Yii::t('memberMember', '您的固定资料或者手机号码未填写，无法进行其他操作，请先完成固定资料的填写，并进行手机绑定！'); ?>
            </a>
        <?php endif; ?>
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
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
                <table width="890" border="0" cellpadding="0" cellspacing="0" class="tableBank updateBase">
                    <tbody>
                        <tr>
                            <td height="50" colspan="3" align="center" class="tdBg">
                                <b><?php echo Yii::t('memberMember', '账户固定信息'); ?></b>
                                <br><span><?php echo Yii::t('memberMember', '固定信息(填写后不能修改，请仔细核对)'); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="127" height="25" align="center" class="dtEe"><?php echo $form->labelEx($model, 'username'); ?>：</td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                                <?php if (empty($model->username)): ?>
                                    <?php echo $form->textField($model, 'username', array('class' => 'inputtxt')) ?>
                                    <?php echo $form->error($model, 'username') ?>
                                <?php else: ?>
                                    <?php echo $model->username ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td height="30" align="center" class="dtEe"><?php echo $form->labelEx($model, 'real_name'); ?>：</td>
                            <td colspan="2" class="dtFff pdleft20">
                                <?php if (empty($model->real_name)): ?>
                                    <?php echo $form->textField($model, 'real_name', array('class' => 'inputtxt')) ?>
                                    <?php echo $form->error($model, 'real_name') ?>
                                <?php else: ?>
                                    <?php echo $model->real_name ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td height="30" align="center" class="dtEe"><?php echo $form->labelEx($model, 'identity_type'); ?>：</td>
                            <td colspan="2" class="dtFff pdleft20">
                                <?php if (empty($model->identity_number)): ?>
                                    <?php echo $form->dropDownList($model, 'identity_type', $model::identityType()); ?>
                                    <?php echo $form->error($model, 'identity_type') ?>
                                <?php else: ?>
                                    <?php echo $model::identityType($model->identity_type) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td height="30" align="center" class="dtEe"><?php echo $form->labelEx($model, 'identity_number'); ?>：</td>
                            <td colspan="2" class="dtFff pdleft20">
                                <?php if (empty($model->identity_number)): ?>
                                    <?php echo $form->textField($model, 'identity_number', array('class' => 'inputtxt')) ?>
                                    <?php echo $form->error($model, 'identity_number') ?>
                                <?php else: ?>
                                    <?php echo $model->identity_number ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td height="30" align="center" class="dtEe"><?php echo $form->labelEx($model, 'sex'); ?>：</td>
                            <td colspan="2" class="dtFff pdleft20">
                                <?php if (empty($model->sex)): ?>
                                    <?php echo $form->radioButtonList($model, 'sex', $model::gender(), array('separator' => '')) ?>
                                    <?php echo $form->error($model, 'sex') ?>
                                <?php else: ?>
                                    <?php echo $model::gender($model->sex) ?>
                                <?php endif; ?>

                            </td>
                        </tr>
                        <tr>
                            <td height="30" colspan="3" align="center" class="dtffe"><b><?php echo Yii::t('memberMember', '手机绑定'); ?></b></td>
                        </tr>
                        <tr>
                            <td height="30" align="center" class="dtEe">
                                <?php echo $form->labelEx($model, 'mobile') ?>
                            </td>
                            <td colspan="2" class="dtFff pdleft20">
                                <?php echo $form->textField($model, 'mobile', array('class' => 'inputtxt','readOnly'=>'readOnly')) ?>
                                <span><?php echo CHtml::link(Yii::t('memberMember','修改绑定手机'),array(empty($model->mobile) ? '/member/home/registerStep2' : '/member/member/updateMobile')) ?></span>
                                <?php echo $form->error($model, 'mobile') ?>
                            </td>
                        </tr>                        
                        <tr>
                            <td height="30" colspan="3" align="center" class="dtffe">
                                <b><?php echo Yii::t('memberMember', '联系地址(用于接收会员卡、账单等资料)'); ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td height="30" align="center" class="dtEe"><?php echo Yii::t('memberMember', '居住地'); ?>：</td>
                            <td colspan="2" class="dtFff pdleft20">
                                <?php
                                echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                                    'prompt' => Yii::t('memberMember', '选择省份'),
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('/member/region/updateCity'),
                                        'dataType' => 'json',
                                        'data' => array(
                                            'province_id' => 'js:this.value',
                                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                        ),
                                        'success' => 'function(data) {
                            $("#Member_city_id").html(data.dropDownCities);
                            $("#Member_district_id").html(data.dropDownCounties);
                        }',
                                )));
                                ?>
                                <?php echo $form->error($model, 'province_id'); ?>
                                <?php
                                echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                                    'prompt' => Yii::t('memberMember', '选择城市'),
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('/member/region/updateArea'),
                                        'update' => '#Member_district_id',
                                        'data' => array(
                                            'city_id' => 'js:this.value',
                                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                        ),
                                )));
                                ?>
                                <?php echo $form->error($model, 'city_id'); ?>
                                <?php
                                echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                                    'prompt' => Yii::t('memberMember', '选择地区'),
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'data' => array(
                                            'city_id' => 'js:this.value',
                                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                        ),
                                )));
                                ?>
                                <?php echo $form->error($model, 'district_id'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td height="30" align="center" class="dtEe">
                                <?php echo $form->labelEx($model, 'street') ?>
                            </td>
                            <td colspan="2" class="dtFff pdleft20">
                                <?php echo $form->textField($model, 'street', array('class' => 'inputtxt')) ?>
                                <?php echo $form->error($model, 'street') ?>
                            </td>
                        </tr>

                        <tr>
                            <td height="30" colspan="3" align="center" class="dtffe">
                                <b><?php echo Yii::t('memberMember', '其他资料'); ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td height="30" align="center" class="dtEe">
                                <?php echo $form->labelEx($model, 'birthday') ?>
                            </td>
                            <td colspan="2" class="dtFff pdleft20">
                                <?php
                                $model->birthday = empty($model->birthday) ? null : date('Y-m-d', $model->birthday);
                                $this->widget('comext.timepicker.timepicker', array(
                                    'model' => $model,
                                    'name' => 'birthday',
                                    'select' => 'date',
                                    'options' => array(
                                        'yearRange' => '-100y',
                                        'class' => 'inputtxt',
                                    ),
                                ));
                                ?>
                                <?php echo $form->error($model, 'birthday') ?>
                                <script type="text/javascript">
                                    $("#yw0").addClass('inputtxt');
                                </script>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php echo CHtml::submitButton(Yii::t('memberMember', '保存资料'), array('class' => 'bankBtn', 'style' => 'cursor:pointer')) ?>
                <?php $this->endWidget(); ?>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>
<?php if(!$this->isMobile) $this->renderPartial('/layouts/_bindMobile',array('member'=>$this->model)); //去掉强制绑定手机号 ?>
<?php echo $this->renderPartial('/home/_sendMobileCodeJs'); ?>
<script type="text/javascript">
    $(function() {
        sendMobileCode2("#sendMobileCode");
    });
</script>