<!--主体start-->  	
      <div class="main-contain">
        <div class="withdraw-contents">
        	<div class="crumbs crumbs-en">
              <span><?php echo Yii::t('memberWealth', '您的位置：') ?></span>
              <a href="#"><?php echo Yii::t('memberWealth', '企业管理') ?></a>
              <span>&gt</span>
              <a href="#"><?php echo Yii::t('memberWealth', '线下交易明细') ?></a>
            </div>
            <div class="accounts-box">
                <p class="accounts-title cover-icon"><?php echo Yii::t('memberWealth', '线下交易明细') ?></p>
                <div class="withdraw-box">
                    <?php $this->renderPartial('_searchOffline', array('model' => $model)) ?>
                    <?php if ($weathsData = $wealths->getData()):?>
                    <table class="link-table" border="0">
                      <tr class="table-title">
                        <td class="table-name"><?php echo Yii::t('memberWealth', '加盟商名称'); ?></td>
                        <td class="table-number"><?php echo Yii::t('memberWealth', '加盟商编号'); ?></td>
                        <td class="table-status"><?php echo Yii::t('memberWealth', '对账状态'); ?></td>
                        <td class="table-gaiwang"><?php echo Yii::t('memberWealth', '盖网折扣(%)'); ?></td>
                        <td class="table-member"><?php echo Yii::t('memberWealth', '会员折扣(%)'); ?></td>
                        <td class="table-time"><?php echo Yii::t('memberWealth', '账单时间'); ?></td>
                        <td class="table-money"><?php echo Yii::t('memberWealth', '消费金额'); ?></td>
                        <td class="table-allocation"><?php echo Yii::t('memberWealth', '分配金额'); ?></td>
                        <td class="table-must"><?php echo Yii::t('memberWealth', '应付金额'); ?></td>
                        <td class="table-gw"><?php echo Yii::t('memberWealth', 'GW号'); ?></td>
                        <td class="table-phone"><?php echo Yii::t('memberWealth', '手机号'); ?></td>
                      </tr>
                       <?php
                            foreach ($weathsData as $wealth): ?>
                      <tr>
                                    <td >
                             <?php echo $wealth->franchisee->name ?>
                                    </td>
                                    <td>
                                        <b><?php echo $wealth->franchisee->code ?></b>
                                    </td>
                                    <td>
                                        <b><?php echo FranchiseeConsumptionRecord::getCheckStatus($wealth->status) ?></b>
                                    </td>
                                    <td>
                                        <b><?php echo $wealth->gai_discount ?></b>
                                    </td>
                                    <td>
                                        <b><?php echo $wealth->member_discount ?></b>
                                    </td>
                                    <td>
                                        <b><?php echo date('Y-m-d H:i:s', $wealth->create_time) ?></b>
                                    </td>
                                    <td>
                                        <b><?php echo IntegralOfflineNew::formatPrice($wealth->entered_money, $wealth->symbol) ?></b>
                                    </td>
                                    <td>
                                        <b><?php echo FranchiseeConsumptionRecord::conversion($wealth->distribute_money, $wealth->base_price, $wealth->symbol) ?></b>
                                    </td>
                                    <td>
                                        <b><?php echo FranchiseeConsumptionRecord::conversion($wealth->spend_money - $wealth->distribute_money, $wealth->base_price, $wealth->symbol) ?></b>
                                    </td>
                                    <td>
                                        <b><?php echo $wealth->member->gai_number ?></b>
                                    </td>
                                    <td>
                                        <b><?php echo $wealth->member->mobile ?></b>
                                    </td>
                                </tr>
               <?php 
                   endforeach; 
                      ?>          
                    </table>
                    <?php else:?>
                    <table class="link-table" border="0">
                      <tr class="table-title">
                        <td class="table-name"><?php echo Yii::t('memberWealth', '加盟商名称'); ?></td>
                        <td class="table-number"><?php echo Yii::t('memberWealth', '加盟商编号'); ?></td>
                        <td class="table-status"><?php echo Yii::t('memberWealth', '对账状态'); ?></td>
                        <td class="table-gaiwang"><?php echo Yii::t('memberWealth', '盖网折扣(%)'); ?></td>
                        <td class="table-member"><?php echo Yii::t('memberWealth', '会员折扣(%)'); ?></td>
                        <td class="table-time"><?php echo Yii::t('memberWealth', '账单时间'); ?></td>
                        <td class="table-money"><?php echo Yii::t('memberWealth', '消费金额'); ?></td>
                        <td class="table-allocation"><?php echo Yii::t('memberWealth', '分配金额'); ?></td>
                        <td class="table-must"><?php echo Yii::t('memberWealth', '应付金额'); ?></td>
                        <td class="table-gw"><?php echo Yii::t('memberWealth', 'GW号'); ?></td>
                        <td class="table-phone"><?php echo Yii::t('memberWealth', '手机号'); ?></td>
                      </tr>
                   </table>
                    <div class="link-list">
                    	<p class="withdraw-not"><?php echo Yii::t('memberWealth', '没有找到数据') ?></p>
                    </div>
                    
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
                            'pages' => $wealths->pagination,
                            'htmlOptions' => array(
                                    'class' => 'yiiPageer'
                            )
                          ));
                ?>
            </div>
        
      </div>      
    </div>  
    <!-- 主体end -->