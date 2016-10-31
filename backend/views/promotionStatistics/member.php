<?php

/* @var $this PromotionStatisticsController */
/* @var $model PromotionStatistics */
$this->breadcrumbs = array(
    Yii::t('promotionStatistics', '统计管理'),
    Yii::t('promotionStatistics', ' 推广渠道列表') => array('admin'),
    Yii::t('promotionStatistics', '新会员列表'),
);
?>
<?php
    $this->renderPartial('_searchMember', array(
            'model' => $model
        )); 
  ?>
<div>
<table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo Yii:: t('member', '推广渠道名称')?>:</th>
            <td><?php echo $promotionInfo->name;?></td>
       </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo Yii:: t('member', '注册页面类型')?>:</th>
            <td><?php echo PromotionChannels::getLoginType($promotionInfo->register_type);?></td>
       </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo Yii:: t('member', '注册页面访问数')?>:</th>
            <td><?php echo $promotionInfo->visits;?></td>
       </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo Yii:: t('member', '引入新会员数')?>:</th>
            <td><?php echo $promotionInfo->new_members;?></td>
       </tr>
    </table>
</div>
<div class="c10"></div>
<?php
    $this->widget('GridView', array(
        'id' => 'member-grid',
        'dataProvider' => $model->searchPromotionMem(),
        'itemsCssClass' => 'tab-reg',
        'cssFile'   => false,
        'columns' => array(
            'gai_number',
            'username',
            'mobile',
            array(
                 'name' => Yii::t('home', '登录次数'),
                 'value' => '$data->logins',
                ),
             array(
                 'name' => 'register_time',
                 'value' => 'date("Y-m-d H:i:s",$data->register_time)',
               ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{views}',
                'header' => Yii::t('home', '操作'),
                'updateButtonImageUrl' => false,
                'buttons' => array(
                   'views' => array(
                                'label' => Yii::t('user', '登陆日志'),
                                'url' => 'Yii::app()->createUrl("PromotionStatistics/memberLog",array("id"=>$data->id))',
                                'visible' => "Yii::app()->user->checkAccess('PromotionStatistics.memberLog')",
                                'options' => array(
                                      'class' => 'regm-sub',
                                      'style' => 'width:83px; background: url("images/sub-fou.gif");',
                               ),
                   ),
                )
            ),
        ),
        )
    );
?>