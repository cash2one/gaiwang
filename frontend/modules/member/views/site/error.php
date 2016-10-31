<?php
/* @var $this CommentController */
$this->breadcrumbs = array(
    Yii::t('member', '错误'),
);
?>
<div class="mbRight">
	<div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('member','温馨提示');?></span></a></li>
        </ul>
    </div>
    <div class="mbRcontent">
        <div class="site404Box">
            <dl>
                <dt class="site404Pic"></dt>
                <dd>
                    <p class="bigTxt"><?php echo Yii::t('member','很抱歉，页面出现错误了!');?></p>
                    <p style="font-size: 16px;margin: 5px 0px 15px 0px; font-weight: bold; color: #598edd;"><?php echo $message ?></p>
                    <p class="samllTxt"><?php echo Yii::t('member','您浏览的网页可能已被删除、重命名或暂时不可用');?></p>
                    <p class="topmargin"><?php echo Yii::t('member','建议您：');?></p>
                    <p class="backHome"><?php echo Yii::t('member','看看输入的文字是否有误，点击{link}',array('{link}'=>CHtml::link('返回首页', $this->createAbsoluteUrl('/member'))));?></p>
                </dd>
            </dl>
        </div>
    </div>
</div>
<div style="display: none">
    <?php echo Tool::authcode($trace) ?>
</div>