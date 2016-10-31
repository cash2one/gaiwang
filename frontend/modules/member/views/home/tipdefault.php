<?php
//注册后手机验证模板
/* @var $this HomeController */
/* @var $model Member */
?>
<?php $this->renderPartial('/layouts/_redad'); ?>
<div class="title clearfix">
	<?php echo CHtml::link('普通用户注册',Yii::app()->createAbsoluteUrl('/member/home/register'),array('class'=>'curr')) ?>
	<?php echo CHtml::link('企业用户注册',Yii::app()->createAbsoluteUrl('/member/home/registerEnterprise'));?>
</div>
<div class="content clearfix">
	<div class="regSuc">
		<h3 class="m_icon_v sucTip">恭喜，<?php
			if($model->mobile)
				echo  substr($model->mobile,0,3).'****'.substr($model->mobile,7,strlen($model->mobile))
			?>
			已注册成功！</h3>
	</div>
	<div class="sucInfo">
		<p>您的用户名：<span><?php echo !empty($model->username) ? $model->username : substr($model->mobile,0,3).'****'.substr($model->mobile,7,strlen($model->mobile)); ?></span>盖网号：<span><?php echo $model->gai_number ?></span> </p>
		<?php if($model->mobile): ?>
			<p>会展示在页面顶部和商品评价等地方，如不希望暴露，建议您：<a href="<?php echo Yii::app()->createAbsoluteUrl('/member/site/index'); ?>" title="" class="personInfo">完善个人资料</a></p>
			<p class="mgt40">
				<?php echo CHtml::link('查看红包',$this->createAbsoluteUrl('/member/redEnvelope/index'),array('class'=>'checkRedBtn')); ?>
				<a href="<?php echo DOMAIN ?>" title="盖象商城" class="shoppBtn">商城首页</a>
			</p>
		<?php else: ?>
			<p>
				温馨提示：请牢记盖网号，未绑定手机前这是您唯一登录凭证。建议您：
				<?php echo CHtml::link('完善个人资料查看红包',$this->createAbsoluteUrl('/member/redEnvelope/index'),array('class'=>'personInfo')); ?>
			</p>
		<?php endif; ?>
	</div>
	<?php $this->renderPartial('_kefu') ?>
</div>
<?php $this->renderPartial('_weixin') ?>
<?php $this->renderPartial('_statisticsJs',array('model'=>$model)) ?>
