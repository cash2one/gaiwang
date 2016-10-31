<?php
/* @var $this  HomeController */
/** @var $model Member */
/** @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberMember','账户管理')=>'',
    Yii::t('memberMember',' 我的推荐会员'),
);
?>
<div class="mbRight">
	<div class="EntInfoTab">
		<ul class="clearfix">
			<li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberMember','我的推荐会员'); ?></span></a></li>
		</ul>
	</div>
    <div class="mbRcontent">
        <?php $this->renderPartial('/layouts/_summary'); ?>
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="MessageTable">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'message-form',
                        'method' => 'post',
                        'htmlOptions' => array(
                            'onsubmit' => 'return getCheckbox()',
                        ),
                    ));
                    ?>
                    <table cellspacing="0" cellpadding="0" border="0" width="99%" class="t_Message">
                        <tbody>
                            <tr>  	
                                <th width="25%"><?php echo Yii::t('memberMember', '用户GW号'); ?></th>
                                <th width="25%"><?php echo Yii::t('memberMember', '用户名'); ?></th>
                                <th width="25%"><?php echo Yii::t('memberMember', '注册时间'); ?></th>
                                <th width="25%"><?php echo Yii::t('memberMember', '推荐时间'); ?></th>
                            </tr>
                            <?php if ($user_lists = $dataProvider->getData()): ?>
                                <?php foreach ($user_lists as $user): ?>
                                    <tr> 
                                        <td><?php echo $user->gai_number; ?></td>
                                        <td><?php echo $user->username; ?></td>
                                        <td><?php echo $user->register_time?date("Y/m/d H:i:s", $user->register_time):''; ?></td>
                                        <td><?php echo $user->referrals_time?date("Y/m/d H:i:s", $user->referrals_time):''; ?></td>
                                    </tr>	
                                <?php endforeach; ?>
                                <tr> 
                                    
                                    <td class="last" colspan="4">
                                        <div class="pagination">
                                            <?php
                                            $this->widget('CLinkPager', array(
                                                'header' => '',
                                                'cssFile' => false,
                                                'firstPageLabel' => Yii::t('page', '首页'),
                                                'lastPageLabel' => Yii::t('page', '末页'),
                                                'prevPageLabel' => Yii::t('page', '上一页'),
                                                'nextPageLabel' => Yii::t('page', '下一页'),
                                                'maxButtonCount' => 13,
                                                'pages' => $dataProvider->pagination
                                            ));
                                            ?>  
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <tr><td colspan="6" class="empty"><span><?php echo Yii::t('memberMember', '没有找到数据'); ?>.</span></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>

