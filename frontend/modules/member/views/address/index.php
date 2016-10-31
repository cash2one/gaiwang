<?php
/* @var $this AddressController */
/* @var $model Address */
/* @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberAddress', '买入管理') => '',
    Yii::t('memberAddress', '收货地址'),
);
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberAddress', '收货地址'); ?></span></a></li>
        </ul>
    </div>
    <div class="mbRcontent">
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="mgtop20 upladBox "><h3><?php echo Yii::t('memberAddress', '收货地址'); ?></h3>
                    <p class="integaralbd pdbottom10"><?php echo Yii::t('memberAddress', '让你购买的商品运送到你所在的地方'); ?>。</p>
                </div>
                <div class="upladBox mgtop20"><b class="mgleft5"><?php echo Yii::t('memberAddress', '带'); ?><span class="required">*</span><?php echo Yii::t('memberAddress', '号均为必填项'); ?></b></div>
                <?php if (Yii::app()->user->hasFlash('maxAddress')): ?>
                    <!--确定删除弹框-->
                    <div class="alterBox" id="alterBox">
                        <a  class="btnClose" onclick="document.getElementById('alterBox').style.display = 'none'">X</a>
                        <p><b style="color:red;"><?php echo $this->getFlash('maxAddress'); ?></b></p>
                        <p><?php echo Yii::t('memberAddress', '请不要重复此操作!'); ?></p>
                        <span><a onclick="document.getElementById('alterBox').style.display = 'none'"><?php echo Yii::t('memberAddress', '关闭'); ?></a></span>
                    </div>
                    <!--确定删除弹框--> 
                <?php endif; ?>
                <div class="upladBox mgtop20">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'address-form',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true, //客户端验证
                        ),
                    ));
                    ?>
                    <div class="addressBox" >
                        <dl class="clearfix">
                            <dt><?php echo $form->labelEx($model, 'real_name'); ?></dt>
                            <dd>
                                <?php echo $form->textField($model, 'real_name', array('class' => 'integaralIpt4')); ?>
                                <?php echo $form->error($model, 'real_name'); ?>
                            </dd>
                        </dl>
                        <dl class="clearfix">
                            <dt><?php echo $form->labelEx($model, 'province_id'); ?></dt>
                            <dd><div class="addSelect fl">
                                    <?php
                                    echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                                        'prompt' => Yii::t('memberAddress', '选择省份'),
                                        'class' => 'integaralXz mgleft5',
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'url' => $this->createAbsoluteUrl('/member/region/updateCity'),
                                            'dataType' => 'json',
                                            'data' => array(
                                                'province_id' => 'js:this.value',
                                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                            ),
                                            'success' => 'function(data) {
                                        $("#Address_city_id").html(data.dropDownCities);
                                        $("#Address_district_id").html(data.dropDownCounties);
                                    }',
                                    )));
                                    ?>
                                    <br/><?php echo $form->error($model, 'province_id'); ?></div>
                                <div class="addSelect fl"> <?php
                                    echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                                        'prompt' => Yii::t('memberAddress', '选择城市'),
                                        'class' => 'integaralXz mgleft5',
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'url' => $this->createAbsoluteUrl('/member/region/updateArea'),
                                            'update' => '#Address_district_id',
                                            'data' => array(
                                                'city_id' => 'js:this.value',
                                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                            ),
                                    )));
                                    ?><br/>
                                    <?php echo $form->error($model, 'city_id'); ?></div>
                                <div class="addSelect fl">
                                    <?php
                                    echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                                        'prompt' => Yii::t('memberAddress', '选择区/县'),
                                        'class' => 'integaralXz mgleft5',
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'data' => array(
                                                'city_id' => 'js:this.value',
                                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                            ),
                                    )));
                                    ?><br/>
                                    <?php echo $form->error($model, 'district_id'); ?></div>
                            </dd>
                        </dl>
                        <dl class="clearfix" >
                            <dt><?php echo $form->labelEx($model, 'street'); ?></dt>
                            <dd>
                                <?php echo $form->textArea($model, 'street', array('class' => 'txtYbl')); ?>
                                <?php echo $form->error($model, 'street'); ?>
                            </dd>
                        </dl>
                        <dl class="clearfix">
                            <dt><?php echo $form->labelEx($model, 'zip_code'); ?> </dt>
                            <dd>
                                <?php echo $form->textField($model, 'zip_code', array('class' => 'integaralIpt4')); ?>
                                <span class="gay95 mgleft5"><?php // echo Yii::t('memberAddress', '大陆以外地区可不填写'); ?></span>
                                <?php echo $form->error($model, 'zip_code'); ?>
                            </dd>
                        </dl>
                        <dl class="clearfix">
                            <dt><?php echo $form->labelEx($model, 'mobile'); ?></dt>
                            <dd>
                                <?php echo $form->textField($model, 'mobile', array('class' => 'integaralIpt4')); ?>
                                <span class="gay95 mgleft5"><?php echo Yii::t('memberAddress', '手机号码必填'); ?></span>
                                <?php echo $form->error($model, 'mobile'); ?>
                            </dd>
                        </dl>
                        <dl class="clearfix">
                            <dt><?php echo Yii::t('memberAddress', '设为默认'); ?>：</dt>
                            <dd><?php echo $form->checkBox($model, 'default'); ?></dd>
                        </dl>
                    </div>
                </div>
                <?php echo CHtml::submitButton(Yii::t('message', '保存收货地址'), array('class' => 'addressBtn')); ?>
                <?php $this->endWidget(); ?>
                <?php if ($address): ?>
                    <table width="890" border="0"  cellpadding="0" cellspacing="0" class="integralTab mgleft45">
                        <tr>
                            <td width="133" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberAddress', '收货人'); ?></b></td>
                            <td width="187" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberAddress', '地区'); ?></b></td>
                            <td width="230" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberAddress', '街道地址'); ?></b></td>
                            <td width="78" align="center" class="tdBg"><b><?php echo Yii::t('memberAddress', '邮编'); ?></b></td>
                            <td width="100" align="center" class="tdBg"><b><?php echo Yii::t('memberAddress', '手机号码'); ?></b></td>
                            <td width="160" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberAddress', '操作'); ?></b></td>
                        </tr>
                    </table>
                    <table width="890" border="0"  cellpadding="0" cellspacing="0" class="tableBank mgleft45">
                        <?php $i = 1; ?>
                        <?php foreach ($address as $as): ?>
                            <tr>
                                <td width="133" height="35" align="center" valign="middle" class="<?php if ($i % 2 == 0): ?>bgF5<?php else: ?>bgF4<?php endif; ?>"><?php echo $as->real_name; ?></td>
                                <td width="187" height="35" align="center" valign="middle" class="bgF4">
                                    <?php echo isset($as->province) ? $as->province->name : ""; ?>-<?php echo isset($as->city) ? $as->city->name : ""; ?>-<?php echo isset($as->district) ? $as->district->name : ""; ?>
                                </td>
                                <td width="230" height="35" align="center" valign="middle" class="bgF4"><?php echo $as->street; ?></td>
                                <td width="78" height="35" align="center" valign="middle" class="bgF4"><?php echo $as->zip_code; ?></td>
                                <td width="100" height="35" align="center" valign="middle" class="bgF4"><b><?php echo $as->mobile; ?></b></td>
                                <td width="160" height="35" align="center" valign="middle" class="bgF4 pdleft20" >
                                    <?php if ($as->default): ?>
                                        <a class="defaultBtn"><?php echo Yii::t('memberAddress', '默认'); ?></a>
                                    <?php else: ?>
                                        <?php echo CHtml::link(Yii::t('memberAddress', '设为默认'), $this->createAbsoluteUrl('/member/address/set', array('id' => $as->id))); ?>
                                    <?php endif; ?>
                                    <?php echo CHtml::link(Yii::t('memberAddress', '编辑'), $this->createAbsoluteUrl('/member/address/update', array('id' => $as->id)), array('class' => 'mgleft5 ftstyle')); ?>
                                    <?php echo CHtml::link(Yii::t('memberAddress', '删除'), $this->createAbsoluteUrl('/member/address/delete', array('id' => $as->id)), array('class' => 'mgleft5 ftstyle', 'confirm' => Yii::t('memberAddress', '你确定的要删除这条数据吗 ?'))); ?>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </table>
                    <div class="upladBox mgtop5"><span class="fr mgright15"><?php echo Yii::t('memberAddress', '最多可存10个收货地址'); ?></span></div>
                <?php endif; ?>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>
