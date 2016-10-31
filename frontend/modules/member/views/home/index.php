<?php
/* @var $this  HomeController */
/** @var $model Member */
$this->breadcrumbs = array(
    Yii::t('memberHome', '账号管理') => '',
    Yii::t('memberHome', '用户基本资料'),
);
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberHome', '用户基本信息'); ?></span></a></li>
            <li><?php echo CHtml::link('<span>' . Yii::t('memberHome', '头像设置') . '</span>', $this->createAbsoluteUrl('/member/member/avatar')) ?></li>
        </ul>
    </div>
    <div class="mbRcontent">
        <?php $this->renderPartial('/layouts/_summary'); ?>
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="upladaapBox">
                    <table width="980" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="51" height="30"></td>
                            <td width="86" height="30"><strong><?php echo Yii::t('memberHome', '账号信息预览'); ?></strong></td>
                            <td width="70" height="30"></td>
                            <td width="615" height="30"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td width="86"><?php echo $model->getAttributeLabel('gai_number') ?>：</td>
                            <td width="70"></td>
                            <td><font class="red"><?php echo $model->gai_number ?></font></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td width="86"><?php echo $model->getAttributeLabel('username') ?>：</td>
                            <td width="70"></td>
                            <td><?php echo $model->username ?></td>
                        </tr>
                    </table>
                </div>
                <div class="upladaapBox">
                    <table width="980" border="0" cellspacing="0" cellpadding="0" >
                        <tr>
                            <td width="51" height="30"></td>
                            <td width="86" height="30"><strong><?php echo Yii::t('memberHome', '固定资料'); ?></strong></td>
                            <td width="70" height="30"></td>
                            <td width="615" height="30"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td width="86" height="20"><?php echo $model->getAttributeLabel('real_name') ?>：</td>
                            <td width="70" height="20"></td>
                            <td height="20"><?php echo $model->real_name ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td height="20"><?php echo $model->getAttributeLabel('identity_type') ?>：</td>
                            <td height="20"></td>
                            <td height="20"><?php echo $model->identityType($model->identity_type) ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td height="20"><?php echo $model->getAttributeLabel('identity_number') ?>：</td>
                            <td height="20"></td>
                            <td height="20"><?php echo $model->identity_number ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td height="20"><?php echo $model->getAttributeLabel('sex') ?>：</td>
                            <td height="20"></td>
                            <td height="20"><?php echo $model->gender($model->sex) ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td width="86" height="20"><?php echo $model->getAttributeLabel('birthday') ?>：</td>
                            <td width="70" height="20"></td>
                            <td height="20"><?php echo $this->format()->formatDate($model->birthday); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="upladaapBox">
                    <table width="980" border="0" cellspacing="0" cellpadding="0" >
                        <tr>
                            <td width="51" height="30"></td>
                            <td width="86" height="30"><strong><?php echo Yii::t('memberHome', '手机绑定'); ?></strong></td>
                            <td width="70" height="30"></td>
                            <td width="615" height="30"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td width="86"><?php echo $model->getAttributeLabel('mobile') ?>：</td>
                            <td width="70"></td>
                            <td><?php echo $model->mobile ?></td>
                        </tr>
                    </table>
                </div>
                <div class="upladaapBox">
                    <table width="980" border="0" cellspacing="0" cellpadding="0" >
                        <tr>
                            <td width="51" height="30"></td>
                            <td width="86" height="30"><strong><?php echo Yii::t('memberHome', '联系地址'); ?></strong></td>
                            <td width="70" height="30"></td>
                            <td width="615" height="30"></td>
                        </tr>
                        <tr>
                            <td height="20"></td>
                            <td height="20"><?php echo Yii::t('memberHome', '居住地'); ?>：</td>
                            <td height="20"></td>
                            <td height="20"><?php echo Region::model()->getName($model->province_id, $model->city_id) ?></td>
                        </tr>
                        <tr>
                            <td height="20"></td>
                            <td height="20"><?php echo $model->getAttributeLabel('street') ?>：</td>
                            <td height="20"></td>
                            <td height="20"><?php echo CHtml::encode($model->street) ?></td>
                        </tr>
                        <tr>
                            <td height="20"></td>
                            <td width="86" height="20"><?php echo $model->getAttributeLabel('email') ?>：</td>
                            <td width="70" height="20"></td>
                            <td height="20"><?php echo $model->email ?></td>
                        </tr>
                    </table>
                </div>
                <table width="980" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center">
                            <?php echo CHtml::link('', $this->createAbsoluteUrl('/member/member/update'), array('class' => 'dateBtn mgtop20')) ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>