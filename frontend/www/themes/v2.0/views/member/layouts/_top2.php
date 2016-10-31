
<div class="member-top">
    <div class="w1200 clearfix">
        <a href="<?php echo $this->createAbsoluteUrl('/member/site/index');?>" class="member-logo"></a>
        <div class="member-nav fl clearfix">
            <a href="<?php echo $this->createAbsoluteUrl('/member/site/index');?>" <?php if($this->id=='site'):?> class="active" <?php endif;?>><?php echo Yii::t('site', '首页');?></a>
            <a href="<?php echo $this->createAbsoluteUrl('/member/goodsCollect');?>" <?php if($this->id=='goodsCollect' || $this->id=='storeCollect'):?> class="active" <?php endif;?>><?php echo Yii::t('site', '我的收藏');?></a>
            <a href="<?php echo $this->createAbsoluteUrl('/member/member/accountSafe');?>" <?php if($this->id=='member' && $this->action->id=='accountSafe'):?> class="active" <?php endif;?>><?php echo Yii::t('site', '账户安全');?></a>
            <a href="<?php echo $this->createAbsoluteUrl('/member/message/index');?>" <?php if($this->id=='message'):?> class="active" <?php endif;?>><?php echo Yii::t('site', '消息');?>（<span id="message_num">0</span>）</a>
        </div>
        <form class="member-search clearfix" id="home-form" action="<?php echo $this->createAbsoluteUrl('/search/search'); ?>" target="_blank" method="get">
            <input maxlength="50" type="search" id="member_keyword" class="search-input" placeholder="<?php echo Yii::t('site', '输入关键词进行搜索'); ?>" name="q"  accesskey="s" autofocus="true"/>
            <input type="submit" class="search-btn" id="member_search" value="<?php echo Yii::t('site', '搜索');?>"/>
        </form>
    </div>
</div>