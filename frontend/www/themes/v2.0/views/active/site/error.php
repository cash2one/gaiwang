<div class="appwapper">
    <div class="site404Box">
        <dl class="clearfix">
            <dt class="site404Pic"></dt>
            <dd>
                <p class="bigTxt"><?php echo empty($message) ? Yii::t('active','很抱歉，页面出现错误了!') : Yii::t('zt', CHtml::encode($message));?></p>
                <p class="samllTxt"><?php echo $code; ?></p>
                <p class="topmargin"><?php echo Yii::t('active','建议您');?>：</p>
                <p class="backHome"><a href="http://zt.g-emall.com" target="_self">返回活动道页</a></p>
            </dd>
        </dl>

    </div>
</div>