<div class="main clearfix">
    <div class="aboutSlider fl">
        <ul class="clearfix">
            <li><?php echo CHtml::link('<p class="aTit">'.Yii::t('contact','关于盖网').'</p><p>About</p>', $this->createAbsoluteUrl('/about'), array('class' => 'it01')); ?></li>
            <li class="curr"><?php echo CHtml::link('<p class="aTit">'.Yii::t('contact','联系客服').'</p><p>Contact</p>', $this->createAbsoluteUrl('/contact'), array('class' => 'it02')); ?></li>
            <li><?php echo CHtml::link('<p class="aTit">'.Yii::t('contact','诚聘英才').'</p><p>Job</p>', $this->createAbsoluteUrl('/job'), array('class' => 'it03')); ?></li>
            <li><?php echo CHtml::link('<p class="aTit">'.Yii::t('contact','免责申明').'</p><p>Statement</p>', $this->createAbsoluteUrl('/statement'), array('class' => 'it04')); ?></li>
			<li><?php echo CHtml::link('<p class="aTit">'.Yii::t('privacy','隐私声明').'</p><p>Privacy</p>', $this->createAbsoluteUrl('/privacy'), array('class' => 'it05')); ?></li>
        </ul>
    </div>
    <div class="aboutMain fl">
<!--        <div class="aTop clearfix">-->
<!--            <span class="aH1">--><?php //echo Yii::t('contact','在线客服');?><!--<em>--><?php //echo Yii::t('contact','服务时间：周一至周五8:30-22：30');?><!--</em></span>-->
<!--            <span class="aIco0 aI01">--><?php //echo Yii::t('contact','感谢你的意见');?><!--</span>-->
<!--        </div>-->
        <div class="aboutContent contactService clearfix">
            <?php echo $article['content'] ?>
        </div>
    </div>
</div>


