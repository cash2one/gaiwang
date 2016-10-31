<?php
/* @var $this  HomeController */
/** @var $model Member */
/** @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberMember', '账户管理') => '',
    Yii::t('memberMember', ' 安全信息'),
);
?>
<div class="mbRight">
	<div class="EntInfoTab">
		<ul class="clearfix">
			<li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberMember','安全信息'); ?></span></a></li>
		</ul>
	</div>
    <div class="mbRcontent">
        <!--end 头像及基本信息-->
        <?php $this->renderPartial('/layouts/_summary'); ?>
        <!--end 头像及基本信息-->
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="saftBox">
                    <div class="saftBox_l">
                        <dt><a class="safeIcon1"></a></dt>
                        <dd><p class="mgtop10"><a><b><?php echo Yii::t('memberMember','身份认证'); ?></b></a></p>
                            <p class="gay95"><?php echo Yii::t('memberMember','用于提升账号的安全性和信任级别。认证后的有卖家记录的账号不能修改认证信息。'); ?></span></p>
                        </dd>
                    </div>
                    <div class="saftBox_r">
                    <?php if($model->identity_number): ?>
                        <span class="saftRtText"><?php echo Yii::t('memberMember','已完成'); ?></span>
                        <span class="saftRtIcon"></span>
                    <?php else: ?>
                        <span class="saftFtText"><?php echo Yii::t('memberMember','未完成'); ?></span>
                        <span class="saftFtIcon"></span>
                    <?php endif; ?>
                    </div>
                </div>

                <div class="saftBox">
                    <div class="saftBox_l">
                        <dt><a class="safeIcon2"></a></dt>
                        <dd>
                            <p class="mgtop10">
                            <a><b><?php echo Yii::t('memberMember','登录密码'); ?></b></a>
                            <?php echo CHtml::link(Yii::t('memberMember','更改'),
                                $this->createAbsoluteUrl('member/setPassword1'),array('class'=>'mbSafeqd')); ?>
                            </p>
                            <p class="gay95"><?php echo Yii::t('memberMember','用于账号登录'); ?></span></p>
                        </dd>
                    </div>
                    <div class="saftBox_r">
                        <?php if($model->password): ?>
                            <span class="saftRtText"><?php echo Yii::t('memberMember','已完成'); ?></span>
                            <span class="saftRtIcon"></span>
                        <?php else: ?>
                            <span class="saftFtText"><?php echo Yii::t('memberMember','未完成'); ?></span>
                            <span class="saftFtIcon"></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="saftBox">
                    <div class="saftBox_l">
                        <dt><a class="safeIcon3"></a></dt>
                        <dd>
                            <p class="mgtop10">
                                <a><b><?php echo Yii::t('memberMember','积分管理密码'); ?></b></a>
                                <?php echo CHtml::link(Yii::t('memberMember','更改'),
                                    $this->createAbsoluteUrl('member/setPassword2'),array('class'=>'mbSafeqd')); ?>
                            </p>
                            <p class="gay95"><?php echo Yii::t('memberMember','用于积分管理'); ?></span></p>
                        </dd>
                    </div>
                    <div class="saftBox_r">
                        <?php if($model->password2): ?>
                            <span class="saftRtText"><?php echo Yii::t('memberMember','已完成'); ?></span>
                            <span class="saftRtIcon"></span>
                        <?php else: ?>
                            <span class="saftFtText"><?php echo Yii::t('memberMember','未完成'); ?></span>
                            <span class="saftFtIcon"></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="saftBox">
                    <div class="saftBox_l">
                        <dt><a class="safeIcon4"></a></dt>
                        <dd>
                            <p class="mgtop10"><a><b><?php echo Yii::t('memberMember','支付密码'); ?></b></a>
                                <?php echo CHtml::link(Yii::t('memberMember','更改'),
                                    $this->createAbsoluteUrl('member/setPassword3'),array('class'=>'mbSafeqd')); ?>
                            <p class="gay95"><?php echo Yii::t('memberMember','用于交易支付'); ?></span></p>
                        </dd>
                    </div>
                    <div class="saftBox_r">
                        <?php if($model->password3): ?>
                            <span class="saftRtText"><?php echo Yii::t('memberMember','已完成'); ?></span>
                            <span class="saftRtIcon"></span>
                        <?php else: ?>
                            <span class="saftFtText"><?php echo Yii::t('memberMember','未完成'); ?></span>
                            <span class="saftFtIcon"></span>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
            <div class="mbDate1_b"></div>

        </div>

    </div>
</div>
