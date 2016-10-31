<!--<script src="<?php // echo AGENT_DOMAIN;  ?>/agent/js/common.js"></script>-->
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/My97DatePicker/WdatePicker.js"></script>

<?php
//    $cs = Yii::app()->clientScript;
//    $cs->registerCssFile(AGENT_DOMAIN. "/agent/js/fancybox/jquery.fancybox-1.3.4.css"); 
//    $cs->registerScriptFile(AGENT_DOMAIN. "/agent/js/fancybox/jquery.fancybox-1.3.4.pack.js", CClientScript::POS_END);
?>

<div class="account_right">
    <!-- -->
    <div class="line table_white" style="margin:10px">
        <table width="100%" cellspacing="0" cellpadding="0" class="table1">
            <tr class="table1_title">
                <td colspan="7"><?php echo Yii::t("Agent", "加盟商运营数据") ?></td>
            </tr>
            <tr bgcolor="#fcfcfc">
                <td class="table_search" colspan="8">
                    <?php $this->renderPartial('consumptionsearch', array('model' => $model)); ?>
                </td>
            </tr>
            <tr>
                <td width="33%" class="tabletd tc"><?php echo Yii::t('Agent', '时间') ?></td>
                <td width="33%" class="tabletd tc"><?php echo Yii::t('Agent', '新增免费会员') ?></td>
                <td width="34%" class="tabletd tc"><?php echo Yii::t('Agent', '新增消费额') ?></td>
            </tr>
            <?php foreach ($allData as $val) { ?>
                <tr>
                    <td class="tc">
                        <?php echo date('Y年m月', $val['time']); ?>
                    </td>
                    <td class="tc"><?php echo $val['num']; ?></td>
                    <td class="tc"><?php echo $val['mony']; ?></td>
                </tr>
            <?php } ?>
                <tr>
                    <td class="padding5" colspan="3"></td>
                </tr>
            <tr>
                <td class="tc">
                    历史统计
                </td>
                <td class="tc"><?php echo $reCount; ?></td>
                <td class="tc"><?php echo $coCount == 0 ? "0.00" : $coCount; ?></td>
            </tr>
            <tr>
                <td colspan="7">
                    <div class="line pagebox">
                        <?php
                        $this->widget('application.modules.agent.widgets.LinkPager', array(
                            'header' => '',
                            'firstPageLabel' => Yii::t('Public', '首页'),
                            'lastPageLabel' => Yii::t('Public', '末页'),
                            'prevPageLabel' => Yii::t('Public', '上一页'),
                            'nextPageLabel' => Yii::t('Public', '下一页'),
                            'pages' => $pages,
                            'maxButtonCount' => 13
                                )
                        );
                        ?>  
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
