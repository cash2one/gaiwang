<div class="redEnvWrap">
	<div class="w1200 clearfix">
		<a class="logo fl" href="<?php echo DOMAIN ?>" title="盖网">
			<img alt="盖网" src="<?php echo DOMAIN.'/images/bgs/logo186X75.png'?>" width="186" height="75"/>
		</a>
		<ul class="navItems03 clearfix">
<!--	class = "curr"  表示选中的是哪个		-->
			<li class="curr"><?php echo CHtml::link(Yii::t('site', '红包首页'), $this->createAbsoluteUrl('/hongbao'), array('class' => 'current', 'title' => Yii::t('site', '红包首页'))); ?></li>
            <!--<li><?php //echo CHtml::link(Yii::t('site', '红包汇'), $this->createAbsoluteUrl('/hongbao/site/list'), array('title' => Yii::t('site', '红包汇'))); ?></li>-->
            <li><?php echo CHtml::link(Yii::t('site', '红包专场'), $this->createAbsoluteUrl('/hongbao/site/share'), array('title' => Yii::t('site', '红包专场'))); ?></li>
			<li>
                <?php echo CHtml::link(Yii::t('site','获奖名单'),$this->createAbsoluteUrl('/hongbao/site/prizeName')) ?>
            </li>
		</ul>
        <div class="redEnvNum clearfix">
            <?php $count = Coupon::getCountCoupon(Activity::TYPE_REGISTER);
                $len = strlen($count);
                $countSpan = 9;
                if($len < $countSpan){
                    $count = str_repeat('0',($countSpan - $len)) . (String)$count;
                }
            ?>
            <span class="t"><?php echo Yii::t('site', '盖象注册已送出红包：') ?></span>
            <div class="num clearfix">
                <?php for($i=0;$i<$countSpan;$i++): ?>
                    <span class="no<?php echo $count[$i] ?>"> <?php echo $count[$i] ?> </span>
                <?php endfor ?>
                <span class="unit">个</span>
            </div>
        </div>
	</div>
</div>
