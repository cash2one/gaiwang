<script src="<?php echo AGENT_DOMAIN;  ?>/agent/js/common.js"></script>
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
                <td colspan="7"><?php echo Yii::t("Agent", "盖机运营数据") ?></td>
            </tr>
            <tr bgcolor="#fcfcfc">
                <td class="table_search" colspan="8">
                    <?php $this->renderPartial('operatesearch', array('model' => $model)); ?>
                </td>
            </tr>
            <tr>
                <td width="16%" class="tabletd tc"><?php echo Yii::t('Agent', '时间') ?></td>
                <td width="20%" class="tabletd tc"><?php echo Yii::t('Agent', '盖机名称') ?></td>
                <td width="16%" class="tabletd tc"><?php echo Yii::t('Agent', '新增会员数') ?></td>
                <td width="16%" class="tabletd tc"><?php echo Yii::t('Agent', '新增消费金额') ?></td>\
                <td width="16%" class="tabletd tc"><?php echo Yii::t('Agent', '历史新增会员数') ?></td>
                <td width="16%" class="tabletd tc"><?php echo Yii::t('Agent', '历史消费总金额') ?></td>
            </tr>
            <?php foreach ($allData as $val) { ?>
                <tr>
                    <td class="tc">
                        <?php echo date('Y年m月', $val['time']); ?>
                    </td>
                    <td class="tc"><?php echo $val['name']; ?></td>
                    <td class="tc"><?php echo $val['num']; ?></td>
                    <td class="tc"><?php echo $val['money']; ?></td>
                    <td class="tc"><?php echo $val['history_num']; ?></td>
                    <td class="tc"><?php echo $val['history_money']; ?></td>
                </tr>
            <?php } ?>
                <tr>
                    <td class="padding5" colspan="3" style="padding:5px;"></td>
                </tr>
            <tr>
                <td class="tc">
                    总计
                </td>
                <td class="tc"></td>
                <td class="tc"><?php  echo $rsCount['num'] ?></td>
                <td class="tc"><?php echo $rsCount['money']; ?></td>
                <td class="tc"><?php echo $rsCount['history_num']; ?></td>
                <td class="tc"><?php echo $rsCount['history_money']; ?></td>
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

<script>
//导出excel
function exportExcel(){
	var create_time = $('#MachineAgent_create_time').val();
        var url = createUrl("<?php echo $this->createUrl('machineAgent/exportExcel')?>",{"create_time":create_time});
	window.open(url);
}
</script>
