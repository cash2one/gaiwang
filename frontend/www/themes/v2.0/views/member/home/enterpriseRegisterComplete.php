
<div class="wrap">
    
	<div class="pages-header">
		<div class="w1200">
			<div class="pages-logo"><a href="<?php echo DOMAIN ?>"><img src="<?php echo DOMAIN?>/themes/v2.0/images/temp/register_logo.jpg" width="213" height="86" /></a></div>
			<div class="pages-title icon-cart"><?php echo Yii::t('home','欢迎注册')?></div>
			<div class="pages-top"><a href="#" title="法式精致顶级时尚"><img src="<?php echo DOMAIN?>/themes/v2.0/images/temp/register_advert215x90.jpg.jpg" width="215" height="90" /></a></div>
		</div>
	</div>	

	<div class="main w1200">
		<div class="setPassword-success">
			<div class="title icon-cart"><?php echo Yii::t('home','注册成功')?>！</div>
			<div class="message">
				<p><?php echo Yii::t('home','请尽快提交网络店铺入驻审核资料，审核成功后，您可享受在盖网商城开店')?><br /><?php echo Yii::t('home','和销售商品等一系列的优质服务')?>。</p>
			</div>
            <div class="determine">
                <?php echo CHtml::link(Yii::t('home','登录并提交资质'),array('/member/enterpriseLog/enterprise'),array('class'=>'btn-dete btn-dete3')); ?>
            </div>
		</div>
	</div>
    
</div>
