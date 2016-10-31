<?php
/* @var $this ApplyCashController */
$this->breadcrumbs = array(
    Yii::t('memberApplyCash', '账户管理'),
    Yii::t('memberApplyCash', '提现列表'),
);
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberApplyCash', '提现列表');?></span></a></li>
        </ul>
    </div>
    <div class="mbRcontent">

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">

                <div class="mgtop20 upladBox ">
                    <h3 class="mgleft14"><?php echo Yii::t('memberApplyCash','提现列表'); ?></h3>
                    <p class="integaralbd pdbottom10">
                        <span class="mgleft14"><?php echo Yii::t('memberApplyCash','企业会员提现记录。'); ?></span>
                    </p>
                </div>
                <?php $this->renderPartial('_search',array('model'=>$model)) ?>

                <table width="890" border="0" cellpadding="0" cellspacing="0" class="integralTab mgtop10">
                    <tr>
                        <td width="142" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberApplyCash','申请时间'); ?></b>
                        </td>
                        <td width="142" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberApplyCash','申请金额'); ?></b>
                        </td>
                        <td width="142" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberApplyCash','手续费'); ?></b>
                        </td>
                        <td width="142" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberApplyCash','手续费费率'); ?></b>
                        </td>
                        <td width="142" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberApplyCash','实扣金额'); ?></b>
                        </td>
                        <td width="113" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberApplyCash','状态'); ?></b>
                        </td>
                        <td width="103" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberApplyCash','备注'); ?></b>
                        </td>
                    </tr>
                    <?php /** @var $v CashHistory */ ?>
                    <?php foreach($log as $v): ?>
                        <?php
                        $v->money = Common::rateConvert($v->money);
                        ?>
                        <tr  class="bgF4">
                            <td height="35" align="center" valign="middle">
                                <?php echo $this->format()->formatDatetime($v->apply_time) ?>
                            </td>
                            <td height="35" align="center" valign="middle">
                                <b><?php echo HtmlHelper::formatPrice('').$v->money ?></b>
                            </td>
                            <td height="35" align="center" valign="middle">
                                <?php echo $fee = sprintf('%0.2f',$v->money*$v->factorage/100) ?>
                            </td>
                            <td height="35" align="center" valign="middle">
                                <?php echo $v->factorage ?>%
                            </td>
                            <td height="35" align="center" valign="middle">
                                <?php echo $v->money+$fee ?>
                            </td>
                            <td height="35" align="center" valign="middle">
                                <?php echo $v::status($v->status) ?>
                            </td>
                            <td height="35" align="center" valign="middle">
                                <b class="red">
                                    <?php echo $v->reason ?>
                                </b>
                            </td>
                        </tr>

                        <tr>
                            <td height="35" colspan="7" align="center" valign="middle" class="bgE5">
                                <b><?php echo Yii::t('memberApplyCash','开户行'); ?></b>：
                                <?php echo $v->bank_name ?>，<?php echo Yii::t('memberApplyCash','帐号名'); ?>:
                                <?php echo $v->account_name ?>，<?php echo Yii::t('memberApplyCash','银行帐号'); ?>:
                                <?php echo $v->account ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td height="35" colspan="7" align="center" valign="middle" class="bgF4">
                            <?php $this->widget('LinkPager', array(
                                'pages' => $pages,
                                'jump' => false,
                                'htmlOptions' => array('class' => 'pagination'),
                            )) ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>
