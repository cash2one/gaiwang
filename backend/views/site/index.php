<span class="us-ico-convenient-title">快捷通道</span>
<div class="us-ico-convenient">
    <?php if (Yii::app()->user->checkAccess('Main.UserInfo')): ?>
        <a href="<?php echo $this->createAbsoluteUrl('/main/userInfo'); ?>" target="_top">
            <img alt="" src="../images/us-ico-1.gif">
        </a>
    <?php endif; ?>
    <?php if (Yii::app()->user->checkAccess('Main.SiteConfigurationManagement')): ?>
        <a href="<?php echo $this->createAbsoluteUrl('/main/siteConfigurationManagement'); ?>" target="_top">
            <img alt="" src="../images/us-ico-2.gif">
        </a>
    <?php endif; ?>
    <?php if (Yii::app()->user->checkAccess('Main.Administrators')): ?>
        <a href="<?php echo $this->createAbsoluteUrl('/main/administrators'); ?>" target="_top">
            <img alt="" src="../images/us-ico-3.gif">
        </a>
    <?php endif; ?>
    <?php if (Yii::app()->user->checkAccess('Main.MemberManagement')): ?>
        <a href="<?php echo $this->createAbsoluteUrl('/main/memberManagement'); ?>" target="_top">
            <img alt="" src="../images/us-ico-4.gif">
        </a>
    <?php endif; ?>
    <?php if (Yii::app()->user->checkAccess('Main.RechargeCashManagement')): ?>
        <a href="<?php echo $this->createAbsoluteUrl('/main/rechargeCashManagement'); ?>" target="_top">
            <img alt="" src="../images/us-ico-5.gif">
        </a>
    <?php endif; ?>
    <?php if (Yii::app()->user->checkAccess('Main.MallManagement')): ?>
        <a href="<?php echo $this->createAbsoluteUrl('/main/mallManagement'); ?>" target="_top">
            <img alt="" src="../images/us-ico-7.gif">
        </a>
    <?php endif; ?>
</div>



<div class="us-log clearfix">
    <div class="us-log-title"><span class="us-ico-convenient-time">系统日志</span></div>
    <?php if ($this->user->checkAccess('User/Log')): ?>
        <ul>
            <?php foreach ($dataProvider->getData() as $log): ?>
                <li><span><?php echo date('Y-m-d H:i:s', $log->create_time); ?></span><?php echo Tool::truncateUtf8String($log->info,'60'); ?></li>
            <?php endforeach; ?>
        </ul>
        <style>
            .us-log .pag li { display: inline; padding:0 10px; }
            .us-log .pag li.selected a { color: #000; font-weight: bold; }
            .pag { padding-bottom: 10px; }
        </style>
        <div style="text-align: center" class="pag">
            <?php
            $this->widget('CLinkPager', array(
                'header' => '',
                'cssFile' => false,
                'firstPageLabel' => Yii::t('comment', '首页'),
                'lastPageLabel' => Yii::t('comment', '末页'),
                'prevPageLabel' => Yii::t('comment', '上一页'),
                'nextPageLabel' => Yii::t('comment', '下一页'),
                'maxButtonCount' => 13,
                'pages' => $dataProvider->pagination
            ));
            ?>  
        </div>
    <?php endif; ?>
</div>
