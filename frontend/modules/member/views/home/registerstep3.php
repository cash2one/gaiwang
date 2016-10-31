<?php
//普通会员注册完成页面
/* @var $this HomeController */
?>
<div class="top">
    <ul class="regTab clearfix">
        <li class="curr"><span><?php echo Yii::t('memberHome','普通用户注册'); ?></span></li>
    </ul>
</div>
<div class="registerCon">
    <div class="regStep">
        <ul class="s3 clearfix">
            <li><?php echo Yii::t('memberHome','1.填写账户信息'); ?></li>
            <li><?php echo Yii::t('memberHome','2.验证账户信息'); ?></li>
            <li><?php echo Yii::t('memberHome','3.完成注册'); ?></li>
        </ul>
    </div>

    <div class="regSuc">
        <?php if(!$model): ?>
        <h3>
			<?php echo Yii::t('memberHome','恭喜'); ?>，<?php echo $this->getUser()->name; ?> <?php echo Yii::t('memberHome','已注册成功！'); ?>
			<?php echo CHtml::link(Yii::t('memberHome','立即购物'),DOMAIN,array('class'=>'shoppingAtonce')); ?>
        </h3>
        <p><?php echo Yii::t('memberHome','您的昵称'); ?>：<strong class="red">
                <?php echo $this->getUser()->name; ?> </strong>
            <?php echo Yii::t('memberHome','会展示在页面顶部和商品评价等地方'); ?>
        </p>
        <?php else: ?>
            <h3><?php echo Yii::t('memberHome','恭喜'); ?>，
                <?php echo empty($model->username) ? $model->gai_number : $model->username ; ?>
                <?php echo Yii::t('memberHome','已注册成功！'); ?>
                <?php echo CHtml::link(Yii::t('memberHome','立即购物'),DOMAIN,array('class'=>'shoppingAtonce')); ?>
            </h3>
            <?php if(!empty($model->username)): ?>

            <p><?php echo Yii::t('memberHome','您的昵称'); ?>：<strong class="red">
                    <?php echo $model->username; ?> </strong>
                <?php echo Yii::t('memberHome','会展示在页面顶部和商品评价等地方'); ?>
            </p>
            <?php endif; ?>

        <?php endif; ?>
		<div class="do">
			<a href="#" class="checkRedBtn">查看红包</a>&nbsp;&nbsp;
			<a href="#" class="shoppingAtonce">商城首页</a>
		</div>
        <!--
        <div class="tips">
            <h2>超过80%的用户选择了立即验证邮箱，账户更安全购物更放心。</h2>
            <p>系统已向您的邮箱<strong style="color:#f60">992308247@qq.com</strong>发送了一封验证邮件，请您登录邮箱，点击邮件中的链接完成邮箱验证。如果您超过2分钟未收到邮件，您可以
                <a href="#" style="color:#005aa0">重新发送</a></p>
            <p><a href="#" class="loginEmail">登录邮箱</a></p>
        </div>
        -->
    </div>
</div>