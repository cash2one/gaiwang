<?php
/**
 * 客服联系方式
 * Created by PhpStorm.
 * User: binbin.liao
 * Date: 2014/12/4
 * Time: 10:39
 */
$siteConfig = $this->getConfig('site');
$phone = $siteConfig['phone'];
$qqArr = Tool::getBackendQQ($siteConfig['qq']);
$q = array_shift($qqArr);
?>
<div class="serviceTell clearfix">
    <a target="_blank"
       href="<?php echo "http://wpa.qq.com/msgrd?v=3&amp;uin={$q['qq']}&amp;site=qq&amp;menu=yes"; ?>">
        <img class="kf-img" src="<?php echo "http://wpa.qq.com/pa?p=2:{$q['qq']}:41"; ?>"
             alt="<?php echo Yii::t('goods', '点击这里给我发消息'); ?>" title="<?php echo Yii::t('goods', '点击这里给我发消息'); ?>">
    </a>&nbsp;&nbsp;
    <span>客服电话：<?php echo $phone; ?></span>
</div>