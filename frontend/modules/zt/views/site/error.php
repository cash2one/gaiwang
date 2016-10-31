<div class="appwapper">
    <div class="site404Box">
        <dl class="clearfix">
            <dt class="site404Pic"></dt>
            <dd>
                <p class="bigTxt"><?php echo empty($message) ? Yii::t('zt','很抱歉，页面出现错误了!') : Yii::t('zt', CHtml::encode($message));?></p>
                <p class="samllTxt"><?php echo $code; ?></p>
                <p class="topmargin"><?php echo Yii::t('zt','建议您');?>：</p>
                <p class="backHome"><?php echo Yii::t('zt','看看输入的文字是否有误，点击'); echo CHtml::link(Yii::t('zt','返回专题首页'), $this->createAbsoluteUrl('/zt')); ?></p>
            </dd>
        </dl>

    </div>
</div>