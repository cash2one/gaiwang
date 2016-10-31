<?php
$siteConfig = $this->getConfig('site');
$phone = $siteConfig['phone'];
$workingTime = $siteConfig['description'];
$qq = Tool::getBackendQQ($siteConfig['qq']);
?>
    <ul class="wq">
        <li>
            <div class="wqTit">
                <span class="ico_onlineServ"></span>
                <span class="Serv"><?php echo Yii::t('goods', '在线服务'); ?></span>
            </div>
            <div class="wqCon">
                <h3><?php echo Yii::t('goods', '在线客服：通过在线解答的方式为您提供咨询服务'); ?></h3>
                <?php echo Yii::t('goods',$workingTime); ?>
                <p class="service clearfix">
                    <?php foreach ($qq as $q): ?>
                        <a target="_blank"
                           href="<?php echo "http://wpa.qq.com/msgrd?v=3&amp;uin={$q['qq']}&amp;site=qq&amp;menu=yes"; ?>">
                            <img class="kf-img" src="<?php echo "http://wpa.qq.com/pa?p=2:{$q['qq']}:41"; ?>"
                                 alt="<?php echo Yii::t('goods', '点击这里给我发消息'); ?>" title="<?php echo Yii::t('goods', '点击这里给我发消息'); ?>">
                            <span class="kf-name"><?php echo Yii::t('goods',$q['text']); ?></span>
                        </a>&nbsp;&nbsp;
                    <?php endforeach; ?>
                </p>
            </div>
        </li>
        <li class="noline">
            <div class="wqTit">
                <span class="ico_phoServ"></span>
                <span class="Serv"><?php echo Yii::t('goods', '电话服务'); ?></span>
            </div>
            <div class="wqCon">
                <h3><?php echo Yii::t('goods', '在线客服：通过在线解答的方式为您提供咨询服务'); ?></h3>
                <?php echo Yii::t('goods',$workingTime); ?>
                <h1><?php echo $phone; ?></h1>
            </div>
        </li>
    </ul>