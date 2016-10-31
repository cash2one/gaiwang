<?php

/* @var $this PromotionStatisticsController */
/* @var $model PromotionStatistics */
$this->breadcrumbs = array(
    Yii::t('promotionStatistics', '统计管理'),
    Yii::t('promotionStatistics', ' 推广渠道列表') => array('admin'),
    Yii::t('promotionStatistics', '新会员列表'),
    Yii::t('promotionStatistics', '会员登录日志'),
);
?>
<div class="border-info search-form clearfix">
<table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo Yii:: t('member', '推广渠道名称')?>:</th>
            <td><?php echo $memInfo['name']?></td>
       </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo Yii:: t('member', '盖网编号')?>:</th>
            <td><?php echo $memInfo['gai_number']?></td>
       </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo Yii:: t('member', '用户名')?>:</th>
            <td><?php echo $memInfo['username']?></td>
       </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo Yii:: t('member', '累计登录次数')?>:</th>
            <td><?php echo $memInfo['logins']?></td>
       </tr>
    </table>
</div>
<div class="c10"></div>

<?php
    $this->widget('GridView', array(
        'id' => 'member-grid',
        'dataProvider' => $model->search(),
        'itemsCssClass' => 'tab-reg',
        'cssFile'   => false,
        'columns' => array(
             array(
                 'name' => 'login_time',
                 'value' => 'date("Y-m-d H:i:s",$data->login_time)',
               ),
               'ip',
        ),
        )
    );
?>