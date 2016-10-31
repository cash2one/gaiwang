<?php
/* @var $this WealthController */
$this->breadcrumbs = array(
    Yii::t('memberWealth', '账户管理'),
    Yii::t('memberWealth', '线下交易明细') => array('/wealth/offline')
);
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberWealth', '线下交易明细') ?></span></a></li>
        </ul>
    </div>
    <div class="mbRcontent">

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="mgtop20 upladBox ">

                    <h3 class="mgleft14"><?php echo Yii::t('memberWealth', '线下交易明细'); ?></h3><p class="integaralbd pdbottom10">
                        <span class="mgleft14"></span></p>
                </div>

                <?php $this->renderPartial('_searchOffline', array('model' => $model)) ?>

                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="integralTab mgtop10" style="margin-left:5px;">
                    <tbody>
                        <tr>
                            <td width="10%" height="40" align="center" class="tdBg">
                                <b><?php echo Yii::t('memberWealth', '加盟商名称'); ?></b>
                            </td>
                            <td width="10%" height="40" align="center" class="tdBg">
                                <strong><?php echo Yii::t('memberWealth', '加盟商编号'); ?>
                            </td>
                            <td width="7%" height="40"  align="center" class="tdBg">
                                <b><?php echo Yii::t('memberWealth', '对账状态'); ?></b>
                            </td>
                            <td width="10%" height="40"  align="center" class="tdBg">
                                <b><?php echo Yii::t('memberWealth', '盖网折扣（百分比）'); ?></b>
                            </td>
                            <td width="10%" height="40"  align="center" class="tdBg">
                                <b><?php echo Yii::t('memberWealth', '会员折扣（百分比）'); ?></b>
                            </td>
                            <td width="8%" height="40" align="center" class="tdBg">
                                <b><?php echo Yii::t('memberWealth', '账单时间'); ?></b>
                            </td>
                            <td width="8%" height="40" align="center" class="tdBg">
                                <b><?php echo Yii::t('memberWealth', '消费金额'); ?></b>
                            </td>
                            <td width="8%" height="40" align="center" class="tdBg">
                                <b><?php echo Yii::t('memberWealth', '分配金额'); ?></b>
                            </td>
                            <td width="8%" height="40" align="center" class="tdBg">
                                <b><?php echo Yii::t('memberWealth', '应付金额'); ?></b>
                            </td>
                            <td width="10%" height="40" align="center" class="tdBg">
                                <b><?php echo Yii::t('memberWealth', 'GW号'); ?></b>
                            </td>
                            <td width="11%" height="40" align="center" class="tdBg">
                                <b><?php echo Yii::t('memberWealth', '手机号'); ?></b>
                            </td>
                        </tr>

                        <?php
                        if ($weathsData = $wealths->getData()):
//                        Tool::pr($weathsData);
                            ?>
                            <?php /** @var $wealth Wealth  */ ?>
    <?php foreach ($weathsData as $wealth): ?>
                                <tr>
                                    <td height="35" align="center" valign="middle" class="bgF4" >
        <?php echo $wealth->franchisee->name ?>
                                    </td>
                                    <td height="35" align="center" valign="middle" class="bgF4" >
                                        <b><?php echo $wealth->franchisee->code ?></b>
                                    </td>
                                    <td height="35"  align="center" valign="middle" class="bgF4" >
                                        <b><?php echo FranchiseeConsumptionRecord::getCheckStatus($wealth->status) ?></b>
                                    </td>
                                    <td height="35"  align="center" valign="middle" class="bgF4" >
                                        <b><?php echo $wealth->gai_discount ?></b>
                                    </td>
                                    <td height="35"  align="center" valign="middle" class="bgF4" >
                                        <b><?php echo $wealth->member_discount ?></b>
                                    </td>
                                    <td height="35"  align="center" valign="middle" class="bgF4" >
                                        <b><?php echo date('Y-m-d H:i:s', $wealth->create_time) ?></b>
                                    </td>
                                    <td height="35"  align="center" valign="middle" class="bgF4" >
                                        <b><?php echo IntegralOfflineNew::formatPrice($wealth->entered_money, $wealth->symbol) ?></b>
                                    </td>
                                    <td height="35"  align="center" valign="middle" class="bgF4" >
                                        <b><?php echo FranchiseeConsumptionRecord::conversion($wealth->distribute_money, $wealth->base_price, $wealth->symbol) ?></b>
                                    </td>
                                    <td height="35"  align="center" valign="middle" class="bgF4">
                                        <b><?php echo FranchiseeConsumptionRecord::conversion($wealth->spend_money - $wealth->distribute_money, $wealth->base_price, $wealth->symbol) ?></b>
                                    </td>
                                    <td height="35"  align="center" valign="middle" class="bgF4">
                                        <b><?php echo substr_replace($wealth->member->gai_number, '****', 3, 4); ?></b>
                                    </td>
                                    <td height="35"  align="center" valign="middle" class="bgF4" >
                                        <b><?php echo substr_replace($wealth->member->mobile, '****', 3, 4); ?></b>
                                    </td>
                                </tr>
    <?php endforeach; ?>
                            <tr>
                                <td height="35" align="center" colspan="7" valign="middle" class="bgF4">
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
                                            'pages' => $wealths->pagination
                                        ));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr><td colspan="7" class="empty"><span><?php echo Yii::t('memberWealth', '没有找到数据'); ?>.</span></td></tr>
<?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>