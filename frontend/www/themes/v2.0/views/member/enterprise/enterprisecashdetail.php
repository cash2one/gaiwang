
<!--主体start-->
    <div class="main-contain">
        <div class="account-details">
            <div class="accounts-box">
                <p class="accounts-title cover-icon"><?php echo Yii::t('memberWealth', '账户明细查询'); ?></p>
                <div class="withdraw-box">
                 <?php $this->renderPartial('_searchenterprise', array('model' => $model)) ?>
                   <?php $wealth = $model->searchForStore(); 
                             $weathsData = $wealth->getData();
                            ?>
                        <?php if(!empty($weathsData)): ?>  
                    <table class="consume-table" border="0">
                        <tr class="consume-title">
                            <td class="table-code"><?php echo Yii::t('memberWealth', '订单编号'); ?></td>
                            <td class="table-time"><?php echo Yii::t('memberWealth', '时间'); ?></td>
                            <td class="table-source"><?php echo Yii::t('memberWealth', '积分来源'); ?></td>
                            <td class="table-money"><?php echo Yii::t('memberWealth', '金额'); ?></td>
                            <td class="table-types"><?php echo Yii::t('memberWealth', '类型'); ?></td>
                            <td class="table-source"><?php echo Yii::t('memberWealth', '被推荐者'); ?></td>
                            <td class="table-remark"><?php echo Yii::t('memberWealth', '备注'); ?></td>
                        </tr>
                            <?php foreach ($weathsData as $v): ?>
                        <tr class="account-item">
                            <td valign="top"><?php echo $v['order_code'];?></td>
                            <td valign="top"><?php echo date('Y-m-d H:i:s', $v['create_time']);?></td>
                            <td valign="top"><?php echo AccountFlow::showOperateType($v['operate_type']);?></td>
                            <td valign="top"><b><?php echo AccountFlow::showPrice($v['credit_amount'], $v['debit_amount']); ?></b></td>
                            <td valign="top"><?php echo AccountFlow::showType($v['type']); ?></td>
                            <td valign="top"><?php echo $v['by_gai_number']?></td>
                            <td valign="top"><?php echo $v['remark']?></td>
                        </tr>
                        <?php endforeach;?>                                           
                    </table>
                    <?php else:?>
                     <table class="consume-table" border="0">
                        <tr class="consume-title">
                            <td class="table-time"><?php echo Yii::t('memberWealth', '时间'); ?></td>
                            <td class="table-source"><?php echo Yii::t('memberWealth', '积分来源'); ?></td>
                            <td class="table-money"><?php echo Yii::t('memberWealth', '金额'); ?></td>
                            <td class="table-types"><?php echo Yii::t('memberWealth', '类型'); ?></td>
                            <td class="table-source"><?php echo Yii::t('memberWealth', '被推荐者'); ?></td>
                            <td class="table-remark"><?php echo Yii::t('memberWealth', '备注'); ?></td>
                        </tr>
                     </table>
                    <div class="withdraw-not"><?php echo Yii::t('memberWealth', '没有找到数据'); ?></div> 
                    <?php endif;?>                   
                </div>                
            </div>
             <div class="pageList mt50 clearfix">
                    <?php
                      $this->widget('SLinkPager', array(
                            'header' => '',
                            'cssFile' => false,
                            'firstPageLabel' => Yii::t('page', '首页'),
                            'lastPageLabel' => Yii::t('page', '末页'),
                            'prevPageLabel' => Yii::t('page', '上一页'),
                            'nextPageLabel' => Yii::t('page', '下一页'),
                            'maxButtonCount' =>5,
                            'pages' => $wealth->pagination,
                            'htmlOptions' => array(
                                    'class' => 'yiiPageer'
                            )
                          ));
                ?>
            </div>
        </div>
    </div>
<!-- 主体end -->
