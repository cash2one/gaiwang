<?php
/* @var $this  HomeController */
/** @var $model Member */
/** @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberMember','账户管理')=>'',
    Yii::t('memberMember',' 密码设置'),
);
?>
<div class="mbRight">
	<div class="EntInfoTab">
		<ul class="clearfix">
			<li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberMember','密码设置'); ?></span></a></li>
		</ul>
	</div>
    <div class="mbRcontent">
        <!--end 头像及基本信息-->
        <?php $this->renderPartial('/layouts/_summary'); ?>
        <!--end 头像及基本信息-->
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
		           <span class="titleLink">
                    	<h2><?php echo Yii::t('memberMember','密码设置'); ?></h2>
                        <p><?php echo Yii::t('memberMember','每一级密码所对应的功能保护'); ?>。</p>
                   </span>
                <div class="pwdProtect">
                       <span class="pwdstep01">
                            <h2><?php echo Yii::t('memberMember','一级密码（登录密码）'); ?>  </h2>
                            <p><?php echo Yii::t('memberMember','权限:登录网站账号。'); ?></p>
                       </span>
                    <?php echo CHtml::link(Yii::t('memberMember','修改'),
                        $this->createAbsoluteUrl('member/setPassword1'),array('class'=>'pwdEditbtn')) ?>
                </div>
                <div class="pwdProtect">
                        <span class="pwdstep02">
                            <h2><?php echo Yii::t('memberMember','二级密码（积分管理密码）'); ?> </h2>
                            <p><?php echo Yii::t('memberMember','权限:积分管理。'); ?></p>
                       </span>
                    <?php echo CHtml::link(Yii::t('memberMember','修改'),
                        $this->createAbsoluteUrl('member/setPassword2'),array('class'=>'pwdEditbtn')) ?>
                </div>
                <div class="pwdProtect ">
                        <span class="pwdstep03">
                            <h2><?php echo Yii::t('memberMember','三级密码（支付方式）'); ?>   </h2>
                            <p><?php echo Yii::t('memberMember','权限:购买商品，积分消费。'); ?></p>
                       </span>
                    <?php echo CHtml::link(Yii::t('memberMember','修改'),
                        $this->createAbsoluteUrl('member/setPassword3'),array('class'=>'pwdEditbtn')) ?>
                </div>
            </div>
            <div class="mbDate1_b"></div>

        </div>



    </div>
</div>
