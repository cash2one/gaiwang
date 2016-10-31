<?php $this->renderPartial('/layouts/_redad'); ?>
<div class="title clearfix">
	<?php echo CHtml::link('普通用户注册',Yii::app()->createAbsoluteUrl('/member/home/register')) ?>
	<?php echo CHtml::link('企业用户注册',Yii::app()->createAbsoluteUrl('/member/home/registerEnterprise'),array('class'=>'curr'));?>
</div>
<div class="content clearfix">
    <div class="regSuc">
        <p class="m_icon_v sucTip">注册成功！</p>
	</div>
	<p class="comTips">
		温馨提示：请尽快提交网络店铺入驻审核资料，审核成功后，您可享受在盖象商城开店<br/>并销售商品等一系列的优质服务。
	</p>
	<div class="profileDo">
		<?php echo CHtml::link('提交资质',array('/member/enterpriseLog/enterprise'),array('class'=>'btnModify')); ?>
	</div>
	<?php $this->renderPartial('_kefu') ?>
</div>
<?php $this->renderPartial('_weixin') ?>
<?php $this->renderPartial('_statisticsJs',array('model'=>$model)) ?>

