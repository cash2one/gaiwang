<?php
/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */

$action=isset($_GET['action'])?$_GET['action']:'admin';
$prepaidCardName='';
switch ($action){
	case 'admin':
		$prepaidCardName = '充值卡列表';
		break;
	case 'list':
		$prepaidCardName = '充值卡使用记录';
		break;
	case 'index':
		$prepaidCardName = '积分返还充值卡列表';
		break;
	case 'detail':
		$prepaidCardName = '积分返还卡使用记录';
		break;		
}
$this->breadcrumbs = array(
    Yii::t('prepaidCard', $prepaidCardName) => array($action),
    Yii::t('prepaidCard', '查看')
);
$type = MemberType::fileCache();
?>
<div class="com-box">
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
            <tr>
                <td colspan="2" style="text-align: center" class="title-th even"><?php echo Yii::t('prepaidCard', '充值卡信息'); ?></td>
            </tr>
            <tr>
                <th width="150px" class="odd"><?php echo Yii::t('prepaidCard', '卡号'); ?>：</th>
                <td class="odd"><?php echo $model->number; ?></td>
            </tr>
            <tr>
                <th class="even"><?php echo Yii::t('prepaidCard', '密码'); ?>：</th>
                <td class="even"><?php echo Tool::authcode($model->password,'DECODE'); ?></td>
            </tr>
            <tr>
                <th class="odd"><?php echo Yii::t('prepaidCard', '充值卡积分'); ?>：</th>
                <td class="odd"><?php echo sprintf("%.2f", $model->value); ?><?php echo Yii::t('prepaidCard', '盖网通积分'); ?></td>
            </tr>
            <tr>
                <th class="even"><?php echo Yii::t('prepaidCard', '实际金额'); ?>：</th>
                <td class="even"><?php if ($model->type == PrepaidCard::TYPE_SPECIAL): ?>￥<?php echo sprintf("%.2f", $model->value * $type['official']); ?><?php endif; ?></td>
            </tr>
            <tr>
                <th class="odd"><?php echo Yii::t('prepaidCard', '状态'); ?>：</th>
                <td class="odd"><?php echo PrepaidCard::showStatus($model->status); ?></td>
            </tr>
            <tr>
                <th class="even"><?php echo Yii::t('prepaidCard', '创建时间'); ?>：</th>
                <td class="even"><?php echo date('Y-m-d H:i:s', $model->create_time); ?></td>
            </tr>
            <?php if ($model->type == PrepaidCard::TYPE_SPECIAL): ?>
                <tr>
                    <td colspan="2" style="text-align: center" class="title-th odd"><?php echo Yii::t('prepaidCard', '拥有者信息'); ?></td>
                </tr>
                <tr>
                    <th class="even"><?php echo Yii::t('prepaidCard', '拥有者'); ?>：</th>
                    <td class="even"><?php echo !empty($model->owner->gai_number)?$model->owner->gai_number:''; ?></td>
                </tr>
                <tr>
                    <th class="odd"><?php echo Yii::t('prepaidCard', '卖出时间'); ?>：</th>
                    <td class="odd"><?php if ($model->sale_time): ?><?php echo date('Y-m-d H:i:s', $model->sale_time); ?><?php endif; ?></td>
                </tr>
                <tr>
                    <th class="even"><?php echo Yii::t('prepaidCard', '卖出备注'); ?>：</th>
                    <td class="even"><?php echo $model->sale_remark; ?></td>
                </tr>
                <tr>
                    <th class="odd"><?php echo Yii::t('prepaidCard', '是否对账'); ?>：</th>
                    <td class="odd">
                        <span style="color: red"><?php echo PrepaidCard::showRecon($model->is_recon); ?></span>
                    </td>
                </tr>
                <tr>
                    <th class="even"><?php echo Yii::t('prepaidCard', '对账时间'); ?>：</th>
                    <td class="even"><?php if ($model->recon_time): ?><?php echo date('Y-m-d H:i:s', $model->recon_time); ?><?php endif; ?></td>
                </tr>
                <tr>
                    <th class="odd"><?php echo Yii::t('prepaidCard', '对账管理员'); ?>：</th>
                    <td class="odd"><?php echo $model->recon_user; ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td colspan="2" style="text-align: center" class="title-th even"><?php echo Yii::t('prepaidCard', '使用会员信息'); ?></td>
            </tr>
            <tr>
                <th class="odd"><?php echo Yii::t('prepaidCard', '会员编码'); ?>：</th>
                <td class="odd"><?php echo !empty($model->member->gai_number)?$model->member->gai_number:''; ?></td>
            </tr>
            <tr>
                <th class="even"><?php echo Yii::t('prepaidCard', '使用时间'); ?>：</th>
                <td class="even"><?php if ($model->use_time): ?><?php echo date('Y-m-d H:i:s', $model->use_time); ?><?php endif; ?></td>
            </tr>
            <tr>
                <th class="odd"><?php echo Yii::t('prepaidCard', '使用时IP地址'); ?>：</th>
                <td class="odd"><?php if ($model->user_ip): ?><?php echo Tool::int2ip($model->use_time); ?><?php endif; ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center" class="title-th even"><?php echo Yii::t('prepaidCard', '管理员信息'); ?>：</td>
            </tr>
            <tr>
                <th class="odd"><?php echo Yii::t('prepaidCard', '管理员名称'); ?>：</th>
                <td class="odd"><?php echo $model->author_name; ?></td>
            </tr>
            <tr>
                <th class="even"><?php echo Yii::t('prepaidCard', '管理员操作时间'); ?>：</th>
                <td class="even"><?php echo date('Y-m-d H:i:s', $model->create_time); ?></td>
            </tr>
            <tr>
                <th class="odd"><?php echo Yii::t('prepaidCard', '管理员IP地址'); ?>：</th>
                <td class="odd"><?php echo Tool::int2ip($model->author_ip); ?></td>
            </tr>
        </tbody>
    </table>
</div>
