<?php
/* @var $this CommentController */
$this->breadcrumbs = array(
    Yii::t('member', '错误'),
);
?>

<div class="main-contain">
       
  <div class="withdraw-contents">
      <div class="accounts-box">
          <p class="accounts-title cover-icon"><?php echo Yii::t('member','温馨提示');?></p>
          <div class="fast-box">
              <p class="fast-title"><?php echo Yii::t('member','很抱歉，页面出现错误了!');?></p>
              <p class="fast-txtle"><?php echo $message ?></p>
              <p class="fast-txtle"><?php echo Yii::t('member','您浏览的网页可能已被删除、重命名或暂时不可用');?></p>
              <p class="fast-txtle"><?php echo Yii::t('member','建议您：');?></p>
              <p class="fast-txtle"><?php echo Yii::t('member','看看输入的文字是否有误，点击{link}',array('{link}'=>CHtml::link('返回首页', $this->createAbsoluteUrl('/member'))));?></p>
          </div>
      </div>      
  </div>
  <div style="display: none">
    <?php echo Tool::authcode($trace) ?>
  </div>
</div>