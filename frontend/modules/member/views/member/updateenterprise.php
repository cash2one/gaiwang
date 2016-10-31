<?php
/* @var $this  HomeController */
/** @var $model Member */
/** @var $modelInfo Enterprise */
/** @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberMember', '账号管理') => '',
    Yii::t('memberMember', '基本信息修改'),
);
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

<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr">
                <a href="javascript:;">
                    <span><?php echo Yii::t('memberMember','基本信息修改'); ?></span>
                </a>
            </li>
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
                    'id' => 'member-form',
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
                                <b><?php echo Yii::t('memberMember', '账号信息'); ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td width="127" height="25" align="center" class="dtEe"><?php echo Yii::t('memberMember','会员号码'); ?>：</td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo $model->gai_number ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="127" height="25" align="center" class="dtEe"><?php echo Yii::t('memberMember','登录名'); ?>：</td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                            <?php echo $model->username ?>
                            </td>
                        </tr>

                        <tr>
                            <td height="50" colspan="3" align="center" class="dtffe">
                                <b><?php echo Yii::t('memberMember', '时间信息'); ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td width="127" height="25" align="center" class="dtEe"><?php echo Yii::t('memberMember','开始服务时间'); ?>：</td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                                <?php echo $this->format()->formatDatetime($modelInfo->service_start_time) ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="127" height="25" align="center" class="dtEe"><?php echo Yii::t('memberMember','结束服务时间'); ?>：</td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                                <?php echo $this->format()->formatDatetime($modelInfo->service_end_time) ?>
                            </td>
                        </tr>

                        <tr>
                            <td height="50" colspan="3" align="center" class="dtffe">
                                <b><?php echo Yii::t('memberMember', '公司信息'); ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td width="127" height="25" align="center" class="dtEe">
                                <?php echo Yii::t('memberMember','公司名称'); ?>：
                            </td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                                <?php echo $modelInfo->name; ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="127" height="25" align="center" class="dtEe">
                                <?php echo $form->labelEx($modelInfo, 'short_name') ?>：
                            </td>
                            <td height="25" colspan="2" class="dtFff pdleft20">
                                <?php echo $form->textField($modelInfo, 'short_name', array('class' => 'inputtxt')) ?>
                                <?php echo $form->error($modelInfo, 'short_name') ?>
                            </td>
                        </tr>
                        <tr>
                            <td height="30" align="center" class="dtEe">
                                <?php echo Yii::t('memberMember', '公司地址'); ?>：
                            </td>
                            <td colspan="2" class="dtFff pdleft20">
                                <?php
                                echo $form->dropDownList($modelInfo, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
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
                            $("#Enterprise_city_id").html(data.dropDownCities);
                            $("#Enterprise_district_id").html(data.dropDownCounties);
                        }',
                                    )));
                                ?>
                                <?php echo $form->error($modelInfo, 'province_id'); ?>
                                <?php
                                echo $form->dropDownList($modelInfo, 'city_id', Region::getRegionByParentId($modelInfo->province_id), array(
                                    'prompt' => Yii::t('memberMember', '选择城市'),
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('/member/region/updateArea'),
                                        'update' => '#Enterprise_district_id',
                                        'data' => array(
                                            'city_id' => 'js:this.value',
                                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                        ),
                                    )));
                                ?>
                                <?php echo $form->error($modelInfo, 'city_id'); ?>
                                <?php
                                echo $form->dropDownList($modelInfo, 'district_id', Region::getRegionByParentId($modelInfo->city_id), array(
                                    'prompt' => Yii::t('memberMember', '选择地区'),
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'data' => array(
                                            'city_id' => 'js:this.value',
                                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                        ),
                                    )));
                                ?>
                                <?php echo $form->error($modelInfo, 'district_id'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td height="30" align="center" class="dtEe">
                                <?php echo $form->labelEx($modelInfo, 'street') ?>
                            </td>
                            <td colspan="2" class="dtFff pdleft20">
                                <?php echo $form->textField($modelInfo, 'street', array('class' => 'inputtxt')) ?>
                                <?php echo $form->error($modelInfo, 'street') ?>
                            </td>
                        </tr>

                        <tr>
                            <td height="30" colspan="3" align="center" class="dtffe">
                                <b><?php echo Yii::t('memberMember', '联系人资料'); ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td height="30" align="center" class="dtEe">
                                <?php echo $form->labelEx($modelInfo, 'link_man') ?>
                            </td>
                            <td colspan="2" class="dtFff pdleft20">
                                <?php echo $form->textField($modelInfo, 'link_man', array('class' => 'inputtxt')) ?>
                                <?php echo $form->error($modelInfo, 'link_man') ?>
                            </td>
                        </tr>
                        <tr>
                            <td height="30" align="center" class="dtEe">
                                <?php echo $form->labelEx($modelInfo, 'email') ?>
                            </td>
                            <td colspan="2" class="dtFff pdleft20">
                                <?php echo $form->textField($modelInfo, 'email', array('class' => 'inputtxt')) ?>
                                <?php echo $form->error($modelInfo, 'email') ?>
                            </td>
                        </tr>
                        <tr>
                            <td height="30" align="center" class="dtEe">
                                <?php echo $form->labelEx($modelInfo, 'department') ?>
                            </td>
                            <td colspan="2" class="dtFff pdleft20">
                                <?php echo $form->dropDownList($modelInfo, 'department', Enterprise::departmentArr()) ?>
                                <?php echo $form->error($modelInfo, 'department') ?>
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
                                <?php echo $form->error($model, 'mobile') ?>
                            </td>
                        </tr>                      
                   </tbody>
                </table>
                <?php echo CHtml::submitButton(Yii::t('memberMember','保存资料'), array('class' => 'bankBtn', 'style' => 'cursor:pointer')) ?>
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