<?php
$siteConfig = $this->getConfig('site');
$phone = $siteConfig['phone'];
$workingTime = $siteConfig['description'];
$qq = Tool::getBackendQQ($siteConfig['qq']);
?>
<ul class="clearfix">
  <li class="pdTab3-liIco"><img width="83" height="83" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl;?>/images/bgs/pord-QQico.jpg"/></li>
  <li>
      <dl class="pdTab3-info">
          <dt><?php echo Yii::t('goods', '在线服务'); ?>：</dt>
          <dd><?php echo Yii::t('goods', '通过在线解答的方式为您提供咨询服务'); ?></dd>
          <dt><?php echo Yii::t('goods', '工作时间'); ?>： </dt>
          <dd><?php echo Yii::t('goods',$workingTime); ?></dd>
          <dt><?php echo Yii::t('goods', '客服QQ'); ?>：</dt>
          <dd><ul class="clearfix">
              <?php foreach ($qq as $q): ?>
                  <li><a target="_blank" class="pdTab-QQIco" href="<?php echo "http://wpa.qq.com/msgrd?v=3&amp;uin={$q['qq']}&amp;site=qq&amp;menu=yes"; ?>">
                      <img  width="77" height="22" src="<?php echo "http://wpa.qq.com/pa?p=2:{$q['qq']}:41"; ?>" alt="<?php echo Yii::t('goods', '点击这里给我发消息'); ?>" title="<?php echo Yii::t('goods', '点击这里给我发消息'); ?>"></a>
                      <span class="pdTab-font1"><?php echo Yii::t('goods',$q['text']); ?></span></li>
              <?php endforeach; ?>
          </ul></dd>
      </dl>
  </li>
  <li class="pdTab3-liIco"><img width="83" height="83" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl;?>/images/bgs/pord_phoneico.jpg"/></li>
  <li>
      <div class="pdTab-line"></div>
      <dl class="pdTab3-info">
          <dt><?php echo Yii::t('goods', '电话服务'); ?>：</dt>
          <dd><?php echo Yii::t('goods', '通过电话的方式为您提供咨询服务'); ?></dd>
          <dt><?php echo Yii::t('goods', '工作时间'); ?>：</dt>
          <dd><?php echo Yii::t('goods',$workingTime); ?></dd>
          <dt><?php echo Yii::t('goods', '客服电话'); ?>： </dt>
          <dd><span class="pdTab-font2"><?php echo $phone; ?></span></dd>
      </dl>
  </li>
</ul>