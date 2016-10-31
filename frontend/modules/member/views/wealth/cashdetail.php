<?php
/**
 * @var $form CActiveForm
 * @var $model AccountFlow
 * @var $this WealthController
 */
$this->breadcrumbs = array(
    Yii::t('memberWealth', '积分管理') => '',
    Yii::t('memberWealth', '积分明细'),
);
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberWealth', '积分明细') ?></span></a></li>
        </ul>
    </div>
    <div class="mbRcontent">
        <?php $this->renderPartial('/layouts/_summary'); ?>
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="mgtop20 upladBox ">
                    <h3 class="mgleft14"><?php echo Yii::t('memberWealth', '积分明细查询'); ?></h3>
                    <p class="integaralbd pdbottom10">
                        <span class="mgleft14">
                            <?php echo Yii::t('memberWealth', '更快地让用户查询浏览积分进出明细。'); ?>
                        </span>
                    </p>
                </div>
                <div class="upladaapBoxBg mgtop20 ">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'action' => Yii::app()->createAbsoluteUrl($this->route),
                        'method' => 'get',
                    ));
                    ?>
                    <div class="upladBox_1">
                        <b class="mgleft20"><?php echo Yii::t('memberWealth', '关键词'); ?>：</b><?php echo $form->textField($model, 'remark', array('class' => 'integaralIpt4 mgright15')); ?>
                        <b><?php echo Yii::t('memberWealth', '起止日期'); ?>：</b>
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'create_time',
                            'language' => 'zh_cn',
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                            ),
                            'htmlOptions' => array(
                                'readonly' => 'readonly',
                                'class' => 'integaralIpt5',
                            )
                        ));
                        ?>  -  <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'endTime',
                            'language' => 'zh_cn',
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                            ),
                            'htmlOptions' => array(
                                'readonly' => 'readonly',
                                'class' => 'integaralIpt5 mgright15',
                            )
                        ));
                        ?>
                        <?php echo CHtml::submitButton(Yii::t('memberWealth', '搜索'), array('class' => 'searchBtn searchBtnright')); ?>
                    </div>
                    <div class="upladBox_1 mgtop10 mgleft20">
                        <dt><?php echo Yii::t('memberWealth', '积分来源'); ?>：</dt>
                        <dd>
                            <?php
                            $sourceArr = $model::getOperateTypeOther();
                            $sourceArr = array_reverse($sourceArr, true);
                            $sourceArr[''] = Yii::t('memberWealth', '全部');
                            $sourceArr = array_reverse($sourceArr, true)
                            ?>
                            <?php echo $form->radioButtonList($model, 'operate_type', $sourceArr, array('separator' => '', 'class' => 'mgleft14')); ?>
                        </dd>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                <table width="890" border="0" cellpadding="0" cellspacing="0" class="integralTab mgtop10">
                    <tbody>
                        <tr>
                            <td width="142" height="40" align="center" class="tdBg">
                                <b><?php echo Yii::t('memberWealth', '类型'); ?></b>
                            </td>
                            <td width="142" height="40" align="center" class="tdBg">
                                <b><?php echo Yii::t('memberWealth', '积分来源'); ?></b>
                            </td>
                            <td height="40"  align="center" class="tdBg">
                                <b><?php echo Yii::t('memberWealth', '金额'); ?></b>
                            </td>
                            <td height="40"  align="center" class="tdBg">
                                <b><?php echo Yii::t('memberWealth', '充值者'); ?></b>
                            </td>
                            <td width="305" height="40" align="center" class="tdBg">
                                <b><?php echo Yii::t('memberWealth', '时间'); ?></b>
                            </td>
                        </tr>
                        <?php $wealth = $model->search(); ?>
                        <?php if ($weathsData = $wealth->getData()): ?>                        
                            <?php foreach ($weathsData as $v): ?>
                                <tr>
                                    <td height="35" align="center" valign="middle" class="bgF4">
                                        <b><?php echo AccountFlow::showType($v['type']); ?></b>
                                    </td>
                                    <td height="35" align="center" valign="middle" class="bgF4">
                                        <b><?php echo AccountFlow::showOperateType($v['operate_type']); ?></b>
                                    </td>
                                    <td height="35"  align="center" valign="middle" class="bgF4">
                                        <b><?php echo AccountFlow::showPrice($v['credit_amount'], $v['debit_amount']); ?></b>
                                    </td>
                                    <td height="35"  align="center" valign="middle" class="bgF4">
                                        <b><?php echo $v['by_gai_number'] ?></b>
                                    </td>
                                    <td height="35" align="center" valign="middle" class="bgF4">
                                        <?php echo date('Y-m-d H:i:s', $v['create_time']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <?php if($v['operate_type'] == AccountFlow::OPERATE_TYPE_ASSIGN_TWO) {?>
                                    <td height="35" colspan="5" align="center" valign="middle" class="bgE5"><b><?php echo Yii::t('memberWealth', '备注'); ?>：;</b><?php echo AccountFlow::formatContent($v['remark']);?> </td>
                                    <?php }else{ ?>
                                    <td height="35" colspan="5" align="center" valign="middle" class="bgE5">
                                        <b><?php echo Yii::t('memberWealth', '备注'); ?>：</b><?php
                                        echo strtr(AccountFlow::formatContent($v['remark']), array(
                                    '订单' => '订单(' . $v['order_code'] . ')',
                                        ));
                                        ?>
                                    </td>
                                    <?php }?>
                                </tr>                           
    <?php endforeach; ?>
                            <tr>
                                <td height="35" align="center" colspan="5" valign="middle" class="bgF4">
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
                                            'pages' => $wealth->pagination
                                        ));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr><td colspan="5" class="empty"><span><?php echo Yii::t('memberWealth', '没有找到数据'); ?>.</span></td></tr>
<?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>
