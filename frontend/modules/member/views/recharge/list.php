<?php
/** @var $this RechargeController */
/** @var $model Recharge */
$this->breadcrumbs = array(
    Yii::t('memberRecharge', '积分管理') => '',
    Yii::t('memberRecharge', '积分充值记录'),
);
?>
<div class="mbRight">
    <div class="left_1"><a class="curr" ><?php echo Yii::t('memberRecharge', '积分充值记录'); ?></a></div>
    <div class="right_1"></div>
    <div class="mbRcontent">

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="mgtop20 upladBox "><h3 class="mgleft14"><?php echo Yii::t('memberRecharge', '积分充值记录'); ?></h3>

                    <p class="integaralbd pdbottom10"><span class="mgleft14"><?php echo Yii::t('memberRecharge', '查找过去的积分充值记录'); ?>。</span></p></div>

                <?php echo $this->renderPartial('_search', array('model' => $model)) ?>

                <table width="890" border="0" cellpadding="0" cellspacing="0" class="integralTab mgtop10">

                    <tr>
                        <td width="181" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberRecharge', '充值单号'); ?></b>
                        </td>
                       
                        <td width="161" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberRecharge', '创建时间'); ?></b>
                        </td>
                        <td width="129" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberRecharge', '金额'); ?></b>
                        </td>
                        <td width="98" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberRecharge', '充值积分'); ?></b>
                        </td>
                        <td width="100" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberRecharge', '状态'); ?></b>
                        </td>
                        <td width="112" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberRecharge', '充值方式'); ?></b>
                        </td>
<!--                        <td width="107" height="40" align="center" class="tdBg">-->
<!--                            <b>--><?php //echo Yii::t('memberRecharge', '操作'); ?><!--</b>-->
<!--                        </td>-->
                    </tr>
                    <?php
                    $recharges = $model->searchList($this->getUser()->id);
                    $data = $recharges->getData();
                    /** @var $v Recharge */
                    ?>
                    <?php foreach ($data as $v): ?>
                        <tr>
                            <td height="35" align="center" valign="middle" class="bgF4">
                                <b><?php echo $v->code ?></b>
                            </td>
                           
                            <td height="35" align="center" valign="middle" class="bgF4">
                                <?php echo $this->format()->formatDatetime($v->create_time) ?>
                            </td>
                            <td height="35" align="center" valign="middle" class="bgF4">
                                ￥ <?php echo $v->money ?>
                            </td>
                            <td height="35" align="center" valign="middle" class="bgF4">
                                <?php echo $v->score ?>
                            </td>
                            <td height="35" align="center" valign="middle" class="bgF4">
                                <?php echo $v::showStatus($v->status) ?>
                            </td>
                            <td height="35" align="center" valign="middle" class="bgF4">
                                <?php echo $v::showPayType($v->pay_type) ?>
                            </td>
<!--                            <td height="35" align="center" valign="middle" class="bgF4">-->
<!--                                --><?php //if ($v->status != $v::STATUS_SUCCESS): ?>
<!--                                    --><?php //echo CHtml::link(Yii::t('memberRecharge', '充值'), $this->createAbsoluteUrl('/member/recharge/index', array('code' => $v->code)));
//                                    ?>
<!--                                --><?php //endif ?>
<!--                            </td>-->
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($data)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center">
                                <?php echo Yii::t('memberRecharge', '还没有任何数据'); ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td height="35" colspan="6" align="center" valign="middle" class="bgF4">


                            <?php
                            $this->widget('LinkPager', array(
                                'pages' => $recharges->pagination,
                                'jump' => false,
                                'htmlOptions' => array('class' => 'pagination'),
                            ))
                            ?>
                        </td>
                    </tr>
                </table>


            </div>
            <div class="mbDate1_b"></div>

        </div>

    </div>
</div>