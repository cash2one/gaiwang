<?php
/* @var $this Controller */
// 会员中心左侧菜单视图
?>
<div class="mbMeun">
    <div class="title"></div>
    <div class="mbMeunBtm">
        <div class="title">
            <div class="mbIcon1"></div>
            <span><?php echo Yii::t('member', '账户管理'); ?></span></div>
        <ul>
            <div class="mb_t">
                <a  class="mbG">
                    <?php echo $this->getSession('enterpriseId') ? Yii::t('member', '企业信息') : Yii::t('member', '个人信息'); ?>
                </a>
                <a class="mbIcon2"></a>
            </div>
            <?php foreach ($this->getMenu('userInfo') as $v): ?>
                <?php
                //普通会员\线下不显示网签
                if( (!$this->getSession('enterpriseId') || $this->getSession('enterpriseFlag')==Enterprise::FLAG_OFFLINE  ) && $v['url'] == 'enterpriseLog/process' ) continue; ?>
                <li <?php echo in_array($this->id . '/' . $this->action->id, $v['curr']) ? 'class="curr"' : null ?> >
                    <?php echo CHtml::link($v['name'], $this->createAbsoluteUrl($v['url'])) ?>
                    <?php if ($v['url'] == 'message/index'): //消息 ?>
                       <span class="mbIcon3" id="messageNumber"></span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if($this->getSession('enterpriseId')): ?>
            <div class="title">
                <div class="enterIcon"></div>
                <span><?php echo Yii::t('member','企业管理');?></span></div>
            <ul>
                <?php foreach ($this->getMenu('qy') as $v): ?>
                    <li <?php echo in_array($this->id . '/' . $this->action->id, $v['curr']) ? 'class="curr"' : null ?> >
                        <?php echo CHtml::link($v['name'], $this->createAbsoluteUrl($v['url'])) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="title">
            <div class="mbIcon4"></div>
            <span><?php echo Yii::t('member','积分管理');?></span></div>
        <ul>
            <?php foreach ($this->getMenu('jf') as $v): ?>
                <?php if($v['url']=='giveCash/index' && substr($this->getUser()->gw,0,4)!='GW03'){
                    continue; //只有gw03 的用户，可以使用派发红包的功能
                }?>
                <li <?php echo in_array($this->id . '/' . $this->action->id, $v['curr']) ? 'class="curr"' : null ?> >
                    <?php echo CHtml::link($v['name'], $this->createAbsoluteUrl($v['url']),isset($v['title'])?array('title'=>$v['title']):array()) ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="title">
            <div class="mbIcon5"></div>
            <span><?php echo Yii::t('member','买入管理');?></span></div>
        <ul>
            <?php foreach ($this->getMenu('order') as $k => $v): ?>
                <li <?php echo in_array($this->id . '/' . $this->action->id, $v['curr']) ? 'class="curr"' : null ?> >
                    <?php echo CHtml::link($v['name'], $this->createAbsoluteUrl($v['url'])) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<script>
    $(function(){
        window.unreadMessageNum = true;
        $.get("<?php echo $this->createAbsoluteUrl('message/unreadMessageNum') ?>",function(num){
            $("#messageNumber").html(num);
            window.unreadMessageNum = false;
        });
    });
</script>